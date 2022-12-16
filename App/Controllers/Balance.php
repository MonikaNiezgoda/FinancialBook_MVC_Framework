<?php

namespace App\Controllers;

use \Core\View;
use \App\Flash;
use \App\Auth;
use \App\Models\UserIncomes;
use \App\Models\UserExpenses;

class Balance extends \Core\Controller
{
    public function newAction()
    {
        $this->requireLogin();
        View::renderTemplate('Balance/new.html');
    }

    public function createAction()
    {
        $this->requireLogin();

        $incomes = new UserIncomes($_POST);

        $expenses = new UserExpenses($_POST);

        $user = Auth::getUser();

        $allExpenses = $expenses->getExpenses($user->id);
        $allIncomes = $incomes->getIncomes($user->id);

            View::renderTemplate('Balance/create.html',[
                'expenses'=>$allExpenses,
                'sum_expenses'=>$expenses->sumExpenses($allExpenses),
                'incomes'=>$allIncomes,
                'sum_incomes'=>$incomes->sumIncomes($allIncomes)

            ]);
        
    }

}