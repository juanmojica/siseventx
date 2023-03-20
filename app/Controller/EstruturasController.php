<?php

App::uses('AppController', 'Controller');

class EstruturasController extends AppController
{
    protected $paginate = array(
        'fields' => array(
            'id',
            'nome',
            'tipo',
            'valor'
        ),
        'conditions' => array('Estrutura.deleted_at' => NULL),
        'limit' => 10,
        'order' => array('Estrutura.tipo' => 'asc')    
    );
    
    public function index()
    {
        try {

            if ($this->request->is('post')) {

                $filtro = $this->request->data['Estrutura']['nome_filtrar'];

                if (!empty($filtro)) {

                    $this->paginate['conditions']['or'] = array(
                        'Estrutura.nome LIKE' => '%' .trim($filtro) . '%'
                    );
                }
            } 

            $estruturas = $this->paginate();
            
            $this->set( compact('estruturas') );
            
        } catch (\Exception $e) {

            $this->Flash->set($e->getMessage());

            $this->redirect(array(
                'controller' => 'pages',
                'action' => 'home',
                '?' => array('erro' => true)
            ));
        }
    }

    public function add() 
    {
        try {
            
            if (!empty($this->request->data)) {

                $dadosForm = $this->request->data;
            
                if(!empty($dadosForm['Estrutura']['valor'])){
                    $valor_hora = (float) str_replace(',', '.', $dadosForm['Estrutura']['valor']);
                    $dadosForm['Estrutura']['valor'] = $valor_hora;
                }
                                
                $this->Estrutura->create();
                
                if ($this->Estrutura->save($dadosForm)) {

                    $this->Flash->set('Salvo com Sucesso!', array(
                        'element' => 'bootstrap',
                        'key' => 'success'
                    ));

                    $this->redirect('/estruturas/add');

                } else {
                    throw new Exception("Erro ao tentar salvar o endereço!");
                }
            } 
        } catch (\Exception $e) {

            if (isset($dadosForm)) {
                $this->request->data = $dadosForm;
            }

            $this->Flash->set( $e->getMessage(), array(
                'element' => 'bootstrap',
                'key' => 'danger'
            ));
        }
             
    }

    public function view($id)
    {
        try {

            $this->request->data = $this->getEstrutura($id);

            $disabled = true;

            $this->set(compact('disabled'));

        } catch (\Exception $e) {

            $this->Flash->set( $e->getMessage(), array(
                'element' => 'bootstrap',
                'key' => 'danger'
            ));

            $this->redirect('/estruturas');
        }
    }

    public function edit($id = null) 
    {
        try {

            if (!empty($this->request->data)) {

                $dadosForm = $this->request->data;
                
                if(!empty($dadosForm['Estrutura']['valor'])){
                    $valor = (float) str_replace(',', '.', $dadosForm['Estrutura']['valor']);
                    $dadosForm['Estrutura']['valor'] = $valor;
                }

                $dadosForm['Estrutura']['updated_at'] = date('Y-m-d H:i:s');
                                                   
                if ($this->Estrutura->save($dadosForm)) {
                   
                    $this->Flash->set('Editado com Sucesso!', array(
                        'element' => 'bootstrap',
                        'key' => 'success'
                    ));

                    $this->redirect('/estruturas');

                } else {
                    throw new Exception("Erro ao tentar editar a estrutura!");
                }
                
            } else {
                $this->request->data = $this->getEstrutura($id);
            }

        } catch (\Exception $e) {

            $this->Flash->set( $e->getMessage(), array(
                'element' => 'bootstrap',
                'key' => 'danger'
            ));

            $this->redirect('/estruturas');
        } 
    }

    public function delete($id) 
    {
        try {

            $estrutura = $this->getEstrutura($id);
            
            if (empty($estrutura)) {
                throw new Exception("Estrutura não encontrada!");
            }

            $estrutura['Estrutura']['deleted_at'] = date('Y-m-d H:i:s');
                                                
            if ($this->Estrutura->save($estrutura)) {
                
                $this->Flash->set('Excluído com Sucesso!', array(
                    'element' => 'bootstrap',
                    'key' => 'success'
                ));

                $this->redirect('/estruturas');

            } else {
                throw new Exception("Erro ao tentar excluir a estrutura!");
            }
          
        } catch (\Exception $e) {

            $this->Flash->set( $e->getMessage(), array(
                'element' => 'bootstrap',
                'key' => 'danger'
            ));

            $this->redirect('/estruturas');
        }
    }

    public function getEstrutura($id) 
    {
        try {

            $fields = array(
                'Estrutura.id',
                'Estrutura.nome',
                'Estrutura.tipo',
                'Estrutura.valor'
            );

            $conditions = array('Estrutura.id' => $id);
            
            return $this->Estrutura->find('first', array(
                'fields' => $fields,
                'conditions' => $conditions
            ));
            
        } catch (\Exception $e) {

            $this->Flash->set( $e->getMessage(), array(
                'element' => 'bootstrap',
                'key' => 'danger'
            ));

            $this->redirect('/estruturas');
        }
    }
}

?>