<?php 
global $argv;
$isRunConsole = isset($argv);
$br = "\n";

if($isRunConsole){ 
    // все файлы проекта (php, js, css)
    $arrayDirGy = array (
  './gy/admin/add-user.php' => 
  array (
    'CODE' => '<?php
include "../../gy/gy.php"; // подключить ядро // include core

global $USER;

// проверим разрешено ли показывать админ панель текущему пользователю
if (Gy\\Core\\User\\AccessUserGroup::accessThisUserByAction( \'show_admin_panel\')) {

    include "../../gy/admin/header-admin.php";

    // Проверим разрешено ли работать с пользователями текущему пользователю
    if (Gy\\Core\\User\\AccessUserGroup::accessThisUserByAction( \'edit_users\')) {
        $APP->component(
            \'add_user\',
            \'0\',
            array(
                \'back-url\' => \'/gy/admin/users.php\'
            )
        );
    }
    
    include "../../gy/admin/footer-admin.php";

} else {
    header( \'Location: /gy/admin/\' );
}

',
    'TYPE' => 'php',
    'DIR' => './gy/admin/',
  ),
  './gy/admin/ajax.php' => 
  array (
    'CODE' => '<?php
include "../../gy/gy.php"; // подключить ядро // include core

$result = array(
    \'stat\' => \'err\'
);

$data = $_REQUEST;

global $USER;

if ( Gy\\Core\\User\\AccessUserGroup::accessThisUserByAction( \'show_admin_panel\') 
    && !empty($data[\'action\'])
) {
    // действие удалить пользователя
    if (($data[\'action\'] == \'user-del\') && !empty($data[\'id-user\'])) {

        $res = $USER->deleteUserById($data[\'id-user\']);
        if ($res) {
            $result[\'stat\'] = \'ok\';
        }
    }
}

echo json_encode($result);

',
    'TYPE' => 'php',
    'DIR' => './gy/admin/',
  ),
  './gy/admin/edit-all-users-propertys.php' => 
  array (
    'CODE' => '<?php

include "../../gy/gy.php"; // подключить ядро // include core

global $USER;

if ($USER->isAdmin()) {

    include "../../gy/admin/header-admin.php";

    // редактирование общих свойств пользователей
    $APP->component(
        \'edit-all-users-propertys\',
        \'0\',
        array()
    );

    include "../../gy/admin/footer-admin.php";

} else {
    header( \'Location: /gy/admin/\' );
}


',
    'TYPE' => 'php',
    'DIR' => './gy/admin/',
  ),
  './gy/admin/edit-user.php' => 
  array (
    'CODE' => '<?php

include "../../gy/gy.php"; // подключить ядро // include core

global $USER;
$data = $_REQUEST;

if (Gy\\Core\\User\\AccessUserGroup::accessThisUserByAction( \'show_admin_panel\')
    && !empty($data[\'edit-id\'])
    && is_numeric($data[\'edit-id\'])
    && ($data[\'edit-id\'] != 1)
) {

    include "../../gy/admin/header-admin.php";

    if (Gy\\Core\\User\\AccessUserGroup::accessThisUserByAction( \'edit_users\')) {
        $APP->component(
            \'edit_user\',
            \'0\',
            array(
                \'back-url\' => \'/gy/admin/users.php\',
                \'id-user\' => $data[\'edit-id\']
            )
        );
    }

    include "../../gy/admin/footer-admin.php";

} else {
	header( \'Location: /gy/admin/\' );
}


',
    'TYPE' => 'php',
    'DIR' => './gy/admin/',
  ),
  './gy/admin/edit-users-propertys.php' => 
  array (
    'CODE' => '<?php
include "../../gy/gy.php"; // подключить ядро // include core

global $USER;
$data = $_REQUEST;

if (Gy\\Core\\User\\AccessUserGroup::accessThisUserByAction( \'show_admin_panel\')
    && !empty($data[\'edit-id\'])
    && is_numeric($data[\'edit-id\'])
    && ($data[\'edit-id\'] != 1) 
) {

    include "../../gy/admin/header-admin.php";

    if (Gy\\Core\\User\\AccessUserGroup::accessThisUserByAction( \'edit_users\')) {

        // редактирование общих свойств пользователей
        $APP->component(
            \'edit-users-propertys\',
            \'0\',
            array(
                \'id-user\' => $data[\'edit-id\']
            )
        );
    }
    include "../../gy/admin/footer-admin.php";

} else {
    header( \'Location: /gy/admin/\' );
}


',
    'TYPE' => 'php',
    'DIR' => './gy/admin/',
  ),
  './gy/admin/footer-admin.php' => 
  array (
    'CODE' => '<?php 
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );
?>

    </body>
</html>
',
    'TYPE' => 'php',
    'DIR' => './gy/admin/',
  ),
  './gy/admin/get-admin-page.php' => 
  array (
    'CODE' => '<?php
include "../../gy/gy.php"; // подключить ядро // include core

global $USER;
$module = Gy\\Core\\Module::getInstance();
global $APP;

$data  = $_GET;

if (Gy\\Core\\User\\AccessUserGroup::accessThisUserByAction( \'show_admin_panel\')
    && !empty($data[\'page\']) 
) {

    // надо ссылаться сюда для получения страницы админки относящихся к модулям,
    // пример в урле /gy/admin/container-data-edit.php станет 
    //   /gy/admin/get-admin-page.php?page=container-data-edit ... 
    //   далее как и было
    // + подумать над безопасностью
    // если есть такая страница то подключить её
    if (!empty($module->nameModuleByNameAdminPage[$data[\'page\']])) {
        include_once( $APP->url.\'/modules/\'.$module->nameModuleByNameAdminPage[$data[\'page\']].\'/admin/\'.$data[\'page\'].\'.php\' );
    }

} else {
    header( \'Location: /gy/admin/\' );
}
',
    'TYPE' => 'php',
    'DIR' => './gy/admin/',
  ),
  './gy/admin/group-user.php' => 
  array (
    'CODE' => '<?php
include "../../gy/gy.php"; // подключить ядро // include core

global $USER;

if ($USER->isAdmin()) {

    include "../../gy/admin/header-admin.php";

    // таблица с пользователями
    $APP->component(
        \'users_group_manager\',
        \'0\',
        array()
    );

    include "../../gy/admin/footer-admin.php";

} else {
    header( \'Location: /gy/admin/\' );
}



',
    'TYPE' => 'php',
    'DIR' => './gy/admin/',
  ),
  './gy/admin/header-admin.php' => 
  array (
    'CODE' => '<?php
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

use Gy\\Core\\Lang;

global $APP;
global $USER;

$langTextThisFile = new Lang(
    $APP->urlProject."/gy/admin", 
    \'header-admin\', 
    $APP->options[\'lang\']
);
?>

<html>
    <head>
        <title>gy -admin</title>
        <link href="../../gy/style/main.css" rel="stylesheet">
        <script src="../../gy/js/main.js"></script>
    </head>
    <body class="gy-body-admin">
        
        
        
        <h2 class="gy-admin-logo">
            <?=$langTextThisFile->getMessage(\'title\')?>
        </h2>
        <?php
        if (!empty($APP->options[\'v-gy\'])) {
        ?>
            <span class="version-gy-core">v <?=$APP->options[\'v-gy\']?></span>
            <br/>
        <?php
        }
        ?>
        <a href="/" class="gy-admin-button-min" >
            <?=$langTextThisFile->getMessage(\'site\')?>
        </a>
        <br/>
        <br/>
        <?php
        if (Gy\\Core\\User\\AccessUserGroup::accessThisUserByAction( \'show_admin_panel\')) {

            // меню доступное для текущего пользователя
            $buttonName = $langTextThisFile->getMessage(\'index-page\');
            $menu[$buttonName] = \'/gy/admin/index.php\';

            if (Gy\\Core\\User\\AccessUserGroup::accessThisUserByAction( \'edit_users\') 
                || $USER->isAdmin()
            ) {
                $buttonName = $langTextThisFile->getMessage(\'users\');
                $menu[$buttonName] = \'/gy/admin/users.php\';
            }

            // надо добавить пункты меню заданные в подключенных модулях
            $module = Gy\\Core\\Module::getInstance();
            foreach ($module->getButtonsMenuAllModules() as $nameModule => $arButton) {
                // условия показа пункта меню (задаётся модулем) или если админ
                if (
                    (!empty($module->getFlagShowButtonsAdminPanelByModule[$nameModule])
                     && Gy\\Core\\User\\AccessUserGroup::accessThisUserByAction( 
                            $module->getFlagShowButtonsAdminPanelByModule[$nameModule]
                        ) 
                    )
                    || $USER->isAdmin()
                ) {
                    foreach ($arButton as $buttonName => $buttonUrl) {
                        $menu[$buttonName] = $buttonUrl;
                    }
                }
            }

            $menu[ $langTextThisFile->getMessage(\'modules\') ] = \'/gy/admin/modules.php\';
            
            if ($USER->isAdmin()) {
                $menu[ $langTextThisFile->getMessage(\'options\') ] = \'/gy/admin/options.php\';
            }

            // menu
            $APP->component(
                \'menu\',
                \'0\',
                array(
                    \'buttons\' => $menu
                )
            );
        }
',
    'TYPE' => 'php',
    'DIR' => './gy/admin/',
  ),
  './gy/admin/index.php' => 
  array (
    'CODE' => '<?php
include "../../gy/gy.php"; // подключить ядро // include core

include "../../gy/admin/header-admin.php";

// пример вызова компонента // example run component
$APP->component(
    \'admin\',
    \'0\',
    array()
);

include "../../gy/admin/footer-admin.php";

',
    'TYPE' => 'php',
    'DIR' => './gy/admin/',
  ),
  './gy/admin/lang_header-admin.php' => 
  array (
    'CODE' => '<?php // языковой файл для componentInfo.php
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

$mess[\'rus\'] = array(
    \'title\' => \'Админка gy framework\',
    \'site\' => \'Перейти на сайт\',
    \'modules\' => \'Модули\',
    \'options\' => \'Настройки\',
    \'index-page\' => \'Главная админки\',
    \'users\' => \'Пользователи\'
);

$mess[\'eng\'] = array(
    \'title\' => \'Admin panel - gy framework\',
    \'site\' => \'Go to website\',
    \'modules\' => \'Modules\',
    \'options\' => \'Options\',
    \'index-page\' => \'Home\',
    \'users\' => \'Users\'
);',
    'TYPE' => 'php',
    'DIR' => './gy/admin/',
  ),
  './gy/admin/modules.php' => 
  array (
    'CODE' => '<?php
include "../../gy/gy.php"; // подключить ядро // include core

global $USER;

if ($USER->isAdmin()) {

    include "../../gy/admin/header-admin.php";

    // таблица с пользователями
    $APP->component(
        \'show_include_modules\',
        \'0\',
        array()
    );

    include "../../gy/admin/footer-admin.php";

} else {
    header( \'Location: /gy/admin/\' );
}



',
    'TYPE' => 'php',
    'DIR' => './gy/admin/',
  ),
  './gy/admin/options.php' => 
  array (
    'CODE' => '<?php
include "../../gy/gy.php"; // подключить ядро // include core

global $USER;

if (Gy\\Core\\User\\AccessUserGroup::accessThisUserByAction( \'show_admin_panel\')) {

    include "../../gy/admin/header-admin.php";

    if (Gy\\Core\\User\\AccessUserGroup::accessThisUserByAction(\'action_all\')) {
        $APP->component(
            \'gy_options\',
            \'0\',
            array()
        );
    }

    include "../../gy/admin/footer-admin.php";

} else {
    header( \'Location: /gy/admin/\' );
}',
    'TYPE' => 'php',
    'DIR' => './gy/admin/',
  ),
  './gy/admin/users.php' => 
  array (
    'CODE' => '<?php
include "../../gy/gy.php"; // подключить ядро // include core

global $USER;

$data = $_REQUEST;

if (Gy\\Core\\User\\AccessUserGroup::accessThisUserByAction( \'show_admin_panel\')) {

    include "../../gy/admin/header-admin.php";

    if (Gy\\Core\\User\\AccessUserGroup::accessThisUserByAction( \'edit_users\')) {

        if (isset($data[\'show-id\']) && is_numeric($data[\'show-id\'])) {
            // если есть параметр show-id то просто просмотреть все данные 
            //   по конкретному пользователю
            $APP->component(
                \'show_user\',
                \'0\',
                array(
                    \'id\' => $data[\'show-id\']
                )
            );

        } else { // просмотр всех пользователей
            // таблица с пользователями
            $APP->component(
                \'users_all_tables\',
                \'0\',
                array()
            );
        }

    }
    include "../../gy/admin/footer-admin.php";

} else {
    header( \'Location: /gy/admin/\' );
}



',
    'TYPE' => 'php',
    'DIR' => './gy/admin/',
  ),
  './gy/classes/Gy/Core/AbstractClasses/Cache.php' => 
  array (
    'CODE' => '<?php 

namespace Gy\\Core\\AbstractClasses;

if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

/** 
 * abstract class Cache - описывает класс работы с кешем
 */
abstract class Cache
{

    /**
     * cacheInit - инициализация кеша
     * @param string $cacheName
     * @param int $cacheTime - время кеширования в секундах
     * @return boolean
     */
    abstract public function cacheInit($cacheName, $cacheTime);
    
    /**
     * getCacheData() - получить данные из кеша
     * @return mixed - может быть массив или одиночное значение любого типа
     */
    abstract public function getCacheData();
    
    /**
     * setCacheData - записать данные в в кеш
     * @param mixed $data - может быть массив или одиночное значение
     * @return boolean true
     */
    abstract public function setCacheData($data);
}
',
    'TYPE' => 'php',
    'DIR' => './gy/classes/Gy/Core/AbstractClasses/',
  ),
  './gy/classes/Gy/Core/AbstractClasses/Db.php' => 
  array (
    'CODE' => '<?php

namespace Gy\\Core\\AbstractClasses;

if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

/** abstract class work database
 * 
 * 
 */
abstract class Db
{
    /** connect() - create connect in database
     * @param string $host - адрис хоста
     * @param string $user - логин
     * @param string $pass - пароль
     * @param string $nameDb - имя БД
     * @param string $port - порт
     * @return resurs, false
     */
    abstract public function connect($host, $user, $pass, $nameDb, $port);

    /** query()  - out query in database
     * @param $db - resurs (create self::connect()), $query - string query
     * @return false or object result query
     */
    abstract public function query($query); // запрос к db

    /**  close() - close connect database
     * @param $db - resurs (create self::connect()) 
     * @return true - ok OR false - not ok
     */
    abstract public function close(); // закрыть подключение к db

    //abstract public function select();

    /**
     * fetch - получить порцию (строку) данных, после выполнения запроса в БД
     * @param $res - результат отработки запроса в БД
     * @return array
    */
    abstract public function fetch($res);

    /**
     * fetchAll - тоже что и fetch только в получит всё в виде массива 
     *     что будет ключём можно указать, либо false тогда вернёт массив 
     *     с ключами по порядку
     * @param $res - результат отработки запроса в БД
     * @param string $key - строка либо false, это что будет ключём в массиве 
     *     (по умолчанию id записи)
     * @return array
    */
    abstract public function fetchAll($res, $key = \'id\');

    // TODO в функции ниже добавить параметры сортировки 
    
    /**
     * selectDb - запрос типа select. на получение данных
     * @param $db - resurs (create self::connect())
     * @param string $tableName - имя таблици 
     * @param array $propertys - параметры (какие поля вернуть или * - все)
     * @param array $where - условия запроса, массив специальной структуры в виде 
     *     дерева (может не быть)
     * @return - false or object result query
     */
    abstract public function selectDb($tableName, $propertys, $where = array());

    /**
     * insertDb - вставка, добавление новых строк в базу данных
     * @param string $tableName - имя таблици 
     * @param array $propertys - параметры (поле = значение)
     * @return - false or object result query
     */
    abstract public function insertDb($tableName, $propertys);

    /**
     * updateDb - обновить поле таблици
     * @param string $tableName - имя таблици 
     * @param array $propertys - параметры (поле = значение)
     * @param array $where - условия запроса, массив специальной структуры 
     *     в виде дерева (может не быть)
     * @return - false or object result query
     */
    abstract public function updateDb($tableName, $propertys, $where = array());

    /**
     * createTable - создать таблицу в базе данных
     * @param string $tableName - имя таблици
     * @param array $propertys - параметры 
     *     (приер  login varchar(50), name varchar(50) ...) 
     * @return - false or object result query
     */
    abstract public function createTable($tableName, $propertys);

    /**
     * deleteDb - удаление строк из таблици
     * @param string $tableName - имя таблици
     * @param array $where - условия запроса, что удалять
     * @return boolean
     */
    abstract public function deleteDb($tableName, $where);
}
',
    'TYPE' => 'php',
    'DIR' => './gy/classes/Gy/Core/AbstractClasses/',
  ),
  './gy/classes/Gy/Core/App.php' => 
  array (
    'CODE' => '<?php 

namespace Gy\\Core;

use Gy\\Core\\Component\\Component;
use Gy\\Core\\Lang;
use Gy\\Core\\Security;

if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

final class App
{

    public $url;
    public $options; // настройки проекта
    public $lang; // табличка с языковыми сообщениями
    //public $db; // db
    public $urlProject; // урл как $this-url только без /gy в конце

    private static $APP;

    private function  __construct($url, $options)
    {
        // подключить настройки
        $this->options = $options;
        
        // записать ещё путь c /gy
        $this->url = $url.\'/gy\';
        
        // путь до проекта
        $this->urlProject = $url;
        
        // если есть языковой файл то надо подключить его
        $this->lang = new Lang($url, \'app\', $this->options[\'lang\']);
    }

    /**
     * createApp - создать объект класса app, запишет его в статичное свойство и вернёт
     * @param string $url - расположение проекта
     * @return object class app
     */
    public static function createApp($url, $options)
    {
        if (static::$APP === null) {
            static::$APP = new static($url, $options);
        }
        return static::$APP;
    }

    /** 
     *  component отобразить компонент // show component
     *  @param string $name - имя компонента и контроллера сразу 
     *  @param string $template - имя шаблона 
     *  @param array $arParam - параметры компонента (параметры кеша и прочие нюансы) 
     *      // array component config
     *  @param strung $url - url где лежит проект
     *  вернёт объект компонент
     * 
     * TODO возможно понадобится сделать подключение модели 
     *     // если делать универсальные модели для компонентов
     *  или возможность подключать много моделей разных
     *  maybe includ many model in component
     */
    public function component($name, $template, $arParam)
    {
        if ($name != \'includeHtml\') {
            // обезопасим входные параметры
            $arParam = Security::filterInputData($arParam);
        }

        $component = new Component(
            $name, 
            $template, 
            $arParam, 
            $this->urlProject, 
            $this->options[\'lang\']
        );
        return $component;
    }

    /**
     * getAllUrlTisPage()
     *  - вернёт полный путь к текущей страницы (вместе с get параметрами)
     * 
     * @return string
     */
    public function getAllUrlTisPage()
    {
        return $_SERVER[\'REQUEST_URI\'];
    }

    /**
     * getUrlTisPageNotGetProperty()
     *  - вернёт полный путь к текущей страницы (без get параметров)
     * 
     * @return string
     */
    public function getUrlTisPageNotGetProperty()
    {
        return $_SERVER[\'SCRIPT_NAME\'];
    }


}
',
    'TYPE' => 'php',
    'DIR' => './gy/classes/Gy/Core/',
  ),
  './gy/classes/Gy/Core/Cache/CacheFiles.php' => 
  array (
    'CODE' => '<?php

namespace Gy\\Core\\Cache;

use Gy\\Core\\AbstractClasses\\Cache;

if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

/**
 * cache - класс для работы с кешем
 * для даботы нужен раздел gy/cache/
 */
class CacheFiles extends Cache 
{
    private $urlCache = \'/cache/\';
    private $urlProject = \'/\';
    private $data = array();
    private $cacheName = \'noneme\';
    private $cacheTime = \'\';
    private $endUrl = \'.php\';

    /**
     * 
     * @param type $urlProject - путь к проекту
     */
    public function __construct($urlProject)
    {
        $this->urlProject = $urlProject;
    }

    /**
     * cacheInit - инициализация кеша, надо проверить есть кеш по заданным параметрам
     * @param string $cacheName
     * @param int $cacheTime - время кеширования в секундах
     * @return boolean
     */
    public function cacheInit($cacheName, $cacheTime)
    {
        $this->cacheName = $cacheName;
        $this->cacheTime = $cacheTime;

        if (file_exists($this->urlProject.$this->urlCache.$this->cacheName.$this->endUrl)) {
            $cacheData = array();
            include $this->urlProject.$this->urlCache.$this->cacheName.$this->endUrl;

            if (!empty($cacheData)) {
                $cacheData = json_decode($cacheData, true);
                if (((int) $cacheData[\'createTime\'] + (int) $cacheData[\'cacheTime\']) > time()) {
                    $this->data = $cacheData[\'data\'];
                    unset($cacheData);
                }
            }
        }

        return !empty($this->data);
    }

    /**
     * getCacheData - получить данные из кеша
     * @return mixed - может быть массив или одиночное значение любого типа
     */
    public function getCacheData()
    {
        return $this->data;
    }

    /**
     * setCacheData - установить данные в кеш
     * @param mixed $data - может быть массив или одиночное значение
     * @return boolean true
     */
    public function setCacheData($data)
    {
        $cacheData = array(
            \'data\' => $data,
            \'createTime\' => time(),
            \'cacheTime\' => $this->cacheTime
        );
        if (file_exists($this->urlProject.$this->urlCache.$this->cacheName.$this->endUrl)) {
            file_put_contents(
                $this->urlProject.$this->urlCache.$this->cacheName.$this->endUrl, 
                \'<?php $cacheData = \'."\'". json_encode($cacheData)."\';" 
            );
        }
        return true;
    }

    /**
     * clearThisCache - удалит текущий кеш (кеш связанный с текущим объектом)
     */
    public function clearThisCache()
    {
        if (file_exists($this->urlProject.$this->urlCache.$this->cacheName.$this->endUrl)) {
            unlink($this->urlProject.$this->urlCache.$this->cacheName.$this->endUrl);
        }
    }

}
',
    'TYPE' => 'php',
    'DIR' => './gy/classes/Gy/Core/Cache/',
  ),
  './gy/classes/Gy/Core/Capcha.php' => 
  array (
    'CODE' => '<?php 

namespace Gy\\Core;

if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

/**
 * class Capcha - для работы с капчей
 */
class Capcha
{

    // символы которые будут в капче
    //private static $letters = \'abcdefghijklmnopqrstuvwxyzABCDRFGHIJKLMNOPQRSTUVWXYZ0123456789\';
    //  убрал ноль и буквы о, что бы не было путаниц
    private static $letters = \'aAbBcCdDeEfFgG1hHiI2jJkK3lLm4MnN5p6PqQr7RsSt8TuUv9VwWxXyYzZ\';
    
    private $count = 5; // количество символов
    private $code = 5; // код капчи
    private $urlFonts; // путь до шрифта (шрифт нужен что бы поворачивать буквы)
    public static $defaultUrlFonts = "/fonts/18018.otf"; //
    
    public function __construct($urlFonts = false)
    {
        $this->urlFonts = $urlFonts;

        $oldCodeCapcha = self::getCapchaValue();
        if (!empty($oldCodeCapcha)) {
            $this->code = $oldCodeCapcha;
        } else {
            $this->setCapchaValue( self::getRandLetters($this->count) );
        }
        
    }

    /**
     * createNewCapchaData
     *  - сгенерирует новые символы и сохранит
     * 
     */
    public function createNewCapchaData()
    {
        $this->setCapchaValue( self::getRandLetters($this->count) );
    }
    
    /**
     * clearCapcha - очистить текущий код капчи
     */
    public static function clearCapcha()
    {
        unset($_SESSION[\'capcha\']);
    }

    /**
     * chackCapcha - проверить код с установленным кодом в капче
     * @param string $code
     * @return boolean
     */
    public function chackCapcha( $code)
    {       
        $arResult = false;
        // проверит код с капчи
        // всё приводится к верхнему регистру что бы пользователю проще 
        //     было угадать капчу
        
        if ($_SESSION[\'capcha\'] == mb_strtoupper($code)) { 
            $arResult = true;
        }
        self::clearCapcha();
        
        if ($arResult === false) {
            // если проверка капчи не прошла то сгенерить новый код капчи
            $this->createNewCapchaData();
        }
        
        return $arResult;
    }

    /**
     * setCapchaValue - установить код капчи
     * @param type $value
     */
    private function setCapchaValue($value)
    {       
        // задать код в классе
        $this->code = $value;

        // записать в сессию значение
        $_SESSION[\'capcha\'] = mb_strtoupper($this->code);
        
    }

    /**
     * getCapchaValue
     *  - получить код капчи из сессии 
     * 
     * @return string
     */
    private function getCapchaValue()
    {
        return $_SESSION[\'capcha\']; 
    }
    
    /**
     * getImageCapcha - вызовет createImageCapcha с нужным кодом
     * это всё чтобы нарисовать картинку капчи
     */
    public function getImageCapcha()
    {
        // задаст стандартные настройки и вызовет createImageCapcha для определённого кода
        $this->createImageCapcha($this->code);
    }

    /**
     * createImageCapcha - нарисовать картинку капчи по заданному коду
     * @param string $code
     */
    private function createImageCapcha($code)
    {

        // постоянные ширина и высота
        $gX = 100;
        $gY = 50;

        ob_clean(); // очистить вывод до этого момента
        header ("Content-type: image/png");
        $img = imagecreatetruecolor($gX, $gY);

        // определяем белый цвет
        $white = imagecolorallocate($img, 0xFF, 0xFF, 0xFF);

        // делаем фон белым
        imagefill($img, 1, 1, $white);

        // нарисовать шум (рендомной длинны в рендомные стороны)
        $j = rand(5, 10);
        for ($i = 0; $i < $j; $i++) {
            
            // произвольно задать цвет
            $r = rand(50, 230);
            $g = rand(50, 230);
            $b = rand(50, 230);
            $textColor = imagecolorallocate($img, $r, $g, $b);
            
            // Рисуем линию
            $x1 = rand(0, $gX);
            $x2 = rand(0, $gX);
            $y1 = rand(0, $gY);
            $y2 = rand(0, $gY);
            
            imageline($img, $x1, $y1, $x2, $y2, $textColor);
        }

        // рисуется код капчи
        for ($i = 0; $i < strlen($code); $i++) {
            
            // произвольно задать цвет
            $r = rand(50, 230);
            $g = rand(50, 230);
            $b = rand(50, 230);
            $textColor = imagecolorallocate($img, $r, $g, $b);

            $font = rand(5, 7); // размер шрифта

            $j = rand(0,1);
            if ($j == 0) {
                $y = sin($i)*10;
            } else {
                $y = cos($i)*10;
            }

            $x = rand(3, 10);

            if ($this->urlFonts == false) {
                // если не задан шрифт то будет штатным рисоваться но без поворота букв
                imagestring($img, $font, $x+($i*20), 10+$y,  $code[$i], $textColor);
                imagestring($img, $font, $x+1+($i*20), 11+$y,  $code[$i], $textColor);
            } else {
                // иначе заданным шрифтом рисует с поворотом букв
                $a = 30 - rand(0, 60); // угол от -30 до 30
                imagettftext($img, $font*3, $a, $x+($i*20), 30+$y, $textColor, $this->urlFonts, $code[$i]);
                imagettftext($img, $font*3, $a, $x+1+($i*20), 31+$y, $textColor, $this->urlFonts, $code[$i]);
            }
        }

        imagepng($img);
        imagedestroy($img);
        die(); // что бы не было вывода после
    }

    /**
     * getRandLetters - получить рендомный набор символов, указанной длинны
     * @param int $count
     * @return string
     */
    public function getRandLetters($count)
    {
        $randLetters = \'\';
        for ($i = 0; $i < $count; $i++) {
            $randLetters .= self::getRandLetter();
        }
        return $randLetters;
    }

    /**
     * getRandLetter - получить произвольный символ из заданного набора символов self::$arrayLetters
     * @return type
     */
    private function getRandLetter()
    {
        $countLetters = strlen(self::$letters);
        $randLetter = rand(0, ($countLetters-1) );
        return substr(self::$letters, $randLetter, 1);
    }

}',
    'TYPE' => 'php',
    'DIR' => './gy/classes/Gy/Core/',
  ),
  './gy/classes/Gy/Core/Component/Component.php' => 
  array (
    'CODE' => '<?php 

namespace Gy\\Core\\Component;

use Gy\\Core\\Lang;
use Gy\\Core\\Module;
use Gy\\Core\\Component\\Mvc\\Controller;
use Gy\\Core\\Component\\Mvc\\Model;
use Gy\\Core\\Component\\Mvc\\Template;

if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

class Component
{

    public $template; // тут будут объект класса template
    public $controller;
    public $model;
    public $url;
    public $lang; 

    public function __construct( $name, $template, $arParam, $url, $lang )
    {
        $this->lang = new Lang($url.\'/gy/lang/\', \'component\', $lang);

        // TODO $template - сюда можно и пустую строку записать
        // могут быть разные шаблоны

        $err = 0;
        $errText = \'\';

        // нужно попробовать найти подключаемый компонент среди подключённых модулей
        $module = Module::getInstance();
        $urlComponentInModule = $module->getModulesComponent($name);

        if (($err == 0) && file_exists($url.\'/customDir/component/\'.$name.\'/teplates/\'.$template.\'/template.php\' )) {
            // если есть такой компонент и указанный шаблон в папке /customDir/ то подключить от туда
            $template = new Template($url.\'/customDir/component/\'.$name.\'/teplates/\'.$template, $lang ); 
        } elseif (($urlComponentInModule !== false) && file_exists($urlComponentInModule.\'/teplates/\'.$template.\'/template.php\' )) {
            // проверить нет ли компонента среди подключенных модулей
            $template = new Template($urlComponentInModule.\'/teplates/\'.$template, $lang ); 
        } elseif (($err == 0) && file_exists($url.\'/gy/component/\'.$name.\'/teplates/\'.$template.\'/template.php\' )) { 
            // если нет то поискать шаблон в стандартной папке с компонентами
            $template = new Template($url.\'/gy/component/\'.$name.\'/teplates/\'.$template, $lang );
        } else {
            $err = 1;
            $errText = $this->lang->getMessage(\'err_not_controller\');
        }

        if (($err == 0) && file_exists($url.\'/customDir/component/\'.$name.\'/controller.php\' )) { 
            $this->controller = new Controller($url.\'/customDir/component/\'.$name, $lang); // всегда один
        } elseif (($urlComponentInModule !== false) && file_exists($urlComponentInModule.\'/controller.php\' )) {
            $this->controller = new Controller($urlComponentInModule, $lang);
        } elseif (($err == 0) && file_exists($url.\'/gy/component/\'.$name.\'/controller.php\' )) {
            $this->controller = new Controller($url.\'/gy/component/\'.$name, $lang); // всегда один
        } else {
            $err = 2;
            $errText = $this->lang->getMessage(\'err_not_controller\') ;
        }

        if (($err == 0) && file_exists($url.\'/customDir/component/\'.$name.\'/model.php\' )) {
            $model = new Model($url.\'/customDir/component/\'.$name.\'/model.php\'); // может и не быть
            $this->controller->setModel($model);
        } elseif (($urlComponentInModule !== false) && file_exists($urlComponentInModule.\'/model.php\' )) {
            $model = new Model($urlComponentInModule.\'/model.php\'); // может и не быть
            $this->controller->setModel($model);
        } elseif (($err == 0) && file_exists($url.\'/gy/component/\'.$name.\'/model.php\' )) {
            $model = new Model($url.\'/gy/component/\'.$name.\'/model.php\'); // может и не быть
            $this->controller->setModel($model);
        } 

        // TODO вывести ошибку если что то не найдено // значит файлы не все есть

        if ($err != 0) { // если есть ошибки
            $this->ShowErr($errText);
        } else { // иначе запускаем компонент

            $this->controller->setTemplate($template); // задать шаблон
            $this->controller->setArParam($arParam); // передать параметры компонента // set array property component

            $this->run();
        }

        $this->url = $url.\'/gy\';
    }

    /**
     * run() 
     */
    public function run()
    {
        $this->controller->run();
        //$this->template->show($arRes);
    }

    /**
     * ShowErr 
     * @param type $err
     */
    public function ShowErr($err)
    { // TODO вынести в отдельный класс про ошибки
        echo \'<div class=gy_err>\'.$err.\'</div>\';
    }

}
',
    'TYPE' => 'php',
    'DIR' => './gy/classes/Gy/Core/Component/',
  ),
  './gy/classes/Gy/Core/Component/Mvc/Controller.php' => 
  array (
    'CODE' => '<?php 
namespace Gy\\Core\\Component\\Mvc;

use Gy\\Core\\Lang;

if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

class Controller
{
    public $model;
    public $controller; // ссылка для запуска выбранного контроллера компонента
    public $lang;
    public $template; // объект шаблона
    public $arParam;

    public function __construct($url, $lang)
    {
        $this->controller = $url.\'/controller.php\';
        $this->lang = new Lang($url, \'controller\', $lang);
    }

    /**
     * setModel
     * @param type $model
     */
    public function setModel($model)
    { // установить ссылку на модель если есть
        $this->model = $model;
    }

    /**
     * setTemplate - задать шаблон
     * @param object class template $template
     */
    public function setTemplate($template)
    {  
        $this->template = $template;	
    }

    /**
     * setArParam - задать параметры компонента // set array property component
     * @param type $arParam
     */
    public function setArParam($arParam)
    { 
        $this->arParam = $arParam;
    }

    /**
     * run 
     */
    public function run()
    {
        $arRes = array();
        include $this->controller;
    }

}
',
    'TYPE' => 'php',
    'DIR' => './gy/classes/Gy/Core/Component/Mvc/',
  ),
  './gy/classes/Gy/Core/Component/Mvc/Model.php' => 
  array (
    'CODE' => '<?php
namespace Gy\\Core\\Component\\Mvc;

if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

class Model
{
    public $url; // ссылка на шаблон

    public function __construct($url)
    {
        $this->url = $url;
    }

    /**
     * includeModel - подключить файл с моделью компонента
     */
    public function includeModel()
    {		
        require_once $this->url; // !!!
    }
}

',
    'TYPE' => 'php',
    'DIR' => './gy/classes/Gy/Core/Component/Mvc/',
  ),
  './gy/classes/Gy/Core/Component/Mvc/Template.php' => 
  array (
    'CODE' => '<?php

namespace Gy\\Core\\Component\\Mvc;

use Gy\\Core\\Lang;

if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

class Template
{
    public $templateUrl; // ссылка на шаблон
    // public $name; // имя шаблона
    public $lang;
    private $urlFileStyle; // url на файл со стилями, для этого шаблона
    private $urlFileJs; // url для файла с js, для этого шаблона
    
    public function __construct($url, $lang)
    {
        $this->templateUrl = $url.\'/template.php\';

        // проверить существует ли файл стилей для компонента
        if (file_exists($url.\'/style.css\')) {
            $this->urlFileStyle = $url.\'/style.css\';
        }

        // если есть файл js
        if (file_exists($url.\'/script.js\')) {
            $this->urlFileJs = $url.\'/script.js\';
        }

        $this->lang = new Lang($url, \'template\', $lang);
    }

    /* show - нарисовать/показать шаблон 
    *	arr - массив с данными для шаблона
    */
    /*public function show($arr){
        $arRes = $arr;
        include $this->template_url;
        // TODO как то по красивее сделать
    }*/

    /** 
     * show - нарисовать/показать шаблон 
     * @param $arRes - массив с данными для шаблона // array for template
     * 
     * @return void - ничего не вернёт, подключится файл шаблона // include template
     */
    public function show($arRes, $arParam)
    {

        // если есть стили то добавить стили
        if (!empty($this->urlFileStyle)) {
            echo \'<style>\';
            include $this->urlFileStyle;
            echo \'</style>\';
        }

        // файл шаблона
        include $this->templateUrl;

        // если есть js то добавить его
        if (!empty($this->urlFileJs)) {
            echo \'<script>\';
            include $this->urlFileJs;
            echo \'</script>\';
        }
    }
}

',
    'TYPE' => 'php',
    'DIR' => './gy/classes/Gy/Core/Component/Mvc/',
  ),
  './gy/classes/Gy/Core/Crypto.php' => 
  array (
    'CODE' => '<?php

namespace Gy\\Core;

if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

class Crypto
{

    private $sole;

    /**
     * setSole - установить соль (некая строка)
     * @param string $sole
     * @return boolean true
     */
    public function setSole($sole)
    {
        $this->sole = $sole;
        return true;
    }

    /**
     * getSole - получить значение соли
     * @return string
     */
    public function getSole()
    {
        return $this->sole;
    }

    /**
     * getRandString - даст произвольную строку
     * @return string
     */
    public function getRandString()
    {
        return md5(microtime().$this->sole);
    }

    /**
     * getStringForUserCookie - даст строку для пользовательской куки
     *  (склеит соль имя id пользователя и сделает md5)
     * @param string $login
     * @param string $name
     * @param int $id
     * @return string (md5)
     */
    public function getStringForUserCookie($login, $name, $id)
    {
        return md5(microtime().$login.$this->sole.$name.$id);
    }

}


',
    'TYPE' => 'php',
    'DIR' => './gy/classes/Gy/Core/',
  ),
  './gy/classes/Gy/Core/Db/MySql.php' => 
  array (
    'CODE' => '<?php

namespace Gy\\Core\\Db;

use Gy\\Core\\AbstractClasses\\Db;

if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

/* MySql - класс для работы с базой данных mysql
 * class work mysql 
 */
class MySql extends Db
{
    
    public $test = \'mysql ok\';
    public $db;
    
    /* connect() - create connect in database
    * @param $host
    * @param $user
    * @param $pass 
    * @param $nameDb
    * @param $port
    * @return resurs, false
    */
    public function connect($host, $user, $pass, $nameDb, $port)
    {
        $this->db = mysqli_connect($host, $user, $pass, $nameDb, $port);
        return $this->db;
    }
    
    /* query()  - out query in database
     * @param $db - resurs (create self::connect()), $query - string query
     * @return true - ok OR false - not ok
     */
    public function query($query)
    {
        return mysqli_query($this->db, $query);
    }
    
    /*  close() - close connect database
     * @param $db - resurs (create self::connect())
     * @return true - ok OR false - not ok
     */
    public function close()
    {
        return mysqli_close($this->db);
    }
	
    /**
     * fetch - получить порцию (строку) данных, после выполнения запроса в БД
     * @param $res - результат отработки запроса в БД
     * @return array
     */
    public function fetch($res)
    {
        $result = array();
        if ($res !== false) {
            $result = mysqli_fetch_assoc($res);
        }
        return $result;
    }
	
    /**
     * fetchAll - тоже что и fetch только в получит всё в виде массива (с ключём id элемента)
     * @param $res - результат отработки запроса в БД
     * @return array
     */
    public function fetchAll($res, $key = \'id\')
    {
        $result = array();
        while ($arRes = self::fetch($res)) {
            if ($key !== false) {
                $result[$arRes[$key]] = $arRes;
            } else {
                $result[] = $arRes;
            }
        }
        return $result;
    }
    
    public function __construct($dbConfig)
    {
        if (empty($this->db)) {
            if (!empty($dbConfig)) {
                if (empty($dbConfig[\'db_port\'])) {
                    $dbConfig[\'db_port\'] = ini_get("mysqli.default_port");
                }
                $this->connect(
                    $dbConfig[\'db_host\'],
                    $dbConfig[\'db_user\'],
                    $dbConfig[\'db_pass\'],
                    $dbConfig[\'db_name\'],
                    $dbConfig[\'db_port\']
                );
            }
        }
    }

    /**
     * isOneVersionWhere 
     *  (ru) - проверит соответствует ли условие, условию как ниже (первый вариант)
     *         (пока поддерживается только сравнение и не рано \'=\', \'!=\' )
     *  
     *  (en) - will check whether it matches the condition, the condition as below (first option)
     *         (so far only comparison is supported and not early \'=\', \'! =\')
     * 
     *  $where = array(
     *    \'=\' => array(
     *       \'login\',
     *       \'asd2\'
     *    )
     *  ) 
     * 
     * @param array $where - 
     *        (ru) - условие (пример выше, что то типа дерева)
     *        (en) - condition (example above, something like a tree)
     * @return boolean
     */ 
    private function isOneVersionWhere($where)
    {
        $result = false;
        if (count($where) == 1) {
            foreach ($where as $key => $value) {
                if (in_array($key, array(\'=\', \'!=\' )) && (count($value) == 2)) {
                    $result = true;
                }
            }
            $value = array_shift($where);
            
        }
        return $result;
    }

    /**
     * isTwoVersionWhere 
     *  (ru) - проверит соответствует ли условие, условию как ниже (второй вариант)
     *         (пока поддерживается только сравнение и не рано \'=\', \'!=\' и связки \'AND\', \'OR\' )
     *  
     *  (ru) - will check whether the condition matches the condition as below (second option)
     *         (so far only comparison is supported and not early \'=\', \'! =\' and the \'AND\', \'OR\' connectives)
     * 
     *  $where = array(
     *      \'OR\' => array(
     *          array(
     *              \'=\' => array(
     *                  \'login\',
     *                  \'asd2\'
     *              ),
     *          ),
     *          array(
     *              \'!=\' => array(
     *                  \'login\',
     *                  \'asd\'
     *              ),
     *          ),
     *          array(
     *              \'!=\' => array(
     *                  \'login\',
     *                  \'asd\'
     *              ),
     *          ),
     *      )    
     *  ) 
     * 
     * @param array $where - 
     *        (ru) - условие (пример выше, что то типа дерева)
     *        (en) - condition (example above, something like a tree)
     * @return boolean
     */
    private function isTwoVersionWhere($where)
    {
        $result = true;
        foreach ($where as $key => $value) {
            if (in_array($key, array(\'OR\', \'AND\'))) {
                foreach ($value as $value2) {
                    if (!$this->isOneVersionWhere($value2)) {
                        $result = false;
                    }
                }
            } else {
                $result = false;
            }
        }
        return $result;
    }

    /**
     * getStrOneTypeWhere
     *  (ru) - соберёт строчку с условием определённого вида,
     *         для условий из массива $where (метода например select) 1 варианта
     * 
     *  (en) - will collect a line with a condition of a certain kind,
     *         for conditions from the array $where (for example, select parameters) 1 option
     * 
     * @param array $where
     * @return string
     */
    private function getStrOneTypeWhere($where)
    {
        $result = false;
        if (!empty($where[\'=\'])) {
            $result = $where[\'=\'][0]." = ".$where[\'=\'][1];
        } elseif ( !empty($where[\'!=\']) ) {
            $result = $where[\'!=\'][0]." != ".$where[\'!=\'][1];
        }
        return $result;
    }

    /**
     * getStrOneTypeWhere
     *  (ru) - соберёт строчку с условием определённого вида,
     *         для условий из массива $where (метода например select) 2 варианта
     * 
     *  (en) - will collect a line with a condition of a certain kind,
     *         for conditions from the array $where (for example, select parameters) 2 option
     * 
     * @param array $where
     * @return string
     */
    private function getStrTwoTypeWhere($where)
    {
        $result = \'\';
        if (!empty($where[\'AND\'])) {
            foreach ($where[\'AND\'] as $val) {
                $result .= ((!empty($result))? \' AND \': \'\').$this->getStrOneTypeWhere( $val );
            }
        } elseif ( !empty($where[\'OR\'])) {
            foreach ($where[\'OR\'] as $val) {
                $result .= ((!empty($result))? \' OR \': \'\').$this->getStrOneTypeWhere($val);
            }
        }
        return $result;
    }

    /**
     * parseWhereForQuery - парсинг параметров where запроса
     *   массив будет в виде дерева, т.е. конечные массивы должны состоять из 2х элементов 
     * @param type $where
     * @param type $i
     * @param type $key2
     * @return type
     */
    private function parseWhereForQuery($where)
    { 

        $strWhere = \'\';
        if ($this->isOneVersionWhere($where)) {
            // (ru) - если условия 1 варианта
            // (en) - if conditions 1 options
            $strWhere = $this->getStrOneTypeWhere($where);

        } elseif($this->isTwoVersionWhere($where)) {
            // (ru) - если условие 2 варианта
            // (en) - if condition 2 options
            $strWhere = $this->getStrTwoTypeWhere($where);
        }
        // (ru) - остальное пока не поддерживается
        // (en) - the rest is not yet supported
        
        return $strWhere;
    }

     /**
     * selectDb - запрос типа select. на получение данных
     * @param $db - расурс, коннект к базе данных
     * @param string $tableName - имя таблицы 
     * @param array $propertys - параметры (какие поля вернуть или * - все)
     * @param array $where - условия запроса, массив специальной структуры в виде дерева (может не быть)
     * @return - false or object result query
     */
    public function selectDb($tableName, $propertys, $where = array())
    {
        $query = \'SELECT \';
        $strPropertys = implode(",", $propertys);

        if (!empty($where)) {
            $where = \' WHERE \'.$this->parseWhereForQuery($where);
        } else {
            $where = \'\';
        }

        $query .= $strPropertys.\' FROM \'.$tableName.$where.\';\';

        return  $this->query($query);
    }

    /**
     * insertDb - вставка, добавление новых строк в базу данных
     * @param string $tableName - имя таблицы 
     * @param array $propertys - параметры (поле = значение)
     * @return - false or object result query
     */
    public function insertDb($tableName, $propertys)
    {
        $query = \'\';

        // разбить параметры на два списка через запятую // TODO вынести куда то
        global $CRYPTO;
        $nameProperty = \'\';
        $valueProperty = \'\';
        foreach ($propertys as $key=> $val) {
            $nameProperty .= (($nameProperty != \'\')? \', \': \'\').$key;

            if ($key == \'pass\') {
                $val = md5($val.$CRYPTO->getSole());
            }

            if (!is_numeric($val)) {
                $val = "\'".$val."\'";
            }

            $valueProperty .= (($valueProperty != \'\')? \', \': \'\').$val;
        }
        ////

        $query = "INSERT INTO ".$tableName." (".$nameProperty." ) VALUES(".$valueProperty.")";

        return  $this->query($query);
    }

    /**
     * updateDb - обновить поле таблицы
     * @param string $tableName - имя таблицы
     * @param array $propertys - параметры (поле = значение)
     * @param array $where - условия запроса, массив специальной структуры в виде дерева (может не быть)
     * @return - false or object result query
     */
    public function updateDb($tableName, $propertys, $where = array())
    {
        $query = \'UPDATE \';
        $textPropertys = \'\';
        global $CRYPTO;
        foreach ($propertys as $key => $val){

            if ($key == \'pass\') {
                $val = md5($val.$CRYPTO->getSole());
            }

            if (!is_numeric($val)) {
                $val = "\'".$val."\'";
            }
            $textPropertys .= ((!empty($textPropertys))? \',\': \'\').\' \'.$key.\'=\'.$val;
        }

        if (!empty($where)) {
            $where = \' WHERE \'.$this->parseWhereForQuery($where);
        } else {
            $where = \'\';
        }

        $query .= $tableName.\' SET \'.$textPropertys.$where.\';\';

        return  $this->query($query);
    }
    
    /**
     * createTable - создать таблицу в базе данных
     * @param string $tableName - имя таблицы
     * @param array $propertys - параметры (приер  login varchar(50), name varchar(50) ...)
     * @return - false or object result query
     */
    public function createTable($tableName, $propertys)
    {
        $query = \'\';
        $textPropertys = \'\';
        foreach ($propertys as $val) {
            $textPropertys .= ((!empty($textPropertys))? \',\': \'\').\' \'.$val;
        }

        $query = \'CREATE TABLE \'.$tableName.\' (\'.$textPropertys.\');\';

        return $this->query($query);
    }

    /**
     * deleteDb - удаление строк из таблицы
     * @param string $tableName - имя таблицы
     * @param array $where - условия запроса, что удалять
     * @return boolean
     */
    public function deleteDb($tableName, $where)
    {
        $query = \'\';
        if (!empty($where)) {            
            $where = \' WHERE \'.$this->parseWhereForQuery($where);
        } else {
            $where = \'\';
        }

        $query = \'DELETE FROM \'.$tableName.$where;

        return  $this->query($query);
    }
    
    public function __destruct()
    {
        if (!empty($this->db)) {
            $this->close($this->db);
        }
    }
}
',
    'TYPE' => 'php',
    'DIR' => './gy/classes/Gy/Core/Db/',
  ),
  './gy/classes/Gy/Core/Db/PgSql.php' => 
  array (
    'CODE' => '<?php

namespace Gy\\Core\\Db;

use Gy\\Core\\AbstractClasses\\Db;

if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

/** 
 * PgSql - класс для работы с базой данных PostgreSQL
 * class work PostgreSQL
 */
class PgSql extends Db
{

    public $test = \'pgsql ok\';
    public $defaultPort = \'5432\';
    public $db;

    /* connect() - create connect in database
    * @param $host
    * @param $user
    * @param $pass 
    * @param $nameDb
    * @param $port
    * @return resurs, false
    */
    public function connect($host, $user, $pass, $nameDb, $port)
    {        
        $this->db = pg_connect("host=".$host." port=".$port." dbname=".$nameDb." user=".$user." password=".$pass);
        return $this->db;
    }

    /* query()  - out query in database
     * @param $db - resurs (create self::connect()), $query - string query
     * @return true - ok OR false - not ok
     */
    public function query($query)
    {
        return pg_query($this->db, $query);
    }

    /*  close() - close connect database
     * @param $db - resurs (create self::connect())
     * @return true - ok OR false - not ok
     */
    public function close()
    {
        return pg_close($this->db);
    }

    /**
     * fetch - получить порцию (строку) данных, после выполнения запроса в БД
     * @param $res - результат отработки запроса в БД
     * @return array
     */
    public function fetch($res)
    {
        $result = array();
        if ($res !== false) {
            $result = pg_fetch_assoc($res);
        }
        return $result;
    }

    /**
     * fetchAll - тоже что и fetch только в получит всё в виде массива (с ключём id элемента)
     * @param $res - результат отработки запроса в БД
     * @return array
     */
    public function fetchAll($res, $key = \'id\')
    {
        $result = array();
        while ($arRes = self::fetch($res)) {
            if ($key !== false) {
                $result[$arRes[$key]] = $arRes;
            } else {
                $result[] = $arRes;
            }
        }
        return $result;
    }

    public function __construct($dbConfig) 
    {
        if ( empty($this->db)) {
            if (!empty($dbConfig)) {
                if (empty($dbConfig[\'db_port\'])) {
                    $dbConfig[\'db_port\'] = $this->defaultPort;
                }
                $this->connect(
                    $dbConfig[\'db_host\'], 
                    $dbConfig[\'db_user\'], 
                    $dbConfig[\'db_pass\'], 
                    $dbConfig[\'db_name\'], 
                    $dbConfig[\'db_port\']
                );
            }
        }
    }

    /**
     * isOneVersionWhere 
     *  (ru) - проверит соответствует ли условие, условию как ниже (первый вариант)
     *         (пока поддерживается только сравнение и не рано \'=\', \'!=\' )
     *  
     *  (en) - will check whether it matches the condition, the condition as below (first option)
     *         (so far only comparison is supported and not early \'=\', \'! =\')
     * 
     *  $where = array(
     *    \'=\' => array(
     *       \'login\',
     *       \'asd2\'
     *    )
     *  ) 
     * 
     * @param array $where - 
     *        (ru) - условие (пример выше, что то типа дерева)
     *        (en) - condition (example above, something like a tree)
     * @return boolean
     */        
    private function isOneVersionWhere($where)
    {
        $result = false;
        if (count($where) == 1) {
            foreach ($where as $key => $value) {
                if (in_array($key, array(\'=\', \'!=\' )) && (count($value) == 2)) {
                    $result = true;
                }
            }
            $value = array_shift($where);

        }
        return $result;
    }

    /**
     * isTwoVersionWhere 
     *  (ru) - проверит соответствует ли условие, условию как ниже (второй вариант)
     *         (пока поддерживается только сравнение и не рано \'=\', \'!=\' и связки \'AND\', \'OR\' )
     *  
     *  (ru) - will check whether the condition matches the condition as below (second option)
     *         (so far only comparison is supported and not early \'=\', \'! =\' and the \'AND\', \'OR\' connectives)
     * 
     *  $where = array(
     *      \'OR\' => array(
     *          array(
     *              \'=\' => array(
     *                  \'login\',
     *                  \'asd2\'
     *              ),
     *          ),
     *          array(
     *              \'!=\' => array(
     *                  \'login\',
     *                  \'asd\'
     *              ),
     *          ),
     *          array(
     *              \'!=\' => array(
     *                  \'login\',
     *                  \'asd\'
     *              ),
     *          ),
     *      )    
     *  ) 
     * 
     * @param array $where - 
     *        (ru) - условие (пример выше, что то типа дерева)
     *        (en) - condition (example above, something like a tree)
     * @return boolean
     */ 
    private function isTwoVersionWhere($where)
    {
        $result = true;
        foreach ($where as $key => $value) {
            if (in_array($key, array(\'OR\', \'AND\'))) {
                foreach ($value as $value2) {
                    if (!$this->isOneVersionWhere($value2)) {
                        $result = false;
                    }
                }
            } else {
                $result = false;
            }
        }
        return $result;
    }

    /**
     * getStrOneTypeWhere
     *  (ru) - соберёт строчку с условием определённого вида,
     *         для условий из массива $where (метода например select) 1 варианта
     * 
     *  (en) - will collect a line with a condition of a certain kind,
     *         for conditions from the array $where (for example, select parameters) 1 option
     * 
     * @param array $where
     * @return string
     */
    private function getStrOneTypeWhere($where)
    {
        $result = false;
        if (!empty($where[\'=\'])) {
            $where[\'=\'][0] = $where[\'=\'][0];
            $result = $where[\'=\'][0]." = ".$where[\'=\'][1];
        } elseif (!empty($where[\'!=\'])) {
            $where[\'!=\'][0] = $where[\'=\'][0];
            $result = $where[\'!=\'][0]." != ".$where[\'!=\'][1];
        }
        return $result;
    }

    /**
     * getStrOneTypeWhere
     *  (ru) - соберёт строчку с условием определённого вида,
     *         для условий из массива $where (метода например select) 2 варианта
     * 
     *  (en) - will collect a line with a condition of a certain kind,
     *         for conditions from the array $where (for example, select parameters) 2 option
     * 
     * @param array $where
     * @return string
     */
    private function getStrTwoTypeWhere($where)
    {
        $result = \'\';
        if( !empty($where[\'AND\'])) {
            foreach ($where[\'AND\'] as $val) {
                $result .= ((!empty($result))? \' AND \': \'\').$this->getStrOneTypeWhere( $val );
            }
        } elseif (!empty($where[\'OR\'])) {
            foreach ($where[\'OR\'] as $val) {
                $result .= ((!empty($result))? \' OR \': \'\').$this->getStrOneTypeWhere($val);
            }
        }
        return $result;
    }

    /**
     * parseWhereForQuery - парсинг параметров where запроса
     *   массив будет в виде дерева, т.е. конечные массивы должны состоять из 2х элементов 
     * @param type $where
     * @param type $i
     * @param type $key2
     * @return type
     */    
    private function parseWhereForQuery($where)
    { 

        $strWhere = \'\';
        if ($this->isOneVersionWhere($where)) {
            // (ru) - если условия 1 варианта
            // (en) - if conditions 1 options
            $strWhere = $this->getStrOneTypeWhere($where);

        } elseif($this->isTwoVersionWhere($where)) {
            // (ru) - если условие 2 варианта
            // (en) - if condition 2 options
            $strWhere = $this->getStrTwoTypeWhere($where);
        } 
        // (ru) - остальное пока не поддерживается
        // (en) - the rest is not yet supported

        return $strWhere;
    }

     /**
     * selectDb - запрос типа select. на получение данных
     * @param $db - расурс, коннект к базе данных
     * @param string $tableName - имя таблицы 
     * @param array $propertys - параметры (какие поля вернуть или * - все)
     * @param array $where - условия запроса, массив специальной структуры в виде дерева (может не быть)
     * @return - false or object result query
     */
    public function selectDb($tableName, $propertys, $where = array())
    {
        $query = \'SELECT \';

        //$propertys = $this->allValueArrayInMbStrtolower($propertys);

        $strPropertys = implode(",", $propertys);

        if (!empty($where)) {
            $where = \' WHERE \'.$this->parseWhereForQuery($where);
        } else {
            $where = \'\';
        }

        $query .= $strPropertys.\' FROM \'.$tableName.$where.\';\';

        return  $this->query($query);
    }

    private static function allValueArrayInMbStrtolower($array)
    {

        foreach ($array as $key => $value) {
            $where[$key] = mb_strtolower($value);
        }
        return $where;
    }

    /**
     * insertDb - вставка, добавление новых строк в базу данных
     * @param string $tableName - имя таблицы 
     * @param array $propertys - параметры (поле = значение)
     * @return - false or object result query
     */
    public function insertDb($tableName, $propertys)
    {
        $query = \'\';

        // разбить параметры на два списка через запятую // TODO вынести куда то
        global $CRYPTO;
        $nameProperty = \'\';
        $valueProperty = \'\';
        foreach ($propertys as $key=> $val) {
            $nameProperty .= (($nameProperty != \'\')? \', \': \'\').$key;

            if ($key == \'pass\') {
                $val = md5($val.$CRYPTO->getSole());
            }

            if (!is_numeric($val)) {
                $val = "\'".$val."\'";
            }

            $valueProperty .= (($valueProperty != \'\')? \', \': \'\').$val;
        }
        ////

        $query = "INSERT INTO ".$tableName." (".$nameProperty." ) VALUES(".$valueProperty.")";

        return  $this->query($query);
    }

    /**
     * updateDb - обновить поле таблицы
     * @param string $tableName - имя таблицы
     * @param array $propertys - параметры (поле = значение)
     * @param array $where - условия запроса, массив специальной структуры в виде дерева (может не быть)
     * @return - false or object result query
     */
    public function updateDb($tableName, $propertys, $where = array())
    {
        $query = \'UPDATE \';
        $textPropertys = \'\';
        global $CRYPTO;
        foreach ($propertys as $key => $val) {

            if ($key == \'pass\') {
                $val = md5($val.$CRYPTO->getSole());
            }

            if (!is_numeric($val)) {
                $val = "\'".$val."\'";
            }
            $textPropertys .= ((!empty($textPropertys))? \',\': \'\').\' \'.$key.\'=\'.$val;
        }

        if (!empty($where)) {
            $where = \' WHERE \'.$this->parseWhereForQuery($where);
        } else {
            $where = \'\';
        }

        $query .= $tableName.\' SET \'.$textPropertys.$where.\';\';

        return  $this->query($query);
    }

    /**
     * createTable - создать таблицу в базе данных
     * @param string $tableName - имя таблицы
     * @param array $propertys - параметры (приер  login varchar(50), name varchar(50) ...)
     * @return - false or object result query
     */
    public function createTable($tableName, $propertys)
    {
        $query = \'\';
        $textPropertys = \'\';

        foreach ($propertys as $val) {
            $strPos = strpos($val, \'int PRIMARY KEY AUTO_INCREMENT\');
            if ($strPos !== false) {
                $val = str_replace(\'int PRIMARY KEY AUTO_INCREMENT\', \'SERIAL PRIMARY KEY\', $val);
            }
            $textPropertys .= ((!empty($textPropertys))? \',\': \'\').\' \'.$val;
        }
        $query = \'CREATE TABLE IF NOT EXISTS \'.$tableName.\' (\'.$textPropertys.\');\';

        return  $this->query($query);
    }

    /**
     * deleteDb - удаление строк из таблицы
     * @param string $tableName - имя таблицы
     * @param array $where - условия запроса, что удалять
     * @return boolean
     */
    public function deleteDb($tableName, $where)
    {
        $query = \'\';
        if (!empty($where)) {
            $where = \' WHERE \'.$this->parseWhereForQuery($where);
        } else {
            $where = \'\';
        }

        $query = \'DELETE FROM \'.$tableName.$where;

        return $this->query($query);
    }

    public function __destruct() 
    {
        if (!empty($this->db)) {
            $this->close($this->db);
        }
    }
}
',
    'TYPE' => 'php',
    'DIR' => './gy/classes/Gy/Core/Db/',
  ),
  './gy/classes/Gy/Core/Db/PhpFileSqlClientForGy.php' => 
  array (
    'CODE' => '<?php

namespace Gy\\Core\\Db;

use Gy\\Core\\AbstractClasses\\Db;

if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

/* PhpFileSqlClientForGy - класс для работы с базой данных PhpFileSql
 *   https://github.com/ssv32/PhpFileSql
 * class work PhpFileSql 
 */
class PhpFileSqlClientForGy extends Db
{

    public $test = \'PhpFileSqlClient ok\';
    public $db; //TODO private

    // даныне после запроса селект для метода fetch()
    private $dataSelectForFetch = array();  

    /**
     * clearResultMethodSelect()
     *  - сбросит результаты запроса метода select
     * 
     * @return boolean
     */
    private function clearResultMethodSelect()
    {
        $this->dataSelectForFetch = array();
        return true;
    }

    /* connect() - create connect in database
    * @param $host
    * @param $user
    * @param $pass 
    * @param $nameDb
    * @param $port - не используется
    * @return resurs, false
    */
    public function connect($dir, $login, $pass, $nameDb, $port = false)
    {
        $phpFileSql = new \\PhpFileSql($dir);
        $phpFileSql->connect($login, $pass, $nameDb);
        
        $this->db = $phpFileSql;
        return $this;
        
    }

    /* query()  - out query in database //TODO
     * @param $db - resurs (create self::connect()), $query - string query
     * @return true - ok OR false - not ok
     */
    public function query($query)
    {	
        // 
    }

    /*  close() - close connect database
     * @param $db - resurs (create self::connect()) 
     * @return true - ok OR false - not ok
     */
    public function close()
    {
        if (!empty($this->db)) {
            $phpFileSql = $this->db;
            return $phpFileSql->close();
        } else {
            return false;
        }
    }

    /** 
     * fetch - получить порцию (строку) данных, после выполнения запроса в БД
     * @param $res - результат отработки запроса в БД
     * @return array
     */
    public function fetch($res)
    {
        $res = $this->dataSelectForFetch;
        
        $result = false;
        if (($res !== false) && is_array($res)) {

            // беру первое значение из него
            $result = array_shift($res);

            // записываем без первого значения
            $this->dataSelectForFetch = $res;

        }
        return $result;
    }

    /**
     * fetchAll - тоже что и fetch только в получит всё в виде массива (с ключём id элемента)
     * @param $res - результат отработки запроса в БД
     * @return array
     */
    public function fetchAll($res, $key = \'id\')
    {
        $result = false;

        if (($res !== false) && is_array($res)) {
            if ($key !== false ) {
                foreach ($res as $value) {
                    if (!empty($value[$key])) {
                        $result[$value[$key]] = $value;
                    }
                }
            } else {
                $result = $res;
            }
        }

        return $result;
    }

    public function __construct($dbConfig)
    {
        if ( empty($this->db)) {
            if (!empty($dbConfig)) {
                $this->connect($dbConfig[\'db_url\'], $dbConfig[\'db_user\'], $dbConfig[\'db_pass\'], $dbConfig[\'db_name\']);
            }
        }
    }

     /** //TODO
     * selectDb - запрос типа select. на получение данных
     * @param $db - расурс, коннект к базе данных
     * @param string $tableName - имя таблицы 
     * @param array $propertys - параметры (какие поля вернуть или * - все)
     * @param array $where - условия запроса, массив специальной структуры в виде дерева (может не быть)
     * @return - false or object result query
     */
    public function selectDb($tableName, $propertys = \'*\', $where = false)
    {

        // чуть подправить для совместимости
        if ($propertys[0] == \'*\') {
            $propertys = \'*\';
        }

        // подготовить массив с условиями для класса PhpFileSql
        $where = $this->createTrueArrayWhereFromPhpFileSql($where);

        $dataResult = $this->db->select($tableName, $propertys, $where);

        // записываю для метода fetch()
        $this->dataSelectForFetch = $dataResult;

        return $dataResult;
    }

    /**
     * insertDb - вставка, добавление новых строк в базу данных
     * @param string $tableName - имя таблицы 
     * @param array $propertys - параметры (поле = значение)
     * @return - false or object result query
     */
    public function insertDb($tableName, $propertys)
    {  
        // сбросить данные предыдущего вызова метода select
        $this->clearResultMethodSelect();

        global $CRYPTO;

        // если встречается пароль то засолить и зашифровать его
        if (!empty($propertys[\'pass\'])) {
            $propertys[\'pass\'] = md5($propertys[\'pass\'].$CRYPTO->getSole());
        }

        return  $this->db->insertInto($tableName, $propertys);
    }

    /**
     * updateDb - обновить поле таблицы
     * @param string $tableName - имя таблицы
     * @param array $propertys - параметры (поле = значение)
     * @param array $where - условия запроса, массив специальной структуры в виде дерева (может не быть)
     * @return - false or object result query
     */
    public function updateDb($tableName, $propertys, $where = array())
    {
        // сбросить данные предыдущего вызова метода select
        $this->clearResultMethodSelect();

        // подготовить массив с условиями для класса PhpFileSql
        $where = $this->createTrueArrayWhereFromPhpFileSql($where);

        // если встречается пароль то засолить и зашифровать его
        global $CRYPTO;
        if (!empty($propertys[\'pass\'])) {
            $propertys[\'pass\'] = md5($propertys[\'pass\'].$CRYPTO->getSole());
        }

        return $this->db->update($tableName, $propertys, $where);
    }

    /** // TODO сделать PRIMARY KEY AUTO_INCREMENT
     * createTable - создать таблицу в базе данных
     * @param string $tableName - имя таблицы
     * @param array $propertys - параметры (приер  login varchar(50), name varchar(50) ...) 
     * @return - false or object result query
     */
    public function createTable($tableName, $propertys)
    {
        // сбросить данные предыдущего вызова метода select
        $this->clearResultMethodSelect();

        // массив мараметров подходящий для PhpFileSql метода createTable
        $arrayColumns = array();

        // нужно подогнать свойства под метод класса PhpFileSql
        foreach ($propertys as $val) {
            $attr = explode(\' \', $val);
            if( (count($attr)>2) 
                && ($attr[1] == \'int\' )
                && ($attr[2] == \'PRIMARY\')
                && ($attr[3] == \'KEY\')
                && ($attr[4] == \'AUTO_INCREMENT\')
            ) { 
                // PRIMARY KEY AUTO_INCREMENT
                $arrayColumns[] = array($attr[0], \'PRIMARY_KEY_AUTO_INCREMENT\' );
            } else {
                $arrayColumns[] = $attr[0];
            }
        }

        return $this->db->createTable($tableName, $arrayColumns);
    }

    /** //TODO из за условий может работать не на всём, желательно ещё потестировать
     * deleteDb - удаление строк из таблицы
     * @param string $tableName - имя таблицы
     * @param array $where - условия запроса, что удалять
     * @return boolean
     */
    public function deleteDb($tableName, $where)
    {
        // сбросить данные предыдущего вызова метода select
        $this->clearResultMethodSelect();
        
        // подготовить массив с условиями для класса PhpFileSql
        $where = $this->createTrueArrayWhereFromPhpFileSql($where);
        
        return $this->db->delete($tableName, $where);
    }

    /**
     * createTrueArrayWhereFromPhpFileSql
     *  - сделать массив where к виду подходящему для класса PhpFileSql
     * 
     * @param array $where
     * @return array
     */
    public function createTrueArrayWhereFromPhpFileSql($where)
    {

        if (is_array($where)) {
            foreach ($where as $key0 => $value0) {
                if (in_array($key0, array(\'=\', \'!=\'))) {
                    $where[$key0][1] = str_replace("\'", \'\', $where[$key0][1]);
                } elseif (in_array($key0, array(\'AND\', \'OR\'))) {
                    foreach ($value0 as $key1 => $value1) {
                        foreach ($value1 as $key2 => $value2) {
                            $where[$key0][$key1][$key2][1] = str_replace("\'", \'\', $where[$key0][$key1][$key2][1]);
                        } 
                    }
                }
            } 
        }  

        return $where;
    }

    public function __destruct()
    {
        $this->close();
    }
}
',
    'TYPE' => 'php',
    'DIR' => './gy/classes/Gy/Core/Db/',
  ),
  './gy/classes/Gy/Core/Image.php' => 
  array (
    'CODE' => '<?php

namespace Gy\\Core;

if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

/* Image class work with image // wrapper class php GD
 * Image класс для работы с изображениями // обёртка класса php GD
 */
class Image
{

    /** 
     * imageResized function compression image (jpeg)
     * imageResized - сжимает изображения (поддерживает пока jpeg)
     * @param string $urlImgIn - ссылка на изображение которое нужно сжать // url input image
     * @param string $urlImageOut - ссылка куда сохранить изображение // url save image
     * @param int $compression - сжатие (0-100) 100 - это наилучшее качество // compression (0-100) 100 max quality
     * @return bool true or false
     */
    public static function imageResized($urlImgIn, $urlImageOut, $compression)
    {
        $result = false;
        $arImg = getimagesize($urlImgIn);
        if ($arImg[2] == 2) {// jpeg ли это ? // if jpeg image
            $img = imageCreateFromJpeg($urlImgIn);// загрузить изображение сжимаемое // loading Image
            $img2 = imageCreateTrueColor($arImg[0], $arImg[1] ); // создать изображение для сохранение с тем же разрешением // create out image 
            imageCopyResampled($img2, $img, 0, 0, 0, 0, $arImg[0], $arImg[1], $arImg[0], $arImg[1]); 
            imageJpeg($img2, $urlImageOut, $compression); // сохраняем // save out image
            imageDestroy($img2); // очищаем память // clear memory
            $result = true;
        }
        return $result;
    }

}
',
    'TYPE' => 'php',
    'DIR' => './gy/classes/Gy/Core/',
  ),
  './gy/classes/Gy/Core/Lang.php' => 
  array (
    'CODE' => '<?php

namespace Gy\\Core;

if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

class Lang
{

    public $textLang; // тексты определённого языка

    public function __construct($url, $fileName, $lang)
    {
        $result = false;

        if (!empty($url) && !empty($fileName) && !empty($lang)) {
            //load array text language
            $this->textLang = $this->getArrLangFromFilre( $url.\'/lang_\'.$fileName.\'.php\', $lang );
        }

        return $result;
    }

    /** 
     * autoLoadLang
     * авто загрузка языкового файла для файла где вызывается эта функция
     * 	нужно передать в какой файле вызывается (название компонента например, шаблона)
     * @param namePHPFile	- файл в котором будет вызываться данный класс // там где нужен языковой файл
     * @return
     */

    public function autoLoadLang($namePHPFile, $lang )
    {

    }

    /**
     *  getMessage вернуть текст для заданной переменной текущего языка
     * @param string $nameVar - передать переменную 
     * @return вернёт текст или false
     */
    public function getMessage($nameVar )
    {
        $result = false;
        if (!empty($this->textLang[$nameVar])) {
            $result = $this->textLang[$nameVar];
        }
        return $result;
    }

    /**
     * getArrLangFromFilre загрузить массив с текстом нужного языка // load array text language
     * @param $urlFile ссылка на загружаемый файл // url load file
     * @param $lang - нужный язык // language // rus, eng ...
     * 
     * @return массив с текстом на выбранном языке // language text array 
     */
    public function getArrLangFromFilre( $urlFile, $lang )
    {
        $mess = array();

        // если есть файл с языковыми параметрами
        if (file_exists($urlFile) === true) {	
            include $urlFile;
            if(!empty($mess[$lang])){
                $mess = $mess[$lang];
            }
        }

        return $mess;
    }

}
',
    'TYPE' => 'php',
    'DIR' => './gy/classes/Gy/Core/',
  ),
  './gy/classes/Gy/Core/Module.php' => 
  array (
    'CODE' => '<?php

namespace Gy\\Core;

if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

/**
 * Module - работа с модулями фреймворка
 */
class Module
{

    // массив подключённых модулей
    public $arrayIncludeModules = array();

    // массив подключённых модулей и их версии
    public $arrayIncludeModulesAndVersion = array();

    // соответствие компонентов подключенным модулям
    public $nameModuleByComponentName = array();

    // соответствие имени класса (находящегося в модуле) и имени модуля
    public $nameClassModuleByNameModule = array();

    // связь имени страницы и модуля
    public $nameModuleByNameAdminPage = array();

    // пункты меню для админ панели (связанные с модулями)
    public $buttonMenuAdminPanel = array();

    // условия показа пунктов меню админки для подключённых модулей
    public $isShowButtonsMenuAdminPanelModules = array();

    // url до папки gy в проекте
    private $urlGyCore = false;

    // объект класса (всегда будет один)
    private static $module;

    private function  __construct()
    {
        // заполнить пустотой
        $this->arrayIncludeModulesAndVersion = array();
        $this->arrayIncludeModules = array();
        $this->nameModuleByComponentName = array();
        $this->nameClassModuleByNameModule = array();
    }

    /**
     * getInstance 
     *  - получение объекта класса (всегда один обьект)
     * реализация singleton
     * 
     * @return jbject this class
     */
    public function getInstance()
    {
        if (self::$module === null) {
            self::$module = new static();
        }
        return self::$module;
    }

    public function setUrlGyCore($urlGyCore)
    {
        $this->urlGyCore = $urlGyCore;
    }

    /**
     * IncludeModule 
     *  - подключить указанный модуль
     *  (т.е. ядро узнает о классах, компонентах модуля и прочем)
     * 
     * @param string $nameModule - имя модуля
     * 
     * @return bool - вернёт true если модуль найден и подключен или false если нет
     */
    public function includeModule($nameModule)
    {
        $result = false;
        if ($this->urlGyCore !== false) {
            $result = $this->IncludeModuleByUrl($this->urlGyCore.\'/modules/\'.$nameModule.\'/\');
        } // TODO возможно кудато вывести ошибку
        
        return $result;
    }

    /**
     * includeModuleByUrl
     *  - подключить модуль по указанному урлу 
     * 
     * @param string $urlModule
     * @return boolean
     */
    public function includeModuleByUrl($urlModule)
    { // TODO можно добавить проверки на ошибки 
        $result = false;

        if (file_exists($urlModule.\'init.php\' )) {
            include $urlModule.\'init.php\';

            // тут имя модуля
            if (!empty($nameThisModule)) {
                $this->arrayIncludeModules[$nameThisModule] = $urlModule;
                //unset($nameThisModule);

                if (!empty($versionThisModule)) {
                    $this->arrayIncludeModulesAndVersion[$nameThisModule] = $versionThisModule;
                    unset($versionThisModule);
                }

            }

            // тут список компонентов модуля
            if (!empty($componentsThisModule)) {

                foreach ($componentsThisModule as $value) {
                    $this->nameModuleByComponentName[$value] = $nameThisModule;
                }

                unset($componentsThisModule);
            }

            // тут список классов модуля
            if (!empty($classesThisModule)) {

                foreach ($classesThisModule as $value) {
                    $this->nameClassModuleByNameModule[$value] = $nameThisModule;
                }
                unset($classesThisModule);
            }

            // тут список страниц админки
            if (!empty($adminPageThisModule)) {

                foreach ($adminPageThisModule as $value) {
                    $this->nameModuleByNameAdminPage[$value] = $nameThisModule;
                }
                unset($adminPageThisModule);
            }

            // пункты меню в админке
            if (!empty($pagesFromAdminMenu)) {
                $this->buttonMenuAdminPanel[$nameThisModule] = $pagesFromAdminMenu;
                unset($pagesFromAdminMenu);
            }

            // условия показа пунктов меню админки для подключённых модулей
            if (!empty($isShowButtonsMenuAdminPanetThisModule)) {
                $this->isShowButtonsMenuAdminPanelModules[$nameThisModule] = $isShowButtonsMenuAdminPanetThisModule;
                unset($isShowButtonsMenuAdminPanetThisModule);
            }
        }
        return $result;
    }


    /**
     * getModulesComponent
     *  - получить по имени компонента данные о компоненте из подключённых модулей
     * 
     * @param string $nameComponent
     * @return string
     */
    public function getModulesComponent($nameComponent)
    {
        $result = false;

        if (!empty($this->nameModuleByComponentName[$nameComponent])) {
            $result = $this->arrayIncludeModules[ $this->nameModuleByComponentName[$nameComponent] ].\'component/\'.$nameComponent;
        }

        return $result;
    } 

    /**
     * getUrlModuleClassByNameClass
     *  - по имени класса, если он есть в одном из подключённых модулей выдать урл на класс
     * 
     * @param string $nameClass
     * @return string
     */
    public function getUrlModuleClassByNameClass($nameClass)
    {
        $result = false;
        if (!empty($this->nameClassModuleByNameModule[$nameClass])) {
            $result = $this->arrayIncludeModules[ $this->nameClassModuleByNameModule[$nameClass] ].\'classes/\'.$nameClass.\'.php\';
        }
        return $result;
    }

    /**
     * searchAllModules()
     *  - найти все разделы из раздела /gy/modules , т.е. все имеющиеся модули
     * 
     * @return array
     */
    public function searchAllModules()
    {
        $result = array();
        if ($handleDirs = opendir( $this->urlGyCore.\'/modules/\' )) {
            while (false !== ($dirName = readdir($handleDirs))) {
                if (($dirName != \'.\') && ($dirName != \'..\')) {
                    $result[$dirName] = $dirName;
                }
            }
            closedir($handleDirs);
        }
        return $result;
    }

    /**
     * includeAllModules()
     *  - подключить все имеющиеся модули
     * 
     */
    public function includeAllModules()
    {
        $allModules = $this->searchAllModules();
        if (!empty($allModules)) {
            foreach ($allModules as $value) {
                $this->includeModule($value);
            }
        }
    }

    /**
     * installDbModuleByNameModule 
     *  - установить часть БД связанную с этим модулем
     * 
     * @param string $nameModule - имя модуля
     * @return boolean
     */
    public function installDbModuleByNameModule($nameModule)
    { // TODO пока только установка для mysql
        $result = false;
        
        if (file_exists($this->urlGyCore.\'/modules/\'.$nameModule.\'/install/installDataBaseTable.php\' )) {
            include_once( $this->urlGyCore.\'/modules/\'.$nameModule.\'/install/installDataBaseTable.php\' );
            $result = true;
        }

        return $result;
    }

    /**
     * installBdAllModules 
     *  - установить части БД для всех модулей
     */
    public function installBdAllModules()
    {
        $allModules = $this->searchAllModules();
        if (!empty($allModules)) {
            foreach ($allModules as $value) {
                $this->installDbModuleByNameModule($value);
            }
        }
    }

    /**
     * getButtonsMenuByModule
     *  - вернуть кнопки меню панели администратора определённые в указанном модуле
     * 
     * @param string $nameModule - код модуля
     * @return array - массив с кнопками где ключ это название пункта меню а значение url
     */
    public function getButtonsMenuByModule($nameModule)
    {
        return $this->buttonMenuAdminPanel[$nameModule];
    }

    /**
     * getButtonsMenuAllModules
     *  - вернуть все пункты меню админки всех подключённых модулей
     * 
     * @return array - массив с кнопками где ключ это код модуля,
     *   а значения как результат getButtonsMenuByModule
     */
    public function getButtonsMenuAllModules()
    {
        return $this->buttonMenuAdminPanel;
    }

    /**
     * getFlagShowButtonsAdminPanelByModule
     *  - вернуть условие показа кнопок в админке,
     *  это код для метода Gy\\Core\\User\\AccessUserGroup::accessThisUserByAction
     *  т.е. действие и если оно разрешено пользователю то покажется пункты меню в админке
     *  
     * 
     * @param string $nameModule - код модуля
     * @return string - код действия 
     */
    public function getFlagShowButtonsAdminPanelByModule($nameModule)
    {
        return $this->isShowButtonsMenuAdminPanelModules[$nameModule];
    }

    public function getInfoAllIncludeModules()
    {
        return $this->arrayIncludeModulesAndVersion;
    }

}',
    'TYPE' => 'php',
    'DIR' => './gy/classes/Gy/Core/',
  ),
  './gy/classes/Gy/Core/Security.php' => 
  array (
    'CODE' => '<?php

namespace Gy\\Core;

if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

/** 
 * Security - класс с методами для обеспечения безопасности gy framework
 * class work security
 */
class Security
{

    /**
     * filterInputData
     *  - фильтр входных данных, в присланных данных уберёт лишнее
     * 
     * @param array/string $data - потенциально с вредоносом
     * @return array/string - с большей частью вырезанным вредоносом
     */
    public static function filterInputData($data)
    {
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                $data[$key] = self::filterInputData($value);
            }
        } else {
            return self::clearValue($data);
        }
        return $data;
    }


    /**
     * clearValue 
     *  - обработать одно значение, что бы лишнее не прошло
     *  (если передадут случайно массив то тоже отработает)
     * 
     * @param string $value
     * @return string
     */
    private static function clearValue($value)
    {
        $value = trim($value);
        $value = stripslashes($value);
        $value = strip_tags($value);
        $value = htmlspecialchars($value);
        return $value;
    }


}


',
    'TYPE' => 'php',
    'DIR' => './gy/classes/Gy/Core/',
  ),
  './gy/classes/Gy/Core/User/AccessUserGroup.php' => 
  array (
    'CODE' => '<?php

namespace Gy\\Core\\User;

if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

/**
 * AccessUserGroup - будет всё что связано с правами доступов пользователей 
 * (и групп пользователей)
 */
class AccessUserGroup
{

    private static $tableNameAccessGroup = \'access_group\';
    private static $tableNameUserActions = \'action_user\';
    private static $tableNameUsersInGroupss = \'users_in_groups\';

    private static $cacheTimeGetData = 604800;

    /**
     * checkAccessUserGroupsByUserAction - определить можно ли пользователю 
     *     с заданным набором его групп 
     *     и данными по всем группам выполнить указанное действие 
     * 
     * @param array $groupsThisUser - группы к каким относится пользователь
     * @param array $dataAllGroups - данные по всем группам
     * @param string $thisAction - проверяемое действие пользователя
     * @return boolean
     */
    private static function checkAccessUserGroupsByUserAction(
        $groupsThisUser, 
        $dataAllGroups, 
        $thisAction
    ) {
        $arResult = false;

        // определить все действия разрешённые для данного пользователя
        $AllAccessActionsThisUser = array();
        foreach ($groupsThisUser as $nameGroup) {
            if ($dataAllGroups[$nameGroup]) {
                $AllAccessActionsThisUser = array_merge(
                    $AllAccessActionsThisUser, 
                    $dataAllGroups[$nameGroup][\'code_action_user\']
                );
            }
        }
        
        // найти заданное действие среди разрешённых для данного пользователя
        // либо проверить на админа (т.е. разрешены любые действия)
        if (in_array($thisAction , $AllAccessActionsThisUser) 
            || in_array(\'action_all\' , $AllAccessActionsThisUser)
        ) {
            $arResult = true;
        }
        return $arResult;
    }

    /**
     * accessUser() - проверит разрешёно ли указанное действие заданному 
     *     пользователю
     * 
     * @param int $userId - id пользователя
     * @param string $actionUser - код пользовательского действия
     * @return boolean
     */
    public static function accessUser($userId, $actionUser)
    {

        // получить данные по пользователю 
        global $USER;
        $dataUserFind = $USER->getUserById($userId);
        
        // получить данные по всем группам
        $dataAllGroups = self::getAccessGroup();
        
        // определить пользователю с таким набором групп доступно ли указанное 
        //     действие
        return self::checkAccessUserGroupsByUserAction(
            $dataUserFind[\'groups\'], 
            $dataAllGroups, 
            $actionUser
        );
    }

    /**
     * accessThisUserByAction - проверить разрешено ли текущему пользователю 
     *   указанное действие
     * 
     * @global type $USER
     * @param string $action - код действия 
     * @return boolean
     */
    public static function accessThisUserByAction($action)
    {
        global $USER;
        $groupsThisUser = $USER->getThisUserGroups();
        
        // получить данные по всем группам
        $dataAllGroups = self::getAccessGroup();

        // определить пользователю с таким набором групп доступно ли указанное 
        //     действие
        $arResult = self::checkAccessUserGroupsByUserAction(
            $groupsThisUser, 
            $dataAllGroups, 
            $action
        );

        return $arResult;
    }

    /**
     * getAccessGroup() - получить все группы пользователей какие есть
     *  + вернутся заданные в группах разрешения на пользовательские действия
     * @return array
     */
    public static function getAccessGroup()
    {
        $arResult = array();

        global $APP;
        global $CACHE_CLASS_NAME;
        $cache = new $CACHE_CLASS_NAME($APP->url);
        $initCache = $cache->cacheInit(\'getAccessGroup\', self::$cacheTimeGetData);

        if ($initCache) {
            $arResult = $cache->getCacheData();
        } else {

            global $DB;
            $res = $DB->selectDb(self::$tableNameAccessGroup, array(\'*\'));
            while ($arRes = $DB->fetch($res)) {
                if (!empty($arRes[\'code_action_user\'])) {
                    $arResult[$arRes[\'code\']][\'code_action_user\'][$arRes[\'code_action_user\']] = $arRes[\'code_action_user\'];
                }
                $arResult[$arRes[\'code\']][\'name\'] = $arRes[\'name\'];
                $arResult[$arRes[\'code\']][\'code\'] = $arRes[\'code\'];
                $arResult[$arRes[\'code\']][\'text\'] = $arRes[\'text\'];
            }

            $cache->setCacheData($arResult);
        }

        return $arResult;
    }

    /**
     * clearCacheForFunctionGetAccessGroup -
     *  сбросить кеш на получение разрешений для групп и всех данных по группам
     * 
     * @global type $APP
     * @global type $CACHE_CLASS_NAME
     */
    public static function clearCacheForFunctionGetAccessGroup()
    {
        global $APP;
        global $CACHE_CLASS_NAME;
        $cache = new $CACHE_CLASS_NAME($APP->url);
        $cache->cacheInit(\'getAccessGroup\', self::$cacheTimeGetData);
        $cache->clearThisCache();
    }

    /**
     * getUserAction() - получить все какие есть пользовательские действия
     * @return array
     */
    public static function getUserAction()
    {
        $arResult = array();

        global $APP;
        global $CACHE_CLASS_NAME;
        $cache = new $CACHE_CLASS_NAME($APP->url);
        $initCache = $cache->cacheInit(
            \'getUserAction\', 
            self::$cacheTimeGetData
        );

        if ($initCache) {
            $arResult = $cache->getCacheData();
        } else {

            global $DB;
            $res = $DB->selectDb(self::$tableNameUserActions, array(\'*\'));
            while ($arRes = $DB->fetch($res)) {
                $arResult[$arRes[\'code\']][\'code\'] = $arRes[\'code\'];
                $arResult[$arRes[\'code\']][\'text\'] = $arRes[\'text\'];
            }

            $cache->setCacheData($arResult);
        }

        return $arResult;
    }

    /**
     * getListGroupsByUser() - получить список групп к каким относится 
     *     пользователь
     * 
     * @param int $idUsers - id пользователя
     * @return array
     */
    public static function getListGroupsByUser($idUsers)
    {
        $arResult = array();

        // определить id групп к каким относится пользователь
        global $DB;
        $res = $DB->selectDb(
            self::$tableNameUsersInGroupss, 
            array(\'code_group\'), 
            array(\'=\'=>array(\'id_user\', $idUsers ))
        );
        while ($arRes = $DB->fetch($res)) {
            $arResult[$arRes[\'code_group\']] = $arRes[\'code_group\'];
        }

        return $arResult;
    }

    /**
     * addUserInGroup() - добавить пользователя в группуы
     * @param int $idUsers - id пользователя
     * @param string $codeGroup - код группы
     * @return boolean
     */
    public static function addUserInGroup($idUsers, $codeGroup)
    {
        $arResult = false;
        global $DB;
        $res = $DB->insertDb(
            self::$tableNameUsersInGroupss,
            array(
                \'code_group\' => $codeGroup,
                \'id_user\' => $idUsers,
            )
        );
        if ($res) {
            $arResult = true;
        }
        return $arResult;
    }

    /**
     * deleteUserInAllGroups - удалить пользователя из всех групп 
     *  (где он состоит)
     * @param int $idUsers - id пользователя
     * @return boolean
     */
    public static function deleteUserInAllGroups($idUsers)
    {
        $arResult = false;
        global $DB;
        $res = $DB->deleteDb(
            self::$tableNameUsersInGroupss, 
            array(\'=\' => array(\'id_user\', $idUsers)) 
        );
        if ($res) {
            $arResult = true;
        }
        return $arResult;
    }

    /**
     * deleteAllActionsForGroup()
     * - удалить все заданные, разрешённые действия пользователей для указанной 
     *      группы
     * 
     * @global type $DB
     * @param string $codeUserGroup
     * @return boolean
     */
    public static function deleteAllActionsForGroup($codeUserGroup)
    {
        $arResult = false;
        global $DB;
        $dataAllGroup = self::getAccessGroup();

        if (!empty($dataAllGroup[$codeUserGroup])) {
            // тут будут данные по нужной группе
            $dataThisGroup = $dataAllGroup[$codeUserGroup];
            $dataThisGroup[\'code_action_user\'] = \'\';

            // удаляем все данные по этой группе из БД
            $res = $DB->deleteDb(
                self::$tableNameAccessGroup, 
                array(
                    \'=\' => array(
                        \'code\', 
                        "\'".$codeUserGroup."\'"
                    )
                ) 
            );

            if ($res) {
                // добавляем пустую группу
                $res2 = $DB->insertDb(
                    self::$tableNameAccessGroup,
                    $dataThisGroup
                );
                if ($res2) {
                    $arResult = true;
                }
            }
        }
    }

    /**
     * addOptionsGroup() 
     * - добавить для указанной группы пользователей разрешённое действие
     *  
     * @global type $DB
     * @param string $codeUserGroup - код группы
     * @param string $codeAction - код пользовательского действия
     * @return boolean
     */
    public static function addOptionsGroup($codeUserGroup, $codeAction)
    {
        $arResult = false;
        global $DB;
        $dataAllGroup = self::getAccessGroup();

        if (!empty($dataAllGroup[$codeUserGroup])) {
            $dataThisGroup = $dataAllGroup[$codeUserGroup];

            // если действий для пользователя нет обновить группу 
            //     (добавить действия)
            if (empty($dataThisGroup[\'code_action_user\'])) {
                $dataThisGroup[\'code_action_user\'] = $codeAction;
                // если мы попали сюда то всего одна запись в БД соответствует 
                //     этой группе её и обновляем
                $res = $DB->updateDb(
                    self::$tableNameAccessGroup,
                    $dataThisGroup,
                    array(
                        \'=\' => array(
                            \'code\',
                            "\'".$codeUserGroup."\'"
                        )
                    )
                );
                if ($res) {
                    $arResult = true;
                }
            } else { // добавить копию группы с новым действием
                $dataThisGroup[\'code_action_user\'] = $codeAction;
                $res = $DB->insertDb(
                    self::$tableNameAccessGroup, 
                    $dataThisGroup
                );
                if ($res) {
                    $arResult = true;
                }
            }

        }

        // сбросить кеш на получение разрешений для групп и всех данных по группам
        self::clearCacheForFunctionGetAccessGroup();

        return $arResult;
    }

    /**
     * addUserGroup
     *  - добавить новую пользовательскую группу 
     * 
     * @global type $DB
     * @param array $arDataNewGroup - массив с данными по группе (name, code, text)
     * @param array $arActionUserThisGroup - массив с разрешёнными для этой группы 
     *     действиями
     * @return boolean
     */
    public static function addUserGroup($arDataNewGroup, $arActionUserThisGroup)
    {
        global $DB;
        $arResult = true;
        foreach ($arActionUserThisGroup as $value) {
            $res = $DB->insertDb(
                self::$tableNameAccessGroup,
                array(
                    \'code\' => $arDataNewGroup[\'code\'],
                    \'name\' => $arDataNewGroup[\'name\'],
                    \'text\' => $arDataNewGroup[\'text\'],
                    \'code_action_user\' => $value
                )
            );
            if ($res) {
                //$arResult = true;
            } else {
                $arResult = false;
            }
        }

        // сбросить кеш на получение разрешений для групп и всех данных по группам
        self::clearCacheForFunctionGetAccessGroup();

        return $arResult;
    }

    /**
     * deleteUserGroupByCode
     *  - удалить пользовательскую группу по коду группы
     * 
     * @global type $DB
     * @param string $codeGroup - код удаляемой группы
     * @return boolean
     */
    public static function deleteUserGroupByCode($codeGroup)
    {
        global $DB;
        $arResult = false;
        // удалить все связи пользователей с этой группой

        $res = $DB->deleteDb(
            self::$tableNameUsersInGroupss,
            array(\'=\' => array(\'code_group\' , "\'".$codeGroup."\'" ) )
        );
        if ($res) {
            $arResult = true;
        }

        // удалить группу по коду уруппы
        if ($arResult) {
            $arResult = false;
            $res = $DB->deleteDb(
                self::$tableNameAccessGroup,
                array(\'=\' => array(\'code\' , "\'".$codeGroup."\'" ) )
            );
            if ($res) {
                $arResult = true;
            }
        }

        // сбросить кеш на получение разрешений для групп и всех данных по группам
        self::clearCacheForFunctionGetAccessGroup();

        return $arResult;
    }

}',
    'TYPE' => 'php',
    'DIR' => './gy/classes/Gy/Core/User/',
  ),
  './gy/classes/Gy/Core/User/GeneralUsersPropertys.php' => 
  array (
    'CODE' => '<?php

namespace Gy\\Core\\User;

if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

/**
 * GeneralUsersPropertys - класс для работы с общими свойствами пользователей
 */
class GeneralUsersPropertys
{

    private static $tableNameCreatePropertys = \'create_all_users_property\';
    private static $tableNameTypePropertys = \'type_all_user_propertys\';

    private static $tableNameTypePropertysForCodeTypeProperty = array(
        \'text\' => \'value_all_user_propertys_text\'
    );

    /**
     * getAllGeneralUsersPropertys
     *  - получить все созданные пользовательские свойства
     * 
     * @global type $DB
     * @return array
     */
    public static function getAllGeneralUsersPropertys()
    { 
        global $DB;
        $res = $DB->selectDb(
            self::$tableNameCreatePropertys,
            array(\'*\'),
            array()
        );
        $result = $DB->fetchAll($res, \'id\');
        return $result;
    }

    /**
     * getAllTypeAllUsersPropertys
     *  - получить все возможные типы пользовательских свойств
     * 
     * @global type $DB
     * @return array
     */
    public static function getAllTypeAllUsersPropertys()
    {
        global $DB;
        $res = $DB->selectDb(
            self::$tableNameTypePropertys,
            array(\'*\'),
            array(
            )
        );
        $result = $DB->fetchAll($res, \'id\');
        return $result;
    }

    /**
     * addUsersPropertys
     *  - создать пользовательское свойство
     * 
     * @global type $DB
     * @param string $name - имя
     * @param int $idType - тип
     * @param string $code - код
     * @return boolean
     */
    public static function addUsersPropertys($name, $idType, $code)
    {
        $result = false;

        global $DB;
        $res = $DB->insertDb(
            self::$tableNameCreatePropertys,
            array(
                \'name_property\' => $name,
                \'type_property\' => $idType,
                \'code\' => $code
            )
        );

        if ($res){
            $result = true;
        }
        return $result;
    }

    /**
     * deleteUserProperty
     *  - удалить общее пользовательское свойство
     * 
     * @global type $DB
     * @param int $id - id общего пользовательского свойства
     * @return boolean
     */
    public static function deleteUserProperty($id)
    {
        $result = false;
        global $DB;

        $res = $DB->deleteDb(
            self::$tableNameCreatePropertys,
            array(\'=\'=>array(\'id\', $id))
        );

        if ($res) {
            $result = true;
        }

        //удалить значения
        self::deleteAllValuesAllUserBypropertyId($id, \'text\'); // text - т.к. пока других нет

        return $result;
    }

    /**
     * deleteAllValuesAllUserBypropertyId
     *  - удалить все значения определённого свойства у всех пользователей
     * 
     * @global type $DB
     * @param int $idProperty - id свойства (общее свойство)
     * @param string $typePropertyCode - пока у всех значение text
     * @return boolean
     */
    public static function deleteAllValuesAllUserBypropertyId($idProperty, $typePropertyCode)
    {
        $result = false;

        if (!empty(self::$tableNameTypePropertysForCodeTypeProperty[$typePropertyCode])) {
            global $DB;

            $res = $DB->deleteDb(
                self::$tableNameTypePropertysForCodeTypeProperty[$typePropertyCode],
                array( \'=\' => array(\'id_property\', $idProperty) )
            );

            if ($res) {
                $result = true;
            }
        }
        return $result;

    }

    /**
     * getAllValueUserProperty
     *  - взять все значения определённого типа свойства пользователя
     * 
     * @global type $DB
     * @param int $idUser - id пользователя
     * @param string $typePropertyCode - пока у всех значение text
     * @return boolean/array
     */
    public static function getAllValueUserProperty($idUser, $typePropertyCode)
    {
        $result = false;

        if (!empty(self::$tableNameTypePropertysForCodeTypeProperty[$typePropertyCode])) {
            global $DB;
            $res = $DB->selectDb(
                self::$tableNameTypePropertysForCodeTypeProperty[$typePropertyCode],
                array(\'*\'),
                array( \'=\' => array(\'id_users\', $idUser) )
            );
            $result = $DB->fetchAll($res, \'id_property\');
        }
        return $result;
    }

    /**
     * addValueProperty
     *  - добавить значение свойства
     * 
     * @global type $DB
     * @param int $idUser - id пользователя
     * @param string $typePropertyCode - пока у всех значение text
     * @param int $idProperty - id пользовательского свойства
     * @param string $value - пока тип text, тут только строка
     * @return boolean
     */
    public static function addValueProperty($idUser, $typePropertyCode, $idProperty, $value)
    {
        $result = false;

        if (!empty(self::$tableNameTypePropertysForCodeTypeProperty[$typePropertyCode])) {
            global $DB;
            $res = $DB->insertDb(
                self::$tableNameTypePropertysForCodeTypeProperty[$typePropertyCode],
                array(
                    \'value\' => $value,
                    \'id_users\' => $idUser,
                    \'id_property\' => $idProperty
                )
            );

            if ($res) {
                $result = true;
            }
        }
        return $result;
    }

    /**
     * deleteValueProperty 
     *  - удалить значения конкретного свойства конкретного пользователя
     * 
     * @global type $DB
     * @param int $idUser - id пользователя
     * @param string $typePropertyCode - пока у всех значение text
     * @param int $idProperty - id пользовательского свойства
     * @return boolean
     */
    public static function deleteValueProperty($idUser, $typePropertyCode, $idProperty)
    {
        $result = false;

        if (!empty(self::$tableNameTypePropertysForCodeTypeProperty[$typePropertyCode])) {
            global $DB;

            $res = $DB->deleteDb(
                self::$tableNameTypePropertysForCodeTypeProperty[$typePropertyCode],
                array( 
                    \'AND\' => array(
                        array(\'=\' => array(\'id_users\', $idUser) ),
                        array(\'=\' => array(\'id_property\', $idProperty) )
                    ),
                )
            );

            if ($res) {
                $result = true;
            }
        }

        return $result;
    }

    /**
     * updateValueProperty
     *  - изменить значение конкретного свойства конкретного пользователя
     * 
     * @global type $DB
     * @param int $idUser - id пользователя
     * @param string $typePropertyCode - пока у всех значение text
     * @param int $idProperty - id пользовательского свойства
     * @param string $value - пока тип text, тут только строка
     * @return boolean
     */
    public static function updateValueProperty($idUser, $typePropertyCode, $idProperty, $value)
    {
        $result = false;

        if (!empty(self::$tableNameTypePropertysForCodeTypeProperty[$typePropertyCode])) {
            global $DB;
            $res = $DB->updateDb(
                self::$tableNameTypePropertysForCodeTypeProperty[$typePropertyCode],
                array(
                    \'id_users\' => $idUser,
                    \'id_property\' => $idProperty,
                    \'value\' => $value
                ),
                array(
                    \'AND\' => array(
                        array(\'=\' => array(\'id_users\', $idUser) ),
                        array(\'=\' => array(\'id_property\', $idProperty) )
                    ),
                )
            );

            if ($res) {
                $result = true;
            }
        }
        return $result;
    }

}
',
    'TYPE' => 'php',
    'DIR' => './gy/classes/Gy/Core/User/',
  ),
  './gy/classes/Gy/Core/User/User.php' => 
  array (
    'CODE' => '<?php

namespace Gy\\Core\\User;

use Gy\\Core\\User\\AccessUserGroup;

if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

class User
{ 

    protected $authorized = false;
    protected $dataUser;
    protected $nameCookie = \'gy_user_auth\';
    protected $admin = false; 
    public $tableName = \'users\';

    public function __construct()
    {
        $this->checkUserCookie();
    }

    /**
     * getThisUserGroups - получить группы текущего пользователя
     * @return array
     */
    public function getThisUserGroups()
    {
        $arResult = array();
        if (!empty($this->dataUser[\'groups\'])) {
            $arResult = $this->dataUser[\'groups\'];
        }
        return $arResult;
    }

    /**
     * getDataThisUser - получить данные по текущему, авторизованному пользователю
     * @return array
     */
    public function getDataThisUser()
    {
        return $this->dataUser;
    }

    /**
     * isAdmin - проверить является ли текущий, авторизованный пользователем администратором
     * @return booleand
     */
    public function isAdmin()
    {
        return $this->admin;
    }

    /**
     * getAuthorized - узнать авторизован ли пользователь
     * @return booleand
     */
    public function getAuthorized()
    {
        return $this->authorized;
    }

    /**
     * getId - получить id текущего пользователя
     * @return int
     */
    public function getId(){
        return $this->dataUser[\'id\'];
    }

    /**
     * authorized - авторизовать пользователя
     * @param type $log - логин
     * @param type $pass - пароль
     * @return booleand 
     */
    public function authorized($log, $pass )
    {
        $result = $this->chackUser($log, $pass);
        $this->authorized = $result;
        return $result;
    }

    /**
     * chackUser - проверить существует ли пользователь
     * @global type $DB
     * @global type $CRYPTO
     * @param type $log - логин
     * @param type $pass - пароль
     * @return booleand
     */
    protected function chackUser($log, $pass)
    {
        $result = false;

        global $DB;
        global $CRYPTO;

        $res = $DB->selectDb(
            $this->tableName, 
            array(\'*\'),
            array(
                \'AND\' => array( 
                    array(\'=\' => array(\'login\', "\'".$log."\'" ) ),
                    array( \'=\' => array(\'pass\',"\'".md5($pass.$CRYPTO->getSole())."\'") )
                ),
            )
        );

        if ($arRes = $DB->fetch($res)) {

            //$this->setUserCookie($arRes[\'id\'] , $CRYPTO->getRandString());
            $this->setUserCookie($arRes[\'id\'] , $CRYPTO->getStringForUserCookie($arRes[\'login\'], $arRes[\'name\'], $arRes[\'id\']));
            $result = true;
        }

        return $result;

    }

    /**
     * setUserCookie - установить пользовательскую куку
     * @global type $DB
     * @param int $userId - id пользователя
     * @param string $StringCookie - строка, значение куки
     * @return boolean
     */
    protected function setUserCookie($userId, $StringCookie)
    {
        setcookie($this->nameCookie, $StringCookie, 0, \'/\');
        global $DB;

        $res = $DB->updateDb(
            $this->tableName,
            array(\'hash_auth\' => $StringCookie),
            array( \'=\' => array(\'id\' , $userId ) )
        );

        return true;
    }

    /**
     * deleteUserCookie - удалить пользовательскую куку
     * @global type $_COOKIE
     * @global type $DB
     * @param int $userId - id пользователя
     * @return boolean
     */
    protected function deleteUserCookie($userId)
    {
        global $_COOKIE;
        unset($_COOKIE[$this->nameCookie]);
        global $DB;

        $res = $DB->updateDb(
            $this->tableName, 
            array(\'hash_auth\' => \'NULL\'),
            array( \'=\' => array(\'id\' , $userId ) )
        );

        return true;
    }

    /**
     * checkUserCookie - проверить пользовательскую куку
     * @global type $_COOKIE
     * @return boolean
     */
    public function checkUserCookie()
    {
        $result = false;

        global $_COOKIE;

        if (!empty($_COOKIE[$this->nameCookie])) {

            $dataUser = $this->findUserByCookie($_COOKIE[$this->nameCookie]);

            if ($dataUser !== false) {
                $this->dataUser = $dataUser;

                // получить группы к каким относится пользователь
                $this->dataUser[\'groups\'] = AccessUserGroup::getListGroupsByUser($dataUser[\'id\']);

                $this->authorized = true;
                if (!empty($this->dataUser[\'groups\'][\'admins\'])) {
                    $this->admin = true;
                }
                $result = true;
            }
        }
        return $result;
    }

    /**
     * findUserByCookie - найти пользователя по значению куки
     * @global type $DB
     * @param string $cookie
     * @return array - данные пользователя
     */
    protected function findUserByCookie($cookie)
    {
        $result = false;

        global $DB;

        $res = $DB->selectDb(
            $this->tableName,
            array(\'*\'), 
            array( \'=\' => array(\'hash_auth\', "\'".$cookie."\'") )
        );

        if ($arRes = $DB->fetch($res)) {
            $result = $arRes;
        }

        return $result;
    }

    /**
     * userExit - сделать выход для пользователя 
     * @return boolean
     */
    public function userExit()
    {
        return $this->deleteUserCookie($this->dataUser[\'id\']);
    }

    /**
     * getAllDataUsers - получить данные по пользователю 
     * @global type $DB
     * @return array
     */
    public function getAllDataUsers()
    {
        $result = array();

        global $DB;
        $res = $DB->selectDb(
            $this->tableName,
            array(\'*\')
        );
        $result = $DB->fetchAll($res, false);

        // получить группы пользователей
        foreach ($result as $key => $value) {
            $result[$key][\'groups\'] = AccessUserGroup::getListGroupsByUser($value[\'id\']);
        }

        return $result;
    }

    /**
     * getUserById - получить данные по пользователю по id
     * @global type $DB
     * @param type $id
     * @return array
     */
    public function getUserById($id)
    {
        $result = array();
        global $DB;
        $res = $DB->selectDb(
            $this->tableName,
            array(\'*\'),
            array(
                \'=\' => array(\'id\', $id)
            )
        );
        $result = $DB->fetch($res, false);

        if (!empty($result)) {
            // получить группы текущего пользователя
            $result[\'groups\'] = AccessUserGroup::getListGroupsByUser($id);
        }

        return $result;
    }

    /**
     * addUsers - добавить пользователя
     * @global type $DB
     * @param type $data
     * @return boolean
     */
    public function addUsers($data)
    {
        $result = false;

        // id, login, name, pass, groups
        global $DB;
        $res = $DB->insertDb($this->tableName, $data);

        if ($res) {
            $result = true;
        }

        return $result;
    }

    /**
     * updateUserById - обновление данных пользователя
     * @global type $DB
     * @param int $userId - id пользователя
     * @param array $arParams - данные пользователя
     * @return boolean
     */
    public function updateUserById($userId, $arParams)
    {
        $result = false;

        unset($arParams[\'id\']);

        global $DB;
        $res = $DB->updateDb($this->tableName, $arParams, array(\'=\' => array(\'id\', $userId)));

        if ($res) {
            $result = true;
        }

        return $result;
    }

    /**
     * deleteUserById - удалить пользователя
     * @global type $DB
     * @param int $idUser - id пользователя
     * @return string
     */
    public function deleteUserById($idUser)
    {
        $result = false;

        if (is_numeric($idUser) && ($idUser != 1)) {
            global $DB;

            $res = $DB->deleteDb($this->tableName, array(\'=\'=>array(\'id\', $idUser)));

            if ($res) {
                $result = true;
            }
        }
        return $result;
    }

}
',
    'TYPE' => 'php',
    'DIR' => './gy/classes/Gy/Core/User/',
  ),
  './gy/classes/Psr/Log/AbstractLogger.php' => 
  array (
    'CODE' => '<?php

namespace Psr\\Log;

/**
 * AbstractLogger - реализация LoggerInterface
 */
abstract class AbstractLogger implements LoggerInterface
{
    /**
     * Система не работает
     *
     * @param string $message
     * @param array $context
     * @return void
     */
    public function emergency($message, array $context = array())
    {
        $this->log(LogLevel::EMERGENCY, $message, $context);
    }

    /**
     * Требуется немедленные действия
     *
     * @param string $message
     * @param array $context
     * @return void
     */
    public function alert($message, array $context = array())
    {
        $this->log(LogLevel::ALERT, $message, $context);
    }

    /**
     * Критическая ситуация.
     *
     * @param string $message
     * @param array $context
     * @return void
     */
    public function critical($message, array $context = array())
    {
        $this->log(LogLevel::CRITICAL, $message, $context);
    }

    /**
     * Ошибка на стадии выполнения, не требующая немедленных действий,
     * но требующая быть залогированной и дальнейшего изучения
     *
     * @param string $message
     * @param array $context
     * @return void
     */
    public function error($message, array $context = array())
    {
        $this->log(LogLevel::ERROR, $message, $context);
    }

    /**
     * Исключительные случаи, которые не являются ошибками

     * @param string $message
     * @param array $context
     * @return void
     */
    public function warning($message, array $context = array())
    {
        $this->log(LogLevel::WARNING, $message, $context);
    }

    /**
     * Нормальные события в работе приложения, но значимые и требуют логирования
     *
     * @param string $message
     * @param array $context
     * @return void
     */
    public function notice($message, array $context = array())
    {
        $this->log(LogLevel::NOTICE, $message, $context);
    }

    /**
     * Полезные значимые события
     *
     * @param string $message
     * @param array $context
     * @return void
     */
    public function info($message, array $context = array())
    {
        $this->log(LogLevel::INFO, $message, $context);
    }

    /**
     * Подробная отладочная информация
     *
     * @param string $message
     * @param array $context
     * @return void
     */
    public function debug($message, array $context = array())
    {
        $this->log(LogLevel::DEBUG, $message, $context);
    }
}
',
    'TYPE' => 'php',
    'DIR' => './gy/classes/Psr/Log/',
  ),
  './gy/classes/Psr/Log/LogLevel.php' => 
  array (
    'CODE' => '<?php

namespace Psr\\Log;

/**
 * LogLevel - уровни логирования
 */
class LogLevel
{
    const EMERGENCY = \'emergency\';
    const ALERT     = \'alert\';
    const CRITICAL  = \'critical\';
    const ERROR     = \'error\';
    const WARNING   = \'warning\';
    const NOTICE    = \'notice\';
    const INFO      = \'info\';
    const DEBUG     = \'debug\';
}',
    'TYPE' => 'php',
    'DIR' => './gy/classes/Psr/Log/',
  ),
  './gy/classes/Psr/Log/Logger/FileRoute.php' => 
  array (
    'CODE' => '<?php

namespace Psr\\Log\\Logger;

use Psr\\Log\\Logger\\Route;

/**
 * Class FileRoute - роут который будет писать логи в файл
 */
class FileRoute extends Route
{
    public $filePath; // путь к файлу

    // шаблон сообщения
    public $template = "{date} {level} {message} {context}";

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);

        if (!file_exists($this->filePath))
        {
            touch($this->filePath);
        }
    }

    public function log($level, $message, array $context = array())
    {
        file_put_contents(
            $this->filePath, 
            trim(
                strtr(
                    $this->template, 
                    array(
                        \'{date}\' => $this->getDate(),
                        \'{level}\' => $level,
                        \'{message}\' => $message,
                        \'{context}\' => $this->contextStringify($context),
                    )
                )
            ).PHP_EOL, 
            FILE_APPEND
        );
    }
}',
    'TYPE' => 'php',
    'DIR' => './gy/classes/Psr/Log/Logger/',
  ),
  './gy/classes/Psr/Log/Logger/Logger.php' => 
  array (
    'CODE' => '<?php
 
namespace Psr\\Log\\Logger;

use SplObjectStorage;
use Psr\\Log\\AbstractLogger;
use Psr\\Log\\LoggerInterface;

/**
 * Class Logger - базовый класс Logger
 */
class Logger extends AbstractLogger implements LoggerInterface
{

    public $routes; // список роутов (обьектов класса Route)

    public function __construct()
    {
        $this->routes = new SplObjectStorage();
    }

    public function log($level, $message, array $context = array())
    {
        foreach ($this->routes as $route) {
            if (($route instanceof Route) && $route->isEnable) {
                $route->log($level, $message, $context);
            }            
        }
    }
}',
    'TYPE' => 'php',
    'DIR' => './gy/classes/Psr/Log/Logger/',
  ),
  './gy/classes/Psr/Log/Logger/Route.php' => 
  array (
    'CODE' => '<?php

namespace Psr\\Log\\Logger;

use DateTime;
use Psr\\Log\\AbstractLogger;
use Psr\\Log\\LoggerInterface;

/**
 * Class Route - базовый класс роута
 */
abstract class Route extends AbstractLogger implements LoggerInterface
{
    public $isEnable = true; // включен ли роут
    public $dateFormat = DateTime::RFC2822; // Формат даты логов

    public function __construct(array $attributes = array())
    {
        foreach ($attributes as $attribute => $value) {
            if (property_exists($this, $attribute)) {
                $this->{$attribute} = $value;
            }
        }
    }

    /**
     * getDate()
     *   - текущая дата
     *
     * @return string
     */
    public function getDate()
    {
        return (new DateTime())->format($this->dateFormat);
    }

    /**
     * contextStringify()
     *   - преобразование $context в строку
     *
     * @param array $context
     * @return string
     */
    public function contextStringify(array $context = array())
    {
        return !empty($context) ? json_encode($context) : null;
    }
}',
    'TYPE' => 'php',
    'DIR' => './gy/classes/Psr/Log/Logger/',
  ),
  './gy/classes/Psr/Log/LoggerInterface.php' => 
  array (
    'CODE' => '<?php

namespace Psr\\Log;

/**
 * LoggerInterface - описывает экземпляр логгера
 */
interface LoggerInterface
{
    /**
     * Система не работает
     *
     * @param string $message
     * @param array $context
     * @return void
     */
    public function emergency($message, array $context = array());

    /**
     * Требуется немедленные действия
     *
     * @param string $message
     * @param array $context
     * @return void
     */
    public function alert($message, array $context = array());

    /**
     * Критическая ситуация.
     *
     * @param string $message
     * @param array $context
     * @return void
     */
    public function critical($message, array $context = array());

    /**
     * Ошибка на стадии выполнения, не требующая немедленных действий,
     * но требующая быть залогированной и дальнейшего изучения
     *
     * @param string $message
     * @param array $context
     * @return void
     */
    public function error($message, array $context = array());

    /**
     * Исключительные случаи, которые не являются ошибками

     * @param string $message
     * @param array $context
     * @return void
     */
    public function warning($message, array $context = array());

    /**
     * Нормальные события в работе приложения, но значимые и требуют логирования
     *
     * @param string $message
     * @param array $context
     * @return void
     */
    public function notice($message, array $context = array());

    /**
     * Полезные значимые события
     *
     * @param string $message
     * @param array $context
     * @return void
     */
    public function info($message, array $context = array());

    /**
     * Подробная отладочная информация
     *
     * @param string $message
     * @param array $context
     * @return void
     */
    public function debug($message, array $context = array());

    /**
     * Логи с произвольным уровнем
     *   В переменную $log передается нужный уровень логирования
     *
     * @param mixed $level
     * @param string $message
     * @param array $context
     * @return void
     */
    public function log($level, $message, array $context = array());
}
',
    'TYPE' => 'php',
    'DIR' => './gy/classes/Psr/Log/',
  ),
  './gy/classes/Psr/Psr4/Psr4AutoloaderClass.php' => 
  array (
    'CODE' => '<?php

namespace Psr\\Psr4;

/**
 * Psr4AutoloaderClass
 *  - книверсальная реализация Psr4
 */
class Psr4AutoloaderClass
{

    // массив соотнощения пространств имён/префиксов и реальных путей на диске
    protected $arPrefixes = array();

    /**
     * register()
     *  - регистрирует авто загрузчик
     */
    public function register()
    {
        spl_autoload_register(array($this, \'loadClass\'));
    }

    /**
     * addNamespace()
     *   -  добавляет префикс пространства имён и реальный ауть в $arPrefixes
     *
     * @param string $prefixName - префикс пространства имён
     * @param string $prefixDir - директория на сервере
     * @param bool $flagFirstAddPrefix - флаг покажит что префикс надо добавить вначало
     */
    public function addNamespace($prefixName, $prefixDir, $flagFirstAddPrefix = false)
    {
        $prefixName = trim($prefixName, \'\\\\\') . \'\\\\\';
        $prefixDir = rtrim($prefixDir, DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR;
        if (isset($this->arPrefixes[$prefixName]) === false) {
            $this->arPrefixes[$prefixName] = array();
        }
        if ($flagFirstAddPrefix) {
            array_unshift($this->arPrefixes[$prefixName], $prefixDir);
        } else {
            array_push($this->arPrefixes[$prefixName], $prefixDir);
        }
    }

    /**
     * loadClass()
     *   - загружает файл класса
     *
     * @param string $className - имя класса
     * @return string/false
     */
    public function loadClass($className)
    {
        $prefixName = $className;
        while (false !== $posStr = strrpos($prefixName, \'\\\\\')) {
            
            $prefixName = substr($className, 0, $posStr + 1);
            $relativeСlass = substr($className, $posStr + 1);
            $mappedFile = $this->loadMappedFile($prefixName, $relativeСlass);
            if ($mappedFile) {
                return $mappedFile;
            }
            $prefixName = rtrim($prefixName, \'\\\\\');   
        }
        return false;
    }
    
    /**
     * loadMappedFile 
     *   - загружает файл в зависимости от префикса и имени класса
     * 
     * @param string $prefixName - имё префикса
     * @param string $relativeClass - относительное имя класса
     * @return string/false
     */
    protected function loadMappedFile($prefixName, $relativeClass)
    {
        if (isset($this->arPrefixes[$prefixName]) === false) {
            return false;
        }  
        foreach ($this->arPrefixes[$prefixName] as $prefixDir) {
            $urlFileClass = $prefixDir.str_replace(\'\\\\\', DIRECTORY_SEPARATOR, $relativeClass).\'.php\';
            if ($this->requireFile($urlFileClass)) {
                return $urlFileClass;
            }
        }
        return false;
    }
    
    /**
     * requireFile()
     *   - загружеаем файл класса если он есть
     * 
     * @param string $urlFileClass - путь к файлу класса
     * @return bool
     */
    protected function requireFile($urlFileClass)
    {
        if (file_exists($urlFileClass)) {
            require_once $urlFileClass;
            return true;
        }
        return false;
    }
}',
    'TYPE' => 'php',
    'DIR' => './gy/classes/Psr/Psr4/',
  ),
  './gy/component/add_user/componentInfo.php' => 
  array (
    'CODE' => '<?php
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

use Gy\\Core\\Lang;

global $APP;
$utlThisComponent = "/gy/component/add_user/";
$langComponentInfo = new Lang($APP->urlProject.$utlThisComponent, \'componentInfo\', $APP->options[\'lang\']);

$componentInfo = array(
    \'name\' => \'add_user\',
    \'text-info\' => $langComponentInfo->getMessage(\'text-info\'),
    \'v\' => \'0.1\',
    \'all-property\' => array(
        \'back-url\',
    ),
    \'all-property-text\' => array(
        \'back-url\' => $langComponentInfo->getMessage(\'property-back-url\'),
    )
);',
    'TYPE' => 'php',
    'DIR' => './gy/component/add_user/',
  ),
  './gy/component/add_user/controller.php' => 
  array (
    'CODE' => '<?php 
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

$data  = $_REQUEST;

$arRes[\'user_property\'] = array(
    \'login\',
    \'name\',
    \'pass\',
    \'groups\'
);

$redirectUrl = str_replace(\'index.php\', \'\', $_SERVER[\'SCRIPT_NAME\']);

// взять все группы пользователей
$arRes[\'allUsersGroups\'] = Gy\\Core\\User\\AccessUserGroup::getAccessGroup();

function checkProperty($arr, $arRes){
    $result = true;
    foreach ($arRes[\'user_property\'] as $val) {
        if (empty($arr[$val])) {
            $result = false;
        }
    }

    if ($result) {
        foreach ($arr[\'groups\'] as $value) {  // TODO протестировать

            if (empty($arRes[\'allUsersGroups\'][$value])) {
                $result = false;
            }

            if (!empty($arr[\'groups\'][\'admins\']) && !$USER->isAdmin()) { // TODO протестировать
                $result = false;
            }
        }
    }

    return $result;
}

if (!empty($data[\'Добавить\']) && ($data[\'Добавить\'] == \'Добавить\')) {
    if (checkProperty($data, $arRes)) {
        // добавление пользователя
        global $USER;
        $arDaraUser = array();
        foreach ($arRes[\'user_property\'] as $val) {
            $arDaraUser[$val] = $data[$val];
        }

        // убрать группы из добавления
        unset($arDaraUser[\'groups\']);

        if ($USER->addUsers($arDaraUser)) {
            // найти id добавленного пользователя
            global $DB;
            global $CRYPTO;
            $res = $DB->selectDb(
                $USER->tableName,
                array(\'*\'),
                array(
                    \'AND\' => array(
                        array(\'=\' => array(\'login\', "\'".$arDaraUser[\'login\']."\'")),
                        array(\'=\' => array(\'pass\', "\'".md5($arDaraUser[\'pass\'].$CRYPTO->getSole())."\'") )
                    )
                )
            );
            $dataAddNewUser = $DB->fetch($res);

            // добавить пользователя к указанным группам
            Gy\\Core\\User\\AccessUserGroup::deleteUserInAllGroups($dataAddNewUser[\'id\']);
            foreach ($data[\'groups\'] as $value) {
                Gy\\Core\\User\\AccessUserGroup::addUserInGroup($dataAddNewUser[\'id\'], $value);
            }

            $arRes["stat"] = \'ok\';
        } else {
            $arRes["stat"] = \'err\';
        }

    } else {
        $arRes["stat-text"] = \'! Не все поля заполнены\';
        $arRes["stat"] = \'err\';
    }

} elseif ((!empty($arRes["stat"]) && ($arRes["stat"] != \'err\')) || empty($arRes["stat"])) {
    $arRes["stat"] = \'add\';
}

if (empty($data[\'stat\'])) {
    header( \'Location: \'.$redirectUrl.\'?stat=\'.$arRes["stat"] );
} else {
    $arRes["stat"] = $data[\'stat\'];
}

// показать шаблон
$this->template->show($arRes, $this->arParam);
',
    'TYPE' => 'php',
    'DIR' => './gy/component/add_user/',
  ),
  './gy/component/add_user/lang_componentInfo.php' => 
  array (
    'CODE' => '<?php // языковой файл для componentInfo.php
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

$mess[\'rus\'] = array(
    \'text-info\' => \'Компонент нужен для добавление пользователя\',
    \'property-back-url\' => \'Ссылка на страницу откуда идёт добавление пользователя\',
);

$mess[\'eng\'] = array(
    \'text-info\' => \'The component is needed to add a user\',
    \'property-back-url\' => \'Link to the page from where the user is being added\',
);',
    'TYPE' => 'php',
    'DIR' => './gy/component/add_user/',
  ),
  './gy/component/add_user/teplates/0/lang_template.php' => 
  array (
    'CODE' => '<?php // языковой файл для шаблона компонента
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

$mess[\'rus\'] = array(
    \'button\' => \'Добавить\',
    \'id\' => \'id\', 
    \'login\' => \'Логин\', 
    \'name\' => \'Имя\', 
    \'pass\' => \'Пароль\', 
    \'groups\' => \'Группа прав\',
    \'title-add\' => \'Добавление нового пользователя\',
    \'back\' => \'<< Назад\',
    \'ok\' => \'ok\',
    \'add-ok\' => \'Пользователь добавлен\',
    \'add-err\' => \'error, попробуйте заново\'
);

$mess[\'eng\'] = array(
    \'button\' => \'Add\',
    \'id\' => \'id\', 
    \'login\' => \'Login\', 
    \'name\' => \'Name\', 
    \'pass\' => \'Password\', 
    \'groups\' => \'Group of rights\',
    \'title-add\' => \'Adding a new user\',
    \'back\' => \'<< Back\',
    \'ok\' => \'ok\',
    \'add-ok\' => \'User added\',
    \'add-err\' => \'error, try again\'
);
',
    'TYPE' => 'php',
    'DIR' => './gy/component/add_user/teplates/0/',
  ),
  './gy/component/add_user/teplates/0/template.php' => 
  array (
    'CODE' => '<?php
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

?>
<h3><?=$this->lang->getMessage(\'title-add\');?></h3>
<?php

if (!empty($arParam[\'back-url\'])) {?>
    <br/>
    <br/>
    <a class="gy-admin-button" href="<?=$arParam[\'back-url\'];?>"><?=$this->lang->getMessage(\'back\');?></a>
    <br/>
    <br/>
<?php }?>
<?php if ($arRes["stat"] == \'add\') {?>
    <form>
        <?php foreach ($arRes["user_property"] as $key => $val) {?>
            <?=$this->lang->getMessage($val);?>:<br/>
            <?php if ($val != \'groups\') {?>
                <input type="<?=(($val == \'pass\')? \'password\': \'text\');?>" name="<?=$val;?>" />
            <?php } else {?>
                <select multiple name="groups[]">
                    <?php foreach ($arRes[\'allUsersGroups\'] as $value) { ?>
                        <option value="<?=$value[\'code\'];?>">
                            <?=$value[\'name\']?> (<?=$value[\'code\'];?>)
                        </option>
                    <?php }?>
                </select>
            <?php }?>
        <br/>
        <?php }?>
    <input class="gy-admin-button" type="submit" name="<?=$this->lang->getMessage(\'button\');?>" value="<?=$this->lang->getMessage(\'button\');?>" />

    </form>

<?php } elseif ($arRes["stat"] == \'ok\') {?>
    <div class="gy-admin-good-message"><?=$this->lang->getMessage(\'add-ok\');?></div>
    <br/>
    <a href="<?=$arParam[\'back-url\'];?>" class="gy-admin-button"><?=$this->lang->getMessage(\'ok\');?></a>
<?php } elseif ($arRes["stat"] == \'err\') { ?>
    <div class="gy-admin-error-message"><?=$this->lang->getMessage(\'add-err\');?></div>
    <?php if (!empty($arRes["stat-text"])) {?>
        <br/> <?=$arRes["stat-text"];?>
    <?php }?>
    <br/>
    <a href="<?=$arParam[\'back-url\'];?>" class="gy-admin-button"><?=$this->lang->getMessage(\'ok\');?></a>
<?php } 
',
    'TYPE' => 'php',
    'DIR' => './gy/component/add_user/teplates/0/',
  ),
  './gy/component/admin/componentInfo.php' => 
  array (
    'CODE' => '<?php
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

use Gy\\Core\\Lang;

global $APP;
$utlThisComponent = "/gy/component/admin/";
$langComponentInfo = new Lang($APP->urlProject.$utlThisComponent, \'componentInfo\', $APP->options[\'lang\']);

$componentInfo = array(
    \'name\' => \'admin\',
    \'text-info\' => $langComponentInfo->getMessage(\'text-info\'),
    \'v\' => \'0.1\',
    \'all-property\' => array()
);',
    'TYPE' => 'php',
    'DIR' => './gy/component/admin/',
  ),
  './gy/component/admin/controller.php' => 
  array (
    'CODE' => '<?php
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

$arRes = array();

// контроллер компонента admin 

// показать шаблон
$this->template->show($arRes, $this->arParam);
',
    'TYPE' => 'php',
    'DIR' => './gy/component/admin/',
  ),
  './gy/component/admin/lang_componentInfo.php' => 
  array (
    'CODE' => '<?php // языковой файл для componentInfo.php
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

$mess[\'rus\'] = array(
    \'text-info\' => \'Запустит внутри себя компонент form_auth\',
);
$mess[\'eng\'] = array(
    \'text-info\' => \'Will launch the form_auth component inside itself\',
);',
    'TYPE' => 'php',
    'DIR' => './gy/component/admin/',
  ),
  './gy/component/admin/lang_controller.php' => 
  array (
    'CODE' => '<?php // языковой файл для компонента
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

$mess[\'rus\'] = array(
    //\'test\' => \'ok\',
);
',
    'TYPE' => 'php',
    'DIR' => './gy/component/admin/',
  ),
  './gy/component/admin/teplates/0/lang_template.php' => 
  array (
    'CODE' => '<?php // языковой файл для шаблона компонента
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

$mess[\'rus\'] = array(
    \'hi\' => \'Админка gy framework\',
);
$mess[\'eng\'] = array(
    \'hi\' => \'Admin panel - gy framework\',
);

',
    'TYPE' => 'php',
    'DIR' => './gy/component/admin/teplates/0/',
  ),
  './gy/component/admin/teplates/0/template.php' => 
  array (
    'CODE' => '<?php /*<H2><?=$this->lang->getMessage(\'hi\');?></h2>*/?>
<?php
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

global $APP;

$APP->component(
    \'form_auth\',
    \'0\',
    array( 
        \'test\' => \'asd\',
        \'idComponent\' => 1,
    )
);


',
    'TYPE' => 'php',
    'DIR' => './gy/component/admin/teplates/0/',
  ),
  './gy/component/admin-button-public-site/componentInfo.php' => 
  array (
    'CODE' => '<?php
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

use Gy\\Core\\Lang;

global $APP;
$utlThisComponent = "/gy/component/admin-button-public-site/";
$langComponentInfo = new Lang($APP->urlProject.$utlThisComponent, \'componentInfo\', $APP->options[\'lang\']);

$componentInfo = array(
    \'name\' => \'admin-button-public-site\',
    \'text-info\' => $langComponentInfo->getMessage(\'text-info\'),
    \'v\' => \'0.1\',
    \'all-property\' => array()
);',
    'TYPE' => 'php',
    'DIR' => './gy/component/admin-button-public-site/',
  ),
  './gy/component/admin-button-public-site/controller.php' => 
  array (
    'CODE' => '<?php 
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

global $USER;

// если есть права просматривать админку
if (Gy\\Core\\User\\AccessUserGroup::accessThisUserByAction( \'show_admin_panel\')) {
    // получить логин пользователя
    $thisLogin = $USER->getDataThisUser()[\'name\'];
    $arRes["auth_user"] = $thisLogin;

    $this->template->show($arRes, $this->arParam);
}',
    'TYPE' => 'php',
    'DIR' => './gy/component/admin-button-public-site/',
  ),
  './gy/component/admin-button-public-site/lang_componentInfo.php' => 
  array (
    'CODE' => '<?php // языковой файл для componentInfo.php
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

$mess[\'rus\'] = array(
    \'text-info\' => \'Отобразит панель администратора в публичной части\',
);
$mess[\'eng\'] = array(
    \'text-info\' => \'Will display the admin panel in the public area\',
);',
    'TYPE' => 'php',
    'DIR' => './gy/component/admin-button-public-site/',
  ),
  './gy/component/admin-button-public-site/teplates/0/lang_template.php' => 
  array (
    'CODE' => '<?php // языковой файл для шаблона компонента
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

$mess[\'rus\'] = array(
    \'button-admin\' => \'Gy - раздел администрирования сайта\',
    \'hi\' => \'Привет, \',
    \'exit\' => \'Выйти\',
    \'button-work-page\' => \'Работа со страницами сайта\'
);

$mess[\'eng\'] = array(
    \'button-admin\' => \'Gy - site administration section\',
    \'hi\' => \'Hello, \',
    \'exit\' => \'Log off\',
    \'button-work-page\' => \'Working with site pages\'
);

',
    'TYPE' => 'php',
    'DIR' => './gy/component/admin-button-public-site/teplates/0/',
  ),
  './gy/component/admin-button-public-site/teplates/0/style.css' => 
  array (
    'CODE' => '.gy-admin-panel{
    width: 800px;
    height: 140px;
    /*background-color: #adade4;*/
    margin-left: -10;
    margin-top: -10;
    padding-left: 8px;
    border-radius: 7px;
    background: url(/gy/images/fon.png) #9292ef;
    box-shadow: 0.4em 0.4em 5px rgba(122,122,122,0.5);
}

.gy-admin-panel > H2{
    padding-top: 8px;
    margin-bottom: 12px;
    margin-top: 0px;
}
.gy-admin-panel > .edit-button{
    padding-top: 10px;
    margin-top: 30px;
}



.gy-admin-edit-button{
    box-shadow: 0.4em 0.4em 5px rgba(122,122,122,0.5);
    margin: 0px;
    border: 0;
    height: auto;
    padding: 2px 30px 4px;
    background-color: #265ed0 ;
    border-radius: 2px;
    color: #fff;
    font-size: 14px;
    font-weight: 700;
    cursor: pointer;
} 
.gy-admin-edit-button:hover { 
    background: #5b81ce; 
}
.gy-admin-edit-button:active { 
    background: #5b81ce; 
}

.gy-admin-panel-button{
    box-shadow: 0.4em 0.4em 5px rgba(122,122,122,0.5);
    margin: 0px;
    border: 0;
    height: auto;
    padding: 2px 30px 4px;
    background-color: #639;
    border-radius: 2px;
    color: #fff;
    font-size: 14px;
    font-weight: 700;
    cursor: pointer;
} 
.gy-admin-panel-button:hover { 
    background: #8b5db9; 
}
.gy-admin-panel-button:active { 
    background: #412260; 
}

.gy-admin-panel > .gy-admin-logo{
    text-shadow: 1px 1px 2px #05ff07, 0 0 1em #0205ff;

}
.div-button-admin-panel{
    float: left;
    width: 65%;
}
.div-login{
    float: left;
    width: 35%;
}

.version-gy-core-admin-panel{
    padding-left: 0px;
    position: absolute;
    top: 35px;
    font-size: 9pt;
    font-style: italic;
    background-color: aquamarine;
    left: 250px;
}',
    'TYPE' => 'css',
    'DIR' => './gy/component/admin-button-public-site/teplates/0/',
  ),
  './gy/component/admin-button-public-site/teplates/0/template.php' => 
  array (
    'CODE' => '<?php if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );?>

<div class="gy-admin-panel">
    <h2 class="gy-admin-logo">Админка gy framework</h2>
    <?php
    global $APP;
    if (!empty($APP->options[\'v-gy\'])) {?>
        <span class="version-gy-core-admin-panel">v <?=$APP->options[\'v-gy\']?></span>
        <br/>
    <?php }?>
    <div>
        <div class="div-button-admin-panel">
            <a href="/gy/admin/" class="gy-admin-panel-button"><?=$this->lang->getMessage(\'button-admin\');?></a>
           
        </div>
        <div class="div-login">
            <?=$this->lang->getMessage(\'hi\');?><?=$arRes["auth_user"]?>
            &nbsp;
            <a 
                href="/gy/admin?<?=$this->lang->getMessage(\'exit\');?>=<?=$this->lang->getMessage(\'exit\');?>" 
                class="gy-admin-panel-button"
            >
                <?=$this->lang->getMessage(\'exit\');?>
            </a>
        </div>
        
    </div>
    <div class="edit-button"> <?php // TODO надо что бы была возможность добавлять кнопки из модулей?>
        <a href="/gy/admin/get-admin-page.php?page=work-page-site" class="gy-admin-edit-button"><?=$this->lang->getMessage(\'button-work-page\');?></a>
    </div>
</div>',
    'TYPE' => 'php',
    'DIR' => './gy/component/admin-button-public-site/teplates/0/',
  ),
  './gy/component/capcha/componentInfo.php' => 
  array (
    'CODE' => '<?php
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

use Gy\\Core\\Lang;

global $APP;
$utlThisComponent = "/gy/component/capcha/";
$langComponentInfo = new Lang($APP->urlProject.$utlThisComponent, \'componentInfo\', $APP->options[\'lang\']);

$componentInfo = array(
    \'name\' => \'capcha\',
    \'text-info\' => $langComponentInfo->getMessage(\'text-info\'),
    \'v\' => \'0.1\',
    \'all-property\' => array()
);',
    'TYPE' => 'php',
    'DIR' => './gy/component/capcha/',
  ),
  './gy/component/capcha/controller.php' => 
  array (
    'CODE' => '<?php 
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

use Gy\\Core\\Capcha;

global $APP;

$arRes = array();

$data = $_REQUEST;

if (!empty($data[\'capcha_get_image\']) && ($data[\'capcha_get_image\'] == 1)) {

    $capcha = new Capcha( $APP->url.Capcha::$defaultUrlFonts );   
    
    // нарисовать капчу
    $capcha->getImageCapcha();
     
} else {
    // показать шаблон
    $this->template->show($arRes, $this->arParam);
}

',
    'TYPE' => 'php',
    'DIR' => './gy/component/capcha/',
  ),
  './gy/component/capcha/lang_componentInfo.php' => 
  array (
    'CODE' => '<?php // языковой файл для componentInfo.php
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

$mess[\'rus\'] = array(
    \'text-info\' => \'Капча, выведет картинку с буквами/цифрами, полем ввода и кнопкой отправить\',
);
$mess[\'eng\'] = array(
    \'text-info\' => \'Captcha, will display a picture with letters / numbers, an input field and send\',
);',
    'TYPE' => 'php',
    'DIR' => './gy/component/capcha/',
  ),
  './gy/component/capcha/teplates/0/lang_template.php' => 
  array (
    'CODE' => '<?php // языковой файл для шаблона компонента
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

$mess[\'rus\'] = array(
);

',
    'TYPE' => 'php',
    'DIR' => './gy/component/capcha/teplates/0/',
  ),
  './gy/component/capcha/teplates/0/template.php' => 
  array (
    'CODE' => '<?php if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );?>

<div>
    <img src="?capcha_get_image=1" />
    <input name="capcha" type="text" value="" />
</div>',
    'TYPE' => 'php',
    'DIR' => './gy/component/capcha/teplates/0/',
  ),
  './gy/component/edit-all-users-propertys/componentInfo.php' => 
  array (
    'CODE' => '<?php
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

use Gy\\Core\\Lang;

global $APP;
$utlThisComponent = "/gy/component/edit-all-users-propertys/";
$langComponentInfo = new Lang($APP->urlProject.$utlThisComponent, \'componentInfo\', $APP->options[\'lang\']);

$componentInfo = array(
    \'name\' => \'edit-all-users-propertys\',
    \'text-info\' => $langComponentInfo->getMessage(\'text-info\'),
    \'v\' => \'0.1\',
    \'all-property\' => array()
);',
    'TYPE' => 'php',
    'DIR' => './gy/component/edit-all-users-propertys/',
  ),
  './gy/component/edit-all-users-propertys/controller.php' => 
  array (
    'CODE' => '<?php 
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

use Gy\\Core\\User\\GeneralUsersPropertys;

$data = $_REQUEST;

// получить все возможные типы свойств
$arRes[\'allTypePropertys\'] = GeneralUsersPropertys::getAllTypeAllUsersPropertys();

// сохранить новое свойство
if (
    !empty($data[\'name_property\'])
    && !empty($data[\'type_property\'])
    && !empty($arRes[\'allTypePropertys\'] )
    && !empty($arRes[\'allTypePropertys\'][$data[\'type_property\']])
    && !empty($data[\'code\'])
) {
    $flag = GeneralUsersPropertys::addUsersPropertys(
        $data[\'name_property\'],
        $data[\'type_property\'],
        $data[\'code\']
    );

    if ($flag) {
        $arRes[\'stat\'] = \'ok\';
    } else {
        $arRes[\'stat\'] = \'err\';
    }
}


// получить все общие свойства пользователей которые были созданы
$arRes[\'allUsersCreatePropertys\'] = GeneralUsersPropertys::getAllGeneralUsersPropertys();

// если удаление свойства
if (
    is_numeric($data[\'del-id\'])
    && !empty($data[\'del-id\'])
    && !empty($arRes[\'allUsersCreatePropertys\'][$data[\'del-id\']])
) {
    $flag = GeneralUsersPropertys::deleteUserProperty($data[\'del-id\']);
    if ($flag) {
        $arRes[\'stat\'] = \'ok\';
    } else {
        $arRes[\'stat\'] = \'err\';
    }
}

// показать шаблон
$this->template->show($arRes, $this->arParam);
',
    'TYPE' => 'php',
    'DIR' => './gy/component/edit-all-users-propertys/',
  ),
  './gy/component/edit-all-users-propertys/lang_componentInfo.php' => 
  array (
    'CODE' => '<?php // языковой файл для componentInfo.php
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

$mess[\'rus\'] = array(
    \'text-info\' => \'Редактирование общих свойств пользователей\',
);

$mess[\'eng\'] = array(
    \'text-info\' => \'Editing General User Properties\',
);',
    'TYPE' => 'php',
    'DIR' => './gy/component/edit-all-users-propertys/',
  ),
  './gy/component/edit-all-users-propertys/teplates/0/lang_template.php' => 
  array (
    'CODE' => '<?php // языковой файл для шаблона компонента
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

$mess[\'rus\'] = array(
    \'ok\' => \'Ok\',
    \'title\' => \'Общие свойства пользователей\',
    \'name\' => \'Имя свойства\',
    \'type\' => \'Тип свойства\',
    \'code\' => \'Код свойства\',
    \'del-property\' => \'Удалить\',
    \'edit-property\' => \'Изменить\',
    \'stat-ok\' => \'Действие выполнено\',
    \'stat-err\' => \'Произошла ошибка\',
    \'not-propertys\' => \'Ещё нет общих пользовательских свойств\',
    \'add-property\' => \'Добавить\',
    \'title-add-property\' => \'Добавление нового общего свойства для пользователей\'
);

$mess[\'eng\'] = array(
    \'ok\' => \'Ok\',
    \'title\' => \'General user properties\',
    \'name\' => \'Property name\',
    \'type\' => \'Property type\',
    \'code\' => \'Property code\',
    \'del-property\' => \'Delete\',
    \'edit-property\' => \'Edit\',
    \'stat-ok\' => \'Action completed\',
    \'stat-err\' => \'An error has occurred\',
    \'not-propertys\' => \'No shared custom properties yet\',
    \'add-property\' => \'Add\',
    \'title-add-property\' => \'Adding a new shared property for users\'
);

',
    'TYPE' => 'php',
    'DIR' => './gy/component/edit-all-users-propertys/teplates/0/',
  ),
  './gy/component/edit-all-users-propertys/teplates/0/template.php' => 
  array (
    'CODE' => '<?php if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );?>

<h1><?=$this->lang->getMessage(\'title\');?></h1>

<?php if (!empty($arRes[\'stat\'])) {?>
    <?php if ($arRes[\'stat\'] == \'ok\') { ?>
        <div class="gy-admin-good-message"><?=$this->lang->getMessage(\'stat-ok\');?></div>
        <br/>
    <?php }?>

    <?php if ($arRes[\'stat\'] == \'err\') {?>
        <div class="gy-admin-error-message"><?=$this->lang->getMessage(\'stat-err\');?></div>
        <br/>
    <?php }?>
    <a href="edit-all-users-propertys.php" class="gy-admin-button"><?=$this->lang->getMessage(\'ok\');?></a>
<?php } else {?>

    <?php if ($arRes[\'allUsersCreatePropertys\']) {?>
        <table border="1" class="gy-table-all-users">
            <tr>
                <th>id</th>
                <th><?=$this->lang->getMessage(\'name\');?></th>
                <th><?=$this->lang->getMessage(\'type\');?></th>
                <th><?=$this->lang->getMessage(\'code\');?></th>
                <th></th>
            </tr>

                <?php foreach ($arRes[\'allUsersCreatePropertys\'] as $key => $val) {?>
                    <tr>
                        <td><?=$val[\'id\'];?></td>
                        <td><?=$val[\'name_property\'];?></td>
                        <td><?=$val[\'type_property\'];?></td>
                        <td><?=$val[\'code\'];?></td>

                        <td>  
                            <br/>
                            <a href="?del-id=<?=$val[\'id\'];?>" class="gy-admin-button"><?=$this->lang->getMessage(\'del-property\');?></a>
                            <br/>
                            <br/>
                        </td>
                    </tr>
                <?php }?>

        </table>
    <?php } else {?>
        <?=$this->lang->getMessage(\'not-propertys\');?>
    <?php }?>
    
    <br/>
    <br/>
    
    <?php if (!empty($arRes[\'allTypePropertys\'])) {?>
    
        <h3><?=$this->lang->getMessage(\'title-add-property\');?></h3>
    
        <form method="post" >
            
            <table border="1" class="gy-table-all-users">

                <tr>
                    <td><?=$this->lang->getMessage(\'name\');?></td>
                    <td><input type="text" name="name_property" ></td> 
                </tr>
                
                <tr>
                    <td><?=$this->lang->getMessage(\'type\');?></td>
                    <td>
                        <select name="type_property">
                            <?php foreach ($arRes[\'allTypePropertys\'] as $value) { ?>
                                <option value="<?=$value[\'id\']?>"><?=$value[\'name_type\']?> - <?=$value[\'info\']?></option> 
                            <?php }?>  
                        </select>
                    </td>
                </tr>
            
                <tr>
                    <td><?=$this->lang->getMessage(\'code\');?></td>
                    <td><input type="text"  name="code" ></td>
                </tr>
            </table>
            <input type="submit" class="gy-admin-button" value="<?=$this->lang->getMessage(\'add-property\');?>" />
        </form>
    <?php }?>
<?php }?>
        ',
    'TYPE' => 'php',
    'DIR' => './gy/component/edit-all-users-propertys/teplates/0/',
  ),
  './gy/component/edit-users-propertys/componentInfo.php' => 
  array (
    'CODE' => '<?php
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

use Gy\\Core\\Lang;

global $APP;
$utlThisComponent = "/gy/component/edit-users-propertys/";
$langComponentInfo = new Lang($APP->urlProject.$utlThisComponent, \'componentInfo\', $APP->options[\'lang\']);

$componentInfo = array(
    \'name\' => \'edit-users-propertys\',
    \'text-info\' => $langComponentInfo->getMessage(\'text-info\'),
    \'v\' => \'0.1\',
    \'all-property\' => array(
        \'id-user\'
    ),
    \'all-property-text\' => array(
        \'id-user\' => $langComponentInfo->getMessage(\'property-id-user\')
    )
);',
    'TYPE' => 'php',
    'DIR' => './gy/component/edit-users-propertys/',
  ),
  './gy/component/edit-users-propertys/controller.php' => 
  array (
    'CODE' => '<?php 
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

use Gy\\Core\\User\\GeneralUsersPropertys;

$data = $_REQUEST;

// получить все возможные типы свойств
$arRes[\'allTypePropertys\'] = generalUsersPropertys::getAllTypeAllUsersPropertys();

// получить все общие свойства пользователей которые были созданы
$arRes[\'allUsersCreatePropertys\'] = generalUsersPropertys::getAllGeneralUsersPropertys();

// получить значения свойств конкретного пользователя
$arRes[\'valuePropertysThisUser\'] = generalUsersPropertys::getAllValueUserProperty( $this->arParam[\'id-user\'], \'text\'); // text - т.к. пока только такие типы свойств реализованы

// собираю общий массив
$arRes[\'propertys\'] = array();
foreach ($arRes[\'allUsersCreatePropertys\'] as $key => $value) {

    $val = \'\';
    if (!empty($arRes[\'valuePropertysThisUser\'][$value[\'id\']])) {
        $val = $arRes[\'valuePropertysThisUser\'][$value[\'id\']][\'value\'];
    }

//    $id = \'-\';
//    if(!empty($arRes[\'valuePropertysThisUser\'][$value[\'id\']])){
//        $id = $arRes[\'valuePropertysThisUser\'][$value[\'id\']][\'id\'];
//    }

    $arRes[\'propertys\'][] = array(
        \'name_property\' => $value[\'name_property\'],
        //\'id\' => $id,
        \'id_property\' => $value[\'id\'],
        \'value\' => $val
    );
}

// проверка пришедшие значения свойств, есть ли такие свойства
function isTrueDataInProperty($propertys, $allUsersCreatePropertys){
    $result = true;
    foreach ($propertys as $idProperty => $value) {
        if (!isset($allUsersCreatePropertys[$idProperty])) {
            $result = false;
        }
    }
    return $result;
}

// сохраняем пришедшее
if (
    !empty($data[\'edit-id\']) 
    && is_numeric($data[\'edit-id\'])
    && !empty($data[\'id-user\'])
    && is_numeric($data[\'id-user\'])
    && ($data[\'edit-id\'] == $data[\'id-user\'])
    && !empty($data[\'property\'])
    && is_array($data[\'property\'])
    && isTrueDataInProperty($data[\'property\'], $arRes[\'allUsersCreatePropertys\'])
) {
    foreach ($data[\'property\'] as $idProperty => $value) {
        if ($arRes[\'valuePropertysThisUser\'][$idProperty]) { // было ли уже задано когда то такое значение, для такого своства
            // если да то обновляем то что есть уже
            generalUsersPropertys::updateValueProperty($data[\'id-user\'], \'text\', $idProperty, $value);
        } else {
            // если нет создаём новое значение
            generalUsersPropertys::addValueProperty($data[\'id-user\'], \'text\', $idProperty, $value);
        }
    }
    $arRes[\'stat\'] = \'ok\';
    // TODO может обработать возможные ошибки
}


// показать шаблон
$this->template->show($arRes, $this->arParam);
',
    'TYPE' => 'php',
    'DIR' => './gy/component/edit-users-propertys/',
  ),
  './gy/component/edit-users-propertys/lang_componentInfo.php' => 
  array (
    'CODE' => '<?php // языковой файл для componentInfo.php
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

$mess[\'rus\'] = array(
    \'text-info\' => \'Компонент для редактирования пользовательских свойств (общих свойств)\',
    \'property-id-user\' => \'Id Пользователя которого надо редактировать\'
);
$mess[\'eng\'] = array(
    \'text-info\' => \'Component for editing custom properties (general properties)\',
    \'property-id-user\' => \'Id of the User to be edited\'
);',
    'TYPE' => 'php',
    'DIR' => './gy/component/edit-users-propertys/',
  ),
  './gy/component/edit-users-propertys/teplates/0/lang_template.php' => 
  array (
    'CODE' => '<?php // языковой файл для шаблона компонента
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

$mess[\'rus\'] = array(
    \'ok\' => \'Ok\',
    \'title\' => \'Редактирование свойств пользователя с id=\',
    \'save\' => \'Сохранить\',
    \'stat-ok\' => \'Данные сохранены\',
    \'stat-err\' => \'Произошла ошибка\',
    \'name-property\' => \'Имя свойства\',
    \'value-property\' => \'Значение свойства\'
);

$mess[\'eng\'] = array(
    \'ok\' => \'Ok\',
    \'title\' => \'Editing user properties id=\',
    \'save\' => \'Save\',
    \'stat-ok\' => \'Data saved\',
    \'stat-err\' => \'An error has occurred\',
    \'name-property\' => \'Property name\',
    \'value-property\' => \'Property value\'
);

',
    'TYPE' => 'php',
    'DIR' => './gy/component/edit-users-propertys/teplates/0/',
  ),
  './gy/component/edit-users-propertys/teplates/0/template.php' => 
  array (
    'CODE' => '<?php if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );?>

<h1><?=$this->lang->getMessage(\'title\');?><?=$arParam[\'id-user\']?></h1>

<?php if (!empty($arRes[\'stat\'])) {?>
    <?php if ($arRes[\'stat\'] == \'ok\') { ?>
        <div class="gy-admin-good-message"><?=$this->lang->getMessage(\'stat-ok\');?></div>
        <br/>
    <?php }?>

    <?php if ($arRes[\'stat\'] == \'err\') {?>
        <div class="gy-admin-error-message"><?=$this->lang->getMessage(\'stat-err\');?></div>
        <br/>
    <?php }?>
    <a href="/gy/admin/edit-users-propertys.php?edit-id=<?=$arParam[\'id-user\']?>" class="gy-admin-button"><?=$this->lang->getMessage(\'ok\');?></a>
<?php } else {?>

    <form method="post" >

        <input type="hidden" name="id-user" value="<?=$arParam[\'id-user\']?>" />
        
        <table border="1" class="gy-table-all-users">

            <tr>
                <th><?=$this->lang->getMessage(\'name-property\');?></th>
                <th><?=$this->lang->getMessage(\'value-property\');?></th>
            </tr>
            
            <?php foreach ($arRes[\'propertys\'] as $value) { ?>
                <tr>
                    <td><?=$value[\'name_property\']?></td>
                    <td>
                        <input type="text" name="property[<?=$value[\'id_property\']?>]" value="<?=$value[\'value\']?>" >
                    </td> 
                </tr>    
            <?php }?>

        </table>
        <input type="submit" class="gy-admin-button" value="<?=$this->lang->getMessage(\'save\');?>" />
    </form>
    
<?php }?>
        ',
    'TYPE' => 'php',
    'DIR' => './gy/component/edit-users-propertys/teplates/0/',
  ),
  './gy/component/edit_user/componentInfo.php' => 
  array (
    'CODE' => '<?php
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

use Gy\\Core\\Lang;

global $APP;
$utlThisComponent = "/gy/component/edit_user/";
$langComponentInfo = new Lang($APP->urlProject.$utlThisComponent, \'componentInfo\', $APP->options[\'lang\']);

$componentInfo = array(
    \'name\' => \'edit_user\',
    \'text-info\' => $langComponentInfo->getMessage(\'text-info\'),
    \'v\' => \'0.1\',
    \'all-property\' => array(
        \'back-url\',
        \'id-user\'
    ),
    \'all-property-text\' => array(
        \'back-url\' => $langComponentInfo->getMessage(\'property-back-url\'),
        \'id-user\' => $langComponentInfo->getMessage(\'property-id-user\')
    )
);',
    'TYPE' => 'php',
    'DIR' => './gy/component/edit_user/',
  ),
  './gy/component/edit_user/controller.php' => 
  array (
    'CODE' => '<?php 
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

$data  = $_REQUEST;

// стоит ли галочка не обновлять пароль, при изменении пользователя
$notUpdatePass = (!empty($data[\'no-update-pass\']) && ($data[\'no-update-pass\'] == \'on\') );

$arRes[\'user_property\'] = array(
    \'login\' => \'login\',
    \'name\' => \'name\',
    \'pass\' => \'pass\',
    \'groups\' => \'groups\'
);

// если идёт обновление пользователя без пароля то убрать пароль из списка свойств пользователя
if ($notUpdatePass) {
    unset($arRes[\'user_property\'][\'pass\']);
}

global $USER;

// взять все группы пользователей
$arRes[\'allUsersGroups\'] = Gy\\Core\\User\\AccessUserGroup::getAccessGroup();

function checkProperty($arr, $arRes){
    $result = true;
    foreach ($arRes[\'user_property\'] as $val) {
        if (empty($arr[$val])) {
            $result = false;
        }
    }

    if($result){
        foreach ($arr[\'groups\'] as $value) {  // TODO протестировать

            if (empty($arRes[\'allUsersGroups\'][$value])) {
                $result = false;
            }

            if (!empty($arr[\'groups\'][\'admins\']) && !$USER->isAdmin()) { // TODO протестировать
                $result = false;
            }
        }
    }

    return $result;
}

// получить данные пользователя
if (!empty($this->arParam[\'id-user\'])) {
    $arRes[\'userData\'] = $USER->getUserById($this->arParam[\'id-user\']);
    unset($arRes[\'userData\'][\'pass\']);
}

if (!empty($data[\'Сохранить\'])
    && ($data[\'Сохранить\'] == \'Сохранить\')
    && !empty($data[\'edit-id\'])
    && is_numeric($data[\'edit-id\'])
    && ($data[\'edit-id\'] != 1)
) {

    if (checkProperty($data, $arRes)) {

        // подготовить массив данных для обновления пользователей
        $dataUpdateUser = array();
        foreach ($arRes[\'user_property\'] as $value) {
            $dataUpdateUser[$value] = $data[$value];
        }

        // сохранить группы для пользователя
        unset($dataUpdateUser[\'groups\']);
        Gy\\Core\\User\\AccessUserGroup::deleteUserInAllGroups($data[\'edit-id\']);
        foreach ($data[\'groups\'] as $value) {
            Gy\\Core\\User\\AccessUserGroup::addUserInGroup($data[\'edit-id\'], $value);
        }

        // обновить данные пользователя
        global $USER;
        $res = $USER->updateUserById($data[\'edit-id\'], $dataUpdateUser);

        if ($res) {
            $arRes["stat"] = \'ok\';
        } else {
            $arRes["stat-text"] = \'! Не все поля заполнены\';
            $arRes["stat"] = \'err\';
        }

    } else {
        $arRes["stat-text"] = \'! Не все поля заполнены\';
        $arRes["stat"] = \'err\';
    }


} elseif ((!empty($arRes["stat"]) && ($arRes["stat"] != \'err\')) || empty($arRes["stat"])) {
    $arRes["stat"] = \'edit\';
}

if (empty($data[\'stat\'])) {
    header( \'Location: ?stat=\'.$arRes["stat"].\'&edit-id=\'.$this->arParam[\'id-user\'] );
} else {
    $arRes["stat"] = $data[\'stat\'];
}

// показать шаблон
$this->template->show($arRes, $this->arParam);
',
    'TYPE' => 'php',
    'DIR' => './gy/component/edit_user/',
  ),
  './gy/component/edit_user/lang_componentInfo.php' => 
  array (
    'CODE' => '<?php // языковой файл для componentInfo.php
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

$mess[\'rus\'] = array(
    \'text-info\' => \'Редактирование пользователя\',
    \'property-back-url\' => \'Ссылка на страницу откуда идёт редактирование\',
    \'property-id-user\' => \'Id Пользователя которого надо редактировать\'
);

$mess[\'eng\'] = array(
    \'text-info\' => \'User editing\',
    \'property-back-url\' => \'Link to the page where the editing is coming from\',
    \'property-id-user\' => \'Id of the User to be edited\'
);',
    'TYPE' => 'php',
    'DIR' => './gy/component/edit_user/',
  ),
  './gy/component/edit_user/teplates/0/lang_template.php' => 
  array (
    'CODE' => '<?php // языковой файл для шаблона компонента
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

$mess[\'rus\'] = array(
    \'button\' => \'Сохранить\',
    \'id\' => \'id\', 
    \'login\' => \'Логин\', 
    \'name\' => \'Имя\', 
    \'pass\' => \'Пароль\', 
    \'groups\' => \'Группа прав\',
    \'title\' => \'Изменение пользователя\',
    \'back\' => \'<< Назад\',
    \'ok\' => \'ok\',
    \'stat-ok\' => \'Данные сохранены\',
    \'edit-err\' => \'error, попробуйте заново\',
    \'no-update-pass-text\' => \'Не изменять пароль\',
    \'edit-propertys\' => \'Изменить своства (общие свойства)\'
);

$mess[\'eng\'] = array(
    \'button\' => \'Save\',
    \'id\' => \'id\', 
    \'login\' => \'Login\', 
    \'name\' => \'Name\', 
    \'pass\' => \'Password\', 
    \'groups\' => \'Group of rights\',
    \'title\' => \'User edit\',
    \'back\' => \'<< Back\',
    \'ok\' => \'ok\',
    \'stat-ok\' => \'Data saved\',
    \'edit-err\' => \'error, try again\',
    \'no-update-pass-text\' => \'Do not change password\',
    \'edit-propertys\' => \'Change properties (general properties)\'
);

',
    'TYPE' => 'php',
    'DIR' => './gy/component/edit_user/teplates/0/',
  ),
  './gy/component/edit_user/teplates/0/template.php' => 
  array (
    'CODE' => '<?php
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

?>
<h3><?=$this->lang->getMessage(\'title\');?></h3>
<?php
if (!empty($arParam[\'back-url\']) && empty($arRes["stat"])) {?>
    <br/>
    <br/>
    <a class="gy-admin-button" href="<?=$arParam[\'back-url\'];?>"><?=$this->lang->getMessage(\'back\');?></a>
    <br/>
    <br/>
<?php }?>
<?php if (empty($arRes["stat"]) || ($arRes["stat"] == \'edit\')) {?>
    <form>
        <input type="hidden" name="edit-id" value="<?=$arParam[\'id-user\'];?>" />
        <?php foreach ($arRes["user_property"] as $key => $val) {?>
            <?=$this->lang->getMessage($val);?>:<br/>
            <?php if ($val != \'groups\') {?>
                <input 
                    type="<?=(($val == \'pass\')? \'password\': \'text\');?>" 
                    name="<?=$val;?>" 
                    value="<?=((!empty($arRes[\'userData\'][$val]))? $arRes[\'userData\'][$val] : \'\');?>"
                />
                <?php
                // эта галочка что бы можно было менять настройки пользователя, без смены пароля
                if ($val == \'pass\') {?>
                    <input type="checkbox" name="no-update-pass" /><?=$this->lang->getMessage(\'no-update-pass-text\');?> 
                <?php }?>
            <?php } else {?>
                <select multiple name="groups[]">
                    <?php foreach ($arRes[\'allUsersGroups\'] as $value) { ?>
                        <option <?=(( !empty($arRes[\'userData\'][$val][$value[\'code\']]) )? \'selected\' : \'\');?> value="<?=$value[\'code\'];?>">
                            <?=$value[\'name\']?> (<?=$value[\'code\'];?>)
                        </option>
                    <?php }?>
                </select>
            <?php }?>    
            <br/>
        <?php }?>
        <input class="gy-admin-button" type="submit" name="<?=$this->lang->getMessage(\'button\');?>" value="<?=$this->lang->getMessage(\'button\');?>" />

    </form>	
    
    <br/>
    <a class="gy-admin-button" href="/gy/admin/edit-users-propertys.php?edit-id=<?=$arParam[\'id-user\'];?>"><?=$this->lang->getMessage(\'edit-propertys\');?></a>
    
<?php } elseif ($arRes["stat"] == \'ok\') {?>
    <div class="gy-admin-good-message"><?=$this->lang->getMessage(\'stat-ok\');?></div>
    <br/>
    <a href="/gy/admin/users.php" class="gy-admin-button"><?=$this->lang->getMessage(\'ok\');?></a>
<?php } elseif ($arRes["stat"] == \'err\') {?>
    <div class="gy-admin-error-message"><?=$this->lang->getMessage(\'edit-err\');?></div>
    <?php if (!empty($arRes["stat-text"])) {?>
        <br/> <?=$arRes["stat-text"];?>
    <?php }?>
    <br/>
    <a href="edit-user.php?edit-id=<?=$arParam[\'id-user\'];?>" class="gy-admin-button"><?=$this->lang->getMessage(\'ok\');?></a>
<?php } 
',
    'TYPE' => 'php',
    'DIR' => './gy/component/edit_user/teplates/0/',
  ),
  './gy/component/footer/componentInfo.php' => 
  array (
    'CODE' => '<?php
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

use Gy\\Core\\Lang;

global $APP;
$utlThisComponent = "/gy/component/footer/";
$langComponentInfo = new Lang($APP->urlProject.$utlThisComponent, \'componentInfo\', $APP->options[\'lang\']);

$componentInfo = array(
    \'name\' => \'footer\',
    \'text-info\' => $langComponentInfo->getMessage(\'text-info\'),
    \'v\' => \'0.1\',
);',
    'TYPE' => 'php',
    'DIR' => './gy/component/footer/',
  ),
  './gy/component/footer/controller.php' => 
  array (
    'CODE' => '<?php 
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

// показать шаблон
$this->template->show($arRes, $this->arParam);
',
    'TYPE' => 'php',
    'DIR' => './gy/component/footer/',
  ),
  './gy/component/footer/lang_componentInfo.php' => 
  array (
    'CODE' => '<?php // языковой файл для componentInfo.php
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

$mess[\'rus\'] = array(
    \'text-info\' => \'Подвал сайта\',
);

$mess[\'eng\'] = array(
    \'text-info\' => \'Footer site\',
);',
    'TYPE' => 'php',
    'DIR' => './gy/component/footer/',
  ),
  './gy/component/footer/teplates/0/lang_template.php' => 
  array (
    'CODE' => '<?php // языковой файл для шаблона компонента
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

',
    'TYPE' => 'php',
    'DIR' => './gy/component/footer/teplates/0/',
  ),
  './gy/component/footer/teplates/0/template.php' => 
  array (
    'CODE' => '<?php if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );?>

    </body>  
</html>',
    'TYPE' => 'php',
    'DIR' => './gy/component/footer/teplates/0/',
  ),
  './gy/component/form_auth/componentInfo.php' => 
  array (
    'CODE' => '<?php
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

use Gy\\Core\\Lang;

global $APP;
$utlThisComponent = "/gy/component/form_auth/";
$langComponentInfo = new Lang($APP->urlProject.$utlThisComponent, \'componentInfo\', $APP->options[\'lang\']);

$componentInfo = array(
    \'name\' => \'form_auth\',
    \'text-info\' => $langComponentInfo->getMessage(\'text-info\'),
    \'v\' => \'0.1\',
    \'all-property\' => array(
        \'idComponent\'
    ),
    \'all-property-text\' => array(
        \'idComponent\' => $langComponentInfo->getMessage(\'property-idComponent\')
    )
);',
    'TYPE' => 'php',
    'DIR' => './gy/component/form_auth/',
  ),
  './gy/component/form_auth/controller.php' => 
  array (
    'CODE' => '<?php 
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

use Gy\\Core\\Capcha;
//use Gy\\Core\\User\\AccessUserGroup;

// контроллер компонента form_auth (форма авторизации)

// подключить модель // include model this component
if (isset($this->model)) {
    $this->model->includeModel();
}

// были доступны параметры
//echo \'$arParam<pre>\'; print_r($this->arParam); echo \'</pre>\';

// если задан параметр idComponent значит сверить с пришедшим
$isChackIdComponent = ( empty($this->arParam[\'idComponent\'])
    || (!empty($this->arParam[\'idComponent\']) && !empty($_REQUEST[\'idComponent\']) && ($this->arParam[\'idComponent\'] == $_REQUEST[\'idComponent\']) )
);

$isShowAdminPanel = false;

if (!empty($_REQUEST[\'auth\'])) {
    $thisLogin = $_REQUEST[\'auth\'];
}

global $USER;

$isShowAdminPanel = Gy\\Core\\User\\AccessUserGroup::accessThisUserByAction( \'show_admin_panel\');

$redirectUrl = str_replace(\'index.php\', \'\', $_SERVER[\'SCRIPT_NAME\']);

if ($isShowAdminPanel === true){

    $thisLogin = $USER->getDataThisUser()[\'name\'];
    $arRes["auth_ok"] = \'ok\';
    $arRes["auth_user"] = $thisLogin;

} elseif (!empty($_REQUEST[\'auth\']) && !empty($_REQUEST[\'pass\']) && !empty($_REQUEST[\'capcha\'])) {

    $capcha = new Capcha($APP->url.Capcha::$defaultUrlFonts);
    
    if ($capcha->chackCapcha($_REQUEST[\'capcha\'])) {

        $USER->authorized($_REQUEST[\'auth\'], $_REQUEST[\'pass\']);
        $isShowAdminPanel = Gy\\Core\\User\\AccessUserGroup::accessThisUserByAction( \'show_admin_panel\');

        if ($isShowAdminPanel === false) {
            $arRes["err"] = \'err1\';
        }

        if ($isChackIdComponent && $isShowAdminPanel) {
            $arRes["auth_ok"] = \'ok\';
            $arRes["auth_user"] = $thisLogin;

            header( \'Location: \'.$redirectUrl );
        } else {
            $arRes[\'form_input\']["auth"] = "auth";
            $arRes[\'form_input\']["pass"] = "pass";
            header( \'Location: \'.$redirectUrl.\'?err=err1\' );

        }
    } else {
        $arRes[\'form_input\']["auth"] = "auth";
        $arRes[\'form_input\']["pass"] = "pass";
        header( \'Location: \'.$redirectUrl.\'?err=err_capcha\' );
    }
} else {
    if (!empty($_REQUEST[\'err\'])) {
        $arRes["err"] = $_REQUEST[\'err\'];
    }
    $arRes[\'form_input\']["auth"] = "auth";
    $arRes[\'form_input\']["pass"] = "pass";
}

if (!empty($arRes["auth_ok"]) && ($arRes["auth_ok"] == \'ok\') && !empty($_REQUEST[ $this->lang->getMessage(\'button-exit\') ])) {
    if ($USER->userExit()) {
        header( \'Location: \'.$redirectUrl );
    }
}

// показать шаблон
$this->template->show($arRes, $this->arParam);
',
    'TYPE' => 'php',
    'DIR' => './gy/component/form_auth/',
  ),
  './gy/component/form_auth/lang_componentInfo.php' => 
  array (
    'CODE' => '<?php  // языковой файл для componentInfo.php
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

$mess[\'rus\'] = array(
    \'text-info\' => \'Форма авторизации\',
    \'property-idComponent\' => \'Уникальное число (придумать надо самому) в рамках страницы сайта где вызывается компонент (сделано если два одинаковых компонента будут на одной странице сайта)\'
);
$mess[\'eng\'] = array(
    \'text-info\' => \'Authorization form\',
    \'property-idComponent\' => \'A unique number (you have to think of it yourself) within the site page where the component is called (done if two identical components are on the same page of the site)\'
);',
    'TYPE' => 'php',
    'DIR' => './gy/component/form_auth/',
  ),
  './gy/component/form_auth/lang_controller.php' => 
  array (
    'CODE' => '<?php // языковой файл для компонента
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

$mess[\'rus\'] = array(
    \'button-exit\' => \'Выйти\',
);
$mess[\'eng\'] = array(
    \'button-exit\' => \'Log_off\',
);
',
    'TYPE' => 'php',
    'DIR' => './gy/component/form_auth/',
  ),
  './gy/component/form_auth/teplates/0/lang_template.php' => 
  array (
    'CODE' => '<?php // языковой файл для шаблона компонента
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

$mess[\'rus\'] = array(
    \'button\' => \'Авторизоваться\',
    \'err1\' => \'! Логин или пароль неправильные.\',
    \'exit\' => \'Выйти\',
    \'err_capcha\' => \'! Ошибка в capcha, попробуйте ещё раз\',
    \'hi\' => \'Привет\'
);

$mess[\'eng\'] = array(
    \'button\' => \'Login\',
    \'err1\' => \'! Login or password is incorrect.\',
    \'exit\' => \'Log off\',
    \'err_capcha\' => \'! Capcha error, please try again\',
    \'hi\' => \'Hello\'
);

',
    'TYPE' => 'php',
    'DIR' => './gy/component/form_auth/teplates/0/',
  ),
  './gy/component/form_auth/teplates/0/template.php' => 
  array (
    'CODE' => '<?php // шаблон компонента // template component form_auth
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

if (empty($arRes["auth_ok"])) :?>
    <form>
        <input type="hidden" name="idComponent" value="<?=$arParam[\'idComponent\']?>" />

        <?php foreach ($arRes[\'form_input\'] as $key => $value) { ?>
            <input type="<?=(($key == \'pass\')? \'password\': \'text\');?>" name="<?=$key;?>"  /><br/>
        <?php }?>

        <?php // показать капчу
        global $APP;
        $APP->component(
            \'capcha\',
            \'0\',
            array( 
            )
        );?>
            
        <?php if (!empty($arRes[\'err\'])) {?>
            <div class="gy-admin-error-message"><?=$this->lang->getMessage($arRes[\'err\']);?></div>
        <?php }?>

        <input class="gy-admin-button" type="submit" name="<?=$this->lang->getMessage(\'button\');?>" value="<?=$this->lang->getMessage(\'button\');?>" />
        
    </form>
<?php else:?>
    <h1><?=$this->lang->getMessage(\'hi\');?>, <?=$arRes["auth_user"];?></h1>
    <form>
        <input class="gy-admin-button" type="submit" name="<?=$this->lang->getMessage(\'exit\');?>" value="<?=$this->lang->getMessage(\'exit\');?>" />
    </form>
<?php endif;?>',
    'TYPE' => 'php',
    'DIR' => './gy/component/form_auth/teplates/0/',
  ),
  './gy/component/form_auth_test/.LCKcontroller.php~' => 
  array (
    'CODE' => '/var/www/gy-test.ru/gy/component/form_auth_test/controller.php',
    'TYPE' => 'hp~',
    'DIR' => './gy/component/form_auth_test/',
  ),
  './gy/component/form_auth_test/componentInfo.php' => 
  array (
    'CODE' => '<?php
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

use Gy\\Core\\Lang;

global $APP;
$utlThisComponent = "/gy/component/form_auth_test/";
$langComponentInfo = new Lang($APP->urlProject.$utlThisComponent, \'componentInfo\', $APP->options[\'lang\']);

$componentInfo = array(
    \'name\' => \'form_auth_test\',
    \'text-info\' => $langComponentInfo->getMessage(\'text-info\'),
    \'v\' => \'0.1\',
    \'all-property\' => array(
        \'test\',
        \'idComponent\',
    ),
    \'all-property-text\' => array(
        \'test\' => $langComponentInfo->getMessage(\'property-test\'),
        \'idComponent\' => $langComponentInfo->getMessage(\'property-idComponent\')
    )
);',
    'TYPE' => 'php',
    'DIR' => './gy/component/form_auth_test/',
  ),
  './gy/component/form_auth_test/controller.php' => 
  array (
    'CODE' => '<?php 
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

// контроллер компонента form_auth_test (форма авторизации)

// подключить модель // include model this component
if (isset($this->model)) {
    $this->model->includeModel();
}

// были доступны параметры
//echo \'$arParam<pre>\'; print_r($this->arParam); echo \'</pre>\';

// если задан параметр idComponent значит сверить с пришедшим
$isChackIdComponent = ( empty($this->arParam[\'idComponent\'])
    || (!empty($this->arParam[\'idComponent\']) && !empty($_REQUEST[\'idComponent\']) && ($this->arParam[\'idComponent\'] == $_REQUEST[\'idComponent\']) )
);

// $model - теоретически должно быть тут доступно
if ($isChackIdComponent && !empty($_REQUEST[\'auth\'])) {
    $arRes["auth_ok"] = \'ok\';
    $arRes["auth_user"] = $_REQUEST[\'auth\'].\' \'.model_setAuth($_REQUEST[\'auth\']);
} else {
    $arRes["auth"] = "auth";
}

// показать шаблон
$this->template->show($arRes, $this->arParam);
',
    'TYPE' => 'php',
    'DIR' => './gy/component/form_auth_test/',
  ),
  './gy/component/form_auth_test/lang_componentInfo.php' => 
  array (
    'CODE' => '<?php // языковой файл для componentInfo.php
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

$mess[\'rus\'] = array(
    \'text-info\' => \'Форма авторизации тестовая, авторизации в ядре gy не происходит (просто демонстрация работы нескольких компонентов одновременно)\',
    \'property-test\' => \'Поле для теста\',
    \'property-idComponent\' => \'Уникальное число (придумать надо самому) в рамках страницы сайта где вызывается компонент (сделано если два одинаковых компонента будут на одной странице сайта)\'
);

$mess[\'eng\'] = array(
    \'text-info\' => \'The authorization form is test, there is no authorization in the gy core (just a demonstration of the work of several components at the same time)\',
    \'property-test\' => \'Test field\',
    \'property-idComponent\' => \'A unique number (you have to come up with yourself) within the site page where the component is called (done if two identical components are on the same page of the site)\'
);',
    'TYPE' => 'php',
    'DIR' => './gy/component/form_auth_test/',
  ),
  './gy/component/form_auth_test/lang_controller.php' => 
  array (
    'CODE' => '<?php // языковой файл для компонента
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

$mess[\'rus\'] = array(
    \'test\' => \'ok\',
);
$mess[\'eng\'] = array(
    \'test\' => \'ok\',
);
',
    'TYPE' => 'php',
    'DIR' => './gy/component/form_auth_test/',
  ),
  './gy/component/form_auth_test/model.php' => 
  array (
    'CODE' => '<?php
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

/**
 * это модель класса, тут должны быть функции к которым будет обращаться компонент
 * также подключаться более общие классы (users, БД ... ) 
 * 
 * this is model component, here function for component and include class
 * 
 * TODO может модель сделать универсальной и не писать свою для каждого класса
 *   надо подумать
 */

function model_setAuth($auth){ // test model
    return \'(test = ok)\';
}

',
    'TYPE' => 'php',
    'DIR' => './gy/component/form_auth_test/',
  ),
  './gy/component/form_auth_test/teplates/0/lang_template.php' => 
  array (
    'CODE' => '<?php // языковой файл для шаблона компонента
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

$mess[\'rus\'] = array(
    \'button\' => \'Отправить\',
    \'get-text\' => \'Введите любой текст\',
    \'hi\' => \'Привет\'
);

$mess[\'eng\'] = array(
    \'button\' => \'Send\',
    \'get-text\' => \'pleas input any text\',
    \'hi\' => \'Hello\'
);',
    'TYPE' => 'php',
    'DIR' => './gy/component/form_auth_test/teplates/0/',
  ),
  './gy/component/form_auth_test/teplates/0/script.js' => 
  array (
    'CODE' => 'console.log(\'test js = ok\')',
    'TYPE' => '.js',
    'DIR' => './gy/component/form_auth_test/teplates/0/',
  ),
  './gy/component/form_auth_test/teplates/0/style.css' => 
  array (
    'CODE' => 'form{
    background-color: #05ff07;
}',
    'TYPE' => 'css',
    'DIR' => './gy/component/form_auth_test/teplates/0/',
  ),
  './gy/component/form_auth_test/teplates/0/template.php' => 
  array (
    'CODE' => '<?php // шаблон компонента // template component form_auth_test
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

if (empty($arRes["auth_ok"])) :?>
    <form>
    <p><?=$this->lang->getMessage(\'get-text\');?></p>
        <?php 
        foreach ($arRes as $key => $value) {
        ?>
            <input type="hidden" name="idComponent" value="<?=$arParam[\'idComponent\']?>" />
            <input type="text" name="<?=$key;?>"  />
        <?php }?>

        <input type="submit" name="<?=$this->lang->getMessage(\'button\');?>" value="<?=$this->lang->getMessage(\'button\');?>" />

    </form>
<?php else:?>
    <h1><?=$this->lang->getMessage(\'hi\');?>, <?=$arRes["auth_user"];?></h1>

<?php endif;?>',
    'TYPE' => 'php',
    'DIR' => './gy/component/form_auth_test/teplates/0/',
  ),
  './gy/component/gy_options/componentInfo.php' => 
  array (
    'CODE' => '<?php
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

use Gy\\Core\\Lang;

global $APP;
$utlThisComponent = "/gy/component/gy_options/";
$langComponentInfo = new Lang($APP->urlProject.$utlThisComponent, \'componentInfo\', $APP->options[\'lang\']);

$componentInfo = array(
    \'name\' => \'gy_options\',
    \'text-info\' => $langComponentInfo->getMessage(\'text-info\'),
    \'v\' => \'0.1\',
    \'all-property\' => array()
);',
    'TYPE' => 'php',
    'DIR' => './gy/component/gy_options/',
  ),
  './gy/component/gy_options/controller.php' => 
  array (
    'CODE' => '<?php 
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

global $APP;

$data = $_POST;

if (!empty($data[\'cacheClear\'])) {
    // нужно удалить все файлы из раздела /gy/cache/

    $files = glob($APP->url.\'/cache/*\');
    foreach ($files as $file) {
        if (is_file($file)) {
            unlink($file);
        }
    }
    $arRes[\'status\'] = \'cacheClear-ok\';
}

$arRes[\'button\'] = array(
    \'cacheClear\'
);

// возможные варианты языка
$arRes[\'langs\'] = array(
    \'rus\',
    \'eng\'
);

$arRes[\'this-lang\'] = $APP->options[\'lang\'];

if (!empty($data[\'save\']) && in_array($data[\'lang\'], $arRes[\'langs\'])) {

    // задать настройки сразу ядра
    global $argv;
    $argv = array();
    $argv[] = 1;
    $argv[] = \'set-option\';
    $argv[] = \'lang\';
    $argv[] = $data[\'lang\'];
    
    ob_start();
    include $_SERVER["DOCUMENT_ROOT"].\'/gy/install/consoleInstallOptions.php\';
    $consoleLog = ob_get_contents();
    ob_end_clean();
   
    if ($consoleLog == "run set-option\\nfinish set-option\\n") {
        $arRes[\'status\'] = \'save-ok\';
    } else {
        $arRes[\'status\'] = \'save-err\';
        $arRes[\'status-text\'] = $consoleLog;
    }

}

// показать шаблон
$this->template->show($arRes, $this->arParam);
',
    'TYPE' => 'php',
    'DIR' => './gy/component/gy_options/',
  ),
  './gy/component/gy_options/lang_componentInfo.php' => 
  array (
    'CODE' => '<?php // языковой файл для componentInfo.php
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

$mess[\'rus\'] = array(
    \'text-info\' => \'Настройки gy админ панели\',
);

$mess[\'eng\'] = array(
    \'text-info\' => \'Gy admin panel settings\',
);',
    'TYPE' => 'php',
    'DIR' => './gy/component/gy_options/',
  ),
  './gy/component/gy_options/teplates/0/lang_template.php' => 
  array (
    'CODE' => '<?php // языковой файл для шаблона компонента
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

$mess[\'rus\'] = array(
    \'title\' => \'Настройки\',
    \'cacheClear\' => \'Сбросить кеш\',
    \'ok\' => \'ОК\',
    \'cacheClear-ok\' => \'! кеш сброшен\',
    \'title-lang\' => \'Выбор языка\',
    \'save\' => \'Сохранить\',
    \'save-ok\' => \'Изменения сохранены\',
    \'save-err\' => \'Произошла ошибка во время сохранения\'
);

$mess[\'eng\'] = array(
    \'title\' => \'Settings\',
    \'cacheClear\' => \'Flush cache\',
    \'ok\' => \'OK\',
    \'cacheClear-ok\' => \'! cache flushed\',
    \'title-lang\' => \'Language selection\',
    \'save\' => \'Save\',
    \'save-ok\' => \'Changes saved\',
    \'save-err\' => \'An error occurred while saving\'
);

',
    'TYPE' => 'php',
    'DIR' => './gy/component/gy_options/teplates/0/',
  ),
  './gy/component/gy_options/teplates/0/template.php' => 
  array (
    'CODE' => '<?php
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );?>

<h1><?=$this->lang->getMessage(\'title\');?></h1>

<?php if (empty($arRes[\'status\']) && !empty($arRes[\'button\'])) {?>
    <?php foreach ($arRes[\'button\'] as $val) { ?>
        <form method="post">
            <?php if (!empty($arRes[\'langs\'])) {?>
                <br/>
                ================================
                <br/>
                <?=$this->lang->getMessage(\'title-lang\');?>:
                <select name="lang">
                    <?php  foreach ($arRes[\'langs\'] as $value) { ?>
                        <option 
                            value="<?=$value?>"
                            <?php if ($value == $arRes[\'this-lang\']) {?>
                                selected
                            <?php }?>
                        >
                            <?=$value?>
                        </option>
                    <?php }?>
                </select>
                <br/>
                <input type=\'submit\' class="gy-admin-button" name="save" value="<?=$this->lang->getMessage(\'save\');?>" />
                <br/>
                ===============================
                <br/>
            <?php }?>
            
            <input type=\'submit\' class="gy-admin-button" name="cacheClear" value="<?=$this->lang->getMessage(\'cacheClear\');?>" />
        </form>
    <?php }?>
<?php } else { ?>
    <?php if ($arRes[\'status\'] == \'cacheClear-ok\') {?>
        <div class="gy-admin-good-message"><?=$this->lang->getMessage(\'cacheClear-ok\');?></div>
    <?php } elseif ($arRes[\'status\'] == \'save-ok\') { ?>
        <div class="gy-admin-good-message"><?=$this->lang->getMessage(\'save-ok\');?></div>
    <?php } elseif ($arRes[\'status\'] == \'save-err\') { ?>
        <div class="gy-admin-error-message">
            <?=$this->lang->getMessage(\'save-err\');?>:
            <br/>
            <?=$arRes[\'status-text\'];?>
        </div>
    <?php }?>

    <br/>
    <a href="/gy/admin/options.php" class="gy-admin-button"><?=$this->lang->getMessage(\'ok\');?></a>
<?php }',
    'TYPE' => 'php',
    'DIR' => './gy/component/gy_options/teplates/0/',
  ),
  './gy/component/header/componentInfo.php' => 
  array (
    'CODE' => '<?php
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

use Gy\\Core\\Lang;

global $APP;
$utlThisComponent = "/gy/component/header/";
$langComponentInfo = new Lang($APP->urlProject.$utlThisComponent, \'componentInfo\', $APP->options[\'lang\']);

$componentInfo = array(
    \'name\' => \'header\',
    \'text-info\' => $langComponentInfo->getMessage(\'text-info\'),
    \'v\' => \'0.1\',
);',
    'TYPE' => 'php',
    'DIR' => './gy/component/header/',
  ),
  './gy/component/header/controller.php' => 
  array (
    'CODE' => '<?php 
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

// показать шаблон
$this->template->show($arRes, $this->arParam);
',
    'TYPE' => 'php',
    'DIR' => './gy/component/header/',
  ),
  './gy/component/header/lang_componentInfo.php' => 
  array (
    'CODE' => '<?php // языковой файл для componentInfo.php
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

$mess[\'rus\'] = array(
    \'text-info\' => \'Шапка сайта\',
);

$mess[\'eng\'] = array(
    \'text-info\' => \'Header site\',
);',
    'TYPE' => 'php',
    'DIR' => './gy/component/header/',
  ),
  './gy/component/header/teplates/0/lang_template.php' => 
  array (
    'CODE' => '<?php // языковой файл для шаблона компонента
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

',
    'TYPE' => 'php',
    'DIR' => './gy/component/header/teplates/0/',
  ),
  './gy/component/header/teplates/0/template.php' => 
  array (
    'CODE' => '<?php if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );
global $APP;
?>

<html>
    <head>
        <?php
        // вывести title и СЕО метатеги
        if (!empty($arParam[\'seo-meta-tag-head\'])) {
            $APP->component(
                \'hed-meta-tag-seo\',
                \'0\',
                $arParam[\'seo-meta-tag-head\']
            );
        }
        
        ?>
    </head>
    <body>  ',
    'TYPE' => 'php',
    'DIR' => './gy/component/header/teplates/0/',
  ),
  './gy/component/hed-meta-tag-seo/componentInfo.php' => 
  array (
    'CODE' => '<?php
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

use Gy\\Core\\Lang;

global $APP;
$utlThisComponent = "/gy/component/hed-meta-tag-seo/";
$langComponentInfo = new Lang($APP->urlProject.$utlThisComponent, \'componentInfo\', $APP->options[\'lang\']);

$componentInfo = array(
    \'name\' => \'hed-meta-tag-seo\',
    \'text-info\' => $langComponentInfo->getMessage(\'text-info\'),
    \'v\' => \'0.1\',
);',
    'TYPE' => 'php',
    'DIR' => './gy/component/hed-meta-tag-seo/',
  ),
  './gy/component/hed-meta-tag-seo/controller.php' => 
  array (
    'CODE' => '<?php 
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

// показать шаблон
$this->template->show($arRes, $this->arParam);
',
    'TYPE' => 'php',
    'DIR' => './gy/component/hed-meta-tag-seo/',
  ),
  './gy/component/hed-meta-tag-seo/lang_componentInfo.php' => 
  array (
    'CODE' => '<?php // языковой файл для componentInfo.php
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

$mess[\'rus\'] = array(
    \'text-info\' => \'CEO метатеги для <head>\',
);

$mess[\'eng\'] = array(
    \'text-info\' => \'SEO tag in <meta> for <head> \',
);',
    'TYPE' => 'php',
    'DIR' => './gy/component/hed-meta-tag-seo/',
  ),
  './gy/component/hed-meta-tag-seo/teplates/0/lang_template.php' => 
  array (
    'CODE' => '<?php // языковой файл для шаблона компонента
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

',
    'TYPE' => 'php',
    'DIR' => './gy/component/hed-meta-tag-seo/teplates/0/',
  ),
  './gy/component/hed-meta-tag-seo/teplates/0/template.php' => 
  array (
    'CODE' => '<?php if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );?>

<?php if (!empty($arParam[\'title\'])) {?>
    <title><?=$arParam[\'title\']?></title>
<?php }?>

<?php if (!empty($arParam[\'descriptions\'])) {?>
    <meta name="descriptions" content="<?=$arParam[\'descriptions\']?>">
<?php }?>

<?php if (!empty($arParam[\'keywords\'])) {?>
    <meta name="keywords" content="<?=$arParam[\'keywords\']?>">
<?php }?>
',
    'TYPE' => 'php',
    'DIR' => './gy/component/hed-meta-tag-seo/teplates/0/',
  ),
  './gy/component/includeHtml/componentInfo.php' => 
  array (
    'CODE' => '<?php
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

use Gy\\Core\\Lang;

global $APP;
$utlThisComponent = "/gy/component/includeHtml/";
$langComponentInfo = new Lang($APP->urlProject.$utlThisComponent, \'componentInfo\', $APP->options[\'lang\']);

$componentInfo = array(
    \'name\' => \'includeHtml\',
    \'text-info\' => $langComponentInfo->getMessage(\'text-info\'),
    \'v\' => \'0.1\',
    \'all-property\' => array(
        \'html\',
        //\'test\'
    ),
    \'all-property-text\' => array(
        \'html\' => $langComponentInfo->getMessage(\'property-html\')
    )
);',
    'TYPE' => 'php',
    'DIR' => './gy/component/includeHtml/',
  ),
  './gy/component/includeHtml/controller.php' => 
  array (
    'CODE' => '<?php 
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

// показать шаблон
$this->template->show($arRes, $this->arParam);
',
    'TYPE' => 'php',
    'DIR' => './gy/component/includeHtml/',
  ),
  './gy/component/includeHtml/lang_componentInfo.php' => 
  array (
    'CODE' => '<?php // языковой файл для componentInfo.php
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

$mess[\'rus\'] = array(
    \'text-info\' => \'Компонент для вывода html кода\',
    \'property-html\' => \'Любой html код\'
);

$mess[\'eng\'] = array(
    \'text-info\' => \'Component for outputting html code\',
    \'property-html\' => \'Any html code\'
);',
    'TYPE' => 'php',
    'DIR' => './gy/component/includeHtml/',
  ),
  './gy/component/includeHtml/teplates/0/template.php' => 
  array (
    'CODE' => '<?php 
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );
if (!empty($arParam[\'html\']) ) { ?>
    <?=$arParam[\'html\']?>
<?php }',
    'TYPE' => 'php',
    'DIR' => './gy/component/includeHtml/teplates/0/',
  ),
  './gy/component/menu/componentInfo.php' => 
  array (
    'CODE' => '<?php
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

use Gy\\Core\\Lang;

global $APP;
$utlThisComponent = "/gy/component/menu/";
$langComponentInfo = new Lang($APP->urlProject.$utlThisComponent, \'componentInfo\', $APP->options[\'lang\']);

$componentInfo = array(
    \'name\' => \'menu\',
    \'text-info\' => $langComponentInfo->getMessage(\'text-info\'),
    \'v\' => \'0.1\',
    \'all-property\' => array(
        \'buttons\'
    ),
    \'all-property-text\' => array(
        \'buttons\' => $langComponentInfo->getMessage(\'property-buttons\')
    )
);',
    'TYPE' => 'php',
    'DIR' => './gy/component/menu/',
  ),
  './gy/component/menu/controller.php' => 
  array (
    'CODE' => '<?php 
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

$arRes[\'thisUrl\'] = $_SERVER[\'SCRIPT_NAME\'];

if (($arRes[\'thisUrl\'] == \'/gy/admin/get-admin-page.php\') && !empty($_GET[\'page\'])) {
    $arRes[\'thisUrl\'] = \'/gy/admin/get-admin-page.php?page=\'.htmlspecialchars($_GET[\'page\']);
}

// показать шаблон
$this->template->show($arRes, $this->arParam);
',
    'TYPE' => 'php',
    'DIR' => './gy/component/menu/',
  ),
  './gy/component/menu/lang_componentInfo.php' => 
  array (
    'CODE' => '<?php // языковой файл для componentInfo.php
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

$mess[\'rus\'] = array(
    \'text-info\' => \'Меню\',
    \'property-buttons\' => \'Массив с элементами меню, вида : названия кнопки => ссылка\'
);

$mess[\'eng\'] = array(
    \'text-info\' => \'Menu\',
    \'property-buttons\' => \'Array of buttons with menu items, like: titles => link\'
);',
    'TYPE' => 'php',
    'DIR' => './gy/component/menu/',
  ),
  './gy/component/menu/lang_controller.php' => 
  array (
    'CODE' => '<?php // языковой файл для компонента
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

$mess[\'rus\'] = array(
    //\'test\' => \'ok\',
);
',
    'TYPE' => 'php',
    'DIR' => './gy/component/menu/',
  ),
  './gy/component/menu/teplates/0/lang_template.php' => 
  array (
    'CODE' => '<?php // языковой файл для шаблона компонента
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

$mess[\'rus\'] = array(
    \'hi\' => \'Админка gy framework\',
);

$mess[\'rus\'] = array(
    \'hi\' => \'Admin panel - gy framework\',
);

',
    'TYPE' => 'php',
    'DIR' => './gy/component/menu/teplates/0/',
  ),
  './gy/component/menu/teplates/0/template.php' => 
  array (
    'CODE' => '<?php
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

if ($arParam[\'buttons\']) {?>
    <div class="gy-admin-menu">
        <?php foreach ($arParam[\'buttons\'] as $key => $val) {?>
            <a href="<?=$val;?>" class="<?=(($val == $arRes[\'thisUrl\'])? \'active-menu\': \'\');?>"><?=$key;?></a>
        <?php }?>
    </div>
<?php }',
    'TYPE' => 'php',
    'DIR' => './gy/component/menu/teplates/0/',
  ),
  './gy/component/show_include_modules/componentInfo.php' => 
  array (
    'CODE' => '<?php
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

use Gy\\Core\\Lang;

global $APP;
$utlThisComponent = "/gy/component/show_include_modules/";
$langComponentInfo = new Lang($APP->urlProject.$utlThisComponent, \'componentInfo\', $APP->options[\'lang\']);

$componentInfo = array(
    \'name\' => \'show_include_modules\',
    \'text-info\' => $langComponentInfo->getMessage(\'text-info\'),
    \'v\' => \'0.1\',
    \'all-property\' => array()
);',
    'TYPE' => 'php',
    'DIR' => './gy/component/show_include_modules/',
  ),
  './gy/component/show_include_modules/controller.php' => 
  array (
    'CODE' => '<?php 
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

// подключить даныне по всем подключенным модулям
$module = Gy\\Core\\Module::getInstance();
$arRes[\'info-modules\'] = $module->getInfoAllIncludeModules();

// показать шаблон
$this->template->show($arRes, $this->arParam);
',
    'TYPE' => 'php',
    'DIR' => './gy/component/show_include_modules/',
  ),
  './gy/component/show_include_modules/lang_componentInfo.php' => 
  array (
    'CODE' => '<?php // языковой файл для componentInfo.php
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

$mess[\'rus\'] = array(
    \'text-info\' => \'Таблица с подключёнными модулями к gy и их версии\',
);

$mess[\'eng\'] = array(
    \'text-info\' => \'Table with connected modules to gy and their versions\',
);',
    'TYPE' => 'php',
    'DIR' => './gy/component/show_include_modules/',
  ),
  './gy/component/show_include_modules/teplates/0/lang_template.php' => 
  array (
    'CODE' => '<?php // языковой файл для шаблона компонента
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

$mess[\'rus\'] = array(
    \'h1\' => \'Модули подключенные к ядру gy\',
    \'name\' => \'Имя модуля\',
    \'v\' => \'Версия\'
);

$mess[\'eng\'] = array(
    \'h1\' => \'Modules connected to the gy core\',
    \'name\' => \'Name module\',
    \'v\' => \'Version\'
);

',
    'TYPE' => 'php',
    'DIR' => './gy/component/show_include_modules/teplates/0/',
  ),
  './gy/component/show_include_modules/teplates/0/template.php' => 
  array (
    'CODE' => '<?php
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );
?>
<h2><?=$this->lang->getMessage(\'h1\');?></h2>
<?php if ($arRes[\'info-modules\']) {?>

    <table border="1" class="gy-table-all-users">
        <tr><th><?=$this->lang->getMessage(\'name\')?></th><th><?=$this->lang->getMessage(\'v\')?></th></tr>

        <?php foreach ($arRes[\'info-modules\'] as $key => $val) {?>
            <tr>
                <td><?=$key;?></td>
                <td><?=$val;?></td>
            </tr>
        <?php }?>     
    </table>
<?php }',
    'TYPE' => 'php',
    'DIR' => './gy/component/show_include_modules/teplates/0/',
  ),
  './gy/component/show_user/componentInfo.php' => 
  array (
    'CODE' => '<?php
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

use Gy\\Core\\Lang;

global $APP;
$utlThisComponent = "/gy/component/show_user/";
$langComponentInfo = new Lang($APP->urlProject.$utlThisComponent, \'componentInfo\', $APP->options[\'lang\']);

$componentInfo = array(
    \'name\' => \'show_user\',
    \'text-info\' => $langComponentInfo->getMessage(\'text-info\'),
    \'v\' => \'0.1\',
    \'all-property\' => array(
        \'id\'
    ),
    \'all-property-text\' => array(
        \'id\' => $langComponentInfo->getMessage(\'property-id-user\')
    )
);',
    'TYPE' => 'php',
    'DIR' => './gy/component/show_user/',
  ),
  './gy/component/show_user/controller.php' => 
  array (
    'CODE' => '<?php 
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

use Gy\\Core\\User\\GeneralUsersPropertys;

if (!empty($this->arParam[\'id\']) && is_numeric($this->arParam[\'id\'])) {
    global $USER;
    $dateUser = $USER->getUserById($this->arParam[\'id\']);

    if (!empty($dateUser)) {
        // взять все группы пользователей
        $allUsersGroups = Gy\\Core\\User\\AccessUserGroup::getAccessGroup();
        
        $arRes[\'dataUser\'] = array(
            \'id\' => $dateUser[\'id\'],
            \'login\' => $dateUser[\'login\'],
            \'name\' => $dateUser[\'name\']
        );
        
        $groups = array();
        if (!empty($dateUser[\'groups\'])) {
            foreach ($dateUser[\'groups\'] as $value) {
                if (!empty($allUsersGroups[$value])) {
                    $groups[$value] = $allUsersGroups[$value][\'name\'].\' - \'.$allUsersGroups[$value][\'text\'];
                }
            }
        }
        $arRes[\'dataUser\'][\'groups\'] = $groups;
        
        // получить свойства и значения
        
        // получить все общие свойства пользователей которые были созданы
        $allUsersCreatePropertys = generalUsersPropertys::getAllGeneralUsersPropertys();

        // получить значения свойств конкретного пользователя
        $valuePropertysThisUser = generalUsersPropertys::getAllValueUserProperty( $this->arParam[\'id\'], \'text\'); // text - т.к. пока только такие типы свойств реализованы

        // собираю общий массив
        $propertys = array();
        foreach ($allUsersCreatePropertys as $key => $value) {

            $val = \'\';
            if (!empty($valuePropertysThisUser[$value[\'id\']])) {
                $val = $valuePropertysThisUser[$value[\'id\']][\'value\'];
            }

            $propertys[] = array(
                \'name_property\' => $value[\'name_property\'],
                \'id_property\' => $value[\'id\'],
                \'value\' => $val
            );
        }
        $arRes[\'dataUser\'][\'propertys\'] = $propertys;
    }

}

// показать шаблон
$this->template->show($arRes, $this->arParam);
',
    'TYPE' => 'php',
    'DIR' => './gy/component/show_user/',
  ),
  './gy/component/show_user/lang_componentInfo.php' => 
  array (
    'CODE' => '<?php // языковой файл для componentInfo.php
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

$mess[\'rus\'] = array(
    \'text-info\' => \'Просмотреть все данные пользователя (и значения общих свойств)\',
    \'property-id-user\' => \'Id Пользователя данные по которому надо просмотреть\'
);

$mess[\'eng\'] = array(
    \'text-info\' => \'View all user data (and general property values)\',
    \'property-id-user\' => \'Id of the User data for which you want to view\'
);',
    'TYPE' => 'php',
    'DIR' => './gy/component/show_user/',
  ),
  './gy/component/show_user/teplates/0/lang_template.php' => 
  array (
    'CODE' => '<?php // языковой файл для шаблона компонента
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

$mess[\'rus\'] = array(
    \'title\' => \'Просмотр данных пользователя с id=\',
    \'err-data\' => \'Данные по пользователю не найдены\',
    \'name-property\' => \'Имя\',
    \'value-property\' => \'Значение\',
    \'title-property\' => \'Значения общих пользовательских свойств\',
    \'title-property-standart\' => \'Основные данные пользователя\'
);


$mess[\'eng\'] = array(
    \'title\' => \'View user data with id=\',
    \'err-data\' => \'User data not found\',
    \'name-property\' => \'Name\',
    \'value-property\' => \'Value\',
    \'title-property\' => \'Common custom property values\',
    \'title-property-standart\' => \'Basic user data\'
);

',
    'TYPE' => 'php',
    'DIR' => './gy/component/show_user/teplates/0/',
  ),
  './gy/component/show_user/teplates/0/template.php' => 
  array (
    'CODE' => '<?php if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );?>
<h1><?=$this->lang->getMessage(\'title\');?><?=$arParam[\'id\']?></h1>

<?php if (!empty($arRes[\'dataUser\'])) {?>
    <h3><?=$this->lang->getMessage(\'title-property-standart\');?></h3>
    <table border="1" class="gy-table-all-users">

        <tr>
            <th><?=$this->lang->getMessage(\'name-property\');?></th>
            <th><?=$this->lang->getMessage(\'value-property\');?></th>
        </tr>

        <tr>
            <td>id</td>
            <td><?=$arRes[\'dataUser\'][\'id\']?></td> 
        </tr>    
        <tr>
            <td>login</td>
            <td><?=$arRes[\'dataUser\'][\'login\']?></td> 
        </tr>    
        <tr>
            <td>name</td>
            <td><?=$arRes[\'dataUser\'][\'name\']?></td> 
        </tr>    
        <tr>
            <td>groups</td>
            <td>
                <?php if (!empty($arRes[\'dataUser\'][\'groups\'])) {?>
                    <?php foreach ($arRes[\'dataUser\'][\'groups\'] as $value) { ?>
                        <?=$value?>
                        </br>
                    <?php }?>
                <?php } else {?>
                    -
                <?php }?>
            </td> 
        </tr>    


    </table>

    <?php if (!empty($arRes[\'dataUser\'][\'propertys\'])) {?>
        <h3><?=$this->lang->getMessage(\'title-property\');?></h3>

        <table border="1" class="gy-table-all-users">

            <tr>
                <th><?=$this->lang->getMessage(\'name-property\');?></th>
                <th><?=$this->lang->getMessage(\'value-property\');?></th>
            </tr>

            <?php foreach ($arRes[\'dataUser\'][\'propertys\'] as $value) { ?>
                <tr>
                    <td><?=$value[\'name_property\']?></td>
                    <td>
                        <?=$value[\'value\']?>
                    </td> 
                </tr>    
            <?php }?>

        </table>
    <?php }?>
<?php } else {?>
    <?=$this->lang->getMessage(\'err-data\');?>
<?php }?>

',
    'TYPE' => 'php',
    'DIR' => './gy/component/show_user/teplates/0/',
  ),
  './gy/component/users_all_tables/componentInfo.php' => 
  array (
    'CODE' => '<?php
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

use Gy\\Core\\Lang;

global $APP;
$utlThisComponent = "/gy/component/users_all_tables/";
$langComponentInfo = new Lang($APP->urlProject.$utlThisComponent, \'componentInfo\', $APP->options[\'lang\']);

$componentInfo = array(
    \'name\' => \'users_all_tables\',
    \'text-info\' => $langComponentInfo->getMessage(\'text-info\'),
    \'v\' => \'0.1\',
    \'all-property\' => array()
);',
    'TYPE' => 'php',
    'DIR' => './gy/component/users_all_tables/',
  ),
  './gy/component/users_all_tables/controller.php' => 
  array (
    'CODE' => '<?php 
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

$data = $_REQUEST;

global $USER;
$arRes[\'allUsers\'] = $USER->getAllDataUsers();

// взять все группы пользователей
$arRes[\'allUsersGroups\'] = Gy\\Core\\User\\AccessUserGroup::getAccessGroup();

// если идёт удаление пользователя
if (!empty($data[\'del-id\'])
    && is_numeric($data[\'del-id\'])
    && ($data[\'del-id\'] != 1)
    && Gy\\Core\\User\\AccessUserGroup::accessThisUserByAction( \'show_admin_panel\')
) {
    $res = $USER->deleteUserById($data[\'del-id\']);
    if ($res) {
        $arRes[\'del-stat\'] = \'ok\';
    } else {
        $arRes[\'del-stat\'] = \'err\';
    }
}

// показать шаблон
$this->template->show($arRes, $this->arParam);
',
    'TYPE' => 'php',
    'DIR' => './gy/component/users_all_tables/',
  ),
  './gy/component/users_all_tables/lang_componentInfo.php' => 
  array (
    'CODE' => '<?php // языковой файл для componentInfo.php
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

$mess[\'rus\'] = array(
    \'text-info\' => \'Таблица со всеми пользователями\',
);

$mess[\'eng\'] = array(
    \'text-info\' => \'Table with all users\',
);',
    'TYPE' => 'php',
    'DIR' => './gy/component/users_all_tables/',
  ),
  './gy/component/users_all_tables/teplates/0/lang_template.php' => 
  array (
    'CODE' => '<?php // языковой файл для шаблона компонента
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

$mess[\'rus\'] = array(
    \'del-user\' => \'Удалить\',
    \'edit-user\' => \'Изменить\',
    \'title\' => \'Пользователи\',
    \'add-user\' => \'Добавить пользователя\',
    \'del-ok\' => \'Пользователь - удалён\',
    \'del-err\' => \'Ошибка при удаление\',
    \'ok\' => \'Ок\',
    \'options-groups\' => \'Настройка групп прав доступа\',
    \'list-all-user-propertys\' => \'Список общих пользовательских свойств\',
    \'show-user\' => \'Посмотреть все данные\'
);

$mess[\'eng\'] = array(
    \'del-user\' => \'Delete\',
    \'edit-user\' => \'Edit\',
    \'title\' => \'Users\',
    \'add-user\' => \'Add user\',
    \'del-ok\' => \'User - delete\',
    \'del-err\' => \'Error while deleting\',
    \'ok\' => \'Ok\',
    \'options-groups\' => \'Setting up access rights groups\',
    \'list-all-user-propertys\' => \'List of common custom properties\',
    \'show-user\' => \'View all data\'
);

',
    'TYPE' => 'php',
    'DIR' => './gy/component/users_all_tables/teplates/0/',
  ),
  './gy/component/users_all_tables/teplates/0/template.php' => 
  array (
    'CODE' => '<?php if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );?>

<h1><?=$this->lang->getMessage(\'title\');?></h1>

<?php if (!empty($arRes[\'del-stat\'])) {?>
    <?php if ($arRes[\'del-stat\'] == \'ok\') { ?>
        <div class="gy-admin-good-message"><?=$this->lang->getMessage(\'del-ok\');?></div>
        <br/>
    <?php }?>

    <?php if ($arRes[\'del-stat\'] == \'err\') {?>
        <div class="gy-admin-error-message"><?=$this->lang->getMessage(\'del-err\');?></div>
        <br/>
    <?php }?>
    <a href="users.php" class="gy-admin-button"><?=$this->lang->getMessage(\'ok\');?></a>
<?php } else {?>

    <?php if ($arRes[\'allUsers\']) {?>
        <table border="1" class="gy-table-all-users">
            <tr><th>id</th><th>login</th><th>name</th><th>group</th><th></th></tr>

                <?php foreach ($arRes[\'allUsers\'] as $key => $val) {?>
                    <tr>
                        <td><?=$val[\'id\'];?></td>
                        <td><?=$val[\'login\'];?></td>
                        <td><?=$val[\'name\'];?></td>
                        <td>
                            <?php foreach ($val[\'groups\'] as $groupIs) {?>
                                -
                                <?=$arRes[\'allUsersGroups\'][$groupIs][\'name\'];?>
                                (
                                <?=$arRes[\'allUsersGroups\'][$groupIs][\'code\'];?>
                                );
                                <br/>
                            <?php }?>

                        </td>
                        <td>
                            <?php if ($val[\'id\'] != 1) {?>
                                <br/>
                                <a href="users.php?del-id=<?=$val[\'id\'];?>" class="gy-admin-button"><?=$this->lang->getMessage(\'del-user\');?></a>
                                <a href="edit-user.php?edit-id=<?=$val[\'id\'];?>" class="gy-admin-button"><?=$this->lang->getMessage(\'edit-user\');?></a>
                                <a href="?show-id=<?=$val[\'id\'];?>" class="gy-admin-button"><?=$this->lang->getMessage(\'show-user\');?></a> <?// TODO ?>
                                <br/>
                                <br/>
                            <?php } ?>
                        </td>
                    </tr>
                <?php }?>

        </table>

        <br/>
        <br/>
        <a class="gy-admin-button" href="add-user.php"><?=$this->lang->getMessage(\'add-user\');?></a>
        <br/>
        <br/>
        <br>
        <br>
        <a href="group-user.php" class="gy-admin-button"><?=$this->lang->getMessage(\'options-groups\');?></a> 
        <br/>
        <br/>
        <br/>
        <br/>
        <a href="edit-all-users-propertys.php" class="gy-admin-button"><?=$this->lang->getMessage(\'list-all-user-propertys\');?></a>
    <?php }?>
<?php }?>
        ',
    'TYPE' => 'php',
    'DIR' => './gy/component/users_all_tables/teplates/0/',
  ),
  './gy/component/users_group_manager/componentInfo.php' => 
  array (
    'CODE' => '<?php
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

use Gy\\Core\\Lang;

global $APP;
$utlThisComponent = "/gy/component/users_group_manager/";
$langComponentInfo = new Lang($APP->urlProject.$utlThisComponent, \'componentInfo\', $APP->options[\'lang\']);

$componentInfo = array(
    \'name\' => \'users_group_manager\',
    \'text-info\' => $langComponentInfo->getMessage(\'text-info\'),
    \'v\' => \'0.1\',
    \'all-property\' => array()
);',
    'TYPE' => 'php',
    'DIR' => './gy/component/users_group_manager/',
  ),
  './gy/component/users_group_manager/controller.php' => 
  array (
    'CODE' => '<?php 
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

$arRes = array();
$data = $_REQUEST;

// добавить новую группу если добавляется новая
if ( !empty($data[\'add-group-name\'])
    && !empty( $data[\'add-group-code\'])
    && !empty( $data[\'add-group-text\'])
    && !empty( $data[\'groupsActions\'][\'add-group-action-user\'])
) {

    $res = Gy\\Core\\User\\AccessUserGroup::addUserGroup(
        array(
            \'code\' => $data[\'add-group-code\'],
            \'text\' => $data[\'add-group-text\'],
            \'name\' => $data[\'add-group-name\']
        ),
        $data[\'groupsActions\'][\'add-group-action-user\']
    );
    unset($data[\'groupsActions\'][\'add-group-action-user\']);
}

// удалить группы, отмеченные для удаления
if (!empty($data[\'delete\'])) {
    foreach ($data[\'delete\'] as $codeDeleteGroup => $val) {
        Gy\\Core\\User\\AccessUserGroup::deleteUserGroupByCode($codeDeleteGroup);
    }
}

// взять все группы пользователей
$arRes[\'allUsersGroups\'] = Gy\\Core\\User\\AccessUserGroup::getAccessGroup();

// взять все дефствия поьзователей 
$arRes[\'allActionUser\'] = Gy\\Core\\User\\AccessUserGroup::getUserAction();

// коды групп пользователей которые даны по умолчанию (их нельзя будет удалять)
$standartGroup = array(
    \'admins\',
    \'content\',
    \'user_admin\'
);
foreach ($arRes[\'allUsersGroups\'] as $key => $value) {
    if (!in_array($value[\'code\'], $standartGroup)) {
        $arRes[\'allUsersGroups\'][$key][\'flag_del\'] = \'Y\'; // флаг что можно удалить группу
    }
}

global $USER;

// надо убрать админа из списка что бы права нельзя было менять никому
unset($data[\'groupsActions\'][\'admins\']);

if (!empty($data[\'button-form\'])
    && ($data[\'button-form\'] == \'Сохранить\')
    && $USER->isAdmin() // TODO пока только админы могут это делать
    && !empty($data[\'groupsActions\'])
) { // нужно сохранить новые настроки прав
    foreach ($data[\'groupsActions\'] as $key => $listActionUser) {
        // удалить все настройки для определённой группы
        Gy\\Core\\User\\AccessUserGroup::deleteAllActionsForGroup($key);
        
        foreach ($listActionUser as $nameActionsUser) {
            Gy\\Core\\User\\AccessUserGroup::addOptionsGroup($key, $nameActionsUser);
        }
    }
    $arRes[\'status\'] = \'ok\';
} elseif (!empty($data[\'button-form\'])) {
    $arRes[\'status\'] = \'add-err\';
}

// показать шаблон
$this->template->show($arRes, $this->arParam);
',
    'TYPE' => 'php',
    'DIR' => './gy/component/users_group_manager/',
  ),
  './gy/component/users_group_manager/lang_componentInfo.php' => 
  array (
    'CODE' => '<?php // языковой файл для componentInfo.php
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

$mess[\'rus\'] = array(
    \'text-info\' => \'Пользовательские группы и их права\',
);

$mess[\'eng\'] = array(
    \'text-info\' => \'User groups and their rights\',
);',
    'TYPE' => 'php',
    'DIR' => './gy/component/users_group_manager/',
  ),
  './gy/component/users_group_manager/teplates/0/lang_template.php' => 
  array (
    'CODE' => '<?php // языковой файл для шаблона компонента
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

$mess[\'rus\'] = array(
    \'title\' => \'Настройка групп прав доступа\',
    \'back\' => \'Отмена\',
    \'save\' => \'Сохранить\',
    \'text-ok\' => \'Настройки успешно сохранены\',
    \'text-er\' => \'! Произошла ошибка, попробуйте ещё раз\',
    \'button-text-ok\' => \'Ок\',
    \'groups\' => \'Группы\',
    \'actions\' => \'Действия пользователей которые разрешены для данной группы\',
    \'title-add-group\' => \'Добавить новую группу\',
    \'text\' => \'Описание\',
    \'delete\' => \'Удалить\'
);

$mess[\'eng\'] = array(
    \'title\' => \'Setting up access rights groups\',
    \'back\' => \'Cancel\',
    \'save\' => \'Save\',
    \'text-ok\' => \'Settings saved successfully\',
    \'text-er\' => \'! An error occured, please try again\',
    \'button-text-ok\' => \'Ok\',
    \'groups\' => \'Groups\',
    \'actions\' => \'User actions that are allowed for this group\',
    \'title-add-group\' => \'Add new group\',
    \'text\' => \'Description\',
    \'delete\' => \'Delete\'
);

',
    'TYPE' => 'php',
    'DIR' => './gy/component/users_group_manager/teplates/0/',
  ),
  './gy/component/users_group_manager/teplates/0/template.php' => 
  array (
    'CODE' => '<?php 
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

if (!empty($arRes["allUsersGroups"]) && !empty($arRes["allActionUser"])) {?>

    <?php if (empty($arRes[\'status\'])) {?>

        <h1><?=$this->lang->getMessage(\'title\');?></h1>
        <form method="post">
            <table border="1" class="gy-table-all-users">
                <tr>
                    <th><?=$this->lang->getMessage(\'groups\');?></th>
                    <th><?=$this->lang->getMessage(\'text\');?></th>
                    <th><?=$this->lang->getMessage(\'actions\');?></th>
                    <th></th>
                </tr>
                <?php foreach ($arRes[\'allUsersGroups\'] as $val) {?>
                    <tr>
                        
                        <td><?=$val[\'name\']?>(<?=$val[\'code\']?>)</td>
                        <td><?=$val[\'text\']?></td>
                        <td>
                            <select <?=(($val[\'code\'] == \'admins\')? \'disabled\': \'\');?> multiple="" name="groupsActions[<?=$val[\'code\']?>][]">
                                <?php foreach ($arRes[\'allActionUser\'] as $userActions) {?>
                                    <option 
                                        value="<?=$userActions[\'code\']?>" 
                                        <?=((!empty($val[\'code_action_user\'][$userActions[\'code\']]))? \'selected\' : \'\')?> 
                                    >
                                        <?=$userActions[\'text\']?>(<?=$userActions[\'code\']?>)
                                    </option>
                                <?php }?>
                            </select>
                        </td>
                        <td> 
                            <?php if (!empty($val[\'flag_del\']) && ($val[\'flag_del\'] == \'Y\')) {?> 
                                <input type="checkbox" name="delete[<?=$val[\'code\']?>]" /><?=$this->lang->getMessage(\'delete\');?> 
                            <?php }?>
                        </td>
                    </tr>
                <?php }?>
                <tr>
                    <td colspan="4"><b><?=$this->lang->getMessage(\'title-add-group\');?></b></td>
                </tr>
                <tr>
                    <td>
                        Название:<input type="text" name="add-group-name" />
                        <br/>
                        (код:<input type="text" name="add-group-code" />)
                    </td>
                    <td>описание:<input type="text" name="add-group-text" /></td>
                    <td>
                        <select multiple="" name="groupsActions[add-group-action-user][]">
                            <?php foreach ($arRes[\'allActionUser\'] as $userActions) {?>
                                <option value="<?=$userActions[\'code\']?>" >
                                    <?=$userActions[\'text\']?>(<?=$userActions[\'code\']?>)
                                </option>
                            <?php }?>
                        </select>
                    </td>
                    <td></td>
                    
                </tr>
            </table> 

            <input type="submit" name="button-form" class="gy-admin-button" value="<?=$this->lang->getMessage(\'save\');?>" />
        </form>    
        <br/>
        <a href="" class="gy-admin-button"><?=$this->lang->getMessage(\'back\');?></a>
        <br/>
        <br/>
        <br/>
    <?php }?>
   
    <?php if (!empty($arRes[\'status\'])) {?>    
        <?php if ($arRes[\'status\'] == \'ok\') {?>
            <div class="gy-admin-good-message"><?=$this->lang->getMessage(\'text-ok\');?></div>
            <br/>
            <a href="/gy/admin/group-user.php" class="gy-admin-button"><?=$this->lang->getMessage(\'button-text-ok\');?></a>
        <?php } ?>

        <?php if ($arRes[\'status\'] == \'add-err\') {?>
            <div class="gy-admin-error-message"><?=$this->lang->getMessage(\'text-err\');?></div>
            <br/>
            <a href="/gy/admin/group-user.php" class="gy-admin-button"><?=$this->lang->getMessage(\'button-text-ok\');?></a>
        <?php } ?>
    <?php }?>

<?php }',
    'TYPE' => 'php',
    'DIR' => './gy/component/users_group_manager/teplates/0/',
  ),
  './gy/config/gy_config.php' => 
  array (
    'CODE' => '<?php 

if (!defined("GY_CORE") && GY_CORE !== true ) die("err_core");


$gyConfig = array(
    "lang" => "rus",
    "sole" => "pass1021asz#_@)A",
    "db_config" => array(
       \'db_type\' => \'MySql\', 
        \'db_host\' => \'localhost\',
        \'db_user\' => \'root\', // заменить на настоящего пользователя // replace by true user 
        \'db_pass\' => \'\', 
        \'db_name\' => \'gy_db\',
        \'db_port\' => \'31006\',
    ),
    "type_cache" => "CacheFiles",
    "v-gy" => "0.2-alpha",
    "404" => "/404.php",
);
',
    'TYPE' => 'php',
    'DIR' => './gy/config/',
  ),
  './gy/gy.php' => 
  array (
    'CODE' => '<?php

use Gy\\Core\\App;
use Gy\\Core\\Security;
use Gy\\Core\\Crypto;
use Gy\\Core\\Module;
use Gy\\Core\\User\\User;

// если ядро не подключено подключаем всё а если уже подключено то не надо
if ( !defined("GY_CORE") ) {

    ob_start();
    define("GY_CORE", true); // флаг о том что ядро подключено // flag include core

    include_once("config/gy_config.php"); // подключение настроек ядра // include options

    if (in_array($gyConfig[\'lang\'], array(\'rus\', \'eng\'))) {
        global $LANG;
        $LANG = $gyConfig[\'lang\'];
    }

    // путь к проекту
    global $URL_PROJECT;
    $URL_PROJECT = substr(__DIR__, 0, (strlen(__DIR__) - 3) );
    
    // авто подключение классов // кроме подключения классов модулей используется psr0
    function autoload($className)
    {
        //   1. для модулей завести пространство имён типа Gy\\Modules\\<имя модуля>\\Classes\\<имя класса>
        //   2. потом подключать вначале customDir/vendor
        //   3. уже потом из раздела gy/classes
  
        global $URL_PROJECT;
        
        // из пространства имён составляю путь к классу
        $className = ltrim($className, \'\\\\\');
        $fileName  = \'\';
        $namespace = \'\';
        if ($lastNsPos = strrpos($className, \'\\\\\')) {
            $namespace = substr($className, 0, $lastNsPos);
            $className = substr($className, $lastNsPos + 1);
            $fileName  = str_replace(\'\\\\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
        }
        $fileName .= str_replace(\'_\', DIRECTORY_SEPARATOR, $className) . \'.php\';

        // определяю является ли путь и вызываемый класс, классом модуля,
        //   если так то подключаю класс модуля 
        //   пространство имён будет: Gy\\Modules\\<имя модуля>\\Classes\\<имя класса>
        
        // условие регулярки для такого пространства имён 
        $br = preg_quote(DIRECTORY_SEPARATOR);
        $pattern = "#^(Gy".$br."Modules".$br.")(.*)(".$br."Classes".$br.")(.*).php#";
              
        //var_dump(  "#^Gy".DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR."Modules".DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR."#" );
        $parseUrl = array(); // тут результат парсинга
        
        if (preg_match( $pattern, $fileName, $parseUrl) == 1) {
            //$parseUrl[2] - тут имя модуля
            //$parseUrl[4] - Тут имя класса
            
            // TODO можно было бы подключить конкретный модуль но пока оставлю старую механику 
            //   (когда подключаются все сразу)
            
            // проверю есть ли класс в подключённых модулях и подключу (в модулях psr0 нет)
            $module = Module::getInstance();
            $meyByClassModule = $module->getUrlModuleClassByNameClass($parseUrl[4]);
            if ($meyByClassModule !== false) {
                require_once( $meyByClassModule );
            } else {
                //die(\'!Error class \'.$className.\' not found\'); 
            }
        } elseif (file_exists($URL_PROJECT.DIRECTORY_SEPARATOR.\'customDir\'.DIRECTORY_SEPARATOR.\'classes/\'.DIRECTORY_SEPARATOR.$fileName)) {
            // иначе, если не класс модуля, ищу класс в разделе для кастомных (пользовательских) классов
            require_once $URL_PROJECT.DIRECTORY_SEPARATOR.\'customDir\'.DIRECTORY_SEPARATOR.\'classes/\'.DIRECTORY_SEPARATOR.$fileName;
        } elseif (file_exists($URL_PROJECT.DIRECTORY_SEPARATOR.\'gy/classes\'.DIRECTORY_SEPARATOR.$fileName)) { 
            // иначе ищу класс в классах gy
            require_once \'classes\'.DIRECTORY_SEPARATOR.$fileName;
        }

    }
    spl_autoload_register(\'autoload\');
      
    // подключить модули (пока сразу все)
    $module = Module::getInstance();
    $module->setUrlGyCore(__DIR__);
    //$module->includeModule(\'containerdata\'); - так подключается конкретный модуль
    $module->includeAllModules();
    
    // обезопасить получаемый конфиг
    $gyConfig = Security::filterInputData($gyConfig);

    global $APP;
    // добавлю версию ядра gy
    $gyConfig[\'v-gy\'] = \'0.2-alpha\';
    $APP = App::createApp($URL_PROJECT, $gyConfig);
    unset($gyConfig);

    // подключить класс работы с базой данный // include class work database
    if (isset($APP->options[\'db_config\'])
        && isset($APP->options[\'db_config\'][\'db_type\'])
        && isset($APP->options[\'db_config\'][\'db_host\'])
        && isset($APP->options[\'db_config\'][\'db_user\'])
        && isset($APP->options[\'db_config\'][\'db_pass\'])
        && isset($APP->options[\'db_config\'][\'db_name\'])
    ) {
        global $DB;
        
        if ($APP->options[\'db_config\'][\'db_type\'] == \'MySql\') {
            $DB = new Gy\\Core\\Db\\MySql($APP->options[\'db_config\']); 
        } elseif ($APP->options[\'db_config\'][\'db_type\'] == \'PgSql\') {
            $DB = new Gy\\Core\\Db\\PgSql($APP->options[\'db_config\']); 
        } elseif ($APP->options[\'db_config\'][\'db_type\'] == \'PhpFileSqlClientForGy\') {
            $DB = new Gy\\Core\\Db\\PhpFileSqlClientForGy($APP->options[\'db_config\']); 
        }
 
    }   
    
    global $CRYPTO;
    $CRYPTO = new Crypto();
    if (!empty($APP->options[\'sole\'])) {
        $CRYPTO->setSole($APP->options[\'sole\']);
    }

    global $USER;
    $USER = new User();

    // объявить имя класса для кеша // TODO пока так но сделать надо получше (заменить на фабрику или ещё какой патерн)
    if (!isset($APP->options[\'type_cache\'])) {
        $APP->options[\'type_cache\'] = \'cacheFiles\';
    }
    global $CACHE_CLASS_NAME;
    $CACHE_CLASS_NAME = \'Gy\\\\Core\\\\Cache\\\\\'.$APP->options[\'type_cache\'];   

    session_start();

    // нужно обезопасить все входные данные
    // на этой странице не проверять, т.к. там могут сохраняться данные html (своства контейнера данных)
    // TODO - может как то это пофиксить
    if( ($APP->getUrlTisPageNotGetProperty() != \'/gy/admin/get-admin-page.php\')
        && ( !empty($_REQUEST[\'page\']) && ($_REQUEST[\'page\'] != \'container-data-element-property\') )
    ) {
        $_REQUEST = Security::filterInputData($_REQUEST);
        $_GET = Security::filterInputData($_GET);
        $_POST = Security::filterInputData($_POST);
    }

    
    // подключаю customDir/gy/afterGyCore.php если он есть, тут можно кастомное дописать 
    //   или обьявить psr4 автозакрузку классов из любой желаемой директории
    if (file_exists($URL_PROJECT.DIRECTORY_SEPARATOR.\'customDir\'.DIRECTORY_SEPARATOR.\'gy\'.DIRECTORY_SEPARATOR.\'afterGyCore.php\')) {
        require_once $URL_PROJECT.DIRECTORY_SEPARATOR.\'customDir\'.DIRECTORY_SEPARATOR.\'gy\'.DIRECTORY_SEPARATOR.\'afterGyCore.php\';
    }

}

',
    'TYPE' => 'php',
    'DIR' => './gy/',
  ),
  './gy/images/fon.png' => 
  array (
    'CODE' => '�PNG

' . "\0" . '' . "\0" . '' . "\0" . 'IHDR' . "\0" . '' . "\0" . '' . "\0" . '' . "\0" . '' . "\0" . '' . "\0" . '' . "\0" . '' . "\0" . '' . "\0" . 'ש��' . "\0" . '' . "\0" . '' . "\0" . 'tEXtSoftware' . "\0" . 'Adobe ImageReadyq�e<' . "\0" . '' . "\0" . ' iTXtXML:com.adobe.xmp' . "\0" . '' . "\0" . '' . "\0" . '' . "\0" . '' . "\0" . '<?xpacket begin="﻿" id="W5M0MpCehiHzreSzNTczkc9d"?> <x:xmpmeta xmlns:x="adobe:ns:meta/" x:xmptk="Adobe XMP Core 5.0-c060 61.134777, 2010/02/12-17:32:00        "> <rdf:RDF xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"> <rdf:Description rdf:about="" xmlns:xmp="http://ns.adobe.com/xap/1.0/" xmlns:xmpMM="http://ns.adobe.com/xap/1.0/mm/" xmlns:stRef="http://ns.adobe.com/xap/1.0/sType/ResourceRef#" xmp:CreatorTool="Adobe Photoshop CS5 Windows" xmpMM:InstanceID="xmp.iid:0F0274D29CFD11EA92E7AE773D58B7DC" xmpMM:DocumentID="xmp.did:0F0274D39CFD11EA92E7AE773D58B7DC"> <xmpMM:DerivedFrom stRef:instanceID="xmp.iid:0F0274D09CFD11EA92E7AE773D58B7DC" stRef:documentID="xmp.did:0F0274D19CFD11EA92E7AE773D58B7DC"/> </rdf:Description> </rdf:RDF> </x:xmpmeta> <?xpacket end="r"?>�1	L' . "\0" . '' . "\0" . '' . "\0" . 'PLTE������:���' . "\0" . '' . "\0" . '' . "\0" . 'tRNS�' . "\0" . '�0J' . "\0" . '' . "\0" . '' . "\0" . '%IDATx�b`ddd``�$p�32��jb�)9�!�*�' . "\0" . '' . "\0" . 'S�!�b��' . "\0" . '' . "\0" . '' . "\0" . '' . "\0" . 'IEND�B`�',
    'TYPE' => 'png',
    'DIR' => './gy/images/',
  ),
  './gy/index.php' => 
  array (
    'CODE' => '<?php
header(\'Location: /gy/admin\');
',
    'TYPE' => 'php',
    'DIR' => './gy/',
  ),
  './gy/install/consoleInstallOptions.php' => 
  array (
    'CODE' => '<?php

global $argv;
$isRunConsole = isset($argv);
global $BR;
$BR = "\\n";

//print_r($argv);

function showHelpFromInstall(){
    global $BR;
    echo $BR."This script set options for gy framework".$BR;
    echo "===================================".$BR;
    echo ">php -f consoleInstallOptions.php <options>".$BR;
    echo $BR;
    echo "options:".$BR;
    echo "    help  - show help this script".$BR;
    echo "    set-all <array options> - set all options (clear options if not input)".$BR;
    echo "    set-option <array options> - set options (save old options if not input)".$BR;
    echo $BR;
    echo "  example: php -f consoleInstallOptions.php set-all sole 111 db_type mysql".$BR;
    echo "  example: php -f consoleInstallOptions.php set-option sole 111 db_type mysql".$BR;
    echo "  example: php -f consoleInstallOptions.php help".$BR;
    echo $BR;
    echo $BR;
    echo $BR;
}


function parseOprions($optionsFromConsole){
    $arOptions = array();
    for ($i = 2; $i < (count($optionsFromConsole)-1); $i = $i+2) {
        if (empty($optionsFromConsole[$i+1])) {
            $optionsFromConsole[$i+1] = \'\';
        }

        if ($optionsFromConsole[$i+1] == \'***\') {
            $optionsFromConsole[$i+1] = \'\';
        }

        if (strripos($optionsFromConsole[$i], \'db\') !== false) {
            $arOptions[\'db_config\'][$optionsFromConsole[$i]] = $optionsFromConsole[$i+1];

        } else {
            $arOptions[$optionsFromConsole[$i]] = $optionsFromConsole[$i+1];
        }
    }

    return $arOptions;
}

function createTextForFileCofig($options){
    global $BR;
    $fileText = \'\';

    if (!empty($options)) {

        $fileText = \'<?php \'.$BR.\'
if (!defined("GY_CORE") && GY_CORE !== true ) die("err_core");\'.$BR.\'

$gyConfig = array(\'.$BR;

        foreach ($options as $key => $val) {

            if (!is_array($val)) {
                $fileText .= \'    "\'.$key.\'" => "\'.$val.\'",\'.$BR;
            } else {
                $fileText .= \'    "\'.$key.\'" => array(\'.$BR;
                foreach ($val as $key2 => $val2) {
                    $fileText .= \'        "\'.$key2.\'" => "\'.$val2.\'",\'.$BR;
                }
                $fileText .= \'    ),\'.$BR;
            }

        }
        $fileText .= \');\'.$BR;
    }

    return $fileText;
}

if ($isRunConsole) { // пока запускать только из консоли
    if (empty($argv[1]) || ($argv[1] == \'help\')) {
        showHelpFromInstall();
    } elseif ($argv[1] == \'set-all\') {
        echo \'run set-all\'.$BR;

        $options = parseOprions($argv);

        if (!empty($options)) {
            $file = fopen(__DIR__.\'/../config/gy_config.php\', \'w\');
            fwrite($file, createTextForFileCofig($options) );
            fclose($file);
        }
        echo \'finish set-all\'.$BR;

    } elseif ($argv[1] == \'set-option\') {
        echo \'run set-option\'.$BR;
        $options = parseOprions($argv);

        include __DIR__."/../gy.php";
        $oldOptions = $APP->options;

        //print_r($oldOptions);

        foreach ($options as $key => $val) {
            if (is_array($val)) {
                //$tempArr = $oldOptions[$key];
                foreach ($val as $key2 => $val2) {
                    $oldOptions[$key][$key2] = $val2;
                }
            } else {
                $oldOptions[$key] = $val;
            }
        }

        if (!empty($oldOptions)) {
            $file = fopen(__DIR__.\'/../config/gy_config.php\', \'w\');
            fwrite($file, createTextForFileCofig($oldOptions) );
            fclose($file);
        }
        echo \'finish set-option\'.$BR;

    }

} else {
    echo \'! Error. You need to run the script in the console\';

}
',
    'TYPE' => 'php',
    'DIR' => './gy/install/',
  ),
  './gy/install/installDataBaseTable.php' => 
  array (
    'CODE' => '<?php
// TODO проверку на ошибки переделать с учётом установки на пострис

global $argv;
$isRunConsole = isset($argv);
$BR = "\\n";

if ($isRunConsole) {

    include __DIR__."/../gy.php"; // подключить ядро // include core

    echo $BR.\'-----install gy core taldes db-----\';
    echo $BR.\'install user table = start\';

    global $DB;

    $res = $DB->createTable(
        \'users\',
        array( 
            \'id int PRIMARY KEY AUTO_INCREMENT\',
            \'login varchar(50)\',
            \'name varchar(50)\',
            \'pass varchar(50)\',
            \'hash_auth varchar(50)\',
            //\'groups int\'
        )
    );

   // if ($res === true){
        echo $BR.\'install user table = OK!\';

        echo $BR.\'add admin user (and test user) = start\';

        $res = $DB->insertDb(
            \'users\',
            array(
                \'login\' => \'admin\',
                \'name\' => \'admin\',
                \'pass\' =>   \'admin\',
                //\'groups\' => 1
            )
        );

        $res = $DB->insertDb(
            \'users\',
            array(
                \'login\' => \'asd\',
                \'name\' => \'asd\',
                \'pass\' =>  \'asdasd\',
                //\'groups\' => 2
            )
        );

//        if($res === true){
            echo $BR.\'add admin user = OK!\';
//        }else{
//            echo $BR.\'add admin user = ERROR!\';
//        }
//    }else{
//        echo $BR.\'install user table = ERROR!\';
//    }

    // задать группы прав доступа и действия разрешаемые для пользователей групп
    echo $BR.\'install access users = start\';
    
    // это действия пользователей к которые можно указать для группы пользователей
    //  суда нужно добавлять новые при появление нового в админке и прочего (модули если будут сделаны в этой версии)
    $res = $DB->createTable(
        \'action_user\',
        array(
            \'id int PRIMARY KEY AUTO_INCREMENT\',
            \'code varchar(255)\',
            \'text varchar(255)\',
        )
    );


    $DB->insertDb(
        \'action_user\',
        array(
            \'code\' => \'show_admin_panel\',
            \'text\' => \'Просматривать админку | View admin panel\',
        )
    );

    $DB->insertDb(
        \'action_user\',
        array(
            \'code\' => \'action_all\',
            \'text\' => \'Редактировать всё (Админ) | Edit All (Admin)\',
        )
    );

    $DB->insertDb(
        \'action_user\',
        array(
            \'code\' => \'edit_users\',
            \'text\' => \'Изменение пользователей (кроме админов) | Edit users (except admins)\',
        )
    );


    echo $BR.\'install access users = OK!\';

    echo $BR.\'install user groups (add action user) = start\';
    // это группы (пользователей) прав доступа
    $res = $DB->createTable(
        \'access_group\',
        array(
            \'id int PRIMARY KEY AUTO_INCREMENT\',
            \'code varchar(255)\',
            \'name varchar(255)\',
            \'text varchar(255)\',
            \'code_action_user varchar(255)\' // код действия пользователя, разрешённый для данной группы
        )
    );

    $DB->insertDb(
        \'access_group\',
        array(
            \'code\' => \'admins\',
            \'name\' => \'Админы | Admins\',
            \'text\' => \'Админы, есть права на всё | Admins, have rights to everything\',
            \'code_action_user\' => \'action_all\'
        )
    );
    $DB->insertDb(
        \'access_group\',
        array(
            \'code\' => \'admins\',
            \'name\' => \'Админы | Admins\',
            \'text\' => \'Админы, есть права на всё | Admins, have rights to everything\',
            \'code_action_user\' => \'show_admin_panel\'
        )
    );

    $DB->insertDb(
        \'access_group\',
        array(
            \'code\' => \'content\',
            \'name\' => \'Контент | Content\',
            \'text\' => \'Те кто изменяют контент сайта | Those who change the content of the site\',
            \'code_action_user\' => \'show_admin_panel\'
        )
    );

    $DB->insertDb(
        \'access_group\',
        array(
            \'code\' => \'user_admin\',
            \'name\' => \'Админи по пользователям | Admin for users\',
            \'text\' => \'Могут изменять только пользователей | Can change users\',
            \'code_action_user\' => \'edit_users\'
        )
    );
    $DB->insertDb(
        \'access_group\',
        array(
            \'code\' => \'user_admin\',
            \'name\' => \'Админи по пользователям | Admin for users\',
            \'text\' => \'Могут изменять только пользователей | Can change users\',
            \'code_action_user\' => \'show_admin_panel\'
        )
    );

    echo $BR.\'install user groups = OK!\';

    echo $BR.\'add users in user groups = start\';
    // в этой таблице будут группы и относящиеся к ним пользователи
    $res = $DB->createTable(
        \'users_in_groups\',
        array(
            \'id int PRIMARY KEY AUTO_INCREMENT\',
            \'code_group varchar(255)\',
            \'id_user int\',
        )
    );



    $DB->insertDb(
        \'users_in_groups\',
        array(
            \'code_group\' => \'admins\',
            \'id_user\' => 1,
        )
    );

    $DB->insertDb(
        \'users_in_groups\',
        array(
            \'code_group\' => \'user_admin\',
            \'id_user\' => 2,
        )
    );

    echo $BR.\'add users in user groups = OK\';

    // общие свойства для пользователей
    echo $BR.\'install all users propertys = start\';
    // таблица с общими свойствами (список общих свойств для всех пользователей)
    $res = $DB->createTable(
        \'create_all_users_property\',
        array(
            \'id int PRIMARY KEY AUTO_INCREMENT\',
            \'name_property varchar(255)\',
            \'type_property int\',
            \'code varchar(255)\',
        )
    );

    // типы общих свойств для пользователей
    $res = $DB->createTable(
        \'type_all_user_propertys\',
        array(
            \'id int PRIMARY KEY AUTO_INCREMENT\',
            \'name_type varchar(255)\',
            \'info varchar(255)\',
            \'code varchar(255)\',
        )
    );

    $DB->insertDb(
        \'type_all_user_propertys\',
        array(
            \'name_type\' => \'text\',
            \'info\' => \'input type text\',
            \'code\' => \'text\',
        )
    );

    // значения общего свойства типа текст
    $res = $DB->createTable(
        \'value_all_user_propertys_text\',
        array(
            \'id int PRIMARY KEY AUTO_INCREMENT\',
            \'value varchar(255)\',
            \'id_users int\',
            \'id_property int\',
        )
    );

    echo $BR.\'install all users propertys = OK\';

    echo $BR.\'install all modules db = start\';

    // теперь установка частей БД относящихся к модулям
    $module = Gy\\Core\\Module::getInstance();
    $module->installBdAllModules();

    echo $BR.\'install all modules db = OK!\';

    echo $BR.\'-----install gy core taldes db = OK!-----\'.$BR;

} else {
    echo \'! Error. You need to run the script in the console\';

}',
    'TYPE' => 'php',
    'DIR' => './gy/install/',
  ),
  './gy/install/installDemoSite1.php' => 
  array (
    'CODE' => '<?php
/**
 * Скрипт установит демо сайт 
 * 
 */

global $argv;
$isRunConsole = isset($argv);
$br = "\\n";

if ($isRunConsole) {
    if ($argv[1] == \'start\') {

        if (!file_exists(__DIR__.\'/../../index.php\')) {

            define("GY_CORE", true); // хак
            include(__DIR__.\'/../../gy/config/gy_config.php\'); // подключение настроек ядра // include options
            if (!empty($gyConfig[\'lang\']) && in_array($gyConfig[\'lang\'], array(\'rus\', \'eng\'))) {
                $lang = $gyConfig[\'lang\'];
            } else {
                $lang = \'rus\';
            }

            // записать основную страницу
            file_put_contents(__DIR__.\'/../../index.php\', getCodeByUrlPage(\'index.php\', $lang));

            mkdir(__DIR__.\'/../../customDir/component/containerdata_element_show/teplates/0/\', 0755, true);
            mkdir(__DIR__.\'/../../customDir/classes/\', 0755, true);

            // записать файлы /customDir
            file_put_contents(__DIR__.\'/../../customDir\\component\\containerdata_element_show\\teplates\\0\\template.php\', getCodeByUrlPage(\'customDir\\component\\containerdata_element_show\\teplates\\0\\template.php\', $lang));
            file_put_contents(__DIR__.\'/../../customDir\\component\\containerdata_element_show\\teplates\\0\\style.css\', getCodeByUrlPage(\'customDir\\component\\containerdata_element_show\\teplates\\0\\style.css\', $lang));
            file_put_contents(__DIR__.\'/../../customDir\\component\\containerdata_element_show\\teplates\\0\\lang_template.php\', getCodeByUrlPage(\'customDir\\component\\containerdata_element_show\\teplates\\0\\lang_template.php\', $lang));

            echo \'Install = OK!\';
        } else {
            echo \'! Did not install. The main page file already exists.\';
        }
    } else {
        echo $br.\'This script will install demo data and one title page. Demo site 1.\';
        echo $br.\'To start the installation, enter the start parameter when invoking the script in the console.\';
        echo $br.\'!!! Carefully the script can destroy the main page and the customDir directory !!!\';
    }
} else {
    echo \'! Error. You need to run the script in the console\';
}

function getCodeByUrlPage($page, $lang){
    $arLang = array(
        \'rus\' => array(
            \'html-title\' => \'Пример использования gy CMS/framework\',
            \'title-show-component\' => \'Вызов компонента\',
            \'title-run-component\' => \'Вызов компонента\',
        ),
        \'eng\' => array(
            \'html-title\' => \'Usage example gy CMS/framework\',
            \'title-show-component\' => \'Component launch\',
            \'title-run-component\' => \'Component launch\',
        )
    );

    $arrayCodeByUrl = array(
        \'index.php\' => \'<?php include $_SERVER["DOCUMENT_ROOT"]."/gy/gy.php"; // подключить ядро // include core 

            $APP->component(
                \\\'header\\\',
                \\\'0\\\',
                array(
                    \\\'seo-meta-tag-head\\\' => array(
                        \\\'title\\\' => \\\'Gy - framework/CMS, demo site 1\\\',
                        \\\'descriptions\\\' => \\\'Test text gy - framework/CMS demo site 1 meta descriptions\\\',
                        \\\'keywords\\\' => \\\'gy, framework, CMS, demo, site, site 1\\\'
                    ) 
                )
            );

            $APP->component(
                \\\'admin-button-public-site\\\',
                \\\'0\\\',
                array()
            );

            $APP->component(
                \\\'includeHtml\\\',
                \\\'0\\\',
                array(
                    \\\'html\\\' => \\\'<h1>\'.$arLang[$lang][\'html-title\'].\'</h1>\\\'
                )
            );

            // пример вызова одинаковых компонентов // example run two component 
            $APP->component(
                \\\'includeHtml\\\',
                \\\'0\\\',
                array(
                    \\\'html\\\' => \\\'<h4>\'.$arLang[$lang][\'title-show-component\'].\' "form_auth_test" (№ 1)</h4>\\\'
                )
            );

            $APP->component(
                \\\'form_auth_test\\\',
                \\\'0\\\',
                array( 
                    \\\'test\\\' => \\\'asd\\\',
                    \\\'idComponent\\\' => 1,
                )
            );

             // пример вызова одинаковых компонентов // example run two component 
            $APP->component(
                \\\'includeHtml\\\',
                \\\'0\\\',
                array(
                    \\\'html\\\' => \\\'<h4>\'.$arLang[$lang][\'title-run-component\'].\' "form_auth_test" (№ 2)</h4>\\\'
                )
            );

            $APP->component(
                \\\'form_auth_test\\\',
                \\\'0\\\',
                array( 
                    \\\'test\\\' => \\\'asd2\\\',
                    \\\'idComponent\\\' => 2,
                )
            );

            /**
            пример вызова компонента с выводом контента,
              + пример использования кастомного (пользовательского) шаблона компонента
              (пользователя - разработчика использующего gy)
            */
            $APP->component(
                \\\'containerdata_element_show\\\',
                \\\'0\\\',
                array( 
                    \\\'container-data-code\\\' => \\\'Content\\\',
                    \\\'element-code\\\' => \\\'html-index-page\\\',
                    \\\'cacheTime\\\' => 86400 // закешить на 24 ч.
                )
            );

            $APP->component(
                \\\'footer\\\',
                \\\'0\\\',
                array()
            );

        \',
        \'customDir\\component\\containerdata_element_show\\teplates\\0\\template.php\' => \'<?php if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );?>

<div class="user_custom_div">
    
    <?php if(!empty($arRes[\\\'ITEMS\\\'])){?>
        <?php  foreach ($arRes[\\\'ITEMS\\\'] as $value) { ?>
            <?=((!empty($value[\\\'value\\\']))? $value[\\\'value\\\'] : \\\'\\\');?>
        <?php }?> 
    <?php }?>    
    
    <br/>(<?=$this->lang->getMessage(\\\'add-custom-text\\\');?>)
      
</div>\',
        \'customDir\\component\\containerdata_element_show\\teplates\\0\\style.css\' => \'.user_custom_div{
    background-color: #21a2ff; 
    color: #05ff07;
}\',
        \'customDir\\component\\containerdata_element_show\\teplates\\0\\lang_template.php\' => \'<?php // языковой файл для шаблона компонента
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

$mess[\\\'rus\\\'] = array(
    \\\'add-custom-text\\\' => \\\'Сейчас запущен кастомный (пользовательский) шаблон компонента\\\'
);

$mess[\\\'eng\\\'] = array(
    \\\'add-custom-text\\\' => \\\'The custom (custom) component template outputs this text to you\\\'
);
\'
    );

    return $arrayCodeByUrl[$page];
}

',
    'TYPE' => 'php',
    'DIR' => './gy/install/',
  ),
  './gy/js/main.js' => 
  array (
    'CODE' => '//$(function(){
//    $(\'.del-user\').click(function(){
//        
//        var button = $(this);
//        var id = $(this).data(\'id-user\')
//        var action = \'user-del\';
//        
//        var url = \'/gy/admin/ajax.php?action=\'+action+\'&id-user=\'+id;
//        
//        if (typeof id != "undefined"){
//            button.hide();
//            $.ajax({
//                url,
//                success: function(res){
//                    result = JSON.parse(res);
//                    if (result[\'stat\'] == \'ok\'){
//                        alert(\'! Пользователь удалён\');
//                        window.location.replace(document.location.href);
//                    } else {
//                        button.show();
//                    }
//                }
//            });
//        }
//    });
//});
',
    'TYPE' => '.js',
    'DIR' => './gy/js/',
  ),
  './gy/lang/lang_component.php' => 
  array (
    'CODE' => '<?php 
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

// TODO нужно убрать этот файл отсюда, это же не класс

$mess[\'rus\'] = array(
    \'err_not_template\' => \'!шаблон не найден\',
    \'err_not_controller\' => \'!!! контроллер компонента не найден\',
    // \'err_not_controller\' => \'\';
);
',
    'TYPE' => 'php',
    'DIR' => './gy/lang/',
  ),
  './gy/modules/containerdata/admin/container-data-add.php' => 
  array (
    'CODE' => '<?php
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

if (Gy\\Core\\User\\AccessUserGroup::accessThisUserByAction( \'show_admin_panel\')) {

    include "../../gy/admin/header-admin.php";

    if (Gy\\Core\\User\\AccessUserGroup::accessThisUserByAction( \'edit_container_data\')) {
        $APP->component(
            \'containerdata_add\',
            \'0\',
            array()
        );
    }

    include "../../gy/admin/footer-admin.php";

} else {
    header( \'Location: /gy/admin/\' );
}',
    'TYPE' => 'php',
    'DIR' => './gy/modules/containerdata/admin/',
  ),
  './gy/modules/containerdata/admin/container-data-edit.php' => 
  array (
    'CODE' => '<?php
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

if (Gy\\Core\\User\\AccessUserGroup::accessThisUserByAction( \'show_admin_panel\')) {

    include "../../gy/admin/header-admin.php";

    if (Gy\\Core\\User\\AccessUserGroup::accessThisUserByAction( \'edit_container_data\') && is_numeric($_GET[\'ID\'])) {
        $id = $_GET[\'ID\'];

        $APP->component(
            \'containerdata_edit\',
            \'0\',
            array(
                \'ID\' => $id
            )
        );

    } else {
        echo \'error not id container-data\';
    }

    include "../../gy/admin/footer-admin.php";

} else {
    header( \'Location: /gy/admin/\' );
}',
    'TYPE' => 'php',
    'DIR' => './gy/modules/containerdata/admin/',
  ),
  './gy/modules/containerdata/admin/container-data-element-list.php' => 
  array (
    'CODE' => '<?php
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

if (Gy\\Core\\User\\AccessUserGroup::accessThisUserByAction( \'show_admin_panel\')) {

    include "../../gy/admin/header-admin.php";

    if (Gy\\Core\\User\\AccessUserGroup::accessThisUserByAction( \'edit_container_data\') && is_numeric($_GET[\'container-data-id\'])) {
        $id = $_GET[\'container-data-id\'];

        $APP->component(
            \'containerdata_element_list\',
            \'0\',
            array(
                \'container-data-id\' => $id
            )
        );

    } else {
        echo \'error not id container-data\';
    }

    include "../../gy/admin/footer-admin.php";

} else {
    header( \'Location: /gy/admin/\' );
}',
    'TYPE' => 'php',
    'DIR' => './gy/modules/containerdata/admin/',
  ),
  './gy/modules/containerdata/admin/container-data-element-property.php' => 
  array (
    'CODE' => '<?php
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

if (Gy\\Core\\User\\AccessUserGroup::accessThisUserByAction( \'show_admin_panel\')) {

    include "../../gy/admin/header-admin.php";

    if (Gy\\Core\\User\\AccessUserGroup::accessThisUserByAction( \'edit_container_data\')) {

        $data = $_GET;

        if ((!empty($data[\'container-data-id\']) && is_numeric($data[\'container-data-id\'])) && (!empty($data[\'el-id\']) && is_numeric($data[\'el-id\']))) {

            $APP->component(
                \'containerdata_element_property\',
                \'0\',
                array(
                    \'container-data-id\' => $data[\'container-data-id\'],
                    \'el-id\' => $data[\'el-id\']
                )
            );

        } else {
            echo \'error not id container-data\';
        }
    }

    include "../../gy/admin/footer-admin.php";

} else {
    header( \'Location: /gy/admin/\' );
}',
    'TYPE' => 'php',
    'DIR' => './gy/modules/containerdata/admin/',
  ),
  './gy/modules/containerdata/admin/container-data-property-edit.php' => 
  array (
    'CODE' => '<?php
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

if (Gy\\Core\\User\\AccessUserGroup::accessThisUserByAction( \'show_admin_panel\')) {

    include "../../gy/admin/header-admin.php";

    if (Gy\\Core\\User\\AccessUserGroup::accessThisUserByAction( \'edit_container_data\') && is_numeric($_GET[\'container-data-id\'])) {
        $id = $_GET[\'container-data-id\'];

        $APP->component(
            \'containerdata_property_edit\',
            \'0\',
            array(
                \'container-data-id\' => $id
            )
        );

    } else {
        echo \'error not id container-data\';
    }

    include "../../gy/admin/footer-admin.php";

} else {
    header( \'Location: /gy/admin/\' );
}',
    'TYPE' => 'php',
    'DIR' => './gy/modules/containerdata/admin/',
  ),
  './gy/modules/containerdata/admin/container-data.php' => 
  array (
    'CODE' => '<?php
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

if (Gy\\Core\\User\\AccessUserGroup::accessThisUserByAction( \'show_admin_panel\')) {

    include "../../gy/admin/header-admin.php";

    if (Gy\\Core\\User\\AccessUserGroup::accessThisUserByAction( \'edit_container_data\')) {

        $APP->component(
            \'containerdata\',
            \'0\',
            array()
        );

    }

    include "../../gy/admin/footer-admin.php";

} else {
    header( \'Location: /gy/admin/\' );
}',
    'TYPE' => 'php',
    'DIR' => './gy/modules/containerdata/admin/',
  ),
  './gy/modules/containerdata/classes/ContainerData.php' => 
  array (
    'CODE' => '<?php

namespace Gy\\Modules\\containerdata\\Classes;

if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

class ContainerData
{            
    public static $tableContainerData = \'container_data\';
    public static $tableListPropertysContainerData = \'list_propertys_container_data\';
    public static $tableTypesPropertyContainerData = \'types_property_container_data\'; 
    public static $tableElementContainerData = \'element_container_data\';
    public static $tableValuePropertysTypeHtml = \'value_propertys_type_html\';
    public static $tableValuePropertysTypeNumber = \'value_propertys_type_number\';

    public static $propertyTapleProperty = array(
        \'id_type_property\',
        \'id_container_data\',
        \'code\',
        \'name\'
    );

    /**
     * getContainerData - получить по фильтру ContainerData
     * @param type $arFilter
     * @param type $arProperty
     * @return array
     */
    public static function getContainerData($arFilter, $arProperty)
    {
        $result = array();
        global $DB;
        $res = $DB->selectDb(
            self::$tableContainerData,
            $arProperty,
            $arFilter
        );

        $result = $DB->fetchAll($res, false);

        return $result;
    }

    /**
     * addContainerData - добавить ContainerData
     * @return boolean
     */
    public static function addContainerData($arParams)
    {
        $result = false;

        // id, login, name, pass, groups
        global $DB;
        $res = $DB->insertDb(self::$tableContainerData, $arParams);

        if ($res) {
            $result = true;
        }

        return $result;
    }

    /**
     * deleteContainerData - удалить ContainerData
     * @global type $DB
     * @param type $arParams
     * @return boolean
     */
    public static function deleteContainerData($id)
    {
        $result = false;

        // id, login, name, pass, groups
        global $DB;
        $res = $DB->deleteDb(self::$tableContainerData, array(\'=\' => array(\'id\', $id)));

        if ($res) {

            //нужно удалить все элементы связанные с ним свойства и значения свойств

            $DB->deleteDb( // удалить значения свойств свойств html
                self::$tableValuePropertysTypeHtml,
                array(\'=\' => array(\'id_container_data\', $id) )
            );
            $DB->deleteDb( // удалить значения свойств свойств number
                self::$tableValuePropertysTypeNumber, 
                array(\'=\' => array(\'id_container_data\', $id) )
            );

            $DB->deleteDb( // удалить элементы container-data
                self::$tableElementContainerData,
                array(\'=\' => array(\'id_container_data\', $id) )
            );

            $DB->deleteDb( // удалить свойства container-data
                self::$tableListPropertysContainerData,
                array(\'=\' => array(\'id_container_data\', $id) )
            );

            $result = true;
        }

        return $result;
    }

    /**
     * deleteContainerData - удалить ContainerData
     * @global type $DB
     * @param type $arParams
     * @return boolean
     */
    public static function updateContainerData($arParams, $where)
    {
        $result = false;

        global $DB;
        $res = $DB->updateDb(self::$tableContainerData, $arParams, $where);

        if ($res) {
            $result = true;
        }

        return $result; 
    }

    /**
     * getAllTypePropertysContainerData - получить все типы свойств ContainerData 
     * @return array
     */
    public static function getAllTypePropertysContainerData()
    {

        $result = array();
        global $DB;
        $res = $DB->selectDb(
            self::$tableTypesPropertyContainerData,
            array(\'*\'),
            array()
        );

        $result = $DB->fetchAll($res);

        return $result;
    }

    /**
     * getAllPropertysContainerData - получить свойства ContainerData (! не значения)
     * @return array
     */
    public static function getPropertysContainerData($where)
    {
        $result = array();
        global $DB;
        $res = $DB->selectDb(
            self::$tableListPropertysContainerData,
            array(\'*\'),
            $where
        );

        $result = $DB->fetchAll($res);

        return $result;
    }

    /**
     * addPropertyContainerData - добавить свойство для ContainerData
     * @param type $arParams
     * @return boolean
     */
    public static function addPropertyContainerData($arParams)
    {
        $result = false;

        // id, login, name, pass, groups
        global $DB;
        $res = $DB->insertDb(self::$tableListPropertysContainerData, $arParams);

        if ($res) {
            $result = true;
        }

        return $result;

    }

    /**
     * getValuePropertysContainerData - получить значения свойств указанного элемента ContainerData
     * @param type $idContainerData
     * @param type $idElementContainerData
     * @param type $idProperty
     * @param type $tableName
     * @return array
     */
    public static function getValuePropertysContainerData($idContainerData, $idElementContainerData, $idProperty,  $tableName)
    {
        $result = array();
        global $DB;
        $res = $DB->selectDb(
            $tableName,
            array(\'*\'),
            array(
                \'AND\' => array(
                    array(\'=\' => array(\'id_container_data\', $idContainerData) ),
                    array(\'=\' => array(\'id_element_container_data\', $idElementContainerData) ),
                    array(\'=\' => array(\'id_property_container_data\', $idProperty) ) 
                )
            )
        );

        if ($arRes = $DB->fetch($res)) {
            $result = $arRes;
        }
        return $result;
    }

    /**
     * addValuePropertyContainerData - добавить значения свойства для элемента ContainerData
     * @param int $idContainerData
     * @param int $idElementContainerData
     * @param int $idProperty
     * @param int $tableName
     * @param mixed $value
     * @return boolean
     */
    public static function addValuePropertyContainerData($idContainerData, $idElementContainerData, $idProperty,  $tableName, $value)
    {
        $result = false;
        global $DB;
        $res = $DB->insertDb(
            $tableName, 
            array(
                \'id_container_data\' => $idContainerData,
                \'id_element_container_data\' => $idElementContainerData,
                \'id_property_container_data\' => $idProperty,
                \'value\' => $value
            )
        );
        if ($res) {
            $result = true;
        }
        return $result;
    }

    /**
     * updateValuePropertyContainerData - обновить значение свойства элемента container-data
     * @global type $DB
     * @param type $tableName
     * @param type $id
     * @param type $value
     * @return boolean
     */
    public static function updateValuePropertyContainerData($tableName, $id, $value)
    {
        $result = false;
        global $DB;

        $res = $DB->updateDb(
            $tableName, 
            array(\'value\' => $value), 
            array(
                \'=\' => array(\'id\', $id)
            )
        );

        if ($res) {
            $result = true;
        }
        return $result;
    }

    /**
     * getAllElementContainerData - получить все элементы ContainerData
     * @param int $idContainerData
     * @return array
     */
    public static function getAllElementContainerData($idContainerData)
    {

        $result = array();
        global $DB;
        $res = $DB->selectDb(
            self::$tableElementContainerData,
            array(\'*\'),
            array(
                \'=\' => array(\'id_container_data\', $idContainerData )
            )
        );

        $result = $DB->fetchAll($res, false);
        
        return $result;
    }

    /**
     * getElementContainerData - получить элемент ContainerData
     * @param int $idContainerData
     * @return array
     */
    public static function getElementContainerData($where){

        $result = array();
        global $DB;
        $res = $DB->selectDb(
            self::$tableElementContainerData,
            array(\'*\'),
            $where
        );

        $result = $DB->fetch($res, false);

        return $result;
    }

    /**
     * addElementContainerData - добавить элемент ContainerData
     * @param type $arParams
     * @return boolean
     */
    public static function addElementContainerData($arParams)
    {
        $result = false;

        // id, login, name, pass, groups
        global $DB;
        $res = $DB->insertDb(self::$tableElementContainerData, $arParams);

        if ($res) {
            $result = true;
        }

        return $result;
    }

    /**
     * deleteElementContainerData - удалить элемент ContainerData
     * @param type $arParams
     * @return boolean
     */
    public static function deleteElementContainerData($id)
    {
        $result = false;

        global $DB;
        $res = $DB->deleteDb(self::$tableElementContainerData, array(\'=\' => array(\'id\', $id)));

        if ($res) {
            // надо удалить все свойства этого элемента
            $DB->deleteDb( // удалить всё для свойств html
                self::$tableValuePropertysTypeHtml, 
                array(\'=\' => array(\'id_element_container_data\', $id) )  
            );
            $DB->deleteDb( // удалить всё для свойств number
                self::$tableValuePropertysTypeNumber, 
                array(\'=\' => array(\'id_element_container_data\', $id) )  
            );


            $result = true;
        }

        return $result;
    }

    /**
     * updateElementContainerData - изменить элемент ContainerData
     * @param type $arParams
     * @return boolean
     */
    public static function updateElementContainerData($arParams, $where)
    {
        $result = false;

        // id, login, name, pass, groups
        global $DB;
        $res = $DB->updateDb(self::$tableElementContainerData, $arParams, $where);

        if ($res) {
            $result = true;
        }

        return $result;
    }

    /** //TODO протестировать за комментировать
     * deletePropertyContainerData - удалить свойства контент блока
     * @param int $idProperty - id свойства container-data
     * @param int $containerData
     * @return boolean
     */
    public static function deletePropertyContainerData($idProperty, $containerData)
    {
        //---надо взять все имеющиеся для этого свойства значения у элементов и удалить тоже
        global $DB;

        // взять все типы контент блоков что бы знать в каких таблицах искать значения
        $dataTypeProperty = self::getAllTypePropertysContainerData();

        // найти все свойства container-data      
        $propertyContainerData = self::getPropertysContainerData(
            array(
                \'=\'=>array(
                    \'id_container_data\',
                    $containerData
                )
            )
        );

        $tableName = $dataTypeProperty[$propertyContainerData[$idProperty][\'id_type_property\']][\'name_table\'];

        // удалить для всех элементов значения свойства           
        $DB->deleteDb($tableName, array(\'=\' => array(\'id_property_container_data\', $idProperty) )  );

        // удалить само свойство container-data
        $DB->deleteDb(static::$tableListPropertysContainerData, array(\'=\' => array(\'id\', $idProperty) )  );

        ////---
        return true; // TODO доделать что бы был ещё false
    }

}
',
    'TYPE' => 'php',
    'DIR' => './gy/modules/containerdata/classes/',
  ),
  './gy/modules/containerdata/component/containerdata/componentInfo.php' => 
  array (
    'CODE' => '<?php
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

use Gy\\Core\\Lang;

global $APP;
$utlThisComponent = "/gy/modules/containerdata/component/containerdata/";
$langComponentInfo = new Lang($APP->urlProject.$utlThisComponent, \'componentInfo\', $APP->options[\'lang\']);

$componentInfo = array(
    \'name\' => \'containerdata\',
    \'text-info\' => $langComponentInfo->getMessage(\'text-info\'),
    \'v\' => \'0.1\',
    \'all-property\' => array()
);',
    'TYPE' => 'php',
    'DIR' => './gy/modules/containerdata/component/containerdata/',
  ),
  './gy/modules/containerdata/component/containerdata/controller.php' => 
  array (
    'CODE' => '<?php 

use Gy\\Modules\\containerdata\\Classes\\ContainerData;

if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

$data = $_POST;

if (!empty($data[\'ID\']) && is_numeric($data[\'ID\'])) {
    $res = ContainerData::deleteContainerData($data[\'ID\']);

    if ($res) {
        $arRes[\'status\'] = \'del-ok\';
    } else {
        $arRes[\'status\'] = \'del-err\';
    }
}

global $USER;
$arRes[\'ITEMS\'] = ContainerData::getContainerData(array(), array(\'*\') );

// показать шаблон
$this->template->show($arRes, $this->arParam);
',
    'TYPE' => 'php',
    'DIR' => './gy/modules/containerdata/component/containerdata/',
  ),
  './gy/modules/containerdata/component/containerdata/lang_componentInfo.php' => 
  array (
    'CODE' => '<?php // языковой файл для componentInfo.php
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

$mess[\'rus\'] = array(
    \'text-info\' => \'Выведет список контейнеров данных\',
);

$mess[\'eng\'] = array(
    \'text-info\' => \'List data containers\',
);',
    'TYPE' => 'php',
    'DIR' => './gy/modules/containerdata/component/containerdata/',
  ),
  './gy/modules/containerdata/component/containerdata/teplates/0/lang_template.php' => 
  array (
    'CODE' => '<?php // языковой файл для шаблона компонента
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

$mess[\'rus\'] = array(
    \'del\' => \'Удалить\',
    \'add\' => \'Добавить\',
    \'edit\' => \'Редактировать\',
    \'show-element\' => \'Работа с элементами контейнера данных\',
    \'del-err\' => \'Ошибка! попробуйте ещё раз\',
    \'del-ok\' => \'Контейнер данных удалён!\',
    \'not-element\' => \'Контейнеров данных пока нет\',
    \'ok\' => \'ОК\',
    \'title-container-data\' => \'Контейнеры данных\'
);

$mess[\'eng\'] = array(
    \'del\' => \'Delete\',
    \'add\' => \'Add\',
    \'edit\' => \'Edit\',
    \'show-element\' => \'Working with data container elements\',
    \'del-err\' => \'Mistake! try again\',
    \'del-ok\' => \'Data container deleted!\',
    \'not-element\' => \'No data containers yet\',
    \'ok\' => \'OK\',
    \'title-container-data\' => \'Data containers\'
);


',
    'TYPE' => 'php',
    'DIR' => './gy/modules/containerdata/component/containerdata/teplates/0/',
  ),
  './gy/modules/containerdata/component/containerdata/teplates/0/template.php' => 
  array (
    'CODE' => '<?php
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );?>

<h1><?=$this->lang->getMessage(\'title-container-data\');?></h1>

<?php if (!empty($arRes[\'status\'])) {?>
    <?php if ( $arRes[\'status\'] == \'del-ok\'){ ?>
        <div class="gy-admin-good-message"><?=$this->lang->getMessage(\'del-ok\');?></div>
        <br/>
    <?php }?>

    <?php if ($arRes[\'status\'] == \'del-err\') {?>
        <div class="gy-admin-error-message"><?=$this->lang->getMessage(\'del-err\');?></div>
        <br/>
    <?php }?>
    <a href="<?=$_SERVER[\'REQUEST_URI\']?>" class="gy-admin-button"><?=$this->lang->getMessage(\'ok\');?></a>
<?php } else {?>
        
    <?php if ($arRes[\'ITEMS\']) {?>
        <table border="1" class="gy-table-all-users">
            <tr><th>id</th><th>name</th><th>code</th><th></th><th></th><th></th></tr>
            <?php foreach ($arRes[\'ITEMS\'] as $key => $val) {?>
                <tr>
                    <td><?=$val[\'id\']?></td>
                    <td><?=$val[\'name\']?></td>
                    <td><?=$val[\'code\']?></td>
                    <td>
                        <form method="post">
                            <input type="hidden" name="ID" value="<?=$val[\'id\']?>" />
                            <input type="submit" class="gy-admin-button" name="<?=$this->lang->getMessage(\'del\');?>" value="<?=$this->lang->getMessage(\'del\');?>" />
                        </form>
                    </td>
                    <td><a href="/gy/admin/get-admin-page.php?page=container-data-edit&ID=<?=$val[\'id\']?>" class="gy-admin-button"><?=$this->lang->getMessage(\'edit\');?></a></td>
                    <td><a href="/gy/admin/get-admin-page.php?page=container-data-element-list&container-data-id=<?=$val[\'id\'];?>" class="gy-admin-button"><?=$this->lang->getMessage(\'show-element\');?></a></td>
                </tr>
            <?php }?>
        </table>

    <?php } else {?>
        <?=$this->lang->getMessage(\'not-element\');?>
        <br/>
        <br/>
        <br/>
    <?php }?>
    <br/>
    <br/>
    <a href="/gy/admin/get-admin-page.php?page=container-data-add" class="gy-admin-button"><?=$this->lang->getMessage(\'add\');?></a>
<?php }',
    'TYPE' => 'php',
    'DIR' => './gy/modules/containerdata/component/containerdata/teplates/0/',
  ),
  './gy/modules/containerdata/component/containerdata_add/componentInfo.php' => 
  array (
    'CODE' => '<?php
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

use Gy\\Core\\Lang;

global $APP;
$utlThisComponent = "/gy/modules/containerdata/component/containerdata_add/";
$langComponentInfo = new Lang($APP->urlProject.$utlThisComponent, \'componentInfo\', $APP->options[\'lang\']);

$componentInfo = array(
    \'name\' => \'containerdata_add\',
    \'text-info\' => $langComponentInfo->getMessage(\'text-info\'),
    \'v\' => \'0.1\',
    \'all-property\' => array()
);',
    'TYPE' => 'php',
    'DIR' => './gy/modules/containerdata/component/containerdata_add/',
  ),
  './gy/modules/containerdata/component/containerdata_add/controller.php' => 
  array (
    'CODE' => '<?php 

use Gy\\Modules\\containerdata\\Classes\\ContainerData;

if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

//global $USER;
//$arRes[\'ITEMS\'] = ContainerData::getContainerData(array(), array(\'*\') );

// найти текущие значения

$arRes = array();

$arRes[\'property\'] = array(
    \'name\',
    \'code\'
);

$data = $_POST;

if (!empty($data)) {
    $saveData = array(); 
    foreach ($arRes[\'property\'] as $val) {
        $saveData[$val] = $data[$val]; 
    }

    $res = ContainerData::addContainerData($saveData);

    if ($res) {
        $arRes[\'status\'] = \'add-ok\';
    } else {
        $arRes[\'status\'] = \'add-err\';
    }
} else {
    $arRes[\'status\'] = \'add\';
}

// показать шаблон
$this->template->show($arRes, $this->arParam);
',
    'TYPE' => 'php',
    'DIR' => './gy/modules/containerdata/component/containerdata_add/',
  ),
  './gy/modules/containerdata/component/containerdata_add/lang_componentInfo.php' => 
  array (
    'CODE' => '<?php // языковой файл для componentInfo.php
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

$mess[\'rus\'] = array(
    \'text-info\' => \'Добавление контейнера данных\',
);
$mess[\'eng\'] = array(
    \'text-info\' => \'Adding a data container\',
);',
    'TYPE' => 'php',
    'DIR' => './gy/modules/containerdata/component/containerdata_add/',
  ),
  './gy/modules/containerdata/component/containerdata_add/teplates/0/lang_template.php' => 
  array (
    'CODE' => '<?php // языковой файл для шаблона компонента
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

$mess[\'rus\'] = array(
    \'save\' => \'Создать\',
    \'back\' => \'Отменить\',
    \'title\' => \'Создание контейнера данных\',
    \'add-err\' => \'Ошибка! попробуйте ещё раз\', 
    \'add-ok\' => \'Контейнер данных успешно создан!\',
    \'ok\' => \'ОК\'
);

$mess[\'eng\'] = array(
    \'save\' => \'Create\',
    \'back\' => \'Cancel\',
    \'title\' => \'Creating a data container\',
    \'add-err\' => \'Error! try again\', 
    \'add-ok\' => \'Data container created successfully!\',
    \'ok\' => \'OK\'
);

',
    'TYPE' => 'php',
    'DIR' => './gy/modules/containerdata/component/containerdata_add/teplates/0/',
  ),
  './gy/modules/containerdata/component/containerdata_add/teplates/0/template.php' => 
  array (
    'CODE' => '<?php
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

if ($arRes[\'status\'] == \'add\') { ?>
    <h1><?=$this->lang->getMessage(\'title\');?></h1>
    <form method="post">
        <table border="1" class="gy-table-all-users">
            <?php foreach ($arRes[\'property\'] as $val) {?>
                <tr>
                    <td><?=$val?></td>
                    <td><input type="text" name="<?=$val?>" value="" /></td>
                </tr>
            <?php }?>
        </table>     
        <input type="submit" class="gy-admin-button" value="<?=$this->lang->getMessage(\'save\');?>" />
    </form>    
    <br/>
    <a href="" class="gy-admin-button"><?=$this->lang->getMessage(\'back\');?></a>
<?php }?>    
    
<?php if ($arRes[\'status\'] == \'add-ok\'){?>
    <div class="gy-admin-good-message"><?=$this->lang->getMessage(\'add-ok\');?></div>
    <br/>
    <a href="/gy/admin/get-admin-page.php?page=container-data" class="gy-admin-button"><?=$this->lang->getMessage(\'ok\');?></a>
<?php } ?>
    
<?php if ($arRes[\'status\'] == \'add-err\') {?>
    <div class="gy-admin-error-message"><?=$this->lang->getMessage(\'add-err\');?></div>
    <br/>
    <a href="/gy/admin/get-admin-page.php?page=container-data" class="gy-admin-button"><?=$this->lang->getMessage(\'ok\');?></a>
<?php } ',
    'TYPE' => 'php',
    'DIR' => './gy/modules/containerdata/component/containerdata_add/teplates/0/',
  ),
  './gy/modules/containerdata/component/containerdata_edit/componentInfo.php' => 
  array (
    'CODE' => '<?php
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

use Gy\\Core\\Lang;

global $APP;
$utlThisComponent = "/gy/modules/containerdata/component/containerdata_edit/";
$langComponentInfo = new Lang($APP->urlProject.$utlThisComponent, \'componentInfo\', $APP->options[\'lang\']);

$componentInfo = array(
    \'name\' => \'containerdata_edit\',
    \'text-info\' => $langComponentInfo->getMessage(\'text-info\'),
    \'v\' => \'0.1\',
    \'all-property\' => array(
        \'ID\'
    ),
    \'all-property-text\' => array(
        \'ID\' => $langComponentInfo->getMessage(\'property-ID\')
    )
);',
    'TYPE' => 'php',
    'DIR' => './gy/modules/containerdata/component/containerdata_edit/',
  ),
  './gy/modules/containerdata/component/containerdata_edit/controller.php' => 
  array (
    'CODE' => '<?php

use Gy\\Modules\\containerdata\\Classes\\ContainerData;

if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

//global $USER;
//$arRes[\'ITEMS\'] = ContainerData::getContainerData(array(), array(\'*\') );

// найти текущие значения

$arRes = array();

$arRes[\'property\'] = array(
    \'name\',
    \'code\'
);

$data = $_POST;

if (!empty($data[\'ID\'])) {
    
    $saveData = array(); 
    foreach ($arRes[\'property\'] as $val) {
        $saveData[$val] = $data[$val]; 
    }
        
    $res = ContainerData::updateContainerData($saveData, array(\'=\' => array(\'id\', $data[\'ID\'])));
    
    if ($res) {
        $arRes[\'status\'] = \'add-ok\';
    } else {
        $arRes[\'status\'] = \'add-err\';
    }

} else {
    $arRes[\'data-this-nfo-box\'] = array();
    if (!empty($this->arParam[\'ID\'])) {
        $arRes[\'data-this-nfo-box\'] = ContainerData::getContainerData(array( \'=\' =>array( \'id\', $this->arParam[\'ID\'])), array(\'*\') );
    }
}

// показать шаблон
$this->template->show($arRes, $this->arParam);
',
    'TYPE' => 'php',
    'DIR' => './gy/modules/containerdata/component/containerdata_edit/',
  ),
  './gy/modules/containerdata/component/containerdata_edit/lang_componentInfo.php' => 
  array (
    'CODE' => '<?php // языковой файл для componentInfo.php
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

$mess[\'rus\'] = array(
    \'text-info\' => \'Изменение контейнера данных\',
    \'property-ID\' => \'ID контейнера данных\',
);

$mess[\'eng\'] = array(
    \'text-info\' => \'Changing the data container\',
    \'property-ID\' => \'Data container ID\',
);',
    'TYPE' => 'php',
    'DIR' => './gy/modules/containerdata/component/containerdata_edit/',
  ),
  './gy/modules/containerdata/component/containerdata_edit/teplates/0/lang_template.php' => 
  array (
    'CODE' => '<?php // языковой файл для шаблона компонента
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

$mess[\'rus\'] = array(
    \'save\' => \'Сохранить\',
    \'back\' => \'Отменить\',
    \'title\' => \'Редактирование контейнера данных\',
    \'add-err\' => \'Ошибка! попробуйте ещё раз\', 
    \'add-ok\' => \'Контейнер данных успешно изменён!\',
    \'ok\' => \'ОК\',
    \'edit-property\' => \'Редактировать свойства этого контейнера данных\'
);

$mess[\'eng\'] = array(
    \'save\' => \'Save\',
    \'back\' => \'Cancel\',
    \'title\' => \'Editing a data container\',
    \'add-err\' => \'Error! try again\', 
    \'add-ok\' => \'Data container changed successfully!\',
    \'ok\' => \'OK\',
    \'edit-property\' => \'Edit properties of this data container\'
);

',
    'TYPE' => 'php',
    'DIR' => './gy/modules/containerdata/component/containerdata_edit/teplates/0/',
  ),
  './gy/modules/containerdata/component/containerdata_edit/teplates/0/template.php' => 
  array (
    'CODE' => '<?php
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

if (!empty($arRes[\'data-this-nfo-box\'])) {
    $value = array_shift($arRes[\'data-this-nfo-box\']);
    if (!empty($value)){
        ?>
        <h1><?=$this->lang->getMessage(\'title\');?></h1>
        <form method="post">
            <input name="ID" type="hidden" value="<?=$value[\'id\']?>" />
            <table border="1" class="gy-table-all-users">
                <?php foreach ($arRes[\'property\'] as $val) {?>
                    <tr>
                        <td><?=$val?></td>
                        <td><input type="text" name="<?=$val?>" value="<?=$value[$val]?>" /></td>
                    </tr>
                <?php }?>
            </table> 

            <input type="submit" class="gy-admin-button" value="<?=$this->lang->getMessage(\'save\');?>" />
        </form>    
        <br/>
        <a href="" class="gy-admin-button"><?=$this->lang->getMessage(\'back\');?></a>
        <br/>
        <br/>
        <br/>
        <a href="/gy/admin/get-admin-page.php?page=container-data-property-edit&container-data-id=<?=$value[\'id\']?>" class="gy-admin-button"><?=$this->lang->getMessage(\'edit-property\');?></a>
    <?php 
    }
}
?>    
   
<?php if (!empty($arRes[\'status\'])) {?>    
    <?php if ($arRes[\'status\'] == \'add-ok\') {?>
        <div class="gy-admin-good-message"><?=$this->lang->getMessage(\'add-ok\');?></div>
        <br/>
        <a href="/gy/admin/get-admin-page.php?page=container-data" class="gy-admin-button"><?=$this->lang->getMessage(\'ok\');?></a>
    <?php } ?>

    <?php if ($arRes[\'status\'] == \'add-err\') {?>
        <div class="gy-admin-error-message"><?=$this->lang->getMessage(\'add-err\');?></div>
        <br/>
        <a href="/gy/admin/get-admin-page.php?page=container-data" class="gy-admin-button"><?=$this->lang->getMessage(\'ok\');?></a>
    <?php } ?>
<?php }',
    'TYPE' => 'php',
    'DIR' => './gy/modules/containerdata/component/containerdata_edit/teplates/0/',
  ),
  './gy/modules/containerdata/component/containerdata_element_list/componentInfo.php' => 
  array (
    'CODE' => '<?php
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

use Gy\\Core\\Lang;

global $APP;
$utlThisComponent = "/gy/modules/containerdata/component/containerdata_element_list/";
$langComponentInfo = new Lang($APP->urlProject.$utlThisComponent, \'componentInfo\', $APP->options[\'lang\']);

$componentInfo = array(
    \'name\' => \'containerdata_element_list\',
    \'text-info\' => $langComponentInfo->getMessage(\'text-info\'),
    \'v\' => \'0.1\',
    \'all-property\' => array(
        \'container-data-id\'
    ),
    \'all-property-text\' => array(
        \'container-data-id\' => $langComponentInfo->getMessage(\'property-container-data-id\'),
    )
);',
    'TYPE' => 'php',
    'DIR' => './gy/modules/containerdata/component/containerdata_element_list/',
  ),
  './gy/modules/containerdata/component/containerdata_element_list/controller.php' => 
  array (
    'CODE' => '<?php

use Gy\\Modules\\containerdata\\Classes\\ContainerData;

if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

$arRes = array();

$data = $_REQUEST;

if (!empty($data[\'id_container_data\']) && !empty($data[\'name\']) && !empty($data[\'code\'])) {

    if (empty($data[\'el-id\'])) { // добавить новый элемент container-data
        $res = ContainerData::addElementContainerData(
            array(
                \'section_id\' => $data[\'section_id\'],
                \'name\' => $data[\'name\'],
                \'code\' => $data[\'code\'],
                \'id_container_data\' => $data[\'id_container_data\']
            )
        );
        if ($res) {
            $arRes[\'stat\'] = \'ok\';
        } else {
            $arRes[\'stat\'] = \'err\';
        }

    } elseif (!empty($data[\'el_edit_id\']) && is_numeric($data[\'el_edit_id\'])) { // изменить элемент container-data
        
        
        $res = ContainerData::updateElementContainerData(
            array(
                \'section_id\' => $data[\'section_id\'],
                \'name\' => $data[\'name\'],
                \'code\' => $data[\'code\'],
                \'id_container_data\' => $data[\'id_container_data\']
            ),
            array(
                \'=\' =>array(\'id\', $data[\'el_edit_id\'])
            )
        );

        if ($res) {
            $arRes[\'stat-edit\'] = \'ok\';
        } else {
            $arRes[\'stat-edit\'] = \'err\';
        }
    } else {
        $arRes[\'stat\'] = \'err\';
    }  

}

if (!empty($data[\'del-el\']) && !empty($data[\'id\'])) {
    $res = ContainerData::deleteElementContainerData( $data[\'id\']);
    if ($res) { 
        $arRes[\'stat-del\'] = \'ok\';
    } else {
        $arRes[\'stat-del\'] = \'err\';
    }
}

if (!empty($this->arParam[\'container-data-id\']) && is_numeric($this->arParam[\'container-data-id\'])) {
    $arRes[\'ITEMS\'] = ContainerData::getAllElementContainerData($this->arParam[\'container-data-id\']);

    if (!empty($data[\'el-id\']) && is_numeric($data[\'el-id\']) && empty($arRes[\'stat-edit\'])) {

        foreach ($arRes[\'ITEMS\'] as $val) {
            if ($val[\'id\'] == $data[\'el-id\']) {
                $arRes[\'stat-del\'] = \'edit\';
                $arRes[\'edit-id\'] = $data[\'el-id\'];
                $arRes[\'edit-el-data\'] = $val;
            }
        }
    }
}

// показать шаблон
$this->template->show($arRes, $this->arParam);
',
    'TYPE' => 'php',
    'DIR' => './gy/modules/containerdata/component/containerdata_element_list/',
  ),
  './gy/modules/containerdata/component/containerdata_element_list/lang_componentInfo.php' => 
  array (
    'CODE' => '<?php // языковой файл для componentInfo.php
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

$mess[\'rus\'] = array(
    \'text-info\' => \'Работа с элементами контейнера данных\',
    \'property-container-data-id\' => \'Id контейнера данных\',
);

$mess[\'eng\'] = array(
    \'text-info\' => \'Working with data container elements\',
    \'property-container-data-id\' => \'Data container id\',
);',
    'TYPE' => 'php',
    'DIR' => './gy/modules/containerdata/component/containerdata_element_list/',
  ),
  './gy/modules/containerdata/component/containerdata_element_list/teplates/0/lang_template.php' => 
  array (
    'CODE' => '<?php // языковой файл для шаблона компонента
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

$mess[\'rus\'] = array(
    \'ITEMS-NULL\' => \'!Элементов ещё нет\',
    \'title-add-element\' => \'Добавить новый элемент\',
    \'add\' => \'Добавить\',
    \'save\' => \'Изменить\',
    \'back\' => \'Отмена\',
    \'title\' => \'Элементы контейнера данных\',
    \'add-ok\' => \'Элемент добавлен\',
    \'add-err\' => \'! Ошибка, попробуйте ещё раз\',
    \'el-edit\' => \'Изменить элемент\',
    \'el-del\' => \'Удалить элемент\',
    \'el-view-property\' => \'Просмотреть свойства элемента\',
    \'del-ok\' => \'! Элемент удалён\',
    \'edit-ok\' => \'Элемент изменён\',
    \'ok\' => \'ОК\'
);

$mess[\'eng\'] = array(
    \'ITEMS-NULL\' => \'!No items yet\',
    \'title-add-element\' => \'Add new item\',
    \'add\' => \'Add\',
    \'save\' => \'Edit\',
    \'back\' => \'Cancel\',
    \'title\' => \'Data container elements\',
    \'add-ok\' => \'Item added\',
    \'add-err\' => \'!Error, please try again\',
    \'el-edit\' => \'Edit item\',
    \'el-del\' => \'Remove item\',
    \'el-view-property\' => \'View item properties\',
    \'del-ok\' => \'! Item removed\',
    \'edit-ok\' => \'item edited\',
    \'ok\' => \'OK\'
);

',
    'TYPE' => 'php',
    'DIR' => './gy/modules/containerdata/component/containerdata_element_list/teplates/0/',
  ),
  './gy/modules/containerdata/component/containerdata_element_list/teplates/0/template.php' => 
  array (
    'CODE' => '<?php if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );?>

<h4><?=$this->lang->getMessage(\'title\');?></H4>

<?php
$isEdit = (!empty($arRes[\'stat-del\']) && ($arRes[\'stat-del\'] == \'edit\'));

if ((empty($arRes[\'stat\']) && empty($arRes[\'stat-edit\']) && empty($arRes[\'stat-del\'])) || $isEdit ) {?>
    
    <?php
    if (!empty($arRes[\'ITEMS\'])){ ?>
        <table border="1" class="gy-table-all-users">
            <tr><th>code</th><th>name</th><th>section id</th><th></th><th></th><th></th></tr>

            <?php foreach ($arRes[\'ITEMS\'] as $val) {?>
                <tr>
                    <td><?=$val[\'code\']?></td>
                    <td><?=$val[\'name\']?></td>
                    <td><?=$val[\'section_id\']?></td>
                    <td><a href="?page=container-data-element-list&container-data-id=<?=$arParam[\'container-data-id\']?>&el-id=<?=$val[\'id\'];?>" class="gy-admin-button"><?=$this->lang->getMessage(\'el-edit\');?></a></td>
                    <td><a href="/gy/admin/get-admin-page.php?page=container-data-element-property&container-data-id=<?=$arParam[\'container-data-id\']?>&el-id=<?=$val[\'id\'];?>" class="gy-admin-button"><?=$this->lang->getMessage(\'el-view-property\');?></a></td>
                    <td>
                        <form method="post">
                            <input type="hidden" name="id" value="<?=$val[\'id\']?>" />
                            <input type="submit" class="gy-admin-button" name="del-el" value="<?=$this->lang->getMessage(\'el-del\');?>" />
                        </form>
                    </td>
                </tr>
            <?php }?>
        </table> 
    <?php } else {?>
        <?=$this->lang->getMessage(\'ITEMS-NULL\');?>
    <?php }?>

    <h4><?=$this->lang->getMessage(\'title-add-element\');?></H4>
    
    <form method="post">
        <input name="id_container_data" type="hidden" value="<?=$arParam[\'container-data-id\']?>" />
        <input name="section_id" type="hidden" value="0" /> <?php // TODO пока так (всегда один раздел н можно доработать)?>

        <?php if ($isEdit) {?>
            <input name="el_edit_id" type="hidden" value="<?=$arRes[\'edit-id\']?>" />
        <?php }?>

        <table border="1" class="gy-table-all-users">

            <tr><td>code</td><td><input type="text" name="code" value="<?=(($isEdit)? $arRes[\'edit-el-data\'][\'code\'] : \'\' )?>" /></td></tr>

            <tr><td>name</td><td><input type="text" name="name" value="<?=(($isEdit)? $arRes[\'edit-el-data\'][\'name\'] : \'\' )?>" /></td></tr>

            <tr>
                <td></td>
                <td>
                    <input type="submit" class="gy-admin-button" value="<?=(($isEdit)? $this->lang->getMessage(\'save\'): $this->lang->getMessage(\'add\'));?>" /> 
                    <a href="" class="gy-admin-button"><?=$this->lang->getMessage(\'back\');?></a>
                </td>
            </tr>
        </table> 

    </form>
<?php } else {?>
    <?php if (!empty($arRes[\'stat-del\'])) { ?>
        <?php if ($arRes[\'stat-del\'] == \'ok\') {?>
            <div class="gy-admin-good-message"><?=$this->lang->getMessage(\'del-ok\');?></div>
        <?php } elseif ($arRes[\'stat-del\'] == \'err\') {?>
            <div class="gy-admin-error-message"><?=$this->lang->getMessage(\'add-err\');?></div>
        <?php }?>
    <?php }?>
    
    <?php if (!empty($arRes[\'stat\'])) { ?>
        <?php if ($arRes[\'stat\'] == \'ok\') {?>
            <div class="gy-admin-good-message"><?=$this->lang->getMessage(\'add-ok\');?></div>
        <?php } elseif ($arRes[\'stat\'] == \'err\') {?>
            <div class="gy-admin-error-message"><?=$this->lang->getMessage(\'add-err\');?></div>
        <?php }?>
    <?php }?>

    <?php if (!empty($arRes[\'stat-edit\'])) { ?>
        <?php if ($arRes[\'stat-edit\'] == \'ok\') {?>
            <div class="gy-admin-good-message"><?=$this->lang->getMessage(\'edit-ok\');?></div>
        <?php } elseif ($arRes[\'stat-edit\'] == \'err\') {?>
            <div class="gy-admin-error-message"><?=$this->lang->getMessage(\'add-err\');?></div>
        <?php }?>
    <?php }?>
    
    <a href="<?=$_SERVER[\'SCRIPT_NAME\']?>?page=container-data-element-list&container-data-id=<?=$arParam[\'container-data-id\']?>" class="gy-admin-button"><?=$this->lang->getMessage(\'ok\');?></a>
<?php }  
',
    'TYPE' => 'php',
    'DIR' => './gy/modules/containerdata/component/containerdata_element_list/teplates/0/',
  ),
  './gy/modules/containerdata/component/containerdata_element_property/componentInfo.php' => 
  array (
    'CODE' => '<?php
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

use Gy\\Core\\Lang;

global $APP;
$utlThisComponent = "/gy/modules/containerdata/component/containerdata_element_property/";
$langComponentInfo = new Lang($APP->urlProject.$utlThisComponent, \'componentInfo\', $APP->options[\'lang\']);

$componentInfo = array(
    \'name\' => \'containerdata_element_property\',
    \'text-info\' => $langComponentInfo->getMessage(\'text-info\'),
    \'v\' => \'0.1\',
    \'all-property\' => array(
        \'container-data-id\',
        \'el-id\'
    ),
    \'all-property-text\' => array(
        \'container-data-id\' => $langComponentInfo->getMessage(\'property-container-data-id\'),
        \'el-id\' => $langComponentInfo->getMessage(\'property-el-id\')
    )
);',
    'TYPE' => 'php',
    'DIR' => './gy/modules/containerdata/component/containerdata_element_property/',
  ),
  './gy/modules/containerdata/component/containerdata_element_property/controller.php' => 
  array (
    'CODE' => '<?php 

use Gy\\Modules\\containerdata\\Classes\\ContainerData;

if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

$arRes = array();

if (!empty($this->arParam[\'container-data-id\']) && !empty($this->arParam[\'el-id\'])) {
    // получить свойства container-data
    $arRes[\'PROPERTY\'] = ContainerData::getPropertysContainerData( array(\'=\'=>array(\'id_container_data\', $this->arParam[\'container-data-id\'])) );
    
    // получить все типы свойств
    $arRes[\'PROPERTY_TYPE\'] = ContainerData::getAllTypePropertysContainerData();

    $data = $_REQUEST;

    // сохранение свойств
    if (!empty($data[\'propertyAdd\'])) {
        
        foreach ($data[\'propertyAdd\'] as $key => $val) {
            $res = ContainerData::addValuePropertyContainerData(
                $this->arParam[\'container-data-id\'], 
                $this->arParam[\'el-id\'], 
                $key,  
                $arRes[\'PROPERTY_TYPE\'][$arRes[\'PROPERTY\'][$key][\'id_type_property\']][\'name_table\'],
                $val
            );
            if ($res) {
                $arRes[\'stat-save\'] = \'ok\';
            }
            
        }
    }

    $arRes[\'PROPERTY_VALUE\'] = array();

    // получить значения
    if (!empty($arRes[\'PROPERTY\']) && is_array($arRes[\'PROPERTY\'])) {
        foreach ($arRes[\'PROPERTY\'] as $key => $val) {
            $propertyValue = ContainerData::getValuePropertysContainerData(
                $this->arParam[\'container-data-id\'], 
                $this->arParam[\'el-id\'],
                $val[\'id\'],
                $arRes[\'PROPERTY_TYPE\'][$val[\'id_type_property\']][\'name_table\']
            );

            if (!empty($propertyValue)) {
                $arRes[\'PROPERTY_VALUE\'][$val[\'id\']] = $propertyValue;
            }
        }
    }

    $arKeyValue = array();
    foreach ($arRes[\'PROPERTY_VALUE\'] as $key => $value) {

        $arKeyValue[$value[\'id\']] = $key;
    }

    // обновление
    // сохранение свойств
    if (!empty($data[\'propertyUpdate\'])) {

        foreach ($data[\'propertyUpdate\'] as $key => $val) {
            $res = ContainerData::updateValuePropertyContainerData(
                $arRes[\'PROPERTY_TYPE\'][$arRes[\'PROPERTY\'][$arKeyValue[$key]][\'id_type_property\']][\'name_table\'],
                $key,
                $val
            );
            if ($res) {
                $arRes[\'stat-save\'] = \'ok\';
            }

        }
    }

    // TODO заменить повторный код на редирект
    $arRes[\'PROPERTY_VALUE\'] = array();

    // получить значения
    if (!empty($arRes[\'PROPERTY\']) && is_array($arRes[\'PROPERTY\'])) {
        foreach ($arRes[\'PROPERTY\'] as $key => $val) {
            $propertyValue = ContainerData::getValuePropertysContainerData(
                $this->arParam[\'container-data-id\'],
                $this->arParam[\'el-id\'],
                $val[\'id\'],
                $arRes[\'PROPERTY_TYPE\'][$val[\'id_type_property\']][\'name_table\']
            );

            if (!empty($propertyValue)) {
                $arRes[\'PROPERTY_VALUE\'][$val[\'id\']] = $propertyValue;
            }
        }
    }
}

// показать шаблон
$this->template->show($arRes, $this->arParam);
',
    'TYPE' => 'php',
    'DIR' => './gy/modules/containerdata/component/containerdata_element_property/',
  ),
  './gy/modules/containerdata/component/containerdata_element_property/lang_componentInfo.php' => 
  array (
    'CODE' => '<?php  // языковой файл для componentInfo.php
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

$mess[\'rus\'] = array(
    \'text-info\' => \'Работа со свойствами конкретного элемента контейнера данных\',
    \'property-container-data-id\' => \'Id контейнера данных\',
    \'property-el-id\' => \'Id элемента\'
);

$mess[\'eng\'] = array(
    \'text-info\' => \'Working with the properties of a specific item in a data container\',
    \'property-container-data-id\' => \'Data container id\',
    \'property-el-id\' => \'Item id\'
);',
    'TYPE' => 'php',
    'DIR' => './gy/modules/containerdata/component/containerdata_element_property/',
  ),
  './gy/modules/containerdata/component/containerdata_element_property/teplates/0/lang_template.php' => 
  array (
    'CODE' => '<?php // языковой файл для шаблона компонента
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

$mess[\'rus\'] = array(
    \'save\' => \'Сохранить\',
    \'back\' => \'Отменить\',
    \'title\' => \'Значения свойств элемента\',
    \'name\' =>  \'Название\',
    \'code\' =>  \'Сode\',
    \'type\'  => \'Тип свойства\',
    \'value\' => \'Значение\',
    \'save-ok\' => \'Свойства сохранены\',
    \'PROPERTY_NULL\' => \'! Элементов не найдено\',
    \'ok\' => \'ОК\'
);

$mess[\'eng\'] = array(
    \'save\' => \'Save\',
    \'back\' => \'Cancel\',
    \'title\' => \'Item property values\',
    \'name\' =>  \'Name\',
    \'code\' =>  \'Сode\',
    \'type\'  => \'Type property\',
    \'value\' => \'Value\',
    \'save-ok\' => \'Properties saved\',
    \'PROPERTY_NULL\' => \'! No items found\',
    \'ok\' => \'OK\'
);

',
    'TYPE' => 'php',
    'DIR' => './gy/modules/containerdata/component/containerdata_element_property/teplates/0/',
  ),
  './gy/modules/containerdata/component/containerdata_element_property/teplates/0/template.php' => 
  array (
    'CODE' => '<?php if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );?>

<h1><?=$this->lang->getMessage(\'title\');?></h1>

<?php
if (empty($arRes[\'stat-save\'])) {

    if (!empty($arRes[\'PROPERTY\'])) { ?>

        <form method="post">

            <table border="1" class="gy-table-all-users">
                <tr>
                    <th><?=$this->lang->getMessage(\'name\');?></th>
                    <th><?=$this->lang->getMessage(\'code\');?></th>
                    <th><?=$this->lang->getMessage(\'type\');?></th>
                    <th><?=$this->lang->getMessage(\'value\');?></th>
                </tr>
                <?php foreach ($arRes[\'PROPERTY\'] as $val) {?>
                    <tr>
                        <td><?=$val[\'name\']?></td>
                        <td><?=$val[\'code\']?></td>
                        <td><?=$arRes[\'PROPERTY_TYPE\'][$val[\'id_type_property\']][\'name\']?></td>
                        <td>
                            <?php if ($arRes[\'PROPERTY_TYPE\'][$val[\'id_type_property\']][\'name\'] != \'html\') {?>
                                <input 
                                    type="text" 
                                    <?php if (!empty($arRes[\'PROPERTY_VALUE\'][$val[\'id\']])) {?>
                                        name="propertyUpdate[<?=$arRes[\'PROPERTY_VALUE\'][$val[\'id\']][\'id\']?>]" 
                                    <?php } else {?>
                                        name="propertyAdd[<?=$val[\'id\']?>]" 
                                    <?php }?>    
                                    value="<?=((!empty($arRes[\'PROPERTY_VALUE\'][$val[\'id\']]))? $arRes[\'PROPERTY_VALUE\'][$val[\'id\']][\'value\'] : \'\')?>" 
                                />
                            <?php } else {?>
                                <textarea 
                                    rows="5" cols="70"
                                    <?php if (!empty($arRes[\'PROPERTY_VALUE\'][$val[\'id\']])) {?>
                                        name="propertyUpdate[<?=$arRes[\'PROPERTY_VALUE\'][$val[\'id\']][\'id\']?>]" 
                                    <?php } else {?>
                                        name="propertyAdd[<?=$val[\'id\']?>]" 
                                    <?php }?>    
                                /><?=((!empty($arRes[\'PROPERTY_VALUE\'][$val[\'id\']]))? $arRes[\'PROPERTY_VALUE\'][$val[\'id\']][\'value\'] : \'\')?></textarea>
                            <?php }?>
                        </td>
                    </tr>
                <?php }?>
            </table> 

            <input type="submit" class="gy-admin-button" value="<?=$this->lang->getMessage(\'save\');?>" />
        </form>    
        
        <br/>
        <a href="" class="gy-admin-button"><?=$this->lang->getMessage(\'back\');?></a>
        <br/>
        <br/>
        <br/>

    <?php } else {?>
        <?=$this->lang->getMessage(\'PROPERTY_NULL\');?>
    <?php }?>
<?php } else {?>
    <?php if (!empty($arRes[\'stat-save\'] ) && ($arRes[\'stat-save\'] == \'ok\')) {?>
        <div class="gy-admin-good-message"><?=$this->lang->getMessage(\'save-ok\');?></div>
    <?php }?>
    <a href="<?=$_SERVER[\'REQUEST_URI\']?>" class="gy-admin-button"><?=$this->lang->getMessage(\'ok\');?></a>
<?php }
        ',
    'TYPE' => 'php',
    'DIR' => './gy/modules/containerdata/component/containerdata_element_property/teplates/0/',
  ),
  './gy/modules/containerdata/component/containerdata_element_show/componentInfo.php' => 
  array (
    'CODE' => '<?php
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

use Gy\\Core\\Lang;

global $APP;
$utlThisComponent = "/gy/modules/containerdata/component/containerdata_element_show/";
$langComponentInfo = new Lang($APP->urlProject.$utlThisComponent, \'componentInfo\', $APP->options[\'lang\']);

$componentInfo = array(
    \'name\' => \'containerdata_element_show\',
    \'text-info\' => $langComponentInfo->getMessage(\'text-info\'),
    \'v\' => \'0.1\',
    \'all-property\' => array(
        \'container-data-code\' ,
        \'element-code\',
        \'cacheTime\'
    ),
    \'all-property-text\' => array(
        \'container-data-code\' => $langComponentInfo->getMessage(\'property-container-data-code\'),
        \'element-code\' => $langComponentInfo->getMessage(\'property-element-code\'),
        \'cacheTime\' => $langComponentInfo->getMessage(\'property-cacheTime\')
    )
);',
    'TYPE' => 'php',
    'DIR' => './gy/modules/containerdata/component/containerdata_element_show/',
  ),
  './gy/modules/containerdata/component/containerdata_element_show/controller.php' => 
  array (
    'CODE' => '<?php 

use Gy\\Modules\\containerdata\\Classes\\ContainerData;

if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

$arRes = array();

// TODO попробовать уменьшить количество запросов

/**
* container-data-code код container-data
* element-code - code элемента
*/
if (!empty($this->arParam[\'container-data-code\']) && !empty($this->arParam[\'element-code\'])) {

    $isCache = (!empty($this->arParam[\'cacheTime\']) && is_numeric($this->arParam[\'cacheTime\']));

    if ($isCache) {
        global $APP;
        global $CACHE_CLASS_NAME;
        $cache = new $CACHE_CLASS_NAME($APP->url);
        $initCache = $cache->cacheInit(\'component_container_data_element_show\', $this->arParam[\'cacheTime\']);
    }

    if ($isCache && $initCache) {
        $arRes = $cache->getCacheData();
    }

    if (!$isCache || ($isCache && !$initCache)) {

        // найти container-data
        $dataContainerData = ContainerData::getContainerData(
            array(
                \'=\' => array( \'code\', "\'".$this->arParam[\'container-data-code\']."\'")
            ),
            array(\'*\')
        );

        $dataContainerData = $dataContainerData[0];

        // взять типы свойств что бы знать названия таблиц где их искать
        $dataTypeProperty = ContainerData::getAllTypePropertysContainerData();

        // найти его свойства
        $propertyContainerData = ContainerData::getPropertysContainerData(
            array(
                \'=\'=>array(
                    \'id_container_data\',
                    $dataContainerData[\'id\']
                )
            )
        );

        // найти элемент
        $dataElement = ContainerData::getElementContainerData(
            array(
                \'AND\' => array(
                    array( \'=\' => array( \'id_container_data\', $dataContainerData[\'id\'])),
                    array( \'=\' => array( \'code\', "\'".$this->arParam[\'element-code\']."\'"))
                )
            )
        );

        // найти значения свойств элемента
        $arRes[\'ITEMS\'] = array();

        foreach ($propertyContainerData as $val) {
            $arRes[\'ITEMS\'][$val[\'id\']] = ContainerData::getValuePropertysContainerData(
                $dataContainerData[\'id\'],
                $dataElement[\'id\'],
                $val[\'id\'],
                $dataTypeProperty[$val[\'id_type_property\']][\'name_table\']
            );
        }

        if ($isCache) {
            $cache->setCacheData($arRes);
        }
    }
}

// показать шаблон
$this->template->show($arRes, $this->arParam);
',
    'TYPE' => 'php',
    'DIR' => './gy/modules/containerdata/component/containerdata_element_show/',
  ),
  './gy/modules/containerdata/component/containerdata_element_show/lang_componentInfo.php' => 
  array (
    'CODE' => '<?php // языковой файл для componentInfo.php
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

$mess[\'rus\'] = array(
    \'text-info\' => \'Вывод элемента контейнера данных\',
    \'property-container-data-code\' => \'Код контейнера данных\',
    \'property-element-code\' => \'Код элемента\',
    \'property-cacheTime\' => \'Время кеширования\'
);

$mess[\'eng\'] = array(
    \'text-info\' => \'Outputting a data container item\',
    \'property-container-data-code\' => \'Data container code\',
    \'property-element-code\' => \'Item code\',
    \'property-cacheTime\' => \'Caching time\'
);',
    'TYPE' => 'php',
    'DIR' => './gy/modules/containerdata/component/containerdata_element_show/',
  ),
  './gy/modules/containerdata/component/containerdata_element_show/teplates/0/template.php' => 
  array (
    'CODE' => '<?php if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

if (!empty($arRes[\'ITEMS\'])) {
    foreach ($arRes[\'ITEMS\'] as $value) { 
        echo ((!empty($value[\'value\']))? $value[\'value\'] : \'\');
    } 
}',
    'TYPE' => 'php',
    'DIR' => './gy/modules/containerdata/component/containerdata_element_show/teplates/0/',
  ),
  './gy/modules/containerdata/component/containerdata_property_edit/componentInfo.php' => 
  array (
    'CODE' => '<?php
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

use Gy\\Core\\Lang;

global $APP;
$utlThisComponent = "/gy/modules/containerdata/component/containerdata_property_edit/";
$langComponentInfo = new Lang($APP->urlProject.$utlThisComponent, \'componentInfo\', $APP->options[\'lang\']);

$componentInfo = array(
    \'name\' => \'containerdata_property_edit\',
    \'text-info\' => $langComponentInfo->getMessage(\'text-info\'),
    \'v\' => \'0.1\',
    \'all-property\' => array(
        \'container-data-id\'
    ),
    \'all-property-text\' => array(
        \'container-data-id\' => $langComponentInfo->getMessage(\'property-container-data-id\')
    )
);',
    'TYPE' => 'php',
    'DIR' => './gy/modules/containerdata/component/containerdata_property_edit/',
  ),
  './gy/modules/containerdata/component/containerdata_property_edit/controller.php' => 
  array (
    'CODE' => '<?php 

use Gy\\Modules\\containerdata\\Classes\\ContainerData;

if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

$arRes = array();

$data = $_POST;

// удаления свойства container-data
if (!empty($data[\'del-property-id\']) && !empty($data[\'del-proprty-container-data\'])) {
    ContainerData::deletePropertyContainerData( $data[\'del-property-id\'], $data[\'del-proprty-container-data\']);
    $arRes[\'status\'] = \'del-property-ok\';
}else{

    $arRes[\'TYPE_PROPERTYS\'] = ContainerData::getAllTypePropertysContainerData();

    if (!empty($data)) {

        if (!empty($data[\'type_property\']) && ($data[\'type_property\'] != \'null\') && !empty($arRes[\'TYPE_PROPERTYS\'][$data[\'type_property\']])) {
            if (!empty($data[\'name\']) && !empty($data[\'code\'])) {

                $res = ContainerData::addPropertyContainerData( 
                    array(
                        \'id_type_property\' => $data[\'type_property\'],
                        \'id_container_data\' => $this->arParam[\'container-data-id\'],
                        \'code\' => $data[\'code\'],
                        \'name\' => $data[\'name\']
                    )
                );

                if ($res) {
                    $arRes[\'status\'] = \'add-ok\';
                } else {
                    $arRes[\'status\'] = \'add-err\';
                }

            } else {
                $arRes[\'status\'] = \'add-err\';
            }
        } else {
            $arRes[\'status\'] = \'add-err-not-type\';
        }
    }

    // найти свойства текущего container-data
    if (!empty($this->arParam[\'container-data-id\']) && is_numeric($this->arParam[\'container-data-id\'])) {
        $arRes[\'PROPERTYS\'] = ContainerData::getPropertysContainerData(array(\'=\'=>array(\'id_container_data\', $this->arParam[\'container-data-id\'])) );
    }
}

// показать шаблон
$this->template->show($arRes, $this->arParam);
',
    'TYPE' => 'php',
    'DIR' => './gy/modules/containerdata/component/containerdata_property_edit/',
  ),
  './gy/modules/containerdata/component/containerdata_property_edit/lang_componentInfo.php' => 
  array (
    'CODE' => '<?php // языковой файл для componentInfo.php
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

$mess[\'rus\'] = array(
    \'text-info\' => \'Работа с свойствами элементов контейнера данных (можно задавать свойства, которые будут доступны для заполнения у всех элементов конкретного контейнера данных)\',
    \'property-container-data-id\' => \'Id контейнера данных\'
);

$mess[\'eng\'] = array(
    \'text-info\' => \'Working with properties of elements of a data container (you can set properties that will be available for filling for all elements of a specific data container)\',
    \'property-container-data-id\' => \'Data container id\'
);',
    'TYPE' => 'php',
    'DIR' => './gy/modules/containerdata/component/containerdata_property_edit/',
  ),
  './gy/modules/containerdata/component/containerdata_property_edit/teplates/0/lang_template.php' => 
  array (
    'CODE' => '<?php // языковой файл для шаблона компонента
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

$mess[\'rus\'] = array(
    \'save\' => \'Сохранить\',
    \'back\' => \'Отменить\',
    \'not-property\' => \'свойства не заданы\',
    \'title-add-property\' => \'Добавить новое свойство\',
    \'add-property\' => \'Добавить\',
    \'add-ok\' => \'свойство добавлено\',
    \'add-err\' => \'Ошибка! попробуйте ещё раз\',
    \'add-err-not-type\' => \'Ошибка! не выбран тип свойства\',
    \'ok\' => \'ОК\',
    \'del-btn\' => \'Удалить\',
    \'del-property-ok\' => \'! свойство этого контейнера данных удалено\'
);

$mess[\'eng\'] = array(
    \'save\' => \'Save\',
    \'back\' => \'Cancel\',
    \'not-property\' => \'properties not set\',
    \'title-add-property\' => \'Add new property\',
    \'add-property\' => \'Add\',
    \'add-ok\' => \'property added\',
    \'add-err\' => \'Error! try again\',
    \'add-err-not-type\' => \'Error! property type not selected\',
    \'ok\' => \'OK\',
    \'del-btn\' => \'Delete\',
    \'del-property-ok\' => \'! property of this data container has been removed\'
);
',
    'TYPE' => 'php',
    'DIR' => './gy/modules/containerdata/component/containerdata_property_edit/teplates/0/',
  ),
  './gy/modules/containerdata/component/containerdata_property_edit/teplates/0/template.php' => 
  array (
    'CODE' => '<?php
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

if (empty($arRes[\'status\'])) {?>

    <?php if (!empty($arRes[\'PROPERTYS\'])) {?>
        <table border="1" class="gy-table-all-users">
            <tr><th>id</th><th>name</th><th>code</th><th>name type property</th><th></th></tr>
            <?php foreach ($arRes[\'PROPERTYS\'] as $val) {?>
                <tr>
                    <td><?=$val[\'id\'];?></td>
                    <td><?=$val[\'name\'];?></td>
                    <td><?=$val[\'code\'];?></td>
                    <td>type= <?=$arRes[\'TYPE_PROPERTYS\'][$val[\'id_type_property\']][\'id\']?> name= <?=$arRes[\'TYPE_PROPERTYS\'][$val[\'id_type_property\']][\'name\']?></td>
                    <td>
                        <form method="post">
                            <input type="hidden" name="del-property-id" value="<?=$val[\'id\'];?>" />
                            <input type="hidden" name="del-proprty-container-data" value="<?=$arParam[\'container-data-id\']?>" />
                            <input type="submit" class="gy-admin-button" value="<?=$this->lang->getMessage(\'del-btn\')?>"  name="<?=$this->lang->getMessage(\'del-btn\')?>" />
                        </form>
                    </td>
                </tr>
            <?php }?>
        </table>
    <?php } else {?>
        <?=$this->lang->getMessage(\'not-property\');?>
        <br/>
    <?php }?>

    <form method="post" >    
        <h4><?=$this->lang->getMessage(\'title-add-property\');?></h4>
        <table border="1" class="gy-table-all-users">
            <tr>
                <td>
                    тип свойства
                </td>
                <td>
                    <select name="type_property">
                        <option  value="null"></option>
                        <?php foreach ($arRes[\'TYPE_PROPERTYS\'] as $val) {?>
                            <option  value="<?=$val[\'id\']?>"><?=$val[\'name\']?></option> 
                        <?php }?>
                    </select>
                </td>
            </tr>
            <tr><td>name</td><td><input type="text" name="name" /></td></tr>
            <tr><td>code</td><td><input type="text" name="code" /></td></tr>    

        </table>
        <input type="submit" class="gy-admin-button" value="<?=$this->lang->getMessage(\'add-property\');?>" />
    </form>

    
<?php } else {?>    
    <?php if ($arRes[\'status\'] == \'add-ok\') {?>
        <div class="gy-admin-good-message"><?=$this->lang->getMessage(\'add-ok\');?></div>
        <br/>
    <?php } ?>

    <?php if ($arRes[\'status\'] == \'add-err\') {?>
        <div class="gy-admin-error-message"><?=$this->lang->getMessage(\'add-err\');?></div>
        <br/>
    <?php } ?>
    
    <?php if ($arRes[\'status\'] == \'add-err-not-type\') {?>
        <div class="gy-admin-error-message"><?=$this->lang->getMessage(\'add-err-not-type\');?></div>
        <br/>
    <?php } ?>
    
    <?php if ($arRes[\'status\'] == \'del-property-ok\') {?>
        <div class="gy-admin-good-message"><?=$this->lang->getMessage(\'del-property-ok\');?></div>
        <br/>
    <?php } ?>
    <a href="<?=$_SERVER[\'REQUEST_URI\']?>" class="gy-admin-button"><?=$this->lang->getMessage(\'ok\');?></a>
<?php }
  
    
',
    'TYPE' => 'php',
    'DIR' => './gy/modules/containerdata/component/containerdata_property_edit/teplates/0/',
  ),
  './gy/modules/containerdata/init.php' => 
  array (
    'CODE' => '<?php
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

/** 
 * описываю что есть в модуле 
 * - это на совести разработчика модуля
 * перечисляются имеющиеся классы и модули, а они лежат в стандартных папках 
 * (заранее обговорено какие есть разделы в модуле)
 */

// языковой файл
global $LANG;
include \'lang_init.php\';

// компоненты которые есть в модуле
$componentsThisModule = array(
    \'containerdata\',
    \'containerdata_add\',
    \'containerdata_edit\',
    \'containerdata_element_list\',
    \'containerdata_element_property\',
    \'containerdata_element_show\',
    \'containerdata_property_edit\'
);

// классы этого можуля
$classesThisModule = array(
    \'ContainerData\'
);

// страници админки
$adminPageThisModule = array(
    \'container-data-add\',
    \'container-data-edit\',
    \'container-data-element-list\',
    \'container-data-element-property\',
    \'container-data-property-edit\',
    \'container-data\',    
);

// кнопки для меню админки
$pagesFromAdminMenu = array(
    $mess[$LANG][\'name-button\'] => \'/gy/admin/get-admin-page.php?page=container-data\'
);

// пользовательское действие, и если оно разрешено текущему пользователю то он увидит 
// в меню админки кнопки $pagesFromAdminMenu
$isShowButtonsMenuAdminPanetThisModule = \'edit_container_data\';

// имя текущего модуля
$nameThisModule = \'containerdata\';

// версия текущего модуля
$versionThisModule = \'0.1\';',
    'TYPE' => 'php',
    'DIR' => './gy/modules/containerdata/',
  ),
  './gy/modules/containerdata/install/installDataBaseTable.php' => 
  array (
    'CODE' => '<?php

use Gy\\Modules\\containerdata\\Classes\\ContainerData;

if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

global $argv;
$isRunConsole = isset($argv);
$br = "\\n";

if ($isRunConsole) {

//    include __DIR__."/../gy.php"; // подключить ядро // include core

    global $DB;

    //---containerData---
    echo $br.$br.\'--install table module - containerData = start--\';

    echo $br.\'install table module - containerData = start\';
    $res = $DB->createTable( // containerData-ы
        \'container_data\',
        array( 
            \'id int PRIMARY KEY AUTO_INCREMENT\', 
            \'name varchar(50)\', 
            \'code varchar(50)\', 
        )
    );

    $res = $DB->createTable( // список свойств containerData
        \'list_propertys_container_data\',
        array(
            \'id int PRIMARY KEY AUTO_INCREMENT\',
            \'id_type_property int\',
            \'id_container_data int\',
            \'code varchar(50)\',
            \'name varchar(50)\',
        )
    );

    $res = $DB->createTable( // типы свойств containerData
        \'types_property_container_data\',
        array(
            \'id int PRIMARY KEY AUTO_INCREMENT\',
            \'info varchar(50)\',
            \'code varchar(50)\',
            \'name varchar(50)\',
            \'name_table varchar(50)\'
        )
    );

    $res = $DB->insertDb(
        \'types_property_container_data\',
        array(
            \'name\' => \'html\',
            \'code\' => \'html\',
            \'info\' => \'property save date - html\',
            \'name_table\' => \'value_propertys_type_html\'
        )
    );

    $res = $DB->insertDb(
        \'types_property_container_data\',
        array(
            \'name\' => \'number\',
            \'code\' =>   \'number\',
            \'info\' => \'property save date - number\',
            \'name_table\' => \'value_propertys_type_number\'
        )
    );

    $res = $DB->createTable( // элементы containerData-а
        \'element_container_data\',
        array(
            \'id int PRIMARY KEY AUTO_INCREMENT\',
            \'section_id int\',
            \'code varchar(50)\',
            \'name varchar(50)\',
            \'id_container_data int\',
        )
    );

    $res = $DB->createTable( // значения свойств containerData-а типа строка
        \'value_propertys_type_html\',
        array(
            \'id int PRIMARY KEY AUTO_INCREMENT\',
            \'id_container_data int\',
            \'id_element_container_data int\',
            \'id_property_container_data int\',
            \'value varchar(255)\'
        )
    );

    $res = $DB->createTable( // значения свойств containerData-а типа число
        \'value_propertys_type_number\',
        array(
            \'id int PRIMARY KEY AUTO_INCREMENT\',
            \'id_container_data int\',
            \'id_element_container_data int\',
            \'id_property_container_data int\',
            \'value int\'
        )
    );
    echo $br.\'install table module - containerData = OK!\';
    //-containerData-------------
    
    
    //--тестовый контент--
    echo $br.\'install sest content - containerData = start\';

    // добавить контейнер данных - контент
    ContainerData::addContainerData(array(\'code\'=> \'Content\',\'name\'=> \'Контент2 | Content2\'));

    $dataContentContainerData = ContainerData::getContainerData(array(\'=\' => array(\'code\', "\'Content\'")), array(\'*\'));

    //добавить свойство
    ContainerData::addPropertyContainerData(
        array(
            \'id_type_property\' => 1,
            \'id_container_data\' => $dataContentContainerData[0][\'id\'],
            \'code\' => \'html-code\',
            \'name\' => \'html вставка | html code\'
        )
    );

    // добавить элемент контейнера данных
    ContainerData::addElementContainerData(
        array(
            \'section_id\' => 0,
            \'code\' => \'html-index-page\',
            \'name\' => \'Приветствие на главной | Welcome on the main\',
            \'id_container_data\' => $dataContentContainerData[0][\'id\']
        )
    );

    // взять типы свойств что бы знать названия таблиц где их искать
    //$dataTypeProperty = ContainerData::getAllTypePropertysContainerData();
    // найти элемент
    $dataElement = ContainerData::getElementContainerData(
        array(
            \'AND\' => array(
                array( \'=\' => array( \'id_container_data\', $dataContentContainerData[0][\'id\']) ),
                array( \'=\' => array( \'code\', "\'html-index-page\'"))
            )
        )
    );

    // найти его свойства
    $propertyContainerData = ContainerData::getPropertysContainerData(
        array(
            \'=\'=>array(
                \'id_container_data\', 
                $dataContentContainerData[0][\'id\']
            ) 
        ) 
    );
    $prop = array_shift($propertyContainerData);

    // добавить значение свойства для элемента созданного выше
    ContainerData::addValuePropertyContainerData(
        $dataContentContainerData[0][\'id\'],
        $dataElement[\'id\'],
        $prop[\'id\'],
        \'value_propertys_type_html\',
        \'Привет пользователь, тебя приветствует gy php framework\'.$br.\' и текст показан из его контентной части!!!\'.
            \'| Hello user, you are greeted by the gy php framework and the text is shown from its content part !!!\'
    );

    echo $br.\'install sest content - containerData = OK!\';
    ////

    echo $br.\'add user group and action and user - containerData = start\';
    // группы пользователей и права на действия
    $DB->insertDb(
        \'action_user\',
        array(
            \'code\' => \'edit_container_data\',
            \'text\' => \'Изменение всех container-data | Edit all container-data\',
        )
    );

    $DB->insertDb(
        \'users_in_groups\',
        array(
            \'code_group\' => \'content\',
            \'id_user\' => 2,
        )
    );

    $DB->insertDb(
        \'access_group\',
        array(
            \'code\' => \'content\',
            \'name\' => \'Контент | Сontent\',
            \'text\' => \'Те кто изменяют контент сайта | Those who can change the content of the site\',
            \'code_action_user\' => \'edit_container_data\'
        )
    );
    
    echo $br.\'add user group and action and user - containerData = OK!\';


    echo $br.\'--install table module - containerData = OK!--\'.$br;

} else {
    echo \'! Error. You need to run the script in the console\';

}',
    'TYPE' => 'php',
    'DIR' => './gy/modules/containerdata/install/',
  ),
  './gy/modules/containerdata/lang_init.php' => 
  array (
    'CODE' => '<?php // языковой файл для componentInfo.php
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

$mess[\'rus\'] = array(
    \'name-button\' => \'Контейнеры данных\'
);

$mess[\'eng\'] = array(
    \'name-button\' => \'Data containers\'
);',
    'TYPE' => 'php',
    'DIR' => './gy/modules/containerdata/',
  ),
  './gy/modules/filemodule/admin/work-page-site.php' => 
  array (
    'CODE' => '<?php
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

if (Gy\\Core\\User\\AccessUserGroup::accessThisUserByAction( \'show_admin_panel\')) {

    include "../../gy/admin/header-admin.php";

    if (Gy\\Core\\User\\AccessUserGroup::accessThisUserByAction( \'work_file_module\')) {
        $APP->component(
            \'work_page_site\',
            \'0\',
            array() 
        );
    }

    include "../../gy/admin/footer-admin.php";

} else {
    header( \'Location: /gy/admin/\' );
}',
    'TYPE' => 'php',
    'DIR' => './gy/modules/filemodule/admin/',
  ),
  './gy/modules/filemodule/classes/AppFromConstructorPageComponent.php' => 
  array (
    'CODE' => '<?php

namespace Gy\\Modules\\filemodule\\Classes;

use Gy\\Core\\Module;

if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

/**
 * class AppFromConstructorPageComponent подменит собой обьект app 
 *  что бы подловить подключаемые компоненты
 */

class AppFromConstructorPageComponent
{

    private $allDateIncludeComponents = array();
    private $intKey = 0;
    public $urlProject;
    public $options; // настройки проекта 

    public function __construct($urlProject, $options)
    {
        $this->urlProject = $urlProject;
        $this->options = $options;
    }

    /**
     * getInfoAboutComponent
     *  - получить информацию о компоненте если есть файл componentInfo.php
     * 
     * @param string $name
     * @param string $template
     * @param array $arParam
     * @param string $url
     * @return array
     */
    public function getInfoAboutComponent( $name, $template, $arParam, $url )
    {
        // нужно попробовать найти подключаемый компонент среди подключённых модулей
        $module = Module::getInstance();
        $urlComponentInModule = $module->getModulesComponent($name);
        $componentInfo = array();

        if (file_exists($url.\'/customDir/component/\'.$name.\'/componentInfo.php\')) {
            require $url.\'/customDir/component/\'.$name.\'/componentInfo.php\';
        } elseif (($urlComponentInModule !== false) && file_exists($urlComponentInModule.\'/componentInfo.php\' )) {
            require $urlComponentInModule.\'/componentInfo.php\'; // может и не быть
        } elseif (file_exists($url.\'/gy/component/\'.$name.\'/componentInfo.php\')) {
            require $url.\'/gy/component/\'.$name.\'/componentInfo.php\'; // может и не быть
        }

        return $componentInfo;
    }

    /**
     * component 
     *  - метод подключения компонента, а в нашем классе возьмёт просто информацию
     *    о подключаемом компоненте
     * 
     * @global type $APP
     * @param type $name
     * @param type $template
     * @param type $arParam
     */
    public function component($name, $template, $arParam  )
    {
        global $APP;
        $this->allDateIncludeComponents[$this->intKey] = array(
            \'name\' => $name,
            \'template\' => $template,
            \'arParam\' => $arParam,
            \'componentInfo\' => self::getInfoAboutComponent( $name, $template, $arParam, $this->urlProject)
        );

        $this->intKey++;
    }

    /**
     * getAllDataIncludeComponents
     *  - получить данные по всем подключенным компонентам
     *
     * @return array
     */
    public function getAllDataIncludeComponents()
    {
        return $this->allDateIncludeComponents;
    }

    /**
     * getCodeIncludeComponent
     *  - сделать php код вызова коппонента из переданных параметров
     * 
     * @param string $componentName
     * @param string $templateName
     * @param array $arParams
     * @return string
     */
    public static function getCodeIncludeComponent($componentName, $templateName, $arParams)
    {

        $codeIncludeComponent = "\\n".\'$APP->component(\'."\\n";
        $codeIncludeComponent .= "   \'".$componentName."\',"."\\n";
        $codeIncludeComponent .= "   \'".$templateName."\',"."\\n";
        $codeIncludeComponent .= \'   array(\'."\\n";
        if (!empty($arParams)) {
            foreach ($arParams as $key => $value) {
                if (!is_numeric($value)) {
                    $codeIncludeComponent .= "     \'".$key."\' => \'".$value."\',"."\\n";
                } else {
                    $codeIncludeComponent .= "     \'".$key."\' => ".$value.",\\n";
                }
            }
        }
        $codeIncludeComponent .= \'   )\'."\\n";

        $codeIncludeComponent .= \');\'."\\n";

        return $codeIncludeComponent;
    }

}',
    'TYPE' => 'php',
    'DIR' => './gy/modules/filemodule/classes/',
  ),
  './gy/modules/filemodule/classes/Files.php' => 
  array (
    'CODE' => '<?php

namespace Gy\\Modules\\filemodule\\Classes;

if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

/**
 * Files - класс для работы с файлами
 */

class Files
{

    /**
     * createFile 
     *  - создать файл по урлу
     * 
     * @param string $url - путь к файлу
     * @return boolean
     */
    public static function createFile($url)
    {
        return file_put_contents($url, \'\');
    }

    /**
     * deleteFile
     *  - удалить файл по урлу
     * 
     * @param string $url - путь к файлу
     * @return boolean
     */
    public static function deleteFile($url)
    {
        return unlink($url);
    }

    /**
     * saveFile
     *  - сохранить текст в файл по урлу
     * 
     * @param string $url - путь к файлу
     * @param string $date - данные для записи в файл
     * @return boolean
     */
    public static function saveFile($url, $date)
    {
        return file_put_contents($url, $date);
    }

    /**
     * getContentFile
     *  - прочитать файл
     * 
     * @param string $url
     * @return boolean
     */
    public static function getContentFile($url)
    {
        return file_get_contents($url);
    }

}',
    'TYPE' => 'php',
    'DIR' => './gy/modules/filemodule/classes/',
  ),
  './gy/modules/filemodule/classes/SitePages.php' => 
  array (
    'CODE' => '<?php

namespace Gy\\Modules\\filemodule\\Classes;

use Gy\\Modules\\filemodule\\Classes\\Files;

if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

/**
 * SitePages - класс для работы со страницами сайта
 */
class SitePages
{

    /**
     * разделы в которых нельзя редактировать страницы
     * @var array
     */
    private $notEditPages = array(
        \'/gy/\',
        \'/customDir/\'
    );

    /**
     * имя файла страницы сайта
     * @var string 
     */
    private $nameFilePageSite = \'index.php\';

    /**
     * путь до проекта
     * @var string/false (false - пока не определён)
     */
    private $urlProject = false;

    /**
     * - текст ошибки
     * @var false/string - (false - нет ошибок, или текст ошибки)
     */
    public $err = false;

    public function __construct($urlProject)
    {
        if (file_exists($urlProject)) {
            $this->urlProject = $urlProject;
            return true;
        } else {
            return false;
        }
    }

    /**
     * createSitePage
     *  - создать страницу сайта (пустую)
     * 
     * @param string $urlPage - путь к файлу (до раздела без index.php)
     * @return boolean
     */
    public function createSitePage($urlPage)
    {
        if (($this->urlProject !== false) && $this->checkUrl(\'/\'.$urlPage.\'/\')) {
            // если нет директории создать её
            if (file_exists($this->urlProject.$urlPage.\'/\') === false) { // TODO вынести в класс files
                mkdir($this->urlProject.$urlPage.\'/\', 0755, true);
            }            
            return Files::createFile($this->urlProject.$urlPage.\'/\'.$this->nameFilePageSite);
        } else {
            return false;
        }
    }

    /**
     * deleteSitePage
     *  - удалить страницу сайта
     * 
     * @param string $urlPage - путь к файлу (до раздела без index.php)
     * @return boolean
     */
    public function deleteSitePage($urlPage)
    {
        if (($this->urlProject !== false) && $this->checkUrl(\'/\'.$urlPage.\'/\')) {
            $res = Files::deleteFile($this->urlProject.$urlPage.\'/\'.$this->nameFilePageSite);

            // если файлов не осталось удалить директорию // TODO вынести в класс files
            if ($res !== false) {
                if (count(scandir($this->urlProject.$urlPage.\'/\')) == 2) {  // 2ва т.е. . и .. в разделе всегда есть
                    rmdir( $this->urlProject.$urlPage.\'/\' );
                }
            }

            return $res;
        } else {
            return false;
        }
    }

    /**
     * getContextPage 
     *  - получить содержимое страницы, просто в виде текста
     * 
     * @param string $urlPage - путь к файлу (до раздела без index.php)
     * @return false/string
     */
    public function getContextPage($urlPage)
    {
        if (($this->urlProject !== false) &&  $this->checkUrl(\'/\'.$urlPage.\'/\')) {
            return Files::getContentFile($this->urlProject.$urlPage.\'/\'.$this->nameFilePageSite);
        } else {
            return false;
        }
    }

    /**
     * putContextPage 
     *  - сохранить на страницу текст
     * 
     * @param string $urlPage - путь к файлу (до раздела без index.php)
     * @param string $date - содержимое страницы
     * @return boolean
     */
    public function putContextPage($urlPage, $date)
    {
        if (($this->urlProject !== false) && $this->checkUrl(\'/\'.$urlPage.\'/\')) {
            return Files::saveFile($this->urlProject.$urlPage.\'/\'.$this->nameFilePageSite, $date);
        } else {
            return false;
        }
    }

    /**
     * checkUrl
     *  - проверит можно ли работать с урлом
     * 
     * @param string $url
     * @return boolean
     */
    private function checkUrl($url)
    {
        $result = true;
        foreach ($this->notEditPages as $value) {
            if (strripos($url, $value) !== false) {
                $result = false;
            }
        }
        return $result;
    }

}',
    'TYPE' => 'php',
    'DIR' => './gy/modules/filemodule/classes/',
  ),
  './gy/modules/filemodule/component/work_page_site/componentInfo.php' => 
  array (
    'CODE' => '<?php
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

use Gy\\Core\\Lang;

global $APP;
$utlThisComponent = "/gy/modules/filemodule/component/work_page_site/";
$langComponentInfo = new Lang($APP->urlProject.$utlThisComponent, \'componentInfo\', $APP->options[\'lang\']);

$componentInfo = array(
    \'name\' => \'work_page_site\',
    \'text-info\' => $langComponentInfo->getMessage(\'text-info\'),
    \'v\' => \'0.1\',
    \'all-property\' => array()
);',
    'TYPE' => 'php',
    'DIR' => './gy/modules/filemodule/component/work_page_site/',
  ),
  './gy/modules/filemodule/component/work_page_site/controller.php' => 
  array (
    'CODE' => '<?php 

use Gy\\Modules\\filemodule\\Classes\\AppFromConstructorPageComponent;
use Gy\\Modules\\filemodule\\Classes\\SitePages;

if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

$data = $_POST;

global $arRes;

// создание страницы сайта
if (!empty($data[\'action-1\'])) {
    
    global $APP;
    $sitePage = new SitePages($APP->urlProject.\'/\');

    $res = $sitePage->createSitePage($data[\'url-site-page\']);
    
    if ($res !== false) {
        $arRes[\'status\'] = \'add-ok\';
    } else {
        $arRes[\'status\'] = \'err\';
    }
}

// удаление страницы
if (!empty($data[\'action-3\']) && empty($arRes[\'status\'])) {

    global $APP;
    $sitePage = new SitePages($APP->urlProject.\'/\');

    $res = $sitePage->deleteSitePage($data[\'url-site-page\']);

    if ($res !== false) {
        $arRes[\'status\'] = \'del-ok\';
    } else {
        $arRes[\'status\'] = \'err\';
    }
}

// изменение страницы
if (!empty($data[\'action-2\']) && empty($arRes[\'status\'])) {
    global $APP;
    $sitePage = new SitePages($APP->urlProject.\'/\');

    $res = $sitePage->getContextPage($data[\'url-site-page\']);

    if ($res !== false) {
        $arRes[\'data-file\'] = $res;
        $arRes[\'url-site-page\'] = $data[\'url-site-page\'];
        $arRes[\'status\'] = \'edit\';
    } else {
        $arRes[\'status\'] = \'err\';
    }
}

// изменение файла
if (!empty($data[\'action-2-1\']) && !empty($data[\'url-site-page\']) && !empty($data[\'new-text-page\'])) {
    global $APP;
    $sitePage = new SitePages($APP->urlProject.\'/\');

    $res = $sitePage->putContextPage($data[\'url-site-page\'], $data[\'new-text-page\']);
    if ($res !== false) {
        $arRes[\'status\'] = \'edit-ok\';
    } else {
        $arRes[\'status\'] = \'err\';
    }
}

// открыть редактируемую страницу
if (!empty($data[\'action-4\'])) {
    header("Location: /".$data[\'url-site-page\'] );
}

if (!empty($data[\'action-5\'])) {    
    ob_start();
    // сохраним основной app обьект
    global $APP;
    $APPGlobal = $APP;

    // переопределим app
    $APP = new AppFromConstructorPageComponent($APP->urlProject, $APP->options );

    $url = $APPGlobal->urlProject.((!empty($data[\'url-site-page\']))? "/" : "").$data[\'url-site-page\']."/index.php";

    include $url; // !! надо не подключать ядро

    $arRes[\'dataIncludeAllComponentsInThisPageSite\'] = $APP->getAllDataIncludeComponents();

    // хочу найти поля обьявленные в компоненте как возможные но не заполненные в коде
    foreach ($arRes[\'dataIncludeAllComponentsInThisPageSite\'] as $key => $value) {
        if (!empty($value[\'componentInfo\'][\'all-property\'])) {
            foreach ($value[\'componentInfo\'][\'all-property\'] as $key2 => $value2) {
                if (empty($value[\'arParam\'][$value2])) {
                    $arRes[\'dataIncludeAllComponentsInThisPageSite\'][$key][\'arParam\'][$value2] = \'\';
                }
            }
        }
    }
    $arRes[\'url-site-page\'] = $data[\'url-site-page\'];

    // вернём как было
    $APP = $APPGlobal;
    unset($APPGlobal);
    ob_end_clean();
    
    $arRes[\'status\'] = \'constructor\';
}

function getCodePageByArrayComponents($arrayComponents){
    $codePage = \'<?php include $_SERVER["DOCUMENT_ROOT"]."/gy/gy.php"; // подключить ядро // include core 

global $APP;

    \';

    // добавить коды компонентов
    if (is_array($arrayComponents)) {
        foreach ($arrayComponents as $value) {
            $codeIncludeComponent = AppFromConstructorPageComponent::getCodeIncludeComponent($value[\'component\'], $value[\'tempalate\'], $value[\'params\']);
            $codePage .= $codeIncludeComponent."\\n";   
        }
    }
    return $codePage;
}

function savePageByArrayComponents($page, $arrayComponents){
    $codePage = getCodePageByArrayComponents($arrayComponents);

    global $APP;
    $sitePage = new SitePages($APP->urlProject.\'/\');

    $res = $sitePage->putContextPage( $page, $codePage);

    global $arRes;
    if ($res !== false) {
        $arRes[\'status\'] = \'edit-ok\';
    } else {
        $arRes[\'status\'] = \'err\';
    }
}

// сохранить всю страницу по компонентам
if (!empty($data[\'action-6\'])) {    
    savePageByArrayComponents($data[\'url-site-page\'], $data[\'component\']);
}

// перемещение компонента ниже
if (!empty($data[\'action7_2\']) && is_array($data[\'action7_2\'])) {
    foreach ($data[\'action7_2\'] as $key => $value) {
        //
    }

    if (!empty($data[\'component\'][$key+1])) {
        $temp = $data[\'component\'][$key];
        $data[\'component\'][$key] = $data[\'component\'][$key+1];
        $data[\'component\'][$key+1] = $temp;
        unset($temp);
    }

    // записать всё обратно из получившегося набора компонентов
    savePageByArrayComponents($data[\'url-site-page\'], $data[\'component\']);

}

// перемещение компонента выше
if (!empty($data[\'action7_1\']) && is_array($data[\'action7_1\'])) {
    foreach ($data[\'action7_1\'] as $key => $value) {
        //
    }

    if (($key - 1) >= 0) {
        $temp = $data[\'component\'][$key];
        $data[\'component\'][$key] = $data[\'component\'][$key-1];
        $data[\'component\'][$key-1] = $temp;
        unset($temp);
    }

    // записать всё обратно из получившегося набора компонентов
    savePageByArrayComponents($data[\'url-site-page\'], $data[\'component\']);
}

// удалить компонент
if (!empty($data[\'action7_3\']) && is_array($data[\'action7_3\'])) {
    foreach ($data[\'action7_3\'] as $key => $value) {
        //
    }

    if (!empty($data[\'component\'][$key])) {
        unset($data[\'component\'][$key]);
    }
    
    // записать всё обратно из получившегося набора компонентов
    savePageByArrayComponents($data[\'url-site-page\'], $data[\'component\']);
}

// добавление компонента
if (!empty($data[\'action_8\']) && is_array($data[\'action_8\'])) {
    foreach ($data[\'action_8\'] as $key => $value) {
        //
    }

    $arRes[\'status\'] = \'addConstructor\';
    $arRes[\'url-site-page\'] = $data[\'url-site-page\'];
    $arRes[\'key\'] = $key; // где вставлять компонент в какую позицию

}

// первый шаг добавления компонента
if (!empty($data[\'action_8_1\'])) {
    
    if (
        !empty($data[\'url-site-page\'])
        && (!empty($data[\'position_new_component\']) || ($data[\'position_new_component\'] == 0) )
        && !empty($data[\'name_new_component\'])
    ) {
    
        // шаблон по умолчанию 0
        if (empty($data[\'name_new_template\'])) {
            $data[\'name_new_template\'] = \'0\';
        }

        global $APP;

        // проверим есть ли такой компонент (точнее файл информации о нём)
        $dataComponent = AppFromConstructorPageComponent::getInfoAboutComponent(
            $data[\'name_new_component\'], 
            $data[\'name_new_template\'],
            array(),
            $APP->urlProject
        );

        if (!empty($dataComponent)) {
            $arRes[\'status\'] = \'good-component\';

            $arRes[\'url-site-page\'] = $data[\'url-site-page\'];
            $arRes[\'position_new_component\'] = $data[\'position_new_component\'];

            $arRes[\'data-component\'] = array(
                \'name\' => $data[\'name_new_component\'],
                \'template\' => $data[\'name_new_template\'],
                \'arParam\' => $dataComponent[\'all-property\'],
                \'componentInfo\' => $dataComponent
            );
        } else {
            $arRes[\'status\'] = \'error-not-component\';
        }
    } else {
        $arRes[\'status\'] = \'error-not-component\';
    }
}

// надо добавить новый компонент на выбранную страницу
if( !empty($data[\'action_8_2\']) 
    && !empty($data[\'url-site-page\'])
    && (!empty($data[\'position_new_component\']) || ($data[\'position_new_component\'] == 0) )
    && !empty($data[\'name_new_component\'])
    && (!empty($data[\'name_new_template\']) || ($data[\'name_new_template\'] == 0) )
) {
    // надо взять все компоненты с редактируемой страницы
    
    ob_start();
    
    // сохраним основной app обьект
    global $APP;
    $APPGlobal = $APP;

    // переопределим app
    $APP = new AppFromConstructorPageComponent($APP->urlProject, $APP->options );

    $url = $APPGlobal->urlProject.((!empty($data[\'url-site-page\']))? "/" : "").$data[\'url-site-page\']."/index.php";

    include $url; // !! надо не подключать ядро

    $allComponentsThisPage = $APP->getAllDataIncludeComponents();
    // вернём как было
    $APP = $APPGlobal;
    unset($APPGlobal);
    
    ob_end_clean();
    
    $newArrayComponents = array();

    if ($data[\'position_new_component\'] == "\'-1\'") {
        $newArrayComponents[] = array(
            \'name\' => $data[\'name_new_component\'],
            \'template\' => $data[\'name_new_template\'],
            \'arParam\' => $data[\'params\']
        );
        foreach ($allComponentsThisPage as $value) {
            $newArrayComponents[] = $value;
        }
    } elseif (is_numeric($data[\'position_new_component\'])) {
        $data[\'position_new_component\']++;
        $flagAdd = false;
        foreach ($allComponentsThisPage as $key => $value) {
            if ($data[\'position_new_component\'] == $key) {
                $newArrayComponents[] =  array(
                    \'name\' => $data[\'name_new_component\'],
                    \'template\' => $data[\'name_new_template\'],
                    \'arParam\' => $data[\'params\']
                );
                $flagAdd  = true;
            }
            $newArrayComponents[] = $value;
        }
        if (!$flagAdd) {
            $newArrayComponents[] =  array(
                \'name\' => $data[\'name_new_component\'],
                \'template\' => $data[\'name_new_template\'],
                \'arParam\' => $data[\'params\']
            );
        }
    }
    unset($allComponentsThisPage);
        
    // правильно подготовить массив с компонентами 
    $trueNewArrayComponents = array();
    foreach ($newArrayComponents as $value) {
        $trueNewArrayComponents[] = array(
            \'component\' => $value[\'name\'],
            \'tempalate\' => $value[\'template\'],
            \'params\' => $value[\'arParam\']
        );
    }

    // сохранить всё на страницу
    savePageByArrayComponents($data[\'url-site-page\'], $trueNewArrayComponents);
    
}

// показать шаблон
$this->template->show($arRes, $this->arParam);
',
    'TYPE' => 'php',
    'DIR' => './gy/modules/filemodule/component/work_page_site/',
  ),
  './gy/modules/filemodule/component/work_page_site/lang_componentInfo.php' => 
  array (
    'CODE' => '<?php // языковой файл для componentInfo.php
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

$mess[\'rus\'] = array(
    \'text-info\' => \'Редактор страниц сайта (и конструктор по компонентам)\',
);

$mess[\'eng\'] = array(
    \'text-info\' => \'Site page editor (and component builder)\',
);',
    'TYPE' => 'php',
    'DIR' => './gy/modules/filemodule/component/work_page_site/',
  ),
  './gy/modules/filemodule/component/work_page_site/teplates/0/lang_template.php' => 
  array (
    'CODE' => '<?php // языковой файл для шаблона компонента
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

$mess[\'rus\'] = array(
    \'title-edit-file\' => \'Работа со страницами сайта\',
    \'text-input-url-page\' => \'Укажите путь к страницы над которой хотите произвести действие\',
    \'ok\' => \'ok\',
    \'add-ok\' => \'Страница успешно создана\',
    \'del-ok\' => \'Страница успешно удалена\',
    \'text-edit-page\' => \'Вы редактируете страницу\',
    \'err\' => \'Произошла ошибка\',
    \'edit-ok\' => \'Страница успешно изменена\',
    \'title-action-5\' => \'Конструктор страницы (редактирование по компонентам)\',
    \'title-action-4-show-page\' => \'Посмотреть страницу\',
    \'title-delete-page\' => \'Удалить страницу\',
    \'title-edit-page\' => \'Изменить страницу\',
    \'title-add-page\' => \'Создать страницу (заменит если уже есть)\',
    \'text-include-components\' => \'На странице подключено компонентов - \',
    \'text-include-this-component\' => \'Компонент - \',
    \'name-template\' => \'Имя шаблона:\',
    \'params-component\' => \'Параметры вызова компонента:\',
    \'param-name\' => \'Название параметра\',
    \'param-value\' => \'Значение параметра\',
    \'text-button-save\' => \'Сохранить\',
    \'text-button-save2\' => \'Сохранить страницу\',
    \'text-button-del-component\' => \'Удалить этот компонент (и сохранить изменения)\',
    \'include-component\' => \'Вызываемый компонент страницы №\',
    \'text-button-up-component\' => \'Переместить компонент выше (и сохранить изменения)\',
    \'text-button-down-component\' => \'Переместить компонент ниже (и сохранить изменения)\',
    \'add-component\' => \'Добавить компонент ниже\',
    \'warning-text-1\' => \'Внимание! код страницы оформленный не компонентами уничтожится.\',
    \'title-action-8\' => \'Добавление нового компонента на страницу\',
    \'name-new-component\' => \'Введите имя компонента\',
    \'name-new-template\' => \'Введите имя шаблона компонента (0 - по умолчанию)\',
    \'next\' => \'Далее\',
    \'not-component\' => \'Выбранного компонента не существует\',
    \'next_final\' => \'Добавить компонент\',
    \'this_component\' => \'Выбран компонент\',
    \'this_v_component\' => \'Версия компонента\',
    \'this_component_text_info\' => \'Описание компонента\',
    \'this_template_component\' => \'Выбранный шаблон компонента\',
    \'param-info-text\' => \'Описание\'
);

$mess[\'eng\'] = array(
    \'title-edit-file\' => \'Working with site pages\',
    \'text-input-url-page\' => \'Specify the path to the page on which you want to perform an action\',
    \'ok\' => \'ok\',
    \'add-ok\' => \'Page created successfully\',
    \'del-ok\' => \'Page successfully deleted\',
    \'text-edit-page\' => \'You are editing the page\',
    \'err\' => \'An error has occurred\',
    \'edit-ok\' => \'Page changed successfully\',
    \'title-action-5\' => \'Page Builder (edit by component)\',
    \'title-action-4-show-page\' => \'View page\',
    \'title-delete-page\' => \'Delete page\',
    \'title-edit-page\' => \'Edit page\',
    \'title-add-page\' => \'Create page (replaces if already exists)\',
    \'text-include-components\' => \'The page has connected components - \',
    \'text-include-this-component\' => \'Component - \',
    \'name-template\' => \'Template name:\',
    \'params-component\' => \'Component call parameters:\',
    \'param-name\' => \'Parameter name\',
    \'param-value\' => \'Parameter value\',
    \'text-button-save\' => \'Save\',
    \'text-button-save2\' => \'Save Page\',
    \'text-button-del-component\' => \'Remove this component (and save changes)\',
    \'include-component\' => \'Called Component of Page #\',
    \'text-button-up-component\' => \'Move component up (and save changes)\',
    \'text-button-down-component\' => \'Move component below (and save changes)\',
    \'add-component\' => \'Add component below\',
    \'warning-text-1\' => \'Attention! the page code decorated with non-components will be destroyed.\',
    \'title-action-8\' => \'Adding a new component to the page\',
    \'name-new-component\' => \'Enter component name\',
    \'name-new-template\' => \'Enter a name for the component template (0 is the default)\',
    \'next\' => \'Next\',
    \'not-component\' => \'The selected component does not exist\',
    \'next_final\' => \'Add component\',
    \'this_component\' => \'Component selected\',
    \'this_v_component\' => \'Component version\',
    \'this_component_text_info\' => \'Component Description\',
    \'this_template_component\' => \'Selected component template\',
    \'param-info-text\' => \'Description\'
);
',
    'TYPE' => 'php',
    'DIR' => './gy/modules/filemodule/component/work_page_site/teplates/0/',
  ),
  './gy/modules/filemodule/component/work_page_site/teplates/0/style.css' => 
  array (
    'CODE' => '.textarea-code{
    background-color: #e5e5ff;
}
.data-component{
    background-color: #5f9ea0ba;
    margin-bottom: 20px;
    margin-top: 20px;
    padding: 10px;
    width: 800px;
    box-shadow: 0.4em 0.4em 5px rgba(122,122,122,0.5);
    border: dashed #4f6c6d;
}
.title-n-component{
    width: 100%;
    text-align: center;
    border-bottom: 2px solid #4f6b6d;
}

.gy-table-all-users th{
    padding: 5px;
    background-color: #21a2ff9e
}
.gy-table-all-users{
    background-color: #8cc7f25e;
}
.button-function .gy-admin-button{
    margin-bottom: 0px;
}
.button-function .gy-admin-button{
    padding: 9px 30px 9px;
    width: 500px;
    margin-left: 0px;
}
form > .button-function > .input-text{
    padding: 9px 30px 9px;
    width: 420px;
    margin-left: 3px;
    margin-right: 3px;
}
.warning{
    color: #c73838;
    font-size: 14pt;
    font-weight: 700;
}',
    'TYPE' => 'css',
    'DIR' => './gy/modules/filemodule/component/work_page_site/teplates/0/',
  ),
  './gy/modules/filemodule/component/work_page_site/teplates/0/template.php' => 
  array (
    'CODE' => '<?php
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );?>

<h1><?=$this->lang->getMessage(\'title-edit-file\');?></h1>

<?php if (empty($arRes[\'status\'])) {?>
    <form method="post">
        <h4><?=$this->lang->getMessage(\'text-input-url-page\');?></h4>
        <div class="button-function">
            <span>/</span><input class="input-text" type="text" name="url-site-page" /><span>/index.php</span>
            <?php // TODO сделать выбор из имеющихся?>
            <br/>
            <input class="gy-admin-button" type="submit" name="action-1" value="<?=$this->lang->getMessage(\'title-add-page\');?>" />
            <br/>
            <input class="gy-admin-button" type="submit" name="action-2" value="<?=$this->lang->getMessage(\'title-edit-page\');?>" />
            <br/>
            <input class="gy-admin-button" type="submit" name="action-3" value="<?=$this->lang->getMessage(\'title-delete-page\');?>" />
            <br/>
            <br/>
            <input class="gy-admin-button" type="submit" name="action-4" value="<?=$this->lang->getMessage(\'title-action-4-show-page\');?>" />
            <br/>
            <input class="gy-admin-button" type="submit" name="action-5" value="<?=$this->lang->getMessage(\'title-action-5\');?>" />
            <br/>
        </div>
    </form>
<?php } else {
    if ( ($arRes[\'status\'] != \'edit\')
        && ($arRes[\'status\'] != \'err\')
        && ($arRes[\'status\'] != \'constructor\')
        && ($arRes[\'status\'] != \'addConstructor\')
        && ($arRes[\'status\'] != \'error-not-component\')
        && ($arRes[\'status\'] != \'good-component\')
    ) {?>
        <div class="gy-admin-good-message"><?=$this->lang->getMessage($arRes[\'status\']);?></div>
        <br/>
        <a href="/gy/admin/get-admin-page.php?page=work-page-site" class="gy-admin-button"><?=$this->lang->getMessage(\'ok\');?></a>
    <?php } elseif ($arRes[\'status\'] == \'edit\') { ?>
        <form method="post">
            <h4><?=$this->lang->getMessage(\'text-edit-page\');?></h4>
            <input type="hidden" name="url-site-page" value="<?=$arRes[\'url-site-page\']?>" />
            <span><?=$arRes[\'url-site-page\']?>/index.php</span>
            <br/>
            <br/>
            <textarea class="textarea-code" rows="50" cols="120" name="new-text-page"><?=$arRes[\'data-file\']?></textarea>
            <br/>
            <br/>
            <input class="gy-admin-button" type="submit" name="action-2-1" value="<?=$this->lang->getMessage(\'text-button-save\');?>" />
            <br/>
            <br/>
            <br/>
            <br/>
            <br/>
        </form>
    <?php } elseif ($arRes[\'status\'] == \'err\') { ?>
        <div class="gy-admin-error-message"><?=$this->lang->getMessage($arRes[\'status\']);?></div>
        <br/>
        <a href="/gy/admin/get-admin-page.php?page=work-page-site" class="gy-admin-button"><?=$this->lang->getMessage(\'ok\');?></a>
    <?php } elseif ($arRes[\'status\'] == \'constructor\') {?>
        <h4><?=$this->lang->getMessage(\'title-action-5\');?></h4>
        <?php
        $countIncludeComponentsInPageSite = count($arRes[\'dataIncludeAllComponentsInThisPageSite\']);?>

        <p><?=$this->lang->getMessage(\'text-include-components\');?><?=$countIncludeComponentsInPageSite;?></p>

        <form method="post">
            <input type="hidden" name="url-site-page" value="<?=$arRes[\'url-site-page\']?>" />

            <input
                class="gy-admin-button" 
                type="submit" 
                name="action_8[\'-1\']" 
                value="<?=$this->lang->getMessage(\'add-component\');?>" 
            />
            <?php foreach ($arRes[\'dataIncludeAllComponentsInThisPageSite\'] as $key => $component) { ?>
                <div class="data-component">
                    <div class="title-n-component"><?=$this->lang->getMessage(\'include-component\');?><?=$key?></div>
                    <p><?=$this->lang->getMessage(\'text-include-this-component\');?><?=$component[\'name\']?></p>
                    <input type="hidden" name="component[<?=$key;?>][component]" value="<?=$component[\'name\']?>">
                    <p>
                        <?=$this->lang->getMessage(\'name-template\');?>
                        <input type="text" name="component[<?=$key;?>][tempalate]" value="<?=$component[\'template\']?>">
                    </p>

                    <?php if (!empty($component[\'componentInfo\'][\'v\'])) {?>
                        <p>
                            <?=$this->lang->getMessage(\'this_v_component\');?>: <?=$component[\'componentInfo\'][\'v\']?>
                        </p>
                    <?php }?>
                        
                    <?php if (!empty($component[\'componentInfo\'][\'text-info\'])) {?>
                        <p>
                            <?=$this->lang->getMessage(\'this_component_text_info\');?>: <?=$component[\'componentInfo\'][\'text-info\']?>
                        </p>
                    <?php }?>

                    <p>
                        <?=$this->lang->getMessage(\'params-component\');?>
                    </p>
                    <table border="1" class="gy-table-all-users">
                        <tr>
                            <th><?=$this->lang->getMessage(\'param-name\');?></th>
                            <th><?=$this->lang->getMessage(\'param-value\');?></th>
                            <th><?=$this->lang->getMessage(\'param-info-text\');?></th>
                        </tr>
                        <?php 
                        // TODO компонент includeHtml в параметре html с кавычками и всё ламается
                        //    пока заменил input на textarea надо протестить

                        foreach ($component[\'arParam\'] as $keyParam => $valueParam) { ?>
                            <tr>
                                <td><?=$keyParam?></td>
                                <td>
                                    <textarea type="text" name="component[<?=$key;?>][params][<?=$keyParam?>]" ><?=$valueParam?></textarea>
                                </td>
                                <td>
                                    <?php if (!empty($component[\'componentInfo\'][\'all-property-text\'][$keyParam])) {?>
                                        <?=$component[\'componentInfo\'][\'all-property-text\'][$keyParam]?>
                                    <?php }?>
                                </td>
                            </tr>   
                        <?php }?>
                    </table>    
                    
                    <div class="button-function">
                        <input 
                            class="gy-admin-button" 
                            type="submit" 
                            name="action7_3[<?=$key;?>]" 
                            value="<?=$this->lang->getMessage(\'text-button-del-component\');?>" 
                        />
                        <br/>
                        <input 
                            class="gy-admin-button" 
                            type="submit" 
                            name="action7_1[<?=$key;?>]" 
                            value="<?=$this->lang->getMessage(\'text-button-up-component\');?>" 
                        />
                        <br/>
                        <input
                            class="gy-admin-button" 
                            type="submit" 
                            name="action7_2[<?=$key;?>]" 
                            value="<?=$this->lang->getMessage(\'text-button-down-component\');?>" 
                        />
                        <br/>
                        <input
                            class="gy-admin-button" 
                            type="submit" 
                            name="action_8[<?=$key;?>]" 
                            value="<?=$this->lang->getMessage(\'add-component\');?>" 
                        />
                    </div>
                    <br/>
                </div>
            <?php }?>

            <input class="gy-admin-button" type="submit" name="action-6" value="<?=$this->lang->getMessage(\'text-button-save2\');?>" />
            <br/>
            <span class="warning">*<?=$this->lang->getMessage(\'warning-text-1\');?></span>
            <br/>
            <br/>
            <br/>
            <br/>

        </form>
                
    <?php } elseif ($arRes[\'status\'] == \'addConstructor\') { // если добавление компонента ?>
        <h4><?=$this->lang->getMessage(\'title-action-8\');?></h4>
        <form method="post">
            <input type="hidden" name="url-site-page" value="<?=$arRes[\'url-site-page\']?>" />
            <input type="hidden" name="position_new_component" value="<?=$arRes[\'key\']?>" />
            <p>
                <?=$this->lang->getMessage(\'name-new-component\');?>
                <input type="text" name="name_new_component">
                <?php // TODO сделать выбор из имеющихся + выводить описаие?>
            </p>
            <p>
                <?=$this->lang->getMessage(\'name-new-template\');?>
                <input type="text" name="name_new_template" >
            </p>
            <input
                class="gy-admin-button" 
                type="submit" 
                name="action_8_1" 
                value="<?=$this->lang->getMessage(\'next\');?>" 
            />
            
        </form>
    <?php } elseif ( $arRes[\'status\'] == \'error-not-component\') { // ошибка при добавление компонента (не найден компонент)?>
        <div class="gy-admin-error-message"><?=$this->lang->getMessage(\'not-component\');?></div>
        <br/>
        <a href="/gy/admin/get-admin-page.php?page=work-page-site" class="gy-admin-button"><?=$this->lang->getMessage(\'ok\');?></a>
    <?php } elseif ($arRes[\'status\'] == \'good-component\') { // последний шаг добавления компонента, ввод параметров компонента ?>   
        <h4><?=$this->lang->getMessage(\'title-action-8\');?></h4>
        <form method="post">
            <input type="hidden" name="url-site-page" value="<?=$arRes[\'url-site-page\']?>" />
            <input type="hidden" name="position_new_component" value="<?=$arRes[\'position_new_component\']?>" />
            <p>
                <?=$this->lang->getMessage(\'this_component\');?>: <?=$arRes[\'data-component\'][\'name\']?>
                <input type="hidden" name="name_new_component" value="<?=$arRes[\'data-component\'][\'name\']?>">
            </p>
            
            <?php if (!empty($arRes[\'data-component\'][\'componentInfo\'][\'v\'])) {?>
                <p>
                    <?=$this->lang->getMessage(\'this_v_component\');?>: <?=$arRes[\'data-component\'][\'componentInfo\'][\'v\']?>
                </p>
            <?php }?>
                
            <?php if (!empty($arRes[\'data-component\'][\'componentInfo\'][\'text-info\'])) {?>
                <p>
                    <?=$this->lang->getMessage(\'this_component_text_info\');?>: <?=$arRes[\'data-component\'][\'componentInfo\'][\'text-info\']?>
                </p>
            <?php }?>
            
            <p>
                <?=$this->lang->getMessage(\'this_template_component\');?>: <?=$arRes[\'data-component\'][\'template\']?>
                <input type="hidden" name="name_new_template" value="<?=$arRes[\'data-component\'][\'template\']?>">
            </p>
           
            <table border="1" class="gy-table-all-users">
                <tr>
                    <th><?=$this->lang->getMessage(\'param-name\');?></th>
                    <th><?=$this->lang->getMessage(\'param-value\');?></th>
                    <th><?=$this->lang->getMessage(\'param-info-text\');?></th>
                </tr>
                <?php
                foreach ($arRes[\'data-component\'][\'arParam\'] as $keyParam => $valueParam) { ?>
                    <tr>
                        <td><?=$valueParam?></td>
                        <td>
                            <textarea type="text" name="params[<?=$valueParam?>]" ></textarea>
                        </td>
                        <td>
                            <?php if (!empty($arRes[\'data-component\'][\'componentInfo\'][\'all-property-text\'][$valueParam])) {?>
                                <?=$arRes[\'data-component\'][\'componentInfo\'][\'all-property-text\'][$valueParam]?>
                            <?php }?>
                        </td>
                    </tr>   
                <?php }?>
            </table>  

            <input
                class="gy-admin-button" 
                type="submit" 
                name="action_8_2" 
                value="<?=$this->lang->getMessage(\'next_final\');?>" 
            />
            
        </form> 

    <?php }
}
',
    'TYPE' => 'php',
    'DIR' => './gy/modules/filemodule/component/work_page_site/teplates/0/',
  ),
  './gy/modules/filemodule/init.php' => 
  array (
    'CODE' => '<?php
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

/** 
 * описываю что есть в модуле 
 * - это на совести разработчика модуля
 * перечисляются имеющиеся классы и модули, а они лежат в стандартных папках 
 * (заранее обговорено какие есть разделы в модуле)
 */

// языковой файл
global $LANG;
include \'lang_init.php\';

// компоненты которые есть в модуле
$componentsThisModule = array(
    \'work_page_site\'
);

// классы этого можуля
$classesThisModule = array(
    \'Files\',
    \'SitePages\',
    \'AppFromConstructorPageComponent\'
);

// страници админки
$adminPageThisModule = array(
    \'work-page-site\',
);

// кнопки для меню админки
$pagesFromAdminMenu = array(
    $mess[$LANG][\'name-button\'] => \'/gy/admin/get-admin-page.php?page=work-page-site\'
);

// пользовательское действие, и если оно разрешено текущему пользователю то он увидит 
// в меню админки кнопки $pagesFromAdminMenu
$isShowButtonsMenuAdminPanetThisModule = \'work_file_module\';

// имя текущего модуля
$nameThisModule = \'filemodule\';

//версия текущего модуля
$versionThisModule = \'0.1\';',
    'TYPE' => 'php',
    'DIR' => './gy/modules/filemodule/',
  ),
  './gy/modules/filemodule/lang_init.php' => 
  array (
    'CODE' => '<?php // языковой файл для componentInfo.php
if (!defined("GY_CORE") && (GY_CORE !== true)) die( "gy: err include core" );

$mess[\'rus\'] = array(
    \'name-button\' => \'Работа со страницами сайта\'
);

$mess[\'eng\'] = array(
    \'name-button\' => \'Working with site pages\'
);',
    'TYPE' => 'php',
    'DIR' => './gy/modules/filemodule/',
  ),
  './gy/style/main.css' => 
  array (
    'CODE' => '.gy-body-admin{
    /*background-color: #adade4;*/
    background: url(/gy/images/fon.png) #9292ef;
}

/*--форма авторизации--*/
.gy-admin-button{
    box-shadow: 0.4em 0.4em 5px rgba(122,122,122,0.5);
    margin: 15px;
    border: 0;
    height: auto;
    padding: 15px 15px 14px;
    background-color: #639;
    border-radius: 2px;
    color: #fff;
    font-size: 14px;
    font-weight: 700;
    cursor: pointer;
} 
.gy-admin-button:hover { 
    background: #8b5db9; 
}
.gy-admin-button:active { 
    background: #412260; 
}

.gy-body-admin input[type="text"]{
    width: 250px;
    font-size: 13px;
    padding: 6px 0 4px 10px;
    border: 0px solid #ddeff6;
    background: #ddeff6;
    margin: 15px;
    color: #040b57;
}

.gy-body-admin input[type="password"]{
    width: 250px;
    font-size: 13px;
    padding: 6px 0 4px 10px;
    border: 0px solid #ddeff6;
    background: #ddeff6;
    margin: 15px;
    color: #040b57;
}
/*-----*/

.gy-admin-button-min{
    box-shadow: 0.4em 0.4em 5px rgba(122,122,122,0.5);
    margin: 0px;
    border: 0;
    height: auto;
    padding: 2px 30px 4px;
    background-color: #639;
    border-radius: 2px;
    color: #fff;
    font-size: 14px;
    font-weight: 700;
    cursor: pointer;
} 
.gy-admin-button-min:hover { 
    background: #8b5db9; 
}
.gy-admin-button-min:active { 
    background: #412260; 
}

/*--меню--*/
.gy-admin-menu{
    background-color: #3257a2;
    padding: 0 0 0 30px;
    margin-bottom: 20px;
    box-shadow: 2px 0 7px #b3b3b3, -2px 0 7px #b3b3b3;
}

.gy-admin-menu a{
    display: inline-block;
    /*width: 115px;*/
    text-align: center;
    text-decoration: none;
    padding: 7px 10px 7px 10px;
    color: #ffffff;
    border-right: 1px solid #fff;
    font-size: 18px;
}
.gy-admin-menu a:hover{
    color: #fff;
    background-color: #5b81ce;
    text-decoration: underline;
}
.active-menu{
    color: #fff;
    background-color: #5b81ce;
}
/*-----*/

.gy-admin-logo{
    text-shadow: 1px 1px 2px #05ff07, 0 0 1em #0205ff;

}

.gy-admin-error-message{
    margin: 15px;
    background-color: #fea8ab;
    padding: 10px;
}

.gy-admin-good-message{
    margin: 15px;
    background-color: #beffb7;
    padding: 10px;
}

/*--таблицы--*/
.gy-table-all-users{
    border-collapse: collapse;
    background-color: #8cc7f2;
    box-shadow: 0.4em 0.4em 5px rgba(122,122,122,0.5);
}

.gy-table-all-users td{
    padding: 10px;
}

.gy-table-all-users th{
    padding: 10px;
    background-color: #21a2ff;
}

/*-----*/

form{
    margin-bottom: 0px;
}

.version-gy-core{
    padding-left: 0px;
    position: absolute;
    top: 35px;
    font-size: 9pt;
    font-style: italic;
    background-color: aquamarine;
    left: 250px;
}',
    'TYPE' => 'css',
    'DIR' => './gy/style/',
  ),
  './gy/test/testLoger.php' => 
  array (
    'CODE' => '<? 
/*
include $_SERVER["DOCUMENT_ROOT"]."/gy/gy.php"; // подключить ядро // include core 
	
$logger = new Psr\\Log\\Logger\\Logger();

$logger->routes->attach(new Psr\\Log\\Logger\\FileRoute([
    \'isEnable\' => true,
    \'filePath\' => $_SERVER["DOCUMENT_ROOT"].\'/111.log\',
]));
$logger->routes->attach(new Psr\\Log\\Logger\\FileRoute([
    \'isEnable\' => true,
    \'filePath\' => $_SERVER["DOCUMENT_ROOT"].\'/222.log\',
]));

$logger->info("Info message");
$logger->alert("Alert message");
$logger->error("Error message");
$logger->debug("Debug message");
$logger->notice("Notice message");
$logger->warning("Warning message");
$logger->critical("Critical message");
$logger->emergency("Emergency message");

*/',
    'TYPE' => 'php',
    'DIR' => './gy/test/',
  ),
);
        
    // создаёт все директории и файлы php, js, css проекта
    foreach ($arrayDirGy as $urlFile => $dataFile){

        if(file_exists($dataFile["DIR"]) === false){
            mkdir($dataFile["DIR"], 0755, true);   
        }
        file_put_contents($urlFile, $dataFile["CODE"]);
    }
        
    // функция которая соберёт все файлы и директории
    function getTrueDataDir($arDir, $thisDir, $arIgnoreDirOrFile){
        $result = array();
        foreach ($arDir as $dirNameOrFile) {
            // проверить не входит ли директория в игнорируемую 
            if( !in_array($dirNameOrFile, $arIgnoreDirOrFile ) ){
                $diirName = $thisDir.$dirNameOrFile;
                if(is_dir($diirName)){
                    $diirName = $thisDir.$dirNameOrFile."/";                
                    $date = scandir($diirName);
                    $twoResult = getTrueDataDir($date, $diirName, $arIgnoreDirOrFile);
                    $result = array_merge($result, $twoResult);   
                }else{
                    $result[$thisDir.$dirNameOrFile]["DIR"] = ".".substr($thisDir, strlen("./install-file") );   
                }
            }
        }

        return $result;
    }

    // найти файлы типа jpg и шрифты, все от сюда ./install-file
    $files = getTrueDataDir( array("install-file"), "./", array(".", "..") );

    // скопировать найденые файлы куда надо
    foreach ($files as $urlFile => $dataFile){

        if(file_exists($dataFile["DIR"]) === false){
            mkdir($dataFile["DIR"], 0755, true);   
        }
        $trueFileName = ".".substr($urlFile, strlen("./install-file"));

        copy($urlFile, $trueFileName);
        //unlink($urlFile); // удалить сразу файлы
    }

    function rmRec($path) {
        if (is_file($path)) {
            unlink($path);
        }
        if (is_dir($path)) {
            foreach(scandir($path) as $p) {
                if (($p!=".") && ($p!="..")){
                    rmRec($path.DIRECTORY_SEPARATOR.$p);
                    @rmdir($path); 
                }
            }
        }
    }

    // удалить директории и файлы ./install-file
    rmRec("./install-file");

    unlink("./consoleInstallGyFramework.php"); // удалить этот скрипт
    @unlink("./graphicalInstallGyFramework.php"); // удалить скрипт графической установки
    
    echo "OK!";
    
}else{
	echo "! нужно запустить скрипт в консоли";
}
    