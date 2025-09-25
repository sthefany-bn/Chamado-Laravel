@extends('modelo')

@section('title', 'Detalhes do Chamado')

@section('content')
<div class="container d-flex justify-content-center mb-5">
    <div class="card p-4" style="max-width: 800px; width: 100%;">
        <h2 class="mb-2 fw-bold">
            <i class="bi bi-ticket-detailed-fill text-primary me-2"></i>
            Chamado: {{ $chamado->titulo }}
        </h2>
        <div class="mb-3">
            <small class="text-muted">
                <i class="bi bi-calendar-event me-1"></i>
                Criado em {{ $chamado->data->format('d/m/Y - H:i') }}
            </small>
        </div>
        <hr>
        <div class="mb-3">
            <p class="fw-bold">Status:
                @if ($chamado->status == 'finalizado')
                    <span class="badge bg-success">Finalizado</span>
                @elseif ($chamado->status == 'em_andamento')
                    <span class="badge bg-warning text-black">Em andamento</span>
                @elseif ($chamado->status == 'cancelado')
                    <span class="badge bg-danger">Cancelado</span>
                @elseif ($chamado->status == 'nao_iniciado')
                    <span class="badge bg-secondary">Não iniciado</span>
                @endif
            </p>
        </div>
        <div class="mb-3">
            <h6 class="fw-bold">
                <i class="bi bi-file-text me-1"></i>
                Descrição:
            </h6>
            <p>{{ $chamado->descricao }}</p>
        </div>
        <div class="row">
            <div class="col-md-6">
                <h6 class="fw-bold">
                    <i class="bi bi-person-fill me-1"></i>
                    Autor:
                </h6>
                <p>{{ $chamado->autor->name }}</p>
            </div>
            <div class="col-md-6">
                <h6 class="fw-bold">
                    <i class="bi bi-person-badge-fill me-1"></i>
                    Responsável:
                </h6>
                <p>{{ $chamado->responsavel->name }}</p>
            </div>
        </div>
        <div class="mb-3">
            <h6 class="fw-bold mb-3">
                <i class="bi bi-paperclip me-1"></i>
                Arquivos:
            </h6>
            @if ($chamado->arquivos && $chamado->arquivos->count() > 0)
                <div class="list-group m-2">
                    @foreach ($chamado->arquivos as $i)
                        <div class="list-group-item d-flex align-items-center gap-2">
                            <img src="{{ asset('storage/' . $i->arquivo) }}" class="img-thumbnail" style="width: 60px; height: 60px; object-fit: cover;">
                            <a href="{{ asset('storage/' . $i->arquivo) }}" target="_blank" class="text-decoration-none">
                                {{ $i->nome_original ?? 'Arquivo' }}
                            </a>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-muted">Nenhum arquivo anexado.</p>
            @endif
        </div>
        <div class="text-end">
            <button class="btn btn-danger" onclick="history.back()">Voltar</button>
        </div>
    </div>
</div>
@endsection
