# install-gy-php-framework<br/>
install gy php framework<br/>

(ru):<br/>
Это скрипт для установки gy php framework (последней релизной версии)<br/>
(можно вместо него просто кланировать содержимое https://github.com/ssv32/gy, а данный инсталятор например сможет установить gy если нет интернета, т.е. скрипт и раздел /install-file это всё необходимое для разворота gy)
(Например zip архив с gy php framework/cms (от сюда  https://github.com/ssv32/gy) весит сейчас (текущий релиз) 131 Кб., а этот инсталятор в zip архиве 61,6 Кб., т.е. в 2ва раза меньше )
<br/>

## Инструкция по применению
1. Cкачайте себе папку /install-file и файл phpInstallGyFramework.php (README.md - не нужен), <br/>
2. Поместите их в корень раздела где должен быть развёрнут проект,<br/>
3. Запустите из консоли скрипт phpInstallGyFramework.php (пример: `php -f ./phpInstallGyFramework.php`), данный скрипт создаст все папки и файлы gy php framework, после чего удалит себя и раздел /install-file (в разделе /install-file находятся файлы типа jpg, шрифты),<br/>
4. После установки необходимо задать настройки ядра gy framework, это можно сделать скриптом gy/install/consoleInstallOptions.php из командной строки (выше есть пример как запускать) или в файле /gy/config/gy_config.php, <br/>
5. Затем надо установить необходимое в базу данных скриптом gy/install/installMysqlTable.php тоже из консоли  (выше есть пример как запускать) (предварительно нужно создать БД и задать доступы и её имя на шаге выше). <br/>
<br/><br/><br/>

`---`<br/>
Также имеется скрипт scriptCreatePhpInstallerGyFramework.php - это технический скрипт, он создаёт скрипт phpInstallGyFramework.php и раздел /install-file (он должен быть помещён рядом с развёрнутом gy (потом можно доделать подгрузку из репозитория) и создаёт php скрипт инсталятор). 
<br/>(Для установки gy не нужен, выложен для ознокомления)<br/>
<br/><br/><br/>




================================================

(en):<br/>
This is the script to install gy php framework (latest release version)<br/>
(you can instead simply clone the contents of https://github.com/ssv32/gy. This script will install gy if there is no internet, i.e. the script and the / install-file section is all you need to deploy gy)
(For example, the zip archive with gy php framework/cms (from here https://github.com/ssv32/gy) weighs now (current release) 131 Kb., And this installer in the zip archive is 61.6 Kb., I.e. 2 times less)
<br/>

## Instructions for use
1. Download the `/install-file` folder and the `phpInstallGyFramework.php` file (README.md - not needed), <br/>
2. Put them in the root of the section where the project should be deployed,<br/>
3. Run the script from the console `phpInstallGyFramework.php` (example: `php -f ./phpInstallGyFramework.php`), this script creates all folders and files gy php framework, after which it will delete itself and the partition /install-file (in section `/install-file` there are files like jpg, fonts),<br/>
4. After installation, you need to set the kernel settings gy framework, this can be done with a script gy/install/consoleInstallOptions.php from the command line (above there is an example of how to run) or in file /gy/config/gy_config.php, <br/>
5. Then you need to install the necessary in the database script `gy/install/installMysqlTable.php` also from the console (above there is an example of how to run) (first you need to create a database and set access and its name in the step above). <br/>
<br/><br/><br/>

`---`<br/>
There is also a script `scriptCreatePhpInstallerGyFramework.php` - this is a technical script, it creates a script `phpInstallGyFramework.php` and section `/install-file` (it should be placed next to the expanded gy and creates a php installer script). 
<br/>
(You do not need gy to install, laid out for familiarity)



