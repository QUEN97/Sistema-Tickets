<table>
    <thead>
        <tr>
            <th>Agente</th>
            <th>Abiertos</th>
            <th>En proceso</th>
            <th>Cerrados</th>
            <th>Vencidos</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($tabla as $item)
            <tr>
                <td>{{$item['us']}}</td>
                <td>{{$item['datos']['abierto']}}</td>
                <td>{{$item['datos']['proceso']}}</td>
                <td>{{$item['datos']['cerrado']}}</td>
                <td>{{$item['datos']['vencido']}}</td>
            </tr>
        @endforeach
    </tbody>
</table>