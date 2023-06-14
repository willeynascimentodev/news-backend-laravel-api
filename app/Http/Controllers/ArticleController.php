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

        $newsAPI = $factory->getClass('NewsAPI');
        $newsUrl = $newsAPI->prepareUrl($req);
        
        $responses = Http::pool(fn (Pool $pool) => [
            $pool->as('nyAPI')->get($nyUrl),
            $pool->as('newsAPI')->get($newsUrl)
        ]);

        $data = array();
        $data['data'] = [];
        $data['total'] = 0;
        $data['inPage'] = 0;

        $nyTimesData = [];
        if ($responses['nyAPI']->ok()) {
            $nyTimesData = $nyTimes->getData(json_decode($responses['nyAPI']->body()));

            $data['data'] = array_merge($data['data'], $nyTimesData['data']);
            $data['total'] += $nyTimesData['total'];
            $data['inPage'] += $nyTimesData['inPage'];
        }
        $newsAPIData = [];
        if ($responses['newsAPI']->ok()) {
            $newsAPIData = $newsAPI->getData(json_decode($responses['newsAPI']->body()));
            
            $data['data'] = array_merge($data['data'], $newsAPIData['data']);
            $data['total'] += $newsAPIData['total'];
            $data['inPage'] += $newsAPIData['inPage'];
        }
        
        return response()->json([
            'total' => $data['total'],
            'inPage' => $data['inPage'],
            'data' => $data['data']
        ], 200);

    }
}
