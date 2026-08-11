<?php namespace Aa\Aa\Models;

use Model;
// use Winter\Storm\Database\Builder;
// use BackendAuth;
/**
 * Model
 */
class Payroll extends Model
{
    use \Winter\Storm\Database\Traits\Validation;
    
  


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
        'price' => 'required|numeric|min:0|max:99999999.99',
        'status' => 'required|boolean'
    ];


        public $belongsTo = [
        'employee' => [Employee::class, 'key' => 'employee_id'],
        'salare' => [Salare::class, 'key' => 'salare_id'],
        'year' => [Year::class, 'key' => 'year_id'],
        'month' => [Month::class, 'key' => 'month_id']
    ];


             public function getYearIdOptions()
  {
      return Year::where('status' , true)->get()->lists('name', 'id');
  }

       public function getMonthIdOptions()
  {
    if (isset($this->year) && !empty($this->year->id)) {
      return Month::where('year_id', $this->year->id)->where('status' , true)->get()->lists('name', 'id');
    } else {
      return [];
    }
  }

}
