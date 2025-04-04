@extends('layouts.admin')

@section('title', 'Product Management')

@section('admin-content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="mb-0">Products</h3>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add Product
        </a>
    </div>
    <div class="card-body">
        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Stock</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                    <tr>
                        <td>
                            <img src="{{ asset('storage/' . $product->image_path) }}"
                                alt="{{ $product->title }}"
                                width="50" class="img-thumbnail">
                        </td>
                        <td>{{ $product->title }}</td>
                        <td>
                            <span class="badge bg-{{ $product->isInStock() ? 'success' : 'danger' }}">
                                {{ $product->quantity }} in stock
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('admin.products.edit', $product->id) }}"
                                class="btn btn-sm btn-primary">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.products.destroy', $product->id) }}"
                                method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"
                                    onclick="return confirm('Are you sure?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{ $products->links() }}
    </div>
</div>
@endsection