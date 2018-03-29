<?php

namespace App\Repositories;

use App\Bill;
use App\Tag;

class BillRepository 
{
    public function create(array $attributes)
    {
        return Bill::create($attributes);
    }

    public function update(int $id, array $attributes)
    {
        return Bill::find($id)->update($attributes);
    }

    public function delete(array $id)
    {
        return Bill::destroy($id);
    }

    public function allCost()
    {
        return Bill::select('id', 'role', 'cost', 'time', 'tag_id', 'subtag_id', 'note')
            ->with([
                'tag' => function ($query) { $query->select('id', 'name'); },
                'subtag' => function ($query) { $query->select('id', 'name'); }
                ])
            ->get();
    }

    public function tagCost(int $tagId)
    {
        return Bill::select('id', 'role', 'cost', 'time', 'tag_id', 'subtag_id', 'note')
            ->where('tag_id', $tagId)
            ->with([
                'tag' => function ($query) { $query->select('id', 'name'); },
                'subtag' => function ($query) { $query->select('id', 'name'); }
                ])
            ->get();
    }

    public function todayCost()
    {
        return Bill::select('role', 'cost', 'time', 'tag_id')
            ->whereDate('time', date('Y-m-d'))
            ->with(['tag' => function ($query) { $query->select('id', 'name'); }])
            ->get();
    }

    public function weekCost()
    {
        return Bill::select(\DB::raw("DAY(`time`) AS `day`, SUM(`cost`) AS `sum`"))
            ->whereBetween('time', [
                date('Y-m-d', strtotime('last monday', strtotime('now'))), 
                date('Y-m-d', strtotime('next sunday', strtotime('now')))
                ])
            ->groupBy(\DB::raw("DAY(`time`)"))
            ->get();
    }

    public function monthCost()
    {
        return Bill::select(\DB::raw("DAY(`time`) AS `day`, SUM(`cost`) AS `sum`"))
            ->whereMonth('time', date('m'))
            ->groupBy(\DB::raw("DAY(`time`)"))
            ->get();
    }

    public function yearCost()
    {
        return Bill::select(\DB::raw("MONTH(`time`) AS `month`, SUM(`cost`) AS `sum`"))
            ->whereYear('time', date('Y'))
            ->groupBy(\DB::raw("MONTH(`time`)"))
            ->get();
    }

    public function todayCostByTag()
    {
        return Bill::select(\DB::raw("`tag_id`, SUM(`cost`) AS `sum`"))
        ->whereDate('time', date('Y-m-d'))
        ->with(['tag' => function ($query) { $query->select('id', 'name'); }])
        ->groupBy(\DB::raw("`tag_id`"))
        ->get();
    }

    public function weekCostByTag()
    {
        return Bill::select(\DB::raw("`tag_id`, SUM(`cost`) AS `sum`"))
            ->whereBetween('time', [
                date('Y-m-d', strtotime('last monday', strtotime('now'))), 
                date('Y-m-d', strtotime('next sunday', strtotime('now')))
                ])
            ->with(['tag' => function ($query) { $query->select('id', 'name'); }])
            ->groupBy(\DB::raw("`tag_id`"))
            ->get();
    }

    public function monthCostByTag()
    {
        return Bill::select(\DB::raw("`tag_id`, SUM(`cost`) AS `sum`"))
            ->whereMonth('time', date('m'))
            ->with(['tag' => function ($query) { $query->select('id', 'name'); }])
            ->groupBy(\DB::raw("`tag_id`"))
            ->get();
    }

    public function yearCostByTag()
    {
        return Bill::select(\DB::raw("`tag_id`, SUM(`cost`) AS `sum`"))
            ->whereYear('time', date('Y'))
            ->with(['tag' => function ($query) { $query->select('id', 'name'); }])
            ->groupBy(\DB::raw("`tag_id`"))
            ->get();
    }

    public function todayCostByRole()
    {
        return Bill::select(\DB::raw("`role`, SUM(`cost`) AS `sum`"))
            ->whereDate('time', date('Y-m-d'))
            ->groupBy(\DB::raw("`role`"))
            ->orderByRaw("FIELD(role , '自己', '女友', '其他') ASC")
            ->get();
    }

    public function weekCostByRole()
    {
        return Bill::select(\DB::raw("`role`, SUM(`cost`) AS `sum`"))
            ->whereBetween('time', [
                date('Y-m-d', strtotime('last sunday', strtotime('now'))), 
                date('Y-m-d', strtotime('next monday', strtotime('now')))
                ])
            ->groupBy(\DB::raw("`role`"))
            ->orderByRaw("FIELD(role , '自己', '女友', '其他') ASC")
            ->get();
    }

    public function monthCostByRole()
    {
        return Bill::select(\DB::raw("`role`, SUM(`cost`) AS `sum`"))
            ->whereMonth('time', date('m'))
            ->groupBy(\DB::raw("`role`"))
            ->orderByRaw("FIELD(role , '自己', '女友', '其他') ASC")
            ->get();
    }

    public function yearCostByRole()
    {
        return Bill::select(\DB::raw("`role`, SUM(`cost`) AS `sum`"))
            ->whereYear('time', date('Y'))
            ->groupBy(\DB::raw("`role`"))
            ->orderByRaw("FIELD(role , '自己', '女友', '其他') ASC")
            ->get();
    }
}