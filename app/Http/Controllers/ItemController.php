<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index()
{
    $items = Item::all();
    return view('item.index', compact('items'));
}

    public function create()
    {
        return view('item.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'price' => 'required|numeric',
        'stock' => 'required|integer',
        'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Save the image to public/image_folder
    $imagePath = $request->file('image')->move(public_path('image_folder'), $request->file('image')->getClientOriginalName());

    // Get the relative path to store in the database
    $relativeImagePath = 'image_folder/' . $request->file('image')->getClientOriginalName();

    $item = Item::create([
        'name' => $request->name,
        'description' => $request->description,
        'price' => $request->price,
        'stock' => $request->stock,
        'image' => $relativeImagePath,
    ]);

    return redirect()->route('items.index')->with('success', 'Item created successfully.');
}

public function edit($id)
{
    $item = Item::findOrFail($id);
    return view('item.edit', compact('item'));
}


    public function show($id)
    {
        return Item::find($id);
    }

    public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'price' => 'required|numeric',
        'stock' => 'required|integer',
        'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $item = Item::findOrFail($id);

    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $imageName = time() . '_' . $image->getClientOriginalName();
        $image->move(public_path('image_folder'), $imageName);
        $item->image = 'image_folder/' . $imageName;
    }

    $item->update([
        'name' => $request->name,
        'description' => $request->description,
        'price' => $request->price,
        'stock' => $request->stock,
        'image' => $item->image,
    ]);

    return redirect()->route('items.index')->with('success', 'Item updated successfully.');
}

    public function destroy($id)
    {
        Item::destroy($id);

        return redirect()->route('items.index')->with('success', 'Item deleted successfully.');
    }
}
