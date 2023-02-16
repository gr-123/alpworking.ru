package ru.alpworking

import io.ktor.server.application.*
import ru.alpworking.plugins.*
import ru.alpworking.routes.services.snow.*
import ru.alpworking.routes.*

fun main(args: Array<String>): Unit =
    io.ktor.server.netty.EngineMain.main(args)

@Suppress("unused") // application.conf references the main function. This annotation prevents the IDE from marking it as unused.
fun Application.module() {
    // Из-за ошибки "Serializer for class 'FreeMarkerContent' is not found. ..." важен порядок установки плагинов:
    // 1. install(FreeMarker) {... plugins/Templating.kt
    configureTemplating()
    // 2. install(ContentNegotiation) {... plugins/Serialization.kt
    configureSerialization()
    // 3. routing {... call.respond(FreeMarkerContent(...
    configureRouting()

    // https://ktor.io/docs/structuring-applications.html#group_routing_definitions
    serviceRoutes() // routes/services/snow/SnowRoutes.kt: fun Application.orderRoutes() { routing { ...
    priceRoutes()
    homeRoutes()
}