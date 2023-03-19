<?php
    App::uses('AppModel', 'Model');

    class Espaco extends AppModel {

        public $actsAs = array(
            'Containable'
        );

        public $belongsTo = array(
            'Endereco'
        );

        /* public $hasMany = array(
            'Critica'
        );
        
        public $hasAndBelongsToMany = array(
            'Ator'
        ); */
        
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