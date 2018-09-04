<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Redirect;

//Models
use App\Address;

class HomeController extends Controller
{

    private $api_key = '';

    function __construct() {
        $this->api_key = 'AIzaSyClj_r-U79Yigh5vQonwrnuupxE9M_KKdc';
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function callApi(Request $request){

        $validator = Validator::make($request->all(), [
            'address' => 'required',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }

        $address_field = $request->address;
        $apikey = $this->api_key;
        $url = "https://maps.googleapis.com/maps/api/place/queryautocomplete/xml?&key=" . $apikey . "&input=" . $address_field;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($ch); //dd($data);
        curl_close($ch);

        $details = $array = json_decode(json_encode(simplexml_load_string($data)), true);
        //dd($details);

        if($details['status'] == 'OK') {
            if(count($details['prediction'])) {

                $call = new Address;
                $call->description = $details['prediction'][0]['description'];
                $call->save();

                return view('home', ['description' => $details['prediction'][0]['description']]);
            }

        } else {

            //do nothing

        }

    }
}
