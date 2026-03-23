@extends('layouts.app')

@section('title', 'Collection Report')

@section('content')
    <div>
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Collection Report</h2>
            <button type="button" class="btn btn-secondary" onclick="clearFilters()">Clear Filters</button>
        </div>
        
        <div class="card mb-4">
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-4">
                        <h5>Total Collections</h5>
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

        <div class="card mb-4">
            <div class="card-header">
                <h5>Filters</h5>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('reports.collection') }}">
                    <div class="row">
                        <div class="col-md-2">
                            <label for="date_from" class="form-label">Date From</label>
                            <input type="date" name="date_from" id="date_from" class="form-control" value="{{ request('date_from') }}">
                        </div>
                        <div class="col-md-2">
                            <label for="date_to" class="form-label">Date To</label>
                            <input type="date" name="date_to" id="date_to" class="form-control" value="{{ request('date_to') }}">
                        </div>
                        <div class="col-md-2">
                            <label for="area_id" class="form-label">Area</label>
                            <select name="area_id" id="area_id" class="form-select">
                                <option value="">All Areas</option>
                                @foreach($areas as $area)
                                    <option value="{{ $area->id }}" {{ request('area_id') == $area->id ? 'selected' : '' }}>
                                        {{ $area->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="filter-type" class="form-label">Type</label>
                            <select name="type" id="filter-type" class="form-select">
                                <option value="">All Types</option>
                                @foreach($types as $type)
                                    <option value="{{ $type->name }}" {{ request('type') == $type->name ? 'selected' : '' }}>
                                        {{ $type->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="filter-term" class="form-label">Term</label>
                            <select name="term" id="filter-term" class="form-select">
                                <option value="">All Terms</option>
                                @foreach($terms as $term)
                                    <option value="{{ $term->name }}" {{ request('term') == $term->name ? 'selected' : '' }}>
                                        {{ $term->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary me-2">Filter</button>
                            <a href="{{ route('reports.collection') }}" class="btn btn-secondary">Clear</a>
                        </div>
                    </div>
                </form>
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

        <div class="card mb-4">
            <div class="card-header">
                <h5>Collections by Area</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Area</th>
                                <th>Term</th>
                                <th>Type</th>
                                <th class="text-end">Total Amount</th>
                                <th class="text-center">Records</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($collectionsByArea as $index => $areaData)
                            @php $loopId = $loop->index; @endphp
                            <tr>
                                <td><strong>{{ $areaData['area'] }}</strong></td>
                                <td colspan="2" class="text-center">All Terms & Types</td>
                                <td class="text-end">KWD {{ number_format($areaData['total'], 3) }}</td>
                                <td class="text-center">{{ $areaData['count'] }}</td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-outline-primary" type="button" data-bs-toggle="collapse" data-bs-target="#areaDetails{{ $loopId }}">
                                        <i class="fas fa-eye"></i> View Details
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="6" class="p-0">
                                    <div class="collapse" id="areaDetails{{ $loopId }}">
                                        <div class="p-3 bg-light">
                                            <h6>{{ $areaData['area'] }} - Detailed Collections</h6>
                                            <div class="table-responsive">
                                                <table class="table table-sm mb-0">
                                                    <thead>
                                                        <tr>
                                                            <th>Date</th>
                                                            <th>Term</th>
                                                            <th>Type</th>
                                                            <th>Amount</th>
                                                            <th>Unit</th>
                                                            <th>Status</th>
                                                            <th>Entered By</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($areaData['collections'] as $collection)
                                                        <tr>
                                                            <td>{{ $collection->collection_date }}</td>
                                                            <td>{{ $collection->term ?? 'N/A' }}</td>
                                                            <td>{{ $collection->type ?? 'N/A' }}</td>
                                                            <td>KWD {{ number_format($collection->amount, 3) }}</td>
                                                            <td>{{ $collection->unit->name ?? 'N/A' }}</td>
                                                            <td>
                                                                @if($collection->collection_status === 'received')
                                                                    <span class="badge bg-success">Received</span>
                                                                @else
                                                                    <span class="badge bg-warning">Payable</span>
                                                                @endif
                                                            </td>
                                                            <td>{{ $collection->enteredBy->name ?? 'N/A' }}</td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="table-info">
                                <th colspan="3">Total:</th>
                                <th class="text-end">KWD {{ number_format($totalAmount, 3) }}</th>
                                <th class="text-center">{{ $collections->count() }}</th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5>All Collections</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Unit</th>
                                <th>Area</th>
                                <th>Amount</th>
                                <th>Type</th>
                                <th>Term</th>
                                <th>Status</th>
                                <th>Entered By</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($collections as $collection)
                            <tr>
                                <td>{{ $collection->collection_date }}</td>
                                <td>{{ $collection->unit->name ?? 'N/A' }}</td>
                                <td>{{ $collection->unit->area->name ?? 'N/A' }}</td>
                                <td>KWD {{ number_format($collection->amount, 3) }}</td>
                                <td>{{ $collection->type }}</td>
                                <td>{{ $collection->term }}</td>
                                <td>
                                    @if($collection->collection_status === 'received')
                                        <span class="badge bg-success">Received</span>
                                    @else
                                        <span class="badge bg-warning">Payable</span>
                                    @endif
                                </td>
                                <td>{{ $collection->enteredBy->name ?? 'N/A' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/term-type-filter.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            initTermTypeFilter('filter-type', 'filter-term', '{{ route("api.terms-by-type") }}', '{{ request("term") }}');
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
            
            // Debug: Check user type and mekhala data
            console.log('User type check:', '{{ auth()->user()->user_type }}');
            console.log('Is center user:', {{ auth()->user()->isCenterUser() ? 'true' : 'false' }});
            console.log('Mekhala data available:', {{ !empty($mekhalaData) ? 'true' : 'false' }});
            
            @if(!empty($mekhalaData))
            // Initialize chart
            console.log('Mekhala Data:', {!! json_encode($mekhalaData) !!});
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
                        plugins: {
                            title: {
                                display: true,
                                text: title
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
            const mekhalaData = {!! json_encode($mekhalaData) !!};
            console.log('Creating chart with data:', mekhalaData);
            createChart(mekhalaData, 'mekhala', 'Mekhala-wise Collections');
            updateBreadcrumb();
            @else
            console.log('No mekhala data available or user is not center user');
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