<?php

namespace App\Models;

use PDO;
use \App\Token;

class UserIncomes extends \Core\Model
{
    public static function findAllIncomesCat($id)
    {
        $sql=("SELECT id, name FROM `incomes_category_assigned_to_users` WHERE user_id='$id'");	
		$db = static::getDB();
        $stmt = $db ->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        
    }

    public static function addDefaultIncomesCat($id)
    {
        //dodanie kategorii przychodow defaultowych do tabeli z przypisanymi do usera
		$sql=('SELECT * FROM incomes_category_default');
        $db = static::getDB();
        $stmt = $db->query($sql);
    
        $incomesCategory = $stmt->fetchAll(PDO::FETCH_ASSOC);
        			
        foreach($incomesCategory as $incomesCategory) {
        $categoryName=$incomesCategory['name'];
        $sql="INSERT INTO incomes_category_assigned_to_users
             VALUES (NULL, '$id', '$categoryName')";
		$db->exec($sql);
		}

    }


}