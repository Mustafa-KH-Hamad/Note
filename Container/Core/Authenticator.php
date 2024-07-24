<?php

namespace Core;

class Authenticator
{
    public function attempt($email, $password)
    {
        $user = App::resolve(Database::class)
            ->query('select * from users where email = :email', [
            'email' => $email
        ])->find();

        if ($user) {
            if (password_verify($password, $user['password'])) {
                $_SESSION['id'] = $user['id'];
                $this->login($email);

                return true;
            }
        }

        return false;
    }

    public function login($user)
    {
        $_SESSION['logged']=true ; 
        $_SESSION['user'] =$user;

        session_regenerate_id(true);
    }

    public function logout()
    {
        Session::destroy();
    }
}