# Учебник: Простой REST API Kotlin с Ktor, Exposed и Kodein
https://bettercoding.dev/kotlin/ktor-rest-api-exposed/
# ESTful Kotlin с Ktor и Exposed
<!-- 14 апреля 2018 г. (последнее обновление: 15 октября 2022 г.) -->
<!-- Обновлено для Ktor 2.1 и Kotlin 1.7.20+ -->
https://ryanharrison.co.uk/2018/04/14/kotlin-ktor-exposed-starter.html

# 1
# Создание статического веб-сайта
# Руководство как размещать статический контент, такой как изображения и HTML-страницы.
# Создать проект Ktor с помощью веб-генератора проектов - сгенерировать новый Ktor project (ссылка будет на странице), Routing , Static Content, FreeMarker, ContentNegotiation, kotlinx.serialization
https://ktor.io/docs/creating-static-website.html

Обслуживание статического контента
https://ktor.io/docs/serving-static-content.html

cd /home/dwsl/Projects/kotlin/ktor-gradle-kotlin/alpworking.ru
# пр.кн.мыши+Shift->конт.меню:linux->pwd # /mnt/...
# разархивировать в текущий каталог
unzip /mnt/d/n1/Downloads/app.zip
rm /mnt/d/n1/Downloads/app.zip

# 2
# В этом уроке мы сделаем наше приложение интерактивным с помощью механизма шаблонов FreeMarker
https://ktor.io/docs/creating-interactive-website.html#freemarker_config
# 
# Публикация серверных приложений Kotlin: Ktor на Heroku
	https://dev.to/kotlin/publishing-server-side-kotlin-applications-ktor-on-heroku-2ce4
# Deploy Ktor App with Postgresql on Heroku
    https://nameisjayant.medium.com/deploy-ktor-app-with-postgresql-on-heroku-ff35df4b5c55
# 




Heroku CLI
----------
# Deploying with Git
https://devcenter.heroku.com/articles/git

git init
git add . ; git commit -m "..."

# application.conf: PORT, KTOR_ENV # на сервере heroku тоже добавить переменную среды
# build.gradle.kts: tasks.create("stage")...
# Procfile:...
# IntelliJ IDEA: VCS | Initial local Git repository | Commit | Push in the remote heroku repository
heroku create myprojectname # создать приложение Heroku
# отправляем фиксацию, сделанную в предыдущем разделе, на только что добавленный heroku удаленный Git
# IntelliJ IDEA: VCS | Push in the remote heroku repository
# Пользовательские доменные имена для приложений
	https://devcenter.heroku.com/articles/custom-domains#view-existing-domains
	# Как настроить DNS для домена вершины (без www), указывающего на приложение Heroku?
		https://stackoverflow.com/questions/16022324/how-do-i-set-up-dns-for-an-apex-domain-no-www-pointing-to-a-heroku-app
	# Документация на heroku: 
		# зарегистрировать приложение как www.example.com, настроить переадресацию с example.com на www.example.com (на внешнем сервере)
		# CNAME для www (на внешнем сервере)
heroku domains:add alpworking.ru     # добавить домен
heroku domains:add www.alpworking.ru # добавить поддомен
# Timeweb: создать запись CNAME для поддомена со значением DNS Target (в настройках приложения Heroku) в разделе "Домены и поддомены" - "Настройки DNS"
heroku logs --tail
	# heroku logs --dyno router
	# heroku logs --source app
	# heroku logs --source app --dyno worker
	# heroku logs --source app --tail
    # Managing Multiple Environments for an App
        https://devcenter.heroku.com/articles/multiple-environments
    # Глобальные настройки окончания строк
        https://docs.github.com/en/get-started/getting-started-with-git/configuring-git-to-handle-line-endings
        git config --global core.autocrlf input
    # KTOR - HEROKU DEPLOYMENT PostgreSQL
        https://kalaiselvan369.medium.com/ktor-heroku-deployment-990476a20f86
# 
# 2. Создание интерактивного веб-сайта (FreeMarker)
chttps://ktor.io/docs/creating-interactive-website.html
# ...
# 3. Добавление постоянства на веб-сайт (Exposed, h2database)
https://ktor.io/docs/interactive-website-add-persistence.html#add-dependencies
# ...






# testing with HttpClient
https://ktor.io/docs/testing.html#end-to-end


# На протяжении всего руководства мы создадим простой JSON API, 
# который позволит нам запрашивать информацию о клиентах нашего фиктивного бизнеса, 
# а также о заказах, которые мы в настоящее время хотим выполнить. Мы создадим удобный 
# способ перечисления всех клиентов и заказов в нашей системе, получим информацию 
# по отдельным клиентам и заказам, а также обеспечим функциональность для добавления 
# новых записей и удаления старых записей.
https://ktor.io/docs/creating-http-apis.html#create_ktor_project
https://github.com/ktorio/ktor-documentation/tree/main/codeSnippets/snippets/tutorial-http-api



# Создание интерактивного веб-сайта
https://ktor.io/docs/creating-interactive-website.html
# API DAO
https://github.com/JetBrains/Exposed/wiki/DAO
# Kotlin Exposed
https://blog.jdriven.com/2019/07/kotlin-exposed-a-lightweight-sql-library/
    # Exposed README
    https://github.com/JetBrains/Exposed
    # Exposed wiki с документацией
    https://github.com/JetBrains/Exposed/wiki
# Kotlin Gradle Flyway Postgres Exposed
https://bettercoding.dev/kotlin/tutorial-exposed-generation-flyway/


# Создание чата WebSocket
# kotlin-ktor-websockets
https://ktor.io/docs/creating-web-socket-chat.html
https://learning.postman.com/docs/sending-requests/supported-api-frameworks/websocket/


# Uploading files
# FileReader
# Параметры формы; Данные составной формы
https://ktor.io/docs/requests.html
# Параметры формы
	https://ktor.io/docs/request.html#form_parameters
# Загрузить файл
	https://ktor.io/docs/request.html#upload_file


# Автоперезагрузка
./gradlew -t build # chmod a+x ./gradlew
# Чтобы пропустить запуск тестов при перезагрузке проекта:
./gradlew -t build -x test -i
# Откройте другую вкладку терминала и запустите пример:
gradle run
# Автоперезагрузка работает только в режиме разработки, который включен в application.conf


# Создание полнофункционального веб-приложения с мультиплатформой Kotlin
https://kotlinlang.org/docs/multiplatform-full-stack-app.html
# все приложение будет написано на Kotlin: 
# бэкэнд будет использовать Kotlin/JVM, фронтенд будет использовать Kotlin/JS.








tar -czvvf archive.tar.gz ./data-website

gradle init
gradle run
gradle run --debug-jvm

# Как установить IntelliJ IDEA в Debian 11
    https://www.itzgeek.com/how-tos/linux/debian/how-to-install-intellij-idea-on-debian-11.html
    https://stackoverflow.com/questions/30130934/how-to-install-intellij-idea-on-ubuntu
$HOME/bin/idea/bin/idea.sh

cd $HOME/Projects/project \
	&& rm -rf $(pwd)/app/{*,.*} ; rmdir $(pwd)/app




Bitbucket
---------
Настройте SSH на macOS/Linux:
https://support.atlassian.com/bitbucket-cloud/docs/set-up-an-ssh-key/

cat ~/.ssh/id_rsa.pub 
# copy output and past to bitbacket.org
# passphrase: 8487

# Create repository Bitbucket ...
git clone git@bitbucket.org:a_gr/alp-jobs-data.git
git push (passphrase)


