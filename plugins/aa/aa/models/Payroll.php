<?php namespace Aa\Aa\Models;

use Model;
// use Winter\Storm\Database\Builder;
// use BackendAuth;
/**
 * Model
 */
use Jacob\Logbook\Traits\LogChanges;
class Payroll extends Model
{
    use \Winter\Storm\Database\Traits\Validation;
    
  
  use LogChanges;



  public $logBookModelName = 'aa.aa::lang.plugin.payrolls';
  public static function changeLogBookDisplayColumn($column)
  {
    return 'aa.aa::lang.model.payroll.' . $column;
  }

    /**
     * @var string The database table used by the model.
     */
    public $table = 'aa_aa_payrolls';

    /**
     * @var array Validation rules
     */

    public $rules = [
        'employee_id' => 'required|exists:aa_aa_employees,id',
        'salare_id' => 'required|exists:aa_aa_salares,id',
        'year_id' => 'required|exists:aa_aa_years,id',
        'month_id' => 'required|exists:aa_aa_months,id',
        'status' => 'required|boolean'
    ];


        public $belongsTo = [
        'employee' => [Employee::class, 'key' => 'employee_id'],
        'salare' => [Salare::class, 'key' => 'salare_id'],
        'year' => [Year::class, 'key' => 'year_id'],
        'month' => [Month::class, 'key' => 'month_id']
    ];




           public function getSalareIdOptions()
  {
   if (isset($this->employee->id) && !empty($this->employee->id)) {
      return Salare::where('id', $this->employee->salay_id)->get()->lists('FullQualityName', 'id');
    } else {
      return [];
    }
  }




  public function beforeValidate(){
    if(Year::where('status' , true)->exists() && Month::where('status' , true)->exists()){
      $this->year_id = Year::where('status' , true)->first()->id;
      $this->month_id = Month::where('status' , true)->first()->id;
    }else{
        
      throw new \ValidationException(['name' => trans('aa.aa::lang.plugin.year_month_status')]);
  
    }
  }


    // before the model is saved, when first created.
  public function beforeCreate()
  {
    $this->checkUniqueNameYear();
    
  }




  public function beforeUpdate()
  {
    if (($this->original['employee_id'] != $this->employee_id) || ($this->original['year_id'] != $this->year_id) || ($this->original['month_id'] != $this->month_id)) {
      $this->checkUniqueNameYear();
    }
    
  }

  protected function checkUniqueNameYear()
  {
    $exists = self::where('employee_id', $this->employee_id)
      ->where('year_id', $this->year_id)
      ->where('month_id', $this->month_id)

      ->exists();

    if ($exists) {
      throw new \ValidationException(['name' => trans('aa.aa::lang.plugin.message_unique')]);
    }
  }


}
