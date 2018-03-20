<?php

namespace App\Http\Controllers;

use App\Bill;
use App\Repositories\BillRepository;
use Illuminate\Http\Request;

class BillController extends Controller
{
    protected $repository;

    public function __construct(BillREpository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->repository->create($request->all());
        return response()->json(['msg' => 'add bill successfully'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @return \App\Bill
     */
    public function showAllCost()
    {
        $bills = $this->repository->allCost();
        return $bills;
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \App\Bill
     */
    public function showTagCost(int $id)
    {
        $bills = $this->repository->tagCost($id);
        return $bills;
    }

    /**
     * Display the specified resource.
     *
     * @return \App\Bill
     */
    public function showTodayCost()
    {
        $bills = $this->repository->todayCost();
        return $bills;
    }

    /**
     * Display the specified resource.
     *
     * @return \App\Bill
     */
    public function showTodayTagCost()
    {
        $bills = $this->repository->todayCostByTag();
        return $bills;
    }

    /**
     * Display the specified resource.
     * 
     * @param  string $role
     * @return \App\Bill
     */
    public function showTodayRoleCost(string $role)
    {
        $bills = $this->repository->todayCostByRole($role);
        return $bills;
    }

    /**
     * Display the specified resource.
     *
     * @return \App\Bill
     */
    public function showWeekCost()
    {
        $bills = $this->repository->weekCost();
        return $bills;
    }

    /**
     * Display the specified resource.
     *
     * @return \App\Bill
     */
    public function showWeekTagCost()
    {
        $bills = $this->repository->weekCostByTag();
        return $bills;
    }

    /**
     * Display the specified resource.
     * 
     * @param  string $role
     * @return \App\Bill
     */
    public function showWeekRoleCost(string $role)
    {
        $bills = $this->repository->weekCostByRole($role);
        return $bills;
    }

    /**
     * Display the specified resource.
     *
     * @return \App\Bill
     */
    public function showMonthCost()
    {
        $bills = $this->repository->monthCost();
        return $bills;
    }

    /**
     * Display the specified resource.
     *
     * @return \App\Bill
     */
    public function showMonthTagCost()
    {
        $bills = $this->repository->monthCostByTag();
        return $bills;
    }

    /**
     * Display the specified resource.
     *
     * @param  string $role
     * @return \App\Bill
     */
    public function showMonthRoleCost(string $role)
    {
        $bills = $this->repository->monthCostByRole($role);
        return $bills;
    }

    /**
     * Display the specified resource.
     *
     * @return \App\Bill
     */
    public function showYearCost()
    {
        $bills = $this->repository->yearCost();
        return $bills;
    }

    /**
     * Display the specified resource.
     *
     * @return \App\Bill
     */
    public function showYearTagCost()
    {
        $bills = $this->repository->yearCostByTag();
        return $bills;
    }

    /**
     * Display the specified resource.
     *
     * @param  string $role
     * @return \App\Bill
     */
    public function showYearRoleCost(string $role)
    {
        $bills = $this->repository->yearCostByRole($role);
        return $bills;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        $this->repository->update($id, $request->all());
        return response()->json(['msg' => 'update bill successfully'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $this->repository->delete($id);
        return response()->json(['msg' => 'delete bill successfully'], 200);
    }
}
