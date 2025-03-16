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
                           <button class="update-button" onclick="showEditCustomerModal({{ json_encode($customer) }})">
    Edit
</button>


                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
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
            <button type="submit">Update Customer</button>
        </form>
    </div>
</div>

<!-- JavaScript for Modal Handling -->
<script>
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

.edit-button {
    background-color: darkorange;
    border: none;
    padding: 5px 10px;
    cursor: pointer;
    font-weight: bold;
}
</style>

@endsection
