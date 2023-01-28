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
        View::renderTemplate('Settings/new.html');
    }
}