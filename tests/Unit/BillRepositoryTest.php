<?php

use Tests\TestCase;
use Tests\Unit\SeedData;
use App\Repositories\BillRepository;

class BillRepositoryTest extends TestCase
{
    use SeedData;
    protected $repository = null;

    protected function setUp()
    {
        parent::setUp();

        $this->initDatabase();
        $this->seedData("thisWeek");
        
        $this->repository = new BillRepository();
    }

    protected function tearDown()
    {
        $this->resetDatabase();
        $this->repositroy = null;
    }

    /**
     * @group BillRepository
     */
    public function testCreate()
    {
        $nextId = App\Bill::latest('id')->first()->id + 1;
        $bill = $this->repository->create([
            'role' => '自己',
            'cost' => 100,
            'time' => date('Y-m-d H:m'),
            'tag_id' => 2
        ]);

        $this->assertEquals($nextId, $bill->id);
    }

    /**
     * @group BillRepository
     */
    public function testUpdate()
    {
        $newData = [
            'cost' => 1,
            'role' => '男友',
            'note' => 'let update!',
            'time' => date('Y-m-d H:m'),
            'tag_id' => 2,
            'subtag_id' => 1
        ];
        $randomId = rand(1, App\Bill::count());
        sleep(1);
        $this->repository->update($randomId, $newData);
        $newBill = App\Bill::find($randomId);

        $this->assertNotEquals($newBill->created_at, $newBill->updated_at);
        $this->assertEquals($newBill->cost, $newData['cost']);
        $this->assertEquals($newBill->role, $newData['role']);
        $this->assertEquals($newBill->note, $newData['note']);
        $this->assertEquals($newBill->time, $newData['time']);
        $this->assertEquals($newBill->tag_id, $newData['tag_id']);
        $this->assertEquals($newBill->subtag_id, $newData['subtag_id']);
    }

    /**
     * @group BillRepository
     */
    public function testDelete()
    {
        $randomId = rand(1, App\Bill::count());
        $total = App\Bill::count();
        $this->repository->delete($randomId);
        $this->assertEquals(App\Bill::count(), $total - 1);
    }

    /**
     * @group BillRepository
     */
    public function testAllCost()
    {
        $total = App\Bill::count();
        $bills = $this->repository->allCost();
        $this->assertCount($total, $bills);
    }

    /**
     * @group BillRepository
     */
    public function testTagCost()
    {
        $tags = App\Tag::all();
        foreach ($tags as $tag) {
            $total = App\Bill::where('tag_id', $tag->id)->count();
            $bills = $this->repository->tagCost($tag->id);
            $this->assertCount($total, $bills);
        }
    }

    /**
     * @group BillRepository
     */
    public function testTodayCost()
    {
        $bills = $this->repository->todayCost();
        foreach ($bills as $bill)
        {
            $this->assertContains(date('Y-m-d'), $bill->time);
        }
    }

    /**
     * @group BillRepository
     */
    public function testweekCost()
    {
        $this->resetDatabase();
        $this->initDatabase();
        $this->seedData('thisMonth');
        $bills = $this->repository->weekCost();
        foreach ($bills as $bill)
        {
            $this->assertContains(date('W', strtotime($bill->time)), date('W'));
        }
    }

    /**
     * @group BillRepository
     */
    public function testMonthCost()
    {
        $this->resetDatabase();
        $this->initDatabase();
        $this->seedData('thisYear');
        $bills = $this->repository->monthCost();
        foreach ($bills as $bill)
        {
            $this->assertContains(date('m', strtotime($bill->time)), date('m'));
        }
    }

    /**
     * @group BillRepository
     */
    public function testYearCost()
    {
        $this->resetDatabase();
        $this->initDatabase();
        $this->seedData('default');
        $bills = $this->repository->yearCost();
        foreach ($bills as $bill)
        {
            $this->assertContains(date('Y', strtotime($bill->time)), date('Y'));
        }
    }

    /**
     * @group BillRepository
     */
    public function testTodayCostByTag()
    {
        $tags = $this->repository->todayCostByTag();
        foreach ($tags as $tag)
        {
            foreach ($tag->bill as $bill)
            {
                $this->assertContains(date('Y-m-d'), $bill->time);
                $this->assertEquals($tag->id, $bill->tag_id);
            }
        }
    }

    /**
     * @group BillRepository
     */
    public function testWeekCostByTag()
    {
        $this->resetDatabase();
        $this->initDatabase();
        $this->seedData('thisMonth');
        $tags = $this->repository->weekCostByTag();
        foreach ($tags as $tag)
        {
            foreach ($tag->bill as $bill)
            {
                $this->assertContains(date('W', strtotime($bill->time)), date('W'));
                $this->assertEquals($tag->id, $bill->tag_id);
            }
        }
    }

    /**
     * @group BillRepository
     */
    public function testMonthCostByTag()
    {
        $this->resetDatabase();
        $this->initDatabase();
        $this->seedData('thisYear');
        $tags = $this->repository->monthCostByTag();
        foreach ($tags as $tag)
        {
            foreach ($tag->bill as $bill)
            {
                $this->assertContains(date('m', strtotime($bill->time)), date('m'));
                $this->assertEquals($tag->id, $bill->tag_id);
            }
        }
    }

    /**
     * @group BillRepository
     */
    public function testYearCostByTag()
    {
        $this->resetDatabase();
        $this->initDatabase();
        $this->seedData('default');
        $tags = $this->repository->yearCostByTag();
        foreach ($tags as $tag)
        {
            foreach ($tag->bill as $bill)
            {
                $this->assertContains(date('Y', strtotime($bill->time)), date('Y'));
                $this->assertEquals($tag->id, $bill->tag_id);
            }
        }
    }

    /**
     * @group BillRepository
     */
    public function testTodayCostByRole()
    {
        $roles = ['自己', '女友', '其他'];
        foreach ($roles as $role) {
            $bills = $this->repository->todayCostByRole($role);
            foreach ($bills as $bill)
            {
                $this->assertContains(date('Y-m-d'), $bill->time);
                $this->assertEquals($role, $bill->role);
            }
        }
    }

    /**
     * @group BillRepository
     */
    public function testWeekCostByRole()
    {
        $this->resetDatabase();
        $this->initDatabase();
        $this->seedData('thisMonth');
        $roles = ['自己', '女友', '其他'];
        foreach ($roles as $role) {
            $bills = $this->repository->weekCostByRole($role);
            foreach ($bills as $bill)
            {
                $this->assertContains(date('W', strtotime($bill->time)), date('W'));
                $this->assertEquals($role, $bill->role);
            }
        }
    }

    /**
     * @group BillRepository
     */
    public function testMonthCostByRole()
    {
        $this->resetDatabase();
        $this->initDatabase();
        $this->seedData('thisYear');
        $roles = ['自己', '女友', '其他'];
        foreach ($roles as $role) {
            $bills = $this->repository->monthCostByRole($role);
            foreach ($bills as $bill)
            {
                $this->assertContains(date('m', strtotime($bill->time)), date('m'));
                $this->assertEquals($role, $bill->role);
            }
        }
    }

    /**
     * @group BillRepository
     */
    public function testYearCostByRole()
    {
        $this->resetDatabase();
        $this->initDatabase();
        $this->seedData('default');
        $roles = ['自己', '女友', '其他'];
        foreach ($roles as $role) {
            $bills = $this->repository->yearCostByRole($role);
            foreach ($bills as $bill)
            {
                $this->assertContains(date('Y', strtotime($bill->time)), date('Y'));
                $this->assertEquals($role, $bill->role);
            }
        }
    }
}