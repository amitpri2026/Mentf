<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_settings', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->text('value')->nullable();
            $table->string('label')->nullable();
            $table->timestamps();
        });

        // Seed default values (empty = use live DB count)
        $defaults = [
            ['key' => 'stat_mentors',    'value' => '', 'label' => 'Expert Mentors display number'],
            ['key' => 'stat_students',   'value' => '', 'label' => 'Happy Students display number'],
            ['key' => 'stat_packages',   'value' => '', 'label' => 'Learning Packages display number'],
            ['key' => 'stat_categories', 'value' => '', 'label' => 'Categories display number'],
            ['key' => 'hero_tagline',    'value' => '', 'label' => 'Hero announcement bar text'],
        ];

        foreach ($defaults as $row) {
            DB::table('site_settings')->insert(array_merge($row, [
                'created_at' => now(), 'updated_at' => now(),
            ]));
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};
