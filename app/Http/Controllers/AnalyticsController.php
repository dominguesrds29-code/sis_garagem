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
        $this->middleware('role:super-admin|admin');
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

        // 5. Uso de Viaturas (Quantidade de Vezes Utilizada)
        $usoViaturas = DB::table('saida_viaturas')
            ->join('viaturas', 'saida_viaturas.viatura_id', '=', 'viaturas.id')
            ->select('viaturas.modelo', DB::raw('count(saida_viaturas.id) as total'))
            ->whereNull('saida_viaturas.deleted_at')
            ->groupBy('viaturas.id', 'viaturas.modelo')
            ->get();

        $usoViaturasModelos = $usoViaturas->pluck('modelo')->toArray();
        $usoViaturasTotais = $usoViaturas->pluck('total')->map(function($val) { return (int) $val; })->values()->toArray();

        // 6. Histórico de Saídas por Mês
        $saidasMes = DB::table('saida_viaturas')
            ->select(DB::raw('DATE_FORMAT(created_at, "%m/%Y") as data'), DB::raw('count(id) as total'))
            ->whereNull('deleted_at')
            ->groupBy('data')
            ->orderBy(DB::raw('MIN(created_at)'), 'asc')
            ->get();

        $saidasMesDatas = $saidasMes->pluck('data')->toArray();
        $saidasMesTotais = $saidasMes->pluck('total')->map(function($val) { return (int) $val; })->values()->toArray();

        // 7. Todas as viaturas para o dropdown de filtro
        $viaturas = Viatura::orderBy('modelo', 'asc')->get();

        return view('analytics.index', [
            'category_name' => $category_name,
            'page_name' => $page_name,
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
            'motoristasKms' => $motoristasKms,
            'viaturasMaisRodadas' => $viaturasMaisRodadas,
            'viaturasMaisAntigas' => $viaturasMaisAntigas,
            'kmPorDia' => $kmPorDia,
            'usoViaturasModelos' => $usoViaturasModelos,
            'usoViaturasTotais' => $usoViaturasTotais,
            'saidasMesDatas' => $saidasMesDatas,
            'saidasMesTotais' => $saidasMesTotais,
            'viaturas' => $viaturas,
        ]);
    }

    public function getKmPorDia($viatura_id)
    {
        $query = SaidaViatura::select(DB::raw('DATE(created_at) as data'), DB::raw('SUM(CAST(hodometro_retorno AS UNSIGNED) - CAST(hodometro_saida AS UNSIGNED)) as total_km'))
            ->whereNotNull('hodometro_retorno')
            ->where('status', SaidaViatura::COMPLETE)
            ->where('created_at', '>=', now()->subDays(30));

        if ($viatura_id !== 'all') {
            $query->where('viatura_id', $viatura_id);
        }

        $kmPorDia = $query->groupBy('data')
            ->orderBy('data', 'asc')
            ->get();

        return response()->json([
            'labels' => $kmPorDia->pluck('data'),
            'values' => $kmPorDia->pluck('total_km')->map(fn($v) => (float)$v)
        ]);
    }
}
