# Editorial hero design QA

final result: passed

## Target and evidence

- Approved source: docs/previews/editorial-reference.png, 1586×992.
- Implementation: docs/previews/editorial-desktop.png, 1586×992 full-page browser capture.
- Short desktop: docs/previews/editorial-short.png, 1220×585.
- Mobile: docs/previews/editorial-mobile.png, 390×844 viewport with full-page capture.
- Source and desktop implementation were opened together in a single visual comparison. No browser chrome or density scaling was included.

## Comparison

The horizontal header, large serif name, offset italic surname, two-line positioning statement, architectural backdrop, primary/secondary actions and slim editorial footer match the approved composition. Bodoni Moda is the implementable visual match for the generated type, with DM Sans supporting text. Text and interface are real DOM content; artwork is separate.

User feedback supersedes the original portrait crop: the full portrait must fit, and the image must sit closer to the text. The portrait now uses contain sizing within its right-hand region. At the short viewport, image and hero heights both measure 465.33px; the image's top/bottom match the hero. The page height measures 585px, equal to the viewport, with all primary actions above the footer. This intentional fit differs from the source's cropped image.

## Interaction and verification

- About, Insights, Speaking and Programmes open content dialogs.
- Primary speaking action opens an enquiry form with speaking preselected.
- A synthetic browser submission saved successfully and returned explicit development confirmation; its database record was removed after the check.
- Four PHP tests passed, including valid persistence and invalid-input rejection (12 assertions).
- Mobile menu opens and its About action opens the expected dialog.
- Escape dismisses the dialog; native dialog focus behaviour is retained.
- No browser console errors observed.
- Frontend production build passed; the public background URL resolves at runtime.
- Headings/labels are readable in the inspected source/implementation pair; separate focused crops were unnecessary at the full source resolution.

## Limits and future work

- Portrait is generated concept imagery, to be replaced with approved photography.
- Enquiries are stored locally; production email, policies, admin review and destination pages are not implemented by this hero task. The form states this visibly.
- No claim of complete accessibility compliance; keyboard/dialog interactions and responsive overflow were checked.
- P3: minor type/portrait-pose differences from raster-generated mockup remain. No P0/P1/P2 issues remain for this scoped hero.
