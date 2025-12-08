@extends('layouts.app')

@section('title', 'Generar Token de Jurado')

@push('styles')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=JetBrains+Mono:wght@400;500&display=swap');

    /* Base - Tema Innovador Naranja/Blanco */
    .token-page {
        background: linear-gradient(135deg, #ffffff 0%, #f9fafb 25%, #ffffff 100%);
        min-height: 100vh;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        position: relative;
        overflow-x: hidden;
    }

    .token-page::before {
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

    .container {
        position: relative;
        z-index: 1;
    }

    /* Back button - Diseño Futurista */
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
        box-shadow: 
            0 4px 20px rgba(0, 0, 0, 0.05),
            0 0 0 1px rgba(255, 255, 255, 0.8);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        text-decoration: none;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
    }

    .back-link::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 149, 0, 0.1), transparent);
        transition: left 0.6s ease;
    }

    .back-link:hover {
        color: #ff9500;
        border-color: rgba(255, 149, 0, 0.3);
        transform: translateX(-5px) translateY(-2px);
        box-shadow: 
            0 8px 30px rgba(255, 149, 0, 0.15),
            0 0 0 1px rgba(255, 255, 255, 0.9);
    }

    .back-link:hover::before {
        left: 100%;
    }

    .back-link i {
        color: #ff9500;
        font-size: 1rem;
        transition: transform 0.3s ease;
    }

    .back-link:hover i {
        transform: translateX(-3px);
    }

    /* Hero Header - Diseño Innovador */
    .hero-header {
        background: linear-gradient(135deg, #1a1a1a 0%, #000000 100%);
        border-radius: 24px;
        padding: 3rem 2.5rem;
        margin-bottom: 3rem;
        position: relative;
        overflow: hidden;
        box-shadow: 
            0 20px 60px rgba(0, 0, 0, 0.25),
            inset 0 1px 0 rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.05);
    }

    .hero-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, 
            transparent 0%, 
            #ff9500 20%, 
            #ff9500 80%, 
            transparent 100%);
        z-index: 2;
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
        animation: pulse 8s ease-in-out infinite;
    }

    @keyframes pulse {
        0%, 100% { opacity: 0.5; transform: translate(-50%, -50%) scale(1); }
        50% { opacity: 0.8; transform: translate(-50%, -50%) scale(1.1); }
    }

    .hero-icon {
        font-size: 4rem;
        margin-bottom: 1.5rem;
        background: linear-gradient(135deg, #ff9500, #ffaa33);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        display: inline-block;
        animation: float 6s ease-in-out infinite;
        filter: drop-shadow(0 10px 20px rgba(255, 149, 0, 0.2));
    }

    @keyframes float {
        0%, 100% { transform: translateY(0px) rotate(0deg); }
        33% { transform: translateY(-10px) rotate(2deg); }
        66% { transform: translateY(5px) rotate(-2deg); }
    }

    .hero-title {
        font-size: 3.5rem;
        font-weight: 900;
        color: #ffffff;
        margin-bottom: 0.75rem;
        line-height: 1.1;
        text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        position: relative;
    }

    .hero-title span {
        background: linear-gradient(135deg, #ff9500, #ffaa33, #ff9500);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        position: relative;
        animation: shimmer 3s infinite linear;
        background-size: 200% 100%;
    }

    @keyframes shimmer {
        0% { background-position: 200% center; }
        100% { background-position: -200% center; }
    }

    .hero-subtitle {
        color: #a0a0a0;
        font-size: 1.125rem;
        margin: 0;
        font-weight: 400;
        max-width: 600px;
        margin: 0 auto;
        position: relative;
        line-height: 1.6;
    }

    /* Content Grid - Layout Moderno */
    .content-grid {
        display: grid;
        grid-template-columns: 1.3fr 0.7fr;
        gap: 2.5rem;
        margin-bottom: 3rem;
        position: relative;
    }

    @media (max-width: 992px) {
        .content-grid {
            grid-template-columns: 1fr;
            gap: 2rem;
        }
    }

    /* Cards - Diseño Glassmorphism */
    .modern-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: 24px;
        padding: 2.5rem;
        box-shadow: 
            0 15px 50px rgba(0, 0, 0, 0.08),
            inset 0 1px 0 rgba(255, 255, 255, 0.6),
            0 0 0 1px rgba(255, 255, 255, 0.2);
        border: 1px solid rgba(255, 255, 255, 0.3);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }

    .modern-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #ff9500, #ffaa33);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .modern-card:hover {
        transform: translateY(-5px);
        box-shadow: 
            0 25px 60px rgba(0, 0, 0, 0.12),
            inset 0 1px 0 rgba(255, 255, 255, 0.8),
            0 0 0 1px rgba(255, 255, 255, 0.3);
    }

    .modern-card:hover::before {
        opacity: 1;
    }

    .card-header-custom {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 2rem;
        padding-bottom: 1.25rem;
        border-bottom: 2px solid #f0f0f0;
        position: relative;
    }

    .card-header-custom::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        width: 60px;
        height: 2px;
        background: linear-gradient(90deg, #ff9500, transparent);
    }

    .card-header-custom i {
        font-size: 1.75rem;
        background: linear-gradient(135deg, #ff9500, #ffaa33);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(255, 149, 0, 0.1);
        border-radius: 12px;
    }

    .card-header-custom h3 {
        font-size: 1.5rem;
        font-weight: 800;
        color: #1a1a1a;
        margin: 0;
        letter-spacing: -0.5px;
    }

    /* Form Styles - Inputs Modernos */
    .form-group {
        margin-bottom: 2rem;
        position: relative;
    }

    .form-label {
        display: block;
        font-weight: 600;
        color: #1a1a1a;
        margin-bottom: 0.75rem;
        font-size: 0.95rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .form-label::before {
        content: '';
        width: 6px;
        height: 6px;
        background: #ff9500;
        border-radius: 50%;
        display: inline-block;
    }

    .form-input {
        width: 100%;
        padding: 1rem 1.25rem;
        background: rgba(255, 255, 255, 0.9);
        border: 2px solid #e0e0e0;
        border-radius: 16px;
        font-size: 1rem;
        color: #1a1a1a;
        transition: all 0.3s ease;
        font-family: 'Inter', sans-serif;
        font-weight: 500;
        box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.04);
    }

    .form-input:focus {
        outline: none;
        border-color: #ff9500;
        background: #ffffff;
        box-shadow: 
            0 0 0 4px rgba(255, 149, 0, 0.15),
            inset 0 2px 4px rgba(0, 0, 0, 0.04);
        transform: translateY(-1px);
    }

    .form-input::placeholder {
        color: #909090;
        font-weight: 400;
    }

    .form-help {
        font-size: 0.85rem;
        color: #666666;
        margin-top: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding-left: 1.5rem;
    }

    .form-help i {
        color: #ff9500;
        font-size: 0.9rem;
    }

    /* Estilos para mensajes de error en tiempo real */
    .error-message {
        margin-top: 0.5rem;
        padding: 0.75rem 1rem;
        background: linear-gradient(135deg, rgba(239, 68, 68, 0.1), rgba(239, 68, 68, 0.05));
        border-left: 4px solid #ef4444;
        border-radius: 12px;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-size: 0.9rem;
        animation: slideInError 0.3s ease-out;
    }

    @keyframes slideInError {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .error-message i {
        color: #ef4444;
        font-size: 1rem;
    }

    .error-message span {
        color: #dc2626;
        font-weight: 500;
    }

    /* Estados de input */
    .form-input.name-input {
        transition: all 0.3s ease;
    }

    .form-input.name-input.error {
        border-color: #ef4444;
        background: rgba(239, 68, 68, 0.05);
        animation: shake 0.5s ease-in-out;
    }

    .form-input.name-input.error:focus {
        border-color: #ef4444;
        box-shadow:
            0 0 0 4px rgba(239, 68, 68, 0.15),
            inset 0 2px 4px rgba(0, 0, 0, 0.04);
    }

    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
        20%, 40%, 60%, 80% { transform: translateX(5px); }
    }

    /* Submit Button - Diseño Futurista */
    .btn-submit {
        width: 100%;
        padding: 1.25rem 2rem;
        background: linear-gradient(135deg, #1a1a1a 0%, #000000 100%);
        color: #ffffff;
        font-weight: 700;
        font-size: 1.1rem;
        border: none;
        border-radius: 16px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 1rem;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        margin-top: 2rem;
    }

    .btn-submit::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, 
            transparent, 
            rgba(255, 149, 0, 0.2), 
            transparent);
        transition: left 0.6s ease;
    }

    .btn-submit:hover {
        background: linear-gradient(135deg, #000000 0%, #1a1a1a 100%);
        transform: translateY(-3px);
        box-shadow: 
            0 15px 40px rgba(255, 149, 0, 0.25),
            0 0 0 1px rgba(255, 149, 0, 0.1);
    }

    .btn-submit:hover::before {
        left: 100%;
    }

    .btn-submit:hover i {
        transform: translateX(5px);
    }

    .btn-submit:active {
        transform: translateY(-1px);
    }

    .btn-submit i {
        font-size: 1.2rem;
        color: #ff9500;
        transition: transform 0.3s ease;
    }

    /* Info Card - Pasos Mejorados */
    .info-card {
        background: linear-gradient(135deg, rgba(26, 26, 26, 0.95), rgba(0, 0, 0, 0.95));
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 149, 0, 0.1);
        box-shadow: 
            0 20px 50px rgba(0, 0, 0, 0.2),
            inset 0 1px 0 rgba(255, 255, 255, 0.1);
    }

    .info-card .card-header-custom i,
    .info-card .card-header-custom h3 {
        color: #ffffff;
        -webkit-text-fill-color: #ffffff;
    }

    .step-list {
        list-style: none;
        padding: 0;
        margin: 0;
        counter-reset: step-counter;
    }

    .step-item {
        display: flex;
        gap: 1.25rem;
        padding: 1.5rem 0;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        counter-increment: step-counter;
        position: relative;
        align-items: flex-start;
    }

    .step-item:last-child {
        border-bottom: none;
    }

    .step-item::before {
        content: counter(step-counter);
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, #ff9500, #ffaa33);
        color: #000000;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 1rem;
        flex-shrink: 0;
        font-family: 'JetBrains Mono', monospace;
        box-shadow: 0 4px 12px rgba(255, 149, 0, 0.3);
    }

    .step-content h5 {
        font-size: 1rem;
        font-weight: 700;
        color: #ffffff;
        margin: 0 0 0.5rem 0;
        letter-spacing: -0.3px;
    }

    .step-content p {
        font-size: 0.9rem;
        color: #a0a0a0;
        margin: 0;
        line-height: 1.5;
    }

    /* Alert Styles - Modernas */
    .alert-custom {
        padding: 1.5rem;
        border-radius: 20px;
        margin: 2rem 0;
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        border: 2px solid transparent;
        border-left: 6px solid;
        animation: slideIn 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .alert-success-custom {
        border-left-color: #10b981;
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.05), rgba(255, 255, 255, 0.95));
    }

    .alert-success-custom i {
        color: #10b981;
        font-size: 1.5rem;
        margin-top: 2px;
    }

    .alert-success-custom .alert-content {
        flex: 1;
    }

    .alert-success-custom .alert-title {
        font-weight: 700;
        color: #065f46;
        margin: 0 0 0.5rem 0;
        font-size: 1.1rem;
    }

    .alert-success-custom .alert-text {
        color: #047857;
        font-size: 0.95rem;
        margin: 0;
        line-height: 1.5;
    }

    .token-display {
        margin-top: 1rem;
        padding: 1rem 1.25rem;
        background: rgba(255, 255, 255, 0.9);
        border: 2px solid rgba(16, 185, 129, 0.2);
        border-radius: 16px;
        font-family: 'JetBrains Mono', monospace;
        font-size: 1rem;
        color: #1a1a1a;
        font-weight: 600;
        display: flex;
        align-items: center;
        justify-content: space-between;
        backdrop-filter: blur(10px);
        position: relative;
        overflow: hidden;
    }

    .token-display::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(90deg, 
            transparent 0%, 
            rgba(255, 149, 0, 0.05) 50%, 
            transparent 100%);
        animation: shine 3s infinite;
    }

    @keyframes shine {
        0% { transform: translateX(-100%); }
        100% { transform: translateX(100%); }
    }

    .btn-copy {
        background: linear-gradient(135deg, #1a1a1a, #000000);
        color: white;
        border: none;
        padding: 0.75rem 1.25rem;
        border-radius: 12px;
        cursor: pointer;
        font-size: 0.9rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        position: relative;
        z-index: 2;
    }

    .btn-copy:hover {
        background: linear-gradient(135deg, #000000, #1a1a1a);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(255, 149, 0, 0.3);
    }

    .btn-copy i {
        font-size: 0.9rem;
    }

    .alert-error-custom {
        border-left-color: #ef4444;
        background: linear-gradient(135deg, rgba(239, 68, 68, 0.05), rgba(255, 255, 255, 0.95));
    }

    .alert-error-custom i {
        color: #ef4444;
    }

    /* Table Styles - Diseño Avanzado */
    .table-container {
        margin-top: 3rem;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 
            0 20px 60px rgba(0, 0, 0, 0.1),
            inset 0 1px 0 rgba(255, 255, 255, 0.6);
        border: 1px solid rgba(255, 255, 255, 0.3);
    }

    .table-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 2rem 2.5rem;
        background: linear-gradient(135deg, #1a1a1a 0%, #000000 100%);
        border-bottom: 2px solid rgba(255, 149, 0, 0.2);
    }

    .table-header h3 {
        font-size: 1.5rem;
        font-weight: 800;
        color: #ffffff;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        letter-spacing: -0.5px;
    }

    .table-header h3 i {
        color: #ff9500;
        font-size: 1.5rem;
    }

    .btn-view-all {
        padding: 0.75rem 1.5rem;
        background: rgba(255, 149, 0, 0.1);
        color: #ff9500;
        border: 2px solid rgba(255, 149, 0, 0.3);
        border-radius: 12px;
        font-size: 0.9rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-view-all:hover {
        background: rgba(255, 149, 0, 0.2);
        border-color: rgba(255, 149, 0, 0.5);
        transform: translateX(5px);
        color: #ffaa33;
    }

    .tokens-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        background: transparent;
    }

    .tokens-table thead {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
    }

    .tokens-table th {
        padding: 1.25rem 1.5rem;
        text-align: left;
        color: #1a1a1a;
        font-weight: 700;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 2px solid #f0f0f0;
        font-family: 'JetBrains Mono', monospace;
    }

    .tokens-table td {
        padding: 1.25rem 1.5rem;
        color: #333333;
        font-size: 0.95rem;
        font-weight: 500;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        transition: all 0.2s ease;
    }

    .tokens-table tbody tr {
        transition: all 0.3s ease;
        background: rgba(255, 255, 255, 0.5);
    }

    .tokens-table tbody tr:hover {
        background: rgba(255, 149, 0, 0.05);
        transform: translateX(5px);
    }

    .token-code {
        font-family: 'JetBrains Mono', monospace;
        background: linear-gradient(135deg, rgba(26, 26, 26, 0.1), rgba(0, 0, 0, 0.05));
        padding: 0.5rem 0.75rem;
        border-radius: 10px;
        font-size: 0.9rem;
        color: #1a1a1a;
        font-weight: 600;
        letter-spacing: 0.5px;
        border: 1px solid rgba(0, 0, 0, 0.1);
    }

    .status-badge {
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .status-badge::before {
        content: '●';
        font-size: 0.6rem;
    }

    .status-active {
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.15), rgba(16, 185, 129, 0.05));
        color: #059669;
        border: 1px solid rgba(16, 185, 129, 0.2);
    }

    .status-active::before {
        color: #10b981;
    }

    .status-used {
        background: linear-gradient(135deg, rgba(255, 149, 0, 0.15), rgba(255, 149, 0, 0.05));
        color: #d97706;
        border: 1px solid rgba(255, 149, 0, 0.2);
    }

    .status-used::before {
        color: #ff9500;
    }

    .status-expired {
        background: linear-gradient(135deg, rgba(107, 114, 128, 0.15), rgba(107, 114, 128, 0.05));
        color: #4b5563;
        border: 1px solid rgba(107, 114, 128, 0.2);
    }

    .status-expired::before {
        color: #6b7280;
    }

    .btn-action {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        border: 2px solid rgba(255, 149, 0, 0.2);
        background: rgba(255, 149, 0, 0.1);
        color: #ff9500;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        font-size: 1rem;
    }

    .btn-action:hover {
        background: linear-gradient(135deg, #ff9500, #ffaa33);
        color: #ffffff;
        border-color: transparent;
        transform: rotate(10deg) scale(1.1);
        box-shadow: 0 5px 15px rgba(255, 149, 0, 0.3);
    }

    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        color: #909090;
    }

    .empty-state i {
        font-size: 4rem;
        margin-bottom: 1.5rem;
        color: #e0e0e0;
        opacity: 0.5;
    }

    .empty-state p {
        margin: 0;
        font-size: 1rem;
        font-weight: 500;
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .hero-title {
            font-size: 2.5rem;
        }
        
        .hero-subtitle {
            font-size: 1rem;
        }
        
        .hero-header {
            padding: 2rem 1.5rem;
        }
        
        .modern-card {
            padding: 2rem 1.5rem;
        }
        
        .table-header {
            flex-direction: column;
            gap: 1rem;
            align-items: stretch;
            padding: 1.5rem;
        }
        
        .btn-view-all {
            width: 100%;
            justify-content: center;
        }
        
        .tokens-table {
            display: block;
            overflow-x: auto;
        }
    }
</style>
@endpush

@section('content')
<div class="token-page py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        <a href="{{ route('admin.dashboard') }}" class="back-link">
            <i class="fas fa-arrow-left"></i> Volver al Dashboard
        </a>

        <!-- Hero Header -->
        <div class="hero-header text-center">
            <div class="hero-icon"><i class="fas fa-key"></i></div>
            <h1 class="hero-title">Generador de <span>Tokens de Jurado</span></h1>
            <p class="hero-subtitle">Crea tokens de acceso seguro para que los jurados se registren en la plataforma</p>
        </div>

        <!-- Alertas -->
        @if(session('success'))
            <div class="alert-custom alert-success-custom">
                <i class="fas fa-check-circle"></i>
                <div class="alert-content">
                    <p class="alert-title">¡Token generado exitosamente!</p>
                    <p class="alert-text">{{ session('success') }}</p>
                    @if(session('token'))
                        <div class="token-display">
                            <span id="tokenValue">{{ session('token') }}</span>
                            <button class="btn-copy" onclick="copyToken()">
                                <i class="fas fa-copy"></i> Copiar
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        @endif

        @if($errors->any())
            <div class="alert-custom alert-error-custom">
                <i class="fas fa-exclamation-circle"></i>
                <div class="alert-content">
                    <p class="alert-title" style="color: #b91c1c;">Error en el formulario</p>
                    <p class="alert-text" style="color: #dc2626;">{{ $errors->first() }}</p>
                </div>
            </div>
        @endif

        <!-- Content Grid -->
        <div class="content-grid">
            <!-- Form Card -->
            <div class="modern-card">
                <div class="card-header-custom">
                    <i class="fas fa-plus-circle"></i>
                    <h3>Crear Nuevo Token</h3>
                </div>
                
                <form action="{{ route('admin.jurado-tokens.store') }}" method="POST">
                    @csrf
                    
                    <!-- Nombre Completo -->
                    <div class="form-group">
                        <label class="form-label">Nombre(s) del Jurado *</label>
                        <input type="text" name="nombre_destinatario" class="form-input name-input"
                               placeholder="Juan"
                               value="{{ old('nombre_destinatario') }}" required>
                        <div class="form-help">
                            <i class="fas fa-info-circle"></i>
                            Solo se permiten letras y acentos
                        </div>
                        <div class="error-message" style="display: none;">
                            <i class="fas fa-exclamation-triangle"></i>
                            <span>El nombre solo puede contener letras y acentos</span>
                        </div>
                    </div>

                    <!-- Apellido Paterno -->
                    <div class="form-group">
                        <label class="form-label">Apellido Paterno *</label>
                        <input type="text" name="apellido_paterno" class="form-input name-input"
                               placeholder="Pérez"
                               value="{{ old('apellido_paterno') }}" required>
                        <div class="form-help">
                            <i class="fas fa-info-circle"></i>
                            Solo se permiten letras y acentos
                        </div>
                        <div class="error-message" style="display: none;">
                            <i class="fas fa-exclamation-triangle"></i>
                            <span>El apellido solo puede contener letras y acentos</span>
                        </div>
                    </div>

                    <!-- Apellido Materno -->
                    <div class="form-group">
                        <label class="form-label">Apellido Materno</label>
                        <input type="text" name="apellido_materno" class="form-input name-input"
                               placeholder="López"
                               value="{{ old('apellido_materno') }}">
                        <div class="form-help">
                            <i class="fas fa-info-circle"></i>
                            Solo se permiten letras y acentos (opcional)
                        </div>
                        <div class="error-message" style="display: none;">
                            <i class="fas fa-exclamation-triangle"></i>
                            <span>El apellido solo puede contener letras y acentos</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Email del Jurado Invitado</label>
                        <input type="email" name="email" class="form-input"
                               placeholder="jurado@ejemplo.com"
                               value="{{ old('email') }}" required>
                        <div class="form-help">
                            <i class="fas fa-info-circle"></i>
                            Se enviará una invitación a este correo electrónico
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Días de Vigencia</label>
                        <input type="number" name="dias_vigencia" class="form-input" 
                               value="{{ old('dias_vigencia', 15) }}" 
                               min="1" max="90" required>
                        <div class="form-help">
                            <i class="fas fa-clock"></i>
                            El token será válido por este número de días (máx. 90)
                        </div>
                    </div>

                    <button type="submit" class="btn-submit">
                        <i class="fas fa-paper-plane"></i>
                        Generar y Enviar Token
                    </button>
                </form>
            </div>

            <!-- Info Card -->
            <div class="modern-card info-card">
                <div class="card-header-custom">
                    <i class="fas fa-lightbulb"></i>
                    <h3>¿Cómo funciona?</h3>
                </div>

                <ul class="step-list">
                    <li class="step-item">
                        <div class="step-number">1</div>
                        <div class="step-content">
                            <h5>Ingresa el email</h5>
                            <p>Escribe el correo electrónico del jurado que deseas invitar</p>
                        </div>
                    </li>
                    <li class="step-item">
                        <div class="step-number">2</div>
                        <div class="step-content">
                            <h5>Define la vigencia</h5>
                            <p>Establece cuántos días será válido el token de acceso</p>
                        </div>
                    </li>
                    <li class="step-item">
                        <div class="step-number">3</div>
                        <div class="step-content">
                            <h5>Genera el token</h5>
                            <p>Se creará un código único y se enviará automáticamente al jurado</p>
                        </div>
                    </li>
                    <li class="step-item">
                        <div class="step-number">4</div>
                        <div class="step-content">
                            <h5>Registro del jurado</h5>
                            <p>El jurado usará el token para completar su registro en la plataforma</p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Table Section -->
        <div class="modern-card table-container">
            <div class="table-header">
                <h3><i class="fas fa-list"></i> Tokens Recientes</h3>
                <a href="{{ route('admin.jurado-tokens.index') }}" class="btn-view-all">
                    Ver todos <i class="fas fa-arrow-right" style="margin-left: 0.25rem;"></i>
                </a>
            </div>

            <table class="tokens-table">
                <thead>
                    <tr>
                        <th>Token</th>
                        <th>Nombre Completo</th>
                        <th>Email</th>
                        <th>Estado</th>
                        <th>Expiración</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tokens->take(5) as $token)
                        <tr>
                            <td><code class="token-code">{{ $token->token }}</code></td>
                            <td>{{
                                trim(($token->nombre_destinatario ?? '') . ' ' .
                                     ($token->apellido_paterno ?? '') . ' ' .
                                     ($token->apellido_materno ?? '')) ?: 'Sin nombre'
                            }}</td>
                            <td>{{ $token->email_invitado ?? 'N/A' }}</td>
                            <td>
                                @if($token->usado)
                                    <span class="status-badge status-used">Usado</span>
                                @elseif($token->fecha_expiracion < now())
                                    <span class="status-badge status-expired">Expirado</span>
                                @else
                                    <span class="status-badge status-active">Activo</span>
                                @endif
                            </td>
                            <td>{{ $token->fecha_expiracion->format('d/m/Y') }}</td>
                            <td>
                                <button class="btn-action" onclick="navigator.clipboard.writeText('{{ $token->token }}')" title="Copiar token">
                                    <i class="fas fa-copy"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                <div class="empty-state">
                                    <i class="fas fa-inbox"></i>
                                    <p>No hay tokens generados todavía</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function copyToken() {
        const tokenValue = document.getElementById('tokenValue').textContent;
        navigator.clipboard.writeText(tokenValue).then(() => {
            const btn = document.querySelector('.btn-copy');
            btn.innerHTML = '<i class="fas fa-check"></i> Copiado';
            setTimeout(() => {
                btn.innerHTML = '<i class="fas fa-copy"></i> Copiar';
            }, 2000);
        });
    }

    // Validación en tiempo real para campos de nombre
    document.addEventListener('DOMContentLoaded', function() {
        const nameInputs = document.querySelectorAll('.name-input');

        // Expresión regular que solo permite letras, espacios y acentos
        const nameRegex = /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]*$/;

        nameInputs.forEach(input => {
            input.addEventListener('input', function() {
                const value = this.value;
                const errorMessage = this.parentElement.querySelector('.error-message');

                if (value && !nameRegex.test(value)) {
                    // Hay caracteres no válidos
                    this.classList.add('error');

                    // Remover caracteres no válidos
                    const cleanValue = value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '');
                    this.value = cleanValue;

                    // Mostrar mensaje de error
                    errorMessage.style.display = 'flex';

                    // Temporizador para ocultar el error después de 3 segundos
                    clearTimeout(this.errorTimeout);
                    this.errorTimeout = setTimeout(() => {
                        this.classList.remove('error');
                        errorMessage.style.display = 'none';
                    }, 3000);
                } else {
                    // Todo está bien
                    this.classList.remove('error');
                    errorMessage.style.display = 'none';
                    clearTimeout(this.errorTimeout);
                }
            });

            // También validar al perder el foco
            input.addEventListener('blur', function() {
                const value = this.value;
                const errorMessage = this.parentElement.querySelector('.error-message');

                if (value && !nameRegex.test(value)) {
                    this.classList.add('error');
                    errorMessage.style.display = 'flex';
                } else {
                    this.classList.remove('error');
                    errorMessage.style.display = 'none';
                }
            });

            // Ocultar error al empezar a escribir de nuevo
            input.addEventListener('focus', function() {
                if (this.classList.contains('error')) {
                    setTimeout(() => {
                        this.classList.remove('error');
                        this.parentElement.querySelector('.error-message').style.display = 'none';
                    }, 100);
                }
            });
        });
    });
</script>
@endsection
