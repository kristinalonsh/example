<?php


namespace Models\Services;

use Models\Services\Db;


class logger
{
    private $db;
    const TABLE_NAME = 'log';

    public function __construct()
    {
    }

    /** Сохранение записи в лог */
    public static function saveLog($type, $source, $message) : void {
    $param = [
               'type' => $type,
                'source' => $source,
               'message' => $message
            ];
    $db = new Db('localhost', 'my_project', 'root', 'root');
    $db ->insert(self::TABLE_NAME, $param);
    }


    /** Вывод последних n строк лога */
    public static function LastRowsLog ($rows) : ?array
    {
        $db = new Db('localhost', 'my_project', 'root', 'root');
        return $db -> selectLastRows(self::TABLE_NAME, $rows);
    }


    /** Очистка лога */
    public static function clearLog() : void
    {
        $db = new Db('localhost', 'my_project', 'root', 'root');
        $db ->deleteAllFromTable([self::TABLE_NAME]);
    }
}