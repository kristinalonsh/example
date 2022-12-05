<?php


use Models\Worker\Worker;
use Models\User\User;
use Models\Form\Form;
use Models\Cookie\Cookie;
use Models\Session\Session;
use Models\Flash\Flash;
use Models\Services\Db;
use Models\Services\logger;
use Exceptions\UncorrectAgeException;
use Exceptions\UncorrectMethodException;


function MyAutoLoader(string $className)
{
    require_once $_SERVER['DOCUMENT_ROOT'] . '/'. str_replace('\\', '/', $className) . '.php';
}

try {
    spl_autoload_register('MyAutoLoader');
    $a = new Worker('Василий', 56);
    $b = new Worker('Геннадий', 28);

    $a -> setSalary(45000);
    $b -> setSalary(63000);
    $sum = $a->getSalary() + $b->getSalary();
    echo $a -> hello();
    echo '<br>';
    echo $b ->hello();
    echo ('<br>Таким образом, Васёк и Гена на двоих получают '.$sum.' рублей. Пора сократить расходы компании!<br>');




    /** ПРОВЕРКА РАБОТЫ КЛАССА form */
    $form = new Form();
    echo '<br><br><b>ПРОВЕРКА РАБОТЫ КЛАССА form</b><br>';
    echo $form->open(['action' => 'index.php', 'method' => 'POST']);
    echo '<br><br>';
    echo $form->input(['type'=>'text', 'name'=>'FIO', 'placeholder'=>'Введите ФИО']);
    echo '<br><br>';
    echo $form->input(['type'=>'text', 'name' => 'job_post', 'placeholder'=>'Должность']);
    echo '<br><br>';
    echo $form->textarea(['name'=>'message', 'placeholder'=> 'Введите сообщение', 'value'=>'!!!']);
    echo $form->password(['placeholder'=>'Придумайте пароль']);
    echo '<br><br>';
    echo $form->submit(['value'=>'Регистрация']);
    echo $form->close();


    /** ПРОВЕРКА РАБОТЫ КЛАССА cookie */
    echo '<br><br><b>ПРОВЕРКА РАБОТЫ КЛАССА Cookie</b><br>';
    $cook = new Cookie();
    $cook->setCookie('user', 'Павел');
    echo $cook->getCookie('user');


    /** ПРОВЕРКА РАБОТЫ КЛАССА session */
    echo '<br><br><b>ПРОВЕРКА РАБОТЫ КЛАССА Session</b><br>';
    $sess = new Session();
    $sess -> set('login', 'master_bill');
    echo $sess ->get('login');
    echo '<br>';
    if ($sess -> check('login')) {echo '$_SESSION [\'login\'] существует';}
    else {echo '$_SESSION [\'login\'] НЕ существует';}
    echo '<br>';
    $sess -> delete('login');
    echo $sess -> get('login');


    /** ПРОВЕРКА РАБОТЫ КЛАССА flash */
    echo '<br><br><b>ПРОВЕРКА РАБОТЫ КЛАССА Flash</b><br>';
    $flash = new Flash();
    $flash -> setMessage('agree', 'Согласие на ОПД подтверждено');
    echo $flash -> getMessage('agree');



    /** ПРОВЕРКА РАБОТЫ КЛАССА Db */
    echo '<br><br><b>ПРОВЕРКА РАБОТЫ КЛАССА Db</b></br><br>';
    $db = new Db();
    $tableName = 'test';


    echo '<br><br><b>SELECT</b></br>';
    $param = ['type' => 'post'];
    $result = $db -> select($tableName, $param);
    var_dump($result);



    echo '<br><br><b>UPDATE</b></br>';
    $newValue = ['type' => 'post'];
    $param2 = ['id' => '5'];
    $db ->update($tableName, $newValue, $param2);


    echo '<br><br><b>INSERT</b></br>';
//    $tableName = 'test';
//    $param3 = [
//               'type' => 'post',
//               'message' => 'Вы никогда не догадаетесь, что там!!',
//               'user_id' =>  11];
//    $db -> insert($tableName, $param3);


    echo '<br><b>DELETE - удалить из таблицы по условию</b></br>';
//    $result = $db ->delete($tableName, $param);


    echo '<br><b>DELETE ALL - очистить полностью одну или несколько таблиц</b></br>';
//    $tablesNames = ['test', 'log'];
//    $db ->deleteAllFromTable($tablesNames);


    echo '<br><b>SELECT последних n строк указанной таблицы</b></br>';
    var_dump ($db ->selectLastRows('test',2));


    echo '<br><b>SELECT последних n строк лога </b></br>';
    var_dump (logger:: LastRowsLog (3));

//    echo '<br><b>ОЧИСТКА ЛОГА</b></br>';
//    logger::clearLog();



} catch (Exceptions\UncorrectAgeException $e) {   // ПЕРЕХВАТ ОШИБКИ, ЕСЛИ ВВЕДЕН НЕКОРРЕКТНЫЙ ВОЗРАСТ (МЕНЕЕ 1 ИЛИ БОЛЕЕ 100)
    echo $e->getMessage();
    logger::saveLog('warning', 'main', $e->getMessage().'  TRACE: '.$e->getTraceAsString());

} catch (Exceptions\UncorrectMethodException $e) { // ПЕРЕХВАТ ОШИБКИ, ЕСЛИ УКАЗАН НЕКОРРЕКТНЫЙ МЕТОД ФОРМЫ - НЕ POST И НЕ GET
    echo $e->getMessage();
    logger::saveLog('error', 'main', $e->getMessage().'  TRACE: '.$e->getTraceAsString());

} catch (Exceptions\DbException $e) { // ПЕРЕХВАТ ОШИБКИ, ЕСЛИ НЕ УДАЛОСЬ ПОДКЛЮЧИТЬСЯ К БД
    echo $e->getMessage();
}