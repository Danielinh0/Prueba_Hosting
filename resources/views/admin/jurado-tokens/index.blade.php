@extends('layouts.app')

@section('title', 'Gestión de Tokens de Jurado')

@push('styles')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=JetBrains+Mono:wght@400;500&display=swap');

    /* Base - Tema Innovador Naranja/Blanco */
    .tokens-page {
        background: linear-gradient(135deg, #ffffff 0%, #f9fafb 25%, #ffffff 100%);
        min-height: 100vh;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif !important;
        position: relative;
        overflow-x: hidden;
    }

    .tokens-page * {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif !important;
    }

    .tokens-page::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 400px;
        background: linear-gradient(135deg, rgba(255, 149, 0, 0.03) 0%, transparent 100%);
        z-index: 0;
        pointer-events: none;
    }

    .tokens-page .container {
        position: relative;
        z-index: 1;
    }

    /* Back button */
    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #1a1a1a;
        font-size: 0.9rem;
        font-weight: 600;
        padding: 12px 24px;
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        border: 2px solid rgba(255, 149, 0, 0.1);
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        text-decoration: none;
        margin-bottom: 2rem;
    }

    .back-link:hover {
        color: #ff9500;
        border-color: rgba(255, 149, 0, 0.3);
        transform: translateX(-5px);
        box-shadow: 0 8px 30px rgba(255, 149, 0, 0.15);
        text-decoration: none;
    }

    .back-link i {
        color: #ff9500;
        transition: transform 0.3s ease;
    }

    .back-link:hover i {
        transform: translateX(-3px);
    }

    /* Hero Header */
    .hero-header {
        background: linear-gradient(135deg, #1a1a1a 0%, #000000 100%);
        border-radius: 24px;
        padding: 3rem 2.5rem;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.25);
        border: 1px solid rgba(255, 255, 255, 0.05);
    }

    .hero-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, transparent 0%, #ff9500 20%, #ff9500 80%, transparent 100%);
    }

    .hero-header::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 300px;
        height: 300px;
        background: radial-gradient(circle, rgba(255, 149, 0, 0.08) 0%, transparent 70%);
        border-radius: 50%;
        filter: blur(40px);
    }

    .hero-icon {
        font-size: 3.5rem;
        margin-bottom: 1rem;
        background: linear-gradient(135deg, #ff9500, #ffaa33);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        display: inline-block;
        filter: drop-shadow(0 10px 20px rgba(255, 149, 0, 0.2));
    }

    .hero-title {
        font-size: 2.75rem;
        font-weight: 900;
        color: #ffffff;
        margin-bottom: 0.5rem;
        line-height: 1.1;
        position: relative;
    }

    .hero-title span {
        background: linear-gradient(135deg, #ff9500, #ffaa33);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .hero-subtitle {
        color: #a0a0a0;
        font-size: 1rem;
        margin: 0;
        max-width: 500px;
        margin: 0 auto;
        position: relative;
    }

    /* Stats Cards */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    @media (max-width: 992px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 576px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }
    }

    .stat-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: 20px;
        padding: 1.75rem;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.06);
        border: 1px solid rgba(255, 255, 255, 0.3);
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 1.25rem;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 50px rgba(0, 0, 0, 0.1);
    }

    .stat-icon {
        width: 56px;
        height: 56px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }

    .stat-icon.orange {
        background: linear-gradient(135deg, rgba(255, 149, 0, 0.15), rgba(255, 149, 0, 0.05));
        color: #ff9500;
    }

    .stat-icon.green {
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.15), rgba(16, 185, 129, 0.05));
        color: #10b981;
    }

    .stat-icon.yellow {
        background: linear-gradient(135deg, rgba(245, 158, 11, 0.15), rgba(245, 158, 11, 0.05));
        color: #f59e0b;
    }

    .stat-icon.gray {
        background: linear-gradient(135deg, rgba(107, 114, 128, 0.15), rgba(107, 114, 128, 0.05));
        color: #6b7280;
    }

    .stat-icon i {
        color: inherit;
        font-size: inherit;
    }

    .stat-content h4 {
        font-size: 1.75rem;
        font-weight: 800;
        color: #1a1a1a;
        margin: 0;
        line-height: 1;
    }

    .stat-content p {
        font-size: 0.85rem;
        color: #6b7280;
        margin: 0.25rem 0 0;
        font-weight: 500;
    }

    /* Filters Section */
    .filters-section {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: 20px;
        padding: 1.5rem 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.06);
        border: 1px solid rgba(255, 255, 255, 0.3);
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
    }

    .search-wrapper {
        flex: 1;
        min-width: 280px;
        max-width: 400px;
        position: relative;
    }

    .search-input {
        width: 100%;
        padding: 0.875rem 1.25rem 0.875rem 3rem;
        background: rgba(255, 255, 255, 0.9);
        border: 2px solid #e5e7eb;
        border-radius: 14px;
        font-size: 0.95rem;
        color: #1a1a1a;
        transition: all 0.3s ease;
        font-weight: 500;
    }

    .search-input:focus {
        outline: none;
        border-color: #ff9500;
        box-shadow: 0 0 0 4px rgba(255, 149, 0, 0.1);
    }

    .search-input::placeholder {
        color: #9ca3af;
    }

    .search-icon {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: #9ca3af;
        font-size: 1rem;
    }

    .filter-pills {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .filter-pill {
        padding: 0.625rem 1.25rem;
        background: #f3f4f6;
        border: 2px solid transparent;
        border-radius: 12px;
        font-size: 0.85rem;
        font-weight: 600;
        color: #4b5563;
        text-decoration: none;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .filter-pill:hover {
        background: #e5e7eb;
        color: #1f2937;
        text-decoration: none;
    }

    .filter-pill.active {
        background: linear-gradient(135deg, #1a1a1a, #000000);
        color: #ffffff;
        border-color: transparent;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }

    .filter-pill.active i {
        color: #ff9500;
    }

    .filter-pill i {
        font-size: 0.8rem;
    }

    /* Table Card */
    .table-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 15px 50px rgba(0, 0, 0, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.3);
    }

    .table-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1.5rem 2rem;
        background: linear-gradient(135deg, #1a1a1a 0%, #000000 100%);
        border-bottom: 2px solid rgba(255, 149, 0, 0.2);
    }

    .table-header h3 {
        font-size: 1.25rem;
        font-weight: 800;
        color: #ffffff;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .table-header h3 i {
        color: #ff9500;
    }

    .btn-create {
        padding: 0.75rem 1.5rem;
        background: linear-gradient(135deg, #ff9500, #ffaa33);
        color: #000000;
        border: none;
        border-radius: 12px;
        font-size: 0.9rem;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        box-shadow: 0 4px 15px rgba(255, 149, 0, 0.3);
    }

    .btn-create:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(255, 149, 0, 0.4);
        color: #000000;
        text-decoration: none;
    }

    /* Custom Table */
    .custom-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    .custom-table thead {
        background: #f9fafb;
    }

    .custom-table th {
        padding: 1rem 1.5rem;
        text-align: left;
        color: #374151;
        font-weight: 700;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 2px solid #e5e7eb;
    }

    .custom-table td {
        padding: 1.25rem 1.5rem;
        color: #1f2937;
        font-size: 0.9rem;
        font-weight: 500;
        border-bottom: 1px solid #f3f4f6;
        vertical-align: middle;
    }

    .custom-table tbody tr {
        transition: all 0.2s ease;
        background: #ffffff;
    }

    .custom-table tbody tr:hover {
        background: rgba(255, 149, 0, 0.03);
    }

    .token-code {
        font-family: 'JetBrains Mono', monospace;
        background: linear-gradient(135deg, rgba(26, 26, 26, 0.08), rgba(0, 0, 0, 0.04));
        padding: 0.5rem 0.875rem;
        border-radius: 10px;
        font-size: 0.85rem;
        color: #1a1a1a;
        font-weight: 600;
        letter-spacing: 0.3px;
        border: 1px solid rgba(0, 0, 0, 0.08);
        display: inline-block;
    }

    .email-cell {
        max-width: 200px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    /* Status Badges */
    .status-badge {
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
    }

    .status-badge::before {
        content: '';
        width: 6px;
        height: 6px;
        border-radius: 50%;
    }

    .status-active {
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.15), rgba(16, 185, 129, 0.05));
        color: #059669;
        border: 1px solid rgba(16, 185, 129, 0.2);
    }

    .status-active::before {
        background: #10b981;
    }

    .status-used {
        background: linear-gradient(135deg, rgba(255, 149, 0, 0.15), rgba(255, 149, 0, 0.05));
        color: #d97706;
        border: 1px solid rgba(255, 149, 0, 0.2);
    }

    .status-used::before {
        background: #ff9500;
    }

    .status-expired {
        background: linear-gradient(135deg, rgba(107, 114, 128, 0.15), rgba(107, 114, 128, 0.05));
        color: #4b5563;
        border: 1px solid rgba(107, 114, 128, 0.2);
    }

    .status-expired::before {
        background: #6b7280;
    }

    /* Action Buttons */
    .actions-cell {
        display: flex;
        gap: 0.5rem;
    }

    .btn-action {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        border: 2px solid;
        background: transparent;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        font-size: 0.9rem;
    }

    .btn-action.copy {
        border-color: rgba(99, 102, 241, 0.2);
        color: #6366f1;
    }

    .btn-action.copy:hover {
        background: #6366f1;
        border-color: #6366f1;
        color: white;
        transform: scale(1.1);
    }

    .btn-action.resend {
        border-color: rgba(16, 185, 129, 0.2);
        color: #10b981;
    }

    .btn-action.resend:hover {
        background: #10b981;
        border-color: #10b981;
        color: white;
        transform: scale(1.1);
    }

    .btn-action.revoke {
        border-color: rgba(239, 68, 68, 0.2);
        color: #ef4444;
    }

    .btn-action.revoke:hover {
        background: #ef4444;
        border-color: #ef4444;
        color: white;
        transform: scale(1.1);
    }

    .btn-action.disabled {
        border-color: rgba(156, 163, 175, 0.2);
        color: #9ca3af;
        cursor: not-allowed;
        opacity: 0.5;
    }

    .btn-action.disabled:hover {
        transform: none;
        background: transparent;
    }

    /* Pagination */
    .pagination-wrapper {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1.5rem 2rem;
        background: #f9fafb;
        border-top: 1px solid #e5e7eb;
    }

    .pagination-info {
        font-size: 0.875rem;
        color: #6b7280;
        font-weight: 500;
    }

    .pagination-info strong {
        color: #1f2937;
    }

    .pagination {
        display: flex;
        gap: 0.375rem;
        margin: 0;
    }

    .pagination .page-item .page-link {
        padding: 0.5rem 0.875rem;
        border-radius: 10px;
        border: 2px solid #e5e7eb;
        background: white;
        color: #374151;
        font-weight: 600;
        font-size: 0.85rem;
        transition: all 0.2s ease;
    }

    .pagination .page-item .page-link:hover {
        border-color: #ff9500;
        color: #ff9500;
    }

    .pagination .page-item.active .page-link {
        background: linear-gradient(135deg, #1a1a1a, #000000);
        border-color: #1a1a1a;
        color: white;
    }

    .pagination .page-item.disabled .page-link {
        opacity: 0.5;
        cursor: not-allowed;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 5rem 2rem;
    }

    .empty-icon {
        width: 100px;
        height: 100px;
        background: linear-gradient(135deg, rgba(255, 149, 0, 0.1), rgba(255, 149, 0, 0.05));
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
    }

    .empty-icon i {
        font-size: 2.5rem;
        color: #ff9500;
    }

    .empty-state h4 {
        font-size: 1.25rem;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 0.5rem;
    }

    .empty-state p {
        color: #6b7280;
        margin-bottom: 1.5rem;
        font-size: 0.95rem;
    }

    .btn-empty {
        padding: 0.875rem 1.75rem;
        background: linear-gradient(135deg, #1a1a1a, #000000);
        color: white;
        border: none;
        border-radius: 14px;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
    }

    .btn-empty:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        color: white;
        text-decoration: none;
    }

    .btn-empty i {
        color: #ff9500;
    }

    /* Floating Button */
    .floating-btn-container {
        position: fixed;
        bottom: 2rem;
        right: 2rem;
        z-index: 1000;
    }

    .floating-btn {
        width: 64px;
        height: 64px;
        background: linear-gradient(135deg, #ff9500, #ffaa33);
        color: #000000;
        border: none;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        text-decoration: none;
        box-shadow: 0 8px 30px rgba(255, 149, 0, 0.4);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .floating-btn:hover {
        transform: scale(1.1) rotate(90deg);
        box-shadow: 0 12px 40px rgba(255, 149, 0, 0.5);
        color: #000000;
        text-decoration: none;
    }

    /* Alert Messages */
    .alert-custom {
        padding: 1.25rem 1.5rem;
        border-radius: 16px;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        animation: slideIn 0.4s ease;
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .alert-success {
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.1), rgba(16, 185, 129, 0.05));
        border: 2px solid rgba(16, 185, 129, 0.2);
        color: #047857;
    }

    .alert-success i {
        color: #10b981;
        font-size: 1.25rem;
    }

    .alert-error {
        background: linear-gradient(135deg, rgba(239, 68, 68, 0.1), rgba(239, 68, 68, 0.05));
        border: 2px solid rgba(239, 68, 68, 0.2);
        color: #b91c1c;
    }

    .alert-error i {
        color: #ef4444;
        font-size: 1.25rem;
    }

    /* Tooltip */
    [data-tooltip] {
        position: relative;
    }

    [data-tooltip]:hover::after {
        content: attr(data-tooltip);
        position: absolute;
        bottom: 100%;
        left: 50%;
        transform: translateX(-50%);
        padding: 0.5rem 0.75rem;
        background: #1a1a1a;
        color: white;
        font-size: 0.75rem;
        font-weight: 600;
        border-radius: 8px;
        white-space: nowrap;
        margin-bottom: 5px;
        z-index: 100;
    }

    /* Responsive */
    @media (max-width: 992px) {
        .hero-title {
            font-size: 2rem;
        }

        .filters-section {
            flex-direction: column;
            align-items: stretch;
        }

        .search-wrapper {
            max-width: 100%;
        }

        .filter-pills {
            justify-content: center;
        }

        .table-header {
            flex-direction: column;
            gap: 1rem;
            text-align: center;
        }

        .btn-create {
            width: 100%;
            justify-content: center;
        }

        .custom-table {
            display: block;
            overflow-x: auto;
        }

        .pagination-wrapper {
            flex-direction: column;
            gap: 1rem;
            text-align: center;
        }
    }

    @media (max-width: 576px) {
        .hero-header {
            padding: 2rem 1.5rem;
        }

        .hero-title {
            font-size: 1.75rem;
        }

        .stat-card {
            padding: 1.25rem;
        }

        .filters-section {
            padding: 1rem 1.25rem;
        }

        .table-header {
            padding: 1.25rem 1.5rem;
        }

        .custom-table th,
        .custom-table td {
            padding: 1rem;
        }

        .floating-btn {
            width: 56px;
            height: 56px;
            font-size: 1.25rem;
        }
    }
</style>
@endpush

@section('content')
<div class="tokens-page py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <a href="{{ route('admin.dashboard') }}" class="back-link">
            <i class="fas fa-arrow-left"></i> Volver al Dashboard
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