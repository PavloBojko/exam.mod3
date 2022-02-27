<?php
$this->layout('layout', ['title' => 'Edit']);
d($user);
?>
<main id="js-page-content" role="main" class="page-content mt-3">
    <div class="subheader">
        <h1 class="subheader-title">
            <i class='subheader-icon fal fa-image'></i> Загрузить аватар
        </h1>
    </div>
    <form action="/logic" method="POST" enctype="multipart/form-data">
        <div class="row">
            <div class="col-xl-6">
                <div id="panel-1" class="panel">
                    <div class="panel-container">
                        <div class="panel-hdr">
                            <h2>Текущий аватар</h2>
                        </div>
                        <div class="panel-content">
                            <div class="form-group">
                                <img src="<?php echo ($user['avatar'] == '') ? 'img/demo/authors/josh.png' : $user['avatar'] ?>" alt="avatar" class="img-responsive" width="200">
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="example-fileinput">Выберите аватар</label>
                                <input type="file" id="example-fileinput" class="form-control-file" name="avatar">
                            </div>
                            <input type="hidden" value="<?php echo $user['user_id'] ?>" name="user_id">
                            <input type="hidden" value="<?php echo $user['id'] ?>" name="id">
                            <input type="hidden" value="<?php echo $user['avatar'] ?>" name="avatar">
                            <div class="col-md-12 mt-3 d-flex flex-row-reverse">
                                <button class="btn btn-warning" value="avatar" name="output">Загрузить</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</main>