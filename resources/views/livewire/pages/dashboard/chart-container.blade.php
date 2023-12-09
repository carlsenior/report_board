<div>
    <div class="row">
        <div class="col-sm-6">
            <livewire:dash-board.chart.chart type="area" :datasource="$dataSource['visitors']" />
            <livewire:dash-board.chart.chart type="doughnut" :datasource="$dataSource['categories']" />
        </div>
        <div class="col-sm-6">
            <livewire:dash-board.chart.chart type="bar" :datasource="$dataSource['sales']" />
            <livewire:dash-board.report />
        </div>
    </div>
</div>

@assets
<script src="{{ asset('js/jquery-ui.min.js') }}" defer></script>
@endassets

@script
<script defer>
    // Make the dashboard widgets sortable Using jquery UI
    $('.connectedSortable').sortable({
        placeholder: 'sort-highlight',
        connectWith: '.connectedSortable',
        handle: '.card-header',
        forcePlaceholderSize: true,
        zIndex: 999999
    })
    $('.connectedSortable .card-header').css('cursor', 'move')
</script>
@endscript
