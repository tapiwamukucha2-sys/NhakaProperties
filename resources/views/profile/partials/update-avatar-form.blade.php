<section>
    <header>
        <h2 class="font-serif-brand text-lg font-semibold text-[--ink]">
            {{ __('Profile Photo') }}
        </h2>
        <p class="mt-1 text-sm text-[--ink]/60">
            {{ __("Used across your listings and dashboard so renters and agents recognise you.") }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.avatar') }}" enctype="multipart/form-data" class="mt-6 flex items-center gap-6">
        @csrf

        <img src="{{ Auth::user()->avatarUrl() }}" alt="{{ Auth::user()->name }}" class="w-16 h-16 rounded-full object-cover border border-[--line]">

        <div>
            <input type="file" name="avatar" accept="image/*" class="text-sm text-[--ink]/70 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-[--forest] file:text-white hover:file:bg-[--forest-dark]" required>
            <x-input-error :messages="$errors->get('avatar')" class="mt-2" />

            @if (session('status') === 'avatar-updated')
                <p class="text-sm text-[--forest] font-medium mt-2">Photo updated.</p>
            @endif

            <button type="submit" class="mt-3 inline-flex items-center px-4 py-2 bg-[--forest] border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-[--forest-dark]">
                {{ __('Upload') }}
            </button>
        </div>
    </form>
</section>
