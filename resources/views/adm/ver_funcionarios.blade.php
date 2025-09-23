@extends('modelo')

@section('title', 'Editar')

@section('content')

<div class="text-center">
    <form method="get" action="">
        <button type="submit" class="btn btn-primary px-5">Todos</button>
        <button type="submit" name="adm" value="False" class="btn btn-warning px-4">Funcionários</button>
        <button type="submit" name="adm" value="True" class="btn btn-secondary px-3">Adiministradores</button>
    </form>
</div>

<br>

<h1 class="fw-bold">Funcionários</h1>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h6 class="mb-0">Quantidade: {{ $quantidade }}</h6>
</div>

@if ($quantidade != 0)
    <table class="table table-hover">
        <thead class="table-dark">
            <tr>
                <th>Nome Completo</th>
                <th>Username</th>
                <th>Tipo</th>
                <th class="text-center">Ação</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($perfil as $i)
            <tr>
                <td>{{$i->nome_completo}}</td>
                <td>{{$i->user->username}}</td>
                <td>@if ($i->adm) Adiministrador @else Funcionário @endif</td>
                <td class="text-center">
                    <a href="{{ route('editar_funcionarios', $i->id) }}" class="btn btn-sm btn-success px-3">Editar</a>
                    <a href="{{ route('tornar_adm', $i->id) }}" class="btn btn-sm btn-warning" onclick="return confirmarAdm('{{ $i->nome_completo }}');">Permição de Adm</a>
                    <a href="{{ route('retirar_adm', $i->id) }}" class="btn btn-sm btn-danger" onclick="return confirmarRemoverAdm('{{ $i->nome_completo }}');">Tirar permição de Adm</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
@else
    <div class="text-center">
        <hr><br>
        <i class="bi bi-person-fill-slash fs-1 text-danger"></i>
        <p>Nenhum funcionários cadastrado alem de você</p>
    </div>
@endif

<script>
    function confirmarAdm(nome) {
        return confirm(`Tem certeza que deseja tornar o "${nome}" em administrador?`);
    }
    function confirmarRemoverAdm(nome) {
        return confirm(`Tem certeza que deseja remover a permição de administrador do "${nome}"?`);
    }
</script>

@endsection