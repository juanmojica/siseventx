<?php 
    $controllerName = $this->request->params['controller'];
    
    $novoButton = $this->Js->link('Novo', '/' . $controllerName . '/add', array(
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

    $searchFields = $this->Form->input('Servico.nome_filtrar', array(
        'required' => false,
        'label' => array('text' => 'Nome', 'class' => 'sr-only'),
        'class' => 'form-control mb-2 mr-sm-2 form-sm',
        'div' => false,
        'placeholder' => 'Nome...'
    ));

    $filtro = $this->Form->create('Servicos', array('class' => 'form-inline '));
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
        $this->Html->div('col-md-6', $novoButton)
    );

    $titulos = array(
        array('Nome' => array('class' => 'col-md-4')),
        array('Tipo' => array('class' => 'col-md-2')),    
        array('Quantidade de Colaboradores' => array('class' => 'col-md-2')),    
        array('Valor' => array('class' => 'col-md-2')),    
        array('Ações' => array('class' => 'col-md-2')),    
    );

    $tableHeaders = $this->Html->tableHeaders($titulos, array('class' => 'text-center'));
    $header = $this->Html->tag('thead', $tableHeaders);

    $dadosServicos = array();

    foreach ($servicos as $servico) {

        $viewLink = $this->Js->link(
            $this->Html->tag('i', '', array('class' => 'fa-solid fa-eye btn btn-sm btn-primary')), 
            '/' . $controllerName . '/view/' . $servico['Servico']['id'], 
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
            '/' . $controllerName . '/edit/' . $servico['Servico']['id'], 
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
            '/' . $controllerName . '/delete/' . $servico['Servico']['id'], 
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
        
        $dadosServicos[] = array(
            $servico['Servico']['nome'],
            array($servico['Servico']['tipo'], array('class' => 'text-center')),
            array($servico['Servico']['quantidade_de_colaboradores'], array('class' => 'text-center')),
            array('R$ ' . $servico['Servico']['valor'], array('class' => 'text-center')),
            array($viewLink .' '. $editLink . ' ' . $deleteLink, array('class' => 'text-center'))
        ); 
    }
    
    $tableCells = $this->Html->tableCells($dadosServicos);
    $table = $this->Html->div('table-responsive', 
        $this->Html->tag('table', $header . $tableCells, array('class' => 'table table-striped table-sm')) 
    );

    echo $this->Flash->render('danger'); 
    echo $this->Flash->render('success'); 

    echo $filtroBar;
    echo $this->Html->tag('h2', 'Serviços', array('class' => 'my-2'));
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

