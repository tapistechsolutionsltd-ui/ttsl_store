@extends('layouts.admin')
@section('title', 'Hero Slides')

@section('content')

<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-lg font-semibold text-gray-700">Hero Slider Management</h2>
        <p class="text-sm text-gray-500 mt-1">Manage the slides shown on the store front page hero section.</p>
    </div>
    <a href="{{ route('admin.hero-slides.create') }}" class="btn-primary flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Add New Slide
    </a>
</div>

@if($slides->isEmpty())
    <div class="card p-12 text-center">
        <div class="w-16 h-16 bg-blue-50 rounded-xl flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
        </div>
        <h3 class="font-semibold text-gray-700 mb-2">No hero slides yet</h3>
        <p class="text-sm text-gray-400 mb-4">Create your first slide to customize the store front hero section.</p>
        <a href="{{ route('admin.hero-slides.create') }}" class="btn-primary">Create First Slide</a>
    </div>
@else
    <div class="card overflow-hidden">
        <div class="p-4 bg-blue-50 border-b border-blue-100 flex items-center gap-2 text-sm text-blue-700">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Slides are shown in the order below. Use the sort order field to control sequence.
        </div>
        <div class="divide-y divide-gray-100">
            @foreach($slides as $slide)
                <div class="flex items-center gap-4 p-4 hover:bg-gray-50 transition-colors">
                    {{-- Thumbnail --}}
                    <div class="w-24 h-16 rounded-lg overflow-hidden flex-shrink-0 border border-gray-200"
                         style="{{ $slide->image_path ? '' : 'background-color:' . $slide->bg_color }}">
                        @if($slide->is_video)
                            <video src="{{ $slide->image_url }}" class="w-full h-full object-cover" autoplay loop muted playsinline></video>
                        @elseif($slide->image_url)
                            <img src="{{ $slide->image_url }}" alt="{{ $slide->title }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-white/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        @endif
                    </div>

                    {{-- Info --}}
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2">
                            <span class="font-semibold text-gray-800 truncate">{{ $slide->title ?: '(No title)' }}</span>
                            @if($slide->badge_text)
                                <span class="text-xs px-2 py-0.5 rounded-full text-white font-medium"
                                      style="background-color: {{ $slide->badge_color }}">
                                    {{ $slide->badge_text }}
                                </span>
                            @endif
                        </div>
                        @if($slide->subtitle)
                            <p class="text-sm text-gray-500 truncate mt-0.5">{{ $slide->subtitle }}</p>
                        @endif
                        <div class="flex items-center gap-3 mt-1.5 text-xs text-gray-400">
                            <span>Order: {{ $slide->sort_order }}</span>
                            @if($slide->button_text)
                                <span class="flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                                    </svg>
                                    {{ $slide->button_text }}
                                </span>
                            @endif
                            @if(!$slide->image_path)
                                <span class="flex items-center gap-1">
                                    <span class="w-3 h-3 rounded-full inline-block" style="background:{{ $slide->bg_color }}"></span>
                                    {{ $slide->bg_color }}
                                </span>
                            @endif
                        </div>
                    </div>

                    {{-- Status toggle --}}
                    <form method="POST" action="{{ route('admin.hero-slides.toggle', $slide) }}">
                        @csrf @method('PATCH')
                        <button type="submit" class="flex items-center gap-1.5 text-sm px-3 py-1.5 rounded-lg border transition-colors
                            {{ $slide->is_active ? 'bg-green-50 border-green-200 text-green-700 hover:bg-green-100' : 'bg-gray-50 border-gray-200 text-gray-500 hover:bg-gray-100' }}">
                            @if($slide->is_active)
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                Active
                            @else
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                </svg>
                                Inactive
                            @endif
                        </button>
                    </form>

                    {{-- Actions --}}
                    <div class="flex items-center gap-2">
                        <a href="{{ route('admin.hero-slides.edit', $slide) }}"
                           class="p-2 text-gray-400 hover:text-brand hover:bg-blue-50 rounded-lg transition-colors" title="Edit">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </a>
                        <form method="POST" action="{{ route('admin.hero-slides.destroy', $slide) }}"
                              onsubmit="return askConfirmForm(event, 'Are you sure you want to delete this slide? This action cannot be undone.', 'Delete Slide');">
                            @csrf @method('DELETE')
                            <button type="submit"
                                    class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Delete">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Live preview note --}}
    <div class="mt-4 text-center">
        <a href="{{ route('home') }}" target="_blank"
           class="inline-flex items-center gap-2 text-sm text-brand hover:underline">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
            </svg>
            Preview store front
        </a>
    </div>
@endif

@endsection
