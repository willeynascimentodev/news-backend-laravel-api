<?php

namespace App\Factory\API;

use App\Factory\API\API;

class NyAPI extends API{


    public function prepareUrl ($req) {

        $baseUrl = "https://api.nytimes.com/svc/search/v2/articlesearch.json";
        $apiKey = "wv5D9AqsM6NoPs4wb5obhGc5qKvqKOI6";
        $baseUrl .= '?api-key='.$apiKey;

        //preparing the url params
        $date = $req->date ? '&begin_date='.str_replace('-', '', $req->date) : '2020-01-01';
        $keyword = $req->keyword ? '&q='.$req->keyword : '';
        $page = $req->page ? '&page='.$req->page : '';

        $categories = $req->categories && count($req->categories) > 0 ?
            'section_name.contains:('.$this->arrayToUrl($req->categories).') AND ' : '';
        
        $sources = $req->sources && count($req->sources) > 0 ?
            'source.contains:('.$this->arrayToUrl($req->sources).') AND ' : '';
        
        $baseUrl .= $date.$keyword.$page.'&fq='.trim($categories.$sources);
        
        $lastLetters = substr($baseUrl, strlen($baseUrl) - 3);
        $baseUrl = $lastLetters == "AND" ? substr($baseUrl, 0, -3) : $baseUrl;

        return $baseUrl;
    }

    public function arrayToUrl($array) {
        $item = '';

        foreach ($array as $a) {
            $item .= '"'.$a.'",';
        }
        $item = substr($item, 0, -1);
        return $item;
    }

    public function getData($data) {
        $articles = array();
        $inPage = 0;

        foreach ($data->response->docs as $d) {
            $article = (object) array(
                'title' => $d->abstract,
                'category' => $d->section_name,
                'date' => substr($d->pub_date, 0, 10),
                'source' => $d->source,
                'link' => $d->web_url
            );
            $articles['data'][] = $article;
            $inPage++;
        }

        $articles['data'] = $articles;
        $articles['total'] = $data->response->meta->hits;
        $articles['inPage'] = $inPage;

        return $articles;
        
    }

}

