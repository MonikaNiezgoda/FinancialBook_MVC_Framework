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
        View::renderTemplate('Settings/new.html');
    }

    public function expensesAction()
    {  
        $user = Auth::getUser();
        echo json_encode(UserExpenses::findAllExpensesCat($user->id));
       
    }
    public function incomesAction()
    {  
        $user = Auth::getUser();
        echo json_encode(UserIncomes::findAllIncomesCat($user->id));
       
    }
}

?>