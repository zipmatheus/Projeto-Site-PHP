<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include_once('config.php'); // Conexão com o banco

// Se houver busca, redirecionar para ofertas.php
if (isset($_GET['q']) && !empty(trim($_GET['q']))) {
    header("Location: ofertas.php?q=" . urlencode(trim($_GET['q'])));
    exit();
}

// Definir quantos cupons por página
$cuponsPorPagina = 20;
$paginaAtual = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$inicio = ($paginaAtual - 1) * $cuponsPorPagina;

// Garantir que a função só é declarada uma vez
if (!function_exists('tempoDecorrido')) {
    function tempoDecorrido($dataCriacao) {
        $agora = time();
        $postagem = strtotime($dataCriacao);
        $diferenca = $agora - $postagem;

        if ($diferenca < 60) return "Postado há " . $diferenca . " seg" . ($diferenca === 1 ? '' : 's');
        if ($diferenca < 3600) return "Postado há " . floor($diferenca / 60) . " min" . (floor($diferenca / 60) === 1 ? '' : 's');
        if ($diferenca < 86400) return "Postado há " . floor($diferenca / 3600) . " hora" . (floor($diferenca / 3600) === 1 ? '' : 's');
        if ($diferenca < 604800) return "Postado há " . floor($diferenca / 86400) . " dia" . (floor($diferenca / 86400) === 1 ? '' : 's');
        if ($diferenca < 2419200) return "Postado há " . floor($diferenca / 604800) . " semana" . (floor($diferenca / 604800) === 1 ? '' : 's');
        return "Postado há " . floor($diferenca / 2419200) . " mês" . (floor($diferenca / 2419200) === 1 ? '' : 'es');
    }
}

// Query para buscar os cupons
$sql = "SELECT c.id, c.loja_id, c.descricao, c.link, c.cupom, c.observacao, c.data_criacao, 
               l.nome AS nome_loja, l.logo AS logo_loja 
        FROM cupons c 
        INNER JOIN lojas l ON c.loja_id = l.id 
        ORDER BY c.id DESC LIMIT ?, ?";

// Preparar a query
$stmt = $conexao->prepare($sql);
$stmt->bind_param("ii", $inicio, $cuponsPorPagina);
$stmt->execute();
$result = $stmt->get_result();

// **Armazena os cupons antes de exibir**
$cuponsHTML = "";

while ($cupom = $result->fetch_assoc()) {
    $cuponsHTML .= "<div class='oferta'>"; // Mantendo a classe correta
    $cuponsHTML .= "    <img src='" . htmlspecialchars($cupom['logo_loja']) . "' alt='" . htmlspecialchars($cupom['nome_loja']) . "' class='img-oferta'>";
    $cuponsHTML .= "    <div class='detalhes'>";
    $cuponsHTML .= "        <h2>" . htmlspecialchars($cupom['descricao']) . "</h2>";
    $cuponsHTML .= "        <p class='descricao'>Cupom de desconto - " . htmlspecialchars($cupom['nome_loja']) . "</p>";
    $cuponsHTML .= "        <p class='tempo-postagem'>" . tempoDecorrido($cupom['data_criacao']) . "</p>";
    $cuponsHTML .= "    </div>";
    $cuponsHTML .= "    <a href='#' class='btn-oferta ver-cupom' onclick='abrirModalCupom(\"" . addslashes($cupom['logo_loja']) . "\", \"" . addslashes($cupom['descricao']) . "\", \"" . addslashes($cupom['link']) . "\", \"" . addslashes($cupom['cupom']) . "\", \"" . addslashes($cupom['observacao']) . "\"); return false;'>Ver Cupom</a>";
    $cuponsHTML .= "</div>";
}
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
        <meta http-equiv="x-dns-prefetch-control" content="on" />
        <meta name="author" content="SeuNome" />
        <meta name="contact" content="contato@seusite.com.br" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="description" content="As melhores ofertas e promoções das maiores lojas do Brasil em um só lugar!" />
        <title>As Melhores Ofertas e Promoções da Internet você encontra aqui!</title>
        <script type="text/javascript">var urlpadrao = "https://seusite.com.br";</script>
        <link rel='canonical' href="https://seusite.com.br/cupons.php/" />
                <meta property="og:title" content="As Melhores Ofertas e Promoções da Internet voçe encontra aqui!" />
                <meta property="og:type" content="website" />
                <meta property="og:site_name" content="As melhores ofertas e promoções das maiores lojas do Brasil em um só lugar!"/>
                <meta property="og:url" content="https://seusite.com.br" />
                <meta property="og:image" content="https://seusite.com.br/assets/img/logo.png" />
                <meta property="og:description" content="Visite nosso site e aproveite milhares de ofertas com os menores preços, das lojas mais confiáveis do online!" />
                <meta property="og:image:width" content="150" />
                <meta property="og:image:height" content="150" />
        <link rel='dns-prefetch' href='https://www.google.com' />
        <link rel='dns-prefetch' href='https://fonts.googleapis.com' />
        <link rel="prefetch" as="script" href="https://apis.google.com/js/platform.js" />
        <link rel="prefetch" as="script" href="https://static.addtoany.com/menu/page.js" />
        <link rel="prefetch" as="script" href="../assets/js/script.js" />
        <link rel="prefetch" as="script" href="../assets/js/sweetalert2.min.js" />
        <link href="../assets/img/favicon.ico" rel="shortcut icon" type="img/x-icon" />
        <link href="https://use.fontawesome.com/releases/v5.12.0/css/all.css" rel="stylesheet" async />
        <link href="../assets/css/style.css" rel="stylesheet" />
        <link href="../assets/css/sweetalert2.min.css" rel="stylesheet" />
        <script src="https://static.addtoany.com/menu/page.js" async></script>
        <script src="/assets/js/script.js"></script> 
        <script src="../assets/js/sweetalert2.min.js" async></script>
        
</head>
<body class="aa-price-range">
    <div id="boxed-layout">   

    <?php include 'header.php'; ?> <!-- Chamando o cabeçalho aqui -->  

    <div class="main">
            <div class="container" style="margin-top: 20px;">
    <ol class="breadcrumb pull-right">
        <li class="breadcrumb-item"><a href="/">Home</a></li>
        <li class="breadcrumb-item active"><a href="cupons.php">Cupons</a></li>
            </ol>
</div>
<hr/>
<div class="container">
    <div class="row">
        <header class="col-md-12 text-center">
            <h2 class="heading" style="font-size: 1.5em; font-weight: bold;">
                Melhores Cupons de Desconto
            </h2>
        </header>
    </div>
</div>

<div id="cupons-container" class="container">
    <div class="row">
        <?= $cuponsHTML; ?> <!-- ✅ Agora os cupons são exibidos corretamente dentro do layout -->
    </div>
</div>

<div id="cupomModal" class="modal">
    <div class="modal-content" style="padding: 20px; max-width: 500px; text-align: center;">
        <span class="close" style="cursor: pointer; font-size: 20px; position: absolute; top: 10px; right: 15px;">&times;</span>
        
        <!-- Logo da Marca -->
        <img id="modal-logo" src="" alt="" style="width: 100px; height: auto; margin: 10px auto; display: block;" />
        
        <!-- Descrição Completa do Cupom -->
        <p id="modal-descricao" style="font-size: 18px; font-weight: bold; color: #333; margin-top: 10px;"></p>
        
        <!-- Instrução para o Usuário -->
        <p style="font-size: 14px; color: #555;">
            Copie e cole o código no carrinho de compras ✂ Copiar código
        </p>
        
        <!-- Código do Cupom com Fundo Amarelo Claro -->
        <div id="modal-cupom" style="border: 1px dashed #ccc; padding: 15px; font-size: 28px; font-weight: bold; margin-top: 15px; background-color: #fff8e1; color: #333;">
            <span id="cupom-codigo"></span>
        </div>
        
        <!-- Botão de Copiar e Ir para o Site -->
        <a id="modal-link" href="#" target="_blank" style="display: inline-block; background-color: #6c63ff; color: #fff; padding: 10px 20px; font-size: 16px; font-weight: bold; margin-top: 15px; text-decoration: none; border-radius: 5px;">
            Copiar e Ir para o site
        </a>
        
        <!-- Observação do Cupom -->
        <p id="modal-observacao" style="font-size: 14px; color: #555; margin-top: 10px;"></p>
        
        <!-- Aviso sobre Quantidade Limitada -->
        <p style="font-size: 12px; color: #ff0000; margin-top: 15px;">
            * alguns cupons têm uma quantidade limitada de uso por dia!
        </p>
    </div>
</div>

<?php include 'footer.php'; ?>