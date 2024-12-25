<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\HTTPException;
use App\Core\Responses\EmptyResponse;
use App\Core\Responses\Response;
use App\Models\User;

class PasswordApiController extends AControllerBase
{

    /**
     * @inheritDoc
     * @throws HTTPException
     */
    public function index(): Response
    {
        throw new HTTPException(501, "Not implemented");
    }

    /**
     * @throws HTTPException
     * @throws \JsonException
     */
    public function change(): Response {
        $json = $this->app->getRequest()->getRawBodyJSON();
        if (
            is_object($json)
            && property_exists($json, 'currentPassword')
            && property_exists($json, 'newPassword')
            && property_exists($json, 'confirmPassword')
        ) {
            $loggedUser = User::getOne($this->app->getAuth()->getLoggedUserId());
            if(password_verify($json->currentPassword, $loggedUser->getPasswordHash())) {
                if ($json->newPassword === $json->confirmPassword) {
                        $password = trim(strip_tags($json->newPassword));
                        if (strlen($password) >= 6) {
                            $loggedUser->setPasswordHash(password_hash($json->newPassword, PASSWORD_DEFAULT));
                            $loggedUser->save();
                            return new EmptyResponse();
                        } else {
                            throw new HTTPException(422, "Password is too short");
                        }


                } else {
                    throw new HTTPException(422, "Password mismatch");
                }

            } else {
                throw new HTTPException(422, "Wrong password");

            }

        } else {
            throw new HTTPException(400,);
        }

    }
}