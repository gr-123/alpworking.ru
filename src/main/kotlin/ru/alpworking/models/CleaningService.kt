package ru.alpworking.models

import java.util.concurrent.atomic.AtomicInteger

class CleaningService
private constructor(val id: Int, var title: String, var body: String) {
    companion object {
        private val idCounter = AtomicInteger()

        fun newEntry(title: String, body: String) = CleaningService(idCounter.getAndIncrement(), title, body)
    }
}

val cleanings = mutableListOf(CleaningService.newEntry(
    "The drive to develop!",
    "...it's what keeps me going."
))
