<?php

namespace App;

use Artistas\PagSeguro\PagSeguro as Base;

class PagSeguro extends Base
{
    public function transaction($transactionCode, $transactionType = 'transaction')
    {
        if ($transactionType == 'transaction') {
            return $this->sendTransaction([
                'email' => $this->email,
                'token' => $this->token,
            ], 'https://ws.' . ($this->sandbox ? 'sandbox.' : '') . 'pagseguro.uol.com.br/v3/transactions/'. $transactionCode, false);
        }
    }
}
