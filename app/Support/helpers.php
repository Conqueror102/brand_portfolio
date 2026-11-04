<?php

use App\Models\Content;
use App\Models\Item;
use App\Models\Setting;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\HtmlString;

if (! function_exists('media_url')) {
    /** Public URL for a bundled image ("images/…") or an uploaded file. */
    function media_url(?string $path): ?string
    {
        if (! $path) {
            return null;
        }
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        return str_starts_with($path, 'images/') ? asset($path) : Storage::disk('public')->url($path);
    }
}

if (! function_exists('content')) {
    /** Plain editable text for a page field. */
    function content(string $key): ?string
    {
        $value = Content::read($key);

        return $value === null ? null : (string) $value;
    }
}

if (! function_exists('content_html')) {
    /** Editable text rendered safely: *words* become emphasis, line breaks are kept. */
    function content_html(string $key): HtmlString
    {
        return rich_text((string) content($key));
    }
}

if (! function_exists('rich_text')) {
    function rich_text(string $text): HtmlString
    {
        $html = e($text);
        $html = preg_replace('/\*(.+?)\*/s', '<em>$1</em>', $html);

        return new HtmlString(nl2br((string) $html, false));
    }
}

if (! function_exists('content_on')) {
    function content_on(string $key): bool
    {
        return filter_var(content($key), FILTER_VALIDATE_BOOLEAN);
    }
}

if (! function_exists('content_url')) {
    /** A link field: internal paths become absolute site URLs. */
    function content_url(string $key): string
    {
        $value = (string) content($key);

        return str_starts_with($value, '/') ? url($value) : $value;
    }
}

if (! function_exists('content_image')) {
    function content_image(string $key): ?string
    {
        return media_url(content($key));
    }
}

if (! function_exists('items')) {
    /** @return Collection<int, Item> */
    function items(string $type): Collection
    {
        return Item::list($type);
    }
}

if (! function_exists('block_text')) {
    /** Paragraphs, "## " headings and "> " quotes, all escaped. */
    function block_text(?string $text): HtmlString
    {
        return new HtmlString(collect(preg_split("/\R{2,}/", trim((string) $text)))
            ->filter()
            ->map(function (string $block) {
                $block = trim($block);
                if (str_starts_with($block, '## ')) {
                    return '<h2>'.e(substr($block, 3)).'</h2>';
                }
                if (str_starts_with($block, '> ')) {
                    return '<blockquote><p>'.e(substr($block, 2)).'</p></blockquote>';
                }

                return '<p>'.nl2br(e($block)).'</p>';
            })
            ->implode("\n"));
    }
}

if (! function_exists('page_live')) {
    /** Optional pages (media, book, podcast, resources) can be switched off under Admin → Pages → Navigation. */
    function page_live(string $page): bool
    {
        $key = 'navigation.'.$page.'_on';

        return Content::field($key) === null || content_on($key);
    }
}

if (! function_exists('site_pages')) {
    /** Live pages with their menu label, link and whether they sit in the top menu. @return array<string, array{label: string, url: string, header: bool, active: bool}> */
    function site_pages(): array
    {
        $pages = [];
        foreach (config('content.pages') as $page => $route) {
            if (! page_live($page)) {
                continue;
            }
            $base = str_replace('.index', '', $route);
            $pages[$page] = [
                'label' => (string) content('navigation.'.$page.'_label'),
                'url' => route($route),
                'header' => content_on('navigation.'.$page.'_header'),
                'active' => request()->routeIs($route) || request()->routeIs($base.'.*') || ($page === 'programmes' && request()->routeIs('mentorship')),
            ];
        }

        return $pages;
    }
}

if (! function_exists('cohort')) {
    /** Mentorship cohort details from Admin → Cohort. */
    function cohort(string $key): ?string
    {
        $value = Setting::get('mentorship_'.$key) ?? Setting::get($key);

        return $value === null || $value === '' ? null : (string) $value;
    }
}

if (! function_exists('mentorship_status')) {
    /** The chosen availability, adjusted by the application window dates when they are set. */
    function mentorship_status(): string
    {
        $status = (string) Setting::get('mentorship_status');
        if ($status !== 'open') {
            return $status;
        }
        $today = now()->startOfDay();
        $opens = Setting::get('applications_open_on');
        $closes = Setting::get('applications_close_on');
        if ($opens && $today->lt(CarbonImmutable::parse($opens))) {
            return 'forthcoming';
        }
        if ($closes && $today->gt(CarbonImmutable::parse($closes))) {
            return 'closed';
        }

        return 'open';
    }
}

if (! function_exists('mentorship_status_label')) {
    function mentorship_status_label(?string $status = null): string
    {
        return ['open' => 'Applications open', 'forthcoming' => 'Opening soon', 'closed' => 'Applications closed', 'in_progress' => 'Cohort in progress'][$status ?? mentorship_status()] ?? '';
    }
}

if (! function_exists('nice_date')) {
    function nice_date(?string $date): ?string
    {
        return $date ? CarbonImmutable::parse($date)->format('j F Y') : null;
    }
}

if (! function_exists('bold_text')) {
    /** Escaped text where *words* become bold (used for names inside paragraphs). */
    function bold_text(string $text): string
    {
        return (string) preg_replace('/\*(.+?)\*/s', '<strong>$1</strong>', e(trim($text)));
    }
}

if (! function_exists('home_sections')) {
    /**
     * Homepage sections in their saved order, with any section added after the order was saved appended.
     *
     * @return list<array{0: string, 1: bool}>
     */
    function home_sections(): array
    {
        $known = array_keys(config('content.home_sections'));
        $sections = [];
        foreach (explode(',', (string) content('home.sections')) as $entry) {
            [$key, $visible] = array_pad(explode(':', $entry), 2, '1');
            if (in_array($key, $known, true) && ! isset($sections[$key])) {
                $sections[$key] = [$key, $visible === '1'];
            }
        }
        foreach ($known as $key) {
            $sections[$key] ??= [$key, true];
        }

        return array_values($sections);
    }
}
