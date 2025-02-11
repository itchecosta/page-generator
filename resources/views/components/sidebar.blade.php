<div class="d-flex flex-column p-3 bg-light sidebar">
    <a href="{{ route('page_sets.list') }}" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
        <span class="fs-4">Menu</span>
    </a>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a href="{{ route('page_sets.list') }}" class="nav-link {{ request()->routeIs('page_sets.list') ? 'active' : 'link-dark' }}">
                <i class="fa fa-th me-2"></i> Conjuntos de Páginas
            </a>
        </li>
        <li>
            <a href="{{ route('page.generator.index') }}" class="nav-link {{ request()->routeIs('page.generator.index') ? 'active' : 'link-dark' }}">
                <i class="fa fa-file me-2"></i> Gerar Páginas
            </a>
        </li>
        <li>
            <a href="#" class="nav-link link-dark">
                <i class="fa fa-cog me-2"></i> Configurações
            </a>
        </li>
    </ul>
    <hr>
    <div class="dropdown">
        <a href="#" class="d-flex align-items-center link-dark text-decoration-none dropdown-toggle" id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="https://via.placeholder.com/32" alt="" width="32" height="32" class="rounded-circle me-2">
            <strong>Usuário</strong>
        </a>
        <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser">
            <li><a class="dropdown-item" href="#">Perfil</a></li>
            <li><a class="dropdown-item" href="#">Sair</a></li>
        </ul>
    </div>
</div>
