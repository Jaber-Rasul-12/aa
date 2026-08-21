<?php namespace Aa\Aa\Controllers;

use Backend\Classes\Controller;
use BackendMenu;
use Aa\Aa\Models\Employee;
use Aa\Aa\Models\Center;
use Aa\Aa\Models\Salare;
use Response;

class Statictes extends Controller
{
    public $requiredPermissions = [
        'statictes' 
    ];

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Aa.Aa', 'menu_employees', 'statictes');
        
        // تحميل الـ assets
        $this->addCss('/plugins/aa/aa/assets/css/statistics.css');
        $this->addJs('/plugins/aa/aa/assets/js/statistics.js');
        $this->addJs('/plugins/aa/aa/assets/js/chart.umd.min.js');
        $this->addJs('/plugins/aa/aa/assets/js/jspdf.umd.min.js');
        $this->addJs('/plugins/aa/aa/assets/js/jspdf.plugin.autotable.min.js');
    }

    public function index()
    {
        $this->pageTitle = trans('aa.aa::lang.plugin.statictes');
        
        // جلب البيانات للإحصائيات
        $statistics = $this->getStatistics();
        
        // جلب الموظفين للجدول
        $employees = Employee::with(['center', 'salare'])->orderBy('id', 'desc')->get();
        
        $this->vars['statistics'] = $statistics;
        $this->vars['employees'] = $employees;
        $this->vars['centers'] = Center::all();
        $this->vars['salares'] = Salare::all();
        $this->vars['years'] = $this->getAvailableYears();
        $this->vars['ranks'] = $this->getAvailableRanks();
        $this->vars['statuses'] = $this->getStatusLabels();
        $this->vars['nationalities'] = $this->getNationalities();
    }
    
    /**
     * جلب جميع الإحصائيات
     */
    private function getStatistics()
    {
        return [
            'total_employees' => Employee::count(),
            'gender_stats' => $this->getGenderStats(),
            'status_stats' => $this->getStatusStats(),
            'center_stats' => $this->getCenterStats(),
            'salare_stats' => $this->getSalareStats(),
            'year_stats' => $this->getYearStats(),
            'rank_stats' => $this->getRankStats(),
            'nationality_stats' => $this->getNationalityStats(),
            'status_summary' => $this->getStatusSummary(),
        ];
    }
    
    /**
     * إحصائيات حسب النوع
     */
    private function getGenderStats()
    {
        $stats = [];
        $total = Employee::count();
        
        $genders = Employee::select('gender')
            ->distinct()
            ->get()
            ->pluck('gender');
        
        foreach ($genders as $gender) {
            $count = Employee::where('gender', $gender)->count();
            $stats[] = (object) [
                'gender' => $gender,
                'gender_label' => $gender ? trans('aa.aa::lang.model.employee.' . $gender) : 'لم يتم تحديد الجنس',
                'total' => $count,
                'color' => $this->getGenderColor($gender),
                'percentage' => $total > 0 ? round(($count / $total) * 100, 1) : 0
            ];
        }
        
        return collect($stats);
    }
    
    private function getGenderColor($gender)
    {
        $colors = [
            'male' => '#3498db',
            'female' => '#e74c3c',
            'other' => '#95a5a6'
        ];
        return $colors[$gender] ?? '#18ca00';
    }
    
    private function getStatusStats()
    {
        $stats = [];
        $total = Employee::count();
        
        $statuses = Employee::select('status')
            ->distinct()
            ->get()
            ->pluck('status');
        
        foreach ($statuses as $status) {
            $count = Employee::where('status', $status)->count();
            $stats[] = (object) [
                'status' => $status,
                'status_label' => $status ? trans('aa.aa::lang.model.employee.' . $status) : 'لم يتم تحديد الحالة',
                'total' => $count,
                'color' => $this->getStatusColor($status),
                'icon' => $this->getStatusIcon($status),
                'percentage' => $total > 0 ? round(($count / $total) * 100, 1) : 0
            ];
        }
        
        return collect($stats);
    }
    
    private function getStatusColor($status)
    {
        $colors = [
            'merged' => '#2ecc71',
            'not_merged' => '#f39c12',
            'civil' => '#3498db',
            'martyrs' => '#e74c3c',
            'prisoners' => '#9b59b6'
        ];
        return $colors[$status] ?? '#95a5a6';
    }
    
    private function getStatusIcon($status)
    {
        $icons = [
            'merged' => 'icon-check-circle',
            'not_merged' => 'icon-exclamation-circle',
            'civil' => 'icon-user',
            'martyrs' => 'icon-flag',
            'prisoners' => 'icon-lock'
        ];
        return $icons[$status] ?? 'icon-circle';
    }
    
    private function getStatusSummary()
    {
        $statuses = ['merged', 'not_merged', 'civil', 'martyrs', 'prisoners'];
        $summary = [];
        $total = Employee::count();
        
        foreach ($statuses as $status) {
            $count = Employee::where('status', $status)->count();
            $summary[] = [
                'status' => $status,
                'label' => trans('aa.aa::lang.model.employee.' . $status),
                'count' => $count,
                'color' => $this->getStatusColor($status),
                'icon' => $this->getStatusIcon($status),
                'percentage' => $total > 0 ? round(($count / $total) * 100, 1) : 0
            ];
        }
        
        return collect($summary);
    }
    
    private function getCenterStats()
    {
        $stats = [];
        $total = Employee::count();
        
        $centers = Center::withCount('employees')->get();
        
        foreach ($centers as $center) {
            $stats[] = (object) [
                'center_name' => $center->name ?? $center->name ?? 'مركز',
                'total' => $center->employees_count,
                'percentage' => $total > 0 ? round(($center->employees_count / $total) * 100, 1) : 0
            ];
        }
        
        return collect($stats);
    }
    
    private function getSalareStats()
    {
        $stats = [];
        $total = Employee::count();
        
        $salares = Salare::withCount('employees')->get();
        
        foreach ($salares as $salare) {
            $stats[] = (object) [
                'salare_name' => $salare->FullQualityName,
                'total' => $salare->employees_count,
                'percentage' => $total > 0 ? round(($salare->employees_count / $total) * 100, 1) : 0
            ];
        }
        
        return collect($stats);
    }
    
    private function getYearStats()
    {
        $stats = [];
        $total = Employee::count();
        
        $employees = Employee::whereNotNull('date_of_enrollment')->get();
        $years = $employees->pluck('date_of_enrollment')
            ->map(function($date) {
                return date('Y', strtotime($date));
            })
            ->unique()
            ->sort()
            ->values();
        
        foreach ($years as $year) {
            $count = Employee::whereNotNull('date_of_enrollment')
                ->whereYear('date_of_enrollment', $year)
                ->count();
            
            $stats[] = (object) [
                'year' => $year,
                'total' => $count,
                'percentage' => $total > 0 ? round(($count / $total) * 100, 1) : 0
            ];
        }
        
        return collect($stats);
    }
    
    private function getRankStats()
    {
        $stats = [];
        $total = Employee::count();
        
        $ranks = Employee::select('rank')
            ->distinct()
            ->orderBy('rank')
            ->get()
            ->pluck('rank');
        
        foreach ($ranks as $rank) {
            $count = Employee::where('rank', $rank)->count();
            $stats[] = (object) [
                'rank' => $rank,
                'total' => $count,
                'percentage' => $total > 0 ? round(($count / $total) * 100, 1) : 0
            ];
        }
        
        return collect($stats);
    }
    
    private function getNationalityStats()
    {
        $stats = [];
        $total = Employee::count();
        
        $nationalities = Employee::select('nationality')
            ->distinct()
            ->get()
            ->pluck('nationality');
        
        foreach ($nationalities as $nationality) {
            $count = Employee::where('nationality', $nationality)->count();
            $stats[] = (object) [
                'nationality' => $nationality,
                'nationality_label' => $nationality ? trans('aa.aa::lang.model.employee.' . $nationality) : 'لم يتم تحديد الجنسية',
                'total' => $count,
                'percentage' => $total > 0 ? round(($count / $total) * 100, 1) : 0
            ];
        }
        
        return collect($stats);
    }
    
    private function getAvailableYears()
    {
        return Employee::whereNotNull('date_of_enrollment')
            ->get()
            ->pluck('date_of_enrollment')
            ->map(function($date) {
                return date('Y', strtotime($date));
            })
            ->unique()
            ->sort()
            ->reverse()
            ->values()
            ->toArray();
    }
    
    private function getAvailableRanks()
    {
        return Employee::select('rank')
            ->distinct()
            ->orderBy('rank')
            ->get()
            ->pluck('rank')
            ->toArray();
    }
    
    private function getStatusLabels()
    {
        $statuses = ['merged', 'not_merged', 'civil', 'martyrs', 'prisoners'];
        $labels = [];
        foreach ($statuses as $status) {
            $labels[$status] = trans('aa.aa::lang.model.employee.' . $status);
        }
        return $labels;
    }
    
    private function getNationalities()
    {
        return Employee::select('nationality')
            ->distinct()
            ->get()
            ->pluck('nationality')
            ->toArray();
    }
    
    public function onGetChartData()
    {
        $type = post('type');
        $data = [];
        
        switch($type) {
            case 'gender':
                $data = $this->getGenderStats();
                break;
            case 'status':
                $data = $this->getStatusStats();
                break;
            case 'center':
                $data = $this->getCenterStats();
                break;
            case 'salare':
                $data = $this->getSalareStats();
                break;
            case 'year':
                $data = $this->getYearStats();
                break;
            case 'rank':
                $data = $this->getRankStats();
                break;
            case 'nationality':
                $data = $this->getNationalityStats();
                break;
        }
        
        return Response::json($data);
    }
    
    public function onExportPDF()
    {
        $statistics = $this->getStatistics();
        $html = view('aa.aa::statistics_pdf', ['statistics' => $statistics])->render();
        
        return Response::json(['html' => $html]);
    }
}