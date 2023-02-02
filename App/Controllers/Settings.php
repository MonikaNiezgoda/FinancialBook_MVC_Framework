<?php

namespace App\Controllers;

use \Core\View;
use \App\Flash;
use \App\Auth;
use \App\Models\UserIncomes;
use \App\Models\UserExpenses;

class Settings extends Authenticated
{
    public function newAction()
    {
        $this->requireLogin();
        $user = Auth::getUser();
        $expensesCategories = (UserExpenses::findAllExpensesCat($user->id));
        $user = Auth::getUser();
        $incomesCategories = (UserIncomes::findAllIncomesCat($user->id));

        View::renderTemplate('Settings/new.html',[
            'incomes'=>$incomesCategories,
            'expenses'=>$expensesCategories
        ]);
    }

}

?>