import Alpine from 'alpinejs';
import './alert';
import tinymce from 'tinymce';
import 'tinymce/icons/default';
import 'tinymce/models/dom';
import 'tinymce/themes/silver';
import 'tinymce/skins/ui/oxide/skin.js';
import 'tinymce/skins/ui/oxide/content.js';
import 'tinymce/skins/content/default/content.js';
import 'tinymce/plugins/advlist';
import 'tinymce/plugins/autolink';
import 'tinymce/plugins/link';
import 'tinymce/plugins/lists';
import 'tinymce/plugins/wordcount';

import { createIcons, icons } from 'lucide';
import { DataTable } from 'simple-datatables';

window.Alpine = Alpine;
window.createIcons = createIcons;
window.tinymce = tinymce;

Alpine.start();

const initIcons = () => {
    const render = () => {
        try {
            createIcons({ icons });
        } catch (error) {
            console.error('[Ruang Cinema] Lucide initialization failed:', error);
        }
    };

    render();
    requestAnimationFrame(render);
};

const initDataTables = () => {
    const options = {
        searchable: true,
        sortable: true,
        paging: true,
        perPage: 5,
        perPageSelect: [5, 10],
        labels: {
            placeholder: 'Search...',
            noRows: 'No records found',
            info: 'Showing {start} to {end} of {rows} entries',
        },
    };

    ['recent-movies-table', 'recent-users-table', 'genres-table', 'users-table'].forEach((id) => {
        const table = document.getElementById(id);

        if (table) {
            new DataTable(`#${id}`, options);
        }
    });
};

const initImagePreviews = () => {
    document.querySelectorAll('[data-image-preview-input]').forEach((input) => {
        input.addEventListener('change', () => {
            const preview = document.getElementById(`${input.dataset.imagePreviewInput}-preview`);
            const placeholder = document.getElementById(`${input.dataset.imagePreviewInput}-upload-placeholder`);
            const file = input.files?.[0];

            if (!preview || !placeholder) return;

            if (!file) {
                preview.classList.add('hidden');
                preview.classList.remove('flex');
                placeholder.classList.remove('hidden');
                return;
            }

            const image = preview.querySelector('img');
            const fileName = preview.querySelector('[data-image-preview-name]');

            image.src = URL.createObjectURL(file);
            fileName.textContent = file.name;
            placeholder.classList.add('hidden');
            preview.classList.remove('hidden');
            preview.classList.add('flex');
        });
    });
};

const initSlugPreviews = () => {
    document.querySelectorAll('[data-slug-source]').forEach((source) => {
        const target = document.getElementById(source.dataset.slugTarget);

        if (!target) return;

        const updateSlug = () => {
            target.value = source.value
                .normalize('NFD')
                .replace(/[\u0300-\u036f]/g, '')
                .toLowerCase()
                .trim()
                .replace(/[^a-z0-9]+/g, '-')
                .replace(/^-+|-+$/g, '');
        };

        source.addEventListener('input', updateSlug);
        updateSlug();
    });
};

const initHorizontalCarousels = () => {
    document.querySelectorAll('[data-horizontal-carousel]').forEach((carousel) => {
        const viewport = carousel.querySelector('[data-horizontal-carousel-viewport]');
        const track = carousel.querySelector('[data-horizontal-carousel-track]');
        const button = carousel.querySelector('[data-horizontal-carousel-next]');
        const previousButton = carousel.querySelector('[data-horizontal-carousel-prev]');

        if (!viewport || !track || !button || !previousButton) return;
        if (button.dataset.carouselBound) return;

        button.dataset.carouselBound = 'true';
        previousButton.dataset.carouselBound = 'true';
        let position = 0;

        const move = (direction) => {
            const firstCard = track.firstElementChild;
            if (!firstCard) return;

            const gap = Number.parseFloat(getComputedStyle(track).columnGap || getComputedStyle(track).gap) || 0;
            const step = firstCard.getBoundingClientRect().width + gap;
            const maxPosition = Math.max(track.scrollWidth - viewport.clientWidth, 0);

            position = Math.max(0, Math.min(position + (step * direction), maxPosition));
            track.style.transform = `translateX(-${position}px)`;

            previousButton.classList.toggle('hidden', position <= 0);
            previousButton.classList.toggle('flex', position > 0);
            button.classList.toggle('pointer-events-none', position >= maxPosition);
            button.classList.toggle('opacity-40', position >= maxPosition);
        };

        button.addEventListener('click', () => move(1));
        previousButton.addEventListener('click', () => move(-1));
    });
};

const initPreline = async () => {
    try {
        await import('preline');
        window.HSStaticMethods?.autoInit();
    } catch (error) {
        console.error('[Ruang Cinema] Preline initialization failed:', error);
    }
};

const initRichTextEditors = () => {
    const textareas = document.querySelectorAll('textarea[data-tinymce]');

    if (!textareas.length || !window.tinymce) return;

    window.tinymce.init({
        selector: 'textarea[data-tinymce]',
        license_key: 'gpl',
        menubar: false,
        branding: false,
        promotion: false,
        height: 360,
        plugins: 'advlist autolink link lists wordcount',
        toolbar: 'undo redo | blocks | bold italic underline | bullist numlist blockquote | link | removeformat',
        block_formats: 'Paragraph=p; Heading 2=h2; Heading 3=h3; Heading 4=h4',
        link_default_target: '_blank',
        link_rel_list: [
            { title: 'No rel', value: '' },
            { title: 'No opener', value: 'noopener' },
            { title: 'No opener and noreferrer', value: 'noopener noreferrer' },
        ],
        content_style: 'body { font-family: Figtree, Arial, sans-serif; font-size: 15px; line-height: 1.7; padding: 0.75rem; }',
    });

    document.querySelectorAll('form').forEach((form) => {
        if (form.dataset.tinymceSubmitBound) return;

        form.dataset.tinymceSubmitBound = 'true';
        form.addEventListener('submit', () => window.tinymce.triggerSave());
    });
};

const init = () => {
    initIcons();
    initDataTables();
    initImagePreviews();
    initSlugPreviews();
    initHorizontalCarousels();
    initPreline();
    initRichTextEditors();
};

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
} else {
    init();
}
