<?php
global $argv;
$isRunConsole = isset($argv);
$br = "\n";

//print_r($argv);

function showHelpFromInstall(){
    global $br;
    echo $br."This script intall gy framework".$br;
    echo "===================================".$br;
    echo ">php -f installGyFrameworkFromLinux.php <options>".$br;
    echo $br;
    echo "options:".$br;
    echo "    help  - show help this script".$br;
    echo "    i <folder name> - this comand run install gy framework".$br;
    echo $br;
    echo "! you should have git".$br;
    echo $br;
    echo $br;
    echo $br;
}


if($isRunConsole){ // пока запускать только из консоли
	if ( empty($argv[1]) || ($argv[1] == 'help') ){
            showHelpFromInstall();
	}elseif($argv[1] == 'i'){
            echo '! для установки необходим git'.$br;
            echo 'run git clone'.$br;
            echo `git clone https://github.com/ssv32/gy.git $argv[2]`;
            echo 'files gy framework is saved'.$br;
            echo $br;
            echo '! You you must task the kernel options with the consoleInstallOptions.php script'.$br;
            echo 'I run script gy/install/consoleInstallOptions.php '.$br;
            
            $slash = '/';
            
            $countStr = strlen($argv[2]);
            
            $lastLetter = substr($argv[2], $countStr-1, 1 );
                        
            if ( $lastLetter == '/' ){
                $slash = '';
            }
            
            echo `php -f {$argv[2]}{$slash}gy/install/consoleInstallOptions.php`;
	}
	
}else{
	echo '! нужно запустить скрипт в консоли';

}
?>
