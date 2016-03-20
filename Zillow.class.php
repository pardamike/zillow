<?php

// Zillow class for making calls to Zillow web service
class Zillow {
    
    // Your Zillow API Key here:
    private $zillow_key; 
    private $searchEndpoint;
    private $chartEndpoint;
    private $detailsEndpoint;
    public $returnInfo;
    public $zpid;

    // Constructor (not used, placeholder)
    function __construct($zpid=null) {	
        $this->zillow_key = '{YOUR KEY HERE}';
        $this->searchEndpoint = 'GetSearchResults.htm';
        $this->chartEndpoint = 'GetChart.htm';
        $this->detailsEndpoint = 'GetUpdatedPropertyDetails.htm';
        $this->zpid = $zpid;
        $this->returnInfo = new stdClass();
    }
    
    // Make a request...we need the API end point and whatever params we are sending it as query string (needs to be encoded)
    private function makeRequest($endpoint, $params) {
        $curlSession = curl_init();
        curl_setopt($curlSession, CURLOPT_URL, 'http://www.zillow.com/webservice/'.$endpoint.'?zws-id='.$this->zillow_key.'&'.$params);
        curl_setopt($curlSession, CURLOPT_BINARYTRANSFER, true);
        curl_setopt($curlSession, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($curlSession);
        curl_close($curlSession);
        return $result;
    }
    
    // Get the ZPID for the address from Zillow, this is almost always needed in the API request
    public function getZPID($addressInfo) {
        // Start building the query string 
        // ***NOTE the web service needs to have everything encoded in a specific way, thus the ' ' spaces
        $paramArray = array('address'       =>  $addressInfo['streetnum'].' '.$addressInfo['streetname'] . ($addressInfo['apt'] ? (' '.$addressInfo['apt']) : ''),
                            'citystatezip'  =>  $addressInfo['city'].', '.$addressInfo['state'].' '.$addressInfo['zip']);
        
        $query = http_build_query($paramArray);
        
        // Pass our key and the query to the curl request
        $searchResult = $this->makeRequest($this->searchEndpoint, $query);
        
        // Check the result, make sure we did not get an error
        $result = $this->checkResult($searchResult);
        
        // Return the result
        if($result) {
            // Format the results...and while we are in there we will look for extra stuff and make a few extra calls
            $output = $this->formatResults($result);
            if($output) {
                return $output;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    
    public function formatResults($results) {
        // Cut down to the meat...nested in 3 arrays (thanks XML)
        $info = $results['response']['results']['result'];
        
        // Set the class ZPID
        $this->zpid = $info['zpid'];
        
        // New object so we can grab what we want and nicely format it so it will be easy to work with client side
        $this->returnInfo->zpid = $info['zpid'];
        $this->returnInfo->fullAddress = $results['request']['address'].' '.$results['request']['citystatezip'];
        $this->returnInfo->lat = $info['address']['latitude'];
        $this->returnInfo->lon = $info['address']['longitude'];
        $this->returnInfo->zestimate = $info['zestimate']['amount'];
        $this->returnInfo->ZestimateDate = $info['zestimate']['last-updated'];
        $this->returnInfo->area = $info['localRealEstate']['region']['@attributes']['name'];
        $this->returnInfo->areaAvg = $info['localRealEstate']['region']['zindexValue'];
        $this->returnInfo->link = $info['links']['homedetails'];
        
        // Get a chart...why not?
        $requestChart = $this->getChart($this->zpid, '1year', 'dollar', '300', '600');
        $chart = $this->checkResult($requestChart);
        if($chart) {
            $this->returnInfo->chart = $chart['response']['url'];
        } else {
            $this->returnInfo->chart = false;
        }
        
        // Check for other stuff (images and details)
        $requestOtherInfo = $this->getImagesAndDetails($this->zpid);
        $otherInfo = $this->checkResult($requestOtherInfo);
        // Oh hey we found some stuff...
        if($otherInfo) {
            // Get images if they are there
            if(isset($otherInfo['response']['images'])) {
                if($otherInfo['response']['images']['count'] > 0) {
                    $this->returnInfo->images = $otherInfo['response']['images']['image']['url'];
                } else {
                    $this->returnInfo->images = false;
                }
            } else {
                $this->returnInfo->images = false;
            }
            // Regardless...get ALL the detail info we can, we can sort out what is empty on the client side
            $this->returnInfo->fullDetails = $otherInfo['response']['editedFacts'];
        } else {
            $this->returnInfo->fullDetails = false;
        }
        
        // Signal for the AJAX that it was a success:
        $this->returnInfo->result = "success";
        
        // Now lets return our stuff
        return $this->returnInfo;
    }
    
    // Get the charts from Zillow, this will return a 1, 5, or 10 year chart estimating the home value,
    // format is the format (% or $), duration is 1, 5, or 10 year, and height and width are the size in pixels
    // If duration is not set, it will default to 1 year
    public function getChart($zpid, $duration=null, $format, $height, $width) {
        // Build the query
        $paramArray = array('unit-type' =>  $format,
                            'zpid'      =>  $zpid,
                            'width'     =>  $width,
                            'height'    =>  $height,
                            'duration'  =>  $duration);
        $query = http_build_query($paramArray);
        
        // Pass our key and the query to the curl request
        $searchResult = $this->makeRequest($this->chartEndpoint, $query);
        return $searchResult;
    }
    
    // Get images and other stuff if possible
    public function getImagesAndDetails($zpid) {
        // Build the query
        $paramArray = array('zpid' => $zpid);
        $query = http_build_query($paramArray);
        
        // Pass our key and the query to the curl request
        $searchResult = $this->makeRequest($this->detailsEndpoint, $query);
        return $searchResult;
    }

    // Check the return, if it's all good, send it as an array 
    // and we'll JSON encode before returning it to the AJAX (no one likes XML, seriously)
    public function checkResult($xml) {
        $convert = simplexml_load_string($xml);
        $json = json_encode($convert);
        $dataArr = json_decode($json, true);
        if($dataArr['message']['code'] != 0) {
            return false;
        } else {
            return $dataArr;
        }
    }

    
    // Somewhat clean the strings
    public function cleanStuff($input) {
        return htmlentities(stripslashes(trim($input)));
    }
}