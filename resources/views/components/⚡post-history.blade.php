<?php

use App\Models\SavedPost;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

new class extends Component
{
    use WithPagination;

    public string $filter = 'all'; // all | posted | draft

    public function markAsPosted(int $id): void
    {
        $post = SavedPost::find($id);

        if ($post && ! $post->is_posted) {
            $post->update(['is_posted' => true, 'posted_at' => now()]);
            $this->dispatch('toast', message: 'Marked as posted ✓', type: 'success');
        }
    }

    public function deletePost(int $id): void
    {
        SavedPost::destroy($id);
        $this->dispatch('toast', message: 'Post deleted', type: 'success');
    }

    public function setFilter(string $filter): void
    {
        $this->filter = $filter;
        $this->resetPage();
    }

    #[Computed]
    public function posts()
    {
        return SavedPost::query()
            ->when($this->filter === 'posted', fn ($q) => $q->where('is_posted', true))
            ->when($this->filter === 'draft', fn ($q) => $q->where('is_posted', false))
            ->latest()
            ->paginate(8);
    }

    #[Computed]
    public function stats(): array
    {
        return [
            'total' => SavedPost::count(),
            'posted' => SavedPost::where('is_posted', true)->count(),
            'draft' => SavedPost::where('is_posted', false)->count(),
        ];
    }
};
?>

<div class="space-y-6">

    {{-- Header + stats --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-xl font-bold text-slate-800 dark:text-white">Post History</h1>
            <p class="text-sm text-slate-500 dark:text-slate-400">Everything you have saved, in one place.</p>
        </div>
        <div class="flex gap-2 text-center">
            <div class="rounded-xl glass px-4 py-2">
                <p class="text-lg font-bold text-slate-800 dark:text-white">{{ $this->stats['total'] }}</p>
                <p class="text-[11px] uppercase tracking-wide text-slate-500 dark:text-slate-400">Total</p>
            </div>
            <div class="rounded-xl glass px-4 py-2">
                <p class="text-lg font-bold text-emerald-600 dark:text-emerald-400">{{ $this->stats['posted'] }}</p>
                <p class="text-[11px] uppercase tracking-wide text-slate-500 dark:text-slate-400">Posted</p>
            </div>
            <div class="rounded-xl glass px-4 py-2">
                <p class="text-lg font-bold text-amber-500">{{ $this->stats['draft'] }}</p>
                <p class="text-[11px] uppercase tracking-wide text-slate-500 dark:text-slate-400">Drafts</p>
            </div>
        </div>
    </div>

    {{-- Filter pills --}}
    <div class="flex gap-2">
        @foreach (['all' => 'All', 'draft' => 'Drafts', 'posted' => 'Posted'] as $key => $label)
            <button type="button" wire:click="setFilter('{{ $key }}')"
                class="rounded-lg px-3.5 py-1.5 text-sm font-medium transition {{ $filter === $key ? 'bg-gradient-to-r from-violet-600 to-fuchsia-600 text-white shadow' : 'glass text-slate-600 hover:bg-white/40 dark:text-slate-300' }}">
                {{ $label }}
            </button>
        @endforeach
    </div>

    {{-- Table / cards --}}
    <div class="overflow-hidden rounded-2xl glass shadow-xl">
        @if ($this->posts->isEmpty())
            <div class="flex flex-col items-center justify-center py-20 text-center">
                <p class="text-sm text-slate-500 dark:text-slate-400">No posts here yet.</p>
                <a href="{{ route('dashboard') }}" wire:navigate class="mt-3 rounded-lg bg-gradient-to-r from-violet-600 to-fuchsia-600 px-4 py-2 text-sm font-semibold text-white">Generate your first post →</a>
            </div>
        @else
            <div class="hidden grid-cols-[1fr_110px_120px_120px_150px] gap-3 border-b border-white/15 px-5 py-3 text-[11px] font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400 md:grid">
                <span>Post</span>
                <span>Platform</span>
                <span>Tone</span>
                <span>Date</span>
                <span class="text-right">Actions</span>
            </div>

            <div class="divide-y divide-white/10">
                @foreach ($this->posts as $post)
                    <div wire:key="hist-{{ $post->id }}" class="grid grid-cols-1 gap-3 px-5 py-4 md:grid-cols-[1fr_110px_120px_120px_150px] md:items-center">
                        {{-- preview --}}
                        <div class="min-w-0">
                            <p class="truncate text-sm text-slate-800 dark:text-slate-100">{{ \Illuminate\Support\Str::limit($post->content, 90) }}</p>
                            <div class="mt-1 flex items-center gap-2">
                                @if ($post->is_posted)
                                    <span class="inline-flex items-center gap-1 rounded-full bg-emerald-500/15 px-2 py-0.5 text-[11px] font-medium text-emerald-600 dark:text-emerald-400">✓ Posted {{ optional($post->posted_at)->diffForHumans() }}</span>
                                @else
                                    <span class="inline-flex items-center rounded-full bg-amber-500/15 px-2 py-0.5 text-[11px] font-medium text-amber-600 dark:text-amber-400">Draft</span>
                                @endif
                            </div>
                        </div>

                        <div>
                            <span class="rounded-full px-2.5 py-0.5 text-xs font-medium capitalize {{ $post->platform === 'facebook' ? 'bg-indigo-500/15 text-indigo-600 dark:text-indigo-300' : 'bg-sky-500/15 text-sky-600 dark:text-sky-300' }}">{{ $post->platform }}</span>
                        </div>

                        <div class="text-xs text-slate-500 dark:text-slate-400">{{ $post->tone ?? '—' }}</div>

                        <div class="text-xs text-slate-500 dark:text-slate-400">{{ $post->created_at->format('d M Y') }}</div>

                        <div class="flex items-center justify-start gap-1.5 md:justify-end">
                            @if (! $post->is_posted)
                                <button type="button" wire:click="markAsPosted({{ $post->id }})"
                                    class="rounded-lg bg-emerald-600 px-2.5 py-1.5 text-xs font-semibold text-white transition hover:bg-emerald-700">Mark Posted</button>
                            @endif
                            <button type="button" wire:click="deletePost({{ $post->id }})" wire:confirm="Delete this saved post?"
                                class="rounded-lg border border-white/20 px-2.5 py-1.5 text-xs font-medium text-slate-500 transition hover:bg-rose-500/10 hover:text-rose-500 dark:text-slate-300">Delete</button>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="px-5 py-4">
                {{ $this->posts->links() }}
            </div>
        @endif
    </div>
</div>
