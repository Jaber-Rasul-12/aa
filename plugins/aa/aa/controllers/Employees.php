<?php namespace Aa\Aa\Controllers;

use Aa\Aa\Models\Salare;
use Backend\Classes\Controller;
use BackendMenu;

class Employees extends Controller
{
    public $implement = [        'Backend\Behaviors\ListController',        'Backend\Behaviors\FormController'   , \Backend\Behaviors\ImportExportController::class   , \Backend\Behaviors\RelationController::class  ];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';

    public $requiredPermissions = [
        'employees' 
    ];    
    public $relationConfig = 'relation_config.yaml';
    public $importExportConfig = 'import_export_config.yaml';

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Aa.Aa', 'menu_employees', 'employees');
    }

       
    public function relationExtendManageWidget($widget, $field, $employee)
    {
        if ($field == 'payrolls') {
           if(!empty($employee->salare) && isset($employee->salare)){

               $widget->fields['salare_id']['options']= Salare::where('id', $employee->salare->id)->get()->lists('FullQualityName', 'id');
           }else{
               $widget->fields['salare_id']['options']= [];

           }
        }
    }
}
