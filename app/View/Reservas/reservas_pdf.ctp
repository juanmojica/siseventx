<?php

require '../../vendor/autoload.php';

use Dompdf\Dompdf;

    $dompdf = new Dompdf();

    $titulos = array(
        array('Espaço' => array('class' => 'col-md-1')),
        array('Endereço' => array('class' => 'col-md-2')),
        array('Data da Reserva' => array('class' => 'col-md-1')),    
        array('Hora Início' => array('class' => 'col-md-1')),    
        array('Hora Final' => array('class' => 'col-md-1')),    
        array('Cliente' => array('class' => 'col-md-2')),    
        array('CPF' => array('class' => 'col-md-1')),    
        array('Valor' => array('class' => 'col-md-1')),    
    );

    $tableHeaders = $this->Html->tableHeaders($titulos, array('class' => 'text-center'));
    $header = $this->Html->tag('thead', $tableHeaders);

    $dadosReservas = array();

    foreach ($reservas as $reserva) {

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
        ); 
    }
    
    $tableCells = $this->Html->tableCells($dadosReservas);
    $table = $this->Html->div('table-responsive', 
        $this->Html->tag('table', $header . $tableCells, array('class' => 'table table-sm border')) 
    );

    $html = $this->Html->tag('h2', 'Relatório de Reservas', array('class' => 'my-2'));
    $html .= $table;

    $dompdf->loadHtml( $html );

    $dompdf->setPaper('A4', 'portrait');

    $dompdf->render();

    $dompdf->stream('reservas.pdf');

    exit(1);

?>
