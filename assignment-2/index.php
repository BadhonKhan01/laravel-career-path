#! /usr/bin/env php
<?php 
require_once 'HelperTrait.php';
require_once 'Common.php';

class Load extends Common{

    public $options;
    public $selected;
    public $path;

    function __construct(){
        $this->options = ['Add income', 'Add expense', 'View income', 'View expense', 'View total', 'View categories'];  
        $this->categories = [
            'income' => ['salary','business','rent'],
            'expense' => ['Family','Personal','recreation', 'Sadakah','gift']
        ];
        $this->path = 'data.json';
        $this->loadPath($this->path, $this->options);
    }

    // Load Read Line
    function selectOption(){
        $this->data = "\n";
        $this->selected = (int) readline("Enter your features option: ");
    }

    // Load Action
    function loadAction(){
        switch ($this->selected) {
            case 1:
                $this->add('income', $this->path);
                break;
            case 2:
                $this->add('expense', $this->path);
                break;
            case 3:
                $this->list('income', $this->path);
                break;
            case 4:
                $this->list('expense', $this->path);
                break;
            case 5:
                $this->totalView($this->path);
                break;
            case 6:
                $this->showCategories($this->categories);
                break;
            default:
                $this->loadFeatures($this->options);
                break;
        }
        $this->run();
    }

    // Main Function Run
    public function run(){
        $this->selectOption();
        $this->loadAction();
    }
}
$load = new Load();
$load->run();