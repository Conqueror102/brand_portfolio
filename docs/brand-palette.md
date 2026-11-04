# Modupe Olusoga — editorial design system

Selected direction: refined third Product Design concept, approved 14 October 2026. Earlier card layouts and typography experiments are superseded.

## Visual system

A warm near-white canvas, deep ink typography, quiet silver-blue architectural layers and a restrained apricot accent. The owner is the focal point. Horizontal navigation, an oversized name with an offset italic surname, and a slim editorial footer replace the card grid.

| Use | Colour |
| --- | --- |
| Primary ink | #102440 |
| Secondary slate | #435565 |
| Muted text | #526170 |
| Base canvas | #FCFAF7 |
| Fine dividers | #C1C7CF |
| Accent dot | #D9AD93 |

## Typography

Bodoni Moda 400/500 normal and italic for the brand, main name and headings. DM Sans 400/500/600 for supporting text, navigation and forms. The existing Laravel Vite font integration downloads local font assets. Main name uses 500 with an offset italic surname. Supporting text remains sans-serif.

## Artwork

Generated with the built-in image tool, using the approved revised concept as reference:

- public/images/editorial-background.png — 1586×992, quiet near-white architectural terraces. Prompt: extract only the reference's architectural environment; no people, furniture, text or UI; preserve pale silver-blue/apricot planes and generous blank typography space.
- public/images/editorial-portrait.png — 1100×1429 transparent portrait and chair. Prompt: isolate the selected concept woman's portrait, preserving her braided updo, seated pose, cream blouse and navy outfit; no text, architecture or interface; transparent background.

This is a generated concept portrait, not Modupe's real photograph. Replace with approved photography before publication. The illustration and all text are separate assets/elements so content remains editable and responsive.

## Responsive composition

On desktop, the frame fits the viewport above 490px in height. Title scale adapts to width; the portrait uses contain sizing within the hero height, centred in its right-hand area. This preserves the full portrait without spilling into the footer. On mobile, content stacks and scrolls naturally.

## Interaction scope

Navigation opens accessible dialogs with approved brief content. The speaking/connection enquiry form validates and persists to the local database before confirmation. Email delivery, admin review, production policy content and full destination pages remain future stages. The UI explicitly identifies the form as a development preview.
