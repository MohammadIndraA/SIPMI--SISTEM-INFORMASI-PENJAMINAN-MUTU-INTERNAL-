<div class="max-w-2xl mx-auto p-4">
    @if ($isCompleted)
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
            angas <p>Kuis selesai! Terima kasih telah berpartisipasi.</p>
        </div>
    @elseif($question)
        <div class="bg-white shadow-md rounded-lg p-6">
            <h3 class="text-lg font-semibold mb-4">Pertanyaan {{ $currentQuestionIndex + 1 }} dari {{ $totalQuestions }}
            </h3>
            <p class="mb-4">{{ $question->text }}</p>
            <form wire:submit.prevent>
                @foreach ($question->options as $option)
                    <label class="block mb-2">
                        <input type="radio" wire:model="selectedAnswer" value="{{ $option }}" class="mr-2">
                        {{ $option }}
                    </label>
                @endforeach
                @error('selectedAnswer')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
            </form>
            <div class="mt-6 flex justify-between">
                <button wire:click="previousQuestion" @if ($currentQuestionIndex == 0) disabled @endif
                    class="px-4 py-2 bg-gray-300 text-gray-700 rounded disabled:opacity-50">
                    Sebelumnya
                </button>
                <button wire:click="nextQuestion" @if ($currentQuestionIndex == $totalQuestions - 1) disabled @endif
                    class="px-4 py-2 bg-blue-500 text-white rounded disabled:opacity-50">
                    Selanjutnya
                </button>
            </div>
            @if ($currentQuestionIndex == $totalQuestions - 1)
                <button wire:click="submitQuiz" class="mt-4 px-4 py-2 bg-green-500 text-white rounded">
                    Selesai
                </button>
            @endif
        </div>
    @else
        <p class="text-red-500">Tidak ada pertanyaan tersedia.</p>
    @endif
</div>
