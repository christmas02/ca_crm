<?php
namespace App\Helpers;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;

class TauxQualificationHelper
{
	
   //    public function GetAuthenticationToken(){

   //    	 $client = new \GuzzleHttp\Client();
   //    	 $response = $client->request('POST',config('AppConfig.api_passerelle').'oauth/token', [
   //    		   'headers' => [
   //    		        'Authorization' => 'Bearer YOUR_TOKEN_HERE',
   //    		    ],
   //    		    'json' => [
   //             	 		"client_id" => "910d132ecfa20cf6c9f64633bdc023c0e805e8da84fa0bedad0950d2e8a1463c",
   //    					"client_secret" => "652c2a37a8254688d0d3c8c1b1b8d459b6035cfeba0c0c608698318f555d55ec",
   //    					"grant_type"=>"client_credentials" 
   //        		],
   //    		]);
      	
   //    	 $response_api_tok = json_decode($response->getBody(), true);
   //       $tocken_obtenu = $response_api_tok['access_token'];

   //   	   return $tocken_obtenu;
   // }


      public function NbRemonteeProspectorFilter ($tableau, $selectedvalue) {
            foreach($tableau as $index => $tableau_el) {
                if($tableau_el['realiserpar'] == $selectedvalue) return $index;
            }
            return false;
        }



}