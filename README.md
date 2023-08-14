# desafio-creditares

O desafio consiste em desenvolver uma API e um sistema FrontEnd para busca e armazenamento de CEPs. Quando o CEP buscado não é encontrado no banco de dados local, o sistema deve consumir uma API externa e armazenar o resultado encontrado.

#### Stack

As tecnologias que foram definidas para o desenvolvimento do sistema:

- Laravel 9
- Php 8
- MySQL 8
- Nodejs 16
- Quasar v2
- Vue 3

#### Requisitos

Com o serviço conteinerizado, os únicos requisitos são:

- docker-compose
- GNU Make

#### Procedimento

Para subir os serviços, execute:

```Bash
$> make
```

ou

```Bash
$> docker-compose -f docker-compose.yml up --build
```

### Uso

Acesse o app através da URL http://localhost/ .

### Layout

Assim como a agenda de qualquer celular moderno, os contatos são os menus e o feedback visual é toda informação necessária para uma navegação intuitiva.

#### Responsividade

HD (1366x768)

<p><img width="75%" src="https://github.com/dpiza/resources/blob/master/imgs/hd.png?raw=true"/>

iPhone 12 (390x844)

<p><img width="25%" src="https://github.com/dpiza/resources/blob/master/imgs/iphone.png?raw=true"/>
