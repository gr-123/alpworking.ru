package ru.alpworking.routes.services.cleaning

import ru.alpworking.models.*
import io.ktor.server.application.*
import io.ktor.server.freemarker.*
import io.ktor.server.response.*
import io.ktor.server.routing.*

import java.io.File
import java.io.IOException

fun Application.CleaningRoutes() {
    routing {
        getCleaningRoute()
    }
}

fun Route.getCleaningRoute() {

    // каталог с фото портфолио услуг
    val filename = "src/main/resources/static/images/services/cleaning"
    var fileObject = File(filename)
    var fileExists = fileObject.exists()
    if(!fileExists){
        print("=== $filename file does not exist. ===")
    }

    // список названий файлов фото
    val fileList = mutableListOf<String>()
    // перечислить файлы в каталоге
    try {
        // println("-------------------------------")
        fileObject.list()
        .filter { 
            it.toString().endsWith(".jpg") 
            || it.toString().endsWith(".png") 
        }
        .forEach {
            fileList.add(it) // println(it + " " + it::class.java)
        }
        // println("-------------------------------")
    } catch (e: IOException) {
        e.printStackTrace()
    }

    // URL: "<...>/services"
    route("/services") {

        // URL: "<...>/services/cleaning"
        route("/cleaning") {
            get {
                // call.respondText("Hello ...")
                call.respond(FreeMarkerContent("services/cleaning/cleaning_show.ftl", mapOf("fileList" to fileList)))
            }

            // URL: "<...>/services/cleaning/price"
            route("/price") {
                get {
                    call.respond(FreeMarkerContent("services/cleaning/cleaning_price.ftl", model = null)) // mapOf("cleanings" to cleanings)
                }
            }
        }
    }
}
