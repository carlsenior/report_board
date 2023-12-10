<div class="row" wire:ignore>
    <div class="col-sm-4">
        <label>Category: </label>
        <select class="select2_1" style="width: 100%;"
                multiple
                data-select2-id="1" tabindex="1" aria-hidden="true">
        </select>
    </div>

    <div class="col-sm-4">
        <label>Products: </label>
        <select class="select2_2" style="width: 100%;"
                multiple
                data-select2-id="2" tabindex="2" aria-hidden="true">
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
    const FILTER_TYPE =  {
        today: 'Today',
        yesterday: 'Yesterday',
        last7days: 'Last7Days',
        last30days: 'Last30Days',
        thismonth: 'ThisMonth',
        lastmonth: 'LastMonth',
        custom: 'Custom'
    }
    $(function (){
        // dateRange picker
        const start = moment().subtract(29, 'days');
        const end = moment();

        const state = {
            filter: FILTER_TYPE.last30days,
            categories: [],
            products: []
        }

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
        const _data_source = @js($categories);
        const category_select_data = _data_source.map(function (_category) {
            return {
                id: _category.id,
                text: _category.name,
                products: _category.products
            }
        })
        let product_select_data = [];

        $('.select2_1').select2({
                theme: "classic",
                data: category_select_data,
        }).on('select2:select', function (e){
            const category_id = e.params.data.id;
            const categories = category_select_data.filter(c => c.id === parseInt(category_id, 10));
            categories[0].products.forEach(function (product) {
                product_select_data.push({
                    id: product.id,
                    text: product.name
                })
            })
            selected_categories = [];
            $(this).find(':selected').each(function () {
                selected_categories.push($(this).val());
            })
            state.categories = selected_categories;
            state.products = [];

            $wire.dispatchTo('dash-board.chart.chart-container', 'dofilter', {
                state
            });
            // console.log($wire);

            // $(".select2_2").empty();
            // $('.select2_2').select2({
            //     theme: 'classic',
            //     data: product_select_data
            // })
        }).on('select2:unselect', function (e) {
            // const category_id = e.params.data.id;
            // const categories = category_select_data.filter(c => c.id === parseInt(category_id, 10));
            // categories[0].products.forEach(function (product) {
            //     product_select_data.pop({
            //         id: product.id,
            //         text: product.name
            //     })
            // });
            // $(".select2_2").empty();
            // $('.select2_2').select2({
            //     theme: 'classic',
            //     data: product_select_data
            // })
        });

        $('.select2_2').select2({
                theme: 'classic',
        })
    })
</script>
@endscript


