@extends('layouts.admin')

@section('title', 'Create Product')

@section('admin-content')
<div class="card">
    <div class="card-header">
        <h3>Add New Product</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            @include('admin.products._form')

            <button type="submit" class="btn btn-primary">Create Product</button>
            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection