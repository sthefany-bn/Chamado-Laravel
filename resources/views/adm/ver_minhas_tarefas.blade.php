@extends('modelo')

@section('title', 'Editar')

@section('content')
<h1 class="fw-bold">Tarefas ativas</h1>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h6 class="m-1">Quantidade: {{ $quantidade }}</h6>
</div>

@if ($quantidade != 0)
    <table class="table table-hover">
        <thead class="table-dark">
            <tr>
                <th>Titulo</th>
                <th>Data do pedido</th>
                <th>Status</th>
                <th class="text-center">Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($chamados as $i)  
                <tr>
                    <td>{{ $i->titulo }}</td>
                    <td>{{ $i->data }}</td>
                    <td>
                        @if ($i->status == 'finalizado')
                            <span class="badge bg-success">{{ $i->status }}</span>
                        @elseif ($i->status == 'em_andamento')
                            <span class="badge bg-warning text-black">{{ $i->status }}</span>
                        @else
                            <span class="badge bg-secondary">{{ $i->status }}</span>
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
        <p>Nenhum chamado cadastrada para você</p>
    </div>
@endif

<script>
    function confirmarIniciar(nome) {
        return confirm(`Tem certeza que deseja iniciar a tarefa "${nome}"?`);
    }
    function confirmarFinalizar(nome) {
        return confirm(`Tem certeza que deseja finalizar a tarefa "${nome}"?`);
    }
    function confirmarCancelar(nome) {
        return confirm(`Tem certeza que deseja cancelar a tarefa "${nome}"?`);
    }
</script>

@endsection