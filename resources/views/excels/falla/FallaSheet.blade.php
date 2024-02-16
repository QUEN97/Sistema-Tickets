<table>
    <thead>
        <tr>
            <th>{{ __('ID') }}</th>
            <th>{{ __('FALLA') }}</th>
            <th>{{ __('SERVICIO') }}</th>
            <th>{{ __('ESTADO') }}</th>
            <th>{{ __('FECHA') }}</th>
        </tr>
    </thead>
    <tbody>
        {{-- {{dd($catego);}} --}}
        @foreach ($fallas as $item)
            <tr>
                <td>
                    {{ $item->id }}
                </td>
                <td>
                    {{ $item->name }}
                </td>
                <td>
                    {{ $item->servicio->name }}
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