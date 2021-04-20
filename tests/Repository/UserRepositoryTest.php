<?php
namespace App\Tests\Repository;

use App\Repository\UserRepository;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserRepositoryTest extends KernelTestCase
{
    use FixturesTrait;

    const FIXTURES_FILE = __DIR__ . '/../fixtures/UserFixturesTest.yaml';

    /**
     * @var UserRepository
     */
    private $userRepository;

    protected function setUp(): void
    {
        self::bootKernel();
        $this->userRepository = self::$container->get(UserRepository::class);
    }

    protected function tearDown(): void
    {
        $this->userRepository = null;
    }

    private function assertEqualsResults($queries = [], $expected = 10, $total = 10): void
    {
        $this->loadFixtureFiles([self::FIXTURES_FILE]);

        $results = $this->userRepository->findAllPaginate($queries);
        $this->assertEquals($total, $results['total']);
        $this->assertCount($expected, $results['content']);
    }

    public function testFindWithDefaultsPagination()
    {
        $this->assertEqualsResults();
    }

    public function testFindWithGivenPagination()
    {
        $this->assertEqualsResults(['par_page' => 7, 'page' => 2], 3);
    }
    
    public function testFindWithGivenPaginationAndQuery()
    {
        $this->assertEqualsResults(['par_page' => 7, 'page' => 1, 'q' => 1], 1, 1);
    }
}