<?php 
namespace App\Controller;

use App\Enums\AppType;
use App\Admin\AllUsers;
use App\Traits\Redirect;
use App\Modeles\UserModel;
use App\Traits\FlashTrait;
use App\Traits\ViewTraits;
use App\User\CurrentBalance;
use App\User\ShowTransactions;
use App\Traits\CheckUserTraits;

class AdminDashboardController
{
    use CheckUserTraits;
    use ViewTraits;
    use FlashTrait;
    use Redirect;
    public UserModel $user;

    function __construct()
    {
        $this->user = $this->loginUser();
    }
    
    public function index(){

        $allusers = new AllUsers(AppType::WEB_APP);
        $customers = $allusers->run();

        $this->view('admin/dashboard', compact('customers'));
    }
}

