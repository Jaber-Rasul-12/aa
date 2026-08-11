<?php namespace Aa\Aa\Models;



class EmployeeExportExcel extends \Backend\Models\ExportModel
{
    public function exportData($columns, $sessionKey = null)
    {
        foreach (Employee::cursor() as $record) {
            $record->addVisible($columns);
            yield $record->toArray();
        }
    }
}