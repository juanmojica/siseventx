<?php

	if ( $this->request->query('erro') != null && $this->request->query('erro') ) {

		echo $this->Html->div('alert alert-danger alert-dismissible fade show mt-2', 
			$this->Flash->render() . 
			$this->Form->button(
				$this->Html->tag('span', '&times;', array('aria-hidden' => "true")),
				array('type' => "button", 'class' => "close", 'data-dismiss' => "alert", 'aria-label' => "Close")
			)
		); 
	}

	$this->Session->flash('Flash.bootstrap');

?>

<div class="jumbotron mt-3">
  <h1>Bem-vindo ao SisEventX</h1>
  <p class="lead">Gerencie as reservas de espaços para os eventos de forma fácil e eficiente.</p>
  <a class="btn btn-primary btn-lg" href="/siseventx/reservas/listarEspacos" role="button">Fazer Reserva</a>
</div>
<div class="row">
  <div class="col-md-6">
    <h2>O que é o SisEvent?</h2>
    <p>O SisEvent é uma aplicação web para gerenciamento de reservas de espaços para eventos. Com o SisEventX, é possível facilmente reservar e gerenciar espaços para eventos, ver disponibilidade de espaços e muito mais.</p>
    <p><a class="btn btn-secondary" href="/" role="button">Saiba mais &raquo;</a></p>
  </div>
  <div class="col-md-6">
    <h2>Por que usar o SisEvent?</h2>
    <p>O SisEvent foi projetado para ser fácil de usar e eficiente, permitindo que você gerencie suas reservas de espaços para eventos de forma mais rápida e simples.</p>
    <p><a class="btn btn-secondary" href="/" role="button">Entre em contato &raquo;</a></p>
  </div>
</div>
