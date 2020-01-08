<?php

/**
 * скрипт должен собрать из файлов gy framework php инсталятор
 */

global $argv;
$isRunConsole = isset($argv);
$br = "\n";

/**
 * getTypeFile 
 *  - вернёт указанного файла
 *  (в упрощённом виде , просто последние 3 символа из имени, большая точность пока ненужна)
 */
function getTypeFile($urlFile){
    return substr($urlFile, strlen($urlFile)-3 );
}

/**
 * deleteOneLetterInString 
 *  - вернёт строку без первого символа
 * 
 * @param string $string - строка
 * @return string
 */
function deleteOneLetterInString($string){
    return substr($string, 1);
}

// функция которая соберёт все файлы и директории
function getTrueDataDir($arDir, $thisDir, $arIgnoreDirOrFile){
    $result = array();
    
    foreach ($arDir as $dirNameOrFile) {
        
        // проверить ен входит ли директория в игнорируемую 
        if( !in_array($dirNameOrFile, $arIgnoreDirOrFile ) ){
            $diirName = $thisDir.$dirNameOrFile;
            if(is_dir($diirName)){
                $diirName = $thisDir.$dirNameOrFile.'/';              
                $date = scandir($diirName);
                $twoResult = getTrueDataDir($date, $diirName, $arIgnoreDirOrFile);
                $result = array_merge($result, $twoResult);               
            }else{
                $result[$thisDir.$dirNameOrFile]['CODE'] = file_get_contents($thisDir.$dirNameOrFile);
                $result[$thisDir.$dirNameOrFile]['TYPE'] = getTypeFile($thisDir.$dirNameOrFile);
                $result[$thisDir.$dirNameOrFile]['DIR'] = $thisDir;
                
            }
        }
    }
    return $result;
}


if($isRunConsole){ 
    // сюда будет собираться скрипт
    $codeScript = '<?php 
global $argv;
$isRunConsole = isset($argv);
$br = "\n";

if($isRunConsole){ ';
    
    // это файлы/директории который должны создаваться скриптом
    $arDirSearchFile = array(
        'index.php',
        'gy',
        'customDir'
    );
    
    // массив с файлами или директориями которые нужно исключать, не брать в расчёт
    $arIgnoreDirOrFile = array(
        '.git',
        'gy/cache',
        'gy/tests',
        '.',
        '..'
    );
    
    
    // TODO надо подтянуть файлы gy framework из gihub 
    //   пока предполагается что файлы gy фреймворка в этом же разделе где этот скрипт

    // пройти по всем разделам найти все имеющиеся файлы (кроме файлов кеша)
    $arDirGy = getTrueDataDir($arDirSearchFile, './', $arIgnoreDirOrFile);
    
    // сделать скрипт php при запуски которого создались бы все разделы и файлы как прочитанные выше
    
    // скопировать отдельно в папку файлы типа картинки и шрифты
    $nameDirInstallStaticFile = './install-file';
    foreach ($arDirGy as $key => $value) {
        if ( ($value['TYPE'] == 'jpg') || ($value['TYPE'] == 'otf')) {
            mkdir($nameDirInstallStaticFile.deleteOneLetterInString($value["DIR"]), 0755, true);
            copy($key, $nameDirInstallStaticFile.deleteOneLetterInString($key) );
            unset($arDirGy[$key]);
        }
    }
    
    // тут структура файлов и содержимое фалов как php код, в виде массива
    ob_start();
    var_export($arDirGy);
    $asd = ob_get_contents();
    ob_end_clean();
    
    $codeScript .= '
    // все файлы проекта (php, js, css)
    $arrayDirGy = '.$asd.';';
    
    // добавляю код который создаст файлы из полученных данных
    $codeScript .= '
        
    // создаёт все директории и файлы php, js, css проекта
    foreach ($arrayDirGy as $urlFile => $dataFile){

        if(file_exists($dataFile["DIR"]) === false){
            mkdir($dataFile["DIR"], 0755, true);   
        }
        file_put_contents($urlFile, $dataFile["CODE"]);
    }';
    
    $codeScript .= '
        
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
    ';
    
    // сохраняем скрипт
    file_put_contents('./phpInstallGyFramework.php', $codeScript);

    // TODO можно удалить файлы gy и этот скрипт 
    //   удалить всё оставив только скрипт установки и раздел install-file
    
    echo 'OK!';
    
}else{
	echo '! нужно запустить скрипт в консоли';
}