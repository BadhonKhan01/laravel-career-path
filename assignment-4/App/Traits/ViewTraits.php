<?php 
namespace App\Traits;

trait ViewTraits
{
    protected function view($view, $data = []) {
        extract($data);
        $output = '';
        $output .= include "app/views/layout/header.php";
        $output .= include "app/views/$view.php";
        $output .= include "app/views/layout/footer.php";
        return $output;
    }
}
