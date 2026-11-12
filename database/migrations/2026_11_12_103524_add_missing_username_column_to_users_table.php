
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('users', 'username')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('username', 30)->nullable();
            });
        }

        // Generate usernames for existing accounts.
        $users = DB::table('users')
            ->select('id', 'email', 'username')
            ->orderBy('id')
            ->get();

        foreach ($users as $user) {
            if (!empty($user->username)) {
                continue;
            }

            $base = strtolower(
                explode('@', $user->email)[0]
            );

            $base = preg_replace('/[^a-z0-9_-]/', '', $base);

            if (empty($base)) {
                $base = 'user';
            }

            $base = substr($base, 0, 25);
            $username = $base;
            $counter = 1;

            while (
                DB::table('users')
                    ->where('username', $username)
                    ->exists()
            ) {
                $username = $base . '_' . $counter;
                $counter++;
            }

            DB::table('users')
                ->where('id', $user->id)
                ->update(['username' => $username]);
        }

        // Add a unique index after usernames have been assigned.
        Schema::table('users', function (Blueprint $table) {
            $table->unique('username');
        });
    }

    public function down(): void
    {
        // Preserve existing usernames and account data.
    }
};
