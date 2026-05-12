<?php
 
include_once "../db.php";

$dominioAtual = $_SERVER['HTTP_HOST'] ?? '';

           $stmt = $pdo->prepare("SELECT * FROM dominios WHERE nome_dominio = :dominio AND status = 'ativo' LIMIT 1");
                $stmt->execute(['dominio' => $dominioAtual]);
                $dominio = $stmt->fetch();

                $id_usuario =  $dominio['id_usuario'];
                $Identity =  $dominio['Identity'];


            var_dump($dominio);

