<#-- @ftlvariable name="services" type="kotlin.collections.List<ru.alpworking.models.SealingService>" -->
<#import "/_layout.ftl" as layout />
<@layout.main_layout 
    keywords="Промышленный альпинизм, Герметизация межпанельных швов"
    title="Герметизация межпанельных швов"
    ; section>

<#if section = "styles">
    <link rel="stylesheet" href="/assets/css_gallery.css">
</#if>

<#if section = "scripts">
    <#--  <script src="/assets/script.js"></script>  -->
</#if>

<#if section="content">

<h2>Герметизация межпанельных швов
<br><a href="/services/sealing/price">Стоимость работ по герметизации межпанельных швов</a></h2>

<#--  Фотогалерея на CSS  -->
<div id="gall">
    <#list fileList as name>
        <img src="/images/services/sealing/${name}" tabindex="0" border="3"/>
    </#list>
    <div></div>
</div>

</#if>
</@layout.main_layout>