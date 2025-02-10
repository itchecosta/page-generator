<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Page Generator - Gerar Páginas</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Carrega o CKEditor -->
    <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
</head>
<body>
<div class="container mt-5">
    <h1>Page Generator</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('page.generator.generate') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <!-- Template para o Título -->
        <div class="form-group">
            <label for="title_template">Template do Título</label>
            <input type="text" name="title_template" id="title_template" class="form-control" placeholder="Ex.: 'Desenvolvimento de Sites em {local}'" required>
        </div>
        
        <!-- Template para o Conteúdo (com editor visual) -->
        <div class="form-group">
            <label for="content_template">Template do Conteúdo</label>
            <textarea name="content_template" id="content_template" rows="5" class="form-control" placeholder="Ex.: 'Oferecemos serviços de {servico} para {nome} em {local}'" required></textarea>
        </div>
        
        <!-- Campo para Agendamento de Publicação -->
        <div class="form-group">
            <label for="published_at">Data de Publicação</label>
            <input type="datetime-local" name="published_at" id="published_at" class="form-control">
        </div>
        
        <!-- Campo para Meta Description (SEO) -->
        <div class="form-group">
            <label for="meta_description">Meta Description</label>
            <textarea name="meta_description" id="meta_description" rows="3" class="form-control" placeholder="Meta description para SEO"></textarea>
        </div>
        
        <!-- Campo para Meta Keywords (SEO) -->
        <div class="form-group">
            <label for="meta_keywords">Meta Keywords</label>
            <input type="text" name="meta_keywords" id="meta_keywords" class="form-control" placeholder="Ex.: web, desenvolvimento, sites">
        </div>
        
        <!-- Upload do Arquivo CSV -->
        <div class="form-group">
            <label for="csv_file">Arquivo CSV</label>
            <input type="file" name="csv_file" id="csv_file" class="form-control-file" accept=".csv, text/plain" required>
            <small class="form-text text-muted">
                O arquivo CSV deve conter a linha de cabeçalho com os nomes dos placeholders (ex.: nome, local, servico) e as respectivas linhas com os valores.
            </small>
        </div>
        
        <button type="submit" class="btn btn-primary">Gerar Páginas</button>
        <a href="{{ route('page.generator.list') }}" class="btn btn-secondary">Voltar a Lista de Páginas</a>
    </form>
</div>

<!-- Inicializa o CKEditor no textarea de conteúdo -->
<script>
    CKEDITOR.replace('content_template');
</script>
</body>
</html>
