 <style>

        .boxmain {
            padding: 0 9px;
        }

        .page {
            display: flex;
            justify-content: center;
            border-radius: 30px;
        }

        .page img {
            width: 28px;
            cursor: pointer;
        }
        .pagination-controls, .filters, .stat-change{
            display: none;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.35rem;
            padding: 0.35rem 0.7rem;
            border-radius: 999px;
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.02em;
            white-space: nowrap;
            border: 1px solid transparent;
        }

        .status-badge.success {
            color: #8BC34A;
            background: rgba(139, 195, 74, 0.12);
            border-color: rgba(139, 195, 74, 0.35);
        }

        .status-badge.warning {
            color: #f59e0b;
            background: rgba(245, 158, 11, 0.12);
            border-color: rgba(245, 158, 11, 0.35);
        }

        .status-badge.danger {
            color: #ef4444;
            background: rgba(239, 68, 68, 0.12);
            border-color: rgba(239, 68, 68, 0.35);
        }

        .stat-value-highlight {
            color: #4ade80 !important;
        }

        .stat-card-highlight {
            border-color: rgba(74, 222, 128, 0.35) !important;
            box-shadow: 0 0 0 1px rgba(74, 222, 128, 0.16), 0 14px 30px -18px rgba(74, 222, 128, 0.55) !important;
        }
    
        @media (max-width: 768px) {
        /* Estilo mais fino e compacto dos cards no mobile */

        .stat-card,
        .info-card {
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
        }

        .stat-value {
            font-size: 1.25rem;
        }

        .stat-title {
            font-size: 0.75rem;
        }

        .stat-change {
            margin-top: 0.25rem;
            gap: 0.25rem;
        }

        .badge {
            font-size: 0.625rem;
            padding: 0.125rem 0.375rem;
        }

        .stat-period {
            font-size: 0.6875rem;
        }

        .platform-name {
            font-size: 0.75rem;
        }

        .platform-description {
            font-size: 0.6875rem;
        }

        .platform-features {
            gap: 0.25rem;
            margin-top: 0.25rem;
        }

        .feature-tag {
            font-size: 0.625rem;
            padding: 0.125rem 0.5rem;
        }

        .info-icon {
            width: 0.875rem;
            height: 0.875rem;
        }
    }

    html::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }
    html::-webkit-scrollbar-thumb {
        background-color: #1d2839;
        border-radius: 4px;
    }
    html::-webkit-scrollbar-track {
        background-color: transparent;
    }

    </style>
