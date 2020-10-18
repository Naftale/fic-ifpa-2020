<?php
	session_start();
	$nome_produto = $_POST['nome_produto'];
	$estoque = $_POST['estoque'];
	$preco = $_POST['preco'];
	$descricao = $_POST['descricao'];
	$imgbd = $_FILES['arquivo']['name'];
	$con = mysqli_connect("localhost", "root", "", "ifpa_naftale");
	$sql = "INSERT INTO produtos(id,nome,estoque,preco,descricao,image) VALUES 
    (NULL, '$nome_produto','$estoque', '$preco','$descricao', '$imgbd')";
    mysqli_query($con, $sql);

	$altura = "152";
	$largura = "152";
	switch($_FILES['arquivo']['type']):
		case 'image/jpeg';
		case 'image/pjpeg';
			$imagem_temporaria = imagecreatefromjpeg($_FILES['arquivo']['tmp_name']);
			
			$largura_original = imagesx($imagem_temporaria);
			
			$altura_original = imagesy($imagem_temporaria);
			
			$nova_largura = $largura ? $largura : floor (($largura_original / $altura_original) * $altura);
			
			$nova_altura = $altura ? $altura : floor (($altura_original / $largura_original) * $largura);
			
			$imagem_redimensionada = imagecreatetruecolor($nova_largura, $nova_altura);
			imagecopyresampled($imagem_redimensionada, $imagem_temporaria, 0, 0, 0, 0, $nova_largura, $nova_altura, $largura_original, $altura_original);

			
			imagejpeg($imagem_redimensionada, 'carrinho/images/' . $_FILES['arquivo']['name']);

			//echo "<p align='center'><img class='img-circle' src='carrinho/images".$_FILES['arquivo']['name']."' width='152' height='152'>";
			//echo "<br/>Nome do Produto: $nome_produto<br/>
			//	  Estoque: $estoque<br/>
			//	  Preço: $preco<br/>
			//	  Descrição: $descricao<br/>
			//";
			
			//echo "Produto cadastrado com sucesso!<br/>";
			
			$_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Produto cadastrado com sucesso! <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
    <span aria-hidden='true'>&times;</span></button></div>";
			header('Location: admin.php');
			
		break;
		
		//Caso a imagem seja extensão PNG cai nesse CASE
		case 'image/png':
		case 'image/x-png';
			$imagem_temporaria = imagecreatefrompng($_FILES['arquivo']['tmp_name']);
			
			$largura_original = imagesx($imagem_temporaria);
			$altura_original = imagesy($imagem_temporaria);
			
			/* Configura a nova largura */
			$nova_largura = $largura ? $largura : floor(( $largura_original / $altura_original ) * $altura);

			/* Configura a nova altura */
			$nova_altura = $altura ? $altura : floor(( $altura_original / $largura_original ) * $largura);
			
			/* Retorna a nova imagem criada */
			$imagem_redimensionada = imagecreatetruecolor($nova_largura, $nova_altura);
			
			/* Copia a nova imagem da imagem antiga com o tamanho correto */
			//imagealphablending($imagem_redimensionada, false);
			//imagesavealpha($imagem_redimensionada, true);

			imagecopyresampled($imagem_redimensionada, $imagem_temporaria, 0, 0, 0, 0, $nova_largura, $nova_altura, $largura_original, $altura_original);
			
			//função imagejpeg que envia para o browser a imagem armazenada no parâmetro passado
			imagepng($imagem_redimensionada, '../assets/img/perfil/' . $_FILES['arquivo']['name']);

			echo "<p align='center'><img class='img-circle' src='../assets/img/perfil/".$_FILES['arquivo']['name']."' width='150' height='150'>";
			echo "<br/>Categoria: $nome_produto<br/>
				  Nome: $nome<br/>
				  Telefone: $telefone<br/>
				  Whatsapp: $whatsapp<br/>
				  Endereço: $endereco<br/>
				  Descrição: $descricao<br/></p>
			";
			
			echo "Perfil cadastrado com sucesso!<br/>";

		break;
	endswitch;
?>