<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Unit;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product = Product::find($request->product_id);
        $unit = Unit::find($request->unit_id);
        $productUnit = Inventory::create($request->all());

        //get old product unit if exists
        $productUnit = DB::table('product_unit')
            ->select('amount')
            ->where('product_id', '=', $request->product_id)
            ->where('unit_id', '=', $request->unit_id)
            ->first();

        //change product unit
        if ($productUnit) {
            $newAmount = $productUnit->amount + (float)$request->amount;
            $product->units()->detach($request->unit_id);
            $product->units()->attach($request->unit_id, ['amount' => $newAmount]);

        } else {
            $product->units()->attach($request->unit_id, ['amount' => $request->amount]);
        }

        // insert data to inventories table
       /* DB::table('inventories')->insert([
            'product_id' => $request->product_id, 
            'unit_id' => $request->unit_id,
            'amount' => $request->amount

    ]);*/

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
