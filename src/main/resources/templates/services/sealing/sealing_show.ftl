<#-- @ftlvariable name="services" type="kotlin.collections.List<ru.alpworking.models.SealingService>" -->
<#import "/_layout.ftl" as layout />
<@layout.main_layout 
    keywords="Промышленный альпинизм, Герметизация межпанельных швов"
    title="Герметизация межпанельных швов"
    ; section>

<#if section = "styles">
    <link rel="stylesheet" href="/assets/css_gallery.css">
    <link rel="stylesheet" href="/assets/price.css">
</#if>

<#if section = "scripts">
    <#--  <script src="/assets/script.js"></script>  -->
</#if>

<#--  IF CONTENT >>>  -->
<#if section="content">



<h2>Герметизация межпанельных швов
<br><a href="/">На главную</a></h2>
<#--  <br><a href="/services/sealing/price">Стоимость работ по герметизации межпанельных швов</a></h2>  -->

<table class="table">
<thead>
    <tr><th>Наименование работ<br><span style="font-weight: normal;"><i>( без учета стоимости материалов )<i></span></th><th style="text-align: center;">Стоимость пог.м. / руб.</th></tr>
</thead>
<tbody>
    <tr>
        <td>
            Вторичная герметизация межпанельного шва<span style="font-weight: normal;"><i>
            <br><br>( Нанесение герметизирующей мастики поверх существующего основания шва )<i></span>
        </td>
        <td style="text-align: center;">250</td>
    </tr>
    <tr>
        <td>
            Теплый шов<span style="font-weight: normal;"><i>
            <br><br>( Комплексный ремонт межпанельного шва -- разбивка, очистка, утепление заполнением монтажной пены, 
            <br> укладка вилатерма и последующая герметизация )<i></span>
        </td>
        <td style="text-align: center;">от 850</td>
    </tr>
</tbody>
</table>

<#--  Фотогалерея на CSS  -->
<div id="gall">
    <#list fileList as name>
        <img src="/images/services/sealing/${name}" tabindex="0" border="3"/>
    </#list>
    <div></div>
</div>



<#--  <<< IF CONTENT  -->
</#if>
</@layout.main_layout>