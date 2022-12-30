
<html>
    
<?php
	ini_set('default_charset', 'UTF-8');
	include "valida_user.inc";
	include "header.php";
	include "config.php";
	date_default_timezone_set('America/Sao_Paulo');
	$datatime = date('Y-m-d H:i');

?>
<script language="JavaScript">
	function pedido(tipo){
        window.location = 'pedido_novo.php?tipo='+tipo;
    }
	function pedido_fixo(tipo){
        window.location = 'pedido_fixo.php?tipo='+tipo;
    }
	
	function voltar(){
        window.location = 'window.history.back()';
    }
</script>

      <div class="jumbotron" align="center">
        <b><h3>Altere o Status do Pedido, Em qual situação está? </b><br/><br/>
	<?php
		if(isset($_GET["fixo"])){
	?>
        <button type="button" onclick="pedido_fixo('Produzindo')" class="btn btn-lg btn-primary">Produzindo</button><br/><br/>
        <button type="button" onclick="pedido_fixo('Pronto')"class="btn btn-lg btn-warning">Pronto para Entrega</button><br/><br/>
        <button type="button" onclick="pedido_fixo('Entregue')"class="btn btn-lg btn-success">Entregue</button><br/><br/>
        <button type="button" onclick="pedido_fixo('Entregue')"class="btn btn-lg btn-danger">Cancelado</button>
    <?php
		}else{
	?> 
        <button type="button" onclick="pedido('Produzindo')" class="btn btn-lg btn-primary">Produzindo</button><br/><br/>
        <button type="button" onclick="pedido('Pronto')"class="btn btn-lg btn-warning">Pronto para Entrega</button><br/><br/>
        <button type="button" onclick="pedido('Entregue')"class="btn btn-lg btn-success">Entregue</button><br/><br/>
        <button type="button" onclick="pedido('Entregue')"class="btn btn-lg btn-danger">Cancelado</button>
	<?php
		}
	?>   
	  </div>

<?php
	include "footer.php";
?>

</html>