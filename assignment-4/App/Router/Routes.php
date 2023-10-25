<?php 
namespace App\Router;

use App\Router\Router;
use App\Controller\AuthController;
use App\Controller\DepositController;
use App\Controller\TransferController;
use App\Controller\WithdrawController;
use App\Controller\AdminAuthController;
use App\Controller\DashboardController;
use App\Controller\AdminTransactionsController;
use App\Controller\AdminDashboardController;

Router::get('/',[AuthController::class, 'register']);
Router::post('/',[AuthController::class, 'create']);

Router::get('/login',[AuthController::class, 'login']);
Router::post('/login',[AuthController::class, 'login']);
Router::get('/logout',[AuthController::class, 'logout']);

Router::get('/customer/dashboard',[DashboardController::class, 'index']);
Router::get('/customer/deposit',[DepositController::class, 'index']);
Router::post('/customer/deposit',[DepositController::class, 'deposit']);

Router::get('/customer/withdraw',[WithdrawController::class, 'index']);
Router::post('/customer/withdraw',[WithdrawController::class, 'withdraw']);

Router::get('/customer/transfer',[TransferController::class, 'index']);
Router::post('/customer/transfer',[TransferController::class, 'transfer']);


// Admin
Router::get('/admin',[AdminAuthController::class, 'login']);
Router::post('/admin',[AdminAuthController::class, 'login']);
Router::get('/admin/logout',[AdminAuthController::class, 'logout']);
Router::get('/admin/add-customer',[AdminAuthController::class, 'addCustomer']);
Router::post('/admin/add-customer',[AdminAuthController::class, 'addCustomer']);

Router::get('/admin/dashboard',[AdminDashboardController::class, 'index']);
Router::get('/admin/single-transactions',[AdminTransactionsController::class, 'index']);
Router::get('/admin/transactions',[AdminTransactionsController::class, 'transactions']);
