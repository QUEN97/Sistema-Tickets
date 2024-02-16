<table>
    <thead>
        <tr>
            <th>{{ __('ID') }}</th>
            <th>{{ __('PRODUCTO') }}</th>
            <th>{{ __('CATEGORÍA') }}</th>
            <th>{{ __('MARCA') }}</th>
            <th>{{ __('DESCRIPCION') }}</th>
            <th>{{ __('UNIDAD') }}</th>
            <th>{{ __('MODELO') }}</th>
            <th>{{ __('ESTADO') }}</th>
            <th>{{ __('PRIORIDAD') }}</th>
            <th>{{ __('FECHA') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($productos as $item)
                <tr>
                    <td>
                        {{$item->id}}  
                    </td>
                    <td>
                        {{ $item->name }}
                    </td>
                    <td>
                        {{ $item->categoria->name }}
                    </td>
                    <td>
                        {{ $item->marca->name }}
                    </td>
                    <td>
                        {{ $item->descripcion }}
                    </td>
                    <td>
                        {{ $item->unidad }}
                    </td>
                    <td>
                        {{ $item->modelo }}
                    </td>
                    <td>
                        {{ $item->status }}
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