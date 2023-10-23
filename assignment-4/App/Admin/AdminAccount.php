<?php 
namespace App\Admin;

use App\User\Deposit;
use App\Enums\AppType;
use App\User\Transfer;
use App\User\Withdraw;
use App\Admin\AllUsers;
use App\Traits\Redirect;
use App\Interfaces\AppRun;
use App\Modeles\UserModel;
use App\Traits\DisplayMenu;
use App\DTO\TransactionType;
use App\Modeles\DepositModel;
use App\Modeles\WithdrawModel;
use App\Admin\ShowTransactions;


class AdminAccount implements AppRun
{
    use DisplayMenu;
    use Redirect;
    public AppType $apptype;
    private const SHOW_ALL_TRANSACTION = 1;
    private const TRANSFER_BY_USER = 2;
    private const SHOW_ALL_USER = 3;
    private const LOG_OUT = 4;
    private array $option = [
        self::SHOW_ALL_TRANSACTION => 'Show all transactions',
        self::TRANSFER_BY_USER => 'Transactions by user',
        self::SHOW_ALL_USER => 'Show all customers',
        self::LOG_OUT => 'Logout'
    ];
    public UserModel $user;

    function __construct(AppType $apptype, UserModel $user)
    {
        $this->apptype = $apptype;
        $this->user = $user;
    }

    public function run(): void
    {
        if($this->apptype == AppType::CLI_APP || (php_sapi_name() === 'cli' && $this->apptype == AppType::WEB_APP)){
            $this->loadMenus($this->option);
            $choice = intval(readline("Enter your option: "));
            switch ($choice) {
                case self::SHOW_ALL_TRANSACTION:
                        $showTransaction = new ShowTransactions($this->apptype);
                        $showTransaction->run();
                    break;
                case self::TRANSFER_BY_USER:
                        $transactionByUser = new TransactionByUser($this->apptype, $this->user);
                        $transactionByUser->run();
                    break;
                case self::SHOW_ALL_USER:
                        $allusers = new AllUsers($this->apptype);
                        $allusers->run();
                    break;
                case self::LOG_OUT:
                        return;
                    break;
            }
            $this->run();
        }else{
            $user_data = json_encode([
                'id' => $this->user->getId(),
                'name' => $this->user->getName(),
                'email' => $this->user->getEmail(),
                'accountType' => $this->user->getAccountType(),
            ]);
            $_SESSION['user_data'] = $user_data;
            $_SESSION["expire_time"] = time() + 86400;
            setcookie("user_data", $user_data, time() + 86400, "/");
            $this->redirect('/admin/dashboard');
        }

        
    }    
}