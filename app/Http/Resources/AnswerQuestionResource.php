<?php

namespace App\Http\Resources;

use App\Models\Answer;
use App\Models\Question;
use App\Models\TestTask;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AnswerQuestionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'question' => new QuestionResource(Question::findOrFail($this->question_id)),
            'answer' => new AnswerResource(Answer::findOrFail($this->answer_id)),
            'test_task' => new TestTaskResource(TestTask::findOrFail($this->test_task_id)),
        ];
    }
}
