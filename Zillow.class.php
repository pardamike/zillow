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

    // Constructor, set up that variables here
    function __construct($zpid=null) {	
        $this->zillow_key = 'YOUR-KEY-HERE';                        // Your web service key
        $this->searchEndpoint = 'GetDeepSearchResults.htm';         // Initial search endpoint
        $this->chartEndpoint = 'GetChart.htm';                      // Chart endpoint for getting property value history
        $this->detailsEndpoint = 'GetUpdatedPropertyDetails.htm';   // Updated property details (not all properties will have this)
        $this->zpid = $zpid;                                        // If we have  ZPID already, set it now
        $this->returnInfo = new stdClass();                         // Initialize an object to store and return our results
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
    
    // Get the ZPID for the address from Zillow, this is the starting point for any property information 
    // once we have the ZPID we can get some more information
    public function getZPID($addressInfo) {
        // Start building the query string 
        // ***NOTE the web service needs to have everything encoded with spaces to seperate everything, 
        // especially the 'GetDeepSearchResults.htm' service...see the Zillow documentation
        $paramArray = array('address'       =>  $addressInfo['streetnum'].' '.$addressInfo['streetname'] . ($addressInfo['apt'] ? (' '.$addressInfo['apt']) : ''),
                            'citystatezip'  =>  $addressInfo['city'].', '.$addressInfo['state'].' '.$addressInfo['zip']);
        
        $query = http_build_query($paramArray);
        
        // Pass our key and the query to the curl request
        $searchResult = $this->makeRequest($this->searchEndpoint, $query);
        
        // Check the result, make sure we did not get an error, as long as we did not, 
        // checkResult() will convert the XML to an array for us
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
        
        // Set the class ZPID...just make sure we got one first!
        if(isset($info['zpid'])) {
            $this->zpid = $info['zpid'];
        } else {
            // If no ZPID, this is not a valid property
            return false;
        }

        // Alright lets grab what we want and nicely format it so it will be easy to work with client side,
        // die out $info to see everything that comes with this call...be forwarned there is stuff missing depending
        // on the city and state...I return just the basics here, you can use everything just make sure to check if its there or not.
        // The titles are pretty self explanitory for what we are storing in the return object
        $this->returnInfo->zpid = $info['zpid'];
        $this->returnInfo->fullAddress = $results['request']['address'].' '.$results['request']['citystatezip'];
        $this->returnInfo->lat = $info['address']['latitude'];
        $this->returnInfo->lon = $info['address']['longitude'];
        $this->returnInfo->zestimate = $info['zestimate']['amount'];
        $this->returnInfo->ZestimateDate = $info['zestimate']['last-updated'];
        $this->returnInfo->link = $info['links']['homedetails'];
        $this->returnInfo->built = $info['yearBuilt'];
        $this->returnInfo->bathrooms = $info['bathrooms'];
        $this->returnInfo->bedrooms = $info['bedrooms'];
        $this->returnInfo->sqft = $info['finishedSqFt'];
        
        // Get a chart...because why not?
        $this->returnInfo->chart = $this->getChart($this->zpid, '1year', 'dollar', '300', '600');
        
        // Check for other stuff (images and updated details)
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
            // Regardless of images...get ALL the detail info we can, we can sort out what is empty on the client side
            $this->returnInfo->fullDetails = $otherInfo['response']['editedFacts'];
        } else {
            // ...or we didn't find anything, store these as false so we know client side what were working with
            $this->returnInfo->fullDetails = false;
            $this->returnInfo->images = false;
        }
        
        // Signal for the AJAX that it was a success
        $this->returnInfo->result = "success";
        
        // Now lets return our information
        return $this->returnInfo;
    }
    
    // Call to get charts from Zillow, this will return a 1, 5, or 10 year chart estimating the home value,
    // format is the format (% or $), duration is 1, 5, or 10 year, and height and width are the size in pixels
    public function getChart($zpid, $duration, $format, $height, $width) {
        // Build the query
        $paramArray = array('unit-type' =>  $format,
                            'zpid'      =>  $zpid,
                            'width'     =>  $width,
                            'height'    =>  $height,
                            'chartDuration'  =>  $duration);
        $query = http_build_query($paramArray);
        
        // Pass our key and the query to the curl request
        $searchResult = $this->makeRequest($this->chartEndpoint, $query);
        // Check the result, format into an array if it's valid
        $chart = $this->checkResult($searchResult);
        if($chart) {
            // Return the URL of the chart
            return $chart['response']['url'];
        } else {
            return false;
        }
    }
    
    // Call to get images and other stuff if possible
    public function getImagesAndDetails($zpid) {
        // Build the query
        $paramArray = array('zpid' => $zpid);
        $query = http_build_query($paramArray);
        
        // Pass our key and the query to the curl request
        $searchResult = $this->makeRequest($this->detailsEndpoint, $query);
        return $searchResult;
    }

    // Check the return, if it's all good, format it to as an array 
    // and we'll JSON encode before returning it to the AJAX (no one likes XML, seriously)
    public function checkResult($xml) {
        $convert = simplexml_load_string($xml);
        $json = json_encode($convert);
        $dataArr = json_decode($json, true);
        // If response is anything other than 0, it failed
        // TODO: Handle the various error codes (EX: too many requests, etc)
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
