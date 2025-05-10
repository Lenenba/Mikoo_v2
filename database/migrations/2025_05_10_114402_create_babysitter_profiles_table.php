<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('babysitter_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained()
                ->onDelete('cascade');
            $table->string('first_name')->default('User');
            $table->string('last_name')->default('User');
            $table->date('birthdate')->nullable();
            $table->string('phone')->nullable();
            $table->text('bio')->nullable();
            $table->text('experience')->nullable();
            $table->decimal('price_per_hour', 8, 2)->default(0);
            $table->enum('payment_frequency', ['per_task', 'daily', 'weekly', 'biweekly', 'monthly'])
                ->default('per_task');
            $table->softDeletes();
            $table->json('settings')->nullable()
                ->comment('Dynamic settings or tags');
            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->foreignId('updated_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();

            // 5) Indexes pour filtrages fréquents
            $table->index('price_per_hour');
            $table->index('payment_frequency');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('babysitter_profiles');
    }
};
