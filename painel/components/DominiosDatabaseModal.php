
          <!-- Modal -->
    <div class="modal-overlay" id="modalOverlay">
        <div class="modalDom">
            <div class="modal-headerDom">
                <h2 class="modal-title">
                    <svg width="28" height="28" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                    </svg>
                    Meus Domínios
                </h2>
                <button class="close-button" id="closeModalBtn">
                    <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <div class="domains-grid" id="domainsGrid">
                <!-- Cards serão inseridos aqui via JavaScript -->
            </div>
        </div>
    </div>

 <style> 
        .icon-button {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            border: none;
            border-radius: 16px;
            padding: 20px 32px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 12px;
            font-size: 16px;
            font-weight: 600;
            color: white;
            box-shadow: 0 10px 30px rgba(59, 130, 246, 0.3);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .icon-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .icon-button:hover::before {
            left: 100%;
        }

        .icon-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 40px rgba(59, 130, 246, 0.4);
        }

        .icon-button:active {
            transform: translateY(0);
        }

        .icon {
            width: 24px;
            height: 24px;
        }

        /* Modal Styles */
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.75);
            backdrop-filter: blur(4px);
            z-index: 1000;
            animation: fadeIn 0.3s ease;
        }

        .modal-overlay.active {
             display: flex;
            justify-content: center;
            align-items: flex-start; /* Alinha no topo */
            padding-top: 2%; /* Define a distância de 10% do topo */
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        .modalDom {
            background: #1e293b;
            border-radius: 5px;
            padding: 24px;
            width: 90%;
            max-width: 600px;
            max-height: 85vh;
            overflow-y: auto;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.5);
            animation: slideUp 0.4s ease;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .modalDom {
            transition: transform 0.3s ease, opacity 0.3s ease;
        }

        .modal-overlay.active .modalDom {
            transform: translateY(0);
            opacity: 1;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .modal-headerDom {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .modal-title {
            font-size: 22px;
            font-weight: 700;
            color: #f1f5f9;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .close-button {
            background: transparent;
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 12px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            color: #94a3b8;
        }

        .close-button:hover {
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
            transform: rotate(90deg);
        }

        .domains-grid {
            display: grid;
            gap: 12px;
        }

        .domain-card {
            background: linear-gradient(135deg, #334155 0%, #1e293b 100%);
            border-radius: 12px;
            padding: 16px;
            border: 1px solid rgba(255, 255, 255, 0.05);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .domain-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: linear-gradient(180deg, #3b82f6, #2563eb);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .domain-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.3);
            border-color: rgba(59, 130, 246, 0.3);
        }

        .domain-card:hover::before {
            opacity: 1;
        }

        .domain-card-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 10px;
        }

        .domain-info {
            flex: 1;
        }

        .domain-name {
            font-size: 16px;
            font-weight: 600;
            color: #f1f5f9;
            margin-bottom: 6px;
            word-break: break-all;
        }

        .domain-user {
            font-size: 13px;
            color: #94a3b8;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .domain-actions {
            display: flex;
            gap: 10px;
            align-items: center;
        }

                /* Toggle Switch */
        .switch {
            position: relative;
            width: 44px;
            height: 24px;
            background: #475569;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            border: 2px solid transparent;
            flex-shrink: 0;
        }

        .switch.active {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        }

        .switch-slider {
            position: absolute;
            top: 2px;
            left: 2px;
            width: 18px;
            height: 18px;
            background: white;
            border-radius: 50%;
            transition: all 0.3s ease;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
        }

        .switch.active .switch-slider {
            transform: translateX(20px);
        }
        
              /* Copy Button */
        .copy-button {
            background: rgba(59, 130, 246, 0.1);
            border: 1px solid rgba(59, 130, 246, 0.3);
            border-radius: 8px;
            padding: 6px 12px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 12px;
            font-weight: 500;
            color: #60a5fa;
            transition: all 0.3s ease;
            flex-shrink: 0;
            white-space: nowrap;
        }

        .copy-button:hover {
            background: rgba(59, 130, 246, 0.2);
            border-color: rgba(59, 130, 246, 0.5);
            transform: translateY(-2px);
        }

        .copy-button:active {
            transform: translateY(0);
        }

        .copy-button.copied {
            background: rgba(16, 185, 129, 0.1);
            border-color: rgba(16, 185, 129, 0.5);
            color: #34d399;
        }

                /* Status Badge */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 3px 8px;
            border-radius: 6px;
            font-size: 10px;
            font-weight: 600;
            flex-shrink: 0;
        }

        .status-badge.active {
            background: rgba(16, 185, 129, 0.15);
            color: #34d399;
            border: 1px solid rgba(16, 185, 129, 0.3);
        }

        .status-badge.inactive {
            background: rgba(239, 68, 68, 0.15);
            color: #f87171;
            border: 1px solid rgba(239, 68, 68, 0.3);
        }

        .status-dot {
            width: 4px;
            height: 4px;
            border-radius: 50%;
            animation: pulse 2s ease-in-out infinite;
        }

        .status-badge.active .status-dot {
            background: #34d399;
        }

        .status-badge.inactive .status-dot {
            background: #f87171;
        }

        @keyframes pulse {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: 0.5;
            }
        }

        /* Notification */
        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            padding: 16px 24px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(16, 185, 129, 0.3);
            display: none;
            align-items: center;
            gap: 12px;
            z-index: 2000;
            animation: slideInRight 0.4s ease;
        }

        .notification.show {
            display: flex;
        }

        @keyframes slideInRight {
            from {
                transform: translateX(400px);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        /* Scrollbar */
        .modal::-webkit-scrollbar {
            width: 8px;
        }

        .modal::-webkit-scrollbar-track {
            background: transparent;
        }

        .modal::-webkit-scrollbar-thumb {
            background: #475569;
            border-radius: 4px;
        }

        .modal::-webkit-scrollbar-thumb:hover {
            background: #64748b;
        }

        .riscado {
          text-decoration: line-through;
          text-decoration-color: red;
        }

        /* Responsive */
        @media (max-width: 640px) {

            .modal-body {
                padding: 2px 0px;
            }

            .modal {
                padding: 20px 14px;
            }

            .modal-title {
                font-size: 18px;
            }

            .domain-card {
                padding: 14px 12px;
            }

            .domain-card-header {
                gap: 12px;
            }
           
        }
    </style>
  <!-- Notification -->
    <div class="notification" id="notification">
        <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <span id="notificationText">Copiado com sucesso!</span>
    </div>
