<?php

return [
    // Defaults for values the owner can change in Admin → Settings.
    'settings' => [
        // Mentorship cohort (Admin → Cohort)
        'mentorship_status' => 'open', // forthcoming | open | closed | in_progress
        'mentorship_cohort' => '2027 cohort',
        'mentorship_year' => '2027',
        'mentorship_timezone' => '(WAT)',
        'mentorship_period' => 'February – July',
        'mentorship_start' => 'Thursday 4 February 2027',
        'mentorship_duration' => 'Six months',
        'mentorship_opening' => 'In person, mid-January 2027',
        'mentorship_sessions' => 'Thursdays, 7:00 – 9:00 PM',
        'mentorship_closing' => 'In person, July 2027',
        'mentorship_fee' => '₦200,000',
        'mentorship_capacity' => '20 places',
        'mentorship_delivery' => '',
        'applications_open_on' => '',
        'applications_close_on' => '2026-12-31',
        // Operations (Admin → Settings)
        'book_waitlist_open' => '1',
        'notification_email' => '',
        'send_receipts' => '1',
        'contact_email' => '',
        'analytics_id' => '',
        'linkedin_url' => 'https://www.linkedin.com/in/modupe-olusoga-msc-sphri/',
        'instagram_url' => 'https://www.instagram.com/modupeifeoluwasimi',
        'x_url' => '',
        'facebook_url' => 'https://www.facebook.com/dupe.olusoga.5',
        'youtube_url' => '',
    ],

    'enquiry_types' => [
        'speaking' => 'Conference speaking or keynote',
        'panel' => 'Panel participation or moderation',
        'session' => 'Leadership or executive session',
        'retreat' => 'Partner or leadership retreat',
        'strategy' => 'Law firm or professional services strategy',
        'workshop' => 'Organisational effectiveness workshop',
        'mentorship' => 'Mentorship or coaching',
        'media' => 'Podcast or media interview',
        'book' => 'Book-related engagement',
        'partnership' => 'Partnership or collaboration',
        'advisory' => 'Advisory engagement',
    ],

    'enquiry_statuses' => [
        'new' => 'New', 'reviewing' => 'Reviewing', 'follow_up' => 'Follow-up',
        'approved' => 'Approved', 'scheduled' => 'Scheduled', 'completed' => 'Completed',
        'declined' => 'Declined', 'archived' => 'Archived',
    ],

    'application_statuses' => [
        'submitted' => 'Submitted', 'reviewing' => 'Under review', 'accepted' => 'Accepted',
        'waitlisted' => 'Waitlisted', 'declined' => 'Declined', 'onboarding' => 'Onboarding',
        'enrolled' => 'Enrolled', 'withdrawn' => 'Withdrawn',
    ],

    'payment_statuses' => ['not_requested' => 'Not requested', 'pending' => 'Pending', 'confirmed' => 'Confirmed'],

    // Insights categories, as set by the client (Nov 20).
    'article_categories' => [
        'institutional-sustainability' => 'Institutional Sustainability',
        'business-of-professional-services' => 'The Business of Professional Services',
        'leadership-execution' => 'Leadership and Execution',
        'future-of-work' => 'The Future of Work',
    ],

    'roles' => [
        'owner' => 'Owner: everything, including settings and team',
        'editor' => 'Editor: pages, articles, lists, testimonials and media',
        'coordinator' => 'Coordinator: enquiries, applications, waiting list and subscribers',
    ],

    'interests' => [
        'insights' => 'Insights', 'mentorship' => 'Mentorship', 'speaking' => 'Events', 'book' => 'The book', 'podcast' => 'Podcast',
    ],
];
