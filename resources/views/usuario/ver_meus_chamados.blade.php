@extends('modelo')

@section('title', 'Meus Chamados')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="fw-bold mb-0">Chamados de <span class="text-primary">{{ $perfil->nome_completo }}</span></h1>
    <a href="{{ route('fazer_chamado') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-1"></i>
        Novo
    </a>
</div>
<hr>

@if ($ativos || $cancelados || $finalizados)
    @if ($ativos)
        <div class="d-flex align-items-center mb-3">
            <i class="bi bi-lightning-charge-fill me-2 fs-3 text-warning"></i>
            <h3 class="fw-bold mb-0">Ativos</h3>
        </div>
        <table class="table table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Titulo</th>
                    <th>Data do pedido</th>
                    <th>Responsável</th>
                    <th>Status</th>
                    <th class="text-center">Ação</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($chamados as $i)
                    @if ($i->status != 'finalizado' && $i->status != 'cancelado')
                        <tr>
                            <td>{{ $i->titulo }}</td>
                            <td>{{ $i->data->format('d/m/Y H:i') }}</td>
                            <td>{{ $i->responsavel->name }}</td>
                            <td>
                                @if ($i->status == 'em_andamento')
                                    <span class="badge bg-warning text-black">Em andamento</span>
                                @elseif ($i->status == 'nao_iniciado')
                                    <span class="badge bg-secondary">Não iniciado</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('editar_chamados', $i->id) }}" class="btn btn-sm btn-success">Editar</a>
                                <a href="{{ route('ver_detalhes', $i->id) }}" class="btn btn-sm btn-primary px-3">Detalhes</a>                                
                                <form action="{{ route('cancelar_chamado', $i->id) }}" method="post" class="d-inline"
                                    onsubmit="return confirmarCancelar('{{ $i->titulo }}');">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-danger">Cancelar</button>
                                </form>
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    @else
        <div class="text-center">
            <i class="bi bi-exclamation-circle fs-1 text-muted"></i>
            <p>Nenhum chamado ativo</p>
            <a class="btn btn-sm btn-success" href="{{ route('fazer_chamado') }}">Fazer chamado</a>
        </div>
        <hr>
    @endif

    @if ($finalizados)
        <div class="d-flex align-items-center mb-3">
            <i class="bi bi-clipboard2-check me-2 fs-3 text-success"></i>
            <h3 class="fw-bold mb-0">Finalizados</h3>
        </div>
        <table class="table table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Titulo</th>
                    <th>Data do pedido</th>
                    <th>Responsável</th>
                    <th>Status</th>
                    <th class="text-center">Ação</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($chamados as $i)
                    @if ($i->status == 'finalizado')
                        <tr>
                            <td>{{ $i->titulo }}</td>
                            <td>{{ $i->data->format('d/m/Y H:i') }}</td>
                            <td>{{ $i->responsavel->name }}</td>
                            <td>
                                <span class="badge bg-success">Finalizado</span>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('ver_detalhes', $i->id) }}" class="btn btn-sm btn-primary px-3">Detalhes</a>                                
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    @endif
    
    @if ($cancelados)
        <div class="d-flex align-items-center mb-3">
            <i class="bi bi-x-octagon-fill me-2 fs-3 text-danger"></i>
            <h3 class="fw-bold mb-0">Cancelados</h3>
        </div>
        <table class="table table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Titulo</th>
                    <th>Data do pedido</th>
                    <th>Responsável</th>
                    <th>Status</th>
                    <th class="text-center">Ação</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($chamados as $i)
                    @if ($i->status == 'cancelado')
                        <tr class="text-decoration-line-through text-muted">
                            <td>{{ $i->titulo }}</td>
                            <td>{{ $i->data->format('d/m/Y H:i') }}</td>
                            <td>{{ $i->responsavel->name }}</td>
                            <td>
                                <span class="badge bg-danger">Cancelado</span>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('ver_detalhes', $i->id) }}" class="btn btn-sm btn-primary px-3">Detalhes</a>                                
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    @endif
@else
    <div class="text-center">
        <br>
        <i class="bi bi-inbox-fill fs-1 text-secondary"></i>
        <p>Nenhum chamado cadastrado</p>
        <a class="btn btn-sm btn-success" href="{{ route('fazer_chamado') }}">Fazer chamado</a>
    </div>
@endif

<script>
    function confirmarCancelar(nome) {
        return confirm(`Tem certeza que deseja cancelar o chamado "${nome}"?`);
    }
</script>
@endsection
