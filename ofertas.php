<?php
session_start();
include_once('config.php'); // Conexão com o banco

// Capturar a busca
$termoBusca = isset($_GET['q']) ? trim($_GET['q']) : "";

// Definir quantos produtos por página
$produtosPorPagina = 20;
$paginaAtual = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$inicio = ($paginaAtual - 1) * $produtosPorPagina;

// Criar a query base
$sql = "SELECT p.id idProduto, p.nome nomeProduto, p.url url, p.imagem imagem, p.valor valor, 
               p.precoAntigo precoAntigo, p.desconto desconto, p.data AS dataPostagem, 
               l.nome nomeLoja, l.logo logo, l.afiliado afiliado 
        FROM produtos p 
        INNER JOIN lojas l ON p.loja_id = l.id";

// Se houver busca, adicionar o filtro corretamente
if (!empty($termoBusca)) {
    $sql .= " WHERE LOWER(p.nome) LIKE LOWER(?) OR LOWER(l.nome) LIKE LOWER(?)";
}

// Adicionar ordenação e paginação
$sql .= " ORDER BY p.id DESC LIMIT ?, ?";

// Preparar a consulta
$stmt = $conexao->prepare($sql);

// Se houver busca, adicionar os parâmetros corretamente com % para funcionar no LIKE
if (!empty($termoBusca)) {
    $termoBuscaLike = "%" . strtolower($termoBusca) . "%"; // Garante que funciona para qualquer capitalização
    $stmt->bind_param("ssii", $termoBuscaLike, $termoBuscaLike, $inicio, $produtosPorPagina);
} else {
    $stmt->bind_param("ii", $inicio, $produtosPorPagina);
}


$stmt->execute();
$result = $stmt->get_result();

// Criar a query para contar o total de registros
$totalRegistrosSQL = "SELECT COUNT(*) AS total FROM produtos p INNER JOIN lojas l ON p.loja_id = l.id";
if (!empty($termoBusca)) {
    $totalRegistrosSQL .= " WHERE p.nome LIKE ? OR l.nome LIKE ?";
}

// Preparar a consulta
$stmtTotal = $conexao->prepare($totalRegistrosSQL);

// Se houver busca, passar os parâmetros
if (!empty($termoBusca)) {
    $stmtTotal->bind_param("ss", $termoBusca, $termoBusca);
}

$stmtTotal->execute();
$resultTotal = $stmtTotal->get_result();
$totalRegistros = $resultTotal->fetch_assoc()['total'];

$totalPaginas = ceil($totalRegistros / $produtosPorPagina);

// Função para calcular o tempo decorrido
function tempoDecorrido($dataPostagem) {
    $agora = new DateTime();
    $postagem = new DateTime($dataPostagem);
    $diferenca = $agora->getTimestamp() - $postagem->getTimestamp(); // Diferença em segundos

    if ($diferenca < 60) return "Postado há " . $diferenca . " seg" . ($diferenca == 1 ? "" : "s");
    if ($diferenca < 3600) return "Postado há " . floor($diferenca / 60) . " min" . (floor($diferenca / 60) == 1 ? "" : "s");
    if ($diferenca < 86400) return "Postado há " . floor($diferenca / 3600) . " hora" . (floor($diferenca / 3600) == 1 ? "" : "s");
    if ($diferenca < 604800) return "Postado há " . floor($diferenca / 86400) . " dia" . (floor($diferenca / 86400) == 1 ? "" : "s");
    if ($diferenca < 2419200) return "Postado há " . floor($diferenca / 604800) . " semana" . (floor($diferenca / 604800) == 1 ? "" : "s");
    return "Postado há " . floor($diferenca / 2419200) . " mês" . (floor($diferenca / 2419200) == 1 ? "" : "es");
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
        <link rel='canonical' href="https://seusite.com.br/ofertas/" />
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
        <link rel="prefetch" as="script" href="../assets/js/sweetalert2.min.js" />
        <link href="/assets/img/favicon.ico" rel="shortcut icon" type="img/x-icon" />
        <link href="https://use.fontawesome.com/releases/v5.12.0/css/all.css" rel="stylesheet" async />
        <link href="/assets/css/style.css" rel="stylesheet" />
        <link href="/assets/css/sweetalert2.min.css" rel="stylesheet" />
         <script src="/assets/js/script.js"></script> 
        <script src="https://static.addtoany.com/menu/page.js" async></script>
        <script src="/assets/js/sweetalert2.min.js" async></script>
</head>
<body class="aa-price-range">
    <div id="boxed-layout">   

    <?php include 'header.php'; ?> <!-- Chamando o cabeçalho aqui -->  
        
        <div class="main">
            <div class="container" style="margin-top: 20px;">
    <ol class="breadcrumb pull-right">
        <li class="breadcrumb-item"><a href="/">Home</a></li>
        <li class="breadcrumb-item active"><a href="ofertas.php">Ofertas</a></li>
            </ol>
</div>

<hr/>

<div class="container" style="display: none;">
    <div class="row col-md-12 text-center">
                    <h1>Ofertas e Promoções</h1>
            </div>
</div>

    <!-- Container de Ofertas -->
    <section class="store-sec latest-coupon container pad-top-lg pad-bottom-md">
        <div class="row">
            <header class="col-md-12 text-center header">
            <?php if (!empty($_GET['q'])) { ?>
    <h2 class="heading">Resultados para: '<?php echo htmlspecialchars($_GET['q']); ?>'</h2>
<?php } else { ?>
    <h2 class="heading">Todas as Ofertas</h2>
<?php } ?>

            </header>
        </div>

        <div id="produtos-container">
            <div class="row">
                <ul class="lista-produtos">
                <?php 
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) { 
        $urlCompleta = !empty($row["afiliado"]) ? $row["afiliado"] . $row["url"] : $row["url"];

        // Correção do valor atual
        $valorCorrigido = str_replace('.', '', $row["valor"]); // Remover separador de milhar
        $valorCorrigido = str_replace(',', '.', $valorCorrigido); // Converter para formato de número do PHP
        $valorFormatado = number_format(floatval($valorCorrigido), 2, ',', '.'); // Formatar no padrão brasileiro

        // Correção do preço antigo, se existir
        $precoAntigoFormatado = "";
        if (!empty($row["precoAntigo"])) { 
            $precoAntigoCorrigido = str_replace('.', '', $row["precoAntigo"]);
            $precoAntigoCorrigido = str_replace(',', '.', $precoAntigoCorrigido);
            $precoAntigoFormatado = number_format(floatval($precoAntigoCorrigido), 2, ',', '.');
        }
?>
        <li class="oferta">
            <div class="oferta-imagem">
                <img src="../../<?php echo $row["imagem"]; ?>" alt="<?php echo htmlspecialchars($row["nomeProduto"]); ?>" class="img-oferta">
            </div>
            <div class="detalhes">
                <h2>
                    <a href="javascript:void(0);" onclick="abrirOferta(this)" data-url="<?php echo htmlspecialchars($urlCompleta); ?>" title="<?php echo htmlspecialchars($row["nomeProduto"]); ?> na <?php echo htmlspecialchars($row["nomeLoja"]); ?>">
                        <?php echo htmlspecialchars($row["nomeProduto"]); ?>
                    </a>
                </h2>
                <p class="preco"><strong>R$ <?php echo $valorFormatado; ?></strong></p>
                <?php if (!empty($precoAntigoFormatado)) { ?>
                    <p class="preco-antigo"><del>R$ <?php echo $precoAntigoFormatado; ?></del></p>
                <?php } ?>
                <p class="descricao"><?php echo htmlspecialchars($row["nomeLoja"]); ?></p>
                <p class="tempo-postagem"><?php echo tempoDecorrido($row["dataPostagem"]); ?></p>
            </div>
            <a href="javascript:void(0);" onclick="abrirOferta(this)" class="btn-oferta" data-url="<?php echo htmlspecialchars($urlCompleta); ?>">Ver Oferta</a>
        </li>
<?php 
    } 
} 
?>

                </ul>
            </div>
        </div>

        <script>
        function abrirOferta(elemento) {
            let url = elemento.getAttribute("data-url");
            window.open(url, "_blank");
        }
    </script>

<!-- Paginação -->
<div class="row">
<div class="text-center">
    <ul class="list-unstyled pagination">
        <?php if ($paginaAtual > 1): ?>
            <li><a href="?q=<?php echo urlencode($termoBusca); ?>&page=1">«</a></li>
            <li><a href="?q=<?php echo urlencode($termoBusca); ?>&page=<?php echo ($paginaAtual - 1); ?>">‹</a></li>
        <?php endif; ?>

        <?php 
        $maximoPaginasVisiveis = 5;
        $inicio = max(1, $paginaAtual - floor($maximoPaginasVisiveis / 2));
        $fim = min($totalPaginas, $inicio + $maximoPaginasVisiveis - 1);

        if ($inicio > 1): ?>
            <li><a href="?q=<?php echo urlencode($termoBusca); ?>&page=1">1</a></li>
            <?php if ($inicio > 2): ?>
                <li><span>...</span></li>
            <?php endif; ?>
        <?php endif; ?>

        <?php for ($i = $inicio; $i <= $fim; $i++): ?>
            <li class="<?php echo ($paginaAtual == $i) ? 'active' : ''; ?>">
                <a href="?q=<?php echo urlencode($termoBusca); ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a>
            </li>
        <?php endfor; ?>

        <?php if ($fim < $totalPaginas): ?>
            <?php if ($fim < $totalPaginas - 1): ?>
                <li><span>...</span></li>
            <?php endif; ?>
            <li><a href="?q=<?php echo urlencode($termoBusca); ?>&page=<?php echo $totalPaginas; ?>"><?php echo $totalPaginas; ?></a></li>
        <?php endif; ?>

        <?php if ($paginaAtual < $totalPaginas): ?>
            <li><a href="?q=<?php echo urlencode($termoBusca); ?>&page=<?php echo ($paginaAtual + 1); ?>">›</a></li>
            <li><a href="?q=<?php echo urlencode($termoBusca); ?>&page=<?php echo $totalPaginas; ?>">»</a></li>
        <?php endif; ?>
    </ul>
</div>

    </section>

            <section class="container" style="font-size: 12px;">
<div class="row">
        <div class="col-md-12">
            <hr>
            <h3>Como usar a <span class="clr"><strong>OFERTA E PROMOÇÃO</strong></span>?</h3>
            <p>Sua descricao</p>
            <p>Sua descricao</p>
            <p>Sua descricao</p>
            <hr>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>