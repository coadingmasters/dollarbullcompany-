<div class="frow">
  <div class="field">
    <label>Password <span class="req">*</span></label>
    <input type="password" name="password" required autocomplete="new-password">
    @error('password')<span class="error-text">{{ $message }}</span>@enderror
    <span class="help-hint">Use this to log in after admin approves your enrollment</span>
  </div>
  <div class="field">
    <label>Confirm password <span class="req">*</span></label>
    <input type="password" name="password_confirmation" required autocomplete="new-password">
  </div>
</div>
