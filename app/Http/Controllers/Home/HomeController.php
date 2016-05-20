<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Film;
use App\Http\Controllers\Controller;
use Symfony\Component\Console\Input\Input;
use Symfony\Component\DomCrawler\Crawler;
use GuzzleHttp\Client;

class HomeController extends Controller
{
    public function index(){

    }

    private function get_page($url){
        $client = new Client(['base_uri' => 'http://fs.to']);
        $rusult = $client->get($url);

        $body = $rusult->getBody();

        $stringBody = (string) $body;

        return($stringBody);
    }

    private function get_page_info($html){
        $crawler = new Crawler($html);

        $info_block = self::removeSpaces($crawler->filter('.item-info tr')->eq(2)->filter('td')->eq(1)->text());

        $name = self::removeSpaces($crawler->filter('.b-tab-item__title-inner > span')->text());

        $poster = $crawler->filter('.poster-main img')->attr('src');

        $season = explode('сезон ', explode('серия', $info_block)[0])[1];

        $series = explode('серия', $info_block)[1];

        return array(
            'name' => $name,
            'poster' => $poster,
            'season' => $season,
            'series' => $series
        );
    }

    public function get_token(){
        return json_encode(array(
            'token' => csrf_token()
        ));
    }

    private function removeSpaces($string){
        return trim(preg_replace('/\t+/', '', $string));
    }
    
    public function add_film(Request $request){
        if($request->has('filmUrl')){
            $html = self::get_page($request->filmUrl);

            if(!empty($html)){
                $page_info = self::get_page_info($html);

                $film = Film::create($page_info);

                $film->save();

                return response()->json(array(
                    'film' => $film
                ));
            }
        }

        return json_encode(array(
            'error' => 'Error Not Found "filmUrl" as parameter!'
        ));
    }

    public function get_last_film(){
        return response()->json(Film::all()->last());
    }
    
    public function get_films(){
        return response()->json(Film::all()->toArray());
    }
}
