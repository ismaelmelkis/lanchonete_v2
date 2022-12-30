<?php include "valida_user.inc"; ?>
<nav class="navbar navbar-fixed-top navbar-inverse">	
	<div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
		  <!--span class="label label-default" style="font-size: 18">ServiceDesk</span-->
          <a class="navbar-brand" href="#">SiPED  :. &nbsp;&nbsp;&nbsp; <?php echo $nome_usuario ?></a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
			<ul class="nav navbar-nav">
				
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Pedidos <span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="pedido_tipo.php">Novo Pedido</a></li>
						<li><a href="pedido_tipo.php?fixo=1">Novo Pedido Fixo</a></li>
						<li><a href="pedido_lista.php">Listar Pedidos</a></li>						
						<li><a href="pedido_pendente.php">Pedidos Pendentes</a></li>
						<li><a href="pedido_busca_rel.php">Relat&oacute;rio</a></li>
					</ul>
				</li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
					Usuarios <span class="caret"></span>
					</a>
					<ul class="dropdown-menu">
					<?php if ($_SESSION["nivel_usuario"]!= "user") {  ?>
						<li><a href="user_novo.php">Cadastrar</a></li>
						<li><a href="user_lista.php">Listar</a></li>
					<?php }else{  ?>
						<li><a href="user_muda_senha.php?id=<?php echo $_SESSION["user_id"] ?>">Muda Senha</a></li>
					<?php } ?>
					</ul>
				</li>
				<li><a href="estatistica_busca.php">Estat&iacute;stica</a></li>	
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Ferramentas <span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="atualizacao.php">Atualiza&ccedil;&atilde;o</a></li>
						<li><a href="tipochamado_lista.php">Backup</a></li>
						<li><a href="acesso_negado.php">Acessos</a></li>
					</ul>
				</li>
				<li><a href="<?php echo "logout.php" ?>">Sair</a></li>
				<?php //if ($_SESSION["nivel_usuario"]== "tecnico"){ ?>
				<!-- i class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Tipo de Chamado <span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="tipochamado_novo.php">Cadastrar</a></li>
						<li><a href="tipochamado_lista.php">Listar</a></li>
					</ul>
				</li>
				<?php //} ?>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">user <span class="caret"></span></a>
					<ul class="dropdown-menu">
			<?php //if ($_SESSION["nivel_usuario"]== "tecnico") {  ?>
						<li><a href="user_novo.php">Cadastrar</a></li>
						<li><a href="user_lista.php">Listar</a></li>
			<?php// }else{  ?>
						<li><a href="user_muda_senha.php?id=<?php //echo $_SESSION["setor_id"] ?>">Muda Senha</a></li>
			<?php //} ?>
					</ul>
				</li>
				<?php //if ($_SESSION["nivel_usuario"]== "tecnico"){ ?>
				<li><a href="estatistica_busca.php">Estat&iacute;stica</a></li>	
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Ferramentas <span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="atualizacao.php">Atualiza&ccedil;&atilde;o</a></li>
						<li><a href="tipochamado_lista.php">Backup</a></li>
						<li><a href="acesso_negado.php">Acessos</a></li>
					</ul>
				</li>
				<?php// } ?>
							
				<li><a href="<?php// echo "logout.php" ?>">Sair</a></li -->
			</ul>
        </div>
      </div>
</nav><!-- /.container --><!-- /.nav-collapse --><!-- /.navbar -->