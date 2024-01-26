<?php
/**
 * Created By PhpStorm
 * User: trungphuna
 * Date: 1/23/24
 * Time: 2:40 PM
 */

namespace App\Services;

use App\Models\Transaction;

class TransactionService
{
    public static function createTransaction($data)
    {
        return Transaction::create($data);
    }
}