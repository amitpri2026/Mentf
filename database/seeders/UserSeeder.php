<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Package;
use App\Models\PackageType;
use App\Models\Skill;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@mentf.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'slug' => 'admin',
            'is_active' => true,
        ]);

        // Sample mentors
        $mentors = [
            [
                'name' => 'Sarah Johnson',
                'email' => 'sarah@mentf.com',
                'title' => 'Senior AI Engineer at Google',
                'bio' => 'Passionate AI engineer with 8+ years of experience in machine learning and deep learning. I have helped 500+ students break into AI careers at top tech companies.',
                'location' => 'San Francisco, CA',
                'country' => 'US',
                'years_experience' => 8,
                'hourly_rate' => 150,
                'category_slug' => 'artificial-intelligence',
                'skills' => ['Python', 'TensorFlow', 'PyTorch', 'Machine Learning', 'Deep Learning'],
                'avg_rating' => 4.9,
                'total_reviews' => 156,
                'total_students' => 342,
                'is_featured' => true,
            ],
            [
                'name' => 'Marcus Williams',
                'email' => 'marcus@mentf.com',
                'title' => 'Full-Stack Developer & Tech Lead',
                'bio' => 'Full-stack engineer with expertise in React, Node.js, and cloud architecture. Former lead at Amazon, now helping developers level up their skills.',
                'location' => 'New York, NY',
                'country' => 'US',
                'years_experience' => 10,
                'hourly_rate' => 120,
                'category_slug' => 'development',
                'skills' => ['JavaScript', 'React', 'Node.js', 'AWS', 'TypeScript'],
                'avg_rating' => 4.8,
                'total_reviews' => 203,
                'total_students' => 451,
                'is_featured' => true,
            ],
            [
                'name' => 'Priya Patel',
                'email' => 'priya@mentf.com',
                'title' => 'UX Design Lead at Meta',
                'bio' => 'Award-winning UX designer with a focus on human-centered design. I mentor aspiring designers to build world-class portfolios and land dream jobs.',
                'location' => 'Austin, TX',
                'country' => 'US',
                'years_experience' => 7,
                'hourly_rate' => 100,
                'category_slug' => 'design-architecture',
                'skills' => ['Figma', 'UX Research', 'Prototyping', 'Design Systems', 'User Testing'],
                'avg_rating' => 4.9,
                'total_reviews' => 178,
                'total_students' => 289,
                'is_featured' => true,
            ],
            [
                'name' => 'James Chen',
                'email' => 'james@mentf.com',
                'title' => 'DevOps Architect & Cloud Consultant',
                'bio' => 'Cloud infrastructure expert with AWS, GCP, and Azure certifications. Helped 200+ companies migrate to cloud and optimize their DevOps pipelines.',
                'location' => 'Seattle, WA',
                'country' => 'US',
                'years_experience' => 12,
                'hourly_rate' => 180,
                'category_slug' => 'infrastructure',
                'skills' => ['AWS', 'Kubernetes', 'Docker', 'Terraform', 'CI/CD'],
                'avg_rating' => 4.7,
                'total_reviews' => 134,
                'total_students' => 267,
                'is_featured' => false,
            ],
            [
                'name' => 'Emily Rodriguez',
                'email' => 'emily@mentf.com',
                'title' => 'Growth Marketing Director',
                'bio' => 'Digital marketing strategist with track record of 10x growth for startups. Expert in SEO, paid ads, content marketing, and conversion optimization.',
                'location' => 'Miami, FL',
                'country' => 'US',
                'years_experience' => 9,
                'hourly_rate' => 110,
                'category_slug' => 'marketing',
                'skills' => ['SEO', 'Google Ads', 'Content Marketing', 'Analytics', 'Social Media'],
                'avg_rating' => 4.8,
                'total_reviews' => 189,
                'total_students' => 398,
                'is_featured' => true,
            ],
            [
                'name' => 'David Okonkwo',
                'email' => 'david@mentf.com',
                'title' => 'Investment Banking Vice President',
                'bio' => 'Decade of experience in investment banking and private equity. I help finance professionals and students break into top financial institutions.',
                'location' => 'London, UK',
                'country' => 'GB',
                'years_experience' => 11,
                'hourly_rate' => 200,
                'category_slug' => 'finance',
                'skills' => ['Financial Modeling', 'Valuation', 'M&A', 'Excel', 'Investment Analysis'],
                'avg_rating' => 4.9,
                'total_reviews' => 142,
                'total_students' => 215,
                'is_featured' => false,
            ],
        ];

        foreach ($mentors as $mentorData) {
            $categorySlug = $mentorData['category_slug'];
            $skills = $mentorData['skills'];
            unset($mentorData['category_slug'], $mentorData['skills']);

            $mentor = User::create(array_merge($mentorData, [
                'password' => Hash::make('password'),
                'role' => 'mentor',
                'is_active' => true,
                'currency' => 'USD',
            ]));

            // Attach category
            $category = Category::where('slug', $categorySlug)->first();
            if ($category) {
                $mentor->categories()->attach($category->id);
                $category->increment('mentors_count');
            }

            // Create skills
            foreach ($skills as $skillName) {
                $skill = Skill::firstOrCreate(['name' => $skillName]);
                $mentor->skills()->syncWithoutDetaching([$skill->id]);
            }
        }

        // Sample mentees
        $mentees = [
            ['name' => 'Alex Thompson', 'email' => 'alex@example.com'],
            ['name' => 'Nina Sharma', 'email' => 'nina@example.com'],
            ['name' => 'Tom Wilson', 'email' => 'tom@example.com'],
        ];

        foreach ($mentees as $mentee) {
            User::create(array_merge($mentee, [
                'password' => Hash::make('password'),
                'role' => 'mentee',
                'is_active' => true,
            ]));
        }
    }
}
