<#--  Общая структура https://freemarker.apache.org/docs/dgui_template_overallstructure.html  -->
<#macro main_layout keywords="" title="">
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="${keywords}">

    <title>${title}</title>

    <link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon">
    
    <#-- common javascript and css references here -->

    <link rel="stylesheet" href="/assets/styles.css">
    <#nested "styles">

    <#--  <script src="/assets/script.js"></script>  -->
    <#nested "scripts">
</head>

<body>

    <#-- header stuff -->

<div class="container">
<header>
<table style="width:1200px; height:150px;">
	<tbody>
		<tr>
            <td>
                <a href="/">
                    <img alt="Logo" width="650px" height="110px" 
                        src="/images/logo.jpg">
                </a>

                <br><span style="color: green; font-size: 2em">Высотные работы</span>
                <br><span style="font-size: 1em">Промышленный альпинист</span>
            </td>
            <td style="text-align: right; height:70px; margin-right: 1em;">
                <p></p>
                <div>
                    <#-- Иконки можно найти на сайте https://www.iconfinder.com/ или http://www.iconsearch.ru/search/ -->
                    <#-- КОНСТРУКТОР ССЫЛОК WHATSAPP https://whatsaps.ru/ ; Telegram, WhatsApp и Viber https://msgr.pw/ -->
                    <p>
                        <a title="Написать в Whatsapp" aria-label="Chat on WhatsApp" 
                            href="https://wa.me/79957708774?text=" target="_blank">
                            <img style="height:20px;" alt="WhatsApp" 
                                src="/images/whatsapp/WhatsAppButtonGreenSmall.svg"/>
                        </a> |
                        <a href="tg://resolve?domain=@aleksey_gr">
                            Telegram
                        </a> |
                        <a href="viber://forward?text=79957708774">
                            Viber
                        </a>
                        <#--  <p>Звоните прямо сейтчас!</p>  -->
                        <br>support@alpworking.ru
                        <br><span>тел. +7 (995) 770-87-74</span>
                        <br>Пн-Сб: 9.00-18.00
                    </p>
                </div>
            </td>
        </tr>
	</tbody>
</table>
<#--  <h5>Москва и Московская область</h5>  -->

<ul>
    <li><a href="/">Главная</a></li> <#-- Home -->
    <#--  <li><a href="/price">Цены</a></li>  -->
    <#--  <li><a href="/about">О нас</a></li>  -->
</ul>
</header>

    <hr>

    <#-- Content of the body -->
    <#nested "content">

    <#--  comment>>>  -->
    <#if false>
        ...
    <#--  <<<comment  -->
    </#if>

    <#-- footer stuff -->

    <p></p>

<p></p><p></p><p></p><p></p><p></p><p></p><p></p><p></p><p></p>
</div>
<footer>
    <div class="footer-gen" style="text-align: center; font-family: sans-serif">
        <div class="footer">
            <#--  <a href="/imprint">Imprint</a> Imprint  -->
            <#--  <a href="/privacy">Privacy Policy</a> Privacy  -->
            <#--  <a href="/conditions">Conditions</a> Conditions  -->
        </div>
        <div class="footer-name">
            <small>&copy; Copyright 2023, alpworking blog</small>
            <#--  
            Владельцам сайтов: 
                изменения в законе о персональных данных
                Как избежать штрафов и что нужно знать о новых поправках
                https://tilda.education/articles-personal-data-law  -->
        </div>
    </div>
</footer>
</body>
</html>

</#macro>