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
use Illuminate\Support\Str;

class SampleMentorSeeder extends Seeder
{
    // ── Indian name pools ──────────────────────────────────────────────────────

    private array $northMaleFirst = [
        'Rahul', 'Amit', 'Vikram', 'Suresh', 'Rajesh', 'Anil', 'Sanjay', 'Deepak', 'Vikas', 'Mohit',
        'Rohit', 'Kunal', 'Nitin', 'Gaurav', 'Manish', 'Vivek', 'Ravi', 'Ajay', 'Aman', 'Arjun',
        'Akash', 'Ankit', 'Harsh', 'Karan', 'Naveen', 'Piyush', 'Shivam', 'Tushar', 'Varun', 'Yash',
        'Abhishek', 'Alok', 'Devendra', 'Girish', 'Hemant', 'Ishaan', 'Kamal', 'Lalit', 'Manoj',
        'Neeraj', 'Prashant', 'Ramesh', 'Sandeep', 'Tarun', 'Umesh', 'Ashish', 'Bhavesh', 'Dinesh',
        'Hitesh', 'Jitesh', 'Mukesh', 'Naresh', 'Pankaj', 'Rakesh', 'Sachin', 'Yogesh', 'Aakash',
    ];

    private array $northFemaleFirst = [
        'Priya', 'Pooja', 'Neha', 'Anita', 'Sunita', 'Kavita', 'Rekha', 'Sonal', 'Meera', 'Nisha',
        'Divya', 'Anjali', 'Aarti', 'Seema', 'Geeta', 'Ritu', 'Sonia', 'Manju', 'Sapna', 'Poonam',
        'Shweta', 'Richa', 'Shreya', 'Swati', 'Tanvi', 'Usha', 'Vandana', 'Garima', 'Himani',
        'Jyoti', 'Monika', 'Nidhi', 'Pallavi', 'Rashmi', 'Shilpa', 'Tanya', 'Varsha', 'Yukta',
        'Archana', 'Bharti', 'Chanchal', 'Deepika', 'Ekta', 'Falguni', 'Harpreet', 'Indira',
        'Kamla', 'Lata', 'Mamta', 'Namrata', 'Preeti', 'Radha', 'Savita', 'Uma', 'Vineeta',
    ];

    private array $northSurnames = [
        'Sharma', 'Gupta', 'Singh', 'Verma', 'Mishra', 'Srivastava', 'Tiwari', 'Pandey', 'Chauhan',
        'Yadav', 'Patel', 'Agarwal', 'Jain', 'Saxena', 'Sinha', 'Tripathi', 'Dubey', 'Chaudhary',
        'Mehta', 'Kapoor', 'Khanna', 'Malhotra', 'Bhatia', 'Arora', 'Chopra', 'Sethi', 'Tandon',
        'Nanda', 'Bajaj', 'Rastogi', 'Dixit', 'Shukla', 'Awasthi', 'Bhatt', 'Joshi', 'Kulkarni',
        'Patil', 'Desai', 'Shah', 'Gandhi', 'Trivedi', 'Solanki', 'Rajput', 'Thakur', 'Rana',
    ];

    private array $southMaleFirst = [
        'Arjun', 'Karthik', 'Vijay', 'Murugan', 'Siva', 'Ganesh', 'Selvam', 'Bala', 'Chandru',
        'Gokul', 'Hari', 'Kannan', 'Logesh', 'Mani', 'Nathan', 'Pandian', 'Raja', 'Senthil',
        'Udhaya', 'Vel', 'Arun', 'Basavaraj', 'Chandrashekhar', 'Eranna', 'Gururaj', 'Hanumantha',
        'Jagadeesh', 'Lokesh', 'Mahesh', 'Nagaraj', 'Prakash', 'Ramaiah', 'Shankar', 'Thimmaiah',
        'Veeranna', 'Srinivas', 'Prasad', 'Bhaskar', 'Gopal', 'Harish', 'Kiran', 'Madhu',
        'Nagesh', 'Praveen', 'Ramana', 'Sudhir', 'Vamsi', 'Venkat', 'Raju', 'Biju', 'Manu',
        'Nibin', 'Rajeev', 'Sunil', 'Dileep', 'Sreejith', 'Anoop', 'Sujith', 'Vishnu', 'Aravind',
    ];

    private array $southFemaleFirst = [
        'Kavitha', 'Lakshmi', 'Meena', 'Nithya', 'Pavithra', 'Radhika', 'Saranya', 'Thenmozhi',
        'Vasantha', 'Abirami', 'Bhuvana', 'Chithra', 'Dhanya', 'Gayathri', 'Hema', 'Indhu',
        'Jayanthi', 'Kamala', 'Lavanya', 'Malathi', 'Nandhini', 'Parvathi', 'Ranjani', 'Shanthi',
        'Anuradha', 'Bhavani', 'Chandana', 'Eesha', 'Haritha', 'Jyothi', 'Latha', 'Madhuri',
        'Padmavathi', 'Sowmya', 'Veda', 'Yamini', 'Deepa', 'Oviya', 'Uma', 'Sudha', 'Revathi',
        'Preethi', 'Nandini', 'Manju', 'Keerthi', 'Jisha', 'Divya', 'Bindu', 'Anu', 'Smitha',
        'Sindhu', 'Rekha', 'Poornima', 'Nirmala', 'Meenakshi', 'Lalitha', 'Indu', 'Geetha',
    ];

    private array $southSurnames = [
        'Murugesan', 'Krishnamurthy', 'Subramaniam', 'Ramamurthy', 'Venkatesan', 'Sundaram',
        'Natarajan', 'Ramasamy', 'Arunachalam', 'Balakrishnan', 'Chandrasekaran', 'Ganesan',
        'Hariharan', 'Karthikeyan', 'Lakshmanan', 'Manikandan', 'Narayanan', 'Rajendran',
        'Selvakumar', 'Reddy', 'Naidu', 'Rao', 'Varma', 'Chowdary', 'Nair', 'Menon', 'Pillai',
        'Kurup', 'Namboothiri', 'Gowda', 'Hegde', 'Shetty', 'Bhat', 'Patil', 'Iyer', 'Iyengar',
        'Venkataraman', 'Subramanian', 'Ramakrishnan', 'Govindasamy', 'Shanmugam', 'Elumalai',
        'Dhandapani', 'Annamalai', 'Arumugam', 'Palaniswamy', 'Ravi', 'Kumar', 'Pillai', 'Nambiar',
    ];

    private array $indianLocations = [
        ['Bangalore', 'IN'], ['Mumbai', 'IN'], ['Delhi', 'IN'], ['Hyderabad', 'IN'],
        ['Chennai', 'IN'], ['Pune', 'IN'], ['Kolkata', 'IN'], ['Ahmedabad', 'IN'],
        ['Noida', 'IN'], ['Gurgaon', 'IN'], ['Kochi', 'IN'], ['Coimbatore', 'IN'],
        ['Jaipur', 'IN'], ['Chandigarh', 'IN'], ['Lucknow', 'IN'], ['Indore', 'IN'],
        ['Bhopal', 'IN'], ['Nagpur', 'IN'], ['Surat', 'IN'], ['Mysore', 'IN'],
        ['Thiruvananthapuram', 'IN'], ['Vizag', 'IN'], ['Madurai', 'IN'], ['Patna', 'IN'],
    ];

    private function pick(array $arr): mixed
    {
        return $arr[array_rand($arr)];
    }

    private function picks(array $arr, int $n): array
    {
        shuffle($arr);
        return array_slice($arr, 0, min($n, count($arr)));
    }

    private function rand_bool(int $percent): bool
    {
        return rand(1, 100) <= $percent;
    }

    private function randomName(): array
    {
        $isSouth  = $this->rand_bool(40);
        $isFemale = $this->rand_bool(35);

        if ($isSouth) {
            $first = $this->pick($isFemale ? $this->southFemaleFirst : $this->southMaleFirst);
            $last  = $this->pick($this->southSurnames);
        } else {
            $first = $this->pick($isFemale ? $this->northFemaleFirst : $this->northMaleFirst);
            $last  = $this->pick($this->northSurnames);
        }

        return [$first, $last];
    }

    public function run(): void
    {
        $password = Hash::make('password');

        // ── Category profiles ─────────────────────────────────────────────────
        $categoryProfiles = [

            'artificial-intelligence' => [
                'count'   => 50,
                'titles'  => ['Machine Learning Engineer', 'AI Research Scientist', 'Data Scientist', 'NLP Engineer', 'Computer Vision Engineer', 'MLOps Engineer', 'Deep Learning Specialist', 'AI Product Manager', 'Applied AI Engineer', 'Generative AI Engineer'],
                'companies' => ['Google DeepMind', 'OpenAI', 'Meta AI', 'Microsoft Research', 'NVIDIA', 'Hugging Face', 'Anthropic', 'Amazon AWS', 'IBM Research', 'Cohere'],
                'skills'  => ['Python', 'TensorFlow', 'PyTorch', 'Machine Learning', 'Deep Learning', 'NLP', 'Computer Vision', 'Scikit-learn', 'Keras', 'Hugging Face', 'LangChain', 'MLflow', 'CUDA', 'Reinforcement Learning', 'RAG'],
                'rates'   => [80, 100, 120, 150, 180, 200],
                'locations' => [['San Francisco, CA', 'US'], ['Seattle, WA', 'US'], ['New York, NY', 'US'], ['London', 'GB'], ['Berlin', 'DE'], ['Bangalore', 'IN'], ['Toronto', 'CA']],
                'bio_templates' => [
                    '{exp} years building production ML systems at {company}. Specialised in {skill1} and {skill2}. Helped 200+ engineers break into AI roles.',
                    'AI researcher turned industry engineer. Former {company}. Expert in {skill1}, {skill2}, and {skill3}. Published at NeurIPS and ICML.',
                    'Senior ML engineer with {exp} years. Passionate about making AI accessible. Expertise in {skill1} and {skill2}.',
                ],
                'packages' => [
                    ['title' => 'ML Fundamentals Bootcamp', 'type' => 'training-program', 'level' => 'beginner', 'sessions' => 8, 'duration' => 90, 'topics' => ['Intro to Machine Learning', 'Linear & Logistic Regression', 'Decision Trees & Random Forests', 'Neural Network Basics', 'Model Evaluation & Tuning', 'Feature Engineering', 'Deploying ML Models', 'Career in AI']],
                    ['title' => 'Deep Learning Masterclass', 'type' => 'training-program', 'level' => 'intermediate', 'sessions' => 6, 'duration' => 90, 'topics' => ['CNNs & Image Classification', 'RNNs & Sequence Models', 'Transformers & Attention', 'Transfer Learning', 'Generative Models (GANs, VAEs)', 'Production Deep Learning']],
                    ['title' => 'AI Career Coaching Session', 'type' => '1-on-1-consultation', 'level' => 'all', 'sessions' => 1, 'duration' => 60, 'topics' => ['Resume & LinkedIn Review', 'AI Interview Preparation', 'Portfolio Project Review', 'Career Roadmap Planning']],
                    ['title' => 'LLM & Generative AI Workshop', 'type' => 'workshop', 'level' => 'intermediate', 'sessions' => 3, 'duration' => 120, 'topics' => ['Intro to LLMs & Prompt Engineering', 'Building RAG Applications', 'Fine-tuning & Deployment']],
                ],
            ],

            'development' => [
                'count'   => 60,
                'titles'  => ['Senior Full-Stack Developer', 'Backend Engineer', 'Frontend Engineer', 'Mobile App Developer', 'Software Architect', 'Principal Engineer', 'iOS Developer', 'Android Developer', 'React Native Developer', 'DevRel Engineer'],
                'companies' => ['Stripe', 'Shopify', 'Airbnb', 'Uber', 'Netflix', 'Spotify', 'GitHub', 'Atlassian', 'Twilio', 'Vercel'],
                'skills'  => ['JavaScript', 'TypeScript', 'React', 'Node.js', 'Python', 'Go', 'Java', 'Kotlin', 'Swift', 'GraphQL', 'PostgreSQL', 'Redis', 'Docker', 'Microservices', 'REST APIs'],
                'rates'   => [60, 80, 100, 120, 150],
                'locations' => [['San Francisco, CA', 'US'], ['Austin, TX', 'US'], ['New York, NY', 'US'], ['London', 'GB'], ['Amsterdam', 'NL'], ['Warsaw', 'PL'], ['Bangalore', 'IN']],
                'bio_templates' => [
                    'Full-stack engineer with {exp} years at {company}. Built products used by millions. Love mentoring developers from junior to senior.',
                    '{exp}+ years building scalable web apps. Ex-{company}. Passionate about clean code, {skill1}, and {skill2}.',
                    'Software engineer specialising in {skill1} and {skill2}. {exp} years of industry experience. Former {company} tech lead.',
                ],
                'packages' => [
                    ['title' => 'Full-Stack Web Development Program', 'type' => 'training-program', 'level' => 'beginner', 'sessions' => 10, 'duration' => 90, 'topics' => ['HTML, CSS & JavaScript Foundations', 'React Fundamentals', 'State Management with Redux', 'Node.js & Express APIs', 'Database Design with PostgreSQL', 'Authentication & Security', 'Deployment on AWS/Vercel', 'Testing & CI/CD', 'Code Review & Best Practices', 'Portfolio & Job Prep']],
                    ['title' => 'React Advanced Patterns', 'type' => 'training-program', 'level' => 'intermediate', 'sessions' => 5, 'duration' => 90, 'topics' => ['Custom Hooks & Composition', 'Performance Optimisation', 'React Query & Server State', 'Testing with Vitest & Testing Library', 'Micro-Frontend Architecture']],
                    ['title' => '1-on-1 Code Review & Mentoring', 'type' => '1-on-1-consultation', 'level' => 'all', 'sessions' => 1, 'duration' => 60, 'topics' => ['Code Review & Refactoring', 'Architecture Discussion', 'Career & Salary Negotiation', 'Technical Interview Prep']],
                    ['title' => 'Backend API Design Workshop', 'type' => 'workshop', 'level' => 'intermediate', 'sessions' => 2, 'duration' => 120, 'topics' => ['REST vs GraphQL Design Principles', 'Scalable API Architecture & Security']],
                ],
            ],

            'business' => [
                'count'   => 40,
                'titles'  => ['Startup Founder & CEO', 'Business Strategy Consultant', 'Venture Capitalist', 'Growth Advisor', 'Chief Operating Officer', 'Business Development Director', 'Entrepreneur & Mentor', 'Management Consultant', 'Executive Coach', 'GTM Strategist'],
                'companies' => ['McKinsey', 'BCG', 'Sequoia Capital', 'Y Combinator', 'Bain & Company', 'Deloitte', 'Goldman Sachs', 'Andreessen Horowitz', 'Accenture', 'KPMG'],
                'skills'  => ['Business Strategy', 'Fundraising', 'Pitch Deck', 'P&L Management', 'Market Research', 'OKRs', 'Unit Economics', 'Go-to-Market', 'Leadership', 'Negotiation'],
                'rates'   => [100, 150, 200, 250, 300],
                'locations' => [['New York, NY', 'US'], ['San Francisco, CA', 'US'], ['London', 'GB'], ['Singapore', 'SG'], ['Dubai', 'AE'], ['Mumbai', 'IN']],
                'bio_templates' => [
                    'Built and sold two startups. Former partner at {company}. Now helping founders avoid the mistakes I made. Expertise in {skill1} and {skill2}.',
                    '{exp} years in strategy consulting at {company}. Advised Fortune 500 companies on {skill1}. Now working with early-stage founders.',
                    'Serial entrepreneur with {exp}+ years. Angel investor. Passionate about {skill1} and scaling teams.',
                ],
                'packages' => [
                    ['title' => 'Startup Launch Accelerator', 'type' => 'coaching', 'level' => 'beginner', 'sessions' => 6, 'duration' => 60, 'topics' => ['Idea Validation & Problem-Solution Fit', 'Business Model Design', 'Building an MVP', 'Go-to-Market Strategy', 'Fundraising & Investor Relations', 'Scaling & Operations']],
                    ['title' => 'Investor Pitch Preparation', 'type' => 'interview-prep', 'level' => 'intermediate', 'sessions' => 3, 'duration' => 90, 'topics' => ['Pitch Deck Structure & Story', 'Financial Projections & Unit Economics', 'Mock Pitch & Q&A Coaching']],
                    ['title' => 'Business Strategy Advisory Session', 'type' => '1-on-1-consultation', 'level' => 'all', 'sessions' => 1, 'duration' => 60, 'topics' => ['Strategic Review & Gap Analysis', 'Competitive Positioning', 'Growth Roadmap', 'Decision-Making Frameworks']],
                ],
            ],

            'design-architecture' => [
                'count'   => 35,
                'titles'  => ['UX Design Lead', 'Senior Product Designer', 'UI/UX Designer', 'Design Systems Lead', 'Creative Director', 'Brand Designer', 'Interaction Designer', 'Visual Designer', 'Head of Design', 'Product Design Manager'],
                'companies' => ['Apple', 'Figma', 'Adobe', 'Airbnb', 'Dropbox', 'Canva', 'InVision', 'Spotify', 'Facebook', 'Google'],
                'skills'  => ['Figma', 'Sketch', 'Adobe XD', 'UX Research', 'Prototyping', 'Design Systems', 'User Testing', 'Wireframing', 'Motion Design', 'Accessibility', 'Adobe Illustrator', 'Framer'],
                'rates'   => [70, 90, 110, 130, 160],
                'locations' => [['San Francisco, CA', 'US'], ['New York, NY', 'US'], ['London', 'GB'], ['Amsterdam', 'NL'], ['Sydney', 'AU'], ['Berlin', 'DE']],
                'bio_templates' => [
                    'Design leader at {company} with {exp} years shaping award-winning products. Expert in {skill1} and {skill2}. Mentored 100+ designers.',
                    'Product designer specialising in {skill1}. Former {company}. Helping designers build strong portfolios and land dream roles.',
                    '{exp} years at {company}. Passionate about human-centred design and {skill1}. Led design for products with 10M+ users.',
                ],
                'packages' => [
                    ['title' => 'UX Design Career Accelerator', 'type' => 'training-program', 'level' => 'beginner', 'sessions' => 7, 'duration' => 60, 'topics' => ['Design Thinking & UX Fundamentals', 'User Research Methods', 'Wireframing & IA', 'Prototyping with Figma', 'Usability Testing', 'Building Your Portfolio', 'UX Interview Preparation']],
                    ['title' => 'Figma Mastery Workshop', 'type' => 'workshop', 'level' => 'beginner', 'sessions' => 3, 'duration' => 90, 'topics' => ['Figma Components & Auto Layout', 'Prototyping & Interactive Flows', 'Design Systems & Variables']],
                    ['title' => 'Portfolio & Career Review', 'type' => '1-on-1-consultation', 'level' => 'all', 'sessions' => 1, 'duration' => 60, 'topics' => ['Portfolio Critique & Improvements', 'Case Study Storytelling', 'Career Strategy & Job Search']],
                ],
            ],

            'finance' => [
                'count'   => 35,
                'titles'  => ['Investment Banking VP', 'Portfolio Manager', 'Financial Analyst', 'CFO & Finance Advisor', 'Equity Research Analyst', 'Private Equity Associate', 'Hedge Fund Manager', 'CFA Charterholder & Mentor', 'Corporate Finance Director', 'Quant Analyst'],
                'companies' => ['Goldman Sachs', 'JP Morgan', 'Morgan Stanley', 'BlackRock', 'Citadel', 'Bridgewater', 'Fidelity', 'Deutsche Bank', 'HSBC', 'Barclays'],
                'skills'  => ['Financial Modelling', 'Valuation', 'DCF Analysis', 'M&A', 'Excel', 'Bloomberg', 'Investment Analysis', 'Risk Management', 'Equity Research', 'Python for Finance', 'LBO Modelling'],
                'rates'   => [100, 150, 200, 250],
                'locations' => [['New York, NY', 'US'], ['London', 'GB'], ['Hong Kong', 'HK'], ['Singapore', 'SG'], ['Zurich', 'CH'], ['Mumbai', 'IN']],
                'bio_templates' => [
                    '{exp} years in investment banking at {company}. VP-level. Expert in {skill1} and {skill2}. Helped 100+ candidates break into finance.',
                    'CFA Charterholder and {exp}-year veteran at {company}. Specialised in {skill1}. Passionate about financial education.',
                    'Former {company} analyst now advising finance professionals. Expertise in {skill1} and {skill2}.',
                ],
                'packages' => [
                    ['title' => 'Investment Banking Interview Prep', 'type' => 'interview-prep', 'level' => 'advanced', 'sessions' => 4, 'duration' => 90, 'topics' => ['Financial Statement Analysis', 'Valuation (DCF, Comps, Precedents)', 'M&A & LBO Concepts', 'Mock Interview & Feedback']],
                    ['title' => 'Financial Modelling Masterclass', 'type' => 'training-program', 'level' => 'intermediate', 'sessions' => 5, 'duration' => 90, 'topics' => ['Excel for Finance', 'Three-Statement Model', 'DCF Valuation Model', 'LBO Modelling', 'Merger Model']],
                    ['title' => 'CFA Exam Coaching', 'type' => 'coaching', 'level' => 'intermediate', 'sessions' => 6, 'duration' => 60, 'topics' => ['Ethics & Standards', 'Quantitative Methods', 'Equity Investments', 'Fixed Income', 'Derivatives & Alternatives', 'Portfolio Management']],
                ],
            ],

            'marketing' => [
                'count'   => 40,
                'titles'  => ['Growth Marketing Director', 'Head of Digital Marketing', 'SEO Strategist', 'Content Marketing Manager', 'Performance Marketing Lead', 'CMO & Advisor', 'Social Media Strategist', 'Email Marketing Expert', 'Brand Strategist', 'Demand Generation Manager'],
                'companies' => ['HubSpot', 'Salesforce', 'Mailchimp', 'Buffer', 'SEMrush', 'Hootsuite', 'Moz', 'Klaviyo', 'ActiveCampaign', 'Ahrefs'],
                'skills'  => ['SEO', 'Google Ads', 'Facebook Ads', 'Content Marketing', 'Email Marketing', 'Analytics', 'Conversion Optimisation', 'Social Media', 'Copywriting', 'Marketing Automation', 'Affiliate Marketing'],
                'rates'   => [60, 80, 100, 120, 150],
                'locations' => [['New York, NY', 'US'], ['Austin, TX', 'US'], ['London', 'GB'], ['Toronto', 'CA'], ['Sydney', 'AU'], ['Bangalore', 'IN']],
                'bio_templates' => [
                    'Growth marketer with {exp} years at {company}. Scaled revenue from $1M to $50M. Expert in {skill1} and {skill2}.',
                    'Former CMO at {company}. {exp} years building growth engines for B2B SaaS. Passionate about {skill1}.',
                    'Digital marketing specialist with proven ROI. {exp} years at {company}. Expertise in {skill1} and {skill2}.',
                ],
                'packages' => [
                    ['title' => 'SEO Mastery Program', 'type' => 'training-program', 'level' => 'beginner', 'sessions' => 6, 'duration' => 60, 'topics' => ['SEO Fundamentals & Keyword Research', 'On-Page Optimisation', 'Technical SEO', 'Link Building Strategies', 'Content SEO & Topic Clusters', 'SEO Analytics & Reporting']],
                    ['title' => 'Paid Ads Strategy Workshop', 'type' => 'workshop', 'level' => 'intermediate', 'sessions' => 3, 'duration' => 90, 'topics' => ['Google Ads Campaign Setup', 'Facebook & Instagram Ads', 'ROI Optimisation & Scaling']],
                    ['title' => 'Growth Marketing Coaching', 'type' => 'coaching', 'level' => 'intermediate', 'sessions' => 1, 'duration' => 60, 'topics' => ['Marketing Audit & Strategy', 'Funnel Analysis', 'Growth Experiment Design', 'Channel Mix Optimisation']],
                ],
            ],

            'infrastructure' => [
                'count'   => 35,
                'titles'  => ['DevOps Architect', 'Cloud Solutions Architect', 'Site Reliability Engineer', 'Platform Engineer', 'Infrastructure Lead', 'Kubernetes Expert', 'AWS Certified Architect', 'Azure Solutions Architect', 'GCP Engineer', 'Security Engineer'],
                'companies' => ['Amazon AWS', 'Google Cloud', 'Microsoft Azure', 'HashiCorp', 'Cloudflare', 'Datadog', 'New Relic', 'PagerDuty', 'Grafana', 'Red Hat'],
                'skills'  => ['AWS', 'Kubernetes', 'Docker', 'Terraform', 'CI/CD', 'Ansible', 'Linux', 'GCP', 'Azure', 'Prometheus', 'Grafana', 'Jenkins', 'Helm', 'Service Mesh', 'GitOps'],
                'rates'   => [80, 100, 130, 160, 200],
                'locations' => [['Seattle, WA', 'US'], ['San Francisco, CA', 'US'], ['Dublin', 'IE'], ['Berlin', 'DE'], ['Bangalore', 'IN'], ['Toronto', 'CA']],
                'bio_templates' => [
                    'Cloud architect at {company} with {exp} years designing resilient infrastructure. Expert in {skill1} and {skill2}.',
                    'SRE and DevOps specialist. {exp} years at {company}. Helped teams achieve 99.99% uptime using {skill1}.',
                    '{exp} years building cloud-native platforms at {company}. Certified AWS, GCP, and Azure. Expert in {skill1}.',
                ],
                'packages' => [
                    ['title' => 'AWS Solutions Architect Exam Prep', 'type' => 'training-program', 'level' => 'intermediate', 'sessions' => 5, 'duration' => 90, 'topics' => ['AWS Core Services Deep Dive', 'High Availability & Auto Scaling', 'Security & IAM Best Practices', 'Storage & Database Options', 'Practice Exam & Strategy']],
                    ['title' => 'Kubernetes & Docker Bootcamp', 'type' => 'training-program', 'level' => 'intermediate', 'sessions' => 6, 'duration' => 90, 'topics' => ['Docker Containers & Images', 'Kubernetes Architecture', 'Deployments & Services', 'Helm Charts', 'CI/CD with Kubernetes', 'Production Monitoring']],
                    ['title' => 'DevOps Transformation Coaching', 'type' => 'coaching', 'level' => 'advanced', 'sessions' => 4, 'duration' => 60, 'topics' => ['CI/CD Pipeline Design', 'Infrastructure as Code with Terraform', 'Observability & Monitoring', 'DevSecOps Best Practices']],
                ],
            ],

            'project-management' => [
                'count'   => 35,
                'titles'  => ['Senior Project Manager', 'Scrum Master & Agile Coach', 'PMP Certified PM', 'Programme Director', 'Product Owner', 'Delivery Manager', 'Agile Transformation Lead', 'PMO Director', 'Technical Project Manager', 'Portfolio Manager'],
                'companies' => ['IBM', 'Accenture', 'Infosys', 'Wipro', 'Capgemini', 'TCS', 'SAP', 'Oracle', 'Cognizant', 'HCL'],
                'skills'  => ['Agile', 'Scrum', 'PMP', 'Kanban', 'JIRA', 'Risk Management', 'Stakeholder Management', 'SAFe', 'Prince2', 'MS Project', 'OKRs', 'Confluence'],
                'rates'   => [60, 80, 100, 120],
                'locations' => [['London', 'GB'], ['New York, NY', 'US'], ['Sydney', 'AU'], ['Toronto', 'CA'], ['Bangalore', 'IN'], ['Dubai', 'AE']],
                'bio_templates' => [
                    'PMP and CSM certified PM with {exp} years at {company}. Led $50M+ programmes. Expert in {skill1} and {skill2}.',
                    'Agile coach and Scrum Master at {company}. {exp} years transforming delivery teams using {skill1}.',
                    '{exp} years in project delivery at {company}. Helped 50+ teams adopt {skill1} and achieve on-time delivery.',
                ],
                'packages' => [
                    ['title' => 'PMP Certification Prep', 'type' => 'training-program', 'level' => 'intermediate', 'sessions' => 6, 'duration' => 90, 'topics' => ['PMP Exam Overview & ECO', 'Project Initiation & Planning', 'Execution & Monitoring', 'Risk & Procurement Management', 'Agile in PMP Context', 'Mock Exam & Study Strategy']],
                    ['title' => 'Agile & Scrum Fundamentals', 'type' => 'training-program', 'level' => 'beginner', 'sessions' => 4, 'duration' => 60, 'topics' => ['Agile Manifesto & Principles', 'Scrum Roles & Ceremonies', 'Sprint Planning & Backlog Grooming', 'Velocity, Burndown & Retrospectives']],
                    ['title' => 'PM Coaching & Career Growth', 'type' => 'coaching', 'level' => 'all', 'sessions' => 1, 'duration' => 60, 'topics' => ['Career Roadmap for PMs', 'Stakeholder Management Tips', 'Salary & Promotion Strategy', 'Interview Preparation']],
                ],
            ],

            'hr' => [
                'count'   => 30,
                'titles'  => ['HR Director', 'Talent Acquisition Lead', 'People Operations Manager', 'OD Consultant', 'HR Business Partner', 'Chief People Officer', 'Recruiting Manager', 'L&D Specialist', 'Compensation & Benefits Lead', 'Culture & Engagement Manager'],
                'companies' => ['LinkedIn', 'Workday', 'BambooHR', 'Greenhouse', 'Lever', 'Culture Amp', 'Lattice', 'Rippling', 'Gusto', 'ADP'],
                'skills'  => ['Talent Acquisition', 'Employee Engagement', 'Performance Management', 'HR Analytics', 'Compensation Design', 'L&D', 'HRIS', 'Diversity & Inclusion', 'Organisational Design', 'Succession Planning'],
                'rates'   => [60, 80, 100, 120],
                'locations' => [['New York, NY', 'US'], ['San Francisco, CA', 'US'], ['London', 'GB'], ['Singapore', 'SG'], ['Toronto', 'CA']],
                'bio_templates' => [
                    'HR leader with {exp} years at {company}. Built people teams from 10 to 500. Expert in {skill1} and {skill2}.',
                    'Former CPO at {company}. Passionate about building great cultures. {exp} years expertise in {skill1}.',
                    'Talent acquisition specialist with {exp} years. Hired 1000+ people at {company}. Expert in {skill1} and {skill2}.',
                ],
                'packages' => [
                    ['title' => 'Recruiting & Talent Acquisition Masterclass', 'type' => 'training-program', 'level' => 'intermediate', 'sessions' => 5, 'duration' => 60, 'topics' => ['Sourcing Strategies & Boolean Search', 'Candidate Experience Design', 'Structured Interview Frameworks', 'Employer Branding', 'Metrics & Talent Analytics']],
                    ['title' => 'HR Career Coaching', 'type' => 'coaching', 'level' => 'all', 'sessions' => 1, 'duration' => 60, 'topics' => ['Breaking into HR', 'HRBP Career Path', 'Compensation Negotiation', 'Building Your HR Brand']],
                ],
            ],

            'legal' => [
                'count'   => 25,
                'titles'  => ['Corporate Lawyer & Advisor', 'Senior Litigation Attorney', 'IP & Patents Specialist', 'Employment Law Consultant', 'Startup Legal Advisor', 'Compliance Officer', 'Contract Law Expert', 'M&A Legal Counsel', 'Privacy & Data Law Specialist', 'Criminal Defense Attorney'],
                'companies' => ['Clifford Chance', 'Linklaters', 'Allen & Overy', 'Baker McKenzie', 'DLA Piper', 'Freshfields', 'Herbert Smith Freehills', 'Norton Rose Fulbright', 'White & Case', 'Latham & Watkins'],
                'skills'  => ['Corporate Law', 'Contract Drafting', 'M&A', 'IP Law', 'Employment Law', 'Compliance', 'GDPR', 'Litigation', 'Legal Research', 'Arbitration'],
                'rates'   => [100, 150, 200, 250],
                'locations' => [['London', 'GB'], ['New York, NY', 'US'], ['Singapore', 'SG'], ['Dubai', 'AE'], ['Sydney', 'AU'], ['Mumbai', 'IN']],
                'bio_templates' => [
                    'Partner at {company} with {exp} years in {skill1}. Advised on $1B+ transactions. Now mentoring law students and junior lawyers.',
                    'Lawyer with {exp} years at {company}. Expert in {skill1} and {skill2}. Passionate about access to legal education.',
                    'Former {company} associate. {exp} years specialising in {skill1}. Helping lawyers build successful careers.',
                ],
                'packages' => [
                    ['title' => 'Corporate Law Career Coaching', 'type' => 'coaching', 'level' => 'all', 'sessions' => 3, 'duration' => 60, 'topics' => ['Breaking into Big Law', 'Navigating Law Firm Hierarchy', 'Transitioning to In-House Counsel']],
                    ['title' => 'Contract Drafting & Negotiation', 'type' => 'training-program', 'level' => 'intermediate', 'sessions' => 4, 'duration' => 90, 'topics' => ['Contract Structure & Key Clauses', 'Risk Allocation & Indemnities', 'Negotiation Tactics', 'Real-World Contract Review']],
                ],
            ],

            'health-fitness' => [
                'count'   => 30,
                'titles'  => ['Certified Personal Trainer', 'Sports Nutritionist', 'Yoga & Wellness Coach', 'Physical Therapist', 'Strength & Conditioning Coach', 'Mental Health Coach', 'Certified Dietitian', 'Marathon Coach', 'Functional Fitness Expert', 'Holistic Health Practitioner'],
                'companies' => ['Nike Training', 'Peloton', 'Equinox', "Barry's Bootcamp", 'Crossfit HQ', 'Orangetheory', 'ClassPass', 'Headspace', 'Calm', 'MyFitnessPal'],
                'skills'  => ['Personal Training', 'Nutrition Planning', 'Weight Loss', 'Strength Training', 'HIIT', 'Yoga', 'Mental Wellness', 'Injury Recovery', 'Marathon Training', 'Body Composition'],
                'rates'   => [40, 60, 80, 100],
                'locations' => [['Los Angeles, CA', 'US'], ['New York, NY', 'US'], ['Miami, FL', 'US'], ['London', 'GB'], ['Sydney', 'AU'], ['Dubai', 'AE']],
                'bio_templates' => [
                    'Certified trainer at {company} with {exp} years transforming clients\' lives. Expert in {skill1} and {skill2}.',
                    'Sports nutritionist and trainer. {exp} years at {company}. Helped 500+ clients achieve their fitness goals through {skill1}.',
                    'Health and wellness coach with {exp} years. Specialised in {skill1} and {skill2}. Former professional athlete.',
                ],
                'packages' => [
                    ['title' => '12-Week Body Transformation Program', 'type' => 'training-program', 'level' => 'all', 'sessions' => 12, 'duration' => 60, 'topics' => ['Fitness Assessment & Goal Setting', 'Nutrition Fundamentals', 'Strength Training Basics', 'Cardio & Conditioning', 'Recovery & Sleep', 'Week 4 Progress Check', 'Advanced Training Techniques', 'Meal Planning', 'Mindset & Motivation', 'Week 8 Assessment', 'Peak Week Preparation', 'Final Review & Maintenance Plan']],
                    ['title' => 'Nutrition & Wellness Coaching', 'type' => 'coaching', 'level' => 'all', 'sessions' => 4, 'duration' => 45, 'topics' => ['Nutritional Assessment', 'Personalised Meal Planning', 'Supplement Guidance', 'Long-term Lifestyle Habits']],
                ],
            ],

            'competitive-exams' => [
                'count'   => 25,
                'titles'  => ['GRE & GMAT Expert Tutor', 'IELTS & TOEFL Coach', 'CAT Exam Mentor', 'UPSC Coaching Expert', 'SAT & ACT Tutor', 'GATE Exam Specialist', 'CFA Exam Coach', 'Bar Exam Tutor', 'LSAT Preparation Expert', 'Medical Entrance Mentor'],
                'companies' => ['Princeton Review', 'Kaplan', 'Magoosh', 'Manhattan Prep', 'Veritas Prep', 'Target Test Prep', 'e-GMAT', 'Wharton', 'IIM Ahmedabad', 'IIT Delhi'],
                'skills'  => ['GRE Prep', 'GMAT Coaching', 'IELTS Training', 'TOEFL Coaching', 'Verbal Reasoning', 'Quantitative Reasoning', 'Essay Writing', 'Exam Strategy', 'Time Management', 'Mock Tests'],
                'rates'   => [30, 50, 70, 90],
                'locations' => [['New York, NY', 'US'], ['Boston, MA', 'US'], ['London', 'GB'], ['Delhi', 'IN'], ['Bangalore', 'IN'], ['Mumbai', 'IN']],
                'bio_templates' => [
                    'Expert tutor at {company} with {exp} years. 99th percentile scorer. Helped 1000+ students achieve target scores in {skill1}.',
                    '{exp} years teaching {skill1} and {skill2}. Former faculty at {company}. Average student improvement: 15+ points.',
                    'Specialised in {skill1} with {exp} years at {company}. Passionate about helping students achieve dream scores.',
                ],
                'packages' => [
                    ['title' => 'GMAT 700+ Score Guarantee Program', 'type' => 'training-program', 'level' => 'intermediate', 'sessions' => 8, 'duration' => 90, 'topics' => ['GMAT Structure & Strategy', 'Quant: Algebra & Word Problems', 'Quant: Geometry & Statistics', 'Verbal: Critical Reasoning', 'Verbal: Reading Comprehension', 'Verbal: Sentence Correction', 'Integrated Reasoning & AWA', 'Full Mock Exam & Review']],
                    ['title' => 'IELTS 8.0 Band Coaching', 'type' => 'training-program', 'level' => 'beginner', 'sessions' => 5, 'duration' => 60, 'topics' => ['Listening Skills & Techniques', 'Reading Comprehension Strategies', 'Academic Writing Task 1 & 2', 'Speaking Fluency & Pronunciation', 'Full Mock Test & Band Prediction']],
                ],
            ],

            'music' => [
                'count'   => 20,
                'titles'  => ['Professional Guitar Instructor', 'Piano & Music Theory Teacher', 'Music Producer', 'Vocal Coach', 'Violin & Classical Music Teacher', 'DJ & Electronic Music Producer', 'Drum & Percussion Instructor', 'Music Composition Teacher', 'Jazz & Improvisation Coach', 'Music Business Mentor'],
                'companies' => ['Berklee College of Music', 'Juilliard', 'Abbey Road Studios', 'Universal Music', 'Sony Music', 'Spotify', 'SoundCloud', 'Native Instruments', 'Ableton', 'Roland'],
                'skills'  => ['Guitar', 'Piano', 'Music Theory', 'Vocals', 'Music Production', 'Ableton Live', 'Logic Pro', 'Mixing & Mastering', 'Songwriting', 'Jazz Improvisation', 'Drums'],
                'rates'   => [30, 50, 70, 90],
                'locations' => [['New York, NY', 'US'], ['Los Angeles, CA', 'US'], ['Nashville, TN', 'US'], ['London', 'GB'], ['Berlin', 'DE'], ['Mumbai', 'IN']],
                'bio_templates' => [
                    'Professional musician and teacher with {exp} years. Former faculty at {company}. Expert in {skill1} and {skill2}.',
                    '{exp} years performing and teaching {skill1}. Worked with {company}. Passionate about unlocking musical potential.',
                    'Music educator at {company} with {exp} years. Helped 300+ students master {skill1} and {skill2}.',
                ],
                'packages' => [
                    ['title' => 'Guitar for Beginners', 'type' => 'training-program', 'level' => 'beginner', 'sessions' => 8, 'duration' => 45, 'topics' => ['Holding the Guitar & Tuning', 'Basic Chords: C, G, D, Em', 'Strumming Patterns', 'Reading Chord Charts & Tabs', 'First Songs', 'Scales & Finger Exercises', 'Barre Chords', 'Playing Your Favourite Song']],
                    ['title' => 'Music Production with Ableton', 'type' => 'training-program', 'level' => 'beginner', 'sessions' => 6, 'duration' => 60, 'topics' => ['Ableton Interface & Navigation', 'Beat Making & Drum Programming', 'Melody & Chord Progressions', 'Sampling & Sound Design', 'Arrangement & Song Structure', 'Mixing & Mastering Basics']],
                ],
            ],

            'photography-video' => [
                'count'   => 25,
                'titles'  => ['Professional Photographer', 'Videographer & Film Director', 'Wedding Photographer', 'Commercial Photography Expert', 'Video Editor & Post-Production', 'Drone Photographer', 'Portrait & Fashion Photographer', 'YouTube Content Creator Coach', 'Cinematographer', 'Photo Retouching Specialist'],
                'companies' => ['National Geographic', 'Getty Images', 'Adobe', 'DJI', 'Canon', 'Nikon', 'Netflix', 'Sony Pictures', 'YouTube', 'Instagram'],
                'skills'  => ['Photography', 'Lightroom', 'Photoshop', 'Videography', 'Premiere Pro', 'DaVinci Resolve', 'Lighting', 'Composition', 'Drone Photography', 'Color Grading', 'After Effects'],
                'rates'   => [40, 60, 80, 100],
                'locations' => [['New York, NY', 'US'], ['Los Angeles, CA', 'US'], ['London', 'GB'], ['Paris', 'FR'], ['Sydney', 'AU'], ['Dubai', 'AE']],
                'bio_templates' => [
                    'Award-winning photographer at {company} with {exp} years. Expert in {skill1} and {skill2}. Published in major magazines.',
                    'Professional videographer and {skill1} expert. {exp} years working with {company}. Passionate about visual storytelling.',
                    '{exp} years in photography and video. Former {company} contributor. Teaching {skill1} and {skill2} to aspiring creators.',
                ],
                'packages' => [
                    ['title' => 'Photography Fundamentals Course', 'type' => 'training-program', 'level' => 'beginner', 'sessions' => 6, 'duration' => 60, 'topics' => ['Camera Settings & Exposure Triangle', 'Composition Rules & Techniques', 'Lighting Fundamentals', 'Lightroom Editing Workflow', 'Portrait Photography', 'Building Your Photography Portfolio']],
                    ['title' => 'Video Editing with Premiere Pro', 'type' => 'workshop', 'level' => 'beginner', 'sessions' => 4, 'duration' => 90, 'topics' => ['Premiere Pro Interface & Import', 'Cutting, Trimming & Transitions', 'Color Correction & Grading', 'Audio Mixing & Export']],
                ],
            ],
        ];

        // ── Load lookup data ──────────────────────────────────────────────────
        $categories   = Category::all()->keyBy('slug');
        $packageTypes = PackageType::all()->keyBy('slug');
        $emailIndex   = 1000;

        foreach ($categoryProfiles as $categorySlug => $profile) {
            $category = $categories->get($categorySlug);
            if (!$category) continue;

            for ($i = 0; $i < $profile['count']; $i++) {
                [$firstName, $lastName] = $this->randomName();
                $name      = $firstName . ' ' . $lastName;
                $emailIndex++;
                $email     = strtolower($firstName) . '.' . strtolower($lastName) . $emailIndex . '@mentf.com';
                $title     = $this->pick($profile['titles']);
                $company   = $this->pick($profile['companies']);
                $location  = $this->rand_bool(70)
                    ? $this->pick($this->indianLocations)
                    : $this->pick($profile['locations']);
                $rate      = $this->pick($profile['rates']);
                $exp       = rand(3, 18);
                $skills    = $this->picks($profile['skills'], rand(4, 7));
                $rating    = round((rand(38, 50) / 10), 1);
                $reviews   = rand(0, 180);
                $students  = rand(0, 400);
                $featured  = $this->rand_bool(15);

                $bioTemplate = $this->pick($profile['bio_templates']);
                $bio = str_replace(
                    ['{exp}', '{company}', '{skill1}', '{skill2}', '{skill3}'],
                    [$exp, $company, $skills[0], $skills[1] ?? $skills[0], $skills[2] ?? $skills[0]],
                    $bioTemplate
                );

                // ── Create mentor ─────────────────────────────────────────────
                $mentor = User::create([
                    'name'             => $name,
                    'email'            => $email,
                    'password'         => $password,
                    'role'             => 'mentor',
                    'title'            => $title . ' at ' . $company,
                    'bio'              => $bio,
                    'location'         => $location[0],
                    'country'          => $location[1],
                    'hourly_rate'      => $rate,
                    'currency'         => 'USD',
                    'years_experience' => $exp,
                    'avg_rating'       => $rating,
                    'total_reviews'    => $reviews,
                    'total_students'   => $students,
                    'is_active'        => true,
                    'is_featured'      => $featured,
                ]);

                $mentor->categories()->attach($category->id);
                $category->increment('mentors_count');

                foreach ($skills as $skillName) {
                    $skill = Skill::firstOrCreate(['name' => $skillName]);
                    $mentor->skills()->syncWithoutDetaching([$skill->id]);
                }

                // ── Create 1–2 packages for this mentor ───────────────────────
                $numPackages = rand(1, 2);
                $packagePool = $this->picks($profile['packages'], $numPackages);

                foreach ($packagePool as $pkgTemplate) {
                    $pkgType = $packageTypes->get($pkgTemplate['type']);
                    if (!$pkgType) continue;

                    $basePrice = $rate * ($pkgTemplate['sessions'] > 1 ? $pkgTemplate['sessions'] * 0.85 : 1);

                    $package = Package::create([
                        'user_id'           => $mentor->id,
                        'category_id'       => $category->id,
                        'package_type_id'   => $pkgType->id,
                        'title'             => $pkgTemplate['title'],
                        'slug'              => Str::slug($pkgTemplate['title']) . '-' . $mentor->id,
                        'description'       => 'A comprehensive ' . strtolower($pkgTemplate['title']) . ' designed to help you master the subject with expert guidance from an industry professional.',
                        'price'             => round($basePrice / 5) * 5,
                        'currency'          => 'USD',
                        'duration'          => $pkgTemplate['duration'],
                        'sessions'          => $pkgTemplate['sessions'],
                        'level'             => $pkgTemplate['level'],
                        'language'          => 'en',
                        'is_active'         => true,
                        'is_featured'       => $this->rand_bool(10),
                        'avg_rating'        => $reviews > 0 ? round((rand(38, 50) / 10), 1) : 0,
                        'total_reviews'     => rand(0, min($reviews, 40)),
                        'total_enrollments' => rand(0, min($students, 80)),
                    ]);

                    foreach ($pkgTemplate['topics'] as $idx => $topicTitle) {
                        Topic::create([
                            'package_id'     => $package->id,
                            'title'          => $topicTitle,
                            'session_number' => $idx + 1,
                            'duration'       => $pkgTemplate['duration'],
                            'sort_order'     => $idx + 1,
                        ]);
                    }
                }
            }
        }
    }
}
