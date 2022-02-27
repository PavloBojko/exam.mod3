<?php

namespace App\Clas;

use Tamtamchik\SimpleFlash\Flash;
use App\Clas\QueryBuilder;

class Avatar
{


    private $flash;
    private $queryBuilder;

    public function __construct(Flash $flash, QueryBuilder $queryBuilder)
    {
        $this->flash = $flash;
        $this->queryBuilder = $queryBuilder;
    }
    public function edit_avatar($var = null)
    {
        $typ = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION); //расширение файла
            $filName = uniqid(); //сгенерированное имя
            $way = "./img/avatar/{$filName}.$typ"; //Новое имя и полный путь
            move_uploaded_file($_FILES['avatar']['tmp_name'], $way);
        // 
        unlink($_POST['avatar']);
        $this->queryBuilder->update(['avatar' => $way], $_POST['id'], 'full_info_user');
        $this->flash->success("Статус  обновлен");
        // d($_POST); die;
        header("Location: /profile/{$_POST['user_id']}");
    }
}