
<#import "_layout.ftl" as layout />
<@layout.main_layout
    keywords="Промышленный альпинизм, .........."
    title="Высотные работы. Промышленный альпинизм"
    ; section>

<#if section = "styles">
    <link rel="stylesheet" href="/assets/price.css">
</#if>

<#if section = "scripts">
    <#--  <script src="/assets/script.js"></script>  -->
</#if>

<#if section="content">

    <h2>Добро пожаловать!</h2>
    <p></p>
    <p>
        Список услуг:
    <ul>
        <li>
            <a href="/services/snow">Уборка снега и наледи с крыш, удаление сосулек</a> <i>От 30 руб./м2</i>
            <a href="/price#snow-price"></a>
        </li>
    </ul>
    </p>

    <#-- *.html
        <#list services?reverse as service>
        <div>
            <h3>
                <a href="/services/${service.id}">${service.title}</a>
            </h3>
            <p>
                ${service.body}
            </p>
        </div>
        </#list>
    *.html -->


<#-- <p><button type="button" onclick="message('Hello, world!')">Click Me!</button></p> -->

</#if>
</@layout.main_layout>