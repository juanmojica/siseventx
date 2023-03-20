<?php

    if (!isset($disabled)) {
        $disabled = false;
    }

    $this->extend('/Common/form');

    $title = $this->fetch('title');

    $this->assign('title', $title);

    $formFields = $this->fetch('formFields') .
    
    $this->Html->tag('hr', '', array(
        'class' => 'col-md-12'
    )) . 

    $this->Form->input('Estrutura.nome', array(
        'label' => array('text' => 'Nome', 'class' => 'control-label mt-2 mb-0'),
        'div' => array('class' => 'col-md-8'),
        'class' => 'form-control',
        'required' => true,
        'disabled' => $disabled
    )) . 
    $this->Form->input('Estrutura.tipo', array(
        'type' => 'select', 
        'label' => array('text' => 'Tipo', 'class' => 'control-label col-md-2 mt-2 mb-0 pl-0'),
        'options' => array('BASICO' => 'BÁSICO', 'ADICIONAL' => 'ADICIONAL'),
        'div' => array('class' => 'col-md-2'),
        'class' => 'form-control',
        'required' => true,
        'disabled' => $disabled
    )) . 
    $this->Form->input('Estrutura.valor', array(
        'label' => array('text' => 'Valor', 'class' => 'control-label mt-2 mb-0'),
        'div' => array('class' => 'col-md-2 '),
        'type' => 'text',
        'class' => 'form-control valor',
        'required' => true,
        'disabled' => $disabled,
        'placeholder' => 'R$'
    )) .  
    $this->Html->tag('hr', '', array(
        'class' => 'col-md-12'
    ));

    $this->assign('formFields', $formFields);
?>


