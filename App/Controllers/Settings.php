<?php

namespace App\Controllers;

use \Core\View;
use \App\Flash;
use \App\Auth;
use \App\Models\User;
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
        $user = User::findbyID($user->id);

        View::renderTemplate('Settings/new.html',[
            'incomes'=>$incomesCategories,
            'expenses'=>$expensesCategories,
            'user'=>$user
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
        

        if(empty($_POST['new_name']))
        {
            $limit=$_POST['limit_category'];
            UserExpenses::addLimit($catId, $limit);
        }
        else if(empty($_POST['limit_category']))
        {
            $newName=$_POST['new_name'];
            UserExpenses::changeName($catId, $newName);
        }
        else{
        $newName=$_POST['new_name'];
        $limit=$_POST['limit_category'];
        UserExpenses::editExpenseCat($catId, $limit, $newName);
        }
      
        Flash::addMessage('Edycja wydatku zakończona pomyślnie.');
        $this-> redirect('/settings/new');

    }

    public function editIncomeAction()
    {
        $catId=$_POST['edit_income'];
        $newName=$_POST['new_income_name'];
        UserIncomes::newName($catId, $newName);
     
        Flash::addMessage('Edycja przychodu zakończona pomyślnie.');
        $this-> redirect('/settings/new');
    }

    public function changePassword()
{   
    $user = Auth::getUser();
    $newPassword = $_POST['new_password'];
    $user->newPassword = $newPassword;
    if ($user->changePassword()) {
        Flash::addMessage('Zmiana hasła zakończona pomyślnie.');
        $this->redirect('/settings/new');
    } else {
        Flash::addMessage('Zmiana hasła zakończona niepomyślnie.',Flash::WARNING);
        View::renderTemplate('Settings/new.html', [
            'user' => $user
        ]);
    }
}

}

?>