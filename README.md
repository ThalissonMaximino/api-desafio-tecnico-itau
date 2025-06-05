# api-desafio-tecnico-itau

Este é um projeto de API RESTful desenvolvido em PHP utilizando o framework Slim, com o objetivo de gerenciar transações e fornecer estatísticas.

## Funcionalidades da API

A API oferece os seguintes endpoints:

* **`POST /transacao`**: Cria uma nova transação.
* **`GET /transacao/{id}`**: Retorna os detalhes de uma transação específica pelo seu ID.
* **`DELETE /transacao/{id}`**: Deleta uma transação específica pelo seu ID.
* **`DELETE /transacao`**: Deleta **todas** as transações cadastradas.
* **`GET /estatistica`**: Retorna estatísticas (soma, média, mínimo, máximo e contagem) das transações realizadas nos últimos 60 segundos.

## Estrutura do Projeto

O projeto segue uma estrutura MVC (Model-View-Controller) simplificada para APIs:

* **`src/Controller`**: Contém a lógica de controle das requisições e respostas.
* **`src/DAO`**: Responsável pela interação com o banco de dados.
* **`src/Model`**: Define a estrutura dos objetos de domínio (transações).
* **`src/config`**: Contém a configuração de conexão com o banco de dados.
* **`src/routes`**: Define as rotas da API.
* **`public`**: Contém o arquivo `index.php`, o ponto de entrada da aplicação.

## Como Executar o Projeto

1.  **Clone o repositório:**
    ```bash
    git clone [https://github.com/ThalissonMaximino/api-desafio-tecnico-itau.git](https://github.com/ThalissonMaximino/api-desafio-tecnico-itau.git)
    cd api-desafio-tecnico-itau
    ```

2.  **Instale as dependências do Composer:**
    ```bash
    composer install
    ```

3.  **Configuração do Banco de Dados:**
    * Crie um banco de dados (ex: SQLite, MySQL, PostgreSQL).
    * Edite o arquivo `src/config/conection.php` com as credenciais e configurações do seu banco de dados.
    * Execute o script SQL para criar a tabela `transacao` (você precisará criar este script se ainda não o tiver). Um exemplo básico para SQLite seria:
        ```sql
        CREATE TABLE transacao (
            ID VARCHAR(36) PRIMARY KEY,
            VALOR DECIMAL(10, 2) NOT NULL,
            DATE_OP DATETIME NOT NULL
        );
        ```

4.  **Servidor Web:**
    * Configure um servidor web (como Apache ou Nginx) para apontar para a pasta `public/`.
    * Alternativamente, para desenvolvimento local, você pode usar o servidor web embutido do PHP:
        ```bash
        php -S localhost:8000 -t public
        ```

## Testando a API

Você pode usar ferramentas como Postman, Insomnia ou cURL para testar os endpoints.

**Exemplos (usando `localhost:8000`):**

* **POST /transacao**
    ```
    curl -X POST -H "Content-Type: application/json" -d '{"id": "a1b2c3d4-e5f6-7890-1234-567890abcdef", "valor": 10.50, "dataHora": "2025-06-05 15:30:00"}' http://localhost:8000/transacao
    ```

* **GET /transacao/{id}**
    ```
    curl http://localhost:8000/transacao/a1b2c3d4-e5f6-7890-1234-567890abcdef
    ```

* **GET /estatistica**
    ```
    curl http://localhost:8000/estatistica
    ```
