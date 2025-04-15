<header id="header">
                <div class="header-top">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                        </div>
                    </div>
                </div>
            </div>

            <div class="header-top">
                <div class="container text-center">
                    <div class="row">
                        <div class="col-md-12">
                            <span class="txt">
                                As melhores ofertas e promoções das maiores lojas do Brasil em um só lugar! Ofertas Atualizada diariamente!
                            </span>
                        </div>
                    </div>
                </div>
            </div>
    
    <div class="header-holder container">
        <div class="row">
            <div class="col-sm-4 text-center">
                <a href="/">
                    <div class="logo">
                        <img src="assets/img/logo.png" alt="seusite" class="img-responsive" Title="Página Inicial">
                    </div>
                </a>
            </div>
            <div class="col-sm-8 hidden-xs">
                <div class="search-cart" style="padding: 0 20px;">
                <form id="search-form" class="search-form" method="GET" action="ofertas.php">
    <fieldset>
        <input type="search" name="q" class="form-control" placeholder="Buscar por loja ou produto..." aria-label="Pesquisar" value="<?php echo isset($_GET['q']) ? htmlspecialchars($_GET['q']) : ''; ?>" required>
        <button type="submit" class="sub-btn" aria-label="Pesquisar"><i class="icon-search"></i></button>
    </fieldset>
</form>
                   
                </div>
            </div>
        </div>
    </div>
    <div class="nav-holder">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="col-xs-9 visible-xs">
                    <div class="search-cart" style="padding: 0px 2px;margin: 2px;">
                        <form class="search-form" method="GET" action="ofertas.php">
                            <fieldset>
                                <input type="search" name="q" class="form-control" placeholder="Buscar por loja ou produto..." aria-label="Pesquisar" required style="background: #fff;width: 87%;" />
                                <button type="submit" class="sub-btn" aria-label="Pesquisar"><i class="icon-search"></i></button>
                                <div id="loadingMessage" style="display: none;">Aguarde um Momento...</div>
                            </fieldset>
                        </form>
                    </div>
                </div>
                    <div class="col-sm-12 col-xs-3">
                        <a href="#" class="nav-opener text-center hidden visible-sm visible-xs pull-right" style="padding: 5px 20px;" aria-label="Menu"><i class="fa fa-bars"></i></a>
                        <nav id="nav" style="width: 100%;">
                            <ul class="list-unstyled">
                                <li><a href="/" title="Inicio">Inicio</a></li> 
                                <li><a href="cupons.php" title="Cupons de Desconto">Cupons</a></li> 
                                <li><a href="ofertas.php" title="Ofertas e Promoções">Ofertas</a></li>
                                <li><a href="lojas.php" title="Lojas">Lojas</a></li>                        
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>