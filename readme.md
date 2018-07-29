# Contacta Max | Teste

Este sistema foi criado em PHP 7.0 e Maria DB 10.1,  utilizando o [Laravel Framework](http://laravel.com).

-- --

## Instalação

### Primeiro passo
Clone o repositório ou faça download para seu localhost ou servidor de preferência. Para isto basta clicar em "Clone or download" > "Download ZIP" ou executar os seguinte comando em seu terminal:

```
git clone https://github.com/adrisonluz/contacta-max.git
```

### Segundo passo
Agora é necessário baixar as dependências do sistema. Para isto, utilizamos o [Composer](https://getcomposer.org/), consulte caso você não tenha familiaridade com o Composer. Execute o seguinte comando no terminal:

```
composer update
```

### Terceiro passo
Agora vamos editar nosso arquivo ".env", o qual é responsável pelas informações indispensáveis para que o sistema funcione corretamente. Para isso basta editar ou cópiar o arquivo ".env.exemple". Retire o final ".exemple" do arquivo deixando apenas como ".env".

Edite o arquivo ".env" com as informações corretas de seu localhost ou servidor. Caso tenha dúvida do que ou como editar, basta editar apenas as seguintes variáveis para que o sistema funcione corretamente para testes:

```
APP_ENV=local  
APP_DEBUG=true  
APP_KEY=SomeRandomString  
APP_URL=http://localhost  
APP_TIMEZONE=UTC  
APP_LOCALE=en

DB_CONNECTION=mysql   
DB_HOST=127.0.0.1    
DB_PORT=3306   
DB_DATABASE=homestead   
DB_USERNAME=homestead    
DB_PASSWORD=secret
```

Obs: Não esqueça de criar o banco de dados citado nas configurações de sua aplicação.

### Quarto passo
Com o banco de dados devidamente configurado, agora precisamos criar as tabelas e alimentá-las com o básico para rodar o sistema. Basta rodar os seguintes comandos:

```
php artisan key:generate
php artisan migrate  
php artisan db:seed --class=DatabaseSeeder
```

### Quinto passo
Se tudo estiver correto, você já pode acessar o sistema utilizando o usuário "Teste". Abaixo você tem o email e senha gerado pelo Seed do quarto passo.

user@teste.com  
teste1234

Obs: Caso seu localhost ou servidor não rode o sistema corretamente, você pode tentar acessá-lo pelo servidor imbutido, executando o comando abaixo e acessando o sistema pelo link http://localhost:8000.

```
php artisan serve
```

## Utilização da API
A primeira autenticação deve ser feita via login na api, utilizando os parametros "email" e "password", sendo os mesmos enviados no body via POST.

Após logado, o sistema retorna um token para que o usuário possa acessar as demais rotas. O sistema utiliza o JWT para autenticação via token, sendo necessário passar o header "Authorization" com o valor "Bearer {access_token}". 

Para se adicionar ou remover produtos do estoque, deve-se enviar o id ou sku do produto para a identificação e o parâmetro "quantity" com o valor da quantidade a ser alterada.


## Contato
[AdrisonLuz.Com](http://adrisonluz.com)  
[Contato@AdrisonLuz.Com](mailto:contato@adrisonluz.com)
