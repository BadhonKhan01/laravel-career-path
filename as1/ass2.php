<?php 
class Load{

    public $data;
    public $features;
    public $cat;
    public $selected;
    public $filename;

    function __construct(){
        $this->features = ['Add income', 'Add expense', 'View income', 'View expense', 'View total', 'View categories'];  
        $this->categories = [
            'income' => ['Salary','Business','Rent'],
            'expense' => ['Family','Personal','Recreation', 'Sadakah','Gift']
        ];
        $this->filename = 'data.json';
    }

    // Helper Display
    function display(){
        printf($this->data);
    }

    // Helper Loop
    function concatLoop($data){
        $output = '';
        $i = 0;
        foreach ($data as $item) {
            $i++;
            $output .= "$i . $item \n";
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

    // Helper Read Line
    function selectOption(){
        $this->selected = (int) readline();
    }

    // Helper Save Data
    function save($type, $data){
        if (file_exists($this->filename)) {
            $file = fopen($this->filename, 'a');
            if ($file) {
                $jsonString = file_get_contents($this->filename);
                $oldData = json_decode($jsonString, true);
                $oldData[$type][] = $data;
                file_put_contents($this->filename, json_encode($oldData, JSON_PRETTY_PRINT) . "\n");
            }
        }else{
            $newData[$type][] = $data;
            $this->data = '';
            if (file_put_contents($this->filename, json_encode($newData, JSON_PRETTY_PRINT) . "\n")) {
                $this->data = "Record saved successfully. \n";
            } else {
                $this->data = "Something wrong! please try again. \n";
            }
        }
    }

    // Load Features
    function loadFeatures(){
        $this->data = $this->title("What do you want to do?");
        $this->data .= $this->concatLoop($this->features);
        $this->data .= "\n";
        $this->display();
    }

    // Load Add Income
    function income(){
        $incVal = (int) readline('Enter income value: ');
        $incCat = readline('Enter income category: ');
        $data = [ 'value' => $incVal, 'cat' => $incCat ];
        $this->save('income', $data);
        $this->run();
    }

    // Load View Income
    function incomeView(){
        $file = fopen($this->filename, 'a');
        if ($file) {
            $jsonString = file_get_contents($this->filename);
            $loadData = json_decode($jsonString, true);
            $this->data = '';
            $this->data .= $this->title("Your Income List");
            foreach ($loadData['income'] as $item) {
                $this->data .=$item['cat'] . ' : ' . $item['value'] ."\n";
            }
            $this->data .= "\n";

            $this->display();
            $this->run();
        }
    }

    // Load View Expense
    function expenseView(){
        $file = fopen($this->filename, 'a');
        if ($file) {
            $jsonString = file_get_contents($this->filename);
            $loadData = json_decode($jsonString, true);
            $this->data = '';
            $this->data .= $this->title("Your Income List");
            foreach ($loadData['expense'] as $item) {
                $this->data .=$item['cat'] . ' : ' . $item['value'] ."\n";
            }
            $this->data .= "\n";

            $this->display();
            $this->run();
        }
    }

    // Load Total Action
    function totalView(){
        $jsonString = file_get_contents($this->filename);
        $loadData = json_decode($jsonString, true);

        $incomeValues = array_column($loadData["income"], "value");
        $expenseValues = array_column($loadData["expense"], "value");

        $totalIncome = array_sum($incomeValues);
        $totalExpense = array_sum($expenseValues);

        $this->data = '';
        $this->data .= "Total Income: $totalIncome \n";
        $this->data .= "Total Expense: $totalExpense \n";

        $this->display();
        $this->run();
    }

    // Load Add Expense
    function expense(){
        $incVal = (int) readline('Enter expense value: ');
        $incCat = readline('Enter expense category: ');
        $data = [ 'value' => $incVal, 'cat' => $incCat ];
        $this->save('expense', $data);
        $this->run();
    }

    // Load Categeories
    function showCategories(){
        foreach ($this->categories as $key => $val) {
            if('income' == $key){
                $this->data = $this->title("Income Categories: ");
                $this->data .= $this->concatLoop($this->categories[$key]);
                $this->display();
            }
            if('expense' == $key){
                $this->data = $this->title("Expance Categories: ");
                $this->data .= $this->concatLoop($this->categories[$key]);
                $this->display();
            }
        }
        $this->run();
    }

    // Load Action
    function loadAction(){
        // Income Action
        if(1 === $this->selected){
            $this->income();
        }

        // Expense Action
        if(2 === $this->selected){
            $this->expense();
        }

        // View Income Action
        if(3 === $this->selected){
            $this->incomeView();
        }

        // View Income Action
        if(4 === $this->selected){
            $this->expenseView();
        }

        // View Income Action
        if(5 === $this->selected){
            $this->totalView();
        }

        // Categories Action
        if(6 === $this->selected){
            $this->showCategories();
        }
    }

    // Main Function Run
    public function run(){
        $this->loadFeatures();
        $this->selectOption();
        $this->loadAction();
    }
}
$load = new Load();
$load->run();