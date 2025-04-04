@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="row">
    <div class="col-md-3">
        <div class="card">
            <div class="card-header bg-primary text-white">
                Admin Menu
            </div>
            <div class="list-group list-group-flush">
                <a href="{{ route('admin.dashboard') }}"
                    class="list-group-item list-group-item-action {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                </a>

                <a href="{{ route('admin.products.index') }}"
                    class="list-group-item list-group-item-action {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                    <i class="fas fa-boxes me-2"></i>Products
                </a>

                <a href="{{ route('admin.users.index') }}"
                    class="list-group-item list-group-item-action {{ request()->routeIs('admin.users.index') ? 'active' : '' }}">
                    <i class="fas fa-users me-2"></i>Users
                </a>

                <a href="{{ route('admin.users.with-products') }}"
                    class="list-group-item list-group-item-action {{ request()->routeIs('admin.users.with-products') ? 'active' : '' }}">
                    <i class="fas fa-users me-2"></i>Users With Products
                </a>
            </div>

        </div>
    </div>
    <div class="col-md-9">
        @yield('admin-content')
    </div>
</div>

@endsection