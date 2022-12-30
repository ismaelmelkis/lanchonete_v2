
<html>
<?php
ini_set('default_charset', 'UTF-8');
	include "valida_user.inc";
	include "header.php";
	include "config.php";
	include "include/mobile.php";
	//include "include/mascara_kg.js";
	include "include/change_color.php";  // o script do lado é responsável pela troca das cores na tabela de listagem.
	date_default_timezone_set('America/Sao_Paulo');
	$datatime = date('Y-m-d H:i');
	$data_now = date('Y-m-d');
	$x=0;
	
	$connect_new = mysqli_connect($Host, $Usuario, $Senha, $Base);
		
		//Pedidos
		$pQuery = mysqli_query($connect_new, "SELECT * FROM pedidos WHERE ped_status != 'Cancelada' ORDER BY ped_data_entrega DESC LIMIT 50");
	
?>
<script language="JavaScript">
	function visualizar(id){
        window.location = 'pedido_novo.php?id='+id;
    }
	function avaliar(id){
        window.location = 'avaliacao.php?id='+id;
    }
	function AlteraStatus(id){
        window.location = 'pedido_status.php?id='+id;
    }
</script>
     
		<div class="panel panel-primary">
            <div class="panel-heading">
              <h3 class="panel-title">Encomendas . . .</h3>
            </div>
            <div class="panel-body">
              <table class="table">
            <thead>
              <tr style="font-size: 14;" id="exemplo">
				<th>
                </th>
				<?php if($mobile == 0) echo "<th>Pedido</th>"; ?>
				<th>Cliente</th>
				<?php if($mobile == 0) echo "<th>Data/HS Entrega</th>"; ?>
				<th>Tempo Restante</th>
				<th>Status</th>
              </tr>
            </thead>
            
             
    <?php
       while ($pRow = mysqli_fetch_object($pQuery)) {
		   $x=$x+1;			
			
			$cliente = $pRow->ped_cliente;	
			$data_hs_entrega = date('d/m/Y - H:i a', strtotime($pRow->ped_data_entrega));
			$status = $pRow->ped_status;
		
			//Calculando Dias
			$hojez = date("Y-m-d");
			$dataz = date('Y-m-d', strtotime($pRow->ped_data_entrega));;
			$dif = strtotime($dataz) - strtotime($hojez);
			$dias = ($dif / 86400);
			
			//Calculando Minutos
			$agoraz = date("H:i:s");
			$minutosz = date('H:i:s', strtotime($pRow->ped_data_entrega));;
			$dif = strtotime($minutosz) - strtotime($agoraz);
			$min = ($dif / 60);
			$hs = ($dif / 3600);
			$minutos = round($min, 0); //Arredondando
			$horas = round($hs, 0);
			
			$msg = 0;
			$class = 0;
			$id = 0;
			$cor_chamado = "blue";
			
			if (($dias>0) || ($minutos >= 60)){
				//$msg = "Pedido: " . $id . " - Entrega: " . $data_hs_entrega . "  <strong> Tempo: Aproximadamente " . $dias . " dias e " . $horas . "hs</strong>";
				$msg = "Aprox " . $dias . " dias e " . $horas . " hs";
				$cor_chamado = "#337AB7";
			}
			if (($minutos <= 59) && ($dias == 0)){
				//$msg = "Pedido: " . $id . " - Entrega: " . $data_hs_entrega . "  <strong> Tempo Restante: " . $minutos . " min - Menos de 1 hora </strong>";
				$msg = "FALTA MENOS DE 1 HS, APENAS " . $minutos . " min";
				$cor_chamado = "#F6951D";
			}
			if (($minutos <= 30) && ($dias == 0)){
				//$msg = "Pedido: " . $id . " - Entrega: " . $data_hs_entrega . "  <strong> Tempo Restante: " . $minutos . " min - Menos de meia hora </strong>";
				$msg = "RESTAM APENAS " . $minutos . " min";
				$cor_chamado = "red";
			}
			if (($dias < 0) || ($dias == 0) && ($minutos <= 0) ){
				//$msg = "Pedido: " . $id . " - Entrega: " . $data_hs_entrega . "  <strong> O TEMPO PARA ENTREGA ACABOU</strong> " . $minutos . " Minutos";
				$msg = "O TEMPO ACABOU a " . $minutos . " min";
				$status = "<u>NAO FOI ENTREGUE</u>";
				$cor_chamado = "#9B0000";
			}
			if ($pRow->ped_status == "Entregue"){
				//$msg = "Pedido: " . $id . " - Entrega: " . $data_hs_entrega . "  <strong>A ENCOMENDA FOI ENTREGUE</strong>";
				$msg = "JA FOI ENTREGUE";
				$status = "ENTREGUE";
				$cor_chamado = "#00BB27";
			}
			if ($status == "Cancelada"){
				//$msg = "Pedido: " . $id . " - Entrega: " . $data_hs_entrega . "  <strong> ..PEDIDO CANCELADO ..</strong>";
				$class = "alert alert-default";
			}
	?>
		<tbody onload="document.getElementById('itens<?php echo $x ?>').style.display='none'">
	         <tr ONMOUSEOVER="move_i(this)" ONMOUSEOUT="move_o(this)" style="font-size: 12; color: <?php echo $cor_chamado ?>;" onClick="AlteraStatus(<?php echo $pRow->ped_id ?>)">
				<th width="50" height="50">
					<button type="button" alt="Editar Registro" onClick="visualizar('<?php echo  $pRow->ped_id ?>')" class="btn btn-xs btn-warning">E</button>
				
					<button type="button" id="btnmais<?php echo $x ?>" class="btn btn-xs btn-primary" 
					onClick="document.getElementById('itens<?php echo $x ?>').style.display=''; document.getElementById('btnmais<?php echo $x ?>').style.display='none'; document.getElementById('btnmenos<?php echo $x ?>').style.display='block';" >
						+
					</button>
					<button style="display:none" id="btnmenos<?php echo $x ?>" type="button" class="btn btn-xs btn-primary" 
					onClick="document.getElementById('itens<?php echo $x ?>').style.display='none'; document.getElementById('btnmenos<?php echo $x ?>').style.display='none'; document.getElementById('btnmais<?php echo $x ?>').style.display='block';" >
						-
					</button>
				</th>
				<?php if ($mobile == 0) echo "<th>" . $pRow->ped_id . "</th>" ?>
				<th><?php echo $pRow->ped_cliente ?></th>
                <?php if ($mobile == 0) echo "<th>" . date('d/m/Y - H:i:s', strtotime($pRow->ped_data_entrega)) . "</th>"; ?>
				<th>
					<?php
						echo $msg;
					?>
				</th>
				<th><?php echo $status ?></th>
			  </tr>
			<tbody id="itens<?php echo $x ?>" style="font-size:12; display:none; color: <?php echo $cor_chamado ?>;">
			  <!--   Itens    style="font-size: 12; color: <?php //echo $cor_chamado ?>; background: #DBDBDB;" -->
			  
	<?php 
		//Itens
		$iSelect =  "SELECT *
				FROM pedido_itens
				WHERE pi_ped_id = ". $pRow->ped_id;
		if($iQuery = mysqli_query($connect_new, $iSelect) ){
			
			while ($iRow = mysqli_fetch_object($iQuery) ){
					$desc = $iRow->pi_pr_desc;
					$quant = $iRow->pi_pr_quant;
		?>			
			  <tr>
				<th></th>
				<?php if ($mobile == 0) echo "<th></th>" ?>
				<th><?php echo "<u> " . $desc . "</u>"?></th>
				<th><?php echo "<u> Qt: " . $quant  . "</u>" ?></th>
				<?php if ($mobile == 0) echo "<th></th>" ?>
				<th></th>
			  </tr>
	<?php
			} //Fecha If 
		} //de Itens
	?>
		</tbody>
	</tbody>
	<?php
	}
    ?>            
            
          </table>
            </div>
        </div>

<?php
	include "footer.php";
?>

</html>