<?php
/**
 * Created by PhpStorm.
 * User: arthur
 * Date: 03.10.18
 * Time: 22:58.
 */

namespace Foundation\Tests;

use Foundation\Abstracts\Tests\CreatesApplication;
use Foundation\Abstracts\Tests\TestCase;
use Foundation\Core\Larapi;
use Foundation\Traits\DisableRefreshDatabase;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Modules\User\Entities\User;

class HelpersTest extends TestCase
{
    use DisableRefreshDatabase;

    const TEST_CONSTANT = 'test';

    private $randomTestVariable = 'blablabla';

    public function testClassImplementsHelper()
    {
        $this->assertFalse(class_implements_interface(self::class, Filesystem::class));
        $this->assertTrue(class_implements_interface(self::class, \PHPUnit\Framework\Test::class));
        $this->assertFalse(class_implements_interface(new self(), Filesystem::class));
        $this->assertTrue(class_implements_interface(new self(), \PHPUnit\Framework\Test::class));
    }

    public function testAuthenticatedUserHelper()
    {
        $this->actingAs(factory(User::class)->make());
        $this->assertTrue(class_implements_interface(get_authenticated_user(), Authenticatable::class));
    }

    public function testClassShortNameHelper()
    {
        $this->assertEquals('HelpersTest', get_short_class_name(self::class));
    }

    public function testRandomArrayElementHelper()
    {
        $array = [
            'test',
            'x',
            'blabla',
            'hello',
            'hey',
        ];

        $randomArrayElement = get_random_array_element($array);

        $this->assertContains($randomArrayElement, $array);
    }

    public function testClassUsesTraitHelper()
    {
        $this->assertTrue(class_uses_trait(self::class, CreatesApplication::class));
        $this->assertFalse(class_uses_trait(self::class, Authorizable::class));
    }

    public function testArrayKeysExistHelper()
    {
        $requiredKeys = [
            'input1',
            'input3',
            'input4',
        ];

        $invalidArray = [
            'input1' => 5,
            'input3' => 4,
            'input5' => 3,
        ];

        $validArray = [
            'input1' => 5,
            'input3' => 4,
            'input4' => 3,
        ];
        $this->assertTrue(array_keys_exists($requiredKeys, $validArray));
        $this->assertFalse(array_keys_exists($requiredKeys, $invalidArray));
    }

    public function testArrayIsSubsetOfHelper()
    {
        $keyValueArray = [
            'input1' => 5,
            'input3' => 4,
            'input4' => 3,
        ];

        $valueArray = [
            'value1',
            'value2',
            'value4',
        ];

        $keyValueSubset = [
            'input1' => 5,
            'input3' => 4,
        ];

        $keyValueInvalidSubset = [
            'input1' => 4,
            'input3' => 4,
        ];

        $keyValueInvalidSubset2 = [
            'input2' => 5,
        ];

        $valueSubset = [
            'value2',
            'value4',
        ];

        $valueSubset2 = [
            'value1',
        ];

        $invalidValueSubset = [
            'value5',
        ];

        $invalidValueSubset2 = [
            'value1',
            'value2',
            'value3',
            'value4',
        ];

        $this->assertTrue(array_is_subset_of($keyValueSubset, $keyValueArray));
        $this->assertFalse(array_is_subset_of($keyValueInvalidSubset, $keyValueArray));
        $this->assertFalse(array_is_subset_of($keyValueInvalidSubset2, $keyValueArray));

        $this->assertTrue(array_is_subset_of($valueSubset, $valueArray));
        $this->assertTrue(array_is_subset_of($valueSubset2, $valueArray));
        $this->assertFalse(array_is_subset_of($invalidValueSubset, $valueArray));
        $this->assertFalse(array_is_subset_of($invalidValueSubset2, $valueArray));
    }

    public function testIsAssocativeArrayHelper()
    {
        $associativeArray = [
            'key1' => 'value1',
            'key3' => 'value3',
        ];

        $array = [
            0, 1, 2, 3,
        ];

        $mixedArray = [
            'key1' => 'value1',
            'randomvalue',
            'key3' => 'value3',
        ];

        $this->assertTrue(is_associative_array($associativeArray));
        $this->assertTrue(is_associative_array($mixedArray));
        $this->assertFalse(is_associative_array($array));
    }

    public function testGetClassPropertyHelper()
    {
        $this->assertEquals($this->randomTestVariable, get_class_property(static::class, 'randomTestVariable'));
    }

    public function testGetClassConstants()
    {
        $this->assertArrayHasKey('TEST_CONSTANT', get_class_constants(static::class));
        $this->assertEquals(self::TEST_CONSTANT, get_class_constants(static::class)['TEST_CONSTANT']);
    }

    public function testInstanceWithoutConstructor()
    {
        $this->assertInstanceOf(Larapi::class, instance_without_constructor(Larapi::class));
    }

    public function testSplitCapitalStringToUnderscores(){
        $this->assertEquals("proxy_uptime_collection", split_caps_to_underscore("ProxyUptimeCollection"));
    }
}
