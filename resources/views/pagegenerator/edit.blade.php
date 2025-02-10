<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Editar Página</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Carrega o CKEditor -->
    <script src="https://cdn.ckeditor.com/4.20.1/standard/ckeditor.js"></script>
</head>
<body>
<div class="container mt-5">
    <h1>Editar Página</h1>
    
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <form action="{{ route('page.generator.update', $page->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <!-- Campo Título -->
        <div class="form-group">
            <label for="title">Título</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ $page->title }}" required>
        </div>
        
        <!-- Campo Conteúdo com editor visual -->
        <div class="form-group">
            <label for="content">Conteúdo</label>
            <textarea name="content" id="content" rows="5" class="form-control" required>{{ $page->content }}</textarea>
        </div>
        
        <!-- Campo para Agendamento de Publicação -->
        <div class="form-group">
            <label for="published_at">Data de Publicação</label>
            <input type="datetime-local" name="published_at" id="published_at" class="form-control" value="{{ $page->published_at ? \Carbon\Carbon::parse($page->published_at)->format('Y-m-d\TH:i') : '' }}">
        </div>
        
        <!-- Campo para Meta Description -->
        <div class="form-group">
            <label for="meta_description">Meta Description</label>
            <textarea name="meta_description" id="meta_description" rows="3" class="form-control">{{ $page->meta_description }}</textarea>
        </div>
        
        <!-- Campo para Meta Keywords -->
        <div class="form-group">
            <label for="meta_keywords">Meta Keywords</label>
            <input type="text" name="meta_keywords" id="meta_keywords" class="form-control" value="{{ $page->meta_keywords }}">
        </div>
        
        <button type="submit" class="btn btn-primary">Atualizar Página</button>
        <a href="{{ route('page.generator.list') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<!-- Inicializa o CKEditor no textarea de conteúdo -->
<script>
    CKEDITOR.replace('content');
</script>
</body>
</html>
