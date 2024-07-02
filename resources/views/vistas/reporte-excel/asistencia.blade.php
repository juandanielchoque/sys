<table>
    <thead>
        <tr>
            <th>CLIENTE</th>
            <th>FECHA</th>
            <th>MARCADO POR</th>
        </tr>
    </thead>
    <tbody>
        @foreach($asistencia as $item)
        <tr>
            <td>{{ $item->nombre }}</td>
            <td>{{ $item->fecha_hora }}</td>
            <td>{{ $item->marcado_por }}</td>
        </tr>
        @endforeach
    </tbody>
</table>