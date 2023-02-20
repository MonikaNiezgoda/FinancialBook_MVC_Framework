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
    $id = $this->route_params['id'];
        
    $categoryLimit = UserExpenses::getCatLimit($id);
    if ($categoryLimit === false) {
        http_response_code(404);
        echo json_encode(['error' => 'Category limit not found']);
    } else {
        $response = ['category_limit' => $categoryLimit];
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}

public function getExpensesByDateAction()
{
    $id = $this->route_params['id'];
    $date = $_GET['date']; 
    $response = UserExpenses::getMonthExpenses($id,$date);
    
        //$response = ['category_limit' => $categoryLimit];
        header('Content-Type: application/json');
        echo json_encode($response);
    
}
}
