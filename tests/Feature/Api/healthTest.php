<?php

namespace Tests\Feature;

use Tests\ApiTestCase;

class healthTest extends ApiTestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $response = $this->get('/api/health');

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals("application/json", $response->getHeaders()["Content-Type"][0]);
        $this->assertEquals('ok', json_decode($response->getBody())->{"health"});
    }
}