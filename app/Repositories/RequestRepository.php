<?php

namespace App\Repositories;
use App\Interfaces\IRequestRepository;
use App\Interfaces\IValidator;
use App\Motorista;
use App\Solicitacao;
use App\User;
use App\Viatura;

class RequestRepository extends DefaultRepository implements IRequestRepository
{

    public function __construct(IValidator $validateData, Solicitacao $entity)
    {
        $this->Entity = $entity;
        $this->validateData = $validateData;
        $this->validateErrors = [];
    }

    public function conditionalList(array $condition)
    {
        $icons = [
            '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clock text-info"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>',
            '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-thumbs-up text-success"><path d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"></path></svg>',
            '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-thumbs-down text-danger"><path d="M10 15v4a3 3 0 0 0 3 3l4-9V2H5.72a2 2 0 0 0-2 1.7l-1.38 9a2 2 0 0 0 2 2.3zm7-13h2.67A2.31 2.31 0 0 1 22 4v7a2.31 2.31 0 0 1-2.33 2H17"></path></svg>'
        ];

        $status = [
            '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clock text-info"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>',
            '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-square text-success"><polyline points="9 11 12 14 22 4"></polyline><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path></svg>',
            '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-triangle text-warning"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>'
        ];


        return $this->Entity->where($condition)->get()->map(function ($item) use($icons, $status) {
            return [
                'id' => $item->id,
                'solicitante' => $item->solicitante,
                'created_at' => date('d/m/Y H:i:s', strtotime($item->created_at)),
                'dt_inicio' => date('d/m/Y', strtotime($item->dt_inicio)),
                'dt_final' => date('d/m/Y', strtotime($item->dt_final)),
                'viatura_id' => Viatura::find($item->viatura_id) ? Viatura::find($item->viatura_id)->modelo :
                    "Desconhecida [ID: {$item->viatura_id}]",
                'motorista_id' => Motorista::find($item->motorista_id)->user_war_name,
                'encarregado_aut' => $icons[$item->encarregado_aut],
                'chefe_aut' => $icons[$item->chefe_aut],
                'status_missao' => $status[$item->status_missao],
            ];
        });
    }

    public function commissionerApprove($id)
    {

        $this->Entity->where('id', $id)->update(['encarregado' => auth()->user()->id, 'encarregado_aut' => $this->Entity::AUTORIZADA]);
        return true;
    }

    public function commissionerDesapprove($id)
    {
        $this->Entity->where('id', $id)->update(['encarregado' => auth()->user()->id, 'encarregado_aut' => $this->Entity::NEGADA]);
        return true;
    }

    public function chiefApprove($id)
    {
        $this->Entity->where('id', $id)->update(['chefe' => auth()->user()->id, 'chefe_aut' => $this->Entity::AUTORIZADA]);
        return true;
    }

    public function chiefDespprove($id)
    {
        $this->Entity->where('id', $id)->update(['chefe' => auth()->user()->id, 'chefe_aut' => $this->Entity::NEGADA]);
        return true;
    }

    public function setMissionStatus($id, $status)
    {
        $this->Entity->where('id', $id)->update(['status_missao' => $status]);
        return true;
    }

    public function arquivar($id)
    {
        $this->Entity->where('id', $id)->update(['arquivo' => date('Y-m-d H:i:s')]);
        return true;
    }

    public function getDataListActions($records, $routeGroup, $buttons)
    {
        $data_arr = [];
        $id_field = $this->Entity::ID_FIELD;

        $btns = ['view','edit', 'active', 'desactive', 'print', 'archive','delete',];

        foreach ($buttons as $index => $value){
            $btn_name = $btns[$index];
            $$btn_name = $value;
        }
        $logged = User::find(auth()->user()->id);
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

            $btn_active = ($logged->can('request-approve-commissioner') && !$logged->hasRole('super-admin') && $record['encarregado_aut'] != 0) ? '' :
                (isset($active) && $active ? '<li class="m-2">
                    <a href="javascript:void(0);" class="bs-tooltip approve-item"
                       data-action="'. route($routeGroup . '.approve', $record->$id_field) .'"
                       data-toggle="tooltip"
                       data-placement="top" title="Aprovar"
                       data-original-title="Aprovar">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                    </a></li>' : '');
            $btn_desactive = ($logged->can('request-desapprove-commissioner') && !$logged->hasRole('super-admin') && $record['encarregado_aut'] != 0) ? '' :
                (isset($desactive) && $desactive ? '<li class="m-2">
                    <a href="javascript:void(0);" class="bs-tooltip desapprove-item"
                       data-action="'. route($routeGroup . '.desapprove', $record->$id_field) .'"
                       data-toggle="tooltip"
                       data-placement="top" title="Reprovar"
                       data-original-title="Reprovar">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-slash"><circle cx="12" cy="12" r="10"></circle><line x1="4.93" y1="4.93" x2="19.07" y2="19.07"></line></svg>
                    </a></li>' : '');
            $btn_print = isset($print) && $print ? '<li class="m-2">
                    <a href="'. route($routeGroup . '.print', $record->$id_field) .'" class="bs-tooltip print-item"
                       target="_blank"
                       data-toggle="tooltip"
                       data-placement="top" title="Imprimir"
                       data-original-title="Imprimir">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-printer"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
                    </a></li>' : '';
            $btn_archive = isset($archive) && $archive? '<li class="m-2">
                    <a href="javascript:void(0);" class="bs-tooltip archive-item"
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
                switch ($field){
                    case 'viatura_id':
                        if($viatura = Viatura::find($value)){
                            $prepareFields[$field] = $viatura->modelo;
                        } else $prepareFields[$field] = "Desconhecida [ID:{$value}]";
                        break;
                    case 'motorista_id':
                        if($motorista = Motorista::find($value)){
                            $prepareFields[$field] = $motorista->user_war_name;;
                        } else $prepareFields[$field] = "Desconhecido [ID:{$value}]";
                        break;
                    case 'encarregado_aut':
                    case 'chefe_aut':
                        $icons = [
                            '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clock text-info"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>',
                            '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-thumbs-up text-success"><path d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"></path></svg>',
                            '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-thumbs-down text-danger"><path d="M10 15v4a3 3 0 0 0 3 3l4-9V2H5.72a2 2 0 0 0-2 1.7l-1.38 9a2 2 0 0 0 2 2.3zm7-13h2.67A2.31 2.31 0 0 1 22 4v7a2.31 2.31 0 0 1-2.33 2H17"></path></svg>'
                        ];
                        $prepareFields[$field] = $icons[$value];
                        break;
                    case 'status_missao':
                        $icons = [
                            '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clock text-info"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>',
                            '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-square text-success"><polyline points="9 11 12 14 22 4"></polyline><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path></svg>',
                            '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-triangle text-warning"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>'
                        ];
                        $prepareFields[$field] = $icons[$value];
                        break;
                    default:
                        $prepareFields[$field] = $value;
                }
            }
            $data_arr[] = $prepareFields;
        }
        return $data_arr;
    }
}
