<?php 
global $argv;
$isRunConsole = isset($argv);
$br = "\n";

if($isRunConsole){ 
    // все файлы проекта (php, js, css)
    $arrayDirGy = array (
  './index.php' => 
  array (
    'CODE' => '<? include "./gy/gy.php"; // подключить ядро // include core ?>
	
    <h1>Пример использования gy CMS/framework</h1>

    <? // пример вызова одинаковых компонентов // example run two component ?>
    <h4>Вызов компонента "form_auth_test" (1 раз)</h4>
    <?
    $app->component(
		\'form_auth_test\',
		\'0\',
		array( 
			\'test\' => \'asd\',
			\'idComponent\' => 1,
		)
	);
    ?>    
    
    <h4>Вызов компонента "form_auth_test" (2 раз)</h4>
    <?
	$app->component(
		\'form_auth_test\',
		\'0\',
		array( 
			\'test\' => \'asd2\',
			\'idComponent\' => 2,
		)
	);

    /**
    пример вызова компонента с выводом контента,
      + пример использования кастомного (пользовательского) шаблона компонента
      (пользователя - разработчика использующего gy)
    */
    
    $app->component(
		\'containerdata_element_show\',
		\'0\',
		array( 
			\'container-data-code\' => \'Content\',
			\'element-code\' => \'html-index-page\',
            \'cacheTime\' => 86400 // закешить на 24 ч.
		)
	);
    
    
    
    

',
    'TYPE' => 'php',
    'DIR' => './',
  ),
  './gy/admin/add-user.php' => 
  array (
    'CODE' => '<?
include "../../gy/gy.php"; // подключить ядро // include core

global $user;

// проверим разрешено ли показывать админ панель текущему пользователю
if (accessUserGroup::accessThisUserByAction( \'show_admin_panel\')){
	
	include "../../gy/admin/header-admin.php";
	
    // Проверим разрешено ли работать с пользователями текущему пользователю
    if (accessUserGroup::accessThisUserByAction( \'edit_users\')){
        $app->component(
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
    'CODE' => '<?
include "../../gy/gy.php"; // подключить ядро // include core

$result = array(
	\'stat\' => \'err\'
);

$data = $_REQUEST;

global $user;

if (accessUserGroup::accessThisUserByAction( \'show_admin_panel\') && !empty($data[\'action\'])){
	// действие удалить пользователя
	if (($data[\'action\'] == \'user-del\') && !empty($data[\'id-user\'])  ) {
				
		$res = $user->deleteUserById($data[\'id-user\']);
		if ($res){
			$result[\'stat\'] = \'ok\';
		}
	}
}

echo json_encode($result);

',
    'TYPE' => 'php',
    'DIR' => './gy/admin/',
  ),
  './gy/admin/edit-user.php' => 
  array (
    'CODE' => '<?
include "../../gy/gy.php"; // подключить ядро // include core

global $user;
$data = $_REQUEST;

if (accessUserGroup::accessThisUserByAction( \'show_admin_panel\') 
    && !empty($data[\'edit-id\']) 
    && is_numeric($data[\'edit-id\']) 
    && ($data[\'edit-id\'] != 1) 
){
	
	include "../../gy/admin/header-admin.php";
	
    if (accessUserGroup::accessThisUserByAction( \'edit_users\')){
        $app->component(
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
  './gy/admin/footer-admin.php' => 
  array (
    'CODE' => '<?if ( !defined("GY_GLOBAL_FLAG_CORE_INCLUDE") && (GY_GLOBAL_FLAG_CORE_INCLUDE !== true) ) die( "gy: err include core" );?>

    </body>
</html>	
',
    'TYPE' => 'php',
    'DIR' => './gy/admin/',
  ),
  './gy/admin/get-admin-page.php' => 
  array (
    'CODE' => '<?
include "../../gy/gy.php"; // подключить ядро // include core

global $user;
$module = module::getInstance();
global $app;

$data  = $_GET;

if (accessUserGroup::accessThisUserByAction( \'show_admin_panel\') && !empty($data[\'page\']) ){
	
    // надо ссылаться сюда для получения страницы админки относящихся к модулям,
    // пример в урле /gy/admin/container-data-edit.php станет /gy/admin/get-admin-page.php?page=container-data-edit ... далее как и было
    // + подумать над безопасностью
    // если есть такая страница то подключить её
    if(!empty($module->nameModuleByNameAdminPage[$data[\'page\']])){
        include_once( $app->url.\'/modules/\'.$module->nameModuleByNameAdminPage[$data[\'page\']].\'/admin/\'.$data[\'page\'].\'.php\' );
    }
    
}else {
	header( \'Location: /gy/admin/\' );
}
',
    'TYPE' => 'php',
    'DIR' => './gy/admin/',
  ),
  './gy/admin/group-user.php' => 
  array (
    'CODE' => '<?
include "../../gy/gy.php"; // подключить ядро // include core

global $user;

if ($user->isAdmin()){
	
	include "../../gy/admin/header-admin.php";

	// таблица с пользователями
	$app->component(
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
    'CODE' => '<?if ( !defined("GY_GLOBAL_FLAG_CORE_INCLUDE") && (GY_GLOBAL_FLAG_CORE_INCLUDE !== true) ) die( "gy: err include core" );?>

<html>
	<head>
		<title>gy -admin</title>
		<link href="../../gy/style/main.css" rel="stylesheet">
		<script src="http://code.jquery.com/jquery-1.8.3.js"></script>
		<script src="../../gy/js/main.js"></script>
	</head>	
	<body class="gy-body-admin">
		<h2 class="gy-admin-logo">Админка gy framework</h2>
        <?
        global $user;

        if (accessUserGroup::accessThisUserByAction( \'show_admin_panel\')){
            
            // меню доступное для текущего пользователя
            $menu[\'Главная админки\'] = \'/gy/admin/index.php\';
           
            if(accessUserGroup::accessThisUserByAction( \'edit_users\') || $user->isAdmin()){ 
                $menu[\'Пользователи\'] = \'/gy/admin/users.php\';
            }
            
            // надо добавить пункты меню заданные в подключенных модулях
            $module = module::getInstance();
            foreach ($module->getButtonsMenuAllModules() as $nameModule => $arButton) {
                // условия показа пункта меню (задаётся модулем) или если админ
                if(
                    (
                        !empty($module->getFlagShowButtonsAdminPanelByModule[$nameModule])
                        && accessUserGroup::accessThisUserByAction( $module->getFlagShowButtonsAdminPanelByModule[$nameModule]) 
                    )
                    || $user->isAdmin() ){
                    foreach ($arButton as $buttonName => $buttonUrl) {
                        $menu[$buttonName] = $buttonUrl;
                    }
                }
            }
            
            if($user->isAdmin()){
                $menu[\'Настройки\'] = \'/gy/admin/options.php\';
            }
            
            // menu
            $app->component(
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
    'CODE' => '<?
include "../../gy/gy.php"; // подключить ядро // include core

include "../../gy/admin/header-admin.php";

	// пример вызова компонента // example run component
	$app->component(
		\'admin\',
		\'0\',
		array()
	);
	
include "../../gy/admin/footer-admin.php";

',
    'TYPE' => 'php',
    'DIR' => './gy/admin/',
  ),
  './gy/admin/options.php' => 
  array (
    'CODE' => '<?
include "../../gy/gy.php"; // подключить ядро // include core

global $user;

if (accessUserGroup::accessThisUserByAction( \'show_admin_panel\')){
	
	include "../../gy/admin/header-admin.php";
        
    if(accessUserGroup::accessThisUserByAction(\'action_all\')){
        $app->component(
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
    'CODE' => '<?
include "../../gy/gy.php"; // подключить ядро // include core

global $user;

if (accessUserGroup::accessThisUserByAction( \'show_admin_panel\')){
	
	include "../../gy/admin/header-admin.php";

    if(accessUserGroup::accessThisUserByAction( \'edit_users\')){
        // таблица с пользователями
        $app->component(
            \'users_all_tables\',
            \'0\',
            array()
        );
        ?>
        <br>
        <br>
        <a href="group-user.php" class="gy-admin-button">Настройка групп прав доступа</a>
        <?
    }
	include "../../gy/admin/footer-admin.php";

} else {
	header( \'Location: /gy/admin/\' );
}



',
    'TYPE' => 'php',
    'DIR' => './gy/admin/',
  ),
  './gy/cache/component_container_data_element_show.php' => 
  array (
    'CODE' => '<? $cacheData = \'{"data":{"ITEMS":{"1":{"id":"1","id_container_data":"1","id_element_container_data":"1","id_property_container_data":"1","value":"\\u041f\\u0440\\u0438\\u0432\\u0435\\u0442 \\u043f\\u043e\\u043b\\u044c\\u0437\\u043e\\u0432\\u0430\\u0442\\u0435\\u043b\\u044c, \\u0442\\u0435\\u0431\\u044f \\u043f\\u0440\\u0438\\u0432\\u0435\\u0442\\u0441\\u0442\\u0432\\u0443\\u0435\\u0442 gy php framework\\r\\n \\u0438 \\u0442\\u0435\\u043a\\u0441\\u0442 \\u043f\\u043e\\u043a\\u0430\\u0437\\u0430\\u043d \\u0438\\u0437 \\u0435\\u0433\\u043e \\u043a\\u043e\\u043d\\u0442\\u0435\\u043d\\u0442\\u043d\\u043e\\u0439 \\u0447\\u0430\\u0441\\u0442\\u0438!!!!!"}}},"createTime":1578432482,"cacheTime":86400}\';',
    'TYPE' => 'php',
    'DIR' => './gy/cache/',
  ),
  './gy/cache/getAccessGroup.php' => 
  array (
    'CODE' => '<? $cacheData = \'{"data":{"admins":{"code_action_user":{"action_all":"action_all","show_admin_panel":"show_admin_panel"},"name":"\\u0410\\u0434\\u043c\\u0438\\u043d\\u044b","code":"admins","text":"\\u0410\\u0434\\u043c\\u0438\\u043d\\u044b, \\u0435\\u0441\\u0442\\u044c \\u043f\\u0440\\u0430\\u0432\\u0430 \\u043d\\u0430 \\u0432\\u0441\\u0451"},"content":{"code_action_user":{"show_admin_panel":"show_admin_panel","edit_container_data":"edit_container_data"},"name":"\\u041a\\u043e\\u043d\\u0442\\u0435\\u043d\\u0442","code":"content","text":"\\u0422\\u0435 \\u043a\\u0442\\u043e \\u0438\\u0437\\u043c\\u0435\\u043d\\u044f\\u044e\\u0442 \\u043a\\u043e\\u043d\\u0442\\u0435\\u043d\\u0442 \\u0441\\u0430\\u0439\\u0442\\u0430"},"user_admin":{"code_action_user":{"edit_users":"edit_users","show_admin_panel":"show_admin_panel"},"name":"\\u0410\\u0434\\u043c\\u0438\\u043d\\u0438 \\u043f\\u043e \\u043f\\u043e\\u043b\\u044c\\u0437\\u043e\\u0432\\u0430\\u0442\\u0435\\u043b\\u044f\\u043c","code":"user_admin","text":"\\u041c\\u043e\\u0433\\u0443\\u0442 \\u0438\\u0437\\u043c\\u0435\\u043d\\u044f\\u0442\\u044c \\u0442\\u043e\\u043b\\u044c\\u043a\\u043e \\u043f\\u043e\\u043b\\u044c\\u0437\\u043e\\u0432\\u0430\\u0442\\u0435\\u043b\\u0435\\u0439"}},"createTime":1578479298,"cacheTime":604800}\';',
    'TYPE' => 'php',
    'DIR' => './gy/cache/',
  ),
  './gy/classes/abstract/cache.php' => 
  array (
    'CODE' => '<? 
if ( !defined("GY_GLOBAL_FLAG_CORE_INCLUDE") && (GY_GLOBAL_FLAG_CORE_INCLUDE !== true) ) die( "gy: err include core" );

/** 
 * abstract class cache - описывает класс работы с кешем
 */
abstract class cache{

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
    'DIR' => './gy/classes/abstract/',
  ),
  './gy/classes/abstract/db.php' => 
  array (
    'CODE' => '<? 
if ( !defined("GY_GLOBAL_FLAG_CORE_INCLUDE") && (GY_GLOBAL_FLAG_CORE_INCLUDE !== true) ) die( "gy: err include core" );

/** abstract class work database
 * 
 * 
 */
abstract class db{
    /** connect() - create connect in database
     * @param string $host - адрис хоста
     * @param string $user - логин
     * @param string $pass - пароль
     * @param string $name_db - имя БД
     * @return resurs, false
     */
    abstract public function connect($host, $user, $pass, $name_db); // подключение к db // connect database
    
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
     *   что будет ключём можно указать, либо false тогда вернёт массив с ключами по порядку
     * @param $res - результат отработки запроса в БД
     * @param string $key - строка либо false, это что будет ключём в массиве (по умолчанию id записи)
     * @return array
	 */
	abstract public function fetchAll($res, $key = \'id\');
    
    
    // TODO в функции ниже добавить параметры сортировки 
    
    /**
     * selectDb - запрос типа select. на получение данных
     * @param $db - resurs (create self::connect())
     * @param string $tableName - имя таблици 
     * @param array $propertys - параметры (какие поля вернуть или * - все)
     * @param array $where - условия запроса, массив специальной структуры в виде дерева (может не быть)
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
     * @param array $where - условия запроса, массив специальной структуры в виде дерева (может не быть)
     * @return - false or object result query
     */
    abstract public function updateDb($tableName, $propertys, $where = array());
    
    /**
     * createTable - создать таблицу в базе данных
     * @param string $tableName - имя таблици
     * @param array $propertys - параметры (приер  login varchar(50), name varchar(50) ...) 
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
    'DIR' => './gy/classes/abstract/',
  ),
  './gy/classes/accessUserGroup.php' => 
  array (
    'CODE' => '<?php
if ( !defined("GY_GLOBAL_FLAG_CORE_INCLUDE") && (GY_GLOBAL_FLAG_CORE_INCLUDE !== true) ) die( "gy: err include core" );

/**
 * accessUserGroup - будет всё что связано с правами доступов пользователей 
 * (и групп пользователей)
 */
class accessUserGroup{
    
    private static $tableNameAccessGroup = \'access_group\';
    private static $tableNameUserActions = \'action_user\';
    private static $tableNameUsersInGroupss = \'users_in_groups\';
    
    private static $cacheTimeGetData = 604800;
    
    /**
     * checkAccessUserGroupsByUserAction - определить можно ли пользователю с заданным набором его групп 
     *   и данными по всем группам выполнить указанное действие 
     * 
     * @param array $groupsThisUser - группы к каким относится пользователь
     * @param array $dataAllGroups - данные по всем группам
     * @param string $thisAction - проверяемое действие пользователя
     * @return boolean
     */
    private static function checkAccessUserGroupsByUserAction($groupsThisUser, $dataAllGroups, $thisAction){
        $arResult = false;

        // определить все действия разрешённые для данного пользователя
        $AllAccessActionsThisUser = array();
        foreach ($groupsThisUser as $nameGroup) {
            if($dataAllGroups[$nameGroup]){
                $AllAccessActionsThisUser = array_merge($AllAccessActionsThisUser, $dataAllGroups[$nameGroup][\'code_action_user\']);
            }
        }
        
        // найти заданное действие среди разрешённых для данного пользователя
        // либо проверить на админа (т.е. разрешены любые действия)
        if(in_array($thisAction , $AllAccessActionsThisUser) || in_array(\'action_all\' , $AllAccessActionsThisUser) ){
            $arResult = true;
        }
        return $arResult;
    }
    
    /**
     * accessUser() - проверит разрешёно ли указанное действие заданному пользователю
     * 
     * @param int $userId - id пользователя
     * @param string $actionUser - код пользовательского действия
     * @return boolean
     */
    public static function accessUser($userId, $actionUser){

        // получить данные по пользователю 
        global $user;
        $dataUserFind = $user->getUserById($userId);
        
        // получить данные по всем группам
        $dataAllGroups = self::getAccessGroup();
        
        // определить пользователю с таким набором групп доступно ли указанное действие
        return self::checkAccessUserGroupsByUserAction($dataUserFind[\'groups\'], $dataAllGroups, $actionUser);
    }
    
    /**
     * accessThisUserByAction - проверить разрешено ли текущему пользователю 
     *   указанное действие
     * 
     * @global type $user
     * @param string $action - код действия 
     * @return boolean
     */
    public static function accessThisUserByAction($action){
        global $user;
        $groupsThisUser = $user->getThisUserGroups();
        
        // получить данные по всем группам
        $dataAllGroups = self::getAccessGroup();
        
        // определить пользователю с таким набором групп доступно ли указанное действие
        $arResult = self::checkAccessUserGroupsByUserAction($groupsThisUser, $dataAllGroups, $action);

        return $arResult;
    }
    

    
    /**
     * getAccessGroup() - получить все группы пользователей какие есть
     *  + вернутся заданные в группах разрешения на пользовательские действия
     * @return array
     */
    public static function getAccessGroup(){
        $arResult = array();
        
        global $app;
        global $cacheClassName;
        $cache = new $cacheClassName($app->url);
        $initCache = $cache->cacheInit(\'getAccessGroup\', self::$cacheTimeGetData);
        
        if ($initCache){
            $arResult = $cache->getCacheData();
        }else{
            
            global $db;
            $res = $db->selectDb(self::$tableNameAccessGroup, array(\'*\'));
            while($arRes = $db->fetch($res)){
                if(!empty($arRes[\'code_action_user\'])){
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
     * @global type $app
     * @global type $cacheClassName
     */
    public static function clearCacheForFunctionGetAccessGroup(){
        global $app;
        global $cacheClassName;
        $cache = new $cacheClassName($app->url);
        $cache->cacheInit(\'getAccessGroup\', self::$cacheTimeGetData);
        $cache->clearThisCache();
    }
    
    /**
     * getUserAction() - получить все какие есть пользовательские действия
     * @return array
     */
    public static function getUserAction(){ 
        $arResult = array();
        
        global $app;
        global $cacheClassName;
        $cache = new $cacheClassName($app->url);
        $initCache = $cache->cacheInit(\'getUserAction\', self::$cacheTimeGetData);
        
        if ($initCache){
            $arResult = $cache->getCacheData();
        }else{
            
            global $db;
            $res = $db->selectDb(self::$tableNameUserActions, array(\'*\'));
            while($arRes = $db->fetch($res)){
                $arResult[$arRes[\'code\']][\'code\'] = $arRes[\'code\'];
                $arResult[$arRes[\'code\']][\'text\'] = $arRes[\'text\'];
            }
        
            $cache->setCacheData($arResult);
        }
            
        return $arResult;
    }
    
    /**
     * getListGroupsByUser() - получить список групп к каким относится пользователь
     * 
     * @param int $idUsers - id пользователя
     * @return array
     */
    public static function getListGroupsByUser($idUsers){
        $arResult = array();

        // определить id групп к каким относится пользователь
        global $db;
        $res = $db->selectDb(self::$tableNameUsersInGroupss, array(\'codeGroup\'), array(\'=\'=>array(\'idUser\', $idUsers )));
        while($arRes = $db->fetch($res)){
            $arResult[$arRes[\'codeGroup\']] = $arRes[\'codeGroup\'];
        }
        
        return $arResult;   
    }
    
    
    /**
     * addUserInGroup() - добавить пользователя в группуы
     * @param int $idUsers - id пользователя
     * @param string $codeGroup - код группы
     * @return boolean
     */
    public static function addUserInGroup($idUser, $codeGroup){
        $arResult = false;
        global $db;
        $res = $db->insertDb(
            self::$tableNameUsersInGroupss, 
            array(
                \'codeGroup\' => $codeGroup, 
                \'idUser\' => $idUser,
            )
        );
        if($res){
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
    public static function deleteUserInAllGroups($idUser){
        $arResult = false;
        global $db;
        $res = $db->deleteDb(self::$tableNameUsersInGroupss, array(\'=\' => array(\'idUser\', $idUser)) );
        if($res){
            $arResult = true;
        }
        return $arResult;
    }
    
    /**
     * deleteAllActionsForGroup() 
     * - удалить все заданные, разрешённые действия пользователей для указанной группы
     * 
     * @global type $db
     * @param string $codeUserGroup
     * @return boolean
     */
    public static function deleteAllActionsForGroup($codeUserGroup){ 
        $arResult = false;
        global $db;
        $dataAllGroup = self::getAccessGroup();
                
        if( !empty($dataAllGroup[$codeUserGroup])){
            // тут будут данные по нужной группе
            $dataThisGroup = $dataAllGroup[$codeUserGroup];
            $dataThisGroup[\'code_action_user\'] = \'\';
            
            // удаляем все данные по этой группе из БД
            $res = $db->deleteDb(self::$tableNameAccessGroup, array(\'=\' => array(\'code\', "\'".$codeUserGroup."\'")) );
                        
            if($res){
                // добавляем пустую группу
                $res2 = $db->insertDb(
                    self::$tableNameAccessGroup, 
                    $dataThisGroup
                );
                if($res2){
                    $arResult = true;
                }
            }
        }
           
    }
    
    /**
     * addOptionsGroup() 
     * - добавить для указанной группы пользователей разрешённое действие
     *  
     * @global type $db
     * @param string $codeUserGroup - код группы
     * @param string $codeAction - код пользовательского действия
     * @return boolean
     */
    public static function addOptionsGroup($codeUserGroup, $codeAction){
        $arResult = false;
        global $db;
        $dataAllGroup = self::getAccessGroup();
                
        if( !empty($dataAllGroup[$codeUserGroup])){
            $dataThisGroup = $dataAllGroup[$codeUserGroup];
          
            // если действий для пользователя нет обновить группу (добавить действия)
            if(empty($dataThisGroup[\'code_action_user\'])){
                $dataThisGroup[\'code_action_user\'] = $codeAction;
                // если мы попали сюда то всего одна запись в БД соответствует этой группе её и обновляем
                $res = $db->updateDb(
                    self::$tableNameAccessGroup, 
                    $dataThisGroup, 
                    array(
                        \'=\' => array(
                            \'code\', 
                            "\'".$codeUserGroup."\'"
                        ) 
                    )
                );
                if($res){
                    $arResult = true;
                }               
            } else{ // добавить копию группы с новым действием                
                $dataThisGroup[\'code_action_user\'] = $codeAction;
                $res = $db->insertDb(
                    self::$tableNameAccessGroup, 
                    $dataThisGroup
                );
                if($res){
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
     * @global type $db
     * @param array $arDataNewGroup - массив с данными по группе (name, code, text)
     * @param array $arActionUserThisGroup - массив с разрешёнными для этой группы действиями
     * @return boolean
     */
    public static function addUserGroup($arDataNewGroup, $arActionUserThisGroup){
        global $db;
        $arResult = true; 
        foreach ($arActionUserThisGroup as $value) {
            $res = $db->insertDb(
                self::$tableNameAccessGroup, 
                array(
                    \'code\' => $arDataNewGroup[\'code\'], 
                    \'name\' => $arDataNewGroup[\'name\'],
                    \'text\' => $arDataNewGroup[\'text\'],
                    \'code_action_user\' => $value
                )
            );
            if($res){
                //$arResult = true;
            }else{
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
     * @global type $db
     * @param string $codeGroup - код удаляемой группы
     * @return boolean
     */
    public static function deleteUserGroupByCode($codeGroup){
        global $db;
        $arResult = false;
        // удалить все связи пользователей с этой группой
        
        $res = $db->deleteDb(
            self::$tableNameUsersInGroupss,
            array(\'=\' => array(\'codeGroup\' , "\'".$codeGroup."\'" ) )
        );
        if($res){
            $arResult = true;
        }
                
        // удалить группу по коду уруппы
        if($arResult){
            $arResult = false;
            $res = $db->deleteDb(
                self::$tableNameAccessGroup,
                array(\'=\' => array(\'code\' , "\'".$codeGroup."\'" ) )
            );
            if($res){
                $arResult = true;
            }
        }
        
        // сбросить кеш на получение разрешений для групп и всех данных по группам
        self::clearCacheForFunctionGetAccessGroup();
        
        return $arResult;   
    }
       
}',
    'TYPE' => 'php',
    'DIR' => './gy/classes/',
  ),
  './gy/classes/app.php' => 
  array (
    'CODE' => '<?php 
if ( !defined("GY_GLOBAL_FLAG_CORE_INCLUDE") && (GY_GLOBAL_FLAG_CORE_INCLUDE !== true) ) die( "gy: err include core" );

final class app{

    public $url;
    public $options; // настройки проекта
    public $lang; // табличка с языковыми сообщениями
    //public $db; // db
    public $urlProject; // урл как $this-url только без /gy в конце
    
    private static $app;
    
    private function  __construct($url, $options){
        // подключить настройки
        $this->options = $options; 
       
        $this->url = $url;
        
        // записать ещё путь до проекта без последней директории т.е. без /gy
        $this->urlProject = substr($this->url, 0, (strlen($this->url) - 3) );
        
        // если есть языковой файл то надо подключить его
        $this->lang = new lang($url, \'app\', $this->options[\'lang\']);
    }

    /**
     * createApp - создать объект класса app, запишет его в статичное свойство и вернёт
     * @param string $url - расположение проекта
     * @return object class app
     */
    public static function createApp($url, $options){       
        if (  static::$app === null ){
            static::$app = new static($url, $options);
        }
        return static::$app;
    }
    
    /** 
     *  component отобразить компонент // show component
     * 	@param string $name - имя компонента и контроллера сразу 
     * 	@param string $template - имя шаблона 
     * 	@param array $arParam - параметры компонента (параметры кеша и прочие нюансы) // array component config
     *  @param strung $url - url где лежит проект
     * 	вернёт объект компонент
     * 
     * 	TODO возможно понадобится сделать подключение модели // если делать универсальные модели для компонентов
     * 		или возможность подключать много моделей разных
     * 		maybe includ many model in component
     */
    public function component($name, $template, $arParam  ){
        $component = new component($name, $template, $arParam, $this->urlProject, $this->options[\'lang\']);
        return $component;
    }

}
',
    'TYPE' => 'php',
    'DIR' => './gy/classes/',
  ),
  './gy/classes/cacheFiles.php' => 
  array (
    'CODE' => '<?php

if ( !defined("GY_GLOBAL_FLAG_CORE_INCLUDE") && (GY_GLOBAL_FLAG_CORE_INCLUDE !== true) ) die( "gy: err include core" );

/**
 * cache - класс для работы с кешем
 * для даботы нужен раздел gy/cache/
 */
class cacheFiles extends cache {
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
    public function __construct($urlProject) {
        $this->urlProject = $urlProject;
    }
    
    /**
     * cacheInit - инициализация кеша, надо проверить есть кеш по заданным параметрам
     * @param string $cacheName
     * @param int $cacheTime - время кеширования в секундах
     * @return boolean
     */
    public function cacheInit($cacheName, $cacheTime){
        $this->cacheName = $cacheName;
        $this->cacheTime = $cacheTime;
                
        if(file_exists($this->urlProject.$this->urlCache.$this->cacheName.$this->endUrl)){
            $cacheData = array();
            include $this->urlProject.$this->urlCache.$this->cacheName.$this->endUrl;
            
            if(!empty($cacheData) ){
                $cacheData = json_decode($cacheData, true);
                if( ((int) $cacheData[\'createTime\'] + (int) $cacheData[\'cacheTime\']) > time()) {
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
    public function getCacheData(){
        return $this->data;
    }
    
    /**
     * setCacheData - установить данные в кеш
     * @param mixed $data - может быть массив или одиночное значение
     * @return boolean true
     */
    public function setCacheData($data){
        $cacheData = array(
            \'data\' => $data,
            \'createTime\' => time(),
            \'cacheTime\' => $this->cacheTime
        );       
        file_put_contents($this->urlProject.$this->urlCache.$this->cacheName.$this->endUrl, \'<? $cacheData = \'."\'". json_encode($cacheData)."\';" );  
        return true;
    }
    
    /**
     * clearThisCache - удалит текущий кеш (кеш связанный с текущим объектом)
     */
    public function clearThisCache(){
        if(file_exists($this->urlProject.$this->urlCache.$this->cacheName.$this->endUrl)){
            unlink($this->urlProject.$this->urlCache.$this->cacheName.$this->endUrl);
        }
    }
    
}
',
    'TYPE' => 'php',
    'DIR' => './gy/classes/',
  ),
  './gy/classes/capcha.php' => 
  array (
    'CODE' => '<?php 
if ( !defined("GY_GLOBAL_FLAG_CORE_INCLUDE") && (GY_GLOBAL_FLAG_CORE_INCLUDE !== true) ) die( "gy: err include core" );

/**
 * class capcha - для работы с капчей
 */
class capcha{
    
    // символы которые будут в капче
    //private static $letters = \'abcdefghijklmnopqrstuvwxyzABCDRFGHIJKLMNOPQRSTUVWXYZ0123456789\';
    //  убрал ноль и буквы о, что бы не было путаниц
    private static $letters = \'aAbBcCdDeEfFgG1hHiI2jJkK3lLm4MnN5p6PqQr7RsSt8TuUv9VwWxXyYzZ\'; 
    
    private $count = 5; // количество символов
    private $code = 5; // код капчи
    private $urlFonts; // путь до шрифта (шрифт нужен что бы поворачивать буквы)
    public static $defaultUrlFonts = "/fonts/18018.otf"; // 
    
    public function __construct($urlFonts = false){
        $this->urlFonts = $urlFonts;
        $this->setCapchaValue( self::getRandLetters($this->count) );
    }
    
    /**
     * clearCapcha - очистить текущий код капчи
     */
    public static function clearCapcha(){
        unset($_SESSION[\'capcha\']);
    }
    
    /**
     * chackCapcha - проверить код с установленным кодом в капче
     * @param string $code
     * @return boolean
     */
    public static function chackCapcha( $code){
        $arResult = false; 
        // проверит код с капчи
        if ($_SESSION[\'capcha\'] == mb_strtoupper($code) ){ // всё приводится к верхнему регистру что бы пользователю проще было угадать капчу
            $arResult = true; 
        }
        self::clearCapcha();
        return $arResult;
    }

    /**
     * setCapchaValue - установить код капчи
     * @param type $value
     */
    private function setCapchaValue($value){
        // задать код в классе
        $this->code = $value;
        
        // записать в сессию значение
        $_SESSION[\'capcha\'] = mb_strtoupper($this->code);
        
    }
    
    /**
     * getImageCapcha - вызовет createImageCapcha с нужным кодом
     * это всё чтобы нарисовать картинку капчи
     */
    public function getImageCapcha(){
        // задаст стандартные настройки и вызовет createImageCapcha для определённого кода
        $this->createImageCapcha($this->code);
    }

    /**
     * createImageCapcha - нарисовать картинку капчи по заданному коду
     * @param string $code
     */
    private function createImageCapcha($code){
              
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
        for($i = 0; $i < $j; $i++){
            
            // произвольно задать цвет
            $r = rand(50, 230);
            $g = rand(50, 230);
            $b = rand(50, 230);
            $text_color = imagecolorallocate($img, $r, $g, $b);
            
            // Рисуем линию
            $x1 = rand(0, $gX);
            $x2 = rand(0, $gX);
            $y1 = rand(0, $gY);
            $y2 = rand(0, $gY);
            
            imageline($img, $x1, $y1, $x2, $y2, $text_color);
        }
        
        // рисуется код капчи
        for($i = 0; $i < strlen($code); $i++){
            
            // произвольно задать цвет
            $r = rand(50, 230);
            $g = rand(50, 230);
            $b = rand(50, 230);
            $text_color = imagecolorallocate($img, $r, $g, $b);
            
            $font = rand(3, 5); // размер шрифта
            
            $j = rand(0,1);
            if($j == 0){
                $y = sin($i)*10;
            }else{
                $y = cos($i)*10;
            }
            
            $x = rand(3, 10);
            
            if ($this->urlFonts == false){ 
                // если не задан шрифт то будет штатным рисоваться но без поворота букв
                imagestring($img, $font, $x+($i*20), 10+$y,  $code[$i], $text_color);          
                imagestring($img, $font, $x+1+($i*20), 11+$y,  $code[$i], $text_color); 
            }else{ 
                // иначе заданным шрифтом рисует с поворотом букв
                $a = 30 - rand(0, 60); // угол от -30 до 30
                imagettftext($img, $font*3, $a, $x+($i*20), 30+$y, $text_color, $this->urlFonts, $code[$i]); 
                imagettftext($img, $font*3, $a, $x+1+($i*20), 31+$y, $text_color, $this->urlFonts, $code[$i]); 
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
    public function getRandLetters($count){
        $randLetters = \'\';
        for($i = 0; $i < $count; $i++){
            $randLetters .= self::getRandLetter();
        }
        return $randLetters;
    }
    
    /**
     * getRandLetter - получить произвольный символ из заданного набора символов self::$arrayLetters
     * @return type
     */
    private function getRandLetter(){
        $countLetters = strlen(self::$letters);
        $randLetter = rand(0, ($countLetters-1) );
        return substr(self::$letters, $randLetter, 1);
    }

}',
    'TYPE' => 'php',
    'DIR' => './gy/classes/',
  ),
  './gy/classes/component.php' => 
  array (
    'CODE' => '<?php 
if ( !defined("GY_GLOBAL_FLAG_CORE_INCLUDE") && (GY_GLOBAL_FLAG_CORE_INCLUDE !== true) ) die( "gy: err include core" );

class component{

	public $template; // тут будут объект класса template
	public $controller;
	public $model;
	public $url;
	public $lang; 

	public function __construct( $name, $template, $arParam, $url, $lang ){
		$this->lang = new lang($url.\'/classes/\', \'component\', $lang);

		// TODO $template - сюда можно и пустую строку записать
		// могут быть разные шаблоны

		$err = 0;
		$errText = \'\';
        
        // нужно попробовать найти подключаемый компонент среди подключённых модулей
        $module = module::getInstance();
        $urlComponentInModule = $module->getModulesComponent($name);
                
        if (($err == 0) && file_exists($url.\'/customDir/component/\'.$name.\'/teplates/\'.$template.\'/template.php\' ) ){
            // если есть такой компонент и указанный шаблон в папке /customDir/ то подключить от туда
            $template = new template($url.\'/customDir/component/\'.$name.\'/teplates/\'.$template, $lang ); 
        }elseif(($urlComponentInModule !== false) && file_exists($urlComponentInModule.\'/teplates/\'.$template.\'/template.php\' ) ){
            // проверить нет ли компонента среди подключенных модулей
            $template = new template($urlComponentInModule.\'/teplates/\'.$template, $lang ); 
        }elseif(($err == 0) && file_exists($url.\'/gy/component/\'.$name.\'/teplates/\'.$template.\'/template.php\' ) ){ 
            // если нет то поискать шаблон в стандартной папке с компонентами
			$template = new template($url.\'/gy/component/\'.$name.\'/teplates/\'.$template, $lang );
		} else {
			$err = 1;
			$errText = $this->lang->GetMessage(\'err_not_controller\');
		}
                
        if (($err == 0) && file_exists($url.\'/customDir/component/\'.$name.\'/controller.php\' ) ){ 
            $this->controller = new controller($url.\'/customDir/component/\'.$name, $lang); // всегда один
        }elseif(($urlComponentInModule !== false) && file_exists($urlComponentInModule.\'/controller.php\' ) ){              
            $this->controller = new controller($urlComponentInModule, $lang);
        }elseif(($err == 0) && file_exists($url.\'/gy/component/\'.$name.\'/controller.php\' ) ){ 
			$this->controller = new controller($url.\'/gy/component/\'.$name, $lang); // всегда один
		} else {
			$err = 2;
			$errText = $this->lang->GetMessage(\'err_not_controller\') ;
		}
                
		if ( ($err == 0) && file_exists($url.\'/customDir/component/\'.$name.\'/model.php\' ) ){ 
            $model = new model($url.\'/customDir/component/\'.$name.\'/model.php\'); // может и не быть
			$this->controller->SetModel($model);
        }elseif(($urlComponentInModule !== false) && file_exists($urlComponentInModule.\'/model.php\' )){
            $model = new model($urlComponentInModule.\'/model.php\'); // может и не быть
			$this->controller->SetModel($model);
        }elseif( ($err == 0) && file_exists($url.\'/gy/component/\'.$name.\'/model.php\' ) ){ 
			$model = new model($url.\'/gy/component/\'.$name.\'/model.php\'); // может и не быть
			$this->controller->SetModel($model);
		} 

		// TODO вывести ошибку если что то не найдено // значит файлы не все есть

		if ($err != 0){ // если есть ошибки 
			$this->ShowErr($errText);
		} else { // иначе запускаем компонент
			
			$this->controller->SetTemplate($template); // задать шаблон	
			$this->controller->SetArParam($arParam); // передать параметры компонента // set array property component 
			
			$this->run();
		}

		$this->url = $url.\'/gy\';
	}

    /**
     * run() 
     */
	public function run(){
		$this->controller->run();
		//$this->template->show($arRes);
	}

    /**
     * ShowErr 
     * @param type $err
     */
	public function ShowErr($err){ // TODO вынести в отдельный класс про ошибки
		echo \'<div class=gy_err>\'.$err.\'</div>\';
	}

}
',
    'TYPE' => 'php',
    'DIR' => './gy/classes/',
  ),
  './gy/classes/controller.php' => 
  array (
    'CODE' => '<?php 
if ( !defined("GY_GLOBAL_FLAG_CORE_INCLUDE") && (GY_GLOBAL_FLAG_CORE_INCLUDE !== true) ) die( "gy: err include core" );

class controller{
	public $model;
	public $controller; // ссылка для запуска выбранного контроллера компонента
	public $lang;
	public $template; // объект шаблона 
	public $arParam;

	public function __construct($url, $lang){
		$this->controller = $url.\'/controller.php\';
		$this->lang = new lang($url, \'controller\', $lang);
	}
	
    /**
     * SetModel
     * @param type $model
     */
	public function SetModel($model){ // установить ссылку на модель если есть
		$this->model = $model;
	}

    /**
     * SetTemplate - задать шаблон
     * @param object class template $template
     */
	public function SetTemplate($template){  
		$this->template = $template;	
	}

    /**
     * SetArParam - задать параметры компонента // set array property component
     * @param type $arParam
     */
	public function SetArParam($arParam){ 
		$this->arParam = $arParam;
	}

    /**
     * run 
     */
	public function run(){		
		include $this->controller;
	}

}
',
    'TYPE' => 'php',
    'DIR' => './gy/classes/',
  ),
  './gy/classes/crypto.php' => 
  array (
    'CODE' => '<?
if ( !defined("GY_GLOBAL_FLAG_CORE_INCLUDE") && (GY_GLOBAL_FLAG_CORE_INCLUDE !== true) ) die( "gy: err include core" );

class crypto{
	
	private $sole; 
	
    /**
     * setSole - установить соль (некая строка)
     * @param string $sole
     * @return boolean true
     */
	public function setSole($sole){
		$this->sole = $sole;
		return true;
	}
	
    /**
     * getSole - получить значение соли
     * @return string
     */
	public function getSole(){
		return $this->sole;
	}
	
    /**
     * getRandString - даст произвольную строку
     * @return string
     */
	public function getRandString(){
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
	public function getStringForUserCookie($login, $name, $id){
		return md5(microtime().$login.$this->sole.$name.$id);
	}

}


',
    'TYPE' => 'php',
    'DIR' => './gy/classes/',
  ),
  './gy/classes/image.php' => 
  array (
    'CODE' => '<?
if ( !defined("GY_GLOBAL_FLAG_CORE_INCLUDE") && (GY_GLOBAL_FLAG_CORE_INCLUDE !== true) ) die( "gy: err include core" );

/* image class work with image // wrapper class php GD
 * image класс для работы с изображениями // обёртка класса php GD
 */
class image{
    
    /** 
     * imageResized function compression image (jpeg)
     * imageResized - сжимает изображения (поддерживает пока jpeg)
     * @param string $urlImgIn - ссылка на изображение которое нужно сжать // url input image
     * @param string $urlImageOut - ссылка куда сохранить изображение // url save image
     * @param int $compression - сжатие (0-100) 100 - это наилучшее качество // compression (0-100) 100 max quality
     * @return bool true or false
     */
    static function imageResized($urlImgIn, $urlImageOut, $compression){
        $result = false;
        $arImg = getimagesize($urlImgIn);
        if ($arImg[2] == 2){// jpeg ли это ? // if jpeg image
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
    'DIR' => './gy/classes/',
  ),
  './gy/classes/lang.php' => 
  array (
    'CODE' => '<?php
if ( !defined("GY_GLOBAL_FLAG_CORE_INCLUDE") && (GY_GLOBAL_FLAG_CORE_INCLUDE !== true) ) die( "gy: err include core" );

class lang{
	
	public $textLang; // тексты определённого языка

	function __construct($url, $fileName, $lang){
		$result = false; 
		        
		if ( !empty($url) && !empty($fileName) && !empty($lang) ) {
			//load array text language
			$this->textLang = $this->GetArrLangFromFilre( $url.\'/lang_\'.$fileName.\'.php\', $lang );
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

	function autoLoadLang($namePHPFile, $lang ){

	}

	/**
     *  GetMessage вернуть текст для заданной переменной текущего языка
	 * @param string $nameVar - передать переменную 
	 * @return вернёт текст или false
	 */
	function GetMessage($nameVar ){
		$result = false;
		if ( !empty($this->textLang[$nameVar]) ){
			$result = $this->textLang[$nameVar];
		}
		return $result;
	}

	
	/**
	 * GetArrLangFromFilre загрузить массив с текстом нужного языка // load array text language
	 * @param $urlFile ссылка на загружаемый файл // url load file
	 * @param $lang - нужный язык // language // rus, eng ...
	 * 
	 * @return массив с текстом на выбранном языке // language text array 
	 */
	function GetArrLangFromFilre( $urlFile, $lang ){
		$mess = array();
	       
		// если есть файл с языковыми параметрами
		if ( file_exists($urlFile) === true ){	
			include $urlFile;
            $mess = $mess[$lang];
		}

		return $mess;
	}
	
}
',
    'TYPE' => 'php',
    'DIR' => './gy/classes/',
  ),
  './gy/classes/lang_component.php' => 
  array (
    'CODE' => '<?php 
if ( !defined("GY_GLOBAL_FLAG_CORE_INCLUDE") && (GY_GLOBAL_FLAG_CORE_INCLUDE !== true) ) die( "gy: err include core" );

$mess[\'rus\'] = array(
	\'err_not_template\' => \'!шаблон не найден\',
	\'err_not_controller\' => \'!!! контроллер компонента не найден\',
	// \'err_not_controller\' => \'\';
);
',
    'TYPE' => 'php',
    'DIR' => './gy/classes/',
  ),
  './gy/classes/model.php' => 
  array (
    'CODE' => '<?
if ( !defined("GY_GLOBAL_FLAG_CORE_INCLUDE") && (GY_GLOBAL_FLAG_CORE_INCLUDE !== true) ) die( "gy: err include core" );

class model{
	public $url; // ссылка на шаблон

	public function __construct($url){
		$this->url = $url;
	}

    /**
     * includeModel - подключить файл с моделью компонента
     */
	public function includeModel(){		
		require_once $this->url; // !!!
	}
}

',
    'TYPE' => 'php',
    'DIR' => './gy/classes/',
  ),
  './gy/classes/module.php' => 
  array (
    'CODE' => '<?php
if ( !defined("GY_GLOBAL_FLAG_CORE_INCLUDE") && (GY_GLOBAL_FLAG_CORE_INCLUDE !== true) ) die( "gy: err include core" );

/**
 * module - работа с модулями фреймворка
 */
class module{
    
    // массив подключённых модулей
    public $arrayIncludeModules = array(); 
    
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
    
    private function  __construct(){
        // заполнить пустотой
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
    public function getInstance(){
        if (static::$module === null){
            static::$module = new static();
        }
        return static::$module;
    }
    
    public function setUrlGyCore($urlGyCore){
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
    public function includeModule($nameModule){
        $result = false;
        if($this->urlGyCore !== false){
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
    public function includeModuleByUrl($urlModule){ // TODO можно добавить проверки на ошибки 
        $result = false;
                
        if(file_exists($urlModule.\'init.php\' )){
            include $urlModule.\'init.php\';
            
            // тут имя модуля
            if (!empty($nameThisModule)){
                $this->arrayIncludeModules[$nameThisModule] = $urlModule;
                //unset($nameThisModule);
            }
            
            // тут список компонентов модуля
            if (!empty($componentsThisModule)){ 

                foreach ($componentsThisModule as $value) {
                    $this->nameModuleByComponentName[$value] = $nameThisModule;
                }
                        
                unset($componentsThisModule);
            }
            
            // тут список классов модуля
            if (!empty($classesThisModule)){

                foreach ($classesThisModule as $value) {      
                    $this->nameClassModuleByNameModule[$value] = $nameThisModule;    
                }
                unset($classesThisModule);
            }
            
            // тут список страниц админки
            if (!empty($adminPageThisModule)){

                foreach ($adminPageThisModule as $value) {      
                    $this->nameModuleByNameAdminPage[$value] = $nameThisModule;    
                }
                unset($adminPageThisModule);
            }
            
            // пункты меню в админке
            if (!empty($pagesFromAdminMenu)){
                $this->buttonMenuAdminPanel[$nameThisModule] = $pagesFromAdminMenu;
                unset($pagesFromAdminMenu);
            }
             
            // условия показа пунктов меню админки для подключённых модулей
            if (!empty($isShowButtonsMenuAdminPanetThisModule)){
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
    public function getModulesComponent($nameComponent){
        $result = false;
        
        if(!empty($this->nameModuleByComponentName[$nameComponent])){
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
    public function getUrlModuleClassByNameClass($nameClass){
        $result = false;
        if(!empty($this->nameClassModuleByNameModule[$nameClass])){
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
    public function searchAllModules(){
        $result = array();
        if ($handleDirs = opendir( $this->urlGyCore.\'/modules/\' ) ) {      
            while (false !== ($dirName = readdir($handleDirs))) { 
                if( ($dirName != \'.\') && ($dirName != \'..\') ){
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
    public function includeAllModules(){
        $allModules = $this->searchAllModules();
        if(!empty($allModules)){
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
    public function installDbModuleByNameModule($nameModule){ // TODO пока только установка для mysql
        $result = false;
        
        if(file_exists($this->urlGyCore.\'/modules/\'.$nameModule.\'/install/installMysqlTable.php\' )){
            include_once( $this->urlGyCore.\'/modules/\'.$nameModule.\'/install/installMysqlTable.php\' );
            $result = true;
        }
        
        return $result;
    }
    
    /**
     * installBdAllModules 
     *  - установить части БД для всех модулей
     */
    public function installBdAllModules(){
        $allModules = $this->searchAllModules();
        if(!empty($allModules)){
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
    public function getButtonsMenuByModule($nameModule){
        return $this->buttonMenuAdminPanel[$nameModule];
    }
    
    /**
     * getButtonsMenuAllModules
     *  - вернуть все пункты меню админки всех подключённых модулей 
     * 
     * @return array - массив с кнопками где ключ это код модуля, 
     *   а значения как результат getButtonsMenuByModule
     */
    public function getButtonsMenuAllModules(){
        return $this->buttonMenuAdminPanel;
    }
    
    /**
     * getFlagShowButtonsAdminPanelByModule
     *  - вернуть условие показа кнопок в админке,
     *  это код для метода accessUserGroup::accessThisUserByAction
     *  т.е. действие и если оно разрешено пользователю то покажется пункты меню в админке
     *  
     * 
     * @param string $nameModule - код модуля
     * @return string - код действия 
     */
    public function getFlagShowButtonsAdminPanelByModule($nameModule){
        return $this->isShowButtonsMenuAdminPanelModules[$nameModule];
    }
    
}',
    'TYPE' => 'php',
    'DIR' => './gy/classes/',
  ),
  './gy/classes/mysql.php' => 
  array (
    'CODE' => '<?
if ( !defined("GY_GLOBAL_FLAG_CORE_INCLUDE") && (GY_GLOBAL_FLAG_CORE_INCLUDE !== true) ) die( "gy: err include core" );

/* mysql - класс для работы с базой данных mysql
 * class work mysql 
 */

class mysql extends db{
    
    public $test = \'mysql ok\';
    public $db;
    
    /* connect() - create connect in database
    * @param $host
    * @param $user
    * @param $pass 
    * @param $name_db
    * @return resurs, false
    */
    public function connect($host, $user, $pass, $name_db){
        $this->db = mysqli_connect($host, $user, $pass, $name_db);
        return $this->db;
    }
    
    /* query()  - out query in database
     * @param $db - resurs (create self::connect()), $query - string query
     * @return true - ok OR false - not ok
     */
    public function query($query){	// TODO брать прямо из класса $db
        return mysqli_query($this->db, $query);
    }
    
    /*  close() - close connect database
     * @param $db - resurs (create self::connect()) 
     * @return true - ok OR false - not ok
     */
    public function close(){
        return mysqli_close($this->db);
    }
	
    /**
     * fetch - получить порцию (строку) данных, после выполнения запроса в БД
     * @param $res - результат отработки запроса в БД
     * @return array
     */
	public function fetch($res){
        $result = array();
        if ($res !== false){
            $result = mysqli_fetch_assoc($res);
        }
		return $result;
	}
	
    /**
	 * fetchAll - тоже что и fetch только в получит всё в виде массива (с ключём id элемента)
     * @param $res - результат отработки запроса в БД
     * @return array
	 */
	public function fetchAll($res, $key = \'id\'){
        $result = array();
        while ($arRes = self::fetch($res)){
            if($key !== false){
                $result[$arRes[$key]] = $arRes;
            }else{
                $result[] = $arRes;
            }
		}
        return $result;
    }
    
	public function __construct($db_config) {
		if ( empty($this->db)){
			if (!empty($db_config)){
				$this->connect($db_config[\'db_host\'], $db_config[\'db_user\'], $db_config[\'db_pass\'], $db_config[\'db_name\']);
			}
		}
	}
    
    /**
     * parseWhereForQuery - парсинг параметров where запроса
     *   массив будет в виде дерева, т.е. конечные массивы должны состоять из 2х элементов // TODO добавить примеры в wiki
     * @param type $where
     * @param type $i
     * @param type $key2
     * @return type
     */    
    private function parseWhereForQuery($where, $i, $key2){ // TODO рефакторинг
        $str = \'\';
        $str2 = \'\';
        if (is_array($where)){
            $i++;
            foreach($where as $key => $val){
                $str = \'\';
                $str = $this->parseWhereForQuery($val, $i, $key);
                $str2 .=  ((!empty($str2))? \' \'.$key2.\' \' : \'\').$str;
            }
        }else{
            $str2 = $where;
        }   
        return $str2;
    }
    
     /**
     * selectDb - запрос типа select. на получение данных
     * @param $db - расурс, коннект к базе данных
     * @param string $tableName - имя таблицы 
     * @param array $propertys - параметры (какие поля вернуть или * - все)
     * @param array $where - условия запроса, массив специальной структуры в виде дерева (может не быть)
     * @return - false or object result query
     */
    public function selectDb($tableName, $propertys, $where = array()){
        $query = \'SELECT \';
        $strPropertys = implode(",", $propertys);

        if(!empty($where)){            
            $where = \' WHERE \'.$this->parseWhereForQuery($where, 0, \'\');
        }else{
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
    public function insertDb($tableName, $propertys){
        $query = \'\';
        
        // разбить параметры на два списка через запятую // TODO вынести куда то
        global $crypto;
        $nameProperty = \'\';
		$valueProperty = \'\';
		foreach ($propertys as $key=> $val){
			$nameProperty .= (($nameProperty != \'\')? \', \': \'\').$key;
			
			if ($key == \'pass\'){
				$val = md5($val.$crypto->getSole());
			}
			
			if (!is_numeric($val)){
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
    public function updateDb($tableName, $propertys, $where = array()){//TODO
        $query = \'UPDATE \';
        $textPropertys = \'\';
        global $crypto;
        foreach ($propertys as $key => $val){
            
            if ($key == \'pass\'){
				$val = md5($val.$crypto->getSole());
			}
            
            if (!is_numeric($val)){
				$val = "\'".$val."\'";
			}
            $textPropertys .= ((!empty($textPropertys))? \',\': \'\').\' \'.$key.\'=\'.$val;
        }

        if(!empty($where)){            
            $where = \' WHERE \'.$this->parseWhereForQuery($where, 0, \'\');
        }else{
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
    public function createTable($tableName, $propertys){
        $query = \'\';
        $textPropertys = \'\';
        foreach($propertys as $val){
            $textPropertys .= ((!empty($textPropertys))? \',\': \'\').\' \'.$val;
        }
        
        $query = \'CREATE TABLE \'.$tableName.\' (\'.$textPropertys.\');\';

        return  $this->query($query);
    }
    
    /**
     * deleteDb - удаление строк из таблицы
     * @param string $tableName - имя таблицы
     * @param array $where - условия запроса, что удалять
     * @return boolean
     */
    public function deleteDb($tableName, $where){
        $query = \'\';
        if(!empty($where)){            
            $where = \' WHERE \'.$this->parseWhereForQuery($where, 0, \'\');
        }else{
            $where = \'\';
        }
        
        $query = \'DELETE FROM \'.$tableName.$where;
                    
        return  $this->query($query);
    }
    
	public function __destruct() {
		if ( !empty($this->db)){
			$this->close($this->db);
		}
	}
}
',
    'TYPE' => 'php',
    'DIR' => './gy/classes/',
  ),
  './gy/classes/template.php' => 
  array (
    'CODE' => '<?php
if ( !defined("GY_GLOBAL_FLAG_CORE_INCLUDE") && (GY_GLOBAL_FLAG_CORE_INCLUDE !== true) ) die( "gy: err include core" );

class template{
	public $templateUrl; // ссылка на шаблон
	// public $name; // имя шаблона
	public $lang;
    private $urlFileStyle; // url на файл со стилями, для этого шаблона
    private $urlFileJs; // url для файла с js, для этого шаблона
    
	public function __construct($url, $lang){
		$this->templateUrl = $url.\'/template.php\';
        
        // проверить существует ли файл стилей для компонента
        if(file_exists($url.\'/style.css\')){
            $this->urlFileStyle = $url.\'/style.css\';
        }
        
        // если есть файл js 
        if(file_exists($url.\'/script.js\')){
            $this->urlFileJs = $url.\'/script.js\';
        }
        
		$this->lang = new lang($url, \'template\', $lang);
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
	public function show($arRes, $arParam){
        
        // если есть стили то добавить стили
        if(!empty($this->urlFileStyle)){
            echo \'<style>\';
            include $this->urlFileStyle;
            echo \'</style>\';
        }
        
        // файл шаблона
		include $this->templateUrl;
        
        // если есть js то добавить его
        if(!empty($this->urlFileJs)){
            echo \'<script>\';
            include $this->urlFileJs;
            echo \'</script>\';
        }
	}
}

',
    'TYPE' => 'php',
    'DIR' => './gy/classes/',
  ),
  './gy/classes/user.php' => 
  array (
    'CODE' => '<?
if ( !defined("GY_GLOBAL_FLAG_CORE_INCLUDE") && (GY_GLOBAL_FLAG_CORE_INCLUDE !== true) ) die( "gy: err include core" );

class user{ 
	
	protected $authorized = false;
	protected $dataUser;
	protected $nameCookie = \'gy_user_auth\';
	protected $admin = false; 
	public $tableName = \'users\';

    public function __construct() {
        $this->checkUserCookie();
    }
    
    /**
     * getThisUserGroups - получить группы текущего пользователя
     * @return array
     */
    public function getThisUserGroups(){
        $arResult = array();
        if(!empty($this->dataUser[\'groups\'])){
            $arResult = $this->dataUser[\'groups\'];
        }
        return $arResult;
    }    
    
    /**
     * getDataThisUser - получить данные по текущему, авторизованному пользователю
     * @return array
     */
	public function getDataThisUser(){
		return $this->dataUser;
	}
	
    /**
     * isAdmin - проверить является ли текущий, авторизованный пользователем администратором
     * @return booleand
     */
	public function isAdmin(){
		return $this->admin;
	}
	
	/**
	 * getAuthorized - узнать авторизован ли пользователь
	 * @return booleand
	 */
	public function getAuthorized(){
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
	public function authorized($log, $pass ){
		$result = $this->chackUser($log, $pass);
		$this->authorized = $result;
		return $result;
	}
	
    /**
     * chackUser - проверить существует ли пользователь
     * @global type $db
     * @global type $crypto
     * @param type $log - логин
     * @param type $pass - пароль
     * @return booleand
     */
	protected function chackUser($log, $pass) { 
		$result = false;
		
		global $db;
		global $crypto;		
			
        $res = $db->selectDb(
            $this->tableName, 
            array(\'*\'), 
            array(
                \'AND\' => array( 
                    \'=\' => array(\'login\', "\'".$log."\'" ),
                    \'AND\' => array( \'=\' => array(\'pass\',"\'".md5($pass.$crypto->getSole())."\'") )
                ),   
            )    
        );
        
		if ($arRes = $db->fetch($res)){				
			
			//$this->setUserCookie($arRes[\'id\'] , $crypto->getRandString());
			$this->setUserCookie($arRes[\'id\'] , $crypto->getStringForUserCookie($arRes[\'login\'], $arRes[\'name\'], $arRes[\'id\']));
			$result = true;		
		}
		
		return $result;
		
	}
	
    /**
     * setUserCookie - установить пользовательскую куку
     * @global type $db
     * @param int $userId - id пользователя
     * @param string $StringCookie - строка, значение куки
     * @return boolean
     */
	protected function setUserCookie($userId, $StringCookie){
		setcookie($this->nameCookie, $StringCookie, 0, \'/\');
		global $db;
        
        $res = $db->updateDb(
            $this->tableName, 
            array(\'hash_auth\' => $StringCookie), 
            array( \'=\' => array(\'id\' , $userId ) )    
        );
        
		return true;
	}
	
    /**
     * deleteUserCookie - удалить пользовательскую куку
     * @global type $_COOKIE
     * @global type $db
     * @param int $userId - id пользователя
     * @return boolean
     */
	protected function deleteUserCookie($userId){
		global $_COOKIE;
		unset($_COOKIE[$this->nameCookie]);
		global $db;
        
        $res = $db->updateDb(
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
	public function checkUserCookie(){
		$result = false;
		
		global $_COOKIE;
		
		if(!empty($_COOKIE[$this->nameCookie]) ){
						
			$dataUser = $this->findUserByCookie($_COOKIE[$this->nameCookie]);
						
			if ($dataUser !== false){
				$this->dataUser = $dataUser;
                
                // получить группы к каким относится пользователь
                $this->dataUser[\'groups\'] = accessUserGroup::getListGroupsByUser($dataUser[\'id\']);
                
				$this->authorized = true;
				if ( !empty($this->dataUser[\'groups\'][\'admins\']) ){
					$this->admin = true;
				}
				$result = true;
			}
		}
		return $result;
	}
	
    /**
     * findUserByCookie - найти пользователя по значению куки
     * @global type $db
     * @param string $cookie
     * @return array - данные пользователя
     */
	protected function findUserByCookie($cookie){
		$result = false;
		
		global $db;
		
		//$res = $db->query($db->db, \'select * from users where hash_auth="\'.$cookie.\'";\');
			
        $res = $db->selectDb(
            $this->tableName, 
            array(\'*\'), 
            array( \'=\' => array(\'hash_auth\', "\'".$cookie."\'") ) 
        );
        
		if ($arRes = $db->fetch($res)){
			$result = $arRes;		
		}
				
		return $result;
	}
	
    /**
     * userExit - сделать выход для пользователя 
     * @return boolean
     */
	public function userExit(){
		return $this->deleteUserCookie($this->dataUser[\'id\']);
	}
	
    /**
     * getAllDataUsers - получить данные по пользователю 
     * @global type $db
     * @return array
     */
	public function getAllDataUsers(){
		$result = array();
		global $db;		        
        $res = $db->selectDb( 
            $this->tableName, 
            array(\'*\')
        );
        $result = $db->fetchAll($res, false);
        
        // получить группы пользователей
        foreach ($result as $key => $value) {
            $result[$key][\'groups\'] = accessUserGroup::getListGroupsByUser($value[\'id\']);
        }
        
		return $result;
	}
	
    /**
     * getUserById - получить данные по пользователю по id
     * @global type $db
     * @param type $id
     * @return array
     */
    public function getUserById($id){
		$result = array();
		global $db;		        
        $res = $db->selectDb( 
            $this->tableName, 
            array(\'*\'),
            array(
                \'=\' => array(\'id\', $id)
            )
        );
        $result = $db->fetch($res, false);
        
        // получить группы текущего пользователя
        $result[\'groups\'] = accessUserGroup::getListGroupsByUser($id);
        
		return $result;
	}
    
    /**
     * addUsers - добавить пользователя
     * @global type $db
     * @global type $crypto
     * @param type $data
     * @return boolean
     */
	public function addUsers($data){
		$result = false;

		// id, login, name, pass, groups
		global $db;		
        $res = $db->insertDb($this->tableName, $data);
                
        if ($res){
			$result = true;
		}
			
		return $result;
	}
	
    /**
     * updateUserById - обновление данных пользователя
     * @global type $db
     * @param int $userId - id пользователя
     * @param array $arParams - данные пользователя
     * @return boolean
     */
    public function updateUserById($userId, $arParams){
        $result = false;

        unset($arParams[\'id\']);
        
		global $db;		
        $res = $db->updateDb($this->tableName, $arParams, array(\'=\' => array(\'id\', $userId)));
        
        if ($res){
			$result = true;
		}
			
		return $result; 
    }
    
    /**
     * deleteUserById - удалить пользователя
     * @global type $db
     * @param int $idUser - id пользователя
     * @return string
     */
	public function deleteUserById($idUser){
		$result = false;
		
		if (is_numeric($idUser) && ($idUser != 1)){
			global $db;
			
			$res = $db->query(\'DELETE FROM \'.$this->tableName.\' WHERE id = \'.$idUser.\';\');

			if ($res){
				$result = true;		
			}
		}		
		return $result;
	}
	
}
',
    'TYPE' => 'php',
    'DIR' => './gy/classes/',
  ),
  './gy/component/add_user/controller.php' => 
  array (
    'CODE' => '<?php 
if ( !defined("GY_GLOBAL_FLAG_CORE_INCLUDE") && (GY_GLOBAL_FLAG_CORE_INCLUDE !== true) ) die( "gy: err include core" );

$data  = $_REQUEST;

$arRes[\'user_property\'] = array(
	\'login\', 
	\'name\', 
	\'pass\', 
	\'groups\'
);

$redirectUrl = str_replace(\'index.php\', \'\', $_SERVER[\'DOCUMENT_URI\']);

// взять все группы пользователей
$arRes[\'allUsersGroups\'] = accessUserGroup::getAccessGroup();

function checkProperty($arr, $arRes){
	$result = true;
	foreach ($arRes[\'user_property\'] as $val){	
        if (empty($arr[$val])){
            $result = false;
        }    
	}
    
    if($result){
        foreach ($arr[\'groups\'] as $value) {  // TODO протестировать
            
            if( empty($arRes[\'allUsersGroups\'][$value]) ){
                $result = false;
            }
            
            if(!empty($arr[\'groups\'][\'admins\']) && !$user->isAdmin()){ // TODO протестировать
                $result = false;
            }
        }
    }
    
	return $result;
}

if (!empty($data[\'Добавить\']) && ($data[\'Добавить\'] == \'Добавить\')) {
	if(checkProperty($data, $arRes)){
		// добавление пользователя
		global $user;
		$arDaraUser = array();
		foreach ($arRes[\'user_property\'] as $val){
			$arDaraUser[$val] = $data[$val];
		}
		
        // убрать группы из добавления
        unset($arDaraUser[\'groups\']);
       
		if( $user->addUsers($arDaraUser)){
            // найти id добавленного пользователя
            global $db;		   
            global $crypto;
            $res = $db->selectDb( 
                $user->tableName, 
                array(\'*\'),
                array(
                    \'AND\' => array(
                        \'=\' => array(\'login\', "\'".$arDaraUser[\'login\']."\'"),
                        \'AND\' => array(\'=\' => array(\'pass\', "\'".md5($arDaraUser[\'pass\'].$crypto->getSole())."\'") )
                    )
                )
            );
            $dataAddNewUser = $db->fetch($res);
            
            // добавить пользователя к указанным группам
            accessUserGroup::deleteUserInAllGroups($dataAddNewUser[\'id\']);
            foreach ($data[\'groups\'] as $value) {
                accessUserGroup::addUserInGroup($dataAddNewUser[\'id\'], $value);
            }
            
			$arRes["stat"] = \'ok\';
		} else{
			$arRes["stat"] = \'err\';
		}
				
	}else{
		$arRes["stat-text"] = \'! Не все поля заполнены\';
		$arRes["stat"] = \'err\';
	}
	
} elseif( (!empty($arRes["stat"]) && ($arRes["stat"] != \'err\')) || empty($arRes["stat"]) ) {
	$arRes["stat"] = \'add\';
}

if (empty($data[\'stat\'])){
	header( \'Location: \'.$redirectUrl.\'?stat=\'.$arRes["stat"] );
}else{
	$arRes["stat"] = $data[\'stat\'];
}

// показать шаблон
$this->template->show($arRes, $this->arParam);
',
    'TYPE' => 'php',
    'DIR' => './gy/component/add_user/',
  ),
  './gy/component/add_user/teplates/0/lang_template.php' => 
  array (
    'CODE' => '<? // языковой файл для шаблона компонента
if ( !defined("GY_GLOBAL_FLAG_CORE_INCLUDE") && (GY_GLOBAL_FLAG_CORE_INCLUDE !== true) ) die( "gy: err include core" );

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

',
    'TYPE' => 'php',
    'DIR' => './gy/component/add_user/teplates/0/',
  ),
  './gy/component/add_user/teplates/0/template.php' => 
  array (
    'CODE' => '<?
if ( !defined("GY_GLOBAL_FLAG_CORE_INCLUDE") && (GY_GLOBAL_FLAG_CORE_INCLUDE !== true) ) die( "gy: err include core" );

?>
<h3><?=$this->lang->GetMessage(\'title-add\');?></h3>
<?

if (!empty($arParam[\'back-url\'])){?>
    <br/>
    <br/>
	<a class="gy-admin-button" href="<?=$arParam[\'back-url\'];?>"><?=$this->lang->GetMessage(\'back\');?></a>
	<br/>
	<br/>
<?}?>
<? if ($arRes["stat"] == \'add\') {?>
	<form>
		<? foreach ($arRes["user_property"] as $key => $val ){?>
			<?=$this->lang->GetMessage($val);?>:<br/>
			<?if($val != \'groups\'){?>
                <input type="<?=(($val == \'pass\')? \'password\': \'text\');?>" name="<?=$val;?>" />
            <?}else{?>
                <select multiple name="groups[]">
                    <? foreach ($arRes[\'allUsersGroups\'] as $value) { ?>
                        <option value="<?=$value[\'code\'];?>">
                            <?=$value[\'name\']?> (<?=$value[\'code\'];?>)
                        </option>
                    <?}?>
                </select>
            <?}?>
            <br/>
		<?}?>
		<input class="gy-admin-button" type="submit" name="<?=$this->lang->GetMessage(\'button\');?>" value="<?=$this->lang->GetMessage(\'button\');?>" />

	</form>	
	
<?}elseif($arRes["stat"] == \'ok\'){?>
    <div class="gy-admin-good-message"><?=$this->lang->GetMessage(\'add-ok\');?></div>
    <br/>
    <a href="<?=$arParam[\'back-url\'];?>" class="gy-admin-button"><?=$this->lang->GetMessage(\'ok\');?></a>
<?}elseif($arRes["stat"] == \'err\'){?>
    <div class="gy-admin-error-message"><?=$this->lang->GetMessage(\'add-err\');?></div>
	<?if (!empty($arRes["stat-text"])){?>
		<br/> <?=$arRes["stat-text"];?>
	<?}?>
    <br/>
    <a href="<?=$arParam[\'back-url\'];?>" class="gy-admin-button"><?=$this->lang->GetMessage(\'ok\');?></a>
<? } 
',
    'TYPE' => 'php',
    'DIR' => './gy/component/add_user/teplates/0/',
  ),
  './gy/component/admin/controller.php' => 
  array (
    'CODE' => '<?php
if ( !defined("GY_GLOBAL_FLAG_CORE_INCLUDE") && (GY_GLOBAL_FLAG_CORE_INCLUDE !== true) ) die( "gy: err include core" );

$arRes = array();

// контроллер компонента admin 

// показать шаблон
$this->template->show($arRes, $this->arParam);
',
    'TYPE' => 'php',
    'DIR' => './gy/component/admin/',
  ),
  './gy/component/admin/lang_controller.php' => 
  array (
    'CODE' => '<? // языковой файл для компонента
if ( !defined("GY_GLOBAL_FLAG_CORE_INCLUDE") && (GY_GLOBAL_FLAG_CORE_INCLUDE !== true) ) die( "gy: err include core" );

$mess[\'rus\'] = array(
	//\'test\' => \'ok\',
);
',
    'TYPE' => 'php',
    'DIR' => './gy/component/admin/',
  ),
  './gy/component/admin/teplates/0/lang_template.php' => 
  array (
    'CODE' => '<? // языковой файл для шаблона компонента
if ( !defined("GY_GLOBAL_FLAG_CORE_INCLUDE") && (GY_GLOBAL_FLAG_CORE_INCLUDE !== true) ) die( "gy: err include core" );

$mess[\'rus\'] = array(
	\'hi\' => \'Админка gy framework\',
);

',
    'TYPE' => 'php',
    'DIR' => './gy/component/admin/teplates/0/',
  ),
  './gy/component/admin/teplates/0/template.php' => 
  array (
    'CODE' => '<?/*<H2><?=$this->lang->GetMessage(\'hi\');?></h2>*/?>
<?
if ( !defined("GY_GLOBAL_FLAG_CORE_INCLUDE") && (GY_GLOBAL_FLAG_CORE_INCLUDE !== true) ) die( "gy: err include core" );

global $app;

$app->component(
	\'form_auth\',
	\'0\',
	array( 
	)
);


',
    'TYPE' => 'php',
    'DIR' => './gy/component/admin/teplates/0/',
  ),
  './gy/component/capcha/controller.php' => 
  array (
    'CODE' => '<?php 
if ( !defined("GY_GLOBAL_FLAG_CORE_INCLUDE") && (GY_GLOBAL_FLAG_CORE_INCLUDE !== true) ) die( "gy: err include core" );

global $app;

$arRes = array();

$capcha = new capcha( $app->url.capcha::$defaultUrlFonts );

$data = $_REQUEST;

if (!empty($_REQUEST[\'capcha_get_image\']) && ($_REQUEST[\'capcha_get_image\'] == 1) ){
    // нарисовать капчу
    $capcha->getImageCapcha();
} else{
    // показать шаблон
    $this->template->show($arRes, $this->arParam);
}',
    'TYPE' => 'php',
    'DIR' => './gy/component/capcha/',
  ),
  './gy/component/capcha/teplates/0/lang_template.php' => 
  array (
    'CODE' => '<? // языковой файл для шаблона компонента
if ( !defined("GY_GLOBAL_FLAG_CORE_INCLUDE") && (GY_GLOBAL_FLAG_CORE_INCLUDE !== true) ) die( "gy: err include core" );

$mess[\'rus\'] = array(
);

',
    'TYPE' => 'php',
    'DIR' => './gy/component/capcha/teplates/0/',
  ),
  './gy/component/capcha/teplates/0/template.php' => 
  array (
    'CODE' => '<?if ( !defined("GY_GLOBAL_FLAG_CORE_INCLUDE") && (GY_GLOBAL_FLAG_CORE_INCLUDE !== true) ) die( "gy: err include core" );?>

<div>
    <img src="?capcha_get_image=1" />
    <input name="capcha" type="text" value="" />
</div>',
    'TYPE' => 'php',
    'DIR' => './gy/component/capcha/teplates/0/',
  ),
  './gy/component/edit_user/controller.php' => 
  array (
    'CODE' => '<?php 
if ( !defined("GY_GLOBAL_FLAG_CORE_INCLUDE") && (GY_GLOBAL_FLAG_CORE_INCLUDE !== true) ) die( "gy: err include core" );

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
if($notUpdatePass){
    unset($arRes[\'user_property\'][\'pass\']);
}

global $user; 

// взять все группы пользователей
$arRes[\'allUsersGroups\'] = accessUserGroup::getAccessGroup();

function checkProperty($arr, $arRes){
	$result = true;
	foreach ($arRes[\'user_property\'] as $val){	
        if (empty($arr[$val])){
            $result = false;
        } 
	}
        
    if($result){
        foreach ($arr[\'groups\'] as $value) {  // TODO протестировать
            
            if( empty($arRes[\'allUsersGroups\'][$value]) ){
                $result = false;
            }
            
            if(!empty($arr[\'groups\'][\'admins\']) && !$user->isAdmin()){ // TODO протестировать
                $result = false;
            }
        }
    }
    
	return $result;
}

// получить данные пользователя
if(!empty($this->arParam[\'id-user\'])){  
    $arRes[\'userData\'] = $user->getUserById($this->arParam[\'id-user\']);  
    unset($arRes[\'userData\'][\'pass\']);
}

if (!empty($data[\'Сохранить\']) 
    && ($data[\'Сохранить\'] == \'Сохранить\') 
    && !empty($data[\'edit-id\']) 
    && is_numeric($data[\'edit-id\']) 
    && ($data[\'edit-id\'] != 1)  
) {
        
	if(checkProperty($data, $arRes)){

        // подготовить массив данных для обновления пользователей
        $dataUpdateUser = array();
        foreach ($arRes[\'user_property\'] as $value) {
            $dataUpdateUser[$value] = $data[$value];
        }

        // сохранить группы для пользователя
        unset($dataUpdateUser[\'groups\']);
        accessUserGroup::deleteUserInAllGroups($data[\'edit-id\']);
        foreach ($data[\'groups\'] as $value) {
            accessUserGroup::addUserInGroup($data[\'edit-id\'], $value);
        }
        
        // обновить данные пользователя
		global $user;
        $res = $user->updateUserById($data[\'edit-id\'], $dataUpdateUser);
        
        if($res){
            $arRes["stat"] = \'ok\';
        }else{
            $arRes["stat-text"] = \'! Не все поля заполнены\';
            $arRes["stat"] = \'err\';
        }
        			
	}else{
		$arRes["stat-text"] = \'! Не все поля заполнены\';
		$arRes["stat"] = \'err\';
	}
	
	
} elseif( (!empty($arRes["stat"]) && ($arRes["stat"] != \'err\')) || empty($arRes["stat"]) ) {
	$arRes["stat"] = \'edit\';
}

if (empty($data[\'stat\'])){
	header( \'Location: ?stat=\'.$arRes["stat"].\'&edit-id=\'.$this->arParam[\'id-user\'] );
}else{
	$arRes["stat"] = $data[\'stat\'];
}
     
// показать шаблон
$this->template->show($arRes, $this->arParam);
',
    'TYPE' => 'php',
    'DIR' => './gy/component/edit_user/',
  ),
  './gy/component/edit_user/teplates/0/lang_template.php' => 
  array (
    'CODE' => '<? // языковой файл для шаблона компонента
if ( !defined("GY_GLOBAL_FLAG_CORE_INCLUDE") && (GY_GLOBAL_FLAG_CORE_INCLUDE !== true) ) die( "gy: err include core" );

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
    \'no-update-pass-text\' => \'Не изменять пароль\'
);

',
    'TYPE' => 'php',
    'DIR' => './gy/component/edit_user/teplates/0/',
  ),
  './gy/component/edit_user/teplates/0/template.php' => 
  array (
    'CODE' => '<?
if ( !defined("GY_GLOBAL_FLAG_CORE_INCLUDE") && (GY_GLOBAL_FLAG_CORE_INCLUDE !== true) ) die( "gy: err include core" );

?>
<h3><?=$this->lang->GetMessage(\'title\');?></h3>
<?
if (!empty($arParam[\'back-url\']) && empty($arRes["stat"])){?>
    <br/>
    <br/>
	<a class="gy-admin-button" href="<?=$arParam[\'back-url\'];?>"><?=$this->lang->GetMessage(\'back\');?></a>
	<br/>
	<br/>
<?}?>
<? if (empty($arRes["stat"]) || ($arRes["stat"] == \'edit\') ) {?>
	<form>
        <input type="hidden" name="edit-id" value="<?=$arParam[\'id-user\'];?>" />
		<? foreach ($arRes["user_property"] as $key => $val ){?>
			<?=$this->lang->GetMessage($val);?>:<br/>
            <?if ($val != \'groups\'){?>
                <input 
                    type="<?=(($val == \'pass\')? \'password\': \'text\');?>" 
                    name="<?=$val;?>" 
                    value="<?=((!empty($arRes[\'userData\'][$val]))? $arRes[\'userData\'][$val] : \'\');?>"
                />
                <?
                // эта галочка что бы можно было менять настройки пользователя, без смены пароля
                if($val == \'pass\'){?>
                    <input type="checkbox" name="no-update-pass" /><?=$this->lang->GetMessage(\'no-update-pass-text\');?> 
                <?}?>
            <?}else{?>
                <select multiple name="groups[]">
                    <? foreach ($arRes[\'allUsersGroups\'] as $value) { ?>
                        <option <?=(( !empty($arRes[\'userData\'][$val][$value[\'code\']]) )? \'selected\' : \'\');?> value="<?=$value[\'code\'];?>">
                            <?=$value[\'name\']?> (<?=$value[\'code\'];?>)
                        </option>
                    <?}?>
                </select>
            <?}?>    
			<br/>
		<?}?>
		<input class="gy-admin-button" type="submit" name="<?=$this->lang->GetMessage(\'button\');?>" value="<?=$this->lang->GetMessage(\'button\');?>" />

	</form>	
	
<?}elseif($arRes["stat"] == \'ok\'){?>
    <div class="gy-admin-good-message"><?=$this->lang->GetMessage(\'stat-ok\');?></div>
    <br/>
    <a href="/gy/admin/users.php" class="gy-admin-button"><?=$this->lang->GetMessage(\'ok\');?></a>
<?}elseif($arRes["stat"] == \'err\'){?>
    <div class="gy-admin-error-message"><?=$this->lang->GetMessage(\'edit-err\');?></div>
	<?if (!empty($arRes["stat-text"])){?>
		<br/> <?=$arRes["stat-text"];?>
	<?}?>
    <br/>
    <a href="edit-user.php?edit-id=<?=$arParam[\'id-user\'];?>" class="gy-admin-button"><?=$this->lang->GetMessage(\'ok\');?></a>
<? } 
',
    'TYPE' => 'php',
    'DIR' => './gy/component/edit_user/teplates/0/',
  ),
  './gy/component/form_auth/controller.php' => 
  array (
    'CODE' => '<?php 
if ( !defined("GY_GLOBAL_FLAG_CORE_INCLUDE") && (GY_GLOBAL_FLAG_CORE_INCLUDE !== true) ) die( "gy: err include core" );

// контроллер компонента form_auth (форма авторизации)

// подключить модель // include model this component
if (isset($this->model) ){
	$this->model->includeModel(); 
}	

// были доступны параметры
//echo \'$arParam<pre>\'; print_r($this->arParam); echo \'</pre>\';

// если задан параметр idComponent значит сверить с пришедшим
$isChackIdComponent = ( empty($this->arParam[\'idComponent\']) 
    || (!empty($this->arParam[\'idComponent\']) && !empty($_REQUEST[\'idComponent\']) && ($this->arParam[\'idComponent\'] == $_REQUEST[\'idComponent\']) ) 
);

$isShowAdminPanel = false;

if(!empty($_REQUEST[\'auth\'])){
    $thisLogin = $_REQUEST[\'auth\'];
}

global $user;

$isShowAdminPanel = accessUserGroup::accessThisUserByAction( \'show_admin_panel\');

$redirectUrl = str_replace(\'index.php\', \'\', $_SERVER[\'DOCUMENT_URI\']);

if ($isShowAdminPanel === true){
		
	$thisLogin = $user->getDataThisUser()[\'name\'];	
	$arRes["auth_ok"] = \'ok\';
	$arRes["auth_user"] = $thisLogin;
		
} elseif ( !empty($_REQUEST[\'auth\']) && !empty($_REQUEST[\'pass\']) && !empty($_REQUEST[\'capcha\'])) {
	
    if( capcha::chackCapcha($_REQUEST[\'capcha\']) ){

        $user->authorized($_REQUEST[\'auth\'], $_REQUEST[\'pass\']);
        $isShowAdminPanel = accessUserGroup::accessThisUserByAction( \'show_admin_panel\');

        if ($isShowAdminPanel === false){
            $arRes["err"] = \'err1\'; 
        }

        if ($isChackIdComponent && $isShowAdminPanel){
            $arRes["auth_ok"] = \'ok\';
            $arRes["auth_user"] = $thisLogin;

            header( \'Location: \'.$redirectUrl );
        } else {
            $arRes[\'form_input\']["auth"] = "auth";
            $arRes[\'form_input\']["pass"] = "pass";
            header( \'Location: \'.$redirectUrl.\'?err=err1\' );

        }
    }else{
        $arRes[\'form_input\']["auth"] = "auth";
        $arRes[\'form_input\']["pass"] = "pass";
        header( \'Location: \'.$redirectUrl.\'?err=err_capcha\' );
    }
} else {
	if (!empty($_REQUEST[\'err\'])){
		$arRes["err"] = $_REQUEST[\'err\']; 
	}
	$arRes[\'form_input\']["auth"] = "auth";
	$arRes[\'form_input\']["pass"] = "pass";
}

if ( !empty($arRes["auth_ok"]) && ($arRes["auth_ok"] == \'ok\') && !empty($_REQUEST[\'Выйти\'])){
	if ($user->userExit() ){
		header( \'Location: \'.$redirectUrl );
	}
}

// показать шаблон
$this->template->show($arRes, $this->arParam);
',
    'TYPE' => 'php',
    'DIR' => './gy/component/form_auth/',
  ),
  './gy/component/form_auth/teplates/0/lang_template.php' => 
  array (
    'CODE' => '<? // языковой файл для шаблона компонента
if ( !defined("GY_GLOBAL_FLAG_CORE_INCLUDE") && (GY_GLOBAL_FLAG_CORE_INCLUDE !== true) ) die( "gy: err include core" );

$mess[\'rus\'] = array(
	\'button\' => \'Авторизоваться\',
	\'err1\' => \'! Логин или пароль неправильные.\',
	\'exit\' => \'Выйти\',
	\'err_capcha\' => \'! Ошибка в capcha, попробуйте ещё раз\'
);

',
    'TYPE' => 'php',
    'DIR' => './gy/component/form_auth/teplates/0/',
  ),
  './gy/component/form_auth/teplates/0/template.php' => 
  array (
    'CODE' => '<? // шаблон компонента // template component form_auth
if ( !defined("GY_GLOBAL_FLAG_CORE_INCLUDE") && (GY_GLOBAL_FLAG_CORE_INCLUDE !== true) ) die( "gy: err include core" );

if ( empty($arRes["auth_ok"]) ) :?>
	<form>
		<input type="hidden" name="idComponent" value="<?=$arParam[\'idComponent\']?>" />

		<?foreach ($arRes[\'form_input\'] as $key => $value) { ?>
			<input type="<?=(($key == \'pass\')? \'password\': \'text\');?>" name="<?=$key;?>"  /><br/>
		<?}?>

        <? // показать капчу
        global $app;
        $app->component(
            \'capcha\',
            \'0\',
            array( 
            )
        );?>
            
		<?if ( !empty($arRes[\'err\']) ){?>
			<div class="gy-admin-error-message"><?=$this->lang->GetMessage($arRes[\'err\']);?></div>
		<?}?>	
		
        <input class="gy-admin-button" type="submit" name="<?=$this->lang->GetMessage(\'button\');?>" value="<?=$this->lang->GetMessage(\'button\');?>" />
        
	</form>	
<?else:?>
	<h1>Привет, <?=$arRes["auth_user"];?></h1>
	<form>
		<input class="gy-admin-button" type="submit" name="<?=$this->lang->GetMessage(\'exit\');?>" value="<?=$this->lang->GetMessage(\'exit\');?>" />
	</form>
<?endif;?>',
    'TYPE' => 'php',
    'DIR' => './gy/component/form_auth/teplates/0/',
  ),
  './gy/component/form_auth_test/controller.php' => 
  array (
    'CODE' => '<?php 
if ( !defined("GY_GLOBAL_FLAG_CORE_INCLUDE") && (GY_GLOBAL_FLAG_CORE_INCLUDE !== true) ) die( "gy: err include core" );

// контроллер компонента form_auth_test (форма авторизации)

// подключить модель // include model this component
if (isset($this->model) ){
	$this->model->includeModel(); 
}	

// были доступны параметры
//echo \'$arParam<pre>\'; print_r($this->arParam); echo \'</pre>\';

// если задан параметр idComponent значит сверить с пришедшим
$isChackIdComponent = ( empty($this->arParam[\'idComponent\']) 
    || (!empty($this->arParam[\'idComponent\']) && !empty($_REQUEST[\'idComponent\']) && ($this->arParam[\'idComponent\'] == $_REQUEST[\'idComponent\']) ) 
);

// $model - теоретически должно быть тут доступно
if ($isChackIdComponent && !empty($_REQUEST[\'auth\']) ){
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
  './gy/component/form_auth_test/lang_controller.php' => 
  array (
    'CODE' => '<? // языковой файл для компонента
if ( !defined("GY_GLOBAL_FLAG_CORE_INCLUDE") && (GY_GLOBAL_FLAG_CORE_INCLUDE !== true) ) die( "gy: err include core" );

$mess[\'rus\'] = array(
	\'test\' => \'ok\',
);
',
    'TYPE' => 'php',
    'DIR' => './gy/component/form_auth_test/',
  ),
  './gy/component/form_auth_test/model.php' => 
  array (
    'CODE' => '<? 
if ( !defined("GY_GLOBAL_FLAG_CORE_INCLUDE") && (GY_GLOBAL_FLAG_CORE_INCLUDE !== true) ) die( "gy: err include core" );

/**
 * это модель класса, тут должны быть функции к которым будет обращаться компонент
 * также подключаться более общие классы (users, БД ... ) 
 * 
 * this is model component, here function for component and include class
 * 
 * TODO может модель сделать универсальной и не писать свою для каждого класса
 * 		надо подумать
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
    'CODE' => '<? // языковой файл для шаблона компонента
if ( !defined("GY_GLOBAL_FLAG_CORE_INCLUDE") && (GY_GLOBAL_FLAG_CORE_INCLUDE !== true) ) die( "gy: err include core" );

$mess[\'rus\'] = array(
	\'button\' => \'Отправить\',
    \'get-text\' => \'Введите любой текст\'
);

$mess[\'eng\'] = array(
	\'button\' => \'Send\',
    \'get-text\' => \'pleas input any text\'
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
    'CODE' => '<? // шаблон компонента // template component form_auth_test
if ( !defined("GY_GLOBAL_FLAG_CORE_INCLUDE") && (GY_GLOBAL_FLAG_CORE_INCLUDE !== true) ) die( "gy: err include core" );

if ( empty($arRes["auth_ok"]) ) :?>
	<form>
        <p><?=$this->lang->GetMessage(\'get-text\');?></p>
		<? 
		foreach ($arRes as $key => $value) {
		?>
		<input type="hidden" name="idComponent" value="<?=$arParam[\'idComponent\']?>" />
			<input type="text" name="<?=$key;?>"  />
		<?}?>

		<input type="submit" name="<?=$this->lang->GetMessage(\'button\');?>" value="<?=$this->lang->GetMessage(\'button\');?>" />

	</form>	
<?else:?>
	<h1>Привет, <?=$arRes["auth_user"];?></h1>

<?endif;?>',
    'TYPE' => 'php',
    'DIR' => './gy/component/form_auth_test/teplates/0/',
  ),
  './gy/component/gy_options/controller.php' => 
  array (
    'CODE' => '<?php 
if ( !defined("GY_GLOBAL_FLAG_CORE_INCLUDE") && (GY_GLOBAL_FLAG_CORE_INCLUDE !== true) ) die( "gy: err include core" );

$data = $_POST;

if(!empty($data[\'cacheClear\'])){
    // нужно удалить все файлы из раздела /gy/cache/
    global $app;    
    $files = glob($app->url.\'/cache/*\'); 
    foreach($files as $file){
        if(is_file($file)){
            unlink($file); 
        }
    }
    $arRes[\'status\'] = \'cacheClear-ok\'; 
}

$arRes[\'button\'] = array(
    \'cacheClear\'
);

// показать шаблон
$this->template->show($arRes, $this->arParam);
',
    'TYPE' => 'php',
    'DIR' => './gy/component/gy_options/',
  ),
  './gy/component/gy_options/teplates/0/lang_template.php' => 
  array (
    'CODE' => '<? // языковой файл для шаблона компонента
if ( !defined("GY_GLOBAL_FLAG_CORE_INCLUDE") && (GY_GLOBAL_FLAG_CORE_INCLUDE !== true) ) die( "gy: err include core" );

$mess[\'rus\'] = array(
	\'title\' => \'Настройки\',
    \'cacheClear\' => \'Сбросить кеш\',
    \'ok\' => \'ОК\',
    \'cacheClear-ok\' => \'! кеш сброшен\'
);

',
    'TYPE' => 'php',
    'DIR' => './gy/component/gy_options/teplates/0/',
  ),
  './gy/component/gy_options/teplates/0/template.php' => 
  array (
    'CODE' => '<?
if ( !defined("GY_GLOBAL_FLAG_CORE_INCLUDE") && (GY_GLOBAL_FLAG_CORE_INCLUDE !== true) ) die( "gy: err include core" );?>

<h1><?=$this->lang->GetMessage(\'title\');?></h1>

<?if(empty($arRes[\'status\']) && !empty($arRes[\'button\'])){?>
    <? foreach ($arRes[\'button\'] as $val) { ?>
        <form method="post">
            <input type=\'submit\' class="gy-admin-button" name="cacheClear" value="<?=$this->lang->GetMessage(\'cacheClear\');?>" />
        </form>
    <?}?>
<? }else{ ?>
    <?if ($arRes[\'status\'] == \'cacheClear-ok\'){?>
        <div class="gy-admin-good-message"><?=$this->lang->GetMessage(\'cacheClear-ok\');?></div>
    <? } ?>
    <br/>
    <a href="/gy/admin/options.php" class="gy-admin-button"><?=$this->lang->GetMessage(\'ok\');?></a>
<?}',
    'TYPE' => 'php',
    'DIR' => './gy/component/gy_options/teplates/0/',
  ),
  './gy/component/menu/controller.php' => 
  array (
    'CODE' => '<?php 
if ( !defined("GY_GLOBAL_FLAG_CORE_INCLUDE") && (GY_GLOBAL_FLAG_CORE_INCLUDE !== true) ) die( "gy: err include core" );

$arRes[\'thisUrl\'] = $_SERVER[\'SCRIPT_NAME\'];

// показать шаблон
$this->template->show($arRes, $this->arParam);
',
    'TYPE' => 'php',
    'DIR' => './gy/component/menu/',
  ),
  './gy/component/menu/lang_controller.php' => 
  array (
    'CODE' => '<? // языковой файл для компонента
if ( !defined("GY_GLOBAL_FLAG_CORE_INCLUDE") && (GY_GLOBAL_FLAG_CORE_INCLUDE !== true) ) die( "gy: err include core" );

$mess[\'rus\'] = array(
	//\'test\' => \'ok\',
);
',
    'TYPE' => 'php',
    'DIR' => './gy/component/menu/',
  ),
  './gy/component/menu/teplates/0/lang_template.php' => 
  array (
    'CODE' => '<? // языковой файл для шаблона компонента
if ( !defined("GY_GLOBAL_FLAG_CORE_INCLUDE") && (GY_GLOBAL_FLAG_CORE_INCLUDE !== true) ) die( "gy: err include core" );

$mess[\'rus\'] = array(
	\'hi\' => \'Админка gy framework\',
);

',
    'TYPE' => 'php',
    'DIR' => './gy/component/menu/teplates/0/',
  ),
  './gy/component/menu/teplates/0/template.php' => 
  array (
    'CODE' => '<?
if ( !defined("GY_GLOBAL_FLAG_CORE_INCLUDE") && (GY_GLOBAL_FLAG_CORE_INCLUDE !== true) ) die( "gy: err include core" );

if ($arParam[\'buttons\']){?>
	<div class="gy-admin-menu">
		<? foreach ($arParam[\'buttons\'] as $key => $val){?>
			<a href="<?=$val;?>" class="<?=(($val == $arRes[\'thisUrl\'])? \'active-menu\': \'\');?>"><?=$key;?></a>
		<?}?>
	</div>
<?}',
    'TYPE' => 'php',
    'DIR' => './gy/component/menu/teplates/0/',
  ),
  './gy/component/users_all_tables/controller.php' => 
  array (
    'CODE' => '<?php 
if ( !defined("GY_GLOBAL_FLAG_CORE_INCLUDE") && (GY_GLOBAL_FLAG_CORE_INCLUDE !== true) ) die( "gy: err include core" );

global $user;
$arRes[\'allUsers\'] = $user->getAllDataUsers();

// взять все группы пользователей
$arRes[\'allUsersGroups\'] = accessUserGroup::getAccessGroup();

// показать шаблон
$this->template->show($arRes, $this->arParam);
',
    'TYPE' => 'php',
    'DIR' => './gy/component/users_all_tables/',
  ),
  './gy/component/users_all_tables/teplates/0/lang_template.php' => 
  array (
    'CODE' => '<? // языковой файл для шаблона компонента
if ( !defined("GY_GLOBAL_FLAG_CORE_INCLUDE") && (GY_GLOBAL_FLAG_CORE_INCLUDE !== true) ) die( "gy: err include core" );

$mess[\'rus\'] = array(
	\'del-user\' => \'удалить\',
	\'edit-user\' => \'изменить\',
    \'title\' => \'Пользователи\',
    \'add-user\' => \'Добавить пользователя\'
);

',
    'TYPE' => 'php',
    'DIR' => './gy/component/users_all_tables/teplates/0/',
  ),
  './gy/component/users_all_tables/teplates/0/template.php' => 
  array (
    'CODE' => '<?if ( !defined("GY_GLOBAL_FLAG_CORE_INCLUDE") && (GY_GLOBAL_FLAG_CORE_INCLUDE !== true) ) die( "gy: err include core" );?>

<h1><?=$this->lang->GetMessage(\'title\');?></h1>

<?if ($arRes[\'allUsers\']){?>
	<table border="1" class="gy-table-all-users">
		<tr><th>id</th><th>login</th><th>name</th><th>group</th><th></th></tr>
		<?foreach ($arRes[\'allUsers\'] as $key => $val){?>
			<tr>
				<td><?=$val[\'id\'];?></td>
				<td><?=$val[\'login\'];?></td>
				<td><?=$val[\'name\'];?></td>
				<td>
                    <? foreach ($val[\'groups\'] as $groupIs) {?>
                        -
                        <?=$arRes[\'allUsersGroups\'][$groupIs][\'name\'];?>
                        (
                        <?=$arRes[\'allUsersGroups\'][$groupIs][\'code\'];?>
                        );
                        <br/>
                    <?}?>
                 
                </td>
				<td>
					<?if ($val[\'id\'] != 1){?>
                        <button  class="del-user gy-admin-button" data-id-user="<?=$val[\'id\'];?>"><?=$this->lang->GetMessage(\'del-user\');?></button>
                        <a href="edit-user.php?edit-id=<?=$val[\'id\'];?>" class="gy-admin-button"><?=$this->lang->GetMessage(\'edit-user\');?></a>
                    <?} ?>
				</td>
			</tr>
		<?}?>
	</table>

    	
    <br/>
    <br/>
	<a class="gy-admin-button" href="add-user.php"><?=$this->lang->GetMessage(\'add-user\');?></a>
	<br/>
	<br/>
<?}',
    'TYPE' => 'php',
    'DIR' => './gy/component/users_all_tables/teplates/0/',
  ),
  './gy/component/users_group_manager/controller.php' => 
  array (
    'CODE' => '<?php 
if ( !defined("GY_GLOBAL_FLAG_CORE_INCLUDE") && (GY_GLOBAL_FLAG_CORE_INCLUDE !== true) ) die( "gy: err include core" );

$arRes = array();
$data = $_REQUEST;

// добавить новую группу если добавляется новая
if( !empty($data[\'add-group-name\'])
    && !empty( $data[\'add-group-code\'])
    && !empty( $data[\'add-group-text\'])
    && !empty( $data[\'groupsActions\'][\'add-group-action-user\'])
){
    
    $res = accessUserGroup::addUserGroup(
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
if(!empty($data[\'delete\'])){
    foreach ($data[\'delete\'] as $codeDeleteGroup => $val) {
        accessUserGroup::deleteUserGroupByCode($codeDeleteGroup);
    }
}

// взять все группы пользователей
$arRes[\'allUsersGroups\'] = accessUserGroup::getAccessGroup();

// взять все дефствия поьзователей 
$arRes[\'allActionUser\'] = accessUserGroup::getUserAction();

// коды групп пользователей которые даны по умолчанию (их нельзя будет удалять)
$standartGroup = array(
    \'admins\',
    \'content\',
    \'user_admin\'
);
foreach ($arRes[\'allUsersGroups\'] as $key => $value) {
    if(!in_array($value[\'code\'], $standartGroup)){
        $arRes[\'allUsersGroups\'][$key][\'flag_del\'] = \'Y\'; // флаг что можно удалить группу
    }
}

global $user;

// надо убрать админа из списка что бы права нельзя было менять никому
unset($data[\'groupsActions\'][\'admins\']);

if(!empty($data[\'button-form\'])
    && ($data[\'button-form\'] == \'Сохранить\')
    && $user->isAdmin() // TODO пока только админы могут это делать
    && !empty($data[\'groupsActions\'])
){ // нужно сохранить новые настроки прав
    foreach ($data[\'groupsActions\'] as $key => $listActionUser){
        // удалить все настройки для определённой группы
        accessUserGroup::deleteAllActionsForGroup($key);
        
        foreach ($listActionUser as $nameActionsUser) {
            accessUserGroup::addOptionsGroup($key, $nameActionsUser);
        }
    }
    $arRes[\'status\'] = \'ok\';
} elseif(!empty($data[\'button-form\']) ){
    $arRes[\'status\'] = \'add-err\';
}

// показать шаблон
$this->template->show($arRes, $this->arParam);
',
    'TYPE' => 'php',
    'DIR' => './gy/component/users_group_manager/',
  ),
  './gy/component/users_group_manager/teplates/0/lang_template.php' => 
  array (
    'CODE' => '<? // языковой файл для шаблона компонента
if ( !defined("GY_GLOBAL_FLAG_CORE_INCLUDE") && (GY_GLOBAL_FLAG_CORE_INCLUDE !== true) ) die( "gy: err include core" );

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

',
    'TYPE' => 'php',
    'DIR' => './gy/component/users_group_manager/teplates/0/',
  ),
  './gy/component/users_group_manager/teplates/0/template.php' => 
  array (
    'CODE' => '<?php 
if ( !defined("GY_GLOBAL_FLAG_CORE_INCLUDE") && (GY_GLOBAL_FLAG_CORE_INCLUDE !== true) ) die( "gy: err include core" );

if ( !empty($arRes["allUsersGroups"]) && !empty($arRes["allActionUser"]) ) {?>

    <?if(empty($arRes[\'status\'])){?>

        <h1><?=$this->lang->GetMessage(\'title\');?></h1>
        <form method="post">
            <table border="1" class="gy-table-all-users">
                <tr>
                    <th><?=$this->lang->GetMessage(\'groups\');?></th>
                    <th><?=$this->lang->GetMessage(\'text\');?></th>
                    <th><?=$this->lang->GetMessage(\'actions\');?></th>
                    <th></th>
                </tr>
                <? foreach ($arRes[\'allUsersGroups\'] as $val){?>
                    <tr>
                        
                        <td><?=$val[\'name\']?>(<?=$val[\'code\']?>)</td>
                        <td><?=$val[\'text\']?></td>
                        <td>
                            <select <?=(($val[\'code\'] == \'admins\')? \'disabled\': \'\');?> multiple="" name="groupsActions[<?=$val[\'code\']?>][]">
                                <? foreach ($arRes[\'allActionUser\'] as $userActions) {?>
                                    <option 
                                        value="<?=$userActions[\'code\']?>" 
                                        <?=((!empty($val[\'code_action_user\'][$userActions[\'code\']]))? \'selected\' : \'\')?> 
                                    >
                                        <?=$userActions[\'text\']?>(<?=$userActions[\'code\']?>)
                                    </option>
                                <?}?>
                            </select>
                        </td>
                        <td> 
                            <?if(!empty($val[\'flag_del\']) && ($val[\'flag_del\'] == \'Y\')){?> 
                                <input type="checkbox" name="delete[<?=$val[\'code\']?>]" /><?=$this->lang->GetMessage(\'delete\');?> 
                            <?}?>
                        </td>
                    </tr>
                <?}?>
                <tr>
                    <td colspan="4"><b><?=$this->lang->GetMessage(\'title-add-group\');?></b></td>
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
                            <? foreach ($arRes[\'allActionUser\'] as $userActions) {?>
                                <option value="<?=$userActions[\'code\']?>" >
                                    <?=$userActions[\'text\']?>(<?=$userActions[\'code\']?>)
                                </option>
                            <?}?>
                        </select>
                    </td>
                    <td></td>
                    
                </tr>
            </table> 

            <input type="submit" name="button-form" class="gy-admin-button" value="<?=$this->lang->GetMessage(\'save\');?>" />
        </form>    
        <br/>
        <a href="" class="gy-admin-button"><?=$this->lang->GetMessage(\'back\');?></a>
        <br/>
        <br/>
        <br/>
    <?}?>
   
    <?if(!empty($arRes[\'status\'])){?>    
        <?if ($arRes[\'status\'] == \'ok\'){?>
            <div class="gy-admin-good-message"><?=$this->lang->GetMessage(\'text-ok\');?></div>
            <br/>
            <a href="/gy/admin/group-user.php" class="gy-admin-button"><?=$this->lang->GetMessage(\'button-text-ok\');?></a>
        <? } ?>

        <?if ($arRes[\'status\'] == \'add-err\'){?>
            <div class="gy-admin-error-message"><?=$this->lang->GetMessage(\'text-err\');?></div>
            <br/>
            <a href="/gy/admin/group-user.php" class="gy-admin-button"><?=$this->lang->GetMessage(\'button-text-ok\');?></a>
        <? } ?>
    <?}?>

<?}',
    'TYPE' => 'php',
    'DIR' => './gy/component/users_group_manager/teplates/0/',
  ),
  './gy/config/gy_config.php' => 
  array (
    'CODE' => '<?
if (!defined("GY_GLOBAL_FLAG_CORE_INCLUDE") && GY_GLOBAL_FLAG_CORE_INCLUDE !== true ) die(\'err_core\');

$gy_config = array(
    \'lang\' => \'rus\', // eng
    \'sole\' => \'pass1021asz#_@)A\',
    \'db_config\' => array(
        \'db_type\' => \'mysql\',
        \'db_host\' => \'localhost\',
        \'db_user\' => \'root\', // заменить на настоящего пользователя // replace by true user 
        \'db_pass\' => \'12345678\', // заменить на настоящий пароль // replace by true password
        \'db_name\' => \'gy_db\',
    ),
    \'type_cache\' => \'cacheFiles\'
);',
    'TYPE' => 'php',
    'DIR' => './gy/config/',
  ),
  './gy/gy.php' => 
  array (
    'CODE' => '<?php
define("GY_GLOBAL_FLAG_CORE_INCLUDE", true); // флаг о том что ядро подключено // flag include core

include_once("config/gy_config.php"); // подключение настроек ядра // include options

// подключаем класс модуля 
// (нужен для подключения модулей до определения авто подключения классов)
include_once(__DIR__ . \'/classes/module.php\');

// подключить модули
//global $module;
$module = module::getInstance();
$module->setUrlGyCore(__DIR__);
//$module->includeModule(\'containerdata\');
$module->includeAllModules();

// авто подключение классов
function __autoload($calssname){ 
    
    // проверю есть ли класс в подключённых модулях и подключу, иначе как всегда всё
    global $module;
    $meyByClassModule = $module->getUrlModuleClassByNameClass($calssname);
    if($meyByClassModule !== false){
        require_once( $meyByClassModule );
    }else{
        if (file_exists(__DIR__ . \'/classes/\'.$calssname.\'.php\' )){
            require_once( "classes/$calssname.php" );          
        } elseif(file_exists(__DIR__ . \'/classes/abstract/\'.$calssname.\'.php\' )){
            // подключение abstract классов (что бы они хранились в отдельном разделе)
            require_once( "classes/abstract/$calssname.php" );   
        }else{
            die(\'class \'.$calssname.\' not find\' );
        }
    }
}

global $app;
$app = app::createApp(__DIR__, $gy_config);
unset($gy_config);

// подключить класс работы с базой данный // include class work database
if (isset($app->options[\'db_config\']) 
    && isset($app->options[\'db_config\'][\'db_type\']) 
    && isset($app->options[\'db_config\'][\'db_host\']) 
    && isset($app->options[\'db_config\'][\'db_user\']) 
    && isset($app->options[\'db_config\'][\'db_pass\']) 
    && isset($app->options[\'db_config\'][\'db_name\']) 
){
    global $db;
    $db = new $app->options[\'db_config\'][\'db_type\']($app->options[\'db_config\']); // mysql - for test work db mysql
}

global $crypto;	
$crypto = new crypto();
if (!empty($app->options[\'sole\'])){
	$crypto->setSole($app->options[\'sole\']);
}

global $user;
$user = new user();


// объявить имя класса для кеша // TODO пока так но сделать надо получше (заменить на фабрику или ещё какой патерн)
if (!isset($app->options[\'type_cache\'])) {  
    $app->options[\'type_cache\'] = \'cacheFiles\';
} 
global $cacheClassName;
$cacheClassName = $app->options[\'type_cache\'];

session_start();


/*
Примеры как можно прокидывать where условия в запросы 
 (возможно не рабочие но можно увидеть логику работы)

global $db;
$res = $db->selectDb(
    $db->db, 
    \'users\', 
    array(\'*\'), 
    array( \'AND\' => array(
        \'=\' => array(\'logIn\', "\'admin\'"), 
        //\'>\' => array(\'id\', 0),
        \'AND\' =>  array(\'=\' => array(\'logIn\', "\'admin2\'") //,
            //\'AND\' =>  array(\'=\' => array(\'logIn\', "\'admin2\'") )
            ),
        
        //\'<\' => array(\'asd\', 2),
        ) 
    )
);*/

/*
$res = $db->selectDb(
    $db->db, 
    \'users\', 
    array(\'*\'), 
    array( 
        \'=\' => array(\'id\', 1,), 
        
    )
);*/
',
    'TYPE' => 'php',
    'DIR' => './gy/',
  ),
  './gy/gy_functions.php' => 
  array (
    'CODE' => '<?php
if ( !defined("GY_GLOBAL_FLAG_CORE_INCLUDE") && (GY_GLOBAL_FLAG_CORE_INCLUDE !== true) ) die( "gy: err include core" );

function GetMessageCore($code_text) {
	$msg = "gy: err core function GetMessageCore";

	global $arLong;

	if (!empty($arLong)) {
		$msg = $arLong[$code_text];
	}
	return $msg;
} 
',
    'TYPE' => 'php',
    'DIR' => './gy/',
  ),
  './gy/index.php' => 
  array (
    'CODE' => '<?
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
$br = "\\n";

//print_r($argv);

function showHelpFromInstall(){
    global $br;
    echo $br."This script set options for gy framework".$br;
    echo "===================================".$br;
    echo ">php -f consoleInstallOptions.php <options>".$br;
    echo $br;
    echo "options:".$br;
    echo "    help  - show help this script".$br;
    echo "    set-all <array options> - set all options (clear options if not input)".$br;
    echo "    set-option <array options> - set options (save old options if not input)".$br;
    echo $br;
    echo "  example: php -f consoleInstallOptions.php set-all sole 111 db_type mysql".$br;
    echo "  example: php -f consoleInstallOptions.php set-option sole 111 db_type mysql".$br;
    echo "  example: php -f consoleInstallOptions.php help".$br;
    echo $br;
    echo $br;
    echo $br;
}


function parseOprions($optionsFromConsole){ // TODO надо распознавать параметры db и правильно записывать
    $arOptions = array();
    for($i = 2; $i < (count($optionsFromConsole)-1); $i = $i+2){
        if (empty($optionsFromConsole[$i+1])) {
            $optionsFromConsole[$i+1] = \'\';
        }          
        
        if (strripos($optionsFromConsole[$i], \'db\') !== false){
            $arOptions[\'db_config\'][$optionsFromConsole[$i]] = $optionsFromConsole[$i+1];
        
        } else{
            $arOptions[$optionsFromConsole[$i]] = $optionsFromConsole[$i+1];  
        }
    }
            
    return $arOptions;
}

function createTextForFileCofig($options){
    global $br;
    $fileText = \'\';
    
    if (!empty($options)){
        
        $fileText = \'
<?\'.$br.\'
if (!defined("GY_GLOBAL_FLAG_CORE_INCLUDE") && GY_GLOBAL_FLAG_CORE_INCLUDE !== true ) die("err_core");\'.$br.\'

$gy_config = array(\'.$br;
            
        foreach($options as $key => $val){

            if (!is_array($val)){
                $fileText .= \'    "\'.$key.\'" => "\'.$val.\'",\'.$br;
            }else{
                $fileText .= \'    "\'.$key.\'" => array(\'.$br;
                foreach($val as $key2 => $val2){
                    $fileText .= \'        "\'.$key2.\'" => "\'.$val2.\'",\'.$br;
                }
                $fileText .= \'    ),\'.$br;
            }

        }
        $fileText .= \');\'.$br;
    }        
    
    return $fileText;
}

if($isRunConsole){ // пока запускать только из консоли
	if ( empty($argv[1]) || ($argv[1] == \'help\') ){
        showHelpFromInstall();
	}elseif($argv[1] == \'set-all\'){
        echo \'run set-all\'.$br;

        $options = parseOprions($argv);
                
        if (!empty($options)){
            $file = fopen(__DIR__.\'/../config/gy_config.php\', \'w\');
            fwrite($file, createTextForFileCofig($options) );
            fclose($file);
        }
        echo \'finish set-all\'.$br;
     
	}elseif($argv[1] == \'set-option\'){
        echo \'run set-option\'.$br;
        $options = parseOprions($argv);
               
        include __DIR__."/../gy.php";
        $old_options = $app->options;
        
        print_r($old_options);
        
        foreach ($options as $key => $val){
            if (is_array($val)){
                //$tempArr = $old_options[$key];
                foreach($val as $key2 => $val2){
                    $old_options[$key][$key2] = $val2;
                }
            }else{
                $old_options[$key] = $val;
            }
        }
        
        if (!empty($old_options)){
            $file = fopen(__DIR__.\'/../config/gy_config.php\', \'w\');
            fwrite($file, createTextForFileCofig($old_options) );
            fclose($file);
        }  
        echo \'finish set-option\'.$br;

    }
	
}else{
	echo \'! нужно запустить скрипт в консоли\';

}
',
    'TYPE' => 'php',
    'DIR' => './gy/install/',
  ),
  './gy/install/installMysqlTable.php' => 
  array (
    'CODE' => '<? // TODO сделать нормально по шагам потом
global $argv;
$isRunConsole = isset($argv);
$br = "\\n";

if($isRunConsole){

    include __DIR__."/../gy.php"; // подключить ядро // include core

    echo $br.\'-----install gy core taldes db-----\';
    echo $br.\'install user table = start\';

    global $db;

    $res = $db->createTable(
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

    if ($res === true){
        echo $br.\'install user table = OK!\';

        echo $br.\'add admin user (and test user) = start\';

        $res = $db->insertDb(
            \'users\', 
            array(
                \'login\' => \'admin\', 
                \'name\' => \'admin\', 
                \'pass\' =>   \'admin\', 
                //\'groups\' => 1
            )
        );

        $res = $db->insertDb(
            \'users\', 
            array(
                \'login\' => \'asd\', 
                \'name\' => \'asd\', 
                \'pass\' =>  \'asdasd\', 
                //\'groups\' => 2
            )
        );

        if($res === true){
            echo $br.\'add admin user = OK!\';
        }else{
            echo $br.\'add admin user = ERROR!\';
        }
    }else{
        echo $br.\'install user table = ERROR!\';
    }

    // задать группы прав доступа и действия разрешаемые для пользователей групп
    echo $br.\'install access users = start\';
    
    // это действия пользователей к которые можно указать для группы пользователей
    //  суда нужно добавлять новые при появление нового в админке и прочего (модули если будут сделаны в этой версии)
    $res = $db->createTable(
        \'action_user\',
        array( 
            \'id int PRIMARY KEY AUTO_INCREMENT\', 
            \'code varchar(255)\', 
            \'text varchar(255)\', 
        )
    );        

    if ($res === true){
        
        $db->insertDb(
            \'action_user\', 
            array(
                \'code\' => \'show_admin_panel\', 
                \'text\' => \'Просматривать админку\', 
            )
        );
        
        $db->insertDb(
            \'action_user\', 
            array(
                \'code\' => \'action_all\', 
                \'text\' => \'Редактировать всё (Админ)\', 
            )
        );
        
        $db->insertDb(
            \'action_user\', 
            array(
                \'code\' => \'edit_users\', 
                \'text\' => \'Изменение пользователей (кроме админов)\', 
            )
        );  
    }
    
    echo $br.\'install access users = OK!\';
    
    
    echo $br.\'install user groups (add action user) = start\';
    // это группы (пользователей) прав доступа
    $res = $db->createTable(
        \'access_group\',
        array( 
            \'id int PRIMARY KEY AUTO_INCREMENT\', 
            \'code varchar(255)\', 
            \'name varchar(255)\', 
            \'text varchar(255)\', 
            \'code_action_user varchar(255)\' // код действия пользователя, разрешённый для данной группы
        )
    );        

    if ($res === true){
        
        $db->insertDb(
            \'access_group\', 
            array(
                \'code\' => \'admins\', 
                \'name\' => \'Админы\',
                \'text\' => \'Админы, есть права на всё\',
                \'code_action_user\' => \'action_all\'
            )
        );
        $db->insertDb(
            \'access_group\', 
            array(
                \'code\' => \'admins\', 
                \'name\' => \'Админы\',
                \'text\' => \'Админы, есть права на всё\',
                \'code_action_user\' => \'show_admin_panel\'
            )
        );
        
        
        $db->insertDb(
            \'access_group\', 
            array(
                \'code\' => \'content\', 
                \'name\' => \'Контент\',
                \'text\' => \'Те кто изменяют контент сайта\',
                \'code_action_user\' => \'show_admin_panel\'
            )
        );
        
        $db->insertDb(
            \'access_group\', 
            array(
                \'code\' => \'user_admin\', 
                \'name\' => \'Админи по пользователям\',
                \'text\' => \'Могут изменять только пользователей\', 
                \'code_action_user\' => \'edit_users\'
            )
        );
        $db->insertDb(
            \'access_group\', 
            array(
                \'code\' => \'user_admin\', 
                \'name\' => \'Админи по пользователям\',
                \'text\' => \'Могут изменять только пользователей\', 
                \'code_action_user\' => \'show_admin_panel\'
            )
        );
        
    }
    echo $br.\'install user groups = OK!\';
    
    echo $br.\'add users in user groups = start\';
    // в этой таблице будут группы и относящиеся к ним пользователи
    $res = $db->createTable(
        \'users_in_groups\',
        array( 
            \'id int PRIMARY KEY AUTO_INCREMENT\', 
            \'codeGroup varchar(255)\', 
            \'idUser int\', 
        )
    );
    
    if ($res === true){
        
        $db->insertDb(
            \'users_in_groups\', 
            array(
                \'codeGroup\' => \'admins\', 
                \'idUser\' => 1,
            )
        );
        
        $db->insertDb(
            \'users_in_groups\', 
            array(
                \'codeGroup\' => \'user_admin\', 
                \'idUser\' => 2,
            )
        );
    }    
    
    echo $br.\'add users in user groups = OK\';
    
    
    echo $br.\'install all modules db = start\';
    
    // теперь установка частей БД относящихся к модулям
    $module = module::getInstance();
    $module->installBdAllModules();
    
    echo $br.\'install all modules db = OK!\';
    
    
    echo $br.\'-----install gy core taldes db = OK!-----\'.$br;
    
}else{
	echo \'! нужно запустить скрипт в консоли\';

}',
    'TYPE' => 'php',
    'DIR' => './gy/install/',
  ),
  './gy/js/main.js' => 
  array (
    'CODE' => '$(function(){
    $(\'.del-user\').click(function(){
        
        var button = $(this);
        var id = $(this).data(\'id-user\')
        var action = \'user-del\';
        
        var url = \'/gy/admin/ajax.php?action=\'+action+\'&id-user=\'+id;
        
        if (typeof id != "undefined"){
            button.hide();
            $.ajax({
                url,
                success: function(res){
                    result = JSON.parse(res);
                    if (result[\'stat\'] == \'ok\'){
                        alert(\'! Пользователь удалён\');
                        window.location.replace(document.location.href);
                    } else {
                        button.show();
                    }
                }
            });
        }
    });
});
',
    'TYPE' => '.js',
    'DIR' => './gy/js/',
  ),
  './gy/lang/ru.php' => 
  array (
    'CODE' => '<?php // сообщения доя Русского языка 
if ( !defined("GY_GLOBAL_FLAG_CORE_INCLUDE") && (GY_GLOBAL_FLAG_CORE_INCLUDE !== true) ) die( "gy: err include core" );
$arLong = array(
	"err_include_core" => "Ядро gy не было подключено", //ошибки подключения ядра
);
',
    'TYPE' => 'php',
    'DIR' => './gy/lang/',
  ),
  './gy/modules/containerdata/admin/container-data-add.php' => 
  array (
    'CODE' => '<?
if ( !defined("GY_GLOBAL_FLAG_CORE_INCLUDE") && (GY_GLOBAL_FLAG_CORE_INCLUDE !== true) ) die( "gy: err include core" );

if (accessUserGroup::accessThisUserByAction( \'show_admin_panel\')){
	
	include "../../gy/admin/header-admin.php";

    if (accessUserGroup::accessThisUserByAction( \'edit_container_data\')){
        $app->component(
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
    'CODE' => '<?
if ( !defined("GY_GLOBAL_FLAG_CORE_INCLUDE") && (GY_GLOBAL_FLAG_CORE_INCLUDE !== true) ) die( "gy: err include core" );

if (accessUserGroup::accessThisUserByAction( \'show_admin_panel\')){
	
	include "../../gy/admin/header-admin.php";?>
    
    <?
    if (accessUserGroup::accessThisUserByAction( \'edit_container_data\') && is_numeric($_GET[\'ID\'])){
        $id = $_GET[\'ID\'];

        $app->component(
            \'containerdata_edit\',
            \'0\',
            array(
                \'ID\' => $id
            )
        );

    }else{
        echo \'error not id container-data\';
    }
	?>
    
	<?include "../../gy/admin/footer-admin.php";

} else {
	header( \'Location: /gy/admin/\' );
}',
    'TYPE' => 'php',
    'DIR' => './gy/modules/containerdata/admin/',
  ),
  './gy/modules/containerdata/admin/container-data-element-list.php' => 
  array (
    'CODE' => '<?
if ( !defined("GY_GLOBAL_FLAG_CORE_INCLUDE") && (GY_GLOBAL_FLAG_CORE_INCLUDE !== true) ) die( "gy: err include core" );

if (accessUserGroup::accessThisUserByAction( \'show_admin_panel\')){
	
	include "../../gy/admin/header-admin.php";?>
    
    <?
    if (accessUserGroup::accessThisUserByAction( \'edit_container_data\') && is_numeric($_GET[\'container-data-id\'])){
        $id = $_GET[\'container-data-id\'];

        $app->component(
            \'containerdata_element_list\',
            \'0\',
            array(
                \'container-data-id\' => $id
            )
        );

    }else{
        echo \'error not id container-data\';
    }
	?>
    
	<?include "../../gy/admin/footer-admin.php";

} else {
	header( \'Location: /gy/admin/\' );
}',
    'TYPE' => 'php',
    'DIR' => './gy/modules/containerdata/admin/',
  ),
  './gy/modules/containerdata/admin/container-data-element-property.php' => 
  array (
    'CODE' => '<?
if ( !defined("GY_GLOBAL_FLAG_CORE_INCLUDE") && (GY_GLOBAL_FLAG_CORE_INCLUDE !== true) ) die( "gy: err include core" );

if (accessUserGroup::accessThisUserByAction( \'show_admin_panel\')){
	
	include "../../gy/admin/header-admin.php";
    
    if(accessUserGroup::accessThisUserByAction( \'edit_container_data\')){
    
        $data = $_GET;

        if ( (!empty($data[\'container-data-id\']) && is_numeric($data[\'container-data-id\'])) && (!empty($data[\'el-id\']) && is_numeric($data[\'el-id\'])   ) ){

            $app->component(
                \'containerdata_element_property\',
                \'0\',
                array(
                    \'container-data-id\' => $data[\'container-data-id\'],
                    \'el-id\' => $data[\'el-id\']
                )
            );

        }else{
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
    'CODE' => '<?
if ( !defined("GY_GLOBAL_FLAG_CORE_INCLUDE") && (GY_GLOBAL_FLAG_CORE_INCLUDE !== true) ) die( "gy: err include core" );

if (accessUserGroup::accessThisUserByAction( \'show_admin_panel\')){
	
	include "../../gy/admin/header-admin.php";
    
    if (accessUserGroup::accessThisUserByAction( \'edit_container_data\') && is_numeric($_GET[\'container-data-id\'])){
        $id = $_GET[\'container-data-id\'];

        $app->component(
            \'containerdata_property_edit\',
            \'0\',
            array(
                \'container-data-id\' => $id
            )
        );

    }else{
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
    'CODE' => '<?
if ( !defined("GY_GLOBAL_FLAG_CORE_INCLUDE") && (GY_GLOBAL_FLAG_CORE_INCLUDE !== true) ) die( "gy: err include core" );

if (accessUserGroup::accessThisUserByAction( \'show_admin_panel\')){
	
	include "../../gy/admin/header-admin.php";
    
    if(accessUserGroup::accessThisUserByAction( \'edit_container_data\')){

        $app->component(
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
  './gy/modules/containerdata/classes/containerData.php' => 
  array (
    'CODE' => '<?
if ( !defined("GY_GLOBAL_FLAG_CORE_INCLUDE") && (GY_GLOBAL_FLAG_CORE_INCLUDE !== true) ) die( "gy: err include core" );

class containerData{            
    public static $table_container_data = \'container_data\';
    public static $table_list_propertys_container_data = \'list_propertys_container_data\';
    public static $table_types_property_container_data = \'types_property_container_data\'; 
    public static $table_element_container_data = \'element_container_data\';
    public static $table_value_propertys_type_html = \'value_propertys_type_html\';
    public static $table_value_propertys_type_number = \'value_propertys_type_number\';
    
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
    public static function getContainerData($arFilter, $arProperty){
        $result = array();
        global $db;
        $res = $db->selectDb(
            self::$table_container_data,
            $arProperty,
            $arFilter
        );
                      
        $result = $db->fetchAll($res, false);
        
        return $result;
    }
    
    /**
     * addContainerData - добавить ContainerData
     * @return boolean
     */
    public static function addContainerData($arParams){
        $result = false;

		// id, login, name, pass, groups
		global $db;		
        $res = $db->insertDb(self::$table_container_data, $arParams);
        
        if ($res){
			$result = true;
		}
			
		return $result;
    }
    
    /**
     * deleteContainerData - удалить ContainerData
     * @global type $db
     * @param type $arParams
     * @return boolean
     */
    public static function deleteContainerData($id){
        $result = false;

		// id, login, name, pass, groups
		global $db;		
        $res = $db->deleteDb(self::$table_container_data, array(\'=\' => array(\'id\', $id)));
        
        if ($res){
            
            //нужно удалить все элементы связанные с ним свойства и значения свойств
            
            $db->deleteDb( // удалить значения свойств свойств html
                self::$table_value_propertys_type_html, 
                array(\'=\' => array(\'id_container_data\', $id) )  
            );
            $db->deleteDb( // удалить значения свойств свойств number
                self::$table_value_propertys_type_number, 
                array(\'=\' => array(\'id_container_data\', $id) )  
            );
            
            
            $db->deleteDb( // удалить элементы container-data
                self::$table_element_container_data, 
                array(\'=\' => array(\'id_container_data\', $id) )  
            );       
              
            $db->deleteDb( // удалить свойства container-data
                self::$table_list_propertys_container_data, 
                array(\'=\' => array(\'id_container_data\', $id) )  
            );
            
			$result = true;
		}
			
		return $result; 
    }
    
    /**
     * deleteContainerData - удалить ContainerData
     * @global type $db
     * @param type $arParams
     * @return boolean
     */
    public static function updateContainerData($arParams, $where){
        $result = false;

		global $db;		
        $res = $db->updateDb(self::$table_container_data, $arParams, $where);
        
        if ($res){
			$result = true;
		}
			
		return $result; 
    }
    
    /**
     * getAllTypePropertysContainerData - получить все типы свойств ContainerData 
     * @return array
     */
    public static function getAllTypePropertysContainerData(){
       
        $result = array();
        global $db;
        $res = $db->selectDb(
            self::$table_types_property_container_data,
            array(\'*\'),
            array()
        );
              
        $result = $db->fetchAll($res);
        
        return $result;
    }
       
    /**
     * getAllPropertysContainerData - получить свойства ContainerData (! не значения)
     * @return array
     */
    public static function getPropertysContainerData($where){
        $result = array();
        global $db;
        $res = $db->selectDb(
            self::$table_list_propertys_container_data,
            array(\'*\'),
            $where
        );
        
        $result = $db->fetchAll($res);
        
        return $result;
    }
    
    /**
     * addPropertyContainerData - добавить свойство для ContainerData
     * @param type $arParams
     * @return boolean
     */
    public static function addPropertyContainerData($arParams){
        $result = false;

		// id, login, name, pass, groups
		global $db;		
        $res = $db->insertDb(self::$table_list_propertys_container_data, $arParams);
        
        if ($res){
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
    public static function getValuePropertysContainerData($idContainerData, $idElementContainerData, $idProperty,  $tableName){
        $result = array();
        global $db;
        $res = $db->selectDb(
            $tableName,
            array(\'*\'),
            array(
                \'AND\' => array(
                    \'=\' => array(
                        \'id_container_data\', 
                        $idContainerData
                    ),
                    \'AND\' => array( 
                        \'AND\' => array(
                            \'=\' => array( 
                                \'id_element_container_data\',
                                $idElementContainerData
                            ), 
                            \'AND\' => array(
                                \'=\' => array(
                                    \'id_property_container_data\', 
                                    $idProperty
                                ) 
                            )    
                        )
                    )
                )    
            )
        );
                      
        if ($arRes = $db->fetch($res)){
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
    public static function addValuePropertyContainerData($idContainerData, $idElementContainerData, $idProperty,  $tableName, $value){
        $result = false;
        global $db;		
        $res = $db->insertDb(
            $tableName, 
            array(
                \'id_container_data\' => $idContainerData,
                \'id_element_container_data\' => $idElementContainerData,
                \'id_property_container_data\' => $idProperty,
                \'value\' => $value
            )
        );
        if($res){
            $result = true;
        }
        return $result;
    }
    
    /**
     * UpdateValuePropertyContainerData - обновить значение свойства элемента container-data
     * @global type $db
     * @param type $tableName
     * @param type $id
     * @param type $value
     * @return boolean
     */
    public static function UpdateValuePropertyContainerData($tableName, $id, $value){
        $result = false;
        global $db;
        
        $res = $db->updateDb(
            $tableName, 
            array(\'value\' => $value), 
            array(
                \'=\' => array(\'id\', $id)
            )
        );
        
        if($res){
            $result = true;
        }
        return $result;
    }  
    
    /**
     * getAllElementContainerData - получить все элементы ContainerData
     * @param int $idContainerData
     * @return array
     */
    public static function getAllElementContainerData($idContainerData){
                      
        $result = array();
        global $db;
        $res = $db->selectDb(
            self::$table_element_container_data,
            array(\'*\'),
            array(
                \'=\' => array(\'id_container_data\', $idContainerData )
            )
        );
                     
        $result = $db->fetchAll($res, false);
        
        return $result;
    }
    
    /**
     * getElementContainerData - получить элемент ContainerData
     * @param int $idContainerData
     * @return array
     */
    public static function getElementContainerData($where){
                      
        $result = array();
        global $db;
        $res = $db->selectDb(
            self::$table_element_container_data,
            array(\'*\'),
            $where
        );
                     
        $result = $db->fetch($res, false);
        
        return $result;
    }
    
    
    /**
     * addElementContainerData - добавить элемент ContainerData
     * @param type $arParams
     * @return boolean
     */
    public static function addElementContainerData($arParams){
        $result = false;

		// id, login, name, pass, groups
		global $db;		
        $res = $db->insertDb(self::$table_element_container_data, $arParams);
        
        if ($res){
			$result = true;
		}
			
		return $result;
    }
    
    /**
     * deleteElementContainerData - удалить элемент ContainerData
     * @param type $arParams
     * @return boolean
     */
    public static function deleteElementContainerData($id){
        $result = false;

		global $db;		
        $res = $db->deleteDb(self::$table_element_container_data, array(\'=\' => array(\'id\', $id)));
        
        if ($res){
            // надо удалить все свойства этого элемента
            $db->deleteDb( // удалить всё для свойств html
                self::$table_value_propertys_type_html, 
                array(\'=\' => array(\'id_element_container_data\', $id) )  
            );
            $db->deleteDb( // удалить всё для свойств number
                self::$table_value_propertys_type_number, 
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
    public static function updateElementContainerData($arParams, $where){
        $result = false;

		// id, login, name, pass, groups
		global $db;		
        $res = $db->updateDb(self::$table_element_container_data, $arParams, $where);
        
        if ($res){
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
    public static function deletePropertyContainerData($idProperty, $containerData){
        //---надо взять все имеющиеся для этого свойства значения у элементов и удалить тоже
        global $db;	
        
        // взять все типы контент блоков что бы знать в каких таблицах искать значения
        $dataTypeProperty = containerData::getAllTypePropertysContainerData();
        
        // найти все свойства container-data      
        $propertyContainerData = containerData::getPropertysContainerData(
            array(
                \'=\'=>array(
                    \'id_container_data\', 
                    $containerData
                ) 
            ) 
        );
        
        $tableName = $dataTypeProperty[$propertyContainerData[$idProperty][\'id_type_property\']][\'name_table\'];
        
        // удалить для всех элементов значения свойства           
        $db->deleteDb($tableName, array(\'=\' => array(\'id_property_container_data\', $idProperty) )  );
        
        // удалить само свойство container-data
        $db->deleteDb(static::$table_list_propertys_container_data, array(\'=\' => array(\'id\', $idProperty) )  );

        ////---
        return true; // TODO доделать что бы был ещё false
    }
       
    
}
',
    'TYPE' => 'php',
    'DIR' => './gy/modules/containerdata/classes/',
  ),
  './gy/modules/containerdata/component/containerdata/controller.php' => 
  array (
    'CODE' => '<?php 
if ( !defined("GY_GLOBAL_FLAG_CORE_INCLUDE") && (GY_GLOBAL_FLAG_CORE_INCLUDE !== true) ) die( "gy: err include core" );

$data = $_POST;

if( !empty($data[\'ID\']) && is_numeric($data[\'ID\']) ){
    $res = containerData::deleteContainerData($data[\'ID\']);
    
    if($res){
        $arRes[\'status\'] = \'del-ok\';
    }else{
        $arRes[\'status\'] = \'del-err\';
    }
}

global $user;
$arRes[\'ITEMS\'] = containerData::getContainerData(array(), array(\'*\') );

// показать шаблон
$this->template->show($arRes, $this->arParam);
',
    'TYPE' => 'php',
    'DIR' => './gy/modules/containerdata/component/containerdata/',
  ),
  './gy/modules/containerdata/component/containerdata/teplates/0/lang_template.php' => 
  array (
    'CODE' => '<? // языковой файл для шаблона компонента
if ( !defined("GY_GLOBAL_FLAG_CORE_INCLUDE") && (GY_GLOBAL_FLAG_CORE_INCLUDE !== true) ) die( "gy: err include core" );

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

',
    'TYPE' => 'php',
    'DIR' => './gy/modules/containerdata/component/containerdata/teplates/0/',
  ),
  './gy/modules/containerdata/component/containerdata/teplates/0/template.php' => 
  array (
    'CODE' => '<?
if ( !defined("GY_GLOBAL_FLAG_CORE_INCLUDE") && (GY_GLOBAL_FLAG_CORE_INCLUDE !== true) ) die( "gy: err include core" );?>

<h1><?=$this->lang->GetMessage(\'title-container-data\');?></h1>

<?if (!empty($arRes[\'status\']) ){?>
    <?if ( $arRes[\'status\'] == \'del-ok\'){ ?>
        <div class="gy-admin-good-message"><?=$this->lang->GetMessage(\'del-ok\');?></div>
        <br/>
    <?}?>

    <?if ($arRes[\'status\'] == \'del-err\'){?>
        <div class="gy-admin-error-message"><?=$this->lang->GetMessage(\'del-err\');?></div>
        <br/>
    <?}?>
    <a href="<?=$_SERVER[\'REQUEST_URI\']?>" class="gy-admin-button"><?=$this->lang->GetMessage(\'ok\');?></a>
<?}else{?>
        
    <?if ($arRes[\'ITEMS\']){?>
        <table border="1" class="gy-table-all-users">
            <tr><th>id</th><th>name</th><th>code</th><th></th><th></th><th></th></tr>
            <? foreach ($arRes[\'ITEMS\'] as $key => $val){?>
                <tr>
                    <td><?=$val[\'id\']?></td>
                    <td><?=$val[\'name\']?></td>
                    <td><?=$val[\'code\']?></td>
                    <td>
                        <form method="post">
                            <input type="hidden" name="ID" value="<?=$val[\'id\']?>" />
                            <input type="submit" class="gy-admin-button" name="<?=$this->lang->GetMessage(\'del\');?>" value="<?=$this->lang->GetMessage(\'del\');?>" />
                        </form>
                    </td>
                    <td><a href="/gy/admin/get-admin-page.php?page=container-data-edit&ID=<?=$val[\'id\']?>" class="gy-admin-button"><?=$this->lang->GetMessage(\'edit\');?></a></td>
                    <td><a href="/gy/admin/get-admin-page.php?page=container-data-element-list&container-data-id=<?=$val[\'id\'];?>" class="gy-admin-button"><?=$this->lang->GetMessage(\'show-element\');?></a></td>
                </tr>
            <?}?>
        </table>

    <?}else{?>
        <?=$this->lang->GetMessage(\'not-element\');?>
        <br/>
        <br/>
        <br/>
    <?}?>
    <br/>
    <br/>
    <a href="/gy/admin/get-admin-page.php?page=container-data-add" class="gy-admin-button"><?=$this->lang->GetMessage(\'add\');?></a>
<?}',
    'TYPE' => 'php',
    'DIR' => './gy/modules/containerdata/component/containerdata/teplates/0/',
  ),
  './gy/modules/containerdata/component/containerdata_add/controller.php' => 
  array (
    'CODE' => '<?php 
if ( !defined("GY_GLOBAL_FLAG_CORE_INCLUDE") && (GY_GLOBAL_FLAG_CORE_INCLUDE !== true) ) die( "gy: err include core" );

//global $user;
//$arRes[\'ITEMS\'] = containerData::getContainerData(array(), array(\'*\') );

// найти текущие значения

$arRes = array();

$arRes[\'property\'] = array(
    \'name\',
    \'code\'
);

$data = $_POST;

if(!empty($data)){
    $saveData = array(); 
    foreach ($arRes[\'property\'] as $val){
        $saveData[$val] = $data[$val]; 
    }

    $res = containerData::addContainerData($saveData);

    if ($res){
        $arRes[\'status\'] = \'add-ok\';
    }else{
        $arRes[\'status\'] = \'add-err\';
    }
}else{
    $arRes[\'status\'] = \'add\';
}

// показать шаблон
$this->template->show($arRes, $this->arParam);
',
    'TYPE' => 'php',
    'DIR' => './gy/modules/containerdata/component/containerdata_add/',
  ),
  './gy/modules/containerdata/component/containerdata_add/teplates/0/lang_template.php' => 
  array (
    'CODE' => '<? // языковой файл для шаблона компонента
if ( !defined("GY_GLOBAL_FLAG_CORE_INCLUDE") && (GY_GLOBAL_FLAG_CORE_INCLUDE !== true) ) die( "gy: err include core" );

$mess[\'rus\'] = array(
	\'save\' => \'Создать\',
    \'back\' => \'Отменить\',
    \'title\' => \'Создание контейнера данных\',
    \'add-err\' => \'Ошибка! попробуйте ещё раз\', 
    \'add-ok\' => \'Контейнер данных успешно создан!\',
    \'ok\' => \'ОК\'
);

',
    'TYPE' => 'php',
    'DIR' => './gy/modules/containerdata/component/containerdata_add/teplates/0/',
  ),
  './gy/modules/containerdata/component/containerdata_add/teplates/0/template.php' => 
  array (
    'CODE' => '<?
if ( !defined("GY_GLOBAL_FLAG_CORE_INCLUDE") && (GY_GLOBAL_FLAG_CORE_INCLUDE !== true) ) die( "gy: err include core" );

if ($arRes[\'status\'] == \'add\'){ ?>
    <h1><?=$this->lang->GetMessage(\'title\');?></h1>
    <form method="post">
        <table border="1" class="gy-table-all-users">
            <? foreach ($arRes[\'property\'] as $val){?>
                <tr>
                    <td><?=$val?></td>
                    <td><input type="text" name="<?=$val?>" value="" /></td>
                </tr>
            <?}?>
        </table>     
        <input type="submit" class="gy-admin-button" value="<?=$this->lang->GetMessage(\'save\');?>" />
    </form>    
    <br/>
    <a href="" class="gy-admin-button"><?=$this->lang->GetMessage(\'back\');?></a>
<?}?>    
    
<?if ($arRes[\'status\'] == \'add-ok\'){?>
    <div class="gy-admin-good-message"><?=$this->lang->GetMessage(\'add-ok\');?></div>
    <br/>
    <a href="/gy/admin/get-admin-page.php?page=container-data" class="gy-admin-button"><?=$this->lang->GetMessage(\'ok\');?></a>
<? } ?>
    
<?if ($arRes[\'status\'] == \'add-err\'){?>
    <div class="gy-admin-error-message"><?=$this->lang->GetMessage(\'add-err\');?></div>
    <br/>
    <a href="/gy/admin/get-admin-page.php?page=container-data" class="gy-admin-button"><?=$this->lang->GetMessage(\'ok\');?></a>
<? } ',
    'TYPE' => 'php',
    'DIR' => './gy/modules/containerdata/component/containerdata_add/teplates/0/',
  ),
  './gy/modules/containerdata/component/containerdata_edit/controller.php' => 
  array (
    'CODE' => '<?php 
if ( !defined("GY_GLOBAL_FLAG_CORE_INCLUDE") && (GY_GLOBAL_FLAG_CORE_INCLUDE !== true) ) die( "gy: err include core" );

//global $user;
//$arRes[\'ITEMS\'] = containerData::getContainerData(array(), array(\'*\') );

// найти текущие значения

$arRes = array();

$arRes[\'property\'] = array(
    \'name\',
    \'code\'
);

$data = $_POST;

if (!empty($data[\'ID\'])){
    
    $saveData = array(); 
    foreach ($arRes[\'property\'] as $val){
        $saveData[$val] = $data[$val]; 
    }
        
    $res = containerData::updateContainerData($saveData, array(\'=\' => array(\'id\', $data[\'ID\'])));
    
    if ($res){
        $arRes[\'status\'] = \'add-ok\';
    }else{
        $arRes[\'status\'] = \'add-err\';
    }
    
} else {
    if(!empty($this->arParam[\'ID\'])){
        $arRes[\'data-this-nfo-box\'] = containerData::getContainerData(array( \'=\' =>array( \'id\', $this->arParam[\'ID\'])), array(\'*\') );
    }
}

// показать шаблон
$this->template->show($arRes, $this->arParam);
',
    'TYPE' => 'php',
    'DIR' => './gy/modules/containerdata/component/containerdata_edit/',
  ),
  './gy/modules/containerdata/component/containerdata_edit/teplates/0/lang_template.php' => 
  array (
    'CODE' => '<? // языковой файл для шаблона компонента
if ( !defined("GY_GLOBAL_FLAG_CORE_INCLUDE") && (GY_GLOBAL_FLAG_CORE_INCLUDE !== true) ) die( "gy: err include core" );

$mess[\'rus\'] = array(
	\'save\' => \'Сохранить\',
    \'back\' => \'Отменить\',
    \'title\' => \'Редактирование контейнера данных\',
    \'add-err\' => \'Ошибка! попробуйте ещё раз\', 
    \'add-ok\' => \'Контейнер данных успешно изменён!\',
    \'ok\' => \'ОК\',
    \'edit-property\' => \'Редактировать свойства этого контейнера данных\'
);

',
    'TYPE' => 'php',
    'DIR' => './gy/modules/containerdata/component/containerdata_edit/teplates/0/',
  ),
  './gy/modules/containerdata/component/containerdata_edit/teplates/0/template.php' => 
  array (
    'CODE' => '<?
if ( !defined("GY_GLOBAL_FLAG_CORE_INCLUDE") && (GY_GLOBAL_FLAG_CORE_INCLUDE !== true) ) die( "gy: err include core" );

if (!empty($arRes[\'data-this-nfo-box\'][0])){
    ?>
    <h1><?=$this->lang->GetMessage(\'title\');?></h1>
    <form method="post">
        <input name="ID" type="hidden" value="<?=$arRes[\'data-this-nfo-box\'][0][\'id\']?>" />
        <table border="1" class="gy-table-all-users">
            <? foreach ($arRes[\'property\'] as $val){?>
                <tr>
                    <td><?=$val?></td>
                    <td><input type="text" name="<?=$val?>" value="<?=$arRes[\'data-this-nfo-box\'][0][$val]?>" /></td>
                </tr>
            <?}?>
        </table> 
        
        <input type="submit" class="gy-admin-button" value="<?=$this->lang->GetMessage(\'save\');?>" />
    </form>    
    <br/>
    <a href="" class="gy-admin-button"><?=$this->lang->GetMessage(\'back\');?></a>
    <br/>
    <br/>
    <br/>
    <a href="/gy/admin/get-admin-page.php?page=container-data-property-edit&container-data-id=<?=$arRes[\'data-this-nfo-box\'][0][\'id\']?>" class="gy-admin-button"><?=$this->lang->GetMessage(\'edit-property\');?></a>
<?}?>    
   
<?if(!empty($arRes[\'status\'])){?>    
    <?if ($arRes[\'status\'] == \'add-ok\'){?>
        <div class="gy-admin-good-message"><?=$this->lang->GetMessage(\'add-ok\');?></div>
        <br/>
        <a href="/gy/admin/get-admin-page.php?page=container-data" class="gy-admin-button"><?=$this->lang->GetMessage(\'ok\');?></a>
    <? } ?>

    <?if ($arRes[\'status\'] == \'add-err\'){?>
        <div class="gy-admin-error-message"><?=$this->lang->GetMessage(\'add-err\');?></div>
        <br/>
        <a href="/gy/admin/get-admin-page.php?page=container-data" class="gy-admin-button"><?=$this->lang->GetMessage(\'ok\');?></a>
    <? } ?>
<?}',
    'TYPE' => 'php',
    'DIR' => './gy/modules/containerdata/component/containerdata_edit/teplates/0/',
  ),
  './gy/modules/containerdata/component/containerdata_element_list/controller.php' => 
  array (
    'CODE' => '<?php 
if ( !defined("GY_GLOBAL_FLAG_CORE_INCLUDE") && (GY_GLOBAL_FLAG_CORE_INCLUDE !== true) ) die( "gy: err include core" );

$arRes = array();

$data = $_REQUEST;

if (!empty($data[\'id_container_data\']) && !empty($data[\'name\']) && !empty($data[\'code\']) ){
    
    if(empty($data[\'el-id\'])){ // добавить новый элемент container-data
        $res = containerData::addElementContainerData(
            array(
                \'section_id\' => $data[\'section_id\'],
                \'name\' => $data[\'name\'],
                \'code\' => $data[\'code\'],
                \'id_container_data\' => $data[\'id_container_data\']
            )
        );
        if($res){ 
            $arRes[\'stat\'] = \'ok\';
        }else{
            $arRes[\'stat\'] = \'err\';
        }
        
    }elseif(!empty($data[\'el_edit_id\']) && is_numeric($data[\'el_edit_id\'])){ // изменить элемент container-data
        
        
        $res = containerData::updateElementContainerData(
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
        
        if($res){ 
            $arRes[\'stat-edit\'] = \'ok\';
        }else{
            $arRes[\'stat-edit\'] = \'err\';
        }
    }else{
        $arRes[\'stat\'] = \'err\';
    }  
    
}

if( !empty($data[\'del-el\']) && !empty($data[\'id\']) ){
    $res = containerData::deleteElementContainerData( $data[\'id\']);
    if($res){ 
        $arRes[\'stat-del\'] = \'ok\';
    }else{
        $arRes[\'stat-del\'] = \'err\';
    }
}

if (!empty($this->arParam[\'container-data-id\']) && is_numeric($this->arParam[\'container-data-id\'])){
    $arRes[\'ITEMS\'] = containerData::getAllElementContainerData($this->arParam[\'container-data-id\']);
      
    if(!empty($data[\'el-id\']) && is_numeric($data[\'el-id\']) && empty($arRes[\'stat-edit\']) ){
        
        foreach ($arRes[\'ITEMS\'] as $val){
            if($val[\'id\'] == $data[\'el-id\']){
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
  './gy/modules/containerdata/component/containerdata_element_list/teplates/0/lang_template.php' => 
  array (
    'CODE' => '<? // языковой файл для шаблона компонента
if ( !defined("GY_GLOBAL_FLAG_CORE_INCLUDE") && (GY_GLOBAL_FLAG_CORE_INCLUDE !== true) ) die( "gy: err include core" );

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

',
    'TYPE' => 'php',
    'DIR' => './gy/modules/containerdata/component/containerdata_element_list/teplates/0/',
  ),
  './gy/modules/containerdata/component/containerdata_element_list/teplates/0/template.php' => 
  array (
    'CODE' => '<?if ( !defined("GY_GLOBAL_FLAG_CORE_INCLUDE") && (GY_GLOBAL_FLAG_CORE_INCLUDE !== true) ) die( "gy: err include core" );?>

<h4><?=$this->lang->GetMessage(\'title\');?></H4>

<?
$isEdit = (!empty($arRes[\'stat-del\']) && ($arRes[\'stat-del\'] == \'edit\'));

if( (empty($arRes[\'stat\']) && empty($arRes[\'stat-edit\']) && empty($arRes[\'stat-del\'])) || $isEdit ){?>
    
    <?
    if(!empty($arRes[\'ITEMS\'])){ ?>
        <table border="1" class="gy-table-all-users">
            <tr><th>code</th><th>name</th><th>section id</th><th></th><th></th><th></th></tr>

            <?foreach ($arRes[\'ITEMS\'] as $val){?>
                <tr>
                    <td><?=$val[\'code\']?></td>
                    <td><?=$val[\'name\']?></td>
                    <td><?=$val[\'section_id\']?></td>
                    <td><a href="?page=container-data-element-list&container-data-id=<?=$arParam[\'container-data-id\']?>&el-id=<?=$val[\'id\'];?>" class="gy-admin-button"><?=$this->lang->GetMessage(\'el-edit\');?></a></td>
                    <td><a href="/gy/admin/get-admin-page.php?page=container-data-element-property&container-data-id=<?=$arParam[\'container-data-id\']?>&el-id=<?=$val[\'id\'];?>" class="gy-admin-button"><?=$this->lang->GetMessage(\'el-view-property\');?></a></td>
                    <td>
                        <form method="post">
                            <input type="hidden" name="id" value="<?=$val[\'id\']?>" />
                            <input type="submit" class="gy-admin-button" name="del-el" value="<?=$this->lang->GetMessage(\'el-del\');?>" />
                        </form>
                    </td>
                </tr>
            <?}?>
        </table> 
    <?}else{?>
        <?=$this->lang->GetMessage(\'ITEMS-NULL\');?>
    <?}?>

    <h4><?=$this->lang->GetMessage(\'title-add-element\');?></H4>
    
    <form method="post">
        <input name="id_container_data" type="hidden" value="<?=$arParam[\'container-data-id\']?>" />
        <input name="section_id" type="hidden" value="0" /> <?// TODO пока так (всегда один раздел н можно доработать)?>

        <?if($isEdit ){?>
            <input name="el_edit_id" type="hidden" value="<?=$arRes[\'edit-id\']?>" />
        <?}?>

        <table border="1" class="gy-table-all-users">

            <tr><td>code</td><td><input type="text" name="code" value="<?=(($isEdit)? $arRes[\'edit-el-data\'][\'code\'] : \'\' )?>" /></td></tr>

            <tr><td>name</td><td><input type="text" name="name" value="<?=(($isEdit)? $arRes[\'edit-el-data\'][\'name\'] : \'\' )?>" /></td></tr>

            <tr>
                <td></td>
                <td>
                    <input type="submit" class="gy-admin-button" value="<?=(($isEdit)? $this->lang->GetMessage(\'save\'): $this->lang->GetMessage(\'add\'));?>" /> 
                    <a href="" class="gy-admin-button"><?=$this->lang->GetMessage(\'back\');?></a>
                </td>
            </tr>
        </table> 

    </form>
<?}else{?>
    <?if (!empty($arRes[\'stat-del\'])){ ?>
        <?if($arRes[\'stat-del\'] == \'ok\'){?>
            <div class="gy-admin-good-message"><?=$this->lang->GetMessage(\'del-ok\');?></div>
        <?}elseif($arRes[\'stat-del\'] == \'err\'){?>
            <div class="gy-admin-error-message"><?=$this->lang->GetMessage(\'add-err\');?></div>
        <?}?>
    <?}?>
    
    <?if (!empty($arRes[\'stat\'])){ ?>
        <?if($arRes[\'stat\'] == \'ok\'){?>
            <div class="gy-admin-good-message"><?=$this->lang->GetMessage(\'add-ok\');?></div>
        <?}elseif($arRes[\'stat\'] == \'err\'){?>
            <div class="gy-admin-error-message"><?=$this->lang->GetMessage(\'add-err\');?></div>
        <?}?>
    <?}?>

    <?if (!empty($arRes[\'stat-edit\'])){ ?>
        <?if($arRes[\'stat-edit\'] == \'ok\'){?>
            <div class="gy-admin-good-message"><?=$this->lang->GetMessage(\'edit-ok\');?></div>
        <?}elseif($arRes[\'stat-edit\'] == \'err\'){?>
            <div class="gy-admin-error-message"><?=$this->lang->GetMessage(\'add-err\');?></div>
        <?}?>
    <?}?>
    
    <a href="<?=$_SERVER[\'SCRIPT_NAME\']?>?page=container-data-element-list&container-data-id=<?=$arParam[\'container-data-id\']?>" class="gy-admin-button"><?=$this->lang->GetMessage(\'ok\');?></a>
<?}  
',
    'TYPE' => 'php',
    'DIR' => './gy/modules/containerdata/component/containerdata_element_list/teplates/0/',
  ),
  './gy/modules/containerdata/component/containerdata_element_property/controller.php' => 
  array (
    'CODE' => '<?php 
if ( !defined("GY_GLOBAL_FLAG_CORE_INCLUDE") && (GY_GLOBAL_FLAG_CORE_INCLUDE !== true) ) die( "gy: err include core" );

$arRes = array();

if(!empty($this->arParam[\'container-data-id\']) && !empty($this->arParam[\'el-id\'])  ){
    // получить свойства container-data
    $arRes[\'PROPERTY\'] = containerData::getPropertysContainerData( array(\'=\'=>array(\'id_container_data\', $this->arParam[\'container-data-id\'])) );
    
    // получить все типы свойств
    $arRes[\'PROPERTY_TYPE\'] = containerData::getAllTypePropertysContainerData();

    $data = $_REQUEST;

    // сохранение свойств
    if(!empty($data[\'propertyAdd\']) ){
        
        foreach($data[\'propertyAdd\'] as $key => $val){
            $res = containerData::addValuePropertyContainerData(
                $this->arParam[\'container-data-id\'], 
                $this->arParam[\'el-id\'], 
                $key,  
                $arRes[\'PROPERTY_TYPE\'][$arRes[\'PROPERTY\'][$key][\'id_type_property\']][\'name_table\'], 
                $val
            );
            if($res){
                $arRes[\'stat-save\'] = \'ok\';
            }
            
        }
    }
    
    $arRes[\'PROPERTY_VALUE\'] = array();
    
    // получить значения
    foreach($arRes[\'PROPERTY\'] as $key => $val){
        $propertyValue = containerData::getValuePropertysContainerData(
            $this->arParam[\'container-data-id\'], 
            $this->arParam[\'el-id\'],
            $val[\'id\'],
            $arRes[\'PROPERTY_TYPE\'][$val[\'id_type_property\']][\'name_table\']
        );
        
        if(!empty($propertyValue)){
            $arRes[\'PROPERTY_VALUE\'][$val[\'id\']] = $propertyValue;
        }
    }
    
    $arKeyValue = array();
    foreach ($arRes[\'PROPERTY_VALUE\'] as $key => $value) {

        $arKeyValue[$value[\'id\']] = $key;
    }
        
    // обновление
    // сохранение свойств
    if(!empty($data[\'propertyUpdate\']) ){
        
        foreach($data[\'propertyUpdate\'] as $key => $val){
            $res = containerData::UpdateValuePropertyContainerData(
                $arRes[\'PROPERTY_TYPE\'][$arRes[\'PROPERTY\'][$arKeyValue[$key]][\'id_type_property\']][\'name_table\'],  
                $key,  
                $val
            );
            if($res){
                $arRes[\'stat-save\'] = \'ok\';
            }
            
        }
    }
    
    // TODO заменить повторный код на редирект
    $arRes[\'PROPERTY_VALUE\'] = array();
    
    // получить значения
    foreach($arRes[\'PROPERTY\'] as $key => $val){
         $propertyValue = containerData::getValuePropertysContainerData(
            $this->arParam[\'container-data-id\'], 
            $this->arParam[\'el-id\'],
            $val[\'id\'],
            $arRes[\'PROPERTY_TYPE\'][$val[\'id_type_property\']][\'name_table\']
        );
        
        if(!empty($propertyValue)){
            $arRes[\'PROPERTY_VALUE\'][$val[\'id\']] = $propertyValue;
        }
    }
    
}

// показать шаблон
$this->template->show($arRes, $this->arParam);
',
    'TYPE' => 'php',
    'DIR' => './gy/modules/containerdata/component/containerdata_element_property/',
  ),
  './gy/modules/containerdata/component/containerdata_element_property/teplates/0/lang_template.php' => 
  array (
    'CODE' => '<? // языковой файл для шаблона компонента
if ( !defined("GY_GLOBAL_FLAG_CORE_INCLUDE") && (GY_GLOBAL_FLAG_CORE_INCLUDE !== true) ) die( "gy: err include core" );

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

',
    'TYPE' => 'php',
    'DIR' => './gy/modules/containerdata/component/containerdata_element_property/teplates/0/',
  ),
  './gy/modules/containerdata/component/containerdata_element_property/teplates/0/template.php' => 
  array (
    'CODE' => '<?if ( !defined("GY_GLOBAL_FLAG_CORE_INCLUDE") && (GY_GLOBAL_FLAG_CORE_INCLUDE !== true) ) die( "gy: err include core" );?>

<h1><?=$this->lang->GetMessage(\'title\');?></h1>

<?
if(empty($arRes[\'stat-save\'] )){

    if(!empty($arRes[\'PROPERTY\'])){ ?>

        <form method="post">

            <table border="1" class="gy-table-all-users">
                <tr>
                    <th><?=$this->lang->GetMessage(\'name\');?></th>
                    <th><?=$this->lang->GetMessage(\'code\');?></th>
                    <th><?=$this->lang->GetMessage(\'type\');?></th>
                    <th><?=$this->lang->GetMessage(\'value\');?></th>
                </tr>
                <? foreach ($arRes[\'PROPERTY\'] as $val){?>
                    <tr>
                        <td><?=$val[\'name\']?></td>
                        <td><?=$val[\'code\']?></td>
                        <td><?=$arRes[\'PROPERTY_TYPE\'][$val[\'id_type_property\']][\'name\']?></td>
                        <td>
                            <?if($arRes[\'PROPERTY_TYPE\'][$val[\'id_type_property\']][\'name\'] != \'html\'){?>
                                <input 
                                    type="text" 
                                    <?if(!empty($arRes[\'PROPERTY_VALUE\'][$val[\'id\']])){?>
                                        name="propertyUpdate[<?=$arRes[\'PROPERTY_VALUE\'][$val[\'id\']][\'id\']?>]" 
                                    <?}else{?>
                                        name="propertyAdd[<?=$val[\'id\']?>]" 
                                    <?}?>    
                                    value="<?=((!empty($arRes[\'PROPERTY_VALUE\'][$val[\'id\']]))? $arRes[\'PROPERTY_VALUE\'][$val[\'id\']][\'value\'] : \'\')?>" 
                                />
                            <?}else{?>
                                <textarea 
                                    rows="5" cols="70"
                                    <?if(!empty($arRes[\'PROPERTY_VALUE\'][$val[\'id\']])){?>
                                        name="propertyUpdate[<?=$arRes[\'PROPERTY_VALUE\'][$val[\'id\']][\'id\']?>]" 
                                    <?}else{?>
                                        name="propertyAdd[<?=$val[\'id\']?>]" 
                                    <?}?>    
                                /><?=((!empty($arRes[\'PROPERTY_VALUE\'][$val[\'id\']]))? $arRes[\'PROPERTY_VALUE\'][$val[\'id\']][\'value\'] : \'\')?></textarea>
                            <?}?>
                        </td>
                    </tr>
                <?}?>
            </table> 

            <input type="submit" class="gy-admin-button" value="<?=$this->lang->GetMessage(\'save\');?>" />
        </form>    
        
        <br/>
        <a href="" class="gy-admin-button"><?=$this->lang->GetMessage(\'back\');?></a>
        <br/>
        <br/>
        <br/>

    <?}else{?>
        <?=$this->lang->GetMessage(\'PROPERTY_NULL\');?>
    <?}?>
<?}else{?>
    <?if( !empty($arRes[\'stat-save\'] ) && ($arRes[\'stat-save\'] == \'ok\')){?>
        <div class="gy-admin-good-message"><?=$this->lang->GetMessage(\'save-ok\');?></div>
    <?}?>
    <a href="<?=$_SERVER[\'REQUEST_URI\']?>" class="gy-admin-button"><?=$this->lang->GetMessage(\'ok\');?></a>
<?}
        ',
    'TYPE' => 'php',
    'DIR' => './gy/modules/containerdata/component/containerdata_element_property/teplates/0/',
  ),
  './gy/modules/containerdata/component/containerdata_element_show/controller.php' => 
  array (
    'CODE' => '<?php 
if ( !defined("GY_GLOBAL_FLAG_CORE_INCLUDE") && (GY_GLOBAL_FLAG_CORE_INCLUDE !== true) ) die( "gy: err include core" );

$arRes = array();

// TODO попробовать уменьшить количество запросов

/**
* container-data-code код container-data
* element-code - code элемента
*/
if(!empty($this->arParam[\'container-data-code\']) && !empty($this->arParam[\'element-code\'])){
    
    $isCache = (!empty($this->arParam[\'cacheTime\']) && is_numeric($this->arParam[\'cacheTime\']));
    
    if($isCache){
        global $app; 
        global $cacheClassName;
        $cache = new $cacheClassName($app->url);
        $initCache = $cache->cacheInit(\'component_container_data_element_show\', $this->arParam[\'cacheTime\']);
    }
    
    if($isCache && $initCache){
        $arRes = $cache->getCacheData();
    }
    
    if( !$isCache || ($isCache && !$initCache) ){
                
        // найти container-data
        $dataContainerData = containerData::getContainerData(
            array(
                \'=\' => array( \'code\', "\'".$this->arParam[\'container-data-code\']."\'") 
            ), 
            array(\'*\')
        );

        $dataContainerData = $dataContainerData[0]; 

        // взять типы свойств что бы знать названия таблиц где их искать
        $dataTypeProperty = containerData::getAllTypePropertysContainerData();

        // найти его свойства
        $propertyContainerData = containerData::getPropertysContainerData(
            array(
                \'=\'=>array(
                    \'id_container_data\', 
                    $dataContainerData[\'id\']
                ) 
            ) 
        );

        // найти элемент
        $dataElement = containerData::getElementContainerData(
            array(
                \'AND\' => array(
                    \'=\' => array(
                        \'id_container_data\', 
                        $dataContainerData[\'id\']
                    ),
                    \'AND\' => array(
                        \'=\' => array(
                            \'code\',
                            "\'".$this->arParam[\'element-code\']."\'"
                        )
                    )
                )
            )
        );

        // найти значения свойств элемента
        $arRes[\'ITEMS\'] = array();

        foreach ($propertyContainerData as $val) {
            $arRes[\'ITEMS\'][$val[\'id\']] = containerData::getValuePropertysContainerData(
                $dataContainerData[\'id\'], 
                $dataElement[\'id\'], 
                $val[\'id\'],  
                $dataTypeProperty[$val[\'id_type_property\']][\'name_table\']
            );
        }
        
        if($isCache){
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
  './gy/modules/containerdata/component/containerdata_element_show/teplates/0/template.php' => 
  array (
    'CODE' => '<?if ( !defined("GY_GLOBAL_FLAG_CORE_INCLUDE") && (GY_GLOBAL_FLAG_CORE_INCLUDE !== true) ) die( "gy: err include core" );

if(!empty($arRes[\'ITEMS\'])){
    foreach ($arRes[\'ITEMS\'] as $value) { 
        echo ((!empty($value[\'value\']))? $value[\'value\'] : \'\');
    } 
}',
    'TYPE' => 'php',
    'DIR' => './gy/modules/containerdata/component/containerdata_element_show/teplates/0/',
  ),
  './gy/modules/containerdata/component/containerdata_property_edit/controller.php' => 
  array (
    'CODE' => '<?php 
if ( !defined("GY_GLOBAL_FLAG_CORE_INCLUDE") && (GY_GLOBAL_FLAG_CORE_INCLUDE !== true) ) die( "gy: err include core" );

$arRes = array();

$data = $_POST;

// удаления свойства container-data
if(!empty($data[\'del-property-id\']) && !empty($data[\'del-proprty-container-data\']) ){
    containerData::deletePropertyContainerData( $data[\'del-property-id\'], $data[\'del-proprty-container-data\']);
    $arRes[\'status\'] = \'del-property-ok\';
}else{

    $arRes[\'TYPE_PROPERTYS\'] = containerData::getAllTypePropertysContainerData();

    if(!empty($data)){

        if( !empty($data[\'type_property\']) && ($data[\'type_property\'] != \'null\') && !empty($arRes[\'TYPE_PROPERTYS\'][$data[\'type_property\']]) ){
            if( !empty($data[\'name\']) && !empty($data[\'code\']) ){

                $res = containerData::addPropertyContainerData( 
                    array(
                        \'id_type_property\' => $data[\'type_property\'],
                        \'id_container_data\' => $this->arParam[\'container-data-id\'],
                        \'code\' => $data[\'code\'],
                        \'name\' => $data[\'name\']
                    )
                );

                if($res){
                    $arRes[\'status\'] = \'add-ok\';
                } else{
                    $arRes[\'status\'] = \'add-err\';
                }

            }else{
                $arRes[\'status\'] = \'add-err\';
            }
        }else{
            $arRes[\'status\'] = \'add-err-not-type\';
        }
    }

    // найти свойства текущего container-data
    if (!empty($this->arParam[\'container-data-id\']) && is_numeric($this->arParam[\'container-data-id\'])){
        $arRes[\'PROPERTYS\'] = containerData::getPropertysContainerData(array(\'=\'=>array(\'id_container_data\', $this->arParam[\'container-data-id\'])) );
    }
}
    
// показать шаблон
$this->template->show($arRes, $this->arParam);
',
    'TYPE' => 'php',
    'DIR' => './gy/modules/containerdata/component/containerdata_property_edit/',
  ),
  './gy/modules/containerdata/component/containerdata_property_edit/teplates/0/lang_template.php' => 
  array (
    'CODE' => '<? // языковой файл для шаблона компонента
if ( !defined("GY_GLOBAL_FLAG_CORE_INCLUDE") && (GY_GLOBAL_FLAG_CORE_INCLUDE !== true) ) die( "gy: err include core" );

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

',
    'TYPE' => 'php',
    'DIR' => './gy/modules/containerdata/component/containerdata_property_edit/teplates/0/',
  ),
  './gy/modules/containerdata/component/containerdata_property_edit/teplates/0/template.php' => 
  array (
    'CODE' => '<?
if ( !defined("GY_GLOBAL_FLAG_CORE_INCLUDE") && (GY_GLOBAL_FLAG_CORE_INCLUDE !== true) ) die( "gy: err include core" );

if(empty($arRes[\'status\'])){?>

    <?if (!empty($arRes[\'PROPERTYS\'])){?>
        <table border="1" class="gy-table-all-users">
            <tr><th>id</th><th>name</th><th>code</th><th>name type property</th><th></th></tr>
            <? foreach ($arRes[\'PROPERTYS\'] as $val){?>
                <tr>
                    <td><?=$val[\'id\'];?></td>
                    <td><?=$val[\'name\'];?></td>
                    <td><?=$val[\'code\'];?></td>
                    <td>type= <?=$arRes[\'TYPE_PROPERTYS\'][$val[\'id_type_property\']][\'id\']?> name= <?=$arRes[\'TYPE_PROPERTYS\'][$val[\'id_type_property\']][\'name\']?></td>
                    <td>
                        <form method="post">
                            <input type="hidden" name="del-property-id" value="<?=$val[\'id\'];?>" />
                            <input type="hidden" name="del-proprty-container-data" value="<?=$arParam[\'container-data-id\']?>" />
                            <input type="submit" class="gy-admin-button" value="<?=$this->lang->GetMessage(\'del-btn\')?>"  name="<?=$this->lang->GetMessage(\'del-btn\')?>" />
                        </form>
                    </td>
                </tr>
            <?}?>
        </table>
    <?}else{?>
        <?=$this->lang->GetMessage(\'not-property\');?>
        <br/>
    <?}?>

    <form method="post" >    
        <h4><?=$this->lang->GetMessage(\'title-add-property\');?></h4>
        <table border="1" class="gy-table-all-users">
            <tr>
                <td>
                    тип свойства
                </td>
                <td>
                    <select name="type_property">
                        <option  value="null"></option>
                        <? foreach ($arRes[\'TYPE_PROPERTYS\'] as $val){?>
                            <option  value="<?=$val[\'id\']?>"><?=$val[\'name\']?></option> 
                        <?}?>
                    </select>
                </td>
            </tr>
            <tr><td>name</td><td><input type="text" name="name" /></td></tr>
            <tr><td>code</td><td><input type="text" name="code" /></td></tr>    

        </table>
        <input type="submit" class="gy-admin-button" value="<?=$this->lang->GetMessage(\'add-property\');?>" />
    </form>

    
<?}else{?>    
    <?if ($arRes[\'status\'] == \'add-ok\'){?>
        <div class="gy-admin-good-message"><?=$this->lang->GetMessage(\'add-ok\');?></div>
        <br/>
    <? } ?>

    <?if ($arRes[\'status\'] == \'add-err\'){?>
        <div class="gy-admin-error-message"><?=$this->lang->GetMessage(\'add-err\');?></div>
        <br/>
    <? } ?>
    
    <?if ($arRes[\'status\'] == \'add-err-not-type\'){?>
        <div class="gy-admin-error-message"><?=$this->lang->GetMessage(\'add-err-not-type\');?></div>
        <br/>
    <? } ?>
    
    <?if ($arRes[\'status\'] == \'del-property-ok\'){?>
        <div class="gy-admin-good-message"><?=$this->lang->GetMessage(\'del-property-ok\');?></div>
        <br/>
    <? } ?>
    <a href="<?=$_SERVER[\'REQUEST_URI\']?>" class="gy-admin-button"><?=$this->lang->GetMessage(\'ok\');?></a>
<?}
  
    
',
    'TYPE' => 'php',
    'DIR' => './gy/modules/containerdata/component/containerdata_property_edit/teplates/0/',
  ),
  './gy/modules/containerdata/init.php' => 
  array (
    'CODE' => '<?
if ( !defined("GY_GLOBAL_FLAG_CORE_INCLUDE") && (GY_GLOBAL_FLAG_CORE_INCLUDE !== true) ) die( "gy: err include core" );

/** 
 * описываю что есть в модуле 
 * - это на совести разработчика модуля
 * перечисляются имеющиеся классы и модули, а они лежат в стандартных папках 
 * (заранее обговорено какие есть разделы в модуле)
 */

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
    \'containerData\'
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
    \'Контейнеры данных\' => \'/gy/admin/get-admin-page.php?page=container-data\'
);

// пользовательское действие, и если оно разрешено текущему пользователю то он увидит 
// в меню админки кнопки $pagesFromAdminMenu
$isShowButtonsMenuAdminPanetThisModule = \'edit_container_data\';

$nameThisModule = \'containerdata\';',
    'TYPE' => 'php',
    'DIR' => './gy/modules/containerdata/',
  ),
  './gy/modules/containerdata/install/installMysqlTable.php' => 
  array (
    'CODE' => '<? 
if ( !defined("GY_GLOBAL_FLAG_CORE_INCLUDE") && (GY_GLOBAL_FLAG_CORE_INCLUDE !== true) ) die( "gy: err include core" );

global $argv;
$isRunConsole = isset($argv);
$br = "\\n";

if($isRunConsole){

//    include __DIR__."/../gy.php"; // подключить ядро // include core

    global $db;

    //---containerData---
    echo $br.$br.\'--install table module - containerData = start--\';

    echo $br.\'install table module - containerData = start\';
    $res = $db->createTable( // containerData-ы
        \'container_data\',
        array( 
            \'id int PRIMARY KEY AUTO_INCREMENT\', 
            \'name varchar(50)\', 
            \'code varchar(50)\', 
        )
    );        

    $res = $db->createTable( // список свойств containerData
        \'list_propertys_container_data\',
        array( 
            \'id int PRIMARY KEY AUTO_INCREMENT\', 
            \'id_type_property int\', 
            \'id_container_data int\', 
            \'code varchar(50)\', 
            \'name varchar(50)\', 
        )
    );

    $res = $db->createTable( // типы свойств containerData
        \'types_property_container_data\',
        array( 
            \'id int PRIMARY KEY AUTO_INCREMENT\', 
            \'info varchar(50)\', 
            \'code varchar(50)\', 
            \'name varchar(50)\', 
            \'name_table varchar(50)\'
        )
    ); 

    $res = $db->insertDb(
        \'types_property_container_data\', 
        array(
            \'name\' => \'html\', 
            \'code\' => \'html\', 
            \'info\' => \'property save date - html\',
            \'name_table\' => \'value_propertys_type_html\'
        )
    );

    $res = $db->insertDb(
        \'types_property_container_data\', 
        array(
            \'name\' => \'number\', 
            \'code\' =>   \'number\', 
            \'info\' => \'property save date - number\',
            \'name_table\' => \'value_propertys_type_number\'
        )
    );

    $res = $db->createTable( // элементы containerData-а
        \'element_container_data\',
        array( 
            \'id int PRIMARY KEY AUTO_INCREMENT\', 
            \'section_id int\', 
            \'code varchar(50)\', 
            \'name varchar(50)\', 
            \'id_container_data int\',
        )
    ); 

    $res = $db->createTable( // значения свойств containerData-а типа строка
        \'value_propertys_type_html\',
        array( 
            \'id int PRIMARY KEY AUTO_INCREMENT\', 
            \'id_container_data int\', 
            \'id_element_container_data int\',
            \'id_property_container_data int\',
            \'value varchar(255)\'
        )
    ); 

    $res = $db->createTable( // значения свойств containerData-а типа число
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
    containerData::addContainerData(array(\'code\'=> \'Content\',\'name\'=> \'Контент2\'));

    $dataContentContainerData = containerData::getContainerData(array(\'=\' => array(\'code\', "\'Content\'")), array(\'*\'));

    //добавить свойство
    containerData::addPropertyContainerData(
        array(
            \'id_type_property\' => 1,
            \'id_container_data\' => $dataContentContainerData[0][\'id\'],
            \'code\' => \'html-code\',
            \'name\' => \'html вставка\'
        )
    );

    // добавить элемент контейнера данных
    containerData::addElementContainerData(
        array(
            \'section_id\' => 0,
            \'code\' => \'html-index-page\',
            \'name\' => \'Приветствие на главной\',
            \'id_container_data\' => $dataContentContainerData[0][\'id\']
        )
    );

    // взять типы свойств что бы знать названия таблиц где их искать
    //$dataTypeProperty = containerData::getAllTypePropertysContainerData();
    // найти элемент
    $dataElement = containerData::getElementContainerData(
        array(
            \'AND\' => array(
                \'=\' => array(
                    \'id_container_data\', 
                    $dataContentContainerData[0][\'id\']
                ),
                \'AND\' => array(
                    \'=\' => array(
                        \'code\',
                        "\'html-index-page\'"
                    )
                )
            )
        )
    );

    // найти его свойства
    $propertyContainerData = containerData::getPropertysContainerData(
        array(
            \'=\'=>array(
                \'id_container_data\', 
                $dataContentContainerData[0][\'id\']
            ) 
        ) 
    );
    $prop = array_shift($propertyContainerData);

    // добавить значение свойства для элемента созданного выше
    containerData::addValuePropertyContainerData(
        $dataContentContainerData[0][\'id\'], 
        $dataElement[\'id\'], 
        $prop[\'id\'],  
        \'value_propertys_type_html\', 
        \'Привет пользователь, тебя приветствует gy php framework\'.$br.\' и текст показан из его контентной части!!!\'
    );

    echo $br.\'install sest content - containerData = OK!\';
    ////
    
    echo $br.\'add user group and action and user - containerData = start\';
    // группы пользователей и права на действия 
    $db->insertDb(
        \'action_user\', 
        array(
            \'code\' => \'edit_container_data\', 
            \'text\' => \'Изменение всех container-data\', 
        )
    );
    
    $db->insertDb(
        \'users_in_groups\', 
        array(
            \'codeGroup\' => \'content\', 
            \'idUser\' => 2,
        )
    );
    
    $db->insertDb(
        \'access_group\', 
        array(
            \'code\' => \'content\', 
            \'name\' => \'Контент\',
            \'text\' => \'Те кто изменяют контент сайта\',
            \'code_action_user\' => \'edit_container_data\'
        )
    );
    
    echo $br.\'add user group and action and user - containerData = OK!\';

    
    echo $br.\'--install table module - containerData = OK!--\'.$br;
    
}else{
	echo \'! нужно запустить скрипт в консоли\';

}',
    'TYPE' => 'php',
    'DIR' => './gy/modules/containerdata/install/',
  ),
  './gy/style/main.css' => 
  array (
    'CODE' => '.gy-body-admin{
    background-color: #adade4;
}

/*--форма авторизации--*/
.gy-admin-button{
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
}',
    'TYPE' => 'css',
    'DIR' => './gy/style/',
  ),
  './gy/tests/infoBox.php' => 
  array (
    'CODE' => '<?

include "../gy.php"; 

echo \'core - ok \';

// container-data
//$res = containerData::getContainerData(array(), array(\'*\') );
//$res = containerData::addContainerData(array(\'name\' => \'asd\', \'code\'=> \'asd1\'));
//$res = containerData::deleteContainerData(array(\'>\' => array(\'id\', 3)));

// property container-data
//$res = containerData::getPropertysContainerData(array(\'=\' => array(\'id_container_data\', 12)));

//$arr = array(
//    \'id_type_property\' => 1,
//    \'id_container_data\' => 12,
//    \'code\' => \'html 12\',
//    \'name\' => \'html вставка\'
//);
//
//$res = containerData::addPropertyContainerData( $arr );


//$res = containerData::getAllTypePropertysContainerData();

/*
$res = containerData::deletePropertyContainerData( 17, 18);

print_r($res);
*/


//$cache = new cacheFiles($app->url);
//
//
//
//$cacheName = \'getContainerData\';
//$cacheTime = 120;
//        
//if($cache->cacheInit($cacheName, $cacheTime)){
//    $data = $cache->getCacheData();
//    echo \'cache ok)))\';
//}else{
//    echo \'cache NOT (((\';
//    $data = array(\'test\' => \'test1\');
//    $cache->setCacheData($data);
//}
//
//echo "<pre>";
//print_r($data);
//echo "</pre>>";
//
//
//$cache = new cache($app->url);
//
//$cacheName = \'getContainerData2\';
//$cacheTime = 90;
//        
//if($cache->cacheInit($cacheName, $cacheTime)){
//    $data = $cache->getCacheData();
//    echo \'cache ok)))\';
//}else{
//    echo \'cache NOT (((\';
//    $data = \'asdasd\';
//    $cache->setCacheData($data);
//}
//
//echo "<pre>";
//print_r($data);
//echo "</pre>>";',
    'TYPE' => 'php',
    'DIR' => './gy/tests/',
  ),
  './gy/tests/test.php' => 
  array (
    'CODE' => '<?

include "../gy.php"; 

echo \'core - ok \';

//$res = accessUserGroup::getAccessGroup();
//$res = accessUserGroup::getUserAction();
//$res = accessUserGroup::getListGroupsByUser(2);

//$res = accessUserGroup::deleteUserInAllGroups(2);

//$res = accessUserGroup::addUserInGroup(2, \'user_admin\');
//$res = accessUserGroup::addUserInGroup(2, \'content\');

//$res = accessUserGroup::deleteAllActionsForGroup(\'user_admin\');
//$res = accessUserGroup::addOptionsGroup(\'user_admin\', \'edit_container_data\');
//echo "res <pre>";
//print_r($res);
//echo "</pre>";
//$res = accessUserGroup::addOptionsGroup(\'user_admin\', \'edit_users\');

//$res = accessUserGroup::accessThisUserByAction( \'edit_users\');

//$res = accessUserGroup::accessUser( 2, \'action_all\' );

//$res = accessUserGroup::addUserGroup(
//    array(
//        \'code\' => \'test\',
//        \'text\' => \'test text\',
//        \'name\' => \'test test 0\'
//    ),
//    array( \'show_admin_panel\', \'edit_users\' )
//);

// $res = accessUserGroup::deleteUserGroupByCode(\'test\');


$res = accessUserGroup::getAccessGroup();

echo "res <pre>";
print_r($res);
echo "</pre>";

$res = accessUserGroup::getUserAction();

echo "res <pre>";
print_r($res);
echo "</pre>";',
    'TYPE' => 'php',
    'DIR' => './gy/tests/',
  ),
  './customDir/component/containerdata_element_show/teplates/0/lang_template.php' => 
  array (
    'CODE' => '<? // языковой файл для шаблона компонента
if ( !defined("GY_GLOBAL_FLAG_CORE_INCLUDE") && (GY_GLOBAL_FLAG_CORE_INCLUDE !== true) ) die( "gy: err include core" );

$mess[\'rus\'] = array(
    \'add-custom-text\' => \'Сейчас запущен кастомный (пользовательский) шаблон компонента\'
);
',
    'TYPE' => 'php',
    'DIR' => './customDir/component/containerdata_element_show/teplates/0/',
  ),
  './customDir/component/containerdata_element_show/teplates/0/style.css' => 
  array (
    'CODE' => '.user_custom_div{
    background-color: #21a2ff; 
    color: #05ff07;
}',
    'TYPE' => 'css',
    'DIR' => './customDir/component/containerdata_element_show/teplates/0/',
  ),
  './customDir/component/containerdata_element_show/teplates/0/template.php' => 
  array (
    'CODE' => '<?if ( !defined("GY_GLOBAL_FLAG_CORE_INCLUDE") && (GY_GLOBAL_FLAG_CORE_INCLUDE !== true) ) die( "gy: err include core" );?>

<div class="user_custom_div">
    
    <?if(!empty($arRes[\'ITEMS\'])){?>
        <? foreach ($arRes[\'ITEMS\'] as $value) { ?>
            <?=((!empty($value[\'value\']))? $value[\'value\'] : \'\');?>
        <?}?> 
    <?}?>    
    
    <br/>(<?=$this->lang->GetMessage(\'add-custom-text\');?>)
      
</div>',
    'TYPE' => 'php',
    'DIR' => './customDir/component/containerdata_element_show/teplates/0/',
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
            // проверить ен входит ли директория в игнорируемую 
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
                    rmdir($path); 
                }
            }
        }
    }

    // удалить директории и файлы ./install-file
    rmRec("./install-file");

    unlink("./phpInstallGyFramework.php"); // удалить этот скрипт

    echo "OK!";
    
}else{
	echo "! нужно запустить скрипт в консоли";
}
    