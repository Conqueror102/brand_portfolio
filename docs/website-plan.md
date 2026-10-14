# Modupe Olusoga website — working build plan

Status: proposed architecture and scope; implementation has not started.
Colour foundation: blue with ash/silver, defined in brand-palette.md and resources/css/app.css. The approved typography pairs Manrope headings with DM Sans supporting text, inspired by the UI reference supplied on 14 October 2026. Public page implementation has not started.

## 1. Direction and working agreement

Build a personal thought-leadership platform connecting institution building with individual development. Speaking, mentorship, session requests and insights lead the launch experience. Organisations provide supporting evidence of leadership and impact.

Use the existing Laravel, Livewire, Blade and Tailwind project. This is a custom application with a content admin. Hosting selection follows the application's requirements.

The user will supply design references/templates, fonts and colours. For each reference, identify the intended section, study its hierarchy, spacing, composition and interaction, then adapt those ideas to Modupe's content and the shared design system. Use original implementation and appropriately licensed assets; do not copy another brand's identity, text or photographs. Maintain coherence across references rather than assembling unrelated sections.

Missing content should not block structural work. Store it as editable fields or draft records. Do not invent achievements, testimonials, article publications, photographs, dates or endorsements. Hide empty public sections. Keep development placeholders out of published pages.

## 2. Public navigation and routes

Launch header: About, Insights, Speaking, Programmes, Impact, and a persistent Book a Session button. The logo links home. Media and Contact are accessible in the footer and mobile navigation. Books and Podcast join the header when ready; support the complete proposed navigation without crowding desktop layouts.

| Page | Proposed route | Launch treatment |
| --- | --- | --- |
| Home | / | Live |
| About | /about | Live |
| Insights | /insights | Live when approved articles exist |
| Insight detail | /insights/{slug} | Published records only |
| Speaking | /speaking | Live |
| Programmes | /programmes | Live; support multiple programmes |
| Programme detail | /programmes/{slug} | Mentorship is the first programme |
| Programme application | /programmes/{slug}/apply | Open only for a configured cohort |
| Leadership & Impact | /impact | Live |
| Initiative detail | /impact/{slug} | Optional when there is enough content |
| Media | /media | Enable when approved material exists |
| Contact / enquiry | /contact | Live; supports preselected enquiry type |
| Books / book detail | /books, /books/{slug} | Draft first; publish waiting-list page when ready |
| Podcast / episode | /podcast, /podcast/{slug} | Future activation |
| Resources / resource detail | /resources, /resources/{slug} | Future activation |
| Privacy / terms | /privacy, /terms | Approved policies before collecting data |
| Form confirmation | Contextual confirmation state/page | No personal data in URLs |

## 3. Homepage sections, in order

1. **Header:** wordmark/name, concise navigation, Book a Session button, accessible mobile menu. Allow a temporary mentorship campaign link while applications are open.
2. **Hero:** portrait, a short positioning line, editorial headline and supporting statement. Working headline: “Building stronger institutions. Helping people turn aspiration into action.” Primary action: Invite Me to Speak. Secondary action: Explore My Insights. Final copy remains editable.
3. **Selected leadership:** restrained text-based proof points for Streamsowers & Köhn, ALAN and relevant international contribution. Describe exact roles; use logos only when supplied and approved.
4. **Two connected areas of work:** institution building, governance and succession; and clarity, leadership and intentional execution. Each connects to relevant insights, speaking or mentorship.
5. **Meet Modupe:** concise introduction, portrait/detail photograph, current leadership context and link to the full About page.
6. **Featured insights:** one lead article and two supporting articles, with topic, excerpt and date. Feature only published content; hide until available.
7. **Speaking and leadership conversations:** positioning, selected topics, available engagement formats, approved event image and invitation CTA.
8. **Mentorship feature:** proposition, six-month journey, cohort information and application CTA. State-aware presentation: forthcoming, applications open, applications closed or in progress. Do not display an unconfirmed year or deadline.
9. **Leadership & Impact:** short introduction and selected initiatives, keeping the personal brand central. Link to the Impact page.
10. **Book spotlight:** optional module for Building the Transgenerational Law Firm; activate with approved cover/copy and an operational waiting list. November 2027 is the supplied planned publication date and remains editable.
11. **Stay connected / final invitation:** at launch, a clear engagement CTA. Add newsletter signup when consent wording and subscription delivery are configured.
12. **Footer:** secondary navigation, verified social links, contact route, policy links and copyright.

Avoid making every section a competing CTA. Speaking leads; mentorship can temporarily take priority during recruitment. Book and podcast modules stay hidden until ready.

## 4. Individual page content

### About
- Opening statement and full biography.
- Philosophy linking institution building and individual execution.
- Selected career and leadership milestones, presented through verified contributions and outcomes.
- Current roles, professional credentials and executive education, accurately distinguished from degrees.
- Links to speaking, insights and impact work.
- Approved short biography and downloadable press biography when supplied.

### Insights listing and article
- This is also the blog: the admin can create, edit, preview, publish, unpublish and delete draft posts, manage categories and choose featured posts. Public navigation can use “Insights” while the admin label is “Blog & Insights”.
- Listing introduction, featured article, topic filters, search and pagination.
- Initial topics: Institution Building; Governance & Succession; Leadership; Professional Services; People & Performance; Intentional Execution.
- Article: title, standfirst, author, publication date, cover with alt text/credit, structured body, pull quotes, references, related articles and share link.
- Support original articles and clearly labelled external publications. Do not seed fabricated articles as published work.

### Speaking
- Speaking proposition, professional photograph or approved reel.
- Editable topics with descriptions and audience takeaways.
- Formats: keynote, panel, moderation, workshop, leadership/partner retreat.
- Relevant audiences and selected verified engagements.
- Optional approved testimonials, event gallery and downloadable speaker kit.
- Invitation form or preselected contact link. Requests are reviewed before scheduling.

### Programmes listing
- Programme philosophy, featured mentorship programme, other published offerings as they become available.
- Cards communicate audience, duration and current availability.

### Mentorship programme detail
- Core proposition: “You already have the aspiration. Are you ready to do the work?”
- Who it is for, expected commitment and who may not be a fit.
- Journey: Aspiration → Clarity → Action → Consistency → Results.
- Six-month structure; January orientation, February–July programme and July closing session, with cohort year explicitly configured before opening.
- Thursday sessions, 7–9 PM, with timezone and delivery location/mode confirmed before applications open.
- Investment: ₦200,000 as supplied; editable per cohort.
- What participation includes, application process, FAQs and application status.
- Limited cohort wording without invented capacity or false scarcity.

### Mentorship application
- Name, email, optional phone, profession/current role and location/timezone.
- Main goals, intended six-month outcomes, reason for applying and support/accountability needs.
- Confirmation of schedule availability and willingness to do work between sessions.
- Required privacy acknowledgement; optional marketing consent kept separate.
- Clear review process and confirmation reference after successful database storage.
- Payment instructions follow acceptance. No automatic public checkout at launch.

### Leadership & Impact
- Overview of professional leadership and social contribution.
- Dedicated content for Streamsowers & Köhn, ALAN, The Strides Platform and Project CHAM.
- For each: role/relationship, purpose, verified contribution, approved imagery and official external link.
- Optional longer initiative pages and outcomes as approved evidence becomes available.

### Media
- Interviews, speaking appearances, videos, podcasts and publications, filterable by type.
- Each item: title, outlet/event, date, description, thumbnail and approved embed/external link.
- Downloadable approved portraits, short/long bio and speaker kit; separate public press assets from private uploads.

### Contact / Book a Session
- Shared enquiry flow with type preselected by referring CTA.
- Types: speaking, moderation, workshop/retreat, coaching/session, advisory, media/podcast, book engagement and partnership.
- Core fields: name, email, organisation, enquiry type and message.
- Conditional engagement fields: proposed date, location/mode, audience, participant count, topic/objectives and other relevant details.
- Confirmation explains review precedes scheduling. Do not promise an unapproved response time or expose a public calendar.

### Books — later activation
- Book-specific landing page with synopsis, audience, themes, approved cover, print/digital formats and publication information.
- Waiting-list form first; preorder and purchase links only when enabled and configured.
- Optional excerpts, endorsements, bulk-purchase enquiry and related content.
- Keep multiple books possible without building checkout until its payment and fulfilment scope is agreed.

### Podcast — later activation
- Show proposition, artwork, platform links and episode listing.
- Episode pages with description, approved player, guest information, transcript and related resources.
- Guest/collaboration enquiries use the shared enquiry system.

### Resources and newsletter — later activation
- Resource cards and detail pages with descriptions, types and public downloads.
- Choose gated downloads only if needed; newsletter signup is not implicitly required for every download.
- Newsletter signup, preferences/unsubscribe support and integration with the selected delivery provider.

## 5. Admin experience

Use structured editing forms and reusable section types. She can change content and choose approved layouts without needing to edit code. Avoid a free-form page builder for the first version.

| Admin area | Required controls |
| --- | --- |
| Dashboard | New enquiries, pending applications, open cohorts, unpublished drafts and content-readiness notices |
| Profile & brand | Preferred name, positioning, short/full bio, approved credentials, portraits, logo, social links |
| Pages & homepage | Section headings/copy/images, visibility, featured records, ordering of supported sections, CTA labels and approved destinations |
| Insights | Draft/edit/preview/publish/unpublish, topics, cover, body, slug, related content and SEO |
| Reviews & testimonials | Add/edit, preview, publish/hide, order and feature approved reviews; manage attribution and associate with speaking, coaching, a programme or a book |
| Speaking | Topics, audiences, formats, selected engagements, testimonials and speaker-kit assets |
| Programmes | Programme copy, FAQs, imagery and reusable programme records |
| Cohorts | Year, dates, timezone, delivery mode, fee/currency, capacity if confirmed, application window and manual close |
| Applications | Search/filter, review answers, internal notes, assignee, status history and restricted CSV export |
| Enquiries | Search/filter by type/status/date, read details, assign owner, add private notes, record follow-up and approved scheduling link |
| Impact | Initiatives, role descriptions, verified outcomes, ordering and external links |
| Media & files | Upload/select assets, alt text, caption, credit, visibility, file validation and usage references before deletion |
| Books | Synopsis, themes, format, planned launch, cover, waiting-list state and later sales destinations |
| Podcast & resources | Draft content and feature switches; expose only configured published modules |
| Subscribers | Source, consent record, subscription state and restricted export/integration |
| Navigation & footer | Approved page links, ordering, social links and header CTA |
| Site settings | Enquiry recipient, notification settings, default SEO, social sharing image and policy content |
| Team & activity | User access, role changes, content changes and submission status audit history |

Fonts and colours supplied by the user become shared design tokens. Keep arbitrary CSS/font uploads out of the initial admin; offer controlled visual options only if needed.

### Permissions
- Owner: full access, users, settings, content and submissions.
- Editor: public content and media; no private applications, subscriber exports or user management by default.
- Coordinator: enquiries/applications and internal notes; no site-wide design or access changes.
- A single owner can operate launch; roles allow later delegation. No public admin registration.

### Reviews and testimonials
- Admin-managed testimonials are included in launch scope; public visitor review submissions are not assumed.
- Fields: quote, reviewer display name, optional role/organisation, optional approved portrait, engagement category, related programme/book where relevant, and optional date.
- Keep source/permission notes private; publish only approved wording and attribution.
- Support draft/published status, featured selection and display ordering. Use one testimonial record across homepage and relevant detail pages.
- Show a homepage testimonial section when approved reviews exist, plus contextual testimonials on Speaking, Programmes and Books pages. Hide empty sections.
- Do not invent quotes, identities, star ratings or aggregate review scores.

### Publishing and review
- Public content states: draft and published, with preview and explicit publish/unpublish actions.
- Preserve a published version while edits are being reviewed; record revisions and support restoration.
- Validate required fields before publishing or activating a module.
- Warn before changing published slugs; preserve old URLs through redirects.
- Missing optional content hides cleanly. Unconfigured forms cannot be activated accidentally.
- Track important admin changes and who made them.

### Application workflow
Submitted → Under review → Accepted / Waitlisted / Declined → Onboarding → Enrolled, with Withdrawn available where appropriate.

Store decisions separately from payment state (not requested / pending / confirmed). Record acceptance and onboarding correspondence. If automated messages are added, let the admin preview and explicitly send them; changing a status should not silently send a rejection email.

### Enquiry workflow
New → Reviewing → Awaiting information → Approved / Declined → Scheduled → Completed / Archived.

Scheduling is a reviewed next step. The submission inbox remains the source of truth even if a notification email fails.

## 6. Technical organisation

Suggested domains/models:
- Identity: User, roles/permissions and audit records.
- Site: Profile, SiteSetting, NavigationItem, Page, PageSection and content revisions.
- Publishing: Article, Topic, MediaAsset, MediaAppearance, SpeakingTopic and SpeakingEngagement.
- Social proof: Testimonial with attribution, publication status, featured placement and optional content relationship.
- Programmes: Programme, Cohort, Application and application status history/notes.
- Engagements: Enquiry and enquiry status history/notes.
- Impact: Initiative.
- Expansion: Book, Subscriber/SubscriptionInterest, PodcastEpisode and Resource.

Keep reusable content as records referenced by homepage sections, so an article or programme update does not need to be repeated in several places. Use constrained structured data for section configuration, with server-side validation. Defer expansion tables until their implementation phase where practical.

Public presentation uses reusable Blade components. Livewire supports forms, filtering and admin interactions. Use a production relational database, managed file storage appropriate to deployment, queued notifications and scheduled backups. Choose specific providers at deployment time.

Admin authentication needs secure login, password reset, session protection and login throttling; enable two-factor authentication for privileged accounts. Enforce permissions on the server. Validate rich text, uploaded file types/sizes and form inputs. Private submissions and exports must never be served from public asset URLs.

All public forms need validation, spam controls, duplicate-submit protection, accessible error states and reliable persistence. Save before sending notifications; retry mail failures. Collect only necessary applicant data, record consent where applicable and support configurable retention/deletion. Keep credentials out of editable public settings.

## 7. Build sequence and acceptance

### Stage 1 — Structure and design foundation
Confirm this working plan; establish reusable layout/components, content fields, page skeletons and section priorities. Integrate the user's fonts/colours and adapt supplied references section by section. Keep a small design decision log so later pages stay consistent.

### Stage 2 — Admin and content foundation
Implement login/permissions, profile/site settings, media, core page sections and draft/preview/publish. Create editable approved source content from the questionnaire. Keep unknown values blank or draft.

### Stage 3 — Public launch pages
Implement homepage, About, Insights, Speaking, Programmes, Impact, Media and Contact using shared components. Activate only content-ready pages. Check desktop and mobile layouts as each section is completed.

### Stage 4 — Enquiries and mentorship
Implement cohort configuration, enquiry submission, mentorship applications, admin review, statuses, exports and notification handling. Confirm date/year, timezone, contact delivery and policy content before enabling live collection.

### Stage 5 — Launch readiness
Verify the owner can update content without code; unpublished/private records cannot be accessed publicly; application windows behave correctly; stored submissions survive mail failures; permissions work; and forms handle errors/duplicates. Check keyboard access, contrast, responsive layouts, image optimisation, metadata, sitemap, social previews, broken links, backups and restore procedure. Replace/hide all placeholders.

### Stage 6 — Progressive expansion
Activate the book waiting list and newsletter, then podcast/resources. Introduce checkout only with defined payments, order management, refunds and print/digital fulfilment requirements. A participant portal, course LMS and full CRM are separate future scope unless later requested.

## 8. Deferred inputs and activation rules

| Input | Where it will be editable | Needed before |
| --- | --- | --- |
| Fonts and palette | Shared implementation design tokens | Final visual approval |
| Full biography, portraits, social links | Profile and media admin | Publishing affected content |
| Official organisation links | Impact admin | Showing external links |
| Programme year, dates, timezone, capacity and mode | Cohort admin | Opening applications |
| Dedicated enquiry email | Notification settings | Enabling email notifications |
| Real articles, media, engagements and testimonials | Respective content modules | Publishing those sections |
| Book cover, price and sales links | Books admin | Cover display / preorder / sales activation |
| Domain, hosting, mail and newsletter providers | Deployment configuration/integrations | Production launch of relevant features |
| Privacy wording and retention choices | Policy content and admin settings | Collecting live personal data |

These are tracked decisions, not questions that need answering now.
