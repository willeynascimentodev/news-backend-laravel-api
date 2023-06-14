<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Factory\API\APIFactory;

use Illuminate\Http\Client\Pool;
use Illuminate\Support\Facades\Http;

class ArticleController extends Controller
{
    public function index(Request $req) {
        $factory = new APIFactory();
        
        $nyTimes = $factory->getClass('NyAPI');
        $nyUrl = $nyTimes->prepareUrl($req);

        $responses = Http::pool(fn (Pool $pool) => [
            $pool->as('nyAPI')->get($nyUrl),
        ]);

        $nyTimesData = $nyTimes->getData(json_decode($responses['nyAPI']->body()));
        
        return response()->json([
            'total' => $nyTimesData['total'],
            'data' => $nyTimesData['data']
        ], 200);

    }
}
