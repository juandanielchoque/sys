<style>
    body{
        font-family: sans-serif
    }
    h1{
        text-align: center;
        font-size: 28px;
    }
    table {
        border-collapse: collapse;
        width: 100%;
    }

    th,
    td {
        text-align: left;
        padding: 8px;
    }

    th {
        background-color: #f2f2f2;
        color: #000000;
    }

    tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    tr:hover {
        background-color: #dddddd;
    }

    p {
        margin-top: 20px;
        text-align: right;
        font-size: 12px;
    }
</style>
<h1>REPORTE DE ASISTENCIAS</h1>
<table>
    <thead>
        <tr>
            <th>CLIENTE</th>
            <th>FECHA</th>
            <th>MARCADO POR</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($datos as $item)
            <tr>
                <td>{{ $item->nombre }}</td>
                <td>{{ $item->fecha_hora }}</td>
                <td>{{ $item->marcado_por }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
<p>Generado el {{ date('d-m-Y H:i:s') }}</p>
