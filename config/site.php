<?php

return [
    // Defaults for values the owner can change in Admin → Settings.
    'settings' => [
        // Mentorship cohort (Admin → Cohort)
        'mentorship_status' => 'open', // forthcoming | open | closed | in_progress
        'mentorship_cohort' => 'Inaugural cohort',
        'mentorship_year' => '',
        'mentorship_timezone' => '',
        'mentorship_period' => 'February – July',
        'mentorship_duration' => 'Six months',
        'mentorship_opening' => 'In person, mid-January',
        'mentorship_sessions' => 'Thursdays, 7:00 – 9:00 PM',
        'mentorship_closing' => 'In person, July',
        'mentorship_fee' => '₦200,000',
        'mentorship_capacity' => '',
        'mentorship_delivery' => '',
        'applications_open_on' => '',
        'applications_close_on' => '',
        // Operations (Admin → Settings)
        'book_waitlist_open' => '1',
        'notification_email' => '',
        'send_receipts' => '1',
        'contact_email' => '',
        'linkedin_url' => '',
        'instagram_url' => '',
    ],

    'enquiry_types' => [
        'speaking' => 'Conference or keynote speaking',
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

    'article_categories' => [
        'institution-building' => 'Institution Building',
        'governance-succession' => 'Governance & Succession',
        'leadership' => 'Leadership',
        'professional-services' => 'Professional Services',
        'people-performance' => 'People & Performance',
        'intentional-execution' => 'Intentional Execution',
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
