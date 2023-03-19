<?php

App::uses('Controller', 'Controller');


class AppController extends Controller {

    public $layout = 'bootstrapLayout';
    public $helpers = array('Js' => array('Jquery'));
    public $components = array('RequestHandler', 'Session', 'Flash');


}
