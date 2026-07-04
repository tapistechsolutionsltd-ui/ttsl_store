@extends('layouts.admin')
@section('title', 'New Promotion')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.cpp.promotions.index') }}" class="inline-flex items-center gap-1 text-sm text-gray-500 hover:text-brand">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Back to Promotions
    </a>
</div>

<form method="POST" action="{{ route('admin.cpp.promotions.store') }}" enctype="multipart/form-data">
    @include('admin.cpp.promotions._form')
</form>
@endsection
