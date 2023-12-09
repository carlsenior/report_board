<div class="row">
    <div class="col-sm-4">
        <label>Category: </label>
        <select class="select2" style="width: 100%;"
                multiple
                data-select2-id="1" tabindex="1" aria-hidden="true">
            @foreach($categories as $index => $category)
                <option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
            @endforeach
        </select>
    </div>

    <div class="col-sm-4">
        <label>Products: </label>
        <select class="select2" style="width: 100%;"
                multiple
                data-select2-id="2" tabindex="2" aria-hidden="true">
            @foreach($products as $index => $product)
                <option value="{{ $product['id'] }}">{{ $product['name'] }}</option>
            @endforeach
        </select>
    </div>

    <div class="col-sm-4">
        <label>Date range Filter: </label>
        <div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
            <i class="fa fa-calendar"></i>&nbsp;
            <span></span> <i class="fa fa-caret-down"></i>
        </div>
    </div>
</div>

@assets
<!-- select plugin -->
<link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/daterangepicker.css') }}">

<script src="{{ asset('js/select2.full.min.js') }}" defer></script>
<script src="{{ asset('js/moment.min.js') }}" defer></script>
<script src="{{ asset('js/daterangepicker.js') }}" defer></script>
@endassets


@script
<script defer>
    $(function (){
        // dateRange picker
        const start = moment().subtract(29, 'days');
        const end = moment();

        function cb(start, end) {
            $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        }

        $('#reportrange').daterangepicker({
            startDate: start,
            endDate: end,
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, cb);
        cb(start, end);

        // multi select
        $('.select2').each(function () {
            $(this).select2({
                theme: "classic",
            });
        })
    })
</script>
@endscript


