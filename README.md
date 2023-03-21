# Sistema de Gestão de Reservas de Locais para Eventos

Este é um sistema web para gerenciamento de reservas de locais para eventos. Ele foi desenvolvido utilizando as seguintes tecnologias:

- PHP 7.4
- MySQL 8
- Bootstrap 4.3
- jQuery 3.3.1
- Dompdf

## Pré-requisitos

Para rodar este sistema em sua máquina local, você precisará ter instalado:

- PHP 7.4
- MySQL 8
- Composer

## Instalação

1. Clone este repositório para sua máquina local:
    git clone https://github.com/juanmojica/siseventx.git


2. Entre na pasta do projeto e rode o Composer para instalar as dependências:
    cd siseventx
    composer install

3. Crie um banco de dados MySQL para o sistema, configure o `database.php` com as infomrções do seu banco e em 
seguida e importe o arquivo `siseventx/app/Config/Schema/metadata.sql`.

## Funcionalidades

O SisEventX oferece as seguintes funções:

- Cadastrar locais de eventos
- Cadastrar Estruturas para os eventos
- Cadastrar Serviços para os eventos
- Reservar locais para eventos
- Gerar relatórios em PDF das reservas


