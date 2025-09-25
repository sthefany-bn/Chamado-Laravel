@extends('modelo')

@section('title', 'Chamados')

@section('content')

<div class="text-center">
    <form method="get" action="">
        <button type="submit" class="btn btn-primary px-5 me-2">Chamados</button>
        <button type="submit" name="status" value="nao_iniciado" class="btn btn-secondary px-5 me-2">Não iniciado</button>
        <button type="submit" name="status" value="em_andamento" class="btn btn-warning px-5 me-2">Em andamento</button>
        <button type="submit" name="status" value="finalizado" class="btn btn-success px-5 me-2">Finalizado</button>
        <button type="submit" name="status" value="cancelado" class="btn btn-danger px-5">Cancelado</button>
    </form>
</div>

<br>

<h6 class="mb-4 ms-1">Quantidade: {{ $quantidade }}</h6>

@if ($quantidade != 0)
    <table class="table table-hover">
        <thead class="table-dark">
            <tr>
                <th>Titulo</th>
                <th>Data do pedido</th>
                <th>Autor</th>
                <th>Status</th>
                <th>Responsável</th>
                <th class="text-center">Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($chamados as $i)
            <tr>
                <td>{{ $i->titulo }}</td>
                <td>{{ $i->data->format('d/m/Y - H:i') }}</td>
                <td>{{ $i->autor->name }}</td>
                <td>
                    <p>
                        @if ($i->status == 'finalizado')
                            <span class="badge bg-success">Finalizado</span>
                        @elseif ($i->status == 'em_andamento')
                            <span class="badge bg-warning text-black">Em andamento</span>
                        @elseif ($i->status == 'cancelado')
                            <span class="badge bg-danger">Cancelado</span>
                        @elseif ($i->status == 'nao_iniciado')
                            <span class="badge bg-secondary">Não iniciado</span>
                        @endif
                    </p>
                </td>
                <td>{{ $i->responsavel->name }}</td>
                <td class="text-center">
                    <a href="{{ route('ver_detalhes', $i->id) }}" class="btn btn-sm btn-primary px-3">Detalhes</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
@else
    <div class="text-center">
        <hr><br>
        <i class="bi bi-chat-left-dots fs-1 text-danger"></i>
        <p>Nenhum chamado</p>
    </div>
@endif
@endsection