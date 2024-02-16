<table>
    <thead>
        <tr>
            <th>{{ __('ID') }}</th>
            <th>{{ __('TIPO/PRIORIDAD') }}</th>
            <th>{{ __('RESPUESTA (HRS)') }}</th>
            <th>{{ __('ESTADO') }}</th>
            <th>{{ __('FECHA') }}</th>
        </tr>
    </thead>
    <tbody>
        {{-- {{dd($catego);}} --}}
        @foreach ($prioridades as $item)
            <tr>
                <td>
                    {{ $item->id }}
                </td>
                <td>
                    {{ $item->clase->name }} - {{ $item->name }}
                </td>
                <td>
                    @if ($item->tiempo == 1)
                        {{ $item->tiempo }} hora
                    @else
                        {{ $item->tiempo }} horas
                    @endif
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
