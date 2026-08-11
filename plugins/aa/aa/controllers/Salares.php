<?php namespace Aa\Aa\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

class Salares extends Controller
{
    public $implement = [        'Backend\Behaviors\ListController',        'Backend\Behaviors\FormController'    ];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';

    public $requiredPermissions = [
        'salares' 
    ];

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Aa.Aa', 'menu_employees', 'salares');
    }
}
