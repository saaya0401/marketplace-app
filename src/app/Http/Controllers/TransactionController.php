<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function chatView($itemId){
        return view('transaction_chat');
    }
}
