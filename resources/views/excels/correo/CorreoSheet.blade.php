<table>
    <thead>
        <tr>
            <th>{{ __('ID') }}</th>
            <th>{{ __('CORREO') }}</th>
            <th>{{ __('FECHA') }}</th>
        </tr>
    </thead>
    <tbody>
        {{-- {{dd($catego);}} --}}
        @foreach ($correos as $item)
            <tr>
                <td>
                    {{ $item->id }}
                </td>
                <td>
                    {{ $item->correo }}
                </td>
                <td>
                    {{ $item->created_at }}
                </td>
            </tr>
        @endforeach
        
    </tbody>
</table>