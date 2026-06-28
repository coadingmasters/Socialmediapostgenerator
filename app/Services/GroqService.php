<?php

namespace App\Services;

use App\Models\SavedPost;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
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
     *
     * Returns the post text plus the randomly selected tone style that was
     * used, so the caller can persist it.
     *
     * @return array{content: string, tone: string}
     */
    public function generatePost(string $topic, string $category, string $tone, string $platform): array
    {
        // 1. Pull the last 20 saved posts so Groq can avoid repeating angles.
        $recentPosts = SavedPost::latest()
            ->take(20)
            ->pluck('content')
            ->map(fn ($p) => '- '.Str::limit($p, 80))
            ->implode("\n");

        if (trim($recentPosts) === '') {
            $recentPosts = '(nothing posted yet — you have a clean slate)';
        }

        // 2. Uniqueness seed: random hook + random tone + entropy.
        $hooks = [
            "I made a mistake that cost my client 3 days of work.",
            "Nobody talks about this Laravel feature.",
            "I lost a client because I ignored this.",
            "After 5 years of PHP, I still get surprised by this.",
            "A junior dev asked me something I couldn't answer.",
            "My client's site crashed. Here's what I learned.",
            "Stop writing Laravel code like this.",
            "I reviewed 10 freelancer portfolios. Same mistake in all.",
            "This one Laravel trick saved me 4 hours last week.",
            "Most PHP developers don't know this exists.",
            "I almost gave up freelancing until I learned this.",
            "This is why your Laravel app is slow.",
            "3 years ago I was charging \$5/hr. Here's what changed.",
            "The client said my code was 'too clean'. I'll explain.",
            "I Googled this embarrassing Laravel thing yesterday.",
        ];

        $tones = [
            "storytelling - share a real personal experience with specific details",
            "controversial - challenge a common belief in PHP/Laravel community",
            "educational - teach one very specific technical thing step by step",
            "mistake - share a real mistake and lesson learned",
            "behind the scenes - show what freelance dev life actually looks like",
            "client story - share an anonymous client project lesson",
            "hot take - strong opinion that developers will agree or disagree with",
        ];

        $randomHook = $hooks[array_rand($hooks)];
        $randomTone = $tones[array_rand($tones)];
        $uniqueSeed = now()->timestamp.rand(100, 999);

        // 3. System prompt.
        $system = <<<PROMPT
        You are a real Pakistani software developer named Ahsan who writes
        brutally honest LinkedIn posts about PHP, Laravel, and freelancing.

        Your writing rules:
        - NEVER start with "I" — start with the hook given to you
        - Write like you are texting a developer friend, then cleaned up
        - Use SPECIFIC numbers, tools, file names, error names when possible
        - One idea per post — do not try to cover multiple points
        - Paragraphs max 2 lines — white space is your friend on LinkedIn
        - NO corporate words: leverage, synergy, journey, excited, thrilled,
          passionate, dive deep, game changer, unlock, empower
        - NO bullet points or numbered lists in the post
        - End with ONE honest question that developers actually want to answer
        - Sound slightly frustrated or surprised — that gets engagement
        - Total length: 160-220 words strictly

        Hashtag rules:
        - Exactly 4 hashtags only
        - Mix: 1 broad (#PHP or #Laravel) + 1 niche (#LaravelTips or #EloquentORM)
          + 1 audience (#FreelanceDeveloper or #WebDeveloper) + 1 location (#PakistanTech or #Pakistani)
        - NO generic hashtags like #Coding #Programming #Developer #Tech #Software
        PROMPT;

        // 4. User prompt.
        $user = <<<PROMPT
        Unique seed: {$uniqueSeed}
        Platform: {$platform}
        Topic: {$topic}
        Category: {$category}
        Tone style: {$randomTone}

        Start the post with this hook (rewrite it naturally, don't copy exactly):
        "{$randomHook}"

        IMPORTANT - I have already posted about these topics recently,
        do NOT repeat these angles:
        {$recentPosts}

        Write a completely different angle. Be specific. Be human.
        Output ONLY the post text + hashtags. No explanations.
        PROMPT;

        $content = $this->chat([
            ['role' => 'system', 'content' => $system],
            ['role' => 'user', 'content' => $user],
        ], temperature: 1.0);

        return ['content' => $content, 'tone' => $randomTone];
    }

    /**
     * Generate a cinematic image prompt that represents the post's story.
     */
    public function generateImagePrompt(string $post, string $topic = ''): string
    {
        $system = <<<PROMPT
        You are a professional art director. Create a Leonardo.ai image prompt
        based on the post content. Output ONLY the prompt, nothing else.
        PROMPT;

        $user = <<<PROMPT
        Post: {$post}
        Topic: {$topic}

        Create a cinematic image prompt that visually tells this post's story.
        Rules:
        - NO generic "developer at laptop" scenes
        - Scene must reflect the SPECIFIC story in the post
        - Include: environment, mood, color, lighting
        - Style: cinematic photography, ultra realistic, 4k
        - Max 30 words before parameters
        - End with: --ar 4:5
        - Output ONLY the prompt text, nothing else
        PROMPT;

        return $this->chat([
            ['role' => 'system', 'content' => $system],
            ['role' => 'user', 'content' => $user],
        ], temperature: 0.85, maxTokens: 160);
    }

    /**
     * Build a free Pollinations.ai (flux) image URL from a prompt.
     * No API key required.
     */
    public function pollinationsUrl(string $prompt, int $width = 800, int $height = 1000): string
    {
        $encodedPrompt = urlencode($prompt);
        $seed = rand(1000, 9999);

        return "https://image.pollinations.ai/prompt/{$encodedPrompt}?width={$width}&height={$height}&seed={$seed}&nologo=true&model=flux";
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
