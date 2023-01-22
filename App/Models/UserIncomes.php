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

    public function save($userId)
    {
        $category=$_POST['kategoria'];
		$amount = $_POST["kwota"];
		$date = $_POST["data"];
		$comment =$_POST["komentarz"];

		$db = static::getDB();
		$addIncome = $db ->exec("INSERT INTO incomes VALUES (NULL , '$userId', '$category', '$amount', '$date', '$comment' )");
    }

    public function getIncomes($userId)
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
            $sql = "SELECT amount as sum, name, incomes.id as id FROM incomes JOIN incomes_category_assigned_to_users as category ON incomes.income_category_assigned_to_user_id = category.id  
            WHERE incomes.user_id='$userId' AND date_of_income BETWEEN '$dataod' AND '$datado'
            GROUP BY name";
            $db = static::getDB();
			$userIncomes = $db->query($sql);
			return $userIncomes -> fetchAll();
    }

    public function sumIncomes($allIncomes)
    {
        $sumIncomes=0;
        foreach($allIncomes as $incomes){
        $sumIncomes+=$incomes['sum'];
        }
        return number_format($sumIncomes,2,'.','');
    }

    public function deleteIncome($id)
    {
        $sql = "DELETE FROM incomes WHERE id= '$id'";
        $db = static::getDB();
        $delete = $db->query($sql);
        return $delete;
    }
}