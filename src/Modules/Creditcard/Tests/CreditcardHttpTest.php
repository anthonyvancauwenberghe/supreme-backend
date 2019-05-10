<?php

namespace Modules\Creditcard\Tests;

use Illuminate\Support\Facades\Event;
use Modules\Auth0\Abstracts\AuthorizedHttpTest;
use Modules\Authorization\Entities\Role;
use Modules\Creditcard\Contracts\CreditcardServiceContract;
use Modules\Creditcard\Dtos\CreateCreditcardData;
use Modules\Creditcard\Entities\Creditcard;
use Modules\Creditcard\Events\CreditcardWasDeletedEvent;
use Modules\Creditcard\Services\CreditcardService;

class CreditcardHttpTest extends AuthorizedHttpTest
{
    protected $roles = Role::ADMIN;

    /**
     * @var Creditcard
     */
    protected $model;

    /**
     * @var CreditcardService
     */
    protected $service;

    protected function seedData()
    {
        parent::seedData();
        $this->service = $this->app->make(CreditcardServiceContract::class);
        $this->model = $this->service->create(CreateCreditcardData::fromFactory(Creditcard::class), $this->getActingUser());
        Event::fake();
    }

    /**
     * Test retrieving all creditcards.
     *
     * @return void
     */
    public function testIndexCreditcards()
    {
        $response = $this->http('GET', '/v1/creditcards');
        $response->assertStatus(200);

        $data = $response->decode();
        $this->assertNotEmpty($data);
        $this->assertCount(Creditcard::where('user_id', $this->getActingUser()->id)->get()->count(), $data);
        $this->assertStringContainsString("*", $data[0]['cvv']);
        $this->assertStringContainsString("*", $data[0]['number']);
    }

    /**
     * Test retrieving a Creditcard.
     *
     * @return void
     */
    public function testFindCreditcard()
    {
        $response = $this->http('GET', '/v1/creditcards/' . $this->model->id);
        $response->assertStatus(200);
        $data = $response->decode();
        $this->assertStringNotContainsString("*", $data['cvv']);
        $this->assertStringNotContainsString("*", $data['number']);
        $this->assertArrayHasKey('expiry_month', $data);
        $this->assertArrayHasKey('expiry_year', $data);

        $this->getActingUser()->syncRoles(Role::GUEST);
        $response = $this->http('GET', '/v1/creditcards/' . $this->model->id);
        $response->assertStatus(403);
    }

    /**
     * Test Creditcard Deletion.
     *
     * @return void
     */
    public function testDeleteCreditcard()
    {
        $response = $this->http('DELETE', '/v1/creditcards/' . $this->model->id);
        $response->assertStatus(204);
        Event::assertDispatched(CreditcardWasDeletedEvent::class);
    }

    /**
     * Test Creditcard Creation.
     *
     * @return void
     */
    public function testCreateCreditcard()
    {
        $input = Creditcard::fromFactory()->raw();
        $response = $this->http('POST', '/v1/creditcards', $input);
        $response->assertStatus(201);

        $data = $response->decode();
        $this->assertNotEmpty($data);
        $this->assertStringContainsString("*", $data['cvv']);
        $this->assertStringContainsString("*", $data['number']);
        $this->assertArrayNotHasKey('expiry_month', $data);
        $this->assertArrayNotHasKey('expiry_year', $data);
    }

    /**
     * Test Updating a Creditcard.
     *
     * @return void
     */
    public function testUpdateCreditcard()
    {
        /* Test response for a normal user */
        $response = $this->http('PATCH', '/v1/creditcards/' . $this->model->id, []);
        $response->assertStatus(200);

        /* Test response for a guest user */
        $this->getActingUser()->syncRoles(Role::GUEST);
        $response = $this->http('PATCH', '/v1/creditcards/' . $this->model->id, []);
        $response->assertStatus(403);
    }

    /**
     * Test Updating a Creditcard.
     *
     * @return void
     */
    public function testMakePrimary()
    {

        /* Test response for a normal user */
        $card = $this->service->create(CreateCreditcardData::fromFactory(Creditcard::class), $this->getActingUser());
        $response = $this->http('PATCH', '/v1/creditcards/' . $card->id, ["primary" => true]);
        $response->assertStatus(200);
        $this->assertTrue($response->decode()['primary']);

        $cards = $this->service->fromUser($this->getActingUser());

        foreach ($cards as $card) {
            if ($card->primary) {
                foreach ($cards as $aCard) {
                    if ($card->id !== $aCard->id)
                        $this->assertFalse($aCard->primary);
                }
                $this->assertTrue(true);
                return;
            }
        }

        //THERE IS NO PRIMARY CARD
        $this->assertTrue(false);
    }
}
