@extends('layouts.master')

@section('content')
    <div class="container user-management">
        <h1>User Management</h1>
        <table class="table">
            <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Actions</th>
                <th class="remove-column">Remove Option</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role }}</td>
                    <td>
                        <form action="{{ route('manager.users.update', $user) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <select name="role" class="form-select" required>
                                <option value="admin" {{ $user->role->value === 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="manager" {{ $user->role->value === 'manager' ? 'selected' : '' }}>Manager</option>
                                <option value="user" {{ $user->role->value === 'user' ? 'selected' : '' }}>User</option>
                            </select>
                            <button type="submit" class="update-button">Update</button>
                        </form>
                    </td>
                    <td>
                        <form action="{{ route('manager.users.destroy', $user) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="delete-button">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
