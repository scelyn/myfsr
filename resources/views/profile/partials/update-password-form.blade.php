<section>
    <header class="mb-5">
        <h4 class="text-sm font-bold" style="color:var(--text-primary);">Ubah Password</h4>
        <p class="text-xs mt-1" style="color:var(--text-secondary);">Gunakan password yang panjang dan acak agar akun Anda aman.</p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="space-y-4">
        @csrf @method('put')

        <div class="form-group">
            <x-input-label for="update_password_current_password" :value="__('Password Saat Ini')"/>
            <x-text-input id="update_password_current_password" name="current_password"
                          type="password" autocomplete="current-password"/>
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-1"/>
        </div>

        <div class="form-group">
            <x-input-label for="update_password_password" :value="__('Password Baru')"/>
            <x-text-input id="update_password_password" name="password"
                          type="password" autocomplete="new-password"/>
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-1"/>
        </div>

        <div class="form-group">
            <x-input-label for="update_password_password_confirmation" :value="__('Konfirmasi Password')"/>
            <x-text-input id="update_password_password_confirmation" name="password_confirmation"
                          type="password" autocomplete="new-password"/>
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-1"/>
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="btn btn-danger btn-sm">Ubah Password</button>
            @if (session('status') === 'password-updated')
                <p x-data="{show:true}" x-show="show" x-init="setTimeout(()=>show=false,2000)"
                   class="text-xs" style="color:var(--color-success);">Password diperbarui!</p>
            @endif
        </div>
    </form>
</section>
