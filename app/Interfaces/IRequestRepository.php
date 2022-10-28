<?php

namespace App\Interfaces;

interface IRequestRepository extends IDefaultRepository
{
    public function conditionalList(array $condition);

    public function commissionerApprove($id);

    public function commissionerDesapprove($id);

    public function chiefApprove($id);

    public function chiefDespprove($id);

    public function setMissionStatus($id, $status);

    public function arquivar($id);
}

