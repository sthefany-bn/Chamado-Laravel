@extends('modelo')

@section('title', 'Editar Funcionários')

@section('content')
<div class="container d-flex justify-content-center mt-5">
    <div class="card p-4" style="max-width: 500px; width: 100%;">
        <h2 class="fw-bold mb-4 text-center">Editando Funcionário</h2>
        <form action="{{ route('atualizar_funcionarios', $perfil->id) }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Nome completo</label>
                <input type="text" name="nome_completo" class="form-control" value="{{ old('nome_completo', $perfil->nome_completo) }}" placeholder="Digite o nome" required>
            </div>
            <div class="mb-4">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control" value="{{ old('username', $perfil->user->username) }}" placeholder="Digite o nome" required>
            </div>
            <div class="d-flex justify-content-between">
                <button type="button" class="btn btn-danger px-3" onclick="history.back()">Cancelar</button>
                <button type="submit" class="btn btn-success px-3">Atualizar</button>
            </div>
        </form>
    </div>
</div>
@endsection
