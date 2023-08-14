# desafio-creditares

O desafio é desenvolver uma API e um sistema FrontEnd para busca e armazenamento de CEPs. Quando o CEP buscado não é encontrado no banco de dados local, o sistema deve consumir uma API externa e armazenar o resultado encontrado.

#### Stack

- Laravel 9
- Php 8
- MySQL 8
- Nodejs 16
- Quasar v2
- Vue 3

#### Requisitos

- docker-compose
- GNU Make

#### Procedimento

Para subir os serviços, execute:
`$> make`
ou
`$> docker-compose -f docker-compose.yml up --build`

### Uso

Acesse o app através da URL http://localhost/ .
