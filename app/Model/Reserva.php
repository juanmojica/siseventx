<?php
    App::uses('AppModel', 'Model');

    class Reserva extends AppModel {

        public $actsAs = array(
            'Containable'
        );

        public $belongsTo = array(
            'Cliente',
            'Espaco'
        );
        
        public $hasAndBelongsToMany = array(
            'Estrutura',
            'Servico'
        ); 
        
        public $validate = array(
            'data_reserva' => array(
                'rule' => 'notBlank', 
                'message' => 'Campo Obrigatório'
            ),
            'hora_inicio' => array(
                'rule' => 'notBlank', 
                'message' => 'Campo Obrigatório'
            ),
            'hora_fim' => array(
                'rule' => array('notBlank', array('money', 'left')),
                'message' => 'Campo Obrigatório'
            ),
            'valor' => array(
                'rule' => 'notBlank',
                'message' => 'Campo Obrigatório'
            )
        ); 
    }

?>