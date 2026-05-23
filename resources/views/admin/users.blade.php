@extends('layouts.admin')

@section('content')

<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h3 class="fw-bold mb-1">Platform User Management</h3>
        <p class="text-muted mb-0" style="font-size:13px;">Total active users: {{ $users->total() }}</p>
    </div>
</div>

<div class="card card-round" style="border:none; box-shadow:0 4px 16px rgba(0,0,0,0.06);">
    <div class="card-body p-0">
        <table class="table mb-0">
            <thead>
                <tr style="background:#f9f9f9;">
                    <th style="padding:14px 20px; font-size:11px; text-transform:uppercase; letter-spacing:0.05em; color:#555; font-weight:600; border:none;">User Identity</th>
                    <th style="padding:14px 20px; font-size:11px; text-transform:uppercase; letter-spacing:0.05em; color:#555; font-weight:600; border:none;">Email Contact</th>
                    <th style="padding:14px 20px; font-size:11px; text-transform:uppercase; letter-spacing:0.05em; color:#555; font-weight:600; border:none;">Status</th>
                    <th style="padding:14px 20px; font-size:11px; text-transform:uppercase; letter-spacing:0.05em; color:#555; font-weight:600; border:none;">Access Level</th>
                    <th style="padding:14px 20px; font-size:11px; text-transform:uppercase; letter-spacing:0.05em; color:#555; font-weight:600; border:none;">Member Since</th>
                    <th style="padding:14px 20px; font-size:11px; text-transform:uppercase; letter-spacing:0.05em; color:#555; font-weight:600; border:none;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr style="border-bottom:1px solid #f5f5f5;">

                        {{-- User Identity --}}
                        <td style="padding:14px 20px; border:none;">
                            <div class="d-flex align-items-center gap-3">
                                <div style="width:38px; height:38px; border-radius:50%; background:#e8f5ee;
                                            display:flex; align-items:center; justify-content:center;
                                            font-weight:600; color:#2d6a4f; font-size:14px; flex-shrink:0;">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="fw-bold mb-0" style="font-size:13px;">{{ $user->name }}</p>
                                    <small class="text-muted">{{ $user->student_id ?? 'N/A' }}</small>
                                </div>
                            </div>
                        </td>

                        {{-- Email --}}
                        <td style="padding:14px 20px; border:none; font-size:13px; color:#555;">
                            {{ $user->email }}
                        </td>

                        {{-- Status --}}
                        <td style="padding:14px 20px; border:none;">
                            @php
                                $statusColors = [
                                    'verified' => ['bg' => '#e8f5ee', 'text' => '#2d6a4f'],
                                    'pending'  => ['bg' => '#fff8f0', 'text' => '#f39c12'],
                                    'rejected' => ['bg' => '#fff0f0', 'text' => '#e74c3c'],
                                ];
                                $sc = $statusColors[$user->status ?? 'pending'];
                            @endphp
                            <span class="badge"
                                  style="font-size:11px; padding:5px 12px; border-radius:20px;
                                         background:{{ $sc['bg'] }}; color:{{ $sc['text'] }}; font-weight:600;">
                                {{ strtoupper($user->status ?? 'pending') }}
                            </span>
                        </td>

                        {{-- Access Level --}}
                        <td style="padding:14px 20px; border:none;">
                            <span class="badge"
                                  style="font-size:11px; padding:5px 12px; border-radius:20px;
                                         background:#f0f0f0; color:#555; font-weight:600;">
                                {{ strtoupper($user->role ?? 'student') }}
                            </span>
                        </td>

                        {{-- Member Since --}}
                        <td style="padding:14px 20px; border:none; font-size:13px; color:#555;">
                            {{ $user->created_at->format('M d, Y') }}
                        </td>

                        {{-- Actions --}}
                        <td style="padding:14px 20px; border:none;">
                            <div class="d-flex align-items-center gap-2">

                                {{-- Role Dropdown --}}
                                <form action="/admin/users/{{ $user->id }}/role" method="POST" style="display:inline;">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <select name="role" onchange="this.form.submit()"
                                            style="border:1px solid #e0e0e0; border-radius:8px;
                                                   padding:4px 8px; font-size:12px; color:#555; cursor:pointer;">
                                        <option value="student" {{ $user->role == 'student' ? 'selected' : '' }}>Student</option>
                                        <option value="instructor" {{ $user->role == 'instructor' ? 'selected' : '' }}>Instructor</option>
                                        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                    </select>
                                </form>

                                {{-- Delete --}}
                                <form action="/admin/users/{{ $user->id }}/delete" method="POST" style="display:inline;">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <button type="submit"
                                            onclick="return confirm('Delete this user?')"
                                            style="background:#fff0f0; border:1px solid #e74c3c; color:#e74c3c;
                                                   border-radius:8px; padding:4px 10px; font-size:12px; cursor:pointer;">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>

                            </div>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">No users found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection