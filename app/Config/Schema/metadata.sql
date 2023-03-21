DROP TABLE IF EXISTS estruturas_basicas;
DROP TABLE IF EXISTS estruturas_adicionais;
DROP TABLE IF EXISTS reservas;
DROP TABLE IF EXISTS espacos;
DROP TABLE IF EXISTS enderecos;
DROP TABLE IF EXISTS estados;
DROP TABLE IF EXISTS servicos;
DROP TABLE IF EXISTS usuarios;
DROP TABLE IF EXISTS clientes;

CREATE TABLE estados (
  id INT PRIMARY KEY AUTO_INCREMENT,
  nome VARCHAR(100) NOT NULL,
  sigla CHAR(2) NOT NULL
);

CREATE TABLE enderecos (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    logradouro VARCHAR(255) NOT NULL,
    numero VARCHAR(20) NOT NULL,
    bairro VARCHAR(100) NOT NULL,
    cidade VARCHAR(100) NOT NULL,
    estado_id INT NOT NULL,
    cep VARCHAR(10) NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL DEFAULT NULL,

    FOREIGN KEY (estado_id) REFERENCES estados (id) 
);

CREATE TABLE espacos (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(200) NOT NULL,
    telefone VARCHAR(20) NOT NULL,
    limite_participantes INT NOT NULL,
    hora_inicio TIME NOT NULL,
    hora_fim TIME NOT NULL,
    valor_hora DECIMAL(10,2) NOT NULL,
    endereco_id INT NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL DEFAULT NULL,

    KEY espaco_endereco_fk (endereco_id),
    CONSTRAINT espaco_endereco_fk 
    FOREIGN KEY (endereco_id) 
    REFERENCES enderecos (id) 
    ON DELETE CASCADE 
    ON UPDATE CASCADE
);

CREATE TABLE estruturas (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(200) NOT NULL,
  tipo ENUM('BASICO', 'ADICIONAL'),
  valor DECIMAL(10,2) NOT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  deleted_at TIMESTAMP NULL DEFAULT NULL
);

CREATE TABLE servicos (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(200) NOT NULL,
    tipo ENUM('TRADICIONAL', 'PREMIUM') NOT NULL ,
    quantidade_de_colaboradores INT NOT NULL ,
    valor DECIMAL(10,2) NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL DEFAULT NULL
);

CREATE TABLE usuarios (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(100) NOT NULL,
  cpf VARCHAR(11) NOT NULL,
  email VARCHAR(100) NOT NULL UNIQUE,
  senha VARCHAR(100) NOT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  deleted_at TIMESTAMP NULL DEFAULT NULL
);

CREATE TABLE clientes (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(100) NOT NULL,
  cpf VARCHAR(11) NOT NULL,
  telefone VARCHAR(20) NOT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  deleted_at TIMESTAMP NULL DEFAULT NULL
);

CREATE TABLE reservas (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  valor DECIMAL(10, 2) NOT NULL,
  data_reserva DATE NOT NULL,
  hora_inicio TIME NOT NULL,
  hora_fim TIME NOT NULL,
  cliente_id INT NOT NULL,
  espaco_id INT NOT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  deleted_at TIMESTAMP NULL DEFAULT NULL,

  FOREIGN KEY (cliente_id) REFERENCES clientes (id), 
  FOREIGN KEY (espaco_id) REFERENCES espacos (id) 
  
);

CREATE TABLE reservas_servicos (
    reserva_id INT NOT NULL,
    servico_id INT NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL DEFAULT NULL,

    FOREIGN KEY (reserva_id) REFERENCES reservas(id),
    FOREIGN KEY (servico_id) REFERENCES servicos(id)
);

CREATE TABLE estruturas_reservas (
    reserva_id INT NOT NULL,
    estrutura_id INT NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL DEFAULT NULL,
    
    FOREIGN KEY (reserva_id) REFERENCES reservas(id),
    FOREIGN KEY (estrutura_id) REFERENCES estruturas(id)
);

INSERT INTO usuarios (nome, cpf, email, senha) VALUES
  ('João Silva', '12345678900', 'joao.silva@gmail.com', '123456'),
  ('Maria Santos', '98765432100', 'maria.santos@yahoo.com', '654321'),
  ('Pedro Almeida', '11122233344', 'pedro.almeida@hotmail.com', '111222'),
  ('Ana Oliveira', '55566677788', 'ana.oliveira@outlook.com', '555666');

INSERT INTO clientes (nome, cpf, telefone) VALUES
  ('João Silva', '12345678901', '11987654321'),
  ('Maria Santos', '23456789012', '21987654321'),
  ('Pedro Souza', '34567890123', '31987654321'),
  ('Ana Oliveira', '45678901234', '41987654321'),
  ('Lucas Pereira', '56789012345', '51987654321');

INSERT INTO estados (nome, sigla) VALUES
('Acre', 'AC'),
('Alagoas', 'AL'),
('Amapá', 'AP'),
('Amazonas', 'AM'),
('Bahia', 'BA'),
('Ceará', 'CE'),
('Distrito Federal', 'DF'),
('Espírito Santo', 'ES'),
('Goiás', 'GO'),
('Maranhão', 'MA'),
('Mato Grosso', 'MT'),
('Mato Grosso do Sul', 'MS'),
('Minas Gerais', 'MG'),
('Pará', 'PA'),
('Paraíba', 'PB'),
('Paraná', 'PR'),
('Pernambuco', 'PE'),
('Piauí', 'PI'),
('Rio de Janeiro', 'RJ'),
('Rio Grande do Norte', 'RN'),
('Rio Grande do Sul', 'RS'),
('Rondônia', 'RO'),
('Roraima', 'RR'),
('Santa Catarina', 'SC'),
('São Paulo', 'SP'),
('Sergipe', 'SE'),
('Tocantins', 'TO');

INSERT INTO enderecos (logradouro, numero, bairro, cidade, estado_id, cep) VALUES
('Rua A', '123', 'Centro', 'São Paulo', 25, '59300-000'),
('Avenida B', '456', 'Jardim', 'Rio de Janeiro', 19, '59300-000'),
('Rua C', '789', 'Boa Vista', 'Curitiba', 16, '59300-000'),
('Avenida D', '1010', 'Centro', 'Belo Horizonte', 13, '59300-000'),
('Rua E', '1111', 'Vila Nova', 'Porto Alegre', 21, '59300-000');

INSERT INTO estruturas (nome, tipo, valor) VALUES
('Palco', 'BASICO', 0.00),
('Mesa para convidados', 'BASICO', 0.00),
('Projetor', 'BASICO', 0.00),
('Microfone', 'BASICO', 0.00),
('PA', 'BASICO', 0.00),
('Flipcharts', 'ADICIONAL', 42.00),
('Backdrops', 'ADICIONAL', 225.00),
('Banner de boas vindas', 'ADICIONAL', 300.00),
('Telão de fundo para Palco', 'ADICIONAL', 150.00),
('Placas de mesa', 'ADICIONAL', 60.00);

INSERT INTO espacos (nome, telefone, limite_participantes, hora_inicio, hora_fim, valor_hora, endereco_id) VALUES
('Sala 01', '(11) 1234-5678', 50, '09:00:00', '18:00:00', 150.00, 1),
('Sala 02', '(11) 1234-5679', 30, '09:00:00', '18:00:00', 100.00, 2),
('Sala 03', '(11) 1234-5680', 80, '08:00:00', '17:00:00', 200.00, 3),
('Sala 04', '(11) 1234-5681', 20, '10:00:00', '19:00:00', 80.00, 4),
('Sala 05', '(11) 1234-5682', 100, '08:00:00', '20:00:00', 250.00, 5);

INSERT INTO servicos (nome, tipo, quantidade_de_colaboradores, valor) VALUES
('RECEPCAO', 'TRADICIONAL', 1, 150.00),
('COFFEEBREAK', 'TRADICIONAL', 30, 500.00),
('COFFEEBREAK', 'PREMIUM', 80, 850.00);

INSERT INTO reservas (valor, data_reserva, hora_inicio, hora_fim, cliente_id, espaco_id) VALUES 
  (100.00, '2023-03-25', '10:00:00', '18:00:00', 1, 1),
  (80.00, '2023-03-26', '14:00:00', '20:00:00', 2, 3),
  (150.00, '2023-03-27',  '09:00:00', '12:00:00', 3, 2),
  (200.00, '2023-04-01',  '12:00:00', '22:00:00', 4, 1),
  (120.00, '2023-04-03',  '15:00:00', '21:00:00', 5, 3),
  (90.00, '2023-04-05', '08:00:00', '18:00:00', 1, 2),
  (80.00, '2023-04-06',  '13:00:00', '17:00:00', 2, 1),
  (130.00, '2023-04-07',  '11:00:00', '15:00:00', 1, 3),
  (110.00, '2023-04-10',  '10:00:00', '19:00:00', 2, 2),
  (180.00, '2023-04-12',  '09:00:00', '16:00:00', 1, 1);

INSERT INTO reservas_servicos (reserva_id, servico_id) VALUES
  (1, 1), (1, 2), (2, 2), (2, 3), (3, 1), (3, 3), (4, 1), (4, 2), (5, 2), (5, 3), (6, 1), (6, 2), (7, 1), (8, 2), (8, 3),
  (9, 1), (9, 3), (6, 1), (6, 2);

INSERT INTO estruturas_reservas (reserva_id, estrutura_id) VALUES
  (1, 1), (1, 2), (2, 2), (2, 3), (3, 1), (3, 3), (4, 1), (4, 2), (5, 2), (5, 3), (6, 1), (6, 2), (7, 1), (8, 2), (8, 3),
  (9, 1), (9, 3), (6, 1), (6, 2);




