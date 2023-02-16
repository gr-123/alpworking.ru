package ru.alpworking.routes.services.snow

import ru.alpworking.models.*
import io.ktor.server.application.*
import io.ktor.server.freemarker.*
import io.ktor.server.response.*
import io.ktor.server.routing.*

import java.io.File
import java.io.IOException

// https://ktor.io/docs/structuring-applications.html#group_routing_definitions
fun Application.serviceRoutes() {
    routing {
        getServiceRoute()
    }
    // CustomerRoutes.kt
        // listCustomersRoute()
        // customerByIdRoute()
        // createCustomerRoute()
        // deleteCustomerRoute()
    // OrderRoutes.kt
        // listOrdersRoute()
        // getOrderRoute()
        // totalizeOrderRoute()
}

// Определение маршрутизации для клиентов
// https://ktor.io/docs/creating-http-apis.html#customer_routing

// https://ktor.io/docs/structuring-applications.html#group_by_file
fun Route.getServiceRoute() {

    // каталог с фото портфолио услуг уборки снега
    val filename = "src/main/resources/static/images/services/snow"
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
            fileList.add(it) 
            // println(it + " " + it::class.java)
        }
        // println("-------------------------------")

        // fileObject.listFiles().forEach {}
        // fileObject.walk().filter { it.isFile }.forEach {}
        // fileObject.walk(FileWalkDirection.BOTTOM_UP).forEach {}
        // fileObject.walkTopDown().forEach {}
        // fileObject.walkBottomUp().forEach {}

        // вы можете создать свою собственную систему для перечисления файлов в каталоге:
        // @Throws(IOException::class)
        // fun getResourceFiles(path: String): List<String> = getResourceAsStream(path).use{
        //     return if(it == null) emptyList()
        //     else BufferedReader(InputStreamReader(it)).readLines()
        // }
        // private fun getResourceAsStream(resource: String): InputStream? = 
        //         Thread.currentThread().contextClassLoader.getResourceAsStream(resource) 
        //                 ?: resource::class.java.getResourceAsStream(resource)
        // Тогда просто позвоните getResourceFiles("/folder/") и вы получите список файлов в папке, предполагая, что это в пути к классам.
    } catch (e: IOException) {
        e.printStackTrace()
    }
    
    // import java.io.InputStream
    // import java.nio.charset.Charset
    // val file = File("src/main/resources/static/services/snow.html")
    // var ins:InputStream = file.inputStream()
    // // read contents of IntputStream to String
    // var content = ins.readBytes().toString(Charset.defaultCharset())
    // println(content)

    route("/services") {
        route("/snow") {
            get {
                // call.respondText("Hello getServiceRoute")
                call.respond(FreeMarkerContent("snow.ftl", mapOf("fileList" to fileList)))
            }
        }
    }
}
