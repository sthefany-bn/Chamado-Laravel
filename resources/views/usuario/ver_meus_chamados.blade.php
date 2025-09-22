@extends('layout') {{modelo}}

@section('title', 'Meus Chamados')

@section('content')
<h1>Meus Chamados</h1>

<div class="mb-3">
    <span class="badge bg-primary">Ativos: {{ $qtd_ativos }}</span>
    <span class="badge bg-success">Finalizados: {{ $qtd_finalizados }}</span>
    <span class="badge bg-danger">Cancelados: {{ $qtd_cancelados }}</span>
</div>

<a href="{{ route('fazer_chamado') }}" class="btn btn-success mb-3">
    <i class="bi bi-plus-circle"></i> Criar Novo Chamado
</a>

@if ($chamados->isEmpty())
    <p>Você não tem chamados registrados.</p>
@else
<table class="table table-striped">
    <thead>
        <tr>
            <th>Título</th>
            <th>Status</th>
            <th>Responsável</th>
            <th>Data</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($chamados as $chamado)
        <tr>
            <td>{{ $chamado->titulo }}</td>
            <td>
                @php
                    $statusClass = match ($chamado->status) {
                        'nao_iniciado' => 'badge bg-secondary',
                        'em_andamento' => 'badge bg-warning text-dark',
                        'finalizado' => 'badge bg-success',
                        'cancelado' => 'badge bg-danger',
                        default => 'badge bg-info',
                    };
                @endphp
                <span class="{{ $statusClass }}">{{ ucfirst(str_replace('_', ' ', $chamado->status)) }}</span>
            </td>
            <td>{{ $chamado->responsavel->nome_completo ?? 'Sem responsável' }}</td>
            <td>{{ $chamado->data->format('d/m/Y H:i') }}</td>
            <td>
                <a href="{{ route('ver_detalhes', $chamado->id) }}" class="btn btn-info btn-sm" title="Ver detalhes">
                    <i class="bi bi-eye"></i>
                </a>
                <a href="{{ route('editar_chamados', $chamado->id) }}" class="btn btn-primary btn-sm" title="Editar">
                    <i class="bi bi-pencil"></i>
                </a>

                @if($chamado->status === 'nao_iniciado')
                <a href="{{ route('cancelar_chamado', $chamado->id) }}" 
                   class="btn btn-danger btn-sm" 
                   onclick="return confirm('Tem certeza que deseja cancelar este chamado?');"
                   title="Cancelar">
                    <i class="bi bi-x-circle"></i>
                </a>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endif
@endsection
