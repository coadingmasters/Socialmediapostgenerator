<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use RuntimeException;

class GroqService
{
    /**
     * Tone presets that dynamically adjust the system prompt.
     */
    public const TONES = [
        'Professional' => 'Keep it polished, credible and thought-leadership oriented.',
        'Storytelling' => 'Frame it as a short personal story with a beginning, tension and a takeaway.',
        'Educational' => 'Teach one concrete concept step by step so a junior dev learns something.',
        'Controversial' => 'Take a bold, slightly contrarian stance that sparks healthy debate (stay respectful).',
    ];

    /**
     * Generate a full social post for the given parameters.
     */
    public function generatePost(string $topic, string $category, string $tone, string $platform): string
    {
        $platformTone = $platform === 'facebook'
            ? 'Facebook: casual, conversational, friendly, use emojis'
            : 'LinkedIn: professional, thought leadership, no emojis';

        $toneDirective = self::TONES[$tone] ?? self::TONES['Professional'];

        $system = <<<PROMPT
        You are a LinkedIn growth expert writing posts for a Pakistani PHP/Laravel freelance developer.
        Write posts that:
        - Open with a scroll-stopping hook (bold claim, surprising stat, or relatable question)
        - Share ONE specific insight, mistake, or lesson (not generic advice)
        - Use short punchy paragraphs (max 2 lines each)
        - Sound like a real human developer, not AI
        - End with a question to drive comments
        - Add 4-5 hashtags on last line
        - Word count: 150-250 words
        - For Facebook tone: more casual, add emoji, conversational
        - For LinkedIn tone: professional, no emoji, thought leadership
        Topic: {$topic}, Category: {$category}, Tone: {$platformTone}

        Extra style direction for this post ({$tone}): {$toneDirective}

        Return ONLY the post text. No preamble, no "Here is your post", no quotes around it.
        PROMPT;

        return $this->chat([
            ['role' => 'system', 'content' => $system],
            ['role' => 'user', 'content' => "Write the post now for topic \"{$topic}\" in the {$category} category."],
        ], temperature: 0.9);
    }

    /**
     * Generate a Leonardo/Midjourney image prompt for a finished post.
     */
    public function generateImagePrompt(string $post): string
    {
        $system = <<<PROMPT
        Generate a Midjourney/Leonardo AI image prompt for this LinkedIn post.
        The image should be professional, modern, tech-themed.
        Format: detailed scene description, style, lighting, camera angle, --ar 4:5 --q 2
        Keep it under 50 words. No explanations, just the prompt.
        Post content: {$post}
        PROMPT;

        return $this->chat([
            ['role' => 'system', 'content' => $system],
            ['role' => 'user', 'content' => 'Return only the image prompt.'],
        ], temperature: 0.8, maxTokens: 200);
    }

    /**
     * Generate 5 hook ideas for a topic (brainstorming tab).
     *
     * @return array<int, string>
     */
    public function generateHooks(string $topic): array
    {
        $system = <<<PROMPT
        You are a viral content strategist for developers.
        Generate exactly 5 scroll-stopping opening hooks (first lines) for social posts about the topic below.
        Each hook must be punchy, specific, and make the reader want to keep reading.
        Mix formats: bold claim, surprising stat, relatable question, mistake confession, contrarian take.
        Return ONLY the 5 hooks, one per line, no numbering, no extra text.
        Topic: {$topic}
        PROMPT;

        $raw = $this->chat([
            ['role' => 'system', 'content' => $system],
            ['role' => 'user', 'content' => "Give me 5 hooks about \"{$topic}\"."],
        ], temperature: 1.0, maxTokens: 400);

        return collect(preg_split('/\r\n|\r|\n/', $raw))
            ->map(fn ($line) => trim(preg_replace('/^\s*(?:\d+[\.\)]|[-*•])\s*/u', '', $line)))
            ->filter()
            ->take(5)
            ->values()
            ->all();
    }

    /**
     * Low-level chat completion call against the Groq API.
     *
     * @param  array<int, array{role: string, content: string}>  $messages
     */
    public function chat(array $messages, float $temperature = 0.8, int $maxTokens = 1024): string
    {
        $key = config('services.groq.key');

        if (blank($key)) {
            throw new RuntimeException('GROQ_API_KEY is not set in your .env file.');
        }

        // Windows PHP often ships without a configured CA bundle (curl.cainfo),
        // which breaks TLS verification. Point at the bundle shipped with the
        // app when present, so verification stays ON without editing php.ini.
        $caBundle = config('services.groq.ca_bundle');

        $response = Http::withToken($key)
            ->when(is_string($caBundle) && is_file($caBundle), fn ($http) => $http->withOptions(['verify' => $caBundle]))
            ->timeout(60)
            ->acceptJson()
            ->post(config('services.groq.base_url').'/chat/completions', [
                'model' => config('services.groq.model'),
                'messages' => $messages,
                'temperature' => $temperature,
                'max_tokens' => $maxTokens,
            ]);

        if ($response->failed()) {
            $message = $response->json('error.message') ?? $response->body();

            throw new RuntimeException('Groq API error: '.$message);
        }

        return trim((string) $response->json('choices.0.message.content', ''));
    }
}
