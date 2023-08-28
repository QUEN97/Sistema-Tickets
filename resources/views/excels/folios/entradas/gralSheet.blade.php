<table>
    <thead>
        <tr>
            <th>No. de ticket</th>
            <th>Estación</th>
            <th>Producto</th>
            <th>Cantidad</th>
            <th>Usuario</th>
            <th>Observación</th>
            <th>Fecha de registro</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($folio->entradas as $entrada)
            @foreach ($entrada->productos as $producto)
                <tr>
                    <th>{{isset($producto->ticket->id)?$producto->ticket->id : 'S/N'}}</th>
                    <th>{{isset($producto->estacion->name)?$producto->estacion->name : 'S/N'}}</th>
                    <th>{{$producto->producto->name}}</th>
                    <th>{{$producto->cantidad}}</th>
                    <th>{{$entrada->usuario->name}}</th>
                    <th>{{$producto->observacion}}</th>
                    <th>{{$producto->created_at}}</th>
                </tr>
            @endforeach
        @endforeach
    </tbody>
</table>