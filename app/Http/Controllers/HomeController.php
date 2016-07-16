<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		//Получаем текущую дату в нужном формате и грузим в массив данные с API за месяц
		$cur_date = new \DateTime();
		$interval = new \DateInterval("P1D");
		$result=[];
		for ($i=0; $i<30; $i++)
		{
		$client = new Client();
		$json = $client->request('GET','http://openrates.in.ua/rates'.'?date='.$cur_date->format('Y-m-d'));
		$result[$i] = json_decode($json->getbody());
		//Если данных по нбу нет берем с предыдущего дняа если это первый день то =0
		if (!property_exists($result[$i]->EUR, 'nbu')) {
			if ($i == 0) 
			{
				$json1='{"USD":{"interbank":{"buy":"'.$result[$i]->USD->interbank->buy.'","sell":"'.$result[$i]->USD->interbank->sell.'"},"nbu":{"buy":"0","sell":"0"}},
				"EUR":{"interbank":{"buy":"'.$result[$i]->EUR->interbank->buy.'","sell":"'.$result[$i]->EUR->interbank->sell.'"},"nbu":{"buy":"0","sell":"0"}},
				"RUB":{"interbank":{"buy":"'.$result[$i]->RUB->interbank->buy.'","sell":"'.$result[$i]->RUB->interbank->sell.'"},"nbu":{"buy":"0","sell":"0"}}}';
			}
			else
			{
				$json1='{"USD":{"interbank":{"buy":"'.$result[$i]->USD->interbank->buy.'","sell":"'.$result[$i]->USD->interbank->sell.'"},"nbu":{"buy":"'.$result[$i-1]->USD->nbu->buy.'","sell":"'.$result[$i-1]->USD->nbu->sell.'"}},
				"EUR":{"interbank":{"buy":"'.$result[$i]->EUR->interbank->buy.'","sell":"'.$result[$i]->EUR->interbank->sell.'"},"nbu":{"buy":"'.$result[$i-1]->EUR->nbu->buy.'","sell":"'.$result[$i-1]->EUR->nbu->sell.'"}},
				"RUB":{"interbank":{"buy":"'.$result[$i]->RUB->interbank->buy.'","sell":"'.$result[$i]->RUB->interbank->sell.'"},"nbu":{"buy":"'.$result[$i-1]->RUB->nbu->buy.'","sell":"'.$result[$i-1]->RUB->nbu->sell.'"}}}';
				
			}
			$result[$i] = json_decode($json1);
			
		}
		
        $n_date[$i]=$cur_date->format('Y-m-d');
		
		$cur_date->sub($interval);
		
		}
		//узнаем сегодняшние котировки
		$client = new Client();
		$json = $client->request('GET','http://openrates.in.ua/rates');
		$results = json_decode($json->getbody());
	   return view('home')->with([
	   'results' => $results,
	   'result' => $result,
	   'n_date' => $n_date
	   ]);
    }
}
