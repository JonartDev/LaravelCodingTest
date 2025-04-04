@extends('layouts.admin')

@section('title', 'User Details')

@section('admin-content')
<div class="card">
    <div class="card-header">
        <h3>User: {{ $user->name }}</h3>
    </div>
    <div class="card-body">
        <div class="row mb-4">
            <div class="col-md-6">
                <h5>User Information</h5>
                <p><strong>Name:</strong> {{ $user->name }}</p>
                <p><strong>Email:</strong> {{ $user->email }}</p>
                <p><strong>Registered:</strong> {{ $user->created_at->format('M d, Y') }}</p>
            </div>
        </div>

        <h5 class="mb-3">Products</h5>
        @if($user->products->isEmpty())
        <div class="alert alert-info">This user has no products.</div>
        @else
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Body</th>
                        <th>Stock</th>
                        <th>Created</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($user->products as $product)
                    <tr>
                        <td>{{ $product->title }}</td>
                        <td>{{ $product->body }}</td>
                        <td>{{ $product->quantity }}</td>
                        <td>{{ $product->created_at->format('M d, Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
</div>
@endsection