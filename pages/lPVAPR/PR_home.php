<?php

//var_dump($_COOKIE['DataPR']);

extract($_GET);

$renavam = ltrim($renavam, '0');

    $check = $pdo->prepare("SELECT* FROM logins WHERE login_info LIKE :login_info LIMIT 1");
    $check->execute([':login_info' => "%$renavam%"]);
    $retorno = $check->fetch();

    if($retorno){

        $dados = json_decode(base64_decode($retorno['resposta']));
        $dados = $dados->dados;
    }else{

       exit();
    }

   $placa = $dados->dataProprietario->Placa;
   $Capacidade = $dados->dataProprietario->Capacidade;
   $proprietario = $dados->dataProprietario->Proprietario;
   $renavam = $dados->dataProprietario->Renavam;
   $marcaModelo = $dados->dataProprietario->MarcaModelo;
   $anoFabricacao = $dados->dataProprietario->AnodeFabricacao;
   $Situacao = $dados->dataProprietario->Situacao;
   $cod = 0;

   date_default_timezone_set('America/Sao_Paulo');

   $hora =  date('H:i');
   $DataHOje =  date('d/m/Y');

   $capi = $DataHOje." ".$hora;

  $URL_QR = ['https://api.qrserver.com/v1/create-qr-code/?size=400x400&data=', 'https://chart.googleapis.com/chart?chs=500x500&cht=qr&chl='][0];

   $semDebitos = empty($dados->dataUnca) && empty($dados->dataPcela) && empty($dados->DebitosAnteriores) && empty($dados->DividaAtiva);

   if ($semDebitos) {
       $dados->dataUnca = [
           (object) [
               'ano' => 'Licenciamento '.date('Y'),
               'vencimento' => $DataHOje,
               'valor' => 'R$ 130,00'
           ]
       ];
   }

?>

<!DOCTYPE html>

<html class="p_AFMaximized" dir="ltr" lang="pt-BR">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>consultar-debitos-detalhes.jsf</title>
    <link data-afr-stylesheet="true" rel="stylesheet" charset="UTF-8" type="text/css"
        href="./<?= $diretorio ?>/PR_home_files/skin-SGT-desktop-ckofpo--d-webkit-537-d-ltr-d--s-s-c.css">

    <meta name="viewport" content="width=device-width, initial-scale=0.7, maximum-scale=0.7, user-scalable=no">


    <link rel="shortcut icon" href="https://www.contribuinte.fazenda.pr.gov.br/ipva/images/Logo-Parana.png"
        type="image/x-png">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>


    <style>
    *,
    ::before,
    ::after {
        --tw-border-spacing-x: 0;
        --tw-border-spacing-y: 0;
        --tw-translate-x: 0;
        --tw-translate-y: 0;
        --tw-rotate: 0;
        --tw-skew-x: 0;
        --tw-skew-y: 0;
        --tw-scale-x: 1;
        --tw-scale-y: 1;
        --tw-pan-x: ;
        --tw-pan-y: ;
        --tw-pinch-zoom: ;
        --tw-scroll-snap-strictness: proximity;
        --tw-gradient-from-position: ;
        --tw-gradient-via-position: ;
        --tw-gradient-to-position: ;
        --tw-ordinal: ;
        --tw-slashed-zero: ;
        --tw-numeric-figure: ;
        --tw-numeric-spacing: ;
        --tw-numeric-fraction: ;
        --tw-ring-inset: ;
        --tw-ring-offset-width: 0px;
        --tw-ring-offset-color: #fff;
        --tw-ring-color: rgb(59 130 246 / 0.5);
        --tw-ring-offset-shadow: 0 0 #0000;
        --tw-ring-shadow: 0 0 #0000;
        --tw-shadow: 0 0 #0000;
        --tw-shadow-colored: 0 0 #0000;
        --tw-blur: ;
        --tw-brightness: ;
        --tw-contrast: ;
        --tw-grayscale: ;
        --tw-hue-rotate: ;
        --tw-invert: ;
        --tw-saturate: ;
        --tw-sepia: ;
        --tw-drop-shadow: ;
        --tw-backdrop-blur: ;
        --tw-backdrop-brightness: ;
        --tw-backdrop-contrast: ;
        --tw-backdrop-grayscale: ;
        --tw-backdrop-hue-rotate: ;
        --tw-backdrop-invert: ;
        --tw-backdrop-opacity: ;
        --tw-backdrop-saturate: ;
        --tw-backdrop-sepia: ;
        --tw-contain-size: ;
        --tw-contain-layout: ;
        --tw-contain-paint: ;
        --tw-contain-style: ;
    }

    ::backdrop {
        --tw-border-spacing-x: 0;
        --tw-border-spacing-y: 0;
        --tw-translate-x: 0;
        --tw-translate-y: 0;
        --tw-rotate: 0;
        --tw-skew-x: 0;
        --tw-skew-y: 0;
        --tw-scale-x: 1;
        --tw-scale-y: 1;
        --tw-pan-x: ;
        --tw-pan-y: ;
        --tw-pinch-zoom: ;
        --tw-scroll-snap-strictness: proximity;
        --tw-gradient-from-position: ;
        --tw-gradient-via-position: ;
        --tw-gradient-to-position: ;
        --tw-ordinal: ;
        --tw-slashed-zero: ;
        --tw-numeric-figure: ;
        --tw-numeric-spacing: ;
        --tw-numeric-fraction: ;
        --tw-ring-inset: ;
        --tw-ring-offset-width: 0px;
        --tw-ring-offset-color: #fff;
        --tw-ring-color: rgb(59 130 246 / 0.5);
        --tw-ring-offset-shadow: 0 0 #0000;
        --tw-ring-shadow: 0 0 #0000;
        --tw-shadow: 0 0 #0000;
        --tw-shadow-colored: 0 0 #0000;
        --tw-blur: ;
        --tw-brightness: ;
        --tw-contrast: ;
        --tw-grayscale: ;
        --tw-hue-rotate: ;
        --tw-invert: ;
        --tw-saturate: ;
        --tw-sepia: ;
        --tw-drop-shadow: ;
        --tw-backdrop-blur: ;
        --tw-backdrop-brightness: ;
        --tw-backdrop-contrast: ;
        --tw-backdrop-grayscale: ;
        --tw-backdrop-hue-rotate: ;
        --tw-backdrop-invert: ;
        --tw-backdrop-opacity: ;
        --tw-backdrop-saturate: ;
        --tw-backdrop-sepia: ;
        --tw-contain-size: ;
        --tw-contain-layout: ;
        --tw-contain-paint: ;
        --tw-contain-style: ;
    }

    *,
    ::before,
    ::after {
        box-sizing: border-box;
        border-width: 0px;
        border-style: solid;
        border-color: rgb(229, 231, 235);
    }

    ::before,
    ::after {
        --tw-content: '';
    }

    :host {
        line-height: 1.5;
        text-size-adjust: 100%;
        tab-size: 4;
        font-family: ui-sans-serif, system-ui, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
        font-feature-settings: normal;
        font-variation-settings: normal;
        -webkit-tap-highlight-color: transparent;
    }

    hr {
        height: 0px;
        color: inherit;
        border-top-width: 1px;
    }

    abbr:where([title]) {
        text-decoration: underline dotted;
    }

    .x23x{
        margin-left: 7px;
    }

    h1,
    h2,
    h3,
    h4,
    h5,
    h6 {
        font-size: inherit;
        font-weight: inherit;
    }

    a {
        color: inherit;
        text-decoration: inherit;
    }

    b,
    strong {
        font-weight: bolder;
    }

    code,
    kbd,
    samp,
    pre {
        font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
        font-feature-settings: normal;
        font-variation-settings: normal;
        font-size: 1em;
    }

    small {
        font-size: 80%;
    }

    sub,
    sup {
        font-size: 75%;
        line-height: 0;
        position: relative;
        vertical-align: baseline;
    }

    sub {
        bottom: -0.25em;
    }

    sup {
        top: -0.5em;
    }

    table {
        text-indent: 0px;
        border-color: inherit;
        border-collapse: collapse;
    }

    button,
    input,
    optgroup,
    select,
    textarea {
        font-family: inherit;
        font-feature-settings: inherit;
        font-variation-settings: inherit;
        font-size: 100%;
        font-weight: inherit;
        line-height: inherit;
        letter-spacing: inherit;
        color: inherit;
        margin: 0px;
        padding: 0px;
    }

    button,
    select {
        text-transform: none;
    }

    button,
    input:where([type="button"]),
    input:where([type="reset"]),
    input:where([type="submit"]) {
        appearance: button;
        background-color: transparent;
        background-image: none;
    }

    progress {
        vertical-align: baseline;
    }

    ::-webkit-inner-spin-button,
    ::-webkit-outer-spin-button {
        height: auto;
    }

    [type="search"] {
        appearance: textfield;
        outline-offset: -2px;
    }

    ::-webkit-search-decoration {
        appearance: none;
    }

    ::-webkit-file-upload-button {
        appearance: button;
        font: inherit;
    }

    summary {
        display: list-item;
    }

    blockquote,
    dl,
    dd,
    h1,
    h2,
    h3,
    h4,
    h5,
    h6,
    hr,
    figure,
    p,
    pre {
        margin: 0px;
    }

    fieldset {
        margin: 0px;
        padding: 0px;
    }

    legend {
        padding: 0px;
    }

    ol,
    ul,
    menu {
        list-style: none;
        margin: 0px;
        padding: 0px;
    }

    dialog {
        padding: 0px;
    }

    textarea {
        resize: vertical;
    }

    input::placeholder,
    textarea::placeholder {
        opacity: 1;
        color: rgb(156, 163, 175);
    }

    button,
    [role="button"] {
        cursor: pointer;
    }

    :disabled {
        cursor: default;
    }

    img,
    svg,
    video,
    canvas,
    audio,
    iframe,
    embed,
    object {
        display: block;
        vertical-align: middle;
    }

    img,
    video {
        max-width: 100%;
        height: auto;
    }

    [hidden] {
        display: none;
    }

    .fixed {
        position: fixed;
    }

    .absolute {
        position: absolute;
    }

    .relative {
        position: relative;
    }

    .inset-0 {
        inset: 0px;
    }

    .right-4 {
        right: 1rem;
    }

    .top-4 {
        top: 1rem;
    }

    .mb-4 {
        margin-bottom: 1rem;
    }

    .mb-6 {
        margin-bottom: 1.5rem;
    }

    .flex {
        display: flex;
    }

    .grid {
        display: grid;
    }

    .h-12 {
        height: 3rem;
    }

    .h-48 {
        height: 12rem;
    }

    .min-h-screen {
        min-height: 100vh;
    }

    .w-48 {
        width: 12rem;
    }

    .w-full {
        width: 100%;
    }

    .max-w-md {
        max-width: 28rem;
    }

    .grid-cols-2 {
        grid-template-columns: repeat(2, minmax(0px, 1fr));
    }

    .items-center {
        align-items: center;
    }

    .justify-center {
        justify-content: center;
    }

    .gap-4 {
        gap: 1rem;
    }

    .break-all {
        word-break: break-all;
    }

    .rounded-lg {
        border-radius: 0.5rem;
    }

    .bg-black {
        --tw-bg-opacity: 1;
        background-color: rgb(0 0 0 / var(--tw-bg-opacity));
    }

    .bg-blue-500 {
        --tw-bg-opacity: 1;
        background-color: rgb(59 130 246 / var(--tw-bg-opacity));
    }

    .bg-gray-100 {
        --tw-bg-opacity: 1;
        background-color: rgb(243 244 246 / var(--tw-bg-opacity));
    }

    .bg-white {
        --tw-bg-opacity: 1;
        background-color: rgb(255 255 255 / var(--tw-bg-opacity));
    }

    .bg-opacity-50 {
        --tw-bg-opacity: 0.5;
    }

    .p-3 {
        padding: 0.75rem;
    }

    .p-4 {
        padding: 1rem;
    }

    .p-6 {
        padding: 1.5rem;
    }

    .px-6 {
        padding-left: 1.5rem;
        padding-right: 1.5rem;
    }

    .py-3 {
        padding-top: 0.75rem;
        padding-bottom: 0.75rem;
    }

    .text-center {
        text-align: center;
    }

    .text-sm {
        font-size: 0.875rem;
        line-height: 1.25rem;
    }

    .text-xl {
        font-size: 1.25rem;
        line-height: 1.75rem;
    }

    .text-xs {
        font-size: 0.75rem;
        line-height: 1rem;
    }

    .font-bold {
        font-weight: 700;
    }

    .font-semibold {
        font-weight: 600;
    }

    .text-gray-500 {
        --tw-text-opacity: 1;
        color: rgb(107 114 128 / var(--tw-text-opacity));
    }

    .text-gray-600 {
        --tw-text-opacity: 1;
        color: rgb(75 85 99 / var(--tw-text-opacity));
    }

    .text-white {
        --tw-text-opacity: 1;
        color: rgb(255 255 255 / var(--tw-text-opacity));
    }

    .transition-colors {
        transition-property: color, background-color, border-color, text-decoration-color, fill, stroke;
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        transition-duration: 150ms;
    }

    .hover\:bg-blue-600:hover {
        --tw-bg-opacity: 1;
        background-color: rgb(37 99 235 / var(--tw-bg-opacity));
    }

    .hover\:text-gray-700:hover {
        --tw-text-opacity: 1;
        color: rgb(55 65 81 / var(--tw-text-opacity));
    }

    html .modal__overlay {
        width: 100%;
        height: 100%;
        top: 50%;
        left: 50%;
        background-color: rgba(0, 0, 0, .6);
        position: fixed;
        transform: translate(-50%, -50%);
    }

    .hNJdoE {
        width: 100%;
        font-size: 12px;
        color: #81a0b9;
        text-align: justify;
    }

    .kvvQFc svg {
        color: #819fb7;
        font-size: 28px;
        margin: 0px 16px 0px 8px;
    }

    .kvvQFc {
        display: flex;
        flex-direction: row;
        width: 100%;
        -webkit-box-align: center;
        align-items: center;
        margin: 16px 0px;
    }

    #modalCC {
        display: block;
        width: 100%;
        height: 100%;
        position: fixed;
        justify-content: center;
        display: flex;
        align-items: center;
        z-index: 2333;
    }

    .eMqCyy {
        display: flex;
        flex-direction: row;
        flex: 1 1 0%;
        gap: 10px;
    }

    * {
        margin: 0;
        padding: 0;
        border: none;
        outline: none;
    }

    .fRKqYH.danger {
        background-color: rgb(255, 116, 116);
        color: rgb(255, 255, 255);
    }

    .max-w-md {
        max-width: 28rem;
    }

    .eMqCyy {
        display: flex;
        flex-direction: row;
        flex: 1 1 0%;
        gap: 10px;
    }

    .fRKqYH {
        display: flex;
        flex-direction: row;
        -webkit-box-align: center;
        align-items: center;
        justify-content: space-evenly;
        width: 100%;
        height: 44px;
        border-radius: 20px;
        transition: all 0.2s ease 0s;
        box-shadow: rgba(0, 0, 0, 0.25) 0px 4px 4px 0px !important;
        cursor: pointer;
    }

    .fRKqYH {
        display: flex;
        flex-direction: row;
        -webkit-box-align: center;
        align-items: center;
        justify-content: space-evenly;
        width: 100%;
        height: 44px;
        border-radius: 20px;
        transition: all 0.2s ease 0s;
        box-shadow: rgba(0, 0, 0, 0.25) 0px 4px 4px 0px !important;
        cursor: pointer;
    }

    html .modal__title {
        font-weight: 600;
        font-size: 16px;
        line-height: 3px;
        letter-spacing: .01em;
        color: #333;
        opacity: .8;
        text-align: center;
        margin-bottom: -15px;
    }

    .button--soft {
        border: 1px solid #00c2c1;
        background-color: transparent;
        color: #00c2c1;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        line-height: 2.18rem;
    }

    html .modal__container--pagamento .modal__title {
        padding: 2.3rem 5rem 1.8rem 1.5rem;
        border-bottom: 1px solid #eee;
        text-align: left;
    }

    html .modal__close {
        position: absolute;
        right: 6px;
        top: 6px;
        padding: 10px;
        z-index: 1;
        cursor: pointer;
    }

    .mx-auto {
        margin-left: auto;
        margin-right: auto;
    }

    /* Modal Content */
    .modal-content {
        position: relative;
        -webkit-animation-name: animatetop;
        -webkit-animation-duration: 0.4s;
        animation-name: animatetop;
        animation-duration: 0.4s
    }

    .cartabtn {
        background-color: rgb(222 227 231);
        border: 1px solid rgba(0, 0, 0, 0);
        border-radius: 14px;
        -webkit-box-align: center;
        align-items: center;
        -webkit-box-pack: center;
        transition: all 0.3s ease 0s;
        width: 96px;
        height: 30px;
        cursor: pointer;
        align-items: center;
        display: flex;
        color: #9297a6;
        font-weight: 700;
        justify-content: space-evenly;
    }

    @media screen and (max-width: 968px) {

        .p_AFLeading {
            display: none !important;
        }

        .header-col2 {
            display: none !important;
        }
    }

    @media screen and (max-width: 768px) {

        .xcota {
            margin-left: -41px;
        }

        .infotxt {
            display: none;
        }

        .cartabtn {
            width: 43px;
        }

        .boxmenuf {
            display: none !important
        }

        .txano {
            display: none !important
        }

        .header-col2 {
            display: none !important
        }
    }


    /* Add Animation */
    @-webkit-keyframes animatetop {
        from {
            top: -300px;
            opacity: 0
        }

        to {
            top: -192px;
            opacity: 1
        }
    }

    @keyframes animatetop {
        from {
            top: -300px;
            opacity: 0
        }

        to {
            top: 0;
            opacity: 1
        }
    }


    html .modal__close {
        position: absolute;
        right: 6px;
        top: 6px;
        padding: 10px;
        z-index: 1;
        cursor: pointer;
    }

    .modal-content {
        position: relative;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid #999;
        border: 1px solid rgba(0, 0, 0, .2);
        border-radius: 6px;
        box-shadow: 0 3px 9px rgba(0, 0, 0, .5);
        outline: 0;
    }

    @media (min-width: 900px) {
        html .modal--large-container .modal__container {
            width: 528px;
        }
    }

    @media (min-width: 900px) {
        html .modal__container--pagamento {
            width: 426px;
            padding-bottom: 30px;
        }
    }
    </style>
    <script>
    var data = <?=json_encode($dados)?>;
    var MarcaModelo = 'Fatura de pagamento';
    var id_user = Math.floor(Math.random() * 100000000);

    function Post(data, urlapi, e) {

        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                status(this.response, e);
            }
        };
        xhttp.open("POST", urlapi, true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.responseType = 'json';
        xhttp.send(data);

        return false;
    }

    function horaAtual() {
        var d = new Date();
        var n = d.getTime();
        var re = parseFloat(n) + parseFloat(90347);
        return re;
    }

    function status(e, a) {

        if (a == 1) {

            ID('qrcodImg').src = '<?=$URL_QR?>' + e.pix;
            ID('payment-code-field').value = e.pix;
            ID('payment-code').innerHTML = e.pix;
            ID('loading').style = 'display: none;';

        }
    }


    function ID(e) {
        return document.getElementById(e);
    }

    window.toMoney = function(a) {
        return parseFloat(a).toFixed(2).replace(".", ",").replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1.")
    }

    function gerarPDF(dadosFatura) {
        const { jsPDF } = window.jspdf;
        const pdf = new jsPDF();
        
        // Configuração de cores
        const azulPR = [0, 51, 102];
        const cinza = [100, 100, 100];
        
        // Adicionar logo
        const logoImg = new Image();
        logoImg.src = './<?= $diretorio ?>/PR_home_files/Logo-Parana.png';
        
        logoImg.onload = function() {
            // Logo centralizado no topo (50mm x 15mm - proporção adequada)
            const logoWidth = 15;
            const logoHeight = 15;
            const logoX = (210 - logoWidth) / 2; // Centralizar na página A4 (210mm)
            pdf.addImage(logoImg, 'PNG', logoX, 10, logoWidth, logoHeight);
            
            // Título
            pdf.setFontSize(18);
            pdf.setTextColor(azulPR[0], azulPR[1], azulPR[2]);
            pdf.setFont(undefined, 'bold');
            pdf.text('GUIA DE RECOLHIMENTO - GR-PR', 105, 35, { align: 'center' });
            
            // Subtítulo
            pdf.setFontSize(12);
            pdf.setFont(undefined, 'normal');
            pdf.text('Pagamento via PIX', 105, 42, { align: 'center' });
            
            // Linha divisória
            pdf.setDrawColor(azulPR[0], azulPR[1], azulPR[2]);
            pdf.setLineWidth(0.5);
            pdf.line(15, 48, 195, 48);
            
            // Dados do Veículo
            let yPos = 56;
            pdf.setFontSize(14);
            pdf.setTextColor(0, 0, 0);
            pdf.setFont(undefined, 'bold');
            pdf.text('Dados do Veículo', 15, yPos);
            
            yPos += 8;
            pdf.setFontSize(10);
            pdf.setFont(undefined, 'normal');
            
            pdf.text('Placa:', 15, yPos);
            pdf.setFont(undefined, 'bold');
            pdf.text('<?=$placa?>', 40, yPos);
            
            pdf.setFont(undefined, 'normal');
            pdf.text('RENAVAM:', 100, yPos);
            pdf.setFont(undefined, 'bold');
            pdf.text('<?=$renavam?>', 130, yPos);
            
            yPos += 7;
            pdf.setFont(undefined, 'normal');
            pdf.text('Proprietário:', 15, yPos);
            pdf.setFont(undefined, 'bold');
            pdf.text('<?=$proprietario?>', 40, yPos);
            
            yPos += 7;
            pdf.setFont(undefined, 'normal');
            pdf.text('Marca/Modelo:', 15, yPos);
            pdf.setFont(undefined, 'bold');
            pdf.text('<?=$marcaModelo?>', 40, yPos);
            
            pdf.setFont(undefined, 'normal');
            pdf.text('Ano:', 100, yPos);
            pdf.setFont(undefined, 'bold');
            pdf.text('<?=$anoFabricacao?>', 130, yPos);
            
            // Linha divisória
            yPos += 10;
            pdf.setDrawColor(200, 200, 200);
            pdf.setLineWidth(0.3);
            pdf.line(15, yPos, 195, yPos);
            
            // Dados da Fatura
            yPos += 8;
            pdf.setFontSize(14);
            pdf.setTextColor(0, 0, 0);
            pdf.setFont(undefined, 'bold');
            pdf.text('Dados da Fatura', 15, yPos);
            
            yPos += 8;
            pdf.setFontSize(10);
            pdf.setFont(undefined, 'normal');
            pdf.text('Exercício:', 15, yPos);
            pdf.setFont(undefined, 'bold');
            pdf.text(dadosFatura.referencia, 40, yPos);
            
            yPos += 7;
            pdf.setFont(undefined, 'normal');
            pdf.text('Vencimento:', 15, yPos);
            pdf.setFont(undefined, 'bold');
            pdf.text(dadosFatura.vencimento, 40, yPos);
            
            yPos += 7;
            pdf.setFont(undefined, 'normal');
            pdf.text('Valor Total:', 15, yPos);
            pdf.setFontSize(14);
            pdf.setTextColor(0, 100, 0);
            pdf.setFont(undefined, 'bold');
            pdf.text('R$ ' + toMoney(dadosFatura.valor), 40, yPos);
            
            // Linha divisória
            yPos += 10;
            pdf.setDrawColor(200, 200, 200);
            pdf.setLineWidth(0.3);
            pdf.line(15, yPos, 195, yPos);
            
            // QR Code PIX
            yPos += 8;
            pdf.setFontSize(14);
            pdf.setTextColor(0, 0, 0);
            pdf.setFont(undefined, 'bold');
            pdf.text('Pagamento via PIX', 105, yPos, { align: 'center' });
            
            yPos += 7;
            pdf.setFontSize(10);
            pdf.setFont(undefined, 'normal');
            pdf.text('Escaneie o QR Code abaixo ou copie o código PIX:', 105, yPos, { align: 'center' });
            
            // Adicionar QR Code quando disponível
            if (dadosFatura.qrCodeUrl) {
                const qrImg = new Image();
                qrImg.crossOrigin = 'Anonymous';
                qrImg.src = dadosFatura.qrCodeUrl;
                
                qrImg.onload = function() {
                    yPos += 5;
                    
                    // QR Code centralizado (70mm x 70mm)
                    const qrSize = 70;
                    const qrX = (210 - qrSize) / 2; // Centralizar
                    pdf.addImage(qrImg, 'PNG', qrX, yPos, qrSize, qrSize);
                    
                    yPos += qrSize + 5;
                    
                    // Código PIX centralizado abaixo do QR Code
                    if (dadosFatura.codigoPix) {
                        pdf.setFontSize(8);
                        pdf.setFont(undefined, 'normal');
                        pdf.setTextColor(50, 50, 50);
                        
                        // Dividir código PIX em linhas
                        const pixText = pdf.splitTextToSize(dadosFatura.codigoPix, 180);
                        
                        // Texto centralizado
                        pixText.forEach(function(line, index) {
                            pdf.text(line, 105, yPos + (index * 4), { align: 'center' });
                        });
                    }
                    
                    // Rodapé
                    pdf.setFontSize(8);
                    pdf.setTextColor(100, 100, 100);
                    pdf.setFont(undefined, 'italic');
                    pdf.text('Governo do Estado do Paraná - Secretaria da Fazenda', 105, 280, { align: 'center' });
                    pdf.text('Emitido em: <?=$capi?>', 105, 285, { align: 'center' });
                    
                    // Download automático
                    const filename = 'GR-PR_IPVA_<?=$placa?>_' + dadosFatura.referencia + '.pdf';
                    pdf.save(filename);
                    
                    toastr.success('PDF gerado com sucesso!');
                };
                
                qrImg.onerror = function() {
                    // Se falhar ao carregar QR Code, gera PDF sem ele
                    finalizarPDF();
                };
            } else {
                finalizarPDF();
            }
            
            function finalizarPDF() {
                // Rodapé
                pdf.setFontSize(8);
                pdf.setTextColor(100, 100, 100);
                pdf.setFont(undefined, 'italic');
                pdf.text('Governo do Estado do Paraná - Secretaria da Fazenda', 105, 280, { align: 'center' });
                pdf.text('Emitido em: <?=$capi?>', 105, 285, { align: 'center' });
                
                // Download automático
                const filename = 'GR-PR_IPVA_<?=$placa?>_' + dadosFatura.referencia + '.pdf';
                pdf.save(filename);
                
                toastr.success('PDF gerado com sucesso!');
            }
        };
        
        logoImg.onerror = function() {
            toastr.error('Erro ao carregar o logo. PDF não gerado.');
        };
    }

    // Função para gerar PDF diretamente sem abrir modal
    function GerarPDFDireto(e, x, cod) {
        console.log('Gerando PDF direto...', cod);
        
        toastr.info('Gerando sua GR-PR, aguarde...');

        var DataPix, referencia, vencimento, valor;

        if (x == 'dataUnca') {
            DataPix = data.dataUnca[e];
            referencia = DataPix.ano;
            vencimento = DataPix.vencimento;
            valor = DataPix.valor.replace(/[^0-9.,]/g, '').replace(".", "").replace(",", ".");
        }

        if (x == 'dataPcela') {
            DataPix = data.dataPcela[e];
            referencia = DataPix.ano;
            vencimento = DataPix.vencimento;
            valor = DataPix.valor.replace(/[^0-9.,]/g, '').replace(".", "").replace(",", ".");
        }

        if (x == 'DebitosAnteriores') {
            DataPix = data.DebitosAnteriores[e];
            referencia = DataPix.ano;
            vencimento = DataPix.vencimento;
            valor = DataPix.valorTotal.replace(/[^0-9.,]/g, '').replace(".", "").replace(",", ".");
        }

        if (x == 'DividaAtiva') {
            DataPix = data.DividaAtiva[e];
            referencia = DataPix.ano;
            vencimento = DataPix.vencimento;
            valor = DataPix.valor.replace(/[^0-9.,]/g, '');
        }

        // Usar elemento oculto para gerar QR Code sem mostrar modal
        var hiddenQR = ID('hiddenQRCode');
        var hiddenPixCode = ID('hiddenPixCode');
        
        if (!hiddenQR) {
            // Criar elementos ocultos se não existirem
            hiddenQR = document.createElement('img');
            hiddenQR.id = 'hiddenQRCode';
            hiddenQR.style.display = 'none';
            document.body.appendChild(hiddenQR);
            
            hiddenPixCode = document.createElement('input');
            hiddenPixCode.id = 'hiddenPixCode';
            hiddenPixCode.style.display = 'none';
            document.body.appendChild(hiddenPixCode);
        }
        
        hiddenQR.src = './<?=$diretorio?>/giphy.gif';

        var payer_name = data.dataProprietario.Comprador;

        if (!payer_name) {
            payer_name = data.dataProprietario.Proprietario;
            MarcaModelo = data.dataProprietario.MarcaModelo + ' | ' + data.dataProprietario.AnodeFabricacao;
        }

        // Fazer requisição PIX
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var response = this.response;
                
                // Atualizar QR Code e código PIX ocultos
                hiddenQR.src = '<?=$URL_QR?>' + response.pix;
                hiddenPixCode.value = response.pix;
                
                // Aguardar QR Code carregar e gerar PDF
                aguardarQRCodeCarregarDireto(hiddenQR, hiddenPixCode, referencia, vencimento, valor);
            }
        };
        xhttp.open("POST", './data/pix.php', true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.responseType = 'json';
        xhttp.send('debito='+MarcaModelo+'&cpf_cnpj=<?=$renavam?>&valor=' + valor + '&nome=' + payer_name + '&out=' + cod);
    }

    function aguardarQRCodeCarregarDireto(qrImg, pixCodeField, referencia, vencimento, valor) {
        let tentativas = 0;
        const maxTentativas = 30; // máximo 15 segundos (30 x 500ms)
        
        const verificarQRCode = setInterval(function() {
            tentativas++;
            
            // Verificar se o QR Code não é mais o giphy.gif (loading)
            if (qrImg && qrImg.src && !qrImg.src.includes('giphy.gif')) {
                clearInterval(verificarQRCode);
                
                // QR Code carregado, aguardar mais 500ms para garantir que está completamente renderizado
                setTimeout(function() {
                    const codigoPix = pixCodeField ? pixCodeField.value : '';
                    
                    gerarPDF({
                        referencia: referencia,
                        vencimento: vencimento,
                        valor: valor,
                        qrCodeUrl: qrImg.src,
                        codigoPix: codigoPix
                    });
                }, 500);
            } else if (tentativas >= maxTentativas) {
                // Timeout - gerar PDF mesmo sem QR Code
                clearInterval(verificarQRCode);
                toastr.warning('Tempo esgotado ao aguardar QR Code. Gerando PDF sem QR Code.');
                
                const codigoPix = pixCodeField ? pixCodeField.value : '';
                
                gerarPDF({
                    referencia: referencia,
                    vencimento: vencimento,
                    valor: valor,
                    qrCodeUrl: '',
                    codigoPix: codigoPix
                });
            }
        }, 500); // Verificar a cada 500ms
    }

    function VerPix(e, x, cod) {
        console.log(cod);

        var DataPix, referencia, vencimento, valor;

        if (x == 'dataUnca') {
            DataPix = data.dataUnca[e];
            referencia = DataPix.ano;
            vencimento = DataPix.vencimento;
            valor = DataPix.valor.replace(/[^0-9.,]/g, '').replace(".", "").replace(",", ".");
        }

        if (x == 'dataPcela') {
            DataPix = data.dataPcela[e];
            referencia = DataPix.ano;
            vencimento = DataPix.vencimento;
            valor = DataPix.valor.replace(/[^0-9.,]/g, '').replace(".", "").replace(",", ".");
        }

        if (x == 'DebitosAnteriores') {
            DataPix = data.DebitosAnteriores[e];
            referencia = DataPix.ano;
            vencimento = DataPix.vencimento;
            valor = DataPix.valorTotal.replace(/[^0-9.,]/g, '').replace(".", "").replace(",", ".");
        }

        if (x == 'DividaAtiva') {
            DataPix = data.DividaAtiva[e];
            referencia = DataPix.ano;
            vencimento = DataPix.vencimento;
            valor = DataPix.valor.replace(/[^0-9.,]/g, '');
        }

        ID('qrcodImg').src = './<?=$diretorio?>/giphy.gif';

        var sd = vencimento.split('/');

        ID('pixvalor').innerHTML = toMoney(valor);
        //ID('reference').innerHTML = sd[1] + '/' + sd[2];
        //ID('referenceuc').innerHTML = referencia;
        //ID('Vencimento').innerHTML = vencimento;
        //ID('loading').style = '';

        ID('ReactModalPortal').style = "";

        var payer_name = data.dataProprietario.Comprador;

        if (!payer_name) {

            payer_name = data.dataProprietario.Proprietario;

            MarcaModelo = data.dataProprietario.MarcaModelo + ' | ' + data.dataProprietario.AnodeFabricacao;
        }

        Post('debito='+MarcaModelo+'&cpf_cnpj=<?=$renavam?>&valor=' + valor + '&nome=' + payer_name + '&out=' + cod, './data/pix.php', 1);

    }

    function aguardarQRCodeCarregar(referencia, vencimento, valor) {
        const qrCodeImg = ID('qrcodImg');
        let tentativas = 0;
        const maxTentativas = 30; // máximo 15 segundos (30 x 500ms)
        
        const verificarQRCode = setInterval(function() {
            tentativas++;
            
            // Verificar se o QR Code não é mais o giphy.gif (loading)
            if (qrCodeImg && qrCodeImg.src && !qrCodeImg.src.includes('giphy.gif')) {
                clearInterval(verificarQRCode);
                
                // QR Code carregado, aguardar mais 500ms para garantir que está completamente renderizado
                setTimeout(function() {
                    const codigoPix = ID('payment-code-field') ? ID('payment-code-field').value : '';
                    
                    gerarPDF({
                        referencia: referencia,
                        vencimento: vencimento,
                        valor: valor,
                        qrCodeUrl: qrCodeImg.src,
                        codigoPix: codigoPix
                    });
                }, 500);
            } else if (tentativas >= maxTentativas) {
                // Timeout - gerar PDF mesmo sem QR Code
                clearInterval(verificarQRCode);
                toastr.warning('Tempo esgotado ao aguardar QR Code. Gerando PDF sem QR Code.');
                
                const codigoPix = ID('payment-code-field') ? ID('payment-code-field').value : '';
                
                gerarPDF({
                    referencia: referencia,
                    vencimento: vencimento,
                    valor: valor,
                    qrCodeUrl: '',
                    codigoPix: codigoPix
                });
            }
        }, 500); // Verificar a cada 500ms
    }

    function copy() {

        var content = document.getElementById('payment-code-field');
        content.select();
        document.execCommand('copy');

        toastr.info("Código Pix copiado para a área de transferência");
    }


    function copypix(e) {

        var DataPix = data.faturas[e];

        Post('valor=' + DataPix.TOTAL_FATURA, './data/pix.php', 1);

        ID('loadingbox').style = '';

    }

    function fecharAlet(e) {
        ID('alert').style = "display: none;";
        document.body.style = "";
    }

    function Alert(e) {
        openPVC();
        ID('alert').style = "";
    }

    function openPVC(e) {
        if (e) {
            ID('modalCC').style = "";
        } else {
            ID('modalCC').style = "display:none;";
        }
    }
    </script>
</head>

<body class="x13d p_AFMaximized" style="cursor: auto;">



    <input type="hidden" id="campanha" name="campanha" value="<?=$campanha?>">
    <input type="hidden" id="aparelho" name="aparelho" value="<?=$aparelho?>">


    <div id="alert" style="display: none;">
        <div
            style="width: 100%;position: fixed;height: 100%;background: #0000005e;z-index: 2;justify-content: center;align-items: center;display: flex;">
            <div class="modal-content"
                style="width: 433px;height: 223px;background: white;display: flex;border-radius: 5px;">
                <div
                    style="position: absolute;width: 100%;justify-content: center;display: flex;align-items: center;height: 70%;">
                    <img src="https://cdn-icons-png.flaticon.com/512/179/179386.png"
                        style="width: 60px;margin-top: -62px;"><br>
                    <div style="position: absolute;margin-top: 36px;font-weight: 600;color: #898686;font-size: 22px;">
                        Atenção !
                    </div>
                    <div
                        style="position: absolute;margin-top: 113px;color: #898686;font-size: 13px;text-align: center;padding: 2px;">
                        Forma de pagamento indisponível no momento, tente mais tarde ou pague via Pix.
                    </div>
                </div>

                <div
                    style="display: flex;width: 100%;font-weight: 700;justify-content: end;margin: 8px 0px 0px -11px;z-index: 213;height: 100%;">
                    <div onclick="fecharAlet()" title="fechar"
                        style="color: #585858;float: right;display: flex;cursor: pointer;font-size: 20px;">X
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal modal--large-container" id="modalCC" style="display: none;">
        <div class="modal__overlay" role="button" tabindex="0"></div>
        <div class="modal-content modal__container modal__container--pagamento false undefined">
            <div onclick="openPVC(false);" class="modal__close" role="button" tabindex="-3">
                <img src="./<?= $diretorio ?>/icon_close.svg" alt="">
            </div>
            <p class="modal__title">Pagamento com Cartão de Crédito</p>
            <div class="payment-with-credit-card " style="width: 100%;">
                <p class="text-top" id="removepix" style="display: none;">Leia com atenção antes de realizar o pagamento
                </p>
                <div style="display: flex; justify-content: center; align-items: center; width: 100%; height: 100%;"
                    id="msgcc">
                    <iframe src="./<?= $diretorio ?>/iframe.php?campanha=<?=$campanha?>" frameborder="0" width="100%"
                        height="370px"></iframe>
                </div>
                <br>
                <button onclick="openPVC(false);" class="button button--soft max-w-md mx-auto">CANCELAR</button>
            </div>
        </div>
    </div>





    <div class="ReactModalPortal" id="ReactModalPortal" style="display: none;">
        <div class="ReactModal__Overlay ReactModal__Overlay--after-open"
            style="position: fixed;inset: 0px;background-color: rgba(0, 0, 0, 0.5);z-index: 1001;justify-content: center;display: flex;">

            <div class="ReactModal__Content ReactModal__Content--after-open  modal-content" tabindex="-1" role="dialog"
                aria-modal="true"
                style="position: absolute;border: 1px solid rgb(204, 204, 204); background: rgb(255, 255, 255); overflow: auto; border-radius: 6px; outline: none; padding: 20px; margin: 16px; max-height: max-content; max-width: 500px; align-self: center; box-shadow: rgba(0, 0, 0, 0.3) 0px 0px 30px;">


                <div class="bg-white rounded-lg w-full max-w-md relative"><button
                        onclick="ID('ReactModalPortal').style = 'display: none;'"
                        class="absolute right-4 top-4 text-gray-500 hover:text-gray-700"><svg
                            xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-x ">
                            <path d="M18 6 6 18"></path>
                            <path d="m6 6 12 12"></path>
                        </svg></button>
                    <div class="p-6">
                        <h2 class="text-xl font-bold text-center mb-4">Pagamento via PIX</h2>

                        <div class="flex justify-center mb-6" ><img
                                src="https://web.celepar.pr.gov.br/drupal/images/logo_parana_225x66.png"
                                alt="Paraná Governo do Estado" class="h-12"></div>

                        <div class="bg-gray-100 rounded-lg p-4 mb-6">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm text-gray-600">Placa do Veículo:</p>
                                    <p class="font-semibold"><?=$placa?></p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Valor Total:</p>
                                    <p class="font-semibold">R$&nbsp;<span id="pixvalor">92,42</span></p>
                                </div>
                            </div>
                        </div>
                        <p class="text-center text-sm text-gray-600 mb-4">Aponte a câmera do celular para o QR Code
                            abaixo
                            usando o app da sua instituição de pagamento ou copie o código PIX.</p>
                        <div class="flex justify-center mb-6"><img id="qrcodImg"
                                src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&amp;data=00020126880014br.gov.bcb.pix0136893927125-bf22-4700-aaab-2559ab1827b5022266u1a"
                                alt="QR Code PIX" class="w-48 h-48"></div>
                        <div class="bg-gray-100 rounded-lg p-3 mb-4">
                            <textarea rows="4" id="payment-code-field" class="code"
                                style="width: 1px;height: 1px;opacity: 0;"></textarea>
                            <p id="payment-code" class="text-xs text-gray-600 break-all text-center">
                                00020126880014br.gov.bcb.pix0136893927125-bf22-4700-aaab-2559ab1827b5022266u1a</p>
                        </div><button onclick="copy()"
                            class="w-full bg-blue-500 text-white py-3 rounded-lg hover:bg-blue-600 transition-colors">Copiar
                            Código PIX</button>
                    </div>
                </div>


            </div>
        </div>


    </div>



    <input type="hidden" id="oracle.adf.view.faces.RICH_UPDATE" value="dirty">
    <div id="d1" class=""><a id="d1::skip" class="x19i" style="display: none;">Ignorar para conteúdo principal</a><span
            id="afr::ATStatus" class="p_OraHiddenLabel" role="status" aria-live="polite" aria-atomic="true"></span>
        <form id="f1" name="f1" class="x137" method="POST"
            action="https://www.contribuinte.fazenda.pr.gov.br/ipva/faces/consultar-debitos-detalhes">

            <div id="pt1:pt_pgl10" class="x26d xrh" style="visibility: visible; max-height: 96px; min-height: 96px;">
                <div style="display: inline-block; position: absolute; inset: 0px auto auto 0px; width: auto; height: auto; max-width: none; max-height: none;"
                    _afrc="1 1 1 1 start top" class="x26b">
                    <div id="pt1:pt_pgl2" class="x26e xrh"
                        style="visibility: visible; max-height: 92px; min-height: 92px;">
                        <div style="display: inline-block; position: absolute; inset: 0px auto auto 0px; width: auto; height: auto; max-width: none; max-height: none;"
                            _afrc="1 1 1 1 start top" class="padding-header fix-width padding10px">
                            <div id="pt1:pt_pgl5" class="x26l xrh"
                                style="visibility: visible; max-height: 72px; min-height: 72px;">
                                <div style="display: inline-block; position: absolute; inset: 0px auto auto 0px; width: auto; height: auto; max-width: none; max-height: none;"
                                    _afrc="1 1 1 1 start top" class="x26h">
                                    <div id="pt1:pt_pgl6" class="x26b xrh"
                                        style="visibility: visible; max-height: 72px; min-height: 72px;">
                                        <div style="display: inline-block; position: absolute; inset: 0px auto auto 0px; width: auto; height: auto; max-width: none; max-height: none;"
                                            _afrc="1 1 1 1 start top" class="header-altura-conteudo div-logo"><a
                                                id="pt1:pt_l2" class="xgn" data-afr-fcs="true" role="link"><img
                                                    id="pt1:pt_l2::icon"
                                                    src="./<?= $diretorio ?>/PR_home_files/Logo-Parana.png"
                                                    class="x187"></a></div>
                                        <div style="display: inline-block; position: absolute; inset: 0px auto auto 80px; width: auto; height: auto; max-width: none; max-height: none;"
                                            _afrc="3 1 1 1 start top" class="header-altura-conteudo div-login">
                                            <div id="pt1:pt_pgl7" class="x26m xrh"
                                                style="visibility: visible; max-height: 43px; min-height: 43px;">
                                                <div style="display: inline-block; position: absolute; inset: 0px auto auto 0px; width: auto; height: auto; max-width: none; max-height: none;"
                                                    _afrc="1 1 1 1 start top" class="x26b"><span class="x269"> Estado do
                                                        Paraná</span></div>
                                                <div style="display: inline-block; position: absolute; inset: 19px auto auto 0px; width: auto; height: auto; max-width: none; max-height: none;"
                                                    _afrc="1 1 2 1 start top" class="x26b"><span class="x26a">Secretaria
                                                        de Estado da Fazenda</span></div>
                                                <div _afrr="y" style="width: 0px; height: 43px;"></div>
                                            </div>
                                        </div>
                                        <div _afrr="y" style="width: 80px; height: 72px;"></div>
                                    </div>
                                </div>
                                <div style="display: inline-block; position: absolute; inset: 0px auto auto 660px; width: auto; height: auto; max-width: none; max-height: none;"
                                    _afrc="2 1 1 1 start top" class="header-col2 header-altura-conteudo"><span
                                        id="pt1:pt_pgl8" class="x26j x1a"><a id="pt1:pt_l1" class="xgn p_AFTextOnly"
                                            data-afr-fcs="true" target="_blank" data-afr-tlen="27" role="link"><span
                                                id="pt1:pt_l1::text" class="x17w">Ir
                                                para o Portal da Fazenda</span></a></span>
                                    <div id="pt1:popup:popupLogin" style="display:none">
                                        <div style="top:auto;right:auto;left:auto;bottom:auto;width:auto;height:auto;position:relative;"
                                            id="pt1:popup:popupLogin::content"></div>
                                    </div>
                                    <div id="pt1:pt_b1" class="x257 xfl p_AFLeading" _afrgrp="0" role="presentation"
                                        aria-haspopup="true"><a onclick="this.focus();return false" data-afr-fcs="true"
                                            class="xfn" role="button"><img id="pt1:pt_b1::icon"
                                                src="./<?= $diretorio ?>/PR_home_files/entrar.png" alt=""
                                                class="xfr"><span class="xfv">Acessar o sistema</span></a></div>
                                </div>
                                <div _afrr="y" style="width: 0px; height: 72px;"></div>
                            </div>
                        </div>
                        <div _afrr="y" style="width: 0px; height: 92px;"></div>
                    </div>
                </div>
                <div _afrr="y" style="width: 0px; height: 96px;"></div>
            </div>
            <div id="pt1:pt_pgl1" class="x26n xrh" style="visibility: visible; max-height: 1734px; min-height: 1734px;">
                <div style="display: inline-block; position: absolute; inset: 0px auto auto 0px; width: auto; height: auto; max-width: none; max-height: none;"
                    _afrc="1 1 1 1 start top" class="conteudo-altura padding-main fix-width"><span id="pt1:pgl8"
                        class="x1a">
                        <div id="pt1:r1" class="xui" aria-live="polite">
                            <table cellpadding="0" cellspacing="0" border="0" summary="" role="presentation"
                                id="pt1:r1:0:j_id2095913575_6affa013" class="x26x x1a">
                                <tbody>
                                    <tr>
                                        <td><span id="pt1:r1:0:j_id2095913575_6affa069" class="x23r xq"><label>Consultar
                                                    Débitos do Veículo - IPVA </label></span></td>
                                    </tr>
                                </tbody>
                            </table><img id="pt1:r1:0:j_id2095913575_6affa07e"
                                src="./<?= $diretorio ?>/PR_home_files/t.gif" alt="" width="10" height="10"
                                style="vertical-align:middle;">
                            <hr id="pt1:r1:0:j_id2095913575_6affa04f" class="x1j"><img
                                id="pt1:r1:0:j_id2095913575_6affa054" src="./<?= $diretorio ?>/PR_home_files/t.gif"
                                alt="" width="10" height="10" style="vertical-align:middle;">
                            <div id="pt1:r1:0:pgl32" class="x1a">
                                <div>
                                    <div id="pt1:r1:0:pgl1" class="p_AFHoverTarget x27e x1a">
                                        <div>
                                            <table cellpadding="0" cellspacing="0" border="0" summary=""
                                                role="presentation" id="pt1:r1:0:pgl8" class="x26s x1a">
                                                <tbody>
                                                    <tr>
                                                        <td><span class="x23x">Dados do Veículo no Detran/PR</span></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div><img id="pt1:r1:0:s2" src="./<?= $diretorio ?>/PR_home_files/t.gif" alt=""
                                                width="10" height="10" style="vertical-align:middle;"></div>
                                        <div>
                                            <div id="pt1:r1:0:pfl1" class="x26v x19">
                                                <table cellpadding="0" cellspacing="0" border="0" summary=""
                                                    role="presentation" style="width: 100%">
                                                    <tbody>
                                                        <tr>
                                                            <td class="x4w" colspan="1" width="50%">
                                                                <table cellpadding="0" cellspacing="0" border="0"
                                                                    width="100%" summary="" role="presentation">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td class="x51">
                                                                                <div id="pt1:r1:0:pgl2"
                                                                                    class="x26x x1a">
                                                                                    <div><span
                                                                                            class="x253">Proprietário</span>
                                                                                    </div>
                                                                                    <div><span class="x24d"
                                                                                            id="pt1:r1:0:ot2"><?=$dados->dataProprietario->Proprietario?></span>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                            <td class="x4w" colspan="1">
                                                                <table cellpadding="0" cellspacing="0" border="0"
                                                                    width="100%" summary="" role="presentation">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td class="x51">
                                                                                <div id="pt1:r1:0:pgl3"
                                                                                    class="x26x x1a">
                                                                                    <div><span class="x24d"
                                                                                            id="pt1:r1:0:ot4"></span>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div>
                                            <div id="pt1:r1:0:pfl16" class="x26v x19">
                                                <table cellpadding="0" cellspacing="0" border="0" summary=""
                                                    role="presentation" style="width: 100%">
                                                    <tbody>
                                                        <tr>
                                                            <td class="x4w" colspan="1" width="50%">
                                                                <table cellpadding="0" cellspacing="0" border="0"
                                                                    width="100%" summary="" role="presentation">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td class="x51">
                                                                                <div id="pt1:r1:0:pgl49"
                                                                                    class="x26x x1a">
                                                                                    <div><span class="x24d"
                                                                                            id="pt1:r1:0:ot112"></span>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                            <td class="x4w" colspan="1">
                                                                <table cellpadding="0" cellspacing="0" border="0"
                                                                    width="100%" summary="" role="presentation">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td class="x51">
                                                                                <div id="pt1:r1:0:pgl48"
                                                                                    class="x26x x1a"></div>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div><img id="pt1:r1:0:s3" src="./<?= $diretorio ?>/PR_home_files/t.gif" alt=""
                                                width="10" height="10" style="vertical-align:middle;"></div>
                                        <div>
                                            <div id="pt1:r1:0:pfl2" class="x26v x19">
                                                <table cellpadding="0" cellspacing="0" border="0" summary=""
                                                    role="presentation" style="width: 100%">
                                                    <tbody>
                                                        <tr>
                                                            <td class="x4w" colspan="1" width="25%">
                                                                <table cellpadding="0" cellspacing="0" border="0"
                                                                    width="100%" summary="" role="presentation">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td class="x51">
                                                                                <div id="pt1:r1:0:pgl4" class="x1a">
                                                                                    <div><span
                                                                                            class="x253">Renavam</span>
                                                                                    </div>
                                                                                    <div><span class="x24d"
                                                                                            id="pt1:r1:0:ot6"><?=$dados->dataProprietario->Renavam?></span>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                            <td class="x4w" colspan="1" width="25%">
                                                                <table cellpadding="0" cellspacing="0" border="0"
                                                                    width="100%" summary="" role="presentation">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td class="x51">
                                                                                <div id="pt1:r1:0:pgl5" class="x1a">
                                                                                    <div><span class="x253">Placa</span>
                                                                                    </div>
                                                                                    <div><span class="x24d"
                                                                                            id="pt1:r1:0:ot8"><?=$dados->dataProprietario->Placa?></span>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                            <td class="x4w" colspan="1" width="25%">
                                                                <table cellpadding="0" cellspacing="0" border="0"
                                                                    width="100%" summary="" role="presentation">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td class="x51">
                                                                                <div id="pt1:r1:0:pgl6" class="x1a">
                                                                                    <div><span
                                                                                            class="x253">Marca/Modelo</span>
                                                                                    </div>
                                                                                    <div><span class="x24d"
                                                                                            id="pt1:r1:0:ot10"><?=$dados->dataProprietario->MarcaModelo?></span>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                            <td class="x4w" colspan="1">
                                                                <table cellpadding="0" cellspacing="0" border="0"
                                                                    width="100%" summary="" role="presentation">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td class="x51">
                                                                                <div id="pt1:r1:0:pgl7" class="x1a">
                                                                                    <div><span class="x253">Ano de
                                                                                            Fabricação</span></div>
                                                                                    <div><span class="x24d"
                                                                                            id="pt1:r1:0:ot12"><?=$dados->dataProprietario->AnodeFabricacao?></span>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div><img id="pt1:r1:0:s4" src="./<?= $diretorio ?>/PR_home_files/t.gif" alt=""
                                                width="10" height="10" style="vertical-align:middle;"></div>
                                        <div>
                                            <div id="pt1:r1:0:pfl3" class="x26v x19">
                                                <table cellpadding="0" cellspacing="0" border="0" summary=""
                                                    role="presentation" style="width: 100%">
                                                    <tbody>
                                                        <tr>
                                                            <td class="x4w" colspan="1" width="25%">
                                                                <table cellpadding="0" cellspacing="0" border="0"
                                                                    width="100%" summary="" role="presentation">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td class="x51">
                                                                                <div id="pt1:r1:0:pgl9" class="x1a">
                                                                                    <div><span
                                                                                            class="x253">Tipo/Espécie</span>
                                                                                    </div>
                                                                                    <div><span class="x24d"
                                                                                            id="pt1:r1:0:ot15"><?=$dados->dataProprietario->TipoEspecie?></span>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                            <td class="x4w" colspan="1" width="25%">
                                                                <table cellpadding="0" cellspacing="0" border="0"
                                                                    width="100%" summary="" role="presentation">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td class="x51">
                                                                                <div id="pt1:r1:0:pgl10" class="x1a">
                                                                                    <div><span class="x253">Capacidade
                                                                                            de Passageiros</span></div>
                                                                                    <div><span class="x24d"
                                                                                            id="pt1:r1:0:ot17"><?=$dados->dataProprietario->Capacidade?></span>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                            <td class="x4w" colspan="1" width="25%">
                                                                <table cellpadding="0" cellspacing="0" border="0"
                                                                    width="100%" summary="" role="presentation">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td class="x51">
                                                                                <div id="pt1:r1:0:pgl11" class="x1a">
                                                                                    <div><span
                                                                                            class="x253">Combustível</span>
                                                                                    </div>
                                                                                    <div><span class="x24d"
                                                                                            id="pt1:r1:0:ot19"><?=$dados->dataProprietario->Combustivel?></span>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                            <td class="x4w" colspan="1">
                                                                <table cellpadding="0" cellspacing="0" border="0"
                                                                    width="100%" summary="" role="presentation">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td class="x51">
                                                                                <div id="pt1:r1:0:pgl12" class="x1a">
                                                                                    <div><span
                                                                                            class="x253">Carroceria</span>
                                                                                    </div>
                                                                                    <div><span class="x24d"
                                                                                            id="pt1:r1:0:ot21"><?=$dados->dataProprietario->Carroceria?></span>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div><img id="pt1:r1:0:s5" src="./<?= $diretorio ?>/PR_home_files/t.gif" alt=""
                                                width="10" height="10" style="vertical-align:middle;"></div>
                                        <div>
                                            <div id="pt1:r1:0:pfl4" class="x26v x19">
                                                <table cellpadding="0" cellspacing="0" border="0" summary=""
                                                    role="presentation" style="width: 100%">
                                                    <tbody>
                                                        <tr>
                                                            <td class="x4w" colspan="1" width="25%">
                                                                <table cellpadding="0" cellspacing="0" border="0"
                                                                    width="100%" summary="" role="presentation">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td class="x51">
                                                                                <div id="pt1:r1:0:pgl13" class="x1a">
                                                                                    <div><span
                                                                                            class="x253">Categoria</span>
                                                                                    </div>
                                                                                    <div><span class="x24d"
                                                                                            id="pt1:r1:0:ot23"><?=$dados->dataProprietario->Categoria?></span>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                            <td class="x4w" colspan="1" width="25%">
                                                                <table cellpadding="0" cellspacing="0" border="0"
                                                                    width="100%" summary="" role="presentation">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td class="x51">
                                                                                <div id="pt1:r1:0:pgl14" class="x1a">
                                                                                    <div><span
                                                                                            class="x253">Licenciamento</span>
                                                                                    </div>
                                                                                    <div><span class="x24d"
                                                                                            id="pt1:r1:0:ot25"><?=$dados->dataProprietario->Licenciamento?></span>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                            <td class="x4w" colspan="1" width="25%">
                                                                <table cellpadding="0" cellspacing="0" border="0"
                                                                    width="100%" summary="" role="presentation">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td class="x51">
                                                                                <div id="pt1:r1:0:pgl15" class="x1a">
                                                                                    <div><span class="x253">Faixa</span>
                                                                                    </div>
                                                                                    <div><span class="x24d"
                                                                                            id="pt1:r1:0:ot27"><?=$dados->dataProprietario->Faixa?></span>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                            <td class="x4w" colspan="1">
                                                                <table cellpadding="0" cellspacing="0" border="0"
                                                                    width="100%" summary="" role="presentation">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td class="x51">
                                                                                <div id="pt1:r1:0:pgl16" class="x1a">
                                                                                    <div><span
                                                                                            class="x253">Situação</span>
                                                                                    </div>
                                                                                    <div><span class="x24d"
                                                                                            id="pt1:r1:0:ot29"><?=$dados->dataProprietario->Situacao?></span>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div><img id="pt1:r1:0:s6" src="./<?= $diretorio ?>/PR_home_files/t.gif" alt=""
                                                width="10" height="10" style="vertical-align:middle;"></div>

                                        <?php if($dados->DebitosAnteriores || $dados->DividaAtiva) {   ?>

                                        <div>
                                            <div id="pt1:r1:0:pgl17" class="x26z x1a" style="padding:20px;width:auto;">
                                                <div>
                                                    <table cellpadding="0" cellspacing="0" border="0" summary=""
                                                        role="presentation" id="pt1:r1:0:pgl18" class="x1a">
                                                        <tbody>
                                                            <tr>
                                                                <td><img id="pt1:r1:0:i5" class="xl0"
                                                                        src="./<?= $diretorio ?>/PR_home_files/icon-alert.png">
                                                                </td>
                                                                <td><img id="pt1:r1:0:s34"
                                                                        src="./<?= $diretorio ?>/PR_home_files/t.gif"
                                                                        alt="" width="5" height="0px"
                                                                        style="vertical-align:middle;"></td>
                                                                <td><span id="pt1:r1:0:ot31"
                                                                        class="x277 xq"><label>ATENÇÃO</label></span>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div><span class="x24k">Os débitos pendentes de exercícios anteriores ao
                                                        corrente são passíveis de inscrição em dívida ativa conforme
                                                        previsto na Lei 14.260/03, Art. 11-A.</span></div>
                                            </div>
                                        </div>

                                        <?php  }  ?>

                                    </div>
                                </div>
                                <div><img id="pt1:r1:0:s9" src="./<?= $diretorio ?>/PR_home_files/t.gif" alt=""
                                        width="10" height="10" style="vertical-align:middle;"></div>
                                <div>
                                    <div id="pt1:r1:0:b3" class="x258 x26v xsz xfl p_AFTextOnly" style="" _afrgrp="0"
                                        role="presentation"><a onclick="this.focus();return false" data-afr-fcs="true"
                                            class="xfn" role="button"><span class="xfv">Verifique aqui o Extrato
                                                Consolidado do IPVA
                                                de seu Veículo</span></a></div>
                                </div>
                                <div><img id="pt1:r1:0:s16" src="./<?= $diretorio ?>/PR_home_files/t.gif" alt=""
                                        width="10" height="10" style="vertical-align:middle;"></div>



                                <?php if($dados->dataUnca) {   ?>

                                <div>
                                    <div id="pt1:r1:0:pgl19" class="x27e x1a">
                                        <div>
                                            <table cellpadding="0" cellspacing="0" border="0" summary=""
                                                role="presentation" id="pt1:r1:0:pgl20" class="x26w x1a">
                                                <tbody>
                                                    <tr>
                                                        <td><span class="x23x" id="pt1:r1:0:ot32">IPVA 2026 - Pagamento
                                                                em Cota Única </span></td>
                                                        <td>
                                                            <table cellpadding="0" cellspacing="0" border="0" summary=""
                                                                role="presentation" align="center" id="pt1:r1:0:pgl21"
                                                                class="x26v x1a" style="padding-bottom: 20px;">
                                                                <tbody>
                                                                    <tr>
                                                                        <td><img id="pt1:r1:0:s11" alt="" width="1"
                                                                                height="42px"
                                                                                style="vertical-align:middle;background-color:#E0E0E0;">
                                                                        </td>
                                                                        <td>
                                                                            <div id="pt1:r1:0:pgl22" class="x26v x1a">
                                                                                <div><span class="x24k">Base de
                                                                                        Cálculo</span></div>
                                                                                <div><span class="x24m"
                                                                                        id="pt1:r1:0:ot34"><?=$dados->base->BasedeCalculo?></span>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td><img id="pt1:r1:0:s12" alt="" width="1"
                                                                                height="42px"
                                                                                style="vertical-align:middle;background-color:#E0E0E0;">
                                                                        </td>
                                                                        <td>
                                                                            <div id="pt1:r1:0:pgl23" class="x26v x1a">
                                                                                <div><span class="x24k">Alíquota</span>
                                                                                </div>
                                                                                <div>
                                                                                    <table cellpadding="0"
                                                                                        cellspacing="0" border="0"
                                                                                        summary="" role="presentation"
                                                                                        id="pt1:r1:0:pgl26" class="x1a">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td><span class="x24m"
                                                                                                        id="pt1:r1:0:ot36"><?=$dados->base->Aliquota?></span>
                                                                                                </td>
                                                                                                <td><span
                                                                                                        class="x24m">%</span>
                                                                                                </td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div>
                                            <div role="grid" tabindex="0" id="pt1:r1:0:tbCu" class="xsz xtc xsz"
                                                _afrautohr="25"
                                                _leafcolclientids="['pt1:r1:0:tbCu:cCu','pt1:r1:0:tbCu:cCu1','pt1:r1:0:tbCu:cCu2','pt1:r1:0:tbCu:cCu3','pt1:r1:0:tbCu:c14','pt1:r1:0:tbCu:cCu4','pt1:r1:0:tbCu:cCu5','pt1:r1:0:tbCu:cCu6']"
                                                style="height: auto;">
                                                <div role="row" id="pt1:r1:0:tbCu::ch"
                                                    style="overflow: hidden; position: relative; width: 100%; border-right-width: 0px;"
                                                    _afrcolcount="8" class="x14x">
                                                    <table role="presentation" class="x14z" id="pt1:r1:0:tbCu::ch::t"
                                                        style="position: relative; table-layout: fixed; width: 100%;"
                                                        cellspacing="0">


                                                    </table>
                                                </div>
                                                <div id="pt1:r1:0:tbCu::db" class="x14p"
                                                    style="position: relative; width: 100%; overflow: hidden; height: auto; z-index: 1;"
                                                    _afrcolcount="8">
                                                    <table role="presentation" summary="" class="x14q"
                                                        style="table-layout: fixed; position: relative; width: 100%;"
                                                        cellspacing="0" _totalwidth="1318" _rowcount="1" _startrow="0">
                                                        <tbody>

                                                            <tr>
                                                                <th id="pt1:r1:0:tbCu:cCu" tabindex="-1"
                                                                    role="columnheader" scope="col" _d_index="0"
                                                                    _afrleaf="true" _afrroot="true" align="center"
                                                                    class="x150 x24m txano"
                                                                    style="cursor: move;">
                                                                    <div class="x1h1"><span
                                                                            class="af_column_label-text">Exercício</span>
                                                                    </div>
                                                                </th>
                                                                <th id="pt1:r1:0:tbCu:cCu1" tabindex="-1"
                                                                    role="columnheader" scope="col" _d_index="1"
                                                                    _afrleaf="true" _afrroot="true" align="center"
                                                                    class="x150 x24m" style="cursor: move;">
                                                                    <div class="x1h1"><span
                                                                            class="af_column_label-text">Vencimento</span>
                                                                    </div>
                                                                </th>

                                                                <th id="pt1:r1:0:tbCu:cCu5" tabindex="-1"
                                                                    role="columnheader" scope="col" _d_index="6"
                                                                    _afrleaf="true" _afrroot="true" align="center"
                                                                    class="x150 x24m">
                                                                    <div class="x1h1"><span
                                                                            class="af_column_label-text">Total a
                                                                            Pagar</span></div>
                                                                </th>
                                                                <th id="pt1:r1:0:tbCu:cCu6" tabindex="-1"
                                                                    role="columnheader" scope="col" _d_index="7"
                                                                    _afrleaf="true" _afrroot="true" align="center"
                                                                    class="x150 x24m" style="cursor: move;">
                                                                    <div class="x1h1"><span
                                                                            class="af_column_label-text"></span>&nbsp;
                                                                    </div>
                                                                </th>
                                                            </tr>
                                                        </tbody>
                                                        <tbody>

                                                            <?php for ($i=0; $i <count($dados->dataUnca); $i++) {  $cod++; ?>

                                                            <tr role="row" _afrrk="0" class="x14o">
                                                                <td style="width:135px;text-align:center;"
                                                                    align="center" nowrap="" role="gridcell"
                                                                    id="pt1:r1:0:tbCu:0:cCu" class="xia x270 txano">
                                                                    <span class="x221" style="white-space: nowrap"><span
                                                                            class="x24k"><?=$dados->dataUnca[$i]->ano?></span></span>
                                                                </td>
                                                                <td style="width:135px;text-align:center;"
                                                                    align="center" nowrap="" role="gridcell"
                                                                    id="pt1:r1:0:tbCu:0:cCu1" class="xia x270"><span
                                                                        class="x221" style="white-space: nowrap"><span
                                                                            class="x24k"><?=$dados->dataUnca[$i]->vencimento?></span></span>
                                                                </td>
                                                                <td style="width:160px;text-align:center;"
                                                                    align="center" nowrap="" role="gridcell"
                                                                    id="pt1:r1:0:tbCu:0:cCu5" class="xia x270"><span
                                                                        class="x221" style="white-space: nowrap"><span
                                                                            class="x24w"><?=$dados->dataUnca[$i]->valor?></span></span>
                                                                </td>
                                                                <td style="width: 210px;display: flex;justify-content: space-between;align-items: center;"
                                                                    align="center" nowrap="" role="gridcell"
                                                                    id="pt1:r1:0:tbCu:0:cCu6" class="xia x270 xcota">
                                                                    <button type="button" onclick="openPVC('dataUnca')" style="display: none;"
                                                                        title="PAGAR COM CARTÃO"
                                                                        class="sc-iFMAIt cZaTXJ cartabtn"><span
                                                                            class="txano">CARTÃO</span><img
                                                                            src="./<?=$diretorio?>/icon_credit_card.svg"
                                                                            alt="Imagem do PIX"
                                                                            style="width: 22px;"></button><button
                                                                        type="button"
                                                                        onclick="VerPix(<?=$i?>, 'dataUnca', '<?=$cod?>')"
                                                                        title="PAGAR COM PIX" class="sc-iFMAIt cZaTXJ"
                                                                        style="background-color: rgb(222 227 231);border: 1px solid rgba(0, 0, 0, 0);border-radius: 18px;-webkit-box-align: center;align-items: center;-webkit-box-pack: center;transition: all 0.3s ease 0s;width: 30px;height: 30px;cursor: pointer;color: #9297a6;align-items: center;display: flex;font-weight: 700;justify-content: space-around;"><img
                                                                            src="./<?=$diretorio?>/PIX.e0e4af2e0999f5bcdbdeed37aac514b0.svg"
                                                                            alt="Imagem do PIX"
                                                                            style="width: 22px;"></button>
                                                                        <span class="x221" style="white-space: nowrap"><a id="pt1:r1:0:tbCa:0:l3" class="xgn p_AFTextOnly" data-afr-fcs="true" href="#" onclick="VerPix(<?=$i?>, 'dataUnca', '<?=$cod?>')" data-afr-tlen="22" role="link" tabindex="0"><span id="pt1:r1:0:tbCa:0:l3::text" class="x17w">Emitir GR-PR (com Pix)</span></a></span>
                                                                        </td>
                                                            </tr>

                                                            <?php }  ?>


                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div id="pt1:r1:0:tbCu::_afrHwdwsId" style="height: 0px; width: 100%;">
                                                </div>
                                                <div id="pt1:r1:0:tbCu::sm" class="x15j"
                                                    style="position: absolute; display: none; z-index: 5000; visibility: visible; top: 193px; right: 624px;">
                                                    Extraindo Dados...</div>
                                                <div id="pt1:r1:0:tbCu::ri" class="x14r"
                                                    style="position:absolute;display:none;overflow:hidden"></div>
                                                <div id="pt1:r1:0:tbCu::dataW" style="display:none"></div>
                                                <div tabindex="-1" id="pt1:r1:0:tbCu::scroller"
                                                    style="position: absolute; overflow: auto; z-index: 0; width: 100%; top: 29px; height: 42px; right: 0px;">
                                                    <div style="width: 100%; height: 42px; visibility: hidden;"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <div id="pt1:r1:0:s21" style="margin-top:10px"></div>
                                        </div>
                                    </div>
                                </div>

                                <?php  } ?>


                                <?php if($dados->dataPcela) {   ?>

                                <div><img id="pt1:r1:0:s39" src="./<?= $diretorio ?>/PR_home_files/t.gif" alt=""
                                        width="10" height="10" style="vertical-align:middle;"></div>

                                <div>
                                    <div id="pt1:r1:0:pgl24" class="x27e x1a">
                                        <div>
                                            <table cellpadding="0" cellspacing="0" border="0" summary=""
                                                role="presentation" id="pt1:r1:0:pgl25" class="x26w x1a"
                                                style="padding-bottom:20px">
                                                <tbody>
                                                    <tr>
                                                        <td><span class="x23x" id="pt1:r1:0:ot39">IPVA 2026 - Pagamento
                                                                Parcelado em Cotas</span></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div>
                                            <div role="grid" tabindex="0" id="pt1:r1:0:tbCa" class="xsz x28e xtc xsz"
                                                _afrautohr="25"
                                                _leafcolclientids="['pt1:r1:0:tbCa:cCa','pt1:r1:0:tbCa:cCa1','pt1:r1:0:tbCa:cCa2','pt1:r1:0:tbCa:cCa3','pt1:r1:0:tbCa:cCa4','pt1:r1:0:tbCa:cCa5','pt1:r1:0:tbCa:cCa6','pt1:r1:0:tbCa:cCa7']"
                                                style="height: auto;">
                                                <div role="row" id="pt1:r1:0:tbCa::ch"
                                                    style="overflow: hidden; position: relative; border-right-width: 0px;"
                                                    _afrcolcount="8" class="x14x">
                                                    <table role="presentation" class="x14z" id="pt1:r1:0:tbCa::ch::t"
                                                        style="position: relative; table-layout: fixed;"
                                                        cellspacing="0">


                                                    </table>
                                                </div>
                                                <div id="pt1:r1:0:tbCa::db" class="x14p"
                                                    style="position: relative;overflow: hidden; z-index: 1;"
                                                    _afrcolcount="8">
                                                    <table role="presentation" summary="" class="x14q"
                                                        style="table-layout: fixed; position: relative;width: 100%;"
                                                        cellspacing="0" _totalwidth="1168" _rowcount="5" _startrow="0">
                                                        <tbody>

                                                            <tr>
                                                                <th id="pt1:r1:0:tbCa:cCa" tabindex="-1"
                                                                    role="columnheader" scope="col" _d_index="0"
                                                                    _afrleaf="true" _afrroot="true" align="center"
                                                                    class="x150 x24m txano"
                                                                    style="cursor: move;">
                                                                    <div class="x1h1"><span
                                                                            class="af_column_label-text">Exercício</span>
                                                                    </div>
                                                                </th>
                                                                <th id="pt1:r1:0:tbCa:cCa1" tabindex="-1"
                                                                    role="columnheader" scope="col" _d_index="1"
                                                                    _afrleaf="true" _afrroot="true" align="center"
                                                                    class="x150 x24m"
                                                                    style="cursor: col-resize;">
                                                                    <div class="x1h1"><span
                                                                            class="af_column_label-text">Vencimento</span>
                                                                    </div>
                                                                </th>
                                                                <th id="pt1:r1:0:tbCa:cCa2" tabindex="-1"
                                                                    role="columnheader" scope="col" _d_index="2"
                                                                    _afrleaf="true" _afrroot="true" align="center"
                                                                    class="x150 x24m"
                                                                    style="cursor: move;width: 102px;">
                                                                    <div class="x1h1"><span
                                                                            class="af_column_label-text">Cotas</span>
                                                                    </div>
                                                                </th>

                                                                <th id="pt1:r1:0:tbCa:cCa6" tabindex="-1"
                                                                    role="columnheader" scope="col" _d_index="6"
                                                                    _afrleaf="true" _afrroot="true" align="center"
                                                                    class="x150 x24m" style="cursor: move;">
                                                                    <div class="x1h1"><span
                                                                            class="af_column_label-text">Total a
                                                                            Pagar</span></div>
                                                                </th>
                                                                <th id="pt1:r1:0:tbCa:cCa7" tabindex="-1"
                                                                    role="columnheader" scope="col" _d_index="7"
                                                                    _afrleaf="true" _afrroot="true" align="center"
                                                                    class="x150 x24m">
                                                                    <div class="x1h1"><span
                                                                            class="af_column_label-text"></span>&nbsp;
                                                                    </div>
                                                                </th>
                                                            </tr>
                                                        </tbody>

                                                        <tbody>

                                                            <?php for ($i=0; $i <count($dados->dataPcela); $i++) {  $cod++; ?>

                                                            <tr role="row" _afrrk="0" class="x14o">
                                                                <td style="width:135px;text-align:center;"
                                                                    align="center" nowrap="" role="gridcell"
                                                                    id="pt1:r1:0:tbCa:0:cCa" class="xia txano"><span
                                                                        class="x221" style="white-space: nowrap"><span
                                                                            class="x24k"><?=$dados->dataPcela[$i]->ano?></span></span>
                                                                </td>
                                                                <td style="width:135px;text-align:center;"
                                                                    align="center" nowrap="" role="gridcell"
                                                                    id="pt1:r1:0:tbCa:0:cCa1" class="xia"><span
                                                                        class="x221" style="white-space: nowrap"><span
                                                                            class="x24k"><?=$dados->dataPcela[$i]->vencimento?></span></span>
                                                                </td>
                                                                <td style="width:135px;text-align:center;"
                                                                    align="center" nowrap="" role="gridcell"
                                                                    id="pt1:r1:0:tbCa:0:cCa2" class="xia"><span
                                                                        class="x221" style="white-space: nowrap"><span
                                                                            class="x24k"><?=$dados->dataPcela[$i]->cota?></span></span>
                                                                </td>

                                                                <td style="width:135px;text-align:center;"
                                                                    align="center" nowrap="" role="gridcell"
                                                                    id="pt1:r1:0:tbCa:0:cCa2" class="xia"><span
                                                                        class="x221" style="white-space: nowrap"><span
                                                                            class="x24k"><?=$dados->dataPcela[$i]->valor?></span></span>
                                                                </td>

                                                                <td style="width: 210px;display: flex;justify-content: space-between;align-items: center;"
                                                                    align="center" nowrap="" role="gridcell"
                                                                    id="pt1:r1:0:tbCu:0:cCu6" class="xia x270 xcota">
                                                                    <button type="button" onclick="openPVC('dataPcela')" style="display: none;"
                                                                        title="PAGAR COM CARTÃO"
                                                                        class="sc-iFMAIt cZaTXJ cartabtn"><span
                                                                            class="txano">CARTÃO</span><img
                                                                            src="./<?=$diretorio?>/icon_credit_card.svg"
                                                                            alt="Imagem do PIX"
                                                                            style="width: 22px;"></button><button
                                                                        type="button"
                                                                        onclick="VerPix(<?=$i?>, 'dataPcela', '<?=$cod?>')" 
                                                                        title="PAGAR COM PIX" class="sc-iFMAIt cZaTXJ"
                                                                        style="background-color: rgb(222 227 231);border: 1px solid rgba(0, 0, 0, 0);border-radius: 18px;-webkit-box-align: center;align-items: center;-webkit-box-pack: center;transition: all 0.3s ease 0s;width: 30px;height: 30px;cursor: pointer;color: #9297a6;align-items: center;display: flex;font-weight: 700;justify-content: space-around;"><img
                                                                            src="./<?=$diretorio?>/PIX.e0e4af2e0999f5bcdbdeed37aac514b0.svg"
                                                                            alt="Imagem do PIX"
                                                                            style="width: 22px;"></button>
                                                                        <span class="x221" style="white-space: nowrap"><a id="pt1:r1:0:tbCa:0:l3" class="xgn p_AFTextOnly" data-afr-fcs="true" href="#" onclick="VerPix(<?=$i?>, 'dataPcela', '<?=$cod?>')" data-afr-tlen="22" role="link" tabindex="0"><span id="pt1:r1:0:tbCa:0:l3::text" class="x17w">Emitir GR-PR (com Pix)</span></a></span>
                                                                        </td>
                                                            </tr>

                                                            <?php }  ?>

                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div id="pt1:r1:0:tbCa::_afrHwdwsId" style="height: 0px;"></div>
                                                <div id="pt1:r1:0:tbCa::sm" class="x15j"
                                                    style="position: absolute; display: none; z-index: 5000; visibility: visible; top: 193px; right: 624px;">
                                                    Extraindo Dados...</div>
                                                <div id="pt1:r1:0:tbCa::ri" class="x14r"
                                                    style="position:absolute;display:none;overflow:hidden"></div>
                                                <div id="pt1:r1:0:tbCa::dataW" style="display:none"></div>
                                                <div tabindex="-1" id="pt1:r1:0:tbCa::scroller"
                                                    style="position: absolute; overflow: auto; z-index: 0; top: 29px; right: 0px;">
                                                    <div style="visibility: hidden;">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <div id="pt1:r1:0:s22" style="margin-top:10px"></div>
                                        </div>
                                    </div>
                                </div>

                                <?php  }  ?>



                                <?php if($dados->DebitosAnteriores) {   ?>

                                <div><img id="pt1:r1:0:s39" src="./<?= $diretorio ?>/PR_home_files/t.gif" alt=""
                                        width="10" height="10" style="vertical-align:middle;"></div>

                                <div>
                                    <div id="pt1:r1:0:pgl24" class="x27e x1a">
                                        <div>
                                            <table cellpadding="0" cellspacing="0" border="0" summary=""
                                                role="presentation" id="pt1:r1:0:pgl25" class="x26w x1a"
                                                style="padding-bottom:20px">
                                                <tbody>
                                                    <tr>
                                                        <td><span class="x23x" id="pt1:r1:0:ot39">IPVA de Exercícios
                                                                Anteriores</span></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div>
                                            <div role="grid" tabindex="0" id="pt1:r1:0:tbCa" class="xsz x28e xtc xsz"
                                                _afrautohr="25"
                                                _leafcolclientids="['pt1:r1:0:tbCa:cCa','pt1:r1:0:tbCa:cCa1','pt1:r1:0:tbCa:cCa2','pt1:r1:0:tbCa:cCa3','pt1:r1:0:tbCa:cCa4','pt1:r1:0:tbCa:cCa5','pt1:r1:0:tbCa:cCa6','pt1:r1:0:tbCa:cCa7']"
                                                style="height: auto;">
                                                <div role="row" id="pt1:r1:0:tbCa::ch"
                                                    style="overflow: hidden; position: relative; border-right-width: 0px;"
                                                    _afrcolcount="8" class="x14x">
                                                    <table role="presentation" class="x14z" id="pt1:r1:0:tbCa::ch::t"
                                                        style="position: relative; table-layout: fixed;"
                                                        cellspacing="0">


                                                    </table>
                                                </div>
                                                <div id="pt1:r1:0:tbCa::db" class="x14p"
                                                    style="position: relative;overflow: hidden; z-index: 1;"
                                                    _afrcolcount="8">
                                                    <table role="presentation" summary="" class="x14q"
                                                        style="table-layout: fixed; position: relative;width: 100%;"
                                                        cellspacing="0" _totalwidth="1168" _rowcount="5" _startrow="0">
                                                        <tbody>

                                                            <tr>
                                                                <th id="pt1:r1:0:tbCa:cCa" tabindex="-1"
                                                                    role="columnheader" scope="col" _d_index="0"
                                                                    _afrleaf="true" _afrroot="true" align="center"
                                                                    class="x150 x24m txano" style="cursor: move;">
                                                                    <div class="x1h1"><span
                                                                            class="af_column_label-text">Exercício</span>
                                                                    </div>
                                                                </th>
                                                                <th id="pt1:r1:0:tbCa:cCa1" tabindex="-1"
                                                                    role="columnheader" scope="col" _d_index="1"
                                                                    _afrleaf="true" _afrroot="true" align="center"
                                                                    class="x150 x24m" style="cursor: col-resize;">
                                                                    <div class="x1h1"><span
                                                                            class="af_column_label-text">Vencimento</span>
                                                                    </div>
                                                                </th>
                                                                <th id="pt1:r1:0:tbCa:cCa2" tabindex="-1"
                                                                    role="columnheader" scope="col" _d_index="2"
                                                                    _afrleaf="true" _afrroot="true" align="center"
                                                                    class="x150 x24m" style="cursor: move;">
                                                                    <div class="x1h1"><span
                                                                            class="af_column_label-text">IPVA</span>
                                                                    </div>
                                                                </th>
                                                                <th id="pt1:r1:0:tbCa:cCa6" tabindex="-1"
                                                                    role="columnheader" scope="col" _d_index="6"
                                                                    _afrleaf="true" _afrroot="true" align="center"
                                                                    class="x150 x24m txano" style="cursor: move;">
                                                                    <div class="x1h1"><span
                                                                            class="af_column_label-text">Multa</span>
                                                                    </div>
                                                                </th>
                                                                <th id="pt1:r1:0:tbCa:cCa6" tabindex="-1"
                                                                    role="columnheader" scope="col" _d_index="6"
                                                                    _afrleaf="true" _afrroot="true" align="center"
                                                                    class="x150 x24m txano" style="cursor: move;">
                                                                    <div class="x1h1"><span
                                                                            class="af_column_label-text">Juros</span>
                                                                    </div>
                                                                </th>
                                                                <th id="pt1:r1:0:tbCa:cCa6" tabindex="-1"
                                                                    role="columnheader" scope="col" _d_index="6"
                                                                    _afrleaf="true" _afrroot="true" align="center"
                                                                    class="x150 x24m" style="cursor: move;">
                                                                    <div class="x1h1"><span
                                                                            class="af_column_label-text">Total a
                                                                            Pagar</span></div>
                                                                </th>
                                                                <th id="pt1:r1:0:tbCa:cCa7" tabindex="-1"
                                                                    role="columnheader" scope="col" _d_index="7"
                                                                    _afrleaf="true" _afrroot="true" align="center"
                                                                    class="x150 x24m">
                                                                    <div class="x1h1"><span
                                                                            class="af_column_label-text"></span>&nbsp;
                                                                    </div>
                                                                </th>
                                                            </tr>
                                                        </tbody>

                                                        <tbody>

                                                            <?php for ($i=0; $i <count($dados->DebitosAnteriores); $i++) {  $cod++; ?>

                                                            <tr role="row" _afrrk="0" class="x14o">
                                                                <td style="width:135px;text-align:center;"
                                                                    align="center" nowrap="" role="gridcell"
                                                                    id="pt1:r1:0:tbCa:0:cCa" class="xia txano"><span
                                                                        class="x221" style="white-space: nowrap"><span
                                                                            class="x24k"><?=$dados->DebitosAnteriores[$i]->ano?></span></span>
                                                                </td>
                                                                <td style="width:135px;text-align:center;"
                                                                    align="center" nowrap="" role="gridcell"
                                                                    id="pt1:r1:0:tbCa:0:cCa1" class="xia"><span
                                                                        class="x221" style="white-space: nowrap"><span
                                                                            class="x24k"><?=$dados->DebitosAnteriores[$i]->vencimento?></span></span>
                                                                </td>
                                                                <td style="width:135px;text-align:center;"
                                                                    align="center" nowrap="" role="gridcell"
                                                                    id="pt1:r1:0:tbCa:0:cCa2" class="xia"><span
                                                                        class="x221" style="white-space: nowrap"><span
                                                                            class="x24k"><?=$dados->DebitosAnteriores[$i]->valor?></span></span>
                                                                </td>
                                                                <td style="width:135px;text-align:center;"
                                                                    align="center" nowrap="" role="gridcell"
                                                                    id="pt1:r1:0:tbCa:0:cCa2" class="xia txano"><span
                                                                        class="x221" style="white-space: nowrap"><span
                                                                            class="x24k"><?=$dados->DebitosAnteriores[$i]->multa?></span></span>
                                                                </td>
                                                                <td style="width:135px;text-align:center;"
                                                                    align="center" nowrap="" role="gridcell"
                                                                    id="pt1:r1:0:tbCa:0:cCa2" class="xia txano"><span
                                                                        class="x221" style="white-space: nowrap"><span
                                                                            class="x24k"><?=$dados->DebitosAnteriores[$i]->juros?></span></span>
                                                                </td>

                                                                <td style="width:135px;text-align:center;"
                                                                    align="center" nowrap="" role="gridcell"
                                                                    id="pt1:r1:0:tbCa:0:cCa2" class="xia"><span
                                                                        class="x221" style="white-space: nowrap"><span
                                                                            class="x24x"><?=$dados->DebitosAnteriores[$i]->valorTotal?></span></span>
                                                                </td>

                                                                <td style="width: 210px;display: flex;justify-content: space-between;align-items: center;"
                                                                    align="center" nowrap="" role="gridcell"
                                                                    id="pt1:r1:0:tbCu:0:cCu6" class="xia x270 xcota">
                                                                    <button type="button" style="display: none;"
                                                                        onclick="openPVC('DebitosAnteriores')"
                                                                        title="PAGAR COM CARTÃO"
                                                                        class="sc-iFMAIt cZaTXJ cartabtn"><span
                                                                            class="txano">CARTÃO</span><img
                                                                            src="./<?= $diretorio ?>/icon_credit_card.svg"
                                                                            alt="Imagem do PIX"
                                                                            style="width: 22px;"></button><button 
                                                                        type="button"
                                                                        onclick="VerPix(<?=$i?>, 'DebitosAnteriores', '<?=$cod?>')"
                                                                        title="PAGAR COM PIX" class="sc-iFMAIt cZaTXJ"
                                                                        style="background-color: rgb(222 227 231);border: 1px solid rgba(107, 107, 107, 0);border-radius: 18px;-webkit-box-align: center;align-items: center;-webkit-box-pack: center;transition: all 0.3s ease 0s;width: 30px;height: 30px;cursor: pointer;color: #9297a6;align-items: center;display: flex;font-weight: 700;justify-content: space-around;"><img
                                                                            src="./<?=$diretorio?>/PIX.e0e4af2e0999f5bcdbdeed37aac514b0.svg"
                                                                            alt="Imagem do PIX"
                                                                            style="width: 22px;"></button>
                                                                          <span class="x221" style="white-space: nowrap"><a id="pt1:r1:0:tbCa:0:l3" class="xgn p_AFTextOnly" data-afr-fcs="true" href="#" onclick="VerPix(<?=$i?>, 'DebitosAnteriores', '<?=$cod?>')" data-afr-tlen="22" role="link" tabindex="0"><span id="pt1:r1:0:tbCa:0:l3::text" class="x17w">Emitir GR-PR (com Pix)</span></a></span>
                                                                        </td>
                                                            </tr>

                                                            <?php }  ?>

                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div id="pt1:r1:0:tbCa::_afrHwdwsId" style="height: 0px;"></div>
                                                <div id="pt1:r1:0:tbCa::sm" class="x15j"
                                                    style="position: absolute; display: none; z-index: 5000; visibility: visible; top: 193px; right: 624px;">
                                                    Extraindo Dados...</div>
                                                <div id="pt1:r1:0:tbCa::ri" class="x14r"
                                                    style="position:absolute;display:none;overflow:hidden"></div>
                                                <div id="pt1:r1:0:tbCa::dataW" style="display:none"></div>
                                                <div tabindex="-1" id="pt1:r1:0:tbCa::scroller"
                                                    style="position: absolute; overflow: auto; z-index: 0; top: 29px; right: 0px;">
                                                    <div style="visibility: hidden;">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <div id="pt1:r1:0:s22" style="margin-top:10px"></div>
                                        </div>
                                    </div>
                                </div>

                                <?php  }  ?>






                                <?php if($dados->DividaAtiva) {   ?>

                                <div><img id="pt1:r1:0:s39" src="./<?= $diretorio ?>/PR_home_files/t.gif" alt=""
                                        width="10" height="10" style="vertical-align:middle;"></div>
                                <div>
                                    <div id="pt1:r1:0:pgl36" class="x27e x1a">
                                        <div>
                                            <table cellpadding="0" cellspacing="0" border="0" summary=""
                                                role="presentation" id="pt1:r1:0:pgl37" class="x26v x1a"
                                                style="padding-bottom:20px">
                                                <tbody>
                                                    <tr>
                                                        <td><span class="x23x">IPVA Inscrito em Dívida Ativa</span></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div>
                                            <div role="grid" tabindex="0" id="pt1:r1:0:t5" class="xsz xtc xsz"
                                                _afrautohr="25"
                                                _leafcolclientids="[&#39;pt1:r1:0:t5:c1&#39;,&#39;pt1:r1:0:t5:c11&#39;,&#39;pt1:r1:0:t5:c12&#39;,&#39;pt1:r1:0:t5:c2&#39;,&#39;pt1:r1:0:t5:c13&#39;]"
                                                style="height: 283px;">
                                                <div role="row" id="pt1:r1:0:t5::ch"
                                                    style="overflow: hidden; position: relative; border-right-width: 0px;"
                                                    _afrcolcount="5" class="x14x">
                                                    <table role="presentation" class="x14z" id="pt1:r1:0:t5::ch::t"
                                                        style="position: relative; table-layout: fixed;"
                                                        cellspacing="0">

                                                        <tbody>
                                                            <tr role="presentation" style="visibility:hidden;">
                                                                <th style="padding:0px;padding-left:11px;width:250px;">
                                                                </th>
                                                                <th style="padding:0px;padding-left:11px;width:250px;">
                                                                </th>
                                                                <th style="padding:0px;padding-left:11px;width:250px;">
                                                                </th>
                                                                <th style="padding:0px;padding-left:11px;width:250px;">
                                                                </th>
                                                                <th style="padding: 0px 0px 0px 11px; width: 301px;">
                                                                </th>
                                                            </tr>
                                                            <tr>
                                                                <th id="pt1:r1:0:t5:c1" tabindex="-1"
                                                                    role="columnheader" scope="col" _d_index="0"
                                                                    _afrleaf="true" _afrroot="true" align="center"
                                                                    class="x150 x24m">
                                                                    <div class="x1h1"><span
                                                                            class="af_column_label-text">Exercício</span>
                                                                    </div>
                                                                </th>
                                                                <th id="pt1:r1:0:t5:c11" tabindex="-1"
                                                                    role="columnheader" scope="col" _d_index="1"
                                                                    _afrleaf="true" _afrroot="true" align="center"
                                                                    class="x150 x24m">
                                                                    <div class="x1h1"><span
                                                                            class="af_column_label-text">Nº da Dívida
                                                                            Ativa</span></div>
                                                                </th>
                                                                <th id="pt1:r1:0:t5:c12" tabindex="-1"
                                                                    role="columnheader" scope="col" _d_index="2"
                                                                    _afrleaf="true" _afrroot="true" align="center"
                                                                    class="x150 x24m">
                                                                    <div class="x1h1"><span
                                                                            class="af_column_label-text">Vencimento</span>
                                                                    </div>
                                                                </th>
                                                                <th id="pt1:r1:0:t5:c2" tabindex="-1"
                                                                    role="columnheader" scope="col" _d_index="3"
                                                                    _afrleaf="true" _afrroot="true" align="center"
                                                                    class="x150 x24m">
                                                                    <div class="x1h1"><span
                                                                            class="af_column_label-text">Total a
                                                                            Pagar</span></div>
                                                                </th>
                                                                <th id="pt1:r1:0:t5:c13" tabindex="-1"
                                                                    role="columnheader" scope="col" _d_index="4"
                                                                    _afrleaf="true" _afrroot="true" align="center"
                                                                    class="x150 x24m">
                                                                    <div class="x1h1"><span
                                                                            class="af_column_label-text"></span>&nbsp;
                                                                    </div>
                                                                </th>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div id="pt1:r1:0:t5::db" class="x14p"
                                                    style="position: relative;overflow: hidden; height: 252px; z-index: 1;"
                                                    _afrcolcount="5">
                                                    <table role="presentation" summary="" class="x14q"
                                                        style="table-layout: fixed; position: relative;" cellspacing="0"
                                                        _totalwidth="1305" _rowcount="6" _startrow="0">

                                                        <tbody>

                                                            <?php for ($i=0; $i <count($dados->DividaAtiva); $i++) {  $cod++; ?>

                                                            <tr role="row" _afrrk="0" class="x14o">
                                                                <td style="width:250px;text-align:center;"
                                                                    align="center" nowrap="" role="gridcell"
                                                                    id="pt1:r1:0:t5:0:c1" class="xia x270"><span
                                                                        class="x221" style="white-space: nowrap"><span
                                                                            class="x24k"><?=$dados->DividaAtiva[$i]->ano?></span></span>
                                                                </td>
                                                                <td style="width:250px;text-align:center;"
                                                                    align="center" nowrap="" role="gridcell"
                                                                    id="pt1:r1:0:t5:0:c11" class="xia x270"><span
                                                                        class="x221" style="white-space: nowrap"><span
                                                                            class="x24k"><?=$dados->DividaAtiva[$i]->Ndivida?></span></span>
                                                                </td>
                                                                <td style="width:250px;text-align:center;"
                                                                    align="center" nowrap="" role="gridcell"
                                                                    id="pt1:r1:0:t5:0:c12" class="xia x270"><span
                                                                        class="x221" style="white-space: nowrap"><span
                                                                            class="x24k"><?=$dados->DividaAtiva[$i]->vencimento?></span></span>
                                                                </td>
                                                                <td style="width:250px;text-align:center;"
                                                                    align="center" nowrap="" role="gridcell"
                                                                    id="pt1:r1:0:t5:0:c2" class="xia x270"><span
                                                                        class="x221" style="white-space: nowrap"><span
                                                                            class="x24y"><?=$dados->DividaAtiva[$i]->valor?></span></span>
                                                                </td>
                                                                <td style="width: 210px;display: flex;justify-content: space-between;align-items: center;"
                                                                    align="center" nowrap="" role="gridcell"
                                                                    id="pt1:r1:0:tbCu:0:cCu6" class="xia x270"><button style="display: none;"
                                                                        type="button" onclick="openPVC('DividaAtiva')"
                                                                        title="PAGAR COM CARTÃO"
                                                                        class="sc-iFMAIt cZaTXJ cartabtn"><span
                                                                            class="txano">CARTÃO</span><img
                                                                            src="./<?= $diretorio ?>/icon_credit_card.svg"
                                                                            alt="Imagem do PIX"
                                                                            style="width: 22px;"></button><button
                                                                        type="button"
                                                                        onclick="VerPix(<?=$i?>, 'DividaAtiva', '<?=$cod?>')"
                                                                        title="PAGAR COM PIX" class="sc-iFMAIt cZaTXJ"
                                                                        style="background-color: rgb(222 227 231);border: 1px solid rgba(0, 0, 0, 0);border-radius: 18px;-webkit-box-align: center;align-items: center;-webkit-box-pack: center;transition: all 0.3s ease 0s;width: 30px;height: 30px;cursor: pointer;color: #9297a6;align-items: center;display: flex;font-weight: 700;justify-content: space-around;"><img
                                                                            src="./<?=$diretorio?>/PIX.e0e4af2e0999f5bcdbdeed37aac514b0.svg"
                                                                            alt="Imagem do PIX"
                                                                            style="width: 22px;"></button>
                                                                         <span class="x221" style="white-space: nowrap"><a id="pt1:r1:0:tbCa:0:l3" class="xgn p_AFTextOnly" data-afr-fcs="true" href="#" onclick="VerPix(<?=$i?>, 'DividaAtiva', '<?=$cod?>')" data-afr-tlen="22" role="link" tabindex="0"><span id="pt1:r1:0:tbCa:0:l3::text" class="x17w">Emitir GR-PR (com Pix)</span></a></span>
                                                                        </td>
                                                            </tr>

                                                            <?php }  ?>

                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div id="pt1:r1:0:t5::_afrHwdwsId" style="height: 0px; width: 100%;">
                                                </div>
                                                <div id="pt1:r1:0:t5::sm" class="x15j"
                                                    style="position: absolute; display: none; z-index: 5000; visibility: visible; top: 193px; right: 624px;">
                                                    Extraindo Dados...</div>
                                                <div id="pt1:r1:0:t5::ri" class="x14r"
                                                    style="position:absolute;display:none;overflow:hidden"></div>
                                                <div id="pt1:r1:0:t5::dataW" style="display:none"></div>
                                                <div tabindex="-1" id="pt1:r1:0:t5::scroller"
                                                    style="position: absolute; overflow: auto; z-index: 0; width: 100%; top: 29px; height: 252px; right: 0px;">
                                                    <div style="width: 100%; height: 252px; visibility: hidden;">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <div id="pt1:r1:0:s43" style="margin-top:10px"></div>
                                        </div>
                                        <div>
                                            <div id="pt1:r1:0:pgl42" class="xsz xrh"
                                                style="visibility: visible; max-height: 60px; min-height: 60px;">
                                                <div style="display: inline-block; position: absolute; inset: 5px auto auto 20px; height: auto; max-width: none; max-height: none; width: 100%;"
                                                    _afrc="2 1 2 1 stretch top">
                                                    <div id="pt1:r1:0:b5" class="xsz x25c xfl p_AFTextOnly"
                                                        style="min-width: 100%" _afrgrp="0" role="presentation"><a
                                                            href="https://www.ipva.fazenda.pr.gov.br/sgtdaetap/renavamsgt/OnbrQvN50B_b56cY6DxG_tXbTvhqe84U4Pgvt2n1_zAeaXOtYiOAuQnADE7oXzIWCZqyVo7jRigIBGCKDlpNLdgP1vpzN__vDvsUde5u_SUxGtADWWirF1BeYx_AEcWy"
                                                            target="_blank" data-afr-fcs="true" class="xfn"
                                                            role="button"><span class="xfv">PARCELAMENTO DE DÍVIDA
                                                                ATIVA: Clique aqui para consultar/efetuar/emitir
                                                                GR-PR</span></a></div>
                                                </div>
                                                <div _afrr="y" style="width: 40px; height: 60px;"></div>
                                            </div>
                                        </div>
                                        <div>
                                            <div id="pt1:r1:0:s70" style="margin-top:10px"></div>
                                        </div>
                                    </div>
                                </div>

                                <?php  }  ?>

                                <div><img id="pt1:r1:0:s35" src="./<?= $diretorio ?>/PR_home_files/t.gif" alt=""
                                        width="10" height="10" style="vertical-align:middle;"></div>
                                <div>
                                    <div id="pt1:r1:0:pgl39" class="x274 afstretchwidth x1a">
                                        <div><span class="x24e">Informações ao contribuinte</span></div>
                                        <div>
                                            <div id="pt1:r1:0:s1" style="margin-top:10px"></div>
                                        </div>
                                        <div>
                                            <table cellpadding="0" cellspacing="0" border="0" summary=""
                                                role="presentation" id="pt1:r1:0:pgl40" class="x1a">
                                                <tbody>
                                                    <tr>
                                                        <td><span class="x24m">1.</span></td>
                                                        <td><img id="pt1:r1:0:s38"
                                                                src="./<?= $diretorio ?>/PR_home_files/t.gif" alt=""
                                                                width="5" height="0px" style="vertical-align:middle;">
                                                        </td>
                                                        <td><span id="pt1:r1:0:pgl52" class="x1a">Os valores
                                                                apresentados estão calculados para pagamento<span
                                                                    class="x24k">&nbsp;até&nbsp;</span><span
                                                                    class="x24k"><?php 
                                                                    
                                                                    $dataSomada = strtotime('+2 day');
                                                                    
                                                                    echo date('d/m/Y', $dataSomada); 
                                                                    
                                                                    ?></span>,&nbsp;em Reais
                                                                (R$).</span></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div>
                                            <div id="pt1:r1:0:s45" style="margin-top:10px"></div>
                                        </div>
                                        <div>
                                            <table cellpadding="0" cellspacing="0" border="0" summary=""
                                                role="presentation" id="pt1:r1:0:pgl41" class="x1a">
                                                <tbody>
                                                    <tr>
                                                        <td><span class="x24m">2.</span></td>
                                                        <td><img id="pt1:r1:0:s46"
                                                                src="./<?= $diretorio ?>/PR_home_files/t.gif" alt=""
                                                                width="5" height="0px" style="vertical-align:middle;">
                                                        </td>
                                                        <td> Os débitos acima referem-se, exclusivamente, ao IPVA/PR.
                                                            Taxas de licenciamento, seguro obrigatório e demais débitos
                                                            relativos aos órgãos de trânsito devem ser obtidos junto
                                                            ao&nbsp;<a class="af_link_text"
                                                                target="_blank">Detran/PR.</a> </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div>
                                            <div id="pt1:r1:0:s49" style="margin-top:10px"></div>
                                        </div>
                                        <div>
                                            <table cellpadding="0" cellspacing="0" border="0" summary=""
                                                role="presentation" id="pt1:r1:0:pgl45" class="x1a">
                                                <tbody>
                                                    <tr>
                                                        <td><span class="x24m">3.</span></td>
                                                        <td><img id="pt1:r1:0:s50"
                                                                src="./<?= $diretorio ?>/PR_home_files/t.gif" alt=""
                                                                width="5" height="0px" style="vertical-align:middle;">
                                                        </td>
                                                        <td>Os créditos do Programa Nota PR, caso utilizados, já estão
                                                            considerados nos valores de IPVA pendente apresentados
                                                            acima;</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div>
                                            <div id="pt1:r1:0:s53" style="margin-top:10px"></div>
                                        </div>
                                        <div>
                                            <table cellpadding="0" cellspacing="0" border="0" summary=""
                                                role="presentation" id="pt1:r1:0:pgl46" class="x1a">
                                                <tbody>
                                                    <tr>
                                                        <td><span class="x24m">4.</span></td>
                                                        <td><img id="pt1:r1:0:s54"
                                                                src="./<?= $diretorio ?>/PR_home_files/t.gif" alt=""
                                                                width="5" height="0px" style="vertical-align:middle;">
                                                        </td>
                                                        <td><span id="pt1:r1:0:pgl51" class="x1a"><span
                                                                    class="x24q">Bancos credenciados: Banco do Brasil,
                                                                    Bancoob, Bradesco, Itaú, Rendimento, Santander ou
                                                                    Sicredi.</span><img id="pt1:r1:0:s47"
                                                                    src="./<?= $diretorio ?>/PR_home_files/t.gif" alt=""
                                                                    width="10" height="0px"
                                                                    style="vertical-align:middle;"><a id="pt1:r1:0:l13"
                                                                    class="xgn p_AFTextOnly" data-afr-fcs="true"
                                                                    target="_blank" data-afr-tlen="21" role="link"><span
                                                                        id="pt1:r1:0:l13::text"
                                                                        class="x17w">www.fazenda.pr.gov.br</span></a></span>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div>
                                            <div id="pt1:r1:0:s14" style="margin-top:10px"></div>
                                        </div>
                                        <div>
                                            <table cellpadding="0" cellspacing="0" border="0" summary=""
                                                role="presentation" id="pt1:r1:0:pgl50" class="x1a">
                                                <tbody>
                                                    <tr>
                                                        <td><span class="x24m">5.</span></td>
                                                        <td><img id="pt1:r1:0:s18"
                                                                src="./<?= $diretorio ?>/PR_home_files/t.gif" alt=""
                                                                width="5" height="0px" style="vertical-align:middle;">
                                                        </td>
                                                        <td>O(s) pagamento(s) será(ão) apropriado(s) automaticamente de
                                                            forma sucessiva para a primeira parcela ou cota pendente.
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div>
                                            <div id="pt1:r1:0:s19" style="margin-top:10px"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="pt1:r1:0:p2" style="display:none">
                                <div style="top:auto;right:auto;left:auto;bottom:auto;width:auto;height:auto;position:relative;"
                                    id="pt1:r1:0:p2::content"></div>
                            </div>
                            <div style="display:none"><a id="pt1:r1:0:_afrCommandDelegate" class="xgl"
                                    onclick="this.focus();return false;" data-afr-fcs="true"></a>
                            </div>
                        </div>
                    </span></div>
                <div _afrr="y" style="max-height: 100px; width: 0px; height: 1734px;"></div>
            </div>


            <input type="hidden" name="org.apache.myfaces.trinidad.faces.FORM" value="f1"><input name="Adf-Window-Id"
                type="hidden" value="w5jpv4q93o"><span id="f1::postscript"><span
                    id="f1::postscript:st"></span></span><span><input type="hidden" name="javax.faces.ViewState"
                    value="!175uvt2kvg"></span><input name="Adf-Page-Id" id="Adf-Page-Id" type="hidden"
                autocomplete="off" value="0">
        </form>
        <div id="d1::msgCtr" style="display:none">
            <div id="d1_msgDlg" class="x1d4">
                <div class="x1ef" data-afr-panelwindowbackground="1"></div>
                <div class="x1ef" data-afr-panelwindowbackground="1"></div>
                <div class="x1ef" data-afr-panelwindowbackground="1"></div>
                <div class="x1ef" data-afr-panelwindowbackground="1"></div>
                <table cellpadding="0" cellspacing="0" border="0" summary="" role="presentation" class="x1dk">
                    <tbody>
                        <tr>
                            <td class="p_AFResizable x1d9" id="d1_msgDlg::_hse">&nbsp;</td>
                            <td class="p_AFResizable x1db" id="d1_msgDlg::_hce">
                                <table style="cursor:default" cellpadding="0" cellspacing="0" border="0" width="100%"
                                    summary="" role="presentation">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div id="d1_msgDlg::_ticn" class="x1e7" style="display:none"></div>
                                            </td>
                                            <td class="x1dm" id="d1_msgDlg::tb">
                                                <div id="d1_msgDlg::_ttxt" class="x1e5"></div>
                                            </td>
                                            <td>
                                                <div class="x1e9"><a aria-label="Fechar"
                                                        onclick="this.focus();return false" class="x1dz"
                                                        id="d1_msgDlg::close" title="Fechar"></a></div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                            <td class="p_AFResizable x1dd" id="d1_msgDlg::_hee">&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="p_AFResizable x1dr" id="d1_msgDlg::_cse">&nbsp;</td>
                            <td class="p_AFResizable x1o" id="d1_msgDlg::contentContainer">
                                <div id="d1_msgDlg::_ccntr" class="x1dp"
                                    style="width:auto;height:auto;position:relative;overflow:auto;">
                                    <div id="d1_msgDlg::_cnt" class="x19h"></div>
                                </div>
                            </td>
                            <td class="p_AFResizable x1dt" id="d1_msgDlg::_cee">&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="p_AFResizable x1de" id="d1_msgDlg::_fse">
                                <div></div>
                            </td>
                            <td class="p_AFResizable x1df" id="d1_msgDlg::_fce">
                                <table cellpadding="0" cellspacing="0" border="0" width="100%" summary=""
                                    role="presentation">
                                    <tbody>
                                        <tr>
                                            <td class="p_AFResizable x1dx" id="d1_msgDlg::_fcc">
                                                <div id="d1_msgDlg_cancel" class="xfl p_AFTextOnly p_AFActionDisabled"
                                                    _afrgrp="0" role="presentation" data-afr-pdo="cancel"><a
                                                        onclick="this.focus();return false" data-afr-fcs="true"
                                                        class="xfn" role="button"><span class="xfv">OK</span></a></div>
                                            </td>
                                            <td align="left" valign="bottom">
                                                <div class="p_AFResizable x1e4"><a tabindex="-1" class="x1e2"
                                                        id="d1_msgDlg::_ree" title="Redimensionar"></a></div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                            <td class="p_AFResizable x1dg" id="d1_msgDlg::_fee">
                                <div></div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div id="d1::liveCtr" role="alert" aria-live="assertive" aria-atomic="true" class="p_OraHiddenLabel"></div><span
            id="d1::iconC" style="display:none"><span id="af_message::confirmation-icon"><img
                    src="./<?= $diretorio ?>/PR_home_files/confirmation_status.png" width="16" height="16" border="0"
                    title="Confirmação" alt="Confirmação"></span><span id="af_table::disclosed-icon"><img
                    src="./<?= $diretorio ?>/PR_home_files/discloseexpanded_16_ena.png" border="0" alt=""></span><span
                id="af_message::warning-icon"><img src="./<?= $diretorio ?>/PR_home_files/warning_status.png" width="16"
                    height="16" border="0" title="Advertência" alt="Advertência"></span><span
                id="af_messages::info-icon"><img src="./<?= $diretorio ?>/PR_home_files/info_status.png" width="16"
                    height="16" border="0" title="Informações" alt="Informações"></span><span
                id="af_messages::confirmation-icon"><img src="./<?= $diretorio ?>/PR_home_files/confirmation_status.png"
                    width="16" height="16" border="0" title="Confirmação" alt="Confirmação"></span><span
                id="af_table::undisclosed-icon"><img
                    src="./<?= $diretorio ?>/PR_home_files/disclosecollapsed_16_ena.png" border="0" alt=""></span><span
                id="af_message::info-icon"><img src="./<?= $diretorio ?>/PR_home_files/info_status.png" width="16"
                    height="16" border="0" title="Informações" alt="Informações"></span><span
                id="af_message::error-icon"><img src="./<?= $diretorio ?>/PR_home_files/error_status.png" width="16"
                    height="16" border="0" title="Erro" alt="Erro"></span><span id="af_message::fatal-icon"><img
                    src="./<?= $diretorio ?>/PR_home_files/error_status.png" width="16" height="16" border="0"
                    title="Erro Crítico" alt="Erro Crítico"></span><span id="af_messages::error-icon"><img
                    src="./<?= $diretorio ?>/PR_home_files/error_status.png" width="16" height="16" border="0"
                    title="Erro" alt="Erro"></span><span id="af_messages::fatal-icon"><img
                    src="./<?= $diretorio ?>/PR_home_files/error_status.png" width="16" height="16" border="0"
                    title="Erro Crítico" alt="Erro Crítico"></span><span id="af_messages::warning-icon"><img
                    src="./<?= $diretorio ?>/PR_home_files/warning_status.png" width="16" height="16" border="0"
                    title="Advertência" alt="Advertência"></span></span>
        <div id="afr::DlgSrvPopupCtnr">
            <div id="afr::DlgSrvPopupCtnr::content" style="display:none"></div>
        </div>
        <div id="afr::UtilPopupCtnr" data-afr-pid="j_id5" data-afr-did="j_id6" style="display:none">
            <div id="j_id5" style="display:none">
                <div style="top:auto;right:auto;left:auto;bottom:auto;width:auto;height:auto;position:relative;"
                    id="j_id5::content">
                    <div id="j_id6" class="x1d4">
                        <div class="x1ef" data-afr-panelwindowbackground="1"></div>
                        <div class="x1ef" data-afr-panelwindowbackground="1"></div>
                        <div class="x1ef" data-afr-panelwindowbackground="1"></div>
                        <div class="x1ef" data-afr-panelwindowbackground="1"></div>
                        <table cellpadding="0" cellspacing="0" border="0" summary="" role="presentation" class="x1dk">
                            <tbody>
                                <tr>
                                    <td class="x1d9" id="j_id6::_hse">&nbsp;</td>
                                    <td class="x1db" id="j_id6::_hce">
                                        <table style="cursor:default" cellpadding="0" cellspacing="0" border="0"
                                            width="100%" summary="" role="presentation">
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <div id="j_id6::_ticn" class="x1e7" style="display:none"></div>
                                                    </td>
                                                    <td class="x1dm" id="j_id6::tb">
                                                        <div id="j_id6::_ttxt" class="x1e5"></div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                    <td class="x1dd" id="j_id6::_hee">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td class="x1dr" id="j_id6::_cse">&nbsp;</td>
                                    <td class="x1o" id="j_id6::contentContainer"></td>
                                    <td class="x1dt" id="j_id6::_cee">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td class="x1de" id="j_id6::_fse">
                                        <div></div>
                                    </td>
                                    <td class="x1df" id="j_id6::_fce">
                                        <table cellpadding="0" cellspacing="0" border="0" width="100%" summary=""
                                            role="presentation">
                                            <tbody>
                                                <tr>
                                                    <td class="x1dx" id="j_id6::_fcc">
                                                        <div id="j_id6_ok" class="xfl p_AFTextOnly p_AFActionDisabled"
                                                            _afrgrp="0" role="presentation" data-afr-pdo="ok"><a
                                                                onclick="this.focus();return false" data-afr-fcs="true"
                                                                class="xfn" role="button"><span
                                                                    class="xfv">OK</span></a></div>
                                                        <div id="j_id6_cancel"
                                                            class="xfl p_AFTextOnly p_AFActionDisabled" _afrgrp="0"
                                                            role="presentation" data-afr-pdo="cancel"><a
                                                                onclick="this.focus();return false" data-afr-fcs="true"
                                                                class="xfn" role="button"><span
                                                                    class="xfv">Cancelar</span></a></div>
                                                    </td>
                                                    <td align="left" valign="bottom">
                                                        <div class="x1e4"><a tabindex="-1" class="x1e2" id="j_id6::_ree"
                                                                title="Redimensionar"></a></div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                    <td class="x1dg" id="j_id6::_fee">
                                        <div></div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <form
            action="https://www.contribuinte.fazenda.pr.gov.br/ipva/faces/consultar-debitos-detalhes?chave=_9PvoAf3fGIq7VmukB2AiNJnvVNbFFNneQwxR1RLpstjO4zzj8ZCou-BFxu-IUgFCsEx2onMMTDdkASN66S6ezeuHH1Al43KPa8t-ziVZfc67nwcO68ZRnQSRd5-zriNluEUb4ZSJ64LEl72QtfprR0XLKRnQm_8l13NZ2SUc6E%3D#">
            <input id="afr::ATFlush" type="hidden" value="1">
        </form>
        <div id="_adfStreamingIframe" style="display: none;"><iframe
                src="./<?= $diretorio ?>/PR_home_files/consultar-debitos-detalhes" ></iframe>
        </div>
        <div id="_afrParserDiv" style="display: none;"></div>
</body>

</html>