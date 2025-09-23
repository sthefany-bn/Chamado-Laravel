<!doctype html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Sistema de Chamados')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>
    <header>
        <nav class="navbar bg-primary">
            <div class="container-fluid">
                @if (Auth::user() && Auth::user()->perfil->adm)
                <a href="{{ route('ver_chamados') }}" class="navbar-brand fw-bold text-white">
                    Chamados - Usuário Master
                </a>
                @else
                <a href="{{ route('meus_chamados') }}" class="navbar-brand fw-bold text-white">
                    Chamados
                </a>
                @endif
                <div class="d-flex">
                    @if (Auth::user() && Auth::user()->perfil->adm)
                    <div class="dropdown">
                        <a href="#" class="btn btn-light fw-bold dropdown-toggle me-1" data-bs-toggle="dropdown">
                            Ações Adm
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="{{ route('ver_chamados') }}">
                                    <i class="bi bi-card-list me-2 text-info"></i>Todos chamados
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('ver_funcionarios') }}">
                                    <i class="bi bi-people-fill me-2 text-warning"></i>Funcionários
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('ver_minhas_tarefas') }}">
                                    <i class="bi bi-clipboard2-check-fill me-2 text-success"></i>Minhas tarefas
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('meus_chamados') }}">
                                    <i class="bi bi-person-lines-fill me-2 text-primary"></i>Meus chamados
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('fazer_chamado') }}">
                                    <i class="bi bi-plus-circle me-2 text-black"></i> Criar chamado
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('editar_funcionarios', Auth::id()) }}">
                                    <i class="bi bi-pencil-square me-2 text-danger"></i>Editar meu perfil
                                </a>
                            </li>
                        </ul>
                    </div>
                    @endif
                    @auth
                    <form action="{{ route('sair') }}" method="POST" onsubmit="return confirmarSair('{{ Auth::user()->name }}');">
                        @csrf
                        <button type="submit" class="btn btn-light fw-bold me-1">Sair</button>
                    </form>
                    @endauth
                </div>
            </div>
        </nav>
    </header>

    <main class="container mt-4">
        {{-- Mensagens de sucesso, erro, etc --}}
        @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        {{-- Conteúdo da página --}}
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function confirmarSair(nome) {
            return confirm(`"${nome}" tem certeza que deseja sair?`);
        }
    </script>

</body>

</html>