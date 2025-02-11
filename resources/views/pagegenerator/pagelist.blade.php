@extends('layouts.app')

@section('title', 'Conjuntos de Páginas')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4">Conjuntos de Páginas (PageSets)</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Título do Template</th>
                <th>Data de Criação</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pageSets as $pageSet)
                <tr>
                    <td>{{ $pageSet->id }}</td>
                    <td>{{ $pageSet->title_template }}</td>
                    <td>{{ $pageSet->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        <!-- Botão para abrir o modal que mostra as páginas associadas -->
                        <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#pagesetModal-{{ $pageSet->id }}">
                            Visualizar Páginas
                        </button>
                        <!-- Botões de Editar e Excluir -->
                        <a href="{{ route('page_set.edit', $pageSet->id) }}" class="btn btn-sm btn-warning">Editar</a>
                        <form action="{{ route('page_set.destroy', $pageSet->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir este conjunto?')">Excluir</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modals para cada PageSet -->
@foreach($pageSets as $pageSet)
<div class="modal fade" id="pagesetModal-{{ $pageSet->id }}" tabindex="-1" aria-labelledby="pagesetModalLabel-{{ $pageSet->id }}" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="pagesetModalLabel-{{ $pageSet->id }}">Páginas do Conjunto #{{ $pageSet->id }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
      </div>
      <div class="modal-body">
          @if($pageSet->pages->isEmpty())
              <p>Nenhuma página gerada para este conjunto.</p>
          @else
              <table class="table table-bordered">
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
                      @foreach($pageSet->pages as $page)
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
                      @endforeach
                  </tbody>
              </table>
          @endif
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>
@endforeach
@endsection
