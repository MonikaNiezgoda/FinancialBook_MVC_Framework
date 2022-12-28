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
        $sumIncomes=$incomes->sumIncomes($allIncomes);
        $dataIncomesPoints = array();
        foreach($allIncomes as $dataIncomes){
        $dataIncomesPoints[]= array("label"=>$dataIncomes['name'], "y"=>$dataIncomes['sum']);}
        $dataExpensesPoints = array();
        foreach($allExpenses as $dataExpenses){
        $dataExpensesPoints[]= array("label"=>$dataExpenses['name'], "y"=>$dataExpenses['sum']);}

            View::renderTemplate('Balance/create.html',[
                'expenses'=>$allExpenses,
                'sum_expenses'=>$expenses->sumExpenses($allExpenses),
                'incomes'=>$allIncomes,
                'sum_incomes'=>$sumIncomes,
                'balance'=>$this->checkDate(),
                'dataIncomesPoints'=>$dataIncomesPoints,
                'dataExpensesPoints'=>$dataExpensesPoints
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
        if (isset($_POST['dataOd']))
        {
            $dataOd= $_POST['dataOd'];
		    $dataDo= $_POST['dataDo'];
            return "od $dataOd do $dataDo";
        }
    }

}