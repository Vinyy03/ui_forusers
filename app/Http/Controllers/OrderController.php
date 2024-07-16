<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $items = Item::all();
        return view('orders.index', compact('items'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*' => 'exists:items,id',
        ]);

        // Here you can process the order, e.g., save it to the database

        return redirect()->route('Order.index')->with('success', 'Order Added.');
    }
}

