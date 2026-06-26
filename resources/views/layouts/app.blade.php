<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Social Post Generator' }}</title>

    {{-- Apply saved theme before paint to avoid a flash --}}
    <script>
        (function () {
            const t = localStorage.getItem('theme') || 'dark';
            if (t === 'dark') document.documentElement.classList.add('dark');
        })();
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gradient-to-br from-slate-100 via-slate-200 to-slate-100 text-slate-900 antialiased
             dark:from-[#0f0c29] dark:via-[#302b63] dark:to-[#24243e] dark:text-slate-100">

    {{-- ============================ NAVBAR ============================ --}}
    <nav class="sticky top-0 z-40 glass">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-3 sm:px-6">
            <a href="{{ route('dashboard') }}" wire:navigate class="flex items-center gap-3">
                <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-gradient-to-br from-violet-500 to-fuchsia-500 text-white shadow-lg shadow-fuchsia-500/30">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904 9 18.75l-.813-2.846a4.5 4.5 0 0 0-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 0 0 3.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 0 0 3.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 0 0-3.09 3.09Z" />
                    </svg>
                </div>
                <div class="leading-tight">
                    <p class="text-sm font-semibold text-slate-800 dark:text-white">Social Post Generator</p>
                    <p class="text-[11px] text-slate-500 dark:text-slate-400">Powered by Groq · Llama 3.3 70B</p>
                </div>
            </a>

            <div class="flex items-center gap-1.5">
                <a href="{{ route('dashboard') }}" wire:navigate
                   class="rounded-lg px-3 py-1.5 text-sm font-medium transition {{ request()->routeIs('dashboard') ? 'bg-white/70 text-violet-700 dark:bg-white/10 dark:text-white' : 'text-slate-600 hover:bg-white/40 dark:text-slate-300 dark:hover:bg-white/10' }}">
                    Generator
                </a>
                <a href="{{ route('history') }}" wire:navigate
                   class="rounded-lg px-3 py-1.5 text-sm font-medium transition {{ request()->routeIs('history') ? 'bg-white/70 text-violet-700 dark:bg-white/10 dark:text-white' : 'text-slate-600 hover:bg-white/40 dark:text-slate-300 dark:hover:bg-white/10' }}">
                    History
                </a>

                {{-- Dark / light toggle --}}
                <button
                    x-data
                    @click="
                        const dark = document.documentElement.classList.toggle('dark');
                        localStorage.setItem('theme', dark ? 'dark' : 'light');
                    "
                    class="ml-1 flex h-9 w-9 items-center justify-center rounded-lg border border-white/20 bg-white/40 text-slate-700 transition hover:bg-white/60 dark:bg-white/10 dark:text-amber-300 dark:hover:bg-white/20"
                    title="Toggle theme">
                    {{-- sun (shown in dark mode) --}}
                    <svg class="hidden h-5 w-5 dark:block" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" />
                    </svg>
                    {{-- moon (shown in light mode) --}}
                    <svg class="h-5 w-5 dark:hidden" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.718 9.718 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z" />
                    </svg>
                </button>
            </div>
        </div>
    </nav>

    {{-- ============================ PAGE ============================ --}}
    <main class="mx-auto max-w-7xl px-4 py-8 sm:px-6">
        {{ $slot }}
    </main>

    {{-- ============================ TOAST HOST ============================ --}}
    <div
        x-data="{
            toasts: [],
            add(detail) {
                const id = Date.now() + Math.random();
                this.toasts.push({ id, message: detail.message, type: detail.type || 'success' });
                setTimeout(() => this.remove(id), 2600);
            },
            remove(id) { this.toasts = this.toasts.filter(t => t.id !== id); }
        }"
        x-on:toast.window="add($event.detail)"
        class="pointer-events-none fixed bottom-5 right-5 z-50 flex w-80 flex-col gap-2">
        <template x-for="toast in toasts" :key="toast.id">
            <div class="animate-toast-in pointer-events-auto flex items-center gap-3 rounded-xl border px-4 py-3 text-sm font-medium shadow-xl backdrop-blur-md"
                 :class="toast.type === 'error'
                    ? 'border-rose-300/40 bg-rose-500/90 text-white'
                    : 'border-emerald-300/40 bg-emerald-500/90 text-white'">
                <span x-text="toast.type === 'error' ? '⚠️' : '✓'"></span>
                <span x-text="toast.message"></span>
            </div>
        </template>
    </div>

</body>
</html>
