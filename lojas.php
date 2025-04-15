<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include_once('config.php'); // Conexão com o banco

// Definir quantas lojas por página
$lojasPorPagina = 30;
$paginaAtual = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$inicio = ($paginaAtual - 1) * $lojasPorPagina;

// Consulta para buscar lojas
$sql = "SELECT id, nome, logo FROM lojas ORDER BY nome ASC LIMIT ?, ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("ii", $inicio, $lojasPorPagina);
$stmt->execute();
$result = $stmt->get_result();

// Consulta para contar total de lojas para paginação
$sqlTotal = "SELECT COUNT(id) as total FROM lojas";
$resultTotal = $conexao->query($sqlTotal);
$totalLojas = $resultTotal->fetch_assoc()['total'];
$totalPaginas = ceil($totalLojas / $lojasPorPagina);
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
        <link rel='canonical' href="https://seusite.com.br/lojas/" />
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
        <script src="/assets/js/script.js"></script>  
        <link href="../assets/img/favicon.ico" rel="shortcut icon" type="img/x-icon" />
        <link href="https://use.fontawesome.com/releases/v5.12.0/css/all.css" rel="stylesheet" async />
        <link href="/assets/css/style.css" rel="stylesheet" />
        <link href="/assets/css/sweetalert2.min.css" rel="stylesheet" />
        <script type="application/ld+json">
                    [{"@context":"https://schema.org","@graph":[{"@context":"https://schema.org","@type":"SiteNavigationElement","@id":"https://seusite.com.br/primary","name":"Home","url":"https://seusite.com.br/"},{"@context":"https://schema.org","@type":"SiteNavigationElement","@id":"https://seusite.com.br/primary","name":"Lojas","url":"https://seusite.com.br/lojas/"},{"@context":"https://schema.org","@type":"SiteNavigationElement","@id":"https://seusite.com.br/primary","name":"Ofertas","url":"https://seusite.com.br/ofertas/"},{"@context":"https://schema.org","@type":"SiteNavigationElement","@id":"https://seusite.com.br/primary","name":"Contato","url":"https://seusite.com.br/contato/"},{"@context":"https://schema.org","@type":"SiteNavigationElement","@id":"https://seusite.com.br/footer","name":"Home","url":"http://seusite.com.br"},{"@context":"https://schema.org","@type":"SiteNavigationElement","@id":"https://seusite.com.br/footer","name":"Contato","url":"http://seusite.com.br/contato/"},{"@context":"https://schema.org","@type":"SiteNavigationElement","@id":"http://seusite.com.br/footer","name":"Política de Privacidade","url":"http://seusite.com.br/politicadeprivacidade/"}]},{"@context":"http://schema.org","@type":"WebPage","@id":"https://seusite.com.br/","name":"As Melhores Ofertas e Promoções de Descontos Grátis da Internet","url":"https://seusite.com.br/","description":"Encontre as melhores ofertas e promoções de centenas de lojas virtuais totalmente grátis!","mainEntity":{"@type":"Article","mainEntityOfPage":"https://seusite.com.br/","image":"http://seusite.com.br/assets/img/icon-192x192.png","headline":"seusite - Ofertas e Promoções de Descontos Grátis da Internet","description":"seusite - Encontre as melhores ofertas e promoções de centenas de lojas virtuais totalmente grátis!","articleBody":"","keywords":"","datePublished":"2023-07-01T00:00:00Z","dateModified":"2023-07-05T00:00:00Z","author":{"@type":"Person","name":"seusite","description":"","image":{"@type":"ImageObject","url":"http://seusite.com.br/assets/img/icon-96x96.png","height":96,"width":96}},"publisher":{"@type":"Organization","logo":{"@type":"ImageObject","url":"http://seusite.com.br/assets/img/icon-96x96.png","height":96,"width":96},"name":"seusite"}},"contactPoint":{"@type":"ContactPoint","contactType":"customer support","telephone":"","url":"https://seusite.com.br/contato/"}}]
            </script>
        <script src="https://static.addtoany.com/menu/page.js" async></script>
</head>
<body class="aa-price-range">
    <div id="boxed-layout">   

    <?php include 'header.php'; ?> <!-- Chamando o cabeçalho aqui -->  

    <div class="main">
            <div class="container" style="margin-top: 20px;">
    <ol class="breadcrumb pull-right">
        <li class="breadcrumb-item"><a href="/">Home</a></li>
        <li class="breadcrumb-item active"><a href="lojas.php">Lojas</a></li>
    </ol>
</div>

    <div class="twocolumns pad-top-lg pad-bottom-lg">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <article id="content">
                             <h3 style="display:none;">Lojas Populares</h3>

                                <div class="holder">
                                    <div class="header-holder">
                                        <span class="txt pull-left text-uppercase">Lojas Populares</span>
                                    </div>
                                    <ul class="list-unstyled store-logo">
                                        <?php while ($loja = $result->fetch_assoc()) : ?>
                                            <li class="li-loja">
                                                <a href="ofertas.php?q=<?= urlencode($loja['nome']) ?>" title="Cupom de desconto <?= htmlspecialchars($loja['nome']) ?>" class="a-loja">
                                                    <img src="<?= htmlspecialchars($loja['logo']) ?>" alt="Cupom de desconto <?= htmlspecialchars($loja['nome']) ?>" class="img-responsive img-loja">
                                                </a>
                                                <p class="p-loja"><?= htmlspecialchars($loja['nome']) ?></p>
                                            </li>
                                        <?php endwhile; ?>
                                    </ul>
                                </div>
<!-- Paginação -->
<div class="row">
    <div class="text-center">
        <ul class="list-unstyled pagination">
            <?php if ($paginaAtual > 1): ?>
                <li><a href="?page=1">«</a></li>
                <li><a href="?page=<?= $paginaAtual - 1 ?>">‹</a></li>
            <?php endif; ?>

            <?php 
            $maximoPaginasVisiveis = 5;
            $inicio = max(1, $paginaAtual - floor($maximoPaginasVisiveis / 2));
            $fim = min($totalPaginas, $inicio + $maximoPaginasVisiveis - 1);

            if ($inicio > 1): ?>
                <li><a href="?page=1">1</a></li>
                <?php if ($inicio > 2): ?>
                    <li><span>...</span></li>
                <?php endif; ?>
            <?php endif; ?>

            <?php for ($i = $inicio; $i <= $fim; $i++): ?>
                <li class="<?= ($paginaAtual == $i) ? 'active' : ''; ?>">
                    <a href="?page=<?= $i ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>

            <?php if ($fim < $totalPaginas): ?>
                <?php if ($fim < $totalPaginas - 1): ?>
                    <li><span>...</span></li>
                <?php endif; ?>
                <li><a href="?page=<?= $totalPaginas ?>"><?= $totalPaginas ?></a></li>
            <?php endif; ?>

            <?php if ($paginaAtual < $totalPaginas): ?>
                <li><a href="?page=<?= $paginaAtual + 1 ?>">›</a></li>
                <li><a href="?page=<?= $totalPaginas ?>">»</a></li>
            <?php endif; ?>
        </ul>
    </div>
</div>


<?php include 'footer.php'; ?>

</body>
</html>