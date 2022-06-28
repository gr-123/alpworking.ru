package ru.alpworking

import io.ktor.server.application.*
import ru.alpworking.plugins.*

fun main(args: Array<String>): Unit =
    io.ktor.server.netty.EngineMain.main(args)

@Suppress("unused") // application.conf references the main function. This annotation prevents the IDE from marking it as unused.
fun Application.module() {
    configureRouting()       // функция, определенная в plugins/Routing.kt
    configureSerialization() // функция, определенная в plugins/Serialization.kt
    configureTemplating()    // функция, определенная в plugins/Templating.kt
}
