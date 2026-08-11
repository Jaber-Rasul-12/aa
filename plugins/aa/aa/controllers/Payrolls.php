<?php namespace Aa\Aa\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

class Payrolls extends Controller
{
    public $implement = [        'Backend\Behaviors\ListController',        'Backend\Behaviors\FormController'    ];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';

    public $requiredPermissions = [
        'payrolls' 
    ];

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Aa.Aa', 'menu_employees', 'payrolls');
    }
}
