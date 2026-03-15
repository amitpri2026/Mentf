<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // mentor
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->foreignId('package_type_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->text('requirements')->nullable();
            $table->text('outcomes')->nullable();
            $table->decimal('price', 10, 2);
            $table->string('currency', 3)->default('USD');
            $table->integer('duration')->default(60); // minutes per session
            $table->integer('sessions')->default(1); // number of sessions
            $table->integer('max_students')->default(1);
            $table->string('level')->default('all'); // beginner, intermediate, advanced, all
            $table->string('language', 10)->default('en');
            $table->string('thumbnail')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->decimal('avg_rating', 3, 2)->default(0);
            $table->integer('total_reviews')->default(0);
            $table->integer('total_enrollments')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
