<?php

    $subTotalEstruturas = 0;

    if (!isset($disabled)) {
        $disabled = false;
    }

    $formFields = $this->fetch('formFields') .

    $this->Html->tag('hr', '', array(
        'class' => 'col-md-12'
    )) .

    /* Reserva */
    $this->Html->tag('h5', 'Selecione a data da Reserva', array(
        'class' => 'col-md-12 mb-0 pb-0'
    )) .         
    $this->Html->tag('hr', '', array(
        'class' => 'col-md-12 mb-0 pb-0'
    )) .         
    
    $this->Html->div('col-md-2 ml-0',
    
        $this->Form->input('Reserva.data', array(
            'label' => array('text' => 'Data da Reserva', 'class' => 'control-label col-md-12 mt-2 mb-0 pl-0'),
            'type' => 'Date',
            'div' => array('class' => 'col-md-12 p-0'),
            'class' => 'form-control d-inline col-md-12 p-0',
            'required' => true,
            'disabled' => false
        ))
    ) . 
    $this->Html->div('col-md-3 ml-4',
        $this->Form->input('Reserva.hora_inicio', array(
            'label' => array('text' => 'Horário Inicial', 'class' => 'control-label col-md-12 mt-2 mb-0 pl-0'),
            'type' => 'time',
            'div' => array('class' => 'col-md-12 p-0'),
            'class' => 'form-control d-inline col-md-3 p-0',
            'required' => true,
            'disabled' => false,
            'min' => $espaco['Espaco']['hora_inicio'],
            'max' => $espaco['Espaco']['hora_fim'],
        ))
    ) . 
    $this->Html->div('col-md-3 ',
        $this->Form->input('Reserva.hora_fim', array(
            'label' => array('text' => 'Horário Final', 'class' => 'control-label col-md-12 mt-2 mb-0 pl-0'),
            'type' => 'time',
            'div' => array('class' => 'col-md-12 p-0'),
            'class' => 'form-control d-inline col-md-3 p-0',
            'required' => true,
            'disabled' => false
        ))
    ) . 

    $this->Form->hidden('Reserva.valor') . 

    $this->Form->input('Reserva.valor1', array(
        'label' => array('text' => '<b>Valor da Reserva</b>', 'class' => 'control-label mt-2 mb-0'),
        'div' => array('class' => 'col-md-2 offset-md-1'),
        'type' => 'text',
        'class' => 'form-control',
        'required' => true,
        'disabled' => true,
    )) . 
    $this->Html->tag('hr', '', array(
        'class' => 'col-md-12 mb-0 pb-0'
    )) .
    $this->Html->tag('hr', '', array(
        'class' => 'col-md-12 mb-0 pb-0'
    )) .
    /* Fim Reserva */

    /* Espaço */
    $this->Html->tag('h5', 'Espaço', array(
        'class' => 'col-md-12 mb-0 pb-0'
    )) .         
    $this->Form->input('Espaco.nome', array(
        'label' => array('text' => 'Nome', 'class' => 'control-label mt-2 mb-0'),
        'value' => $espaco['Espaco']['nome'],
        'div' => array('class' => 'col-md-8'),
        'class' => 'form-control',
        'required' => true,
        'disabled' => true
    )) . 
    $this->Form->input('Espaco.telefone', array(
        'label' => array('text' => 'Telefone', 'class' => 'control-label mt-2 mb-0'),
        'value' => $espaco['Espaco']['telefone'],
        'div' => array('class' => 'col-md-2'),
        'class' => 'form-control telefone',
        'required' => true,
        'disabled' => true,
        'placeholder' => '(00) 0 0000-0000'
    )) . 
    $this->Form->input('Espaco.limite_participantes', array(
        'label' => array('text' => 'Limite de Participantes', 'class' => 'control-label mt-2 mb-0'),
        'value' => $espaco['Espaco']['limite_participantes'],
        'div' => array('class' => 'col-md-2'),
        'class' => 'form-control',
        'required' => true,
        'disabled' => true
    )) . 

    $this->Form->input('Espaco.valor_hora', array(
        'label' => array('text' => 'Valor Hora', 'class' => 'control-label mt-2 mb-0'),
        'value' => $espaco['Espaco']['valor_hora'],
        'div' => array('class' => 'col-md-2 '),
        'type' => 'text',
        'class' => 'form-control valor',
        'required' => true,
        'disabled' => true,
        'placeholder' => 'R$'
    )) . 
    $this->Html->div('col-md-3 ml-5',
        $this->Form->input('Espaco.hora_inicio', array(
            'label' => array('text' => 'Horário Inicial', 'class' => 'control-label col-md-12 mt-2 mb-0 pl-0'),
            'value' => $espaco['Espaco']['hora_inicio'],
            'type' => 'time',
            'div' => array('class' => 'col-md-12 p-0'),
            'class' => 'form-control d-inline col-md-3 p-0',
            'required' => true,
            'disabled' => true
        ))
    ) . 
    $this->Html->div('col-md-3 ',
        $this->Form->input('Espaco.hora_fim', array(
            'label' => array('text' => 'Horário Final', 'class' => 'control-label col-md-12 mt-2 mb-0 pl-0'),
            'value' => $espaco['Espaco']['hora_fim'],
            'type' => 'time',
            'div' => array('class' => 'col-md-12 p-0'),
            'class' => 'form-control d-inline col-md-3 p-0',
            'required' => true,
            'disabled' => true
        ))
    ) . 
    
    /* Endereço */
    $this->Html->tag('hr', '', array(
        'class' => 'col-md-12'
    )) . 
    $this->Html->tag('h5', 'Endereço', array(
        'class' => 'col-md-12 mb-0 pb-0'
    )) . 
    $this->Form->input('Endereco.logradouro', array(
        'label' => array('text' => 'Logradouro', 'class' => 'control-label col-md-6 mt-2 mb-0 pl-0'),
        'value' => $espaco['Endereco']['logradouro'],
        'type' => 'text',
        'div' => array('class' => 'col-md-6'),
        'class' => 'form-control',
        'required' => true,
        'disabled' => true
    )) . 
    $this->Form->input('Endereco.numero', array(
        'label' => array('text' => 'Número', 'class' => 'control-label col-md-1 mt-2 mb-0 pl-0'),
         'value' => $espaco['Endereco']['numero'],
        'type' => 'text',
        'div' => array('class' => 'col-md-1'),
        'class' => 'form-control',
        'required' => true,
        'disabled' => true
    )) . 
    $this->Form->input('Endereco.bairro', array(
        'label' => array('text' => 'Bairro', 'class' => 'control-label col-md-5 mt-2 mb-0 pl-0'),
         'value' => $espaco['Endereco']['bairro'],
        'type' => 'text',
        'div' => array('class' => 'col-md-5'),
        'class' => 'form-control',
        'required' => true,
        'disabled' => true
    )) . 

    $this->Form->input('Endereco.cidade', array(
        'label' => array('text' => 'Cidade', 'class' => 'control-label col-md-5 mt-2 mb-0 pl-0'),
         'value' => $espaco['Endereco']['cidade'],
        'type' => 'text',
        'div' => array('class' => 'col-md-5'),
        'class' => 'form-control',
        'required' => true,
        'disabled' => true,
    )) . 
    $this->Form->input('Endereco.estado_id', array(
        'type' => 'text', 
        'label' => array('text' => 'Estado', 'class' => 'control-label col-md-2 mt-2 mb-0 pl-0'),
        'value' => $espaco['Endereco']['Estado']['sigla'],
        'div' => array('class' => 'col-md-2'),
        'class' => 'form-control',
        'required' => true,
        'disabled' => true,
    )) . 
    $this->Form->input('Endereco.cep', array(
        'label' => array('text' => 'CEP', 'class' => 'control-label 1 mt-2 mb-0 pl-0'),
        'value' => $espaco['Endereco']['cep'],
        'aria-describedby' => 'EnderecoCep',
        'type' => 'text',
        'div' => array('class' => '1'),
        'class' => 'form-control cep',
        'required' => true,
        'disabled' => true,
        'placeholder' => '00000-000'
    )) . 
    /* Fim do Endereço */
    /* Fim do Espaço */

    /* Tabela Estruturas */
    $this->Html->tag('hr', '', array(
        'class' => 'col-md-12'
    )) .

    $this->Html->tag('hr', '', array(
        'class' => 'col-md-12'
    )) . 

    $this->Html->tag('h5', 'Estruturas', array(
        'class' => 'col-md-12 mb-1 pb-0'
    ));

    $titulos = array(
        array('Selecione' => array('class' => 'col-md-1')),    
        array('Nome' => array('class' => 'col-md-7')),
        array('Tipo' => array('class' => 'col-md-2')),    
        array('Valor' => array('class' => 'col-md-2')),    
    );

    $tableHeaders = $this->Html->tableHeaders($titulos, array('class' => 'text-center'));
    $header = $this->Html->tag('thead', $tableHeaders);

    $dadosEstruturas = array();

    $checked = false;
    $disabled = false;

    foreach ($estruturas as $estrutura) {

        if ($estrutura['Estrutura']['tipo'] == 'BASICO') {
            $checked = true;
            $disabled = true;
            $estrutura['Estrutura']['tipo'] = 'BÁSICO';

        } else {
            $checked = false;
            $disabled = false;
        }
       
        $dadosEstruturas[] = array(
            
            array(
                $this->Form->checkbox('Estrutura.'.$estrutura['Estrutura']['id'], array(
                    'checked' => $checked,
                    'disabled' => $disabled,
                    'class' => 'checkbox-estrutura'
               )), 
               array('class' => 'text-center')
            ),
            $estrutura['Estrutura']['nome'],
            array($estrutura['Estrutura']['tipo'], array('class' => 'text-center')),
            array(
                'R$ ' . number_format($estrutura['Estrutura']['valor'], 2 , ",", "."),
                array('class' => 'text-center valor-estrutura')
            ),

        ); 
    }

    $dadosEstruturas[] = array(
        '',
        '',
        array('<b>Total Estruturas</b>', array('class' => 'text-center text-bold', 'id' => 'label-total-estrutura')),
        array('', array('class' => 'text-center', 'id' => 'total-estrutura'))
    );
    
    
    $tableCells = $this->Html->tableCells($dadosEstruturas);
    $table = $this->Html->div('table-responsive', 
        $this->Html->tag('table', $header . $tableCells, array('class' => 'table table-striped table-sm')) 
    );

    $formFields .= $table;
    /* Fim da Tabela Estruturas */

    /* Tabela Serviços */
    $formFields .= $this->Html->tag('hr', '', array(
        'class' => 'col-md-12'
    )) . 
    $this->Html->tag('h5', 'Serviços', array(
        'class' => 'col-md-12 mb-1 pb-0'
    ));

    $titulos = array(
        array('Selecione' => array('class' => 'col-md-1')),    
        array('Nome' => array('class' => 'col-md-5')),
        array('Tipo' => array('class' => 'col-md-2')),    
        array('Quantidade de Colaboradores' => array('class' => 'col-md-2')),    
        array('Valor' => array('class' => 'col-md-2')),    
    );

    $tableHeaders = $this->Html->tableHeaders($titulos, array('class' => 'text-center'));
    $header = $this->Html->tag('thead', $tableHeaders);

    $dadosServicos = array();

    $checked = false;
    
    foreach ($servicos as $servico) {
        
        $dadosServicos[] = array(

            array(
                $this->Form->checkbox('Servico.'.$servico['Servico']['id'], array(
                    'class' => 'checkbox-servico'
               )), 
               array('class' => 'text-center')
            ),
            $servico['Servico']['nome'],
            array($servico['Servico']['tipo'], array('class' => 'text-center')),
            array($servico['Servico']['quantidade_de_colaboradores'], array('class' => 'text-center')),
            array(
                'R$ ' . number_format($servico['Servico']['valor'], 2 , ",", "."),
                array('class' => 'text-center valor-servico')
            ),

        ); 
    }

    $dadosServicos[] = array(
        '',
        '',
        '',
        array('<b>Total Serviços</b>', array('class' => 'text-center text-bold', 'id' => 'label-total-servico')),
        array('', array('class' => 'text-center', 'id' => 'total-servico'))
    );
    
    
    $tableCells = $this->Html->tableCells($dadosServicos);
    $table = $this->Html->div('table-responsive', 
        $this->Html->tag('table', $header . $tableCells, array('class' => 'table table-striped table-sm')) 
    );

    $formFields .= $table;
    /* Fim da Tabela Serviços */

    $formFields .= $this->Html->tag('hr', '', array(
        'class' => 'col-md-12'
    )) .
    $this->Form->input('Reserva.valor2', array(
        'label' => array('text' => '<b>Valor da Reserva</b>', 'class' => 'control-label mt-2 mb-0'),
        'div' => array('class' => 'col-md-2 offset-md-10'),
        'type' => 'text',
        'class' => 'form-control',
        'required' => true,
        'disabled' => true,
    )) .
    $this->Html->tag('hr', '', array(
        'class' => 'col-md-12'
    )) .
    $this->Html->tag('h5', 'Clientes', array(
        'class' => 'col-md-12 mb-1 pb-0'
    )) .
    $this->Form->input('Cliente.id.nome', array(
        'type' => 'select', 
        'label' => '', 
        'options' => $clientesNome,
        'div' => array('class' => 'col-md-9'),
        'class' => 'form-control mb-2 cliente-nome',
        'required' => true,
    )) .
    $this->Form->input('Cliente.id.cpf', array(
        'type' => 'select', 
        'label' => '', 
        'options' => $clientesCpf,
        'div' => array('class' => 'col-md-3'),
        'class' => 'form-control mb-2 cliente-cpf',
        'required' => true,
    ));

    $this->assign('formFields', $formFields);

    if ($this->request->is('ajax')) {
        echo $this->Js->writeBuffer();
    }
    
?>


<?php

    $controllerName = $this->request->params['controller'];
   
    $actionName = $this->request->params['action'];

    $form = $formFields;

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

    var totalEstrutura = 0.00 
    let totalServico = 0.00


    $(document).ready(function() {

        $('.telefone').mask('(00) 0 0000-0000');
        $('.valor').mask('#.##0,00', {reverse: true});
        $('.estado').mask('AA');
        $('.cep').mask('00000-000');

        calcularTotalEstruturas();
        calcularTotalServicos();
    });

    $('.checkbox-servico').change(function() {
        calcularTotalServicos();
    });

    $('.checkbox-estrutura').change(function() {
        calcularTotalEstruturas();
    });


    function calcularTotalEstruturas() {

        totalEstrutura = 0.00
        totalEstruturaaaaa = 0.00

        $('.checkbox-estrutura:checked').each(function() {
            
            let valorTexto = $(this).closest('tr').find('.valor-estrutura').text();

            let valorSemLetras  = valorTexto.replace(/\D/g, '');

            let valorNumerico = parseFloat( valorSemLetras / 100 );

            totalEstrutura += valorNumerico;
        });

        totalEstrutura = totalEstrutura
        totalEstruturaaaaa = parseFloat(totalEstrutura).toFixed(2)

        let total =  totalEstruturaaaaa.toString()

        total = total.replace('.', ',')

        $('#total-estrutura').remove();
        $('#label-total-estrutura').after(`<td id="total-estrutura" class="text-center"><b>R$ ${total}</b></td>`)

        calcularValorReserva()
    }

    
    function calcularTotalServicos() {

        totalServico = 0.00
        totalServicoooo = 0.00

        $('.checkbox-servico:checked').each(function() {
            
            let valorTexto = $(this).closest('tr').find('.valor-servico').text();

            let valorSemLetras  = valorTexto.replace(/\D/g, '');

            let valorNumerico = parseFloat( valorSemLetras / 100 );

            totalServico += valorNumerico;
        });

        totalServico = totalServico
        totalServicoooo = parseFloat(totalServico).toFixed(2)
        
        let total =  totalServicoooo.toString()

        total = total.replace('.', ',')

        $('#total-servico').remove();
        $('#label-total-servico').after(`<td id="total-servico" class="text-center"><b>R$ ${total}</b></td>`)

        calcularValorReserva()
    }

    $('.cliente-nome').change(function() {

        idCliente = $(".cliente-nome option:selected").val();

        $('.cliente-cpf').find('[value="' + idCliente + '"]').attr('selected', true);
    });

    $('.cliente-cpf').change(function() {

        idCliente = $(".cliente-cpf option:selected").val();

        $('.cliente-nome').find('[value="' + idCliente + '"]').attr('selected', true);
    });

    function calcularValorReserva() {
        
        let valorReserva = 0.00
        let total = 0.00
        
        let valorEspacoHoraTexto = $('#EspacoValorHora').val()

        let valorSemLetras  = valorEspacoHoraTexto.replace(/\D/g, '');

        let valorNumerico = parseFloat( valorSemLetras / 100 );

        let valorEspacoHora = parseFloat(valorNumerico).toFixed(2)

        valorReserva = (valorNumerico + totalEstrutura + totalServico).toFixed(2)
        console.log(valorNumerico)
        console.log(valorEspacoHora)
        console.log(totalEstrutura)
        console.log(valorReserva)

        total =  valorReserva.toString()

        valorReserva = total.replace('.', ',')

        $('#ReservaValor').val('R$ ' + valorReserva)
        $('#ReservaValor1').val('R$ ' + valorReserva)
        $('#ReservaValor2').val('R$ ' + valorReserva)
    }

    
        
</script>


