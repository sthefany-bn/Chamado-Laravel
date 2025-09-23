@extends('modelo')

@section('title', 'Detalhes do Chamado')

@section('content')
<div class="container py-4">
    <div class="border rounded p-4 shadow-sm bg-white">
        <h2 class="mb-2 fw-bold">Chamado: {{ $chamado->titulo }}</h2>
        <div class="mb-3">
            <small class="text-muted">
                Criado em {{ $chamado->data }}
            </small>
        </div>
        <hr>
        <div class="mb-3">
            <p>Status:
                @if ($chamado->status === 'finalizado')
                    <span class="badge bg-success">{{ $chamado->status }}</span>
                @elseif ($chamado->status === 'em_andamento')
                    <span class="badge bg-warning text-black">{{ $chamado->status }}</span>
                @elseif ($chamado->status === 'cancelado')
                    <span class="badge bg-danger">{{ $chamado->status }}</span>
                @else
                    <span class="badge bg-secondary">{{ $chamado->status }}</span>
                @endif
            </p>
        </div>
        <div class="mb-3">
            <h6 class="fw-bold">Descrição:</h6>
            <p>{{ $chamado->descricao }}</p>
        </div>
        <div class="row">
            <div class="col-md-6">
                <h6 class="fw-bold">Autor:</h6>
                <p>{{ $chamado->autor->name }}</p>
            </div>
            <div class="col-md-6">
                <h6 class="fw-bold">Responsável:</h6>
                <p>{{ $chamado->responsavel->name }}</p>
            </div>
        </div>
        <div class="mb-3">
            <h6 class="fw-bold mb-2">Arquivos:</h6>
            @if ($chamado->arquivos && $chamado->arquivos->count() > 0)
                <div class="list-group">
                    @foreach ($chamado->arquivos as $i)
                        <div class="list-group-item d-flex align-items-center gap-3">
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
