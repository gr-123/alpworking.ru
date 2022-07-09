package ru.alpworking.plugins

import io.ktor.server.application.*
import io.ktor.server.http.content.*
import io.ktor.server.routing.*
//import io.ktor.http.*
//import io.ktor.server.response.*
//import io.ktor.server.request.*

fun Application.configureRouting() {
    
    routing {
            
            // Обслуживание статического контента
            // https://ktor.io/docs/serving-static-content.html
            
            static("/") {
                
                // установить static пакет по умолчанию (внутри resources папки)
                staticBasePackage = "static"
        
                // рекурсивно обслуживать все файлы из static папки, если URL-адрес и физическое имя файла совпадают
                // resources(".")
        
                // обслуживание отдельных файлов
                resource("index.html") // 'static/index.html'

                // определить ресурс по умолчанию
                defaultResource("index.html") // '/' -> 'static/index.html'
        
                // определить подмаршруты по URL-адресу
                static("images") { // '/images'

                    resource("ktor_logo.png")              // '/images/ktor_logo.png'
                    resource("image.png", "ktor_logo.png") // '/images/ktor_logo.png' | '/images/image.png'
                }

                static("assets") {

                    // обслуживание содержимого из папки ресурсов
                    // позволит любому файлу, расположенному в 'css' папке ресурсов, служить статическим содержимым по заданному шаблону URL
                    resources("css") // '/assets/styles.css' -> 'files/css/styles.css'
                    resources("js")
                }
        }
    }

}
