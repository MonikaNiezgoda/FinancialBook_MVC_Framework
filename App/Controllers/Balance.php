<?php

namespace App\Controllers;

use \Core\View;
use \App\Flash;

class Balance extends \Core\Controller
{
    public function newAction()
    {
        View::renderTemplate('Balance/new.html');
    }

}