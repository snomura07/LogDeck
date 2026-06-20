<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('logs', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('system_id')->constrained('systems')->cascadeOnDelete();
            $table->string('level', 32);
            $table->text('message');
            $table->dateTime('received_at');
            $table->timestamps();
            $table->index(['received_at', 'level']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('logs');
    }
};
