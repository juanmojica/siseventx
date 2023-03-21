<?php

use function PHPSTORM_META\type;

    $controllerName = $this->request->params['controller'];
    
    $novoButton = $this->Js->link('Novo', '/' . $controllerName . '/listarEspacos', array(
        'class' => 'btn btn-success float-right', 
        'update' => '#content',
        'evalScripts' => true,
        'before' => $this->Js->get('#busy-indicator')->effect(
            'fadeIn',
            array('buffer' => false)
        ),
        'complete' => $this->Js->get('#busy-indicator')->effect(
            'fadeOut',
            array('buffer' => false)
        )
    ));

    $reportButton = $this->Html->link('Imprimir', '/' . $controllerName . '/report', array('class' => 'btn btn-secondary float-right mr-2', 'target' => '_blank'));

    $searchFields = $this->Form->input('Reserva.data_filtrar', array(
        'type' => 'Date',
        'required' => true,
        'label' => array('text' => 'Nome', 'class' => 'sr-only'),
        'class' => 'form-control mb-2 mr-sm-2 form-sm',
        'div' => false,
    ));

    $filtro = $this->Form->create('Reservas', array('class' => 'form-inline '));
    $filtro .= $searchFields; 
    $filtro .= $this->Js->submit('Filtrar', array(
        'class' => 'btn btn-primary mb-2', 
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
        $this->Html->div('col-md-6', $filtro) . 
        $this->Html->div('col-md-6', $novoButton . $reportButton)
    );

    $titulos = array(
        array('Espaço' => array('class' => 'col-md-1')),
        array('Endereço' => array('class' => 'col-md-2')),
        array('Data da Reserva' => array('class' => 'col-md-1')),    
        array('Hora Início' => array('class' => 'col-md-1')),    
        array('Hora Final' => array('class' => 'col-md-1')),    
        array('Cliente' => array('class' => 'col-md-2')),    
        array('CPF' => array('class' => 'col-md-1')),    
        array('Valor' => array('class' => 'col-md-1')),    
        array('Ações' => array('class' => 'col-md-2')),    
    );

    $tableHeaders = $this->Html->tableHeaders($titulos, array('class' => 'text-center'));
    $header = $this->Html->tag('thead', $tableHeaders);

    $dadosReservas = array();

    foreach ($reservas as $reserva) {

        $viewLink = $this->Js->link(
            $this->Html->tag('i', '', array('class' => 'fa-solid fa-eye btn btn-sm btn-primary')), 
            '/' . $controllerName . '/view/' . $reserva['Reserva']['id'], 
            array(
                'update' => '#content', 
                'escape' => false, 
                'title' => 'Ver Detalhes',
                'evalScripts' => true,
                'before' => $this->Js->get('#busy-indicator')->effect(
                    'fadeIn',
                    
                ),
                'complete' => $this->Js->get('#busy-indicator')->effect(
                    'fadeOut',
                    
                )
            )
        );

        $editLink = $this->Js->link(
            $this->Html->tag('i', '', array('class' => 'fa-solid fa-pen-to-square btn btn-sm btn-info')), 
            '/' . $controllerName . '/edit/' . $reserva['Reserva']['id'], 
            array(
                'update' => '#content', 
                'escape' => false, 
                'title' => 'Editar',
                'evalScripts' => true,
                'before' => $this->Js->get('#busy-indicator')->effect(
                    'fadeIn',
                    
                ),
                'complete' => $this->Js->get('#busy-indicator')->effect(
                    'fadeOut',
                    
                )
            )
        );
        
        $deleteLink = $this->Js->link(
            $this->Html->tag('i', '', array('class' => 'fa-solid fa-trash-can btn btn-sm btn-danger')), 
            '/' . $controllerName . '/delete/' . $reserva['Reserva']['id'], 
            array(
                'update' => '#content', 
                'confirm' => 'Confirmar Exclusão?',
                'escape' => false, 
                'title' => 'Excluir',
                'evalScripts' => true,
                'before' => $this->Js->get('#busy-indicator')->effect(
                    'fadeIn',
                    
                ),
                'complete' => $this->Js->get('#busy-indicator')->effect(
                    'fadeOut',
                    
                )
            )
        );

        $endereco = "{$reserva['Espaco']['Endereco']['logradouro']}, 
        {$reserva['Espaco']['Endereco']['numero']}, 
        {$reserva['Espaco']['Endereco']['bairro']}, 
        {$reserva['Espaco']['Endereco']['cidade']}/{$reserva['Espaco']['Endereco']['Estado']['sigla']}";

        $dataReserva = date('d/m/Y', strtotime($reserva['Reserva']['data_reserva']));
        
        $dadosReservas[] = array(
            $reserva['Espaco']['nome'],
            $endereco,
            array($dataReserva, array('class' => 'text-center')),
            array($reserva['Reserva']['hora_inicio'], array('class' => 'text-center')),
            array($reserva['Reserva']['hora_fim'], array('class' => 'text-center')),
            $reserva['Cliente']['nome'],
            array($reserva['Cliente']['cpf'], array('class' => 'text-center')),
            array('R$ ' . $reserva['Reserva']['valor'], array('class' => 'text-center')),
            array($viewLink .' '. $editLink . ' ' . $deleteLink, array('class' => 'text-center'))
        ); 
    }
    
    $tableCells = $this->Html->tableCells($dadosReservas);
    $table = $this->Html->div('table-responsive', 
        $this->Html->tag('table', $header . $tableCells, array('class' => 'table table-striped table-sm')) 
    );

    echo $this->Flash->render('danger'); 
    echo $this->Flash->render('success'); 

    echo $filtroBar;
    echo $this->Html->tag('h2', 'Reservas', array('class' => 'my-2'));
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
    $this->Js->buffer('$(".nav-item a[href$=\'' . $controllerName . '\']").addClass("active");');
    
    if ($this->request->is('ajax')) {
        echo $this->Js->writeBuffer();
    }

?>

