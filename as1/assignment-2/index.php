#! /usr/bin/env php
<?php 
require_once 'HelperTrait.php';

class Common{
    use HelperTrait;

    function add($type){
        $this->display("\n");
        $incVal = (int) readline("Enter $type value: ");
        $this->display("\n");
        $incCat = readline("Enter $type category: ");
        $this->display("\n");
        if($incVal && $this->checkCat($incCat, $this->categories[$type])){
            $isSave = $this->save($this->path,$type, [ 'value' => $incVal, 'cat' => $incCat ]);            
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
        $this->run();
    }
}



class Load extends Common{

    use HelperTrait;

    public $data;
    public $features;
    public $cat;
    public $selected;
    public $path;

    function __construct(){
        $this->features = ['Add income', 'Add expense', 'View income', 'View expense', 'View total', 'View categories'];  
        $this->categories = [
            'income' => ['salary','business','rent'],
            'expense' => ['Family','Personal','Recreation', 'Sadakah','Gift']
        ];
        $this->path = 'data.json';
        if($this->isFileExist($this->path)){
            $this->loadFeatures();
        }else{
            $this->display("Something wrong! please provide file creation permission in this folder");
        }
    }

    // Load Features
    function loadFeatures(){
        $this->data = $this->title("What do you want to do?");
        $this->data .= $this->concatLoop($this->features) . "\n";
        $this->display($this->data);
    }

    // Load Add Income
    function income(){
        $this->add('income');

        // $this->display("\n");
        // $incVal = (int) readline('Enter income value: ');
        // $this->display("\n");
        // $incCat = readline('Enter income category: ');
        // $this->display("\n");
        // if($incVal && $this->checkCat($incCat, $this->categories['income'])){
        //     $isSave = $this->save($this->path,'income', [ 'value' => $incVal, 'cat' => $incCat ]);            
        //     if($isSave){
        //         $this->display("Record saved successfully. \n");
        //     }else{
        //         $this->display("Sorry! your data not saved \n");
        //     }
        // }else{
        //     $this->display("\n");
        //     $this->display("Sorry! you did not add the correct value/category data \n");
        //     $this->display("\n");
        // }
        // $this->display("\n");
        // $this->run();
    }

    // Load Add Expense
    function expense(){
        $this->display("\n");
        $expVal = (int) readline('Enter expense value: ');
        $this->display("\n");
        $expCat = readline('Enter expense category: ');
        $this->display("\n");
        if($expVal && $this->checkCat($expCat, $this->categories['expense'])){
            $isSave = $this->save($this->path,'expense', [ 'value' => $expVal, 'cat' => $expCat ]);            
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
        $this->run();
    }

    // Load View Income
    function incomeView(){
        $saveInfo = $this->getSaveData($this->path,'income');
        if(!empty((array)$saveInfo)){
            $this->data = '';
            $this->data .= $this->title("Your income list");
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

    // Load View Expense
    function expenseView(){
        $saveInfo = $this->getSaveData($this->path,'expense');
        if(!empty(is_array($saveInfo))){
            $this->data = '';
            $this->data .= $this->title("Your expense list");
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

    // Load Total Action
    function totalView(){
        $income = array_sum(array_column($this->getSaveData($this->path,'income'), "value"));
        $expense = array_sum(array_column($this->getSaveData($this->path,'expense'), "value"));
        $total = ($income - $expense);

        $this->data = '';
        $this->data .= "Income: $income \n";
        $this->data .= "Expense: $expense \n";
        $this->data .= "Total: $total \n";

        $this->display("\n");
        $this->display($this->data);
        $this->display("\n");
        $this->run();
    }

    // Load Categories
    function loadCat($title, $features){
        $this->data = $this->title($title);
        $this->data .= $this->concatLoop($features);
        $this->data .= "\n";
        $this->display($this->data);
    }

    // Load Categeories
    function showCategories(){
        foreach ($this->categories as $key => $val) {
            if('income' == $key){
                $this->loadCat("Income Categories: ", $this->categories[$key]);
            }
            if('expense' == $key){
                $this->loadCat("Expance Categories: ", $this->categories[$key]);
            }
        }
        $this->run();
    }

    // Load Action
    function loadAction(){
        switch ($this->selected) {
            case 1:
                $this->income();
                break;
            case 2:
                $this->expense();
                break;
            case 3:
                $this->incomeView();
                break;
            case 4:
                $this->expenseView();
                break;
            case 5:
                $this->totalView();
                break;
            case 6:
                $this->showCategories();
                break;
            default:
                $this->loadFeatures();
                break;
        }
        $this->run();
    }

    // Load Read Line
    function selectOption(){
        $this->data = "\n";
        $this->selected = (int) readline("Enter your features option: ");
    }

    // Main Function Run
    public function run(){
        $this->selectOption();
        $this->loadAction();


    }
}
$load = new Load();
$load->run();