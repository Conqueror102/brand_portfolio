{{-- Background images served by Laravel, so they load the same with `npm run dev` and `npm run build`. --}}
<style>:root {
    --bg-editorial: url('{{ asset('images/editorial-background.png') }}');
    --bg-portrait-context: url('{{ asset('images/generated/portrait-context-background.webp') }}');
    --bg-impact: url('{{ asset('images/generated/impact-background.webp') }}');
    --bg-cta: url('{{ asset('images/generated/cta-background.webp') }}');
}</style>
