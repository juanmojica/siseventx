<?php 

    $this->extend('/Reservas/formReserva');

    $this->assign('title', 'Cadastrar Reserva');

    $formFields =  $this->Form->create('Reservas', array(
        'class' => 'form-row my-3',
    )); 

    $this->assign('formFields', $formFields);

?>
