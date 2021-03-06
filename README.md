# htmlBuilder


## Simples classe para criação de tags HTML

Ĉlasse que traz uma interface para criação de tags `HTML`. Feito em `PHP` para sistema que necessitam criar de forma dinâmica códigos `HTML`. E possibilita o uso dos scripts `PHP` sem a necessidade de misturar com códigos `HTML`

O sistema funciona de forma simples, podendo ser utilizado junto com um sistema de cache para não necessitar o processo de geração de código a toda requisição e diminuir o throughput.

### Pré-requisitos
* PHP 7.0
* Composer

### Instação

Use o comando de instalação do composer

`$ composer require alanfm/html-builder`

### Como trabalhar com o htmlBuilder

Basta a chamado do autoload gerado pelo composer.

```php
<?php

include __DIR__ . '/vendor/autoload.php';

use HTMLBuilder\ElementFactory;

$tag = ElementFactory::make('tag')->value('Valor')->attr('attr', ['value1', 'value2']);

echo $tag->render();

```
Resultado
```html
<tag attr="value1 value2">Valor</tag>
```
### Uso da classe Element
A Classe Element possui 4 métodos publicos:

1. Método construtor (`__construct($name, $value, $attr)`) recebe 3 parametros:
  1. Nome da tag do HTML.

        Exemplo:

```php
new Element('div')
```

```php
new Element('p', 'Conteúdo do parágrafo.')
```

```php
new Element('span', 'Conteúdo do span.', ['atributo'=>'atributo-do-span'])
```

  2. Conteúdo da tag. Pode ser passado um objeto tipo InterfaceElements, strings ou um array com objetos ou strings.

        Exemplo:

```php
new Element('div','Uma string simples')
```

```php
new Element('div', ['Uma string', 'Outra string'])
```

```php
new Element('div', [new Element('p'), 'Uma string'])
```

```php
new Element('div', [new Element('div', [new Element('p', 'Texto simples', ['attr'=>['value1', 'value2']])])])
```

  3. Atributos da tag. Recebe os artributos do elemento HTML em forma de um array, onde a chave é o nome do atributo e o valor é outro array com os valores possiveis do atributo.

        Exemplo:

```php
new Element('p', 'Meu paragrafo', ['class'=>['text-justify', 'text-muted']])
```

```php
new Element('div', null, ['id'=>['main'], 'class'=>['align-top', 'cleaner']])
```

2. Método para atribuir um conteúdo a tag (`value($value)`):
  * O valor pode ser uma string, um objeto do tipo InterfaceElements ou um array contendo objetos ou strings.

```php
$p = new Element('p');
$p->value('Texto do meu parágrafo!');
echo $p->render();

```

Resultado:

```html
<p>Texto do meu parágrafo!</p>
```

3. Método para atribuição de atributos (`attr($attr)`) a tag:
  * O parametro recebido por esse método deve ser um array como no item 1.3.

```php
$div = new Element('span', 'Conteúdo do span!');
$div->attr(['class'=>['text-bold', 'clear']]);
echo $div->render();

```

Resultado:

```html
<span class="text-bold clear">Conteúdo do span</span>
```

  * Outra forma de setar os atributos é passando dois parametros no método `attr($attr, $valor)`.

```php
$div = new Element('span', 'Conteúdo do span!');
$div->attr('class', ['text-bold', 'clear']);
echo $div->render();
```

Resultado:

```html
<span class="text-bold clear">Conteúdo do span</span>
```

4. Método que retorna a tag html (`render()`)
  * O método build não imprime na tela do browser, apenas retorna o códgo HTML gerado.

```php
<?php

use HTMLBuilder\Element;

$div = new Element('div');
$div->value('Texto que está dentro da minha div.');
$div->attr(['id'=>['main'], 'class'=>['content']]);

echo $div->render();

```

Resultado:

```html
<div id="main" class="content">Texto que está dentro da minha div.</div>
```
### Exemplos

Veja abaixo alguns fragmentos de código possiveis de ser usados. Nos exemplos também será usado a classe `HTML` que foi criado com auxílio da classe `Element`.

Estrutura simples de um parágrafo

```php
<?php

use HTMLBuilder\Element;

$p = new Element('p');

$p->value('Texto que estará dentro do meu paragrafo.');

$attr = ['class'=>['text-justify', 'text-muted']];

$p->attr($attr);

echo $p->render();
```

Resultado:

```html
<p class="text-justify text-muted">Texto que estará dentro do meu paragrafo.</p>
```
Parágrafo com elementos filhos

```php
<?php

use HTMLBuilder\Element;

$strong = new Element('strong');

$br = new Element('br');

$p = new Element('p');

$contentP[] = $strong->value('Nome: ');
$contentP[] = 'Fulano de Tals';
$contentP[] = $br;
$contentP[] = $strong->value('E-mail: ');
$contentP[] = 'fulano@de.tals';

echo $p->value($contentP)->attr(['class'=>['text-center']])->render();
```

Resultado:

```html
<p class="text-center">
    <strong>Nome: </strong>Fulano de Tals<br>
    <strong>E-mail: </strong>fulano@de.tals
</p>
```

Lista simples

```php
<?php

use HTMLBuilder\Element;

$contentUl = [];

for ($i = 0; $i < 5; $i++) {
    $contentUl[] = new Element('li', 'Item ' . $i + 1);
}

$ul = new Element('ul', $contentUl);

echo $ul->render();
```

Resultado

```html
<ul>
    <li>Item 1</li>
    <li>Item 2</li>
    <li>Item 3</li>
    <li>Item 4</li>
    <li>Item 5</li>
</ul>
```

### Usando a classe ElementFactory

A classe ElementFactory fabrica objetos do tipo `InterfaceElements`.

```php
<?php

use HTMLBuilder\ElementFactory;

$html = ElementFactory::make('html')->attr('lang', ['pt-br']);
$title = ElementFactory::make('title')->value('Titulo da Minha Página');
$h1 = ElementFactory('h1')->value('Minha Página')->attr('class',['teste'])->attr('id', ['my-title']);
$p = ElementFactory('p')->value('Etiam posuere quam ac quam. Maecenas aliquet accumsan leo. Nullam dapibus fermentum ipsum. Etiam quis quam. Integer lacinia. Nulla est. Nulla turpis magna, cursus sit amet, suscipit a, interdum id, felis. Integer vulputate sem a nibh rutrum consequat. Maecenas lorem. Pellentesque pretium lectus id turpis. Etiam sapien elit, consequat eget, tristique non, venenatis quis, ante. Fusce wisi. Phasellus faucibus molestie nisl. Fusce eget urna. Curabitur vitae diam non enim vestibulum interdum. Nulla quis diam. Ut tempus purus at lorem.');

$head = ElementFactory::make('head');
$head->value($title);

$body = ElementFactory::make('body');
$body->value($h1)->value($p);

$html->value($head)->value($body);
echo $html->render();
```

Resultado

```html
<html lang="pt-br">
    <head>
        <title>Titulo da Minha Página</title>
    </head>
    <body>
        <h1 class="teste" id="my-title">Minha Página</h1>
        <p>Etiam posuere quam ac quam. Maecenas aliquet accumsan leo. Nullam dapibus fermentum ipsum. Etiam quis quam. Integer lacinia. Nulla est. Nulla turpis magna, cursus sit amet, suscipit a, interdum id, felis. Integer vulputate sem a nibh rutrum consequat. Maecenas lorem. Pellentesque pretium lectus id turpis. Etiam sapien elit, consequat eget, tristique non, venenatis quis, ante. Fusce wisi. Phasellus faucibus molestie nisl. Fusce eget urna. Curabitur vitae diam non enim vestibulum interdum. Nulla quis diam. Ut tempus purus at lorem.</p>
    </body>
</html>
```
### Tópicos que não estão na documentação

* Classe Page
* Classe Elements\Table

### Licença

MIT © 2016 Alan Freire