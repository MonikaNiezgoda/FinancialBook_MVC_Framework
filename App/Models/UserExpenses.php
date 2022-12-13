<?php

namespace App\Models;

use PDO;
use \App\Token;

class UserExpenses extends \Core\Model
{
    public static function findAllExpensesCat($id)
    {
        $sql=("SELECT id, name FROM `expenses_category_assigned_to_users` WHERE user_id='$id'");	
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


}