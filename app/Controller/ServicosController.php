<?php

App::uses('AppController', 'Controller');

class ServicosController extends AppController
{
    protected $paginate = array(
        'fields' => array(
            'id',
            'nome',
            'tipo',
            'quantidade_de_colaboradores',
            'valor'
        ),
        'conditions' => array('Servico.deleted_at' => NULL),
        'limit' => 10,
        'order' => array('Servico.nome' => 'asc')    
    );
    
    public function index()
    {
        try {

            if ($this->request->is('post')) {

                $filtro = $this->request->data['Servico']['nome_filtrar'];

                if (!empty($filtro)) {

                    $this->paginate['conditions']['or'] = array(
                        'Servico.nome LIKE' => '%' .trim($filtro) . '%'
                    );
                }
            } 

            $servicos = $this->paginate();
            
            $this->set( compact('servicos') );
            
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
            
                if(!empty($dadosForm['Servico']['valor'])){
                    $valor_hora = (float) str_replace(',', '.', $dadosForm['Servico']['valor']);
                    $dadosForm['Servico']['valor'] = $valor_hora;
                }
                            
                $this->Servico->create();
                
                if ($this->Servico->save($dadosForm)) {

                    $this->Flash->set('Salvo com Sucesso!', array(
                        'element' => 'bootstrap',
                        'key' => 'success'
                    ));

                    $this->redirect('/servicos/add');

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

            $this->request->data = $this->getServico($id);

            $disabled = true;

            $this->set(compact('disabled'));

        } catch (\Exception $e) {

            $this->Flash->set( $e->getMessage(), array(
                'element' => 'bootstrap',
                'key' => 'danger'
            ));

            $this->redirect('/servicos');
        }
    }

    public function edit($id = null) 
    {
        try {

            if (!empty($this->request->data)) {

                $dadosForm = $this->request->data;
                
                if(!empty($dadosForm['Servico']['valor'])){
                    $valor = (float) str_replace(',', '.', $dadosForm['Servico']['valor']);
                    $dadosForm['Servico']['valor'] = $valor;
                }

                $dadosForm['Servico']['updated_at'] = date('Y-m-d H:i:s');
                                                   
                if ($this->Servico->save($dadosForm)) {
                   
                    $this->Flash->set('Editado com Sucesso!', array(
                        'element' => 'bootstrap',
                        'key' => 'success'
                    ));

                    $this->redirect('/servicos');

                } else {
                    throw new Exception("Erro ao tentar editar o serviço!");
                }
                
            } else {
                $this->request->data = $this->getServico($id);
            }

        } catch (\Exception $e) {

            $this->Flash->set( $e->getMessage(), array(
                'element' => 'bootstrap',
                'key' => 'danger'
            ));

            $this->redirect('/servicos');
        } 
    }

    public function delete($id) 
    {
        try {

            $servico = $this->getServico($id);
            
            if (empty($servico)) {
                throw new Exception("Serviço não encontrado!");
            }

            $servico['Servico']['deleted_at'] = date('Y-m-d H:i:s');
                                                
            if ($this->Servico->save($servico)) {
                
                $this->Flash->set('Excluído com Sucesso!', array(
                    'element' => 'bootstrap',
                    'key' => 'success'
                ));

                $this->redirect('/servicos');

            } else {
                throw new Exception("Erro ao tentar excluir o servico!");
            }
          
        } catch (\Exception $e) {

            $this->Flash->set( $e->getMessage(), array(
                'element' => 'bootstrap',
                'key' => 'danger'
            ));

            $this->redirect('/servicos');
        }
    }

    public function getServico($id) 
    {
        try {

            $fields = array(
                'id',
                'nome',
                'tipo',
                'quantidade_de_colaboradores',
                'valor'
            );

            $conditions = array('Servico.id' => $id);
            
            return $this->Servico->find('first', array(
                'fields' => $fields,
                'conditions' => $conditions
            ));
            
        } catch (\Exception $e) {

            $this->Flash->set( $e->getMessage(), array(
                'element' => 'bootstrap',
                'key' => 'danger'
            ));

            $this->redirect('/servicos');
        }
    }
}

?>
