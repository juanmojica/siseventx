<?php 

    $this->extend('/Servicos/formServico');

    $this->assign('title', 'Editar Serviço');

    $formFields =  $this->Form->create('Servicos', array(
        'class' => 'form-row my-3',
    )) .
    
    $this->Form->hidden('Servico.id');

    $this->assign('formFields', $formFields);

?>
