<?php

namespace App\Models;

use PDO;
use \App\Token;

class Income extends \Core\Model
{
    public function findAllIncomesCat($id)
    {
        $stmt = $db ->query("SELECT name FROM `incomes_category_assigned_to_users` WHERE user_id='$id'");	
		$stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        $stmt = execute();
        
        return $stmt->fetch();

    }

    public static function addDefaultIncomesCat($id)
    {
        //dodanie kategorii przychodow defaultowych do tabeli z przypisanymi do usera
		$sql=('SELECT * FROM incomes_category_default');
        $db = static::getDB();
        $stmt = $db->query($sql);
    
        $incomesCategory = $stmt->fetchAll(PDO::FETCH_ASSOC);
        var_dump($incomesCategory);
        
					
        foreach($incomesCategory as $incomesCategory) {
        $categoryName=$incomesCategory['name'];
        $sql="INSERT INTO incomes_category_assigned_to_users
             VALUES (NULL, '$id', '$categoryName')";
		$db->exec($sql);
		}

    }


}