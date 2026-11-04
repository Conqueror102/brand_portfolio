<?php

/*
| Repeatable lists edited under Admin → Lists. Each type names the fields it uses and their labels.
| "pages" => true gives each item its own public page (podcast episodes).
| "seed" is the launch content, added once by the SiteContentSeeder.
*/

$icons = ['columns', 'relay', 'compass', 'people', 'steps', 'spark', 'mic', 'panel', 'workshop', 'retreat', 'book', 'scale', 'globe', 'heart', 'star', 'calendar', 'clock', 'mail', 'eye', 'video', 'headphones', 'file', 'download', 'play', 'check', 'home', 'pin', 'lock', 'quote', 'search', 'settings', 'inbox'];

return [
    'speaking_topics' => [
        'label' => 'Speaking topics', 'group' => 'Speaking', 'icon' => 'mic',
        'help' => 'Shown on the Speaking page; the first four also appear on the homepage.',
        'fields' => ['title' => 'Topic', 'body' => 'Description', 'subtitle' => 'Audience takeaway', 'icon' => 'Icon'],
        'seed' => [
            ['icon' => 'columns', 'title' => 'Building the transgenerational firm', 'body' => 'Moving from founder-dependent practices to institutions designed for longevity.'],
            ['icon' => 'relay', 'title' => 'Governance and succession', 'body' => 'Leadership pipelines, ownership transitions and the structures that make continuity possible.'],
            ['icon' => 'compass', 'title' => 'The future of professional services', 'body' => 'Technology, AI, talent and the business of running a modern firm.'],
            ['icon' => 'people', 'title' => 'People and organisational performance', 'body' => 'Culture, talent development and the operating rhythm of effective organisations.'],
            ['icon' => 'steps', 'title' => 'From aspiration to execution', 'body' => 'Clarity, discipline and consistency for professionals ready to do the work.'],
            ['icon' => 'spark', 'title' => 'Leading with quiet confidence', 'body' => 'Substance, credibility and the leadership habits that outlast a single role.'],
        ],
    ],
    'speaking_formats' => [
        'label' => 'Speaking formats', 'group' => 'Speaking', 'icon' => 'panel',
        'fields' => ['title' => 'Format', 'icon' => 'Icon'],
        'seed' => [
            ['icon' => 'mic', 'title' => 'Keynotes'],
            ['icon' => 'panel', 'title' => 'Panels and moderation'],
            ['icon' => 'workshop', 'title' => 'Workshops'],
            ['icon' => 'retreat', 'title' => 'Partner and leadership retreats'],
        ],
    ],
    'speaking_audiences' => [
        'label' => 'Speaking audiences', 'group' => 'Speaking', 'icon' => 'people',
        'fields' => ['title' => 'Audience'],
        'seed' => [
            ['title' => 'Founders, managing partners and senior leaders of law firms and professional services organisations.'],
            ['title' => 'Boards and executives focused on governance, succession and organisational effectiveness.'],
            ['title' => 'Professional bodies, associations and conference organisers.'],
            ['title' => 'Business professionals and emerging leaders in professional services.'],
        ],
    ],
    'engagements' => [
        'label' => 'Speaking engagements', 'group' => 'Speaking', 'icon' => 'calendar',
        'help' => 'Only add verified engagements. The section appears on the Speaking page once there is one.',
        'fields' => ['title' => 'Event', 'subtitle' => 'Organiser and role (e.g. Keynote, IBA Annual Conference)', 'date' => 'Date', 'body' => 'Short description', 'url' => 'Link', 'image' => 'Photo'],
        'seed' => [],
    ],
    'speaking_steps' => [
        'label' => 'How invitations work', 'group' => 'Speaking', 'icon' => 'check',
        'fields' => ['title' => 'Step', 'body' => 'Explanation', 'icon' => 'Icon'],
        'seed' => [
            ['icon' => 'mail', 'title' => 'Send the details', 'body' => 'Event, date, audience and what you hope people leave with.'],
            ['icon' => 'eye', 'title' => 'Personal review', 'body' => 'Your request is reviewed against availability and fit.'],
            ['icon' => 'calendar', 'title' => 'Confirm and shape', 'body' => 'We agree the format and tailor the session to your room.'],
        ],
    ],
    'credentials' => [
        'label' => 'Credentials', 'group' => 'Profile', 'icon' => 'scale',
        'help' => 'Education, certifications and executive education. Keep degrees and executive programmes distinct.',
        'fields' => ['title' => 'Credential', 'subtitle' => 'Detail', 'icon' => 'Icon'],
        'seed' => [
            ['icon' => 'book', 'title' => 'MSc, Industrial & Labour Relations', 'subtitle' => 'Postgraduate degree'],
            ['icon' => 'scale', 'title' => 'SPHRi', 'subtitle' => 'Senior Professional in Human Resources – International'],
            ['icon' => 'compass', 'title' => 'Certified Coach', 'subtitle' => 'Professional coaching certification'],
            ['icon' => 'globe', 'title' => 'Executive education', 'subtitle' => 'Harvard, MIT Sloan and George Washington University'],
        ],
    ],
    'organisations' => [
        'label' => 'Organisations & initiatives', 'group' => 'Impact', 'icon' => 'columns',
        'help' => 'Shown on Leadership & Impact and in “Current roles” on the About page.',
        'fields' => ['title' => 'Organisation', 'subtitle' => 'Her role', 'body' => 'Her contribution', 'url' => 'Official website', 'icon' => 'Icon', 'image' => 'Logo or photo'],
        'seed' => [
            ['icon' => 'columns', 'title' => 'Streamsowers & Köhn', 'subtitle' => 'Chief Operating Officer', 'body' => 'Partnering with the firm’s leadership on strategy, institutional structures and the operational functions that support its people, clients and business objectives.'],
            ['icon' => 'scale', 'title' => 'Association of Law Firm Administrators Nigeria (ALAN)', 'subtitle' => 'President, 2026–2029', 'body' => 'Advancing the development and professionalisation of law firm management and business professionals in Nigeria’s legal services industry.'],
            ['icon' => 'globe', 'title' => 'International Bar Association', 'subtitle' => 'Law Firm Management Committee', 'body' => 'Serving as African Regional Forum Liaison Officer and contributing to international conversations on law firm management, technology, AI and the future of professional services.'],
            ['icon' => 'steps', 'title' => 'The Strides Platform', 'subtitle' => 'Founder initiative', 'body' => 'A development and community platform supporting professionals through career, leadership, personal development and growth.'],
            ['icon' => 'heart', 'title' => 'Project CHAM', 'subtitle' => 'Social impact', 'body' => 'Childhood cancer awareness, support and advocacy, including support for children and families affected by childhood cancer.'],
        ],
    ],
    'impact_focus' => [
        'label' => 'Impact focus areas', 'group' => 'Impact', 'icon' => 'spark',
        'fields' => ['title' => 'Focus area'],
        'seed' => [
            ['title' => 'Professionalising law firm management and business functions.'],
            ['title' => 'Governance, succession and leadership pipelines.'],
            ['title' => 'People strategy, culture and organisational performance.'],
            ['title' => 'Technology, AI and the future of professional services.'],
            ['title' => 'Community, career growth and support for families affected by childhood cancer.'],
        ],
    ],
    'programmes' => [
        'label' => 'Other programmes', 'group' => 'Programmes', 'icon' => 'steps',
        'help' => 'Additional offerings shown on the Programmes page next to the mentorship programme.',
        'fields' => ['title' => 'Programme', 'subtitle' => 'Audience and duration', 'body' => 'Description', 'category' => 'Availability', 'url' => 'Link (page or form)', 'image' => 'Image'],
        'categories' => ['open' => 'Open', 'forthcoming' => 'Coming soon', 'on_request' => 'On request', 'closed' => 'Closed'],
        'seed' => [],
    ],
    'programme_principles' => [
        'label' => 'Programme principles', 'group' => 'Programmes', 'icon' => 'compass',
        'fields' => ['title' => 'Principle', 'body' => 'Explanation', 'icon' => 'Icon'],
        'seed' => [
            ['icon' => 'compass', 'title' => 'Clarity', 'body' => 'Turn a vague ambition into a defined outcome you can measure.'],
            ['icon' => 'steps', 'title' => 'Discipline', 'body' => 'Deliberate weekly action, reviewed and adjusted with honest feedback.'],
            ['icon' => 'relay', 'title' => 'Consistency', 'body' => 'A structure and community that keeps you going when motivation fades.'],
        ],
    ],
    'journey' => [
        'label' => 'Mentorship journey', 'group' => 'Programmes', 'icon' => 'steps',
        'fields' => ['title' => 'Stage', 'body' => 'What happens', 'icon' => 'Icon'],
        'seed' => [
            ['icon' => 'star', 'title' => 'Aspiration', 'body' => 'Name the goal you have been carrying.'],
            ['icon' => 'eye', 'title' => 'Clarity', 'body' => 'Turn ambition into a defined outcome.'],
            ['icon' => 'steps', 'title' => 'Action', 'body' => 'Commit to deliberate weekly steps.'],
            ['icon' => 'calendar', 'title' => 'Consistency', 'body' => 'Keep going when motivation fades.'],
            ['icon' => 'check', 'title' => 'Results', 'body' => 'Review real progress in July.'],
        ],
    ],
    'mentorship_audience' => [
        'label' => 'Mentorship: who it is for', 'group' => 'Programmes', 'icon' => 'check',
        'fields' => ['title' => 'Statement'],
        'seed' => [
            ['title' => 'You have meaningful personal, professional or entrepreneurial goals you want to pursue.'],
            ['title' => 'You know you are capable of more, but need greater clarity, structure and accountability.'],
            ['title' => 'You are prepared to do the work required between sessions.'],
            ['title' => 'You want mentorship, perspective and a structured community.'],
            ['title' => 'You are willing to be challenged and held accountable.'],
            ['title' => 'You can commit consistently for six months.'],
        ],
    ],
    'mentorship_includes' => [
        'label' => 'Mentorship: what is included', 'group' => 'Programmes', 'icon' => 'star',
        'fields' => ['title' => 'Included', 'body' => 'Detail', 'icon' => 'Icon'],
        'seed' => [],
    ],
    'faqs' => [
        'label' => 'Mentorship FAQs', 'group' => 'Programmes', 'icon' => 'quote',
        'fields' => ['title' => 'Question', 'body' => 'Answer'],
        'seed' => [
            ['title' => 'When do I pay?', 'body' => 'Only after your application has been reviewed and accepted. Successful applicants receive payment and onboarding information.'],
            ['title' => 'Are sessions online or in person?', 'body' => 'The opening session in mid-January and the closing session in July are in person. Delivery details and the time zone for the weekly sessions will be confirmed to the cohort.'],
            ['title' => 'How large is the cohort?', 'body' => 'Deliberately limited, so every participant receives meaningful interaction, accountability and mentorship.'],
            ['title' => 'Is this a motivational course?', 'body' => 'No. It is designed to create clarity, intentional action, accountability, consistency and execution.'],
        ],
    ],
    'book_themes' => [
        'label' => 'Book themes', 'group' => 'Book', 'icon' => 'book',
        'fields' => ['title' => 'Theme'],
        'seed' => array_map(fn ($t) => ['title' => $t], ['Institutionalisation', 'Governance', 'Succession', 'Leadership pipelines', 'Culture', 'Talent development', 'Founder dependency', 'Organisational identity', 'Innovation and technology', 'Building for the next generation']),
    ],
    'book_endorsements' => [
        'label' => 'Book endorsements', 'group' => 'Book', 'icon' => 'quote',
        'help' => 'Only approved endorsements. They appear on the book page once added.',
        'fields' => ['body' => 'Endorsement', 'title' => 'Name', 'subtitle' => 'Role and organisation'],
        'seed' => [],
    ],
    'moments' => [
        'label' => 'Photo reel (in public)', 'group' => 'Homepage', 'icon' => 'eye',
        'help' => 'Photos of Modupe speaking, hosting and meeting people. They scroll gently under the homepage hero. Landscape or portrait both work; add a short caption.',
        'fields' => ['image' => 'Photo', 'title' => 'Caption', 'subtitle' => 'Event or place', 'date' => 'Date', 'url' => 'Link (optional)'],
        'required' => ['image'],
        'seed' => [],
    ],
    'media_items' => [
        'label' => 'Media appearances', 'group' => 'Media', 'icon' => 'video',
        'help' => 'Interviews, talks, videos, podcast appearances and publications. YouTube, Vimeo and Spotify links play on the page.',
        'fields' => ['title' => 'Title', 'category' => 'Type', 'subtitle' => 'Outlet or event', 'date' => 'Date', 'body' => 'Description', 'image' => 'Thumbnail', 'url' => 'Link or video URL'],
        'categories' => ['interview' => 'Interview', 'speaking' => 'Speaking appearance', 'video' => 'Video', 'podcast' => 'Podcast', 'publication' => 'Publication'],
        'seed' => [],
    ],
    'resources' => [
        'label' => 'Downloads & resources', 'group' => 'Media', 'icon' => 'download',
        'help' => 'Files from the media library or external links. “Press kit” and “Speaker kit” items appear on the Media and Speaking pages.',
        'fields' => ['title' => 'Title', 'category' => 'Kind', 'body' => 'Description', 'file' => 'File', 'url' => 'Or external link', 'image' => 'Preview image'],
        'categories' => ['press' => 'Press kit', 'speaker' => 'Speaker kit', 'download' => 'Download', 'reading' => 'Recommended reading', 'presentation' => 'Presentation'],
        'seed' => [],
    ],
    'podcast_episodes' => [
        'label' => 'Podcast episodes', 'group' => 'Podcast', 'icon' => 'headphones', 'pages' => true,
        'help' => 'Each episode gets its own page with the player, guest and transcript.',
        'fields' => ['title' => 'Episode title', 'subtitle' => 'Guest', 'date' => 'Release date', 'category' => 'Episode number', 'body' => 'Show notes and transcript', 'url' => 'Player or listening link', 'image' => 'Episode artwork'],
        'seed' => [],
    ],
    'podcast_platforms' => [
        'label' => 'Podcast listening links', 'group' => 'Podcast', 'icon' => 'play',
        'fields' => ['title' => 'Platform', 'url' => 'Link'],
        'seed' => [],
    ],
    // ── Authority layer: proof, track record and offers (added November 2026) ──
    'proof_stats' => [
        'label' => 'Proof figures', 'group' => 'Homepage', 'icon' => 'star',
        'help' => 'The large figures in the homepage proof band. Put the number in “Figure” (e.g. 82%, 20+, 100+); it counts up as visitors scroll.',
        'fields' => ['title' => 'Figure', 'subtitle' => 'What it measures', 'body' => 'Where it comes from (small print)'],
        'seed' => [
            ['title' => '20+', 'subtitle' => 'Years building organisations across banking, the Big Four and law', 'body' => 'Career since 2006'],
            ['title' => '82%', 'subtitle' => 'Rise in employee productivity after her career and performance framework', 'body' => 'Streamsowers & Köhn'],
            ['title' => '35%', 'subtitle' => 'Faster client delivery after a firm-wide restructuring she led', 'body' => 'Streamsowers & Köhn'],
            ['title' => '40%', 'subtitle' => 'Shorter internal task cycles through workflow digitisation', 'body' => 'Streamsowers & Köhn'],
            ['title' => '100+', 'subtitle' => 'Children reached, 27 with direct medical support', 'body' => 'Project CHAM'],
        ],
    ],
    'affiliations' => [
        'label' => 'Affiliations band', 'group' => 'Homepage', 'icon' => 'columns',
        'help' => 'Organisations shown in the scrolling band under the hero. Add a logo (transparent PNG or SVG) to replace the typeset name.',
        'fields' => ['title' => 'Organisation', 'subtitle' => 'Her relationship (shown on hover)', 'image' => 'Logo (optional)', 'url' => 'Link (optional)'],
        'seed' => [
            ['title' => 'Streamsowers & Köhn', 'subtitle' => 'Chief Operating Officer'],
            ['title' => 'Association of Law Firm Administrators Nigeria', 'subtitle' => 'President, 2026–2029'],
            ['title' => 'International Bar Association', 'subtitle' => 'Law Firm Management Committee'],
            ['title' => 'KPMG Nigeria', 'subtitle' => 'HR Business Partner, Audit'],
            ['title' => 'Olajide Oyewole LLP · DLA Piper Africa', 'subtitle' => 'Practice Manager'],
            ['title' => 'Harvard Business School', 'subtitle' => 'Strategy Execution · Organizational Leadership'],
            ['title' => 'MIT Sloan', 'subtitle' => 'Applied Business Analytics'],
            ['title' => 'The George Washington University', 'subtitle' => 'Strategic Management Performance System'],
        ],
    ],
    'career' => [
        'label' => 'Career journey', 'group' => 'Profile', 'icon' => 'steps',
        'help' => 'The timeline on the homepage and About page, oldest first. Keep each highlight to one or two sentences.',
        'fields' => ['category' => 'Years (e.g. 2020 – now)', 'title' => 'Role', 'subtitle' => 'Organisation', 'body' => 'Highlight', 'image' => 'Illustration (transparent PNG or WebP works best)', 'icon' => 'Icon (used when there is no illustration)'],
        'seed' => [
            ['category' => '2006 – 2009', 'title' => 'Marketing & Operations', 'subtitle' => 'Zenith Bank Plc', 'image' => 'images/journey/bank-hall.webp', 'icon' => 'compass', 'body' => 'Began in Kano and Lagos, mobilising deposits and building client relationships: an early education in how institutions earn trust.'],
            ['category' => '2009 – 2012', 'title' => 'Administrator & Assistant Manager', 'subtitle' => 'Grace Corporate', 'image' => 'images/journey/office-desk.webp', 'icon' => 'settings', 'body' => 'Streamlined administrative processes for a 30% gain in operational efficiency.'],
            ['category' => '2012 – 2014', 'title' => 'Practice Manager', 'subtitle' => 'Olajide Oyewole LLP, a member of DLA Piper Africa', 'image' => 'images/journey/law-library.webp', 'icon' => 'columns', 'body' => 'Redesigned the firm’s structure to lift administrative load from its 8 partners, and introduced succession planning and career development.'],
            ['category' => '2014 – 2016', 'title' => 'Practice Administrator', 'subtitle' => 'Aelex', 'image' => 'images/journey/talent-steps.webp', 'icon' => 'people', 'body' => 'Built a talent management framework spanning progression, retention and performance, with gains in satisfaction and retention.'],
            ['category' => '2016 – 2017', 'title' => 'Business Development Manager', 'subtitle' => 'Storgos and Phileo', 'image' => 'images/journey/growth-compass.webp', 'icon' => 'spark', 'body' => 'Designed growth and market-entry strategies for small and medium-sized enterprises.'],
            ['category' => '2017 – 2020', 'title' => 'Practice Administrator, then HR Business Partner', 'subtitle' => 'KPMG Nigeria, Audit', 'image' => 'images/journey/learning-hall.webp', 'icon' => 'scale', 'body' => 'Launched the division’s first “Audit University”, led executive coaching and succession planning, and a client engagement framework for the top ten clients.'],
            ['category' => '2020 – now', 'title' => 'Chief Operating Officer', 'subtitle' => 'Streamsowers & Köhn', 'image' => 'images/journey/firm-tower.webp', 'icon' => 'relay', 'body' => 'Leads strategy, governance and operations across Lagos, Abuja and Port Harcourt; restructured delivery, digitised the firm’s workflows and lifted productivity by 82%.'],
            ['category' => '2026 – 2029', 'title' => 'President', 'subtitle' => 'Association of Law Firm Administrators Nigeria', 'image' => 'images/journey/assembly-hall.webp', 'icon' => 'star', 'body' => 'Leading the professionalisation of law firm management in Nigeria, and contributing internationally through the IBA.'],
        ],
    ],
    'case_studies' => [
        'label' => 'Selected work (case studies)', 'group' => 'Impact', 'icon' => 'file', 'pages' => true,
        'help' => 'Each case study gets its own page under /work. In “Story”, start sections with “## ” (for example “## The challenge”).',
        'fields' => ['title' => 'Title', 'subtitle' => 'Organisation and her role', 'category' => 'Headline result (e.g. 35% faster client delivery)', 'date' => 'Date (optional)', 'body' => 'Story', 'image' => 'Image', 'url' => 'Related link (optional)'],
        'seed' => [
            ['title' => 'Re-engineering a 20-year-old firm for its next 20', 'subtitle' => 'Streamsowers & Köhn · Chief Operating Officer', 'category' => '35% faster client delivery', 'image' => 'images/authority/case-firm.webp', 'body' => "## The challenge\n\nA respected commercial law firm with offices in Lagos, Abuja and Port Harcourt needed its operations, people systems and finance function to keep pace with its ambitions.\n\n## What she did\n\nLed a firm-wide restructuring of how work flows from instruction to delivery. Implemented a revised career development and performance management framework. Upgraded budgeting, monthly reporting and audit reporting to support executive decisions. Introduced workflow digitisation, and established a dedicated business development desk.\n\n## The outcome\n\nClient delivery timelines improved by 35%. Internal task cycle times fell by 40%. Employee productivity rose by 82%, with a 72% employee satisfaction rate.\n\n> Sustainable growth is designed. It does not happen by accident."],
            ['title' => 'Building a learning institution inside the Audit division', 'subtitle' => 'KPMG Nigeria · HR Business Partner', 'category' => 'First “Audit University”', 'image' => 'images/authority/case-learning.webp', 'body' => "## The challenge\n\nIn a complex matrix organisation, the Audit division needed its people strategy to move as fast as its client work.\n\n## What she did\n\nActed as change champion for the division, translating HR strategy into short and medium-term goals. Launched the inaugural “Audit University” learning platform, led executive coaching for career progression and succession, and designed a client engagement framework for the firm’s top ten clients.\n\n## The outcome\n\nA repeatable learning platform, a clearer leadership pipeline and revenue growth from the division’s most important client relationships."],
            ['title' => 'Freeing eight partners to lead, not administer', 'subtitle' => 'Olajide Oyewole LLP (DLA Piper Africa) · Practice Manager', 'category' => '8 partners released from admin', 'image' => 'images/authority/case-boardroom.webp', 'body' => "## The challenge\n\nPartners were carrying the firm’s administrative, HR and operational load themselves.\n\n## What she did\n\nEstablished a new organisational structure that decentralised HR, administrative and operational functions. Wrote competency-based job descriptions, introduced talent reviews, succession planning and career development, and set new policies for recruitment, compensation, learning and welfare.\n\n## The outcome\n\nThe firm’s eight partners were relieved of day-to-day administration, creating room for business development and revenue growth."],
            ['title' => 'Convening the profession on the scalable law firm', 'subtitle' => 'ALAN · President and convener, MPR 5.0', 'category' => 'A white paper for the industry', 'image' => 'images/authority/case-roundtable.webp', 'url' => 'http://bit.ly/ALANMPR5', 'body' => "## The challenge\n\nNigerian law firms are growing, but growth alone does not build institutions that can scale and last.\n\n## What she did\n\nAs President of ALAN, convened the 5th Managing Partners’ Roundtable on 3 September 2026, themed “The Scalable Law Firm: The New Equation for Thriving”, bringing senior advocates, managing partners and business leaders into one room. Then commissioned a white paper researched in-house by ALAN’s executive committee.\n\n## The outcome\n\nA published white paper that turns the conversation into practical guidance on governance, leadership, technology, talent and succession for the wider legal industry.\n\n> Growth is an outcome; scaling is a capability."],
            ['title' => 'A platform for professionals ready to do the work', 'subtitle' => 'The Strides Platform · Founder and Lead Facilitator', 'category' => 'Leadership training · a goal-setting journal', 'image' => 'images/authority/case-journal.webp', 'body' => "## The challenge\n\nTalented professionals often have the aspiration, but lack the structure and accountability to act on it.\n\n## What she did\n\nFounded The Strides Platform in 2021. Designed leadership training for senior managers and executives, hosted webinars, roundtables and mentorship programmes, and authored a goal-setting journal for professionals.\n\n## The outcome\n\nSharper strategic thinking among participating leaders, a growing professional community, and a practical tool that participants use to turn goals into progress."],
        ],
    ],
    'offers' => [
        'label' => 'Ways to work together', 'group' => 'Homepage', 'icon' => 'compass',
        'help' => 'The offers on the homepage “Work with Modupe” section. The first one is shown large. The link should usually be /contact?type=… so the right enquiry type is chosen.',
        'fields' => ['title' => 'Offer', 'subtitle' => 'Who it is for', 'body' => 'What it solves', 'category' => 'Format (e.g. Engagement · 3–6 months)', 'image' => 'Illustration (transparent PNG or WebP works best)', 'icon' => 'Icon', 'url' => 'Button link'],
        'seed' => [
            ['title' => 'Institutional advisory for law firms', 'subtitle' => 'Founders, managing partners and leadership teams', 'category' => 'Selected engagements', 'icon' => 'columns', 'url' => '/contact?type=advisory', 'body' => 'Governance, operating model, succession and the business functions that let a firm thrive beyond its founders.'],
            ['title' => 'Keynotes, panels & moderation', 'image' => 'images/offers/keynote-stage.webp', 'subtitle' => 'Conferences, professional bodies and firms', 'category' => 'Half-day or less', 'icon' => 'mic', 'url' => '/contact?type=speaking', 'body' => 'Institution building, the business of law, AI and client value, and the future of professional services.'],
            ['title' => 'Partner & leadership retreats', 'image' => 'images/offers/retreat-room.webp', 'subtitle' => 'Partnerships and executive teams', 'category' => '1–2 days', 'icon' => 'retreat', 'url' => '/contact?type=retreat', 'body' => 'Facilitated sessions that leave with decisions: strategy execution, culture, talent and leadership pipelines.'],
            ['title' => 'Executive sessions & coaching', 'image' => 'images/offers/executive-session.webp', 'subtitle' => 'Leaders in transition or taking on more', 'category' => 'One-to-one or small group', 'icon' => 'compass', 'url' => '/contact?type=session', 'body' => 'Clarity, structure and accountability for the decisions in front of you.'],
            ['title' => 'The Mentorship Programme', 'image' => 'images/offers/mentorship-journal.webp', 'subtitle' => 'Professionals ready to do the work', 'category' => 'Six months · limited cohort', 'icon' => 'steps', 'url' => '/programmes/mentorship', 'body' => 'From aspiration to clarity, action, consistency and results, with weekly accountability.'],
        ],
    ],
    'recognition' => [
        'label' => 'Recognition & appointments', 'group' => 'Profile', 'icon' => 'star',
        'help' => 'Awards, elected roles and notable appointments, shown on the homepage and About page. Remove the placeholder once real awards are added.',
        'fields' => ['category' => 'Year', 'title' => 'Recognition', 'subtitle' => 'Awarding or appointing body', 'icon' => 'Icon'],
        'seed' => [
            ['category' => '2026', 'title' => 'Elected President, 2026–2029 term', 'subtitle' => 'Association of Law Firm Administrators Nigeria', 'icon' => 'star'],
            ['category' => '2026', 'title' => 'Speaker, IBA Annual Conference, Copenhagen', 'subtitle' => 'International Bar Association', 'icon' => 'mic'],
            ['category' => 'Now', 'title' => 'African Regional Forum Liaison Officer', 'subtitle' => 'IBA Law Firm Management Committee', 'icon' => 'globe'],
            ['category' => '2024', 'title' => 'Organizational Leadership', 'subtitle' => 'Harvard Business School Online', 'icon' => 'book'],
            ['category' => 'Year', 'title' => 'Award or honour to be added', 'subtitle' => 'Awarding body · edit under Lists → Recognition', 'icon' => 'scale'],
        ],
    ],

    'icons' => $icons,
];
