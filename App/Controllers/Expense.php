<?php

namespace App\Controllers;

use \Core\View;
use \App\Auth;
use \App\Flash;
use \App\Models\UserExpenses;

class Expense extends Authenticated

{
     
    public function createAction()
    {
        $user = Auth::getUser();
        View::renderTemplate('Expense/create.html',[
            'expenses_categories'=>UserExpenses::findAllExpensesCat($user->id)
        ]);
    }

    public function addAction()
    {
        $user = Auth::getUser();
        $expense = new UserExpenses($_POST);
        $expense->save($user->id);

        Flash::addMessage('Wydatek został dodany.');
        $this-> redirect('/expense/create');
    }

    public function getLimitAction()
    {
       // $id = $_GET['id'];
       echo json_encode(UserExpenses::getCatLimit(37), JSON_UNESCAPED_UNICODE);
    }

}
