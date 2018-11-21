<?php
/**
 * Created by PhpStorm.
 * User: QuanDar
 * Date: 08/11/2018
 * Time: 16:53
 */

namespace App\Test\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CommentControllerTest extends WebTestCase
{
    public function testPostCommentWithModel()
    {
        $commentId = uniqid();

        $response = $this->client->post('/message/comment/post', [
            'json' => [
                'id'    => $commentId,
                'content'     => 'Random message content',
            ]
        ]);

        $this->assertEquals(201, $response->getStatusCode());

        $data = json_decode($response->getBody(), true);

        $this->assertEquals($commentId, $data['id']);
    }

    public function testPostCommentNoModel()
    {
        $client = static::createClient();

        $client->request('POST', '/message/comment/post');

        $this->assertEquals(400, $client->getResponse()->getStatusCode());
    }


    public function testUpdateCommentNoModel()
    {
        $client = static::createClient();

        $client->request('POST', '/message/comment/update');

        $this->assertEquals(404, $client->getResponse()->getStatusCode());
    }

    public function testUpdateCommentWithModel()
    {
        $messageId = uniqid();

        $response = $this->client->post('/message/comment/update', [
            'json' => [
                'id'    => $messageId,
                'upVotes'     => 33,
            ]
        ]);

        $this->assertEquals(200, $response->getStatusCode());

        $data = json_decode($response->getBody(), true);

        $this->assertEquals($messageId, $data['id']);
    }

    public function testDeleteComment()
    {
        $client = static::createClient();

        $client->request('DELETE', '/message/comment/delete');

        $this->assertEquals(404, $client->getResponse()->getStatusCode());
    }

    public function testCommentController_GET_comment(){
        $client = static::createClient();

        $client->request('GET', '/comment');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

    }

    public function testCommentController_GET_commentUpdate(){
        $client = static::createClient();

        $client->request('GET', '/comment/update');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

    }

    public function testCommentController_GET_commentDelete(){
        $client = static::createClient();

        $client->request('GET', '/comment/delete');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

    }

    public function testCommentController_getRightPage(){
        $client = static::createClient();

        $crawler = $client->request('GET', '/comment');

        $this->assertSame('Comment Controls', $crawler->filter('h1')->text());

    }
}