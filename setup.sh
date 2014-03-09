#!/bin/bash

# Текущая директория скрипта установки. Требуется запускать из корневой директории проекта
CMS_DOCROOT=$(pwd)
CMS_CONFIG_PATH="$CMS_DOCROOT/application/config/"
CMS_WWW_PATH="$CMS_DOCROOT/www/"

clear
echo "Инициализация проекта в '$CMS_DOCROOT'"

# ------------------------------------------------------------------------------
# Настройка конфигурационных файлов CMS
# ------------------------------------------------------------------------------
cd $CMS_CONFIG_PATH
cp ./cms_config.php.example ./cms_config.php
cp ./cms_constants.php.example ./cms_constants.php

echo "Файлы конфигурации настроены"
# ------------------------------------------------------------------------------


# ------------------------------------------------------------------------------
# Установка симлинка на системную папку CodeIgniter
# ------------------------------------------------------------------------------
CI_VERSION="2.1.0"
CI_SYSTEM_PATH="/var/www/CI/$CI_VERSION/system/"

cd $CMS_DOCROOT
ln -f -s $CI_SYSTEM_PATH

echo "System установлен в '$CI_SYSTEM_PATH'"
# ------------------------------------------------------------------------------


# ------------------------------------------------------------------------------
# Настройка директории загрузки файлов
# ------------------------------------------------------------------------------
UPLOAD="upload"

# создание иерархии директории ipload
cd $CMS_WWW_PATH
mkdir -p ./$UPLOAD

if [ -d $CMS_WWW_PATH$UPLOAD ]
then
    cd ./$UPLOAD
    mkdir -p ./images ./editor

    if [ -d $CMS_WWW_PATH$UPLOAD/images/ ]
    then
        cd ./images
        mkdir -p ./avatar ./banner ./gallery ./news ./page ./settings
    else
        echo "Ошибка создания каталога '/$UPLOAD/images/'"
    fi

    if [ -d $CMS_WWW_PATH$UPLOAD/editor/ ]
    then
        cd ../editor
        mkdir -p ./files ./images
    else
        echo "Ошибка создания каталога '/$UPLOAD/editor/'"
    fi

else
    echo "Ошибка создания каталога '/$UPLOAD/'"
fi

# назначение прав доступа
cd $CMS_WWW_PATH
sudo chmod -R 0777 ./$UPLOAD

echo "Настройка директории загрузки файлов завершена"
# ------------------------------------------------------------------------------