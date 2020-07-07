<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;

class Setup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run initial setup';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if ($this->confirm('Do you want to add new admin user?'))
        {
            $email    = $this->ask('Enter email.');
            $password = $this->secret('Enter new password.');

            $user           = new User();
            $user->name     = 'Administrator';
            $user->surname  = 'Administrator';
            $user->name_5   = 'Administrator';
            $user->email    = $email;
            $user->phone    = '734791909';
            $user->is_admin = true;
            $user->password = bcrypt($password);

            $user->save();

            $this->info("User was created. Email: $email");
        }


        $this->info('Setup has been successful.');
    }
}
