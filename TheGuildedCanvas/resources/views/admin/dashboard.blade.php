@extends('layouts.master')




    <!-- Your basket page content -->
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
    <section class="charts">
        <div id="curve_chart" style="width: 900px; height: 500px"></div>
        <hr class="divider">
        <div id="piechart" style="width: 900px; height: 500px;"></div>
    </section>
</main>
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
            title: 'Stock Tracking',
            curveType: 'function',
            legend: { position: 'bottom',},
            colors: ['#d4af37', '#000000']
        };

        var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

        chart.draw(data, options);
    }

    // Pie chart for status of all orders
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawPieChart);

    function drawPieChart() {

        var data = google.visualization.arrayToDataTable([
            <?php echo $pieChartData ?>
        ]);

        var options = {
            title: 'Orders by Status',
            colors: ['#d4af37', '#000000', '#cccccc', '#808080'],
            backgroundColor: 'transparent',
            pieSliceTextStyle: {
                fontSize: 16,
                bold: true
            },
            pieSliceBorderColor: '#000000',
            chartArea: { width: '90%', height: '80%' } // Size of chart 
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
    }
    </script>


@endsection