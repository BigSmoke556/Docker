

# Sistema de Gerenciamento de Empresas e Tarefas

Este sistema permite o gerenciamento de empresas, usuários e tarefas, com controle de permissões e operações específicas para cada perfil. O objetivo é facilitar a administração de tarefas entre diferentes usuários vinculados a empresas.

## Tecnologias utilizadas
- **Backend:** Laravel 8.x (PHP 7.4)
- **Frontend:** Vue.js 2.6.14
- **Bibliotecas Frontend:** PrimeVue 2.9.0, Vue Router 3.6.5
- **Node.js:** 16.x
- **Banco de dados:** MySQL 8.0
- **Containerização:** Docker (imagens PHP 7.4, Node 16, MySQL 8) e Docker Compose

# Como rodar o projeto com Docker

Este projeto utiliza Docker para facilitar o ambiente de desenvolvimento e execução. Siga os passos abaixo para iniciar o ambiente:

## Pré-requisitos
- [Docker](https://www.docker.com/get-started) instalado
- [Docker Compose](https://docs.docker.com/compose/install/) instalado

## Subindo os containers

Execute o comando abaixo na raiz do projeto para iniciar os serviços:

```powershell
docker-compose up -d
```

Isso irá iniciar os containers definidos no arquivo `docker-compose.yml`.


## Comandos úteis

Após subir os containers, você pode executar comandos dentro do container do backend. 

```powershell
php artisan key:generate --force || true
php artisan migrate --force || true
```

Esses comandos geram a chave da aplicação e executam as migrações do banco de dados.

### Comandos personalizados

#### Criar wizard de usuário da empresa

O comando abaixo cria um wizard para usuários da empresa:

```powershell
php artisan make:company-user-wizard
```

Esse comando irá gerar um wizard interativo para criação de usuários vinculados a uma empresa. Siga as instruções exibidas no terminal para preencher os dados necessários.


#### Criar tarefa para empresa

O comando abaixo permite criar uma nova tarefa para uma empresa:

```powershell
php artisan company:create-task
```

Ao executar este comando, você será guiado por prompts para informar os dados da tarefa e da empresa relacionada. Preencha conforme solicitado para concluir a criação da tarefa.

> **Importante:** Apenas o usuário de id 1 de cada empresa possui permissão para criar tarefas para os demais usuários da mesma empresa. Usuários com outros ids não conseguem criar tasks para outros membros.

## Parando os containers

Para parar todos os containers, execute:

```powershell
docker-compose down
```


## Portas e URLs dos serviços

Os serviços utilizam as seguintes portas:

- **Banco de dados (MySQL):** 33060 (externa) → 3306 (container)
- **Backend (Laravel):** 8000 (externa) → 8000 (container)
- **Frontend (Vue.js):** 8080 (externa) → 8080 (container)

### URLs para acessar os serviços

- **Frontend:**
	- http://localhost:8080

O frontend está disponível em `http://localhost:8080` após subir os containers. Ele se comunica automaticamente com o backend na porta 8000.

---

---

*Para mais informações, consulte a documentação dos serviços individuais em `backend/README.md` e `frontend/README.md`.*