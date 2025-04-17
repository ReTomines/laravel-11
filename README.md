# Curso GRATUITO de Laravel 11.x

- :movie_camera: [Como Rodar o Framework?](https://www.youtube.com/watch?v=L_F7lVj_9AY&list=PLVSNL1PHDWvThyUgAgJoulpg5kB7GpYqS&index=2).


## Passo a passo para rodar o projeto
Clone o projeto (por branch)
```sh
git clone --branch <nome_branch> https://github.com/especializati/curso-laravel-11.git --single-branch <nome_pasta_raiz>
```
Entrar na pasta criada
```sh
cd <nome_pasta_raiz>
```


Crie o Arquivo .env
```sh
cp .env.example .env
```

*Atualize essas variáveis de ambiente no arquivo .env*
```dosini
APP_NAME="Especializa Ti"
APP_URL=http://localhost:8989

DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=nome_que_desejar_db
DB_USERNAME=nome_usuario
DB_PASSWORD=senha_aqui

CACHE_DRIVER=redis
QUEUE_CONNECTION=redis
SESSION_DRIVER=redis

REDIS_HOST=redis
REDIS_PASSWORD=null
REDIS_PORT=6379
```

Suba os containers do projeto
```sh
docker compose up -d
```


Acesse o container
```sh
docker compose exec app bash
```


Instale as dependências do projeto
```sh
composer install
```


Gere a key do projeto Laravel
```sh
php artisan key:generate
```
Executar as migrations
```sh
php artisan migrate
```

............................................................................................
## Iniciando um repositório no Git e conectando ao repositório do Github

Criar uma conta e um repositório no [github](https://github.com/)


Executar os comando de configuração antes do 1º commit 
```sh
git config --global user.email "suaContaDoGithub@gmail.com"      
git config --global user.name "IDdaSuaConta"
```

Inicia 1 novo repositório Git em um dir. local
```sh
git init 
```

Adicionar todos os arquivos de uma vez
```sh
git add . 
git status #Exibe o status atual do repositório.
git commit -m "digiteUmaMensagem" #Texto para dentificar a versão do commit
git log 
```

Renomeia a branch padrão do Git de MASTER para main
```sh
git branch -M main 
```

Criar link com repositório remoto
```sh
git remote add origin https://github.com/IDdaSuaConta/nomeRepositoro.git 
git push -u origin main #Enviar as alterações do reositório local para o repositório remoto
git log #Exibe todo o histórico de mudandas
```
............................................................................................
## Comandos úteis Docker/Laravel

Verificar versão do lavrável
```sh
php artisan --version
```

Atualizar docker-composer
```sh
composer update
```

Parar todos os containers Docker: 
```sh 
docker stop $(docker ps -q)
```

Deletar todos os containers Docker: 
```sh
docker rm $(docker ps -aq)
```

Deletar todos os volumes Docker: 
```sh
docker volume rm $(docker volume ls -q)
```

Deletar todas as networks Docker: 
```sh
docker network rm $(docker network ls -q)
```

Deletar todas as imagens Docker: 
```sh 
docker rmi [-f] $(docker images -q)
```

