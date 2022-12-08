<?php


namespace Models\Services;

use PDO;
use Exceptions\DbException;


class Db
{
    private $db;

    /** Соединение с БД через файл с настройками*/
//    public function __construct()
//    {
//        $dbOptions = (require $_SERVER['DOCUMENT_ROOT'] . '/Setting.php')['db'];
//        try {
//            $this->db = new PDO(
//                'mysql:host=' . $dbOptions['host'] . ';dbname=' . $dbOptions['dbname'],
//                $dbOptions['user'],
//                $dbOptions['password']
//            );
//            $this->db->exec('SET NAMES UTF8');
//        } catch (\PDOException $e) {
//            throw new DbException('Не удалось подключиться к базе данных');
//        }
//    }

    /** Соединение с БД методом передачи параметров подключения в момент создания объекта*/
    public function __construct ($host, $dbname, $user, $password)
    {

        try {
            $this->db = new PDO(
                'mysql:host=' . $host . ';dbname=' . $dbname,
                $user,
                $password
            );
            $this->db->exec('SET NAMES UTF8');
        } catch (\PDOException $e) {
            throw new DbException('Не удалось подключиться к базе данных');
        }
    }



    /** Операции над БД */
    private function query(string $sql, array $params = []): ?array
    {
        $zapros = $this->db->prepare($sql); //подготавливаем запрос
        $zapros->execute($params); //отправляем запрос
        return $zapros->fetchAll(PDO::FETCH_ASSOC); //возвращаем ответ
    }


    /** SELECT */
    public function select ($tableName, array $param = []) : ?array
    {
        // формируем общий запрос на выборку всех данных таблицы
        $zapros = 'SELECT * FROM '.$tableName;

        // если переданы параметры отбора, то пробегаемся по каждому параметру отбора и формируем строку отбора в формате PDO
        if (!empty($param)) {
            $zapros = $zapros . ' WHERE ';
            $otbor = '';
            foreach ($param as $key => $value)
            {
                $otbor = $otbor . $key.'=:'.$key.' AND ';
            }
        }

        // удаляем у строки отбора последний AND с пробелом, так как он добавлялся в конце на каждой итерации перебора условий
        $otbor = mb_substr($otbor, 0, -4);

        //склеиваем строки запрос + параметры отбора
        $zapros = $zapros.$otbor;

        //выполняем запрос методом query нашего же класса Db
        $result = $this->query($zapros, $param);
        return $result;
    }



    /** UPDATE */
    public function update ($tableName, array $newValue = [], array $param = []) : void
    {
        $zapros = 'UPDATE ' . $tableName. ' SET ';
        $newVal = '';
        $otbor = '';

        if (!empty($newValue)) {
            foreach ($newValue as $key => $value)
            {
                $newVal = $newVal . $key.'=:'.$key.', ';
            }
        }
        else return;

        if (!empty($param)) {
            $otbor = $otbor . ' WHERE ';
            foreach ($param as $key => $value)
            {
                $otbor = $otbor . $key.'=:'.$key.' AND ';
            }
        }
        else return;

        // удаляем у строки отбора последний AND с пробелом, у новых параметров запятую с пробелом
        // (добавленные в цикле перебора на каждой итерации, включая последний, что ошибочно)
        $otbor = mb_substr($otbor, 0, -4);
        $newVal = mb_substr($newVal, 0, -2);

        $zapros = $zapros.$newVal.$otbor; //склеиваем строки запрос + новые значения + параметры отбора
        $zapros = $this->db->prepare($zapros); //подготавливаем запрос к отправке в БД

        $params = $newValue + $param; //объединяем два массива (параметры отбора + новые значения) для передачи параметров в запрос PDO execute в виде одного маасива

        $zapros->execute($params); //отправляем запрос

        if ($zapros -> rowCount() > 0) {
            echo 'Данные в таблице '.$tableName.' успешно обновлены! Запросом было затронуто '.$zapros -> rowCount().' строк <br>';
        }
        else {
            echo 'Данные в таблице '.$tableName.' не были обновлены! <br>';
        }

    }


    /** INSERT */
    public function insert ($tableName, array $param) : void {

        $zapros = 'INSERT INTO `' .$tableName.'` ('; // формируем начало запроса вставки
        $VALUES = ') VALUES (';

        //пробегаемся по каждому элементу параметра, дополняем строку запроса
        foreach ($param as $key => $value)
        {
            $zapros = $zapros.$key.', ';
            $VALUES = $VALUES . ':'.$key.', ';
        }

        // удаляем у сформированных в цикле строк $zapros и $VALUES последнюю запятую с пробелом, так как она добавлялась в конце на каждой итерации перебора условий
        $zapros = mb_substr($zapros, 0, -2);
        $VALUES = mb_substr($VALUES, 0, -2);


        $zapros = $zapros. $VALUES. ')';                    //склеиваем строки запрос + значения
        $zapros = $this->db->prepare($zapros);              //подготавливаем запрос к отправке в БД

        $zapros->execute($param);                           //отправляем запрос

        if ($zapros -> rowCount() > 0) {
            echo 'В таблицу '.$tableName.' было успешно добавлено '.$zapros -> rowCount().' строк <br>';
        }
        else {
            echo 'Не удалось добавить данные в таблицу '.$tableName.'<br>';
            var_dump ($zapros->errorInfo()) ;
        }
    }


    /** DELETE */
    public function delete ($tableName, array $param = []) : void
    {
        // формируем общий запрос на удаление данных
        $zapros = 'DELETE FROM ' . $tableName;
        // если переданы параметры отбора, то пробегаемся по каждому параметру отбора и формируем строку отбора в формате PDO
        if (!empty($param)) {
            $zapros = $zapros . ' WHERE ';
            $otbor = '';
            foreach ($param as $key => $value)
            {
                $otbor = $otbor . $key.'=:'.$key.' AND ';
            }
        }

        // удаляем у строки отбора последний AND с пробелом, так как он добавлялся в конце на каждой итерации перебора условий
        $otbor = mb_substr($otbor, 0, -4);

        $zapros = $zapros.$otbor; //склеиваем строки запрос + параметры отбора
        $zapros = $this->db->prepare($zapros); //подготавливаем запрос к отправке в БД

        $zapros->execute($param); //отправляем запрос

        if ($zapros -> rowCount() > 0) {
            echo 'Данные в таблице '.$tableName.' успешно удалены! Запросом было затронуто '.$zapros -> rowCount().' строк <br>';
        }
        else {
            echo 'Данные в таблице '.$tableName.' не были удалены!<br>';
        }
    }


    /** DELETE ALL FROM TABLE - удаление всех данных из одной или нескольких таблиц */
    public function deleteAllFromTable (array $tableName) : void
    {
        try {
            foreach ($tableName as $key => $value) {
                $this->delete($tableName[$key]);
            }
        } catch (\PDOException $e) {
            throw new DbException('В процессе удаления данных проищошла ошибка! <br>');
        }
    }


    /** SELECT последних n строк */
    public function selectLastRows ($tableName, $rows) : ?array {

        // формируем общий запрос на выборку всех данных таблицы
        $zapros = 'SELECT * FROM '.$tableName. ' ORDER BY id DESC LIMIT '.$rows;
        //выполняем запрос методом query нашего же класса Db
        $result = $this->query($zapros);
        return $result;
    }

}