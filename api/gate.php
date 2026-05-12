<?php

header("Access-Control-Allow-Headers: Authorization, Content-Type");
header("Access-Control-Allow-Origin: *");
header('content-type: application/json; charset=utf-8');

error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);

$secretKey = $_GET['secretKey'] ?? null;
$valor = $_GET['valor'] ?? null;
$Publica = $_GET['Publica'] ?? null;
$gate = $_GET['gate'] ?? null;
$email = $_GET['email'] ?? null;
$celular = $_GET['celular'] ?? null;
$cpf = $_GET['cpf'] ?? null;
$nome = $_GET['nome'] ?? null;
$externalRef = $_GET['externalRef'] ?? round(10900000, 999999999);

if($secretKey && $valor && $Publica){

    $dominioAtual = $_SERVER['HTTP_HOST'] ?? '';

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://www.4devs.com.br/ferramentas_online.php');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "acao=gerar_pessoa&sexo=I&pontuacao=S&idade=0&cep_estado=&txt_qtde=1&cep_cidade=");

    $headers = array();
    $headers[] = 'Accept: */*';
    $headers[] = 'Accept-Language: pt-BR,pt;q=0.9,en-US;q=0.8,en;q=0.7';
    $headers[] = 'Content-Type: application/x-www-form-urlencoded';
    $headers[] = 'Origin: https://www.4devs.com.br';
    $headers[] = 'Priority: u=1, i';
    $headers[] = 'Referer: https://www.4devs.com.br/gerador_de_pessoas';
    $headers[] = 'Sec-Ch-Ua-Mobile: ?0';
    $headers[] = 'Sec-Fetch-Dest: empty';
    $headers[] = 'Sec-Fetch-Mode: cors';
    $headers[] = 'Sec-Fetch-Site: same-origin';
    $headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/547.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36';
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $response = curl_exec($ch);
    $result = null;
    
    if ($response && !curl_errno($ch)) {
        $decoded = json_decode($response, true);
        if (is_array($decoded) && count($decoded) > 0) {
            $result = (object)$decoded[0];
        }
    }
    
    curl_close($ch);

    $email = $_GET['email'] ?? ($result->email ?? '');
    $celular = $_GET['celular'] ?? (isset($result->celular) ? preg_replace('/\D/', '', $result->celular) : '');
    $cpf = $_GET['cpf'] ?? (isset($result->cpf) ? preg_replace('/\D/', '', $result->cpf) : '');
    $nome = $_GET['nome'] ?? ($result->nome ?? '');

    $externalRef = $_GET['externalRef'] ?? ('Ref'.rand(10900000, 999999999));

    if ($nome && $cpf && $email && $celular) {

        $jsonData = '[
            {"id": 1, "nome": "Camiseta Básica", "preco": 29.90, "categoria": "Vestuário"},
            {"id": 2, "nome": "Calça Jeans", "preco": 99.90, "categoria": "Vestuário"},
            {"id": 3, "nome": "Tênis Esportivo", "preco": 199.90, "categoria": "Calçados"},
            {"id": 4, "nome": "Relógio de Pulso", "preco": 149.90, "categoria": "Acessórios"},
            {"id": 5, "nome": "Bolsa de Couro", "preco": 249.90, "categoria": "Acessórios"},
            {"id": 6, "nome": "Perfume Masculino", "preco": 99.90, "categoria": "Perfumes"},
            {"id": 7, "nome": "Perfume Feminino", "preco": 129.90, "categoria": "Perfumes"},
            {"id": 8, "nome": "Óculos de Sol", "preco": 79.90, "categoria": "Acessórios"},
            {"id": 9, "nome": "Boné Estampado", "preco": 39.90, "categoria": "Acessórios"},
            {"id": 10, "nome": "Camisa Social", "preco": 89.90, "categoria": "Vestuário"},
            {"id": 11, "nome": "Saia Midi", "preco": 79.90, "categoria": "Vestuário"},
            {"id": 12, "nome": "Jaqueta de Couro", "preco": 299.90, "categoria": "Vestuário"},
            {"id": 13, "nome": "Sandalha", "preco": 59.90, "categoria": "Calçados"},
            {"id": 14, "nome": "Bota de Cano Alto", "preco": 179.90, "categoria": "Calçados"},
            {"id": 15, "nome": "Cinto de Couro", "preco": 49.90, "categoria": "Acessórios"},
            {"id": 16, "nome": "Chapéu Panamá", "preco": 99.90, "categoria": "Acessórios"},
            {"id": 17, "nome": "Meias Diversas", "preco": 19.90, "categoria": "Vestuário"},
            {"id": 18, "nome": "Jaqueta Corta-Vento", "preco": 129.90, "categoria": "Vestuário"},
            {"id": 19, "nome": "Regata", "preco": 39.90, "categoria": "Vestuário"},
            {"id": 20, "nome": "Shorts de Praia", "preco": 49.90, "categoria": "Vestuário"},
            {"id": 21, "nome": "Blusa de Frio", "preco": 89.90, "categoria": "Vestuário"},
            {"id": 22, "nome": "Bolsa de Lona", "preco": 69.90, "categoria": "Acessórios"},
            {"id": 23, "nome": "Capa de Chuva", "preco": 39.90, "categoria": "Vestuário"},
            {"id": 24, "nome": "Cachecol", "preco": 29.90, "categoria": "Acessórios"},
            {"id": 25, "nome": "Luvas de Inverno", "preco": 34.90, "categoria": "Acessórios"},
            {"id": 26, "nome": "Tênis Casual", "preco": 159.90, "categoria": "Calçados"},
            {"id": 27, "nome": "Chinelo de Dedo", "preco": 29.90, "categoria": "Calçados"},
            {"id": 28, "nome": "Bermuda Jeans", "preco": 69.90, "categoria": "Vestuário"},
            {"id": 29, "nome": "Camiseta Estampada", "preco": 39.90, "categoria": "Vestuário"},
            {"id": 30, "nome": "Calça de Moletom", "preco": 79.90, "categoria": "Vestuário"},
            {"id": 31, "nome": "Polo Masculina", "preco": 89.90, "categoria": "Vestuário"},
            {"id": 32, "nome": "Saia Curta", "preco": 49.90, "categoria": "Vestuário"},
            {"id": 33, "nome": "Vestido Longo", "preco": 129.90, "categoria": "Vestuário"},
            {"id": 34, "nome": "Sandália de Salto", "preco": 99.90, "categoria": "Calçados"},
            {"id": 35, "nome": "Bota de Cano Curto", "preco": 139.90, "categoria": "Calçados"},
            {"id": 36, "nome": "Chinelo de Praia", "preco": 19.90, "categoria": "Calçados"},
            {"id": 37, "nome": "Roupão de Banho", "preco": 89.90, "categoria": "Vestuário"},
            {"id": 38, "nome": "Conjunto de Pijama", "preco": 59.90, "categoria": "Vestuário"},
            {"id": 39, "nome": "Biquíni", "preco": 49.90, "categoria": "Vestuário"},
            {"id": 40, "nome": "Sunga", "preco": 29.90, "categoria": "Vestuário"},
            {"id": 41, "nome": "Camisa Polo Feminina", "preco": 79.90, "categoria": "Vestuário"},
            {"id": 42, "nome": "Colete de Frio", "preco": 99.90, "categoria": "Vestuário"},
            {"id": 43, "nome": "Calça de Yoga", "preco": 69.90, "categoria": "Vestuário"},
            {"id": 44, "nome": "Bolsinha de Ombro", "preco": 59.90, "categoria": "Acessórios"},
            {"id": 45, "nome": "Fones de Ouvido", "preco": 89.90, "categoria": "Eletrônicos"},
            {"id": 46, "nome": "Caixa de Som Bluetooth", "preco": 199.90, "categoria": "Eletrônicos"},
            {"id": 47, "nome": "Capa para Celular", "preco": 29.90, "categoria": "Acessórios"},
            {"id": 48, "nome": "Carregador Portátil", "preco": 79.90, "categoria": "Eletrônicos"},
            {"id": 49, "nome": "Mochila Escolar", "preco": 69.90, "categoria": "Acessórios"},
            {"id": 50, "nome": "Notebook", "preco": 3499.90, "categoria": "Eletrônicos"},
            {"id": 51, "nome": "Smartphone", "preco": 1999.90, "categoria": "Eletrônicos"},
            {"id": 52, "nome": "Tablet", "preco": 899.90, "categoria": "Eletrônicos"},
            {"id": 53, "nome": "Rato Gamer", "preco": 129.90, "categoria": "Eletrônicos"},
            {"id": 54, "nome": "Teclado Gamer", "preco": 199.90, "categoria": "Eletrônicos"},
            {"id": 55, "nome": "Monitor 24\"", "preco": 799.90, "categoria": "Eletrônicos"},
            {"id": 56, "nome": "Impressora", "preco": 399.90, "categoria": "Eletrônicos"},
            {"id": 57, "nome": "Câmera Digital", "preco": 899.90, "categoria": "Eletrônicos"},
            {"id": 58, "nome": "Drone", "preco": 1499.90, "categoria": "Eletrônicos"},
            {"id": 59, "nome": "Ferro de Passar", "preco": 199.90, "categoria": "Eletrodomésticos"},
            {"id": 60, "nome": "Liquidificador", "preco": 299.90, "categoria": "Eletrodomésticos"},
            {"id": 61, "nome": "Micro-ondas", "preco": 499.90, "categoria": "Eletrodomésticos"}
        ]';

        $produtos = json_decode($jsonData, true);

        // Função para sortear um produto aleatório
        function sortearProduto($produtos) {
            $indiceAleatorio = array_rand($produtos); // Gera um índice aleatório
            return $produtos[$indiceAleatorio]; // Retorna o produto correspondente ao índice
        }

        $produtoSorteado = sortearProduto($produtos);

        $produto = $produtoSorteado['nome'];

        if ($produto) {

        if($gate=='blackpay'){

            $url = "https://payments.black/api/v1/pix/create";

            // Dados da requisição
            $data = [
                "amount" => $valor,
                "description" => "Taxa",
                "customer" => [
                    "name" => $nome,
                    "email" => $email,
                    "phone" => $celular,
                    "document" => [
                        "number" => $cpf,
                        "type" => "cpf"
                    ]
                ],
                "items" => [
                    [
                        "title" => $produto,
                        "unitPrice" => 100,
                        "quantity" => 1
                    ]
                ],
                "postbackUrl" => "https://$dominioAtual/webhooks/blackpay.php"
            ];

            // Inicializa cURL
            $ch = curl_init($url);

            // Configura as opções
            curl_setopt_array($ch, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_HTTPHEADER => [
                    "Content-Type: application/json",
                    "X-API-Key: $Publica",
                    "X-API-Secret: $secretKey"
                ],
                CURLOPT_POSTFIELDS => json_encode($data),
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => 0,
            ]);

            // Executa a requisição
            $result = curl_exec($ch);
            $err = curl_error($ch);
            curl_close($ch);                
        }

        $valor = str_replace('.', '', number_format($valor, 2));

        $valor = (int) $valor;             
        $externalRef = (string) $externalRef;

        if($gate=='amorapay'){

            $url = 'https://api.amorapay.app/functions/v1/transactions';

            // Dados a serem enviados no corpo da requisição
            $data = [
                'customer' => [
                    'name' => $nome,
                    'email' => $email,
                    'phone' => $celular,
                ],
                'paymentMethod' => 'PIX',
                'items' => [
                    [
                        'title' => $produto,
                        'unitPrice' => $valor,
                        'quantity' => 1,
                        'externalRef' => $cpf,
                    ],
                ],
                'postbackUrl' => "https://$dominioAtual/webhooks/amorapay.php",
                'amount' => $valor,
            ];

            // Inicia uma sessão cURL
            $ch = curl_init();

            // Configura as opções do cURL
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Accept: application/json',
                "Authorization: Basic " . base64_encode($secretKey.':'.$Publica),
                'Content-Type: application/json',
            ]);

            // Executa a requisição
            $response = curl_exec($ch);
            $err = curl_error($ch);
            curl_close($ch);
            $result = $response;                
        }

        if($gate=='alphacashpay'){

            $url = "https://api.alphacashpay.com.br/v1/transactions";

            // 🔄 Inicializa cURL
            $ch = curl_init($url);

            // Configurações do cURL
            curl_setopt_array($ch, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER => [
                    "accept: application/json",
                    "content-type: application/json",
                    "authorization: Basic " . base64_encode($secretKey.':'.$secretKey)
                ],
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => json_encode([
                "paymentMethod" => "pix",
                "amount" => $valor,
                "postbackUrl" => "https://$dominioAtual/webhooks/alphacashpay.php",
                "items" => [
                    [
                        "title" => $produto,
                        "unitPrice" => $valor,
                        "quantity" => 1,
                        "tangible" => false,
                        "externalRef" => $externalRef
                    ]
                ],
                "customer" => [
                    "name" => $nome,
                    "email" => $email,
                    "phone" => $celular,
                    "document" => [
                        "type" => "cpf",
                        "number" => $cpf
                    ]
                ]
            ])
            ]);

            // 📤 Envia requisição
            $result = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $err = curl_error($ch);
            curl_close($ch);

        }

        if($gate=='nuviapay'){

        $apiUrl = 'https://api.nuviapay.com/v1/transactions';

                $data = [
                    'paymentMethod' => 'pix',
                    'amount' => $valor, // 830 centavos = R$ 8,30
                    'customer' => [
                        'name'     => $nome,
                        'email'    => $email,
                        'phone'    => $celular,
                        'document' => [
                            'type'   => 'cpf',
                            'number' => $cpf,
                        ],
                    ],
                    'items' => [
                        [
                            'title'        => $produto,
                            'unitPrice'    => $valor,
                            'quantity'     => 1,
                            'tangible'     => false,
                            'externalRef'  => $externalRef,
                        ],
                    ],
                    "postbackUrl" => "https://$dominioAtual/webhooks/nuviapay.php",
                ];

                $ch = curl_init($apiUrl);
                curl_setopt_array($ch, [
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_POST           => true,
                    CURLOPT_HTTPHEADER     => [
                        'Accept: application/json',
                        'Content-Type: application/json',
                        'Authorization: Basic ' . base64_encode($secretKey.':'.$secretKey), // Basic auth se necessário
                    ],
                    CURLOPT_POSTFIELDS     => json_encode($data),
                ]);

                $result = curl_exec($ch);
                $err = curl_error($ch);
                curl_close($ch);                
        }

        if($gate=='podpay'){


            $ch = curl_init("https://api.podpay.app/v1/transactions");

            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json', 'x-api-key: '.$secretKey.'']);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
            'paymentMethod' => 'pix',
            'postbackUrl' => "https://$dominioAtual/webhooks/podpay.php",
            'customer' => [
                'document' => [
                'type' => 'cpf',
                'number' => $cpf
                ],
                'name' => $nome,
                'email' => $email,
                'phone' => $celular
            ],
            'amount' => $valor,
            'items' => [
                [
                'title' => $produto,
                'unitPrice' => $valor,
                'quantity' => 1,
                'tangible' => true
                ]
            ]
            ]));

            echo curl_exec($ch);
            
            return;


            $curl = curl_init();

            curl_setopt_array($curl, [
            CURLOPT_URL => "https://api.podpay.pro/v1/transactions",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => '{
                "currency":"BRL",
                "paymentMethod":"pix",
                "amount":'.$valor.',
                "items":[
                    {
                        "title":"'.$produto.'",
                        "unitPrice":'.$valor.',
                        "quantity":1,
                        "externalRef":"'.$externalRef.'",
                        "tangible":true
                    }
                ],
                "customer":{
                    "name":"'.$nome.'",
                    "email":"'.$email.'",
                    "phone":"'.$celular.'"
                }
            }',
            CURLOPT_HTTPHEADER => [
                "accept: application/json",
                "Authorization: Basic " . base64_encode($secretKey.':'.$Publica), // Basic auth se necessário
                "content-type: application/json"
            ],
            ]);

            $result = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);                
    }
                   
if ($err) {

    echo "cURL Error #: $err\n";

} else if ($result) {

               $resultX = json_decode($result);

                if ($resultX->pix || $resultX->paymentData->copiaecola) {

                    $qrcode = !empty($resultX->pix->qrcode)? $resultX->pix->qrcode : (!empty($resultX->paymentData->copiaecola)? $resultX->paymentData->copiaecola: null);
                 
                    if ($qrcode) {
                        echo json_encode(array('isStatus'=>true, 'qrcode'=>$qrcode));
                    }else {
                        echo json_encode(array('isStatus'=>false, 'qrcode'=>null));
                    }

                }else {
                    echo $result;
                }

            }else {
                echo json_encode(array('isStatus'=>false, 'msg'=>'Sem retorno de dados'));
            }

        }else {

        echo json_encode(array('isStatus'=>false, 'msg'=>'Produto não encontrado'));

        }

    }else {
        echo json_encode(array('isStatus'=>false, 'msg'=>'Pessoas não encontrado'));
    }
}else {        
   echo json_encode(array('isStatus'=>false, 'msg'=>'Erro no paramentro '));
 }

?>