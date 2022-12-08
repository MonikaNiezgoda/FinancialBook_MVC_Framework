<?php

namespace App\Controllers;

use \Core\View;
use \App\Auth;

class Income extends Authenticated
{
    public function addAction()

    { 
        View::renderTemplate('Income/add.html');
    }
}
