<div class="connectedSortable" wire:ignore>
    <div class="card">
        <div class="card-header border-0">
            <h3 class="card-title">Products</h3>
            <div class="card-tools">
                <a id="request_handler" class="btn btn-tool btn-sm">
                    <i class="fas fa-download"></i>
                </a>
                <a href="javascript:void(0);" class="btn btn-tool btn-sm">
                    <i class="fas fa-bars"></i>
                </a>
            </div>
        </div>
        <div class="card-body table-responsive p-0">
            <div id="overlay_scroll">
                <table class="table table-striped table-valign-middle">

                    <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Sales</th>
                        <th>More</th>
                    </tr>
                    </thead>
                    <tbody>

                    @forelse($datasource[0] as $index => $data)
                        @php
                        $_last_datas = array_filter($datasource[1], function ($value) use ($data) {
                            return $value['id'] == $data['id'];
                        });
                        $last_data = count($_last_datas) == 1 ? array_values($_last_datas)[0] : [
                            'sales' => 0
                        ];

                        @endphp
                        <livewire:dash-board.report-item :this_data="$data" :last_data="$last_data" key="$index" />
                    @empty
                        <p class="no-product">No products</p>
                    @endforelse

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@assets
<script src="{{ asset('js/pdfmake.min.js') }}"></script>
<script src="{{ asset('js/vfs_fonts.js') }}"></script>
@endassets

@script
<script defer>

    $(document).ready(function () {

        $('#request_handler').on('click', function (e){
            e.preventDefault();
            $wire.dispatchTo('dash-board.chart.chart-container', 'requestSales');
        })

        window.addEventListener('create_pdf', function (e) {
            _data_source = e.detail[0];

            const currencyFormatter = new Intl.NumberFormat('en-US', {
                style: 'currency',
                currency: 'USD',
            });

            let start_date = moment().startOf('year').format('MMM DD YYYY');
            let end_date = moment().endOf('year').format('MMM DD YYYY');
            let documentDef = {
                pageSize: 'A4',
                pageMargins: [70, 70, 70, 50],
                content: [
                    {
                        text: `Summary Sales by between ${start_date} to ${end_date} by category by product`,
                        fontSize: 18,
                        bold:true,
                        alignment: 'center',
                        color: '#3b8bba'
                    },
                ],
                footer: function(currentPage, pageCount) {
                    return {
                        text: currentPage.toString() + ' of ' + pageCount,
                        style: {
                            alignment: 'center'
                        }
                    }
                },
                defaultStyle: {
                    fontSize: 12,
                }
            };

            function product_template(product_name, quantities, price, product_total) {
                return [
                    // product row
                  [
                      {
                          text: ''
                          }, {
                              text: `Product: ${product_name}`,
                              colSpan: 4
                          }, {}, {}, {}
                  ],// sub-header row
                    [
                        {
                            text: '',
                            colSpan: 2
                        }, {}, {
                            text: 'Qty'
                        }, {
                            text: 'Price'
                        }, {
                            text: 'Total',
                            alignment: 'right'
                        }
                    ],// descripton row
                    [
                        {
                            text: '',
                            colSpan: 2
                        }, {

                        }, {
                                text: quantities.toString()
                        }, {
                            text: `${currencyFormatter.format(price)}`
                        }, {
                            text: `${currencyFormatter.format(product_total)}`,
                            alignment: 'right'
                        }
                    ]
                ];
            }
            function category_table_template(category_name) {
                return {
                     layout: 'noBorders',
                    table: {
                        widths: [50, '*', 70, 70, 'auto'],
                            body: [
                            // category row
                            [{
                                text: `Category: ${category_name}`,
                                colSpan: 5,
                                fillColor: '#F5F5F5',
                                bold: true
                            }, {

                            }, {}, {}, {}
                            ],
                            // product subportion, 3 rows per portion

                            // should be total row
                        ],
                    },
                    margin: [0, 30, 0, 0]
                }
            }

            function generateTotalRowOfCategory(category_name, category_total) {
                // total row
                return [{
                    text: `Total ${category_name}`,
                    colSpan: 4,
                    fillColor: '#E0E0E0',
                    bold: true
                }, {

                }, {}, {}, {
                    text: `${currencyFormatter.format(category_total)}`,
                    fillColor: '#E0E0E0',
                    alignment: 'right',
                    bold: true
                }]
            }

            Object.keys(_data_source).forEach(function (key) {
                let category_name = key;
                let products = _data_source[key];
                let category_total = 0;
                let category_template = category_table_template(category_name)
                for (var _p in products) {
                    let product_name = products[_p]['pname'];
                    let quantities = products[_p]['quantities'];
                    let price = products[_p]['price'];
                    let product_total = products[_p]['total'];
                    category_total += product_total;

                    product_template(product_name, quantities, price, product_total).forEach(function (row) {
                        category_template.table.body.push(row);
                    });
                }
                category_template.table.body.push(generateTotalRowOfCategory(category_name, category_total));
                documentDef.content.push(category_template);
            })

            pdfMake.createPdf(documentDef).open();
        })
    })

</script>
@endscript


