<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

    public function index()
    {
        return view('home');
    }    
}