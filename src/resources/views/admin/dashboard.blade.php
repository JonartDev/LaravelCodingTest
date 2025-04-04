@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('admin-content')
    <div class="card">
        <div class="card-header">
            <h3>Admin Dashboard</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="card text-white bg-primary mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Total Products</h5>
                            <p class="card-text display-4">{{ App\Models\Product::count() }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-white bg-success mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Total Users</h5>
                            <p class="card-text display-4">{{ App\Models\User::count() }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-white bg-info mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Your Products</h5>
                            <p class="card-text display-4">{{ auth()->user()->products()->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection