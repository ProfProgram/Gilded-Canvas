@extends('layouts.master')

@section('content')
<main class="dashboard">
    @if (session('status'))
        <div class="alert">
            <p class="message">{{ session('status') }}</p>
            <form method="POST" action="{{ url('/close-alert') }}" style="display: inline;">
                @csrf
                <button type="submit" class="close-btn">✖</button>
            </form>
        </div>
    @endif

    <h1>Dashboard</h1>

    <!-- Top Tracking Tabs Section -->
    <section class="tracking-section">
    <!-- Total Orders Tab -->
    <div class="placeholder-tab">
        <h4>Total Orders</h4>
        <div class="placeholder-box">{{ $totalOrders }}</div>
    </div>

        
       <!-- Active Customers Tab -->

<div class="placeholder-tab">
    <h4>Active Customers</h4>
    <div class="placeholder-box">{{ $activeCustomers }}</div>
</div>

            <!-- Total Revenue Tab -->
<div class="placeholder-tab">
    <h4>Total Revenue</h4>
    <div class="placeholder-box">£{{ number_format($totalRevenue, 2) }}</div>
</div>

    <!-- Stock Tracking Chart Card -->
    <section class="chart-card">
        <h3>Stock Tracking</h3>
        <div id="curve_chart" style="width: 900px; height: 500px;"></div>
    </section>

    <!-- Orders by Status Pie Chart Card -->
    <section class="chart-card">
        <h3>Orders by Status</h3>
        <div id="piechart" style="width: 900px; height: 500px;"></div>
    </section>
</main>

<!-- Load Google Charts -->
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawLineChart);

    function drawLineChart() {
        var data = google.visualization.arrayToDataTable([
            ['Product', 'Stock Incoming', 'Stock Outgoing'],
            <?php echo $stockChartData; ?>
        ]);

        var options = {
            
            curveType: 'function',
            legend: { position: 'bottom' },
            colors: ['#d4af37', '#000000']
        };

        var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));
        chart.draw(data, options);
    }

    // Pie chart for status of all orders
    google.charts.setOnLoadCallback(drawPieChart);

    function drawPieChart() {
        var data = google.visualization.arrayToDataTable([
            <?php echo $pieChartData ?>
        ]);

        var options = {
    
    colors: ['#d4af37', '#000000', '#cccccc', '#808080'],
    backgroundColor: 'transparent',
    pieSliceTextStyle: {
        fontSize: 19,
        bold: true
    },
    pieSliceBorderColor: '#000000',
    chartArea: { width: '80%', height: '80%' },
    legend: {
        position: 'right',
        alignment: 'center',
        textStyle: {
            fontSize: 20,
            color: '#333',
        }
    }
};

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));
        chart.draw(data, options);
    }
</script>
@endsection
