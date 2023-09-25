<table>
    <thead>
        <tr>
            <th>Usuario</th>
            <th>Puntos positivos</th>
            <th>Puntos negativos</th>
            <th>Total de puntos</th>
            <th>Calificación</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($grupos as $grupo)
            @foreach ($grupo as $user)
                <tr>
                    <td>{{$user['user']}}</td>
                    <td>{{$user['pos']}}</td>
                    <td>{{$user['neg']}}</td>
                    <td>{{$user['total']}}</td>
                    <td>{{number_format($user['cal'],1)}}</td>
                </tr>
            @endforeach
        @endforeach
    </tbody>
</table>