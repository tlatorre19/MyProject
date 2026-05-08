<?php
use Illuminate\Support\Str;
?>

@extends('layouts.dashboard')

@section('content')
<div class="container">
    <div class="page-inner">

        {{-- Header --}}
        <div class="d-flex align-items-center flex-column flex-md-row pt-2 pb-4">
            <div>
                <h3 class="fw-bold mb-1">All Items</h3>
                <h6 class="op-7 mb-2">{{ $items->count() }} items found</h6>
            </div>
        </div>

        <div class="row">

            {{-- Filters Sidebar --}}
            <div class="col-md-3">
                <div class="card card-round p-3">
                    <h6 class="fw-bold mb-3">Refine Search</h6>

                    <form method="GET" action="{{ route('browse') }}">
                        <div class="mb-3">
                            <label class="text-uppercase small fw-bold text-muted">Keywords</label>
                            <input type="text" name="search" value="{{ request('search') }}"
                                class="form-control form-control-sm mt-1" placeholder="Search...">
                        </div>

                        <div class="mb-3">
                            <label class="text-uppercase small fw-bold text-muted">Type</label>
                            <div class="mt-1">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="type" value="" id="typeAll"
                                        {{ request('type') == '' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="typeAll">All</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="type" value="Lost" id="typeLost"
                                        {{ request('type') == 'Lost' ? 'checked' : '' }}>
                                    <label class="form-check-label text-danger" for="typeLost">Lost</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="type" value="Found" id="typeFound"
                                        {{ request('type') == 'Found' ? 'checked' : '' }}>
                                    <label class="form-check-label text-success" for="typeFound">Found</label>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-success btn-sm w-100 mb-2">Apply Filters</button>
                        <a href="{{ route('browse') }}" class="btn btn-outline-secondary btn-sm w-100">Reset</a>
                    </form>
                </div>
            </div>

            {{-- Items Grid --}}
            <div class="col-md-9">
                <div class="row">
                    @forelse($items as $item)
                        <div class="col-md-4 mb-4">
                            <div class="card card-round h-100" style="overflow:hidden;">

                                {{-- Item Image --}}
                                <div style="position:relative; height:180px; overflow:hidden; background:#f0f0f0;">
                                    @if($item->photo)
                                        <img src="{{ asset('storage/' . $item->photo) }}"
                                             alt="{{ $item->name }}"
                                             style="width:100%; height:100%; object-fit:cover;">
                                    @else
                                        <div class="d-flex align-items-center justify-content-center h-100 text-muted">
                                            <i class="fas fa-image" style="font-size:48px; opacity:0.3;"></i>
                                        </div>
                                    @endif

                                    {{-- Status Badge --}}
                                    <span class="badge bg-{{ $item->status == 'Pending' ? 'warning' : 'success' }}"
                                          style="position:absolute; top:10px; right:10px; font-size:11px;">
                                        {{ $item->status }}
                                    </span>

                                    {{-- Type Badge --}}
                                    <span class="badge bg-{{ $item->type == 'Lost' ? 'danger' : 'success' }}"
                                          style="position:absolute; top:10px; left:10px; font-size:11px;">
                                        {{ $item->type }}
                                    </span>
                                </div>

                                <div class="card-body d-flex flex-column">
                                    <p class="text-muted mb-1" style="font-size:11px;">
                                        <i class="fas fa-calendar me-1"></i>
                                        {{ \Carbon\Carbon::parse($item->date)->format('M d, Y') }}
                                    </p>
                                    <h6 class="fw-bold mb-1">{{ $item->name }}</h6>
                                    <p class="text-muted mb-3" style="font-size:12px;">
                                        {{ Str::limit($item->description, 60) }}
                                    </p>
                                    <div class="mt-auto">
                                        <a href="{{ route('forms.edit', $item->id) }}"
                                           class="btn btn-success btn-sm w-100 rounded-pill">
                                            View Details
                                        </a>
                                    </div>
                                </div>

                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center py-5 text-muted">
                            <i class="fas fa-box-open mb-3" style="font-size:48px; opacity:0.3;"></i>
                            <p>No items found.</p>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</div>
@endsection