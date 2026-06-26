<?php

namespace Database\Seeders;

use App\Models\PostTemplate;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        PostTemplate::query()->delete();

        foreach ($this->posts() as $post) {
            PostTemplate::create($post);
        }
    }

    /**
     * 50+ professional, ready-to-share posts.
     *
     * @return array<int, array<string, string>>
     */
    private function posts(): array
    {
        return [
            // ---------------------------------------------------------------
            // LARAVEL
            // ---------------------------------------------------------------
            [
                'topic' => 'Laravel',
                'category' => 'Tips',
                'platform' => 'linkedin',
                'content' => "Most Laravel performance problems are not framework problems — they are N+1 query problems.\n\nBefore you reach for caching or a bigger server, run Laravel Debugbar and eager-load your relationships with `with()`. I have seen pages drop from 400 queries to 6 with a single line of code.\n\nMeasure first. Optimise second.",
                'hashtags' => '#Laravel #PHP #WebDev #Performance #Freelancer',
            ],
            [
                'topic' => 'Laravel',
                'category' => 'Tips',
                'platform' => 'facebook',
                'content' => "Quick Laravel tip 👇\n\nStop writing raw queries for everything. `Model::with('relation')` will save you from the dreaded N+1 problem and make your app fly. 🚀\n\nWhat's your favourite Laravel shortcut? Drop it in the comments!",
                'hashtags' => '#Laravel #PHP #WebDev #CodingLife',
            ],
            [
                'topic' => 'Laravel',
                'category' => 'Case Study',
                'platform' => 'linkedin',
                'content' => "Case study: We rebuilt a client's legacy PHP dashboard in Laravel 12.\n\nResults after 6 weeks:\n• Page load time: 3.2s → 480ms\n• Codebase size: reduced by 40%\n• New features ship in days, not weeks\n\nThe lesson? A clean framework and queued jobs do more for UX than any micro-optimisation.",
                'hashtags' => '#Laravel #PHP #WebDev #CaseStudy #Freelancer',
            ],
            [
                'topic' => 'Laravel',
                'category' => 'Case Study',
                'platform' => 'facebook',
                'content' => "Just wrapped up a Laravel project for a client and the numbers are wild 😮\n\nOld dashboard: 3.2 seconds to load\nNew Laravel dashboard: under half a second ⚡\n\nClients always feel the difference when the app is fast. Speed sells. 💪",
                'hashtags' => '#Laravel #WebDev #Freelancer #Pakistan',
            ],
            [
                'topic' => 'Laravel',
                'category' => 'Achievement',
                'platform' => 'linkedin',
                'content' => "Milestone unlocked 🎉\n\nI just shipped my 25th Laravel application to production. From small business CRMs to multi-tenant SaaS platforms, every project taught me something new about writing maintainable PHP.\n\nGrateful to every client who trusted the process. On to the next one.",
                'hashtags' => '#Laravel #PHP #WebDev #Achievement #Freelancer',
            ],
            [
                'topic' => 'Laravel',
                'category' => 'Achievement',
                'platform' => 'facebook',
                'content' => "25 Laravel apps in production and counting! 🥳🎉\n\nWhen I wrote my first migration I had no idea where this would lead. Today it pays the bills and lets me work with amazing clients worldwide. 🌍\n\nKeep building, friends! 🔨",
                'hashtags' => '#Laravel #Freelancer #CodingLife #Pakistan',
            ],
            [
                'topic' => 'Laravel',
                'category' => 'Question',
                'platform' => 'linkedin',
                'content' => "A question for the Laravel community:\n\nWhen your application grows, do you prefer Service classes, Action classes, or fat Models with traits?\n\nI have settled on single-purpose Actions for write operations, but I'm curious how teams at scale keep their business logic organised. What works for you?",
                'hashtags' => '#Laravel #PHP #WebDev #SoftwareArchitecture',
            ],
            [
                'topic' => 'Laravel',
                'category' => 'Question',
                'platform' => 'facebook',
                'content' => "Laravel devs, settle a debate for me 👀\n\nService classes vs Action classes vs fat models — which one is your go-to and WHY?\n\nNo wrong answers, just curious how everyone organises their code. Comment below! 👇",
                'hashtags' => '#Laravel #PHP #CodingLife #WebDev',
            ],
            [
                'topic' => 'Laravel',
                'category' => 'Motivation',
                'platform' => 'linkedin',
                'content' => "You don't need to know every Laravel feature to build great software.\n\nWhen I started, I only understood routes, controllers and Blade. That was enough to ship real value for real clients. The advanced features came later, project by project.\n\nStart small. Ship often. Learn as you go.",
                'hashtags' => '#Laravel #PHP #WebDev #Motivation #Freelancer',
            ],
            [
                'topic' => 'Laravel',
                'category' => 'Motivation',
                'platform' => 'facebook',
                'content' => "Reminder for anyone learning Laravel right now 💚\n\nYou don't need to master everything before you start building. Routes + controllers + Blade is enough to ship something real today.\n\nStop waiting. Start shipping. You've got this! 🚀",
                'hashtags' => '#Laravel #CodingLife #Motivation #WebDev',
            ],

            // ---------------------------------------------------------------
            // PHP
            // ---------------------------------------------------------------
            [
                'topic' => 'PHP',
                'category' => 'Tips',
                'platform' => 'linkedin',
                'content' => "PHP in 2026 is not the PHP people love to mock.\n\nTyped properties, enums, readonly classes, fibers, and a JIT compiler make modern PHP fast and expressive. If your opinion of the language is stuck in 2014, it's worth another look.\n\nThe tooling has never been better.",
                'hashtags' => '#PHP #WebDev #Laravel #Programming #Freelancer',
            ],
            [
                'topic' => 'PHP',
                'category' => 'Tips',
                'platform' => 'facebook',
                'content' => "Hot take: modern PHP is actually really nice now 🔥\n\nEnums, readonly classes, typed properties, JIT... the language people loved to hate has quietly become a joy to write.\n\nGive it another shot. You might be surprised! 😄",
                'hashtags' => '#PHP #WebDev #CodingLife',
            ],
            [
                'topic' => 'PHP',
                'category' => 'Case Study',
                'platform' => 'linkedin',
                'content' => "We migrated a PHP 7.4 application to PHP 8.3 for a client last month.\n\nWith zero code rewrites — just the version bump and a config tune — the API response times dropped by 22% thanks to the improved engine and JIT.\n\nKeeping your runtime current is the cheapest performance win there is.",
                'hashtags' => '#PHP #WebDev #Performance #CaseStudy',
            ],
            [
                'topic' => 'PHP',
                'category' => 'Achievement',
                'platform' => 'linkedin',
                'content' => "Proud moment: I just contributed my first patch to an open-source PHP package used by thousands of developers.\n\nIt was a small fix to a date-handling edge case, but seeing it merged reminded me why I love this community. We all stand on each other's shoulders.",
                'hashtags' => '#PHP #OpenSource #WebDev #Achievement',
            ],
            [
                'topic' => 'PHP',
                'category' => 'Achievement',
                'platform' => 'facebook',
                'content' => "My first ever open-source PHP contribution just got merged! 🎉🎉\n\nIt's a tiny bug fix but it's used by thousands of devs around the world. Feeling like I gave a little something back today. 🙏",
                'hashtags' => '#PHP #OpenSource #CodingLife #Pakistan',
            ],
            [
                'topic' => 'PHP',
                'category' => 'Question',
                'platform' => 'linkedin',
                'content' => "Honest question for senior PHP engineers:\n\nDo you still write custom framework code, or has the ecosystem matured to the point where you reach for a package for almost everything?\n\nI find myself composing packages more than writing from scratch. Curious where you draw the line.",
                'hashtags' => '#PHP #WebDev #SoftwareEngineering',
            ],
            [
                'topic' => 'PHP',
                'category' => 'Motivation',
                'platform' => 'facebook',
                'content' => "If anyone told you PHP is a dead language, ignore them 😌\n\nIt powers 75% of the web, pays incredible salaries, and the community is thriving. Learn it well and you'll never run out of work.\n\nBet on fundamentals, not hype. 💪",
                'hashtags' => '#PHP #WebDev #Motivation #Freelancer',
            ],
            [
                'topic' => 'PHP',
                'category' => 'Motivation',
                'platform' => 'linkedin',
                'content' => "A reminder for developers feeling behind:\n\nPHP has powered the web for nearly 30 years and still runs the majority of websites you use daily. Mastering a 'boring' technology that pays bills and solves problems is a perfectly valid career strategy.\n\nDepth beats hype.",
                'hashtags' => '#PHP #WebDev #Motivation #CareerAdvice',
            ],

            // ---------------------------------------------------------------
            // WEB DEVELOPMENT
            // ---------------------------------------------------------------
            [
                'topic' => 'Web Development',
                'category' => 'Tips',
                'platform' => 'linkedin',
                'content' => "The fastest way to improve any web app's perceived speed:\n\n1. Add loading states to every async action\n2. Optimise and lazy-load images\n3. Defer non-critical JavaScript\n4. Cache aggressively at the edge\n\nUsers don't measure milliseconds — they measure how responsive your app feels.",
                'hashtags' => '#WebDev #Frontend #Performance #UX',
            ],
            [
                'topic' => 'Web Development',
                'category' => 'Tips',
                'platform' => 'facebook',
                'content' => "Want your website to FEEL faster instantly? ⚡\n\n✅ Add loading spinners\n✅ Lazy-load your images\n✅ Defer heavy JavaScript\n\nUsers don't count milliseconds — they feel the responsiveness. Small changes, big difference! 🙌",
                'hashtags' => '#WebDev #Frontend #CodingLife',
            ],
            [
                'topic' => 'Web Development',
                'category' => 'Case Study',
                'platform' => 'linkedin',
                'content' => "A client came to me with a 'slow website'. The real issue? 8MB of unoptimised hero images on the landing page.\n\nAfter compression and modern formats (WebP/AVIF), the page went from 9s to 1.4s on 3G. No backend changes needed.\n\nSometimes the biggest wins are the simplest ones.",
                'hashtags' => '#WebDev #Performance #CaseStudy #Freelancer',
            ],
            [
                'topic' => 'Web Development',
                'category' => 'Achievement',
                'platform' => 'facebook',
                'content' => "Just hit 100 Lighthouse performance score on a client site! 💯⚡\n\nGreen across the board — performance, accessibility, SEO and best practices. Took some work but so worth it.\n\nFast websites = happy users = happy clients. 😍",
                'hashtags' => '#WebDev #Performance #Freelancer #Pakistan',
            ],
            [
                'topic' => 'Web Development',
                'category' => 'Achievement',
                'platform' => 'linkedin',
                'content' => "Small win worth celebrating: a client's e-commerce site just hit a perfect 100 Lighthouse performance score.\n\nGreen across performance, accessibility, SEO and best practices. The bounce rate dropped 18% in the first week.\n\nPerformance is a feature, and it directly affects revenue.",
                'hashtags' => '#WebDev #Performance #UX #Achievement',
            ],
            [
                'topic' => 'Web Development',
                'category' => 'Question',
                'platform' => 'linkedin',
                'content' => "Curious where the community stands in 2026:\n\nFor a new content-heavy marketing site, are you reaching for a full SPA framework, a meta-framework with SSR, or going back to server-rendered HTML with a sprinkle of JavaScript?\n\nI'm increasingly choosing the last option. What about you?",
                'hashtags' => '#WebDev #Frontend #JavaScript #SoftwareArchitecture',
            ],
            [
                'topic' => 'Web Development',
                'category' => 'Question',
                'platform' => 'facebook',
                'content' => "Web devs, quick poll 📊\n\nFor a simple marketing site would you use:\n\nA) A big JS framework\nB) Server-rendered HTML + a little JavaScript\n\nI'm Team B these days. What about you? 👇",
                'hashtags' => '#WebDev #Frontend #CodingLife',
            ],
            [
                'topic' => 'Web Development',
                'category' => 'Motivation',
                'platform' => 'linkedin',
                'content' => "You will never feel 'ready' to call yourself a web developer.\n\nThere is always another framework, another tool, another best practice. The developers who succeed are not the ones who know everything — they are the ones who keep shipping while they learn.\n\nProgress over perfection.",
                'hashtags' => '#WebDev #Motivation #CareerAdvice #Freelancer',
            ],
            [
                'topic' => 'Web Development',
                'category' => 'Motivation',
                'platform' => 'facebook',
                'content' => "Friendly reminder 💛\n\nThere will ALWAYS be a new framework to learn. You'll never feel 100% ready — and that's okay!\n\nThe devs who win are the ones who keep shipping while they learn. Progress over perfection, always. 🚀",
                'hashtags' => '#WebDev #Motivation #CodingLife',
            ],

            // ---------------------------------------------------------------
            // FREELANCING TIPS
            // ---------------------------------------------------------------
            [
                'topic' => 'Freelancing Tips',
                'category' => 'Tips',
                'platform' => 'linkedin',
                'content' => "The freelancing skill nobody talks about: writing a clear scope.\n\nMost project disputes are not about code quality — they are about mismatched expectations. A one-page scope that lists what IS and what is NOT included will save you more stress than any tool.\n\nClarity is kindness. To your client and yourself.",
                'hashtags' => '#Freelancer #Freelancing #WebDev #BusinessTips',
            ],
            [
                'topic' => 'Freelancing Tips',
                'category' => 'Tips',
                'platform' => 'facebook',
                'content' => "Freelancer life lesson 📝\n\nALWAYS write down what's included AND what's NOT included before you start. 90% of project fights come from unclear scope, not bad code.\n\nA simple one-page scope = fewer headaches. Trust me on this one! 😅",
                'hashtags' => '#Freelancer #Freelancing #CodingLife #Pakistan',
            ],
            [
                'topic' => 'Freelancing Tips',
                'category' => 'Case Study',
                'platform' => 'linkedin',
                'content' => "Two years ago I raised my rate by 60% and braced myself to lose every client.\n\nWhat actually happened: the price-sensitive clients left, the serious ones stayed, and I worked fewer hours for more money. The work also got better because I could give each project real focus.\n\nCharge what you're worth.",
                'hashtags' => '#Freelancer #Freelancing #BusinessTips #CareerAdvice',
            ],
            [
                'topic' => 'Freelancing Tips',
                'category' => 'Achievement',
                'platform' => 'linkedin',
                'content' => "Three years ago I sent my first nervous proposal on Upwork.\n\nToday I crossed six figures in lifetime freelance earnings, working with clients across four continents from my home in Pakistan.\n\nTo anyone just starting: the first client is the hardest. Keep sending that proposal.",
                'hashtags' => '#Freelancer #Freelancing #Achievement #Pakistan',
            ],
            [
                'topic' => 'Freelancing Tips',
                'category' => 'Achievement',
                'platform' => 'facebook',
                'content' => "From my first scary \$5 proposal to six figures in freelance earnings 🥹🎉\n\nWorking with clients on 4 continents from right here in Pakistan 🇵🇰\n\nIf you're just starting out — the first client is the hardest. Don't give up! 💪❤️",
                'hashtags' => '#Freelancer #Freelancing #Pakistan #Motivation',
            ],
            [
                'topic' => 'Freelancing Tips',
                'category' => 'Question',
                'platform' => 'linkedin',
                'content' => "A question for fellow freelancers:\n\nHow do you handle a client who keeps adding 'small' requests after the scope is agreed?\n\nI use a friendly change-request process, but I'd love to hear how you protect your time while keeping the relationship warm. Share your approach below.",
                'hashtags' => '#Freelancer #Freelancing #BusinessTips #WebDev',
            ],
            [
                'topic' => 'Freelancing Tips',
                'category' => 'Question',
                'platform' => 'facebook',
                'content' => "Freelancers, help me out 🙏\n\nHow do YOU deal with 'just one more small thing' requests after the project scope is locked in?\n\nDrop your best tips in the comments — we can all learn from each other! 👇",
                'hashtags' => '#Freelancer #Freelancing #CodingLife',
            ],
            [
                'topic' => 'Freelancing Tips',
                'category' => 'Motivation',
                'platform' => 'linkedin',
                'content' => "Freelancing is not just about coding skills. It's about trust.\n\nClients rehire the developer who communicates clearly, meets deadlines, and stays calm when things break — not necessarily the one with the cleverest code.\n\nBe reliable. Reliability compounds into a reputation.",
                'hashtags' => '#Freelancer #Freelancing #Motivation #CareerAdvice',
            ],
            [
                'topic' => 'Freelancing Tips',
                'category' => 'Motivation',
                'platform' => 'facebook',
                'content' => "Secret to freelancing success? It's not your code 🤫\n\nIt's TRUST. Clear communication, hitting deadlines, staying calm when things break.\n\nBe the reliable one and clients will keep coming back forever. Reliability = reputation = income. 💯",
                'hashtags' => '#Freelancer #Freelancing #Motivation #Pakistan',
            ],

            // ---------------------------------------------------------------
            // CLICKHOUSE
            // ---------------------------------------------------------------
            [
                'topic' => 'ClickHouse',
                'category' => 'Tips',
                'platform' => 'linkedin',
                'content' => "If your analytics dashboard is crawling on MySQL, it might be time to look at ClickHouse.\n\nIt's a columnar database built for analytical queries. Aggregations that took 30 seconds on a row store can return in under 200ms because it only reads the columns you ask for.\n\nRight tool, right job.",
                'hashtags' => '#ClickHouse #Database #DataEngineering #WebDev',
            ],
            [
                'topic' => 'ClickHouse',
                'category' => 'Tips',
                'platform' => 'facebook',
                'content' => "If your dashboards are slow on MySQL, meet ClickHouse 👋\n\nIt's a columnar database made for analytics. Queries that took 30 seconds can finish in under a second ⚡\n\nGame changer for reporting-heavy apps! 📊",
                'hashtags' => '#ClickHouse #Database #DataEngineering',
            ],
            [
                'topic' => 'ClickHouse',
                'category' => 'Case Study',
                'platform' => 'linkedin',
                'content' => "We moved a client's reporting workload off MySQL and onto ClickHouse.\n\nThe headline numbers:\n• A 12-second monthly report now runs in 300ms\n• Storage dropped 70% thanks to columnar compression\n• The dashboard finally feels instant\n\nFor append-only analytical data, ClickHouse is hard to beat.",
                'hashtags' => '#ClickHouse #Database #DataEngineering #CaseStudy',
            ],
            [
                'topic' => 'ClickHouse',
                'category' => 'Case Study',
                'platform' => 'facebook',
                'content' => "Client had a report that took 12 SECONDS to load 😴\n\nMoved it to ClickHouse → now it loads in 0.3 seconds ⚡ AND uses 70% less storage thanks to compression.\n\nThe right database for the job makes ALL the difference. 🔥",
                'hashtags' => '#ClickHouse #Database #Freelancer #Pakistan',
            ],
            [
                'topic' => 'ClickHouse',
                'category' => 'Achievement',
                'platform' => 'linkedin',
                'content' => "Just shipped my first production ClickHouse pipeline 🎉\n\nIt ingests millions of events per day and powers a real-time analytics dashboard with sub-second queries. Coming from a traditional Laravel + MySQL background, learning a columnar engine stretched my thinking in the best way.\n\nAlways be learning.",
                'hashtags' => '#ClickHouse #DataEngineering #Achievement #Laravel',
            ],
            [
                'topic' => 'ClickHouse',
                'category' => 'Question',
                'platform' => 'linkedin',
                'content' => "For the data engineers here:\n\nWhen integrating ClickHouse alongside a Laravel + MySQL stack, do you sync data with a queue-based ETL, change-data-capture, or scheduled batch jobs?\n\nI've had good results with queued batch inserts, but I'm keen to learn what scales best for you.",
                'hashtags' => '#ClickHouse #DataEngineering #Laravel #Database',
            ],
            [
                'topic' => 'ClickHouse',
                'category' => 'Question',
                'platform' => 'facebook',
                'content' => "Data folks, I need your wisdom 🧠\n\nIf you run ClickHouse next to Laravel + MySQL, how do you keep the data in sync? Queues? CDC? Batch jobs?\n\nCurious what's working for everyone. Comment below! 👇",
                'hashtags' => '#ClickHouse #DataEngineering #Laravel',
            ],
            [
                'topic' => 'ClickHouse',
                'category' => 'Motivation',
                'platform' => 'linkedin',
                'content' => "Don't be intimidated by 'big data' tools like ClickHouse.\n\nUnderneath the buzzwords it's still just SQL, tables and queries — concepts you already know. I went from never having touched a columnar database to shipping one in production in a few focused weeks.\n\nYour existing skills transfer further than you think.",
                'hashtags' => '#ClickHouse #DataEngineering #Motivation #CareerAdvice',
            ],
            [
                'topic' => 'ClickHouse',
                'category' => 'Motivation',
                'platform' => 'facebook',
                'content' => "Scared of 'big data' tools? Don't be! 💪\n\nClickHouse looks fancy but underneath it's still just SQL — tables, queries, the stuff you already know.\n\nI learned it in a few weeks. If I can, you can too! Your skills transfer further than you think. 🚀",
                'hashtags' => '#ClickHouse #DataEngineering #Motivation #Pakistan',
            ],

            // ---------------------------------------------------------------
            // EXTRA MIX (to comfortably pass 50)
            // ---------------------------------------------------------------
            [
                'topic' => 'Laravel',
                'category' => 'Tips',
                'platform' => 'linkedin',
                'content' => "Underrated Laravel feature: queued jobs.\n\nAnything that doesn't need to happen during the request — emails, PDF generation, third-party API calls — belongs on a queue. Your users get an instant response and your app stays snappy under load.\n\nMove slow work off the request lifecycle.",
                'hashtags' => '#Laravel #PHP #Performance #WebDev',
            ],
            [
                'topic' => 'PHP',
                'category' => 'Tips',
                'platform' => 'linkedin',
                'content' => "A small habit that improved my PHP code overnight: enabling `declare(strict_types=1)` at the top of every file.\n\nIt turns silent type coercion bugs into loud, catchable errors. You fix problems at write-time instead of debugging them at 2am in production.",
                'hashtags' => '#PHP #WebDev #CleanCode #Programming',
            ],
            [
                'topic' => 'Web Development',
                'category' => 'Tips',
                'platform' => 'linkedin',
                'content' => "Accessibility is not a feature you bolt on at the end. It's a default you build in from the start.\n\nSemantic HTML, proper labels, keyboard navigation and sufficient colour contrast cost almost nothing during development — and they make your product usable for everyone.\n\nBuild for all your users.",
                'hashtags' => '#WebDev #Accessibility #Frontend #UX',
            ],
            [
                'topic' => 'Freelancing Tips',
                'category' => 'Tips',
                'platform' => 'linkedin',
                'content' => "Take the deposit. Always.\n\nA 30–50% upfront payment isn't about distrust — it's about commitment from both sides. Clients who happily pay a deposit are the clients who respect your time and take the project seriously.\n\nIt's the simplest filter for serious work.",
                'hashtags' => '#Freelancer #Freelancing #BusinessTips #CareerAdvice',
            ],
            [
                'topic' => 'ClickHouse',
                'category' => 'Tips',
                'platform' => 'linkedin',
                'content' => "ClickHouse tip: choose your ORDER BY key carefully.\n\nIt's not just sorting — it defines how data is stored on disk and is the single biggest factor in query performance. Order by the columns you filter on most, and your queries will scan a fraction of the data.\n\nThe schema is the optimisation.",
                'hashtags' => '#ClickHouse #Database #DataEngineering #Performance',
            ],
            [
                'topic' => 'Laravel',
                'category' => 'Motivation',
                'platform' => 'linkedin',
                'content' => "Every senior Laravel developer you admire once stared at a 500 error with no idea what to do.\n\nThe difference between a beginner and an expert is not the absence of bugs — it's the calm, methodical way they hunt them down. That calm is built one stack trace at a time.\n\nKeep debugging. It compounds.",
                'hashtags' => '#Laravel #PHP #Motivation #WebDev',
            ],
            [
                'topic' => 'Web Development',
                'category' => 'Case Study',
                'platform' => 'linkedin',
                'content' => "A SaaS client was paying for a bigger server every quarter to keep up with traffic.\n\nThe real fix wasn't more hardware — it was adding Redis caching to three hot endpoints and a CDN in front of static assets. Their server bill dropped 45% and the app got faster.\n\nScale your architecture before your invoice.",
                'hashtags' => '#WebDev #Performance #CaseStudy #Freelancer',
            ],
            [
                'topic' => 'PHP',
                'category' => 'Case Study',
                'platform' => 'facebook',
                'content' => "Bumped a client's app from PHP 7.4 to 8.3 and did basically nothing else 😅\n\nResult? API got 22% faster for free. ⚡\n\nKeeping your PHP version current is the easiest performance win out there. Don't sleep on it! 💤➡️🚀",
                'hashtags' => '#PHP #WebDev #Performance #Freelancer',
            ],
            [
                'topic' => 'Freelancing Tips',
                'category' => 'Achievement',
                'platform' => 'facebook',
                'content' => "Just got my 50th five-star review on Upwork! ⭐⭐⭐⭐⭐\n\nEvery single one represents a client who trusted me and a problem we solved together. Beyond grateful for this journey. 🙏❤️\n\nConsistency really does pay off, friends!",
                'hashtags' => '#Freelancer #Freelancing #Achievement #Pakistan',
            ],
            [
                'topic' => 'Laravel',
                'category' => 'Question',
                'platform' => 'linkedin',
                'content' => "Laravel testing question for the community:\n\nDo you write feature tests that hit the database, or do you mock everything for speed? I lean towards real feature tests with an in-memory SQLite database — the confidence is worth the milliseconds.\n\nWhere do you land on this trade-off?",
                'hashtags' => '#Laravel #PHP #Testing #WebDev',
            ],
            [
                'topic' => 'Web Development',
                'category' => 'Achievement',
                'platform' => 'linkedin',
                'content' => "Today a junior developer I mentored landed their first full-time role 🎉\n\nSix months ago they couldn't centre a div without Googling. Today they're shipping production features. Watching someone grow is the most rewarding part of this industry.\n\nLift as you climb.",
                'hashtags' => '#WebDev #Mentorship #Achievement #CareerAdvice',
            ],
            [
                'topic' => 'ClickHouse',
                'category' => 'Achievement',
                'platform' => 'facebook',
                'content' => "My first ClickHouse pipeline is LIVE and handling millions of events a day! 🎉📊\n\nWent from 'never touched a columnar DB' to production in a few weeks. Sub-second analytics queries feel like magic ✨\n\nNever stop learning, people! 🚀",
                'hashtags' => '#ClickHouse #DataEngineering #Achievement #Pakistan',
            ],
            [
                'topic' => 'Freelancing Tips',
                'category' => 'Motivation',
                'platform' => 'linkedin',
                'content' => "Your first year freelancing will feel chaotic. That's normal.\n\nInconsistent income, awkward client calls, underpricing your work — every successful freelancer has been there. Push through the messy beginning and the systems, confidence and referrals start to stack up.\n\nIt gets better. Keep going.",
                'hashtags' => '#Freelancer #Freelancing #Motivation #CareerAdvice',
            ],
            [
                'topic' => 'PHP',
                'category' => 'Motivation',
                'platform' => 'facebook',
                'content' => "To every self-taught PHP dev grinding right now 👇\n\nNo CS degree? Doesn't matter. The web runs on PHP and clients pay for results, not diplomas.\n\nKeep building real projects and your skills will speak louder than any certificate. 💪🔥",
                'hashtags' => '#PHP #WebDev #Motivation #Pakistan',
            ],
        ];
    }
}
