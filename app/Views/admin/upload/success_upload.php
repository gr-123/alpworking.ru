<?php
/**
 * @var CodeIgniter\View\View $this
*/
?>
<?= $this->extend('admin/dashboard/layout'); ?>
<?= $this->section('content'); ?>

<?php $validation =  \Config\Services::validation(); ?>

<p><?= anchor('admin/image/upload', 'Загрузить другие файлы!') ?></p>
<!-- echo anchor_popup('news/local/123', 'Click Me!', []); -->

<div class="container py-4">
  <hr>
  <div class="clear-fix py-2"></div>
  <div class="row">

    <div class="col-lg-8 col-md-6 col-sm-12 col-xs-12">
      <div class="card rounded-0 shadow">
        <div class="card-header">
          <div class="card-title h4 mb-0 fw-bolder">

            <?php if (session()->has('message')) {
              echo esc(session()->getFlashdata('message'));
            } ?>
            <?php if (session()->getFlashdata('success')) : ?>
              <div class="alert alert-success alert-dismissible">
                <button type="button" class="btn-close" data-bs-dismiss="alert">&times;</button>
                <b><?php echo esc(session()->getFlashdata('success')) ?></b>
              </div>
            <?php endif; ?>

            Uploaded Files
          </div>
        </div>
        <div class="card-body">
          <div class="container-fluid">
            <table class="table table-striped table-bordered">
              <colgroup>
                <col width="10%">
                <col width="20%">
                <col width="50%">
                <col width="20%">
              </colgroup>
              <thead>
                <tr class="bg-primary bg-gradient text-light">
                  <th class="p-1 text-center">№</th>
                  <th class="p-1 text-center">id</th>
                  <th class="p-1 text-center">img</th>
                  <th class="p-1 text-center">name</th>
                  <th class="p-1 text-center">Action</th>
                  <th class="p-1 text-center"></th>
                </tr>
              </thead>
              <tbody>
                <?php if (isset($files) && !empty($files)) : ?>
                  <?php
                  $i = 1;
                  foreach ($files as $img) : ?>
                    <tr>
                      <td class="px-2 py-1 align-middle text-center"><?= number_format($i++) ?></td>
                      <td class="px-2 py-1 align-middle"><?= esc($img['id'], 'html') ?></td>
                      <td class="px-2 py-1 align-middle"><img src="<?= esc(base_url($thumbsDir . '/' . $img['name']), 'attr') ?>" class="img-fluid" height="150px" /></td>
                      <td class="px-2 py-1 align-middle">
                        <p class="m-0 text-truncate" title="<?= esc($img['name'], 'attr') ?>"><?= esc($img['name'], 'html') ?></p>
                      </td>
                      <td class="px-2 py-1 align-middle">
                        <p class="m-0 text-truncate" title="<?= $img['name'] ?>">
                          <a href="<?= esc(base_url('admin/image/edit/' . $img['id']), 'url') ?>" class="btn btn-success">Edit</a>
                          <a href="<?= esc(base_url('admin/image/delete/' . $img['id']), 'url') ?>" class="btn btn-danger">Delete</a>
                        </p>
                      </td>
                      <td class="px-2 py-1 align-middle text-center">
                        <!-- https://codeigniter.com/user_guide/outgoing/response.html#force-file-download -->
                        <a href="<?= esc(base_url($thumbsDir . '/' . $img['name']), 'url') ?>" class="text-primary fw-bolder text-decoration-none mx-2" target="_blank" title="Download File" download="<?= esc($thumbsDir . '/' . $img['name'], 'attr') ?>">
                          <i class="fa fa-download"></i>
                        </a>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                <?php endif; ?>
                <?php if (!isset($files) || (isset($files) && count($files) <= 0)) : ?>
                  <tr>
                    <th colspan="4" class="p-1 text-center">No records found</th>
                  </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>

<div class="form-group col-md-6">
  <label for="formGroupExampleInput">Name</label>
  <input type="file" name="file" class="form-control" id="file" onchange="readURL(this);" accept=".png, .jpg, .jpeg" />
</div>
<div class="form-group col-md-6">
  <img id="blah" src="#" class="" width="200" height="150" />
</div>
<script>
  function readURL(input, id) {
    id = id || '#blah';
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function(e) {
        $(id)
          .attr('src', e.target.result)
          .width(200)
          .height(150);
      };

      reader.readAsDataURL(input.files[0]);
    }
  }
</script>


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

<!-- как получить горизонтальные продукты в Ci4, сэр, 😶я хочу отображать их в динамической сетке на главной странице?
.container
    .row
       your foreach loop
       . col-md-4
          product details. 
      /
    endforeach;
   /
/
 -->
<?= $this->section('javascript') ?>
<!-- let a = 'a'; -->
<?= $this->endSection() ?>

<?= $this->endSection(); ?>