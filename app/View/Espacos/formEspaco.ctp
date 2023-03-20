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

    $this->Form->input('Espaco.nome', array(
        'label' => array('text' => 'Nome', 'class' => 'control-label mt-2 mb-0'),
        'div' => array('class' => 'col-md-8'),
        'class' => 'form-control',
        'required' => true,
        'disabled' => $disabled
    )) . 
    $this->Form->input('Espaco.telefone', array(
        'label' => array('text' => 'Telefone', 'class' => 'control-label mt-2 mb-0'),
        'div' => array('class' => 'col-md-2'),
        'class' => 'form-control telefone',
        'required' => true,
        'disabled' => $disabled,
        'placeholder' => '(00) 0 0000-0000'
    )) . 
    $this->Form->input('Espaco.limite_participantes', array(
        'label' => array('text' => 'Limite de Participantes', 'class' => 'control-label mt-2 mb-0'),
        'div' => array('class' => 'col-md-2'),
        'class' => 'form-control',
        'required' => true,
        'disabled' => $disabled
    )) . 

    $this->Form->input('Espaco.valor_hora', array(
        'label' => array('text' => 'Valor Hora', 'class' => 'control-label mt-2 mb-0'),
        'div' => array('class' => 'col-md-2 '),
        'type' => 'text',
        'class' => 'form-control valor',
        'required' => true,
        'disabled' => $disabled,
        'placeholder' => 'R$'
    )) . 
    $this->Html->div('col-md-3 ml-5',
        $this->Form->input('Espaco.hora_inicio', array(
            'label' => array('text' => 'Horário Inicial', 'class' => 'control-label col-md-12 mt-2 mb-0 pl-0'),
            'type' => 'time',
            'div' => array('class' => 'col-md-12 p-0'),
            'class' => 'form-control d-inline col-md-3 p-0',
            'required' => true,
            'disabled' => $disabled
        ))
    ) . 
    $this->Html->div('col-md-3 ',
        $this->Form->input('Espaco.hora_fim', array(
            'label' => array('text' => 'Horário Final', 'class' => 'control-label col-md-12 mt-2 mb-0 pl-0'),
            'type' => 'time',
            'div' => array('class' => 'col-md-12 p-0'),
            'class' => 'form-control d-inline col-md-3 p-0',
            'required' => true,
            'disabled' => $disabled
        ))
    ) . 

    $this->Html->tag('hr', '', array(
        'class' => 'col-md-12'
    )) . 
    $this->Html->tag('h5', 'Endereço', array(
        'class' => 'col-md-12 mb-0 pb-0'
    )) . 
    $this->Form->input('Endereco.logradouro', array(
        'label' => array('text' => 'Logradouro', 'class' => 'control-label col-md-6 mt-2 mb-0 pl-0'),
        'type' => 'text',
        'div' => array('class' => 'col-md-6'),
        'class' => 'form-control',
        'required' => true,
        'disabled' => $disabled
    )) . 
    $this->Form->input('Endereco.numero', array(
        'label' => array('text' => 'Número', 'class' => 'control-label col-md-1 mt-2 mb-0 pl-0'),
        'type' => 'text',
        'div' => array('class' => 'col-md-1'),
        'class' => 'form-control',
        'required' => true,
        'disabled' => $disabled
    )) . 
    $this->Form->input('Endereco.bairro', array(
        'label' => array('text' => 'Bairro', 'class' => 'control-label col-md-5 mt-2 mb-0 pl-0'),
        'type' => 'text',
        'div' => array('class' => 'col-md-5'),
        'class' => 'form-control',
        'required' => true,
        'disabled' => $disabled
    )) . 

    $this->Form->input('Endereco.cidade', array(
        'label' => array('text' => 'Cidade', 'class' => 'control-label col-md-5 mt-2 mb-0 pl-0'),
        'type' => 'text',
        'div' => array('class' => 'col-md-5'),
        'class' => 'form-control',
        'required' => true,
        'disabled' => $disabled,
    )) . 
    $this->Form->input('Endereco.estado_id', array(
        'type' => 'select', 
        'label' => array('text' => 'Estado', 'class' => 'control-label col-md-2 mt-2 mb-0 pl-0'),
        'options' => $estados,
        'div' => array('class' => 'col-md-2'),
        'class' => 'form-control',
        'required' => true,
        'disabled' => $disabled,
    )) . 
    $this->Form->input('Endereco.cep', array(
        'label' => array('text' => 'CEP', 'class' => 'control-label 1 mt-2 mb-0 pl-0'),
        'aria-describedby' => 'EnderecoCep',
        'type' => 'text',
        'div' => array('class' => '1'),
        'class' => 'form-control cep',
        'required' => true,
        'disabled' => $disabled,
        'placeholder' => '00000-000'
    )) . 
    $this->Html->tag('small',
        $this->Html->link('Consulte o cep da sua cidade', '/https://buscacepinter.correios.com.br/app/endereco/index.php', array(
        'class' => 'ml-1', 
        'target' => '_blank'
    )), 
        array(
        'id' => 'EnderecoCep',
        'class' => 'form-text text-muted offset-md-7'
        )
    ) . 

    $this->Html->tag('hr', '', array(
        'class' => 'col-md-12'
    ));

    $this->assign('formFields', $formFields);
?>


