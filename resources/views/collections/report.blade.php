@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h3>Collection Report</h3>
                    </div>
                    <form method="GET" class="row g-2">
                        <div class="col-md-2">
                            <select name="year" class="form-select" onchange="this.form.submit()">
                                @for($y = date('Y'); $y >= 2020; $y--)
                                    <option value="{{ $y }}" {{ request('year', date('Y')) == $y ? 'selected' : '' }}>{{ $y }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-2">
                            <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}" placeholder="From Date">
                        </div>
                        <div class="col-md-2">
                            <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}" placeholder="To Date">
                        </div>
                        <div class="col-md-2">
                            <select name="term" class="form-select">
                                <option value="">All Terms</option>
                                @foreach($terms as $term)
                                    <option value="{{ $term }}" {{ request('term') == $term ? 'selected' : '' }}>{{ ucfirst($term) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select name="type" class="form-select">
                                <option value="">All Types</option>
                                @foreach($types as $type)
                                    <option value="{{ $type }}" {{ request('type') == $type ? 'selected' : '' }}>{{ ucfirst($type) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary">Filter</button>
                            <button type="button" class="btn btn-secondary" onclick="clearFilters()">Clear</button>
                        </div>
                    </form>
                </div>
                <div class="card-body">
                    <div id="chartContainer" style="height: 400px;">
                        <canvas id="collectionChart"></canvas>
                    </div>
                    

                    
                    @if($user->isMekhalaUser() || $user->isAdmin())
                    <div id="drillDownContainer" style="display: none; margin-top: 30px;">
                        <h4 id="drillDownTitle"></h4>
                        <div style="height: 400px; max-height: 400px; overflow: hidden;">
                            <canvas id="drillDownChart"></canvas>
                        </div>
                        <button class="btn btn-secondary mt-2" onclick="backToMain()">Back to Areas</button>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
<script>
Chart.register(ChartDataLabels);
const chartData = @json($data);
const userType = '{{ $user->user_type }}';
const year = {{ $year }};

let mainChart, drillDownChart;

// Initialize main chart
function initMainChart() {
    const ctx = document.getElementById('collectionChart').getContext('2d');
    
    const labels = chartData.map(item => 
        userType === 'area' ? item.unit_name : item.area_name
    );
    const amounts = chartData.map(item => parseFloat(item.total_amount));
    
    mainChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Collection Amount (KWD)',
                data: amounts,
                backgroundColor: 'rgba(54, 162, 235, 0.8)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        plugins: [ChartDataLabels],
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'KWD ' + value.toLocaleString('en-US', {minimumFractionDigits: 3, maximumFractionDigits: 3});
                        }
                    }
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return 'Amount: KWD ' + context.parsed.y.toLocaleString('en-US', {minimumFractionDigits: 3, maximumFractionDigits: 3});
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
                if (elements.length > 0 && (userType === 'mekhala' || userType === 'admin' || userType === 'center')) {
                    const index = elements[0].index;
                    const areaId = chartData[index].area_id;
                    const areaName = chartData[index].area_name;
                    drillDown(areaId, areaName);
                }
            }
        }
    });
}

// Drill down function
function drillDown(areaId, areaName) {
    const dateFrom = '{{ request('date_from', $year . '-01-01') }}';
    const dateTo = '{{ request('date_to', $year . '-12-31') }}';
    const term = '{{ request('term') }}';
    const type = '{{ request('type') }}';
    let url = '{{ url("/collections/report/drill-down") }}?area_id=' + areaId + '&date_from=' + dateFrom + '&date_to=' + dateTo;
    if (term) url += `&term=${term}`;
    if (type) url += `&type=${type}`;
    fetch(url)
        .then(response => response.json())
        .then(data => {
            const dateFrom = '{{ request('date_from', $year . '-01-01') }}';
            const dateTo = '{{ request('date_to', $year . '-12-31') }}';
            document.getElementById('drillDownTitle').textContent = `Units in ${areaName} - ${dateFrom} to ${dateTo}`;
            document.getElementById('drillDownContainer').style.display = 'block';
            
            const ctx = document.getElementById('drillDownChart').getContext('2d');
            
            if (drillDownChart) {
                drillDownChart.destroy();
            }
            
            drillDownChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: data.map(item => item.unit_name),
                    datasets: [{
                        label: 'Collection Amount (KWD)',
                        data: data.map(item => parseFloat(item.total_amount)),
                        backgroundColor: 'rgba(255, 99, 132, 0.8)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    }]
                },
                plugins: [ChartDataLabels],
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return 'KWD ' + value.toLocaleString('en-US', {minimumFractionDigits: 3, maximumFractionDigits: 3});
                                }
                            }
                        }
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return 'Amount: KWD ' + context.parsed.y.toLocaleString('en-US', {minimumFractionDigits: 3, maximumFractionDigits: 3});
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
            
            // Scroll to drill-down container instead of chart canvas
            document.getElementById('drillDownContainer').scrollIntoView({ behavior: 'smooth', block: 'start' });
        });
}

// Back to main chart
function backToMain() {
    document.getElementById('drillDownContainer').style.display = 'none';
    document.getElementById('chartContainer').scrollIntoView({ behavior: 'smooth', block: 'start' });
}

// Clear filters function
function clearFilters() {
    window.location.href = '{{ route('collections.report') }}';
}



// Initialize chart on page load
document.addEventListener('DOMContentLoaded', function() {
    initMainChart();
});
</script>
@endsection