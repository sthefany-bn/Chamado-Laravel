@extends('modelo')

@section('title', 'Editar Chamado')

@section('content')
<div class="container d-flex justify-content-center mb-5">
    <div class="card p-4" style="max-width: 600px; width: 100%;">
        <h2 class="fw-bold mb-4 text-center">Editando Chamado</h2>

        <form action="{{ route('editar_chamados', $chamado->id) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label class="form-label">Título</label>
                <input type="text" name="titulo" class="form-control" value="{{ $chamado->titulo }}"
                    placeholder="Digite o título" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Descrição</label>
                <textarea name="descricao" class="form-control" rows="5" placeholder="Descreva o problema..." required>{{ $chamado->descricao }}</textarea>
            </div>

            <div class="mb-4">
                <label class="form-label">Responsável</label>
                <select name="responsavel" class="form-select" required>
                    <option value="" disabled>Selecione um responsável</option>
                    @foreach ($perfis as $perfil)
                        <option value="{{ $perfil->id }}" {{ $perfil->id == $chamado->responsavel_id ? 'selected' : '' }}>
                            {{ $perfil->nome_completo }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Arquivos já anexados:</label>
                @if ($chamado->arquivos && $chamado->arquivos->count() > 0)
                    <div class="list-group">
                        @foreach ($chamado->arquivos as $i)
                            <div class="list-group-item d-flex align-items-center gap-3">
                                <img src="{{ asset('storage/' . $i->arquivo) }}" class="img-thumbnail" style="width: 60px; height: 60px; object-fit: cover;">
                                <a href="{{ asset('storage/' . $i->arquivo) }}" target="_blank" class="text-decoration-none">
                                    {{ $i->nome_original ?? 'Arquivo' }}
                                </a>
                                <div class="ms-auto">
                                    <a href="{{ route('remover_arquivo', $i->id) }}" class="btn btn-sm btn-outline-danger">Remover</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-muted">Nenhum arquivo anexado.</p>
                @endif
            </div>

            <div class="mb-3">
                <label class="form-label">Anexar novos arquivos:</label>
                <input type="file" name="arquivos[]" id="fileInput" class="form-control" multiple>
                <ul id="fileLista" class="mt-2 list-group"></ul>
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('meus_chamados') }}" class="btn btn-danger px-3">Cancelar</a>
                <button type="submit" class="btn btn-success px-3">Atualizar</button>
            </div>
        </form>
    </div>
</div>

<script>
    const fileInput = document.getElementById('fileInput');
    const fileLista = document.getElementById('fileLista');
    const dataTransfer = new DataTransfer();

    fileInput.addEventListener('change', function () {
        for (const file of this.files) {
            dataTransfer.items.add(file);
            const li = document.createElement('li');
            li.className = 'list-group-item d-flex justify-content-between align-items-center';
            li.textContent = file.name;

            const removeBtn = document.createElement('button');
            removeBtn.textContent = 'Remover';
            removeBtn.className = 'btn btn-sm btn-danger';
            removeBtn.onclick = () => {
                for (let i = 0; i < dataTransfer.items.length; i++) {
                    if (dataTransfer.items[i].getAsFile().name == file.name) {
                        dataTransfer.items.remove(i);
                        break;
                    }
                }
                fileInput.files = dataTransfer.files;
                li.remove();
            };

            li.appendChild(removeBtn);
            fileLista.appendChild(li);
        }

        fileInput.files = dataTransfer.files;
    });
</script>
@endsection
