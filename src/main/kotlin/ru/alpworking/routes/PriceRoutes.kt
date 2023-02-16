package ru.alpworking.routes

import ru.alpworking.models.*
import io.ktor.server.application.*
import io.ktor.server.freemarker.*
import io.ktor.server.response.*
import io.ktor.server.routing.*
import java.util.*

fun Application.priceRoutes() {
    routing {
        getPriceRoute()
    }
}

fun Route.getPriceRoute() {

    route("/price") {
        get {
            // call.respondText("Hello getPriceRoute")
            call.respond(FreeMarkerContent("price.ftl", mapOf("prices" to prices)))
        }
    }
}
