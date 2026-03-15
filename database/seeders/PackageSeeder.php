<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Package;
use App\Models\PackageType;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    public function run(): void
    {
        $packages = [
            [
                'mentor_email' => 'sarah@mentf.com',
                'category_slug' => 'artificial-intelligence',
                'type_slug' => 'training-program',
                'title' => 'Machine Learning Mastery: From Zero to Production',
                'description' => 'A comprehensive training program covering machine learning fundamentals, advanced algorithms, and deploying ML models to production. Perfect for developers looking to transition into AI roles.',
                'price' => 599,
                'duration' => 90,
                'sessions' => 8,
                'level' => 'intermediate',
                'outcomes' => "Build and deploy real ML models\nUnderstand core ML algorithms\nWork with TensorFlow and PyTorch\nGet job-ready in AI",
                'topics' => [
                    'Introduction to Machine Learning',
                    'Data Preprocessing & Feature Engineering',
                    'Supervised Learning Algorithms',
                    'Neural Networks & Deep Learning',
                    'Computer Vision Projects',
                    'NLP & Text Processing',
                    'Model Deployment with Docker & APIs',
                    'Career Strategy & Portfolio Review',
                ],
            ],
            [
                'mentor_email' => 'marcus@mentf.com',
                'category_slug' => 'development',
                'type_slug' => '1-on-1-consultation',
                'title' => 'Full-Stack React & Node.js Mentoring',
                'description' => 'One-on-one mentoring sessions for developers wanting to master modern full-stack development with React, Node.js, and cloud deployment.',
                'price' => 120,
                'duration' => 60,
                'sessions' => 1,
                'level' => 'all',
                'outcomes' => "Build production-ready React apps\nDesign scalable Node.js APIs\nDeploy to AWS/Vercel\nCode review & best practices",
                'topics' => [
                    'Custom React Hooks & State Management',
                    'REST API Design with Node.js',
                    'Authentication & Security',
                    'Testing & CI/CD',
                ],
            ],
            [
                'mentor_email' => 'priya@mentf.com',
                'category_slug' => 'design-architecture',
                'type_slug' => 'training-program',
                'title' => 'UX Design Career Accelerator',
                'description' => 'Comprehensive UX design program to help you build a stunning portfolio and land your first UX role. Covers research, wireframing, prototyping, and case studies.',
                'price' => 449,
                'duration' => 60,
                'sessions' => 6,
                'level' => 'beginner',
                'outcomes' => "Create a job-ready UX portfolio\nMaster Figma and design tools\nConduct user research\nCrack UX interviews",
                'topics' => [
                    'Design Thinking & UX Fundamentals',
                    'User Research Methods',
                    'Wireframing & Information Architecture',
                    'Prototyping with Figma',
                    'Portfolio Project: End-to-End Case Study',
                    'Interview Prep & Portfolio Review',
                ],
            ],
            [
                'mentor_email' => 'james@mentf.com',
                'category_slug' => 'infrastructure',
                'type_slug' => 'training-program',
                'title' => 'AWS Solutions Architect Exam Prep',
                'description' => 'Intensive prep program for AWS Solutions Architect Associate certification. Includes hands-on labs, practice exams, and real-world architecture reviews.',
                'price' => 349,
                'duration' => 90,
                'sessions' => 5,
                'level' => 'intermediate',
                'outcomes' => "Pass AWS SAA certification\nDesign scalable cloud architectures\nHands-on AWS lab experience\nReal project architecture reviews",
                'topics' => [
                    'AWS Core Services Deep Dive',
                    'High Availability & Auto Scaling',
                    'Security & IAM Best Practices',
                    'Storage & Database Options',
                    'Practice Exam & Exam Strategy',
                ],
            ],
            [
                'mentor_email' => 'emily@mentf.com',
                'category_slug' => 'marketing',
                'type_slug' => 'coaching',
                'title' => 'Growth Marketing Strategy Coaching',
                'description' => 'Personal coaching for marketers and entrepreneurs looking to scale their business through data-driven growth strategies.',
                'price' => 110,
                'duration' => 60,
                'sessions' => 1,
                'level' => 'intermediate',
                'outcomes' => "Build a growth marketing framework\nOptimize conversion funnels\nScale paid advertising ROI\nCreate content that converts",
                'topics' => [
                    'Marketing Audit & Strategy',
                    'Funnel Optimization',
                    'Paid Ads Review',
                    'SEO & Content Strategy',
                ],
            ],
            [
                'mentor_email' => 'david@mentf.com',
                'category_slug' => 'finance',
                'type_slug' => 'interview-prep',
                'title' => 'Investment Banking Interview Mastery',
                'description' => 'Crack investment banking interviews with comprehensive prep covering technical finance, behavioral questions, and real case studies from top banks.',
                'price' => 400,
                'duration' => 90,
                'sessions' => 4,
                'level' => 'advanced',
                'outcomes' => "Master IB interview questions\nBuild financial models\nNail behavioral interviews\nGet offers from top banks",
                'topics' => [
                    'Financial Statement Analysis',
                    'Valuation Methods (DCF, Comps, Precedent)',
                    'M&A and LBO Concepts',
                    'Mock Interview & Feedback',
                ],
            ],
        ];

        foreach ($packages as $pkgData) {
            $mentor = User::where('email', $pkgData['mentor_email'])->first();
            $category = Category::where('slug', $pkgData['category_slug'])->first();
            $type = PackageType::where('slug', $pkgData['type_slug'])->first();
            $topics = $pkgData['topics'];

            unset($pkgData['mentor_email'], $pkgData['category_slug'], $pkgData['type_slug'], $pkgData['topics']);

            if ($mentor && $category && $type) {
                $package = Package::create(array_merge($pkgData, [
                    'user_id' => $mentor->id,
                    'category_id' => $category->id,
                    'package_type_id' => $type->id,
                    'currency' => 'USD',
                    'language' => 'en',
                    'is_active' => true,
                    'is_featured' => in_array($pkgData['type_slug'] ?? '', ['training-program']),
                    'avg_rating' => round($mentor->avg_rating - 0.1 + (rand(0, 20) / 100), 1),
                    'total_reviews' => rand(10, 60),
                    'total_enrollments' => rand(20, 100),
                ]));

                foreach ($topics as $index => $topicTitle) {
                    Topic::create([
                        'package_id' => $package->id,
                        'title' => $topicTitle,
                        'session_number' => $index + 1,
                        'duration' => $pkgData['duration'] ?? 60,
                        'sort_order' => $index + 1,
                    ]);
                }
            }
        }
    }
}
