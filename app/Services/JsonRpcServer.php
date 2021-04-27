<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Http\Controllers\DataController;
use App\Http\Response\JsonRpcResponse;

class JsonRpcServer
{
    public function handle(Request $request, DataController $controller)
    {
        if ($request->header('AccessToken') != 'Hpd7YBtXPTX6bQV9pe5Rq4MfJQj4Lw86WdbF') return ['error' => 'wrong access token'];
        try {

            $content = json_decode($request->getContent(), true);

            if (empty($content)) {
                throw new \Exception('Parse error');
            }
            $result = $controller->{$content['method']}(...[$content['params']]);

            return JsonRpcResponse::success($result, $content['id']);
        } catch (\Exception $e) {
            return JsonRpcResponse::error($e->getMessage());
        }
    }
}
