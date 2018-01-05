<?php

use tests\TestCase;
use App\Repositories\BillRepository;

class BillRepositoryTest extends TestCase
{
    protected $repository = null;

    protected function setUp()
    {
        parent::setUp();

        $this->initDatabase();
        $this->seedData("thisWeek");
        
        $this->repository = new BillRepository();
    }

    public function seedData(string $state)
    {
        factory(App\Tag::class, 5)->create()->each(function ($t) use ($state)
        {
            $subtag = factory(App\Subtag::class, rand(1, 4))->create(['tag_id' => $t->id])->each(function ($st) use ($state)
            {
                $num = 10;
                switch ($state) {
                    case 'thisWeek':
                        $bill = factory(App\Bill::class, $num)->states($state)->create(['subtag_id' => $st->id, 'tag_id' => $st->tag_id]);
                        break;
                    case 'thisMonth':
                        $bill = factory(App\Bill::class, $num)->states($state)->create(['subtag_id' => $st->id, 'tag_id' => $st->tag_id]);
                        break;
                    case 'thisYear':
                        $bill = factory(App\Bill::class, $num)->states($state)->create(['subtag_id' => $st->id, 'tag_id' => $st->tag_id]);
                        break;
                    default:
                        $bill = factory(App\Bill::class, $num)->create(['subtag_id' => $st->id, 'tag_id' => $st->tag_id]);
                        break;
                }
                $st->bill()->save($bill->first());
            });
            $t->subtag()->save($subtag->first());
        });
    }

    protected function tearDown()
    {
        $this->resetDatabase();
        $this->repositroy = null;
    }

    /**
     * @group BillRepository
     * @group ignore
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
     * @group ignore
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
     * @group ignore
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
     * @group ignore
     */
    public function testAllCost()
    {
        $total = App\Bill::count();
        $bills = $this->repository->allCost();
        $this->assertCount($total, $bills);
    }

    /**
     * @group BillRepository
     * @group ignore
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
     * @group ignore
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
     * @group ignore
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
     * @group ignore
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
     * @group ignore
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
     * @group ignore
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
     * @group ignore
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
     * @group ignore
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
     * @group ignore
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
     * @group ignore
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
     * @group ignore
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
     * @group ignore
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
     * @group ignore
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