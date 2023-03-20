<?php
    App::uses('AppModel', 'Model');

    class Estrutura extends AppModel 
    {

        public $hasAndBelongsToMany = array(
            'Reserva'
        ); 

        public $validate = array(
            'nome' => array(
                'rule' => 'notBlank', 
                'message' => 'Campo Obrigatório'
            ),
            'tipo' => array(
                array(
                    'rule' => 'notBlank', 
                    'message' => 'Campo Obrigatório'
                ),
                array(
                    'rule' => array('inList', array('BASICO', 'ADICIONAL')),
                    'message' => 'Escolha BÁSICO OU ADICIONAL'
                )
            ),
            'valor' => array(
                'rule' => array('notBlank', array('money', 'left'),),
                'message' => 'Campo Obrigatório'
            )
        ); 
    }