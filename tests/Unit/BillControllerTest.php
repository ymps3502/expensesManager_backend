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
     */
    public function testCSRFFailed()
    {         
        $response = $this->post('api/bill/add');
        $response->assertStatus(500);
    }

    /**
     * @group BillController
     */
    public function testCreate()
    {
        $this->mock
            ->shouldReceive('create')
            ->once()
            ->withAnyArgs();

        $response = $this->post('api/bill/add');
        $response->assertStatus(201)
            ->assertJson(['msg' => 'add bill successfully']);
    }

    /**
     * @group BillController
     */
    public function testAllCost()
    {
        $this->mock
            ->shouldReceive('allCost')
            ->once()
            ->andReturn();
        $response = $this->get('api/bill/all');
        $response->assertStatus(200);
    }

    /**
     * @group BillController
     */
    public function testTagCost()
    {
        $this->mock
            ->shouldReceive('tagCost')
            ->once()
            ->andReturn();
        $response = $this->get('api/bill/tag/1');
        $response->assertStatus(200);
    }

    /**
     * @group BillController
     * @group BC-today
     */
    public function testTodayCost()
    {
        $this->mock
            ->shouldReceive('todayCost')
            ->once()
            ->andReturn();
        $response = $this->get('api/bill/today');
        $response->assertStatus(200);
    }

    /**
     * @group BillController
     * @group BC-today
     */
    public function testTodayTagCost()
    {
        $this->mock
            ->shouldReceive('todayCostByTag')
            ->once()
            ->andReturn();
        $response = $this->get('api/bill/today/tag');
        $response->assertStatus(200);
    }

    /**
     * @group BillController
     * @group BC-today
     */
    public function testTodayRoleCost()
    {
        $this->mock
            ->shouldReceive('todayCostByRole')
            ->once()
            ->andReturn();
        $response = $this->get('api/bill/today/role');
        $response->assertStatus(200);
    }

    /**
     * @group BillController
     * @group BC-week
     */
    public function testWeekCost()
    {
        $this->mock
            ->shouldReceive('weekCost')
            ->once()
            ->andReturn();
        $response = $this->get('api/bill/week');
        $response->assertStatus(200);
    }

    /**
     * @group BillController
     * @group BC-week
     */
    public function testWeekTagCost()
    {
        $this->mock
            ->shouldReceive('weekCostByTag')
            ->once()
            ->andReturn();
        $response = $this->get('api/bill/week/tag');
        $response->assertStatus(200);
    }

    /**
     * @group BillController
     * @group BC-week
     */
    public function testWeekRoleCost()
    {
        $this->mock
            ->shouldReceive('weekCostByRole')
            ->once()
            ->andReturn();
        $response = $this->get('api/bill/week/role');
        $response->assertStatus(200);
    }

    /**
     * @group BillController
     * @group BC-month
     */
    public function testMonthCost()
    {
        $this->mock
            ->shouldReceive('monthCost')
            ->once()
            ->andReturn();
        $response = $this->get('api/bill/month');
        $response->assertStatus(200);
    }

    /**
     * @group BillController
     * @group BC-month
     */
    public function testMonthTagCost()
    {
        $this->mock
            ->shouldReceive('monthCostByTag')
            ->once()
            ->andReturn();
        $response = $this->get('api/bill/month/tag');
        $response->assertStatus(200);
    }

    /**
     * @group BillController
     * @group BC-month
     */
    public function testMonthRoleCost()
    {
        $this->mock
            ->shouldReceive('monthCostByRole')
            ->once()
            ->andReturn();
        $response = $this->get('api/bill/month/role');
        $response->assertStatus(200);
    }

    /**
     * @group BillController
     * @group BC-year
     */
    public function testYearCost()
    {
        $this->mock
            ->shouldReceive('yearCost')
            ->once()
            ->andReturn();
        $response = $this->get('api/bill/year');
        $response->assertStatus(200);
    }

    /**
     * @group BillController
     * @group BC-year
     */
    public function testYearTagCost()
    {
        $this->mock
            ->shouldReceive('yearCostByTag')
            ->once()
            ->andReturn();
        $response = $this->get('api/bill/year/tag');
        $response->assertStatus(200);
    }

    /**
     * @group BillController
     * @group BC-year
     */
    public function testYearRoleCost()
    {
        $this->mock
            ->shouldReceive('yearCostByRole')
            ->once()
            ->andReturn();
        $response = $this->get('api/bill/year/role');
        $response->assertStatus(200);
    }

    /**
     * @group BillController
     */
    public function testUpdate()
    {
        $this->mock
            ->shouldReceive('update')
            ->once()
            ->withAnyArgs();

        $response = $this->put('api/bill/update/1');
        $response->assertStatus(200)
            ->assertJson(['msg' => 'update bill successfully']);
    }

    /**
     * @group BillController
     */
    public function testDelete()
    {
        $this->mock
            ->shouldReceive('delete')
            ->once()
            ->withAnyArgs();

        $response = $this->delete('api/bill/delete/1');
        $response->assertStatus(200)
            ->assertJson(['msg' => 'delete bill successfully']);
    }
}