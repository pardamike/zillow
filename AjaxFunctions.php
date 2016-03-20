<?php
include_once 'Zillow.class.php';

if(isset($_POST['action']) && isset($_POST['data'])) {
    
    // Init Zillow
    $Zillow = new Zillow();
    
    // Lets try not get hacked (for the most part anyway)
    $action = $Zillow::cleanStuff($_POST['action']);
    $data = $_POST['data'];
    foreach($data as $key=>$value) {
        $data[$key] = $Zillow->cleanStuff($value);
    }
    
    function error($theError) {
        $res = ['result'=>$theError];
        print_r(json_encode($res));
        exit();
    }
    
    // Switch case as a "middle man", direct the AJAX data to a Zillow class function 
    // depending on the $action var, return the result...probably not the best way...
    // you should use a framework or make this its own class...doing it quick and dirty here:
    
    switch ($action) {
        case "findZPID":
            $getInfo = $Zillow->getZPID($data);
            if($getInfo) {
                print_r(json_encode($getInfo));
                exit();
            } else {
                error("Zillow could not find that address");
            }
            break;
        case "chart":
            $chart = $Zillow->getChart($data['zpid'], $data['years'], 'dollar', '300', '600');
            $result = array();
            if($chart) {
                $result['result'] = "success";
                $result['chartURL'] = $chart;
                print_r(json_encode($result));
                exit();
            } else {
                error("Unable to load chart");
            }
            break;
        default:
            $res = ['result'=>'Something has gone wrong...'];
            print_r($res);
            exit();
    }

}