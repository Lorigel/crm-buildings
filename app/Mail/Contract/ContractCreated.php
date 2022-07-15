<?php

namespace App\Mail\Contract;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContractCreated extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $contract;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    
    public function __construct($user, $contract)
    {
        $this->user = $user;
        $this->contract = $contract;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.contract-created')->subject('Nuova prachtica creato');
    }
}
