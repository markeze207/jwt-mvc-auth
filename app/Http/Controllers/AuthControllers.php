<?php

namespace App\Http\Controllers;

use App\Http\Models\Auth;
use App\RMVC\Route\Route;
use App\RMVC\View\View;

class AuthControllers
{
    public function index()
    {
        if(Auth::checkLogged())
        {
            Route::redirect('/profile');
        }

        return View::view('auth.index');
    }

    public function auth()
    {
        $data = json_decode(file_get_contents("php://input"));

        if(isset($data->submitLogin))
        {

            $email = $data->email;
            $password = $data->password;

            $userId = Auth::checkUserData($email, $password);

            if(!$userId)
            {
                http_response_code(401);

                // Скажем пользователю что войти не удалось
                echo json_encode(array("message" => "error login"));

            } else {
                http_response_code(200);
                echo json_encode(
                    array(
                        "message" => 'success',
                        "jwt" => Auth::auth($userId)
                    )
                );

            }

        }
    }
}