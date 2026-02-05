@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Panel de Control - Biblioteca</h1>
@stop

@section('content')
    <div class="row">
        {{-- Caja para Autores --}}
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $totalAuthors ?? 0 }}</h3>
                    <p>Autores Registrados</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
                <a href="#" class="small-box-footer">Ver más <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        {{-- Caja para Libros --}}
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $totalBooks ?? 0 }}</h3>
                    <p>Libros Totales</p>
                </div>
                <div class="icon">
                    <i class="fas fa-book"></i>
                </div>
                <a href="#" class="small-box-footer">Ver más <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Bienvenido al Sistema</h3>
                </div>
                <div class="card-body">
                    <p>
                        La automatización está activa:
                        <ul>
                            <li><strong>Observer:</strong> Monitoreando cambios en libros.</li>
                            <li><strong>Jobs:</strong> Sincronizando el conteo de autores en segundo plano.</li>
                        </ul>
                    </p>
                </div>
            </div>
        </div>
    </div>
@stop