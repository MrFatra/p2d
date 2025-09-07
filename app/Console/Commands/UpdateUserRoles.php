<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class UpdateUserRoles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-user-roles';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update daily the users role.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info("Updating roles...");

        User::chunk(100, function ($users) {
            foreach ($users as $user) {
                
                if ($user->hasRole(['admin', 'cadre', 'resident', 'midwife'])) {
                    continue;
                }

                $newRole = User::determineTypeOfUser($user->birth_date);

                $pregnant = $user->pregnantPostpartumBreastfeedings()->exists();

                if (!$user->hasRole($newRole)) {
                    $user->syncRoles($newRole);
                }

                if ($pregnant && !$user->hasRole('pregnant')) {
                    $user->syncRoles('pregnant');
                }
            }
        });

        $this->info("Done updating roles.");
    }
}
