import Alpine from 'alpinejs';
import 'flowbite';

import './alert';

import { createIcons, icons } from 'lucide';

window.Alpine = Alpine;
window.createIcons = createIcons;

Alpine.start();

const initIcons = () => {
    createIcons({
        icons,
    });
};

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initIcons);
} else {
    initIcons();
}
