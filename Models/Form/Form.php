<?php


namespace Models\Form;

use Exceptions\UncorrectMethodException;


class Form
{

    public function __construct() {
    }

    /** Возврат строки пасраметров */
    private function returnParam (array $array) : string
    {
        /** Проверяем массив REGUEST (POST + GET) на заполненность по полям. Если ранее вводилось какое значение в это поле - выводим его */
        if (!empty($_REQUEST[$array['name']])) {
            $parameters = 'value='.$_POST[$array['name']];
        }
        else
            $parameters = "";

        /** Перебор каждого элемента переданного массива, преобразование его в html атрибуты (key в название атрибута, value в значение атрибута */
        foreach ($array as $key => $value) {
            $parameters .= ' '.$key.'="'.$value.'"';
        }
        return $parameters;
    }


    /** ТЕГ input */
    public function input (array $array)  : string
    {
        return '<input '. $this->returnParam($array) . '>';
    }

    public function password (array $array) : string
    {
        return '<input type="password"' . $this -> returnParam ($array) . '>';
    }


    public function textarea (array $array) : string
    {
        return '<textarea' . $this -> returnParam ($array) . '>'.$array['value'].'</textarea><br/><br>';
    }


    public function submit (array $array) {
        return '<input type="submit" value="'.$array['value'].'"><br>';
    }


    public function open (array $array) {
        if (($array['method']=='POST') || ($array['method']=='GET')) {
            $this -> method = $array['method'];
        }
        else {
            throw new UncorrectMethodException ('Метод формы может быть только GET или POST');
        }

        return '<form action="'.$array['action'].'" method="'.$array['method'].'">';
    }

    public function close () {
        return '</form>';
    }


}