@extends('layouts.app')

@section('title', 'Editar Conjunto de Páginas')

@section('content')
<div class="container">
    <h1 class="mb-4">Editar Conjunto de Páginas (PageSet)</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('page_set.update', $pageSet->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <!-- Template do Título -->
        <div class="mb-3">
            <label for="title_template" class="form-label">Template do Título</label>
            <input type="text" name="title_template" id="title_template" class="form-control" value="{{ $pageSet->title_template }}" required>
        </div>
        
        <!-- Template do Conteúdo -->
        <div class="mb-3">
            <label for="content_template" class="form-label">Template do Conteúdo</label>
            <textarea name="content_template" id="content_template" rows="5" class="form-control" required>{{ $pageSet->content_template }}</textarea>
        </div>
        
        <!-- Data de Publicação -->
        <div class="mb-3">
            <label for="published_at" class="form-label">Data de Publicação</label>
            <input type="datetime-local" name="published_at" id="published_at" class="form-control" value="{{ $pageSet->published_at ? \Carbon\Carbon::parse($pageSet->published_at)->format('Y-m-d\TH:i') : '' }}">
        </div>
        
        <!-- Meta Description -->
        <div class="mb-3">
            <label for="meta_description" class="form-label">Meta Description</label>
            <textarea name="meta_description" id="meta_description" rows="3" class="form-control">{{ $pageSet->meta_description }}</textarea>
        </div>
        
        <!-- Meta Keywords -->
        <div class="mb-3">
            <label for="meta_keywords" class="form-label">Meta Keywords</label>
            <input type="text" name="meta_keywords" id="meta_keywords" class="form-control" value="{{ $pageSet->meta_keywords }}">
        </div>
        
        <button type="submit" class="btn btn-primary">Atualizar Conjunto</button>
        <a href="{{ route('page_sets.list') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<!-- Carrega e inicializa o CKEditor para o campo de conteúdo -->
<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('content_template');
</script>
@endsection
