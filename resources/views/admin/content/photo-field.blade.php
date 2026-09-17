<div class="admin-upload" data-photo-field>
    <img src="{{ $profile->photoUrl($section) ?: '' }}" alt="Preview foto {{ $label }}" data-photo-preview @if(!$profile->photoUrl($section)) hidden @endif>
    <label>Foto {{ $label }}<input type="file" name="{{ $section }}_photo" accept="image/jpeg,image/png,image/webp" data-photo-input data-current-src="{{ $profile->photoUrl($section) }}"><small>JPG, PNG, WebP. Maksimal 3 MB / 6000 × 6000 px. Upload ulang bila validasi gagal.</small></label>
    <p role="alert" data-photo-error></p>
    <label>Deskripsi foto (alt text)<input name="{{ $section }}_photo_alt" maxlength="255" value="{{ old($section.'_photo_alt', $profile->getAttribute($section.'_photo_alt')) }}"><small>Wajib ketika mengunggah foto baru.</small></label>
    @if($profile->photoUrl($section))<label class="admin-checkbox"><input type="checkbox" name="remove_{{ $section }}_photo" value="1" @checked(old('remove_'.$section.'_photo'))> Hapus foto saat disimpan</label>@endif
</div>
