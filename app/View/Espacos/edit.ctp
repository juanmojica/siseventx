<?php 

    $this->extend('/Espacos/formEspaco');

    $this->assign('title', 'Editar Espaço');

    $formFields =  $this->Form->create('Espaco', array(
        'class' => 'form-row my-3',
    )) .
    
    $this->Form->hidden('Espaco.id') .
    $this->Form->hidden('Endereco.id');

    $this->assign('formFields', $formFields);

?>
