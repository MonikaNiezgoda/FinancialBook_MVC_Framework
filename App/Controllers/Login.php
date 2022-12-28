<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\User;
use \App\Auth;
use \App\Flash;

/**
 * Login controller
 *
 * PHP version 7.0
 */
class Login extends \Core\Controller
{

    /**
     * Show the login page
     *
     * @return void
     */
    public function newAction()
    {
        View::renderTemplate('Login/new.html');
    }

    /**
     * Log in a user
     *
     * @return void
     */
    public function createAction()
    {
        
        $user = User::authenticate($_POST['email'], $_POST['password']);
        
        if ($user) {

            Auth::login($user);
            Flash::addMessage('Logowanie się powiodło.');

            $this -> redirect('/menu/main');

        } else {
            Flash::addMessage('Logowanie nieudane, spróbuj ponownie', Flash::WARNING);

            View::renderTemplate('Login/new.html');
        
        }
    }

    /**
     * Log out a user
     *
     * @return void
     */
    public function destroyAction()
    {
        Auth::logout();

        $this->redirect('/login/show-logout-message');
    }

    public function showLogoutMessageAction()
    {
        Flash::addMessage('Wylogowanie się powiodło.');

        $this->redirect('/');
    }
}
