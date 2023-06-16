<?php

namespace App\Factory\API;

use App\Factory\API\API;

class TheGuardianAPI extends API{


    public function prepareUrl($req) {

        $baseUrl = "https://content.guardianapis.com/search";
        $apiKey = "test";
        $baseUrl .= '?api-key='.$apiKey;

        //preparing the url params
        $date = $req->date ? '&from-date='.$req->date : '2020-01-01';
        $keyword = $req->keyword ? '&q='.$req->keyword : '';
        $page = $req->page ? '&page='.$req->page : '';
        $showTags = '&show-tags=contributor&';
        
        $categories = $req->categories && count($req->categories) > 0 ?
            'section='.$this->arrayToUrl($req->categories).'' : '';
        
        $baseUrl .= $date.$keyword.$page.$showTags.trim($categories);
        
        return $baseUrl;
    }

    public function arrayToUrl($array) {
        $item = '';

        foreach ($array as $a) {
            $a = is_array($a) ? $a['name'] : $a;
            $a = str_replace(' ', '-', $a);
            $a = strtolower($a);

            $item .= ''.$a.'|';
        }
        $item = substr($item, 0, -1);
        return $item;
    }

    public function getData($data, $inPage) {
        $articles = array();
        
        foreach ($data->response->results as $d) {
            $article = (object) array(
                'idInPage' => $inPage,
                'title' => $d->webTitle,
                'category' => $d->sectionName,
                'date' => substr($d->webPublicationDate, 0, 10),
                'source' => 'N/I',
                'link' => $d->webUrl
            );
            $articles['data'][$inPage] = $article;
            $inPage++;
        }

        $articles['data'] = $articles;
        $articles['total'] = $data->response->total;
        $articles['inPage'] = $inPage;

        return $articles;
        
    }

}

