<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Content;
use App\Models\Item;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

/**
 * Authority content (Nov 2026): real articles drawn from Modupe's LinkedIn writing, verified speaking
 * engagements and corrected credentials. Safe to re-run: it updates by title and never deletes.
 * Sample articles are moved to draft (not deleted) so they can be restored or removed from the admin.
 */
class AuthorityContentSeeder extends Seeder
{
    public function run(): void
    {
        $this->articles();
        $this->engagements();
        $this->credentials();
        $this->homeOrder();
        $this->careerArt();
        $this->careerWording();
        $this->affiliationLogos();
        $this->momentStories();
        $this->recognitionDetails();
        Content::where('key', 'profile.portrait_note')->where('value', 'Concept portrait')->update(['value' => '']);
        Cache::forget('contents');
    }

    private function articles(): void
    {
        $articles = [
            [
                'title' => 'Transgenerational law firm practice in Nigeria',
                'category' => 'institution-building',
                'cover' => 'images/generated/article-institutions.webp',
                'featured' => true,
                'date' => '2026-06-10',
                'url' => 'https://lnkd.in/enFrGWpX',
                'excerpt' => 'Most Nigerian law firms are built around remarkable founders. Building one that thrives for generations is a deliberate design choice, and a responsibility shared by partners and emerging leaders alike.',
                'body' => <<<'MD'
                Prepared for the plenary session “Building a Transgenerational Law Practice: The Pros and Cons” at the Christian Lawyers Fellowship of Nigeria (CLASFON) South West Regional Conference in Abeokuta, where Modupe represented her Senior Partner, Etigwe Uwa, SAN.

                ## Why so few firms outlive their founders

                Many of the most respected firms in our market were built on the reputation, relationships and judgement of one or two exceptional individuals. That is a strength in the early years and a risk in the later ones. When decisions, client loyalty and institutional knowledge all sit with the founder, the firm’s future is only as long as that founder’s career.

                ## What a transgenerational firm does differently

                It separates the institution from the individual. Governance is written down and shared. Client relationships are held by teams, not personalities. Talent is developed deliberately, with clear pathways to partnership and leadership. And the firm invests in the operating systems, finance, people and technology, that let good lawyers do great work consistently.

                > Building for longevity begins long before anyone plans to leave.

                ## Legacy is a shared endeavour

                Building a transgenerational law firm is not the responsibility of partners alone. Leadership must be intentional in creating pathways, investing in people and genuinely making room for the next generation. Emerging leaders, in turn, must be intentional about developing the capabilities, credibility and track record required to assume greater responsibility.

                ## Read the full paper

                The full nine-page article is available on LinkedIn. A follow-up piece on the role employees and emerging leaders play in building enduring institutions is in preparation.
                MD,
            ],
            [
                'title' => 'From billable hours to value: client retention in the age of AI',
                'category' => 'professional-services',
                'cover' => 'images/generated/article-operations.webp',
                'featured' => false,
                'date' => '2026-10-12',
                'url' => null,
                'excerpt' => 'The future of law firms will not be decided by how much AI they adopt, but by how effectively they rethink the way they deliver value. Three reflections from the IBA Annual Conference 2026 in Copenhagen.',
                'body' => <<<'MD'
                At the IBA Annual Conference 2026 in Copenhagen, Modupe led the Client Retention roundtable in the Law Firm Management Committee’s World Café, “Who Holds the Crystal Ball? Future-Proof Planning for Small and Medium-Sized Law Firms”. Her contribution drew on a survey of 70 Nigerian legal practitioners on AI adoption.

                ## From billable hours to value

                AI may reduce the time it takes to deliver legal services, but it does not diminish the value of professional judgement, risk management and strategic counsel. The question for every firm is whether its pricing models are keeping pace.

                ## From relationships to relevance

                Longstanding relationships are valuable, but no longer sufficient. Clients increasingly expect advisers who understand their businesses, anticipate risks and contribute to commercial outcomes.

                ## From individual relationships to institutional capability

                Sustainable client retention cannot depend solely on individual partners. It requires deliberate strategy, institutional knowledge, operational excellence and a consistent client experience.

                > Client retention must become a deliberate strategic priority, not an assumed consequence of good relationships or excellent legal work.

                ## What it means for leaders

                As clients bring AI into their own organisations, they are not only changing how they operate. They are redefining what they expect from their external advisers. Firms that treat retention as a system, not a by-product, will be the ones those clients keep.
                MD,
            ],
            [
                'title' => 'Sustainable growth is designed. It does not happen by accident.',
                'category' => 'governance-succession',
                'cover' => 'images/authority/case-roundtable.webp',
                'featured' => false,
                'date' => '2026-09-10',
                'url' => 'http://bit.ly/ALANMPR5',
                'excerpt' => 'Reflections from ALAN’s fifth Managing Partners’ Roundtable, “The Scalable Law Firm: The New Equation for Thriving”, and the questions every firm leader should be asking after the room empties.',
                'body' => <<<'MD'
                On 3 September 2026, the Association of Law Firm Administrators Nigeria convened its fifth Managing Partners’ Roundtable (MPR 5.0) in Lagos, themed “The Scalable Law Firm: The New Equation for Thriving”.

                ## The law firm of the future needs a new operating model

                Growth remains important. But sustainable growth requires more than increased revenue, larger teams or a broader client base. It requires the deliberate design of institutions that can scale with discipline, preserve their culture, attract and develop exceptional talent, use technology intelligently, strengthen governance and ultimately outlive individual leaders.

                > Sustainable growth is designed. It does not happen by accident.

                ## Seven conversations that matter

                The Roundtable worked through governance, leadership, economics, talent, technology, systems and succession: the seven levers that decide whether a firm simply grows or genuinely scales.

                ## The work that begins after the room empties

                What will we rethink? What will we redesign? What will we do differently? As custodians of our institutions, leaders have a responsibility to build firms that are stronger, smarter and more enduring for the generations that follow.

                ## Watch the conversation

                The full MPR 5.0 conversation is available to watch online.
                MD,
            ],
            [
                'title' => 'Growth is an outcome. Scaling is a capability.',
                'category' => 'institution-building',
                'cover' => 'images/authority/case-journal.webp',
                'featured' => false,
                'date' => '2026-10-28',
                'url' => 'https://lnkd.in/e3FqQiY9',
                'excerpt' => 'ALAN’s MPR 5.0 White Paper takes the Roundtable beyond the event: practical insight, independent regulatory research and comparative market evidence for building sustainable, resilient law firms.',
                'body' => <<<'MD'
                The conversations from MPR 5.0 continue beyond the Roundtable. ALAN’s official White Paper translates the insights shared by managing partners, industry leaders and business experts into a resource for continued dialogue, strategic reflection and action.

                ## The central question

                How can law firms move beyond growth to build institutions capable of scaling sustainably?

                ## What the White Paper covers

                Key insights and perspectives from the Roundtable, supported by independent regulatory research and comparative legal-market evidence, organised around the practical decisions firm leaders face: structure, governance, economics, people and technology.

                > Growth is an outcome; scaling is a capability.

                ## Download

                The full White Paper is available to download from ALAN.
                MD,
            ],
            [
                'title' => 'What law firms really look for when they hire',
                'category' => 'people-performance',
                'cover' => 'images/generated/article-next-generation.webp',
                'featured' => false,
                'date' => '2026-08-27',
                'url' => null,
                'excerpt' => 'Technical knowledge of the law is the entry ticket. The differentiator is how effectively you translate that knowledge into value: notes from the DealHQ Partners 2026 Virtual Career Fair.',
                'body' => <<<'MD'
                Modupe joined the DealHQ Partners 2026 Virtual Career Fair as a panelist on “Recruiters’ Secrets: What Law Firms and Companies Really Look for When Hiring”, under the theme “Future-Ready Counsel: Building Distinctive Legal Careers in a Changing World”.

                ## More than knowledge of the law

                Excellence in the practice of law remains fundamental. But lawyers are increasingly expected to understand the business of law and the commercial environment in which their clients and organisations operate.

                ## What employers are looking for

                Legal competence combined with commercial awareness, effective communication, sound judgement, adaptability, client orientation and an understanding of how their work contributes to broader business objectives.

                > The differentiator is not simply what you know, but how effectively you translate that knowledge into value.

                ## For the next generation

                Understanding the intersection between the practice and the business of law is becoming one of the most important foundations of a relevant, future-ready legal career.
                MD,
            ],
        ];

        foreach ($articles as $a) {
            Article::updateOrCreate(['slug' => Str::slug($a['title'])], [
                'title' => $a['title'],
                'category' => $a['category'],
                'excerpt' => $a['excerpt'],
                'body' => trim(preg_replace('/^ {16}/m', '', $a['body'])),
                'cover_image' => $a['cover'],
                'external_url' => $a['url'],
                'status' => 'published',
                'is_featured' => $a['featured'],
                'is_sample' => false,
                'published_at' => $a['date'],
                'seo_description' => Str::limit($a['excerpt'], 290),
            ]);
        }

        // Only one featured article: the transgenerational paper.
        Article::where('is_featured', true)->where('slug', '!=', Str::slug($articles[0]['title']))->update(['is_featured' => false]);
        Article::where('is_sample', true)->where('status', 'published')->update(['status' => 'draft']);
    }

    private function engagements(): void
    {
        $rows = [
            ['2026-10-06', 'Who Holds the Crystal Ball? Future-proof planning for small and medium-sized law firms', 'Roundtable lead, Client Retention · IBA Annual Conference 2026, Copenhagen', 'Led the Client Retention roundtable in the Law Firm Management Committee World Café, drawing on a survey of 70 Nigerian legal practitioners on AI.', null],
            ['2026-10-04', 'IBA Law Firm Management Committee pre-conference retreat', 'Participant · IBA LFMC, hosted by Gorrissen Federspiel, Copenhagen', 'Closed-door retreat for law firm management leaders ahead of the IBA Annual Conference.', null],
            ['2026-10-04', 'The High Tide Conference', 'Delegate · IBA LFMC BD & Marketing Professionals, Copenhagen', 'Moving from AI experimentation to sustainable adoption in law firms.', null],
            ['2026-09-03', 'MPR 5.0: The Scalable Law Firm, the New Equation for Thriving', 'Convener and host · ALAN Managing Partners’ Roundtable, Lagos', 'The fifth Managing Partners’ Roundtable, bringing managing partners, SANs and business leaders together on governance, economics, talent, technology and succession.', 'http://bit.ly/ALANMPR5'],
            ['2026-08-27', 'Recruiters’ Secrets: what law firms and companies really look for when hiring', 'Panelist · DealHQ Partners 2026 Virtual Career Fair', 'The practice and the business of law, and the commercial awareness employers now expect from young lawyers.', null],
            ['2026-07-11', 'The New Tax Order', 'Host · ALAN Learning & Development Committee webinar', 'A professional development session for law firm administrators and leaders on Nigeria’s new tax regime.', null],
            ['2025-06-14', 'Building a Transgenerational Law Practice: The Pros and Cons', 'Plenary speaker · CLASFON South West Regional Conference, Abeokuta', 'Represented Senior Partner Etigwe Uwa, SAN, presenting the paper “Transgenerational Law Firm Practice in Nigeria”.', 'https://lnkd.in/enFrGWpX'],
        ];

        foreach ($rows as $i => [$date, $title, $subtitle, $body, $url]) {
            Item::updateOrCreate(['type' => 'engagements', 'title' => $title], [
                'subtitle' => $subtitle, 'body' => $body, 'date' => $date, 'url' => $url,
                'sort_order' => $i, 'is_published' => true,
            ]);
        }
    }

    private function credentials(): void
    {
        $fixes = [
            'MSc, Industrial & Labour Relations' => ['title' => 'MSc, Industrial Relations & Personnel Management', 'subtitle' => 'University of Lagos'],
        ];
        foreach ($fixes as $old => $new) {
            Item::where('type', 'credentials')->where('title', $old)->update($new);
        }
        Item::firstOrCreate(['type' => 'credentials', 'title' => 'BSc, Economics'], [
            'subtitle' => 'Babcock University', 'icon' => 'book', 'sort_order' => 1, 'is_published' => true,
        ]);
    }

    /** Give career stops and offers their engraved illustrations, unless one was already chosen in the admin. */
    private function careerArt(): void
    {
        foreach (config('collections.offers.seed', []) as $row) {
            Item::where('type', 'offers')->where('title', $row['title'])->where(fn ($q) => $q->whereNull('image')->orWhere('image', ''))
                ->update(['image' => $row['image'] ?? null]);
        }
        foreach (config('collections.career.seed', []) as $row) {
            Item::where('type', 'career')->where('subtitle', $row['subtitle'])->where(fn ($q) => $q->whereNull('image')->orWhere('image', ''))
                ->update(['image' => $row['image'] ?? null]);
        }
    }

    /** Put the new authority sections in their designed order if an older saved order exists. */
    private function homeOrder(): void
    {
        $saved = Content::find('home.sections');
        // Apply only to an order saved before the redesign, or to the first redesign order (photo reel after Speaking).
        $firstDraft = 'affiliations:1,proof:1,meet:1,journey:1,work:1,offers:1,idea:1,speaking:1,moments:1,impact:1,insights:1,mentorship:1,testimonials:1,book:1,cta:1';
        if (! $saved || (str_contains((string) $saved->value, 'proof:') && $saved->value !== $firstDraft)) {
            return;
        }
        $saved->update(['value' => config('content.groups.home.fields.sections.default') ?? $saved->value]);
    }

    /** Update the first-draft career highlights to the figure-led wording, only where the text is still the original. */
    private function careerWording(): void
    {
        $from = ['from its eight partners,', 'restructured delivery and digitised the firm’s workflows.'];
        $to = ['from its 8 partners,', 'restructured delivery, digitised the firm’s workflows and lifted productivity by 82%.'];
        Item::where('type', 'career')->get()->each(function (Item $item) use ($from, $to) {
            $body = str_replace($from, $to, (string) $item->body);
            if ($body !== $item->body) {
                $item->update(['body' => $body]);
            }
        });
    }

    /** Attach logos saved in public/images/logos to affiliations that have no logo yet. */
    private function affiliationLogos(): void
    {
        $logos = [
            'Streamsowers & Köhn' => 'ssk',
            'Association of Law Firm Administrators Nigeria' => 'alan',
            'International Bar Association' => 'iba',
            'KPMG Nigeria' => 'kpmg',
            'Olajide Oyewole LLP · DLA Piper Africa' => 'dla-piper',
            'Harvard Business School' => 'harvard-business-school',
            'MIT Sloan' => 'mit-sloan',
            'The George Washington University' => 'gwu',
        ];
        foreach ($logos as $title => $slug) {
            $file = collect(['svg', 'png', 'webp'])->map(fn ($ext) => "images/logos/{$slug}.{$ext}")
                ->first(fn ($path) => is_file(public_path($path)));
            if ($file) {
                Item::where('type', 'affiliations')->where('title', $title)
                    ->where(fn ($q) => $q->whereNull('image')->orWhere('image', ''))
                    ->update(['image' => $file]);
            }
        }
    }

    /** Logos and short stories for the recognition cards, only where the admin has not set them. */
    private function recognitionDetails(): void
    {
        $details = [
            'Association of Law Firm Administrators Nigeria' => ['alan', 'Elected by her peers to lead the body that professionalises the business side of Nigerian law firms.'],
            'International Bar Association' => ['iba', 'Invited to speak on the business of law at the world’s largest gathering of the legal profession.'],
            'IBA Law Firm Management Committee' => ['iba', 'Connecting African law firm leaders to the IBA’s global work on firm management.'],
            'Harvard Business School Online' => [null, 'Executive study in leading organisations through growth and change.'],
        ];
        foreach ($details as $org => [$slug, $story]) {
            $file = $slug ? collect(['svg', 'png', 'webp'])->map(fn ($ext) => "images/logos/{$slug}.{$ext}")
                ->first(fn ($path) => is_file(public_path($path))) : null;
            $q = fn () => Item::where('type', 'recognition')->where('subtitle', $org);
            if ($file) $q()->where(fn ($w) => $w->whereNull('image')->orWhere('image', ''))->update(['image' => $file]);
            $q()->where(fn ($w) => $w->whereNull('body')->orWhere('body', ''))->update(['body' => $story]);
        }
        // The Harvard wordmark is too wide to read at row size, so that row uses its icon instead.
        Item::where('type', 'recognition')->where('image', 'images/logos/harvard-business-school.png')->update(['image' => null]);
        Item::where('type', 'recognition')->where('title', 'Award or honour to be added')
            ->where(fn ($w) => $w->whereNull('body')->orWhere('body', ''))
            ->update(['body' => 'Placeholder: add an award, fellowship or appointment here, with one line on why it matters.']);
    }

    /** Placeholder stories for the sample photos, so the back of each print has something to read until real ones are added. */
    private function momentStories(): void
    {
        $stories = [
            'keynote' => 'Placeholder story: a keynote on why firms that plan their succession early grow faster, and what managing partners can change this year. Replace with the real event, date and a line on what she said.',
            'panel' => 'Placeholder story: a panel on succession planning with managing partners and HR leaders, on moving from founder-led decisions to shared governance. Replace with the real event.',
            'cohort' => 'Placeholder story: the opening session of a mentorship cohort, setting goals and accountability partners for the six months ahead. Replace with the real cohort and date.',
            'fireside' => 'Placeholder story: a fireside conversation with managing partners on building firms that outlast their founders. Replace with the real event.',
            'workshop' => 'Placeholder story: a hands-on workshop on firm operations, mapping how work moves from instruction to delivery and where it stalls. Replace with the real event.',
            'evening' => 'Placeholder story: an evening recognising excellence in law firm management. Replace with the real event, the award and the date.',
        ];
        Item::where('type', 'moments')->where(fn ($q) => $q->whereNull('body')->orWhere('body', ''))->get()->each(function (Item $item) use ($stories) {
            foreach ($stories as $key => $story) {
                if (str_contains((string) $item->image, $key)) {
                    $item->update(['body' => $story]);

                    return;
                }
            }
        });
    }
}
