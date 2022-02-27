<?php

namespace App\Clas;

use Delight\Auth\Auth;
use Tamtamchik\SimpleFlash\Flash;

class Sequrity
{

    private $auth;
    private $flash;

    public function __construct(Auth $auth, Flash $flash)
    {

        $this->auth = $auth;
        $this->flash = $flash;
    }
    public function sequr($var = null)
    {
        if ($_POST['password'] != $_POST['password_confirm']) {
            $this->flash->error("Пароли не совпадают");
            header("location: /security/{$_POST['id']}");
            exit;
        }


        try {
            $this->auth->admin()->changePasswordForUserById($_POST['id'], $_POST['password']);
        } catch (\Delight\Auth\UnknownIdException $e) {
            $this->flash->error("Unknown ID");
            header("Location: /security/{$_POST['id']}");
        } catch (\Delight\Auth\InvalidPasswordException $e) {
            $this->flash->error("Invalid password");
            header("Location: /security/{$_POST['id']}");
        }



        // try {
        //     $this->auth->login($_POST['email'], $_POST['password']);
        //     // $this->flash->success("User <strong>{$_POST['email']}</strong> is logged in");
        //     // header('Location: /');
        // }
        // catch (\Delight\Auth\InvalidEmailException $e) {
        //     $this->flash->error('Wrong email address');
        //     header('Location: /login');
        // }
        // catch (\Delight\Auth\InvalidPasswordException $e) {
        //     $this->flash->error('Wrong password');
        //     header('Location: /login');
        // }
        // catch (\Delight\Auth\EmailNotVerifiedException $e) {
        //     $this->flash->error('Email not verified');
        //     header('Location: /login');
        // }
        // catch (\Delight\Auth\TooManyRequestsException $e) {
        //     $this->flash->error('Too many requests');
        //     header('Location: /login');
        // }


        try {
            if ($this->auth->reconfirmPassword($_POST['password'])) {
                $this->auth->changeEmail($_POST['email'], function ($selector, $token) {
                    $this->auth->confirmEmail($selector, $token);
                });
            } else {
                echo 'We can\'t say if the user is who they claim to be';
            }
        } catch (\Delight\Auth\InvalidEmailException $e) {
            $this->flash->error("Invalid email address");
            header("Location: /security/{$_POST['id']}");
        } catch (\Delight\Auth\UserAlreadyExistsException $e) {
            $this->flash->error("Email address already exists");
            header("Location: /security/{$_POST['id']}");
        } catch (\Delight\Auth\EmailNotVerifiedException $e) {
            $this->flash->error("Account not verified");
            header("Location: /security/{$_POST['id']}");
        } catch (\Delight\Auth\NotLoggedInException $e) {
            $this->flash->error("Not logged in");
            header("Location: /security/{$_POST['id']}");
        } catch (\Delight\Auth\TooManyRequestsException $e) {
            $this->flash->error("Too many requests");
            header("Location: /security/{$_POST['id']}");
        }
        $this->auth->logOutEverywhereElse();
        $this->flash->success("Зайдите с под новими данними");
        header('Location: /login');
        d($_POST);
    }
}
