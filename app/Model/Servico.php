<?php
    App::uses('AppModel', 'Model');

    class Servico extends AppModel 
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
                    'rule' => array('inList', array('TRADICIONAL', 'PREMIUM')),
                    'message' => 'Escolha TRADICIONAL OU PREMIUM.'
                )
            ),
            'quantidade_de_colaboradores' => array(
                'rule' => array('notBlank', array('money', 'left'),),
                'message' => 'Campo Obrigatório'
            ),
            'valor' => array(
                'rule' => array('notBlank', array('money', 'left'),),
                'message' => 'Campo Obrigatório'
            )
        ); 
    }