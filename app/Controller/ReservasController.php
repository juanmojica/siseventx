<?php

App::uses('AppController', 'Controller');

class ReservasController extends AppController
{
    protected $paginate = array(
        'fields' => array(
            'id',
            'data_inicio',
            'data_fim',
            'hora_inicio',
            'hora_fim',
            'valor'
        ),
        'contain' => array(
            'Espaco' => array(
                'fields' => array(
                    'nome'
                ),
                'Endereco' => array(
                    'fields' => array(
                        'logradouro',
                        'numero',
                        'bairro',
                        'cidade',
                    ),
                    'Estado' => array(
                        'fields' => 'sigla'
                    )
                )
            ),
            'Cliente' => array(
                'fields' => array(
                    'nome',
                    'cpf'
                )
            ),
        ),
        'conditions' => array('Reserva.deleted_at' => NULL),
        'limit' => 10,
        'order' => array(
            'Espaco.nome' => 'asc', 
            'Reserva.data_inicio' => 'asc'
        )    
    );
    
    public function index()
    {
        try {
            
            if ($this->request->is('post')) {
                
                $filtro = $this->request->data['Reserva']['nome_filtrar'];

                if (!empty($filtro)) {

                    $this->paginate['conditions']['or'] = array(
                        'Reserva.nome LIKE' => '%' .trim($filtro) . '%'
                    );
                }
            } 

            $reservas = $this->paginate();
            
            $this->set( compact('reservas') );
            
        } catch (\Exception $e) {

            $this->Flash->set($e->getMessage());

            $this->redirect(array(
                'controller' => 'pages',
                'action' => 'home',
                '?' => array('erro' => true)
            ));
        }
    }

    public function add($id) 
    {
        try {
            if ($this->request->data) {
                pr($this->request->data);exit;
            }
            
            $espaco = $this->getEspaco($id);

            $servicos = $this->getServicos();
            
            $estruturas = $this->getEstruturas();

            $clientesNome = $this->getClientes('nome');
            $clientesCpf = $this->getClientes('cpf');

            $estados = $this->getEstados();

            $this->set( compact('espaco', 'servicos', 'estruturas', 'clientesNome', 'clientesCpf', 'estados'));
            
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

            $this->request->data = $this->getEspaco($id);

            $estados = $this->getEstados(array(
                'Estado.id' => $this->request->data['Endereco']['estado_id']
            ));

            $disabled = true;
           
            $this->set(compact('estados', 'disabled'));

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
                        $this->Flash->set('Editado com Sucesso!', array(
                            'element' => 'bootstrap',
                            'key' => 'success'
                        ));
                        $this->redirect('/espacos');

                    } else {
                        throw new Exception("Erro ao tentar editar o espaço!");
                    }
                } else {
                    throw new Exception("Erro ao tentar editar o endereço!");
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

            $fields = array(
                'Espaco.id',
                'Espaco.nome',
                'Espaco.telefone',
                'Espaco.limite_participantes',
                'Espaco.hora_inicio',
                'Espaco.hora_fim',
                'Espaco.valor_hora',
                'Endereco.logradouro',
                'Endereco.numero',
                'Endereco.bairro',
                'Endereco.cidade',
                'Endereco.cep',
                'Endereco.estado_id',
            );

            $contain = array(
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
            );

            $conditions = array('Espaco.id' => $id);
            
            return $this->Reserva->Espaco->find('first', array(
                'fields' => $fields,
                'contain' => $contain,
                'conditions' => $conditions
            ));
            

        } catch (\Exception $e) {

            $this->Flash->set( $e->getMessage(), array(
                'element' => 'bootstrap',
                'key' => 'danger'
            ));

            $this->redirect('/espacos');
        }
    }

    public function getEspacos($conditions = null)
    {
        try {

            $this->paginate = array(
                'fields' => array(
                    'id'
                ),
                'contain' => array(
                    'Espaco' => array(
                        'fields' => array(
                            'nome',
                            'telefone',
                            'limite_participantes',
                            'hora_inicio',
                            'hora_fim',
                            'valor_hora'
                        ),
                        'Endereco' => array(
                            'fields' => array(
                                'logradouro',
                                'numero',
                                'bairro',
                                'cidade',
                            ),
                            'Estado' => array(
                                'fields' => 'sigla'
                            )
                        )
                    )
                ),
                'conditions' => array('Reserva.deleted_at' => NULL),
                'limit' => 10,
                'order' => array(
                    'Espaco.nome' => 'asc', 
                    'Reserva.data_inicio' => 'asc'
                )    
            );

            if (isset($conditions)) {

                $this->paginate['conditions']['or'] = $conditions;
            } 

            $espacos = $this->paginate();

            return $espacos;

        } catch (\Exception $e) {

            $this->Flash->set( $e->getMessage(), array(
                'element' => 'bootstrap',
                'key' => 'danger'
            ));

            $this->redirect('/espacos');
        }
    }

    public function listarEspacos()
    {
        try {

            $conditions = null;
            
            if ($this->request->is('post')) {
                
                $filtro = $this->request->data['Espaco']['nome_filtrar'];
                
                if (!empty($filtro)) {

                    $conditions = array(
                        'Espaco.nome LIKE' => '%' .trim($filtro) . '%'
                    );

                } 
            } 

            $espacos = $this->getEspacos($conditions);
            
            $this->set(compact('espacos'));

        } catch (\Exception $e) {

            $this->Flash->set( $e->getMessage(), array(
                'element' => 'bootstrap',
                'key' => 'danger'
            ));

            $this->redirect('/reservas');
        }
    }

    public function getServicos()
    {
        try {

            return $this->Reserva->Servico->query(
                'select id, nome, tipo, quantidade_de_colaboradores, valor from servicos as Servico'
            );

        } catch (\Exception $e) {

            $this->Flash->set( $e->getMessage(), array(
                'element' => 'bootstrap',
                'key' => 'danger'
            ));

            $this->redirect('/reservas');
        }
    }

    public function getEstruturas()
    {
        try {
            
            return $this->Reserva->Estrutura->query(
                'select id, nome, tipo, valor from estruturas as Estrutura ORDER BY tipo, nome'
            );

        } catch (\Exception $e) {

            $this->Flash->set( $e->getMessage(), array(
                'element' => 'bootstrap',
                'key' => 'danger'
            ));

            $this->redirect('/reservas');
        }
    }

    public function getClientes($field)
    {
        try {
            
            $fields = array('Cliente.id', 'Cliente.' . $field);

            return $this->Reserva->Cliente->find('list', array(
                'fields' => $fields,
            ));

        } catch (\Exception $e) {

            $this->Flash->set( $e->getMessage(), array(
                'element' => 'bootstrap',
                'key' => 'danger'
            ));

            $this->redirect('/reservas');
        }
    }

    public function getEstados($conditions = null)
    {
        try {

            $fields = array('Estado.id', 'Estado.sigla');

            $estados = $this->Reserva->Espaco->Endereco->Estado->find('list', array(
                'fields' => $fields,
                'conditions' => $conditions,
            ));

            return $estados;

        } catch (\Exception $e) {

            $this->Flash->set( $e->getMessage(), array(
                'element' => 'bootstrap',
                'key' => 'danger'
            ));

            $this->redirect('/espacos');
        }
    }

}

?>