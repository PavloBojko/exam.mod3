<?php

namespace App\Clas;

class AddMethods
{

    public function StatusCheck($status)
    {
        switch ($status) {
            case '1':
                return 'success';
                break;
            case '2':
                return 'warning';
                break;
            case '3':
                return 'danger';
                break;
            default:
                return 'danger';
                break;
        }
    }
    public function upload_avatar($tmp, $name, $id)
    {
        $typ = pathinfo($name, PATHINFO_EXTENSION); //расширение файла
        $filName = uniqid(); //сгенерированное имя
        $way = "img/avatar/{$filName}.$typ"; //Новое имя и полный путь
        move_uploaded_file($tmp, $way);
    }

    public function combinedArray($arrUserInfo, $arrUserFullInfo)
    {
        $combinedArray = [];
        foreach ($arrUserInfo as $key => $value1) {
            foreach ($arrUserFullInfo as $key => $value2) {
                if ($value1['id']==$value2['user_id']) {
                    $combinedArray[] = array_merge($value1, $value2);
                }
            }
        }
        return $combinedArray;
    }
}
