<?php 

    $this->extend('/Espacos/formEspaco');

    $this->assign('title', 'Visualizar Detalhes do Espaço');

    $formFields =  $this->Form->create('Espaco', array(
        'class' => 'form-row my-3',
    )); 

    $this->assign('formFields', $formFields);

?>