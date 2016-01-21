<?php

use Silex\WebTestCase;

/**
 * @group integration
 *
 * @author timrodger
 * Date: 18/03/15
 */
class AppIntegrationTest extends WebTestCase
{
    /**
     * @var Symfony\Component\HttpKernel\Client
     */
    private $client;

    public function createApplication()
    {
        putenv('REDIS_PORT=MEMORY');
        return require __DIR__.'/../../app.php';
    }

    public function testGetReturnsErrorWhenNoKeyFound()
    {
        $this->givenAClient();
        $this->client->request('GET', '/tokens/missing');

        $this->thenTheResponseIs404();
    }

    public function testGetReturnsSuccessWhenFound()
    {
        $this->givenAClient();
        $this->client->request('PUT', '/tokens/xxx', ['token' => 'secret']);
        $this->client->request('GET', '/tokens/xxx');

        $this->thenTheResponseIsSuccess();
        $this->assertResponseContents('secret');
    }

    public function testGetAllReturnsSuccess()
    {
        $this->givenAClient();
        $this->client->request('PUT', '/tokens/xxx', ['token' => 'secret']);
        $this->client->request('PUT', '/tokens/yyy', ['token' => 'another secret']);
        $this->client->request('PUT', '/tokens/abc', ['token' => 'string q']);
        $this->client->request('GET', '/tokens');

        $this->thenTheResponseIsSuccess();
        $this->assertResponseContents(json_encode(['xxx', 'yyy','abc']));
    }

    private function givenAClient()
    {
        $this->client = $this->createClient();
    }

    private function thenTheResponseIsSuccess()
    {
        $this->assertSame(200, $this->client->getResponse()->getStatusCode());
    }

    private function thenTheResponseIs204()
    {
        $this->assertSame(204, $this->client->getResponse()->getStatusCode());
    }

    private function thenTheResponseIs404()
    {
        $this->assertSame(404, $this->client->getResponse()->getStatusCode());
    }

    private function thenTheResponseIs500()
    {
        $this->assertSame(500, $this->client->getResponse()->getStatusCode());
    }

    private function assertResponseContents($expected_body)
    {
        $this->assertEquals($expected_body, $this->client->getResponse()->getContent());
    }
}
