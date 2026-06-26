<?php

use App\Models\SavedPost;
use App\Services\GroqService;
use Livewire\Component;

new class extends Component
{
    public string $topic = 'Laravel';

    public string $category = 'Tips';

    public string $tone = 'Professional';

    public string $platform = 'linkedin';

    public ?string $content = null;

    public ?string $imagePrompt = null;

    public int $generationCount = 0;

    public bool $justSaved = false;

    public string $hookTopic = '';

    /** @var array<int, string> */
    public array $hooks = [];

    public array $topics = ['Laravel', 'PHP', 'Web Development', 'Freelancing Tips', 'ClickHouse'];

    public array $categories = ['Tips', 'Case Study', 'Achievement', 'Question', 'Motivation'];

    public function tones(): array
    {
        return array_keys(GroqService::TONES);
    }

    public function generate(): void
    {
        if (trim($this->topic) === '') {
            $this->dispatch('toast', message: 'Please enter a topic first.', type: 'error');

            return;
        }

        try {
            $groq = app(GroqService::class);

            $this->content = $groq->generatePost($this->topic, $this->category, $this->tone, $this->platform);
            $this->imagePrompt = $groq->generateImagePrompt($this->content);
            $this->generationCount++;
            $this->justSaved = false;

            $this->dispatch('toast', message: 'Fresh post generated!', type: 'success');
        } catch (\Throwable $e) {
            $this->dispatch('toast', message: $e->getMessage(), type: 'error');
        }
    }

    public function regenerate(): void
    {
        $this->generate();
    }

    public function savePost(): void
    {
        if (! $this->content) {
            $this->dispatch('toast', message: 'Generate a post before saving.', type: 'error');

            return;
        }

        SavedPost::create([
            'content' => $this->content,
            'platform' => $this->platform,
            'tone' => $this->tone,
            'image_prompt' => $this->imagePrompt,
        ]);

        $this->justSaved = true;
        $this->dispatch('toast', message: 'Saved to history!', type: 'success');
    }

    public function generateHooks(): void
    {
        if (trim($this->hookTopic) === '') {
            $this->dispatch('toast', message: 'Enter a topic to brainstorm hooks.', type: 'error');

            return;
        }

        try {
            $this->hooks = app(GroqService::class)->generateHooks($this->hookTopic);
            $this->dispatch('toast', message: '5 hooks ready!', type: 'success');
        } catch (\Throwable $e) {
            $this->dispatch('toast', message: $e->getMessage(), type: 'error');
        }
    }
};
?>

<div x-data="{ tab: 'post' }" class="grid grid-cols-1 gap-6 lg:grid-cols-[280px_1fr]">

    {{-- ============================ SIDEBAR (glass) ============================ --}}
    <aside class="h-fit rounded-2xl glass p-5 shadow-xl lg:sticky lg:top-24">
        {{-- Tabs --}}
        <div class="mb-5 grid grid-cols-2 gap-1 rounded-xl bg-white/30 p-1 dark:bg-white/5">
            <button type="button" @click="tab = 'post'"
                :class="tab === 'post' ? 'bg-white text-violet-700 shadow dark:bg-white/15 dark:text-white' : 'text-slate-600 dark:text-slate-300'"
                class="rounded-lg px-3 py-1.5 text-xs font-semibold transition">Post</button>
            <button type="button" @click="tab = 'hooks'"
                :class="tab === 'hooks' ? 'bg-white text-violet-700 shadow dark:bg-white/15 dark:text-white' : 'text-slate-600 dark:text-slate-300'"
                class="rounded-lg px-3 py-1.5 text-xs font-semibold transition">Hooks</button>
        </div>

        {{-- ---------- POST TAB CONTROLS ---------- --}}
        <div x-show="tab === 'post'" x-cloak class="space-y-5">
            {{-- Platform --}}
            <div>
                <label class="mb-2 block text-[11px] font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400">Platform</label>
                <div class="grid grid-cols-2 gap-2">
                    <button type="button" wire:click="$set('platform', 'linkedin')"
                        class="rounded-lg border px-3 py-2 text-sm font-medium transition {{ $platform === 'linkedin' ? 'border-sky-400 bg-sky-500/20 text-sky-700 dark:text-sky-200' : 'border-white/20 text-slate-600 hover:bg-white/30 dark:text-slate-300 dark:hover:bg-white/10' }}">
                        LinkedIn
                    </button>
                    <button type="button" wire:click="$set('platform', 'facebook')"
                        class="rounded-lg border px-3 py-2 text-sm font-medium transition {{ $platform === 'facebook' ? 'border-indigo-400 bg-indigo-500/20 text-indigo-700 dark:text-indigo-200' : 'border-white/20 text-slate-600 hover:bg-white/30 dark:text-slate-300 dark:hover:bg-white/10' }}">
                        Facebook
                    </button>
                </div>
            </div>

            {{-- Topic --}}
            <div>
                <label for="topic" class="mb-2 block text-[11px] font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400">Topic</label>
                <input id="topic" type="text" wire:model="topic" list="topic-suggestions" placeholder="e.g. Laravel queues"
                    class="w-full rounded-lg border border-white/20 bg-white/60 px-3 py-2 text-sm text-slate-800 placeholder-slate-400 focus:border-violet-400 focus:ring-2 focus:ring-violet-300/50 focus:outline-none dark:bg-white/10 dark:text-white">
                <datalist id="topic-suggestions">
                    @foreach ($topics as $t)
                        <option value="{{ $t }}"></option>
                    @endforeach
                </datalist>
            </div>

            {{-- Category --}}
            <div>
                <label for="category" class="mb-2 block text-[11px] font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400">Category</label>
                <select id="category" wire:model="category"
                    class="w-full rounded-lg border border-white/20 bg-white/60 px-3 py-2 text-sm text-slate-800 focus:border-violet-400 focus:ring-2 focus:ring-violet-300/50 focus:outline-none dark:bg-white/10 dark:text-white">
                    @foreach ($categories as $c)
                        <option value="{{ $c }}">{{ $c }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Tone --}}
            <div>
                <label class="mb-2 block text-[11px] font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400">Tone</label>
                <div class="grid grid-cols-2 gap-2">
                    @foreach ($this->tones() as $t)
                        <button type="button" wire:click="$set('tone', '{{ $t }}')"
                            class="rounded-lg border px-2 py-2 text-xs font-medium transition {{ $tone === $t ? 'border-violet-400 bg-violet-500/20 text-violet-700 dark:text-violet-200' : 'border-white/20 text-slate-600 hover:bg-white/30 dark:text-slate-300 dark:hover:bg-white/10' }}">
                            {{ $t }}
                        </button>
                    @endforeach
                </div>
            </div>

            {{-- Generate --}}
            <button type="button" wire:click="generate" wire:loading.attr="disabled" wire:target="generate"
                class="pulse-on-hover flex w-full items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-violet-600 to-fuchsia-600 px-4 py-3 text-sm font-semibold text-white shadow-lg shadow-fuchsia-500/30 transition hover:from-violet-500 hover:to-fuchsia-500 disabled:opacity-60">
                <svg wire:loading.remove wire:target="generate,regenerate" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904 9 18.75l-.813-2.846a4.5 4.5 0 0 0-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 0 0 3.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 0 0 3.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 0 0-3.09 3.09Z" />
                </svg>
                <svg wire:loading wire:target="generate,regenerate" class="h-4 w-4 animate-spin" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 0 1 8-8V0C5.373 0 0 5.373 0 12h4z"></path>
                </svg>
                <span wire:loading.remove wire:target="generate,regenerate">Generate Post</span>
                <span wire:loading wire:target="generate,regenerate">Generating…</span>
            </button>
        </div>

        {{-- ---------- HOOKS TAB CONTROLS ---------- --}}
        <div x-show="tab === 'hooks'" x-cloak class="space-y-4">
            <p class="text-xs text-slate-500 dark:text-slate-400">Brainstorm 5 scroll-stopping opening lines for any topic.</p>
            <input type="text" wire:model="hookTopic" wire:keydown.enter="generateHooks" placeholder="e.g. switching MySQL to ClickHouse"
                class="w-full rounded-lg border border-white/20 bg-white/60 px-3 py-2 text-sm text-slate-800 placeholder-slate-400 focus:border-violet-400 focus:ring-2 focus:ring-violet-300/50 focus:outline-none dark:bg-white/10 dark:text-white">
            <button type="button" wire:click="generateHooks" wire:loading.attr="disabled" wire:target="generateHooks"
                class="flex w-full items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-violet-600 to-fuchsia-600 px-4 py-3 text-sm font-semibold text-white shadow-lg shadow-fuchsia-500/30 transition hover:from-violet-500 hover:to-fuchsia-500 disabled:opacity-60">
                <span wire:loading.remove wire:target="generateHooks">Generate 5 Hooks</span>
                <span wire:loading wire:target="generateHooks">Thinking…</span>
            </button>
        </div>
    </aside>

    {{-- ============================ MAIN ============================ --}}
    <div class="space-y-6">

        {{-- ===================== POST TAB CONTENT ===================== --}}
        <div x-show="tab === 'post'" x-cloak class="space-y-6">

            {{-- Skeleton loader (while generating) --}}
            <div wire:loading.flex wire:target="generate,regenerate" class="hidden flex-col gap-4 rounded-2xl bg-white p-6 shadow-xl dark:bg-slate-900/70">
                <div class="flex items-center gap-3">
                    <div class="skeleton h-11 w-11 rounded-full"></div>
                    <div class="flex-1 space-y-2">
                        <div class="skeleton h-3 w-32"></div>
                        <div class="skeleton h-2.5 w-24"></div>
                    </div>
                </div>
                <div class="skeleton h-3 w-full"></div>
                <div class="skeleton h-3 w-11/12"></div>
                <div class="skeleton h-3 w-10/12"></div>
                <div class="skeleton h-3 w-full"></div>
                <div class="skeleton h-3 w-8/12"></div>
            </div>

            {{-- Preview card (LinkedIn style) --}}
            <div wire:loading.remove wire:target="generate,regenerate">
                @if ($content)
                    <div wire:key="post-{{ $generationCount }}"
                        x-data="{
                            copy(text) {
                                navigator.clipboard.writeText(text).then(() =>
                                    window.dispatchEvent(new CustomEvent('toast', { detail: { message: 'Post copied!', type: 'success' } }))
                                );
                            }
                        }"
                        class="animate-fade-in-up overflow-hidden rounded-2xl bg-white shadow-xl dark:bg-slate-900/70 dark:ring-1 dark:ring-white/10">

                        {{-- card header --}}
                        <div class="flex items-center gap-3 border-b border-slate-100 p-5 dark:border-white/10">
                            <div class="flex h-11 w-11 items-center justify-center rounded-full bg-gradient-to-br from-violet-500 to-fuchsia-500 text-sm font-bold text-white">YD</div>
                            <div class="leading-tight">
                                <p class="text-sm font-semibold text-slate-800 dark:text-white">Your Name</p>
                                <p class="text-xs text-slate-400">PHP / Laravel Freelancer ·
                                    <span class="capitalize">{{ $platform }}</span> · {{ $tone }}
                                </p>
                            </div>
                            <span class="ml-auto rounded-full bg-violet-50 px-2.5 py-0.5 text-xs font-medium text-violet-600 dark:bg-violet-500/15 dark:text-violet-300">{{ $category }}</span>
                        </div>

                        {{-- post body --}}
                        <div class="p-5">
                            <p class="whitespace-pre-line text-[15px] leading-relaxed text-slate-800 dark:text-slate-100">{{ $content }}</p>

                            @if ($justSaved)
                                <p class="mt-3 text-sm font-medium text-emerald-600 dark:text-emerald-400">✓ Saved — view it on the History page.</p>
                            @endif

                            {{-- Character counter --}}
                            @php
                                $len = mb_strlen($content);
                                $counterColor = $len < 1500
                                    ? 'text-emerald-600 dark:text-emerald-400'
                                    : ($len <= 3000 ? 'text-amber-500' : 'text-rose-500');
                            @endphp
                            <div class="mt-4 flex items-center justify-between border-t border-slate-100 pt-3 dark:border-white/10">
                                <span class="text-xs font-medium {{ $counterColor }}">{{ number_format($len) }} characters</span>
                                <span class="text-xs text-slate-400">LinkedIn limit: 3,000</span>
                            </div>

                            {{-- Floating action buttons --}}
                            <div class="mt-4 flex flex-wrap gap-2">
                                <button type="button" wire:click="regenerate"
                                    class="inline-flex items-center gap-1.5 rounded-lg border border-slate-200 px-3.5 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-50 dark:border-white/10 dark:text-slate-200 dark:hover:bg-white/10">
                                    ↻ Regenerate
                                </button>
                                <button type="button" @click="copy(@js($content))"
                                    class="inline-flex items-center gap-1.5 rounded-lg border border-slate-200 px-3.5 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-50 dark:border-white/10 dark:text-slate-200 dark:hover:bg-white/10">
                                    ⧉ Copy
                                </button>
                                <button type="button" wire:click="savePost"
                                    class="ml-auto inline-flex items-center gap-1.5 rounded-lg bg-gradient-to-r from-violet-600 to-fuchsia-600 px-4 py-2 text-sm font-semibold text-white shadow-lg shadow-fuchsia-500/30 transition hover:from-violet-500 hover:to-fuchsia-500">
                                    ♥ Save Post
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- ===================== IMAGE PROMPT CARD ===================== --}}
                    @if ($imagePrompt)
                        <div wire:key="img-{{ $generationCount }}"
                            x-data="{
                                full: @js($imagePrompt),
                                shown: '',
                                done: false,
                                init() {
                                    let i = 0;
                                    const tick = () => {
                                        if (i <= this.full.length) {
                                            this.shown = this.full.slice(0, i);
                                            i++;
                                            setTimeout(tick, 12);
                                        } else { this.done = true; }
                                    };
                                    tick();
                                },
                                copy() {
                                    navigator.clipboard.writeText(this.full).then(() =>
                                        window.dispatchEvent(new CustomEvent('toast', { detail: { message: 'Image prompt copied!', type: 'success' } }))
                                    );
                                }
                            }"
                            class="animate-fade-in-up overflow-hidden rounded-2xl bg-gradient-to-br from-violet-600 via-purple-600 to-fuchsia-700 p-6 text-white shadow-xl">
                            <div class="mb-3 flex items-center justify-between">
                                <h3 class="flex items-center gap-2 text-base font-semibold">🎨 AI Image Prompt <span class="text-xs font-normal text-violet-200">(paste on Leonardo.ai)</span></h3>
                                <button type="button" @click="copy()"
                                    class="rounded-lg bg-white/15 px-3 py-1.5 text-xs font-semibold transition hover:bg-white/25">⧉ Copy</button>
                            </div>

                            <p class="rounded-xl bg-black/20 p-4 font-mono text-sm leading-relaxed" :class="!done && 'typewriter-caret'" x-text="shown"></p>

                            <a href="https://leonardo.ai" target="_blank" rel="noopener"
                                class="mt-4 inline-flex items-center gap-2 rounded-lg bg-white px-4 py-2 text-sm font-semibold text-violet-700 transition hover:bg-violet-50">
                                Open Leonardo.ai →
                            </a>
                            <p class="mt-3 text-xs text-violet-200">Go to leonardo.ai (free) → paste this → download image → post with LinkedIn.</p>
                        </div>
                    @endif
                @else
                    {{-- Empty state --}}
                    <div class="flex flex-col items-center justify-center rounded-2xl border border-dashed border-white/30 bg-white/40 py-20 text-center dark:bg-white/5">
                        <div class="mb-4 flex h-14 w-14 items-center justify-center rounded-2xl bg-gradient-to-br from-violet-500 to-fuchsia-500 text-white shadow-lg">
                            <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904 9 18.75l-.813-2.846a4.5 4.5 0 0 0-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 0 0 3.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 0 0 3.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 0 0-3.09 3.09Z" />
                            </svg>
                        </div>
                        <p class="text-sm text-slate-600 dark:text-slate-300">Pick a topic, tone &amp; platform, then hit <span class="font-semibold text-violet-600 dark:text-violet-300">Generate Post</span>.</p>
                        <p class="mt-1 text-xs text-slate-400">Each post is written live by Groq · Llama 3.3 70B.</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- ===================== HOOKS TAB CONTENT ===================== --}}
        <div x-show="tab === 'hooks'" x-cloak>
            {{-- skeleton --}}
            <div wire:loading.flex wire:target="generateHooks" class="hidden flex-col gap-3 rounded-2xl bg-white p-6 shadow-xl dark:bg-slate-900/70">
                @for ($i = 0; $i < 5; $i++)
                    <div class="skeleton h-4 w-full"></div>
                @endfor
            </div>

            <div wire:loading.remove wire:target="generateHooks">
                @if (count($hooks))
                    <div class="space-y-3">
                        @foreach ($hooks as $i => $hook)
                            <div wire:key="hook-{{ $i }}"
                                x-data="{ copy() { navigator.clipboard.writeText(@js($hook)).then(() => window.dispatchEvent(new CustomEvent('toast', { detail: { message: 'Hook copied!', type: 'success' } }))); } }"
                                class="animate-fade-in-up flex items-start gap-3 rounded-xl bg-white p-4 shadow-md dark:bg-slate-900/70 dark:ring-1 dark:ring-white/10">
                                <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-lg bg-violet-100 text-sm font-bold text-violet-700 dark:bg-violet-500/20 dark:text-violet-300">{{ $i + 1 }}</span>
                                <p class="flex-1 text-sm text-slate-800 dark:text-slate-100">{{ $hook }}</p>
                                <button type="button" @click="copy()" class="shrink-0 rounded-lg border border-slate-200 px-2.5 py-1 text-xs font-medium text-slate-600 transition hover:bg-slate-50 dark:border-white/10 dark:text-slate-300 dark:hover:bg-white/10">Copy</button>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="flex flex-col items-center justify-center rounded-2xl border border-dashed border-white/30 bg-white/40 py-20 text-center dark:bg-white/5">
                        <p class="text-sm text-slate-600 dark:text-slate-300">Enter a topic on the left to brainstorm <span class="font-semibold text-violet-600 dark:text-violet-300">5 hook ideas</span>.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
