import Alpine from 'alpinejs';
import 'flowbite';
import './alert';

import { createIcons, icons } from 'lucide';
import { DataTable } from 'simple-datatables';

window.Alpine = Alpine;
window.createIcons = createIcons;

Alpine.start();

const initIcons = () => {
    createIcons({
        icons,
    });
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

const init = () => {
    initIcons();
    initDataTables();
    initImagePreviews();
    initSlugPreviews();
};

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
} else {
    init();
}
