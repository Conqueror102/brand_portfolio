<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Content;
use App\Models\Item;
use App\Models\Setting;
use App\Models\Testimonial;
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
        $this->clientFeedbackNov11();
        $this->realPhotos();
        $this->clientFeedbackNov20();
        $this->refinementBriefNov25();
        $this->briefArticleDrafts();
        Content::where('key', 'profile.portrait_note')->where('value', 'Concept portrait')->update(['value' => '']);
        Cache::forget('contents');
    }

    private function articles(): void
    {
        $articles = [
            [
                'title' => 'Transgenerational law firm practice in Nigeria',
                'category' => 'institutional-sustainability',
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
                'category' => 'future-of-work',
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
                'category' => 'institutional-sustainability',
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
                'category' => 'business-of-professional-services',
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
                'category' => 'leadership-execution',
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
            ['2026-10-30', 'The Growth Mandate: Leading Businesses Built to Scale and Last', 'Panellist, CEOs Roundtable · BeyondHR Conference 3.0, Lagos', 'A CEOs Roundtable on building businesses that scale and endure.', null],
            ['2026-10-06', 'Who Holds the Crystal Ball? Future-proof planning for small and medium-sized law firms', 'Roundtable lead, Client Retention · IBA Annual Conference 2026, Copenhagen', 'Led the Client Retention roundtable in the Law Firm Management Committee World Café, drawing on a survey of 70 Nigerian legal practitioners on AI.', null],
            ['2026-10-04', 'IBA Law Firm Management Committee pre-conference retreat', 'Participant · IBA LFMC, hosted by Gorrissen Federspiel, Copenhagen', 'Closed-door retreat for law firm management leaders ahead of the IBA Annual Conference.', null],
            ['2026-10-04', 'The High Tide Conference', 'Delegate · IBA LFMC BD & Marketing Professionals, Copenhagen', 'Moving from AI experimentation to sustainable adoption in law firms.', null],
            ['2026-09-03', 'MPR 5.0: The Scalable Law Firm, the New Equation for Thriving', 'Convener and host · ALAN Managing Partners’ Roundtable, Lagos', 'The fifth Managing Partners’ Roundtable, bringing managing partners, SANs and business leaders together on governance, economics, talent, technology and succession.', 'http://bit.ly/ALANMPR5'],
            ['2026-08-27', 'Recruiters’ Secrets: what law firms and companies really look for when hiring', 'Panellist · DealHQ Partners 2026 Virtual Career Fair', 'The practice and the business of law, and the commercial awareness employers now expect from young lawyers.', null],
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

    /**
     * Client feedback of 11 Nov 2026: title line, tagline and first-person intro in the hero, a clearer mentorship audience,
     * and the Key pillars section after Meet Modupe. Only replaces old defaults, never text edited in the admin.
     */
    private function clientFeedbackNov11(): void
    {
        $intro = 'A seasoned strategy and organisational development professional with over 20 years of experience helping law firms and professional services organisations build sustainable structures, strengthen leadership and achieve measurable growth.';
        $replace = [
            'home.hero_line1' => [['Building institutions'], 'Clarity for people.'],
            'home.hero_line2' => [['that outlast their founders.'], 'Continuity for institutions.'],
            'home.hero_summary' => [[
                'Two decades turning strategy into structure, and structure into results, for law firms and professional services organisations in Nigeria and beyond.',
                'I am a strategy and organisational development professional with over 20 years of experience helping law firms and professional services organisations build sustainable structures, strengthen leadership and achieve measurable growth.',
                'Modupe Olusoga is a seasoned strategy and organisational development professional with over 20 years of experience helping law firms and professional services organisations build sustainable structures, strengthen leadership and achieve measurable growth.',
            ], $intro],
            'mentorship.audience_title' => [['Built for people *ready to commit.*'], 'Who this programme *is for.*'],
            'mentorship.audience_text' => [['This is not a motivational course. It is designed to create clarity, intentional action, accountability, consistency and execution.'], config('content.groups.mentorship.fields.audience_text.default')],
        ];
        foreach ($replace as $key => [$old, $new]) {
            Content::where('key', $key)->whereIn('value', $old)->update(['value' => $new]);
        }

        if (! Item::where('type', 'pillars')->exists()) {
            foreach (config('collections.pillars.seed', []) as $position => $row) {
                Item::create($row + ['type' => 'pillars', 'sort_order' => $position, 'is_published' => true]);
            }
        }

        $saved = Content::find('home.sections');
        if ($saved && ! str_contains((string) $saved->value, 'pillars:')) {
            $value = preg_replace('/(meet:[01])/', '$1,pillars:1', (string) $saved->value, 1, $count);
            $saved->update(['value' => $count ? $value : $saved->value.',pillars:1']);
        }
    }

    /**
     * Client feedback, 20 Nov 2026: speaker profile download, short video section, coaching certificate
     * placeholder and her LinkedIn. Only fills values the admin has not already set.
     */
    private function clientFeedbackNov20(): void
    {
        $replace = [
            'speaking.profile_link_label' => [['Download the speaker bio', ''], 'Download speaker profile'],
            'speaking.profile_link' => [[''], '/files/speaker-profile.pdf'],
        ];
        foreach ($replace as $key => [$old, $new]) {
            Content::where('key', $key)->where(fn ($q) => $q->whereIn('value', $old)->orWhereNull('value'))->update(['value' => $new]);
        }

        $saved = Content::find('home.sections');
        if ($saved && ! str_contains((string) $saved->value, 'video:')) {
            $value = preg_replace('/(speaking:[01])/', '$1,video:1', (string) $saved->value, 1, $count);
            $saved->update(['value' => $count ? $value : $saved->value.',video:1']);
        }

        // Her coaching certificate (CTA-CPC, Coach Transformation Academy, 6 July 2025), replacing the placeholder.
        Item::where('type', 'credentials')->where('title', 'Certified Coach')
            ->whereIn('subtitle', ['Professional coaching certification', 'Certificate name to be confirmed'])
            ->update(['title' => 'Certified Professional Coach (CTA-CPC)', 'subtitle' => 'Coach Transformation Academy, 2025', 'icon' => 'award']);

        // 23 Nov: the Facebook link first sent was cut short.
        if (Setting::get('facebook_url') === 'https://www.facebook.com/dupe.oluso') {
            Setting::put(['facebook_url' => config('site.settings.facebook_url')]);
        }

        // Her social profiles, sent 20 Nov. Only fills a slot the admin has left empty.
        foreach (['linkedin_url', 'instagram_url', 'facebook_url'] as $key) {
            if (trim((string) Setting::get($key)) === '') {
                Setting::put([$key => config('site.settings.'.$key)]);
            }
        }
    }

    /** Real photographs of Modupe (11 Nov 2026) replace the generated placeholders, only where the admin still has the old image. */
    private function realPhotos(): void
    {
        $replace = [
            'profile.portrait' => [['images/editorial-portrait.png', 'images/portraits/hero-cutout.webp', 'images/portraits/hero-blue-suit.webp', 'images/portraits/hero-navy.webp'], 'images/portraits/hero-navy-chair.webp'],
            'profile.portrait_alt' => [['Generated concept portrait for design preview; to be replaced with Modupe’s photograph'], 'Portrait of Modupe Olusoga'],
            'home.idea_photo' => [['images/generated/reel-keynote.webp'], 'images/portraits/alan-investiture-crop.webp'],
            'home.mentorship_image' => [['images/generated/mentorship-home.webp', 'images/portraits/mentorship-portrait.webp', 'images/portraits/mentorship-blue-suit.webp', 'images/portraits/mentorship-portrait-dark.webp'], 'images/portraits/mentorship-cream-blazer.webp'],
            'mentorship.image' => [['images/generated/mentorship-conversation.webp', 'images/portraits/mentorship-portrait.webp', 'images/portraits/mentorship-blue-suit.webp', 'images/portraits/mentorship-portrait-dark.webp'], 'images/portraits/mentorship-cream-blazer.webp'],
        ];
        foreach ($replace as $key => [$old, $new]) {
            Content::where('key', $key)->whereIn('value', $old)->update(['value' => $new]);
        }

        $photo = 'images/portraits/alan-investiture.webp';
        if (! Item::where('type', 'moments')->where('image', $photo)->exists()) {
            Item::where('type', 'moments')->increment('sort_order');
            Item::create([
                'type' => 'moments', 'image' => $photo, 'sort_order' => 0, 'is_published' => true,
                'title' => 'ALAN investiture ceremony',
                'subtitle' => 'Association of Law Firm Administrators Nigeria',
                'body' => 'Reading the programme at the Association of Law Firm Administrators Nigeria investiture ceremony.',
            ]);
        }
    }

    /**
     * Refinement brief, 25 Nov 2026: first-person voice, her new opening, no confidential firm figures, no generated
     * photographs presented as real events, exact speaking roles, booking FAQ, Leadership in Practice, mentorship facts
     * and a hidden book date and cover. Replaces only values that still hold the earlier launch default; never deletes.
     */
    private function refinementBriefNov25(): void
    {
        $before = require __DIR__.'/data/before_brief_nov25.php';

        // Page wording: move every untouched old default to the new one.
        foreach ($before['content'] as $key => $old) {
            Content::where('key', $key)->where('value', $old)->update(['value' => config("content.fields.$key.default")]);
        }
        // Earlier hero intros that were saved before this round.
        Content::where('key', 'home.hero_summary')->whereIn('value', [
            'I am a strategy and organisational development professional with over 20 years of experience helping law firms and professional services organisations build sustainable structures, strengthen leadership and achieve measurable growth.',
            'Modupe Olusoga is a seasoned strategy and organisational development professional with over 20 years of experience helping law firms and professional services organisations build sustainable structures, strengthen leadership and achieve measurable growth.',
        ])->update(['value' => config('content.fields.home.hero_summary.default')]);
        // Generated scenes are replaced by real photographs wherever they are still in use.
        foreach (['home.meet_photo', 'speaking.image', 'impact.image', 'programmes.feature_image'] as $key) {
            Content::where('key', $key)->where('value', 'like', 'images/generated/%')->update(['value' => config("content.fields.$key.default")]);
        }

        // Lists: update seeded rows that nobody has edited, matching on the fields the old seed set.
        $new = config('collections');
        foreach ($before['items'] as $type => $rows) {
            foreach ($rows as $i => $old) {
                $target = collect($new[$type]['seed'])->firstWhere('title', $old['title'])
                    ?? ($type === 'speaking_topics' && $old['title'] === 'From aspiration to execution' ? $new[$type]['seed'][4] : null)
                    ?? (in_array($type, ['career', 'case_studies', 'recognition', 'credentials'], true) ? ($new[$type]['seed'][$i] ?? null) : null);
                $query = Item::where('type', $type);
                foreach (['title', 'subtitle', 'body', 'category'] as $field) {
                    if (array_key_exists($field, $old)) {
                        $query->where($field, $old[$field]);
                    }
                }
                if ($target) {
                    $query->update(array_intersect_key($target, array_flip(['title', 'subtitle', 'body', 'category'])));
                } elseif ($type === 'proof_stats') {
                    // Firm performance figures (82%, 35%, 40%) are confidential: hide them, keep them in the admin.
                    $query->update(['is_published' => false]);
                }
            }
        }
        // Credentials the admin added earlier get a group so the About page can split them.
        Item::where('type', 'credentials')->where(fn ($q) => $q->whereNull('category')->orWhere('category', ''))->get()->each(function (Item $item) {
            $item->update(['category' => preg_match('/^(BSc|MSc|BA|MA|MBA|PhD|LLB|LLM)\b/i', $item->title) ? 'education' : 'development']);
        });
        // Any career highlight still carrying the productivity figure.
        Item::where('type', 'career')->where('body', 'like', '%lifted productivity by 82%')->update(['body' => collect($new['career']['seed'])->firstWhere('subtitle', 'Streamsowers & Köhn')['body']]);

        // New topics, booking FAQ and Leadership in Practice.
        foreach (['speaking_topics', 'speaking_faqs', 'practice'] as $type) {
            foreach ($new[$type]['seed'] as $position => $row) {
                Item::firstOrCreate(['type' => $type, 'title' => $row['title']], $row + ['sort_order' => $position, 'is_published' => true]);
            }
        }
        Item::where('type', 'speaking_topics')->where('title', 'Leading with quiet confidence')->update(['sort_order' => 7]);

        // Proof figures she will supply. Hidden until a real number is entered and the row is switched on.
        foreach (['Speaking engagements, panels and roundtables', 'Professionals mentored', 'Mentorship programmes run'] as $position => $label) {
            Item::firstOrCreate(['type' => 'proof_stats', 'subtitle' => $label], [
                'title' => '0', 'body' => 'Figure to be confirmed by Modupe', 'sort_order' => 10 + $position, 'is_published' => false,
            ]);
        }

        // Sample testimonials are not real people: hidden until real, permitted testimonials are added.
        Testimonial::where('is_sample', true)->update(['is_published' => false]);

        // Generated photographs of events that never happened leave the photo reel.
        Item::where('type', 'moments')->where('image', 'like', 'images/generated/%')->update(['is_published' => false]);

        // Logos are shown only where their use is authorised. The files stay in the media folder for later.
        Item::where('type', 'affiliations')->whereIn('title', ['Streamsowers & Köhn', 'KPMG Nigeria', 'Olajide Oyewole LLP · DLA Piper Africa', 'Harvard Business School', 'MIT Sloan', 'The George Washington University'])
            ->where('image', 'like', 'images/logos/%')->update(['image' => null]);

        // Recognition story that described the IBA engagement as a talk.
        Item::where('type', 'recognition')->where('body', 'Invited to speak on the business of law at the world’s largest gathering of the legal profession.')
            ->update(['body' => 'Led the Client Retention roundtable in the Law Firm Management Committee’s World Café at the IBA Annual Conference.']);

        // Mentorship facts confirmed by Modupe, filled only where the admin still has the old defaults.
        $cohort = [
            'mentorship_cohort' => ['Inaugural cohort'], 'mentorship_year' => [''], 'mentorship_timezone' => [''],
            'mentorship_opening' => ['In person, mid-January'], 'mentorship_closing' => ['In person, July'],
            'mentorship_capacity' => [''], 'mentorship_start' => [''], 'applications_close_on' => [''],
        ];
        foreach ($cohort as $key => $old) {
            if (in_array((string) Setting::get($key), $old, true)) {
                Setting::put([$key => config("site.settings.$key")]);
            }
        }
    }

    /**
     * The three launch articles named in the brief, as drafts for her approval. firstOrCreate: once she edits or
     * publishes one in the admin, the seeder never touches it again.
     */
    private function briefArticleDrafts(): void
    {
        $drafts = [
            ['From Operational Support to Strategic Influence: Redefining Law Firm Administration', 'business-of-professional-services', 'images/generated/article-operations.webp',
                'Law firm administration is still too often treated as back-office support. The firms that will last treat it as a strategic function, with a seat where decisions are made.',
                "## Draft for Modupe’s review\n\nReplace this outline with the final article before publishing.\n\n## From support to strategy\n\nWhy the business side of a firm shapes client service, talent and growth as much as the practice does.\n\n## What strategic administration looks like\n\nGovernance, finance, people and technology led by professionals who sit close to decisions.\n\n## What managing partners can do now\n\nPractical steps to give the business function the mandate and the measures it needs."],
            ['The Currency of Professional Relationships', 'leadership-execution', 'images/generated/article-succession.webp',
                'Careers and institutions are built on relationships of trust. Like any currency, they grow with deliberate investment and lose value through neglect.',
                "## Draft for Modupe’s review\n\nReplace this outline with the final article before publishing.\n\n## Relationships as an asset\n\nWhy trust compounds over a career, and why it cannot be built in a hurry.\n\n## Investing deliberately\n\nGenerosity, consistency and follow-through as daily habits.\n\n## Protecting the balance\n\nHow credibility is lost, and how it is rebuilt."],
            ['Career Transitions: Knowing When and How to Move', 'leadership-execution', 'images/generated/article-execution.webp',
                'Every career reaches moments where staying and moving both carry risk. Knowing which one serves your long-term goals takes clarity, honesty and a plan.',
                "## Draft for Modupe’s review\n\nReplace this outline with the final article before publishing.\n\n## Signals that it is time\n\nGrowth, values and the difference between a hard season and the wrong place.\n\n## Moving well\n\nPreparing, negotiating and leaving in a way that protects your relationships.\n\n## The first ninety days\n\nHow to establish credibility quickly in a new role."],
        ];
        foreach ($drafts as [$title, $category, $cover, $excerpt, $body]) {
            Article::firstOrCreate(['slug' => Str::slug($title)], [
                'title' => $title, 'category' => $category, 'excerpt' => $excerpt, 'body' => $body, 'cover_image' => $cover,
                'status' => 'draft', 'is_featured' => false, 'is_sample' => false, 'seo_description' => $excerpt,
            ]);
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
        // Retired by the refinement brief of 25 Nov 2026: no firm performance figures on the site.
        $from = ['from its eight partners,'];
        $to = ['from its partners,'];
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
        // Only bodies whose logo use is authorised (brief, 25 Nov 2026). Others show their typeset name until approved.
        $logos = [
            'Association of Law Firm Administrators Nigeria' => 'alan',
            'International Bar Association' => 'iba',
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
