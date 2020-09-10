# install-gy-php-framework<br/>
install gy php framework<br/>

(ru):<br/>
Это скрипты для установки gy php framework (последней релизной версии)<br/>
(можно вместо них просто кланировать содержимое https://github.com/ssv32/gy, а данные инсталяторы например смогут установить gy если нет интернета, т.е. скрипты и раздел `/install-file` это всё необходимое для разворота gy)
(Например zip архив с gy php framework/cms (от сюда  https://github.com/ssv32/gy) весит сейчас (текущий релиз) 198 Кб., а этот инсталятор в zip архиве 98 Кб., т.е. в 2ва раза меньше )
<br/>

Для установки Вам необходимо на сервер добавить файлы из этого репозитория: 
- `consoleInstallGyFramework.php` - это для установки gy из консоли;
- `graphicalInstallGyFramework.php` - это для графической установки из браузера (для него необходим `consoleInstallGyFramework.php` и раздел `install-file`);
- раздел `install-file` - тут файлы типа картинок шрифтов и т.д.

## Инструкция по установки gy графически из браузера
1. Cкачайте себе файлы описанные выше (`consoleInstallGyFramework.php`, `graphicalInstallGyFramework.php`, раздел `install-file`); <br/>
2. Поместите их в корень раздела где должен быть развёрнут проект;<br/>
3. Перейдите в браузере на скрипт установки ( `<домен вашего проекта>/graphicalInstallGyFramework.php` );<br/>
4. Далее нужно следовать инструкциям которые будут на экране, принять условия лицензии, указать найтройки ядра gy и базы данных (база данных уже должна быть создана);<br/>
5. Далее произведётся установка gy, зададутся настройки ядра gy и установятся таблицы в базу данных необходимые ядру gy и удалятся все файлы которые были нужны для установки (`consoleInstallGyFramework.php`, `graphicalInstallGyFramework.php`, раздел `install-file`).
<br/>

## Инструкция по установки gy из консоли
1. Cкачайте себе файлы описанные выше (`consoleInstallGyFramework.php`, `graphicalInstallGyFramework.php`, раздел `install-file`); <br/>
2. Поместите их в корень раздела где должен быть развёрнут проект;<br/>
3. Запустите из консоли скрипт `consoleInstallGyFramework.php` (пример: `php -f ./consoleInstallGyFramework.php`), данный скрипт создаст все папки и файлы gy php framework, после чего удалит себя, `graphicalInstallGyFramework.php` и раздел `/install-file`;<br/>
4. После установки необходимо задать настройки ядра gy framework, это можно сделать скриптом `gy/install/consoleInstallOptions.php` из командной строки (выше есть пример как запускать) или изменив файл `/gy/config/gy_config.php`; <br/>
5. Затем надо установить необходимое в базу данных скриптом `gy/install/installDataBaseTable.php` тоже из консоли  (выше есть пример как запускать) (предварительно нужно создать БД и задать доступы и её имя на шаге выше). <br/>

<br/><br/><br/>
`---`<br/>
Также имеется скрипт `scriptCreatePhpInstallerGyFramework.php` - это технический скрипт, он создаёт скрипт `consoleInstallGyFramework.php` и раздел `/install-file` (что бы им пользоваться нужно поместить его рядом с развёрнутом gy и запустить в консоли, он создаст php скрипт инсталятор - `consoleInstallGyFramework.php`). 
<br/>(Для установки gy не нужен, выложен для ознокомления)<br/>
<br/><br/><br/>


================================================

(en):<br/>
install gy php framework<br/>

These are the scripts for installing the gy php framework (latest release version)<br/>
(you can simply clone https://github.com/ssv32/gy, and these installers, for example, install gy if there is no Internet, i.e. scripts and section `/install-file` that's all you need to install gy)
(For example zip archive with gy php framework/cms ( https://github.com/ssv32/gy) weighs now (current release) 198 Kb., and this installer is in a zip archive 98 Kb., 2 times less )
<br/>

To install, you need to add files from this repository to the server: 
- `consoleInstallGyFramework.php` - this is for installing gy from the console;
- `graphicalInstallGyFramework.php` - this is for graphical installation from browser (necessary `consoleInstallGyFramework.php`, `install-file`);
- section `install-file` - here files like font pictures, etc.

## Instructions for installing gy graphically from a browser
1. Download yourself the files described above (`consoleInstallGyFramework.php`, `graphicalInstallGyFramework.php`, section `install-file`); <br/>
2. Place them at the root of the section where the project should be deployed;<br/>
3. Go to the installation script in the browser ( `<your project domain>/graphicalInstallGyFramework.php` );<br/>
4. Next, you need to follow the instructions that will be on the screen, accept the license terms, specify the gy kernel settings and the database (you should have created the database yourself before this step);<br/>
5. Next, gy is installed, the gy kernel settings are set and the tables are installed in the database necessary for the gy kernel and all files that were needed for the installation are deleted (`consoleInstallGyFramework.php`, `graphicalInstallGyFramework.php`, section `install-file`).
<br/>

## Instructions for installing gy from the console
1. Download yourself the files described above (`consoleInstallGyFramework.php`, `graphicalInstallGyFramework.php`, section `install-file`); <br/>
2. Place them at the root of the section where the project should be deployed;<br/>
3. Run the script from the console `consoleInstallGyFramework.php` (example: `php -f ./consoleInstallGyFramework.php`), this script will create all folders and files gy php framework, after which it will delete itself, `graphicalInstallGyFramework.php` and section `/install-file`;<br/>
4. After installation, you need to configure the gy framework core, this can be done with a script `gy/install/consoleInstallOptions.php` from the command line (there is an example of how to run it above) or by changing the file `/gy/config/gy_config.php`; <br/>
5. Then you need to install the necessary in the database with a script `gy/install/installDataBaseTable.php` also from the console (above there is an example of how to run) (you first need to create a database and set access and its name in the step above). <br/>


<br/><br/><br/>
`---`<br/>
There is also a script `scriptCreatePhpInstallerGyFramework.php` - this is a technical script, it creates a script `consoleInstallGyFramework.php` and section `/install-file` (to use it, you need to place it next to the expanded gy and run it in the console, it will create a php script installer - `consoleInstallGyFramework.php`). 
<br/>(Not needed for gy installation, laid out for familiarization)<br/>
<br/><br/><br/>


