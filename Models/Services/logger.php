<?php


namespace Models\Services;

use Models\Services\Db;


class logger
{
    private $log;
    private $tableName;

    public function __construct()
    {
        $this->tableName = 'log';
    }


    /** Сохранение записи в лог */
    public static function saveLog($type, $source, $message) : void {
    $param = [
               'type' => $type,
                'source' => $source,
               'message' => $message
            ];
    $tableName = 'log';
    $db = new Db();
    $db ->insert($tableName, $param);
    }


    /** Вывод последних n строк лога */
    public static function LastRowsLog ($rows) : ?array
    {
        $tableName = 'log';
        $db = new Db();
        return $db -> selectLastRows($tableName, $rows);
    }


    /** Очистка лога */
    public static function clearLog() : void
    {
        $tableName = ['log'];
        $db = new Db();
        $db ->deleteAllFromTable($tableName);
    }
}