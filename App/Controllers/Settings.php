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

    public function addNewIncomeCatAction()
    {
        $user = Auth::getUser();
        $income = new UserIncomes($_POST);
        $income->add($user->id);

        Flash::addMessage('Nowa kategoria przychodu została dodana.');
        $this-> redirect('/settings/new');

    }

    public function addNewExpenseCatAction()
    {
        $user = Auth::getUser();
        $expense = new UserExpenses($_POST);
        $expense->addCategory($user->id);

        Flash::addMessage('Nowa kategoria wydatku została dodana.');
        $this-> redirect('/settings/new');

    }

    public function deleteIncomesAction()
    {
        
        $catId=$_POST['delete_incomes'];
        UserIncomes::deleteIncomeCategory($catId);
        Flash::addMessage('Kategoria przychodu została usunięta.');
        $this-> redirect('/settings/new');

    }

    public function deleteExpensesAction()
    {
        
        $catId=$_POST['delete_expenses'];
        UserExpenses::deleteExpenseCategory($catId);
        Flash::addMessage('Kategoria wydatku została usunięta.');
        $this-> redirect('/settings/new');

    }

    public function editExpenseAction()
    {
        
        $catId=$_POST['edit_expense'];
        $limit=$_POST['limit_category'];
        UserExpenses::addLimit($catId, $limit);
        Flash::addMessage('Dodano limit do kategorii wydatku.');
        $this-> redirect('/settings/new');

    }

}

?>