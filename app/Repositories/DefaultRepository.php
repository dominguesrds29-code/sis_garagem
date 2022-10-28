<?php

namespace App\Repositories;

use App\Interfaces\IDefaultRepository;

class DefaultRepository implements IDefaultRepository
{
    protected $validateData;
    protected $validateErrors;
    protected $Entity;

    public function list()
    {
        return $this->Entity->all();
    }

    public function get($id)
    {
        return $this->Entity->find($id);
    }

    public function getFieldList()
    {
        return $this->Entity->fieldList();
    }

    public function create($data)
    {
        return $this->Entity->create($this->loadData($data));
    }

    public function update($data, $id)
    {
        return $this->Entity->find($id)->fill($this->loadData($data))->save();
    }

    public function delete($id)
    {
        return $this->Entity->find($id)->delete();
    }

    public function getTotalRecords($searchValue = null, $isFiltered = false, $condition = null)
    {
        if(!$isFiltered){
            return $this->Entity->count();
        }

        $queryBuilder = $this->Entity->select($this->getSelectFields());

        if($condition){
            if(is_array($condition)){
                $queryBuilder->where($condition);
            } else {
                $queryBuilder->onlyTrashed();
            }
        }

        $queryBuilder = $this->setFilters($queryBuilder, $searchValue);

        return $queryBuilder->count();
    }

    public function getFilteredList($searchValue, $columnName, $columnSortOrder, $start, $rowperpage, $condition = null)
    {
        $queryBuilder = $this->Entity->select($this->getSelectFields());

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
            ->get();
    }

    public function getDataListActions($records, $routeGroup, $buttons)
    {
        $data_arr = [];
        $id_field = $this->Entity::ID_FIELD;
        $btns = ['view','edit', 'active', 'desactive', 'print', 'archive', 'delete',];

        foreach ($buttons as $index => $value){
            $btn_name = $btns[$index];
            $$btn_name = $value;
        }

        foreach($records as $record){
            $btn_view = isset($view) && $view ? '<li class="m-2">
                    <a href="'. route($routeGroup . '.show', $record->$id_field) .'"
                       class="bs-tooltip"
                       data-toggle="tooltip"
                       data-placement="top" title="Visualizar"
                       data-original-title="Visualizar">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                    </a></li>' : '';
            $btn_edit = isset($edit) && $edit ? '<li class="m-2">
                    <a href="'. route($routeGroup . '.edit', $record->$id_field) .'"
                       class="bs-tooltip"
                       data-toggle="tooltip"
                       data-placement="top" title="Editar"
                       data-original-title="Editar">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg>
                    </a></li>' : '';
            $btn_delete = isset($delete) && $delete ? '<li class="m-2">
                    <a href="javascript:void(0);" class="bs-tooltip del-item"
                       data-action="'. route($routeGroup . '.destroy', $record->$id_field) .'"
                       data-toggle="tooltip"
                       data-placement="top" title="Excluir"
                       data-original-title="Excluir">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                    </a></li>' : '';
            $btn_active = isset($active) && $active ? '<li class="m-2">
                    <a href="javascript:void(0);" class="bs-tooltip active-item"
                       data-action="'. route($routeGroup . '.activate', $record->$id_field) .'"
                       data-toggle="tooltip"
                       data-placement="top" title="Reativar"
                       data-original-title="Reativar">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-refresh-cw"><polyline points="23 4 23 10 17 10"></polyline><polyline points="1 20 1 14 7 14"></polyline><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path></svg>
                    </a></li>' : '';
            $btn_desactive = isset($desactive) && $desactive ? '<li class="m-2">
                    <a href="javascript:void(0);" class="bs-tooltip desactive-item"
                       data-action="'. route($routeGroup . '.desactivate', $record->$id_field) .'"
                       data-toggle="tooltip"
                       data-placement="top" title="Desativar"
                       data-original-title="Desativar">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-octagon"><polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"></polygon><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                    </a></li>' : '';
            $btn_print = isset($print) && $print ? '<li class="m-2">
                    <a href="javascript:void(0);" class="bs-tooltip desactive-item"
                       data-action="'. route($routeGroup . '.print', $record->$id_field) .'"
                       data-toggle="tooltip"
                       data-placement="top" title="Imprimir"
                       data-original-title="Imprimir">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-printer"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
                    </a></li>' : '';
            $btn_archive = isset($archive) && $archive? '<li class="m-2">
                    <a href="javascript:void(0);" class="bs-tooltip desactive-item"
                       data-action="'. route($routeGroup . '.archive', $record->$id_field) .'"
                       data-toggle="tooltip"
                       data-placement="top" title="Arquivar"
                       data-original-title="Arquivar">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-folder"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path></svg>
                    </a></li>' : '';

            $prepareFields = [];
            $prepareFields['action'] = '<ul class="table-controls">';
            foreach ($btns as $action) {
                if(isset($$action) && $$action){
                    $btn = 'btn_' . $action;
                    $prepareFields['action'] .= $$btn;
                }
            }
            $prepareFields['action'] .= '</ul>';
            $prepareFields['DT_RowId'] = $record->$id_field;
            foreach ($record->getAttributes() as $field => $value) {
                $date = \DateTime::createFromFormat('Y-m-d', $value);
                $datetime = \DateTime::createFromFormat('Y-m-d H:i:s', $value);
                if ($date) {
                    $value = $date->format('d/m/Y');
                }
                if($datetime){
                    $value = $datetime->format('d/m/Y H:i:s');
                }
                $prepareFields[$field] = $value;
            }
            $data_arr[] = $prepareFields;
        }
        return $data_arr;
    }

    protected function getSelectFields()
    {
        return collect($this->Entity->fieldList())->filter(function ($item) {
            return $item['query'];
        })->pluck('name')->all();
    }

    protected function setFilters($queryBuilder, $searchValue)
    {
        $queryBuilder->where(function ($query) use ($searchValue) {
            $i = 0;
            $fieldList = Collect($this->Entity->fieldList())->filter(function ($item) {
                return $item['query'];
            })->all();
            foreach ($fieldList as $field) {
                if(is_array($field)){
                    if($i == 0){
                        $query->where($field['name'], 'like', '%' .$searchValue . '%');
                    } else {
                        $query->orWhere($field['name'], 'like', '%' .$searchValue . '%');
                    }
                } else {
                    if($i == 0){
                        $query->where($field, 'like', '%' .$searchValue . '%');
                    } else {
                        $query->orWhere($field, 'like', '%' .$searchValue . '%');
                    }
                } $i++;
            }
        });

        return $queryBuilder;
    }

    public function isValid($data)
    {
        if(isset($data['id'])){
            $this->Entity->id = ($data['id']);
        }

        if(!$this->validateErrors = $this->validateData->check($data, $this->formValidate())){
            return true;
        }

        return false;
    }

    public function getValidateErrors()
    {
        return $this->validateErrors;
    }

    private function formValidate()
    {
        return $this->Entity->dataValidate;
    }

    private function loadData($data)
    {
        $dataForm = [];
        foreach ($this->Entity->getFillable() as $column) {
            $dataForm[$column] = is_object($data) ? $data->$column : $data[$column];
            $date = \DateTime::createFromFormat('d/m/Y', $dataForm[$column]);
            if ($date) {
                $dataForm[$column] = $date->format('Y-m-d');
            }
        }
        return $dataForm;
    }
}
