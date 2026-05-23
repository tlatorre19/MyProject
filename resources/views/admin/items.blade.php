@extends('admin.layout')

@section('content')
<div style="margin-bottom:1.5rem;">
    <h2 style="font-size:24px; font-weight:700; color:#1b4332; margin-bottom:4px;">Item Management</h2>
    <p style="color:#888; font-size:14px;">Review and update status of reported items</p>
</div>

<div class="card border-0 shadow-sm rounded-3 mb-4">
    <div class="card-body p-4">
        <form method="GET" action="{{ route('admin.items') }}">
            <div class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label style="font-size:11px; font-weight:700; color:#aaa; text-transform:uppercase; letter-spacing:1px;">Search Keywords</label>
                    <input type="text" name="search" class="form-control mt-1"
                        placeholder="Search by title, description..."
                        value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <label style="font-size:11px; font-weight:700; color:#aaa; text-transform:uppercase; letter-spacing:1px;">Filter by Status</label>
                    <select name="status" class="form-select mt-1">
                        <option value="all">All Statuses</option>
                        <option value="Pending"  {{ request('status')=='Pending'  ? 'selected':'' }}>Pending</option>
                        <option value="Found"    {{ request('status')=='Found'    ? 'selected':'' }}>Found</option>
                        <option value="Lost"     {{ request('status')=='Lost'     ? 'selected':'' }}>Lost</option>
                        <option value="Resolved" {{ request('status')=='Resolved' ? 'selected':'' }}>Resolved</option>
                        <option value="Claimed"  {{ request('status')=='Claimed'  ? 'selected':'' }}>Claimed</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label style="font-size:11px; font-weight:700; color:#aaa; text-transform:uppercase; letter-spacing:1px;">Filter by Type</label>
                    <select name="type" class="form-select mt-1">
                        <option value="all">All Types</option>
                        <option value="Lost"  {{ request('type')=='Lost'  ? 'selected':'' }}>Lost</option>
                        <option value="Found" {{ request('type')=='Found' ? 'selected':'' }}>Found</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn w-100 text-white fw-600"
                        style="background:#2d6a4f; border-radius:8px; padding:10px; font-size:13px; font-weight:600;">
                        <i class="fas fa-filter me-2"></i> Apply Filters
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-3">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr style="background:#fafafa;">
                        <th style="font-size:11px; text-transform:uppercase; letter-spacing:1px; color:#aaa; font-weight:600; padding:14px 16px; border-bottom:1px solid #f0f0f0;">Item Details</th>
                        <th style="font-size:11px; text-transform:uppercase; letter-spacing:1px; color:#aaa; font-weight:600; padding:14px 16px; border-bottom:1px solid #f0f0f0;">Reporter</th>
                        <th style="font-size:11px; text-transform:uppercase; letter-spacing:1px; color:#aaa; font-weight:600; padding:14px 16px; border-bottom:1px solid #f0f0f0;">Current Status</th>
                        <th style="font-size:11px; text-transform:uppercase; letter-spacing:1px; color:#aaa; font-weight:600; padding:14px 16px; border-bottom:1px solid #f0f0f0;">Match</th>
                        <th style="font-size:11px; text-transform:uppercase; letter-spacing:1px; color:#aaa; font-weight:600; padding:14px 16px; border-bottom:1px solid #f0f0f0;">Management</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $item)
                        @php
                            $match = \App\Models\Item::where('name', $item->name)
                                ->where('type', '!=', $item->type)
                                ->first();
                            $statusColor = match($item->status) {
                                'Pending'  => 'background:#fff8e1; color:#f39c12;',
                                'Found'    => 'background:#f0fff4; color:#27ae60;',
                                'Lost'     => 'background:#fff0f0; color:#e74c3c;',
                                'Resolved' => 'background:#e8f5e9; color:#2d6a4f;',
                                'Claimed'  => 'background:#e3f2fd; color:#1565c0;',
                                default    => 'background:#fff8e1; color:#f39c12;',
                            };
                            $typeColor = $item->type == 'Lost'
                                ? 'background:#fff0f0; color:#e74c3c;'
                                : 'background:#f0fff4; color:#27ae60;';
                        @endphp
                        <tr style="border-bottom:1px solid #f9f9f9;">
                            <td style="padding:14px 16px; vertical-align:middle;">
                                <div class="d-flex align-items-center gap-3">
                                    @if($item->photo)
                                        <img src="{{ asset('storage/' . $item->photo) }}"
                                            style="width:44px; height:44px; border-radius:8px; object-fit:cover;" alt="">
                                    @else
                                        <div style="width:44px; height:44px; border-radius:8px; background:#e8f5e9; display:flex; align-items:center; justify-content:center; color:#2d6a4f; font-size:18px;">
                                            <i class="fas fa-box"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <div style="font-weight:700; color:#1b4332;">{{ $item->name }}</div>
                                        <div style="font-size:12px; color:#aaa; display:flex; align-items:center; gap:6px;">
                                            {{ $item->category ?? 'Uncategorized' }} ·
                                            <span style="display:inline-block; padding:2px 8px; border-radius:20px; font-size:10px; font-weight:700; {{ $typeColor }}">
                                                {{ $item->type }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td style="padding:14px 16px; vertical-align:middle;">
                                <div style="font-weight:600; color:#333;">{{ $item->user->name ?? 'Unknown' }}</div>
                                <div style="font-size:12px; color:#aaa;">{{ $item->created_at->format('Y-m-d') }}</div>
                                @if(isset($item->user->phone))
                                    <div style="font-size:12px; color:#aaa;">
                                        <i class="fas fa-phone" style="font-size:10px;"></i> {{ $item->user->phone }}
                                    </div>
                                @endif
                            </td>
                            <td style="padding:14px 16px; vertical-align:middle;">
                                <span style="display:inline-block; padding:4px 12px; border-radius:20px; font-size:11px; font-weight:700; text-transform:uppercase; {{ $statusColor }}">
                                    {{ $item->status }}
                                </span>
                            </td>
                            <td style="padding:14px 16px; vertical-align:middle;">
                                @if($match)
                                    <span style="display:inline-block; padding:4px 12px; border-radius:20px; font-size:11px; font-weight:700; background:#f0fff4; color:#27ae60;">
                                        Match Found
                                    </span>
                                @else
                                    <span style="color:#ccc;">—</span>
                                @endif
                            </td>
                            <td style="padding:14px 16px; vertical-align:middle;">
                                <div class="dropdown">
                                    <button class="btn" type="button" data-bs-toggle="dropdown" aria-expanded="false"
                                        style="width:32px; height:32px; border-radius:50%; background:#f0f0f0; border:none;
                                               display:flex; align-items:center; justify-content:center;
                                               font-size:18px; font-weight:700; color:#555; cursor:pointer; padding:0;">
                                        ⋮
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow"
                                        style="border:none; border-radius:12px; padding:8px; min-width:170px;">

                                        <li>
                                            <a href="{{ route('items.show', $item->id) }}"
                                                class="dropdown-item d-flex align-items-center gap-2"
                                                style="border-radius:8px; font-size:13px; padding:9px 12px;">
                                                <i class="fas fa-eye" style="color:#3498db; width:16px;"></i> View Details
                                            </a>
                                        </li>

                                        <li>
                                            <form action="{{ route('admin.items.status', $item->id) }}" method="POST">
                                                @csrf @method('PATCH')
                                                <input type="hidden" name="status" value="Resolved">
                                                <button type="submit"
                                                    class="dropdown-item d-flex align-items-center gap-2"
                                                    style="border-radius:8px; font-size:13px; padding:9px 12px;">
                                                    <i class="fas fa-check" style="color:#27ae60; width:16px;"></i> Verify Item
                                                </button>
                                            </form>
                                        </li>

                                        <li>
                                            <a href="#" class="dropdown-item d-flex align-items-center gap-2"
                                                style="border-radius:8px; font-size:13px; padding:9px 12px;"
                                                data-bs-toggle="modal"
                                                data-bs-target="#statusModal{{ $item->id }}">
                                                <i class="fas fa-edit" style="color:#f39c12; width:16px;"></i> Update Status
                                            </a>
                                        </li>

                                        <li><hr class="dropdown-divider" style="margin:6px 0;"></li>

                                        <li>
                                            <form action="{{ route('admin.items.destroy', $item->id) }}" method="POST"
                                                onsubmit="return confirm('Delete this item?')">
                                                @csrf @method('DELETE')
                                                <button type="submit"
                                                    class="dropdown-item d-flex align-items-center gap-2"
                                                    style="border-radius:8px; font-size:13px; padding:9px 12px; color:#e74c3c;">
                                                    <i class="fas fa-trash" style="width:16px;"></i> Delete Item
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>

                                {{-- Update Status Modal --}}
                                <div class="modal fade" id="statusModal{{ $item->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered" style="max-width:380px;">
                                        <div class="modal-content" style="border:none; border-radius:16px; padding:8px;">
                                            <div class="modal-header" style="border:none; padding-bottom:0;">
                                                <h5 class="modal-title fw-bold" style="color:#1b4332;">Update Status</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p style="font-size:13px; color:#888;">
                                                    Updating: <strong>{{ $item->name }}</strong>
                                                </p>
                                                <form action="{{ route('admin.items.status', $item->id) }}" method="POST">
                                                    @csrf @method('PATCH')
                                                    <div class="mb-3">
                                                        <label style="font-size:12px; font-weight:600; color:#555; text-transform:uppercase;">Select Status</label>
                                                        <select name="status" class="form-select mt-1">
                                                            <option value="Pending"  {{ $item->status=='Pending'  ? 'selected':'' }}>Pending</option>
                                                            <option value="Found"    {{ $item->status=='Found'    ? 'selected':'' }}>Found</option>
                                                            <option value="Lost"     {{ $item->status=='Lost'     ? 'selected':'' }}>Lost</option>
                                                            <option value="Resolved" {{ $item->status=='Resolved' ? 'selected':'' }}>Resolved</option>
                                                            <option value="Claimed"  {{ $item->status=='Claimed'  ? 'selected':'' }}>Claimed</option>
                                                        </select>
                                                    </div>
                                                    <div class="d-flex gap-2">
                                                        <button type="button" class="btn w-50" data-bs-dismiss="modal"
                                                            style="border:1.5px solid #ddd; border-radius:8px; font-size:13px;">
                                                            Cancel
                                                        </button>
                                                        <button type="submit" class="btn w-50 text-white"
                                                            style="background:#2d6a4f; border-radius:8px; font-size:13px; font-weight:600;">
                                                            Save
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5" style="color:#aaa;">
                                <i class="fas fa-box-open" style="font-size:40px; display:block; margin-bottom:10px;"></i>
                                No items found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($items->hasPages())
            <div class="p-3">{{ $items->links() }}</div>
        @endif
    </div>
</div>
@endsection