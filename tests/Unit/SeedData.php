<?php

namespace Tests\Unit;

use App\Bill;
use App\Tag;
use App\Subtag;

trait SeedData
{
    public function seedData(string $state)
    {
        factory(Tag::class, 5)->create()->each(function ($t) use ($state)
        {
            $subtag = factory(Subtag::class, rand(1, 4))->create(['tag_id' => $t->id])->each(function ($st) use ($state)
            {
                $num = 10;
                switch ($state) {
                    case 'thisWeek':
                        $bill = factory(Bill::class, $num)->states($state)->create(['subtag_id' => $st->id, 'tag_id' => $st->tag_id]);
                        break;
                    case 'thisMonth':
                        $bill = factory(Bill::class, $num)->states($state)->create(['subtag_id' => $st->id, 'tag_id' => $st->tag_id]);
                        break;
                    case 'thisYear':
                        $bill = factory(Bill::class, $num)->states($state)->create(['subtag_id' => $st->id, 'tag_id' => $st->tag_id]);
                        break;
                    default:
                        $bill = factory(Bill::class, $num)->create(['subtag_id' => $st->id, 'tag_id' => $st->tag_id]);
                        break;
                }
                $st->bill()->save($bill->first());
            });
            $t->subtag()->save($subtag->first());
        });
    }
}