<?php namespace Aa\Aa\Models;

use Model;
// use Winter\Storm\Database\Builder;
// use BackendAuth;
/**
 * Model
 */
class Salare extends Model
{
    use \Winter\Storm\Database\Traits\Validation;
    
   

    /**
     * @var string The database table used by the model.
     */
    public $table = 'aa_aa_salares';

      /**
     * @var array Validation rules
     */
    public $rules = [
        'currency' => 'required|string|size:3|in:USD,EUR,GBP,JOD,KWD,SAR,AED,EGP',
        'price' => 'required|numeric|min:0|max:999999999999.99',
        'name' => 'nullable|string|max:255|unique:aa_aa_salares,name',
        'description' => 'nullable|string|max:1000',
        'is_active' => 'boolean'
    ];

       public $hasMany = [
        'employees' => [Employee::class, 'key' => 'salare_id'],
        'payrolls' => [Payroll::class, 'key' => 'salare_id']
    ];


    public function getFullQualityNameAttribute()
  {
    return ( $this->currency == 'USD' ? ' $' : ' ل.س ' . $this->price );
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
