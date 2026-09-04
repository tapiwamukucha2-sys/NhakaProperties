<x-app-layout>
    <x-slot name="header">
        <h2 class="font-serif-brand font-semibold text-2xl text-[--ink]">List a property</h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-[--paper-2] border border-[--line] rounded-xl p-8">
                <form action="{{ route('properties.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @include('properties.partials.form', ['property' => null])

                    <button type="submit" class="mt-2 bg-[--forest] text-[--paper-2] font-semibold text-sm px-6 py-3 rounded">
                        Submit for review
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
