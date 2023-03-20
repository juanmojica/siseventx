<?php 

    $this->extend('/Estruturas/formEstrutura');

    $this->assign('title', 'Cadastrar Estrutura');

    $formFields =  $this->Form->create('Estruturas', array(
        'class' => 'form-row my-3',
    )); 

    $this->assign('formFields', $formFields);

?>
