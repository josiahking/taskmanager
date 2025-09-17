<?php

use App\Enums\PriorityEnum;
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
        $priorities = array_map(fn(PriorityEnum $p) => $p->value, PriorityEnum::cases());

        Schema::create('tasks', function (Blueprint $table) use($priorities) {
            $table->id();
            $table->string('name');
            $table->enum('priority', $priorities)->default('Low');
            $table->foreignId('project_id')->nullable()->constrained()->nullOnDelete();
            $table->unsignedInteger('order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
