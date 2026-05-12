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
