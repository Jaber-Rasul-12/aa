<?php namespace Aa\Aa\Models;

use Model;
// use Winter\Storm\Database\Builder;
// use BackendAuth;
/**
 * Model
 */
use Jacob\Logbook\Traits\LogChanges;
class Employee extends Model
{
    use \Winter\Storm\Database\Traits\Validation;
    

  use LogChanges;



  public $logBookModelName = 'aa.aa::lang.plugin.employees';
  public static function changeLogBookDisplayColumn($column)
  {
    return 'aa.aa::lang.model.employee.' . $column;
  }

    /**
     * @var string The database table used by the model.
     */
    public $table = 'aa_aa_employees';

    public $rules = [
        'full_name' => 'required|string|max:255',
        'name' => 'required|string|max:255',
        'father_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'mother_name' => 'required|string|max:255',
        'date_of_birth' => 'required|date|before:today',
        'place_of_birth' => 'required|string|max:255',
        'national_id' => 'required|string|unique:aa_aa_employees,national_id',
        'rank' => 'required|string|max:100',
        'level' => 'required|string|max:100',
        'center_id' => 'nullable|exists:aa_aa_centers,id',
        'salare_id' => 'nullable|exists:aa_aa_salares,id',
        'gender' => 'nullable|in:male,female,other',
        'nationality' => 'nullable|string|max:100',
        'comprehensive_issue' => 'nullable|integer|min:0',
        'file_number' => 'nullable|integer|min:0',
        'entry_number' => 'nullable|integer|min:0',
        'date_of_enrollment' => 'nullable|date|after_or_equal:date_of_birth',
    ];

       public $belongsTo = [
        'center' => [Center::class, 'key' => 'center_id'],
        'salare' => [Salare::class, 'key' => 'salare_id']
    ];

        public $hasMany = [
        'payrolls' => [Payroll::class, 'key' => 'employee_id'],
    ];


    


   public function getGenderListsAttribute()
  {
    return trans('aa.aa::lang.model.employee.' . $this->attributes['gender']);
  }
     public function getNationalityListsAttribute()
  {
    return trans('aa.aa::lang.model.employee.' . $this->attributes['nationality']);
  }

                   /**
     * Perform actions before deleting 
     *
     * @throws \ValidationException
     */
    public function beforeDelete()
    {
        foreach ($this->hasMany as $relation => $details) {
            if ($this->{$relation}->count() > 0) {
                throw new \ValidationException(['name' => trans('aa.aa::lang.plugin.message_delete')]);
            }
        }
    }



}
