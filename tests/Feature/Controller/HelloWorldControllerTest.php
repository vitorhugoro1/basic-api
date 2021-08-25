<?php

namespace Tests\Feature\Controller;

use Tests\TestCase;

/**
 * @covers \App\Controller\HelloWorlController::
 */
class HelloWorldControllerTest extends TestCase
{
    /** @test */
    public function testShouldReturnHelloWorld()
    {
        $response = $this->call('GET', '/');

        $this->assertJson($response->getBody());
        $this->assertJsonStringEqualsJsonString(
            '{"hello":"world"}',
            $response->getBody()
        );
    }
}
