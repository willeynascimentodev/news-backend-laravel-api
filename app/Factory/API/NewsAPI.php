<?php

namespace App\Factory\API;

use App\Factory\API\API;

class NewsAPI extends API{


    public function prepareUrl($req) {

        $baseUrl = "https://newsapi.org/v2/everything";
        $apiKey = "6cbe95b31cc649eeab6d111af78cc82d";
        $baseUrl .= '?apiKey='.$apiKey;

        //preparing the url params
        $date = $req->date ? '&from='.$req->date : '2020-01-01';
        $keyword = $req->keyword ? '&q='.$req->keyword : '';
        $page = $req->page ? '&page='.$req->page : '';
        $pageSize = '&pageSize=10';
        $sources = $req->sources && count($req->sources) > 0 ?
        '&sources='.$this->arrayToUrl($req->sources) : '';
        
        $baseUrl .= $date.$keyword.$page.$pageSize.trim($sources);

        return $baseUrl;
    }

    public function arrayToUrl($array) {
        $item = '';

        foreach ($array as $a) {
            $a = is_array($a) ? $a['name'] : $a;
            $a = str_replace(' ', '-', $a);
            $a = strtolower($a);
            $item .= ''.$a.',';
        }

        $item = substr($item, 0, -1);
        return $item;
    }

    public function getData ($data, $inPage) {
        $articles = array();

        foreach ($data->articles as $d) {
            $article = (object) array(
                'idInPage' => $inPage,
                'title' => $d->title,
                'category' => 'N/I',
                'date' => substr($d->publishedAt, 0, 10),
                'source' => $d->source->name,
                'link' => $d->url
            );
            $articles['data'][$inPage] = $article;
            $inPage++;
        }

        
        $articles['data'] = $articles;
        $articles['total'] = $data->totalResults;
        $articles['inPage'] = $inPage;

        return $articles;
        
    }

}

