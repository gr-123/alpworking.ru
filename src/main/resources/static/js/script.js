// ограничивать область видимости скрипта, чтобы исключить конфликты с другими JS-скриптами подключенными к странице
// ;(function() {
// 	'use strict';

// })();

(function(){
    console.log("Hello FreeMarker Form!");
  })();
  

function message(msg) {
    alert(msg);
}

// 
// Remove the event listener:
// ----------------------------------------------------------------------------
// 1:
// const handler = () => { console.log('Click event...'); }
// const img = document.querySelector('img');
// img.addEventListener('click', handler, false);
// ...
// img.removeEventListener('click', handler, false);
// or 2:
// const img = document.querySelector('img');
// img.addEventListener('click', function handler(event) {
//     console.log('Click event...');
//     event.currentTarget.removeEventListener(event.type, handler);
// });
// 
