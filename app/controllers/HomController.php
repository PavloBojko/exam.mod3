<?php

namespace App\controllers;

use App\Clas\AddMethods;
use Delight\Auth\Auth;
use League\Plates\Engine;
use App\Clas\QueryBuilder;
use Tamtamchik\SimpleFlash\Flash;


class HomController
{
    private $templates;
    private $auth;
    private $queryBuilder;
    private $flash;
    private $addMethods;

    public function __construct(Engine $templates, Auth $auth, QueryBuilder $queryBuilder, Flash $flash, AddMethods $addMethods)
    {
        $this->addMethods = $addMethods;
        $this->templates = $templates;
        $this->auth = $auth;
        $this->queryBuilder = $queryBuilder;
        $this->flash = $flash;
    }
    public function users($var = null)
    {
        if (!$this->auth->isLoggedIn()) {
            header('Location: /login');
        }
        $result1 = $this->queryBuilder->get_ALL('users', ['id', 'email']);
        $result2 = $this->queryBuilder->get_ALL('full_info_user');
        $result = [$result1, $result2];

        $user[0] = $this->addMethods->combinedArray($result1, $result2);

        if ($this->auth->hasRole(\Delight\Auth\Role::ADMIN)) {
            $user[] = ['admin' => true];
        } else {
            $user[] = ['admin' => false];
        }

        $id = $this->auth->getUserId();
        $user[] = ['id' => $id];
        echo $this->templates->render('users', ['users' => $user]);
    }
    
    public function register($var = null)
    {
        echo $this->templates->render('register', ['name' => 'Jonathan']);
    }

    public function login($var = null)
    {
        echo $this->templates->render('login', ['name' => 'Jonathan']);
    }

    public function editUser($vars = null)
    {
        if (!$this->auth->isLoggedIn()) {
            header('location: /login');
            exit;
        }
        if (!$this->auth->hasRole(\Delight\Auth\Role::ADMIN)) {
            if ($vars['id'] != $this->auth->getUserId()) {
                $this->flash->success("Можно редактировать только свой профиль");
                header('location: /');
            }
        }
        $where = 'user_id';
        $result2 = $this->queryBuilder->get_($vars['id'], 'full_info_user', $where);

        echo $this->templates->render('edit', ['user' => $result2[0]]);
    }

    public function createUser($var = null)
    {
        if (!$this->auth->isLoggedIn() || !$this->auth->hasRole(\Delight\Auth\Role::ADMIN)) {

            header('location: /login');
        }
        $result = $this->queryBuilder->get_ALL('status');
        // d($result);die;
        echo $this->templates->render('create_user', ['status' => $result]);
    }

    public function profile($vars = null)
    {
        if (!$this->auth->isLoggedIn()) {
            header('location: /login');
            exit;
        }
        $where = 'user_id';
        $result1 = $this->queryBuilder->get_($vars['id'], 'full_info_user', $where);

        $where = 'id';
        $result2 = $this->queryBuilder->get_($vars['id'], 'users', $where, ['email']);

        $result = array_merge($result1[0], $result2[0]);

        echo $this->templates->render('profile', ['user' => $result]);
    }

    public function security($vars = null)
    {
        if (!$this->auth->isLoggedIn()) {
            header('location: /login');
            exit;
        }
        if (!$this->auth->hasRole(\Delight\Auth\Role::ADMIN)) {
            if ($vars['id'] != $this->auth->getUserId()) {
                $this->flash->success("Можно редактировать только свой профиль");
                header('location: /');
            }
        }
        $where = 'id';
        $result = $this->queryBuilder->get_($vars['id'], 'users', $where);
        d($result);
        echo $this->templates->render('security', ['user' => $result[0]]);
    }

    public function status($vars = null)
    {
        if (!$this->auth->isLoggedIn()) {
            header('location: /login');
            exit;
        }
        if (!$this->auth->hasRole(\Delight\Auth\Role::ADMIN)) {
            if ($vars['id'] != $this->auth->getUserId()) {
                $this->flash->success("Можно редактировать только свой профиль");
                header('location: /');
            }
        }
        $result = $this->queryBuilder->get_ALL('status');
        $where = 'user_id';
        $result1 = $this->queryBuilder->get_($vars['id'], 'full_info_user', $where, ['status', 'id']);
        $user = [$result, $result1[0], $vars['id']];

        echo $this->templates->render('status', ['user' => $user]);
    }

    public function media($vars = null)
    {
        if (!$this->auth->isLoggedIn()) {
            header('location: /login');
            exit;
        }
        if (!$this->auth->hasRole(\Delight\Auth\Role::ADMIN)) {
            if ($vars['id'] != $this->auth->getUserId()) {
                $this->flash->success("Можно редактировать только свой профиль");
                header('location: /');
            }
        }
        $where = 'user_id';
        $result = $this->queryBuilder->get_($vars['id'], 'full_info_user', $where, ['avatar', 'id', 'user_id']);
        echo $this->templates->render('media', ['user' => $result[0]]);
    }
}
