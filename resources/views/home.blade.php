<?php

use Illuminate\Support\Facades\Auth;
use App\Models\Item;

?>


@extends('layouts.dashboard')

@section('content')
<div class="container">
    <div class="page-inner">

        {{-- Header --}}
        <div class="d-flex align-items-center flex-column flex-md-row pt-2 pb-4">
            <div>
                <h3 class="fw-bold mb-1">My Dashboard</h3>
                <h6 class="op-7 mb-2">Hey there, <strong>{{ Auth::user()->name }}</strong>! Ready to help the community today?</h6>
            </div>
            <div class="ms-md-auto py-2 py-md-0">
                <a href="{{ route('forms') }}" class="btn btn-primary btn-round">
                    <i class="fas fa-plus me-2"></i> Report New Item
                </a>
            </div>
        </div>

        {{-- Stats Cards --}}
        <div class="row">
            <div class="col-sm-6 col-md-4">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center bubble-shadow-small"
                                    style="background-color:#fff0f0; color:#e74c3c;">
                                    <i class="fas fa-search"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Items You Lost</p>
                                    <h4 class="card-title">
                                        {{ App\Models\Item::where('user_id', Auth::id())->where('type', 'Lost')->count() }}
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-4">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center bubble-shadow-small"
                                    style="background-color:#f0fff4; color:#27ae60;">
                                    <i class="fas fa-hands-helping"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Items You Found</p>
                                    <h4 class="card-title">
                                        {{ App\Models\Item::where('user_id', Auth::id())->where('type', 'Found')->count() }}
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-4">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center bubble-shadow-small"
                                    style="background-color:#f0f8ff; color:#2980b9;">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Total Resolved</p>
                                    <h4 class="card-title">
                                        {{ App\Models\Item::where('user_id', Auth::id())->where('status', 'Resolved')->count() }}
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Activity Log + Updates --}}
        <div class="row">
            <div class="col-md-8">
                <div class="card card-round">
                    <div class="card-header">
                        <div class="card-head-row">
                            <div class="card-title">Your Activity Log</div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table align-items-center mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Item Details</th>
                                        <th>Category</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse(App\Models\Item::where('user_id', Auth::id())->latest()->take(5)->get() as $item)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="ms-2">
                                                        <p class="fw-bold mb-0">{{ $item->name }}</p>
                                                        <p class="text-muted mb-0" style="font-size:12px;">
                                                            Reported: {{ $item->created_at->format('M d, Y') }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $item->type }}</td>
                                            <td>
                                                <span class="badge bg-{{ $item->status == 'Pending' ? 'warning' : 'success' }}">
                                                    {{ $item->status }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="{{ route('forms.edit', $item->id) }}"
                                                    class="btn btn-sm btn-outline-primary rounded-pill">
                                                    View Details
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center py-4 text-muted">
                                                No items reported yet.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                {{-- Updates Card --}}
                <div class="card card-round mb-4">
                    <div class="card-header">
                        <div class="card-head-row">
                            <div class="card-title">Updates</div>
                            <span class="badge bg-primary ms-2">
                                {{ App\Models\Item::where('status', 'Pending')->count() }}
                            </span>
                        </div>
                    </div>
                    <div class="card-body text-center py-5">
                        @if(App\Models\Item::where('user_id', Auth::id())->where('status', 'Pending')->count() > 0)
                            @foreach(App\Models\Item::where('user_id', Auth::id())->where('status','Pending')->latest()->take(3)->get() as $pending)
                                <div class="d-flex align-items-center mb-3 text-start">
                                    <i class="fas fa-circle text-warning me-2" style="font-size:8px;"></i>
                                    <div>
                                        <p class="mb-0 fw-bold">{{ $pending->name }}</p>
                                        <small class="text-muted">{{ $pending->type }} — Pending</small>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <i class="fas fa-check-circle text-success mb-3" style="font-size:48px;"></i>
                            <p class="text-muted">All caught up!</p>
                        @endif
                    </div>
                </div>

                {{-- Quick Tip Card --}}
                <div class="card card-round" style="background-color: #2d6a4f; color: white;">
                    <div class="card-body">
                        <h6 class="fw-bold mb-2">
                            <i class="fas fa-lightbulb me-2" style="color:#f9c74f;"></i> Quick Tip
                        </h6>
                        <p class="mb-0" style="font-size:13px; opacity:0.9;">
                            Providing a clear description and specific location improves the chances of item recovery. Admins typically process reports within 24 hours.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Claim Requests --}}
        <div class="row">
            <div class="col-md-12">
                <div class="card card-round">
                    <div class="card-header">
                        <div class="card-head-row">
                            <div class="card-title">Your Reported Items</div>
                            <span class="badge bg-secondary ms-2">
                                {{ App\Models\Item::where('user_id', Auth::id())->count() }} Total
                            </span>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table align-items-center mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Item</th>
                                        <th>Date Reported</th>
                                        <th>Type</th>
                                        <th>Status</th>
                                        <th>Match</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse(App\Models\Item::where('user_id', Auth::id())->latest()->get() as $item)
                                        @php
                                            $match = App\Models\Item::where('name', $item->name)
                                                ->where('type', '!=', $item->type)
                                                ->first();
                                        @endphp
                                        <tr>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->created_at->format('M d, Y') }}</td>
                                            <td>
                                                <span class="badge bg-{{ $item->type == 'Lost' ? 'danger' : 'success' }}">
                                                    {{ $item->type }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge bg-{{ $item->status == 'Pending' ? 'warning' : 'success' }}">
                                                    {{ $item->status }}
                                                </span>
                                            </td>
                                            <td>
                                                @if($match)
                                                    <span class="badge bg-success">Possible Match</span>
                                                @else
                                                    <span class="text-muted">—</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('forms.edit', $item->id) }}"
                                                    class="btn btn-sm btn-warning">Edit</a>
                                                <form action="{{ route('forms.destroy', $item->id) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Are you sure?')">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-4 text-muted">
                                                No items reported yet.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection