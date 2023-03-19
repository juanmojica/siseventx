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
    $reportButton = $this->Html->link('Imprimir', '/' . $controllerName . '/report', array('class' => 'btn btn-secondary float-right mr-2', 'target' => '_blank'));

    $searchFields = $this->Form->input('Espaco.nome', array(
        'required' => false,
        'label' => array('text' => 'Nome', 'class' => 'sr-only'),
        'class' => 'form-control mb-2 mr-sm-2 form-sm',
        'div' => false,
        'placeholder' => 'Nome...'
    ));

    $filtro = $this->Form->create('Espaco', array('class' => 'form-inline '));
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
        array('Nome' => array('class' => 'col-md-2')),
        array('Endereço' => array('class' => 'col-md-2')),
        array('Telefone' => array('class' => 'col-md-2')),
        array('Limite de Participantes' => array('class' => 'col-md-1')),
        array('Hora de Início' => array('class' => 'col-md-1')),
        array('Hora de Encerramento' => array('class' => 'col-md-1')),
        array('Valor por Hora' => array('class' => 'col-md-1')),
        array('Ações' => array('class' => 'col-md-2'))    
    );

    $tableHeaders = $this->Html->tableHeaders($titulos, array('class' => 'text-center'));
    $header = $this->Html->tag('thead', $tableHeaders);

    $dadosEspacos = array();

    foreach ($espacos as $espaco) {

        $endereco = "Rua {$espaco['Endereco']['logradouro']}, 
            {$espaco['Endereco']['numero']}, 
            {$espaco['Endereco']['bairro']}, 
            {$espaco['Endereco']['cidade']}/{$espaco['Endereco']['Estado']['sigla']}";

        $viewLink = $this->Js->link(
            $this->Html->tag('i', '', array('class' => 'fa-solid fa-eye btn btn-sm btn-primary')), 
            '/espacos/view/' . $espaco['Espaco']['id'], 
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
            '/espacos/edit/' . $espaco['Espaco']['id'], 
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
            '/espacos/delete/' . $espaco['Espaco']['id'], 
            array(
                'update' => '#content', 
                'confirm' => 'Tem certeza?',
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
        
        $dadosEspacos[] = array(
            $espaco['Espaco']['nome'],
            $endereco,
            array($espaco['Espaco']['telefone'], array('class' => 'text-center')),
            array($espaco['Espaco']['limite_participantes'], array('class' => 'text-center')),
            array($espaco['Espaco']['hora_inicio'], array('class' => 'text-center')),
            array($espaco['Espaco']['hora_fim'], array('class' => 'text-center')),
            array($espaco['Espaco']['valor_hora'], array('class' => 'text-center')),
            array($viewLink .' '. $editLink . ' ' . $deleteLink, array('class' => 'text-center'))
        ); 
    }
    
    $tableCells = $this->Html->tableCells($dadosEspacos);
    $table = $this->Html->div('table-responsive', 
        $this->Html->tag('table', $header . $tableCells, array('class' => 'table table-striped table-sm')) 
    );

    echo $this->Flash->render('danger'); 
    echo $this->Flash->render('success'); 

    echo $filtroBar;
    echo $this->Html->tag('h2', 'Espaços', array('class' => 'my-2'));
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
        '{:page} de {:pages}, mostrando {:current} de registros {:count}, começando em {:start} até {:end}'
    );

    $paginateBar = $this->Html->div('row mt-2', 
        $this->Html->div('col-md-6', $paginate) . 
        $this->Html->div('col-md-6', $paginateCount)
    );

    echo $paginateBar;

    $this->Js->buffer('$(".nav-item").removeClass("active");');
    $this->Js->buffer('$(".nav-item a[href$=\'' . $controllerName . '\']").addClass("active");');
    
    if ($this->request->is('ajax')) {
        echo $this->Js->writeBuffer();
    }

?>

