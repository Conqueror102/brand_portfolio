# Website image assets

24 original images were generated with the built-in image generation tool and installed into the existing image slots. The hero background and portrait were excluded and their SHA-256 checksums were verified before installation. The website layout, font system, content and page availability settings were preserved.

## Review

- [Full contact sheet](contact-sheet.jpg)
- [Asset manifest, prompts, descriptions, source locations and dimensions](manifest.json)
- [Installed assignments](assignments.json)
- Original PNGs and optimized WebP files: `public/images/generated/`

## Placement

| Area | Assets |
| --- | --- |
| Meet Modupe | Editorial writing scene; ivory portrait backdrop |
| Mentorship on homepage | Planning cards and notebook |
| Speaking page | Microphone and auditorium |
| Programmes page | Professional group conversation |
| Mentorship page | One-to-one mentoring conversation |
| Leadership & Impact page | Volunteers preparing care bags and books |
| Leadership story card | Interconnected woven fibres |
| Six insight articles | Bookbinding, baton exchange, precision gears, morning preparation, young professionals, lighthouse |
| Six photo reel cards | Keynote, panel setup, cohort activity, conversation setting, workshop, reception detail |
| Book | Flat front concept cover |
| Podcast | Square show artwork, ready in admin while the optional page is disabled |
| Social sharing | Branded landscape card |
| Shared page CTA | Dark navy fabric texture |

## Editing in admin

All 24 WebP files are registered in **Admin → Media**, with alt text and a caption identifying generated artwork. Section images can be replaced in **Admin → Pages**. Article covers are editable in **Admin → Articles**; reel images are under **Admin → Lists → Photo reel**. Decorative backgrounds are referenced in `resources/views/partials/image-vars.blade.php`.

The generated people are illustrative characters, not portraits of Modupe, actual participants or verified events. Existing reel “Sample” titles were retained and illustrative captions added. Replace these with genuine event photos when available. The book cover is a design concept, not approved publication artwork.

## Areas intentionally kept without generated photos

- Organisation cards retain the existing icons; official logos need the genuine brand files.
- Testimonials retain initials; reviewer portraits need actual photos.
- Empty media, podcast episode, resource and extra programme lists retain their existing empty states. Images should follow actual entries rather than create invented guests, appearances or resources.
- Text, topic, credential, FAQ, form and journey cards retain the existing icon treatment where imagery adds no useful information.

## Reproducing the installation

1. `python scripts/assets/prepare.py` encodes the saved PNG originals as WebP and rebuilds the review sheet. Requires Pillow.
2. `python scripts/assets/update_references.py` sets the audited default image paths and non-hero CSS backgrounds.
3. `php scripts/assets/install.php` registers media and updates only matching audited placeholders. Custom values and pending page drafts are preserved. An assignment snapshot is saved before each run.
4. `npm run build` rebuilds the CSS references.

The inventory is the original pre-installation baseline; do not regenerate it before rerunning the installer. Existing records are matched against that baseline to avoid overwriting later edits.

## Verification

- Production build passed.
- Existing Laravel suite passed: 75 tests, 310 assertions.
- `php scripts/assets/verify.php` verified all 24 files, dimensions, checksums, media records and assignments, plus both protected hero files.
- Browser checks covered homepage, speaking, programmes, mentorship, leadership & impact, insights and book imagery. The book cover was checked at a 390px viewport and its image/grid sizing adjusted so the full artwork fits.
- Screenshots: `website-meet.png`, `website-speaking.png`, `website-insights.png`, `website-book-mobile.png` in this directory.
