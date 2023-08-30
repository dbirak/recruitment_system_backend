<?php

use App\Models\Answer;
use App\Models\Question;
use App\Models\TestAnswer;
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
        Schema::create('test_answer_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(TestAnswer::class)->constrained();
            $table->foreignIdFor(Question::class)->constrained();
            $table->foreignIdFor(Answer::class)->constrained();
            $table->boolean("is_checked");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('test_answer_answers');
    }
};
