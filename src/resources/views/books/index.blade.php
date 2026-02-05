@extends('adminlte::page')

@section('title', 'Listado de Libros')

@section('content_header')
    <h1>Gestión de Libros</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Libros Registrados</h3>
            <div class="card-tools">
                <button class="btn btn-primary btn-sm">Nuevo Libro</button>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Título</th>
                        <th>Autor</th>
                        <th>ISBN</th>
                        <th>Año</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($books as $book)
                    <tr>
                        <td>{{ $book['id'] }}</td>
                        <td>{{ $book['title'] }}</td>
                        <td>{{ $book['author']['name'] ?? 'Sin autor' }}</td>
                        <td>{{ $book['isbn'] }}</td>
                        <td>{{ $book['year'] }}</td>
                        <td>
                            <button class="btn btn-xs btn-info">Editar</button>
                            <button class="btn btn-xs btn-danger">Borrar</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="card-footer clearfix">
            <button id="exportExcel" class="btn btn-success float-right">
                <i class="fas fa-file-excel"></i> Exportar a Excel
            </button>
        </div>

    </div>

    <script>
document.getElementById('exportExcel').addEventListener('click', function() {
    // Obtenemos la tabla de libros
    var table = document.querySelector(".table"); // Asegúrate de que tu tabla tenga esta clase
    var html = table.outerHTML;

    // Creamos un Blob con el contenido HTML y el tipo MIME de Excel
    var url = 'data:application/vnd.ms-excel;charset=utf-8,' + encodeURIComponent(html);
    
    // Creamos un link temporal para descargar el archivo
    var downloadLink = document.createElement("a");
    downloadLink.href = url;
    downloadLink.download = "listado_libros.xls";

    document.body.appendChild(downloadLink);
    downloadLink.click();
    document.body.removeChild(downloadLink);
});
</script>

@stop