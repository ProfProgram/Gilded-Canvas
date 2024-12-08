<!-- email_form.blade.php -->
<form method="POST" action="{{ route("password.email") }}"> <!-- Assume this route exists -->
    <input type="email" name="email" required placeholder="Email" value="{{ old('email') }}">
    <button type="submit">Submit</button>
</form>
