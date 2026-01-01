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
                        <div id="drillDownContent"></div>
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
                                @foreach($data as $item)
                                <tr>
                                    <td><strong>{{ $item['type'] }}</strong></td>
                                    <td>{{ $item['count'] }}</td>
                                    <td>KWD {{ number_format($item['total'], 3) }}</td>
                                </tr>
                                @endforeach
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
            
            chartInstance = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: data.map(item => item.type),
                    datasets: [{
                        label: 'Collections (KWD)',
                        data: data.map(item => parseFloat(item.total)),
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
                            const unitType = data[index].type;
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
            
            fetch(url))
                .then(response => response.json())
                .then(data => {
                    document.getElementById('drillDownTitle').textContent = `${unitType} Units - {{ $year }}`;
                    
                    let html = '<div class="table-responsive"><table class="table table-striped"><thead><tr><th>Unit Name</th><th>Area</th><th>Collections</th><th>Total Amount</th></tr></thead><tbody>';
                    
                    data.forEach(unit => {
                        html += `<tr><td>${unit.unit_name}</td><td>${unit.area_name}</td><td>${unit.collection_count}</td><td>KWD ${parseFloat(unit.total_amount).toLocaleString()}</td></tr>`;
                    });
                    
                    html += '</tbody></table></div>';
                    
                    document.getElementById('drillDownContent').innerHTML = html;
                    document.getElementById('drillDownSection').style.display = 'block';
                })
                .catch(error => {
                    console.error('Error fetching drill-down data:', error);
                    document.getElementById('drillDownContent').innerHTML = '<p class="text-danger">Error loading unit details</p>';
                    document.getElementById('drillDownSection').style.display = 'block';
                });
        }
        
        function hideDrillDown() {
            document.getElementById('drillDownSection').style.display = 'none';
        }
    </script>
@endsection