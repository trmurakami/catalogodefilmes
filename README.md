# Catálogo de filmes
Software livre para gestão de acervos de filmes

## Dependencias

- [Apache 2](https://httpd.apache.org/)
- [PHP > 7](https://www.php.net/)
- [Elasticsearch > 7.2](https://www.elastic.co/pt/products/elasticsearch)

## Instalação no Linux

```
curl -s http://getcomposer.org/installer | php
php composer.phar install --no-dev
```

Copiar o arquivo inc/config.demo.php para inc/config.php

```
cd inc/
cp config.demo.php config.php
```

Editar o arquivo config.php

## Instalação no Windows

Baixar a [versão compilada]() e extrair do zip

Entrar no diretório elasticsearch/bin e executar o elasticsearch.bin

Aguardar o Elasticsearch carregar (A primeira execução demora mais do que as demais)

Executar o arquivo catalogodefilmes.exe

Obs: A versão Windows só é possível graças ao [PHP Desktop](https://github.com/cztomczak/phpdesktop)

## Doação

Você pode ajudar o projeto doando qualquer quantia: [Pagseguro](https://pag.ae/7VbJhhRHP)



