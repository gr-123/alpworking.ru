package ru.alpworking.plugins

import freemarker.cache.*
import freemarker.core.*
import io.ktor.server.application.*
import io.ktor.server.freemarker.*

fun Application.configureTemplating() {
    install(FreeMarker) {
        templateLoader = ClassTemplateLoader(this::class.java.classLoader, "templates")
        outputFormat = HTMLOutputFormat.INSTANCE // экранирование
    }

    // install(FreeMarker) {
        // мы можем использовать MultiTemplateLoader, а затем загружать шаблоны из разных мест:
        // н-р: src/main/kotlin/ru/alpworking/customer/changeAddress/<FileSpecificsName>.kt
        //     val customerTemplates = FileTemplateLoader(File("./customer/changeAddress"))
        //     val loaders = arrayOf<TemplateLoader>(customerTemplates)
        //     templateLoader = MultiTemplateLoader(loaders)
        // Преимущество этого подхода заключается в том, что мы можем сгруппировать все, что связано с одной и той же функциональностью, в одном месте, по функциям, а не по техническим/инфраструктурным аспектам.
        // https://ktor.io/docs/structuring-applications.html#group_by_feature
    // }
}
