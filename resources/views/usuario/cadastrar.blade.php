@extends('modelo')

@section('title', 'Cadastrar')

@section('content')
<div class="d-flex justify-content-center">
    <div class="card p-4" style="max-width: 850px; width: 100%;">
        <br>
        <div class="text-center">
            <ul class="nav nav-pills nav-justified mb-3">
                <li class="nav-item">
                    <a class="nav-link bg-light me-1" href="{{ route('login') }}">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active ms-1" href="{{ route('cadastrar') }}">Cadastrar</a>
                </li>
            </ul>
        </div>
        <br>
        <div class="d-flex justify-content-center">
            <div class="w-50">
                <h2 class="fw-bold mb-4 text-center">Cadastro</h2>
                <form action="{{ route('cadastrar') }}" method="POST">
                    @csrf
                    <label class="mb-1">Nome completo:</label>
                    <input type="text" name="nome" class="form-control" placeholder="Digite seu nome completo">
                    <br>
                    <label class="mb-1">Username:</label>
                    <input type="text" name="username" class="form-control" placeholder="Crie seu username">
                    <br>
                    <label class="mb-1">Senha:</label>
                    <input type="password" name="password" class="form-control" placeholder="Crie uma senha segura">
                    <br>
                    <div class="d-grid gap-2 text-center">
                        <button type="submit" class="btn btn-success">Cadastrar</button>
                    </div>
                </form>
            </div>
        </div>
        <br><br>
    </div>
</div>
@endsection
