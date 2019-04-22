<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class PagesController extends Controller
{
    private function collectItems($arr, $callback)
    {
        foreach($arr as $value):
            yield $callback($value) . ' ';
        endforeach;
    }

    private function getSquare($val)
    {
        yield $val * $val;
    }

    private function checkEven($array)
    {
        foreach($array as $val):
            if(!($val % 2)) yield from $this->getSquare($val);
        endforeach;
    }
    
    public function useYield()
    {
        $array = [1, 2, 3, 4, 5];
        $callbackFunction = function($e){ return $e * $e; };
        $collect = $this->collectItems($array, $callbackFunction);
        foreach($collect as $val): echo $val; endforeach;
        
        return 'done';
    }

    public function useYieldFrom()
    {
        $array = [1, 2, 3, 4, 5];
        foreach($this->checkEven($array) as $val): echo "$val "; endforeach;

        echo '<br> Затрачено памяти ' . memory_get_usage()  . ' bytes <br>';

        echo mb_strlen('привет') . "<br>"; //для работы с русскими буквами нужно использовать мультибайтовые аналоги

        return 'done';
    }

    public function useOperators()
    {
        $a = 3;
        $b = 2;
        $c = 3;

        switch($a<=>$b):
            case -1:
                echo "$a < $b";
                break;
            case 0:
                echo "$a = $b";
                break;
            case 1:
                echo "$a > $b";
                break;
        endswitch;

        echo "<br>";

        unset($a);

        echo $a ?? $b ?? $c;
    }

    public function regExp()
    {
        // ^ начало ввода
        // $ конец ввода
        // [^A-Za-z] все кроме шаблона
        // {2, 256} кол-во повторений от 2 до 256 {3} ограниченное кол-во раз {3,} от 3 до бесконечности
        // (\d) группа (карман); (?<tag>\d) именование кармана; (?:\d) игнорирование кармана; в preg_replace(/re/, '<b>$1</b>') $1 - номер кармана
        // (?=[j]) позитивный просмотр справа
        // (?![j]) негативнй просмотр справа
        // (?<=[j]) позитивный просмотр слева
        // (?<![j]) негативный просмотр слева
        // + повтор шаблона 1 или несколько раз
        // * ноль или более раз повторяется символ (-*)
        // . один любой символ
        // флаг g искать еще по шаблону, даже, если уже найдено
        // флаг i не учитывать регистр
        // флаг s искать по одной стороке
        // ? шаблон повторятеся ноль или один раз
        // | или
        // \s пробел \S все кроме пробела
        // \d синоним [0-9] \D все остальное кроме \d
        // \w синоним [A-Za-z0-9_] \W все остальное кроме \w
        // \u для русских символов
        // использовать апострофы ' в выражении чтобы не смущать php
        // # #, { }, [ ], () альтернатива / /
        // [[:alpha:][:digit:][:punct:]] буква, цифра, знак пунктуации
        // в скобках [] специальные сиимволы теряют смысл, обратный слеш не нужен
        // ^$ пустая строка

        $rules = [
            'ace7upp@gmail.com' => '/^[\w\.\-]+@[\w\.\-]+\.[a-z]{2,6}$/is',
            'www.tehnostor.ru' => '/^[w]{0,3}\.?(?<!^[.])[\w-]{2,256}(?<![w]{3})\.[a-z]{2,6}\/?$/is',
            'self-teaching' => '/[a-zA-Z]+-[a-zA-Z]+/',
            '<span></span>' => '/<(?<tag>\w+)>(?<content>.*?)<\/\1>/gi'
        ];
    }

    private function echoOOP()
    {
        return 'hi there';
    }

    private static function echoStaticOOP()
    {
        return 'hi static therer';
    }

    public function OOP()
    {
        // статические методы не имею $this и могут вызывать только статичные методы и переменные, используется self::method();
        // вызов переменной класса вызывается через __get, установка через __set, вызов метода __call, эти прозрачные методы можно перехыватывать и писать обработчик
        // clone - клонирвоание объекта, при $a = Cabon::now() и $b = $a, и $b->addDay(), то $a становится тем же самым что и $b, при клонировании вызывается прозрачный метод __clone
        // но, $a = 4 $b = $a $b++, то $a = 4 $b = 5. Чтобы $a == $b => $b = &$a
        // parent::__construct(); вызов конструктора родительского класса, полученного через ChildClass extends ParentClass
        /**
         * public function __construct($arg)
         * {
         *      parent::__construct(basename($arg), $arg); // переопределение родительской переменной
         * }
         */
        // public final - запретить переназначение элемента родительского класса
        // final class ClassName {} - запретить наследование класса
        // абстрактный класс - класс, который имеет все возможные функции, но конкретное назначение не определено

        $firstDate = Carbon::now();
        $seconDate = clone $firstDate;
        echo $firstDate->format('d-m-y') . '<br>';
        echo $seconDate->format('d-m-y') . '<br>';
        $seconDate->addDay();
        echo $firstDate->format('d-m-y') . '<br>';
        echo $seconDate->format('d-m-y') . '<br>';
        echo '<br>';

        /** внутри можно вызывать 4-мя способами */
        // parenrt::method();
        echo $this->echoOOP() . '<br>';
        echo self::echoOOP() . '<br>';
        echo PagesController::echoOOP() . '<br>';
        /** статик можно вызвать двумя способами */
        echo self::echoStaticOOP() . '<br>';
        echo static::echoStaticOOP() . '<br>';
    }

    public function index()
    {
        return view('home');
    }    
}