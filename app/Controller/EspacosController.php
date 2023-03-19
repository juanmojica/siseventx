<?php

App::uses('AppController', 'Controller');

class EspacosController extends AppController
{
    protected $paginate = array(
        'fields' => array(
            'id',
            'nome',
            'telefone',
            'limite_participantes',
            'hora_inicio',
            'hora_fim',
            'valor_hora'
        ),
        'contain' => array(
            'Endereco' => array(
                'fields' => array(
                    'logradouro',
                    'numero',
                    'bairro',
                    'cidade',
                    'cep'
                ), 
                'Estado.sigla'
            ),
        ),
        'conditions' => array('Espaco.deleted_at' => NULL),
        'limit' => 10,
        'order' => array('Espaco.nome' => 'asc')    
    );
    
    public function index()
    {
        try {

            $espacos = $this->paginate();
            
            $this->set( compact('espacos') );
            
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

            $estados = $this->getEstados();
            $this->set( compact('estados'));

            if (!empty($this->request->data)) {

                $dadosForm = $this->request->data;
            
                if(!empty($dadosForm['Espaco']['valor_hora'])){
                    $valor_hora = (float) str_replace(',', '.', $dadosForm['Espaco']['valor_hora']);
                    $dadosForm['Espaco']['valor_hora'] = $valor_hora;
                }
               
                $dataSource = $this->Espaco->getDataSource();
                
                $dataSource->begin();
                                
                $this->Espaco->Endereco->create();

                $espaco = $this->Espaco->Endereco->save($dadosForm);
                
                if ($espaco) {

                    $dadosForm['Espaco']['endereco_id'] = $espaco['Endereco']['id'];
                    $this->Espaco->create();
                    
                    if ($this->Espaco->save($dadosForm)) {

                        $dataSource->commit();
                        $this->Flash->set('Salvo com Sucesso!', array(
                            'element' => 'bootstrap',
                            'key' => 'success'
                        ));
                        $this->redirect('/espacos/add');

                    } else {
                        throw new Exception("Erro ao tentar salvar o espaço!");
                    }
                } else {
                    throw new Exception("Erro ao tentar salvar o endereço!");
                }
            }
        } catch (\Exception $e) {

            $dataSource->rollback();

            $this->Flash->set( $e->getMessage(), array(
                'element' => 'bootstrap',
                'key' => 'danger'
            ));

            $this->redirect('/espacos/add');
        }
             
    }

    public function view()
    {
        try {
            //code...
        } catch (\Exception $e) {

            $this->Flash->set( $e->getMessage(), array(
                'element' => 'bootstrap',
                'key' => 'danger'
            ));

            $this->redirect('/espacos');
        }
    }

    public function edit($id = null) 
    {
        try {

            $estados = $this->getEstados();
            $this->set( compact('estados'));

            if (!empty($this->request->data)) {

                $dadosForm = $this->request->data;
                
                if(!empty($dadosForm['Espaco']['valor_hora'])){
                    $valor_hora = (float) str_replace(',', '.', $dadosForm['Espaco']['valor_hora']);
                    $dadosForm['Espaco']['valor_hora'] = $valor_hora;
                }

                $dadosForm['Espaco']['updated_at'] = date('Y-m-d H:i:s');
                $dadosForm['Endereco']['updated_at'] = date('Y-m-d H:i:s');
                
                $dataSource = $this->Espaco->getDataSource();
                
                $dataSource->begin();
                                
                $espaco = $this->Espaco->Endereco->save($dadosForm);
                
                if ($espaco) {
                    
                    $dadosForm['Espaco']['endereco_id'] = $espaco['Endereco']['id'];
                    
                    if ($this->Espaco->save($dadosForm)) {
                        $dataSource->commit();
                        $this->Flash->set('Alterado com Sucesso!', array(
                            'element' => 'bootstrap',
                            'key' => 'success'
                        ));
                        $this->redirect('/espacos');

                    } else {
                        throw new Exception("Erro ao tentar salvar o espaço!");
                    }
                } else {
                    throw new Exception("Erro ao tentar salvar o endereço!");
                }
            } else {
                $this->request->data = $this->getEspaco($id);
            }

        } catch (\Exception $e) {

            $dataSource->rollback();

            $this->Flash->set( $e->getMessage(), array(
                'element' => 'bootstrap',
                'key' => 'danger'
            ));

            $this->redirect('/espacos');
        } 
    }

    public function delete($id) 
    {
        try {

            $espaco = $this->getEspaco($id);
            
            if (empty($espaco)) {
                throw new Exception("Espaço não encontrado!");
            }

            $espaco['Espaco']['deleted_at'] = date('Y-m-d H:i:s');
            $espaco['Endereco']['deleted_at'] = date('Y-m-d H:i:s');

            $dataSource = $this->Espaco->getDataSource();
                
            $dataSource->begin();
                            
            $response = $this->Espaco->Endereco->save($espaco);
            
            if ($response) {

                $dadosForm['Espaco']['endereco_id'] = $response['Endereco']['id'];
                
                if ($this->Espaco->save($espaco)) {

                    $dataSource->commit();
                    $this->Flash->set('Excluído com Sucesso!', array(
                        'element' => 'bootstrap',
                        'key' => 'success'
                    ));
                    $this->redirect('/espacos');

                } else {
                    throw new Exception("Erro ao tentar excluir o espaço!");
                }
            } else {
                throw new Exception("Erro ao tentar excluir o endereço!");
            }

        } catch (\Exception $e) {

            $dataSource->rollback();

            $this->Flash->set( $e->getMessage(), array(
                'element' => 'bootstrap',
                'key' => 'danger'
            ));

            $this->redirect('/espacos');
        }
    }

    public function getEspaco($id) 
    {
        try {
            
            $conditions = array('Espaco.id' => $id);
    
            return $this->Espaco->find('first', compact('conditions'));

        } catch (\Exception $e) {

            throw $e->getMessage();
        }
    }

    public function getEstados()
    {
        try {

            $fields = array('Estado.id', 'Estado.sigla');
            $estados = $this->Espaco->Endereco->Estado->find('list', compact('fields'));

            return $estados;

        } catch (\Exception $e) {

            throw $e->getMessage();
        }
    }
}

?>