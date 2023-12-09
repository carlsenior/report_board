<div class="connectedSortable">
    <div class="card">
        <div class="card-header border-0">
            <h3 class="card-title">Products</h3>
            <div class="card-tools">
                <a href="#" class="btn btn-tool btn-sm">
                    <i class="fas fa-download"></i>
                </a>
                <a href="#" class="btn btn-tool btn-sm">
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
                        <livewire:dash-board.report-item :this_data="$data" :last_data="$datasource[1][$index]" :key="$index"/>
                    @empty
                        <p>No products</p>
                    @endforelse

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


