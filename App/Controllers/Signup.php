<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\User;
use \App\Flash;
use \App\Models\Income;

/**
 * Signup controller
 *
 * PHP version 7.0
 */
class Signup extends \Core\Controller
{

    /**
     * Show the signup page
     *
     * @return void
     */
    public function newAction()
    {
        View::renderTemplate('Signup/new.html');
    }

    /**
     * Sign up a new user
     *
     * @return void
     */
    public function createAction()
    {
        $user = new User($_POST);

        if ($user->save()) {

            $incomesCat = new Income();

            $users=$user->findByEmail($_POST['email']);

            $incomesCat->addDefaultIncomesCat($users->id);
            $incomesCat->findAllIncomesCat($users->id);

            $this->redirect('/signup/success');

        } else {

            View::renderTemplate('Signup/new.html', [
                'user' => $user
            ]);

        }
    }

    /**
     * Show the signup success page
     *
     * @return void
     */
    public function successAction()
    {
        Flash::addMessage('Rejestracja zakończyła się powodzeniem', Flash::WARNING);
        View::renderTemplate('Home/index.html');
    }
}
