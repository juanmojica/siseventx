DROP TABLE IF EXISTS `espacos`;
DROP TABLE IF EXISTS `enderecos`;
DROP TABLE IF EXISTS `estados`;
DROP TABLE IF EXISTS `estruturas_basicas`;
DROP TABLE IF EXISTS `estruturas_adicionais`;
DROP TABLE IF EXISTS `servicos`;
DROP TABLE IF EXISTS `usuarios`;
DROP TABLE IF EXISTS `clientes`;

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

    KEY `endereco_estado_fk` (`estado_id`),
    CONSTRAINT `endereco_estado_fk` 
    FOREIGN KEY (`estado_id`) 
    REFERENCES `estados` (`id`) 
    ON DELETE CASCADE 
    ON UPDATE CASCADE
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

    KEY `espaco_endereco_fk` (`endereco_id`),
    CONSTRAINT `espaco_endereco_fk` 
    FOREIGN KEY (`endereco_id`) 
    REFERENCES `enderecos` (`id`) 
    ON DELETE CASCADE 
    ON UPDATE CASCADE
);

CREATE TABLE estruturas_basicas (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(200) NOT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  deleted_at TIMESTAMP NULL DEFAULT NULL
);

CREATE TABLE estruturas_adicionais (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(200) NOT NULL,
  valor DECIMAL(10,2) NOT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  deleted_at TIMESTAMP NULL DEFAULT NULL
);

CREATE TABLE servicos (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(200) NOT NULL,
    tipo ENUM('TRADICIONAL', 'PREMIUM') NULL DEFAULT NULL,
    quantidade_de_colaboradores INT NULL DEFAULT NULL,
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

INSERT INTO estruturas_basicas (nome) VALUES
('Palco'),
('Mesa para convidados'),
('Projetor'),
('Microfone'),
('PA');

INSERT INTO estruturas_adicionais (nome, valor) VALUES
('Flipcharts', 42.00),
('Backdrops', 225.00),
('Banner de boas vindas', 300.00),
('Telão de fundo para Palco', 150.00),
('Placas de mesa', 60.00);

INSERT INTO espacos (nome, telefone, limite_participantes, hora_inicio, hora_fim, valor_hora, endereco_id) VALUES
('Sala 01', '(11) 1234-5678', 50, '09:00:00', '18:00:00', 150.00, 1),
('Sala 02', '(11) 1234-5679', 30, '09:00:00', '18:00:00', 100.00, 2),
('Sala 03', '(11) 1234-5680', 80, '08:00:00', '17:00:00', 200.00, 3),
('Sala 04', '(11) 1234-5681', 20, '10:00:00', '19:00:00', 80.00, 4),
('Sala 05', '(11) 1234-5682', 100, '08:00:00', '20:00:00', 250.00, 5);

INSERT INTO servicos (nome, tipo, quantidade_de_colaboradores, valor) VALUES
('RECEPCAO', null, 1, 150.00),
('COFFEEBREAK', 'TRADICIONAL', null, 500.00),
('COFFEEBREAK', 'PREMIUM', null, 850.00);




/* DROP TABLE IF EXISTS `reservas`;
CREATE TABLE reservas (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  espaco_id INT NOT NULL,
  estruturas_adicionais_id INT,
  servicos_adicionais_id INT,
  nome_cliente VARCHAR(100) NOT NULL,
  cpf_cliente VARCHAR(11) NOT NULL,
  FOREIGN KEY (espaco_id) REFERENCES espacos(id),
  FOREIGN KEY (estruturas_adicionais_id) REFERENCES estruturas_adicionais(id),
  FOREIGN KEY (servicos_adicionais_id) REFERENCES servicos(id)
); */
