<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    public function testGetUsers()
    {
        $client = static::createClient();
        $client->request( 'GET', '/api/users', [], [], ['HTTP_ACCEPT' => 'application/json'] );
        $response = $client->getResponse();
        $content = $response->getContent();
        $this->assertEquals( 200, $response->getStatusCode() );
        $this->assertJson( $content );
        $arrayContent = \json_decode( $content, true );
        $this->assertCount( 10, $arrayContent );
    }

    public function testPostUsers ()
    {
        $client = static::createClient();
        $client->request('POST', '/api/user' , [], [],
            [
                'HTTP_ACCEPT' => 'application/json' ,
                'CONTENT_TYPE' => 'application/json' ,
                'HTTP_X-AUTH-TOKEN' => 'admin'
            ],
            '{"apiKey": "testPost","email": "testPost@testPost.com","firstname": "testPost", "lastname": "testPost","createdAt": "2017-05-12 00:00:00", "adress": "testPostAddress","country": "France", "subscription": "Premium", "card": "Gold"}'
        );
        $response = $client->getResponse ();
        $content = $response->getContent ();

        $this->assertEquals (200, $response->getStatusCode ());
        $this->assertJson ($content);
    }
}