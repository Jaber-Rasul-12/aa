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

         use \Winter\Storm\Database\Traits\Nullable;
protected $nullable = ['center_id' , 'date_of_enrollment' , 'salare_id' , 'gender' , 'nationality'];
public $fillable = [
    'full_name' ,
    'name' , 
    'father_name' , 
    'last_name' , 
    'mother_name' , 
    'date_of_birth' , 
    'place_of_birth' , 
    'national_id' , 
    'rank' , 
    'level' , 
    'center_id' , 
    'salare_id' , 
    'gender' , 
    'nationality' , 
    'comprehensive_issue' , 
    'file_number' , 
    'entry_number' , 
    'date_of_enrollment' , 

    ];


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
        'last_name' => 'nullable|string|max:255',
        'mother_name' => 'required|string|max:255',
        'date_of_birth' => 'nullable|string',
        'place_of_birth' => 'nullable|string|max:255',
        'national_id' => 'required|string',
        'rank' => 'required|string|max:100',
        'center_id' => 'required|exists:aa_aa_centers,id',
        'salare_id' => 'required|exists:aa_aa_salares,id',
        'gender' => 'required|in:male,female,other',
        'nationality' => 'required|string|max:100',
        'status' => 'required|in:merged,not_merged,civil,martyrs,prisoners',
        'date_of_enrollment' => 'nullable|date',
    ];


       public $belongsTo = [
        'center' => [Center::class, 'key' => 'center_id'],
        'salare' => [Salare::class, 'key' => 'salare_id']
    ];

        public $hasMany = [
        'payrolls' => [Payroll::class, 'key' => 'employee_id'],
    ];


    


      public function getFullQualityNameAttribute()
  {
    return $this->full_name . ' ( ' . $this->national_id . ' )';
  }

   public function getGenderListsAttribute()
  {
    return $this->attributes['gender'] ?  trans('aa.aa::lang.model.employee.' . $this->attributes['gender']) : 'لا يوجد بيانات';
  }

  public function getStatusListsAttribute()
  {
    return $this->attributes['status'] ?  trans('aa.aa::lang.model.employee.' . $this->attributes['status']) : 'لا يوجد بيانات';
  }

  
     public function getNationalityListsAttribute()
  {
    return $this->attributes['nationality'] ? trans('aa.aa::lang.model.employee.' . $this->attributes['nationality']) : 'لا يوجد بيانات';
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
