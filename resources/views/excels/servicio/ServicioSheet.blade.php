<table>
    <thead>
        <tr>
            <th>{{ __('ID') }}</th>
            <th>{{ __('SERVICIO') }}</th>
            <th>{{ __('ÁREA') }}</th>
            <th>{{ __('ESTADO') }}</th>
            <th>{{ __('FECHA') }}</th>
        </tr>
    </thead>
    <tbody>
        {{-- {{dd($catego);}} --}}
        @foreach ($servicios as $item)
            <tr>
                <td>
                    {{ $item->id }}
                </td>
                <td>
                    {{ $item->name }}
                </td>
                <td>
                    {{ $item->area->name }}
                </td>
                <td>
                    {{ $item->status }}
                </td>
                <td>
                    {{ $item->created_at }}
                </td>
            </tr>
        @endforeach
        
    </tbody>
</table>