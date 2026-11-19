import Alpine from 'alpinejs';
import './bootstrap';

window.Alpine = Alpine;

Alpine.start();

document.addEventListener('submit', (event) => {
    const form = event.target;

    if (!(form instanceof HTMLFormElement) || !form.hasAttribute('data-disable-on-submit')) {
        return;
    }

    const submitButton = form.querySelector('button[type="submit"]');

    if (submitButton instanceof HTMLButtonElement) {
        submitButton.disabled = true;
        submitButton.setAttribute('aria-disabled', 'true');
        submitButton.classList.add('cursor-not-allowed', 'opacity-70');
    }
});

document.querySelectorAll('[data-filter-scope]').forEach((scope) => {
    const list = scope.querySelector('[data-filter-list]');
    const search = scope.querySelector('[data-filter-search]');
    const status = scope.querySelector('[data-filter-status]');
    const count = scope.querySelector('[data-filter-count]');
    const emptyState = scope.querySelector('[data-filter-empty]');
    const clearButton = scope.querySelector('[data-filter-clear]');
    const items = list ? Array.from(list.querySelectorAll('[data-filter-item]')) : [];
    const tableContainer = list ? list.closest('.overflow-x-auto') : null;

    if (!search || items.length === 0) {
        return;
    }

    const applyFilters = () => {
        const query = search.value.trim().toLocaleLowerCase();
        const selectedStatus = status ? status.value : 'all';
        let visibleCount = 0;

        items.forEach((item) => {
            const matchesQuery = item.textContent.toLocaleLowerCase().includes(query);
            const matchesStatus = selectedStatus === 'all' || item.dataset.status === selectedStatus;
            const isVisible = matchesQuery && matchesStatus;

            item.hidden = !isVisible;
            visibleCount += isVisible ? 1 : 0;
        });

        if (count) {
            count.textContent = `${visibleCount} of ${items.length} ${scope.dataset.filterLabel || 'items'}`;
        }

        if (emptyState) {
            emptyState.hidden = visibleCount !== 0;
        }

        if (tableContainer) {
            tableContainer.hidden = visibleCount === 0;
        }

        if (clearButton) {
            clearButton.hidden = query === '' && selectedStatus === 'all';
        }
    };

    search.addEventListener('input', applyFilters);
    status?.addEventListener('change', applyFilters);
    clearButton?.addEventListener('click', () => {
        search.value = '';

        if (status) {
            status.value = 'all';
        }

        applyFilters();
        search.focus();
    });

    applyFilters();
});
