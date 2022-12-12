<?php

namespace App\Controllers;

use \Core\View;
use \App\Auth;
use \App\Models\UserIncomes;

class Income extends Authenticated
{
    public function createAction()
    {
        $user = Auth::getUser();
        View::renderTemplate('Income/create.html',[
            'incomes_categories'=>UserIncomes::findAllIncomesCat($user->id)
        ]);
    }

    public function addAction()
    {
        Flash::addMessage('Dodanie przychodu się powiodło.');
        $this-> redirect('/income/create');
    }
}
