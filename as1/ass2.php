<?php 
class Load{

    public $data;
    public $features;
    public $cat;
    public $selected;

    function __construct(){
        $this->features = ['Add income', 'Add expense', 'View income', 'View expense', 'View total', 'View categories'];  
        $this->categories = [
            'income' => ['Salary','Business','Rent'],
            'expense' => ['Family','Personal','Recreation', 'Sadakah','Gift']
        ];
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
        $this->selected = (int) readline('');
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
        $data['income'][] = [
            'value' => $incVal,
            'cat' => $incCat
        ];
        var_dump($data);
    }

    // Load Categeories
    function showCategories(){
        foreach ($this->categories as $key => $val) {
            if('income' == $key){
                $this->data = $this->title("Income Categories: ");
                $this->data .= $this->concatLoop($this->features);
                $this->display();
            }
            if('expense' == $key){
                $this->data = $this->title("Expance Categories: ");
                $this->data .= $this->concatLoop($this->features);
                $this->display();
            }
        }
        $this->run();
    }

    // Load Action
    function loadAction(){
        if(1 === $this->selected){
            $this->income();
        }
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










// // Load Our Features
// function load(){
//     global $features, $data;
//     $output = title("What do you want to do?");
//     $output .= concatLoop($features);
//     $output .= "\n";
//     display($output);

//     // Select Feature
//     $selectFeatures = (int) readline('');

//     if (1 === $selectFeatures) {
//         $incVal = (int) readline('Enter a value: ');
//         $incCat = readline('Enter a category: ');
//         $data['income'][] = [
//             'value' => $incVal,
//             'cat' => $incCat
//         ];
//         var_dump($data);
//     }

//     // Display Categories
//     if(6 === $selectFeatures){
//         global $inCat, $exCat;
        
//         // Display Income
//         $inc = title("Income Categories: ");
//         $inc .= concatLoop($inCat);
//         $inc .= "\n";
//         display($inc);

//         // Display Expance
//         $exp = title("Expance Categories: ");
//         $exp .= concatLoop($exCat);
//         $exp .= "\n";
//         display($exp);

//         load();
//     }

// }
// load(); // Main fun Loaded

// // Load Helper functions
// function display($content){
//     printf($content);
// }

// function concatLoop($data){
//     $output = '';
//     $i = 0;
//     foreach ($data as $item) {
//         $i++;
//         $output .= "$i . $item \n";
//     }
//     return $output;
// }

// function title($title) {
//     $output = "\n---------------------------------------\n";
//     $output .= "    $title  \n";
//     $output .= "---------------------------------------\n";
//     return $output;
// }



