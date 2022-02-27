<?php

namespace App\Clas;

use Tamtamchik\SimpleFlash\Flash;
use App\Clas\QueryBuilder;

class Edit_genInfo
{
    private $queryBuilder;
    private $flash;

    public function __construct(QueryBuilder $queryBuilder, Flash $flash)
    {
        $this->queryBuilder = $queryBuilder;
        $this->flash = $flash;
    }
    public function edit_genInfo ($var = null)
    {
        $data=['name'=>$_POST['name'], 'work'=>$_POST['work'], 'tel'=>$_POST['tel'], 'adres'=>$_POST['adres']]; 
        $id=$_POST['id']; 
        $table='full_info_user';
        $this->queryBuilder->update($data, $id, $table);

        $this->flash->success("User <strong>{$_POST['email']}</strong> c id-{$_POST['id']}  успешно обновлен");
            header("Location: /profile/{$_POST['user_id']}");
        
    }
}
