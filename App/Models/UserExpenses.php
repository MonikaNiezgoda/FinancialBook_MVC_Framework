<?php

namespace App\Models;

use PDO;
use \App\Token;

class UserExpenses extends \Core\Model
{
    public static function findAllExpensesCat($id)
    {
        $sql=("SELECT id, name, category_limit FROM `expenses_category_assigned_to_users` WHERE user_id='$id'");	
		$db = static::getDB();
        $stmt = $db ->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        
    }

    public static function addDefaultExpensesCat($id)
    {
        //dodanie kategorii przychodow defaultowych do tabeli z przypisanymi do usera
		$sql=('SELECT * FROM expenses_category_default');
        $db = static::getDB();
        $stmt = $db->query($sql);
    
        $expensesCategory = $stmt->fetchAll(PDO::FETCH_ASSOC);
        			
        foreach($expensesCategory as $expensesCategory) {
        $categoryName=$expensesCategory['name'];
        $sql="INSERT INTO expenses_category_assigned_to_users
             VALUES (NULL, '$id', '$categoryName')";
		$db->exec($sql);
		}

    }

    public function save($userId)
    {
        $category=$_POST['kategoria'];
        $paymentMethod="1";
		$amount = $_POST["kwota"];
		$date = $_POST["data"];
		$comment =$_POST["komentarz"];

		$db = static::getDB();
		$addExpense = $db ->exec("INSERT INTO expenses VALUES (NULL , '$userId', '$category', '$paymentMethod', '$amount', '$date', '$comment' )");
    }

    public function getExpenses($userId)
    {
        if(isset($_POST['currentMonth']))
        {
            $dataod=date('Y-m-d ', mktime(0,0,0,date('m'),1,date('Y')));
		    $datado=date('Y-m-d', mktime(23,59,59,date('m')+1,0,date('Y')));
        }
        if(isset($_POST['previousMonth']))
        {
            $dataod=  date('Y-m-d ', mktime(0,0,0,date('m')-1,1,date('Y')));
		    $datado= date('Y-m-d', mktime(23,59,59,date('m'),0,date('Y')));
        }
        if(isset($_POST['currentYear']))
		{
		//ustawienie pierwszego i ostatniego dnia bieżącego roku
		$dataod=  date('Y-m-d ', mktime(0,0,0,1,1,date('Y')));
		$datado= date('Y-m-d', mktime(23,59,59,13,0,date('Y')));
        }
        if(isset($_POST['dataOd']))
        {
            $dataod= $_POST['dataOd'];
		    $datado= $_POST['dataDo'];
        }
        $sql = "SELECT amount as sum, name, expenses.id as id FROM expenses JOIN expenses_category_assigned_to_users as category ON expenses.expense_category_assigned_to_user_id = category.id  
			WHERE expenses.user_id='$userId' AND date_of_expense BETWEEN '$dataod' AND '$datado'";
            $db = static::getDB();
			$userExpenses = $db->query($sql);
			return $userExpenses -> fetchAll();
    }

    public function sumExpenses($allExpenses)
    {
        $sumExpenses=0;
        foreach($allExpenses as $expenses){
        $sumExpenses+=$expenses['sum'];
        }
        return number_format($sumExpenses,2,'.','');
    }

    public function deleteExpense($id)
    {
        $sql = "DELETE FROM expenses WHERE id= '$id'";
        $db = static::getDB();
        $delete = $db->query($sql);
        return $delete;
    }

    public function addCategory($userId)
    {
        $newCat=$_POST['newCategory'];
		
		$db = static::getDB();
		$addExpenseCat = $db ->exec("INSERT INTO expenses_category_assigned_to_users VALUES (NULL , '$userId', '$newCat')");
    }

    static function deleteExpenseCategory($id)
    {
		$db = static::getDB();
		$deleteIncomeCat = $db ->exec("DELETE FROM expenses_category_assigned_to_users WHERE id= '$id'");
        $delete = $db->exec("DELETE FROM expenses WHERE expense_category_assigned_to_user_id= '$id'");
    }
    static function addLimit($id, $limit)
    {
		$db = static::getDB();
		$deleteIncomeCat = $db ->exec("UPDATE expenses_category_assigned_to_users SET category_limit='$limit'  WHERE id= '$id'");
        
    }

}