<#-- @ftlvariable name="cleanings" type="kotlin.collections.List<ru.alpworking.models.CleaningService>" -->
<#import "/_layout.ftl" as layout />
<@layout.main_layout 
    keywords="промышленный альпинизм, мойка окон, мойка сплошного остекления, мойка витрин, мойка балконов, мойка лоджий, мойка зимних садов, мойка фасадов"
    title="Мойка окон, витрин, сплошного остекления"
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



<h2>Мойка окон альпинистами, витрин, сплошного остекления
<br><a href="/">На главную</a></h2>
<#--  <br><a href="/services/cleaning/price">Стоимость работ по мойке окон альпинистами</a></h2>  -->

<br>

<table class="table">
<thead>
    <tr>
        <th rowspan="2">Высотная мойка окон<br><span style="font-weight: normal;"><i>( без учета расходных материалов )<i></span></th>
        <th style="text-align: center;">Стоимость</th>
    </tr>
</thead>
<tbody>
    <tr><td>Атмосферные загрязнения</td><td>45</td></tr>
    <tr><td>Механическая очистка <span style="font-weight: normal;"><i>( краска, цемент )<i></span></td><td colspan="4">185</td></tr>
</tbody>
</table>

<#--  Фотогалерея на CSS  -->
<div id="gall">
    <#list fileList as name>
        <img src="/images/services/cleaning/${name}" tabindex="0" border="3"/>
    </#list>
    <div></div>
</div>



<#--  <<< IF CONTENT  -->
</#if>
</@layout.main_layout>