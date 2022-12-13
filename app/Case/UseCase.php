<?php

namespace App\Case;

use App\Models\User;

class UseCase
{
    function store($id, $name, $email, $password)
    {

        $user           = new User;
        $user->id       = $id;
        $user->name     = $name;
        $user->email    = $email;
        $user->password = $password;
        if ($name == null) {
            return array('message' => 'enter Name');
        }
        if ($email == null) {
            return array('message' => 'enter email');
        }
        if ($password == null) {
            return array('message' => 'enter password');
        }
        if ($name != null and $password != null and $email != null) {
            $user->create($user);
            return array('message' => 'user created successfully');
        }
    }
}
