<?php

namespace App\Clas;

use Delight\Auth\Auth;
use Tamtamchik\SimpleFlash\Flash;
use App\Clas\QueryBuilder;

class Create_user
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
    public function create_user($var = null)
    {
        if (!$this->auth->isLoggedIn() || !$this->auth->hasRole(\Delight\Auth\Role::ADMIN)) {
            header('location: /login');
        }
        try {
            $userId = $this->auth->register($_POST['email'], $_POST['password'], $_POST['username'], function ($selector, $token) {
                // $this->mail->login_mail($_POST['email'], $selector, $token);
                // $this->flash->success("подтвердите почту <strong>{$_POST['email']}</strong> selector- {$selector} token- {$token} зарегистрирован
                // <hr>");
            });
            $typ = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION); //расширение файла
            $filName = uniqid(); //сгенерированное имя
            $way = "./img/avatar/{$filName}.$typ"; //Новое имя и полный путь
            move_uploaded_file($_FILES['avatar']['tmp_name'], $way);
            $avatar = $_FILES['avatar']['name']=='' ? '' : $way;
            $full = [
                'user_id' => $userId,
                'name' => $_POST['name'],
                'avatar' => $avatar,
                'work' => $_POST['work'],
                'tel' => $_POST['tel'],
                'adres' => $_POST['adres'],
                'status' => $_POST['status']
            ];
            $social = [
                'user_id' => $userId,
                'telegram' => $_POST['telegram'],
                'instagram' => $_POST['instagram'],
                'vk' => $_POST['vk']
            ];

            $this->queryBuilder->Insert($full, 'full_info_user');

            $this->queryBuilder->Insert($social, 'social_links');

            $this->flash->success("User <strong>{$_POST['email']}</strong> c id-{$userId}  успешно создан");
            header('Location: /');
            
        } catch (\Delight\Auth\InvalidEmailException $e) {
            $this->flash->error('Invalid email address');
            header('Location: /create_user');
        } catch (\Delight\Auth\InvalidPasswordException $e) {
            $this->flash->error('Invalid password');
            header('Location: /create_user');
        } catch (\Delight\Auth\UserAlreadyExistsException $e) {
            $this->flash->error("<strong>Уведомление!</strong> Этот эл. адрес уже занят другим пользователем.");
            header('Location: /create_user');
        } catch (\Delight\Auth\TooManyRequestsException $e) {
            $this->flash->error('Too many requests');
            header('Location: /create_user');
        }
    }
}
