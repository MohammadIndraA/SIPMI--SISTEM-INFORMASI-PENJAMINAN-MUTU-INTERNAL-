<?php

namespace App\Livewire;

use App\Models\Answer;
use App\Models\DaftarSubStandar;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class QuizComponent extends Component
{
    public $quizId;
    public $quiz;
    public $questions = [];
    public $currentQuestionIndex = 0;
    public $selectedAnswer;
    public $isCompleted = false;

    
    public function mount()
    {
        // $this->quizId = $quizId;
        // $this->quiz = Quiz::with('questions')->findOrFail($quizId);
        $lastSegment = collect(request()->segments())->last();

        $sub_standars = DaftarSubStandar::with('daftar_standar_mutu','daftar_standar','poins')->where('slug', $lastSegment)->first();
        $this->questions = $sub_standars->poins()->get()->toArray();

        // Load jawaban sebelumnya jika ada
        $this->loadPreviousAnswer();
    }

    public function nextQuestion()
    {
        $this->saveAnswer();
        if ($this->currentQuestionIndex < count($this->questions) - 1) {
            $this->currentQuestionIndex++;
            $this->loadPreviousAnswer();
        } else {
            $this->isCompleted = true;
        }
    }

    public function previousQuestion()
    {
        $this->saveAnswer();
        if ($this->currentQuestionIndex > 0) {
            $this->currentQuestionIndex--;
            $this->loadPreviousAnswer();
        }
    }

    public function saveAnswer()
    {
        if ($this->selectedAnswer && Auth::check()) {
            Answer::updateOrCreate(
                [
                    'user_id' => Auth::id(),
                    'question_id' => $this->questions[$this->currentQuestionIndex]->id,
                ],
                [
                    'answer' => $this->selectedAnswer,
                    'is_submitted' => false,
                ]
            );
        }
    }

    public function submitQuiz()
    {
        $this->saveAnswer();
        Answer::where('user_id', Auth::id())
              ->update(['is_submitted' => true]);
        $this->isCompleted = true;
    }

    protected function loadPreviousAnswer()
    {
        if (Auth::check()) {
            $answer = Answer::where('user_id', Auth::id())
                           ->where('question_id', $this->questions[$this->currentQuestionIndex]->id)
                           ->first();
            $this->selectedAnswer = $answer ? $answer->answer : null;
        }
    }

    public function render()
    {
        return view('livewire.quiz-component', [
            'question' => $this->questions[$this->currentQuestionIndex] ?? null,
            'totalQuestions' => count($this->questions),
        ]);
    }
}
