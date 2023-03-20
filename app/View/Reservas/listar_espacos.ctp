<?php

    $searchFields = $this->Form->input('Espaco.nome_filtrar', array(
        'required' => false,
        'label' => array('text' => 'Nome', 'class' => 'sr-only'),
        'class' => 'form-control mb-2 mr-sm-2 form-sm',
        'div' => false,
        'placeholder' => 'Nome...'
    ));

    $filtro = $this->Form->create('Reserva', array('class' => 'form-inline '));
    $filtro .= $searchFields; 
    $filtro .= $this->Js->submit('Filtrar', array(
        'class' => 'btn btn-primary mb-2', 
        'action' => '/reservas/listarEspacos', 
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
    ));

    $filtro .= $this->Form->end();

    $filtroBar = $this->Html->div('row mb-3 mt-3', 
        $this->Html->div('col-md-6', $filtro) 
    );

    $titulos = array(
        array('Nome' => array('class' => 'col-md-2')),
        array('Endereço' => array('class' => 'col-md-3')),
        array('Telefone' => array('class' => 'col-md-2')),
        array('Limite de Participantes' => array('class' => 'col-md-1')),
        array('Hora de Início' => array('class' => 'col-md-1')),
        array('Hora de Encerramento' => array('class' => 'col-md-1')),
        array('Valor por Hora' => array('class' => 'col-md-1')),
        array('Ações' => array('class' => 'col-md-1'))    
    );

    $tableHeaders = $this->Html->tableHeaders($titulos, array('class' => 'text-center'));
    $header = $this->Html->tag('thead', $tableHeaders);

    $dadosEspacos = array();

    foreach ($espacos as $espaco) {
        
        $endereco = "{$espaco['Espaco']['Endereco']['logradouro']}, 
            {$espaco['Espaco']['Endereco']['numero']}, 
            {$espaco['Espaco']['Endereco']['bairro']}, 
            {$espaco['Espaco']['Endereco']['cidade']}/{$espaco['Espaco']['Endereco']['Estado']['sigla']}";

        $viewLink = $this->Js->link(
            $this->Html->tag('i', '', array('class' => 'fa-solid fa-check-to-slot btn btn-sm btn-success')), 
            '/reservas/add/' . $espaco['Espaco']['id'], 
            array(
                'update' => '#content', 
                'escape' => false, 
                'title' => 'Iniciar Reserva',
                'evalScripts' => true,
                'before' => $this->Js->get('#busy-indicator')->effect(
                    'fadeIn',
                    
                ),
                'complete' => $this->Js->get('#busy-indicator')->effect(
                    'fadeOut',
                    
                )
            )
        );

        $dadosEspacos[] = array(
            $espaco['Espaco']['nome'],
            $endereco,
            array($espaco['Espaco']['telefone'], array('class' => 'text-center')),
            array($espaco['Espaco']['limite_participantes'], array('class' => 'text-center')),
            array($espaco['Espaco']['hora_inicio'], array('class' => 'text-center')),
            array($espaco['Espaco']['hora_fim'], array('class' => 'text-center')),
            array('R$ ' . $espaco['Espaco']['valor_hora'], array('class' => 'text-center')),
            array($viewLink, array('class' => 'text-center'))
        ); 
    }
    
    $tableCells = $this->Html->tableCells($dadosEspacos);
    $table = $this->Html->div('table-responsive', 
        $this->Html->tag('table', $header . $tableCells, array('class' => 'table table-striped table-sm')) 
    );

    echo $this->Flash->render('danger'); 
    echo $this->Flash->render('success'); 

    echo $filtroBar;
    echo $this->Html->tag('h2', 'Escolha o espaço a ser reservado', array('class' => 'my-2'));
    echo $table;

    $this->Paginator->options(array('update' => '#content'));

    $links = array(
        $this->Paginator->first('Primeira', array('class' => 'page-link')),
        $this->Paginator->prev('Anterior', array('class' => 'page-link')),
        $this->Paginator->next('Próxima', array('class' => 'page-link')),
        $this->Paginator->last('Última', array('class' => 'page-link'))
    );

    $paginate = $this->Html->nestedList($links, array('class' => 'pagination'), array('class' => 'page-item'));
    $paginate = $this->Html->tag('nav', $paginate);
    $paginateCount = $this->Paginator->counter(
        '{:page} de {:pages}, mostrando {:current} registros de {:count}, começando em {:start} até {:end}'
    );

    $paginateBar = $this->Html->div('row mt-2', 
        $this->Html->div('col-md-6', $paginate) . 
        $this->Html->div('col-md-6', $paginateCount)
    );

    echo $paginateBar;

    $this->Js->buffer('$(".active").removeClass("active");');
    $this->Js->buffer('$(".nav-item a[href$=\'reservas\']").addClass("active");');
    
    if ($this->request->is('ajax')) {
        echo $this->Js->writeBuffer();
    }

?>

