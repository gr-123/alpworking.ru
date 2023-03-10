<#-- @ftlvariable name="services" type="kotlin.collections.List<ru.alpworking.models.SnowService>" -->
<#import "/_layout.ftl" as layout />
<@layout.main_layout 
    keywords="Промышленный альпинизм, Уборка снега и наледи с крыш, удаление сосулек"
    title="Уборка снега и наледи с крыш, удаление сосулек"
    ; section>

<#if section = "styles">
    <link rel="stylesheet" href="/assets/css_gallery.css">
</#if>

<#if section = "scripts">
    <#--  <script src="/assets/script.js"></script>  -->
</#if>

<#if section="content">

<h2>Уборка снега и наледи с крыш, удаление сосулек.
<br><a href="/services/snow/price">Стоимость работ по уборке снега, наледи и сосулек.</a></h2>

<#--  Фотогалерея на CSS  -->
<div id="gall">
    <#list fileList as name>
        <img src="/images/services/snow/${name}" tabindex="0" border="3"/>
    </#list>
    <div></div>
</div>


<#--  <script type="text/javascript" language="javascript">
function image(img) {
    if (document.getElementById) {
        document.getElementById('placeholder').src = img.href;
    if (img.title) {
        // childNodes[0].nodeValue: значение первого дочернего узла элемента
        document.getElementById('desc').childNodes[0].nodeValue = img.title;
    } else {
        document.getElementById('desc').childNodes[0].nodeValue = img.childNodes[0].nodeValue;
    }
    return false;
    } else {
        return true;
    }
}
</script>  -->
    <#--  
    <#list fileList as name>
        Остается только вызывать эту функцию из каждой из ссылок. Чтобы передать значение для whatpic, каждой из ссылок можно присвоить уникальный идентификатор. Однако гораздо проще просто передать значение this, что будет означать, что whatpic будет иметь значение «этот элемент, вызывающий функцию».
        Если функция возвращает false, ссылка не переходит. Это делается с помощью onclick="return image(this)".
        <a image(this) href="/images/services/snow/${name}" title="...111111">===111</a>
    </#list>
<p id="desc">Choose an image to begin</p>
<img id="placeholder" src="/images/blank.gif" alt="" />
-->


<#--  
<div class="container">
    <div class="row">
        <#list fileList as name>
            <a href="/images/services/snow/${name}" target = "_blank">
                <img src="/images/services/snow/${name}"
                    alt="click here" 
                    width="150" height="150" 
                    style="float:left; padding-right:15px; padding-top:15px;">
            </a>
        </#list>
        
        <#list fileList as name>
            <a href="/images/services/snow/${name}" target = "_blank">
                <img src="/images/services/snow/${name}" alt="ktor logo" 
                    width="100" height="100" 
                    style="max-width:100%;height:auto;">
            </a>
        </#list>  
    </div>
</div>
-->

<#--  
<article>
    <#list fileList as name>
        <a href="/images/services/snow/${name}" target = "_blank">
            <img src="/images/services/snow/${name}" alt="ktor logo" 
                width="100" height="100" 
                style="max-width:100%;height:auto;">
        </a>
    </#list> 
    
    max-width растягивает картинку на всю ширину внешнего блока при условии, что размер этого блока не превышает размера изображения. Когда это не так, срабатывают значения атрибутов длины и ширины тега.
    
    для выравнивая отдельно стоящего изображения по центру приводился пример помещения его в блок div или figure. Однако мы можем сделать само изображение блочным элементом с помощью объявления display: block. После этого центрировать его с помощью margin: auto.
    img {
        display: block;
        margin: 0 auto;
        max-width: 100%;
        height: auto;
    }
    … 
    <img src="gnu.png" alt="Логотип GNU"
        width="491" height="480">  



<img src="/images/services/snow/1.jpg" alt="ktor logo" 
    width="100" height="100" 
    style="float:left; padding-right:15px;">
<p>
    Бывает, что маленькие картинки предпочитают обтекать текстом слева или справа. Для этого используют свойство float со значением left или right. В случае float: left элемент будет "уплывать" налево. Другие элементы будут оказываться справа от него.
</p>
<p>
    Здесь может потребоваться решать две проблемы:
</p>
<p>
    1. Бывает необходимо, чтобы только конкретный абзац обтекал изображение.<br>
    2. На узких экранах обтекание должно смениться на расположение картинки и текста друг под другом. Иначе получается слишком мало места для текста сбоку от изображения, и верстка выглядит плохо.
</p>
<p>
    Первая проблема решается с помощью свойства clear. В примере на скрине выше допустим мы не хотим, чтобы второй абзац обтекал изображение. Следовательно, очищать обтекание мы должны у него.
</p>
<p><"p style="clear:left;">Здесь может …</"p></p>

<img src="/images/services/snow/1.jpg" alt="ktor logo" 
    width="100" height="100" 
    style="float:left; padding-right:15px;">
<p>
    Бывает, что маленькие картинки предпочитают обтекать текстом слева или справа. Для этого используют свойство float со значением left или right. В случае float: left элемент будет "уплывать" налево. Другие элементы будут оказываться справа от него.
</p>
<p style="clear:left;">
    Здесь может потребоваться решать две проблемы:
</p>
<img src="/images/services/snow/1.jpg" alt="ktor logo" 
    width="100" height="100" 
    style="float:right; padding-left:15px;">
<p>
    Объявление clear: left заставляет элемент перестать обтекать объекты, расположенные с левой стороны. Вариант clear: both – с обоих сторон. В нашем примере значение both дало бы тот же результат.
</p>
<p>
    Чтобы убрать обтекание изображений на малых экранах, потребуется использовать @media-запрос, в котором значения свойств будут меняться. Однако если мы до этого оформляли элемент через атрибут style тега, то такой inline-стиль (строчный) имеет приоритет над внешней или внутренней таблицей стилей.
</p>
<p>
    Поэтому в нашем случае понадобится использовать команду !impotant:
</p>
<p>
    @media (max-width: 599px) {
        img {
            float: none!important;
            padding: 0!important;
            display: block;
            margin: 0 auto;
            max-width: 100%;
            height: auto;
        }
    }
</p>
<img src="/images/services/snow/1.jpg" alt="ktor logo"
    width="100" height="100" >
<p>
    Бывает, что маленькие картинки предпочитают обтекать текстом слева или справа. Для этого используют свойство float со значением left или right. В случае float: left элемент будет "уплывать" налево. Другие элементы будут оказываться справа от него.
</p>
<p>
    Здесь может потребоваться решать две проблемы:
</p>
<img src="/images/services/snow/1.jpg" alt="ktor logo"
    width="100" height="100" >
<p>
    Бывает, что маленькие картинки предпочитают обтекать текстом слева или справа. Для этого используют свойство float со значением left или right. В случае float: left элемент будет "уплывать" налево. Другие элементы будут оказываться справа от него.
</p>
<p>
    Здесь может потребоваться решать две проблемы:
</p>
<p>
    ...
</p>
<p>
    Когда на странице несколько изображений оформляются по-разному, то inline-стили могут выглядеть предпочтительными. Если же можно выделить несколько групп изображений, каждая из которых стилизуется по-своему, следует задуматься об использовании классов.
</p>
</article>  -->

</#if>
</@layout.main_layout>