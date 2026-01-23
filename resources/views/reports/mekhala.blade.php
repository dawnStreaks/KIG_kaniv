@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3>Mekhala Report - {{ $year }}/{{ $month ?? date('m') }}</h3>
                    <form method="GET" class="d-flex gap-2">
                        <select name="year" class="form-select" onchange="this.form.submit()">
                            @for($y = date('Y'); $y >= 2020; $y--)
                                <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                            @endfor
                        </select>
                        <select name="month" class="form-select" onchange="this.form.submit()">
                            @for($i = 1; $i <= 12; $i++)
                                <option value="{{ sprintf('%02d', $i) }}" {{ ($month ?? date('m')) == sprintf('%02d', $i) ? 'selected' : '' }}>{{ date('M', mktime(0, 0, 0, $i, 1)) }}</option>
                            @endfor
                        </select>
                    </form>
                </div>
                <div class="card-body">
                    <div id="chartContainer" style="height: 500px; position: relative;">
                        <canvas id="mekhalaChart"></canvas>
                    </div>
                    
                    <div id="drillDownContainer" style="display: none; margin-top: 30px; position: relative;">
                        <h4 id="drillDownTitle"></h4>
                        <div style="height: 350px; position: relative;">
                            <canvas id="drillDownChart"></canvas>
                        </div>
                        <button class="btn btn-secondary mt-2" onclick="backToMain()">Back to Mekhalas</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
<script>
const chartData = @json($data);
const year = {{ $year }};

let mainChart, drillDownChart;

function initMainChart() {
    const ctx = document.getElementById('mekhalaChart').getContext('2d');
    
    const labels = chartData.map(item => item.name);
    
    mainChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Collections (KWD)',
                data: chartData.map(item => parseFloat(item.collections)),
                backgroundColor: 'rgba(54, 162, 235, 0.8)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }, {
                label: 'Applications (KWD)',
                data: chartData.map(item => parseFloat(item.applications)),
                backgroundColor: 'rgba(255, 99, 132, 0.8)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }, {
                label: 'Expenses (KWD)',
                data: chartData.map(item => parseFloat(item.expenses)),
                backgroundColor: 'rgba(255, 206, 86, 0.8)',
                borderColor: 'rgba(255, 206, 86, 1)',
                borderWidth: 1
            }, {
                label: 'Balance (KWD)',
                data: chartData.map(item => parseFloat(item.balance)),
                backgroundColor: 'rgba(75, 192, 192, 0.8)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        plugins: [{
            id: 'datalabels',
            afterDraw: function(chart) {
                const ctx = chart.ctx;
                ctx.save();
                ctx.font = 'bold 10px Arial';
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
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'KWD ' + value.toFixed(3);
                        }
                    }
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.dataset.label + ': KWD ' + context.parsed.y.toFixed(3);
                        }
                    }
                },
                datalabels: {
                    anchor: 'end',
                    align: 'top',
                    formatter: function(value) {
                        return value.toFixed(3);
                    },
                    font: {
                        size: 10
                    }
                }
            },
            onClick: function(event, elements) {
                if (elements.length > 0) {
                    const datasetIndex = elements[0].datasetIndex;
                    const index = elements[0].index;
                    const mekhalaId = chartData[index].mekhala_id;
                    const mekhalaName = chartData[index].name;
                    
                    let type = '';
                    if (datasetIndex === 0) type = 'collections';
                    else if (datasetIndex === 1) type = 'applications';
                    
                    if (type) {
                        drillDown(mekhalaId, mekhalaName, type);
                    }
                }
            }
        }
    });
}

function drillDown(mekhalaId, mekhalaName, type) {
    fetch(`{{ url('/reports/mekhala/drill-down') }}?mekhala_id=${mekhalaId}&year=${year}&type=${type}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('drillDownTitle').textContent = `${mekhalaName} - ${type.charAt(0).toUpperCase() + type.slice(1)} by Area - ${year}`;
            document.getElementById('drillDownContainer').style.display = 'block';
            
            const ctx = document.getElementById('drillDownChart').getContext('2d');
            
            if (drillDownChart) {
                drillDownChart.destroy();
            }
            
            drillDownChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: data.map(item => item.name),
                    datasets: [{
                        label: `${type.charAt(0).toUpperCase() + type.slice(1)} Amount (KWD)`,
                        data: data.map(item => parseFloat(item.amount)),
                        backgroundColor: type === 'collections' ? 'rgba(54, 162, 235, 0.8)' : 'rgba(255, 99, 132, 0.8)',
                        borderColor: type === 'collections' ? 'rgba(54, 162, 235, 1)' : 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    }]
                },
                plugins: [{
                    id: 'datalabels',
                    afterDraw: function(chart) {
                        const ctx = chart.ctx;
                        ctx.save();
                        ctx.font = 'bold 10px Arial';
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
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return 'KWD ' + value.toFixed(3);
                                }
                            }
                        }
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return 'Amount: KWD ' + context.parsed.y.toFixed(3);
                                }
                            }
                        },
                        datalabels: {
                            anchor: 'end',
                            align: 'top',
                            formatter: function(value) {
                                return value.toFixed(3);
                            },
                            font: {
                                size: 10
                            }
                        }
                    }
                }
            });
            

        });
}

function backToMain() {
    document.getElementById('drillDownContainer').style.display = 'none';
}

document.addEventListener('DOMContentLoaded', function() {
    initMainChart();
});
</script>
@endsection