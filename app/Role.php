<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    protected $fillable = [
        'name', 'guard_name'
    ];

    public const ID_FIELD = 'id';
    public const NAME_FIELD = 'name';

    public function fieldList()
    {
        return [
            ['name' => 'id', 'label' => '#', 'query' => true, 'table' => true],
            ['name' => 'name', 'label' => 'Papel', 'query' => true, 'table' => true],
            ['name' => 'guard_name', 'label' => 'Guard', 'width' => 40, 'query' => true, 'table' => false],
        ];
    }

    public function listPermissions()
    {
        return [
            'role-list',
            'role-create',
            'role-edit',
            'role-delete'
        ];
    }

    public function setGuardNameAttribute()
    {
        $this->attributes['guard_name'] = 'web';
    }

    public function getdataValidateAttribute()
    {
        $ignore = ',NULL,id';

        if($this->id){
            $ignore = ','.$this->id.',id';
        }

        return [
            'name' => 'required|unique:roles,name'.$ignore,
            'permissions' => 'required'
        ];
    }
}
