/**
 * Filters the term dropdown based on the selected type.
 * When a type is selected, fetches only terms associated with that type.
 * When no type is selected, shows all terms.
 *
 * @param {string} typeSelectId - ID of the type <select> element
 * @param {string} termSelectId - ID of the term <select> element
 * @param {string} apiUrl - URL for the terms-by-type API endpoint
 * @param {string|null} selectedTerm - Currently selected term value (for preserving selection)
 */
function initTermTypeFilter(typeSelectId, termSelectId, apiUrl, selectedTerm, autoSubmitFormId) {
    const typeSelect = document.getElementById(typeSelectId);
    const termSelect = document.getElementById(termSelectId);
    if (!typeSelect || !termSelect) return;

    function fetchTerms(preserveValue, submit) {
        const typeValue = typeSelect.value;
        let url = apiUrl;
        if (typeValue) {
            url += (url.includes('?') ? '&' : '?') + 'type=' + encodeURIComponent(typeValue);
        }

        fetch(url)
            .then(r => r.json())
            .then(terms => {
                termSelect.innerHTML = '<option value="">All Terms</option>';
                terms.forEach(term => {
                    const opt = document.createElement('option');
                    opt.value = term;
                    opt.textContent = term;
                    if (term === preserveValue) opt.selected = true;
                    termSelect.appendChild(opt);
                });
                if (submit && autoSubmitFormId) {
                    document.getElementById(autoSubmitFormId).submit();
                }
            });
    }

    typeSelect.addEventListener('change', function() {
        termSelect.value = '';
        fetchTerms('', true);
    });

    if (typeSelect.value) fetchTerms(selectedTerm, false);
}
