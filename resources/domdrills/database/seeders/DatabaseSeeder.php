<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\ChatRoom;
use App\Models\Faq;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@domdrills.test'],
            [
                'name' => 'DomDrills Admin',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        $mentor = User::firstOrCreate(
            ['email' => 'mentor@domdrills.test'],
            [
                'name' => 'Alex Mentor',
                'password' => Hash::make('password'),
                'role' => 'mentor',
            ]
        );

        User::firstOrCreate(
            ['email' => 'trader@domdrills.test'],
            [
                'name' => 'Sam Trader',
                'password' => Hash::make('password'),
                'role' => 'user',
            ]
        );

        $categories = collect(['Risk Management', 'Technical Analysis', 'Trading Psychology', 'Market Structure'])
            ->map(fn ($name) => Category::firstOrCreate(['slug' => Str::slug($name)], ['name' => $name]));

        $samplePosts = [
            [
                'title' => 'The 1% Rule: Why Position Sizing Beats Prediction',
                'category' => 'Risk Management',
                'body' => "Most new traders obsess over being right. Experienced traders obsess over how much they lose when they're wrong.\n\nThe 1% rule means you never risk more than 1% of your account on a single trade. If you have a $10,000 account, your maximum loss per trade is $100 — no matter how confident you feel.\n\nThis single habit is the difference between traders who survive long enough to get good, and traders who blow up their account on one bad week.",
            ],
            [
                'title' => 'Reading Support and Resistance Like a Professional',
                'category' => 'Technical Analysis',
                'body' => "Support and resistance aren't exact lines — they're zones where buyers and sellers have historically fought for control.\n\nInstead of drawing a single line, mark a zone using the wicks and bodies of candles that reacted at that level. Price rarely respects a line to the pixel, but it very often respects a zone.\n\nCombine this with volume: a zone with high volume is more significant than one with thin trading.",
            ],
            [
                'title' => 'Why Revenge Trading Destroys Accounts',
                'category' => 'Trading Psychology',
                'body' => "Revenge trading happens when a loss triggers an emotional need to 'win it back' immediately. It bypasses your strategy entirely.\n\nThe fix isn't willpower — it's a rule: after two losing trades in a row, you stop trading for the day. No exceptions. Write it into your trading plan and treat it like a hard stop, not a suggestion.",
            ],
            [
                'title' => 'Understanding Market Structure: Higher Highs vs Lower Lows',
                'category' => 'Market Structure',
                'body' => "Market structure is the skeleton underneath every chart. An uptrend is a series of higher highs and higher lows. A downtrend is the opposite.\n\nThe moment structure breaks — a lower high forms in an uptrend — is often your earliest warning that momentum is shifting. Learning to spot structure breaks before the crowd is one of the highest-leverage skills in trading.",
            ],
        ];

        foreach ($samplePosts as $data) {
            $category = $categories->firstWhere('name', $data['category']);

            Post::firstOrCreate(
                ['slug' => Str::slug($data['title'])],
                [
                    'user_id' => $mentor->id,
                    'category_id' => $category?->id,
                    'title' => $data['title'],
                    'excerpt' => Str::limit(strip_tags($data['body']), 150),
                    'body' => $data['body'],
                    'published_at' => now()->subDays(rand(1, 30)),
                ]
            );
        }

        $faqs = [
            ['category' => 'Getting Started', 'question' => 'Is DomDrills free to use?', 'answer' => 'Reading articles, browsing the FAQ, and viewing the forum are free. Posting in the forum, using the trading journal, and live chat require a free account. 1-on-1 tutoring is a paid add-on.'],
            ['category' => 'Getting Started', 'question' => 'Do I need trading experience to join?', 'answer' => 'No. Our content spans complete beginner to advanced, and mentors can tailor 1-on-1 sessions to your level.'],
            ['category' => 'Tutoring', 'question' => 'How do I book a 1-on-1 session?', 'answer' => 'Head to the Tutoring page, pick a plan, and submit the request form. A mentor will follow up by email within 24 hours to schedule your session.'],
            ['category' => 'Tutoring', 'question' => 'Can I cancel or reschedule?', 'answer' => 'Yes — just reply to your confirmation email or reach out via live chat and we will find a new time.'],
            ['category' => 'Trading Journal', 'question' => 'What should I log for each trade?', 'answer' => 'At minimum: symbol, direction, entry/exit price, size, and a note on your reasoning. The more consistent your notes, the more useful your journal becomes over time.'],
            ['category' => 'Trading Journal', 'question' => 'Is my journal data private?', 'answer' => 'Yes. Your trades are only visible to you and site administrators for support purposes.'],
        ];

        foreach ($faqs as $i => $data) {
            Faq::firstOrCreate(
                ['question' => $data['question']],
                ['category' => $data['category'], 'answer' => $data['answer'], 'order' => $i]
            );
        }

        ChatRoom::firstOrCreate(
            ['slug' => 'live-help'],
            ['name' => 'Live Help - Ask a Doubt', 'type' => 'live_help', 'created_by' => $admin->id]
        );

        $this->command?->info('Seeded admin@domdrills.test / mentor@domdrills.test / trader@domdrills.test (password: "password")');
    }
}
