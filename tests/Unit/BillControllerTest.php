<?php

use tests\TestCase;
use App\Repositories\BillRepository;

class BillControllerTest extends TestCase
{
    protected $mock = null;

    protected function setUp()
    {
        parent::setUp();

        $this->mock = $this->initMock(BillRepository::class);
    }

    protected function tearDown()
    {
        parent::tearDown();
        Mockery::close();
    }

    /**
     * @group BillController
     * @group ignore
     */
    public function testAllCost()
    {
        $this->mock
            ->shouldReceive('allCost')
            ->once();
            
        $response = $this->get('/api/bill/all');
        $response->assertStatus(200);
    }

    /**
     * @group BillController
     * @group ignore
     */
    public function testCSRFFailed()
    {         
        $response = $this->POST('/api/bill/add');
        $response->assertStatus(500);
    }

    /**
     * @group BillController
     * @group ignor
     */
    public function testCreate()
    {
        $this->mock
            ->shouldReceive('create')
            ->once()
            ->withAnyArgs();

        $response = $this->post('api/bill/add');
        $response->assertStatus(201)
            ->assertJsonStructure(['message']);
    }
}