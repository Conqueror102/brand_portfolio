<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Testimonial;
use Illuminate\Database\Seeder;

/**
 * Placeholder articles and testimonials so every section can be reviewed before real content exists.
 * Each record is flagged is_sample, shown with a "Sample" label, and can be deleted from the admin.
 */
class SampleContentSeeder extends Seeder
{
    public function run(): void
    {
        $articles = [
            ['From founder-dependent to future-ready: building a firm that outlasts its founders', 'institution-building', 'Most professional services firms are built around remarkable individuals. The harder work is designing an institution that can thrive without them.', true, 'images/generated/article-institutions.webp'],
            ['Succession is a system, not a moment', 'governance-succession', 'Leadership transitions fail when they are treated as events. They succeed when they are designed years in advance.', false, 'images/generated/article-succession.webp'],
            ['The quiet operations behind exceptional client service', 'people-performance', 'Clients see the advice. They feel the operations: the responsiveness, the consistency and the people behind both.', false, 'images/generated/article-operations.webp'],
            ['Why aspiration stalls, and the discipline that moves it', 'intentional-execution', 'Most goals do not fail for lack of desire. They fail for lack of clarity, structure and consistent action.', false, 'images/generated/article-execution.webp'],
            ['What the next generation of lawyers expects from the firm', 'professional-services', 'Talent now evaluates firms the way firms evaluate clients: on purpose, development and the quality of leadership.', false, 'images/generated/article-next-generation.webp'],
            ['Leading with quiet confidence', 'leadership', 'Substance outlasts visibility. The leaders institutions remember are the ones who built what others could continue.', false, 'images/generated/article-confidence.webp'],
        ];

        foreach ($articles as $i => [$title, $category, $excerpt, $featured, $cover]) {
            Article::updateOrCreate(['title' => $title], [
                'category' => $category,
                'excerpt' => $excerpt,
                'body' => $this->body($excerpt),
                'cover_image' => $cover,
                'status' => 'published',
                'is_featured' => $featured,
                'is_sample' => true,
                'published_at' => now()->subDays(6 + $i * 9),
            ]);
        }

        $testimonials = [
            ['Modupe brought a rare combination of structure and warmth to our partners’ retreat. We left with decisions, not just discussions.', 'speaking'],
            ['She asks the questions that move you from intention to action, and then she holds you to the answers.', 'mentorship'],
            ['Her session on succession reframed how our leadership team thinks about the firm we are building for the next generation.', 'speaking'],
        ];

        foreach ($testimonials as $i => [$quote, $context]) {
            Testimonial::updateOrCreate(['quote' => $quote], [
                'name' => 'Sample reviewer',
                'role' => 'Role to be confirmed',
                'organisation' => 'Organisation',
                'context' => $context,
                'is_published' => true,
                'is_featured' => true,
                'is_sample' => true,
                'sort_order' => $i,
            ]);
        }
    }

    private function body(string $excerpt): string
    {
        return <<<TXT
        {$excerpt}

        This is sample text so the article layout can be reviewed. Replace it from the admin with the final, approved article.

        ## The challenge

        Institutions are rarely undone by a single decision. They are shaped by the habits that accumulate when growth outpaces structure: decisions that depend on one person, knowledge that lives in a few heads, and a culture that has never been written down.

        > Building for longevity begins long before anyone plans to leave.

        ## What changes the outcome

        Clarity about what the organisation is for. Governance that distributes decisions. Leadership pipelines that are deliberate rather than accidental. And people who are developed, not merely deployed.

        ## A closing thought

        The work is rarely glamorous, but it compounds. Every structure put in place today is a decision the next generation will not have to make alone.
        TXT;
    }
}
