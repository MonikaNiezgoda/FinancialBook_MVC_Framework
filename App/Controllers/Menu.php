<?php

namespace App\Controllers;

use \Core\View;
use \App\Auth;

class Menu extends \Core\Controller
{
    public function mainAction()

    {
        View::renderTemplate('Menu/main.html');
    }
}
