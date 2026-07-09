<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->date('event_date')->index();
            $table->string('location');
            $table->string('client_name')->nullable();
            $table->unsignedInteger('sold_price_cents')->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('staff_members', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->nullable()->index();
            $table->string('phone')->nullable();
            $table->boolean('is_active')->default(true)->index();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('staff_roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true)->index();
            $table->timestamps();
        });

        Schema::create('event_staff_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->foreignId('staff_member_id')->constrained()->cascadeOnDelete();
            $table->foreignId('staff_role_id')->constrained()->restrictOnDelete();
            $table->unsignedInteger('compensation_cents')->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique(['event_id', 'staff_member_id', 'staff_role_id']);
            $table->index(['staff_member_id', 'event_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('event_staff_assignments');
        Schema::dropIfExists('staff_roles');
        Schema::dropIfExists('staff_members');
        Schema::dropIfExists('events');
    }
};
