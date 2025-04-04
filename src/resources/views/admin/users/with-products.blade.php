@extends('layouts.admin')

@section('title', 'Users with Products')

@section('admin-content')
<div class="card">
    <div class="card-header">
        <h3>Users with Products</h3>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Email</th>
                        <th>Products Count</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->products->count() }}</td>
                        <td>
                            <a href="{{ route('admin.users.show', $user->id) }}"
                                class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i> View Products
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{ $users->links() }}
    </div>
</div>
@endsection