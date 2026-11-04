document.documentElement.classList.add('js');

// Close the mobile menu when clicking outside it.
document.addEventListener('click', (event) => {
    const menu = document.querySelector('.mobile-nav[open]');
    if (menu && !menu.contains(event.target)) menu.removeAttribute('open');
});

// Motion: content slides in from the side it sits on, headings rise word by word, cards tilt, buttons are magnetic.
const calm = !window.matchMedia('(prefers-reduced-motion: reduce)').matches;
const onPublicPage = !document.body.classList.contains('admin-body') && !document.body.classList.contains('admin-login');
const finePointer = window.matchMedia('(hover: hover) and (pointer: fine)').matches;

let motionOk = onPublicPage && calm;
if (motionOk) try {
    const inHero = (el) => el.closest('.editorial-hero, .editorial-header, .page-header');

    // Headings: split into words so each one can rise in turn.
    document.querySelectorAll('main h1, main h2, .display, .meet h2, .insights-head h2, .moments-head h2').forEach((heading) => {
        if (inHero(heading) || heading.dataset.split) return;
        heading.dataset.split = '1';
        let index = 0;
        const split = (node) => {
            [...node.childNodes].forEach((child) => {
                if (child.nodeType === Node.TEXT_NODE) {
                    const parts = child.textContent.split(/(\s+)/);
                    const fragment = document.createDocumentFragment();
                    parts.forEach((part) => {
                        if (!part) return;
                        if (/^\s+$/.test(part)) {
                            fragment.append(document.createTextNode(part));
                            return;
                        }
                        const word = document.createElement('span');
                        word.className = 'word';
                        const inner = document.createElement('span');
                        inner.className = 'word-inner';
                        inner.style.setProperty('--wi', index++);
                        inner.textContent = part;
                        word.append(inner);
                        fragment.append(word);
                    });
                    child.replaceWith(fragment);
                } else if (child.nodeType === Node.ELEMENT_NODE && child.tagName !== 'BR' && !child.classList.contains('word')) {
                    split(child);
                }
            });
        };
        split(heading);
        heading.setAttribute('data-reveal', 'words');
    });

    // Blocks that animate without needing data-reveal in the markup.
    const autoReveal = [
        'main > section > header', '.section-head', '.page-hero-simple > *', '.article-head > *', '.meet > *', '.insights-head',
        '.insight-feature', '.insight-list li', '.impact-row > *', '.moments-head', '.journey li', '.facts > div',
        '.engagement', '.episode-list li', '.download-list li', '.faq-item', '.site-footer-top > *', '.site-footer-news',
        '.article-body > *', '.tags > *', '.format-list > *', '.actions > *', 'main p.lede', 'main .eyebrow',
    ].join(', ');
    document.querySelectorAll(autoReveal).forEach((el) => {
        if (el.hasAttribute('data-reveal') || inHero(el) || el.closest('[data-reveal="words"]')) return;
        const nestedOk = el.matches('.journey li, .facts > div, .tags > *, .actions > *');
        if (!nestedOk && el.parentElement.closest('[data-reveal]')) return;
        el.setAttribute('data-reveal', '');
    });

    // Photo frames wipe open from their outer edge.
    const frames = '.frame, .meet-portrait, .meet-photo, .programme-card-img, .home-mentorship-art, .book-cover-img';
    document.querySelectorAll(frames).forEach((el) => {
        if (inHero(el)) return;
        const box = el.getBoundingClientRect();
        el.setAttribute('data-reveal', box.left + box.width / 2 < window.innerWidth / 2 ? 'wipe-left' : 'wipe-right');
    });

    // Direction comes from position: left column slides from the left, right column from the right, centred items rise.
    const groups = new Map();
    document.querySelectorAll('[data-reveal=""]').forEach((el) => {
        const box = el.getBoundingClientRect();
        const centre = (box.left + box.width / 2) / window.innerWidth;
        const wide = box.width > window.innerWidth * 0.7;
        el.setAttribute('data-reveal', wide ? 'up' : centre < 0.42 ? 'left' : centre > 0.58 ? 'right' : 'up');
        if (el.matches('.icon-chip, .tags > *, .facts > div, .journey li')) el.setAttribute('data-reveal', 'pop');
    });
    document.querySelectorAll('[data-reveal]').forEach((el) => {
        const siblings = groups.get(el.parentElement) ?? [];
        siblings.push(el);
        groups.set(el.parentElement, siblings);
    });
    groups.forEach((items) => items.forEach((el, i) => el.style.setProperty('--reveal-delay', `${Math.min(i, 7) * 0.11}s`)));
} catch (error) {
    // If anything above fails, leave the page fully visible instead of half-hidden.
    motionOk = false;
    console.error(error);
}

// Reveal on scroll. Positions are checked directly rather than with IntersectionObserver,
// because a card that clips its contents would hide a child that is still sliding in.
const pending = [...document.querySelectorAll('[data-reveal]')];
const reveal = (el) => {
    el.classList.add('is-visible');
    // Once the entrance has played, hover effects take over the element's transform.
    const delay = parseFloat(el.style.getPropertyValue('--reveal-delay')) || 0;
    setTimeout(() => el.classList.add('is-settled'), 1400 + delay * 1000);
};
if (motionOk) {
    let queued = false;
    const check = () => {
        queued = false;
        const line = window.innerHeight * 0.9;
        for (let i = pending.length - 1; i >= 0; i--) {
            const box = pending[i].getBoundingClientRect();
            if (box.top - 120 < line && box.bottom + 120 > 0) {
                reveal(pending[i]);
                pending.splice(i, 1);
            }
        }
    };
    const queue = () => {
        if (!queued && pending.length) {
            queued = true;
            requestAnimationFrame(check);
        }
    };
    // Capture catches scrolling on any container, not just the window.
    document.addEventListener('scroll', queue, { passive: true, capture: true });
    window.addEventListener('resize', queue);
    window.addEventListener('load', queue);
    // Safety net for anything a missed scroll event would leave hidden.
    const sweep = setInterval(() => (pending.length ? queue() : clearInterval(sweep)), 400);
    document.documentElement.classList.add('motion-ready');
    // Let the hidden state paint once so on-screen items animate in too.
    requestAnimationFrame(() => requestAnimationFrame(check));
} else {
    pending.forEach(reveal);
}

if (onPublicPage && calm && finePointer) {
    // Cards tilt toward the cursor and catch a soft light.
    document.querySelectorAll('.card, .article-card, .link-card, .engagement, .episode, .resource-card, .meet-intro, .meet-perspective, .insight-feature, .moment figure').forEach((card) => {
        if (card.closest('.editorial-hero') || card.querySelector('form') || card.offsetWidth > window.innerWidth * 0.75) return;
        card.setAttribute('data-tilt', '');
        const strength = Math.max(2, Math.min(7, 2400 / card.offsetWidth));
        card.addEventListener('pointermove', (event) => {
            const box = card.getBoundingClientRect();
            const x = (event.clientX - box.left) / box.width;
            const y = (event.clientY - box.top) / box.height;
            card.classList.add('is-tilting');
            card.style.setProperty('--ry', `${((x - 0.5) * strength).toFixed(2)}deg`);
            card.style.setProperty('--rx', `${((0.5 - y) * strength).toFixed(2)}deg`);
            card.style.setProperty('--mx', `${(x * 100).toFixed(1)}%`);
            card.style.setProperty('--my', `${(y * 100).toFixed(1)}%`);
        });
        card.addEventListener('pointerleave', () => {
            card.classList.remove('is-tilting');
            card.style.setProperty('--rx', '0deg');
            card.style.setProperty('--ry', '0deg');
        });
    });

    // Buttons lean toward the cursor.
    document.querySelectorAll('.btn, .speaking-button, .connect-button').forEach((button) => {
        button.addEventListener('pointermove', (event) => {
            const box = button.getBoundingClientRect();
            button.classList.add('is-magnet');
            button.style.setProperty('--mag-x', `${((event.clientX - box.left - box.width / 2) * 0.25).toFixed(1)}px`);
            button.style.setProperty('--mag-y', `${((event.clientY - box.top - box.height / 2) * 0.35).toFixed(1)}px`);
        });
        button.addEventListener('pointerleave', () => {
            button.classList.remove('is-magnet');
            button.style.setProperty('--mag-x', '0px');
            button.style.setProperty('--mag-y', '0px');
        });
    });

    // A soft ring follows the cursor and opens up over anything clickable.
    const ring = document.createElement('div');
    ring.className = 'cursor-ring';
    ring.setAttribute('aria-hidden', 'true');
    document.body.append(ring);
    let tx = 0;
    let ty = 0;
    let cx = 0;
    let cy = 0;
    window.addEventListener('pointermove', (event) => {
        tx = event.clientX;
        ty = event.clientY;
        ring.classList.add('is-on');
        ring.classList.toggle('is-hover', !!event.target.closest('a, button, summary, label, [data-tilt], input, select, textarea'));
    }, { passive: true });
    document.addEventListener('pointerleave', () => ring.classList.remove('is-on'));
    window.addEventListener('pointerdown', () => ring.classList.add('is-down'));
    window.addEventListener('pointerup', () => ring.classList.remove('is-down'));
    const follow = () => {
        cx += (tx - cx) * 0.18;
        cy += (ty - cy) * 0.18;
        ring.style.transform = `translate3d(${cx}px, ${cy}px, 0)`;
        requestAnimationFrame(follow);
    };
    follow();
}

// Photos inside rounded frames drift slower than the page.
if (onPublicPage && calm && window.matchMedia('(min-width: 900px)').matches) {
    const layers = [...document.querySelectorAll('.frame > img, .meet-portrait > img, .meet-photo > img, .home-mentorship-art > img')]
        .filter((img) => getComputedStyle(img.parentElement).overflow === 'hidden');
    layers.forEach((img) => img.setAttribute('data-parallax', ''));
    let ticking = false;
    const update = () => {
        layers.forEach((img) => {
            const box = img.parentElement.getBoundingClientRect();
            if (box.bottom < 0 || box.top > window.innerHeight) return;
            const offset = (box.top + box.height / 2 - window.innerHeight / 2) / window.innerHeight;
            img.style.setProperty('--parallax', `${(offset * -40).toFixed(1)}px`);
        });
        ticking = false;
    };
    window.addEventListener('scroll', () => {
        if (!ticking) {
            ticking = true;
            requestAnimationFrame(update);
        }
    }, { passive: true });
    update();
}

// Show fields that only apply to some choices: <div data-show-when="type" data-show-values="speaking,panel">.
document.querySelectorAll('[data-show-when]').forEach((block) => {
    const form = block.closest('form');
    const control = form?.querySelector(`[name="${block.dataset.showWhen}"]`);
    if (!control) return;
    const values = block.dataset.showValues.split(',');
    const sync = () => {
        const current = control.type === 'radio' ? form.querySelector(`[name="${control.name}"]:checked`)?.value : control.value;
        block.hidden = !values.includes(current);
    };
    form.querySelectorAll(`[name="${block.dataset.showWhen}"]`).forEach((c) => c.addEventListener('change', sync));
    sync();
});

// Prevent double submissions.
document.querySelectorAll('form[data-once]').forEach((form) => {
    form.addEventListener('submit', () => {
        const button = form.querySelector('[type="submit"]');
        if (button) {
            button.disabled = true;
            button.dataset.label = button.textContent;
        }
    });
});

// Admin: confirm destructive actions.
document.querySelectorAll('[data-confirm]').forEach((el) => {
    el.addEventListener('submit', (event) => {
        if (!window.confirm(el.dataset.confirm)) event.preventDefault();
    });
});

// Admin: confirm a single destructive button inside a larger form.
document.querySelectorAll('[data-confirm-click]').forEach((button) => {
    button.addEventListener('click', (event) => {
        if (!window.confirm(button.dataset.confirmClick)) event.preventDefault();
    });
});

// Admin: reorder homepage sections with the arrow buttons; numbers stay in sync for the server.
document.querySelectorAll('[data-sortable]').forEach((list) => {
    const renumber = () => list.querySelectorAll('.section-order-num').forEach((input, i) => { input.value = i + 1; });
    list.addEventListener('click', (event) => {
        const button = event.target.closest('[data-move]');
        if (!button) return;
        const item = button.closest('li');
        if (button.dataset.move === 'up' && item.previousElementSibling) item.previousElementSibling.before(item);
        if (button.dataset.move === 'down' && item.nextElementSibling) item.nextElementSibling.after(item);
        renumber();
        button.focus();
    });
});

// Admin: show the newly chosen image in a media picker.
document.querySelectorAll('[data-media-picker]').forEach((picker) => {
    const current = picker.querySelector('.media-picker-current');
    const show = (src) => {
        current.innerHTML = '';
        if (src) {
            const img = document.createElement('img');
            img.src = src;
            img.alt = '';
            current.append(img);
        } else {
            current.innerHTML = '<span class="media-picker-empty">Nothing selected</span>';
        }
    };
    picker.addEventListener('change', (event) => {
        if (event.target.type === 'radio') {
            const img = event.target.closest('label')?.querySelector('img');
            if (img || !event.target.value) show(img?.src);
        }
        if (event.target.type === 'file' && event.target.files[0]?.type.startsWith('image/')) {
            show(URL.createObjectURL(event.target.files[0]));
        }
    });
});

// Media page: filter appearances by type.
document.querySelectorAll('.media-filter').forEach((nav) => {
    const cards = nav.parentElement.querySelectorAll('[data-type]');
    nav.addEventListener('click', (event) => {
        const button = event.target.closest('[data-filter]');
        if (!button) return;
        nav.querySelectorAll('[data-filter]').forEach((b) => {
            b.classList.toggle('is-active', b === button);
            b.setAttribute('aria-pressed', b === button ? 'true' : 'false');
        });
        cards.forEach((card) => { card.hidden = button.dataset.filter !== '' && card.dataset.type !== button.dataset.filter; });
    });
});

// ── Authority layer ──────────────────────────────────────────────

// Figures count up when they come into view ("82%", "20+", "100+", "₦200k"). Text that is not a number is left alone.
(() => {
    const figures = [...document.querySelectorAll('[data-count]')];
    if (!figures.length) return;
    const parse = (text) => {
        const m = String(text).match(/^(\D*?)(\d[\d,]*(?:\.\d+)?)(.*)$/);
        return m ? { pre: m[1], num: parseFloat(m[2].replace(/,/g, '')), decimals: (m[2].split('.')[1] || '').length, post: m[3], comma: m[2].includes(',') } : null;
    };
    const format = (p, v) => {
        let s = v.toFixed(p.decimals);
        if (p.comma) s = Number(s).toLocaleString('en-GB', { minimumFractionDigits: p.decimals });
        return p.pre + s + p.post;
    };
    if (!calm || !onPublicPage) return;
    figures.forEach((el) => {
        const p = parse(el.dataset.count);
        if (!p) return;
        el.textContent = format(p, 0);
        el.dataset.countReady = '1';
    });
    const run = (el) => {
        const p = parse(el.dataset.count);
        if (!p) return;
        const start = performance.now();
        const duration = 1600 + Math.min(p.num, 100) * 6;
        const tick = (now) => {
            const t = Math.min((now - start) / duration, 1);
            const eased = 1 - Math.pow(1 - t, 4);
            el.textContent = format(p, p.num * eased);
            if (t < 1) requestAnimationFrame(tick); else el.textContent = el.dataset.count;
        };
        requestAnimationFrame(tick);
    };
    const io = new IntersectionObserver((entries) => entries.forEach((entry) => {
        if (!entry.isIntersecting) return;
        io.unobserve(entry.target);
        setTimeout(() => run(entry.target), 250);
    }), { threshold: 0.4 });
    figures.filter((el) => el.dataset.countReady).forEach((el) => io.observe(el));
})();

// Career journey: on wide screens the section pins and the timeline travels sideways as the page scrolls.
(() => {
    const section = document.querySelector('[data-journey]');
    if (!section) return;
    const sticky = section.querySelector('.career-sticky');
    const track = section.querySelector('[data-journey-track]');
    const stops = [...section.querySelectorAll('[data-journey-stop]')];
    const current = section.querySelector('[data-journey-current]');
    const ghost = section.querySelector('[data-journey-ghost]');
    const wide = window.matchMedia('(min-width: 901px)');
    let distance = 0;
    let lastActive = -1;
    const layout = () => {
        section.classList.remove('is-pinned', 'is-swipe');
        section.style.removeProperty('--journey-height');
        track.style.transform = '';
        distance = 0;
        if (!wide.matches) return;
        const overflow = track.scrollWidth - window.innerWidth;
        if (overflow < 40) return;
        if (!calm) { section.classList.add('is-swipe'); return; }
        section.classList.add('is-pinned');
        // Pin only when the whole chapter view fits on screen; otherwise let the rail scroll sideways by itself.
        const cs = getComputedStyle(sticky);
        const part = (sel) => sticky.querySelector(sel)?.offsetHeight || 0;
        const needed = Math.max(part('.career-head'), part('.career-rail')) + part('.career-progress') + 40 + parseFloat(cs.paddingTop) + parseFloat(cs.paddingBottom);
        if (needed > window.innerHeight) { section.classList.remove('is-pinned'); section.classList.add('is-swipe'); return; }
        distance = overflow;
        section.style.setProperty('--journey-height', `${window.innerHeight + distance}px`);
    };
    const update = () => {
        const box = section.getBoundingClientRect();
        let progress;
        if (distance) {
            progress = Math.min(Math.max(-box.top / distance, 0), 1);
            track.style.transform = `translate3d(${-progress * distance}px, 0, 0)`;
        } else {
            const vh = window.innerHeight;
            progress = Math.min(Math.max((vh * 0.6 - box.top) / box.height, 0), 1);
        }
        section.style.setProperty('--journey-progress', progress.toFixed(4));
        const active = Math.min(stops.length - 1, Math.floor(progress * stops.length + 0.0001));
        stops.forEach((stop, i) => { stop.classList.toggle('is-passed', i <= active); stop.classList.toggle('is-active', i === active); });
        if (current) current.textContent = String(active + 1).padStart(2, '0');
        if (ghost && active !== lastActive) {
            const year = stops[active]?.dataset.year || '';
            if (lastActive === -1 || calm === false) ghost.textContent = year;
            else { ghost.classList.add('is-swapping'); setTimeout(() => { ghost.textContent = year; ghost.classList.remove('is-swapping'); }, 220); }
            lastActive = active;
        }
    };
    layout();
    update();
    let raf = 0;
    document.addEventListener('scroll', () => { cancelAnimationFrame(raf); raf = requestAnimationFrame(update); }, { passive: true });
    window.addEventListener('resize', () => { layout(); update(); });
    window.addEventListener('load', () => { layout(); update(); });
})();

// Selected work: a photo follows the cursor over each row.
(() => {
    const peek = document.querySelector('[data-work-peek]');
    if (!peek || !calm || !finePointer) return;
    const img = peek.querySelector('img');
    let x = 0, y = 0, tx = 0, ty = 0, raf = 0, on = false;
    const loop = () => {
        x += (tx - x) * 0.16; y += (ty - y) * 0.16;
        peek.style.setProperty('--px', `${x}px`); peek.style.setProperty('--py', `${y}px`);
        peek.style.setProperty('--prot', `${Math.max(-8, Math.min(8, (tx - x) * 0.05)) - 3}deg`);
        if (on || Math.abs(tx - x) > 0.5) raf = requestAnimationFrame(loop);
    };
    document.querySelectorAll('[data-work-list] .work-row').forEach((row) => {
        row.addEventListener('mouseenter', () => {
            if (!row.dataset.peek) return;
            img.src = row.dataset.peek;
            on = true; peek.classList.add('is-on');
            cancelAnimationFrame(raf); raf = requestAnimationFrame(loop);
        });
        row.addEventListener('mouseleave', () => { on = false; peek.classList.remove('is-on'); });
        row.addEventListener('mousemove', (e) => { tx = e.clientX + 28; ty = e.clientY - 120; });
    });
})();

// Proof of practice: scroll-driven card stack. The centre card is a full story; the rest fan out as image pills.
(() => {
    const section = document.querySelector('[data-stack]');
    if (!section) return;
    const stage = section.querySelector('[data-stack-stage]');
    const cards = [...section.querySelectorAll('[data-stack-card]')];
    const dots = [...section.querySelectorAll('[data-stack-dot]')];
    const n = cards.length;
    const wide = window.matchMedia('(min-width: 901px)');
    let pos = 0;          // current (fractional) position in card units
    let pinned = false;
    const lerp = (a, b, t) => a + (b - a) * t;
    const geometry = () => {
        const W = stage.clientWidth ? cards[0].offsetWidth : 0;
        const H = cards[0].offsetHeight;
        const small = !wide.matches;
        const pills = small ? [W, 34, 20, 0] : [W, Math.min(150, W * 0.17), Math.min(108, W * 0.12), Math.min(70, W * 0.08), 0];
        const heights = small ? [H, H * 0.78, H * 0.6, 0] : [H, H * 0.8, H * 0.64, H * 0.5, 0];
        const gap = small ? 10 : 16;
        const xs = [0];
        for (let i = 1; i < pills.length; i++) xs[i] = xs[i - 1] + pills[i - 1] / 2 + gap + pills[i] / 2;
        return { pills, heights, xs };
    };
    let geo = null;
    const render = () => {
        if (!geo) geo = geometry();
        const { pills, heights, xs } = geo;
        const last = pills.length - 1;
        cards.forEach((card, i) => {
            const d = i - pos;
            const a = Math.min(Math.abs(d), last);
            const k = Math.floor(a);
            const f = a - k;
            const w = lerp(pills[k], pills[Math.min(k + 1, last)], f);
            const h = lerp(heights[k], heights[Math.min(k + 1, last)], f);
            const x = Math.sign(d) * lerp(xs[k], xs[Math.min(k + 1, last)], f);
            card.style.setProperty('--x', `${x.toFixed(1)}px`);
            card.style.setProperty('--w', `${w.toFixed(1)}px`);
            card.style.setProperty('--h', `${h.toFixed(1)}px`);
            card.style.setProperty('--t', Math.min(a, 1).toFixed(3));
            card.style.setProperty('--z', String(100 - Math.round(a * 10)));
            card.style.setProperty('--o', a >= last - 0.05 ? '0' : '1');
            const active = Math.abs(d) < 0.5;
            card.classList.toggle('is-active', active);
            card.classList.toggle('is-side', !active);
            card.setAttribute('aria-hidden', active ? 'false' : 'true');
            card.querySelector('[data-stack-link]').tabIndex = active ? 0 : -1;
        });
        const current = Math.round(pos);
        dots.forEach((dot, i) => {
            dot.classList.toggle('is-on', i === current);
            dot.setAttribute('aria-selected', i === current ? 'true' : 'false');
        });
    };
    const scrollSpan = () => window.innerHeight * 0.75;
    const layout = () => {
        section.classList.remove('is-pinned');
        section.style.removeProperty('--stack-height');
        pinned = false;
        geo = null;
        if (wide.matches && calm && n > 1) {
            section.classList.add('is-pinned');
            const sticky = section.querySelector('.stack-sticky');
            const fits = [...sticky.children].filter((el) => !el.classList.contains('stack-glow')).reduce((s, el) => s + el.offsetHeight, 0) + 60 <= window.innerHeight;
            if (fits) {
                pinned = true;
                section.style.setProperty('--stack-height', `${window.innerHeight + (n - 1) * scrollSpan()}px`);
            } else section.classList.remove('is-pinned');
        }
        geo = geometry();
        render();
    };
    const fromScroll = () => {
        if (!pinned) return;
        const top = -section.getBoundingClientRect().top;
        const raw = Math.min(Math.max(top / scrollSpan(), 0), n - 1);
        // ease towards whole cards so each story rests in the centre for a beat
        const k = Math.floor(raw);
        const f = raw - k;
        const eased = f < 0.25 ? 0 : f > 0.75 ? 1 : (f - 0.25) / 0.5;
        const next = k + (eased * eased * (3 - 2 * eased));
        section.classList.add('is-scrubbing');
        pos = next;
        render();
        const dot = dots[Math.round(pos)];
        if (dot) dot.style.setProperty('--fill', '1');
    };
    const go = (index) => {
        index = Math.max(0, Math.min(n - 1, index));
        section.classList.remove('is-scrubbing');
        if (pinned) {
            const target = section.getBoundingClientRect().top + window.scrollY + index * scrollSpan() + scrollSpan() * 0.5 * (index ? 1 : 0);
            window.scrollTo({ top: target, behavior: 'smooth' });
        } else { pos = index; render(); }
    };
    cards.forEach((card, i) => card.querySelector('[data-stack-link]').addEventListener('click', (e) => {
        if (Math.round(pos) !== i) { e.preventDefault(); go(i); }
    }));
    dots.forEach((dot, i) => dot.addEventListener('click', () => go(i)));
    section.querySelector('[data-stack-prev]')?.addEventListener('click', () => go(Math.round(pos) - 1));
    section.querySelector('[data-stack-next]')?.addEventListener('click', () => go(Math.round(pos) + 1));
    stage.addEventListener('keydown', (e) => {
        if (e.key === 'ArrowRight') { e.preventDefault(); go(Math.round(pos) + 1); }
        if (e.key === 'ArrowLeft') { e.preventDefault(); go(Math.round(pos) - 1); }
    });
    let sx = null;
    stage.addEventListener('touchstart', (e) => { sx = e.touches[0].clientX; }, { passive: true });
    stage.addEventListener('touchend', (e) => {
        if (sx === null) return;
        const dx = e.changedTouches[0].clientX - sx;
        if (Math.abs(dx) > 40) go(Math.round(pos) + (dx < 0 ? 1 : -1));
        sx = null;
    });
    let raf = 0;
    document.addEventListener('scroll', () => { cancelAnimationFrame(raf); raf = requestAnimationFrame(fromScroll); }, { passive: true });
    window.addEventListener('resize', () => { layout(); fromScroll(); });
    window.addEventListener('load', () => { layout(); fromScroll(); });
    layout();
    fromScroll();
})();
