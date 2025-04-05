<table >
    <thead>
        <tr>
            <th>Tipo Linea</th>
            <th>N°.Linea</th>
            <th>De Estaca</th>
            <th>De metros+</th>
            <th>A Estaca</th>
            <th>A metros+</th>
            <th>Afectación</th>
            <th>m</th>
            <th>m2</th>
            <th>Km</th>
            <th>ha</th>
            <th>Costo Cultivo</th>
            <th>Monto Base</th> 
        </tr>
    </thead>
    <tbody>
        <!-- //TODO COLOCAR EL TIPO DE LINEA EN LUGAR DE EL ID Y DAR FOMATO A LAS CELDAS (CENTRAR ) -->
        

       
     

        @foreach($datos['detalles'] as $detail)
                @php
                $precioHectarea = $detail['afectacion']['precioHectarea'];
                $ha=$detail['ha'];
                $montoBase=$precioHectarea*$ha;
            @endphp

        
    


            <tr>
                <td>{{ $detail['tipoLinea'] }}</td>
                <td>{{ $detail['linea'] }}</td>
                <td>{{ $detail['estacaIni'] }}</td>
                <td>{{ $detail['mtsIni']??'' }}</td>
                <td>{{ $detail['estacaFin'] }}</td>
                <td>{{ $detail['mtsFin'] }}</td>
                <td>{{ $detail['afectacion']['cultivo'] }}</td>
                <td>{{ $detail['metros'] }}</td>
                <td>{{ $detail['metros2'] }}</td>
                <td>{{ $detail['km'] }}</td>
                <td>{{$ha}}</td>
                <td>${{ number_format($precioHectarea, 2, '.', ',')}}</td>
                <td>${{number_format($montoBase, 2, '.', ',')}}</td>
            </tr>
    

    
        @endforeach

    </tbody>
</table>