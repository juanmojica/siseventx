<?php 

    echo $this->Flash->render('danger'); 
    echo $this->Flash->render('success'); 

    echo $this->Form->create('Espaco', array(
        'class' => 'form-row my-3',
    ));
    echo $this->Html->tag('h2', 'Editar Espaço', array(
        'class' => 'col-md-12'
    ));
    echo $this->Html->tag('hr', '', array(
        'class' => 'col-md-12'
    ));
    echo $this->Form->hidden('Espaco.id');
    echo $this->Form->input('Espaco.nome', array(
        'label' => array('text' => 'Nome', 'class' => 'control-label mt-2 mb-0'),
        'div' => array('class' => 'col-md-8'),
        'class' => 'form-control',
        'required' => true
    ));
    echo $this->Form->input('Espaco.telefone', array(
        'label' => array('text' => 'Telefone', 'class' => 'control-label mt-2 mb-0'),
        'div' => array('class' => 'col-md-2'),
        'class' => 'form-control telefone',
        'required' => true,
        'placeholder' => '(00) 0 0000-0000'
    ));
    echo $this->Form->input('Espaco.limite_participantes', array(
        'label' => array('text' => 'Limite de Participantes', 'class' => 'control-label mt-2 mb-0'),
        'div' => array('class' => 'col-md-2'),
        'class' => 'form-control',
        'required' => true
    ));
    echo $this->Form->input('Espaco.valor_hora', array(
        'label' => array('text' => 'Valor Hora', 'class' => 'control-label mt-2 mb-0'),
        'div' => array('class' => 'col-md-2 '),
        'type' => 'text',
        'class' => 'form-control valor_hora',
        'required' => true,
        'placeholder' => 'R$'
    ));
    echo $this->Html->div('col-md-3 ml-5',
        $this->Form->input('Espaco.hora_inicio', array(
            'label' => array('text' => 'Horário Inicial', 'class' => 'control-label col-md-12 mt-2 mb-0 pl-0'),
            'type' => 'time',
            'div' => array('class' => 'col-md-12 p-0'),
            'class' => 'form-control d-inline col-md-3 p-0',
            'required' => true
        ))
    );
    echo $this->Html->div('col-md-3 ',
    $this->Form->input('Espaco.hora_fim', array(
        'label' => array('text' => 'Horário Final', 'class' => 'control-label col-md-12 mt-2 mb-0 pl-0'),
        'type' => 'time',
        'div' => array('class' => 'col-md-12 p-0'),
        'class' => 'form-control d-inline col-md-3 p-0',
        'required' => true
        ))
    );
    echo $this->Html->tag('hr', '', array(
        'class' => 'col-md-12'
    ));
    echo $this->Html->tag('h5', 'Endereço', array(
        'class' => 'col-md-12 mb-0 pb-0'
    ));
    echo $this->Form->hidden('Endereco.id');
    echo $this->Form->input('Endereco.logradouro', array(
        'label' => array('text' => 'Logradouro', 'class' => 'control-label col-md-6 mt-2 mb-0 pl-0'),
        'type' => 'text',
        'div' => array('class' => 'col-md-6'),
        'class' => 'form-control',
        'required' => true
    ));
    echo $this->Form->input('Endereco.numero', array(
        'label' => array('text' => 'Número', 'class' => 'control-label col-md-1 mt-2 mb-0 pl-0'),
        'type' => 'text',
        'div' => array('class' => 'col-md-1'),
        'class' => 'form-control',
        'required' => true
    ));
    echo $this->Form->input('Endereco.bairro', array(
        'label' => array('text' => 'Bairro', 'class' => 'control-label col-md-5 mt-2 mb-0 pl-0'),
        'type' => 'text',
        'div' => array('class' => 'col-md-5'),
        'class' => 'form-control',
        'required' => true
    ));
    echo $this->Form->input('Endereco.cidade', array(
        'label' => array('text' => 'Cidade', 'class' => 'control-label col-md-5 mt-2 mb-0 pl-0'),
        'type' => 'text',
        'div' => array('class' => 'col-md-5'),
        'class' => 'form-control',
        'required' => true,
    ));
    echo $this->Form->input('Endereco.estado_id', array(
        'type' => 'select', 
        'label' => array('text' => 'Estado', 'class' => 'control-label col-md-2 mt-2 mb-0 pl-0'),
        'options' => $estados,
        'div' => array('class' => 'col-md-2'),
        'class' => 'form-control',
        'required' => true
    ));
    echo $this->Form->input('Endereco.cep', array(
        'label' => array('text' => 'CEP', 'class' => 'control-label 1 mt-2 mb-0 pl-0'),
        'aria-describedby' => 'EnderecoCep',
        'type' => 'text',
        'div' => array('class' => '1'),
        'class' => 'form-control cep',
        'required' => true,
        'placeholder' => '00000-000'
    ));
    echo $this->Html->tag('small',
        $this->Html->link('Consulte o cep da sua cidade', '/https://buscacepinter.correios.com.br/app/endereco/index.php', array(
        'class' => 'ml-1', 
        'target' => '_blank'
    )), 
        array(
        'id' => 'EnderecoCep',
        'class' => 'form-text text-muted offset-md-7'
        )
    );
    echo $this->Html->tag('hr', '', array(
        'class' => 'col-md-12'
    ));
    echo $this->Html->div('col-md-12 text-right mb-5',
        $this->Js->link(
            $this->Html->tag('i', '', array('class' => 'fa-solid fa-arrow-left')) . ' Voltar', 
            '/espacos', 
            array(
                'update' => '#content', 
                'escape' => false, 
                'class' => 'btn btn-sm btn-warning text-white')
        ) .
        $this->Js->submit(
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
        ) . 
        $this->Form->end()
    );

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


    
