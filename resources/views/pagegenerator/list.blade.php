<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Lista de Páginas</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h1 class="mb-4">Lista de Páginas Criadas</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Slug</th>
                <th>Data de Criação</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pages as $page)
                <tr>
                    <td>{{ $page->id }}</td>
                    <td>{{ $page->title }}</td>
                    <td>{{ $page->slug }}</td>
                    <td>{{ $page->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        <!-- Botão Visualizar: abre a página pública -->
                        <a href="{{ route('page.generator.show', $page->slug) }}" class="btn btn-sm btn-info" target="_blank">Visualizar</a>
                        
                        <!-- Botão Editar: leva ao formulário de edição -->
                        <a href="{{ route('page.generator.edit', $page->id) }}" class="btn btn-sm btn-warning">Editar</a>
                        
                        <!-- Botão Excluir: formulário com método DELETE -->
                        <form action="{{ route('page.generator.destroy', $page->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir esta página?')">Excluir</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Nenhuma página encontrada.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Link para voltar ao gerador de páginas -->
    <a href="{{ route('page.generator.index') }}" class="btn btn-secondary">Voltar ao Gerador de Páginas</a>
</div>
</body>
</html>
