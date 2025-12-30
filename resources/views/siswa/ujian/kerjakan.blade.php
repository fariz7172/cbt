<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $ujian->judul }} - CBT Madrasah</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-secondary-100 min-h-screen">
    <!-- Timer -->
    <div id="exam-timer" class="exam-timer">
        <i class="fas fa-clock"></i>
        <span id="timer-display">{{ sprintf('%02d:%02d', floor($remainingMinutes), 0) }}</span>
    </div>

    <!-- Header -->
    <header class="bg-white border-b border-secondary-200 px-6 py-4 sticky top-0 z-20">
        <div class="max-w-4xl mx-auto flex items-center justify-between">
            <div>
                <h1 class="font-semibold text-lg text-gray-800">{{ $ujian->judul }}</h1>
                <p class="text-sm text-gray-500">{{ $ujian->pelajaran->nama }}</p>
            </div>
            <form action="{{ route('siswa.ujian.submit', $ujian) }}" method="POST" id="submit-form">
                @csrf
                <button type="submit" class="btn-primary" onclick="return confirm('Yakin ingin mengakhiri ujian?')">
                    <i class="fas fa-paper-plane"></i>
                    <span>Selesai</span>
                </button>
            </form>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-4xl mx-auto px-6 py-8">
        <!-- Question Navigation -->
        <div class="card mb-6">
            <h2 class="text-sm font-semibold text-gray-500 mb-3">Navigasi Soal</h2>
            <div class="flex flex-wrap gap-2">
                @foreach($soals as $index => $soal)
                    <a href="#soal-{{ $index + 1 }}" 
                       class="w-10 h-10 rounded-lg flex items-center justify-center text-sm font-medium transition-colors
                              {{ isset($jawabanMap[$soal->id]) ? 'bg-success text-white' : 'bg-secondary-200 text-gray-600 hover:bg-primary-200' }}"
                       id="nav-{{ $index + 1 }}">
                        {{ $index + 1 }}
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Questions -->
        <div class="space-y-6">
            @foreach($soals as $index => $soal)
                <div class="card" id="soal-{{ $index + 1 }}">
                    <div class="flex items-start justify-between mb-4">
                        <span class="badge-primary">Soal {{ $index + 1 }}</span>
                        <span class="text-sm text-gray-500">{{ $soal->poin }} poin</span>
                    </div>

                        {!! nl2br(e($soal->pertanyaan)) !!}
                        @if($soal->gambar)
                            <div class="mt-4">
                                <img src="{{ asset('uploads/' . $soal->gambar) }}" alt="Gambar Soal" class="max-w-md rounded-lg shadow">
                            </div>
                        @endif
                    </div>

                    @if($soal->isPilihanGanda() && $soal->opsi)
                        <div class="space-y-3">
                            @foreach($soal->opsi as $key => $opsi)
                                @php
                                    // Handle numeric keys (legacy data) by converting 0->A, 1->B, etc.
                                    $val = is_numeric($key) ? chr(65 + $key) : $key;
                                @endphp
                                <label class="answer-option {{ ($jawabanMap[$soal->id] ?? '') === (string)$val ? 'selected' : '' }}"
                                       data-soal-id="{{ $soal->id }}" 
                                       data-value="{{ $val }}">
                                    <input type="radio" name="jawaban_{{ $soal->id }}" value="{{ $val }}"
                                           {{ ($jawabanMap[$soal->id] ?? '') === (string)$val ? 'checked' : '' }}
                                           class="form-radio text-accent">
                                    <span class="font-bold mr-2">{{ $val }}.</span>
                                    <span>{{ $opsi }}</span>
                                </label>
                            @endforeach
                        </div>
                    @elseif($soal->isBenarSalah())
                        <div class="space-y-3">
                            <label class="answer-option {{ ($jawabanMap[$soal->id] ?? '') === 'benar' ? 'selected' : '' }}"
                                   data-soal-id="{{ $soal->id }}" 
                                   data-value="benar">
                                <input type="radio" name="jawaban_{{ $soal->id }}" value="benar"
                                       {{ ($jawabanMap[$soal->id] ?? '') === 'benar' ? 'checked' : '' }}
                                       class="form-radio text-accent">
                                <span>Benar</span>
                            </label>
                            <label class="answer-option {{ ($jawabanMap[$soal->id] ?? '') === 'salah' ? 'selected' : '' }}"
                                   data-soal-id="{{ $soal->id }}" 
                                   data-value="salah">
                                <input type="radio" name="jawaban_{{ $soal->id }}" value="salah"
                                       {{ ($jawabanMap[$soal->id] ?? '') === 'salah' ? 'checked' : '' }}
                                       class="form-radio text-accent">
                                <span>Salah</span>
                            </label>
                        </div>
                    @else
                        <textarea name="jawaban_{{ $soal->id }}" 
                                  class="form-textarea" 
                                  rows="4"
                                  data-soal-id="{{ $soal->id }}"
                                  placeholder="Tulis jawaban Anda...">{{ $jawabanMap[$soal->id] ?? '' }}</textarea>
                    @endif
                </div>
            @endforeach
        </div>

        <!-- Submit Button -->
        <div class="mt-8 text-center">
            <form action="{{ route('siswa.ujian.submit', $ujian) }}" method="POST">
                @csrf
                <button type="submit" class="btn-primary btn-lg" onclick="return confirm('Yakin ingin mengakhiri ujian? Jawaban akan disimpan dan dinilai.')">
                    <i class="fas fa-paper-plane"></i>
                    <span>Selesai & Kumpulkan</span>
                </button>
            </form>
        </div>
    </main>

    <script>
        // Timer
        let remainingSeconds = {{ $remainingMinutes * 60 }};
        const timerDisplay = document.getElementById('timer-display');
        const examTimer = document.getElementById('exam-timer');

        function updateTimer() {
            if (remainingSeconds <= 0) {
                document.getElementById('submit-form').submit();
                return;
            }

            const minutes = Math.floor(remainingSeconds / 60);
            const seconds = remainingSeconds % 60;
            timerDisplay.textContent = `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;

            // Warning states
            if (remainingSeconds <= 60) {
                examTimer.classList.add('danger');
                examTimer.classList.remove('warning');
            } else if (remainingSeconds <= 300) {
                examTimer.classList.add('warning');
            }

            remainingSeconds--;
        }

        setInterval(updateTimer, 1000);
        updateTimer();

        // Auto-save answers
        document.querySelectorAll('.answer-option').forEach(option => {
            option.addEventListener('click', function() {
                const soalId = this.dataset.soalId;
                const value = this.dataset.value;
                
                // Update UI
                document.querySelectorAll(`[data-soal-id="${soalId}"]`).forEach(el => {
                    el.classList.remove('selected');
                });
                this.classList.add('selected');

                // Save to server
                saveAnswer(soalId, value);
            });
        });

        document.querySelectorAll('textarea[data-soal-id]').forEach(textarea => {
            let timeout;
            textarea.addEventListener('input', function() {
                clearTimeout(timeout);
                timeout = setTimeout(() => {
                    saveAnswer(this.dataset.soalId, this.value);
                }, 1000);
            });
        });

        function saveAnswer(soalId, jawaban) {
            fetch('{{ route("siswa.ujian.save-jawaban", $ujian) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ soal_id: soalId, jawaban: jawaban })
            }).then(response => response.json())
              .then(data => {
                  if (data.success) {
                      // Update navigation
                      const navItems = document.querySelectorAll('[id^="nav-"]');
                      // Find the nav item for this soal and mark it answered
                  }
              });
        }

        // Prevent accidental leave
        const beforeUnloadHandler = function(e) {
            e.preventDefault();
            e.returnValue = '';
        };
        window.addEventListener('beforeunload', beforeUnloadHandler);

        // Allow submit without warning
        document.getElementById('submit-form').addEventListener('submit', function() {
            window.removeEventListener('beforeunload', beforeUnloadHandler);
        });

        // Also for the bottom submit button
        document.querySelector('main form[action*="submit"]').addEventListener('submit', function() {
            window.removeEventListener('beforeunload', beforeUnloadHandler);
        });
    </script>
</body>
</html>
