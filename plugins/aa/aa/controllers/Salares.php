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


    public function formGetRedirectUrl($context = null, $model = null)
    {
        $url = post('url');


        if (($url == 'create') && !empty($url)) {
            return "aa/aa/salares";
        }else if (($url == 'preview') && !empty($url)) {
            return "aa/aa/salares/$url/$model->id";
        }else {
            if ((post("close") == 1) && !empty(post("close"))) {
                return "aa/aa/salares";
            } else {
                return "aa/aa/salares/update/$model->id";
            }
        }
    }
}
