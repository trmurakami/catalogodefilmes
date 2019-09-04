<?php

    require 'inc/config.php';
    require 'inc/functions.php';

    use Ramsey\Uuid\Uuid;
    use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;

if (isset($_FILES['cover']['name'])) {
    if (($_FILES['cover']['name']!="")) {
        // Where the file is going to be stored
        $target_dir = "covers/";
        $file = $_FILES['cover']['name'];
        $path = pathinfo($file);

        if (!empty($_REQUEST["isbn"])) {
            $filename = $_REQUEST["isbn"];
        } elseif (!empty($_REQUEST["ID"])) {
            $filename = $_REQUEST["ID"];
        } else {
            $filename = $path['filename'];
        }        
        $ext = $path['extension'];
        $temp_name = $_FILES['cover']['tmp_name'];
        $path_filename_ext = $target_dir.$filename.".".$ext;
        
        // Check if file already exists
        if (file_exists($path_filename_ext)) {
            $alert = '<div class="alert alert-danger" role="alert">Desculpe, arquivo já existe.</div>';
        } else {
            move_uploaded_file($temp_name, $path_filename_ext);
            $alert = '<div class="alert alert-success" role="alert">Parabéns! Capa carregada com sucesso.</div>';
        }
    }
}

if (isset($_REQUEST["ID"])) {
    //print_r($_REQUEST);
    $query["doc"]["name"] = $_REQUEST["name"];
    $query["doc"]["workTranslation"] = $_REQUEST["workTranslation"];
    if (!empty($_REQUEST["director"])) {
        $query["doc"]["director"] = explode(";", $_REQUEST["director"]);
    }

    

    $query["doc_as_upsert"] = true;
    //print_r($query);
    $result = Elasticsearch::update($_REQUEST["ID"], $query);
    //print_r($result);
    sleep(2); 
    header('Location: node.php?_id='.$_REQUEST["ID"].'');
} else {
    $uuid4 = Uuid::uuid4();
    $uuid = $uuid4->toString();
}


/* Define variables */
if (isset($_REQUEST["_id"])) {
    $uuid = $_REQUEST["_id"];
    $elasticsearch = new Elasticsearch();
    $cursor = $elasticsearch->get($_REQUEST["_id"], null);
    //print_r($cursor);

    if (isset($cursor["_source"]["name"])) {
        $nameValue = $cursor["_source"]["name"];
    } else {
        $nameValue = "";
    }

    if (isset($cursor["_source"]["workTranslation"])) {
        $workTranslationValue = $cursor["_source"]["workTranslation"];
    } else {
        $workTranslationValue = "";
    }
    
    if (isset($cursor["_source"]["director"])) {
        $directorValue = implode(";", $cursor["_source"]["director"]);
    } else {
        $directorValue = "";
    }     

}

if (!isset($nameValue)) {
    $nameValue = "";
}
if (!isset($workTranslationValue)) {
    $workTranslationValue = "";
}

if (!isset($directorValue)) {
    $directorValue = "";
}

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Tiago Murakami">
    <title>Editor</title>

    <link rel="canonical" href="https://github.com/trmurakami/bibliolight">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

  </head>
  <body>
  <?php include 'inc/navbar.php'; ?>
  <div class="container">
    
    <h1>Editor</h1>

    <?php (isset($alert)? print_r($alert) : print_r("")); ?>

    <form action="editor.php" method="post" enctype="multipart/form-data">
    <div class="form-group row">
      <label for="ID" class="col-sm-2 col-form-label">ID</label>
      <div class="col-sm-10">
        <input type="text" readonly class="form-control-plaintext" id="ID" name="ID" value="<?php echo $uuid; ?>">
      </div>
    </div>
    <div class="form-group row">
      <label for="name" class="col-sm-2 col-form-label">Título original</label>
      <div class="col-sm-10">
          <input type="text" class="form-control" id="name" name="name" placeholder="Insira o título original" value="<?php echo $nameValue; ?>" required>
      </div>
    </div>
    <div class="form-group row">
      <label for="workTranslation" class="col-sm-2 col-form-label">Título nacional</label>
      <div class="col-sm-10">
          <input type="text" class="form-control" id="workTranslation" name="workTranslation" placeholder="Insira o título nacional" value="<?php echo $workTranslationValue; ?>" required>
      </div>
    </div>    
    <div class="form-group row">
      <label for="director" class="col-sm-2 col-form-label">Diretor</label>
      <div class="col-10">
          <input type="text" class="form-control" id="director" name="director" placeholder="Insira o diretor" value="<?php echo $directorValue; ?>" required>
      </div>
    </div> 

    <div class="form-group row">
      <label for="actor" class="col-sm-2 col-form-label">Intérpretes</label>
      <div class="col-sm-10">
          <input type="text" class="form-control" id="actor" name="actor" placeholder="Insira os intérpretes (separados por ponto e vírgula ;)"  value="<?php echo $actorValue; ?>">
      </div>
    </div>

    <div class="form-group row">
      <label for="countryOfOrigin" class="col-sm-2 col-form-label">País de produção</label>
      <div class="col-10">
          <input type="text" class="form-control" id="countryOfOrigin" name="countryOfOrigin" placeholder="Insira o País de produção" value="<?php echo $countryOfOriginValue; ?>">
      </div>
    </div> 
    <div class="form-group row">
      <label for="datePublished" class="col-sm-2 col-form-label">Ano de produção</label>
      <div class="col-10">
          <input type="text" class="form-control" id="datePublished" name="datePublished" placeholder="Insira o ano de produção" pattern="\d\d\d\d" value="<?php echo $datePublishedValue; ?>">
      </div>
    </div>
    <div class="form-group row">
      <label for="inLanguage" class="col-sm-2 col-form-label">Idiomas - Áudio</label>
      <div class="col-10">
          <select multiple class="form-control" id="inLanguage" name="inLanguage">
            <option selected>Escolha os idiomas abaixo</option>
            <option value="Português">Português</option>
            <option value="Inglês">Inglês</option>
            <option value="Espanhol">Espanhol</option>
            <option value="Francês">Francês</option>
            <option value="Indeterminado">Indeterminado</option>
          </select>
      </div>
    </div>
    <div class="form-group row">
      <label for="subtitleLanguage" class="col-sm-2 col-form-label">Idiomas - Legenda</label>
      <div class="col-10">
          <select multiple class="form-control" id="subtitleLanguage" name="subtitleLanguage">
            <option selected>Escolha os idiomas abaixo</option>
            <option value="Português">Português</option>
            <option value="Inglês">Inglês</option>
            <option value="Espanhol">Espanhol</option>
            <option value="Francês">Francês</option>
            <option value="Indeterminado">Indeterminado</option>
          </select>
      </div>
    </div>            
    <div class="form-group row">
      <label for="physicalDescriptions" class="col-sm-2 col-form-label">Descrição física</label>
      <div class="col-10">
          <input type="text" class="form-control" id="physicalDescriptions" name="physicalDescriptions" placeholder="Insira a Descrição física (suporte, duração, cromia)" value="<?php echo $physicalDescriptionsValue; ?>">
      </div>
    </div>    
    <div class="form-group row">
      <label for="keywords" class="col-sm-2 col-form-label">Assuntos</label>
      <div class="col-sm-10">
          <input type="text" class="form-control" id="keywords" name="keywords" placeholder="Insira os assuntos (separados por ponto e vírgula ;)"  value="<?php echo $keywordsValue; ?>">
      </div>
    </div>
    <div class="form-group row">
      <label for="genre" class="col-sm-2 col-form-label">Gênero</label>
      <div class="col-sm-10">
          <input type="text" class="form-control" id="genre" name="genre" placeholder="Insira os gêneros (separados por ponto e vírgula ;)"  value="<?php echo $genreValue; ?>">
      </div>
    </div>    
    <div class="form-group row">
      <label for="about" class="col-sm-2 col-form-label">Resumo</label>
      <div class="col-sm-10">
          <textarea class="form-control" id="about" name="about" placeholder="Insira o resumo" value="<?php echo $aboutValue; ?>" rows="4"></textarea>
      </div>
    </div>                  
    <div class="form-group row">
      <label for="location" class="col-sm-2 col-form-label">Localização</label>
      <div class="col-sm-10">
          <input type="text" class="form-control" id="location" name="location" placeholder="Insira a localização" value="<?php echo $locationValue; ?>">
      </div>
    </div>
    <div class="form-group row">
      <label for="notes" class="col-sm-2 col-form-label">Nota</label>
      <div class="col-sm-10">
          <input type="text" class="form-control" id="notes" name="notes" placeholder="Insira uma nota" value="<?php echo $notesValue; ?>">
      </div>
    </div>
    <div class="custom-file">
        <input type="file" class="custom-file-input" id="customFile" name="cover">
        <label class="custom-file-label" for="customFile">Selecionar arquivo de capa. Somente formato .jpg</label>
    </div> 
    <br/><br/>              
    <button type="submit" class="btn btn-primary">Salvar</button>
    <button class="btn btn-danger" onclick="history.go(-1);">Voltar</button>


    </form>
  </div>

  <script>
    // Add the following code if you want the name of the file appear on select
    $(".custom-file-input").on("change", function() {
    var fileName = $(this).val().split("\\").pop();
    $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });
  </script>

  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script> 
  <script src="https://getbootstrap.com/docs/4.3/assets/js/docs.min.js"></script>

  </body>
</html>