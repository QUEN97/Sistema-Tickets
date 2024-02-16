<table>
    <thead>
        <tr>
            <th>{{ __('ID') }}</th>
            <th>{{ __('PRODUCTO') }}</th>
            <th>{{ __('STOCK ACTUAL') }}</th>
            <th>{{ __('STOCK BASE') }}</th>
            <th>{{ __('ACTUALIZADO') }}</th>
        </tr>
    </thead>
    <tbody>
        {{-- {{dd($catego);}} --}}
        @foreach ($almacenes as $item)
            <tr>
                <td>
                    {{ $item->id }}
                </td>
                <td>
                    {{ $item->producto->name }}
                </td>
                <td>
                    {{ $item->stock }}
                </td>
                <td>
                    {{ $item->stock_base }}
                </td>
                <td>
                    {{ $item->updated_at }}
                </td>
            </tr>
        @endforeach
        
    </tbody>
</table>