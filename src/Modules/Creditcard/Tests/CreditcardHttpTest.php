<?php

namespace Modules\Creditcard\Tests;

use Modules\Auth0\Abstracts\AuthorizedHttpTest;
use Modules\Authorization\Entities\Role;
use Modules\Creditcard\Contracts\CreditcardServiceContract;
use Modules\Creditcard\Entities\Creditcard;
use Modules\Creditcard\Services\CreditcardService;
use Modules\Creditcard\Transformers\CreditcardTransformer;

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
        $this->model = factory(Creditcard::class)->create(['user_id' => $this->getActingUser()->id]);
        $this->service = $this->app->make(CreditcardServiceContract::class);
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

        //TODO assert array rule
        /*
        $this->assertEquals(
            CreditcardTransformer::collection($this->service->getByUserId($this->getActingUser()->id))->serialize(),
            $response->decode()
        ); */
    }

    /**
     * Test retrieving a Creditcard.
     *
     * @return void
     */
    public function testFindCreditcard()
    {
        $response = $this->http('GET', '/v1/creditcards/'.$this->model->id);
        $response->assertStatus(200);

        $this->getActingUser()->syncRoles(Role::GUEST);
        $response = $this->http('GET', '/v1/creditcards/'.$this->model->id);
        $response->assertStatus(403);
    }

    /**
     * Test Creditcard Deletion.
     *
     * @return void
     */
    public function testDeleteCreditcard()
    {
        $response = $this->http('DELETE', '/v1/creditcards/'.$this->model->id);
        $response->assertStatus(204);
    }

    /**
     * Test Creditcard Creation.
     *
     * @return void
     */
    public function testCreateCreditcard()
    {
        $model = Creditcard::fromFactory()->make([]);
        $response = $this->http('POST', '/v1/creditcards', $model->toArray());
        $response->assertStatus(201);

        //TODO ASSERT RESPONSE CONTAINS ATTRIBUTES
        /*
        $this->assertArrayHasKey('username', $this->decodeHttpResponse($response));
        $this->assertArrayHasKey('password', $this->decodeHttpResponse($response));
        */
    }

    /**
     * Test Updating a Creditcard.
     *
     * @return void
     */
    public function testUpdateCreditcard()
    {
        /* Test response for a normal user */
        $response = $this->http('PATCH', '/v1/creditcards/'.$this->model->id, []);
        $response->assertStatus(200);

        /* Test response for a guest user */
        $this->getActingUser()->syncRoles(Role::GUEST);
        $response = $this->http('PATCH', '/v1/creditcards/'.$this->model->id, []);
        $response->assertStatus(403);
    }
}
