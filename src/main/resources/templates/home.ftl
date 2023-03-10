
<#import "_layout.ftl" as layout />
<@layout.main_layout
    keywords="Промышленный альпинизм, .........."
    title="Высотные работы. Промышленный альпинизм"
    ; section>
<#if section = "styles"><link rel="stylesheet" href="/assets/price.css"></#if>
<#if section = "scripts"><#--  <script src="/assets/script.js"></script>  --></#if>
<#if section="content">

<#--  content  -->



<ul>
    <li>
        <a href="/services/snow">Уборка снега и наледи с крыш, удаление сосулек</a> 
        <i>От 30 руб./м2</i> <a href="/services/snow/price">(...)</a>
        <a title="Написать в Whatsapp" aria-label="Chat on WhatsApp" 
                            href="https://wa.me/79957708774?text=" target="_blank">
                            <img alt="WhatsApp" 
                                src="/images/whatsapp/WhatsAppButtonGreenSmall.svg"/>
                        </a>
        <#--  <a href="/price#snow-price">якорь</a>  -->
    </li>
    <li>
        <a href="">Мойка окон</a><i>От 55 руб./м2</i>
        <a title="Написать в Whatsapp" aria-label="Chat on WhatsApp" 
                            href="https://wa.me/79957708774?text=" target="_blank">
                            <img alt="WhatsApp" 
                                src="/images/whatsapp/WhatsAppButtonGreenSmall.svg"/>
                        </a>
    </li>
    <li>
        <a href="/services/sealing">Герметизация межпанельных швов</a> 
        <i>От 250 руб./пог.м.</i> <a href="/services/sealing/price">(...)</a>
        <a title="Написать в Whatsapp" aria-label="Chat on WhatsApp" 
                            href="https://wa.me/79957708774?text=" target="_blank">
                            <img alt="WhatsApp" 
                                src="/images/whatsapp/WhatsAppButtonGreenSmall.svg"/>
                        </a>
        <#--  <a href="/price#sealing-price">якорь</a>  -->
    </li>
</ul>

<p></p>
    Минимальная сумма заказа
    <div class="tab">
        Москва 8700 руб
        <br>Московская область 10000 руб.
    </div>
    
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