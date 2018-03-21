<?php

use Illuminate\Database\Seeder;
use Tests\Unit\SeedData;

class DatabaseSeeder extends Seeder
{
    use SeedData;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tables = array_map('current', DB::select('SHOW TABLES'));
        foreach ($tables as $table) {
            //if you don't want to truncate migrations
            if ($table == 'migrations') {
                continue;
            }
            DB::table($table)->truncate();
        }
        $this->seedData("thisYear");
    }
}
