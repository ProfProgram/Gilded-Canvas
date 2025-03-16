@extends('layouts.master')

@section('content')
<div class="container">
    <h2 class="page-title">Customer Management</h2>

    <!-- Success Message -->
    @if(session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <!-- Add Customer Button -->
    <button class="update-button" onclick="showAddCustomerModal()">+ Add Customer</button>
<!-- Search Form -->
<form method="GET" action="{{ route('admin.customers') }}" class="filter-form">
    <input type="text" name="search" placeholder="Search by ID or Name" value="{{ request()->search }}" class="filter-input" />
    <button type="submit" class="filter-button">Search</button>
</form>

    <!-- Customer Table -->
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone Number</th>
                <th>Registered Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @if($customers->isEmpty())
                <tr>
                    <td colspan="6" class="no-results">No customers found.</td>
                </tr>
            @else
                @foreach($customers as $customer)
                    <tr>
                        <td>{{ $customer->user_id }}</td>
                        <td>{{ $customer->name }}</td>
                        <td>{{ $customer->email }}</td>
                        <td>{{ $customer->phone_number ?? 'N/A' }}</td>
                        <td>{{ \Carbon\Carbon::parse($customer->created_at)->format('d M Y') }}</td>
                        <td>
                            <!-- Edit Button -->
                            <button class="update-button" onclick="showEditCustomerModal({{ json_encode($customer) }})">Edit</button>
                            
                            <!-- Delete Button -->
                            <button class="delete-button" onclick="showDeleteCustomerModal({{ $customer->user_id }})">Delete</button>
                        </td>
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
        <form id="addCustomerForm" method="POST" action="{{ route('admin.customers.store') }}">
            @csrf
            <input type="text" name="name" placeholder="Customer Name" required>
            <input type="email" name="email" placeholder="Customer Email" required>
            <input type="text" name="phone_number" placeholder="Phone Number">
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" class="update-button">Add Customer</button>
        </form>
    </div>
</div>

<!-- Edit Customer Modal -->
<div id="editCustomerModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeEditCustomerModal()">&times;</span>
        <h3>Edit Customer Details</h3>
        <form id="editCustomerForm" method="POST" action="">
            @csrf
            @method('PUT')
            <input type="hidden" id="edit_user_id" name="user_id">
            <input type="text" id="edit_name" name="name" placeholder="Customer Name" required>
            <input type="email" id="edit_email" name="email" placeholder="Customer Email" required>
            <input type="text" id="edit_phone_number" name="phone_number" placeholder="Phone Number">
            <button type="submit" class="update-button">Update Customer</button>
        </form>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteCustomerModal" class="modal">
    <div class="modal-content">
        <h3>Are you sure?</h3>
        <p>Do you really want to delete this customer? This action cannot be undone.</p>
        <form id="deleteCustomerForm" method="POST" action="">
            @csrf
            @method('DELETE')
            <button type="submit" class="update-button">Yes, Delete</button>
            <button type="button" class="update-button cancel-button" onclick="closeDeleteCustomerModal()">Cancel</button>
        </form>
    </div>
</div>

<!-- JavaScript for Modal Handling -->
<script>
function showAddCustomerModal() {
    document.getElementById("addCustomerModal").style.display = "block";
}

function closeAddCustomerModal() {
    document.getElementById("addCustomerModal").style.display = "none";
}

function showEditCustomerModal(customer) {
    document.getElementById("edit_user_id").value = customer.user_id;
    document.getElementById("edit_name").value = customer.name;
    document.getElementById("edit_email").value = customer.email;
    document.getElementById("edit_phone_number").value = customer.phone_number || '';
    document.getElementById("editCustomerForm").action = "/admin/customers/" + customer.user_id + "/update";
    document.getElementById("editCustomerModal").style.display = "block";
}

function closeEditCustomerModal() {
    document.getElementById("editCustomerModal").style.display = "none";
}

function showDeleteCustomerModal(user_id) {
    document.getElementById("deleteCustomerForm").action = "/admin/customers/" + user_id + "/delete";
    document.getElementById("deleteCustomerModal").style.display = "block";
}

function closeDeleteCustomerModal() {
    document.getElementById("deleteCustomerModal").style.display = "none";
}
</script>

<!-- Modal CSS -->
<style>
.modal {
    display: none;
    position: fixed;
    z-index: 10;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0,0,0,0.5);
}

.modal-content {
    background-color: #EED9A4;
    margin: 15% auto;
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

.update-button {
    background-color: #b08a2e;
    border: none;
    padding: 10px 15px;
    margin: 5px;
    cursor: pointer;
    font-weight: bold;
    color: white;
    border-radius: 5px;
}

.update-button:hover {
    background-color: #8d6b23;
}

.delete-button {
    background-color: #b08a2e;
    border: none;
    padding: 10px 15px;
    margin: 5px;
    cursor: pointer;
    font-weight: bold;
    color: white;
    border-radius: 5px;
}

.delete-button:hover {
    background-color: #8d6b23;
}

.cancel-button {
    background-color: white;
    color: black;
    border: 1px solid #b08a2e;
}
</style>

@endsection
