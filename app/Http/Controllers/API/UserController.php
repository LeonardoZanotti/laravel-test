<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\User;

class UserController extends BaseController
{
    public function index() {
        $users = User::all();
        if($users->count() == 0) {
            return $this::sendErrorResponse('Nenhum usuário cadastrado');
        }

        return $this::sendSucessResponse($users, 'Mostrando usuários cadastrados', 200);
    }
}
