@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3>Collection Report - {{ $year }}</h3>
                    <form method="GET" class="d-flex">
                        <select name="year" class="form-select me-2" onchange="this.form.submit()">
                            @for($y = date('Y'); $y >= 2020; $y--)
                                <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                            @endfor
                        </select>
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
<script>
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
                label: 'Collection Amount (₹)',
                data: amounts,
                backgroundColor: 'rgba(54, 162, 235, 0.8)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return '₹' + value.toLocaleString();
                        }
                    }
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return 'Amount: ₹' + context.parsed.y.toLocaleString();
                        }
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
    fetch(`/collections/report/drill-down?area_id=${areaId}&year=${year}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('drillDownTitle').textContent = `Units in ${areaName} - ${year}`;
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
                        label: 'Collection Amount (₹)',
                        data: data.map(item => parseFloat(item.total_amount)),
                        backgroundColor: 'rgba(255, 99, 132, 0.8)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return '₹' + value.toLocaleString();
                                }
                            }
                        }
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return 'Amount: ₹' + context.parsed.y.toLocaleString();
                                }
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

// Initialize chart on page load
document.addEventListener('DOMContentLoaded', function() {
    initMainChart();
});
</script>
@endsection