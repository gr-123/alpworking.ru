package ru.alpworking.plugins

import io.ktor.server.application.*
import io.ktor.server.http.content.*
import io.ktor.server.routing.*
//import io.ktor.http.*
//import io.ktor.server.response.*
//import io.ktor.server.request.*

fun Application.configureRouting() {
    
    routing {
            
        // 
        // https://ktor.io/docs/serving-static-content.html
        // 
        // Обслуживание статических ресурсов
        // 
        
        static("/") {
            
            // статические файлы приложения хранятся внутри 'static' пакета папки 'resources'
            staticBasePackage = "static" // Изменить пакет ресурсов по умолчанию, установить пакет 'static'
            // path '/src/main/resources/static/' -> url '/' // ..?
            
            // Как обслуживать статические ресурсы:
            // resources(".")             // Обслуживать все ресурсы, в том числе во вложенных папках
            resource("index.html")        // Обслуживать отдельные файлы
            defaultResource("index.html") // Определить ресурс по умолчанию. В этом случае для запросов '/' к серверу Ktor служит 'static/index.html'
    
            // Определить подмаршрут 'images':
            static("images") {
                // resource("ktor_logo.png") // url -> '/images/ktor_logo.png'
                // второй необязательный аргумент, который позволяет вам сопоставить физическое имя файла с виртуальным
                // resource("image.png", "ktor_logo.png") // url -> '/images/ktor_logo.png' или '/images/image.png'
                resources("images")
            }

            // Определить подмаршрут 'assets':
            static("assets") {
                resources("css") // таблицы стилей из папки 'css'. Это означает, что запрос '/assets/styles.css' будет обслуживать 'files/css/styles.css' файл
                resources("js")  // скрипты из папки 'js'
            }
    
            // Физический путь -> URL-адрес
            // ----------------------------
            // static/index.html        /index.html или /
            // static/ktor_logo.png     /images/ktor_logo.png
            // static/css/styles.css    /assets/styles.css
            // static/js/script.js(.gz) /assets/script.js
        }
    }

}
