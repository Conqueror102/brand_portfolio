<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Item;
use App\Models\Testimonial;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PageController extends Controller
{
    public function home(): View
    {
        $articles = Article::published()->orderByDesc('is_featured')->latest('published_at')->take(4)->get();

        $testimonials = Testimonial::published()->where('is_featured', true)->take(3)->get();
        if ($testimonials->isEmpty()) {
            $testimonials = Testimonial::published()->take(3)->get();
        }

        return view('welcome', [
            'featured' => $articles->first(),
            'insights' => $articles->slice(1),
            'testimonials' => $testimonials,
        ]);
    }

    public function about(): View
    {
        return view('pages.about');
    }

    public function work(): View
    {
        return view('pages.work.index', ['cases' => items('case_studies')]);
    }

    public function caseStudy(string $slug): View
    {
        $caseStudy = Item::where('type', 'case_studies')->where('slug', $slug)->where('is_published', true)->firstOrFail();
        $cases = items('case_studies')->values();
        $index = $cases->search(fn (Item $c) => $c->is($caseStudy));
        $next = $cases->count() > 1 ? $cases[($index + 1) % $cases->count()] : null;

        return view('pages.work.show', ['case' => $caseStudy, 'next' => $next, 'number' => $index + 1]);
    }

    public function speaking(): View
    {
        return view('pages.speaking', ['testimonials' => $this->testimonials('speaking', 2)]);
    }

    public function programmes(): View
    {
        return view('pages.programmes');
    }

    public function impact(): View
    {
        return view('pages.impact');
    }

    public function media(): View
    {
        $this->ensureLive('media');

        return view('pages.media');
    }

    public function book(): View
    {
        $this->ensureLive('book');

        return view('pages.book', ['testimonials' => $this->testimonials('book', 3)]);
    }

    public function podcast(): View
    {
        $this->ensureLive('podcast');

        return view('pages.podcast.index');
    }

    public function episode(Item $episode): View
    {
        $this->ensureLive('podcast');
        abort_unless($episode->type === 'podcast_episodes' && $episode->is_published, 404);

        return view('pages.podcast.show', compact('episode'));
    }

    public function resources(): View
    {
        $this->ensureLive('resources');

        return view('pages.resources');
    }

    public function contact(Request $request): View
    {
        $type = $request->query('type');

        return view('pages.contact', [
            'selectedType' => array_key_exists((string) $type, config('site.enquiry_types')) ? $type : null,
        ]);
    }

    public function privacy(): View
    {
        return view('pages.privacy');
    }

    private function ensureLive(string $page): void
    {
        abort_unless(page_live($page) || auth()->check(), 404);
    }

    /** @return Collection<int, Testimonial> */
    private function testimonials(string $context, int $limit): Collection
    {
        return Testimonial::published()->where('context', $context)->take($limit)->get();
    }
}
