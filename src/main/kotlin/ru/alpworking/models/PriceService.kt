package ru.alpworking.models

import java.util.concurrent.atomic.AtomicInteger

// Создать модель
// https://ktor.io/docs/creating-interactive-website.html#model

class PriceService
private constructor(val id: Int, var title: String, var body: String) {
    companion object {
        private val idCounter = AtomicInteger()

        fun newEntry(title: String, body: String) = PriceService(idCounter.getAndIncrement(), title, body)
    }
}

val prices = mutableListOf(PriceService.newEntry(
    "The drive to develop!",
    "...it's what keeps me going."
))
