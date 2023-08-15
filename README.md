# Introdução do projeto Back-end Desenvolvimento Laravel

Este projeto possui 3 entidades(funcionarios,departamentos,tarefas) e para cada entidade suporta operações de (criar, ler, atualizar e excluir).

A Aplicação contém Autenticação padrão do Laravel, a onde somente usuario que estão no banco de dados na tabela users conseguem acessar e suporta operações de (criar, ler, atualizar e excluir).

A Aplicação também possui E-mail de Verificação o botão pra essa ação está na tela de *Gerenciar Usúarios* e utilizei o Notifications pra disparar a notificação e usei o service (Mailtrap) vocÊ pode utilizar outros serviços pra testar (se quiser).

exemplo: 
```dosini
MAIL_MAILER=smtp
MAIL_HOST=smtp.example.io
MAIL_PORT=2525
MAIL_USERNAME=exampleUser
MAIL_PASSWORD=examplePassword
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=example@example.com
MAIL_FROM_NAME="${APP_NAME}"
```

A Aplicação contém relação da entidade funcionarios com departamentos, e tarefas com funcionarios pra isso ocorrer de forma otimizada e com melhor desempenho utilizei o Eager Loading nas Models (task,employee) (ORM).

A Aplicação contém tratamento de erros e campos obrigatório de cada entidade, e também do usúario.

Existe a relação entre as tabelas, entretanto não é obrigatório que o relacionamento seja obrigatório na hora da criação de alguma entidade.

- Entidade funcionário:
* id: Número inteiro auto-incrementado
* firstName: String, obrigatório
* lastName: String, obrigatório
* email: String, obrigatório, deve ser único
* phone: String, opcional
* department_id: Chave estrangeira, relacionada ao modelo Departamento

- Departamento:
* id: Número inteiro auto-incrementado
* name: String, obrigatório

- Tarefa:
* id: Número inteiro auto-incrementado
* title: String, obrigatório
* description: String, opcional
* assignee_id: Chave estrangeira, relacionada ao modelo Funcionário
* due_date: DateTime, opcional

Criei uma Middleware simples pra verificar se o usúario adm fez logout | login, sendo assim é possivel implementar na middleware um ACL futuramente.

Implementei paginação com o proprio recurso do Laravel em todas as views que existem all.

Implementei teste com PHPUnit pra validar as 3 entidades nos métodos de (create,read,update,delete) e também nas chamadas e navegação das paginas após o Login, optei por deixar padrão os nomes dos testes pra cada entidade.

exemplo:

`php artisan test --filter UserControllerTest::testLogin` - estou acessando a pasta tests/Feature pra testar recursividade do sistema e entro na entidade do teste que eu quero testar e passo o método, acaso queira testar por controller só retirar o método.
 
# Introdução para executar o projeto

### 1) Clone o projeto
`git clone https://github.com/GuilhermeAlamino/pricemet.git`

### 2) Navegue até o diretório
`cd pricemet`

### 3) Instale os pacotes e dependências
`Composer install ou Composer update`

### 4) Crie seu Banco de dados e Atualize `*(.env)*` laravel, vai existir o `*.env.example*` crie um arquivo `*(.env)*` portanto não esqueça de criar um banco de dados e deixar o mesmo nessa variável `*DB_DATABASE*`

exemplo:
```dosini
DB_DATABASE=company_management
DB_USERNAME=root
DB_PASSWORD=
```

### 5) Gere a key do laravel
`php artisan key:generate`

### 6) Rode as migrações do Banco de dados
`php artisan migrate`

### 7) Execute a o projeto Laravel com o seguinte comando, optei por rodar na porta 8001.
`php artisan serve --port=8001`

### 8) Está é URL que está rodando a aplicação acesse:
`http://127.0.0.1:8001 ou http://localhost:8001/`

### Observações:
`O acesso para os usuários do sistema serão o e-mail da tabela users e a senha: password no faker`
