<?php
/**
 * Created by PhpStorm.
 * User: arthur
 * Date: 30.10.18
 * Time: 22:59.
 */

namespace Foundation\Tests;

use Foundation\Abstracts\Tests\TestCase;
use Foundation\Abstracts\Transformers\Transformer;
use Illuminate\Database\Eloquent\Model;

class TransformerTest extends TestCase
{
    protected $user;

    protected $machine;

    protected $machineNoUser;

    protected function seedData()
    {
        $this->user = new UserTestModel();
        $this->machine = new MachineTestModel($this->user);
        $this->machineNoUser = new MachineTestModel(null);
    }

    public function testNoRelation()
    {
        $machineResource = MachineTestTransformer::resource($this->machine)->serialize();
        $this->assertEmpty($machineResource);
        $this->assertArrayNotHasKey('user', $machineResource);
    }

    /*public function testIncludeMethodRelation()
    {
        $machineResource = MachineTestTransformer::resource($this->machine,['user'=>UserTestTransformer::class])->serialize();
        $this->assertArrayHasKey('user', $machineResource);
    }

    public function testEmptyRelation()
    {
        $machineResource = MachineTestTransformer::resource($this->machineNoUser)->include('user')->serialize();
        $this->assertArrayHasKey('user', $machineResource);
        $this->assertNull($machineResource['user']);
    }

    public function testPreIncludedRelation()
    {
        $machineResource = UserIncludedMachineTestTransformer::resource($this->machine)->serialize();
        $this->assertArrayHasKey('user', $machineResource);
    }*/
}

final class MachineTestModel extends Model
{
    public $user;

    public function __construct($user)
    {
        $this->user = $user;
        parent::__construct([]);
    }
}

final class UserTestModel extends Model
{
}

class MachineTestTransformer extends Transformer
{
    public function toArray($request)
    {
        return [];
    }

    public function transformUser(MachineTestModel $machine)
    {
        return UserTestTransformer::resource($machine->user);
    }
}

class UserIncludedMachineTestTransformer extends MachineTestTransformer
{
    public $include = ['user'];
}

class UserTestTransformer extends Transformer
{
    public function toArray($request)
    {
        return [];
    }
}
