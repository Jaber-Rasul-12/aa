<?php namespace Aa\Aa\Models;

use October\Rain\Support\Facades\Flash;

class PayrollExportExcel extends \Backend\Models\ExportModel
{


 protected $fillable = ['year_id', 'month_id', 'center_id'];


        public function exportData($columns, $sessionKey = null)
    {
        if(empty($this->year_id) && empty($this->month_id) && empty($this->center_id)){
         Flash::error('تحديد السنة والشهر و المركز مطلوبين');
         throw new \ValidationException(['name' => 'رجاء اختر السنة و الشهر و المركز']);

        }
        // جلب البيانات مع العلاقات
        $cars = Payroll::where('year_id', $this->year_id)->where('month_id', $this->month_id)->whereHas('employee', function ($query) { $query->where('center_id', $this->center_id); })->cursor();
        
        foreach ($cars as $record) {
            $exportData = $record->toArray();
            
            // إضافة العلاقات مع تحويل آمن
            
            $exportData['employee'] = $record->employee ? $record->employee->FullQualityName : 'لا يوجد';

            
            $exportData['year'] = $record->year ? $record->year->name : 'لا يوجد';
            $exportData['month'] = $record->month ? $record->month->name : 'لا يوجد';

            $exportData['salare'] = $record->salare ? $record->salare->FullQualityName : 'لا يوجد';
            $exportData['discount'] = $record->discount . ' ' . ($record->salare->currency == 'dollar' ? '$' : 'ل.س');

            $exportData['price'] = $record->price . ' ' . ($record->salare->currency == 'dollar' ? '$' : 'ل.س');


            
            // تصفية الأعمدة
            $finalData = [];
            foreach ($columns as $column) {
                $finalData[$column] = $exportData[$column];
            }
            
            yield $finalData;
        }
    }

         public function getYearIdOptions()
  {
      return Year::get()->lists('name', 'id');
  }

       public function getMonthIdOptions()
  {
    if (isset($this->year_id) && !empty($this->year_id)) {
      return Month::where('year_id', $this->year_id)->get()->lists('name', 'id');
    } else {
      return [];
    }
  }
        public function getCenterIdOptions(){
      return Center::get()->lists('name', 'id');
 
    }

}