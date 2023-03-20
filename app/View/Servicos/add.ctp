<?php 

    $this->extend('/Servicos/formServico');

    $this->assign('title', 'Cadastrar Serviço');

    $formFields =  $this->Form->create('Servicos', array(
        'class' => 'form-row my-3',
    )); 

    $this->assign('formFields', $formFields);

?>
