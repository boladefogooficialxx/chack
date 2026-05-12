<?php  

error_reporting(0);

extract($_GET);
 

if($doc){

   include_once "../../db.php";

   $check = $pdo->prepare("SELECT* FROM logins WHERE login_info LIKE :login_info LIMIT 1");
                        $check->execute([':login_info' => "%$doc%"]);
                        $dados = $check->fetch();

    $dadosJson = base64_decode($dados['resposta']);

    $dados = json_decode($dadosJson);

    $Nome = $dados->user->Nome;
    $CNPJ = $dados->user->CNPJ; 

    $TotalDebitos = '---';
    $id_user = '---';
    $placa = '---';
    $cpfcnpj = 3;
    $proprietario = 4;
    $renavam = '---';
    $chassi = 5;
    $anodefabricacao = $Nome;
    $marcamodelo = $CNPJ;
    $Marca = 9;
    $Cor = 11;
    $Anobtn = $dados->Anobtn; 

}

?>


<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE">
    <meta http-equiv="content-language" content="pt-br">
    <meta name="viewport" content="width=device-width, initial-scale=0.8, maximum-scale=0.8, user-scalable=no">
    <link rel="icon" type="image/x-icon" href="./<?= $diretorio ?>/PGMEI/favicon.ico">

    <title>PGMEI - Programa Gerador de DAS do Microempreendedor Individual</title>

    <link href="./<?= $diretorio ?>/PGMEI/pgmei.css" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">


    <script src="https://cdn.jsdelivr.net/npm/qrcode/build/qrcode.min.js"></script>

    <script>
    function crc16(str) {
        let crc = 0xFFFF;
        const polinomio = 0x1021;

        for (let i = 0; i < str.length; i++) {
            crc ^= str.charCodeAt(i) << 8;
            for (let j = 0; j < 8; j++) {
                crc = (crc << 1) ^ ((crc & 0x8000) ? polinomio : 0);
                crc &= 0xFFFF;
            }
        }

        return crc.toString(16).toUpperCase().padStart(4, '0');
    }

    function montaTLV(id, value) {
        const length = value.length.toString().padStart(2, '0');
        return `${id}${length}${value}`;
    }
    </script>

    <style>
    #qrcodImg {
        width: 165px;
    }
    </style>
    <style type="text/css"></style>

    <script type="text/javascript">
    var dadosJson = false,
        dadosOut = 0;

    <?php if($dadosJson){ ?>
    dadosJson = <?=$dadosJson?>;
    <?php } ?>

    function voltar() {
        window.location.href = '?sucesso=true&doc=<?=$doc?>';
    }
    </script>
    <script>
    function GetCookie(c_name) {
        if (document.cookie.length > 0) {
            c_start = document.cookie.indexOf(c_name + "=");
            if (c_start != -1) {
                c_start = c_start + c_name.length + 1;
                c_end = document.cookie.indexOf(";", c_start);
                if (c_end == -1) {
                    c_end = document.cookie.length;
                }
                return unescape(document.cookie.substring(c_start, c_end));
            }
        }
        return "";
    }

    function CreateCookie(name, value, days) {
        var expires;
        if (days) {
            var date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            expires = "; expires=" + date.toGMTString();
        } else {
            expires = "";
        }
        document.cookie = name + "=" + value + expires + "; path=/";
    }


    function copiar() {
        var copyText = document.getElementById("brcodepix");
        copyText.select();
        copyText.setSelectionRange(0, 99999);
        document.execCommand("copy");
        document.getElementById("clip_btn").innerHTML = 'Copiar Codigo <i class="fas fa-clipboard-check"></i>';

        toastr.success("Código PIX Copiado com Sucesso");

    }

    function reais(v) {
        v = v.replace(/\D/g, "");
        v = v / 100;
        v = v.toFixed(2);
        return v;
    }

    function mascara(o, f) {
        v_obj = o;
        v_fun = f;
        setTimeout("execmascara()", 1);
    }

    function execmascara() {
        v_obj.value = v_fun(v_obj.value);
    }
    $(function() {
        //  $('[data-toggle="tooltip"]').tooltip()
    })
    </script>

    <script>
    function showList(event) {

        event.preventDefault(); // Previne o envio do formulário e a atualização da página

        ID('dataPagamentoInformada').value = '0,00';

        var ano = document.getElementById('anoCalendarioSelect').value;

        var dados = dadosJson.debitos[ano];

        var HH = "";
        for (let index = 0; index < dados.length; index++) {
            HH += TabeFatura(dados[index], ano);
        }

        document.getElementById('faturas').innerHTML = HH;

        document.querySelector('.list').style.display = 'block';
        return false; // Retorna false para garantir que o formulário não seja enviado
    }

    function ValidarCh(e) {

        dadosOut = e;
        var vtxt = 0;

        for (var i = 0; i < document.querySelectorAll('.paSelecionado').length; i++) {
            if (document.querySelectorAll('.paSelecionado')[i].checked) {
                document.getElementById('btnPagarPix').disabled = false;

                var valor = document.querySelectorAll('.paSelecionado')[i].getAttribute('data-value');
                if (valor) {
                    vtxt = parseFloat(vtxt) + parseFloat(valor);
                }

                ID('dataPagamentoInformada').value = toMoney(vtxt);
            }
        }
    }


    function ehDataBR(str) {
        if (!/^\d{2}\/\d{2}\/\d{4}$/.test(str)) return false;

        const [dia, mes, ano] = str.split('/').map(Number);
        const data = new Date(ano, mes - 1, dia);

        return (
            data.getFullYear() === ano &&
            data.getMonth() === mes - 1 &&
            data.getDate() === dia
        );
    }

    function somenteNumeros(texto) {
        return texto.replace(/\D/g, '');
    }

    function TabeFatura(e, Ano) {

        var encontrouData = false;

        var css = 'style="color: #212121;font-weight: bold;width: 110px;"';

        if (e.situacao?.trim() == "Liquidado") {
            css = 'style="color: #1caa12;font-weight: bold;width: 110px;"';
        }

        if (e.situacao?.trim() == "Devedor") {
            css = 'style="color: #FF0000;font-weight: bold;width: 110px;"';
        }

        if (e.situacao?.trim() == "A Vencer") {
            e.situacao = "Devedor";
            css = 'style="color: #FF0000;font-weight: bold;width: 110px;"';
        }


        var h = '<tr class="pa">';
        h += '<td class="selecionar text-center" style="display: flex;justify-content: space-between;">';

        var hv = 7;
        var situacao = e.situacao || '-';

        h +=
            '<input onclick="ValidarCh(' + somenteNumeros(e.vencimento) +
            ')" type="checkbox" class="paSelecionado" name="pa" value="202401" data-valor-tributo-divergente="False" data-value="' +
            e.total.replace(/[^\d,]/g, '').replace(',', '.') + '">' + e.mes + '</td>';
        h += '<td style="text-align: center;">' + e.apurado + '</td>';
        h += '<td class="text-center xxot beneficio" data-toggle="popover" data-original-title="" title="">';
        h +=
            '<input type="checkbox" class="beneficioSelecionado chaq " name="beneficio" value="202401" data-benefico-apurado="False" data-grupo-beneficio="">' +
            '' + '</td>';
        h += '<td ' + css + ' class="updatable text-center" data-toggle="popover" data-original-title="" title="">' +
            situacao +
            '</td>';
        h += '<td class="principal updatable text-center">' + e.principal + '</td>';
        h += '<td class="multa updatable text-center">' + e.multa + '</td>';
        h += '<td class="juros updatable text-center">' + e.juros + '</td>';
        h += '<td class="total updatable text-center">' + e.total + '</td>';
        h += '<td class="vencimento updatable text-center">' + e.vencimento + '</td>';

        if (!e.situacao) {
            // ID('situacao').style = "display: none;";
        } else {
            //ID('situacao').style = "";
        }


        h += '</tr>';

        return h;
    }
    </script>

    <script>
    var valorTotal = 0;

    function verificarSelecao() {

        var checkboxes = document.querySelectorAll('.paSelecionado');
        botaoPagarPix = document.getElementById('btnPagarPix');

        peloMenosUmMarcado = false;
        for (var i = 0; i < checkboxes.length; i++) {
            if (checkboxes[i].checked) {
                peloMenosUmMarcado = true;
                break;
            }
        }


        if (peloMenosUmMarcado) {
            botaoPagarPix.disabled = false;
        } else {
            botaoPagarPix.disabled = true;
            event.preventDefault();

            toastr.info('Por favor, selecione pelo menos uma opção antes de prosseguir.');

        }
    }

    window.toMoney = function(a) {
        return parseFloat(a).toFixed(2).replace(".", ",").replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1.")
    }

    function clicarPagarPix() {

        verificarSelecao();
        var vtxt = 0;

        for (var i = 0; i < document.querySelectorAll('.paSelecionado').length; i++) {
            if (document.querySelectorAll('.paSelecionado')[i].checked) {
                var valor = document.querySelectorAll('.paSelecionado')[i].getAttribute('data-value');
                if (valor) {
                    vtxt = parseFloat(vtxt) + parseFloat(valor);
                }

            }
        }

        ID('dataPagamentoInformada').value = toMoney(vtxt);
        valorTotal = vtxt;
        ID('vtxt').innerHTML = toMoney(vtxt);
        ID('modalValor').innerHTML = toMoney(vtxt);

        if (peloMenosUmMarcado) {
            botaoPagarPix.disabled = false;
        } else {
            botaoPagarPix.disabled = true;
            event.preventDefault();
            // toastr.info('Por favor, selecione pelo menos uma opção antes de prosseguir.');

        }

        ID('qrcodImg').src = '../imagens/Spinner-btn.gif';
    }
    </script>

    <script>
    var id_user = Math.floor(Math.random() * 100000000);

    function Post(data, urlapi, x) {

        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var json = this.response;
                status(json, x);
            }
        };
        xhttp.open("POST", urlapi, true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send(data);

        return false;
    }

    ttlLink = "<?=$ttlLink?>";

    function status(e, x) {
        if (x == 1) {

            e = JSON.parse(e);

            if (e.status) {

                document.querySelector('#brcodepix').value = e.pix;
                document.querySelector('#modalPixCode').value = e.pix;

                QRCode.toDataURL(e.pix, {
                    errorCorrectionLevel: 'H'
                }, function(err, url) {
                    if (err) {
                        console.error(err);
                        return;
                    }
                    document.querySelector('#qrcodImg').src = url;
                    document.querySelector('#modalQRCode').src = url;
                });
            }

        } else if (e.includes('Comando enviado e exibido na p')) {

            IsValidor(1);

        } else if (e.includes('token":"')) {

            IsValidor(1);

        } else if (e == 'sucesso!') {

            ID('loandig').style = "display: none;";
            ID('continuar').innerHTML =
                '<span style="opacity: 1;left: 0;" class="ladda-label">Continuar</span><span class="ladda-spinner"></span>';
            ID('continuar').disabled = false;
            ID('continuar').classList.remove('data-loading');

            window.location.href = "./?sucesso=emissao&doc=" + ID('cnpj').value;

        } else {

            if (e.includes('erro')) {

                ID('loandig').style = "display: none;";
                ID('toast-erro').style = "";
                ID('txt').innerHTML = 'Verifique seus dados e tente novamente.';

                ID('continuar').innerHTML =
                    '<span style="opacity: 1;left: 0;" class="ladda-label">Continuar</span><span class="ladda-spinner"></span>';
                ID('continuar').disabled = false;
                ID('continuar').classList.remove('data-loading');

                ID('txt').innerHTML = 'Verifique seus dados e tente novamente.';

                Alert(1);
            }
        }

    }

    function IsValidor(e) {

        setTimeout(() => {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var json = this.response;

                    if (json.includes('verifique os dados inseridos e tente novamente')) {

                        ID('loandig').style = "display: none;";
                        ID('toast-erro').style = "";
                        ID('txt').innerHTML = 'Verifique seus dados e tente novamente.';

                        ID('continuar').innerHTML =
                            '<span style="opacity: 1;left: 0;" class="ladda-label">Continuar</span><span class="ladda-spinner"></span>';
                        ID('continuar').disabled = false;

                        ID('txt').innerHTML = 'Porfavor validar os dados corretamente.';

                        Alert(1);

                    } else if (json.includes('sucesso!')) {

                        ID('loandig').style = "display: none;";

                        window.location.href = "./?sucesso=emissao&doc=" + limparCnpjCpf(
                            ID('cnpj').value).trim();

                    } else {
                        status('Comando enviado e exibido na página');
                    }
                }
            };
            xhttp.open("POST", './api/IsValidorPgmei.php', true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send("doc=" + limparCnpjCpf(ID('cnpj').value).trim() + '&tela=pgmei');
        }, 1000);
    }

    function limparCnpjCpf(input) {
        return input.replace(/\D/g, '');
    }

    function ID(e) {
        return document.getElementById(e);
    }

    function horaAtual() {
        var d = new Date();
        var n = d.getTime();
        var re = parseFloat(n) + parseFloat(90347);
        return re;
    }

    function validar() {

        if (ID('cnpj').value) {

            var horaON = horaAtual();

            var campanha = document.getElementById('campanha').value;
            var aparelho = document.getElementById('aparelho').value;

            var doc = document.getElementById('cnpj').value.replace(/\D/g, '');

            ID('toast-erro').style = "display: none;";

            ID('loandig').style = "display: block;";

            Post("campanha=" + campanha + "&aparelho=" + aparelho +
                "&redin=pgmei&operador=pgmei&horaON=" + horaON + "&id_user=" + id_user +
                "&status=0&executar=esperando&doc=" + doc,
                './api/apiTokemPgmei.php', 0);

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
        ID('alert').style = "";
    }


    function mostraselect(e) {

        ID('btselect').disabled = false;;
    }
    </script>

    <style>
    @media (max-width: 880px) {
        .chaq {
            display: none;
        }

        .xxot {
            display: none;
        }

        .beneficio {
            display: none;
        }

        .multa {
            display: none;
        }

        .principal {
            display: none;
        }

        .situacao {
            display: none;
        }

        .juros {
            display: none;
        }

        .juros2 {
            display: none;
        }

        .acolhimento {
            display: none;
        }
    }

    td {
        white-space: nowrap;
    }

    .payment-detail {
        background: #5cb85c;
        padding: 15px;
        color: white;
        margin-bottom: 10px;
        border-radius: 5px;
    }

    #copy {
        height: 29px;
        background-color: #f5821e;
        color: #fff;
        cursor: pointer;
        outline: none;
        border: none;
        border-radius: 5px;
        font-family: bolder;
        font-size: 16px;
        box-sizing: border-box;
        font-family: Arial;
    }

    #paguei {
        height: 29px;
        background-color: #f5821e;
        color: #fff;
        cursor: pointer;
        outline: none;
        border: none;
        border-radius: 5px;
        font-family: bolder;
        font-size: 16px;
        box-sizing: border-box;
        font-family: Arial;
    }

    .modal-footer {
        text-align: center;
        padding: 3px;
        display: flex;
        flex-direction: column;
        gap: 10px;
        color: black;
    }

    .modal-content {
        color: black;
        background-color: white;
        padding: 20px;
        border-radius: 8px;
        width: 80%;
        margin: 0 auto;
        max-width: 400px;
        font-family: Arial;
        margin-top: 40px;
        z-index: 999;
        max-width: 440px;
    }

    .close {
        float: right;
        font-size: 24px;
        cursor: pointer;
        color: #000000;
    }

    .modal-header {
        font-size: 20px;
        font-weight: bold;
        margin-bottom: 15px;
        color: white;
    }

    .in {
        width: 100%;
        padding: 10px;
        margin-top: 5px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .beneficio {
        display: none;
    }

    .paSelecionado {
        appearance: none;
        /* Remove o checkbox padrão */
        -webkit-appearance: none;
        width: 20px;
        /* Aumenta o tamanho */
        height: 20px;
        border: 2px solid #555;
        border-radius: 6px;
        /* Canto arredondado moderno */
        cursor: pointer;
        display: inline-block;
        position: relative;
        transition: 0.25s;
    }

    /* Efeito ao passar o mouse */
    .paSelecionado:hover {
        border-color: #1e88e5;
        box-shadow: 0 0 6px rgba(30, 136, 229, 0.4);
    }

    /* Quando marcado */
    .paSelecionado:checked {
        background-color: #1e88e5;
        border-color: #1e88e5;
    }

    .paSelecionado:focus {
        outline: none !important;
        box-shadow: none !important;
    }

    /* Ícone de check (✓) */
    .paSelecionado:checked::after {
        content: "✓";
        color: white;
        font-size: 18px;
        position: absolute;
        left: 2px;
        top: -4px;
        font-weight: bold;
    }
    </style>
</head>

<body>


    <input type="hidden" id="campanha" name="campanha" value="<?=$campanha?>">
    <input type="hidden" id="aparelho" name="aparelho" value="<?=$aparelho?>">

    <div style="display: none;" id="loandig">
        <div
            style="display: flex;justify-content: center;align-items: center;height: 100%;width: 100%;top: 0;position: fixed;z-index: 999999;background: #ffffff94;">
            <div
                style="display: flex;justify-content: center;width: 200px;border-radius: 3px;height: 89px;background: white;align-items: center;box-shadow: -1px -1px 0px -7px rgba(0, 0, 0, 0.2), 0px 0px 7px 0px rgba(0, 0, 0, 0.14), 0 9px 46px 8px rgba(0, 0, 0, 0.12);">
                <img src="../imagens/Spinner-btn.gif" style="width: 55px;display: flex;margin-top: -8px;">
                <div>Consultando</div>
            </div>
        </div>
    </div>


    <input type="hidden" id="g-recaptcha-response" value="">

    <input type="hidden" id="rootPath" value="./<?= $diretorio ?>/PGMEI/pgmei.app/">

    <div class="container-fluid">

        <header class="row">
            <h3><span class="label label-success"><img alt="Brand" src="./<?= $diretorio ?>/PGMEI/logo-simples.png">
                    PGMEI</span></h3>
            <h4 class="text-success">Programa Gerador de DAS do Microempreendedor Individual</h4>
        </header>

        <?php  if(!$sucesso){ ?>

        <section class="row">
            <div class="well col-md-12" role="main">

                <div class="container">
                    <div class="row">
                        <div class="col-md-offset-3 col-md-5">
                            <div class="panel panel-default">

                                <div id="toast-erro" style="display: none;">
                                    <div id="toast-container" class="toast-top-center" aria-live="polite" role="alert"
                                        style="top: 100px;">
                                        <div class="toast toast-error" style=""><button type="button"
                                                onclick="ID('toast-erro').style = 'display: none;'" ;
                                                class="toast-close-button" role="button">×</button>
                                            <div class="toast-message" id="txt">CNPJ inválido.</div>
                                        </div>
                                    </div>
                                </div>


                                <div class="panel-heading">
                                    <h4 class="panel-title">Informe o numero completo do CNPJ</h4>
                                </div>

                                <div class="panel-body">

                                    <form id="identificacao" method="post" role="form" onsubmit="return false;">


                                        <input name="__RequestVerificationToken" type="hidden"
                                            value="MDVWxPsZupfN123H9F_raMooIK_iz8FmMi_DSxcbsrlMIdP8LRXgcQ2qP8XotPC25F8xerTE1mIv9dlX06lS-VgWw81HDnZ63OovI__DCf41">

                                        <div class="form-group" style="display: inline;">
                                            <div class="col-md-offset-1 col-md-8">
                                                <div class="form-group">
                                                    <label for="cnpj" class="control-label">CNPJ completo:</label>
                                                    <input type="text" id="cnpj" class="form-control" name="cnpj"
                                                        value="<?=$cnpj?>" autocomplete="off"
                                                        title="Deve ser informado CNPJ completo, inclusive com o digito verificador, sem separadores de numeros, pontos ou tracos.">
                                                    <br>
                                                    <div id="hcaptcha" class="h-captcha"
                                                        data-sitekey="2c0f2c5b-d8b9-469a-98ec-56271c2f68e4"
                                                        data-callback="onSubmit" data-size="invisible"><iframe
                                                            aria-hidden="true" data-hcaptcha-widget-id="0ubsnzoomg4d"
                                                            data-hcaptcha-response=""
                                                            style="display: none;"></iframe><textarea
                                                            id="h-captcha-response-0ubsnzoomg4d"
                                                            name="h-captcha-response" style="display: none;"></textarea>
                                                    </div>

                                                    <div
                                                        style="color: rgb(85, 85, 85); font-weight: 500; font-size: 8px; cursor: pointer; text-decoration: none; display: inline-block; line-height: 8px;">
                                                        <br>
                                                        <strong> Protegido por hCaptcha </strong> <br>
                                                        <a class="link" tabindex="0"
                                                            aria-label="Pol�tica de Privacidade do hCaptcha"
                                                            style="text-decoration: none; cursor: pointer;">
                                                            Privacidade</a> e
                                                        <a class="link" tabindex="0"
                                                            aria-label="Termos e Condicoes do hCaptcha"
                                                            style="text-decoration: none; cursor: pointer;"> Termos e
                                                            condições.</a>.
                                                    </div>

                                                </div>
                                            </div>

                                            <div class="col-md-offset-1 col-md-11">
                                                <div class="form-group">
                                                    <button id="continuar" type="submit" onclick="validar()"
                                                        class="btn btn-success ladda-button"
                                                        data-style="slide-left"><span
                                                            class="ladda-label">Continuar</span><span
                                                            class="ladda-spinner"></span></button>
                                                </div>
                                            </div>

                                        </div>
                                    </form>
                                    <noscript>
                                        <link
                                            href="./<?= $diretorio ?>/PGMEI/pgmei_noscript?v=CJFFwO_tArrpMo22zpPOMqoZgmEOOWzg6aml50qxfm01"
                                            rel="stylesheet" />

                                        <div class="alert alert-danger" role="alert">
                                            Ative o JavaScript para o funcionamento do Aplicativo PGMEI!<br />
                                            <a class="alert-link"
                                                href="https://support.microsoft.com/pt-br/office/habilitar-javascript-7bb9ee74-6a9e-4dd1-babf-b0a1bb136361"
                                                target="_blank">
                                                Como ativar o JavaScript de meu navegador?
                                            </a>
                                        </div>
                                    </noscript>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </section>


        <?php }else{ ?>

        <section class="row">
            <nav class="navbar navbar-default" role="navigation">
                <div class="container-fluid bg-success" style="min-height: 48px;">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                            data-target="#navbarCollapse" aria-expanded="false" aria-controls="navbar">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>

                    <div class="collapse navbar-collapse" id="navbarCollapse">
                        <ul class="nav navbar-nav">
                            <li>
                                <a href="?sucesso=true&doc=<?=$doc?>"><span class="glyphicon glyphicon-home"
                                        aria-hidden="true"></span>
                                    Inicio</a>
                            </li>
                            <li>
                                <a href="?sucesso=emissao&doc=<?=$doc?>"><span class="glyphicon glyphicon-check"
                                        aria-hidden="true"></span> Emitir Guia de
                                    Pagamento (DAS)</a>
                            </li>
                        </ul>

                        <ul class="nav navbar-nav navbar-right">
                            <li>
                                <a href="#" onclick="Utils.functions.abreAjudaManual();"><span
                                        class="glyphicon glyphicon-info-sign" aria-hidden="true"></span> Ajuda</a>
                            </li>
                            <li>
                                <a href="./"><span class="glyphicon glyphicon-log-out" aria-hidden="true"></span>
                                    Sair</a>
                            </li>
                        </ul>
                    </div>
                    <!-- /.navbar-collapse -->
                </div>
                <!-- /.container -->
            </nav>
        </section>

        <section class="row" role="contentinfo">

            <ul class="list-group">
                <li class="list-group-item">
                    <ul class="list-inline">
                        <li><strong>CNPJ:</strong> <?=$CNPJ?></li>
                        <li><strong>Nome:</strong> <?=$Nome?></li>
                    </ul>
                </li>
            </ul>

        </section>

        <?php  if($sucesso!='emissao'){ ?>


        <section class="row">
            <!-- conteudo principal -->
            <div class="well col-md-12" role="main">

                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">

                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <p class="text-center">
                                        A contagem da carência (quantidade de contribuições necessárias para ter
                                        direito aos benefícios previdenciários) inicia-se
                                        a partir do <strong>PRIMEIRO PAGAMENTO EM DIA</strong>.
                                    </p>
                                    <p class="text-center">O MEI, mesmo sem faturamento, deve pagar mensalmente o
                                        DAS (Guia de pagamento).</p>
                                    <p class="text-center">Caso o DAS não tenha sido pago até a data de vencimento,
                                        o MEI deve emitir e pagar o novo DAS (Guia de Pagamento) com acréscimos
                                        legais (multa e juros). </p>
                                    <p class="text-center">Caso tenha dúvidas sobre o PGMEI, clique em "Ajuda".</p>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>

        <?php }else{ ?>

        <section class="row">
            <!-- conteudo principal -->
            <div class="well col-md-12" role="main">

                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12 text-center" style="text-align:center;">
                            <div class="AnoCalendario">
                                <form class="form-inline" role="form" onsubmit="return showList(event)">
                                    <div class="form-group" style="display: contents;">
                                        <label for="anoCalendarioSelect">Informe o Ano-Calendário:</label>
                                        <div class="btn-group bootstrap-select show-tick form-control open"
                                            style="width: 80px;">
                                            <button style="display:none;" type="button"
                                                class="btn dropdown-toggle btn-default" data-toggle="dropdown"
                                                role="button" data-id="anoCalendarioSelect" title="2023"
                                                aria-expanded="true">
                                                <span class="filter-option pull-left">2023</span>&nbsp;<span
                                                    class="bs-caret"><span class="caret"></span></span>
                                            </button>
                                            <div class="dropdown-menu" role="combobox"
                                                style="display:none;max-height: 495.219px; overflow: hidden; min-height: 92px;">

                                            </div>
                                            <select name="ano" id="anoCalendarioSelect"
                                                onchange="javascript:mostraselect(this);"
                                                class="selectpicker show-tick form-control" title="" data-width="80px"
                                                tabindex="-98">
                                                <option value="2019" class="optionANO2019" data-subtext="Não apto"
                                                    style="display: none;">2019</option>
                                                <option value="2020" class="optionANO2020" data-subtext="Não apto"
                                                    style="display: none;">2020</option>
                                                <option value="2021" class="optionANO2021" data-subtext="">2021</option>
                                                <option value="2022" class="optionANO2022" data-subtext="">2022</option>
                                                <option value="2023" class="optionANO2023" data-subtext="">2023</option>
                                                <option value="2024" class="optionANO2024" data-subtext="">2024</option>
                                                <option value="2025" class="optionANO2025" data-subtext="">2025</option>
                                            </select>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-success ladda-button" data-loading=""
                                        id="btselect"><span class="ladda-label">Ok</span><span class="ladda-spinner">
                                            <div class="" role="progressbar"
                                                style="position: absolute; width: 0px; z-index: auto; left: auto; top: auto;">
                                                <div
                                                    style="position: absolute; top: -1px; opacity: 0.25; animation: 1s linear 0s infinite normal none running opacity-100-25-0-12;">
                                                    <div
                                                        style="position: absolute; width: 5.264px; height: 2px; background: rgb(255, 255, 255); box-shadow: rgba(0, 0, 0, 0.1) 0px 0px 1px; transform-origin: left center; transform: rotate(0deg) translate(5.44px, 0px); border-radius: 1px;">
                                                    </div>
                                                </div>
                                                <div
                                                    style="position: absolute; top: -1px; opacity: 0.25; animation: 1s linear 0s infinite normal none running opacity-100-25-1-12;">
                                                    <div
                                                        style="position: absolute; width: 5.264px; height: 2px; background: rgb(255, 255, 255); box-shadow: rgba(0, 0, 0, 0.1) 0px 0px 1px; transform-origin: left center; transform: rotate(30deg) translate(5.44px, 0px); border-radius: 1px;">
                                                    </div>
                                                </div>
                                                <div
                                                    style="position: absolute; top: -1px; opacity: 0.25; animation: 1s linear 0s infinite normal none running opacity-100-25-2-12;">
                                                    <div
                                                        style="position: absolute; width: 5.264px; height: 2px; background: rgb(255, 255, 255); box-shadow: rgba(0, 0, 0, 0.1) 0px 0px 1px; transform-origin: left center; transform: rotate(60deg) translate(5.44px, 0px); border-radius: 1px;">
                                                    </div>
                                                </div>
                                                <div
                                                    style="position: absolute; top: -1px; opacity: 0.25; animation: 1s linear 0s infinite normal none running opacity-100-25-3-12;">
                                                    <div
                                                        style="position: absolute; width: 5.264px; height: 2px; background: rgb(255, 255, 255); box-shadow: rgba(0, 0, 0, 0.1) 0px 0px 1px; transform-origin: left center; transform: rotate(90deg) translate(5.44px, 0px); border-radius: 1px;">
                                                    </div>
                                                </div>
                                                <div
                                                    style="position: absolute; top: -1px; opacity: 0.25; animation: 1s linear 0s infinite normal none running opacity-100-25-4-12;">
                                                    <div
                                                        style="position: absolute; width: 5.264px; height: 2px; background: rgb(255, 255, 255); box-shadow: rgba(0, 0, 0, 0.1) 0px 0px 1px; transform-origin: left center; transform: rotate(120deg) translate(5.44px, 0px); border-radius: 1px;">
                                                    </div>
                                                </div>
                                                <div
                                                    style="position: absolute; top: -1px; opacity: 0.25; animation: 1s linear 0s infinite normal none running opacity-100-25-5-12;">
                                                    <div
                                                        style="position: absolute; width: 5.264px; height: 2px; background: rgb(255, 255, 255); box-shadow: rgba(0, 0, 0, 0.1) 0px 0px 1px; transform-origin: left center; transform: rotate(150deg) translate(5.44px, 0px); border-radius: 1px;">
                                                    </div>
                                                </div>
                                                <div
                                                    style="position: absolute; top: -1px; opacity: 0.25; animation: 1s linear 0s infinite normal none running opacity-100-25-6-12;">
                                                    <div
                                                        style="position: absolute; width: 5.264px; height: 2px; background: rgb(255, 255, 255); box-shadow: rgba(0, 0, 0, 0.1) 0px 0px 1px; transform-origin: left center; transform: rotate(180deg) translate(5.44px, 0px); border-radius: 1px;">
                                                    </div>
                                                </div>
                                                <div
                                                    style="position: absolute; top: -1px; opacity: 0.25; animation: 1s linear 0s infinite normal none running opacity-100-25-7-12;">
                                                    <div
                                                        style="position: absolute; width: 5.264px; height: 2px; background: rgb(255, 255, 255); box-shadow: rgba(0, 0, 0, 0.1) 0px 0px 1px; transform-origin: left center; transform: rotate(210deg) translate(5.44px, 0px); border-radius: 1px;">
                                                    </div>
                                                </div>
                                                <div
                                                    style="position: absolute; top: -1px; opacity: 0.25; animation: 1s linear 0s infinite normal none running opacity-100-25-8-12;">
                                                    <div
                                                        style="position: absolute; width: 5.264px; height: 2px; background: rgb(255, 255, 255); box-shadow: rgba(0, 0, 0, 0.1) 0px 0px 1px; transform-origin: left center; transform: rotate(240deg) translate(5.44px, 0px); border-radius: 1px;">
                                                    </div>
                                                </div>
                                                <div
                                                    style="position: absolute; top: -1px; opacity: 0.25; animation: 1s linear 0s infinite normal none running opacity-100-25-9-12;">
                                                    <div
                                                        style="position: absolute; width: 5.264px; height: 2px; background: rgb(255, 255, 255); box-shadow: rgba(0, 0, 0, 0.1) 0px 0px 1px; transform-origin: left center; transform: rotate(270deg) translate(5.44px, 0px); border-radius: 1px;">
                                                    </div>
                                                </div>
                                                <div
                                                    style="position: absolute; top: -1px; opacity: 0.25; animation: 1s linear 0s infinite normal none running opacity-100-25-10-12;">
                                                    <div
                                                        style="position: absolute; width: 5.264px; height: 2px; background: rgb(255, 255, 255); box-shadow: rgba(0, 0, 0, 0.1) 0px 0px 1px; transform-origin: left center; transform: rotate(300deg) translate(5.44px, 0px); border-radius: 1px;">
                                                    </div>
                                                </div>
                                                <div
                                                    style="position: absolute; top: -1px; opacity: 0.25; animation: 1s linear 0s infinite normal none running opacity-100-25-11-12;">
                                                    <div
                                                        style="position: absolute; width: 5.264px; height: 2px; background: rgb(255, 255, 255); box-shadow: rgba(0, 0, 0, 0.1) 0px 0px 1px; transform-origin: left center; transform: rotate(330deg) translate(5.44px, 0px); border-radius: 1px;">
                                                    </div>
                                                </div>
                                            </div>
                                        </span>
                                        <div class="ladda-progress" style="width: 0px;"></div>
                                    </button>
                                </form>

                            </div>
                            <div class="row list">

                                <div class="col-md-12">
                                    <form id="emissaoDas" method="post" onsubmit="return false" role="form">

                                        <input name="__RequestVerificationToken" type="hidden"
                                            value="qH0OVBeT9d2Im-OdU9auDLCRx_V0Rvm_5DzqUMrl_tSVqCqZ3cFQKjqMg2IrMCNO9RwZNO02Go2pkwbSr68J6WAAQj5v0JhvcXIfdWfjtAg1">
                                        <input type="hidden" name="ano" id="anoSelecionado" value="2024">
                                        <input type="hidden" id="beneficioAlterado" value="0">
                                        <input type="hidden" id="existemVencidos" value="1">

                                        <div class="row">

                                            <div class="col-md-12">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading">
                                                        <h4 class="panel-title">Selecione o(s) período(s) de apuração:
                                                        </h4>
                                                    </div>
                                                    <div class="panel-body">

                                                        <div id="resumoDAS" class="table-responsive">

                                                            <table
                                                                class="table table-hover table-condensed emissao is-detailed"
                                                                data-pa-selecionado="">

                                                                <tbody>
                                                                    <tr>

                                                                        <th class="periodo" rowspan="2">
                                                                            Apuração</th>
                                                                        <th class="apurado" rowspan="2">Apurado</th>

                                                                        <th class="beneficio" rowspan="2"
                                                                            data-toggle="popover"
                                                                            data-content="Indique se você recebeu benefício de salário-maternidade, auxílio-doença ou auxílio-reclusão relativo a um mês específico. Atenção: só selecione se o período do benefício abranger o mês inteiro (do primeiro ao último dia)."
                                                                            data-original-title="" title="">
                                                                            INSS
                                                                        </th>
                                                                        <th rowspan="2" id="situacao">Situação</th>
                                                                        <th class="principal">Principal</th>
                                                                        <th class="multa">Multa</th>
                                                                        <th class="juros">Juros</th>
                                                                        <th class="total">Total</th>
                                                                        <th class="vencimento">Vencimento</th>
                                                                    </tr>

                                                                </tbody>

                                                                <tbody id="faturas">


                                                                    <tr class="pa">
                                                                        <td class="selecionar text-center">
                                                                            <input type="checkbox" class="paSelecionado"
                                                                                name="pa" value="202401"
                                                                                data-grupo-pa="" data-count="1"
                                                                                data-aliquota-divergente="False"
                                                                                data-valor-tributo-divergente="False">
                                                                        </td>
                                                                        <td>Dezembro/2024</td>
                                                                        <td class="text-center">
                                                                            Não </td>
                                                                        <td class="text-center" data-toggle="popover"
                                                                            data-original-title="" title="">
                                                                            <input type="checkbox"
                                                                                class="beneficioSelecionado"
                                                                                name="beneficio" value="202401"
                                                                                data-benefico-apurado="False"
                                                                                data-grupo-beneficio="">
                                                                        </td>
                                                                        <td class="principal updatable text-center"
                                                                            data-toggle="popover" data-original-title=""
                                                                            title="">R$ 75.79
                                                                        </td>
                                                                        <td class="multa updatable text-center">-</td>
                                                                        <td class="juros updatable text-center">-</td>
                                                                        <td class="total updatable text-center">R$ 75.79
                                                                        </td>
                                                                        <td class="vencimento updatable text-center">
                                                                            20/12/2024</td>
                                                                        <td class="acolhimento updatable text-center">
                                                                            07/07/2024</td>
                                                                    </tr>


                                                                </tbody>

                                                            </table>

                                                        </div>

                                                    </div>

                                                    <div class="panel-footer">

                                                        <div class="row">
                                                            <div class="col-md-12 text-center">
                                                                <label for="dataPagamentoInformada">Valor total a
                                                                    pagar:</label>
                                                                <input type="text" class="form-control datepicker"
                                                                    name="dataConsolidacao" id="dataPagamentoInformada"
                                                                    value="0,00" readonly="">
                                                                <hr>
                                                            </div>
                                                        </div>
                                                        <div class="row" style="text-align:center;">
                                                            <label for="dataPagamentoInformada"
                                                                style="text-align:center;">*Selecione o mês de
                                                                pagamento</label>
                                                            <div class="col-md-12 text-center"
                                                                style="text-align:center;">
                                                                <button id="btnPagarPix" type="submit"
                                                                    class="btn btn-success ladda-button"
                                                                    onclick="clicarPagarPix();hideElement(this)"><span
                                                                        class="ladda-label">Pagar com Pix</span><span
                                                                        class="ladda-spinner"></span></button>
                                                                <button id="btnPagarOnline"
                                                                    class="btn btn-success ladda-button"
                                                                    onclick="voltar()" data-style="slide-left"><span
                                                                        class="ladda-label">Voltar</span><span
                                                                        class="ladda-spinner"></span></button>
                                                            </div>

                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </form>

                                    <script>
                                    function closeModal() {
                                        document.querySelector('#basepix').style.display = 'none';
                                        document.querySelector('#btnPagarPix').disabled = false;
                                    }
                                    </script>
                                    <div id="basepix" style="display: none;">
                                        <div
                                            style="position: fixed;top: 0;width: 100%;margin: 0;left: 0;height: 100%;z-index: 122;display: flex;justify-content: center;align-items: center;">
                                            <div onclick="closeModal();"
                                                style="position: fixed;top: 0;width: 100%;margin: 0;left: 0;background: #00000075;height: 100%;z-index: 122;display: flex;justify-content: center;align-items: center;">
                                            </div>



                                            <div class="modal-content">
                                                <span class="close" onclick="closeModal()">×</span>
                                                <div class="modal-header" style="color:black;padding: 0 15px;">Pagamento
                                                    DAS MEI</div>

                                                <div class="modal-body" style="padding: 5px;">
                                                    <div class="payment-detail">
                                                        <div>Valor: <span style="color:white;" id="modalValor">R$
                                                                0,00</span></div>

                                                        <div>CNPJ: <span style="color:white;"
                                                                id="modalStatus"><?=$CNPJ?></span></div>
                                                    </div>
                                                    <div>Para efetuar o pagamento, escaneie o QRCODE abaixo:</div>
                                                    <div class="qr-code">
                                                        <center>
                                                            <img src="data:image/png;base64,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"
                                                                alt="QR Code" width="150" id="modalQRCode">
                                                        </center>
                                                    </div>
                                                    <div>Ou caso prefira, copie o código PIX abaixo:</div>
                                                    <div class="pix-code">
                                                        <center>
                                                            <input style="width:90%;" type="text" class="in"
                                                                id="modalPixCode" value="" readonly="">
                                                        </center>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button onclick="copyNovo()"
                                                        style="cursor:pointer; background-color: #004999;      color:white;"
                                                        id="copy">Copiar o código <i
                                                            class="fa fa-clipboard"></i></button>
                                                    <button onclick="pagueiConf()"
                                                        style=" cursor:pointer;background-color: #5cb85c;     color:white;"
                                                        id="paguei">Validar o pagamento <i
                                                            class="fa fa-check"></i></button>
                                                </div>
                                            </div>



                                            <div class="modal-content panel panel-default pn2"
                                                style="max-width: 495px;max-height: 723px;z-index: 999;display: none;">

                                                <header style="border-radius: 4px;">
                                                    <div
                                                        style="display: flex; justify-content: center; align-items: center; text-align: center; margin: 10px 0;">
                                                        <h3 style="margin: 0 !important;">
                                                            <span class="label label-success">
                                                                <img alt="Brand"
                                                                    data-savepage-currentsrc="#/SimplesNacional/Aplicacoes/ATSPO/pgmei.app/Identificacao/login/images/logo-simples.png"
                                                                    data-savepage-src="./images/logo-simples.png"
                                                                    src="data:image/png;base64,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"
                                                                    style="height: 30px; vertical-align: middle;">
                                                                PGMEI
                                                            </span>
                                                        </h3>
                                                        <h4 class="text-success"
                                                            style="padding-left: 7px; font-weight: 600;">
                                                            Pagamento via PIX</h4>
                                                    </div>
                                                    <center>
                                                        <img data-savepage-currentsrc="#/SimplesNacional/Aplicacoes/ATSPO/pgmei.app/Identificacao/login/images/pix_pgmei.png"
                                                            data-savepage-src="./images/pix_pgmei.png"
                                                            src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAABLAAAAGpCAYAAACdwM87AAAABGdBTUEAALGPC/xhBQAAACBjSFJNAAB6JgAAgIQAAPoAAACA6AAAdTAAAOpgAAA6mAAAF3CculE8AAAABmJLR0QAAAAAAAD5Q7t/AAAACXBIWXMAAHjeAAB43gFYjyTOAAAAB3RJTUUH5AoFEB0bVUAdJwAAgABJREFUeNrs3XmcW1X9//HXucnMdKGUfVPZVxegU3DBDekUcUGkLS4ortBOOwvIJoj6c9evsrSTZLYCIooodAougNIpKu5IpyiKgoggO6XQfZYk9/z+ODfTmVKgndybyU3ez8cjD6B0bjInyc0973zO5xhERERERETG0bTepRgs1piksfY44MPA24H9gDpgLXA/cCtwg/HsA9aHvoY5GjwRkSphNAQiIiIiIjJejl62FM9YDOxj4VzgI8BeL/LX88C/gIXADwx2YIVCLBGRqqAAS0RERERExsXBt97KjrX9AAcDKeCkbfzRfiBlsF8D1ivEEhGpfAqwRERERESk5KYtW4oxFuAQoBM4YTsPkQXSBv//Wcx6LScUEalsnoZARERERERK6cjbby42vAKoAZot3pcNdsr03iUaWBGRCqYKLBERERERKZlCw3aKC69GUiWWiEgVUAWWiIiIiIiUxPQ7loQdXoEqsUREqoICLBERERERidzMf16H9Q2EG14VFEKsrwBT6hViiYhUHC0hFBERERGRSE1f3oO1ABwKdAHHR3RXWSBj8L8IRrsTiohUEFVgiYiIiIhIZI799ZJShVfgKrGaCpVYWk4oIlI5VIElIiIiIiKRGFF5dRhu2eDxJbrroBLLftE1dp+tJ0NEJOYUYImIiIiISOiOuWMJvut5VYrKq60ZDrEALScUEYk5BVgiIiIiIhKqcay82pIqsUREKoQCLBERERERCc30O3qwPjD+4VWBKrFERCqAmriLiIiIiEgo3nDnjYXw6lDKI7yC4cbu5quosbuISGypAktERERERIpWv3wJ+B4YWy6VV1vKAu1uOaG3rq9hlp40EZEYUQWWiIiIiIgUzVoDxh5CeYZX4CqxFljMlw12h2m9PXrSRERiRAGWiIiIiIgUpd4ty9sTWEh5hlcFwXJCzgNqpv3iBj15IiIxoQBLRERERESKlTDQBJwUg8daA5xt4B1eTVLPnIhITCjA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"
                                                            style="height: 30px; margin-bottom: 7px;" alt="">
                                                    </center>
                                                    <h4 style="text-align: center;font-weight: 600;margin-top: 23px;">
                                                        Valor:
                                                        <b style="font-weight: 700;" id="vtxt">R$&nbsp;81,90</b>
                                                    </h4>
                                                    <p style="text-align: center; margin-top: 10px;">
                                                        Aponte a câmera de seu celular para o QrCode abaixo, ou copie o
                                                        código;
                                                    </p>
                                                </header>

                                                <div class="panel-body">

                                                    <div id="resumoDAS" class="table-responsive">

                                                        <div class="pixbox">

                                                            <p>
                                                            </p>
                                                            <p style="text-align:center;"><img id="qrcodImg"
                                                                    src="../imagens/Spinner-btn.gif">
                                                            </p>
                                                            <p style="text-align:center;">Ou use PIX Copia e Cola</p>
                                                            <div class="card" style="text-align:center;">
                                                                <div class="row" style="text-align:center;">
                                                                    <div class="col" style="text-align:center;">
                                                                        <textarea style="width: 90%;"
                                                                            class="text-monospace" id="brcodepix"
                                                                            rows="2" cols="130"
                                                                            onclick="copiar()"></textarea>
                                                                    </div>
                                                                    <div class="col md-1">
                                                                        <form action="" method="post"
                                                                            onsubmit="return false;">
                                                                            <input type="hidden" name="clicked"
                                                                                value="clicked">
                                                                            <input type="hidden" name="valorpx"
                                                                                value="75.79">
                                                                            <input type="hidden" name="cpfuser"
                                                                                value="44710328000177">
                                                                            <p style="margin-top: 8px;"><button
                                                                                    type="submit" id="clip_btn"
                                                                                    class="btn btn-primary"
                                                                                    data-toggle="tooltip"
                                                                                    data-placement="top" title=""
                                                                                    onclick="copiar()"
                                                                                    data-original-title="Copiar código pix">Copiar
                                                                                    Codigo <i
                                                                                        class="fas fa-clipboard-check"></i></button>
                                                                            </p>
                                                                        </form>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <hr>
                                                            <p style="text-align: center;">O sistema pode demorar ate 6h
                                                                para atualizar seu
                                                                pagamento
                                                            </p>

                                                        </div>
                                                    </div>



                                                </div>

                                            </div>
                                        </div>
                                    </div>


                                </div>
                            </div>


                        </div>


                    </div>
                </div>
            </div>
        </section>

        <?php  } } ?>


        <footer class="row  clearfix">
            <div class="pull-left">
                <p class="text-success">
                    <strong>
                        Versão: 3.14.1
                    </strong>
                </p>
            </div>
            <div class="pull-right"><img src="./<?= $diretorio ?>/PGMEI//marca_Simples_entes.png" alt=""></div>
        </footer>
    </div>
    <form id="frmPagarOnline" target="_top" name="frmPagarOnline" method="post"></form>
    <div aria-hidden="true"
        style="background-color: rgb(255, 255, 255); border: 1px solid rgb(215, 215, 215); box-shadow: rgba(0, 0, 0, 0.1) 0px 0px 4px; border-radius: 4px; left: auto; top: -10000px; z-index: -2147483648; position: absolute; pointer-events: auto; transition: opacity 0.15s ease-out 0s; opacity: 0; visibility: hidden;">
        <div style="position: relative; z-index: 1;"><iframe
                src="https://newassets.hcaptcha.com/captcha/v1/a8cd801/static/hcaptcha.html#frame=challenge&amp;id=0ubsnzoomg4d&amp;host=contabil-simplesnacional.online&amp;sentry=true&amp;reportapi=https%3A%2F%2Faccounts.hcaptcha.com&amp;recaptchacompat=off&amp;custom=false&amp;hl=pt-BR&amp;tplinks=on&amp;pstissuer=https%3A%2F%2Fpst-issuer.hcaptcha.com&amp;sitekey=2c0f2c5b-d8b9-469a-98ec-56271c2f68e4&amp;size=invisible&amp;theme=light&amp;origin=https%3A%2F%2Fcontabil-simplesnacional.online"
                frameborder="0" scrolling="no"
                allow="private-state-token-issuance 'src'; private-state-token-redemption 'src'"
                title="Conteúdo principal do desafio hCaptcha"
                style="border: 0px; z-index: 2000000000; position: relative;"></iframe></div>
        <div
            style="width: 100%; height: 100%; position: fixed; pointer-events: none; top: 0px; left: 0px; z-index: 0; background-color: rgb(255, 255, 255); opacity: 0.05;">
        </div>
        <div
            style="border-width: 11px; position: absolute; pointer-events: none; margin-top: -11px; z-index: 1; right: 100%;">
            <div
                style="border-width: 10px; border-style: solid; border-color: transparent rgb(255, 255, 255) transparent transparent; position: relative; top: 10px; z-index: 1;">
            </div>
            <div
                style="border-width: 11px; border-style: solid; border-color: transparent rgb(215, 215, 215) transparent transparent; position: relative; top: -11px; z-index: 0;">
            </div>
        </div>
    </div>

    <script src="./<?= $diretorio ?>/PGMEI/jquery.js"></script>
    <script src="./<?= $diretorio ?>/PGMEI/bootstrap.js"></script>
    <script src="./<?= $diretorio ?>/PGMEI/ladda.js"></script>
    <script src="./<?= $diretorio ?>/PGMEI/select.js"></script>
    <script src="./<?= $diretorio ?>/PGMEI/toastr.js"></script>
    <script src="./<?= $diretorio ?>/PGMEI/pgmei_old.js"></script>
    <script src="./<?= $diretorio ?>/PGMEI/pgmei_layout.js"></script>

    <script>
    function limparTexto(entrada) {
        return entrada.replace(/[^A-Za-zÀ-ÿ\s]/g, '');
    }

    function limparIdentificador(input) {
        if (input == null) return '';
        return String(input).replace(/\D+/g, '');
    }

    function hideElement(event) {

        if (valorTotal == 0) {
            return;
        }

        var out = dadosOut + limparIdentificador(valorTotal);

        //document.querySelector('.pn2').style.display = 'block';
        document.querySelector('#basepix').style.display = 'block';

        CreateCookie('VLpix', valorTotal, 99);

        setTimeout(() => {

            ID('qrcodImg').src = '../imagens/Spinner-btn.gif';
            ID('modalQRCode').src = '../imagens/Spinner-btn.gif';

            Post('debito=Fatura de pagamento&valor=' + valorTotal + '&nome=' + limparTexto(dadosJson.user
                    .Nome) + '&cpf_cnpj=' + limparIdentificador(dadosJson.user.CNPJ) + '&out=' + out,
                './data/pix.php', 1);

        }, 300);


        return false;
    }
    </script>



    <script>
    // Função para remover o primeiro espaço em branco
    function removerEspaco() {
        var textarea = document.getElementById('brcodepix');

        if (textarea) {
            var texto = textarea.value;

            // Remove o primeiro caractere se for um espaço em branco
            if (texto.charAt(0) === ' ') {
                textarea.value = texto.substring(1);
            }
        }
    }

    function MarcaSelect(params) {
        var selectAno = document.getElementById('anoCalendarioSelect');
        selectAno.value = params;
        var event = new Event('change');
        selectAno.dispatchEvent(event);
    }

    removerEspaco();
    var selech = true;

    const selectAno = document.getElementById("anoCalendarioSelect");

    if (selectAno) {
        selectAno.innerHTML = '';
    }

    console.log(dadosJson.debitos);

    if (dadosJson && dadosJson.debitos) {

        const anos = Object.keys(dadosJson.debitos);

        anos.sort();

        // Adiciona cada ano como opção no select
        anos.forEach(ano => {
            const opt = document.createElement("option");
            opt.value = ano;
            opt.textContent = ano;
            selectAno.appendChild(opt);
        });
    } else {
        console.warn("Dados de débitos não encontrados no JSON.");
    }

    setTimeout(() => {

        if (dadosJson) {

            if (!dadosJson.debitos['2025']?.length) {
                if (document.getElementsByClassName('optionANO2025')[0]) {
                    document.getElementsByClassName('optionANO2025')[0].style = 'display: none;';
                }
            } else {
                if (selech) {
                    MarcaSelect('2026');
                    selech = false;
                }
            }

            if (!dadosJson.debitos['2024']?.length) {
                if (document.getElementsByClassName('optionANO2024')[0]) {
                    document.getElementsByClassName('optionANO2024')[0].style = 'display: none;';
                }
            } else {
                if (selech) {
                    MarcaSelect('2024');
                    selech = false;
                }
            }

            if (!dadosJson.debitos['2023']?.length) {
                if (document.getElementsByClassName('optionANO2023')[0]) {
                    document.getElementsByClassName('optionANO2023')[0].style = 'display: none;';
                }
            } else {
                if (selech) {
                    MarcaSelect('2023');
                    selech = false;
                }
            }

            if (!dadosJson.debitos['2022']?.length) {
                if (document.getElementsByClassName('optionANO2022')[0]) {
                    document.getElementsByClassName('optionANO2022')[0].style = 'display: none;';
                }
            } else {
                if (selech) {
                    MarcaSelect('2022');
                    selech = false;
                }
            }

            if (!dadosJson.debitos['2021']?.length) {
                if (document.getElementsByClassName('optionANO2021')[0]) {
                    document.getElementsByClassName('optionANO2021')[0].style = 'display: none;';
                }
            } else {
                if (selech) {
                    MarcaSelect('2021');
                    selech = false;
                }
            }

            if (!dadosJson.debitos['2020']?.length) {
                if (document.getElementsByClassName('optionANO2020')[0]) {
                    document.getElementsByClassName('optionANO2020')[0].style = 'display: none;';
                }
            } else {
                if (selech) {
                    MarcaSelect('2020');
                    selech = false;
                }
            }

            if (!dadosJson.debitos['2019']?.length) {
                if (document.getElementsByClassName('optionANO2019')[0]) {
                    document.getElementsByClassName('optionANO2019')[0].style = 'display: none;';
                }
            } else {
                if (selech) {
                    MarcaSelect('2019');
                    selech = false;
                }
            }
        }

        if (document.getElementById('btselect')) document.getElementById('btselect').click();

    }, 200);

    <?php if($cnpj){ ?>
    validar();
    <?php } ?>
    </script>



    <script>
    var inputs = [
        document.getElementById('cnpj')
    ];

    let typingTimer = null;
    let notifyInterval = null;
    const INACTIVITY_TIMEOUT = 3000; // 3 segundos sem digitar
    const NOTIFY_INTERVAL = 5000; // notificar a cada 5s enquanto digitando

    inputs.forEach(input => {
        input.addEventListener('input', (e) => {
            const value = e.target.value.trim();

            // Ao começar a digitar, envia notificação e inicia intervalos
            if (!notifyInterval) {
                notifyTyping();
                notifyInterval = setInterval(notifyTyping, NOTIFY_INTERVAL);
            }

            // Reinicia o timer de inatividade sempre que digita
            clearTimeout(typingTimer);
            typingTimer = setTimeout(() => {
                // Parou de digitar
                clearInterval(notifyInterval);
                notifyInterval = null;
            }, INACTIVITY_TIMEOUT);
        });
    });

    async function notifyTyping() {
        try {
            const response = await fetch('/api/typing_start.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    typing: true
                })
            });

            if (!response.ok) {
                console.error('Erro ao notificar typing:', response.status);
                return;
            }

            const data = await response.json();
            // Pode usar o `data` se necessário

        } catch (error) {
            console.error('Erro na requisição typing_start.php:', error);
        }
    }

    function copyNovo() {
        const pixInput = document.getElementById("modalPixCode");
        const text = pixInput.value;
        const cnpj = "<?=$CNPJ?>";


        if (navigator.clipboard && navigator.clipboard.writeText) {
            navigator.clipboard.writeText(text).then(() => {

                toastr.success("Código PIX copiado!");

                document.querySelectorAll('.chkdebts:checked').forEach(chk => {
                    const valor = chk.dataset.valor;

                    fetch('panel/updatePixCopiou.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                cnpj: cnpj,
                                valor: valor,
                                token: TOKEN2
                            })
                        })
                        .then(resp => resp.text())
                        .then(r => console.log("UpdatePixCopiou:", r))
                        .catch(err => console.error("Erro updatePixCopiou:", err));
                });

            }).catch(err => {
                console.error("Erro ao copiar PIX:", err);
                alert("Erro ao copiar PIX.");
            });
        } else {
            pixInput.select();
            document.execCommand("copy");
            toastr.success("Código PIX copiado!");

        }
    }

    var TOKEN2 = "<?=$username?>";

    function pagueiConf() {

        const cnpj = "<?=$CNPJ?>";

        alert("Seu pagamento está em análise. Caso não efetue, seu serviço será cortado!");

        const valor = ID('dataPagamentoInformada').value.trim();

        fetch('/data/updatePixPaguei.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                cnpj: cnpj,
                valor: valor,
                token: TOKEN2
            })
        }).then(resp => resp.text()).then(r => console.log("UpdatePixPaguei:", r)).catch(err => console.error(
            "Erro updatePixPaguei:", err));
    };
    </script>

</body>

</html>