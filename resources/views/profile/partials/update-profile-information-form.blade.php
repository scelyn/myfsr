<section>
    <header class="mb-5">
        <h4 class="text-sm font-bold" style="color:var(--text-primary);">Informasi Profil</h4>
        <p class="text-xs mt-1" style="color:var(--text-secondary);">Perbarui nama dan alamat email akun Anda.</p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">@csrf</form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-4">
        @csrf @method('patch')

        <div class="form-group">
            <x-input-label for="name" :value="__('Nama')"/>
            <x-text-input id="name" name="name" type="text"
                          :value="old('name', $user->name)" required autofocus autocomplete="name"/>
            <x-input-error class="mt-1" :messages="$errors->get('name')"/>
        </div>

        <div class="form-group">
            <x-input-label for="email" :value="__('Email')"/>
            <x-text-input id="email" name="email" type="email"
                          :value="old('email', $user->email)" required autocomplete="username"/>
            <x-input-error class="mt-1" :messages="$errors->get('email')"/>

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                <div class="mt-2">
                    <p class="text-sm" style="color:var(--text-secondary);">
                        {{ __('Email belum diverifikasi.') }}
                        <button form="send-verification" class="underline text-xs" style="color:var(--color-success);">
                            {{ __('Kirim ulang verifikasi') }}
                        </button>
                    </p>
                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-1 text-xs" style="color:var(--color-success);">{{ __('Link verifikasi telah dikirim.') }}</p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="btn btn-accent btn-sm">Simpan Profil</button>
            @if (session('status') === 'profile-updated')
                <p x-data="{show:true}" x-show="show" x-init="setTimeout(()=>show=false,2000)"
                   class="text-xs" style="color:var(--color-success);">Tersimpan!</p>
            @endif
        </div>
    </form>
</section>
