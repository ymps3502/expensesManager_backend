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

    public function delete(int $id)
    {
        return Bill::destroy($id);
    }

    public function allCost()
    {
        return Bill::select('role', 'cost', 'time', 'tag_id', 'subtag_id', 'note')
            ->with([
                'tag' => function ($query) { $query->select('id', 'name'); },
                'subtag' => function ($query) { $query->select('id', 'name'); }
                ])
            ->get();
    }

    public function tagCost(int $tagId)
    {
        return Bill::select('role', 'cost', 'time', 'tag_id', 'subtag_id', 'note')
            ->where('tag_id', $tagId)
            ->with([
                'tag' => function ($query) { $query->select('id', 'name'); },
                'subtag' => function ($query) { $query->select('id', 'name'); }
                ])
            ->get();
    }

    public function todayCost()
    {
        return Bill::select('role', 'cost', 'time', 'tag_id', 'subtag_id')
            ->whereDate('time', '=', date('Y-m-d'))
            ->with([
                'tag' => function ($query) { $query->select('id', 'name'); },
                'subtag' => function ($query) { $query->select('id', 'name'); }
                ])
            ->get();

        /**
         * alternative query
         */
        // return Bill::join('tags', 'tags.id', '=', 'bills.tag_id')
        //     ->leftJoin('subtags', 'subtags.id', '=', 'bills.subtag_id')
        //     ->select('bills.role', 'bills.cost', 'bills.time', 'tags.name AS tag_name', 'subtags.name AS subtag_name')
        //     ->whereDate('time', '=', date('Y-m-d'))
        //     ->get();
    }

    public function weekCost()
    {
        return Bill::select('role', 'cost', 'time', 'tag_id', 'subtag_id')
            ->whereBetween('time', [
                date('Y-m-d', strtotime('last monday', strtotime('now'))), 
                date('Y-m-d', strtotime('next sunday', strtotime('now')))
                ])
            ->with([
                'tag' => function ($query) { $query->select('id', 'name'); },
                'subtag' => function ($query) { $query->select('id', 'name'); }
                ])
            ->get();
    }

    public function monthCost()
    {
        return Bill::select('role', 'cost', 'time', 'tag_id', 'subtag_id')
            ->whereMonth('time', date('m'))
            ->with([
                'tag' => function ($query) { $query->select('id', 'name'); },
                'subtag' => function ($query) { $query->select('id', 'name'); }
                ])
            ->get();
    }

    public function yearCost()
    {
        return Bill::select('role', 'cost', 'time', 'tag_id', 'subtag_id')
            ->whereYear('time', date('Y'))
            ->with([
                'tag' => function ($query) { $query->select('id', 'name'); },
                'subtag' => function ($query) { $query->select('id', 'name'); }
                ])
            ->get();
    }

    public function todayCostByTag()
    {
        return Tag::select('id', 'name')->with(['bill' => function ($query) {
            $query->select('tag_id', 'cost', 'time')->whereDate('time', '=', date('Y-m-d'));
        }])
        ->get();
    }

    public function weekCostByTag()
    {
        return Tag::select('id', 'name')->with(['bill' => function ($query) {
            $query->select('tag_id', 'cost', 'time')
            ->whereBetween('time', [
                date('Y-m-d', strtotime('last monday', strtotime('now'))), 
                date('Y-m-d', strtotime('next sunday', strtotime('now')))
                ]);
        }])
        ->get();
    }

    public function monthCostByTag()
    {
        return Tag::select('id', 'name')->with(['bill' => function ($query) {
            $query->select('tag_id', 'cost', 'time')
            ->whereMonth('time', date('m'));
        }])
        ->get();
    }

    public function yearCostByTag()
    {
        return Tag::select('id', 'name')->with(['bill' => function ($query) {
            $query->select('tag_id', 'cost', 'time')
            ->whereYear('time', date('Y'));
        }])
        ->get();
    }

    public function todayCostByRole(string $role)
    {
        return Bill::select('id', 'role', 'time', 'cost')
            ->where('role', $role)
            ->whereDate('time', '=', date('Y-m-d'))
            ->get();
    }

    public function weekCostByRole(string $role)
    {
        return Bill::select('id', 'role', 'time', 'cost')
            ->where('role', $role)
            ->whereMonth('time', date('m'))
            ->get();
    }

    public function monthCostByRole(string $role)
    {
        return Bill::select('id', 'role', 'time', 'cost')
            ->where('role', $role)
            ->whereBetween('time', [
                date('Y-m-d', strtotime('last monday', strtotime('now'))), 
                date('Y-m-d', strtotime('next sunday', strtotime('now')))
                ])
            ->get();
    }

    public function yearCostByRole(string $role)
    {
        return Bill::select('id', 'role', 'time', 'cost')
            ->where('role', $role)
            ->whereYear('time', date('Y'))
            ->get();
    }
}