
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add username only if it does not already exist.
        if (!Schema::hasColumn('users', 'username')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('username', 30)
                    ->nullable()
                    ->unique();
            });
        }

        // Assign usernames to existing accounts that do not have one.
        DB::table('users')
            ->select('id', 'email', 'username')
            ->orderBy('id')
            ->chunkById(100, function ($users) {
                foreach ($users as $user) {
                    if (!empty($user->username)) {
                        continue;
                    }

                    // Use the email prefix as the initial username.
                    $base = strtolower(
                        explode('@', $user->email)[0] ?? ''
                    );

                    // Remove unsupported characters.
                    $base = preg_replace('/[^a-z0-9_-]/', '', $base);

                    if (empty($base)) {
                        $base = 'user';
                    }

                    $base = substr($base, 0, 25);
                    $username = $base;
                    $counter = 1;

                    // Make sure every username is unique.
                    while (
                        DB::table('users')
                            ->where('username', $username)
                            ->exists()
                    ) {
                        $username = substr($base, 0, 25)
                            . '_' . $counter;

                        $counter++;
                    }

                    DB::table('users')
                        ->where('id', $user->id)
                        ->update(['username' => $username]);
                }
            });
    }

    public function down(): void
    {
        // Intentionally preserve usernames and existing accounts.
        // Do not remove the username column automatically.
    }
};
