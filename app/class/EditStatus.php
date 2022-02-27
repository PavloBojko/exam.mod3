<?php

namespace App\Clas;

use Tamtamchik\SimpleFlash\Flash;
use App\Clas\QueryBuilder;

class EditStatus
{


    private $flash;
    private $queryBuilder;

    public function __construct(Flash $flash, QueryBuilder $queryBuilder)
    {
        $this->flash = $flash;
        $this->queryBuilder = $queryBuilder;
    }
    public function editStatus($var = null)
    {
        $this->queryBuilder->update(['status' => $_POST['status']], $_POST['id'], 'full_info_user');
        $this->flash->success("Статус  обновлен");
        header("Location: /profile/{$_POST['user_id']}");
    }
}
