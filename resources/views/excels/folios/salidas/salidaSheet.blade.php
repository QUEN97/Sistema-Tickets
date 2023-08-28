@foreach ($folio as $salida)        
<table style="border-collapse:collapse;">   
    <thead>
        <tr>
            <th colspan="6" style="background-color: #c90000; color:white;">Salida #{{$salida->id}}</th>
            
        </tr>
        <tr>
            <th colspan="6" style="background-color: #c90000; color:white;border:2px;">Motivo: {{$salida->motivo}}</th>
            
        </tr>
        <tr>
            <th>No. de ticket</th>
            <th>Estación</th>
            <th>Producto</th>
            <th>Cantidad</th>
            <th>Observación</th>
            <th>Fecha de registro en el sistema</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($salida->productos as $producto)
            <tr>
                <th>{{isset($producto->ticket->id)?'#'.$producto->ticket->id : 'S/N'}}</th>
                <th>{{isset($producto->estacion->name)?$producto->estacion->name : 'S/N'}}</th>
                <th>{{$producto->producto->name}}</th>
                <th>{{$producto->cantidad}}</th>
                <th>{{$producto->observacion}}</th>
                <th>{{$producto->created_at}}</th>
            </tr>
        @endforeach
    </tbody>
</table>
@endforeach