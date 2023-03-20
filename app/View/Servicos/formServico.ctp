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

    $this->Form->input('Servico.nome', array(
        'label' => array('text' => 'Nome', 'class' => 'control-label mt-2 mb-0'),
        'div' => array('class' => 'col-md-10'),
        'class' => 'form-control',
        'required' => true,
        'disabled' => $disabled
    )) . 
    $this->Form->input('Servico.tipo', array(
        'type' => 'select', 
        'label' => array('text' => 'Tipo', 'class' => 'control-label col-md-2 mt-2 mb-0 pl-0'),
        'options' => array( 'TRADICIONAL' => 'TRADICIONAL', 'PREMIUM' => 'PREMIUM'),
        'div' => array('class' => 'col-md-2'),
        'class' => 'form-control',
        'required' => true,
        'disabled' => $disabled
    )) . 
    $this->Form->input('Servico.quantidade_de_colaboradores', array(
        'label' => array('text' => 'Quantidade de Colaboradores', 'class' => 'control-label mt-2 mb-0'),
        'div' => array('class' => 'col-md-3'),
        'class' => 'form-control',
        'required' => true,
        'disabled' => $disabled
    )) .  
    $this->Form->input('Servico.valor', array(
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


