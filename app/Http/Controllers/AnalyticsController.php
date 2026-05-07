<?php

namespace App\Http\Controllers;

use App\Motorista;
use App\SaidaViatura;
use App\Viatura;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
    }

    public function index()
    {
        $category_name = 'estatisticas';
        $page_name = 'dashboard_estatisticas';

        // 1. Quanto cada motorista dirige (Top 10)
        $motoristasKms = SaidaViatura::select('motorista_id', DB::raw('SUM(CAST(hodometro_retorno AS UNSIGNED) - CAST(hodometro_saida AS UNSIGNED)) as total_km'))
            ->whereNotNull('hodometro_retorno')
            ->where('status', SaidaViatura::COMPLETE)
            ->groupBy('motorista_id')
            ->orderBy('total_km', 'desc')
            ->with('motorista')
            ->take(10)
            ->get();

        // 2. Viaturas mais rodadas
        $viaturasMaisRodadas = Viatura::orderBy(DB::raw('CAST(kilometragem AS UNSIGNED)'), 'desc')
            ->take(10)
            ->get();

        // 3. Viaturas mais antigas (baseado no cadastro)
        $viaturasMaisAntigas = Viatura::orderBy('created_at', 'asc')
            ->take(10)
            ->get();

        // 4. KM rodados por dia nos últimos 30 dias
        $kmPorDia = SaidaViatura::select(DB::raw('DATE(created_at) as data'), DB::raw('SUM(CAST(hodometro_retorno AS UNSIGNED) - CAST(hodometro_saida AS UNSIGNED)) as total_km'))
            ->whereNotNull('hodometro_retorno')
            ->where('status', SaidaViatura::COMPLETE)
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('data')
            ->orderBy('data', 'asc')
            ->get();

        return view('analytics.index', [
            'category_name' => $category_name,
            'page_name' => $page_name,
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
            'motoristasKms' => $motoristasKms,
            'viaturasMaisRodadas' => $viaturasMaisRodadas,
            'viaturasMaisAntigas' => $viaturasMaisAntigas,
            'kmPorDia' => $kmPorDia
        ]);
    }
}
