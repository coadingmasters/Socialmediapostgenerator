# Social Media Post Generator

AI-powered LinkedIn & Facebook post generator for PHP/Laravel freelancers, built with
**Laravel + Livewire + Tailwind v4** and powered by the **Groq API** (Llama 3.3 70B — free tier).

## Features

- **AI post generation** — live Groq calls (no hardcoded templates) with topic, category,
  platform (LinkedIn / Facebook) and tone (Professional / Storytelling / Educational / Controversial).
- **AI image-prompt generator** — a second Groq call produces a Leonardo.ai / Midjourney prompt
  (`--ar 4:5 --q 2`) with a one-click copy and typewriter reveal.
- **Hook generator** — brainstorm 5 scroll-stopping opening lines for any topic.
- **Character counter** with LinkedIn-limit colour coding (green / amber / red).
- **Post history** (`/history`) — table of saved posts with Mark-as-Posted, delete, filters and stats.
- **Modern UI** — glassmorphism sidebar, gradient background, dark/light mode (saved to
  `localStorage`), skeleton loaders, fade-in & toast notifications.

## Requirements

- PHP 8.3+, Composer
- Node 18+ / npm
- MySQL 8

## Setup

```bash
composer install
npm install

cp .env.example .env
php artisan key:generate
# set your DB_* credentials and GROQ_API_KEY in .env

php artisan migrate
npm run build      # or: npm run dev
php artisan serve
```

Then open http://127.0.0.1:8000

### Get a free Groq API key

Create one at https://console.groq.com/keys and set it in `.env`:

```
GROQ_API_KEY=gsk_xxxxxxxx
GROQ_MODEL=llama-3.3-70b-versatile
```

> **Windows note:** if PHP cannot verify TLS (`cURL error 60`), this project ships a CA bundle at
> `storage/certs/cacert.pem` that the Groq client uses automatically. Alternatively, set
> `curl.cainfo` in your `php.ini` to a `cacert.pem`.

## Tech

Laravel · Livewire (single-file components) · Tailwind CSS v4 · Alpine.js · Groq API
