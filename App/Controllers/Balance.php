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
        $sumExpenses=$expenses->sumExpenses($allExpenses);
        $dataIncomesPoints = array();
        foreach($allIncomes as $dataIncomes){
        $dataIncomesPoints[]= array("label"=>$dataIncomes['name'], "y"=>($dataIncomes['sum']*100/$sumIncomes));}
        $dataExpensesPoints = array();
        foreach($allExpenses as $dataExpenses){
        $dataExpensesPoints[]= array("label"=>$dataExpenses['name'], "y"=>($dataExpenses['sum']*100/$sumExpenses));}

            View::renderTemplate('Balance/create.html',[
                'expenses'=>$allExpenses,
                'sum_expenses'=>$sumExpenses,
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

    public function deleteIncomeAction()
    {
        if(isset($_POST['delete_income']))
        {
            $incomes = new UserIncomes($_POST);
            $id=$_POST['delete_income'];
            $incomes->deleteIncome($id);
            Flash::addMessage('Przychód został usunięty', Flash::WARNING);
            View::renderTemplate('Balance/new.html');
            
        } 
    }
    public function editIncomeAction()
    {
        if(isset($_POST['income_id']))
        {
            $incomes = new UserIncomes($_POST);
            $id=$_POST['income_id'];
            $amount=$_POST['sum_income'];
            $incomes->editIncome($id,$amount);
            Flash::addMessage('Wartość przychodu została zmieniona', Flash::WARNING);
            View::renderTemplate('Balance/new.html');
            
        } 
    }

    public function deleteExpenseAction()
    {
        if(isset($_POST['delete_expense']))
        {
            $expenses = new UserExpenses($_POST);
            $id=$_POST['delete_expense'];
            $expenses->deleteExpense($id);
            Flash::addMessage('Wydatek został usunięty', Flash::WARNING);
            View::renderTemplate('Balance/new.html');
            
        } 
    }

}