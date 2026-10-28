
window.addEvent("domready", function(){
    $$('.tl_listing .tl_file input').addEvent('click', function(){
        $$(this).getParent().getParent().toggleClass('active');
    });
    $$('.tl_file').addEvent('click', function(){
        $$(this).toggleClass('active');
    });
});


/*
 * Inhaltselemente: Klassen mit Präfix „be-“ am .cte_type (z. B. per child_record_callback
 * gesetzt) als „<klasse>-wrapper“ an die Zeile (.tl_content wrapper_* …) übertragen.
 * Beispiel: <div class="cte_type published be-row-anfang"> → .tl_content.be-row-anfang-wrapper
 */
(function () {
    var prefix = 'be-';

    function applyCteWrapperClasses() {
        document.querySelectorAll('.tl_content .cte_type').forEach(function (el) {
            var row = el.closest('.tl_content');
            if (!row) return;
            el.classList.forEach(function (cls) {
                if (cls.indexOf(prefix) === 0) row.classList.add(cls + '-wrapper');
            });
        });
    }

    document.addEventListener('DOMContentLoaded', applyCteWrapperClasses);
    document.addEventListener('turbo:load', applyCteWrapperClasses);

    // per Ajax nachgeladene Zeilen (Verschieben, Umschalten …)
    new MutationObserver(applyCteWrapperClasses).observe(document.documentElement, { childList: true, subtree: true });
})();
