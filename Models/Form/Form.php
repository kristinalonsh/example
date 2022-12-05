<?php


namespace Models\Form;

use Exceptions\UncorrectMethodException;


class Form
{

    public function __construct() {
    }

    /** ТЕГ input */
    public function input (array $array)  {
        /** Проверяем массив REGUEST (POST + GET) на заполненность по полям. Если ранее вводилось какое значение в это поле - выводим его */
        if (!empty($_REQUEST[$array['name']])) {
            $result = '<input value='.$_POST[$array['name']];
        }
        else
        $result = '<input ';
        /** Перебор каждого элемента переданного массива, преобразование его в html атрибуты (key в название атрибута, value в значение атрибута */
        foreach ($array as $key => $value) {
            $result = $result.' '.$key.'="'.$value.'"';
        }
        $result = $result.'>';
        return $result;
    }

    public function password (array $array)  {
        $pswd = '<input type="password"';
        foreach ($array as $key => $value) {
            $pswd = $pswd.' '.$key.'="'.$value.'"';
        }
        $pswd = $pswd.'>';
        return $pswd;
    }


    public function textarea (array $array) {
        /** Проверяем массив REGUEST (POST + GET) на заполненность полей, если ранее вводилось значени е, то выводим его*/
        if (!empty($_REQUEST[$array['name']])) {
            $array['value'] = $_REQUEST[$array['name']];
        }

        $txt='<textarea';
        foreach ($array as $key => $value) {
            $txt=$txt.' '.$key.'="'.$value.'"';
        }
        $txt=$txt.'>'.$array['value'].'</textarea><br><br>';
        return $txt;
    }


    public function submit (array $array) {
        return '<input type="submit" value="'.$array['value'].'"><br><br>';
    }


    public function open (array $array) {
        if (($array['method']=='POST') || ($array['method']=='GET')) {
            $this->method = $array['method'];
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