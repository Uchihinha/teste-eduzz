# API para Negociação de Bitcoins

Esta aplicação tem como objetivo simular uma plataforma de negociação de bitcoins usando a API do [Mercado do Bitcoin](https://www.mercadobitcoin.com.br/).

O projeto foi todo desenvolvido em PHP usando o micro framework [Lumen](https://lumen.laravel.com/) em sua versão 7.2, tudo isso em um ambiente Dockerizado.

Toda a base de dados é PostgreSQL.

## Instalação e Configuração

Primeiramente, deve-se ter o Docker instalado no ambiente.

Assumindo isso, clone o projeto e inicie os containers.

```
docker-compose -f "docker-compose.yml" up -d --build
```

Copie todo o conteudo do arquivo .env.example para um arquivo chamado .env (já deixei exatamente configurado, com as credenciais do banco e com a chave do sendgrid para facilitar o processo).

Se conecte ao container da **aplicação** e rode os seguintes comandos:

```
composer install
sudo /usr/sbin/crond -l 8
php /var/www/app/artisan queue:listen &
php artisan migrate
php artisan jwt:secret
```

Explicando cada comando...

* ``composer install`` irá instalar as dependências do projeto;
* ``sudo /usr/sbin/crond -l 8`` irá habilitar a execuação da cron que ficará monitorando a cotação do bitcoin de 10 em 10 minutos para montar o histórico;
* ``php /var/www/app/artisan queue:listen &`` irá ligar a fila que ficará responsável por enviar os emails;
* ``php artisan migrate`` criará todas as tabelas do banco de dados através do Eloquent, o ORM do framework;
* ``php artisan jwt:secret`` gerará a key que será usada para autenticação da aplicação;

Após tudo isso configurado, o ambiente estará rodando na porta 8080, pode ser acessada sua página inicial em [http://localhost:8080](http://localhost:8080).

A documentação em JSON pode ser encontrada [aqui](https://www.postman.com/collections/a71fc94cf7a7101c4130), basta fazer o download e importar no postman.

## Recursos Utilizados

Toda a parte de autenticação foi feita utilizando JWT (JSON Web Token).

Os emails da aplicação são disparados pela fila baseada em banco de dados, fornecida pelo próprio framework.

Todos os códigos de identificação de todas as entidades do sistemas são criptografadas no momento do retorno à interface, para melhorar a segurança.

Está configurada uma cron job para gerar o histórico de cotação do bitcoin.

Possui um sistema de Logs, o qual registra request, resposta e IP de origem de todas as requisições feitas para o servidor, pode ser encontrado na tabela *logs* no banco de dados.

## Arquitetura e Patterns

A aplicação foi desenvolvida baseada no MVC, fazendo adição de uma camada de Services, para uma melhor organização do sistema.

O código foi feito respeitando o código PSR (PHP Standards Recommendations).

Utilizados também SOLID, DRY, Object Calisthenics.

## Sobre o Desafio

Achei o desafio interessantíssimo, um tanto quanto complexo, dando liberdade para o uso devárias tecnologias, achei uma ótima maneira de se avaliar o nível de um programador.

E além de tudo, ainda mexeu com um tema que me interesso muito, investimentos e criptomoedas (as quais já tenho em minha carteira kk).
