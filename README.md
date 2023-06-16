<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About News Agregator 

It is an application that gathers news and article information from various API's and provides it in a single user interface. Some of the API's used:

- [NewsAPI]([https://laravel.com/docs/routing](https://newsapi.org/)).
- [New York Times API]([https://laravel.com/docs/container](https://developer.nytimes.com/docs/articlesearch-product/1/overview)).
- [The GUardian]([https://laravel.com/docs/queues](https://open-platform.theguardian.com/documentation/)).

## Estrutura

In this project, it was necessary to implement integrations with more than 1 API in different ways. It fit very well with the Factory Method Design Pattern. In this way, it was possible to instantiate objects of the same class (API) but with different behaviors. It was a great way to preserve SOLID's Individual Responsibility and Open Closed principles.


## Installation Guide

1 - Make sure the port 8000 is open (You can also configure other ports, but if you use the default one, it won't be necessary to change it in the react project).
2 - Run the setup.sh file that you will find in the root directory. It will be responsible for prepare the docker. 
3 - If you haven't installed the backend yet, follow the tutorial at this link: [Frontend]([[https://reactjs.org/](https://github.com/willeynascimentodev/news-backend-laravel-api)](https://github.com/willeynascimentodev/react-news-app)).

### Requirements
1 - Docker
2 - Docker Compose
