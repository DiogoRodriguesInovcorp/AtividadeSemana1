<?php

use App\Models\Log;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Auth;

if (!function_exists('logAction')) {
    function logAction($modulo, $objeto_id, $alteracao)
    {
        Log::create([
            'user_id' => Auth::id(),
            'modulo' => $modulo,
            'objeto_id' => $objeto_id,
            'acao' => $acao ?? 'Ação não especificada',
            'ip' => Request::ip(),
            'browser' => request()->header('User-Agent') ?? 'test-agent',
        ]);
    }
}
