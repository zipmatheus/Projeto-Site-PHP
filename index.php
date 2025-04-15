<?php
session_start();
include_once('config.php'); // Conexão com o banco

// Capturar a busca
$termoBusca = isset($_GET['q']) ? trim($_GET['q']) : "";

// Criar a query base
$sql = "SELECT p.id idProduto, p.nome nomeProduto, p.url url, p.imagem imagem, p.valor valor, 
               p.precoAntigo precoAntigo, p.desconto desconto, p.data AS dataPostagem, 
               l.nome nomeLoja, l.logo logo, l.afiliado afiliado 
        FROM produtos p 
        INNER JOIN lojas l ON p.loja_id = l.id";

// Se houver busca, adicionar o filtro
if (!empty($termoBusca)) {
    $sql .= " WHERE LOWER(p.nome) LIKE LOWER(?) OR LOWER(l.nome) LIKE LOWER(?)";
}

// Adicionar ordenação e limite para 10 produtos (Home)
$sql .= " ORDER BY p.id DESC LIMIT 10";

// Preparar a consulta
$stmt = $conexao->prepare($sql);

// Se houver busca, adicionar os parâmetros
if (!empty($termoBusca)) {
    $termoBusca = "%$termoBusca%";
    $stmt->bind_param("ss", $termoBusca, $termoBusca);
}

$stmt->execute();
$result = $stmt->get_result();

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
        <link rel='canonical' href="https://seusite.com.br" />
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
        <link rel="prefetch" as="script" href="/assets/js/sweetalert2.min.js" />
                <link href="assets/img/favicon.ico" rel="shortcut icon" type="img/x-icon" />
        <link href="https://use.fontawesome.com/releases/v5.12.0/css/all.css" rel="stylesheet" async />
        <link href="assets/css/style.css" rel="stylesheet" />
        <link href="assets/css/sweetalert2.min.css" rel="stylesheet" />
        <script type="application/ld+json">
        [{"@context":"https://schema.org","@graph":[{"@context":"https://schema.org","@type":"SiteNavigationElement","@id":"https://seusite.com.br/primary","name":"Home","url":"https://seusite.com.br/"},{"@context":"https://schema.org","@type":"SiteNavigationElement","@id":"https://seusite.com.br/primary","name":"Lojas","url":"https://seusite.com.br/lojas/"},{"@context":"https://schema.org","@type":"SiteNavigationElement","@id":"https://seusite.com.br/primary","name":"Ofertas","url":"https://seusite.com.br/ofertas/"},{"@context":"https://schema.org","@type":"SiteNavigationElement","@id":"https://seusite.com.br/primary","name":"Contato","url":"https://seusite.com.br/contato/"},{"@context":"https://schema.org","@type":"SiteNavigationElement","@id":"https://seusite.com.br/footer","name":"Home","url":"http://seusite.com.br"},{"@context":"https://schema.org","@type":"SiteNavigationElement","@id":"https://seusite.com.br/footer","name":"Contato","url":"http://seusite.com.br/contato/"},{"@context":"https://schema.org","@type":"SiteNavigationElement","@id":"http://seusite.com.br/footer","name":"Política de Privacidade","url":"http://seusite.com.br/politicadeprivacidade/"}]},{"@context":"http://schema.org","@type":"WebPage","@id":"https://seusite.com.br/","name":"As Melhores Ofertas e Promoções de Descontos Grátis da Internet","url":"https://seusite.com.br/","description":"Encontre as melhores ofertas e promoções de centenas de lojas virtuais totalmente grátis!","mainEntity":{"@type":"Article","mainEntityOfPage":"https://seusite.com.br/","image":"http://seusite.com.br/assets/img/icon-192x192.png","headline":"seusite - Ofertas e Promoções de Descontos Grátis da Internet","description":"seusite - Encontre as melhores ofertas e promoções de centenas de lojas virtuais totalmente grátis!","articleBody":"","keywords":"","datePublished":"2023-07-01T00:00:00Z","dateModified":"2023-07-05T00:00:00Z","author":{"@type":"Person","name":"seusite","description":"","image":{"@type":"ImageObject","url":"http://seusite.com.br/assets/img/icon-96x96.png","height":96,"width":96}},"publisher":{"@type":"Organization","logo":{"@type":"ImageObject","url":"http://seusite.com.br/assets/img/icon-96x96.png","height":96,"width":96},"name":"seusite"}},"contactPoint":{"@type":"ContactPoint","contactType":"customer support","telephone":"","url":"https://seusite.com.br/contato/"}}]
        </script>
        <script src="https://static.addtoany.com/menu/page.js" async></script>
        <script src="/assets/js/script.js"></script> 
        <script src="assets/js/sweetalert2.min.js" async></script>       
    </head>

    <body class="aa-price-range">
        <div id="boxed-layout">      

        <?php include 'header.php'; ?> <!-- Chamando o cabeçalho aqui -->        
    
        <div class="main">
                <h1 style="display:none;">As melhores ofertas e promoções das maiores lojas do Brasil em um só lugar!</h1>
    <h2 style="display:none;">Desconto e Promoções</h2>

<section class="store-sec latest-coupon container pad-top-lg pad-bottom-md">
    <div class="row">
        <header class="col-md-12 text-center header">
            <h2 class="heading">Últimas Ofertas</h2>
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
    </section>
    <script>
        function abrirOferta(elemento) {
            let url = elemento.getAttribute("data-url");
            window.open(url, "_blank");
        }
    </script>

    <div class="row">
        <div class="text-center" id="botaoOcultar">
            <a id="btnVerOfertas" a href="ofertas.php" style="color: #fff" class="btn-primary text-center text-uppercase md-round" title="Ver mais ofertas">Ver mais ofertas</a>
        </div>
    </div>
</section>

<section class="store-sec bg-grey pad-top-lg pad-bottom-lg">
    <div class="container">
        <div class="row">
            <header class="col-md-12 text-center header">
                <h3 class="heading">Lojas <span class="clr"><strong>PARCEIRAS</strong></span> em destaque</h3>
                <p>As melhores ofertas e promoções das maiores lojas do Brasil em um só lugar!</p>
            </header>
        </div>
        <div class="row">
            <div class="col-md-12">
                <ul class="list-unstyled store-logo">
                                            <li>
                            <a href="ofertas.php?q=loja01" title="loja01">
                                <img src="assets/lojas/01.png" alt="Cupom de desconto e Ofertas loja01" class="img-responsive" title="Cupom de desconto e Ofertas loja01">
                            </a>
                        </li>
                                            <li>
                            <a href="ofertas.php?q=loja02" title="loja02">
                                <img src="assets/lojas/loja02.png" alt="Cupom de desconto e Ofertas loja02" class="img-responsive" title="Cupom de desconto e Ofertas loja02">
                            </a>
                        </li>
                                            <li>
                            <a href="ofertas.php?q=loja03" title="loja03">
                                <img src="assets/lojas/loja03.png" alt="Cupom de desconto e Ofertas loja03" class="img-responsive" title="Cupom de desconto e Ofertas loja03">
                            </a>
                        </li>
                                            <li>
                            <a href="ofertas.php?q=loja04" title="loja04">
                                <img src="assets/lojas/loja04.png" alt="Cupom de desconto e Ofertas loja04" class="img-responsive" title="Cupom de desconto e Ofertas loja04">
                            </a>
                        </li>
                                            <li>
                            <a href="ofertas.php?q=loja05" title="loja05">
                                <img src="assets/lojas/loja05.png" alt="Cupom de desconto e Ofertas loja05" class="img-responsive" title="Cupom de desconto e Ofertas loja05">
                            </a>
                        </li>
                                            <li>
                            <a href="ofertas.php?q=loja06" title="loja06">
                                <img src="assets/lojas/loja06.png" alt="Cupom de desconto e Ofertas loja06" class="img-responsive" title="Cupom de desconto e Ofertas loja06">
                            </a>
                        </li>
                                            <li>
                            <a href="ofertas.php?q=loja07" title="loja07">
                                <img src="assets/lojas/loja07.png" alt="Cupom de desconto e Ofertas loja07" class="img-responsive" title="Cupom de desconto e Ofertas loja07">
                            </a>
                        </li>
                                            <li>
                            <a href="ofertas.php?q=loja08" title="loja08">
                                <img src="assets/lojas/loja08.png" alt="Cupom de desconto e Ofertas loja08" class="img-responsive" title="Cupom de desconto e Ofertas loja08">
                            </a>
                        </li>
                                            <li>
                            <a href="ofertas.php?q=loja09" title="loja09">
                                <img src="assets/lojas/loja09.png" alt="Cupom de desconto e Ofertas loja09" class="img-responsive" title="Cupom de desconto e Ofertas loja09">
                            </a>
                        </li>
                                            <li>
                            <a href="ofertas.php?q=loja10" title="Drogaria loja10">
                                <img src="assets/lojas/loja10.png" alt="Cupom de desconto e Ofertas Drogaria loja10" class="img-responsive" title="Cupom de desconto e Ofertas Drogaria loja10">
                            </a>
                        </li>
                                            <li>
                            <a href="ofertas.php?q=loja11" title="loja11">
                                <img src="assets/lojas/loja11.png" alt="Cupom de desconto e Ofertas loja11" class="img-responsive" title="Cupom de desconto e Ofertas loja11">
                            </a>
                        </li>
                                            <li>
                            <a href="ofertas.php?q=loja12" title="loja12">
                                <img src="assets/lojas/loja12.png" alt="Cupom de desconto e Ofertas loja12" class="img-responsive" title="Cupom de desconto e Ofertas loja12">
                            </a>
                        </li>
                                            <li>
                            <a href="ofertas.php?q=loja13" title="loja13">
                                <img src="assets/lojas/loja13.png" alt="Cupom de desconto e Ofertas loja13" class="img-responsive" title="Cupom de desconto e Ofertas loja13">
                            </a>
                        </li>
                                            <li>
                            <a href="ofertas.php?q=loja14" title="loja14">
                                <img src="assets/lojas/loja14.png" alt="Cupom de desconto e Ofertas loja14" class="img-responsive" title="Cupom de desconto e Ofertas loja14">
                            </a>
                        </li>
                                            <li>
                            <a href="ofertas.php?q=loja15" title="loja15">
                                <img src="assets/lojas/loja15.png" alt="Cupom de desconto e Ofertas loja15" class="img-responsive" title="Cupom de desconto e Ofertas loja15">
                            </a>
                        </li>
                                            <li>
                            <a href="ofertas.php?q=loja16" title="loja16">
                                <img src="assets/lojas/loja16.png" alt="Cupom de desconto e Ofertas loja16" class="img-responsive" title="Cupom de desconto e Ofertas loja16">
                            </a>
                        </li>
                                            <li>
                            <a href="ofertas.php?q=loja17" title="loja17">
                                <img src="assets/lojas/loja17.png" alt="Cupom de desconto e Ofertas loja17" class="img-responsive" title="Cupom de desconto e Ofertas loja17">
                            </a>
                        </li>
                                            <li>
                            <a href="ofertas.php?q=loja18" title="loja18">
                                <img src="assets/lojas/loja18.png" alt="Cupom de desconto e Ofertas loja18" class="img-responsive" title="Cupom de desconto e Ofertas loja18">
                            </a>
                        </li>
                                            <li>
                            <a href="ofertas.php?q=loja19" title="loja19">
                                <img src="assets/lojas/loja19.png" alt="Cupom de desconto e Ofertas loja19" class="img-responsive" title="Cupom de desconto e Ofertas loja19">
                            </a>
                        </li>
                                            <li>
                            <a href="ofertas.php?q=loja20" title="Compra loja20">
                                <img src="assets/lojas/loja20.png" alt="Cupom de desconto e Ofertas loja20" class="img-responsive" title="Cupom de desconto e Ofertas loja20">
                            </a>
                        </li>
                                    </ul>
                <div class="text-center">
                    <a href="lojas.php" style="color: #fff" class="btn-primary text-center text-uppercase md-round" title="Ver todas as Lojas">Ver todas as lojas</a>
                </div>
            </div>
        </div>
    </div>
</section>

            <section class="container" style="font-size: 12px;">
    <div class="row">
        <div class="col-md-12">
            <hr>
            <h3>Como usar a <span class="clr"><strong>OFERTA E PROMOÇÃO</strong></span>?</h3>
            <p>Sua Descricao de como usar</p>
            <p>Sua Descricao de como usar</p>
            <p>Sua Descricao de como usar</p>
            <hr>
        </div>
    </div>
</section>


<?php include 'footer.php'; ?>






