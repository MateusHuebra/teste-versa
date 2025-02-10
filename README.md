# Teste para a empresa VersaTec

Feito com PHP 8.2 no Laravel 11 para o backend. Utilizando Laravel Breeze com Vue.js 3 para a integração com o frontend. Além de Laravel Sail para a dockerização.

## O projeto contém:

- CRUD de pessoas (com validação de campos e de CPF);
- Testes unitários;
- Tarefas agendadas por Scheduler;
- Docker (Laravel Sail);

## Como rodar o projeto:

Execute os comandos:

```bash
git clone https://github.com/MateusHuebra/teste-versa.git
cd teste-versa
composer install
npm install
cp .env.example .env
./vendor/bin/sail up -d
```

Caso haja um erro de portas ocupadas, desative temporariamente serviços como *apache2* e/ou *mysql* que podem estar usando-as no momento.

Agora para gerar a chave de encriptação e montar o banco de dados execute:

```bash
./vendor/bin/sail artisan key:generate
./vendor/bin/sail artisan migrate
./vendor/bin/sail npm run build
```

### Acessando o CRUD:

- Abra *http://0.0.0.0/*
- Clique em Register no canto superior direito da tela e crie uma conta;
- Clique em People na barra superior;

## Configurando Scheduler:

Para as tarefas agendadas funcionarem automaticamente é necessário configurar o *cron* seguindo os passos:

```bash
./vendor/bin/sail root-shell
apt-get update && apt-get install cron -y
service cron start
crontab -e
```

E inserir a linha abaixo no arquivo aberto pelo *cron* e salvar:

```bash
* * * * * cd /var/www/html && php artisan schedule:run >> /var/www/html/cronlog.txt 2>&1
```

A tarefa atual é só um exemplo de como informações (ou estatísticas) poderiam ser enviadas (ou guardadas) em algum lugar. Atualmente esse exemplo registra a cada 5 minutos as **Pessoas** com dados atualizados nos últimos 5 minutos no arquivo *storage/logs/laravel.log*.

## Rodando os Testes Unitários:

Na pasta base, fora do *docker*, execute:

```bash
./vendor/bin/sail artisan test
```
