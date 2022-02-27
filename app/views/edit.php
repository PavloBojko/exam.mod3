<?php
$this->layout('layout', ['title' => 'Edit']);
?>

<main id="js-page-content" role="main" class="page-content mt-3">
    <div class="subheader">
        <h1 class="subheader-title">
            <i class='subheader-icon fal fa-plus-circle'></i> Редактировать
        </h1>

    </div>
    <form action="/logic" method="POST">
        <div class="row">
            <div class="col-xl-6">
                <div id="panel-1" class="panel">
                    <div class="panel-container">
                        <div class="panel-hdr">
                            <h2>Общая информация</h2>
                        </div>
                        <div class="panel-content">
                            <!-- username -->
                            <div class="form-group">
                                <label class="form-label" for="simpleinput">Имя</label>
                                <input type="text" id="simpleinput" class="form-control" value='<?php echo $user['name'] ?>' name="name">
                            </div>

                            <!-- title -->
                            <div class="form-group">
                                <label class="form-label" for="simpleinput">Место работы</label>
                                <input type="text" id="simpleinput" class="form-control" value='<?php echo $user['work'] ?>' name="work">
                            </div>

                            <!-- tel -->
                            <div class="form-group">
                                <label class="form-label" for="simpleinput">Номер телефона</label>
                                <input type="text" id="simpleinput" class="form-control" value='<?php echo $user['tel'] ?>' name="tel">
                            </div>

                            <!-- address -->
                            <div class="form-group">
                                <label class="form-label" for="simpleinput">Адрес</label>
                                <input type="text" id="simpleinput" class="form-control" value='<?php echo $user['adres'] ?>' name="adres">
                            </div>
                            <input type="hidden" value='<?php echo $user['id'] ?>' name="id">
                            <input type="hidden" value='<?php echo $user['user_id'] ?>' name="user_id">


                            <div class="col-md-12 mt-3 d-flex flex-row-reverse">
                                <button class="btn btn-warning" value="edit_generalInfo" name="output">Редактировать</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</main>