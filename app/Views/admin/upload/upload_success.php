<!DOCTYPE html>
<html lang="en">
<head>
    <title>Upload Form</title>
</head>
<body>

<h3>Your file was successfully uploaded!</h3>
<!-- https://codeigniter.com/user_guide/libraries/files.html -->
<ul>
    <li>name: <?= esc($uploaded_fileinfo->getBasename()) ?></li>
    <li>size: <?= esc($uploaded_fileinfo->getSizeByUnit('kb')) ?> KB</li>
    <li>extension: <?= esc($uploaded_fileinfo->guessExtension()) ?></li>

		<br>
		<img src="<?= base_url() ?>/public/uploads/<?= esc($uploaded_fileinfo->getBasename()) ?>" width="120">
		<br>

</ul>

<p><?= anchor('admin/image/upload', 'Upload Another File!') ?></p>
<!-- echo anchor_popup('news/local/123', 'Click Me!', []); -->

<!-- https://www.w3schools.com/jsref/met_win_open.asp
 -->
<!-- Откройте страницу about:blank в новом окне/вкладке:
<p>Click the button to open an about:blank page in a new browser window that is 200px wide and 100px tall.</p>
<button onclick="myFunction()">Try it</button>
<script>
function myFunction() {
  var myWindow = window.open("", "", "width=200,height=100");
}
</script> -->

<!-- Откройте новое окно под названием «MsgWindow» и напишите в нем текст:
 <p>Click the button to open a new window called "MsgWindow" with some text.</p>
<button onclick="myFunction()">Try it</button>
<script>
function myFunction() {
  var myWindow = window.open("", "MsgWindow", "width=200,height=100");
  myWindow.document.write("<p>This is 'MsgWindow'. I am 200px wide and 100px tall!</p>");
}
</script> -->

<!-- 
    
Откройте новое окно. Используйте close(), чтобы закрыть новое окно:

<h1>The Window Object</h1>
<h2>The open() and close() Methods</h2>
<button onclick="openWin()">Open "myWindow"</button>
<button onclick="closeWin()">Close "myWindow"</button>
<script>
let myWindow;
function openWin() {
  myWindow = window.open("", "", "width=200,height=100");
}
function closeWin() {
  myWindow.close();
}
</script> -->

<!-- Использование свойства opener для возврата ссылки на окно, создавшее новое окно:
<h1>The Window Object</h1>
<h2>The opener Property</h2>
<p id="demo">
Click the button to open a new window that writes "HELLO!" in the opener window.</p>
<button onclick="myFunction()">Try it</button>
<script>
function myFunction() {
  const myWindow = window.open("", "", "width=300,height=300");
  myWindow.opener.document.getElementById("demo").innerHTML = "HELLO!";
}
</script> -->
<?php
// $js = 'onClick="some_function ()"';
// echo form_input('username', 'johndoe', $js);
// /*
//  * Would produce:
//  * <input type="text" name="username" value="johndoe" onClick="some_function ()">
//  */
// Or you can pass it as an array:
// $js = ['onClick' => 'some_function ();'];
// echo form_input('username', 'johndoe', $js);
// /*
//  * Would produce:
//  * <input type="text" name="username" value="johndoe" onClick="some_function ();">
//  */
?>

</body>
</html>