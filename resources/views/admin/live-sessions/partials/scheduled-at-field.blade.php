@props([
    'value' => '',
])

<div class="ls-form-group">
    <label for="scheduled_at">Scheduled Date &amp; Time</label>
    <div class="ls-datetime-field">
        <input
            type="text"
            id="scheduled_at"
            name="scheduled_at"
            value="{{ $value }}"
            class="ls-datetime-input"
            placeholder="Select date &amp; time"
            autocomplete="off"
            readonly
        >
        <button type="button" class="ls-datetime-trigger" data-datetime-trigger aria-label="Open date and time picker">
            <svg viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
        </button>
    </div>
    <p class="ls-datetime-help">Optional — pick when this session is planned to start.</p>
    @error('scheduled_at')
        <div class="ls-field-error">{{ $message }}</div>
    @enderror
</div>
