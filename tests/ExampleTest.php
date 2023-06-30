<?php

namespace Tests;

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_that_base_endpoint_returns_a_successful_response()
    {
        $response = $this->get('/');

        $response->seeJsonStructure([
            "name",
            "message",
            "technology" => [
                "framework",
                "Authantication",
            ],
            "status"
        ])->assertResponseStatus(200);
    }

    public function testUrls()
    {
        $urlnotfound = $this->call('GET', '/api');
        $this->assertEquals(404, $urlnotfound->status());

        $headernotfound1 = $this->call('GET', '/api/portfolio');
        $this->assertEquals(401, $headernotfound1->status());

        $headernotfound2 = $this->call('GET', '/api/portfolio/1');
        $this->assertEquals(401, $headernotfound2->status());

        $headernotfound3 = $this->call('POST', '/api/portfolio');
        $this->assertEquals(401, $headernotfound3->status());

        $headernotfound4 = $this->call('PUT', '/api/portfolio/1');
        $this->assertEquals(401, $headernotfound4->status());

        $headernotfound5 = $this->call('DELETE', '/api/portfolio/1');
        $this->assertEquals(401, $headernotfound5->status());
    }
}
