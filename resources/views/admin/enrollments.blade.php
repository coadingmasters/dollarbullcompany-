@extends('layouts.admin')

@section('title', 'Premium Group — Admin')
@section('breadcrumb', 'Premium Group')
@section('page_eyebrow', 'Services')
@section('page_title', 'Premium Enrollments')

@push('styles')
<style>
        :root {
            --gold: #C9A84C;
            --gold-light: #E8C97A;
            --gold-dim: #7a6230;
            --black: #0d0d0d;
            --card: #161616;
            --border: rgba(201,168,76,0.18);
            --border-h: rgba(201,168,76,0.5);
            --text: #D8D0C0;
            --muted: #7a7060;
            --red: #C0392B;
            --green: #27ae60;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            background: var(--black);
            color: var(--text);
            font-family: Georgia, serif;
            font-size: 14px;
            min-height: 100vh;
        }
        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 40px 20px;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 40px;
        }
        .header h1 {
            font-family: Cinzel, serif;
            font-size: 2rem;
            color: #fff;
        }
        .header a {
            color: var(--gold-light);
            text-decoration: none;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 16px;
            margin-bottom: 32px;
        }
        .stat-card {
            background: var(--card);
            border: 1px solid var(--border);
            padding: 20px;
            text-align: center;
        }
        .stat-value {
            font-size: 2rem;
            color: var(--gold-light);
            font-weight: 700;
            margin-bottom: 4px;
        }
        .stat-label {
            font-size: 0.8rem;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: 0.1em;
        }

        .table-container {
            background: var(--card);
            border: 1px solid var(--border);
            overflow-x: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        thead {
            background: rgba(201, 168, 76, 0.05);
            border-bottom: 2px solid var(--border);
        }
        th {
            padding: 12px 16px;
            text-align: left;
            font-family: Cinzel, serif;
            font-size: 0.75rem;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: var(--gold);
        }
        td {
            padding: 14px 16px;
            border-bottom: 1px solid rgba(201, 168, 76, 0.08);
        }
        tbody tr:hover {
            background: rgba(201, 168, 76, 0.03);
        }

        .status-badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 3px;
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.1em;
        }
        .status-pending {
            background: rgba(255, 193, 7, 0.15);
            color: #ffd54f;
        }
        .status-verified {
            background: rgba(39, 174, 96, 0.15);
            color: #5dde95;
        }
        .status-rejected {
            background: rgba(192, 57, 43, 0.15);
            color: #e07b73;
        }

        .action-buttons {
            display: flex;
            gap: 6px;
        }
        .btn-small {
            padding: 6px 10px;
            border: 1px solid var(--border);
            background: rgba(201, 168, 76, 0.05);
            color: var(--gold-light);
            font-family: Cinzel, serif;
            font-size: 0.65rem;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
        }
        .btn-small:hover {
            background: rgba(201, 168, 76, 0.15);
            border-color: var(--gold);
        }
        .btn-verify {
            color: #5dde95;
            border-color: rgba(39, 174, 96, 0.3);
        }
        .btn-verify:hover {
            background: rgba(39, 174, 96, 0.1);
        }
        .btn-reject {
            color: #e07b73;
            border-color: rgba(192, 57, 43, 0.3);
        }
        .btn-reject:hover {
            background: rgba(192, 57, 43, 0.1);
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: var(--muted);
        }

        .modal {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.8);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }
        .modal.active {
            display: flex;
        }
        .modal-content {
            background: var(--card);
            border: 1px solid var(--border);
            padding: 32px;
            max-width: 880px;
            width: 92%;
            max-height: 90vh;
            overflow-y: auto;
        }
        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 16px;
            border-bottom: 1px solid var(--border);
        }
        .modal-header h2 {
            font-family: Cinzel, serif;
            font-size: 1.4rem;
            color: #fff;
        }
        .modal-close {
            background: none;
            border: none;
            color: var(--muted);
            font-size: 1.5rem;
            cursor: pointer;
        }
        .modal-body {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }
        .info-group {
            grid-column: span 1;
        }
        .info-group.full {
            grid-column: span 2;
        }
        .info-label {
            font-family: Cinzel, serif;
            font-size: 0.7rem;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: var(--gold);
            margin-bottom: 4px;
        }
        .info-value {
            color: var(--text);
            line-height: 1.4;
        }
        .screenshot-preview {
            margin-top: 16px;
            padding-top: 16px;
            border-top: 1px solid var(--border);
        }
        .modal-images {
            grid-column: span 2;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-top: 8px;
        }
        @media (max-width: 640px) {
            .modal-images {
                grid-template-columns: 1fr;
            }
        }
        .modal-img-box {
            border: 1px solid var(--border);
            padding: 12px;
            background: rgba(0,0,0,0.2);
        }
        .modal-img-box .info-label {
            margin-bottom: 10px;
        }
        .screenshot-preview img,
        .modal-img-box img {
            max-width: 100%;
            max-height: 280px;
            object-fit: contain;
            display: block;
            margin: 0 auto;
            border: 1px solid var(--border);
        }
        .modal-actions {
            grid-column: span 2;
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid var(--border);
        }
        .flash-msg {
            background: rgba(39, 174, 96, 0.12);
            border: 1px solid rgba(39, 174, 96, 0.35);
            color: #7dcea0;
            padding: 14px 18px;
            margin-bottom: 24px;
            border-radius: 4px;
        }
    </style>
@endpush

@section('content')
        <div class="stats">
            <div class="stat-card">
                <div class="stat-value">{{ $enrollments->count() }}</div>
                <div class="stat-label">Total</div>
            </div>
            <div class="stat-card">
                <div class="stat-value">{{ $enrollments->where('status', 'pending')->count() }}</div>
                <div class="stat-label">Pending</div>
            </div>
            <div class="stat-card">
                <div class="stat-value">{{ $enrollments->where('status', 'verified')->count() }}</div>
                <div class="stat-label">Verified</div>
            </div>
            <div class="stat-card">
                <div class="stat-value">{{ $enrollments->where('status', 'rejected')->count() }}</div>
                <div class="stat-label">Rejected</div>
            </div>
        </div>

        @if($enrollments->isEmpty())
            <div class="empty-state">
                <div style="font-size: 3rem; margin-bottom: 20px;">📭</div>
                <h2>No enrollments yet</h2>
                <p>Enrollments will appear here once users submit the form.</p>
            </div>
        @else
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>WhatsApp</th>
                            <th>Country</th>
                            <th>CICNI</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($enrollments as $enrollment)
                            <tr>
                                <td>{{ $enrollment->first_name }} {{ $enrollment->last_name }}</td>
                                <td><a href="mailto:{{ $enrollment->email }}" style="color: var(--gold); text-decoration: none;">{{ $enrollment->email }}</a></td>
                                <td>+{{ $enrollment->whatsapp_number }}</td>
                                <td>{{ $enrollment->country }}</td>
                                <td>{{ $enrollment->cicni }}</td>
                                <td><span class="status-badge status-{{ $enrollment->status }}">{{ ucfirst($enrollment->status) }}</span></td>
                                <td>{{ $enrollment->created_at->format('M d, Y') }}</td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn-small" onclick="openModal({{ $enrollment->id }})">View</button>
                                        @if($enrollment->status !== 'verified')
                                            <form method="POST" action="{{ route('enrollments.verify', $enrollment) }}" style="display: inline;">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn-small btn-verify">Verify</button>
                                            </form>
                                        @endif
                                        @if($enrollment->status !== 'rejected')
                                            <form method="POST" action="{{ route('enrollments.reject', $enrollment) }}" style="display: inline;">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn-small btn-reject">Reject</button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

    <!-- Modal for enrollment details -->
    <div class="modal" id="enrollmentModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Enrollment Details</h2>
                <button class="modal-close" onclick="closeModal()">&times;</button>
            </div>
            <div class="modal-body" id="modalBody"></div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const adminBase = @json(rtrim(url('/admin'), '/'));

        const enrollmentsData = {!! json_encode($enrollments->map(function ($e) {
            return [
                'id' => $e->id,
                'first_name' => $e->first_name,
                'last_name' => $e->last_name,
                'email' => $e->email,
                'whatsapp_number' => $e->whatsapp_number,
                'country' => $e->country,
                'cicni' => $e->cicni,
                'face_recognition' => $e->face_recognition,
                'course' => $e->course,
                'status_label' => ucfirst($e->status),
                'status_raw' => $e->status,
                'created_at' => $e->created_at->format('M d, Y H:i A'),
                'payment_screenshot' => $e->payment_screenshot ? asset('storage/' . $e->payment_screenshot) : null,
                'face_photo' => $e->face_photo ? asset('storage/' . $e->face_photo) : null,
            ];
        })) !!};

        function openModal(id) {
            const enrollment = enrollmentsData.find(e => e.id === id);
            if (!enrollment) return;

            const modalBody = document.getElementById('modalBody');
            const st = enrollment.status_raw;
            const badgeClass = 'status-' + String(st).toLowerCase();

            let html = `
                <div class="info-group">
                    <div class="info-label">First Name</div>
                    <div class="info-value">${enrollment.first_name}</div>
                </div>
                <div class="info-group">
                    <div class="info-label">Last Name</div>
                    <div class="info-value">${enrollment.last_name || '—'}</div>
                </div>
                <div class="info-group full">
                    <div class="info-label">Email</div>
                    <div class="info-value"><a href="mailto:${enrollment.email}" style="color: var(--gold); text-decoration: none;">${enrollment.email}</a></div>
                </div>
                <div class="info-group">
                    <div class="info-label">WhatsApp</div>
                    <div class="info-value">+${enrollment.whatsapp_number}</div>
                </div>
                <div class="info-group">
                    <div class="info-label">Country</div>
                    <div class="info-value">${enrollment.country}</div>
                </div>
                <div class="info-group">
                    <div class="info-label">CICNI</div>
                    <div class="info-value">${enrollment.cicni}</div>
                </div>
                <div class="info-group">
                    <div class="info-label">Status</div>
                    <div class="info-value"><span class="status-badge ${badgeClass}">${enrollment.status_label}</span></div>
                </div>
                <div class="info-group full">
                    <div class="info-label">Course</div>
                    <div class="info-value">${enrollment.course || '—'}</div>
                </div>
                <div class="info-group full">
                    <div class="info-label">Submitted</div>
                    <div class="info-value">${enrollment.created_at}</div>
                </div>
            `;

            if (enrollment.face_photo || enrollment.payment_screenshot || enrollment.face_recognition) {
                html += '<div class="modal-images">';
                if (enrollment.face_photo) {
                    html += `
                        <div class="modal-img-box">
                            <div class="info-label">Student face (capture)</div>
                            <img src="${enrollment.face_photo}" alt="Student face">
                        </div>`;
                } else if (enrollment.face_recognition) {
                    html += `
                        <div class="modal-img-box">
                            <div class="info-label">Face note (legacy)</div>
                            <div class="info-value" style="padding:8px 0">${enrollment.face_recognition}</div>
                        </div>`;
                }
                if (enrollment.payment_screenshot) {
                    html += `
                        <div class="modal-img-box">
                            <div class="info-label">Payment proof</div>
                            <img src="${enrollment.payment_screenshot}" alt="Payment proof">
                        </div>`;
                }
                html += '</div>';
            }

            html += '<div class="modal-actions">';
            if (st !== 'verified') {
                html += `
                    <form method="POST" action="${adminBase}/enrollments/${enrollment.id}/verify" style="display:inline">
                        <input type="hidden" name="_token" value="${csrfToken}">
                        <input type="hidden" name="_method" value="PATCH">
                        <button type="submit" class="btn-small btn-verify">Approve (verify)</button>
                    </form>`;
            }
            if (st !== 'rejected') {
                html += `
                    <form method="POST" action="${adminBase}/enrollments/${enrollment.id}/reject" style="display:inline">
                        <input type="hidden" name="_token" value="${csrfToken}">
                        <input type="hidden" name="_method" value="PATCH">
                        <button type="submit" class="btn-small btn-reject">Reject</button>
                    </form>`;
            }
            html += '</div>';

            modalBody.innerHTML = html;
            document.getElementById('enrollmentModal').classList.add('active');
        }

        function closeModal() {
            document.getElementById('enrollmentModal').classList.remove('active');
        }

        document.getElementById('enrollmentModal').addEventListener('click', function(e) {
            if (e.target === this) closeModal();
        });
    </script>
@endpush
