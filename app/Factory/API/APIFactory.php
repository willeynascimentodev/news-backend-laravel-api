<?php

namespace App\Factory\API;

use App\Factory\API\NyAPI;

class APIFactory{
    public function getClass($class) {
        switch($class) {
            case 'NyAPI':
                return new NyAPI();
                    break;
        }
    }
}