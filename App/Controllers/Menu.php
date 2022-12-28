<?php

namespace App\Controllers;

use \Core\View;
use \App\Auth;
use \App\Models\User;


class Menu extends Authenticated
{
    public function mainAction()

    { 
        View::renderTemplate('Menu/main.html');
    }
}
