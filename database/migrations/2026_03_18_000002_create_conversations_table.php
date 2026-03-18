<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        // Drop old conversations table if it exists with old schema
        Schema::dropIfExists('messages');
        Schema::dropIfExists('conversations');

        Schema::create('conversations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mentor_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('mentee_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('package_id')->nullable()->constrained('packages')->onDelete('set null');
            $table->timestamp('last_message_at')->nullable();
            $table->timestamps();
            $table->unique(['mentor_id', 'mentee_id']);
        });
    }

    public function down(): void {
        Schema::dropIfExists('conversations');
    }
};
