<?php 
session_start();
$connect = mysqli_connect("localhost", "root", "", "ifpa_naftale");
?>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>IFPA - FIC - Naftale Israel</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">

    <link rel="stylesheet" type="text/css" href="css/estilo.css">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <nav class="navbar navbar-default">
      <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="admin.php">IFPA - FIC</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
          <ul class="nav navbar-nav">
            <li class=""><a href="admin.php">Cadastrar Produtos </a></li>
            <li class="active"><a href="listar.php">Listar <span class="sr-only">(current)</span></a></li>

          </ul>
          
          <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Bem vindo! <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="#">Sair</a></li>
                <li role="separator" class="divider"></li>
                <li><a href="#">Contato</a></li>
              </ul>
            </li>
          </ul>
        </div><!-- /.navbar-collapse -->
      </div><!-- /.container-fluid -->
  </nav>

  <div class="container">
      <h3>Projeto Final da Disciplina - ADMINISTRADOR</h3>
      <hr class="hr">
      <h4 align="center">Listagem de produtos:</h4>
      <hr class="hr">
        <div class="row">
              <?php
      if(isset($_SESSION['msg'])){
        echo $_SESSION['msg'];
        unset($_SESSION['msg']);
      }
    ?>
          <div class="container tabela">
          <table id="" class="table">
      <thead>
        <th>ID</th>
        <th>Nome</th>
        <th>Preço</th>
        <th>Estoque</th>
        <th>Ações</th>
      </thead>
      <tbody>
      <?php  
    $con = mysqli_connect("localhost", "root", "", "ifpa_naftale");
    $sql = "SELECT * FROM produtos";
    $result = mysqli_query($con,$sql);
    while($lh = mysqli_fetch_assoc($result)){
      echo "
        
        <tr>
          <td>".utf8_encode($lh['id'])."</td>
          <td>".utf8_encode($lh['nome'])."</td>
          <td>".utf8_encode($lh['preco'])."</td>
          <td>".utf8_encode($lh['estoque'])."</td>
          <td>
          <button type='button' style='margin-top:5px;' class='btn btn-primary' data-toggle='modal' data-target='#myModal".$lh['id']."'>
              Editar
            </button>

            <!-- Modal -->
            <div class='modal fade' id='myModal".$lh['id']."' tabindex='-1' role='dialog' aria-labelledby='TituloModalCentralizado' aria-hidden='true'>
              <div class='modal-dialog modal-dialog-centered' role='document'>
                <div class='modal-content'>
                  <div class='modal-header'>
                    <h5 class='modal-title' id='TituloModalCentralizado'>".$lh['nome']."</h5>
                    <button type='button' class='close' data-dismiss='modal' aria-label='Fechar'>
                      <span aria-hidden='true'>&times;</span>
                    </button>
                  </div>
                  <div class='modal-body'>
                    ".$lh['descricao']."
                  </div>
                  <div class='modal-footer'>
                    <button type='button' class='btn btn-secondary' data-dismiss='modal'>Fechar</button>
                    <button type='button' class='btn btn-primary'>Salvar mudanças</button>
                  </div>
                </div>
              </div>
            </div>
            <a href='excluir.php?id=".$lh['id']."'> Excluir</a>
          </td>

        </tr>
        
      ";
    }
  ?>  
    </tbody>
    </table>           
          </div>
        </div>
  </div>

  <br/>
  <hr/>



    <!--RODAPÉ-->
    <footer class="">
      <div class="container footer">
        <p class="float-right">
        </p>
        <hr/>
        <p align="center">Desenvolvido pelo aluno &copy; Naftale Israel.</p>
        <p align="center">NC/FIC/PW - 05.Projeto de Website - Projeto Final da Disciplina de Projeto de Website.</p>
      </div>
    </footer>


    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" crossorigin="anonymous"></script>
    <!-- JS Bootstrap -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
  </body>
</html>