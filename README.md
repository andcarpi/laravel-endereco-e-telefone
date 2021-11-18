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

Adicione a trait `` TemTelefones`` para adicionar a funcionalidade de Telefones no model.

Adicione a trait `` TemEnderecos`` para adicionar a funcionalidade de Enderecos no model.

Exemplo de classe que permite o uso de enderecos e telefones:

```php
class Pessoa extends Model
{
    use TemTelefones;
    use TemEnderecos;
}
```

exemplo de uso do model com a trait TemEnderecos:

```php

function exemplosEndereco() {

    $pessoa = Pessoa::find(1);
    //Tera q adicionar a classe no uses, ou utilizar o namespace completo
    $endereco = new Endereco();
    $endereco->endereco = 'rua teste';
    $endereco->numero = 'numero teste';
    $endereco->bairro = 'bairro teste';
    $endereco->cep = 'cep teste';
    //cidade baseada na tabela cidades.
    $endereco->cidade_id = 10;
    
    //vinculando o endereco ao model pessoa e salvando
    $pessoa->enderecos()->save($endereco);
    
    //Verificando se o model tem algum endereco cadastrado
    var_dump($pessoa->temEnderecos());  //true ou false
    
    //retorna uma coleção com os endereços cadastrados.    
    $enderecos = $pessoa->enderecos()->get();

}

```


```php

function exemplosTelefone() {

    $pessoa = Pessoa::find(1);
    //Tera q adicionar a classe no uses, ou utilizar o namespace completo
    $telefone = new Telefone();
    $telefone->numero = 'numero teste';
    $telefone->descricao = 'descricao teste';
        
    //vinculando o telefone ao model pessoa e salvando
    $pessoa->telefones()->save($telefone);
    
    //Verificando se o model tem algum telefone cadastrado
    var_dump($pessoa->temTelefones());  //true ou false
    
    //retorna uma coleção com os endereços cadastrados.    
    $enderecos = $pessoa->telefones()->get();

}

```
