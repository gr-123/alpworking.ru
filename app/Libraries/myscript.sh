#!/bin/bash
set -e
# встроенная функция 'set' с аргументом '-e': дать команду оболочке выйти из сценария, если какая-либо из команд завершится неудачей
# Сохраните это в файл, например myscript, и сделайте его исполняемым:
# chmod +x myscript



# echo --- Showing \""$@"\" as parameters ---
# for i in "$@"; do
#     echo i=$i
# done



# -----------------------------------------------------------------------------
# $#	# Сколько параметров командной строки было передано в скрипт.
# $@	# Все параметры командной строки передаются в скрипт.
# $?	# Статус завершения последнего запущенного процесса.
# $$	# Идентификатор процесса (PID) текущего сценария.
# $USER	# Имя пользователя, выполняющего скрипт.
# $HOSTNAME	# Имя хоста компьютера, на котором выполняется сценарий.
# $SECONDS	# Количество секунд, в течение которых выполнялся сценарий.
# $RANDOM  	# Возвращает случайное число.
# $LINENO	# Возвращает текущий номер строки скрипта.
# -----------------------------------------------------------------------------
