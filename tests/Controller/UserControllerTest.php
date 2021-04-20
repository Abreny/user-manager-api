<?php
namespace App\Tests\Controller;

use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    use FixturesTrait;

    const FIXTURES_FILE = __DIR__ . '/../fixtures/UserFixturesTest.yaml';
    const LIST_URL = '/api/v1/users';

    public function testGetAllUsers() {
        $client = static::createClient();

        $this->loadFixtureFiles([self::FIXTURES_FILE]);
        $client->request('GET', self::LIST_URL);

        $this->assertResponseIsSuccessful();
        
        $response = json_decode($client->getResponse()->getContent());
        $this->assertNotNull($response->users);
        $this->assertNotNull($response->total);
    }
    
    public function testGetPage() {
        $client = static::createClient();

        $this->loadFixtureFiles([self::FIXTURES_FILE]);
        $client->request('GET', self::LIST_URL, [
            'page' => 2
        ]);

        $this->assertResponseIsSuccessful();
        
        $response = json_decode($client->getResponse()->getContent());
        $this->assertCount(0, $response->users);
        $this->assertEquals(10, $response->total);
    }

    public function testGetParPage() {
        $client = static::createClient();

        $this->loadFixtureFiles([self::FIXTURES_FILE]);
        $client->request('GET', self::LIST_URL, [
            'page' => 2,
            'par_page' => 7
        ]);

        $this->assertResponseIsSuccessful();
        
        $response = json_decode($client->getResponse()->getContent());
        $this->assertCount(3, $response->users);
        $this->assertEquals(10, $response->total);
    }
    
    public function testResolveCors() {
        $client = static::createClient();

        $this->loadFixtureFiles([__DIR__ . '/../fixtures/UserFixturesTest.yaml']);
        $client->request('GET', '/api/v1/users');

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('Content-Type', 'application/json');
        $this->assertResponseHasHeader('Access-Control-Allow-Origin');
        $this->assertResponseHasHeader('Access-Control-Allow-Methods');
    }
}
