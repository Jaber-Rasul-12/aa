<?php namespace Aa\Aa\Models;

use Model;
// use Winter\Storm\Database\Builder;
// use BackendAuth;
/**
 * Model
 */
use Jacob\Logbook\Traits\LogChanges;
class Salare extends Model
{
    use \Winter\Storm\Database\Traits\Validation;
    
   
  use LogChanges;



  public $logBookModelName = 'aa.aa::lang.plugin.salares';
  public static function changeLogBookDisplayColumn($column)
  {
    return 'aa.aa::lang.model.salare.' . $column;
  }
    /**
     * @var string The database table used by the model.
     */
    public $table = 'aa_aa_salares';

      /**
     * @var array Validation rules
     */
    public $rules = [
        'currency' => 'required|string|in:dollar,syrian',
        'price' => 'required|numeric|min:0|max:999999999999.99',

    ];

       public $hasMany = [
        'employees' => [Employee::class, 'key' => 'salare_id'],
        'payrolls' => [Payroll::class, 'key' => 'salare_id']
    ];


    public function getFullQualityNameAttribute()
  {
    return ( $this->currency == 'dollar' ? ' $ ' : ' ل.س ' . $this->price );
  }


  public function getCurrencyListsAttribute()
  {
    return $this->attributes['currency'] ?  trans('aa.aa::lang.model.salare.' . $this->attributes['currency']) : 'لا يوجد بيانات';
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
