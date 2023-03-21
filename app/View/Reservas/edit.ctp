<?php 

    $this->extend('/Reservas/formReserva');

    $this->assign('title', 'Cadastrar Reserva');

    $formFields =  $this->Form->create('Reservas', array(
        'class' => 'form-row my-3',
    )) .

    $this->Form->hidden('Reserva.id');

    $this->assign('formFields', $formFields);

?>