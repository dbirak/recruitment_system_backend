<?php

use App\Models\Announcement;
use App\Models\FileTask;
use App\Models\OpenTask;
use App\Models\Task;
use App\Models\TestTask;
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
        Schema::create('steps', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Announcement::class)->constrained();
            $table->integer('step_number');
            $table->foreignIdFor(Task::class)->constrained();
            $table->foreignIdFor(TestTask::class)->nullable()->constrained();
            $table->foreignIdFor(OpenTask::class)->nullable()->constrained();
            $table->foreignIdFor(FileTask::class)->nullable()->constrained();
            $table->date('expiry_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('steps');
    }
};
