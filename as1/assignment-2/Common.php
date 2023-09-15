<?php 
require_once 'HelperTrait.php';

class Common{
    public $data;
    public $cat;

    use HelperTrait;

    function loadPath($path, $options){
        if($this->isFileExist($path)){
            $this->loadFeatures($options);
        }else{
            $this->display("Something wrong! please provide file creation permission in this folder");
        }
    }

    function add($type, $path){
        $this->display("\n");
        $incVal = (int) readline("Enter $type value: ");
        $this->display("\n");
        $incCat = readline("Enter $type category: ");
        $this->display("\n");
        if($incVal && $this->checkCat($incCat, $this->categories[$type])){
            $isSave = $this->save($path,$type, [ 'value' => $incVal, 'cat' => $incCat ]);            
            if($isSave){
                $this->display("Record saved successfully. \n");
            }else{
                $this->display("Sorry! your data not saved \n");
            }
        }else{
            $this->display("\n");
            $this->display("Sorry! you did not add the correct value/category data \n");
            $this->display("\n");
        }
        $this->display("\n");
    }

    function list($type, $path){
        $saveInfo = $this->getSaveData($path, $type);
        if(!empty(is_array($saveInfo))){
            $this->data = '';
            $this->data .= $this->title("Your $type list");
            foreach ($saveInfo as $item) {
                $this->data .=$item['cat'] . ' : ' . $item['value'] ."\n";
            }
            $this->data .= "\n";
            $this->display($this->data);
        }else{
            $this->display("\n");
            $this->display($saveInfo);
            $this->display("\n");
        }
    }

    // Load Features
    function loadFeatures($options){
        $this->data = $this->title("What do you want to do?");
        $this->data .= $this->concatLoop($options) . "\n";
        $this->display($this->data);
    }

    // Load Total Action
    function totalView($path){
        $income = array_sum(array_column($this->getSaveData($path,'income'), "value"));
        $expense = array_sum(array_column($this->getSaveData($path,'expense'), "value"));
        $total = ($income - $expense);

        $this->data = '';
        $this->data .= "Income: $income \n";
        $this->data .= "Expense: $expense \n";
        $this->data .= "Total: $total \n";

        $this->display("\n");
        $this->display($this->data);
        $this->display("\n");
    }

    // Load Categories
    function loadCat($title, $features){
        $this->data = $this->title($title);
        $this->data .= $this->concatLoop($features);
        $this->data .= "\n";
        $this->display($this->data);
    }

    // Load Categeories
    function showCategories($categories){
        foreach ($categories as $key => $val) {
            if('income' == $key){
                $this->loadCat("Income Categories: ", $categories[$key]);
            }
            if('expense' == $key){
                $this->loadCat("Expance Categories: ", $categories[$key]);
            }
        }
    }
}