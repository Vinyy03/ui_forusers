@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Item</h1>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('items.update', $item->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group mb-3">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $item->name }}" required>
        </div>
        <div class="form-group mb-3">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="description">{{ $item->description }}</textarea>
        </div>
        <div class="form-group mb-3">
            <label for="price">Price</label>
            <input type="number" class="form-control" id="price" name="price" value="{{ $item->price }}" required>
        </div>
        <div class="form-group mb-3">
            <label for="stock">Stock</label>
            <input type="number" class="form-control" id="stock" name="stock" value="{{ $item->stock }}" required>
        </div>
        <div class="form-group mb-3">
            <label for="image">Image</label>
            <input type="file" class="form-control" id="image" name="image">
            <img src="{{ asset($item->image) }}" alt="{{ $item->name }}" width="100" class="mt-2">
        </div>

        <button type="submit" class="btn btn-primary">Update Item</button>
    </form>
</div>
@endsection
