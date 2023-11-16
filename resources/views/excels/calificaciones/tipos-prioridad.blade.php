@foreach ($tablas as $tabla)
    <table>
        <thead>
            <tr>
                <th colspan="6">{{$tabla['tipo']}}</th>
            </tr>
            <tr>
                <th style="background-color: #800000; color:white; font-weight: bold;">Prioridad</th>
                <th style="background-color: #800000; color:white; font-weight: bold;">Abiertos</th>
                <th style="background-color: #800000; color:white; font-weight: bold;">En proceso</th>
                <th style="background-color: #800000; color:white; font-weight: bold;">Cerrados</th>
                <th style="background-color: #800000; color:white; font-weight: bold;">Vencidos</th>
                <th style="background-color: #800000; color:white; font-weight: bold;">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tabla['data'] as $item)    
                <tr>
                    <td>{{$item['prioridad']}}</td>
                    <td>{{$item['abiertos']}}</td>
                    <td>{{$item['cerrados']}}</td>
                    <td>{{$item['procesos']}}</td>
                    <td>{{$item['vencidos']}}</td>
                    <td>{{$item['total']}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endforeach