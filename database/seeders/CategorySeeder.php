<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Artificial Intelligence', 'slug' => 'artificial-intelligence', 'icon' => 'cpu-chip', 'color' => '#6366F1', 'description' => 'Machine learning, deep learning, NLP, and AI engineering'],
            ['name' => 'Business', 'slug' => 'business', 'icon' => 'briefcase', 'color' => '#F59E0B', 'description' => 'Entrepreneurship, strategy, management, and business development'],
            ['name' => 'Competitive Exams', 'slug' => 'competitive-exams', 'icon' => 'academic-cap', 'color' => '#10B981', 'description' => 'GRE, GMAT, IELTS, TOEFL, and other competitive examinations'],
            ['name' => 'Design & Architecture', 'slug' => 'design-architecture', 'icon' => 'paint-brush', 'color' => '#EC4899', 'description' => 'UI/UX design, graphic design, architecture and visual arts'],
            ['name' => 'Development', 'slug' => 'development', 'icon' => 'code-bracket', 'color' => '#3B82F6', 'description' => 'Web, mobile, backend, and full-stack software development'],
            ['name' => 'Finance', 'slug' => 'finance', 'icon' => 'currency-dollar', 'color' => '#22C55E', 'description' => 'Investment, trading, accounting, and financial planning'],
            ['name' => 'Health & Fitness', 'slug' => 'health-fitness', 'icon' => 'heart', 'color' => '#EF4444', 'description' => 'Personal training, nutrition, wellness, and mental health'],
            ['name' => 'HR', 'slug' => 'hr', 'icon' => 'user-group', 'color' => '#8B5CF6', 'description' => 'Human resources, talent acquisition, and people management'],
            ['name' => 'Infrastructure', 'slug' => 'infrastructure', 'icon' => 'server', 'color' => '#06B6D4', 'description' => 'DevOps, cloud computing, system administration, and networking'],
            ['name' => 'Legal', 'slug' => 'legal', 'icon' => 'scale', 'color' => '#64748B', 'description' => 'Law, compliance, contracts, and intellectual property'],
            ['name' => 'Marketing', 'slug' => 'marketing', 'icon' => 'megaphone', 'color' => '#F97316', 'description' => 'Digital marketing, SEO, social media, and growth hacking'],
            ['name' => 'Music', 'slug' => 'music', 'icon' => 'musical-note', 'color' => '#A855F7', 'description' => 'Instruments, music theory, production, and performance'],
            ['name' => 'Photography & Video', 'slug' => 'photography-video', 'icon' => 'camera', 'color' => '#14B8A6', 'description' => 'Photography, videography, editing, and visual storytelling'],
            ['name' => 'Project Management', 'slug' => 'project-management', 'icon' => 'clipboard-document-list', 'color' => '#84CC16', 'description' => 'Agile, Scrum, PMP, and project delivery methodologies'],
        ];

        foreach ($categories as $index => $cat) {
            Category::create(array_merge($cat, ['sort_order' => $index + 1, 'is_active' => true]));
        }
    }
}
