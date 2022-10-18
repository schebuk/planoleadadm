**Requerimentos:**

 - composer https://getcomposer.org
 - node 16.18.0 https://nodejs.org/en/
 - php 8.0
 
Caso esteja usando o windows recomendo usar o laragon

    https://laragon.org
    
**Instalação:**

  
clone o repositório

    git clone https://github.com/fagnerreis/Admin-PlanoLeads

Instale as dependências do laravel

    composer install

instale e de update nas dependências do vue.js

    npm install

copie o **.env.exemple** e renomeia pra **.env**

no **.env** configure as variáveis de acesso ao banco de dados

    DB_DATABASE=planolead
    DB_USERNAME=root    
    DB_PASSWORD=
 Nao esqueça de criar um banco com o mesmo nome que puser na variável
  
rode o npm run dev para gerar o app.js de vue

    npm run dev
caso esteja desenvolvendo rode npm run watch para nao ter que ficar gerando imagem a cada alteração

    npm run watch
agora para poder rodar a api do laravel gere as key de passport

    php artisan key:generate

para gerar as tabelas e os registros fake da tabela

    php artisan migrate

    php artisan db:seed

caso nao esteja usando o laragon ou nao tenha configurado o webserver

    php artisan serve
no **.env** coloque o caminho da aplicação na variável

    APP_URL=

a cada atualização rode isso para atualizar as dependências 
    composer install
    npm i 
