<?php

namespace App\Interfaces;

interface IDefaultRepository
{
    public function list();

    public function get($id);

    public function getFieldList();

    public function create($data);

    public function update($data, $id);

    public function delete($id);

    public function getTotalRecords($searchValue = null, $isFiltered = false, $condition = null);

    public function getFilteredList($searchValue, $columnName, $columnSortOrder, $start, $rowperpage, $condition = null);

    public function getDataListActions($records, $routeGroup, $buttons);

    public function isValid($data);

    public function getValidateErrors();
}
