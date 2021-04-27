<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class DataController extends Controller
{
    public function userBalance(array $params)
    {
        if (!isset($params['user_id'])) return ['error' => 'user_id is undefined'];
        $data = DB::selectOne('select * from balance_history where user_id = ? ORDER BY created_at DESC LIMIT 1', [(int) $params['user_id']]);
        return $data;
    }

    public function history(array $params)
    {
        if (!isset($params['limit']) || $params['limit'] > 1000) $params['limit'] = 1000;
        $data = DB::select('select * from balance_history ORDER BY created_at DESC LIMIT ?', [(int) $params['limit']]);
        return ['history' => $data];
    }
}
