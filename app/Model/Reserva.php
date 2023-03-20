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
            'nome' => array(
                'rule' => 'notBlank', 
                'message' => 'Campo Obrigatório'
            ),
            'telefone' => array(
                'rule' => 'notBlank', 
                'message' => 'Campo Obrigatório'
            ),
            'limite_participantes' => array(
                'rule' => 'notBlank', 
                'message' => 'Campo Obrigatório'
            ),
            'valor_hora' => array(
                'rule' => array('notBlank', array('money', 'left'),),
                'message' => 'Campo Obrigatório'
            ),
            'hora_inicio' => array(
                'rule' => 'notBlank',
                'message' => 'Campo Obrigatório'
            ),
            'hora_fim' => array(
                'rule' => 'notBlank',
                'message' => 'Campo Obrigatório'
            )
        ); 
    }

?>