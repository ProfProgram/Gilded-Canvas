@extends('layouts.master')

@section('content')
<div class="container">
    <h2 class="page-title">Customer Management</h2>

    <!-- Success Message -->
    @if(session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <!-- Add Customer Button -->
    <button class="add-button" onclick="showAddCustomerModal()">+ Add Customer</button>

    <!-- Customer Table -->
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone Number</th>
                <th>Registered Date</th>
            </tr>
        </thead>
        <tbody>
            @if($customers->isEmpty())
                <tr>
                    <td colspan="5" class="no-results">No customers found.</td>
                </tr>
            @else
                @foreach($customers as $customer)
                    <tr>
                        <td>{{ $customer->user_id }}</td>
                        <td>{{ $customer->name }}</td>
                        <td>{{ $customer->email }}</td>
                        <td>{{ $customer->phone_number ?? 'N/A' }}</td>
                        <td>{{ \Carbon\Carbon::parse($customer->created_at)->format('d M Y') }}</td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>

<!-- Add Customer Modal -->
<div id="addCustomerModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeAddCustomerModal()">&times;</span>
        <h3>Add New Customer</h3>
        <form method="POST" action="{{ route('admin.customers.store') }}">
            @csrf
            <input type="text" name="name" placeholder="Customer Name" required>
            <input type="email" name="email" placeholder="Customer Email" required>
            <input type="text" name="phone_number" placeholder="Phone Number">
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Add Customer</button>
        </form>
    </div>
</div>

<!-- JavaScript to Handle Modal -->
<script>
function showAddCustomerModal() {
    document.getElementById("addCustomerModal").style.display = "block";
}

function closeAddCustomerModal() {
    document.getElementById("addCustomerModal").style.display = "none";
}
</script>

<!-- Modal CSS -->
<style>
.modal {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0,0,0,0.5);
}

.modal-content {
    background-color: white;
    margin: 10% auto;
    padding: 20px;
    width: 40%;
    border-radius: 10px;
    text-align: center;
}

.close {
    float: right;
    font-size: 24px;
    cursor: pointer;
}

.add-button {
    background-color: gold;
    border: none;
    padding: 10px 15px;
    margin-bottom: 15px;
    cursor: pointer;
    font-weight: bold;
}
</style>

@endsection
