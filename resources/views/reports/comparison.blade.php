@extends('layouts.app')

@section('title', 'Comparison Report')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3>Unit Type Comparison Report - {{ $year }}</h3>
                    <form method="GET" class="d-flex">
                        <select name="year" class="form-select me-2" onchange="this.form.submit()">
                            @for($y = date('Y'); $y >= 2020; $y--)
                                <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                            @endfor
                        </select>
                    </form>
                </div>
                <div class="card-body">
                    <div id="chartContainer" style="height: 400px; position: relative;">
                        <canvas id="comparisonChart"></canvas>
                    </div>
                    
                    <div class="row mt-4">
                        <div class="col-12">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Unit Type</th>
                                        <th>Total Collection (KWD)</th>
                                        <th>Number of Units</th>
                                        <th>Average per Unit (KWD)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data as $item)
                                    <tr>
                                        <td><span class="badge bg-info">{{ $item['type'] }}</span></td>
                                        <td>KWD {{ number_format($item['total'], 3) }}</td>
                                        <td>{{ $item['count'] }}</td>
                                        <td>KWD {{ $item['count'] > 0 ? number_format($item['total'] / $item['count'], 3) : '0.000' }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('comparisonChart').getContext('2d');
    const data = {!! json_encode($data) !!};
    
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: data.map(item => item.type),
            datasets: [{
                label: 'Collection Amount (KWD)',
                data: data.map(item => item.total),
                backgroundColor: ['rgba(54, 162, 235, 0.6)', 'rgba(255, 99, 132, 0.6)', 'rgba(75, 192, 192, 0.6)'],
                borderColor: ['rgba(54, 162, 235, 1)', 'rgba(255, 99, 132, 1)', 'rgba(75, 192, 192, 1)'],
                borderWidth: 1
            }]
        },
        plugins: [{
            id: 'datalabels',
            afterDraw: function(chart) {
                const ctx = chart.ctx;
                ctx.save();
                ctx.font = 'bold 12px Arial';
                ctx.fillStyle = '#000';
                ctx.textAlign = 'center';
                ctx.textBaseline = 'bottom';
                
                chart.data.datasets.forEach((dataset, datasetIndex) => {
                    const meta = chart.getDatasetMeta(datasetIndex);
                    if (!meta.hidden) {
                        meta.data.forEach((element, index) => {
                            const dataValue = dataset.data[index];
                            if (dataValue && dataValue > 0) {
                                const position = element.tooltipPosition();
                                ctx.fillText('KWD ' + dataValue.toFixed(3), position.x, position.y - 5);
                            }
                        });
                    }
                });
                ctx.restore();
            }
        }],
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                title: {
                    display: true,
                    text: 'Collections by Unit Type - {{ $year }}'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'KWD ' + value.toFixed(3);
                        }
                    }
                }
            }
        }
    });
});
</script>
@endsection