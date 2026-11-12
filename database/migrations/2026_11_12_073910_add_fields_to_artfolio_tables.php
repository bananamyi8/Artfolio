
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('artist_profiles', function (Blueprint $table) {
            $table->foreignId('user_id')
                ->unique()
                ->constrained()
                ->cascadeOnDelete();

            $table->string('display_name');
            $table->text('bio')->nullable();
            $table->string('avatar')->nullable();
            $table->string('website')->nullable();
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->text('description')->nullable();
        });

        Schema::table('artworks', function (Blueprint $table) {
            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('category_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->string('title');
            $table->text('description')->nullable();
            $table->string('image_path');
            $table->string('status')->default('draft');
        });

        Schema::table('favorites', function (Blueprint $table) {
            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('artwork_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->unique(['user_id', 'artwork_id']);
        });
    }

    public function down(): void
    {
        Schema::table('favorites', function (Blueprint $table) {
            $table->dropUnique(['user_id', 'artwork_id']);
            $table->dropConstrainedForeignId('artwork_id');
            $table->dropConstrainedForeignId('user_id');
        });

        Schema::table('artworks', function (Blueprint $table) {
            $table->dropConstrainedForeignId('category_id');
            $table->dropConstrainedForeignId('user_id');
            $table->dropColumn([
                'title',
                'description',
                'image_path',
                'status',
            ]);
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->dropUnique(['name']);
            $table->dropUnique(['slug']);
            $table->dropColumn(['name', 'slug', 'description']);
        });

        Schema::table('artist_profiles', function (Blueprint $table) {
            $table->dropConstrainedForeignId('user_id');
            $table->dropColumn([
                'display_name',
                'bio',
                'avatar',
                'website',
            ]);
        });
    }
};
