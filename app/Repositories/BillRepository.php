<?php

namespace App\Repositories;

use App\Bill;

class BillRepository 
{
    public function latest10()
    {
        return Bill::orderBy('id')->take(10)->get();
    }
}