<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blog_posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt')->nullable();
            $table->longText('content');
            $table->string('cover_image')->nullable();
            $table->boolean('is_published')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });

        $now = now();

        // CMS page content settings
        DB::table('site_settings')->insertOrIgnore([
            [
                'key'        => 'page_about',
                'value'      => '<h2>About MentF</h2>
<p>MentF is India\'s premier mentorship platform connecting ambitious learners with world-class mentors who bring real industry experience to every session.</p>
<p>Founded in 2024, we believe that personalised guidance is the fastest path to mastery — whether you\'re cracking a job interview, launching a startup, or levelling up your technical skills.</p>
<h3>Our Mission</h3>
<p>To make high-quality mentorship accessible to every learner in India, regardless of their background or location.</p>
<h3>Why MentF?</h3>
<ul>
<li>500+ verified expert mentors across 14+ categories</li>
<li>Flexible 1-on-1 sessions and structured learning packages</li>
<li>Transparent reviews and ratings from real students</li>
<li>Affordable pricing in Indian Rupees</li>
</ul>
<h3>Get in Touch</h3>
<p>Have questions? Reach out to us at <a href="mailto:hello@mentf.com">hello@mentf.com</a> — we\'d love to hear from you.</p>',
                'label'      => 'About Us Page Content',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'key'        => 'page_privacy',
                'value'      => '<h2>Privacy Policy</h2>
<p><em>Last updated: March 2025</em></p>
<p>MentF ("we", "us", or "our") is committed to protecting your personal information. This Privacy Policy explains how we collect, use, and safeguard data when you use our platform.</p>
<h3>1. Information We Collect</h3>
<ul>
<li><strong>Account data:</strong> name, email address, and password when you register.</li>
<li><strong>Profile data:</strong> biography, skills, profile photo, and professional details you add voluntarily.</li>
<li><strong>Usage data:</strong> pages visited, search queries, and session activity to improve our services.</li>
<li><strong>Payment data:</strong> handled exclusively by our payment processor; we do not store card details.</li>
</ul>
<h3>2. How We Use Your Data</h3>
<ul>
<li>To provide and improve MentF services.</li>
<li>To match mentees with relevant mentors.</li>
<li>To send service-related communications (session reminders, invoices).</li>
<li>To comply with legal obligations.</li>
</ul>
<h3>3. Data Sharing</h3>
<p>We do not sell your personal data. We share data only with trusted service providers (hosting, payments) who process data on our behalf under strict confidentiality agreements.</p>
<h3>4. Cookies</h3>
<p>We use essential session cookies to keep you logged in and preference cookies to remember your settings. You can disable cookies in your browser, but some features may not work correctly.</p>
<h3>5. Your Rights</h3>
<p>You may request access to, correction of, or deletion of your personal data at any time by contacting us at <a href="mailto:privacy@mentf.com">privacy@mentf.com</a>.</p>
<h3>6. Contact</h3>
<p>For any privacy-related queries, email us at <a href="mailto:privacy@mentf.com">privacy@mentf.com</a>.</p>',
                'label'      => 'Privacy Policy Content',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'key'        => 'page_contact_email',
                'value'      => 'hello@mentf.com',
                'label'      => 'Contact Email',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'key'        => 'page_contact_phone',
                'value'      => '+91 98765 43210',
                'label'      => 'Contact Phone',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'key'        => 'page_contact_address',
                'value'      => '91Springboard, Koramangala, Bengaluru, Karnataka 560034, India',
                'label'      => 'Contact Address',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);

        // Seed 2 sample blog posts
        DB::table('blog_posts')->insert([
            [
                'title'        => 'How to Choose the Right Mentor for Your Career Goals',
                'slug'         => 'how-to-choose-the-right-mentor',
                'excerpt'      => 'Picking a mentor is one of the most impactful decisions you can make. Here is a practical framework to find the right match.',
                'content'      => '<p>Finding the right mentor can accelerate your career by years. But with so many options, how do you choose wisely? Here is a practical framework.</p>
<h3>1. Define Your Goal First</h3>
<p>Before you search, write down exactly what you want to achieve in the next 6–12 months. A clear goal makes it easy to filter mentors by specialisation.</p>
<h3>2. Look at Track Record, Not Just Credentials</h3>
<p>Degrees are nice, but real-world results speak louder. Check what your potential mentor has actually built, shipped, or led — not just where they studied.</p>
<h3>3. Check for Communication Fit</h3>
<p>The best mentor for someone else may not be the best mentor for you. Browse their reviews and, if possible, book a short introductory session to gauge communication style.</p>
<h3>4. Align on Frequency and Format</h3>
<p>Some learners thrive with weekly check-ins; others prefer intensive burst sessions. Agree on a cadence before committing to a package.</p>
<p>Ready to find your mentor? <a href="/mentors">Browse our expert mentors →</a></p>',
                'is_published' => true,
                'published_at' => now()->subDays(7),
                'created_at'   => now()->subDays(7),
                'updated_at'   => now()->subDays(7),
            ],
            [
                'title'        => 'Why 1-on-1 Mentorship Beats Online Courses for Skill Building',
                'slug'         => 'why-mentorship-beats-online-courses',
                'excerpt'      => 'Online courses are great for information. But when it comes to real skill-building, nothing beats personalised mentorship. Here is why.',
                'content'      => '<p>In 2024, there is no shortage of online courses. Yet many learners finish a course and still feel stuck. The missing piece is almost always personalised feedback.</p>
<h3>The Information vs. Skill Gap</h3>
<p>Courses deliver information. Skills require practice, feedback, and iteration — exactly what a mentor provides in every session.</p>
<h3>Accountability Changes Everything</h3>
<p>When you have a mentor waiting for your progress update, you show up differently. The social commitment turns vague intentions into consistent action.</p>
<h3>Real-World Context</h3>
<p>A mentor who has done what you want to do can instantly translate abstract concepts into the context of your specific situation — something no recorded video can do.</p>
<h3>Faster Course Correction</h3>
<p>In a course, you can spend weeks going down the wrong path. A mentor catches and corrects errors in real time, saving you months of wasted effort.</p>
<p>Explore our <a href="/packages">learning packages</a> to find structured mentorship that fits your schedule and budget.</p>',
                'is_published' => true,
                'published_at' => now()->subDays(3),
                'created_at'   => now()->subDays(3),
                'updated_at'   => now()->subDays(3),
            ],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('blog_posts');
        DB::table('site_settings')->whereIn('key', [
            'page_about', 'page_privacy',
            'page_contact_email', 'page_contact_phone', 'page_contact_address',
        ])->delete();
    }
};
