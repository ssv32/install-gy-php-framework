# install-gy-php-framework<br/>
install gy php framework<br/>
Это скрипт для установки gy php framework (последней релизной версии)<br/>
<br/>

## Инструкция по применению
1. Cкачайте себе папку /install-file и файл phpInstallGyFramework.php (README.md - не нужен), <br/>
2. Поместите их в корень раздела где должен быть развёрнут проект,<br/>
3. Запустите из консоли скрипт phpInstallGyFramework.php (пример: `php -f ./phpInstallGyFramework.php`), данный скрипт создаст все папки и файлы gy php framework, после чего удалит себя и раздел /install-file (в разделе /install-file находятся файлы типа jpg, шрифты),<br/>
4. После установки необходимо задать настройки ядра gy framework, это можно сделать скриптом gy/install/consoleInstallOptions.php из командной строки (выше есть пример как запускать), <br/>
5. Затем надо установить и создать базу данных (пока mysql) скриптом gy/install/installMysqlTable.php тоже из консоли  (выше есть пример как запускать). <br/>
<br/><br/><br/>
