<?php

namespace Aa\Aa\Models;

use Model;
// use Winter\Storm\Database\Builder;
use BackendAuth;
/**
 * Model
 */
class Year extends Model
{
    use \Winter\Storm\Database\Traits\Validation;





    /**
     * @var string The database table used by the model.
     */
    public $table = 'aa_aa_years';

    public $rules = [
        'name' => 'required|unique:aa_aa_years,name|max:255',
        'status'      => 'required|boolean',
        'user_id' => 'nullable|exists:backend_users,id',
    ];

    public $belongsTo = [
        'user' => ['Backend\Models\User', 'key' => 'user_id'],
    ];



    

              public $hasMany = [
         'payrolls' => [Payroll::class, 'key' => 'year_id'],
    ];


    public function scopeIsActive($query)
    {
        return $query->where('status', true)->orderBy('name', 'desc');
    }



    /**
     * Perform actions before deleting 
     *
     * @taaows \ValidationException
     */
    public function beforeDelete()
    {

        // Check if there are associated records in any of the hasMany relationships
        foreach ($this->hasMany as $relation => $details) {
            if ($this->{$relation}->count() > 0) {
                // If associated records exist, prevent deletion and throw a validation exception
                throw new \ValidationException(['name' => trans('aa.aa::lang.plugin.message_delete')]);
            }
        }
    }


    public function beforeCreate()
    {
        if ($this->status) {
            $this->statusYear();
        }
    }

    public function beforeUpdate()
    {
        $originalValues = $this->getOriginal();
        if (($originalValues['status'] == false) && ($this->status == true)) {
            $this->statusYear();
        } else if (($this->original['status'] == true) && ($this->status == false)) {
            $this->months()->update(['status' => false]);
        }
    }

public function afterCreate()
{
    $this->months()->createMany([
        [
            'name' => '1',
            'status' => true,
            'user_id' => BackendAuth::getUser()->id ?? null,
        ],
        [
            'name' => '2',
            'status' => false,
            'user_id' => BackendAuth::getUser()->id ?? null,
        ],
        [
            'name' => '3',
            'status' => false,
            'user_id' => BackendAuth::getUser()->id ?? null,
        ],
        [
            'name' => '4',
            'status' => false,
            'user_id' => BackendAuth::getUser()->id ?? null,
        ],
        [
            'name' => '5',
            'status' => false,
            'user_id' => BackendAuth::getUser()->id ?? null,
        ],
        [
            'name' => '6',
            'status' => false,
            'user_id' => BackendAuth::getUser()->id ?? null,
        ],
        [
            'name' => '7',
            'status' => false,
            'user_id' => BackendAuth::getUser()->id ?? null,
        ],
        [
            'name' => '8',
            'status' => false,
            'user_id' => BackendAuth::getUser()->id ?? null,
        ],
        [
            'name' => '9',
            'status' => false,
            'user_id' => BackendAuth::getUser()->id ?? null,
        ],
        [
            'name' => '10',
            'status' => false,
            'user_id' => BackendAuth::getUser()->id ?? null,
        ],
        [
            'name' => '11',
            'status' => false,
            'user_id' => BackendAuth::getUser()->id ?? null,
        ],
        [
            'name' => '12',
            'status' => false,
            'user_id' => BackendAuth::getUser()->id ?? null,
        ],
    ]);
}

    protected function statusYear()
    {
        $exists = self::where('status', true)
            ->exists();

        if ($exists) {
            throw new \ValidationException(['status' => trans('aa.aa::lang.plugin.error_status_save')]);
        }
    }

    public function beforeSave()
  {
      $this->user_id = isset(BackendAuth::getUser()->id) ? BackendAuth::getUser()->id : null;
  }
}
