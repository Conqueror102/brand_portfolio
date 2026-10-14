# Blue and silver brand palette

Working palette established from the user's blue and ash/silver direction. The approved font pairing is Manrope for headings and DM Sans for supporting text. It is a visual approximation; the exact reference font is unidentified.

## Typography and UI reference

Reference supplied on 14 October 2026: eacff09930c72b63a4c304295eca4549.jpg. Adopt its spacious white canvas, portrait-led composition, strong sans-serif name treatment, rounded image cards, pill buttons and contrasting lower feature section. Translate lime accents to brand blue and the charcoal feature section to navy. Adapt the content to Modupe's positioning; do not reuse the reference's people, logos, statistics or claims.

Manrope weights: 700 for section headings and 800 for prominent headlines. DM Sans weights: 400 for body copy, 500 for navigation/buttons and 600 for supporting emphasis. Font loading uses the existing Laravel Vite Bunny font integration and Blade @fonts directive. Families: Manrope and DM Sans.

Reusable CSS classes: brand-display (responsive large headings), brand-heading (section titles) and brand-body (reading text). Tailwind font-sans resolves to DM Sans; font-display resolves to Manrope. Uppercase is optional for the hero name, not imposed on all headings. Keep body text at comfortable sizes rather than reproducing the screenshot's tiny supporting text.

| Token | Hex | Use |
| --- | --- | --- |
| brand-navy | #142D4E | Headings, footer, occasional dark feature sections |
| brand-blue | #245A81 | Primary buttons, links and selective emphasis |
| brand-blue-hover | #1B4665 | Hover/active treatment for blue actions |
| brand-mist | #EAF0F5 | Quiet blue-tinted panels and selected states |
| brand-silver | #C5CBD3 | Decorative accents and small graphic details |
| brand-ash | #F3F4F6 | Alternating section backgrounds |
| brand-white | #FFFFFF | Main canvas, cards and text on navy/blue |
| brand-ink | #202B38 | Main body text |
| brand-muted | #596675 | Secondary text on white/ash/mist |
| brand-border | #DCE1E7 | Decorative separators |
| brand-control | #788594 | Input boundaries on white/ash/mist |

Aim for predominantly white/ash surfaces, with navy typography and selective blue actions. Silver is a flat cool neutral; metallic effects are optional decorative details, not a requirement. Avoid large areas of grey text or silver text on white.

Tailwind tokens live in resources/css/app.css; examples: bg-brand-ash, text-brand-navy, bg-brand-blue, hover:bg-brand-blue-hover and border-brand-control.

Use white labels on blue/navy buttons. Use blue links on light surfaces with an underline or another non-colour cue. Use a blue focus outline on light surfaces and white on dark surfaces, with enough offset to separate it from the control. Decorative borders must not be the only means of identifying a form control.

This establishes tokens for upcoming components; it does not restyle the starter welcome page. Semantic success/error/warning colours will be defined with the form components, with text/icons accompanying colour.
