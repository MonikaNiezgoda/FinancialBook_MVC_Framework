<?php

namespace App\Controllers;

use \Core\View;
use \App\Flash;
use \App\Auth;
use \App\Models\UserIncomes;
use \App\Models\UserExpenses;

class Balance extends Authenticated
{
    public function newAction()
    {
        $this->requireLogin();
        View::renderTemplate('Balance/new.html');
    }

    public function createAction()
    {
        $this->requireLogin();

        $expenses = new UserExpenses($_POST);
        $incomes = new UserIncomes($_POST);

        $user = Auth::getUser();

        $allExpenses = $expenses->getExpenses($user->id);
        $allIncomes = $incomes->getIncomes($user->id);

            View::renderTemplate('Balance/create.html',[
                'expenses'=>$allExpenses,
                'sum_expenses'=>$expenses->sumExpenses($allExpenses),
                'incomes'=>$allIncomes,
                'sum_incomes'=>$incomes->sumIncomes($allIncomes),
                'balance'=>$this->checkDate()

            ]);
        
    }

    public function checkDate()
    {
        if(isset($_POST['currentMonth']))
        return "z bieżącego miesiąca";
        if(isset($_POST['previousMonth']))
        return "z poprzedniego miesiąca";
        if(isset($_POST['currentYear']))
        return "z bieżącego roku";

    }

}