<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Skill;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name'       => 'Amit Priyadarshi',
            'email'      => 'amitpri@gmail.com',
            'password'   => Hash::make('password'),
            'role'       => 'admin',
            'slug'       => 'admin',
            'phone'      => '9538988111',
            'is_active'  => true,
        ]);

        // Mentors with full profiles
        $mentors = [
            [
                'name'             => 'Amit Priyadarshi',
                'email'            => 'amitbangalore2017@gmail.com',
                'phone'            => '9538988111',
                'title'            => 'Director - Technology | Synechron',
                'bio'              => "Head - Information Management Practice\nSolution Architect, Enterprise Architect, Tech Lead, Developer, Designer, Presales\nData, Big Data, Kafka, Analytics, Cloud, DWH, ETL, BI, Dimensional Data Model\nService Delivery, Solution Architecture, Presales and Consulting\nTOGAF certified professional with 21 years of experience\nB.Tech from Indian Institute of Technology (IIT) - Roorkee\nExcellent Customer, Vendor & Team management skills",
                'location'         => 'Bangalore, India',
                'country'          => 'IN',
                'linkedin'         => 'https://www.linkedin.com/in/amit-priyadarshi-7602245/',
                'years_experience' => 21,
                'hourly_rate'      => 1000,
                'currency'         => 'INR',
                'total_students'   => 200,
                'is_featured'      => true,
                'avg_rating'       => 4.9,
                'total_reviews'    => 45,
                'categories'       => ['development', 'infrastructure'],
                'skills'           => ['Oracle', 'SQL Server', 'MySQL', 'Hive', 'Kafka', 'HDFS', 'ETL', 'Informatica', 'Python', 'Java', 'Big Data', 'AWS', 'Azure', 'Data Mesh'],
            ],
            [
                'name'             => 'Dr. Shivangi Sinha',
                'email'            => 'shivangisinha@nlc.bvdu.in',
                'phone'            => '8763665704',
                'title'            => 'Sr. Legal Advisor | Assistant Professor at BVDU NLC Pune',
                'bio'              => "PhD, LLM, BBA LL.B — Specialization in Arbitration & Corporate Laws.\nAssistant Professor at Bharati Vidyapeeth (Deemed to be University) New Law College, Pune.\nFormer Advocate at Jharkhand High Court.\nExpertise: Corporate Law, M&A, Competition Law, ADR, Cyber Law, Legal Research.\nMember of CIArb and Young Mumbai Center of International Arbitration.",
                'location'         => 'Pune, India',
                'country'          => 'IN',
                'linkedin'         => 'https://www.linkedin.com/in/dr-shivangi-sinha-962086bb/',
                'years_experience' => 10,
                'hourly_rate'      => 2000,
                'currency'         => 'INR',
                'total_students'   => 50,
                'is_featured'      => true,
                'avg_rating'       => 4.8,
                'total_reviews'    => 18,
                'categories'       => ['legal'],
                'skills'           => ['Corporate Law', 'Arbitration', 'M&A', 'Cyber Law', 'Legal Research', 'Compliance'],
            ],
            [
                'name'             => 'Nivita Dhameja',
                'email'            => 'nivitadhameja18@gmail.com',
                'phone'            => '+919717980378',
                'title'            => 'Program Manager | UiPath',
                'location'         => 'Delhi, India',
                'country'          => 'IN',
                'linkedin'         => 'https://www.linkedin.com/in/nivita-dhameja/',
                'years_experience' => 8,
                'hourly_rate'      => 1500,
                'currency'         => 'INR',
                'total_students'   => 150,
                'is_featured'      => true,
                'avg_rating'       => 4.7,
                'total_reviews'    => 30,
                'categories'       => ['project-management'],
                'skills'           => ['Project Management', 'UiPath', 'RPA', 'Agile', 'Scrum'],
            ],
            [
                'name'             => 'Rajiv Singh',
                'email'            => 'amitpri2024@gmail.com',
                'phone'            => '9538988111',
                'years_experience' => 0,
                'currency'         => 'INR',
                'categories'       => [],
                'skills'           => [],
            ],
            [
                'name'             => 'Mohammad Shahid Khan',
                'email'            => 'shahid211800@gmail.com',
                'phone'            => '7007995502',
                'years_experience' => 0,
                'currency'         => 'INR',
                'categories'       => [],
                'skills'           => [],
            ],
            [
                'name'             => 'venkataraman venkateswaran',
                'email'            => 'venkynir_98@hotmail.com',
                'phone'            => '09444470548',
                'years_experience' => 0,
                'currency'         => 'INR',
                'categories'       => [],
                'skills'           => [],
            ],
            [
                'name'             => 'Naresh Arora',
                'email'            => 'arora_naresh@hotmail.com',
                'phone'            => '+919818101989',
                'years_experience' => 0,
                'currency'         => 'INR',
                'categories'       => [],
                'skills'           => [],
            ],
            [
                'name'             => 'C V M R PRAKASH',
                'email'            => 'cvmrprakash@gmail.com',
                'phone'            => '9441479444',
                'years_experience' => 0,
                'currency'         => 'INR',
                'categories'       => [],
                'skills'           => [],
            ],
            [
                'name'             => 'Sudhir Sharma',
                'email'            => 'sudhirsharma@iitbhilai.ac.in',
                'phone'            => '+918787862055',
                'years_experience' => 0,
                'currency'         => 'INR',
                'categories'       => [],
                'skills'           => [],
            ],
            [
                'name'             => 'ABHISHEK SINHA',
                'email'            => 'abhishek.11n05@gmail.com',
                'phone'            => '9932607873',
                'years_experience' => 0,
                'currency'         => 'INR',
                'categories'       => [],
                'skills'           => [],
            ],
            [
                'name'             => 'Shikhar Rusia',
                'email'            => 'shikharrusia@gmail.com',
                'phone'            => '7388319102',
                'years_experience' => 0,
                'currency'         => 'INR',
                'categories'       => [],
                'skills'           => [],
            ],
            [
                'name'             => 'Dakshina Jain',
                'email'            => 'jaindakshina02@gmail.com',
                'phone'            => '08320293863',
                'years_experience' => 0,
                'currency'         => 'INR',
                'categories'       => [],
                'skills'           => [],
            ],
            [
                'name'             => 'Rohan Lanke',
                'email'            => 'lanke.rohan@gmail.com',
                'phone'            => '7702286519',
                'years_experience' => 0,
                'currency'         => 'INR',
                'categories'       => [],
                'skills'           => [],
            ],
            [
                'name'             => 'Payal Saini',
                'email'            => 'payalsaini6563@gmail.com',
                'phone'            => '9079975114',
                'years_experience' => 0,
                'currency'         => 'INR',
                'categories'       => [],
                'skills'           => [],
            ],
        ];

        foreach ($mentors as $data) {
            $categories = $data['categories'] ?? [];
            $skills     = $data['skills'] ?? [];
            unset($data['categories'], $data['skills']);

            $mentor = User::create(array_merge([
                'password'  => Hash::make('password'),
                'role'      => 'mentor',
                'is_active' => true,
            ], $data));

            foreach ($categories as $slug) {
                $category = Category::where('slug', $slug)->first();
                if ($category) {
                    $mentor->categories()->attach($category->id);
                    $category->increment('mentors_count');
                }
            }

            foreach ($skills as $skillName) {
                $skill = Skill::firstOrCreate(['name' => $skillName]);
                $mentor->skills()->syncWithoutDetaching([$skill->id]);
            }
        }

        // Mentees (real registrants from DB)
        $mentees = [
            ['name' => 'Sandeep Sagar',    'email' => 'sandeepsagarhere@gmail.com', 'phone' => '9008017896'],
            ['name' => 'Ninad Uddhav Gole','email' => 'ninadgole2311@gmail.com',    'phone' => '9130202037'],
            ['name' => 'Parth Mehrotra',   'email' => 'parthmehrotra55@gmail.com',  'phone' => '8273238621'],
            ['name' => 'Aratrika Manhas',  'email' => 'aruzz092003@gmail.com',      'phone' => '8899723515'],
            ['name' => 'Atharve Mohan Tiwari', 'email' => 'atharvetiwari96@gmail.com', 'phone' => '7620821076'],
            ['name' => 'Shubh Tandon',     'email' => 'tandon.shub@gmail.com',      'phone' => '+918601612345'],
            ['name' => 'Aaryan Dixit',     'email' => 'dixitaryan2112@gmail.com',   'phone' => '9005089494'],
            ['name' => 'Belga Michael S',  'email' => '24-06427@g.batstate-u.edu.ph', 'phone' => '09156874542'],
        ];

        foreach ($mentees as $mentee) {
            User::create(array_merge($mentee, [
                'password'  => Hash::make('password'),
                'role'      => 'mentee',
                'is_active' => true,
            ]));
        }
    }
}
