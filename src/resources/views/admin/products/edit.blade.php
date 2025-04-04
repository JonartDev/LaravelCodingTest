@extends('layouts.admin')

@section('title', 'Edit Product')

@section('admin-content')
<div class="card">
    <div class="card-header">
        <h3>Edit Product</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            @include('admin.products._form')
            
            <button type="submit" class="btn btn-primary">Update Product</button>
            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection