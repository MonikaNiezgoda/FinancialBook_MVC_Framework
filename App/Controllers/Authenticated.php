<?php

namespace App\Controllers;

abstract class Authenticated extends \Core\Controller
{
    protected function before()
    {
        var_dump($_SESSION['user_id']);
        $this->requireLogin();
    }
}