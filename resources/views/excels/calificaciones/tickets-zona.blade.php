{{-- tabla de zonas --}}
<table>
    <thead>
        <tr>
            <th colspan="6">Tickets por zona</th>
        </tr>
        <tr>
            <th style="background-color: #800000; color:white; font-weight: bold;">Zona</th>
            <th style="background-color: #800000; color:white; font-weight: bold;">Abiertos</th>
            <th style="background-color: #800000; color:white; font-weight: bold;">Cerrados</th>
            <th style="background-color: #800000; color:white; font-weight: bold;">En proceso</th>
            <th style="background-color: #800000; color:white; font-weight: bold;">Vencidos</th>
            <th style="background-color: #800000; color:white; font-weight: bold;">Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($tablaZonas as $zona)
            <tr>
                <td>{{$zona['zona']}}</td>
                <td>{{$zona['abierto']}}</td>
                <td>{{$zona['cerrado']}}</td>
                <td>{{$zona['proceso']}}</td>
                <td>{{$zona['vencido']}}</td>
                <td>{{$zona['total']}}</td>
            </tr>
        @endforeach
    </tbody>
</table>
{{-- tabla de usuarios --}}
<table>
    <thead>
        <tr>
            <th colspan="6">Tickets generados por usuario</th>
        </tr>
        <tr>
            <th style="background-color: #800000; color:white; font-weight: bold;">Usuario</th>
            <th style="background-color: #800000; color:white; font-weight: bold;">Abiertos</th>
            <th style="background-color: #800000; color:white; font-weight: bold;">Cerrados</th>
            <th style="background-color: #800000; color:white; font-weight: bold;">En proceso</th>
            <th style="background-color: #800000; color:white; font-weight: bold;">Vencidos</th>
            <th style="background-color: #800000; color:white; font-weight: bold;">Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($tablaUsers as $user)
            <tr>
                <td>{{$user['user']}}</td>
                <td>{{$user['abierto']}}</td>
                <td>{{$user['cerrado']}}</td>
                <td>{{$user['proceso']}}</td>
                <td>{{$user['vencido']}}</td>
                <td>{{$user['total']}}</td>
            </tr>
        @endforeach
    </tbody>
</table>
{{-- tabla de fallas --}}
<table>
    <thead>
        <tr>
            <th colspan="6">Tickets por falla</th>
        </tr>
        <tr>
            <th style="background-color: #800000; color:white; font-weight: bold;">Falla</th>
            <th style="background-color: #800000; color:white; font-weight: bold;">Abiertos</th>
            <th style="background-color: #800000; color:white; font-weight: bold;">Cerrados</th>
            <th style="background-color: #800000; color:white; font-weight: bold;">En proceso</th>
            <th style="background-color: #800000; color:white; font-weight: bold;">Vencidos</th>
            <th style="background-color: #800000; color:white; font-weight: bold;">Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($tablaFallas as $falla)
            <tr>
                <td>{{$falla['falla']}}</td>
                <td>{{$falla['abierto']}}</td>
                <td>{{$falla['cerrado']}}</td>
                <td>{{$falla['proceso']}}</td>
                <td>{{$falla['vencido']}}</td>
                <td>{{$falla['total']}}</td>
            </tr>
        @endforeach
    </tbody>
</table>