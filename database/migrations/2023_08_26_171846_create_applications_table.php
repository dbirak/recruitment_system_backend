<?php

use App\Models\Announcement;
use App\Models\CvAnswer;
use App\Models\FileAnswer;
use App\Models\OpenAnswer;
use App\Models\Step;
use App\Models\Task;
use App\Models\TestAnswer;
use App\Models\User;
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
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Announcement::class)->constrained();
            $table->foreignIdFor(User::class)->constrained();
            $table->foreignIdFor(Step::class)->constrained();
            $table->integer("step_number");
            $table->foreignIdFor(Task::class)->constrained();
            $table->foreignIdFor(FileAnswer::class)->nullable()->constrained();
            $table->foreignIdFor(OpenAnswer::class)->nullable()->constrained();
            $table->foreignIdFor(TestAnswer::class)->nullable()->constrained();
            $table->foreignIdFor(CvAnswer::class)->nullable()->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
