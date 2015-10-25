<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH . '/libraries/REST_Controller.php';

class User_track extends REST_Controller {

    function __construct($config = 'rest') {

        parent::__construct($config);

        $this->auth = new stdClass;

        $this->load->helper('polylineencoder_helper');
        $this->load->model('user_accounts_model');
        $this->load->model('things_model');
        $this->load->model('user_walk_model');
        $this->load->model('user_walk_thing_model');
    }
    
    public function map_filled_get() {
        //https://maps.googleapis.com/maps/api/staticmap?center=43.463310,%20-80.525736&zoom=13&size=600x300&maptype=roadmap&markers=color:blue%7Clabel:S%7C40.702147,-74.015794&markers=color:green%7Clabel:G%7C40.711614,-74.012318&markers=color:red%7Clabel:C%7C40.718217,-73.998284&key=AIzaSyBM-g5g2KBvvQ1H8eLlyVET1ALlh9uKPiE
        
        $markers = $this->user_walk_model->get_all();
       // $things = $this->things_model->get_all();
        
        $str = array();;
        
        foreach($markers as $marker) {
            $str[] = $marker->usw_lat . "," . $marker->usw_lng;
        }
        
        $icon = "http://goo.gl/X5ePpN";        
        $markersFinal = "&markers=icon:$icon" . "%257C996600" . implode("&markers=icon:$icon" . "%257C996600", $str);
        
        //$markersFinal = "&markers=" . implode("&markers=", $str);
        
        $apiKey = "AIzaSyBM-g5g2KBvvQ1H8eLlyVET1ALlh9uKPiE";
        $urlFinal = "https://maps.googleapis.com/maps/api/staticmap?center=43.463310,%20-80.525736&zoom=13&size=600x300&maptype=roadmap". $markersFinal ."&key=" . $apiKey;
        
        //echo $urlFinal;
        
        // set some options
        $mapLat = '43.463310'; // latitude for map's and circle's center
        $mapLng = '-80.525736'; // longitude for map's and circle's center
        $mapRadius1 = 2; // the radius of the first circle (in Kilometres)
        $mapRadius2 = 5; // the radius of the second circle (in Kilometres)
        $mapFill_first = '000000'; // fill colour of the first circle
        $mapFill_second = '000000'; // fill colour of the second circle
        $map1Border1 = '0000CC'; // border colour of the first circle
        $map1Border2 = '0000CC'; // border colour of the second circle
        $mapWidth = 900; // map image width (max 640px)
        $mapHeight = 800; // map image height (max 640px)
        $zoom = 11;
        $scale = 4;
        $EncString1 = $this->GMapCircle($mapLat, $mapLng, $mapRadius1);
        $EncString2 = $this->GMapCircle($mapLat, $mapLng, $mapRadius2);
        
        if(!$this->get("no_marks")) { 
            $MapAPI = 'http://maps.google.com.au/maps/api/staticmap?style=element:labels|visibility:off&style=element:geometry.stroke|visibility:off&style=feature:all|visibility:off&style=feature:water|visibility:off|invert_lightness:true&';
            $MapURL = $MapAPI . 'center=' . $mapLat . ',' . $mapLng . '&zoom=' . $zoom . '&size=' .
                $mapWidth . 'x' . $mapHeight . '&scale=' . $scale . '&markers=color:red%7Clabel:S%7C'.$mapLat.','.$mapLng . '&maptype=roadmap';
            
            foreach($markers as $marker) {
                $MapURL .= '&path=color:0x00000099|weight:90|fillcolor:0x00000099|enc:' . $this->GMapCircle($marker->usw_lat, $marker->usw_lng, $mapRadius1);
            }
        } else {
            $MapAPI = 'http://maps.google.com.au/maps/api/staticmap?style=element:labels|visibility:true&';
            
            $MapURL = $MapAPI . 'center=' . $mapLat . ',' . $mapLng . '&zoom=' . $zoom . '&size=' .
            $mapWidth . 'x' . $mapHeight . '&scale=' . $scale . '&markers=color:red%7Clabel:S%7C'.$mapLat.','.$mapLng .
            '&maptype=roadmap';
            
          /*  foreach($things as $thing) { 
                $geo = unserialize($thing->tgh_geo);                
                $MapURL .= "&markers=size:mid|color:red|" . $geo['location']['lat'] . "," . $geo['location']['lng'];
                break;
            }*/
        
        }
        
        //&path=fillcolor:0x' .
          //  $mapFill_second . '33%7Ccolor:0x' . $map1Border2 . '00%7Cenc:' . $EncString2;

        //echo '<img src="' . $MapURL . '" />';
        echo file_get_contents($MapURL);
        
    }
    

    function GMapCircle($Lat, $Lng, $Rad, $Detail = 8)
    {
        $R = 6371;
        $pi = pi();
        $Lat = ($Lat * $pi) / 180;
        $Lng = ($Lng * $pi) / 180;
        $d = $Rad / $R;
        $points = array();
        for ($i = 0; $i <= 360; $i += $Detail)
        {
            $brng = $i * $pi / 180;
            $pLat = asin(sin($Lat) * cos($d) + cos($Lat) * sin($d) * cos($brng));
            $pLng = (($Lng + atan2(sin($brng) * sin($d) * cos($Lat), cos($d) - sin($Lat) * sin($pLat))) * 180) / $pi;
            $pLat = ($pLat * 180) / $pi;
            $points[] = array($pLat, $pLng);
        }

        $PolyEnc = new PolylineEncoder($points);
        $EncString = $PolyEnc->dpEncode();

        return $EncString['Points'];
    }

    
    public function walk_history_get() {
        $user_id = $this->get("user_id");
        
        if ($user_id) {
            // check if this user exists
            if ($this->user_accounts_model->get_by_id($user_id)) {
                $this->response(array("status" => true, "history" => $this->user_walk_model->get_all_by_userid($user_id)), 200);
            }
        }
        
        $this->response(array("status" => false), 403);
    }
    
    public function walk_thing_history_get() {
        $user_id = $this->get("user_id");
        
        if ($user_id) {
            // check if this user exists
            if ($this->user_accounts_model->get_by_id($user_id)) {
                $this->response(array("status" => true, "history" => $this->user_walk_thing_model->get_all_by_userid($user_id)), 200);
            }
        }
        
        $this->response(array("status" => false), 403);
    }

    public function walk_post() {
        $user_id = $this->post("user_id");
        $geo_lat = $this->post("lat");
        $geo_lng = $this->post("lng");

        if ($user_id && $geo_lat && $geo_lng) {
            // check if this user exists
            if ($this->user_accounts_model->get_by_id($user_id)) {
                // save info
                $data = array("usw_uacc_id" => $user_id,
                    "usw_lat" => $geo_lat,
                    "usw_lng" => $geo_lng,
                    "usw_date_added" => date("Y-m-d H:i:s", time()));

                $this->user_walk_model->insert($data);

                $this->response(array("status" => true), 200);
            }
        }

        $this->response(array("status" => false), 403);
    }

    public function walk_thing_post() {
        $user_id = $this->post("user_id");
        $geo_lat = $this->post("lat");
        $geo_lng = $this->post("lng");
        $thing_id = $this->post("thing_id");

        if ($user_id && $geo_lat && $geo_lng) {
            // check if this user exists
            if ($this->user_accounts_model->get_by_id($user_id)) {
                // check if the thing exists
                if ($this->things_model->get_by_id($thing_id)) {
                    // save info
                    $data = array("uwt_uacc_id" => $user_id,
                        "uwt_lat" => $geo_lat,
                        "uwt_lng" => $geo_lng,
                        "uwt_thg_id" => $thing_id,
                        "uwt_date_added" => date("Y-m-d H:i:s", time()));

                    $this->user_walk_thing_model->insert($data);

                    $this->response(array("status" => true), 200);
                }
            }
        }

        $this->response(array("status" => false), 403);
    }

}
