<table>
    <thead>
        <tr>
            <th>{{ __('ID') }}</th>
            <th>{{ __('ESTADO') }}</th>
            <th>{{ __('SERVICIO') }}</th>
            <th>{{ __('FECHA CREACIÓN') }}</th>
            <th>{{ __('FECHA VENCIMIENTO') }}</th>
            <th>{{ __('AGENTE') }}</th>
            <th>{{ __('CLIENTE') }}</th>
            <th>{{ __('PRIORIDAD') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($tickets as $item)
            <tr>
                <td>
                    {{ $item->id }}
                </td>
                <td>
                    {{ $item->status }}
                </td>
                <td>
                    {{ $item->falla->servicio->name }}
                </td>
                <td>
                    {{ $item->created_at }}
                </td>
                <td>
                    {{ $item->fecha_cierre }}
                </td>
                <td>
                    {{ $item->agente->name }}
                </td>
                <td>
                    {{ $item->cliente->name }}
                </td>
                <td>
                    {{ $item->falla->prioridad->name }}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>