<?php

    $controllerName = $this->request->params['controller'];

    $actionName = $this->request->params['action'];

    $form = $this->fetch('formFields');

    if ($actionName != 'view') {

        $btnSalvar = $this->Js->submit(
            'Salvar', 
            array(
                'class' => 'btn btn-sm btn-primary ml-2', 
                'div' => false, 
                'update' => '#content',
                'escape' => false, 
                'evalScripts' => true,
                'before' => $this->Js->get('#busy-indicator')->effect(
                    'fadeIn',
                    
                ),
                'complete' => $this->Js->get('#busy-indicator')->effect(
                    'fadeOut',
                    
                )
            )
        );

    } else {

        $btnSalvar = '';
    }

    $form .= $this->Html->div('col-md-12 text-right mb-5', 
        $this->Js->link(
            $this->Html->tag('i', '', array('class' => 'fa-solid fa-arrow-left')) . ' Voltar', 
            '/' . $controllerName, 
            array(
                'update' => '#content', 
                'escape' => false, 
                'class' => 'btn btn-sm btn-warning text-white',
                'evalScripts' => true,
                'before' => $this->Js->get('#busy-indicator')->effect(
                    'fadeIn',
                ),
                'complete' => $this->Js->get('#busy-indicator')->effect(
                    'fadeOut',
                )
            )
        ) . $btnSalvar
    );

    $form .= $this->Form->end();

    echo $this->Flash->render('danger'); 
    echo $this->Flash->render('success'); 

    echo $this->Html->tag('h2', $this->fetch('title'), array(
        'class' => 'col-md-12'
    ));
    echo $form;

    $this->Js->buffer(
        '$(".form-error").addClass("is-invalid");',
    );

    if ($this->request->is('ajax')) {
        echo $this->Js->writeBuffer();
    }
?>

<style>
    .error-message {
        color: red;
    }
</style>

<script>
    $(document).ready(function() {
        $('.telefone').mask('(00) 0 0000-0000');
        $('.valor_hora').mask('#.##0,00', {reverse: true});
        $('.estado').mask('AA');
        $('.cep').mask('00000-000');
    });
</script>
