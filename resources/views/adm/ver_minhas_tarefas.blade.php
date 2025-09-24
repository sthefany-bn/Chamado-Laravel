@extends('modelo')

@section('title', 'Tarefas')

@section('content')

<h1 class="fw-bold">Minhas Tarefas</h1>
<hr>
@if ($chamadosAtivos->count() != 0)
    <div class="d-flex align-items-center mb-1">
        <i class="bi bi-lightning-charge-fill me-2 fs-3 text-warning"></i>
        <h3 class="fw-bold mb-0">Ativos</h3>
    </div>
    <h6 class="m-2 mb-3">Quantidade: {{ $chamadosAtivos->count() }}</h6>
    <table class="table table-hover">
        <thead class="table-dark">
            <tr>
                <th>Titulo</th>
                <th>Data do pedido</th>
                <th>Autor</th>
                <th>Status</th>
                <th class="text-center">Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($chamadosAtivos as $i)
                <tr>
                    <td>{{ $i->titulo }}</td>
                    <td>{{ $i->data->format('d/m/Y H:i') }}</td>
                    <td>{{ $i->autor->name }}</td>
                    <td>
                        @if ($i->status == 'em_andamento')
                            <span class="badge bg-warning text-black">Em andamento</span>
                        @elseif ($i->status == 'nao_iniciado')
                            <span class="badge bg-secondary">Não iniciado</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <a href="{{ route('ver_detalhes', $i->id) }}" class="btn btn-sm btn-primary px-3">Detalhes</a>
                        <div class="btn-group">
                            <button class="btn btn-sm btn-warning px-3">
                                <a href="{{ route('ifc', ['id' => $i->id, 'status' => 'em_andamento']) }}" class="text-black text-decoration-none"
                                    onclick="return confirmarIniciar('{{ $i->titulo }}');">
                                    Iniciar
                                </a>
                            </button>
                            <button class="btn btn-sm btn-success">
                                <a href="{{ route('ifc', ['id' => $i->id, 'status' => 'finalizado']) }}" class="text-white text-decoration-none"
                                    onclick="return confirmarFinalizar('{{ $i->titulo }}');">
                                    Finalizar
                                </a>
                            </button>
                            <button class="btn btn-sm btn-danger">
                                <a href="{{ route('ifc', ['id' => $i->id, 'status' => 'cancelado']) }}" class="text-white text-decoration-none"
                                    onclick="return confirmarCancelar('{{ $i->titulo }}');">
                                    Cancelar
                                </a>
                            </button>
                        </div>
                    </td>
                </tr> 
            @endforeach
        </tbody>
    </table>
@else
    <div class="text-center">
        <hr><br>
        <i class="bi bi-folder-x fs-1 text-danger"></i>
        <p>Nenhum chamado ativo para você</p>
    </div>
@endif

<br>
@if ($chamadosInativos->count() != 0)
    <div class="d-flex align-items-center mb-1">
    <i class="bi bi-pause-circle me-2 fs-3 text-danger"></i>
        <h3 class="fw-bold mb-0">Inativos</h3>
    </div>
    <h6 class="m-2 mb-3">Quantidade: {{ $chamadosInativos->count() }}</h6>
    <table class="table table-hover">
        <thead class="table-dark">
            <tr>
                <th>Titulo</th>
                <th>Data do pedido</th>
                <th>Autor</th>
                <th>Status</th>
                <th class="text-center">Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($chamadosInativos as $i)
                <tr>
                    <td>{{ $i->titulo }}</td>
                    <td>{{ $i->data->format('d/m/Y H:i') }}</td>
                    <td>{{ $i->autor->name }}</td>
                    <td>
                        @if ($i->status == 'finalizado')
                            <span class="badge bg-success">Finalizado</span>
                        @elseif ($i->status == 'cancelado')
                            <span class="badge bg-danger">Cancelado</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <a href="{{ route('ver_detalhes', $i->id) }}" class="btn btn-sm btn-primary px-3">Detalhes</a>
                        <button class="btn btn-sm btn-warning px-3">
                            <a href="{{ route('ifc', ['id' => $i->id, 'status' => 'em_andamento']) }}" class="text-black text-decoration-none"
                                onclick="return confirmarReiniciar('{{ $i->titulo }}');">
                                Reiniciar
                            </a>
                        </button>
                    </td>
                </tr> 
            @endforeach
        </tbody>
    </table>
@endif


<script>
    function confirmarIniciar(nome) {
        return confirm(`Tem certeza que deseja iniciar a tarefa "${nome}"?`);
    }
    function confirmarReiniciar(nome) {
        return confirm(`Tem certeza que deseja reiniciar a tarefa "${nome}"?`);
    }
    function confirmarFinalizar(nome) {
        return confirm(`Tem certeza que deseja finalizar a tarefa "${nome}"?`);
    }
    function confirmarCancelar(nome) {
        return confirm(`Tem certeza que deseja cancelar a tarefa "${nome}"?`);
    }
</script>

@endsection