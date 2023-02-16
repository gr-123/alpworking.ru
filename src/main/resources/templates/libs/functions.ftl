
<#--  https://freemarker.apache.org/docs/ref_directive_function.html#ref.directive.function  -->
<#function avg nums...>
  <#local sum = 0>
  <#list nums as num>
    <#local sum += num>
  </#list>
  <#if nums?size != 0>
    <#return sum / nums?size>
  </#if>
</#function>
${avg(10, 20)}
${avg(10, 20, 30, 40)}
${avg()!"N/A"}
<#--  
will print:
OUTPUT
15
25
N/A  -->