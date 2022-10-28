<?php

namespace App\Support;

trait DateTools
{
    public function getFormatDate(String $date)
    {
        $months = [
            'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho',
            'Junlho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'
        ];
        list($Year, $month, $day) = explode('-', $date);
        return "{$day} de {$months[$month - 1]} de {$Year}";
    }
}
