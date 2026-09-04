<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between flex-wrap gap-4">
            <div class="flex items-center gap-4">
                <img src="{{ Auth::user()->avatarUrl() }}" alt="{{ Auth::user()->name }}" class="w-12 h-12 rounded-full object-cover border border-[--line]">
                <div>
                <h2 class="font-serif-brand font-semibold text-2xl text-[--ink]">
                    Welcome back, {{ Auth::user()->name }}
                </h2>
                <p class="text-sm text-[--ink]/60 mt-1">
                    {{ ucfirst(Auth::user()->role) }} dashboard
                    @if (Auth::user()->is_verified)
                        <span class="ml-2 inline-flex items-center gap-1 text-xs font-bold text-[--forest] bg-[--forest]/10 px-2 py-0.5 rounded-full">✓ Verified</span>
                    @endif
                </p>
                </div>
            </div>
            <a href="{{ route('properties.create') }}" class="inline-block bg-[--forest] text-[--paper-2] font-semibold text-sm px-5 py-3 rounded">
                + List a property
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            @if (session('status'))
                <div class="bg-[--forest]/10 border border-[--forest]/30 text-[--forest] text-sm font-medium px-4 py-3 rounded">
                    {{ session('status') }}
                </div>
            @endif

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="bg-[--paper-2] border border-[--line] rounded-xl p-6">
                    <div class="text-xs font-bold uppercase tracking-wide text-[--ink]/50">Total listings</div>
                    <div class="font-serif-brand text-3xl mt-2">{{ $stats['total'] }}</div>
                </div>
                <div class="bg-[--paper-2] border border-[--line] rounded-xl p-6">
                    <div class="text-xs font-bold uppercase tracking-wide text-[--ink]/50">Published</div>
                    <div class="font-serif-brand text-3xl mt-2 text-[--forest]">{{ $stats['published'] }}</div>
                </div>
                <div class="bg-[--paper-2] border border-[--line] rounded-xl p-6">
                    <div class="text-xs font-bold uppercase tracking-wide text-[--ink]/50">Pending review</div>
                    <div class="font-serif-brand text-3xl mt-2 text-[--gold]">{{ $stats['pending'] }}</div>
                </div>
            </div>

            <div class="bg-[--paper-2] border border-[--line] rounded-xl overflow-hidden">
                <div class="px-6 py-4 border-b border-[--line] flex items-center justify-between">
                    <h3 class="font-serif-brand font-semibold text-lg">Your properties</h3>
                </div>

                @if ($properties->isEmpty())
                    <div class="px-6 py-14 text-center text-[--ink]/60">
                        <p class="mb-4">You haven't listed a property yet.</p>
                        <a href="{{ route('properties.create') }}" class="inline-block bg-[--forest] text-[--paper-2] font-semibold text-sm px-5 py-3 rounded">
                            List your first property
                        </a>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="text-left text-xs font-bold uppercase tracking-wide text-[--ink]/50 border-b border-[--line]">
                                    <th class="px-6 py-3">Title</th>
                                    <th class="px-6 py-3">Category</th>
                                    <th class="px-6 py-3">Price</th>
                                    <th class="px-6 py-3">Location</th>
                                    <th class="px-6 py-3">Status</th>
                                    <th class="px-6 py-3"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($properties as $property)
                                    <tr class="border-b border-[--line] last:border-0">
                                        <td class="px-6 py-4 font-medium">{{ $property->title }}</td>
                                        <td class="px-6 py-4 capitalize">{{ $property->category }}</td>
                                        <td class="px-6 py-4">
                                            ${{ number_format($property->price) }}{{ $property->price_period === 'month' ? ' / mo' : '' }}
                                        </td>
                                        <td class="px-6 py-4">{{ $property->location }}</td>
                                        <td class="px-6 py-4">
                                            <span @class([
                                                'inline-flex text-xs font-bold px-2 py-0.5 rounded-full',
                                                'bg-[--forest]/10 text-[--forest]' => $property->status === 'published',
                                                'bg-[--gold]/15 text-[--gold]' => $property->status === 'pending',
                                                'bg-red-100 text-red-700' => $property->status === 'rejected',
                                                'bg-[--ink]/10 text-[--ink]/70' => $property->status === 'draft',
                                            ])>
                                                {{ ucfirst($property->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-right space-x-3">
                                            <a href="{{ route('properties.edit', $property) }}" class="text-[--forest] font-semibold hover:underline">Edit</a>
                                            <form action="{{ route('properties.destroy', $property) }}" method="POST" class="inline" onsubmit="return confirm('Remove this listing?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 font-semibold hover:underline">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
