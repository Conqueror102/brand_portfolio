<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Content;
use App\Models\Enquiry;
use App\Models\MentorshipApplication;
use App\Models\Subscriber;
use App\Models\Testimonial;
use App\Models\WaitlistSignup;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('admin.dashboard', [
            'stats' => [
                'newEnquiries' => Enquiry::where('status', 'new')->count(),
                'pendingApplications' => MentorshipApplication::whereIn('status', ['submitted', 'reviewing'])->count(),
                'publishedArticles' => Article::published()->count(),
                'draftArticles' => Article::where('status', 'draft')->count(),
                'testimonials' => Testimonial::where('is_published', true)->count(),
                'waitlist' => WaitlistSignup::count(),
            ],
            'recentEnquiries' => Enquiry::latest()->take(5)->get(),
            'recentApplications' => MentorshipApplication::latest()->take(5)->get(),
            'mentorshipStatus' => mentorship_status(),
            'followUps' => Enquiry::with('assignee')->whereNotNull('follow_up_on')->whereDate('follow_up_on', '<=', today()->addDays(7))->whereNotIn('status', ['completed', 'declined', 'archived'])->orderBy('follow_up_on')->take(6)->get(),
            'subscribers' => Subscriber::active()->count(),
            'unpublished' => Content::where('has_draft', true)->count(),
            'samples' => Article::where('is_sample', true)->count() + Testimonial::where('is_sample', true)->count(),
        ]);
    }
}
