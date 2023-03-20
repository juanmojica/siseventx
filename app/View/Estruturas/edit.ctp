<?php 

    $this->extend('/Estruturas/formEstrutura');

    $this->assign('title', 'Editar Estrutura');

    $formFields =  $this->Form->create('Estruturas', array(
        'class' => 'form-row my-3',
    )) .
    
    $this->Form->hidden('Estrutura.id');

    $this->assign('formFields', $formFields);

?>
