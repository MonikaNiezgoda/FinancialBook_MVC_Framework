<?php

namespace App\Controllers;

use \Core\View;
use \App\Auth;

class Income extends Authenticated
{
    public function createAction()
    { 
        View::renderTemplate('Income/create.html');
    }

    public function addAction()
    {
        Flash::addMessage('Dodanie przychodu się powiodło.');
        $this-> redirect('/income/create');
    }
}
