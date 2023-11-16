@foreach ($tablas as $tabla)
    <table>
        <thead>
            <tr>
                <th colspan="6">{{$tabla['serv']}}</th>
            </tr>
            <tr>
                <th style="background-color: #800000; color:white; font-weight: bold; text-align:center">FALLA</th>
                <th style="background-color: #800000; color:white; font-weight: bold; text-align:center">ABIERTOS</th>
                <th style="background-color: #800000; color:white; font-weight: bold; text-align:center">EN PROCESO</th>
                <th style="background-color: #800000; color:white; font-weight: bold; text-align:center">CERRADOS</th>
                <th style="background-color: #800000; color:white; font-weight: bold; text-align:center">VENCIDOS</th>
                <th style="background-color: #800000; color:white; font-weight: bold; text-align:center">TOTAL</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tabla['fallas'] as $item)
                <tr>
                    <td>{{$item['falla']}}</td>
                    <td>{{$item['datos']['abierto']}}</td>
                    <td>{{$item['datos']['proceso']}}</td>
                    <td>{{$item['datos']['cerrado']}}</td>
                    <td>{{$item['datos']['vencido']}}</td>
                    <td>{{$item['datos']['total']}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endforeach