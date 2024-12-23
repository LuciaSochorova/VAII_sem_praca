<?php

namespace App\Controllers;

use App\Config\Configuration;
use App\Core\AControllerBase;
use App\Core\Responses\Response;
use App\Core\Responses\ViewResponse;
use App\Models\Role;
use App\Models\User;

/**
 * Class AuthController
 * Controller for authentication actions
 * @package App\Controllers
 */
class AuthController extends AControllerBase
{
    /**
     *
     * @return Response
     */
    public function index(): Response
    {
        return $this->redirect(Configuration::LOGIN_URL);
    }

    /**
     * Login a user
     * @return Response
     */
    public function login(): Response
    {
        $formData = $this->app->getRequest()->getPost();
        $logged = null;
        if (isset($formData['submit'])) {
            $logged = $this->app->getAuth()->login($formData['login'], $formData['password']);
            if ($logged) {
                return $this->redirect($this->url("home.index"));
            }

        }

        $data = ($logged === false ? ['message' => 'Zlý login alebo heslo!'] : []);
        return $this->html($data);
    }

    /**
     * Logout a user
     * @return ViewResponse
     */
    public function logout(): Response
    {
        $this->app->getAuth()->logout();
        return $this->redirect($this->url("home.index")) ;
    }

    public function signin(): Response {
        $formData = $this->app->getRequest()->getPost();
        $message = "";
        $data =[];
        if (isset($formData['email']) && isset($formData['password1']) && isset($formData['password2'])) {
            if(empty(User::getAll("`email`=?", [$formData['email']]))) {
                if ($formData['password1'] === $formData['password2']) {
                    $user = new User();
                    $email = filter_var($formData['email'], FILTER_VALIDATE_EMAIL);
                    if ($email) {
                        $user->setEmail($email);
                        $password = trim(strip_tags($formData['password1']));
                        if (strlen($password) >= 6) {
                            $user->setPasswordHash(password_hash($formData['password1'], PASSWORD_DEFAULT));
                            $user->setRole(Role::USER);
                            $user->save();
                            $logged = $this->app->getAuth()->login($formData['email'], $formData['password1']);
                            return $this->redirect($this->url("home.index"));
                        } else {
                            $message = "Heslo musí mať aspoň 6 znakov!";
                        }

                    } else {
                        $message = "Nevalidný email";

                    }


                } else {
                    $message = "Zadané heslá sa nezhodujú. Prosím, skúste to znova.";
                }

            } else {
                $message = "Emailová adresa sa už používa";
            }

            $data["email"] = $formData['email'];
        }

        $data["message"] = $message;
        return $this->html($data);
    }
}
