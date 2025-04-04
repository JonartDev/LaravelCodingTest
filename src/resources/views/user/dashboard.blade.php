@extends('layouts.app')

@section('title', 'My Dashboard')

@section('content')
<div class="card">
    <div class="card-header">
        <h3>My Products</h3>
    </div>
    <div class="card-body">
        @if($products->isEmpty())
        <div class="alert alert-info">You haven't added any products yet.</div>
        @else
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Body</th>
                        <th>Price</th>
                        <th>Stock</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                    <tr>
                        <td>
                            <img src="{{ $product->image_url }}"
                                alt="{{ $product->title }}"
                                width="50" class="img-thumbnail">
                        </td>
                        <td>{{ $product->title }}</td>
                        <td>{{ Str::limit($product->body, 50) }}</td>
                        <td>${{ number_format($product->price, 2) }}</td>
                        <td>
                            <span class="badge bg-{{ $product->quantity > 0 ? 'success' : 'danger' }}">
                                {{ $product->quantity }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $products->links() }}
        @endif
    </div>
</div>
@endsection