@extends('layouts.app')

@section('title', 'Unit Type Comparison')

@section('content')
    <div>
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Collection Comparison by Unit Type</h2>
            <form method="GET" class="d-flex gap-2">
                <select name="year" class="form-select">
                    @for($i = date('Y'); $i >= 2020; $i--)
                        <option value="{{ $i }}" {{ $year == $i ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
                </select>
                <select name="term" class="form-select">
                    <option value="">All Terms</option>
                    @foreach($terms as $termOption)
                        <option value="{{ $termOption }}" {{ $term == $termOption ? 'selected' : '' }}>{{ $termOption }}</option>
                    @endforeach
                </select>
                <select name="type" class="form-select">
                    <option value="">All Types</option>
                    @foreach($types as $typeOption)
                        <option value="{{ $typeOption }}" {{ $type == $typeOption ? 'selected' : '' }}>{{ $typeOption }}</option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-primary">Filter</button>
            </form>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5>Unit Type Comparison - {{ $year }}</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="comparisonChart" width="400" height="200"></canvas>
                    </div>
                </div>
                
                <!-- Drill-down details -->
                <div id="drillDownSection" class="card mt-3" style="display: none;">
                    <div class="card-header">
                        <h5 id="drillDownTitle">Unit Details</h5>
                        <button type="button" class="btn btn-sm btn-secondary float-end" onclick="hideDrillDown()">Close</button>
                    </div>
                    <div class="card-body">
                        <canvas id="drillDownChart" width="400" height="200"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5>Summary</h5>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Type</th>
                                    <th>Units</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($data as $item)
                                <tr>
                                    <td><strong>{{ $item['type'] }}</strong></td>
                                    <td>{{ $item['count'] }}</td>
                                    <td>KWD {{ number_format($item['total'], 3) }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted">No data available</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        let chartInstance;
        let drillDownChartInstance;
        const unitData = @json($data);
        
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('comparisonChart').getContext('2d');
            const data = unitData;
            
            console.log('Chart data:', data);
            
            if (!data || data.length === 0) {
                ctx.font = '16px Arial';
                ctx.fillStyle = '#666';
                ctx.textAlign = 'center';
                ctx.fillText('No data available for {{ $year }}', ctx.canvas.width / 2, ctx.canvas.height / 2);
                return;
            }
            
            // Filter out zero values and ensure we have valid data
            const validData = data.filter(item => item.total > 0);
            
            if (validData.length === 0) {
                ctx.font = '16px Arial';
                ctx.fillStyle = '#666';
                ctx.textAlign = 'center';
                ctx.fillText('No collections found for selected filters', ctx.canvas.width / 2, ctx.canvas.height / 2);
                return;
            }
            
            chartInstance = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: validData.map(item => item.type),
                    datasets: [{
                        label: 'Collections (KWD)',
                        data: validData.map(item => parseFloat(item.total) || 0),
                        backgroundColor: [
                            'rgba(54, 162, 235, 0.8)',
                            'rgba(255, 99, 132, 0.8)',
                            'rgba(75, 192, 192, 0.8)',
                            'rgba(255, 206, 86, 0.8)'
                        ],
                        borderColor: [
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 99, 132, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(255, 206, 86, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    onClick: function(event, elements) {
                        if (elements.length > 0) {
                            const index = elements[0].index;
                            const unitType = validData[index].type;
                            showDrillDown(unitType);
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                afterLabel: function(context) {
                                    return 'Click to see unit details';
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return 'KWD ' + value.toLocaleString();
                                }
                            }
                        }
                    }
                },
                plugins: [{
                    afterDraw: function(chart) {
                        const ctx = chart.ctx;
                        chart.data.datasets.forEach((dataset, i) => {
                            const meta = chart.getDatasetMeta(i);
                            meta.data.forEach((bar, index) => {
                                const data = dataset.data[index];
                                if (data > 0) {
                                    ctx.fillStyle = '#000';
                                    ctx.font = 'bold 12px Arial';
                                    ctx.textAlign = 'center';
                                    ctx.fillText('KWD ' + data.toLocaleString(), bar.x, bar.y - 5);
                                }
                            });
                        });
                    }
                }]
            });
        });
        
        function showDrillDown(unitType) {
            const term = '{{ $term ?? '' }}';
            const collectionType = '{{ $type ?? '' }}';
            
            let url = `/collections/unit-type-drill-down?type=${unitType}&year={{ $year }}`;
            if (term) url += `&term=${encodeURIComponent(term)}`;
            if (collectionType) url += `&collection_type=${encodeURIComponent(collectionType)}`;
            
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('drillDownTitle').textContent = `${unitType} Units - {{ $year }}`;
                    
                    // Destroy existing drill-down chart if it exists
                    if (drillDownChartInstance) {
                        drillDownChartInstance.destroy();
                    }
                    
                    // Filter units with collections
                    const validUnits = data.filter(unit => unit.total_amount > 0);
                    
                    if (validUnits.length === 0) {
                        const ctx = document.getElementById('drillDownChart').getContext('2d');
                        ctx.clearRect(0, 0, ctx.canvas.width, ctx.canvas.height);
                        ctx.font = '16px Arial';
                        ctx.fillStyle = '#666';
                        ctx.textAlign = 'center';
                        ctx.fillText('No units found with collections', ctx.canvas.width / 2, ctx.canvas.height / 2);
                        document.getElementById('drillDownSection').style.display = 'block';
                        return;
                    }
                    
                    // Create drill-down bar chart
                    const ctx = document.getElementById('drillDownChart').getContext('2d');
                    drillDownChartInstance = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: validUnits.map(unit => unit.unit_name),
                            datasets: [{
                                label: 'Collections (KWD)',
                                data: validUnits.map(unit => parseFloat(unit.total_amount) || 0),
                                backgroundColor: 'rgba(54, 162, 235, 0.8)',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    display: false
                                },
                                tooltip: {
                                    callbacks: {
                                        afterLabel: function(context) {
                                            const unit = validUnits[context.dataIndex];
                                            return [`Area: ${unit.area_name}`, `Collections: ${unit.collection_count}`];
                                        }
                                    }
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        callback: function(value) {
                                            return 'KWD ' + value.toLocaleString();
                                        }
                                    }
                                },
                                x: {
                                    ticks: {
                                        maxRotation: 45,
                                        minRotation: 45
                                    }
                                }
                            }
                        }
                    });
                    
                    document.getElementById('drillDownSection').style.display = 'block';
                })
                .catch(error => {
                    console.error('Error fetching drill-down data:', error);
                    const ctx = document.getElementById('drillDownChart').getContext('2d');
                    ctx.clearRect(0, 0, ctx.canvas.width, ctx.canvas.height);
                    ctx.font = '16px Arial';
                    ctx.fillStyle = '#dc3545';
                    ctx.textAlign = 'center';
                    ctx.fillText('Error loading unit details', ctx.canvas.width / 2, ctx.canvas.height / 2);
                    document.getElementById('drillDownSection').style.display = 'block';
                });
        }
        
        function hideDrillDown() {
            document.getElementById('drillDownSection').style.display = 'none';
            if (drillDownChartInstance) {
                drillDownChartInstance.destroy();
                drillDownChartInstance = null;
            }
        }
    </script>
@endsection