<?php
/**
 * Created by PhpStorm.
 * User: arthur
 * Date: 08.03.19
 * Time: 11:13.
 */

namespace Foundation\Abstracts\Tests;

use Illuminate\Foundation\Testing\Assert as PHPUnit;
use Illuminate\Foundation\Testing\TestResponse as ParentTestResponse;

class TestResponse extends ParentTestResponse
{
    public function assertStatus($status)
    {
        $actual = $this->getStatusCode();
        PHPUnit::assertTrue(
            $actual === $status,
            "Expected status code {$status} but received {$actual}."."\n".$this->getContent()
        );

        return $this;
    }

    public function decode()
    {
        return json_decode($this->getContent(), true)['data'] ?? json_decode($this->getContent(), true);
    }
}
