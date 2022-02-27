<?php

namespace App\Clas;

use Delight\Auth\Auth;
use App\Clas\Mail;
use Tamtamchik\SimpleFlash\Flash;
use App\Clas\QueryBuilder;



class Register
{
    private $auth;
    private $mail;
    private $flash;
    private $queryBuilder;

    public function __construct(Auth $auth, Mail $mail, Flash $flash, QueryBuilder $queryBuilder)
    {
        $this->auth = $auth;
        $this->mail = $mail;
        $this->flash = $flash;
        $this->queryBuilder = $queryBuilder;
    }
    public function register($var = null)
    {
        try {
            $userId = $this->auth->register($_POST['email'], $_POST['password'], $_POST['username'], function ($selector, $token) {
                $this->mail->login_mail($_POST['email'], $selector, $token);

                $this->flash->success("подтвердите почту <strong>{$_POST['email']}</strong> selector- {$selector} token- {$token} зарегистрирован
                <hr>");
            });

            $this->queryBuilder->Insert(['user_id' => $userId], 'full_info_user');

            $this->queryBuilder->Insert(['user_id' => $userId], 'social_links');
            

            $this->flash->success("User <strong>{$_POST['email']}</strong> c id-{$userId}  зарегистрирован");
            header('Location: /login');
        } catch (\Delight\Auth\InvalidEmailException $e) {
            $this->flash->error('Invalid email address');
            header('Location: /register');
        } catch (\Delight\Auth\InvalidPasswordException $e) {
            $this->flash->error('Invalid password');
            header('Location: /register');
        } catch (\Delight\Auth\UserAlreadyExistsException $e) {
            $this->flash->error("<strong>Уведомление!</strong> Этот эл. адрес уже занят другим пользователем.");
            header('Location: /register');
        } catch (\Delight\Auth\TooManyRequestsException $e) {
            $this->flash->error('Too many requests');
            header('Location: /register');
        }
    }
}
