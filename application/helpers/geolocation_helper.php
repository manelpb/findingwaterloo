<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Get Geo Location by Given/Current IP address
 *
 * @access    public
 * @param    string
 * @return    array
 */
if (!function_exists('get_geolocation')) {

    function get_geolocation($address) {
        
        $google_api = "AIzaSyA3q-E_5ydFcm9BSzW3hSpLcIk1U9Gp6FQ";
        
        $address_trans = urlencode(utf8_encode($address));

        // Desired address
        $address_final = "https://maps.googleapis.com/maps/api/geocode/xml?address=". $address_trans ."&sensor=false&key=" . $google_api;
        
        $d = file_get_contents($address_final);
        $xml = new SimpleXMLElement($d);
        
        $arResult = array(
                        "address" => (string)$xml->result->formatted_address,
                        "geometry" => 
                            array("location" => 
                                array(
                                    "lat" => (string)$xml->result->geometry->location->lat,
                                    "lng" => (string)$xml->result->geometry->location->lng
                                    )
                                )
                        );
        
        //print_R($xml);
        //print_R($arResult);
        
        return $arResult;
    }
}