<?php
/**
 * Created by PhpStorm.
 * User: arthur
 * Date: 14.10.18
 * Time: 22:56.
 */

namespace Foundation\Tests;

//Tests disabled because need to find a way to enable pusher without sending messages to test.
/*
class BroadcastTest extends HttpTest
{

    public function testPrivateChannelAuthenticationSuccess()
    {
        $user = $this->getHttpUser();
        $id = $user->getKey();
        $response = $this->http('POST', '/broadcasting/auth', [
            'socket_id' => '125200.2991064',
            'channel_name' => 'private-user.' . $id
        ]);
        //$response->assertStatus(200);
        $response = $this->decodeHttpContent($response->content(), false);
        $this->assertArrayHasKey('auth', $response);
    }

    public function testPrivateChannelAuthenticationForbidden()
    {
        $response = $this->http('POST', '/broadcasting/auth', [
            'socket_id' => '125200.2991064',
            'channel_name' => 'private-user.' . new ObjectId()
        ]);
        $response->assertStatus(403);
    }

}*/
