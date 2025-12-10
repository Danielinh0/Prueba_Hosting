@extends('layouts.app')

@section('title', 'Gestión de Tokens de Jurado')

@push('styles')
<link rel="stylesheet" href="{{ Vite::asset('resources/css/admin/jurado-tokens/index.css') }}">
@endpush

@section('content')
<div class="tokens-page py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <a href="{{ route('admin.dashboard') }}" class="back-link">
            <i class="fas fa-arrow-left"></i> Volver al Inicio  
        </a>

        <!-- Hero Header -->
        <div class="hero-header text-center">
            <div class="hero-icon"><i class="fas fa-ticket-alt"></i></div>
            <h1 class="hero-title">Gestión de <span>Tokens</span></h1>
            <p class="hero-subtitle">Administra todos los tokens de acceso generados para los jurados del sistema</p>
        </div>

        <!-- Alertas -->
        @if(session('success'))
            <div class="alert-custom alert-success">
                <i class="fas fa-check-circle"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="alert-custom alert-error">
                <i class="fas fa-exclamation-circle"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <!-- Stats Cards -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon orange">
                    <i class="fas fa-ticket-alt"></i>
                </div>
                <div class="stat-content">
                    <h4>{{ $tokens->total() }}</h4>
                    <p>Tokens Totales</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon green">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-content">
                    <h4>{{ $tokens->where('usado', false)->where('fecha_expiracion', '>', now())->count() }}</h4>
                    <p>Vigentes</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon yellow">
                    <i class="fas fa-user-check"></i>
                </div>
                <div class="stat-content">
                    <h4>{{ $tokens->where('usado', true)->count() }}</h4>
                    <p>Usados</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon gray">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-content">
                    <h4>{{ $tokens->where('usado', false)->where('fecha_expiracion', '<', now())->count() }}</h4>
                    <p>Expirados</p>
                </div>
            </div>
        </div>

        <!-- Filters Section -->
        <div class="filters-section">
            <div class="search-wrapper">
                <form method="GET" action="{{ route('admin.jurado-tokens.index') }}">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" 
                           name="search" 
                           class="search-input" 
                           placeholder="Buscar por token o email..." 
                           value="{{ request('search') }}">
                    @if(request('estado'))
                        <input type="hidden" name="estado" value="{{ request('estado') }}">
                    @endif
                </form>
            </div>
            <div class="filter-pills">
                <a href="{{ route('admin.jurado-tokens.index') }}" 
                   class="filter-pill {{ !request('estado') ? 'active' : '' }}">
                    <i class="fas fa-layer-group"></i> Todos
                </a>
                <a href="{{ route('admin.jurado-tokens.index', ['estado' => 'vigentes', 'search' => request('search')]) }}" 
                   class="filter-pill {{ request('estado') == 'vigentes' ? 'active' : '' }}">
                    <i class="fas fa-check-circle"></i> Vigentes
                </a>
                <a href="{{ route('admin.jurado-tokens.index', ['estado' => 'usados', 'search' => request('search')]) }}" 
                   class="filter-pill {{ request('estado') == 'usados' ? 'active' : '' }}">
                    <i class="fas fa-user-check"></i> Usados
                </a>
                <a href="{{ route('admin.jurado-tokens.index', ['estado' => 'expirados', 'search' => request('search')]) }}" 
                   class="filter-pill {{ request('estado') == 'expirados' ? 'active' : '' }}">
                    <i class="fas fa-clock"></i> Expirados
                </a>
            </div>
        </div>

        <!-- Table Card -->
        <div class="table-card">
            <div class="table-header">
                <h3><i class="fas fa-list-ul"></i> Listado de Tokens</h3>
                <a href="{{ route('admin.jurado-tokens.create') }}" class="btn-create">
                    <i class="fas fa-plus-circle"></i> Nuevo Token
                </a>
            </div>

            @if($tokens->count() > 0)
                <div class="table-responsive">
                    <table class="custom-table">
                        <thead>
                            <tr>
                                <th>Token</th>
                                <th>Email Invitado</th>
                                <th>Estado</th>
                                <th>Creación</th>
                                <th>Expiración</th>
                                <th>Creado por</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tokens as $token)
                                <tr>
                                    <td>
                                        <code class="token-code">{{ $token->token }}</code>
                                    </td>
                                    <td class="email-cell" title="{{ $token->email_invitado }}">
                                        {{ $token->email_invitado ?? '—' }}
                                    </td>
                                    <td>
                                        @if($token->usado)
                                            <span class="status-badge status-used">Usado</span>
                                        @elseif($token->fecha_expiracion < now())
                                            <span class="status-badge status-expired">Expirado</span>
                                        @else
                                            <span class="status-badge status-active">Vigente</span>
                                        @endif
                                    </td>
                                    <td>{{ $token->created_at ? $token->created_at->format('d/m/Y H:i') : '—' }}</td>
                                    <td>{{ $token->fecha_expiracion->format('d/m/Y H:i') }}</td>
                                    <td>
                                        @if($token->creador)
                                            {{ $token->creador->nombre }}
                                        @else
                                            <span style="color: #9ca3af;">Sistema</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="actions-cell">
                                            <button class="btn-action copy" 
                                                    onclick="copyToken('{{ $token->token }}')"
                                                    data-tooltip="Copiar token">
                                                <i class="fas fa-copy"></i>
                                            </button>
                                            
                                            @if(!$token->usado && $token->fecha_expiracion > now())
                                                <button class="btn-action resend" 
                                                        onclick="reenviarToken('{{ $token->id_token }}')"
                                                        data-tooltip="Reenviar">
                                                    <i class="fas fa-paper-plane"></i>
                                                </button>
                                                <button class="btn-action revoke" 
                                                        onclick="revocarToken('{{ $token->id_token }}')"
                                                        data-tooltip="Revocar">
                                                    <i class="fas fa-ban"></i>
                                                </button>
                                            @else
                                                <button class="btn-action disabled" disabled data-tooltip="No disponible">
                                                    <i class="fas fa-lock"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($tokens->hasPages())
                    <div class="pagination-wrapper">
                        <div class="pagination-info">
                            Mostrando <strong>{{ $tokens->firstItem() }}</strong> a <strong>{{ $tokens->lastItem() }}</strong> de <strong>{{ $tokens->total() }}</strong> tokens
                        </div>
                        {{ $tokens->withQueryString()->links() }}
                    </div>
                @endif
            @else
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-inbox"></i>
                    </div>
                    @if(request('search') || request('estado'))
                        <h4>No se encontraron tokens</h4>
                        <p>No hay tokens que coincidan con los filtros aplicados.</p>
                        <a href="{{ route('admin.jurado-tokens.index') }}" class="btn-empty">
                            <i class="fas fa-times"></i> Limpiar Filtros
                        </a>
                    @else
                        <h4>Aún no hay tokens</h4>
                        <p>Genera tu primer token para invitar jurados al sistema.</p>
                        <a href="{{ route('admin.jurado-tokens.create') }}" class="btn-empty">
                            <i class="fas fa-plus-circle"></i> Generar Primer Token
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Floating Button -->
<div class="floating-btn-container">
    <a href="{{ route('admin.jurado-tokens.create') }}" class="floating-btn" title="Generar Nuevo Token">
        <i class="fas fa-plus"></i>
    </a>
</div>

<!-- Hidden Forms for Actions -->
<form id="revocarForm" method="POST" style="display: none;">
    @csrf
    @method('PATCH')
</form>

<form id="reenviarForm" method="POST" style="display: none;">
    @csrf
</form>
@endsection

@push('scripts')
<script>
function copyToken(token) {
    navigator.clipboard.writeText(token).then(() => {
        // Show a brief toast or feedback
        const toast = document.createElement('div');
        toast.innerHTML = '<i class="fas fa-check"></i> Token copiado';
        toast.style.cssText = `
            position: fixed;
            bottom: 100px;
            right: 30px;
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            padding: 12px 20px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 10px 30px rgba(16, 185, 129, 0.3);
            z-index: 9999;
            animation: slideUp 0.3s ease;
        `;
        document.body.appendChild(toast);
        
        setTimeout(() => {
            toast.style.animation = 'slideDown 0.3s ease forwards';
            setTimeout(() => toast.remove(), 300);
        }, 2000);
    });
}

function revocarToken(id) {
    if(confirm('¿Está seguro de revocar este token? Esta acción no se puede deshacer.')) {
        const form = document.getElementById('revocarForm');
        form.action = `/admin/jurado-tokens/${id}/revocar`;
        form.submit();
    }
}

function reenviarToken(id) {
    if(confirm('¿Desea reenviar el token al correo del jurado?')) {
        const form = document.getElementById('reenviarForm');
        form.action = `/admin/jurado-tokens/${id}/reenviar`;
        form.submit();
    }
}

// Add keyframe animations via JS
const style = document.createElement('style');
style.textContent = `
    @keyframes slideUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes slideDown {
        from { opacity: 1; transform: translateY(0); }
        to { opacity: 0; transform: translateY(20px); }
    }
`;
document.head.appendChild(style);
</script>
@endpush