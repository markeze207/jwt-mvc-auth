<?php

namespace App\Http\Controllers;

use App\Http\Models\Auth;
use App\Http\Models\Profile;
use App\RMVC\Route\Route;
use App\RMVC\View\View;

class ProfileControllers
{
    public function index()
    {
        if(!Auth::checkLogged()) {
            Route::redirect('/auth');
        }

        return View::view('profile.index');
    }

    public function check()
    {
        $data = json_decode(file_get_contents("php://input"));

        $validateJWT = Profile::validateJWT($data->jwt);

        if($validateJWT)
        {
            // Код ответа
            http_response_code(200);

            // Покажем детали
            echo json_encode(array(
                "message" => "Success",
                "data" => $validateJWT->data
            ));
        } else {
            // Код ответа
            http_response_code(401);

            // Сообщим пользователю что ему отказано в доступе и покажем сообщение об ошибке
            echo json_encode(array(
                "message" => "error",
            ));
        }
    }
}