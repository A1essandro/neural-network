#neural-network (Нейронная сеть)

[![Build Status](https://travis-ci.org/A1essandro/neural-network.svg?branch=master)](https://travis-ci.org/A1essandro/neural-network)
[![Coverage Status](https://coveralls.io/repos/github/A1essandro/neural-network/badge.svg?branch=master)](https://coveralls.io/github/A1essandro/neural-network?branch=master)
[![Code Climate](https://codeclimate.com/github/A1essandro/neural-network/badges/gpa.svg)](https://codeclimate.com/github/A1essandro/neural-network)
[![Latest Stable Version](https://poser.pugx.org/a1essandro/neural-network/v/stable)](https://packagist.org/packages/a1essandro/neural-network) 
[![Latest Unstable Version](https://poser.pugx.org/a1essandro/neural-network/v/unstable)](https://packagist.org/packages/a1essandro/neural-network)
[![Total Downloads](https://poser.pugx.org/a1essandro/neural-network/downloads)](https://packagist.org/packages/a1essandro/neural-network)
[![License](https://poser.pugx.org/a1essandro/neural-network/license)](https://packagist.org/packages/a1essandro/neural-network)

######Выбор языка документации:
[![English](https://img.shields.io/:readme-EN-336699.svg)](https://github.com/A1essandro/neural-network/blob/master/README.md)
[![Russian](https://img.shields.io/:readme-RU-cc3300.svg)](https://github.com/A1essandro/neural-network/blob/master/README.ru.md)

##Требования
Пакет работает только на версии PHP 5.5 или выше.

##Установка
####Способ №1 (рекомендуемый): используя Composer
О Composer'е [getcomposer.org](http://getcomposer.org).

Используйте команду:
```
composer require a1essandro/neural-network dev-master
```
Пакет `neural-network` автоматически скачается в папку `vendors` Вашего проекта

####Способ №2: клонирование репозитория
Выполните команду
```
git clone https://github.com/A1essandro/neural-network
```
Папка с пакетом будет скопирована в текущую папку.

*Вы не сможете использовать примеры из папки `demo` без изменения кода, если у Вас не установлен `composer`*

##Примеры использования пакета

###пример XOR:

```php
require_once '../vendor/autoload.php';

//Создание нейронной сети с 2-мя входными нейронами, одним скрытым слоем с 2-мя нейронами и одним выходом:
$p = new Neural\Network([2, 2, 1]); //Вы можете добавить нейроны в любой слой, или же добавить скрытые слои, например: [2, 3, 2, 1]
$p->generateSynapses(); //автоматическое генерирование синапсов 

$t = new Neural\BackpropagationTeacher($p); //"Учитель" с алгоритмом "обратное распространение ошибки"

//Тренирует, пока не достигнет нужного результата (максимальное количество итераций задается 4-м параметром)
$learningResult = $t->teachKit(
    [[1, 0], [0, 1], [1, 1], [0, 0]], //набор входных параметров для обучения
    [[1], [1], [0], [0]], //соотверствующие ожидания выходного слоя
    0.3 //погрешность
);

if ($learningResult != -1) {
    echo '1,0: ' . round($p->input([1, 0])->output()[0]) . PHP_EOL;
    echo '0,1: ' . round($p->input([0, 1])->output()[0]) . PHP_EOL;
    echo '0,0: ' . round($p->input([0, 0])->output()[0]) . PHP_EOL;
    echo '1,1: ' . round($p->input([1, 1])->output()[0]) . PHP_EOL;
}

/* Результат, если обучение прошло успешно:
1,0: 1
0,1: 1
0,0: 0
1,1: 0
*/
```
