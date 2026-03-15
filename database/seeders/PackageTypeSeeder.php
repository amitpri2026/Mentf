<?php

namespace Database\Seeders;

use App\Models\PackageType;
use Illuminate\Database\Seeder;

class PackageTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            ['name' => '1-on-1 Consultation', 'slug' => '1-on-1-consultation', 'icon' => 'user', 'description' => 'Private one-to-one mentoring session'],
            ['name' => 'Group Session', 'slug' => 'group-session', 'icon' => 'user-group', 'description' => 'Group learning with multiple students'],
            ['name' => 'Training Program', 'slug' => 'training-program', 'icon' => 'academic-cap', 'description' => 'Structured multi-session training course'],
            ['name' => 'Workshop', 'slug' => 'workshop', 'icon' => 'wrench', 'description' => 'Hands-on interactive workshop session'],
            ['name' => 'Bootcamp', 'slug' => 'bootcamp', 'icon' => 'bolt', 'description' => 'Intensive learning bootcamp experience'],
            ['name' => 'Coaching', 'slug' => 'coaching', 'icon' => 'chat-bubble-left-right', 'description' => 'Goal-oriented personal coaching sessions'],
            ['name' => 'Interview Prep', 'slug' => 'interview-prep', 'icon' => 'clipboard', 'description' => 'Interview preparation and mock sessions'],
        ];

        foreach ($types as $index => $type) {
            PackageType::create(array_merge($type, ['is_active' => true, 'sort_order' => $index + 1]));
        }
    }
}
