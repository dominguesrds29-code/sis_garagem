<?php

namespace App\Support;

trait DataList
{
    /**
     * @param array $fieldList
     * @return array
     */
    public function getHeads(Array $fieldList)
    {
        $heads = [];

        foreach ($fieldList as $field) {
            if(is_array($field)){
                if(!$field['table']) continue;
                $width = $field['width'] ?? '';
                $heads[] = ['label' => $field['label'], 'width' => $width];
            } else {
                $heads[] = $field;
            }
        }
        $heads[] = ['label' => 'Ações', 'no-export' => true, 'width' => 10];

        return $heads;
    }

    public function getConfig(Array $fieldList, String $route, $orderColumn = [0, 'asc'])
    {
        $config = [
            'order' => [$orderColumn],
            'oLanguage' => [
                'oPaginate' => [
                    'sPrevious' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
                    'sNext' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'
                ],
                'sInfo' => "Mostrando página _PAGE_ de _PAGES_",
                'sSearch' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                'sSearchPlaceholder' => "Pesquisar... ",
                'sLengthMenu' => "Resultados:  _MENU_",
                'sInfoEmpty' => "Não há dados",
                'sFilter' => "Mostrando página _PAGE_ de _PAGES_",
                'sInfoFiltered' => "(filtrado de um total de _MAX_ valores)",
                'sLoadingRecords' => "Carregando...",
                'sProcessing' => "Processando...",
                'sZeroRecords' => "Não há dados a serem visualizados"
            ],
            'lengthMenu' => [5, 10, 20, 50],
            'pageLength' => 10,
            'processing' => true,
            'serverSide' => true,
            'ajax' => ['url' => route($route), 'type' => 'POST', 'dataType' => 'JSON'],
        ];

        foreach ($fieldList as $field) {
            if(is_array($field)){
                if(!$field['table']) continue;
                $col = ['data' => $field['name']];
                if (isset($field['orderable'])) {
                    $col['orderable'] = $field['orderable'];
                }
                $config['columns'][] = $col;
            } else {
                $config['columns'][] = $field;
            }
        }
        $config['columns'][] = ['data' => 'action', 'orderable' => false ];

        return $config;
    }
}
