#Laravel Endereços e Telefones

Funcional, porém em andamento.

* Migration e seed para países
* Migration e seed para estados brasileiros
* Migration e seed para cidades brasileiras

Após instalação do pacote utilize o comando
```php 
php artisan migrate 
```
para adicionar as tabelas ao banco de dados.

Para efetuar a Seed dos dados, utilize o comando

```php
php artisan addresses:seed
```

* Trait de funcionalidade de endereço para models
* Trait de funcionalidade de telefone para models

Adicione 
