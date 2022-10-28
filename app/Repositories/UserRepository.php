<?php

namespace App\Repositories;

use App\Interfaces\IUserRepository;
use App\Interfaces\IValidator;
use App\User;

class UserRepository extends DefaultRepository implements IUserRepository
{
    public function __construct(IValidator $validateData, User $entity)
    {
        $this->Entity = $entity;
        $this->validateData = $validateData;
        $this->validateErrors = [];
    }

    public function restore($id)
    {
        $this->Entity->withTrashed()->where('id', $id)->restore();
    }

    public function list()
    {
        return $this->Entity->where('id', '<>', auth()->user()->id)->get();
    }

    public function create($data)
    {
        $this->Entity->fill($data->all());
        $this->Entity->password = bcrypt('#dtcea$J123');
        $this->Entity->save();

        return $this->Entity;
    }

    public function getOwnRoles($user)
    {
        return $this->Entity->find($user)->roles->pluck('name', 'name')->all();
    }

    public function getOwnPermissions($user)
    {
        return $this->Entity->find($user)->permissions->pluck('name', 'name')->all();
    }

    public function getInheritancePermissions($user)
    {
        return $this->Entity->find($user)->getPermissionsViaRoles()->pluck('name', 'name')->all();
    }

    public function setPassword($value, $user)
    {
        $user = $this->Entity->find($user);
        $user->password = bcrypt($value);
        $user->save();
    }

    public function getTotalRecords($searchValue = null, $isFiltered = false, $condition = null)
    {
        if(!$isFiltered){
            return $this->Entity->select($this->getSelectFields())->where($this->Entity::ID_FIELD, '<>', auth()->user()->id)->get()
                ->filter(function($item){
                    if(auth()->user()->hasRole('super-admin')){
                        return true;
                    } else {
                        if($item->hasRole('super-admin')) return false;
                        return true;
                    }
                })->count();
        }

        $queryBuilder = $this->Entity->select($this->getSelectFields())
            ->where($this->Entity::ID_FIELD, '<>', auth()->user()->id);

        if($condition){
            if(is_array($condition)){
                $queryBuilder->where($condition);
            } else {
                $queryBuilder->onlyTrashed();
            }
        }

        $queryBuilder = $this->setFilters($queryBuilder, $searchValue);

        return $queryBuilder->get()
            ->filter(function($item){
                if(auth()->user()->hasRole('super-admin')){
                    return true;
                } else {
                    if($item->hasRole('super-admin')) return false;
                    return true;
                }
            })
            ->count();
    }

    public function getFilteredList($searchValue, $columnName, $columnSortOrder, $start, $rowperpage, $condition = null)
    {
        $queryBuilder = $this->Entity->select($this->getSelectFields())
            ->where($this->Entity::ID_FIELD, '<>', auth()->user()->id);

        if($condition){
            if(is_array($condition)){
                $queryBuilder->where($condition);
            } else {
                $queryBuilder->onlyTrashed();
            }
        }

        $queryBuilder = $this->setFilters($queryBuilder, $searchValue);

        return $queryBuilder->skip($start)
            ->take($rowperpage)
            ->orderBy($columnName, $columnSortOrder)
            ->get()
            ->filter(function($item){
                if(auth()->user()->hasRole('super-admin')){
                    return true;
                } else {
                    if($item->hasRole('super-admin')) return false;
                    return true;
                }
            });
    }
}
