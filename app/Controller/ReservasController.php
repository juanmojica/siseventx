<?php

App::uses('AppController', 'Controller');

class ReservasController extends AppController
{
    protected $paginate = array(
        'fields' => array(
            'id',
            'data_reserva',
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
        'limit' => 30,
        'order' => array(
            'Espaco.nome' => 'asc', 
            'Reserva.data_inicio' => 'asc'
        )    
    );
    
    public function index()
    {
        try {
            
            if ($this->request->is('post')) {
                
                $filtro = $this->request->data['Reserva']['data_filtrar'];

                if (!empty($filtro)) {

                    $this->paginate['conditions']['or'] = array(
                        'DATE(Reserva.data_reserva)' => $filtro
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
            
            $espaco = $this->getEspaco($id);
           
            $servicos = $this->getServicos();
            
            $estruturas = $this->getEstruturas();

            $clientesNome = $this->getClientes('nome');

            $clientesCpf = $this->getClientes('cpf');

            $estados = $this->getEstados();

            $this->set( compact('espaco', 'servicos', 'estruturas', 'clientesNome', 'clientesCpf', 'estados'));
            
            if (!empty($this->request->data)) {

                $dadosForm['Reserva'] = $this->request->data['Reserva'];

                $dadosForm['Reserva']['cliente_id'] = $this->request->data['Cliente']['id']['cpf'];

                $dadosForm['Reserva']['espaco_id'] = $this->request->data['Espaco']['id'];

                if(!empty($dadosForm['Reserva']['valor'])){

                    $valor = str_replace("R$ ", "", $dadosForm['Reserva']['valor']);

                    $valor = (float) str_replace(',', '.', $valor);

                    $dadosForm['Reserva']['valor'] = $valor;
                }

                $dataSource = $this->Reserva->getDataSource();
                
                $dataSource->begin();

                $this->Reserva->create();

                $reserva = $this->Reserva->save($dadosForm);

                if( !$reserva ) {
                    throw new Exception("Erro ao tentar salvar a reserva!");
                }

                $servicos = $this->request->data['Servico'];

                foreach ($servicos as $key => $servico) {
                    if ($servico == '1') {
                        $dadosForm['Servico'][$key]['servico_id'] = $key;
                        $dadosForm['Servico'][$key]['reserva_id'] = $reserva['Reserva']['id'];

                        if( !$this->Reserva->ReservasServico->save($dadosForm['Servico'][$key]) ) {
                            throw new Exception("Erro ao tentar salvar os servicos!");
                        }
                    }
                }

                $estruturas = $this->request->data['Estrutura'];
              
                foreach ($estruturas as $key => $estrutura) {
                    if ($estrutura == '1') {
                        $dadosForm['Estrutura'][$key]['estrutura_id'] = $key;
                        $dadosForm['Estrutura'][$key]['reserva_id'] = $reserva['Reserva']['id'];

                        if( !$this->Reserva->EstruturasReserva->save($dadosForm['Estrutura'][$key]) ) {
                            throw new Exception("Erro ao tentar salvar as estruturas!");
                        }
                    }
                }

                $dataSource->commit();

                $this->Flash->set( 'Salvo com sucesso!', array(
                    'element' => 'bootstrap',
                    'key' => 'success'
                ));

                $this->redirect('/reservas');
            }
        } catch (\Exception $e) {

            if (isset($dataSource)) {
                $dataSource->rollback();
            }

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

            if (isset($dataSource)) {
                $dataSource->rollback();
            }

            if (isset($dadosForm)) {
                $this->request->data = $dadosForm;
            }

            $this->Flash->set( $e->getMessage(), array(
                'element' => 'bootstrap',
                'key' => 'danger'
            ));
        }
    }

    public function edit($id = null) 
    {
        try {
            
            if (!empty($this->request->data)) {

                $dadosForm['Reserva'] = $this->request->data['Reserva'];

                $dadosForm['Reserva']['cliente_id'] = $this->request->data['Cliente']['id']['cpf'];

                $dadosForm['Reserva']['espaco_id'] = $this->request->data['Espaco']['id'];

                if(!empty($dadosForm['Reserva']['valor'])){

                    $valor = str_replace("R$ ", "", $dadosForm['Reserva']['valor']);

                    $valor = (float) str_replace(',', '.', $valor);

                    $dadosForm['Reserva']['valor'] = $valor;
                }

                $dadosForm['Reserva']['updated_at'] = date('Y-m-d H:i:s');

                $dataSource = $this->Reserva->getDataSource();
                
                $dataSource->begin();

                $reserva = $this->Reserva->save($dadosForm);

                if( !$reserva ) {
                    throw new Exception("Erro ao tentar salvar a reserva!");
                }

                if (isset($this->request->data['Servico'])) {

                    $servicos = $this->request->data['Servico'];

                    foreach ($servicos as $key => $servico) {
                        if ($servico == '1') {
                            $dadosForm['Servico'][$key]['servico_id'] = $key;
                            $dadosForm['Servico'][$key]['reserva_id'] = $reserva['Reserva']['id'];
    
                            if( !$this->Reserva->ReservasServico->save($dadosForm['Servico'][$key]) ) {
                                throw new Exception("Erro ao tentar salvar os servicos!");
                            }
                        }
                    }
                }
              
                if (isset($this->request->data['Estrutura'])) {

                    $estruturas = $this->request->data['Estrutura'];

                    foreach ($estruturas as $key => $estrutura) {
                        if ($estrutura == '1') {
                            $dadosForm['Estrutura'][$key]['estrutura_id'] = $key;
                            $dadosForm['Estrutura'][$key]['reserva_id'] = $reserva['Reserva']['id'];

                            if( !$this->Reserva->EstruturasReserva->save($dadosForm['Estrutura'][$key]) ) {
                                throw new Exception("Erro ao tentar salvar as estruturas!");
                            }
                        }
                    }
                }

                $dataSource->commit();

                $this->Flash->set( 'Salvo com sucesso!', array(
                    'element' => 'bootstrap',
                    'key' => 'success'
                ));

                $this->redirect('/reservas');

            } else {

                $reserva = $this->request->data = $this->getReserva($id);
               
                $espaco = $this->getEspaco($reserva['Espaco']['id']);
                
                $servicos = $this->getServicos();
                
                $estruturas = $this->getEstruturas();

                $clientesNome = $this->getClientes('nome');

                $clientesCpf = $this->getClientes('cpf');

                $estados = $this->getEstados();

                $this->set( compact('espaco', 'servicos', 'estruturas', 'clientesNome', 'clientesCpf', 'estados'));
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
                'limit' => 30,
                'order' => array(
                    'Espaco.nome' => 'asc', 
                    'Reserva.data_inicio' => 'asc'
                ),
                'group' => array('Espaco.id')    
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

    public function getReserva($id) 
    {
        try {

            $fields = array(
                'Reserva.id',
                'Reserva.data_reserva',
                'Reserva.hora_inicio',
                'Reserva.hora_fim',
                'Reserva.valor'
            );

            $contain = array(
                'Espaco' => array(
                    'fields' => array(
                        'nome',
                        'Espaco.nome',
                        'telefone',
                        'limite_participantes',
                        'hora_inicio',
                        'hora_fim',
                        'valor_hora',
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
                        'id',
                        'nome',
                        'cpf'
                    )
                ),
                'Servico' => array(
                    'fields' => array(
                        'id'
                    )
                ),
                'Estrutura' => array(
                    'fields' => array(
                        'id'
                    )
                ),
            );

            $conditions = array('Reserva.id' => $id);
            
           return $this->Reserva->find('first', array(
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


}

?>