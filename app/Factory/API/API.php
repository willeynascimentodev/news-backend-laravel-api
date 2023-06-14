<?php

namespace App\Factory\API;

abstract class API {
    protected $url;
    protected $apiKey;

    public function getUrl() {
        return $this->url;
    }

    public function setUrl($url) {
        $this->url = $url;
    }

    public function getApiKey() {
        return $this->apiKey;
    }

    public function setApiKey($apiKey) {
        $this->apiKey = $apiKey;
    }


    abstract public function prepareUrl($req);

    abstract public function getData($payload);

    abstract public function arrayToUrl($array);

}