<?php

    include "config.php";
    include "valida_user.inc";
    //include "layout.php";
	//$periodopg = $_POST["datai"] . " - " . $_POST["dataf"];
	date_default_timezone_set('America/Sao_Paulo');
	 
    $connect_new = mysqli_connect($Host, $Usuario, $Senha, $Base);

	$opcao = $_GET["op"];
	
	//CADASTRO DO PEDIDO :.
	
if ($opcao == "Salvar") {
		
	if(($_POST["data_entrega"] != "") && ($_POST["hora_entrega"] != "") && ($_POST["cliente"] != "") && ($_POST["telefone"] != "") && ($_POST["atendente"] != "")){ 
		$psQuery = mysqli_query($connect_new, "SELECT * FROM pedidos ORDER BY ped_id DESC");
		$psRow = mysqli_fetch_object($psQuery);
		$pedido_id = $psRow->ped_id;
		$pedido = $pedido_id + 1;
		$data_entrega = $_POST["data_entrega"] . " " . $_POST["hora_entrega"];

		$datatime = date('Y-m-d H:i');
		$status = "Aberto";
		
		//Chamados
		$cQuery = "INSERT INTO pedidos (ped_data, ped_data_entrega, ped_cliente, ped_cliente_tel, ped_atendente, ped_obs, ped_tipo, ped_status)
                 VALUES ('" . $datatime . "',
						 '" . $data_entrega . "',
						 '" . $_POST["cliente"] . "',
						 '" . $_POST["telefone"] . "',
						 '" . $_POST["atendente"] . "',
						 '" . $_POST["obs"] . "',
						 '" . $_POST["tipo"] . "',
                         '" . $status . "')";

		if ( mysqli_query($connect_new, $cQuery) or die(mysqli_error($connect_new)) ) {		
	?>
                <script language="JavaScript">
                <!--
                alert("Pedido Criado com Sucesso!");
                window.location ='pedido_novo.php?id=<?php echo $pedido ?>';
                //-->
                </script>
     <?php
		} else { 
      ?>
                <script language="JavaScript">
                <!--
                alert("*** PROBLEMAS NO CADASTRO - GRAVAR NO BANCO DE DADOS ! *** ");
                window.location = 'pedido_lista.php';
                //-->
                </script>
     <?php
		}
	}else { 
      ?>
         <script language="JavaScript">
         <!--
			alert("*** FAVOR PREENCHER TODOS OS CAMPOS OBRIGATORIOS ANTES DE SALVAR ! *** ");
			window.location = 'pedido_novo.php';
         //-->
         </script>
     <?php
	}
}
	
	if ($opcao == "incluir_itens") {
		
		$quantidade = str_replace(",",".",$_POST["quantidade"]);
		
		
		//Select para testar se o produto consta no banco de dados
		$psQuery = mysqli_query($connect_new,"SELECT pr_desc FROM produto WHERE pr_desc = '" . $_POST["txtProduto"] . "' ORDER BY pr_desc ASC");
		$psRow = mysqli_fetch_object($psQuery);
		
		//Incluindo Itens
		if(isset($psRow->pr_desc)){
			$cQuery = "INSERT INTO pedido_itens (pi_ped_id, pi_pr_desc, pi_pr_quant)
                 VALUES ('" . $_GET["id"] . "',
						 '" . $_POST["txtProduto"] . "',
                         '" . $quantidade . "')";
		}else{
		?>
                <script language="JavaScript">
                <!--
                alert("Nao foi possivel encontrar o produto no cadastro \n Favor efetuar a busca novamente \n Com a descricao correta do produto!");
                window.location ='pedido_novo.php?id=<?php echo $_GET["id"] ?>';
                //-->
                </script>
     <?php	
		}
		if ( mysqli_query($connect_new, $cQuery) or die(mysqli_error($connect_new)) ) {		
	?>
                <script language="JavaScript">
                <!--
                alert("Produto Incluso com Sucesso!");
                window.location ='pedido_novo.php?id=<?php echo $_GET["id"] ?>';
                //-->
                </script>
     <?php
		} else { 
      ?>
                <script language="JavaScript">
                <!--
                alert("*** PROBLEMAS NO CADASTRO - ERRO AO GRAVAR NO BANCO DE DADOS ! *** ");
                window.location = 'pedido_lista.php';
                //-->
                </script>
     <?php
		}
	}
	
if ($opcao == "Alterar") {
	$horario_correto = strpos($_POST["hora_entrega"], ':');
	$data_correta = strpos($_POST["data_entrega"], '/');
	
	if( ($_POST["data_entrega"] != "") && ($_POST["hora_entrega"] != "") && ($horario_correto == 2) && ($data_correta == 2) && ($_POST["cliente"] != "") && ($_POST["telefone"] != "") && ($_POST["atendente"] != "") ){ 
	
		//ALTERACAO DE CADASTRO :.
		$_POST["data_entrega"] = implode('-', array_reverse(explode('/', $_POST["data_entrega"]))); //Mudando o formato da data d/m/y para y-m-d;
		$data_entrega1 = $_POST["data_entrega"] . " " . $_POST["hora_entrega"];
		$data_entrega = date('Y-m-d H:i', strtotime($data_entrega1));

			$cQuery = "UPDATE pedidos SET
				ped_data_entrega = '" . $data_entrega . "',
				ped_cliente = '" . $_POST["cliente"] . "', 
				ped_cliente_tel = '" . $_POST["telefone"] . "',
				ped_obs = '" . $_POST["obs"] . "',
				ped_status = '" . $_POST["status"] . "',
				ped_tipo = '" . $_POST["tipo"] . "',
				ped_atendente  = '" . $_POST["atendente"] . "'
                   WHERE ped_id = " . $_GET["id"];
				   
		if ( mysqli_query($connect_new, $cQuery) ) {
		?>
                <script language="JavaScript">
                <!--
                alert("Alteracao do Cadastro Efetuada com Sucesso!");
                window.location = 'pedido_lista.php';
                //-->
                </script>
         <?php
		} else {
       	 ?>
                <script language="JavaScript">
                <!--
                alert("*** PROBLEMAS A ALTERAR CADASTRO NO BANCO DE DADOS ! *** ENTRAR EM CONTATO COM O ADMINISTRADOR DO SISTEMA!");
                window.location = 'pedido_novo.php?id=<?php echo $_GET["id"] ?>';
                //-->
                </script>
   <?php
		}
		
	}else{		
		?>
                <script language="JavaScript">
                <!--
                alert("FAVOR PREENCHER TODOS OS DADOS CORRETAMENTE \n ANTES DE GRAVAR!");
                window.location = 'pedido_novo.php?id=<?php echo $_GET["id"] ?>';
                //-->
                </script>
         <?php
	}
}
	
	if ($opcao == "excluir_itens") {
		
		$i2Query = mysqli_query($connect_new,"SELECT * FROM pedido_itens
                WHERE pi_id = " . $_GET["id"]);
			$i2Row = mysqli_fetch_object($i2Query);
			$pedido_id = $i2Row->pi_ped_id;
	 
		$iQuery = "DELETE FROM pedido_itens
                WHERE pi_id = " . $_GET["id"]; 
   
			if (mysqli_query($connect_new, $iQuery)) {
			?>
                <script language="JavaScript">
                <!--
                alert("Item Excluido com Sucesso!");
				window.location ='pedido_novo.php?id=<?php echo $pedido_id ?>';
                //-->
                </script>
         	<?php
			mysqli_close($connect_new);
			} else {
       	 	?>
                <script language="JavaScript">
                <!--
                alert("*** PROBLEMAS AO EXCLUIR O CADASTRO NO BANCO DE DADOS ! *** ENTRAR EM CONTATO COM O ADMINISTRADOR DO SISTEMA!");
                window.location = 'pedido_novo.php';
                //-->
                </script>
   			<?php
			}
		
		}
	
		if ($opcao == "excluir") {
	
		$pQuery = "DELETE FROM pedidos
                WHERE ped_id = " . $_GET["id"];  
		$iQuery = "DELETE FROM pedido_itens
                WHERE pi_ped_id = " . $_GET["id"]; 
   
			if ((mysqli_query($connect_new, $pQuery)) && (mysqli_query($connect_new, $iQuery)) ) {
			?>
                <script language="JavaScript">
                <!--
                alert("Pedido Excluido com Sucesso!");
                window.location = 'pedido_lista.php';
                //-->
                </script>
         	<?php
			mysqli_close($connect_new);
			} else {
       	 	?>
                <script language="JavaScript">
                <!--
                alert("*** PROBLEMAS AO EXCLUIR O CADASTRO NO BANCO DE DADOS ! *** ENTRAR EM CONTATO COM O ADMINISTRADOR DO SISTEMA!");
                window.location = 'pedido_lista.php';
                //-->
                </script>
   			<?php
			}
		
		}

?>


