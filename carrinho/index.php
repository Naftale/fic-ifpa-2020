<?php 
session_start();
$connect = mysqli_connect("localhost", "root", "", "ifpa_naftale");

if(isset($_POST["add_to_cart"]))
{
	if(isset($_SESSION["shopping_cart"]))
	{
		$item_array_id = array_column($_SESSION["shopping_cart"], "item_id");
		if(!in_array($_GET["id"], $item_array_id))
		{
			$count = count($_SESSION["shopping_cart"]);
			$item_array = array(
				'item_id'			=>	$_GET["id"],
				'item_nome'			=>	$_POST["hidden_nome"],
				'item_preco'		=>	$_POST["hidden_preco"],
				'item_quantidade'		=>	$_POST["quantidade"]
			);
			$_SESSION["shopping_cart"][$count] = $item_array;
		}
		else
		{
			echo '<script>alert("Item já adicionado ao Carrinho!")</script>';
		}
	}
	else
	{
		$item_array = array(
			'item_id'			=>	$_GET["id"],
			'item_nome'			=>	$_POST["hidden_nome"],
			'item_preco'		=>	$_POST["hidden_preco"],
			'item_quantidade'		=>	$_POST["quantidade"]
		);
		$_SESSION["shopping_cart"][0] = $item_array;
	}
}

if(isset($_GET["action"]))
{
	if($_GET["action"] == "delete")
	{
		foreach($_SESSION["shopping_cart"] as $keys => $values)
		{
			if($values["item_id"] == $_GET["id"])
			{
				unset($_SESSION["shopping_cart"][$keys]);
				echo '<script>alert("Item Removido com sucesso!")</script>';
				echo '<script>window.location="index.php"</script>';
			}
		}
	}
}

?>
<!DOCTYPE html>
<html>
	<head>
		<title>IFPA - FIC - Projeto Final Naftale Israel</title>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" href="../css/estilo.css">
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
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
          <a class="navbar-brand" href="index.php">IFPA - FIC</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
          <ul class="nav navbar-nav">
            <li class=""><a href="../">Home</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Categorias <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="#">Laptops</a></li>
                <li><a href="#">Desktops</a></li>
                <li><a href="#">Impressoras</a></li>
              </ul>
            </li>
			<li class="active"><a href="index.php">Carrinho <span class="sr-only">(current)</span></a></li>
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
			<h4 align="center">Carrinho de Compras</h4>
			<?php
				$query = "SELECT * FROM produtos ORDER BY id ASC";
				$result = mysqli_query($connect, $query);
				if(mysqli_num_rows($result) > 0)
				{
					while($row = mysqli_fetch_array($result))
					{
				?>
			<div class="col-md-4">
				<form method="post" action="index.php?action=add&id=<?php echo $row["id"]; ?>">
					<div style="border:1px solid #333; background-color:#fff; border-radius:5px; padding:16px;" align="center">
						<img src="images/<?php echo $row["image"]; ?>" class="img-responsive" /><br />

						<h4 class="text-info"><?php echo $row["nome"]; ?></h4>

						<h4 class="text-danger">R$ <?php echo $row["preco"]; ?></h4>

						<input type="text" name="quantidade" value="1" class="form-control" />

						<input type="hidden" name="hidden_nome" value="<?php echo $row["nome"]; ?>" />

						<input type="hidden" name="hidden_preco" value="<?php echo $row["preco"]; ?>" />

						<input type="submit" name="add_to_cart" style="margin-top:5px;" class="btn btn-success" value="Adicionar" />

					</div><br/>
				</form>
			</div>
			<?php
					}
				}
			?>
			<div style="clear:both"></div>
			<br />
			<h3>Detalhes do Carrinho</h3>
			<div class="table-responsive">
				<table class="table table-bordered">
					<tr>
						<th width="40%">Item</th>
						<th width="5%">Quant.</th>
						<th width="20%">Preço</th>
						<th width="15%">Total</th>
						<th width="5%">Ação</th>
					</tr>
					<?php
					if(!empty($_SESSION["shopping_cart"]))
					{
						$total = 0;
						foreach($_SESSION["shopping_cart"] as $keys => $values)
						{
					?>
					<tr>
						<td><?php echo $values["item_nome"]; ?></td>
						<td><?php echo $values["item_quantidade"]; ?></td>
						<td>R$ <?php echo $values["item_preco"]; ?></td>
						<td>R$ <?php echo number_format($values["item_quantidade"] * $values["item_preco"], 2);?></td>
						<td><a href="index.php?action=delete&id=<?php echo $values["item_id"]; ?>"><span class="text-danger">Remover</span></a></td>
					</tr>
					<?php
							$total = $total + ($values["item_quantidade"] * $values["item_preco"]);
						}
					?>
					<tr>
						<td colspan="3" align="right">Total</td>
						<td align="right">R$ <?php echo number_format($total, 2); ?></td>
						<td><a class="btn btn-success" href="#">Finalizar</a></td>
					</tr>
					<?php
					}
					?>
						
				</table>
			</div>
		</div>
	</div>
	<br />

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
	</body>
</html>

<?php
//If you have use Older PHP Version, Please Uncomment this function for removing error 

/*function array_column($array, $column_name)
{
	$output = array();
	foreach($array as $keys => $values)
	{
		$output[] = $values[$column_name];
	}
	return $output;
}*/
?>