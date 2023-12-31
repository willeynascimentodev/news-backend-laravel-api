<?php

namespace App\Factory\API;

use App\Factory\API\NyAPI;
use App\Factory\API\NewsAPI;
use App\Factory\API\TheGuardianAPI;

class APIFactory{
    public function getClass($class) {
        switch($class) {
            case 'NyAPI':
                return new NyAPI();
                    break;
            case 'NewsAPI':
                return new NewsAPI();
                    break;
            case 'TheGuardian':
                return new TheGuardianAPI();
                    break;
        }
    }
}