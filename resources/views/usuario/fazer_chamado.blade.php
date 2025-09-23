@extends('modelo')

@section('title', 'Chamado')

@section('content')
<div class="container d-flex justify-content-center mt-2">
    <div class="card p-4" style="max-width: 600px; width: 100%;">
        <h2 class="fw-bold mb-4 text-center">Abrir um Chamado</h2>
        <form action="{{ route('fazer_chamado') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label class="form-label">Título</label>
                <input type="text" name="titulo" class="form-control" placeholder="Digite o título" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Descrição</label>
                <textarea name="descricao" class="form-control" rows="5" placeholder="Descreva o problema..." required></textarea>
            </div>
            <div class="mb-4">
                <select name="responsavel" class="form-select" required>
                    <option value="" disabled selected>Selecione um responsável pelo chamado</option>
                    @foreach ($perfis as $i)
                        <option value="{{ $i->id }}">{{ $i->nome_completo }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Adicione arquivos:</label>
                <input type="file" id="fileInput" name="arquivos[]" class="form-control" multiple/>
                <ul id="fileLista" class="mt-2 list-group"></ul>
            </div>
            <div class="d-flex justify-content-between">
                <a href="{{ route('meus_chamados') }}" class="btn btn-danger px-3">Cancelar</a>
                <button type="submit" class="btn btn-success px-3">Cadastrar</button>
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
            // Verifica se o arquivo já foi adicionado para evitar duplicatas
            let exists = false;
            for (let i = 0; i < dataTransfer.items.length; i++) {
                if (dataTransfer.items[i].getAsFile().name === file.name) {
                    exists = true;
                    break;
                }
            }
            if (!exists) {
                dataTransfer.items.add(file);

                const li = document.createElement('li');
                li.className = 'list-group-item d-flex justify-content-between align-items-center';
                li.textContent = file.name;

                const removeBtn = document.createElement('button');
                removeBtn.textContent = 'Remover';
                removeBtn.className = 'btn btn-sm btn-danger';

                removeBtn.onclick = () => {
                    for (let i = 0; i < dataTransfer.items.length; i++) {
                        if (dataTransfer.items[i].getAsFile().name === file.name) {
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
        }
        fileInput.files = dataTransfer.files;
    });
</script>
@endsection
