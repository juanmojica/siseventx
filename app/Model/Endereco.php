<?php
    App::uses('AppModel', 'Model');

    class Endereco extends AppModel {

        public $actsAs = array(
            'Containable'
        );

        public $belongsTo = array(
            'Estado'
        );

        public $validate = array(
            'logradouro' => array(
                'rule' => 'notBlank', 
                'message' => 'Campo Obrigatório',
            ),
            'numero' => array(
                'rule' => 'notBlank', 
                'message' => 'Campo Obrigatório',
            ),
            'bairro' => array(
                'rule' => 'notBlank', 
                'message' => 'Campo Obrigatório',
            ),
            'cidade' => array(
                'rule' => 'notBlank', 
                'message' => 'Campo Obrigatório',
            ),
            'estado_id' => array(
                'rule' => 'notBlank', 
                'message' => 'Campo Obrigatório',
            ),
            'cep' => array(
                'rule' => 'notBlank', 
                'message' => 'Campo Obrigatório',
            ),
        ); 
    }
    
?>