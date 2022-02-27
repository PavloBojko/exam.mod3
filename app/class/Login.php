<?php 
namespace App\Clas;

use Delight\Auth\Auth;
use Tamtamchik\SimpleFlash\Flash;

class Login {
    private $auth;
    private $flash;

    public function __construct(Auth $auth, Flash $flash) {
        $this->auth = $auth;
        $this->flash = $flash;
    }
    public function login( $var = null)
    {
        try {
            $this->auth->login($_POST['email'], $_POST['password']);
            $this->flash->success("User <strong>{$_POST['email']}</strong> is logged in");
            header('Location: /');
        }
        catch (\Delight\Auth\InvalidEmailException $e) {
            $this->flash->error('Wrong email address');
            header('Location: /login');
        }
        catch (\Delight\Auth\InvalidPasswordException $e) {
            $this->flash->error('Wrong password');
            header('Location: /login');
        }
        catch (\Delight\Auth\EmailNotVerifiedException $e) {
            $this->flash->error('Email not verified');
            header('Location: /login');
        }
        catch (\Delight\Auth\TooManyRequestsException $e) {
            $this->flash->error('Too many requests');
            header('Location: /login');
        }
    }


}