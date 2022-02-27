<?php
$this->layout('layout', ['title' => 'Status']);
?>

<h1>Users</h1>
<p>Hello, <?= $this->e($name) ?></p>



<main id="js-page-content" role="main" class="page-content mt-3">
    <div class="subheader">
        <h1 class="subheader-title">
            <i class='subheader-icon fal fa-sun'></i> Установить статус
        </h1>

    </div>
    <form action="/logic" method="POST">
        <div class="row">
            <div class="col-xl-6">
                <div id="panel-1" class="panel">
                    <div class="panel-container">
                        <div class="panel-hdr">
                            <h2>Установка текущего статуса</h2>
                        </div>
                        <div class="panel-content">
                            <div class="row">
                                <div class="col-md-4">
                                    <!-- status -->
                                    <div class="form-group">
                                        <label class="form-label" for="example-select">Выберите статус</label>
                                        <select class="form-control" id="example-select" name="status">
                                            <?php
                                            foreach ($user[0] as $key => $value) {
                                            ?>
                                                <option value='<?php echo $value['id'] ?>' <?php echo $value['id'] == $user[1]['status'] ? 'selected' : '' ?>><?php echo $value['name_status'] ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <input type="hidden" value="<?php echo $user[2] ?>" name="user_id">
                                <input type="hidden" value="<?php echo $user[1]['id'] ?>" name="id">

                                <div class="col-md-12 mt-3 d-flex flex-row-reverse">
                                    <button class="btn btn-warning" value="status" name="output">Set Status</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </form>
</main>