<?php

namespace App\Controllers;

use \Core\View;
use \App\Auth;
use \App\Flash;
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
        $user = Auth::getUser();
        $income = new UserIncomes($_POST);
        $income->save($user->id);

        Flash::addMessage('Przychód został dodany.');
        $this-> redirect('/income/create');
    }
}
