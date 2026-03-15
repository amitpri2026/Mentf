<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Package;
use App\Models\PackageType;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PackageSeeder extends Seeder
{
    public function run(): void
    {
        // All packages belong to the main mentor (Amit Priyadarshi)
        $packages = [
            [
                'mentor_email' => 'amitbangalore2017@gmail.com',
                'category_slug' => 'development',
                'type_slug'     => '1-on-1-consultation',
                'title'         => 'Big Data Architect Mentorship',
                'slug'          => 'big-data-architect-mentorship',
                'description'   => 'How to be a Big data based technical architect. Comprehensive mentorship covering Big Data landscape, real-world use cases, and architecture patterns for building scalable data platforms.',
                'requirements'  => 'Basic understanding of databases and software development',
                'outcomes'      => "Understand the Big Data landscape and ecosystem\nLearn real-world Big Data architecture patterns\nGain hands-on knowledge of Hadoop, Kafka, and cloud data platforms\nBe able to design scalable Big Data solutions",
                'price'         => 1000,
                'currency'      => 'INR',
                'duration'      => 600,
                'sessions'      => 1,
                'level'         => 'intermediate',
                'is_featured'   => true,
                'total_students' => 20,
                'avg_rating'    => 4.9,
                'total_reviews' => 12,
                'topics' => [
                    ['title' => 'Understanding Big Data Landscape',   'details' => 'Understand different categories of Big Data products and their use cases in enterprise environments.'],
                    ['title' => 'Use Cases Discussions',              'details' => 'Discuss real-world Big Data use cases spanning finance, e-commerce, healthcare, and more.'],
                ],
            ],
            [
                'mentor_email'  => 'amitbangalore2017@gmail.com',
                'category_slug' => 'infrastructure',
                'type_slug'     => '1-on-1-consultation',
                'title'         => 'Kafka Introduction',
                'slug'          => 'kafka-introduction',
                'description'   => '1-hour session showcasing how Kafka is used in real-time applications. Covers core Kafka concepts, producers, consumers, topics, and partitions with live examples.',
                'requirements'  => 'Basic knowledge of distributed systems or messaging queues',
                'outcomes'      => "Understand Kafka architecture and core components\nBuild a simple producer-consumer application\nKnow when and why to use Kafka in real-time systems",
                'price'         => 1000,
                'currency'      => 'INR',
                'duration'      => 60,
                'sessions'      => 1,
                'level'         => 'beginner',
                'is_featured'   => false,
                'total_students' => 0,
                'avg_rating'    => 0,
                'total_reviews' => 0,
                'topics' => [
                    ['title' => 'Kafka Core Concepts',        'details' => 'Topics, partitions, producers, consumers, consumer groups, and offsets.'],
                    ['title' => 'Kafka in Real-Time Systems', 'details' => 'How Kafka is used in data pipelines, event sourcing, and microservices architectures.'],
                ],
            ],
            [
                'mentor_email'  => 'amitbangalore2017@gmail.com',
                'category_slug' => 'infrastructure',
                'type_slug'     => '1-on-1-consultation',
                'title'         => 'Data Mesh Introduction',
                'slug'          => 'data-mesh-introduction',
                'description'   => 'Introduction to Data Mesh — the modern decentralised data architecture paradigm. Understand how to move away from monolithic data lakes to domain-oriented data ownership.',
                'outcomes'      => "Understand Data Mesh principles and motivations\nCompare Data Mesh vs Data Lake vs Data Fabric\nLearn how to apply Data Mesh in your organisation",
                'price'         => 1000,
                'currency'      => 'INR',
                'duration'      => 120,
                'sessions'      => 1,
                'level'         => 'intermediate',
                'is_featured'   => false,
                'total_students' => 0,
                'avg_rating'    => 0,
                'total_reviews' => 0,
                'topics' => [
                    ['title' => 'What is Data Mesh?',                     'details' => 'Origins, principles, and the four pillars of Data Mesh architecture.'],
                    ['title' => 'Solution Architecture for Data Mesh',    'details' => 'Domain-oriented ownership, data as a product, self-serve platform, and federated governance.'],
                ],
            ],
            [
                'mentor_email'  => 'amitbangalore2017@gmail.com',
                'category_slug' => 'development',
                'type_slug'     => '1-on-1-consultation',
                'title'         => 'Datagrid Concepts',
                'slug'          => 'datagrid-concepts',
                'description'   => 'Deep dive into Datagrid concepts for in-memory data storage and distributed caching. Learn how Datagrid powers high-performance, low-latency applications.',
                'outcomes'      => "Understand Datagrid architecture\nLearn distributed caching strategies\nApply Datagrid concepts in real projects",
                'price'         => 500,
                'currency'      => 'INR',
                'duration'      => 120,
                'sessions'      => 1,
                'level'         => 'intermediate',
                'is_featured'   => false,
                'total_students' => 0,
                'avg_rating'    => 0,
                'total_reviews' => 0,
                'topics' => [
                    ['title' => 'Datagrid Architecture Fundamentals', 'details' => 'In-memory storage, partitioning, and replication strategies.'],
                    ['title' => 'Datagrid Use Cases',                 'details' => 'Session management, caching, and real-time analytics with Datagrid.'],
                ],
            ],
            [
                'mentor_email'  => 'amitbangalore2017@gmail.com',
                'category_slug' => 'artificial-intelligence',
                'type_slug'     => 'training-program',
                'title'         => 'Inside Data World',
                'slug'          => 'inside-data-world',
                'description'   => 'Your perfect entry into the data world. This course covers the full journey from RDBMS and ETL in the early 2000s, through Big Data, to modern data platform implementations including Data Mesh and Data Fabric.',
                'requirements'  => 'Basic programming knowledge; curiosity about data and analytics',
                'outcomes'      => "Understand the complete data platform evolution\nMaster DWH, ETL, Data Lake, and Big Data concepts\nLearn real-time processing with Kafka and Spark\nUnderstand modern architectures: Data Mesh and Data Fabric",
                'price'         => 5000,
                'currency'      => 'INR',
                'duration'      => 600,
                'sessions'      => 10,
                'level'         => 'beginner',
                'is_featured'   => true,
                'total_students' => 0,
                'avg_rating'    => 0,
                'total_reviews' => 0,
                'topics' => [
                    ['title' => 'Introduction to Data Landscape',          'details' => 'Understand high-level data implementations through real case studies: RDBMS-based DWH and Data Lake implementations.'],
                    ['title' => 'Traditional DWH & Data Modelling',        'details' => 'Core concepts of DWH and data modelling: DWH, Data Mart, EDW, 3NF and Dimensional Data Modelling.'],
                    ['title' => 'ETL',                                     'details' => 'ETL architecture: batch load, file-based, database extraction, transformations, loading. ETL vs ELT vs ETLT.'],
                    ['title' => 'Master Data Management',                  'details' => 'Master data concepts and MDM: Data Steward responsibilities, merge and matching strategies.'],
                    ['title' => 'Data Governance, Data Quality & Metadata','details' => 'Governance principles, data quality rules, and metadata implementations.'],
                    ['title' => 'Data Lake',                               'details' => 'Next-generation data platforms: architecture, HDFS, Hive, Sqoop, and the data lake ecosystem.'],
                    ['title' => 'Real-Time Processing',                    'details' => 'Real-time architecture with Kafka: core Kafka, Kafka Connectors, KStreams, and KSQL.'],
                    ['title' => 'Data Lake Processing',                    'details' => 'Spark for data lake processing: Python basics, Spark with Python and Scala.'],
                    ['title' => 'Data on Cloud',                           'details' => 'Cloud data architecture: Data on Azure and Data on AWS.'],
                    ['title' => 'Modern Data Architecture',                'details' => 'Data 3.0: Data Mesh, Data Fabric, and the future of data platforms.'],
                ],
            ],
        ];

        foreach ($packages as $pkgData) {
            $mentor   = User::where('email', $pkgData['mentor_email'])->first();
            $category = Category::where('slug', $pkgData['category_slug'])->first();
            $type     = PackageType::where('slug', $pkgData['type_slug'])->first();
            $topics   = $pkgData['topics'];
            $typeSlug = $pkgData['type_slug'];

            unset($pkgData['mentor_email'], $pkgData['category_slug'], $pkgData['type_slug'], $pkgData['topics']);

            if (!$mentor || !$category || !$type) {
                continue;
            }

            $package = Package::create(array_merge($pkgData, [
                'user_id'         => $mentor->id,
                'category_id'     => $category->id,
                'package_type_id' => $type->id,
                'language'        => 'en',
                'is_active'       => true,
                'is_featured'     => in_array($typeSlug, ['training-program']) || ($pkgData['is_featured'] ?? false),
            ]));

            foreach ($topics as $index => $topic) {
                Topic::create([
                    'package_id'     => $package->id,
                    'title'          => $topic['title'],
                    'description'    => $topic['details'] ?? null,
                    'session_number' => $index + 1,
                    'duration'       => $pkgData['duration'] ?? 60,
                    'sort_order'     => $index + 1,
                ]);
            }
        }
    }
}
