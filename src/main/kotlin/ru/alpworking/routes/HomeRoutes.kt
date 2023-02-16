package ru.alpworking.routes

import ru.alpworking.models.*
import io.ktor.server.application.*
import io.ktor.server.freemarker.*
import io.ktor.server.response.*
import io.ktor.server.routing.*
import java.util.*

fun Application.homeRoutes() {
    routing {
        getHomeRoute()
    }
}

fun Route.getHomeRoute() {

    route("/home") {
        get {
            // call.respondText("Hello getHomeRoute")
            call.respond(FreeMarkerContent("home.ftl", model = null))
        }
    }
}
