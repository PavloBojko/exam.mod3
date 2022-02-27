<?php

namespace App\controllers;

use App\controllers\HomController;
use Delight\Auth\Auth;
use Tamtamchik\SimpleFlash\Flash;
use League\Plates\Engine;
use App\Clas\Mail;
use App\Clas\QueryBuilder;

class RequestHandler extends HomController
{

    private $auth;
    private $flash;
    private $queryBuilder;

    public function __construct(Auth $auth, Flash $flash, QueryBuilder $queryBuilder)
    {
        $this->auth = $auth;
        $this->flash = $flash;
        $this->queryBuilder = $queryBuilder;
    }

    public function verificationmail($var = null)
    {
        try {
            $this->auth->confirmEmail($_GET['selector'], $_GET['token']);
            $this->flash->success("Email address has been verified");
            header('Location: /login');
        } catch (\Delight\Auth\InvalidSelectorTokenPairException $e) {
            $this->flash->error('Invalid token');
            header('Location: /login');
        } catch (\Delight\Auth\TokenExpiredException $e) {
            $this->flash->error('Token expired');
            header('Location: /login');
        } catch (\Delight\Auth\UserAlreadyExistsException $e) {
            $this->flash->error('Email address already exists');
            header('Location: /login');
        } catch (\Delight\Auth\TooManyRequestsException $e) {
            $this->flash->error('Too many requests');
            header('Location: /login');
        }
    }
    public function dell($vars = null)
    {
        if (!$this->auth->isLoggedIn()) {
            header('location: /login');
            exit;
        }
        if (!$this->auth->hasRole(\Delight\Auth\Role::ADMIN)) {
            if ($vars['id'] != $this->auth->getUserId()) {
                $this->flash->success("Можно Удалить только свой профиль");
                header('location: /');
            }
        }
        $where = 'user_id';
        $result = $this->queryBuilder->get_($vars['id'], 'full_info_user', $where, ['avatar', 'id']);

        $result1 = $this->queryBuilder->get_($vars['id'], 'social_links', $where, ['id']);
        // d($result);
        // d($result1);

        // die;
        unlink($result[0]['avatar']);

        $this->queryBuilder->delete($result[0]['id'], 'full_info_user');
        $this->queryBuilder->delete($result1[0]['id'], 'social_links');

        try {
            $this->auth->admin()->deleteUserById($vars['id']);
        }
        catch (\Delight\Auth\UnknownIdException $e) {
            die('Unknown ID');
        }
        $this->flash->success("Пользователь Удален");
        header("Location: /");

    }
}
