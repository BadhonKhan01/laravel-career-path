<?php 
trait HelperTrait {
    // Helper Display
    function display($data){
        printf($data);
    }

    // Helper Loop
    function concatLoop($data){
        $output = '';
        $i = 0;
        foreach ($data as $item) {
            $i++;
            $output .= "$i. $item \n";
        }
        return $output;
    }

    // Helper Display title
    function title($title) {
        $data = "\n---------------------------------------\n";
        $data .= "    $title  \n";
        $data .= "---------------------------------------\n";
        return $data;
    }

    // Helper Load JSON File
    function isFileExist($path){
        if (!file_exists($path)) {
            if(file_put_contents($path,'') !== false){
                return true;
            }else{
                return false;
            }
        }else{
            return true;
        }
    }

    // Helper Get Save Data
    function getSaveData($path, $type){
        $file = fopen($path, 'a');
        if ($file) {
            $saveData = json_decode(file_get_contents($path), true);
            if (!empty($saveData)) {
                if(!empty($saveData[$type])){
                    return $saveData[$type];
                }else{
                    return "Sorry! you don't have $type data\n";
                }
            }else{
                return "Sorry! you did not add any $type data.\n";
            }
        }
    }

    // Helper Save Data
    function save($path, $type, $content){
        $file = fopen($path, 'a');
        if ($file) {
            $json = file_get_contents($path);
            $data = json_decode($json, true);
            $data[$type][] = array_map('ucwords', $content);
            if(file_put_contents($path, json_encode($data, JSON_PRETTY_PRINT) . "\n") !== false){
                return true;
            }else{
                return false;
            }
        }
    }

    // Helper Check Category
    function checkCat($inputCat, $categories) {
        $input = strtolower($inputCat);
        if(in_array(strtolower($inputCat), array_map('strtolower', $categories))){
            return true;
        }else{
            return false;
        }
    }
}