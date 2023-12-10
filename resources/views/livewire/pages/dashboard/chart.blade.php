<div class="mt-4 connectedSortable">
    <div class="card {{$type == 'area' ? 'card-primary' : ($type == 'doughnut' ? 'card-danger' : '') }}">
        @if ($type == 'area')
            <div class="card-header">
                <h3 class="card-title">Area Chart</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        @elseif($type == 'bar')
            <div class="card-header border-0">
                <div class="d-flex justify-content-between">
                    <h3 class="card-title">Online Store Sales</h3>
                    <a href="javascript:void(0);">View Report</a>
                </div>
            </div>
        @else
            <div class="card-header">
                <h3 class="card-title">Donut Chart</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        @endif
        <div class="card-body">
            @if ($type == 'bar')
                <div class="d-flex">
                    <p class="d-flex flex-column">
                        <span class="text-bold text-lg">${{ number_format($datasource['total'][0], 2, '.', ',') }}</span>
                        <span>Sales Over Time</span>
                    </p>
                    <p class="ml-auto d-flex flex-column text-right">
                    @php
                        $rate = round(($datasource['total'][0] / $datasource['total'][1]-1) * 100, 1)
                    @endphp
                    <span class="{{$rate >= 0 ? 'text-success' : 'text-danger' }}">
                      <i class="fas {{$rate >= 0 ? 'fa-arrow-up' : 'fa-arrow-down' }}"></i> {{ $rate }}%
                    </span>
                        <span class="text-muted">Since last year</span>
                    </p>
                </div>
            @elseif($type == 'area')
                <div class="d-flex">
                    <p class="d-flex flex-column">
                        <span class="text-bold text-lg">{{ $datasource['total'][0] }}</span>
                        <span>Visitors Over Time</span>
                    </p>
                    <p class="ml-auto d-flex flex-column text-right">
                     @php
                        $rate = round(($datasource['total'][0] / $datasource['total'][1]-1) * 100, 1);
                     @endphp
                    <span class="{{$rate >= 0 ? 'text-success' : 'text-danger' }}">
                      <i class="fas {{ $rate >= 0 ? 'fa-arrow-up' : "fa-arrow-down" }}"></i> {{ $rate }}%
                    </span>
                        <span class="text-muted">Since last year</span>
                    </p>
                </div>
            @endif
            <!-- /.d-flex -->

            <div class="chart">
                <canvas id="chart_{{ $type }}" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
            </div>
            @if($type != 'doughnut')
                <div class="d-flex flex-row justify-content-end mt-4">
                      <span class="mr-2">
                        <i class="fas fa-square text-primary"></i> This Year
                      </span>

                    <span>
                        <i class="fas fa-square text-gray"></i> Last Year
                      </span>
                </div>
            @endif
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div>

@assets
<script src="{{ asset('js/Chart.min.js') }}" defer></script>
@endassets

@script
<script defer>


    $(document).ready(() => {

        function buildChart(chartType, _data_source, chartCanvas) {
            let chartData;

            switch (chartType) {
                case 'line':
                case 'bar':
                    chartData = {
                        labels: _data_source['labels'],
                        datasets: [
                            {
                                label: 'This Year Visitors',
                                backgroundColor: 'rgba(60,141,188,0.9)',
                                borderColor: 'rgba(60,141,188,0.8)',
                                pointRadius: true,
                                pointColor: '#3b8bba',
                                pointStrokeColor: 'rgba(60,141,188,1)',
                                pointHighlightFill: '#fff',
                                pointHighlightStroke: 'rgba(60,141,188,1)',
                                data: _data_source['data'][0]
                            },
                            {
                                label: 'Last Year Profit',
                                backgroundColor: 'rgba(210, 214, 222, 1)',
                                borderColor: 'rgba(210, 214, 222, 1)',
                                pointRadius: true,
                                pointColor: 'rgba(210, 214, 222, 1)',
                                pointStrokeColor: '#c1c7d1',
                                pointHighlightFill: '#fff',
                                pointHighlightStroke: 'rgba(220,220,220,1)',
                                data: _data_source['data'][1]
                            },
                        ]
                    }
                    break;
                case 'doughnut':
                    chartData = {
                        labels: Object.keys(_data_source),
                        datasets: [
                            {
                                data: Object.values(_data_source),
                                backgroundColor : _back_colors.slice(0, Object.values(_data_source).length),
                            }
                        ]
                    };
                    break;
            }


            let chartOptions = chartType !== 'doughnut' ? {
                maintainAspectRatio: false,
                responsive: true,
                legend: {
                    display: false
                },
                scales: {
                    xAxes: [{
                        gridLines: {
                            display: false,
                        }
                    }],
                    yAxes: [{
                        gridLines: {
                            display: true,
                        },
                        ticks: {
                            precision: 0
                        }
                    }],
                }

            } : {
                maintainAspectRatio: false,
                responsive: true,
            };

            // This will get the first returned node in the jQuery collection.
            return new Chart(chartCanvas, {
                type:  chartType,
                data: chartData,
                options: chartOptions
            })
        }
        const _chat_type = @js($type);
        const _data_source = @js($datasource);
        const _back_colors = ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#6200EE', '#03DAC6', '#d2d6de'];

        const _month_name = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September',
            'October', 'November', 'December'];

        const chartCanvas = $('#chart_{{ $type }}').get(0).getContext('2d');
        const chartType = _chat_type === 'area' ? 'line' : _chat_type;
        chart = buildChart(chartType, _data_source, chartCanvas);
        {{--window.addEventListener('content_changed', e => {--}}
        {{--    const _data_source = @js($datasource);--}}
        {{--    console.log(_data_source);--}}
        {{--    if (chart != null) {--}}
        {{--        if (_chat_type !== 'doughnut') {--}}
        {{--            chart.data.labels = _data_source['labels'];--}}
        {{--            chart.data.datasets[0].data = _data_source['data'][0];--}}
        {{--            chart.data.datasets[1].data = _data_source['data'][1];--}}
        {{--        } else {--}}
        {{--            console.log(_data_source);--}}
        {{--            chart.data.labels = Object.keys(_data_source);--}}
        {{--            chart.data.datasets = [--}}
        {{--                {--}}
        {{--                    data: Object.values(_data_source),--}}
        {{--                    backgroundColor : _back_colors.slice(0, Object.values(_data_source).length),--}}
        {{--                }--}}
        {{--            ]--}}
        {{--        }--}}
        {{--        chart.update('none');--}}
        {{--    }--}}
        {{--})--}}
    })

</script>
@endscript
