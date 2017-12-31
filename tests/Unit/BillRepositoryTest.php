<?php

use tests\TestCase;
use App\Repositories\BillRepository;
use App\Bill;

class BillRepositoryTest extends TestCase
{
    protected $repository = null;

    public function setUp()
    {
        parent::setUp();

        $this->initDatabase();
        factory(App\Bill::class, 100)->create();
        $this->repository = new BillRepository();
    }

    public function tearDown()
    {
        $this->resetDatabase();
        $this->repositroy = null;
    }

    public function testFetchLatest10Bills()
    {
        $bills = $this->repository->latest10();
        $this->assertEquals(10, count($bills));
    }
}