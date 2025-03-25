@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Customer Orders</h2>

    <div class="row mb-4" id="customerSearchContainer">
        <div class="col-md-6">
            <div id="customerSearchSection">
                <form id="customer-search-form" class="d-flex gap-2">
                    <div class="form-group flex-grow-1">
                        <label for="customer-search">Search Customer:</label>
                        <input type="text" id="customer-search" class="form-control"
                            placeholder="Type customer's last name..." required>
                    </div>
                    <div class="align-self-end">
                        <button type="submit" id="searchCustomers" class="btn btn-primary">Search</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-6" id="lstCustomers">
            <!-- Customer list will be loaded here -->
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-6" id="lstOrders">
            <!-- Orders will be loaded here -->
        </div>
        <div class="col-md-6" id="orderDetails">
            <!-- Order details will be loaded here -->
        </div>
    </div>
</div>

@push('scripts')
<script>
    function loadOrderDetails(orderId) {
        $.get(`/api/orders/${orderId}/details`, function(response) {
            $('#orderDetails').html(response);
        });
    }

    function loadCustomerOrders(customerId) {
        // Clear previous order details
        $('#orderDetails').empty();

        $.get(`/api/customers/${customerId}/orders`, function(orders) {
            let html = '<div class="d-flex justify-content-between align-items-center mb-3">';
            html += '<h3>Customer Orders</h3>';
            html += '<button class="btn btn-secondary btn-sm" onclick="toggleCustomerSearch()">Show Customer Search</button>';
            html += '</div><div class="list-group">';
            orders.forEach(order => {
                html += `
                    <a href="#" class="list-group-item list-group-item-action" onclick="loadOrderDetails(${order.id})">
                        Order #${order.id} - ${order.created_at}
                    </a>
                `;
            });
            html += '</div>';
            $('#lstOrders').html(html);

            // Hide customer search section after selecting a customer
            $('#customerSearchContainer').hide();
        });
    }

    function displayCustomers(customers) {
        let html = '<h3>Customers Found</h3><div class="list-group">';
        customers.forEach(customer => {
            html += `
                <a href="#" class="list-group-item list-group-item-action" onclick="loadCustomerOrders(${customer.id})">
                    ${customer.first_name} ${customer.last_name}
                </a>
            `;
        });
        html += '</div>';
        $('#lstCustomers').html(html);
    }

    function toggleCustomerSearch() {
        $('#customerSearchContainer').toggle();
        $('#customer-search').val('');
        $('#lstCustomers').empty();
    }

    $(document).ready(function() {
        $('#customer-search-form').on('submit', function(e) {
            e.preventDefault();
            const searchTerm = $('#customer-search').val();

            $.get(`/api/customers/search/${searchTerm}`, function(customers) {
                displayCustomers(customers);
            });
        });
    });
</script>
@endpush

@endsection