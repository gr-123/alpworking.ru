package ru.alpworking.models

import java.util.concurrent.atomic.AtomicInteger

class SealingService
private constructor(val id: Int, var title: String, var body: String) {
    companion object {
        private val idCounter = AtomicInteger()

        fun newEntry(title: String, body: String) = SealingService(idCounter.getAndIncrement(), title, body)
    }
}

val sealings = mutableListOf(SealingService.newEntry(
    "The drive to develop!",
    "...it's what keeps me going."
))
