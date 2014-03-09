#!/bin/bash

# Текущая директория скрипта установки. Требуется запускать из корневой директории проекта
CMS_DOCROOT=$(pwd)
CMS_VIEWS_PATH="$CMS_DOCROOT/application/views/"

# ------------------------------------------------------------------------------
# Добавление новой темы шаблона
# ------------------------------------------------------------------------------
cd $CMS_VIEWS_PATH
read -p "Введите название темы: " THEME_NAME
mkdir -p ./$THEME_NAME

if [ -d $CMS_VIEWS_PATH$THEME_NAME ]
then
    cd ./$THEME_NAME
    cp $CMS_DOCROOT/application/views/default/widgets.php ./widgets.php
    mkdir -p ./admin ./site ./widgets ./www_admin ./www_site

    if [ -d $CMS_VIEWS_PATH$THEME_NAME/www_admin/ ]
    then
        cd ./www_admin
        mkdir -p ./css ./img ./js
    else
        echo "Ошибка создания каталога '/$THEME_NAME/www_admin/'"
    fi

    if [ -d $CMS_VIEWS_PATH$THEME_NAME/www_site/ ]
    then
        cd ../www_site
        mkdir -p ./css ./img ./js
    else
        echo "Ошибка создания каталога '/$THEME_NAME/www_site/'"
    fi

else
    echo "Ошибка создания каталога '/$THEME_NAME/'"
fi
# ------------------------------------------------------------------------------