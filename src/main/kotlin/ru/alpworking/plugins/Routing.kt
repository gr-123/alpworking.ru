package ru.alpworking.plugins

import io.ktor.server.routing.*
//import io.ktor.http.*
import io.ktor.server.http.content.*
import io.ktor.server.application.*
//import io.ktor.server.response.*
//import io.ktor.server.request.*

fun Application.configureRouting() {
    
    // http://localhost:8080/static/ktor_logo.png
    // http://localhost:8080/static/aboutme.html
    routing {
        static("/static") {
            resources("files")
        }
    }
}
