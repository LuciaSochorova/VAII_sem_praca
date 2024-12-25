<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\Responses\Response;
use App\Models\User;

class ProfileController extends AControllerBase
{
    public function authorize(string $action)
    {
        return $this->app->getAuth()->isLogged();
    }


    /**
     * @inheritDoc
     */
    public function index(): Response
    {
        return $this->html(["email" => $this->app->getAuth()->getLoggedUserName(), "role" =>$this->app->getAuth()->getLoggedUserContext()["role"]]);
    }

    public function delete(): Response {
        $user = User::getOne($this->app->getAuth()->getLoggedUserId());
        $this->app->getAuth()->logout();
        $user->delete();
        return $this->redirect($this->url("home.index"));
    }


}