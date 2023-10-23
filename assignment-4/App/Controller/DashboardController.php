<?php 
namespace App\Controller;

use App\Enums\AppType;
use App\Traits\Redirect;
use App\Modeles\UserModel;
use App\Traits\FlashTrait;
use App\Traits\ViewTraits;
use App\User\CurrentBalance;
use App\Traits\CheckUserTraits;
use App\User\ShowTransactions;

class DashboardController
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
        $currentBalance = new CurrentBalance(AppType::WEB_APP, $this->user);
        $currentBalance = $currentBalance->run();

        $name = $this->user->getName();

        $showTransaction = new ShowTransactions(AppType::WEB_APP, $this->user);
        $allTranscation = $showTransaction->run();

        $this->view('users/dashboard', compact('name','currentBalance','allTranscation'));
    }
}

