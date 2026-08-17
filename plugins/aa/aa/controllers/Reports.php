<?php

namespace Aa\Aa\Controllers;

use Aa\Aa\Models\Center;
use Aa\Aa\Models\Employee;
use Aa\Aa\Models\Month;
use Aa\Aa\Models\Payroll;
use Aa\Aa\Models\Year;
use Backend\Classes\Controller;
use Backend\Facades\BackendMenu;
use Flash;

/**
 * Reports Backend Controller
 */
class Reports extends Controller
{

    /**
     * @var array Permissions required to view this page.
     */
    protected $requiredPermissions = [
        'reports',
    ];

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Aa.Aa', 'menu_employees', 'reports');
    }

    public function index(){
    $this->pageTitle = trans('aa.aa::lang.plugin.reports');
    $this->vars['yearsOptions'] = Year::get();
    $this->vars['centersOptions'] = Center::get();

    
}



    public function onGetMonths()
    {
        $yearId = post('year_id');
        $months = Month::where('year_id', $yearId)->get();

        return [
            '#monthSelect' => $this->makePartial('monthoptions', ['months' => $months]),
        ];
    }
public function onFilterReports()
{
    $year_id = post('year_id');
    $month_id = post('month_id');
    $center_id = post('center_id');

    if(empty($year_id) || empty($month_id) || empty($center_id)){
        Flash::error('تحديد السنة والشهر و المركز مطلوبين');
        return;
    }

  $employees = Employee::withWhereHas('payrolls', function ($query) use ($year_id, $month_id) {
    $query->where('year_id', $year_id)->where('month_id', $month_id);
})
->where('center_id', $center_id)
->get();



$total_dollars = Payroll::where('status' , true)->where('year_id' , $year_id)->where('month_id' , $month_id)->whereHas('salare', function ($query) { $query->where('currency', 'dollar');})->whereIn('employee_id', $employees->pluck('id')->toArray())->get()->sum('price');
$total_syrian = Payroll::where('status' , true)->where('year_id' , $year_id)->where('month_id' , $month_id)->whereHas('salare', function ($query) { $query->where('currency', 'syrian');})->whereIn('employee_id', $employees->pluck('id')->toArray())->get()->sum('price');
    $this->vars['employees'] = $employees;

    // ====== حساب الإحصائيات ======
    $statistics = [
        'total_dollars' => $total_dollars,
        'total_syrian' => $total_syrian,
        'total_number' => count($employees),
    ];


    $this->vars['statistics'] = $statistics;
    // ====== نهاية حساب الإحصائيات ======

    return [
        '#body_table' => $this->makePartial('table', ['employees' => $employees ]),
        '#statistics-container' => $this->makePartial('statistics', ['statistics' => $statistics ]),
    ];
}
}
