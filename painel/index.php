<?php

session_start();

error_reporting(0);

require_once '../db.php';
require_once "../base/utility.php";

// Pega token da sessão ou do cookie
$token = $_SESSION['token'] ?? null;

if ($token) {

    $sql = "SELECT * FROM users WHERE token = :token LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':token' => $token]);
    $user = $stmt->fetch();

    if (!$user) {
        // Token inválido, limpa sessão e cookie
        session_unset();
        session_destroy();
        header('Location: ../login');
        exit();
    }

    $configuracoes = $user['configuracoes'];
    $delete = $user['delete'];
    $id_user = $user['id'];
    $online = $user['online'];
    $username = $user['username'];

  } else {
    // Sem token, redireciona para login
    header('Location: ../login');
    exit();
}

$DadosIp = getFromIp(getClientIp());

if($DadosIp){
    if($DadosIp->country){
        $servidornet = $DadosIp->org;
        $pais = $DadosIp->country;
        $regionName = $DadosIp->regionName;
        $city = $DadosIp->city;
    }
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=0.8">
    <title>Painel Administrativo</title>
    <link rel="stylesheet" href="./css/styles.css">
    <link rel="icon" href="https://cdn-icons-png.flaticon.com/512/6079/6079584.png" sizes="192x192">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./css/lucide.css">

<?php include_once('./components/style.php'); ?>


<style>

 .typing-indicator {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    width: fit-content;
    margin-top: var(--space-xs);
    animation: fadeIn 0.3s ease;
}

.typing-dot {
    width: 11px;
    height: 11px;
    background-color: #8BC34A;
    border-radius: 50%;
    animation: typingBounce 1.4s infinite ease-in-out both;
}

.typing-dot:nth-child(1) { animation-delay: 0s; }
.typing-dot:nth-child(2) { animation-delay: 0.2s; }
.typing-dot:nth-child(3) { animation-delay: 0.4s; }

.typing-text {
    font-size: 23px;
    color: #8BC34A;
}

.hidden {
    display: none !important;
}

@keyframes typingBounce {
    0%, 80%, 100% { transform: scale(0); }
    40% { transform: scale(1); }
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(5px); }
    to { opacity: 1; transform: translateY(0); }
}


.card-admins-online {
    position: relative;
    display: flex;
    background: #1e1e2f;
    color: #fff;
    cursor: pointer;
    gap: 6px;
    padding: 10px 14px;
    border-radius: 8px;
    cursor: default;
    align-items: center;
}

.tooltip-admins {
  display: none;
  position: absolute;
  top: 120%;
  left: 0;
  background-color: #2c2c3e;
  color: #fff;
  padding: 10px;
  border-radius: 8px;
  box-shadow: 0 4px 12px rgba(0,0,0,0.3);
  z-index: 1000;
  white-space: nowrap;
}

.card-admins-online:hover .tooltip-admins {
  display: block;
}

.status-dot {
  height: 8px;
  width: 8px;
  border-radius: 50%;
  display: inline-block;
  margin-right: 6px;
}

.online {
  background-color: #00c853;
}
.idle {
  background-color: #ffab00;
}
.offline {
  background-color: #d50000;
}

.ver-button {
    background: rgba(59, 130, 246, 0.1);
    border: 1px solid #FFC107;
    border-radius: 8px;
    padding: 6px 12px;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: 12px;
    font-weight: 500;
    color: #FFC107;
    transition: all 0.3s ease;
    flex-shrink: 0;
    white-space: nowrap;
}

@media (max-width: 768px) {
    .header-actions {
        flex-direction: row;
        gap: var(--space-sm);
    }
}

/* Estilos para Modal de Usuários */
.users-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.user-card {
    background: #1e1e2f;
    border-radius: 12px;
    padding: 1.5rem;
    border: 1px solid rgba(255, 255, 255, 0.1);
    transition: all 0.3s ease;
}

.user-card:hover {
    border-color: rgba(139, 195, 74, 0.3);
    box-shadow: 0 4px 12px rgba(139, 195, 74, 0.1);
}

.user-card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
}

.user-info {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.user-avatar {
    width: 48px;
    height: 48px;
    background: linear-gradient(135deg, #8BC34A, #4CAF50);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 600;
    font-size: 18px;
}

.user-details h4 {
    margin: 0;
    color: #fff;
    font-size: 16px;
}

.user-details p {
    margin: 0.25rem 0 0 0;
    color: #9ca3af;
    font-size: 14px;
}

.user-badge {
    padding: 4px 12px;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 500;
}

.config-badge {
    padding: 4px 10px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.3px;
    border: 1px solid rgba(255, 255, 255, 0.12);
    background: rgba(255, 255, 255, 0.04);
}

.config-on {
    color: #8BC34A;
    border-color: rgba(139, 195, 74, 0.6);
    background: rgba(139, 195, 74, 0.12);
}

.config-off {
    color: #f97316;
    border-color: rgba(249, 115, 22, 0.5);
    background: rgba(249, 115, 22, 0.1);
}

.badge-master {
    background: rgba(255, 193, 7, 0.1);
    color: #FFC107;
    border: 1px solid #FFC107;
}

.badge-comum {
    background: rgba(59, 130, 246, 0.1);
    color: #3B82F6;
    border: 1px solid #3B82F6;
}

.user-card-body {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
    margin-bottom: 1rem;
}

.user-field {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.user-field label {
    font-size: 12px;
    color: #9ca3af;
    text-transform: uppercase;
    font-weight: 500;
}

.user-field span {
    color: #fff;
    font-size: 14px;
}

.payment-type {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 4px 8px;
    border-radius: 6px;
    font-size: 12px;
}

.payment-gate {
    background: rgba(139, 195, 74, 0.1);
    color: #8BC34A;
}

.payment-pix {
    background: rgba(59, 130, 246, 0.1);
    color: #3B82F6;
}

.payment-none {
    background: rgba(156, 163, 175, 0.1);
    color: #9ca3af;
}

.user-card-footer {
    display: flex;
    justify-content: flex-end;
    gap: 0.5rem;
    padding-top: 1rem;
    border-top: 1px solid rgba(255, 255, 255, 0.1);
}

.btn-small {
    padding: 6px 12px;
    font-size: 13px;
    border-radius: 6px;
}

.domain-list {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    margin-top: 0.5rem;
}

.domain-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0.75rem;
    background: #151521;
    border-radius: 8px;
    border: 1px solid rgba(255, 255, 255, 0.05);
}

.domain-item-info {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.domain-name {
    color: #8BC34A;
    font-weight: 500;
    font-size: 14px;
}

.domain-path {
    color: #9ca3af;
    font-size: 12px;
}

.domain-status {
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 11px;
    font-weight: 500;
}

.domain-status.ativo {
    background: rgba(139, 195, 74, 0.1);
    color: #8BC34A;
}

.domain-status.inativo {
    background: rgba(239, 68, 68, 0.1);
    color: #EF4444;
}

.edit-user-layout {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
    gap: 1rem;
}

.edit-card {
    background: #151521;
    border: 1px solid rgba(255, 255, 255, 0.08);
    border-radius: 12px;
    padding: 1rem;
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.edit-card .section-header {
    margin-bottom: 0.25rem;
}

.form-group + .form-group {
    margin-top: 0.5rem;
}

.form-inline {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.form-inline label {
    margin: 0;
    white-space: nowrap;
    color: #fff;
}

.form-inline select,
.form-inline input {
    flex: 1;
}

.select-inline {
    background: #0b1220;
    border: 1px solid rgba(255, 255, 255, 0.12);
    border-radius: 10px;
    color: #e5e7eb;
    padding: 10px 14px;
    appearance: none;
    background-image: linear-gradient(45deg, transparent 50%, #8bc34a 50%),
                      linear-gradient(135deg, #8bc34a 50%, transparent 50%);
    background-position: right 14px center, right 8px center;
    background-size: 7px 7px, 7px 7px;
    background-repeat: no-repeat;
    transition: border-color 0.2s, box-shadow 0.2s;
}

.select-inline:focus {
    outline: none;
    border-color: rgba(139, 195, 74, 0.7);
    box-shadow: 0 0 0 3px rgba(139, 195, 74, 0.15);
}

.toggle-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 0.5rem;
    padding: 6px 10px;
    border: 1px solid rgba(255, 255, 255, 0.08);
    border-radius: 8px;
    background: #0f172a;
}
.toggle-row label {
    margin: 0;
    color: #fff;
}
.switch {
    position: relative;
    display: inline-block;
    width: 42px;
    height: 22px;
    flex-shrink: 0;
}
.switch input {
    opacity: 0;
    width: 0;
    height: 0;
}
.slider {
    position: absolute;
    cursor: pointer;
    inset: 0;
    background: #374151;
    transition: 0.25s;
    border-radius: 999px;
    box-shadow: inset 0 0 0 1px rgba(255,255,255,0.08);
}
.slider:before {
    position: absolute;
    content: "";
    height: 16px;
    width: 16px;
    left: 3px;
    top: 3px;
    background-color: #111827;
    border-radius: 50%;
    transition: 0.25s;
    box-shadow: 0 2px 6px rgba(0,0,0,0.35);
}
.switch input:checked + .slider {
    background: linear-gradient(135deg, #8BC34A, #4CAF50);
}
.switch input:checked + .slider:before {
    transform: translateX(18px);
    background-color: #0b1a0a;
}

/* Transaction details modal */
#transactionModal {
    display: none;
    align-items: center;
    justify-content: center;
    background: rgba(0, 0, 0, 0.55);
    z-index: 1200;
}
#transactionModal.active {
    display: flex;
}
.transaction-modal {
    width: min(92vw, 920px);
    background: #0b1220;
    border-radius: 16px;
    border: 1px solid rgba(255, 255, 255, 0.06);
    box-shadow: 0 18px 50px rgba(0, 0, 0, 0.45);
}
.transaction-modal .modal-header {
    border-bottom: 1px solid rgba(255, 255, 255, 0.06);
    padding: 18px 20px;
}
.transaction-modal .modal-body {
    padding: 18px 20px;
}
.transaction-modal .modal-footer {
    border-top: 1px solid rgba(255, 255, 255, 0.06);
    padding: 14px 20px;
    justify-content: flex-end;
}
.transaction-body {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 14px;
}
@media (max-width: 900px) {
    .transaction-body {
        grid-template-columns: 1fr;
    }
}
.transaction-summary {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 10px;
    gap: 10px;
}
.transaction-summary .meta {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
    color: #cbd5e1;
    font-size: 13px;
}
.transaction-summary .meta span {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 10px;
    background: #0f172a;
    border: 1px solid rgba(255, 255, 255, 0.05);
    border-radius: 8px;
}
.transaction-info {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 10px;
}
.transaction-info .info-block {
    background: #0f172a;
    border: 1px solid rgba(255, 255, 255, 0.05);
    border-radius: 10px;
    padding: 10px 12px;
}
.transaction-info label {
    display: block;
    font-size: 12px;
    color: #94a3b8;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    margin-bottom: 4px;
}
.transaction-info .value {
    color: #f8fafc;
    font-size: 14px;
    word-break: break-word;
}
.qr-card {
    background: #0f172a;
    border: 1px solid rgba(255, 255, 255, 0.05);
    border-radius: 12px;
    padding: 12px;
    display: flex;
    flex-direction: column;
    gap: 12px;
}
.qr-card img {
    width: 100%;
    max-width: 280px;
    align-self: center;
    background: rgba(255, 255, 255, 0.04);
    border-radius: 12px;
    padding: 10px;
}
.qr-card .qr-spinner {
    align-self: center;
    width: 180px;
    height: 180px;
    border: 6px solid rgba(255, 255, 255, 0.12);
    border-top-color: #8bc34a;
    border-radius: 50%;
    animation: qr-spin 0.9s linear infinite;
    box-sizing: border-box;
}
@keyframes qr-spin {
    to { transform: rotate(360deg); }
}
.qr-card .qr-code-box {
    width: 100%;
    min-height: 90px;
    max-height: 150px;
    background: #020617;
    border: 1px dashed rgba(255, 255, 255, 0.1);
    color: #cbd5e1;
    border-radius: 10px;
    padding: 10px;
    font-size: 12px;
    resize: none;
}
.qr-card .qr-actions {
    display: flex;
    align-items: center;
    gap: 10px;
    justify-content: space-between;
    flex-wrap: wrap;
}

.modalFa{
    background-color: var(--bg-secondary);
    border: 1px solid var(--border-color);
    border-radius: var(--radius-lg);
    width: 90%;
    max-width: 787px;
    max-height: 90vh;
    overflow-y: auto;
    box-shadow: var(--shadow-lg);
    transform: translateY(-20px);
    transition: var(--transition);
}

</style>
</head>

<body>

<?php if($delete){ ?>

    <?php 

        include_once('./components/notificationModal.php'); 

        include_once('./components/DeleteDatabaseModal.php'); 

     ?>

<?php } ?>

    <!-- Loading Screen -->
    <div id="loading-screen" class="loading-screen">
        <!-- Background with subtle gradient -->
        <div class="loading-background"></div>

        <!-- Animated background elements -->
        <div class="bg-elements">
            <div class="bg-circle circle-1"></div>
            <div class="bg-circle circle-2"></div>
            <div class="bg-circle circle-3"></div>
        </div>

        <!-- Main loading content -->
        <div class="loading-content">

            <!-- Loading spinner -->
            <div class="spinner-container">
                <div class="spinner-outer"></div>
                <div class="spinner-main"></div>
                <div class="spinner-inner"></div>
            </div>

            <!-- Progress bar -->
            <div class="progress-container">
                <div class="progress-bar">
                    <div id="progress-fill" class="progress-fill"></div>
                </div>
            </div>

            <!-- Progress text -->
            <div class="progress-text">
                <div id="progress-percent" class="progress-percent">0%</div>
                <div class="progress-status">Preparando interface...</div>
            </div>

            <!-- Loading dots animation -->
            <div class="loading-dots">
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
            </div>
        </div>
    </div>

    <!-- Dashboard Content -->
    <div id="dashboard" class="dashboard hidden">
        <!-- Header -->
        <header class="header">
            <div class="container">
                <div>
                <h1 class="header-title">Painel <?=$_SESSION['username']?></h1>

                <div class="location">
                        <i data-lucide="map-pin"></i>
                        <span><?=$city?>, <?=$pais?></span>
                    </div>

                </div>
                <div class="header-actions">

                                <?php if($online){ ?>

                                    <div class="card-admins-online">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="users" class="lucide lucide-users stat-icon stat-icon-purple" style="color: #00ff0a;"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><path d="M16 3.128a4 4 0 0 1 0 7.744"></path><path d="M22 21v-2a4 4 0 0 0-3-3.87"></path><circle cx="9" cy="7" r="4"></circle></svg>
                                     Online: <span class="admins-online">0</span>
                                    <div class="tooltip-admins">
                                    </div>
                                    </div>

                                    <?php } ?>

                <?php if($user['role'] == 'master'){ ?>
                    <button class="btn btn-secondary" id="manageUsersBtn" title="Gerenciar Usuários">
                        <i data-lucide="user-cog"></i>
                    </button>
                <?php } ?>

                <?php if($configuracoes){ ?>
                    <button class="btn btn-secondary" id="configBtn">
                        <i data-lucide="settings"></i>
                    </button>
                <?php } ?>

                    <button class="btn btn-secondary hidden" id="openModalBtn" style="background-color: rgb(0 156 6);">
                        <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                    </svg>
                    </button>
                    
                </div>
            </div>
        </header>

        <?php include_once('./components/DominiosDatabaseModal.php'); ?>

        <main class="main">
            <div class="container boxmain">
                <!-- Stats Cards -->
                <section class="stats-grid">
                    <div class="stat-card" onclick="SessaoBox('transacoes')">
                        <div class="stat-header">
                            <span class="stat-label">Total de Valores Pagos</span>
                            <i data-lucide="dollar-sign" class="stat-icon stat-icon-green"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-value" id="totalPaid">R$ 00,00</div>
                            <div class="stat-change">+12.5% desde o último mês</div>
                        </div>
                    </div>

                    <div class="stat-card" onclick="SessaoBox('transacoes')">
                        <div class="stat-header">
                            <span class="stat-label">Faturas Impressas</span>
                            <i data-lucide="file-text" class="stat-icon stat-icon-blue"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-value" id="invoicesPrinted">0</div>
                            <div class="stat-change">+8.2% desde o último mês</div>
                        </div>
                    </div>

                    <div class="stat-card" onclick="SessaoBox('logins')">
                        <div class="stat-header">
                            <span class="stat-label">Total de Logins</span>
                            <i data-lucide="users" class="stat-icon stat-icon-purple"></i>
                        </div>
                        <div class="stat-content">
                            <div style="display: flex;justify-content: space-between;">
                            <div class="stat-value" id="totalLogins">0</div>
                            <div title="Digitando..." class="typing-indicator hidden" id="typingIndicator">
                                <div class="typing-dot"></div>
                                <div class="typing-dot"></div>
                                <div class="typing-dot"></div>
                                <span class="typing-text">0</span>
                            </div>
                        </div>

                            <div class="stat-change">+15.3% desde o último mês</div>
                        </div>
                    </div>

                    <div class="stat-card" onclick="SessaoBox('acessos')">
                        <div class="stat-header">
                            <span class="stat-label">Total de Acessos</span>
                            <img src="data:image/svg+xml;utf8,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2232%22%20height%3D%2232%22%20fill%3D%22none%22%20stroke%3D%22currentColor%22%20stroke-width%3D%222%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%20class%3D%22stat-icon%20stat-icon-blue%22%3E%0A%20%20%3C!--%20Base%20do%20gr%C3%A1fico%20de%20barras%20--%3E%0A%20%20%3Crect%20x%3D%224%22%20y%3D%2214%22%20width%3D%224%22%20height%3D%228%22%20rx%3D%221%22%20fill%3D%22%234f8cff%22%3E%3C%2Frect%3E%0A%20%20%3Crect%20x%3D%2210%22%20y%3D%2210%22%20width%3D%224%22%20height%3D%2212%22%20rx%3D%221%22%20fill%3D%22%234f8cff%22%3E%3C%2Frect%3E%0A%20%20%3Crect%20x%3D%2216%22%20y%3D%226%22%20width%3D%224%22%20height%3D%2216%22%20rx%3D%221%22%20fill%3D%22%234f8cff%22%3E%3C%2Frect%3E%0A%20%20%3Crect%20x%3D%2222%22%20y%3D%222%22%20width%3D%224%22%20height%3D%2220%22%20rx%3D%221%22%20fill%3D%22%234f8cff%22%3E%3C%2Frect%3E%0A%20%20%3C!--%20Seta%20de%20crescimento%20--%3E%0A%20%20%3Cpath%20d%3D%22M2%2022%20L12%2012%20L22%2016%20L32%206%22%20stroke%3D%22%23ffffff%22%20stroke-width%3D%222%22%20fill%3D%22none%22%3E%3C%2Fpath%3E%0A%3C%2Fsvg%3E%0A"
                                class="max-h-96 w-full">
                        </div>
                        <div class="stat-content">
                            <div class="stat-value" id="totalAcessos">0</div>
                            <div class="stat-change">+15.3% desde o último mês</div>
                        </div>
                    </div>
                </section>

                <!-- Data Table Transacoes -->
                <section class="table-section" data-date="transacoes">
                    <div class="table-header">
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                data-lucide="file-text" class="lucide lucide-file-text stat-icon stat-icon-blue">
                                <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"></path>
                                <path d="M14 2v4a2 2 0 0 0 2 2h4"></path>
                                <path d="M10 9H8"></path>
                                <path d="M16 13H8"></path>
                                <path d="M16 17H8"></path>
                            </svg>
                            <h2>Dados de Transações</h2>
                        </div>
                        <button class="btn btn-primary" id="addTestTransactionBtn" type="button">
                            <i data-lucide="plus"></i>
                            Adicionar teste
                        </button>
                    </div>

                    <!-- Filters -->
                    <div class="filters">
                        <div class="search-box" style="align-items: center;display: flex">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" data-lucide="search" class="lucide lucide-search"
                                style="position: absolute;margin-left: 9px;">
                                <path d="m21 21-4.34-4.34"></path>
                                <circle cx="11" cy="11" r="8"></circle>
                            </svg>
                            <input type="text" id="searchInput" placeholder="Buscar por nome, placa ou CPF/CNPJ...">
                        </div>
                        <div class="filter-select">
                            <i data-lucide="filter"></i>
                            <select id="statusFilter">
                                <option value="all">Todos</option>
                                <option value="pago">Pago</option>
                                <option value="pendente">Pendente</option>
                                <option value="cancelado">Cancelado</option>
                            </select>
                        </div>
                    </div>

                    <!-- Table -->
                    <div class="table-container">
                        <table class="data-table" id="dataTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>PAGE</th>
                                    <th>DOC</th>
                                    <th>NOME</th>
                                    <th>DÉBITO</th>
                                    <th>VALOR</th>
                                    <th>IP</th>
                                    <th>PAÍS</th>
                                    <th>IDENTITY</th>
                                    <th>HORA</th>
                                    <th>AÇÕES</th>
                                </tr>
                            </thead>
                            <tbody id="tableBody">
                                <!-- Data will be populated by JavaScript -->
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="pagination" id="paginationTable">
                        <div class="pagination-info" id="paginationInfoTable"></div>
                        <div class="pagination-controls">
                            <button class="btn btn-outline" id="prevTable">Anterior</button>
                            <button class="btn btn-outline" id="nextTable">Próximo</button>
                        </div>
                    </div>
                </section>

                <!-- Data Table Logins -->
                <section class="table-section" data-date="logins" style="display: none;">
                    <div class="table-header">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            data-lucide="users" class="lucide lucide-users stat-icon stat-icon-purple">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                            <path d="M16 3.128a4 4 0 0 1 0 7.744"></path>
                            <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
                            <circle cx="9" cy="7" r="4"></circle>
                        </svg>
                        <h2>Dados de Logins</h2>
                    </div>

                    <!-- Table -->
                    <div class="table-container">
                        <table class="data-table" id="dataTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>PAGE</th>
                                    <th>LOGINS</th>
                                    <th>DADOS</th>
                                    <th>DÉBITOS</th>
                                    <th>IP</th>
                                    <th>PAÍS</th>
                                    <th>IDENTITY</th>
                                    <th>HORA</th>
                                    <th>AÇÕES</th>
                                </tr>
                            </thead>
                            <tbody id="tableBodylogins">
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="pagination" id="paginationLogins">
                        <div class="pagination-info" id="paginationInfoLogins"></div>
                        <div class="pagination-controls">
                            <button class="btn btn-outline" id="prevLogins">Anterior</button>
                            <button class="btn btn-outline" id="nextLogins">Próximo</button>
                        </div>
                    </div>
                </section>


                <!-- Data Table Acessos -->
                <section class="table-section" data-date="acessos" style="display: none;">
                    <div class="table-header">
                        <img src="data:image/svg+xml;utf8,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2232%22%20height%3D%2232%22%20fill%3D%22none%22%20stroke%3D%22currentColor%22%20stroke-width%3D%222%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%20class%3D%22stat-icon%20stat-icon-blue%22%3E%0A%20%20%3C!--%20Base%20do%20gr%C3%A1fico%20de%20barras%20--%3E%0A%20%20%3Crect%20x%3D%224%22%20y%3D%2214%22%20width%3D%224%22%20height%3D%228%22%20rx%3D%221%22%20fill%3D%22%234f8cff%22%3E%3C%2Frect%3E%0A%20%20%3Crect%20x%3D%2210%22%20y%3D%2210%22%20width%3D%224%22%20height%3D%2212%22%20rx%3D%221%22%20fill%3D%22%234f8cff%22%3E%3C%2Frect%3E%0A%20%20%3Crect%20x%3D%2216%22%20y%3D%226%22%20width%3D%224%22%20height%3D%2216%22%20rx%3D%221%22%20fill%3D%22%234f8cff%22%3E%3C%2Frect%3E%0A%20%20%3Crect%20x%3D%2222%22%20y%3D%222%22%20width%3D%224%22%20height%3D%2220%22%20rx%3D%221%22%20fill%3D%22%234f8cff%22%3E%3C%2Frect%3E%0A%20%20%3C!--%20Seta%20de%20crescimento%20--%3E%0A%20%20%3Cpath%20d%3D%22M2%2022%20L12%2012%20L22%2016%20L32%206%22%20stroke%3D%22%23ffffff%22%20stroke-width%3D%222%22%20fill%3D%22none%22%3E%3C%2Fpath%3E%0A%3C%2Fsvg%3E%0A"
                            class="max-h-96 w-full">
                        <h2>Dados de Acessos</h2>
                    </div>

                    <!-- Table -->
                    <div class="table-container">
                        <table class="data-table" id="dataTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>PAGE</th>
                                    <th>PROVEDOR</th>
                                    <th>IP</th>
                                    <th>PAIS</th>
                                    <th>TIME</th>
                                    <th>ACESSO</th>
                                    <th>DEVICE</th>
                                    <th>IDENTITY</th>
                                    <th>AÇÕES</th>
                                </tr>
                            </thead>
                            <tbody id="tableBodyAcessos">
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="pagination" id="paginationAcessos">
                        <div class="pagination-info" id="paginationInfoAcessos"></div>
                        <div class="pagination-controls">
                            <button class="btn btn-outline" id="prevAcessos">Anterior</button>
                            <button class="btn btn-outline" id="nextAcessos">Próximo</button>
                        </div>
                    </div>
                </section>

            </div>
        </main>

        <!-- Footer -->
        <footer class="footer">
            <div class="container">
                <div class="footer-left">
                    <i data-lucide="map-pin"></i>
                    <span>Sistema de Gestão - São Paulo, Brasil</span>
                </div>
                <div class="footer-right">
                    <i data-lucide="calendar"></i>
                    <span id="lastUpdate">Última atualização: --</span>
                </div>
            </div>
        </footer>

        <!-- Configuration Modal -->
        <div class="modal-overlay" id="configModal">
            <div class="modal">
                <div class="modal-header">
                    <h3>
                        <i data-lucide="settings"></i>
                        Configurações do Sistema
                    </h3>
                    <button class="modal-close" id="closeModal">
                        <i data-lucide="x"></i>
                    </button>
                </div>

                <div class="modal-body">
                    <!-- API Keys Section -->
                    <div class="config-section">
                        <div class="section-header">
                            <i data-lucide="key" class="section-icon"></i>
                            <h4>Chaves de Autenticação</h4>
                        </div>
                        <div class="form-group">
                            <label for="gatewayPlatform">Selecionar Plataforma</label>
                            <div class="select-wrapper">


                                <select id="gatewayPlatform">
                                    <option value="podpay">PodPay</option>
                                    <option value="nuviapay">NuviaPay</option>
                                    <option value="freepaybr">FreePaybr</option>
                                    <option value="amorapay">AmoraPay</option>
                                    <option value="blackpay">BlackPay</option>
                                    <option value="alphacashpay">AlphaCashPay</option>
                                    <option value="chavepix">ChavePix</option>
                                </select>
                                <i data-lucide="chevron-down" class="select-arrow"></i>
                            </div>
                            <small class="form-help">💡 Escolha a plataforma de gateway de pagamento que será
                                integrada.</small>
                        </div>

                        <div class="form-group chavepix">
                            <label for="chavepixnome">
                                <i data-lucide="user"></i>
                                Nome
                            </label>
                            <div class="input-group">
                                <input type="text" id="chavepixnome" placeholder="Nome da instituição">
                            </div>
                            <small class="form-help"> Nome da chave que vai receber.</small>
                        </div>

                        <div class="form-group chavepix">
                            <label for="chavepixCidade">
                                <i data-lucide="map-pin"></i>
                                Cidade
                            </label>
                            <div class="input-group">
                                <input type="text" id="chavepixCidade" placeholder="Cidade da instituição">
                            </div>
                            <small class="form-help"> Cidade da chave que vai receber.</small>
                        </div>

                        <div class="form-group chavepix">
                            <label for="chavepix">
                                <i data-lucide="key"></i>
                                Chave Pix
                            </label>
                            <div class="input-group">
                                <input type="text" id="chavepix" placeholder="Chave Aliatoria">
                            </div>
                            <small class="form-help"> Chave pix que vai receber.</small>
                        </div>


                        <div class="form-group apigate">
                            <label for="secretKey">
                                <i data-lucide="lock"></i>
                                Chave Secreta
                            </label>
                            <div class="input-group">
                                <input type="password" id="secretKey" placeholder="sk_live_xxxxxxxxxxxxxxxxxx">
                                <button type="button" class="btn-icon" id="toggleSecret">
                                    <i data-lucide="eye"></i>
                                </button>
                                <button type="button" class="btn-icon" id="copySecret">
                                    <i data-lucide="copy"></i>
                                </button>
                            </div>
                            <small class="form-help">⚠️ Mantenha esta chave em segurança. Nunca a compartilhe
                                publicamente.</small>
                        </div>

                        <div class="form-group apigate">
                            <label for="publicKey">
                                <i data-lucide="unlock"></i>
                                Chave Pública
                            </label>
                            <div class="input-group">
                                <input type="text" id="publicKey" placeholder="pk_live_xxxxxxxxxxxxxxxxxx">
                                <button type="button" class="btn-icon" id="copyPublic">
                                    <i data-lucide="copy"></i>
                                </button>
                            </div>
                            <small class="form-help">Esta chave pode ser usada em aplicações client-side.</small>
                        </div>
                    </div>

                    <!-- Web Router Section -->
                    <div class="config-section apigate">
                        <div class="section-header">
                            <i data-lucide="globe" class="section-icon"></i>
                            <h4>Configurações Web Router</h4>
                        </div>

                        <div class="form-group" style="display: none;">
                            <label for="webRouterUrl">URL do Web Router</label>
                            <div class="input-group">
                                <input type="text" id="webRouterUrl"
                                    placeholder="https://api.webrouter.com.br/v1/gateway/your-endpoint">
                                <button type="button" class="btn btn-small" id="generateUrl">Gerar URL</button>
                            </div>
                            <small class="form-help">💡 URL principal para roteamento de requisições. Clique em "Gerar
                                URL" para uma sugestão.</small>
                        </div>

                        <div class="form-group" style="display: none;">
                            <label for="apiEndpoint">Endpoint da API (Opcional)</label>
                            <input type="text" id="apiEndpoint" placeholder="https://api.exemplo.com/v1">
                        </div>

                        <div class="form-group">
                            <label for="webhookUrl">URL do Webhook</label>
                            <input type="text" id="webhookUrl" placeholder="https://webhook.exemplo.com/notify">
                        </div>
                    </div>

                    <!-- Status Section -->
                    <div class="config-status" id="configStatus" style="display: none;">
                        <div class="status-info">
                            <i data-lucide="alert-circle" class="status-icon"></i>
                            <span class="status-text">Configuração incompleta</span>
                            <span class="status-badge status-pending">Pendente</span>
                        </div>
                        <div class="last-saved" id="lastSaved"></div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-outline" id="cancelConfig">Cancelar</button>
                    <button class="btn btn-primary" id="saveConfig" disabled>
                        <i data-lucide="save"></i>
                        Salvar
                    </button>
                </div>
            </div>
        </div>

        <!-- Modal de Gerenciamento de Usuários -->
        <div class="modal-overlay" id="usersModal">
            <div class="modal" style="max-width: 1200px;">
                <div class="modal-header">
                    <h3>
                        <i data-lucide="user-cog"></i>
                        Gerenciamento de Usuários
                    </h3>
                    <button class="modal-close" id="closeUsersModal">
                        <i data-lucide="x"></i>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="users-list" id="usersList">
                        <!-- Usuários serão carregados aqui via JavaScript -->
                        <div class="loading-users" style="text-align: center; padding: 2rem;">
                            <div class="spinner-container">
                                <div class="spinner-main"></div>
                            </div>
                            <p style="margin-top: 1rem; color: #9ca3af;">Carregando usuários...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal de Edição de Usuário -->
        <div class="modal-overlay" id="editUserModal">
            <div class="modal" style="max-width: 900px;">
                <div class="modal-header">
                    <h3>
                        <i data-lucide="user-cog"></i>
                        Editar Usuário: <span id="editUserName"></span>
                    </h3>
                    <button class="modal-close" id="closeEditUserModal">
                        <i data-lucide="x"></i>
                    </button>
                </div>

                <div class="modal-body">
                    <input type="hidden" id="editUserId">
                    <div class="edit-user-layout">
                        <div class="edit-card">
                            <!-- Configurações de Pagamento -->
                            <div class="section-header">
                                <i data-lucide="credit-card" class="section-icon"></i>
                                <h4>Configurações de Pagamento</h4>
                            </div>
                            <div class="form-group toggle-row">
                                <span style="color:#fff;">Configuração ativa</span>
                                <label class="switch" aria-label="Configuração ativa">
                                    <input type="checkbox" id="editConfigAtivo">
                                    <span class="slider"></span>
                                </label>
                            </div>
                            <div class="form-group form-inline">
                                <label for="editPlataforma">Plataforma:</label>
                                <select id="editPlataforma" class="select-inline">
                                    <option value="">Nenhuma</option>
                                    <option value="podpay">PodPay</option>
                                    <option value="nuviapay">NuviaPay</option>
                                    <option value="freepaybr">FreePaybr</option>
                                    <option value="amorapay">AmoraPay</option>
                                    <option value="blackpay">BlackPay</option>
                                    <option value="alphacashpay">AlphaCashPay</option>
                                    <option value="chavepix">ChavePix</option>
                                </select>
                            </div>

                            <div class="form-group" id="editGateFields" style="display: none;">
                                <label for="editSecretKey">Chave Secreta:</label>
                                <input type="text" id="editSecretKey" placeholder="sk_live_xxxxxxxxxxxxxxxxxx">
                            </div>

                            <div class="form-group" id="editGateFields2" style="display: none;">
                                <label for="editPublicKey">Chave Pública:</label>
                                <input type="text" id="editPublicKey" placeholder="pk_live_xxxxxxxxxxxxxxxxxx">
                            </div>

                            <div class="form-group" id="editPixFields" style="display: none;">
                                <label for="editPixNome">Nome:</label>
                                <input type="text" id="editPixNome" placeholder="Nome da instituição">
                            </div>

                            <div class="form-group" id="editPixFields2" style="display: none;">
                                <label for="editPixCidade">Cidade:</label>
                                <input type="text" id="editPixCidade" placeholder="Cidade da instituição">
                            </div>

                            <div class="form-group" id="editPixFields3" style="display: none;">
                                <label for="editPixChave">Chave PIX:</label>
                                <input type="text" id="editPixChave" placeholder="Chave aleatória">
                            </div>

                            <div class="form-group" id="editWebhookGroup">
                                <label for="editWebhookUrl">URL do Webhook:</label>
                                <input type="text" id="editWebhookUrl" placeholder="https://webhook.exemplo.com/notify">
                            </div>
                        </div>

                        <div class="edit-card">
                            <!-- Domínios -->
                            <div class="section-header">
                                <i data-lucide="globe" class="section-icon"></i>
                                <h4>Domínios Associados</h4>
                            </div>
                            <div id="userDomains">
                                <!-- Domínios serão carregados aqui -->
                                <p style="color: #9ca3af;">Carregando domínios...</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-outline" id="cancelEditUser">Cancelar</button>
                    <button class="btn btn-primary" id="saveEditUser">
                        <i data-lucide="save"></i>
                        Salvar Alterações
                    </button>
                </div>
            </div>
        </div>

        <!-- Transaction Details Modal -->
        <div class="modal-overlay" id="transactionModal">
            <div class="modalFa transaction-modal">
                <div class="modal-header">
                    <h3>
                        <i data-lucide="eye"></i>
                        Detalhes da Transação
                    </h3>
                    <button class="modal-close" id="closeTransactionModal">
                        <i data-lucide="x"></i>
                    </button>
                </div>
                <div class="modal-body transaction-body">
                    <div>
                        <div class="transaction-summary">
                            <div class="meta">
                                <span><strong id="transactionId">-</strong></span>
                                <span id="transactionPage">-</span>
                            </div>
                            <span class="status-badge" id="transactionStatus">-</span>
                        </div>
                        <div class="transaction-info">
                            <div class="info-block"><label>Nome</label><div class="value" id="transactionNome">-</div></div>
                            <div class="info-block"><label>Documento</label><div class="value" id="transactionDoc">-</div></div>
                            <div class="info-block"><label>Débito</label><div class="value" id="transactionDebito">-</div></div>
                            <div class="info-block"><label>Valor</label><div class="value" id="transactionValor">-</div></div>
                            <div class="info-block"><label>IP</label><div class="value" id="transactionIp">-</div></div>
                            <div class="info-block"><label>País</label><div class="value" id="transactionPais">-</div></div>
                            <div class="info-block"><label>Identity</label><div class="value" id="transactionIdentity">-</div></div>
                            <div class="info-block"><label>Hora</label><div class="value" id="transactionHora">-</div></div>
                        </div>
                    </div>
                    <div class="qr-card" id="transactionQrWrapper">
                        <div class="qr-spinner hidden" id="transactionQrSpinner"></div>
                        <img id="transactionQr" src="" alt="QR Code PIX">
                        <textarea class="qr-code-box" id="transactionPixText" readonly></textarea>
                        <div class="qr-actions">
                            <button class="btn btn-primary" id="copyPixBtn" style="width: 100%;text-align: center;justify-content: center;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="copy" class="lucide lucide-copy"><rect width="14" height="14" x="8" y="8" rx="2" ry="2"></rect><path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"></path></svg>
                                Copiar PIX
                            </button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-outline" id="closeTransactionFooter">Fechar</button>
                </div>
            </div>
        </div>

        <!-- Toast Notifications -->
        <div class="toast-container" id="toastContainer"></div>
    </div>

    <!-- Scripts -->
    <script src="./js/lucide.js"></script>
    <script src="./js/data.js"></script>

    <?php include_once('./components/scriptX.php'); ?>

    <?php include_once('./components/painel.php'); ?>

    <?php if($user['role'] == 'master'){ ?>

        
    <script> // Gerenciamento de Usuários - Apenas para Master
 //src="./js/gerenciar_usuarios.js"
// Gerenciamento de Usuários - Apenas para Master

// Abrir modal de usuários
const manageUsersBtn = document.getElementById('manageUsersBtn');
const usersModal = document.getElementById('usersModal');
const closeUsersModal = document.getElementById('closeUsersModal');

if (manageUsersBtn) {
    manageUsersBtn.addEventListener('click', () => {
        usersModal.classList.add('active');
        carregarUsuarios();
    });
}

if (closeUsersModal) {
    closeUsersModal.addEventListener('click', () => {
        usersModal.classList.remove('active');
    });
}

// Fechar modal ao clicar fora
if (usersModal) {
    usersModal.addEventListener('click', (e) => {
        if (e.target === usersModal) {
            usersModal.classList.remove('active');
        }
    });
}

// Modal de edição de usuário
const editUserModal = document.getElementById('editUserModal');
const closeEditUserModal = document.getElementById('closeEditUserModal');
const cancelEditUser = document.getElementById('cancelEditUser');
const saveEditUser = document.getElementById('saveEditUser');

if (closeEditUserModal) {
    closeEditUserModal.addEventListener('click', () => {
        editUserModal.classList.remove('active');
    });
}

if (cancelEditUser) {
    cancelEditUser.addEventListener('click', () => {
        editUserModal.classList.remove('active');
    });
}

if (editUserModal) {
    editUserModal.addEventListener('click', (e) => {
        if (e.target === editUserModal) {
            editUserModal.classList.remove('active');
        }
    });
}

// Carregar usuários
async function carregarUsuarios() {
    const usersList = document.getElementById('usersList');
    usersList.innerHTML = `
        <div class="loading-users" style="text-align: center; padding: 2rem;">
            <div class="spinner-container">
                <div class="spinner-main"></div>
            </div>
            <p style="margin-top: 1rem; color: #9ca3af;">Carregando usuários...</p>
        </div>
    `;

    try {
        const response = await fetch('./dados/listar_usuarios.php');
        const data = await response.json();

        if (data.success && data.users) {
            renderizarUsuarios(data.users);
        } else {
            usersList.innerHTML = `
                <div style="text-align: center; padding: 2rem; color: #ef4444;">
                    <i data-lucide="alert-circle" style="width: 48px; height: 48px;"></i>
                    <p style="margin-top: 1rem;">${data.error || 'Erro ao carregar usuários'}</p>
                </div>
            `;
            lucide.createIcons();
        }
    } catch (error) {
        console.error('Erro ao carregar usuários:', error);
        usersList.innerHTML = `
            <div style="text-align: center; padding: 2rem; color: #ef4444;">
                <i data-lucide="alert-circle" style="width: 48px; height: 48px;"></i>
                <p style="margin-top: 1rem;">Erro ao carregar usuários</p>
            </div>
        `;
        lucide.createIcons();
    }
}

// Renderizar lista de usuários
function renderizarUsuarios(users) {
    const usersList = document.getElementById('usersList');
    
    if (users.length === 0) {
        usersList.innerHTML = `
            <div style="text-align: center; padding: 2rem; color: #9ca3af;">
                <i data-lucide="users" style="width: 48px; height: 48px;"></i>
                <p style="margin-top: 1rem;">Nenhum usuário encontrado</p>
            </div>
        `;
        lucide.createIcons();
        return;
    }

    let html = '';
    users.forEach(user => {
        const inicial = user.username.charAt(0).toUpperCase();
        const roleBadge = user.role === 'master' ? 'badge-master' : 'badge-comum';
        const roleText = user.role === 'master' ? 'Master' : 'Comum';
        const configActive = Number(user.configuracoes || 0) === 1;
        const configBadge = `<span class="config-badge ${configActive ? 'config-on' : 'config-off'}">${configActive ? 'Configuração ativa' : 'Configuração inativa'}</span>`;
        
        let paymentType = 'Nenhuma';
        let paymentClass = 'payment-none';
        let paymentInfo = '';
        
        if (user.config) {
            if (user.config.Plataforma === 'chavepix') {
                paymentType = 'Chave PIX';
                paymentClass = 'payment-pix';
                paymentInfo = `
                    <div class="user-field">
                        <label>Chave PIX</label>
                        <span>${user.config.chave || 'Não configurada'}</span>
                    </div>
                    <div class="user-field">
                        <label>Nome</label>
                        <span>${user.config.nome || 'N/A'}</span>
                    </div>
                    <div class="user-field">
                        <label>Cidade</label>
                        <span>${user.config.cidade || 'N/A'}</span>
                    </div>
                `;
            } else if (user.config.Plataforma) {
                paymentType = user.config.Plataforma.toUpperCase();
                paymentClass = 'payment-gate';
                paymentInfo = `
                    <div class="user-field">
                        <label>Secret Key</label>
                        <span>${user.config.secret_key ? '****' + user.config.secret_key.slice(-8) : 'N/A'}</span>
                    </div>
                    <div class="user-field">
                        <label>Public Key</label>
                        <span>${user.config.public_key ? '****' + user.config.public_key.slice(-8) : 'N/A'}</span>
                    </div>
                `;
            }
        }

        const dominiosCount = user.dominios.length;
        const dominiosText = dominiosCount === 0 ? 'Nenhum domínio' : 
                           dominiosCount === 1 ? '1 domínio' : 
                           `${dominiosCount} domínios`;

        html += `
            <div class="user-card">
                <div class="user-card-header">
                    <div class="user-info">
                        <div class="user-avatar">${inicial}</div>
                        <div class="user-details">
                            <h4>${user.username}</h4>
                            <p>${user.email}</p>
                        </div>
                    </div>
                    <div style="display:flex; gap:8px; align-items:center; flex-wrap:wrap; justify-content:flex-end;">
                        <span class="user-badge ${roleBadge}">${roleText}</span>
                        ${configBadge}
                    </div>
                </div>
                <div class="user-card-body">
                    <div class="user-field">
                        <label>Plataforma de Pagamento</label>
                        <span class="payment-type ${paymentClass}">${paymentType}</span>
                    </div>
                    ${paymentInfo}
                    <div class="user-field">
                        <label>Domínios</label>
                        <span>${dominiosText}</span>
                    </div>
                    <div class="user-field">
                        <label>Último Login</label>
                        <span>${user.last_login ? formatarData(user.last_login) : 'Nunca'}</span>
                    </div>
                </div>
                <div class="user-card-footer">
                    <button class="btn btn-outline btn-small" onclick="editarUsuario(${user.id})">
                        <i data-lucide="edit"></i>
                        Editar
                    </button>
                </div>
            </div>
        `;
    });

    usersList.innerHTML = html;
    lucide.createIcons();
}

// Editar usuário
async function editarUsuario(userId) {
    try {
        const response = await fetch('./dados/listar_usuarios.php');
        const data = await response.json();

        if (data.success && data.users) {
            const user = data.users.find(u => u.id === userId);
            if (user) {
                preencherFormularioEdicao(user);
                editUserModal.classList.add('active');
            }
        }
    } catch (error) {
        console.error('Erro ao carregar dados do usuário:', error);
        showToast('Erro ao carregar dados do usuário', 'error');
    }
}

// Preencher formulário de edição
function preencherFormularioEdicao(user) {
    const setValue = (id, val, prop = 'value') => {
        const el = document.getElementById(id);
        if (el) {
            el[prop] = val;
        }
    };

    setValue('editUserId', user.id);
    setValue('editUserName', user.username, 'textContent');

    const nameLabel = document.getElementById('editUsernameLabel');
    const roleBadge = document.getElementById('editRoleBadge');
    const avatar = document.getElementById('editUserAvatar');
    if (nameLabel) nameLabel.textContent = user.username;
    if (avatar) avatar.textContent = user.username.charAt(0).toUpperCase();
    if (roleBadge) {
        const isMaster = user.role === 'master';
        roleBadge.textContent = isMaster ? 'Master' : 'Comum';
        roleBadge.className = `user-badge ${isMaster ? 'badge-master' : 'badge-comum'}`;
    }

    // Preencher configurações
    if (user.config) {
        setValue('editPlataforma', user.config.Plataforma || '');
        setValue('editSecretKey', user.config.secret_key || '');
        setValue('editPublicKey', user.config.public_key || '');
        setValue('editWebhookUrl', user.config.webhook_url || '');
        setValue('editPixNome', user.config.nome || '');
        setValue('editPixCidade', user.config.cidade || '');
        setValue('editPixChave', user.config.chave || '');
    } else {
        setValue('editPlataforma', '');
        setValue('editSecretKey', '');
        setValue('editPublicKey', '');
        setValue('editWebhookUrl', '');
        setValue('editPixNome', '');
        setValue('editPixCidade', '');
        setValue('editPixChave', '');
    }

    // Flag de configuração ativa vem do usuário; se ausente, ativa quando existe config
    const configuracoesFlag = user.configuracoes !== undefined
        ? Number(user.configuracoes) === 1
        : Boolean(user.config && user.config.Plataforma);
    setValue('editConfigAtivo', configuracoesFlag, 'checked');

    // Mostrar/ocultar campos baseado na plataforma
    toggleEditPaymentFields();

    // Renderizar domínios
    renderizarDominiosUsuario(user.dominios);
}

// Toggle campos de pagamento na edição
const editPlataforma = document.getElementById('editPlataforma');
if (editPlataforma) {
    editPlataforma.addEventListener('change', toggleEditPaymentFields);
}

function toggleEditPaymentFields() {
    const plataformaSelect = document.getElementById('editPlataforma');
    const gateFields = document.getElementById('editGateFields');
    const gateFields2 = document.getElementById('editGateFields2');
    const pixFields = document.getElementById('editPixFields');
    const pixFields2 = document.getElementById('editPixFields2');
    const pixFields3 = document.getElementById('editPixFields3');
    const webhookGroup = document.getElementById('editWebhookGroup');

    // Se algum campo não existir (HTML não carregado), sai silenciosamente para evitar erro
    if (!plataformaSelect || !gateFields || !gateFields2 || !pixFields || !pixFields2 || !pixFields3 || !webhookGroup) {
        return;
    }

    const plataforma = plataformaSelect.value;

    if (plataforma === 'chavepix') {
        gateFields.style.display = 'none';
        gateFields2.style.display = 'none';
        pixFields.style.display = 'block';
        pixFields2.style.display = 'block';
        pixFields3.style.display = 'block';
        webhookGroup.style.display = 'none';
    } else if (plataforma === '') {
        gateFields.style.display = 'none';
        gateFields2.style.display = 'none';
        pixFields.style.display = 'none';
        pixFields2.style.display = 'none';
        pixFields3.style.display = 'none';
        webhookGroup.style.display = 'block';
    } else {
        gateFields.style.display = 'block';
        gateFields2.style.display = 'block';
        pixFields.style.display = 'none';
        pixFields2.style.display = 'none';
        pixFields3.style.display = 'none';
        webhookGroup.style.display = 'block';
    }
}

// Renderizar domínios do usuário
function renderizarDominiosUsuario(dominios) {
    const userDomains = document.getElementById('userDomains');
    
    if (dominios.length === 0) {
        userDomains.innerHTML = `
            <p style="color: #9ca3af; text-align: center; padding: 1rem;">
                Este usuário não possui domínios associados
            </p>
        `;
        return;
    }

    let html = '<div class="domain-list">';
    dominios.forEach(dominio => {
        const statusClass = dominio.status === 'ativo' ? 'ativo' : 'inativo';
        html += `
            <div class="domain-item">
                <div class="domain-item-info">
                    <div class="domain-name">${dominio.nome_dominio}</div>
                    ${dominio.page ? `<div class="domain-path">Page: ${dominio.page}</div>` : ''}
                </div>
                <span class="domain-status ${statusClass}">${dominio.status}</span>
            </div>
        `;
    });
    html += '</div>';
    
    userDomains.innerHTML = html;
}

// Salvar edição de usuário
if (saveEditUser) {
    saveEditUser.addEventListener('click', async () => {
        const userId = document.getElementById('editUserId').value;
        const plataforma = document.getElementById('editPlataforma').value;
        const ativoCheckbox = document.getElementById('editConfigAtivo');
        
        const dados = {
            id_usuario: userId,
            plataforma: plataforma,
            webhook_url: document.getElementById('editWebhookUrl').value,
            configuracoes: ativoCheckbox && ativoCheckbox.checked ? 1 : 0
        };

        if (plataforma === 'chavepix') {
            dados.nome = document.getElementById('editPixNome').value;
            dados.cidade = document.getElementById('editPixCidade').value;
            dados.chave = document.getElementById('editPixChave').value;
            dados.secret_key = '';
            dados.public_key = '';
        } else if (plataforma) {
            dados.secret_key = document.getElementById('editSecretKey').value;
            dados.public_key = document.getElementById('editPublicKey').value;
            dados.nome = '';
            dados.cidade = '';
            dados.chave = '';
        }

        try {
            const response = await fetch('./dados/atualizar_usuario.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(dados)
            });

            const result = await response.json();

            if (result.success) {
                showToast('Configurações atualizadas com sucesso!', 'success');
                editUserModal.classList.remove('active');
                carregarUsuarios(); // Recarregar lista de usuários
            } else {
                showToast(result.error || 'Erro ao atualizar configurações', 'error');
            }
        } catch (error) {
            console.error('Erro ao salvar:', error);
            showToast('Erro ao salvar configurações', 'error');
        }
    });
}

// Função auxiliar para formatar data
function formatarData(dateString) {
    if (!dateString) return 'N/A';
    const date = new Date(dateString);
    return date.toLocaleString('pt-BR', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
}

 </script>
    <?php } ?>

    <?php include_once('./components/script.php'); ?>

   
</body>

</html>
