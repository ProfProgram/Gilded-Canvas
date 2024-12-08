<form action="{{ route('password.update') }}" method="POST">
    @csrf
    @method('PUT')
    <input type="password" name="current_password" placeholder="Current Password">
    <input type="password" name="new_password" placeholder="New Password">
    <button type="submit">Update Password</button>
</form>
