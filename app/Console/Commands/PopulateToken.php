<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class PopulateToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:token';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $user = User::find(1);

         $token = $user->createToken('authToken')->plainTextToken;

         echo($token);

//        1|9A3CPZtqCsJJWD8afLnufehu2p9wNYs9BeqslrYl                Token for local
//        1|XZnsoLk8o8Dtcsbxy6CMCEaJN9wLxZS8G401ZH788580c14b        Token for live

    }
}
