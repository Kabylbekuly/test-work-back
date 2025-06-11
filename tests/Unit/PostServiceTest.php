<?php

namespace Tests\Unit;

use App\Repositories\PostRepository;
use App\Services\PostService;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;

class PostServiceTest extends TestCase
{
    /** @var PostRepository|MockObject */
    private $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = $this->createMock(PostRepository::class);
    }

    public function test_get_all_returns_repository_results()
    {
        $expected = ['foo'];
        $this->repository->expects($this->once())
            ->method('with')
            ->with('category')
            ->willReturnSelf();
        $this->repository->expects($this->once())
            ->method('get')
            ->willReturn($expected);

        $service = new PostService($this->repository);
        $result = $service->getAll();

        $this->assertSame($expected, $result);
    }

    public function test_store_creates_post()
    {
        $data = ['name' => 'Post', 'description' => 'd', 'content' => 'c', 'cat_id' => 1];
        $created = (object)$data;

        $this->repository->expects($this->once())
            ->method('create')
            ->with($data)
            ->willReturn($created);

        $service = new PostService($this->repository);
        $result = $service->store($data);

        $this->assertSame($created, $result);
    }
}
