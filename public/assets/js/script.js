


{/* <button onclick="deleteItem('<?php echo esc($id, 'url'); ?>')">Delete Item</button>
<script>
    function deleteItem(id) {
        if (confirm("Удалить этот элемент? '" + id + "'")) {
            document.getElementById("form1").submit();
            // GET: window.location.href="<?php echo base_url(); ?>/products/delete/" + id;

            // $(
            //     "<form method='POST' action='https://example.com'>\
            //         <input type='hidden' name='q' value='a'/>\
            //     </form>"
            // ).appendTo("body").submit();
        }

        return false;
    }
</script> */}






// 
// POST Request: XMLHttpRequest и Fetch API.
// 

// ----------------------------------------------------------------
// XMLHttpRequest:
// ----------------------------------------------------------------

// const xhr = new XMLHttpRequest();                                       // создание нового объекта XMLHttpRequest
// xhr.open("POST", "https://jsonplaceholder.typicode.com/todos");         // указание типа запроса и конечной точки (URL-адрес сервера)
// xhr.setRequestHeader("Content-Type", "application/json; charset=UTF-8") // тип данных ('application/json', 'application/x-www-form-urlencoded'm )
// // создать и сериализовать данные JSON в строковом формате перед 
// // отправкой их на веб-сервер или API с помощью метода JSON.stringify():
// const body = JSON.stringify({
//     userId: 1,
//     title: "Fix my bugs",
//     completed: false
// });
// xhr.onload = () => {
//     if (xhr.readyState == 4 && xhr.status == 201) {
//         console.log(JSON.parse(xhr.responseText));
//     } else {
//         console.log(`Error: ${xhr.status}`);
//     }
// };
// xhr.send(body);

// Или тоже:

// ----------------------------------------------------------------
// Fetch API:
// ----------------------------------------------------------------

// fetch("https://jsonplaceholder.typicode.com/todos", {
//     method: "POST",
//     // body: new FormData(document.getElementById("inputform")),
//     // -- or --
//     // body : JSON.stringify({
//     //     user : document.getElementById('user').value,
//     //     ...
//     // })
//     body: JSON.stringify({
//         userId: 1,
//         title: "Fix my bugs",
//         completed: false
//     }),
//     headers: {
//         "Content-type": "application/json; charset=UTF-8"
//     }
// })
// .then(
//     (response) => response.json()
//     // (response) => response.text()
//     // same as function(response) {return response.text();}
// )
// .then(
//     (json) => console.log(json)
//     // html => console.log(html)
// );










// /**
//  * отправляет запрос на указанный URL из формы (перенаправить браузер на новый URL-адрес, указанный действием)
//  * @param {string} path путь для отправки запроса
//  * @param {object} params параметры, добавляемые в URL-адрес
//  * @param {string} [enctype=multipart/form-data] тип данных формы
//  * @param {string} [method=post] метод, используемый в форме
//  */

// function postForm(path, params, enctype, method) {
//     enctype = enctype || 'multipart/form-data';
//     method  = method  || 'post';

//     var form = document.createElement('form');
//     form.setAttribute('action',  path);
//     form.setAttribute('enctype', enctype);
//     form.setAttribute('method',  method);

//     for (var key in params) {
//         if (params.hasOwnProperty(key)) {
//             var hiddenField = document.createElement('input');
//             hiddenField.setAttribute('type', 'hidden');
//             hiddenField.setAttribute('name', key);
//             hiddenField.setAttribute('value', params[key]);

//             form.appendChild(hiddenField);
//         }
//     }

//     document.body.appendChild(form);
//     form.submit();
// }

// postForm('mysite.com/form', {
//     arg1: 'value1',
//     arg2: 'value2'
// });

// CSRF
// «Запрещено (403). Проверка CSRF не удалась. Запрос прерван.», 
// если создать форму с нуля. В этом случае вы должны передать токен csrf следующим образом: 
// post('/contact/', {name: 'Johnny Bravo', csrfmiddlewaretoken: $("#csrf_token").val()});

// Если вы хотите, чтобы этот пост появился в новой вкладке: 
// var tabWindowId = window.open('about:blank', '_blank');     
// var form = tabWindowId.document.createElement("form");     
// tabWindowId.document.body.appendChild(form);