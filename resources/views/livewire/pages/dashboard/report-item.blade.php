<tr>
    <td>
        <img src="{{asset('images/default-150x150.png')}}" alt="{{ $this_data['name'] }}" class="img-circle img-size-32 mr-2">
        {{ $this_data['name'] }}
    </td>
    <td>${{ $this_data['price'] }} USD</td>
    <td>
        <small class="{{ $this_data['sales'] >= $last_data['sales'] ? 'text-success' : 'text-danger' }} mr-1">
            @if($last_data['sales'] <= $this_data['sales'])
                <i class="fas fa-arrow-up"></i>
            @else
                <i class="fas fa-arrow-down"></i>
            @endif
            {{ $last_data['sales'] == 0 ? ($this_data['sales'] == 0 ? 0 : 100) : ($last_data['sales'] <= $this_data['sales'] ? round(($this_data['sales']/$last_data['sales']-1)*100) : round((1 - $this_data['sales']/$last_data['sales'])*100)) }}%
        </small>
        {{ number_format($this_data['sales'], 2, '.', ',') }}
    </td>
    <td>
        <a href="#" class="text-muted">
            <i class="fas fa-search"></i>
        </a>
    </td>
</tr>

