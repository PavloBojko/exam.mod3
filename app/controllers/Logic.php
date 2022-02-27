<?php

namespace App\controllers;

use App\Clas\Register;
use App\Clas\Login;
use App\Clas\Create_user;
use App\Clas\Edit_genInfo;
use App\Clas\EditStatus;
use App\Clas\Sequrity;
use App\Clas\Avatar;


class Logic
{
    private $register;
    private $login;
    private $create_user;
    private $edit_genInfo;
    private $sequrity;
    public $editStatus;
    public $avatar;


    public function __construct(Register $register, Login $login, Create_user $create_user, Edit_genInfo $edit_genInfo, Sequrity $sequrity, EditStatus $editStatus, Avatar $avatar)
    {
        $this->edit_genInfo = $edit_genInfo;
        $this->register = $register;
        $this->login = $login;
        $this->create_user = $create_user;
        $this->sequrity = $sequrity;
        $this->editStatus = $editStatus;
        $this->avatar = $avatar;
    }
    public function input_POST($var = null)
    {

        switch ($_POST['output']) {
            case 'register':
                // d($_POST);die;
                $this->register->register();
                break;
            case 'login':
                $this->login->login();
                break;
            case 'create_user':
                $this->create_user->create_user();
                break;
            case 'edit_generalInfo':
                $this->edit_genInfo->edit_genInfo();
                break;
            case 'sequrity':
                $this->sequrity->sequr();
                break;
            case 'status':
                $this->editStatus->editStatus();
                break;
            case 'avatar':
                $this->avatar->edit_avatar();
                break;

            default:
                # code...
        }
    }
}
