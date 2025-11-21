@extends('layouts.app')

@section('title', 'Collection Report')

@section('content')
    <div>
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Collection Report - {{ date('Y') }}</h2>
            <button type="button" class="btn btn-secondary" onclick="clearFilters()">Clear Filters</button>
        </div>
        
        <div class="card mb-4">
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-4">
                        <h5>Total Collections ({{ date('Y') }})</h5>
                        <h3 class="text-primary" id="yearlyTotal">KWD {{ number_format($totalAmount ?? $collections->sum('amount'), 3) }}</h3>
                    </div>
                    <div class="col-md-4">
                        <h5>Filtered Total</h5>
                        <h3 class="text-success" id="filteredTotal">KWD {{ number_format($totalAmount ?? $collections->sum('amount'), 3) }}</h3>
                    </div>
                    <div class="col-md-4">
                        <h5>Total Records</h5>
                        <h3 class="text-info" id="recordCount">{{ $collections->count() }}</h3>
                    </div>
                </div>
            </div>
        </div>

        @if(!empty($mekhalaData))
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Mekhala-wise Collection Overview</h5>
                <div id="chartBreadcrumb" class="small text-muted"></div>
            </div>
            <div class="card-body">
                <canvas id="collectionChart" width="400" height="200"></canvas>
            </div>
        </div>
        @endif

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Collection Date</th>
                                <th>Amount</th>
                                <th>Unit</th>
                                <th>Mekhala</th>
                                <th>Area</th>
                                <th>Status</th>
                                <th>Entered By</th>
                                <th>Created At</th>
                            </tr>
                        </thead>
                        <thead>
                            <tr>
                                <th><input type="date" class="form-control form-control-sm filter-input" data-column="0"></th>
                                <th><input type="text" class="form-control form-control-sm filter-input" placeholder="Filter Amount" data-column="1"></th>
                                <th><input type="text" class="form-control form-control-sm filter-input" placeholder="Filter Unit" data-column="2"></th>
                                <th><input type="text" class="form-control form-control-sm filter-input" placeholder="Filter Mekhala" data-column="3"></th>
                                <th><input type="text" class="form-control form-control-sm filter-input" placeholder="Filter Area" data-column="4"></th>
                                <th><select class="form-control form-control-sm filter-input" data-column="5"><option value="">All Status</option><option value="payable">Payable</option><option value="received">Received</option></select></th>
                                <th><input type="text" class="form-control form-control-sm filter-input" placeholder="Filter User" data-column="6"></th>
                                <th><input type="date" class="form-control form-control-sm filter-input" data-column="7"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($collections as $collection)
                                <tr>
                                    <td>{{ $collection->collection_date }}</td>
                                    <td>KWD {{ number_format($collection->amount, 3) }}</td>
                                    <td>{{ $collection->unit->name ?? 'N/A' }}</td>
                                    <td>{{ $collection->unit->area->mekhala->name ?? 'N/A' }}</td>
                                    <td>{{ $collection->unit->area->name ?? 'N/A' }}</td>
                                    <td>
                                        @if($collection->collection_status === 'received')
                                            <span class="badge bg-success">Received</span>
                                        @else
                                            <span class="badge bg-warning">Payable</span>
                                        @endif
                                    </td>
                                    <td>{{ $collection->enteredBy->name ?? 'N/A' }}</td>
                                    <td>{{ $collection->created_at->format('Y-m-d H:i:s') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">No collections found</td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr class="table-info">
                                <th>Total:</th>
                                <th id="totalAmount">KWD {{ number_format($totalAmount ?? $collections->sum('amount'), 3) }}</th>
                                <th colspan="6"></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const filterInputs = document.querySelectorAll('.filter-input');
            const tableRows = document.querySelectorAll('tbody tr');
            
            filterInputs.forEach(input => {
                input.addEventListener('input', function() {
                    filterTable();
                });
                input.addEventListener('change', function() {
                    filterTable();
                });
            });
            
            function filterTable() {
                let visibleTotal = 0;
                let visibleCount = 0;
                
                tableRows.forEach(row => {
                    if (row.cells.length < 8) return; // Skip empty rows
                    
                    let showRow = true;
                    
                    filterInputs.forEach(input => {
                        const column = parseInt(input.dataset.column);
                        const filterValue = input.value.toLowerCase().trim();
                        
                        if (filterValue) {
                            const cellValue = row.cells[column].textContent.toLowerCase().trim();
                            
                            // For date columns, handle date filtering
                            if (input.type === 'date' && filterValue) {
                                const cellDate = row.cells[column].textContent.trim();
                                if (cellDate !== filterValue) {
                                    showRow = false;
                                }
                            }
                            // For select dropdowns, exact match
                            else if (input.tagName === 'SELECT' && filterValue) {
                                if (!cellValue.includes(filterValue)) {
                                    showRow = false;
                                }
                            }
                            // For text inputs, partial match
                            else if (!cellValue.includes(filterValue)) {
                                showRow = false;
                            }
                        }
                    });
                    
                    row.style.display = showRow ? '' : 'none';
                    
                    if (showRow) {
                        const amountText = row.cells[1].textContent.replace('KWD ', '').replace(/,/g, '');
                        const amount = parseFloat(amountText) || 0;
                        visibleTotal += amount;
                        visibleCount++;
                    }
                });
                
                document.getElementById('totalAmount').textContent = 'KWD ' + visibleTotal.toLocaleString('en-US', {minimumFractionDigits: 3, maximumFractionDigits: 3});
                document.getElementById('filteredTotal').textContent = 'KWD ' + visibleTotal.toLocaleString('en-US', {minimumFractionDigits: 3, maximumFractionDigits: 3});
                document.getElementById('recordCount').textContent = visibleCount;
            }
            
            @if(!empty($mekhalaData))
            // Initialize chart
            const ctx = document.getElementById('collectionChart').getContext('2d');
            let currentChart;
            let currentLevel = 'mekhala';
            let breadcrumb = [];
            
            function createChart(data, level, title) {
                if (currentChart) {
                    currentChart.destroy();
                }
                
                currentChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: data.map(item => item.name),
                        datasets: [{
                            label: 'Collection Amount (KWD)',
                            data: data.map(item => item.total),
                            backgroundColor: 'rgba(54, 162, 235, 0.6)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            title: {
                                display: true,
                                text: title
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
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        },
                        onClick: function(event, elements) {
                            if (elements.length > 0) {
                                const index = elements[0].index;
                                const item = data[index];
                                
                                if (level === 'mekhala') {
                                    drillDownToArea(item.id, item.name);
                                } else if (level === 'area') {
                                    drillDownToUnit(item.id, item.name);
                                }
                            }
                        }
                    }
                });
            }
            
            function drillDownToArea(mekhalaId, mekhalaName) {
                fetch(`{{ route('reports.collection.mekhala-drilldown') }}?mekhala_id=${mekhalaId}`)
                    .then(response => response.json())
                    .then(data => {
                        breadcrumb = [{name: mekhalaName, level: 'mekhala', id: mekhalaId}];
                        currentLevel = 'area';
                        createChart(data, 'area', `Areas in ${mekhalaName}`);
                        updateBreadcrumb();
                    });
            }
            
            function drillDownToUnit(areaId, areaName) {
                fetch(`{{ route('reports.collection.area-drilldown') }}?area_id=${areaId}`)
                    .then(response => response.json())
                    .then(data => {
                        breadcrumb.push({name: areaName, level: 'area', id: areaId});
                        currentLevel = 'unit';
                        createChart(data, 'unit', `Units in ${areaName}`);
                        updateBreadcrumb();
                    });
            }
            
            function updateBreadcrumb() {
                const breadcrumbHtml = breadcrumb.map((item, index) => 
                    `<button class="btn btn-link p-0" onclick="goToBreadcrumb(${index})">${item.name}</button>`
                ).join(' > ');
                
                document.getElementById('chartBreadcrumb').innerHTML = 
                    `<button class="btn btn-link p-0" onclick="goToMekhala()">All Mekhalas</button>` + 
                    (breadcrumbHtml ? ' > ' + breadcrumbHtml : '');
            }
            
            function goToMekhala() {
                breadcrumb = [];
                currentLevel = 'mekhala';
                createChart({!! json_encode($mekhalaData) !!}, 'mekhala', 'Mekhala-wise Collections');
                updateBreadcrumb();
            }
            
            function goToBreadcrumb(index) {
                const item = breadcrumb[index];
                breadcrumb = breadcrumb.slice(0, index);
                
                if (item.level === 'mekhala') {
                    drillDownToArea(item.id, item.name);
                }
            }
            
            // Initialize with mekhala data
            createChart({!! json_encode($mekhalaData) !!}, 'mekhala', 'Mekhala-wise Collections');
            updateBreadcrumb();
            @endif
        });
        
        function clearFilters() {
            const filterInputs = document.querySelectorAll('.filter-input');
            filterInputs.forEach(input => {
                input.value = '';
            });
            filterTable();
        }
    </script>
@endsection