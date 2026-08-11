<?php namespace Aa\Aa\Models;

use Model;
// use Winter\Storm\Database\Builder;
// use BackendAuth;
/**
 * Model
 */
class Center extends Model
{
    use \Winter\Storm\Database\Traits\Validation;
    
   

    /**
     * @var string The database table used by the model.
     */
    public $table = 'aa_aa_centers';

  
    public $rules = [
        'name' => 'required|string|max:255',
        'parent_id' => 'nullable|exists:aa_aa_centers,id'
    ];
    
    /**
     * Custom validation messages
     */
    public $customMessages = [
        'name.required' => 'The center name is required.',
        'parent_id.exists' => 'The selected parent center does not exist.'
    ];
    
    /**
     * Relationships
     */
    public $belongsTo = [
        'parent' => [Center::class, 'key' => 'parent_id']
    ];
    
    public $hasMany = [
        'children' => [Center::class, 'key' => 'parent_id'],
        'employees' => [Employee::class, 'key' => 'center_id']
    ];


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
