<?php

namespace Database\Seeders;

use App\Models\Question;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuizSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $questions = [
            [
                'text' => 'Apa ibu kota Indonesia?',
                'type' => 'multiple_choice',
                'options' => json_encode(['Jakarta', 'Surabaya', 'Bandung', 'Yogyakarta']),
                'correct_answer' => 'Jakarta',
            ],
            [
                'text' => '1 + 1 = ?',
                'type' => 'multiple_choice',
                'options' => json_encode(['1', '2', '3', '4']),
                'correct_answer' => '2',
            ],
        ];

        foreach ($questions as $index => $questionData) {
            $question = Question::create($questionData);
        }
    }
}
