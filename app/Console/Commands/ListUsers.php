<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class ListUsers extends Command
{
    protected $signature = 'app:list-users';
    protected $description = 'List all users in the database';

    public function handle()
    {
        $users = User::all();
        
        $this->info('Total users: ' . $users->count());
        $this->newLine();
        
        foreach ($users as $user) {
            $this->line("{$user->name} - {$user->email} - {$user->role}");
        }
        
        return 0;
    }
}
