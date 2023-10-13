<?php
require 'vendor/autoload.php';

use App\Database\Migration;

$migration = new Migration();
$migration->run();