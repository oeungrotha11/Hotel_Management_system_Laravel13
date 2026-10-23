<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class MakeAdmin extends Command
{
    protected $signature = 'hotel:make-admin {email : Email address of an existing user}';
    protected $description = 'Promote an existing account to hotel administrator (CLI only).';

    public function handle(): int
    {
        $user = User::where('email', strtolower(trim((string) $this->argument('email'))))->first();

        if (!$user) {
            $this->error('No user has that email. Register the account first, then run this command.');
            return self::FAILURE;
        }

        if ($user->role === 'admin') {
            $this->info($user->email.' is already an administrator.');
            return self::SUCCESS;
        }

        if (!$this->confirm('Promote '.$user->name.' <'.$user->email.'> to ADMIN?')) {
            $this->warn('No changes made.');
            return self::SUCCESS;
        }

        $user->role = 'admin';
        $user->save();
        $this->info('Administrator role assigned successfully.');
        return self::SUCCESS;
    }
}
