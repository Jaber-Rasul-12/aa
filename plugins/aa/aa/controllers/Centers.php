<?php namespace Aa\Aa\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

class Centers extends Controller
{
    public $implement = [        'Backend\Behaviors\ListController',        'Backend\Behaviors\FormController' , \Backend\Behaviors\ReorderController::class,    ];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';

    public $requiredPermissions = [
        'centers' 
    ];
    public $reorderConfig = 'reorder_config.yaml';

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Aa.Aa', 'menu_employees', 'centers');
    }
}
