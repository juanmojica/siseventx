<!doctype html>
<html lang="pt">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="author" content="Juan Mojica">

		<title>Sistema EventX</title>

		<?php 
			echo $this->Html->css('bootstrap-grid.min.css'); 
			echo $this->Html->css('bootstrap-reboot.min.css'); 
			echo $this->Html->css('bootstrap.min.css'); 
			echo $this->Html->css('dashboard.css'); 
		?>

	</head>
  	<body>
		<nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
			<?php
				echo $this->Html->link('SisEventX', '/espacos', array('class' => 'navbar-brand col-sm-3 col-md-2 mr-0')) 
			?>
			<div class="col-md-5 text-center">
				<?php
					echo $this->Html->image('loading.gif',array(
						'id' => 'busy-indicator',
						'height' => 30, 
						'width' => 30
					));
				?>
			</div>
			<ul class="navbar-nav px-3">
				<li class="nav-item text-nowrap col-md-2">
					<?php
						echo $this->Html->link(
							$this->Html->tag('i', '', array('class' => 'fa-solid fa-right-from-bracket')) . ' Sair',
							'/espacos', array('escape' => false, 'class' => 'nav-link')
						) 
					?>
				</li>
			</ul>
		</nav>

		<div class="container-fluid">
			<div class="row">

				<nav class="col-md-2 d-none d-md-block bg-light sidebar">
					<div class="sidebar-sticky">
						<ul class="nav flex-column">
							<li class="nav-item">
								<?php 
									echo $this->Js->link(
										$this->Html->tag('i', '', array('class' => 'fa-solid fa-hotel')) . ' Espaços',
										'/espacos', array(
											'update' => '#content', 
											'escape' => false, 
											'class' => 'nav-link',
											'evalScripts' => true,
											'before' => $this->Js->get('#busy-indicator')->effect(
												'fadeIn',
												array('buffer' => false)
											),
											'complete' => $this->Js->get('#busy-indicator')->effect(
												'fadeOut',
												array('buffer' => false)
											)
										)
									) 
								?>
							</li>
							<li class="nav-item">
								<?php 
									echo $this->Js->link(
										$this->Html->tag('i', '', array('class' => 'fa-solid fa-table-list')) . ' Estruturas Adicionais',
										'/espacos', array(
											'update' => '#content', 
											'escape' => false, 
											'class' => 'nav-link',
											'evalScripts' => true,
											'before' => $this->Js->get('#busy-indicator')->effect(
												'fadeIn',
												array('buffer' => false)
											),
											'complete' => $this->Js->get('#busy-indicator')->effect(
												'fadeOut',
												array('buffer' => false)
											)
										)
									) 
								?>
							</li>
							<li class="nav-item">
								<?php 
									echo $this->Js->link( 
										$this->Html->tag('i', '', array('class' => 'fa-solid fa-people-carry-box')) . ' Serviços',
										'/espacos', array(
											'update' => '#content', 
											'escape' => false, 
											'class' => 'nav-link',
											'evalScripts' => true,
											'before' => $this->Js->get('#busy-indicator')->effect(
												'fadeIn',
												array('buffer' => false)
											),
											'complete' => $this->Js->get('#busy-indicator')->effect(
												'fadeOut',
												array('buffer' => false)
											)
										) 
									) 
								?>
							</li>
						</ul>
					</div>
				</nav>

				<main role="main" class="col-9 ml-sm-auto col-lg-10 mr-5">
					<div id="content" class="mb-5 offset-1">
						

						<?php echo $this->Flash->render(); ?>

						<?php echo $this->fetch('content'); ?>

						<?php echo $this->element('sql_dump'); ?> 
						
					</div>
				</main>

				<footer class="footer mt-auto py-3 col-10 offset-2">
					<div class="footer-container text-right">
						&copy; 2023 - Cidade Escola Aprendiz 
					</div>
				</footer>
				
			</div>
		</div>

		
		
		<?php echo $this->Html->script('jquery-3.3.1.min.js'); ?>
		<script src="https://igorescobar.github.io/jQuery-Mask-Plugin/js/jquery.mask.min.js"></script>
		<?php echo $this->Html->script('bootstrap.min.js'); ?>
		<?php echo $this->Html->script('bootstrap.bundle.min.js'); ?>
		<?php echo $this->Js->writeBuffer(); ?>

		<script src="https://kit.fontawesome.com/b9577fc22a.js" crossorigin="anonymous"></script>

	</body>
</html>
