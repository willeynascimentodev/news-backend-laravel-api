<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Factory\API\APIFactory;

use Illuminate\Http\Client\Pool;
use Illuminate\Support\Facades\Http;

use App\Models\User;

class ArticleController extends Controller
{
    public function index(Request $req) {
        $factory = new APIFactory();
        
        $nyTimes = $factory->getClass('NyAPI');
        $nyUrl = $nyTimes->prepareUrl($req);

        $newsAPI = $factory->getClass('NewsAPI');
        $newsUrl = $newsAPI->prepareUrl($req);

        $guardianAPI = $factory->getClass('TheGuardian');
        $guardianUrl = $guardianAPI->prepareUrl($req);

        try {
            $responses = Http::pool(fn (Pool $pool) => [
                $pool->as('nyAPI')->get($nyUrl),
                $pool->as('newsAPI')->get($newsUrl),
                $pool->as('guardianAPI')->get($guardianUrl)
            ]);
    
            $data = array();
            $data['data'] = [];
            $data['total'] = 0;
            $data['inPage'] = 0;
    
            $nyTimesData = [];
            if (isset($responses['nyAPI']) && $responses['nyAPI']->ok()) {
                $nyTimesData = $nyTimes->getData(json_decode($responses['nyAPI']->body()), $data['inPage']);
                
                
                $data['data'] = isset($nyTimesData['data']['data']) ?
                    array_merge($data['data'], $nyTimesData['data']['data']) : [];
                $data['total'] += $nyTimesData['total'];
                $data['inPage'] = $nyTimesData['inPage'];
            }
            
            $newsAPIData = [];
            if (isset($responses['newsAPI']) && $responses['newsAPI']->ok()) {
                $newsAPIData = $newsAPI->getData(json_decode($responses['newsAPI']->body()), $data['inPage']);
                
                $data['data'] = isset($newsAPIData['data']['data']) ?
                    array_merge($data['data'], $newsAPIData['data']['data']) : [];
                $data['total'] += $newsAPIData['total'];
                $data['inPage'] = $newsAPIData['inPage'];
            }
            
            $guardianAPIData = [];
            if ($responses['guardianAPI']->ok()) {
                $guardianAPIData = $guardianAPI->getData(json_decode($responses['guardianAPI']->body()), $data['inPage']);
                
                $data['data'] = isset($guardianAPIData['data']['data']) ?
                    array_merge($data['data'], $guardianAPIData['data']['data']) : [];
                $data['total'] += $guardianAPIData['total'];
                $data['inPage'] = $guardianAPIData['inPage'];
            }
            
            return response()->json([
                'total' => $data['total'],
                'inPage' => $data['inPage'],
                'data' => $data['data']
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }

    }

    public function feed(Request $req) {
        $filters = User::getFilters();
        
        $request['categories'] = $filters['data']['categories'];
        $request['sources'] = $filters['data']['sources'];
        $request['authors'] = $filters['data']['authors'];
        
        $req->merge($request);
        
        return $this->index($req);
    }
}
