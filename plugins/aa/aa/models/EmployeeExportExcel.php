<?php namespace Aa\Aa\Models;



class EmployeeExportExcel extends \Backend\Models\ExportModel
{


        public function exportData($columns, $sessionKey = null)
    {
        // جلب البيانات مع العلاقات
        $cars = Employee::with(['center', 'salare'])->cursor();
        
        foreach ($cars as $record) {
            $exportData = $record->toArray();
            
            // إضافة العلاقات مع تحويل آمن
            $exportData['center'] = $record->center ? $record->center->name : 'لا يوجد';
            $exportData['salare'] = $record->salare ? $record->salare->FullQualityName : 'لا يوجد';

            $exportData['gender'] = $record->gender ?  trans('aa.aa::lang.model.employee.' . $record->gender) : 'لا يوجد';
            $exportData['status'] = $record->status ?  trans('aa.aa::lang.model.employee.' . $record->status) : 'لا يوجد';

            $exportData['nationality'] = $record->nationality ?  trans('aa.aa::lang.model.employee.' . $record->nationality) : 'لا يوجد';

            

            
            // تصفية الأعمدة
            $finalData = [];
            foreach ($columns as $column) {
                $finalData[$column] = $exportData[$column];
            }
            
            yield $finalData;
        }
    }
}