<?php
    require 'inc/config.php';
    require 'inc/functions.php';
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="Tiago Murakami">
        <title><?php echo $library_name; ?></title>

        <link rel="canonical" href="https://github.com/trmurakami/catalogodefilmes">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

        <style>
            .bd-placeholder-img {
                font-size: 1.125rem;
                text-anchor: middle;
                -webkit-user-select: none;
                -moz-user-select: none;
                -ms-user-select: none;
                user-select: none;
            }

            @media (min-width: 768px) {
                .bd-placeholder-img-lg {
                font-size: 3.5rem;
                }
            }
        </style>

    </head>
    <body>            

        <?php include 'inc/navbar.php'; ?>

        <div class="px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
            <h1 class="display-4"><?php echo $library_name; ?></h1>
            <p class="lead">Ferramenta de gestão de acervo de filmes <?php echo $library_name; ?>.</p>

            <?php isset($error_connection_message) ? print_r($error_connection_message) : '' ?>

            <div class="container">
                <form action="search.php" method="get">
                    <div class="form-group">
                        <label for="searchHelp">Pesquisar</label>
                        <input type="text" class="form-control" id="search" name="search[]" aria-describedby="searchHelp" placeholder="Digite a expressão de busca">
                        <small id="searchHelp" class="form-text text-muted">Você pode pesquisar por título, autor, editora...</small>
                        <small id="searchHelp" class="form-text text-muted">Para pesquisar por parte de uma palavra, digite a parte com asterisco. Ex.: biblio*</small>
                    </div>
                    <button type="submit" class="btn btn-primary">Pesquisar</button>
                </form>
            </div>
            </div>
            <div class="container">

<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
  <ol class="carousel-indicators">
    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="1" class=""></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="2" class=""></li>
  </ol>
  <div class="carousel-inner">
    <div class="carousel-item active">
      <svg class="bd-placeholder-img bd-placeholder-img-lg d-block w-100" width="800" height="400" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: First slide"><title>Placeholder</title><rect width="100%" height="100%" fill="#777"></rect><text x="50%" y="50%" fill="#555" dy=".3em">First slide</text></svg>
    </div>
    <div class="carousel-item">
      <svg class="bd-placeholder-img bd-placeholder-img-lg d-block w-100" width="800" height="400" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: Second slide"><title>Placeholder</title><rect width="100%" height="100%" fill="#666"></rect><text x="50%" y="50%" fill="#444" dy=".3em">Second slide</text></svg>
    </div>
    <div class="carousel-item">
      <svg class="bd-placeholder-img bd-placeholder-img-lg d-block w-100" width="800" height="400" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: Third slide"><title>Placeholder</title><rect width="100%" height="100%" fill="#555"></rect><text x="50%" y="50%" fill="#333" dy=".3em">Third slide</text></svg>
    </div>
  </div>
  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>




                <footer class="pt-4 my-md-5 pt-md-5 border-top">
                <div class="row">
                    <div class="col-12 col-md">
                        <!-- <img class="mb-2" src="/docs/4.3/assets/brand/bootstrap-solid.svg" alt="" width="24" height="24"> -->
                        <small class="d-block mb-3 text-muted">Desenvolvido com <a target="_blank" rel="noopener noreferrer nofollow" href="https://trmurakami.github.io/Bibliolight">Bibliolight</a></small>
                        <small class="d-block mb-3 text-muted">Você pode <a target="_blank" rel="noopener noreferrer nofollow" href="https://pag.ae/7VbJhhRHP">contribuir com o Bibliolight</a></small>
                    </div>
                    <div class="col-6 col-md">
                        <h5>Estatísticas</h5>
                        <ul class="list-unstyled text-small">
                            <li><a class="text-muted" href="search.php">Quantidade de registros: <?php echo Homepage::numberOfRecords(); ?></a></li>
                            <li><a class="text-muted" href="search.php?search[]=_exists_:circ.name">Quantidade de empréstimos: <?php echo Homepage::numberCirc(); ?></a></li>
                        </ul>
                    </div>                    
                    <div class="col-6 col-md">
                    <h5>Operações</h5>
                        <ul class="list-unstyled text-small">
                            <li><a class="text-muted" href="tools/export.php?format=table">Exportar todos os registros em CSV</a></li>
                            <li><a class="text-muted" href="editor.php">Criar novo registro</a></li>
                        </ul>
                    </div>
                    <!--
                    <div class="col-6 col-md">
                    <h5>About</h5>
                    <ul class="list-unstyled text-small">
                    <li><a class="text-muted" href="#">Team</a></li>
                    <li><a class="text-muted" href="#">Locations</a></li>
                    <li><a class="text-muted" href="#">Privacy</a></li>
                    <li><a class="text-muted" href="#">Terms</a></li>
                    </ul>
                    </div>
                    -->
                </div>
                </footer>
            </div>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>           

    </body>
</html>
