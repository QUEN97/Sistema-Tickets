<table>
    <thead>
        <tr>
            <th>{{ __('ID') }}</th>
            <th>{{ __('SERVICIO') }}</th>
            <th>{{ __('DESCRIPCION') }}</th>
            <th>{{ __('PRIORIDAD') }}</th>
            <th>{{ __('FECHA') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($tckservicios as $item)
                <tr>
                    <td>
                        {{$item->id}}  
                    </td>
                    <td>
                        {{ $item->name }}
                    </td>
                    <td>
                        {{ $item->descripcion }}
                    </td>
                    <td>
                        {{ $item->prioridad }}
                    </td>
                    <td>
                        {{ $item->created_at }}
                    </td>
                </tr>
        @endforeach
        
    </tbody>
</table>