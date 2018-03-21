<?php

use tests\TestCase;
use App\Repositories\TagRepository;

class TagControllerTest extends TestCase
{
    protected $mock = null;

    protected function setUp()
    {
        parent::setUp();

        $this->mock = $this->initMock(TagRepository::class);
    }

    protected function tearDown()
    {
        parent::tearDown();
        Mockery::close();
    }

    /**
     * @group TagController
     */
    public function testCSRFFailed()
    {         
        $response = $this->post('api/tag/add');
        $response->assertStatus(500);
    }
    
    /**
     * @group TagController
     */
    public function testCreateTag()
    {
        $this->mock
            ->shouldReceive('createTag')
            ->once()
            ->withAnyArgs();

        $response = $this->post('api/tag/add');
        $response->assertStatus(201)
            ->assertJson(['msg' => 'add tag successfully']);
    }
    
    /**
     * @group TagController
     */
    public function testCreateSubtag()
    {
        $this->mock
            ->shouldReceive('createSubtag')
            ->once()
            ->withAnyArgs();

        $response = $this->post('api/subtag/add');
        $response->assertStatus(201)
            ->assertJson(['msg' => 'add subtag successfully']);
    }
        
    /**
     * @group TagController
     */
    public function testAllTag()
    {
        $this->mock
            ->shouldReceive('allTag')
            ->once()
            ->withAnyArgs();

        $response = $this->get('api/tag/all');
        $response->assertStatus(200);
    }
    
    /**
     * @group TagController
     */
    public function testUpdateTag()
    {
        $this->mock
            ->shouldReceive('updateTag')
            ->once()
            ->withAnyArgs();

        $response = $this->put('api/tag/update/1');
        $response->assertStatus(200)
            ->assertJson(['msg' => 'update tag successfully']);
    }
    
    /**
     * @group TagController
     */
    public function testUpdateSubtag()
    {
        $this->mock
            ->shouldReceive('updateSubtag')
            ->once()
            ->withAnyArgs();

        $response = $this->put('api/subtag/update/1');
        $response->assertStatus(200)
            ->assertJson(['msg' => 'update subtag successfully']);
    }
    
    /**
     * @group TagController
     */
    public function testDeleteTag()
    {
        $this->mock
            ->shouldReceive('deleteTag')
            ->once()
            ->withAnyArgs();

        $response = $this->delete('api/tag/delete/1');
        $response->assertStatus(200)
            ->assertJson(['msg' => 'delete tag successfully']);
    }
    
    /**
     * @group TagController
     */
    public function testDeleteSubtag()
    {
        $this->mock
            ->shouldReceive('deleteSubtag')
            ->once()
            ->withAnyArgs();

        $response = $this->delete('api/subtag/delete/1');
        $response->assertStatus(200)
            ->assertJson(['msg' => 'delete subtag successfully']);
    }
}