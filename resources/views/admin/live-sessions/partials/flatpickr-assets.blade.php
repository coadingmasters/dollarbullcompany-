@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr@4.6.13/dist/flatpickr.min.css">
<style>
    .ls-datetime-field {
        position: relative;
        display: flex;
        align-items: stretch;
    }
    .ls-datetime-input,
    .ls-datetime-field .flatpickr-input {
        flex: 1;
        width: 100% !important;
        padding: 11px 14px !important;
        padding-right: 48px !important;
        background: var(--black) !important;
        border: 1px solid var(--bb) !important;
        color: var(--wd) !important;
        border-radius: 0 !important;
        cursor: pointer;
    }
    .ls-datetime-input::placeholder {
        color: var(--wf);
        opacity: .85;
    }
    .ls-datetime-trigger {
        position: absolute;
        right: 0;
        top: 0;
        bottom: 0;
        width: 44px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(212, 160, 23, .08);
        border: none;
        border-left: 1px solid var(--bb);
        color: var(--gold);
        cursor: pointer;
        transition: background .2s, color .2s;
    }
    .ls-datetime-trigger:hover {
        background: rgba(212, 160, 23, .18);
        color: var(--gold-light);
    }
    .ls-datetime-trigger svg {
        width: 18px;
        height: 18px;
        stroke: currentColor;
        fill: none;
        stroke-width: 1.6;
    }
    .ls-datetime-help {
        margin-top: 8px;
        font-size: .8rem;
        color: var(--wf);
        font-style: italic;
    }

    /* Flatpickr — match admin dark + gold */
    .flatpickr-calendar {
        background: var(--bc) !important;
        border: 1px solid rgba(212, 160, 23, .35) !important;
        box-shadow: 0 16px 48px rgba(0, 0, 0, .65), 0 0 24px rgba(212, 160, 23, .08) !important;
        border-radius: 3px !important;
        font-family: 'Crimson Pro', Georgia, serif !important;
    }
    .flatpickr-months .flatpickr-month,
    .flatpickr-current-month .flatpickr-monthDropdown-months,
    .flatpickr-weekdays,
    span.flatpickr-weekday {
        background: var(--bc) !important;
        color: var(--wd) !important;
        fill: var(--wd) !important;
    }
    .flatpickr-current-month input.cur-year,
    .flatpickr-current-month .flatpickr-monthDropdown-months {
        font-family: 'Cinzel', serif !important;
        font-weight: 600 !important;
        color: var(--gold-light) !important;
    }
    .flatpickr-months .flatpickr-prev-month,
    .flatpickr-months .flatpickr-next-month {
        fill: var(--gold) !important;
        color: var(--gold) !important;
    }
    .flatpickr-months .flatpickr-prev-month:hover svg,
    .flatpickr-months .flatpickr-next-month:hover svg {
        fill: var(--gold-light) !important;
    }
    .flatpickr-day {
        color: var(--wd) !important;
        border-radius: 2px !important;
    }
    .flatpickr-day:hover,
    .flatpickr-day:focus {
        background: rgba(212, 160, 23, .15) !important;
        border-color: rgba(212, 160, 23, .3) !important;
    }
    .flatpickr-day.today {
        border-color: var(--gold) !important;
    }
    .flatpickr-day.selected,
    .flatpickr-day.startRange,
    .flatpickr-day.endRange {
        background: linear-gradient(135deg, var(--gold-dark), var(--gold)) !important;
        border-color: var(--gold) !important;
        color: #060606 !important;
        font-weight: 600;
    }
    .flatpickr-day.flatpickr-disabled {
        color: var(--wf) !important;
        opacity: .4;
    }
    .flatpickr-time {
        border-top: 1px solid var(--bb) !important;
        background: var(--black) !important;
    }
    .flatpickr-time input,
    .flatpickr-time .flatpickr-am-pm {
        color: var(--wd) !important;
        font-family: 'Cinzel', serif !important;
        font-size: .85rem !important;
    }
    .flatpickr-time input:hover,
    .flatpickr-time .flatpickr-am-pm:hover,
    .flatpickr-time input:focus,
    .flatpickr-time .flatpickr-am-pm:focus {
        background: rgba(212, 160, 23, .12) !important;
    }
    .flatpickr-time .numInputWrapper span.arrowUp:after {
        border-bottom-color: var(--gold) !important;
    }
    .flatpickr-time .numInputWrapper span.arrowDown:after {
        border-top-color: var(--gold) !important;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/flatpickr@4.6.13/dist/flatpickr.min.js"></script>
<script>
(function () {
    const input = document.getElementById('scheduled_at');
    const trigger = document.querySelector('[data-datetime-trigger]');

    if (!input || typeof flatpickr === 'undefined') return;

    const picker = flatpickr(input, {
        enableTime: true,
        dateFormat: 'Y-m-d H:i',
        altInput: true,
        altFormat: 'F j, Y \\a\\t h:i K',
        allowInput: false,
        clickOpens: true,
        minuteIncrement: 5,
        defaultHour: 18,
        defaultMinute: 0,
        disableMobile: true,
    });

    if (trigger) {
        trigger.addEventListener('click', function () {
            picker.open();
        });
    }
})();
</script>
@endpush
