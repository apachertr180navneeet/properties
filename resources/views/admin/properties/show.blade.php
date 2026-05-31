@extends('admin.layouts.app')

@section('style')
<style>
    /* ── Page shell ─────────────────────────────────────────── */
    .pv-wrap { display: flex; gap: 1.5rem; align-items: flex-start; }
    .pv-main { flex: 1 1 0; min-width: 0; }
    .pv-sidebar {
        width: 300px;
        flex-shrink: 0;
        position: sticky;
        top: 80px;
    }

    /* ── Hero Header ────────────────────────────────────────── */
    .pv-hero {
        border-radius: 18px;
        background: linear-gradient(135deg, #696cff 0%, #8592ff 55%, #a78bfa 100%);
        padding: 2rem 2rem 1.5rem;
        color: #fff;
        margin-bottom: 1.25rem;
        position: relative;
        overflow: hidden;
    }
    .pv-hero::before {
        content: '';
        position: absolute;
        top: -60px; right: -60px;
        width: 220px; height: 220px;
        background: rgba(255,255,255,.08);
        border-radius: 50%;
    }
    .pv-hero::after {
        content: '';
        position: absolute;
        bottom: -40px; left: 30%;
        width: 160px; height: 160px;
        background: rgba(255,255,255,.05);
        border-radius: 50%;
    }
    .pv-hero-title {
        font-size: 1.5rem;
        font-weight: 800;
        line-height: 1.25;
        margin: 0 0 .35rem;
        position: relative; z-index: 1;
    }
    .pv-hero-meta {
        font-size: .82rem;
        opacity: .85;
        position: relative; z-index: 1;
        display: flex; flex-wrap: wrap; gap: .5rem .9rem; align-items: center;
    }
    .pv-hero-meta span { display: flex; align-items: center; gap: 4px; }
    .pv-hero-badges {
        display: flex; flex-wrap: wrap; gap: .5rem;
        margin-top: 1rem; position: relative; z-index: 1;
    }
    .pv-hero-badge {
        background: rgba(255,255,255,.18);
        color: #fff;
        border: 1px solid rgba(255,255,255,.3);
        backdrop-filter: blur(4px);
        padding: .3rem .9rem;
        border-radius: 50px;
        font-size: .78rem;
        font-weight: 600;
    }

    /* ── Cards (shared) ─────────────────────────────────────── */
    .pv-card {
        background: #fff;
        border-radius: 16px;
        border: 1px solid #eaecf5;
        box-shadow: 0 2px 16px rgba(105,108,255,.06);
        margin-bottom: 1.25rem;
        overflow: hidden;
    }
    .pv-card-head {
        padding: .9rem 1.4rem;
        border-bottom: 1px solid #f3f4fb;
        display: flex; align-items: center; gap: 8px;
    }
    .pv-card-head-icon {
        width: 32px; height: 32px;
        border-radius: 8px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1rem;
        background: linear-gradient(135deg,#eef0ff,#f5f4ff);
        color: #696cff;
        flex-shrink: 0;
    }
    .pv-card-head-title {
        font-size: .82rem;
        font-weight: 700;
        color: #696cff;
        text-transform: uppercase;
        letter-spacing: .5px;
    }
    .pv-card-body { padding: 1.25rem 1.4rem; }

    /* ── Info Row ───────────────────────────────────────────── */
    .info-row { display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: .85rem; }
    .info-item {}
    .info-item .lbl {
        font-size: .74rem;
        font-weight: 600;
        color: #a0aaba;
        text-transform: uppercase;
        letter-spacing: .4px;
        margin-bottom: .2rem;
        display: flex; align-items: center; gap: 4px;
    }
    .info-item .lbl i { color: #b0b5ff; font-size: .85rem; }
    .info-item .val {
        font-size: .95rem;
        font-weight: 600;
        color: #2b2b4a;
    }
    .info-item .val.money { color: #059669; font-size: 1.05rem; }
    .info-item .val.na { color: #c0c6d4; font-weight: 400; font-style: italic; }

    /* ── Divider inside card ────────────────────────────────── */
    .pv-divider { height: 1px; background: #f3f4fb; margin: 1rem 0; }

    /* ── Sidebar stat card ──────────────────────────────────── */
    .stat-pill {
        display: flex; align-items: center; gap: .85rem;
        padding: .8rem 1rem;
        border-radius: 12px;
        background: #f8f9ff;
        border: 1px solid #eaecf5;
        margin-bottom: .7rem;
        transition: box-shadow .2s;
    }
    .stat-pill:hover { box-shadow: 0 4px 16px rgba(105,108,255,.1); }
    .stat-pill-icon {
        width: 40px; height: 40px; border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.1rem; flex-shrink: 0;
    }
    .stat-pill-lbl { font-size: .75rem; color: #a0aaba; font-weight: 600; text-transform: uppercase; letter-spacing: .4px; }
    .stat-pill-val { font-size: .95rem; font-weight: 700; color: #2b2b4a; }
    .stat-pill-val.money { color: #059669; }

    /* icon color variants */
    .ic-purple { background: #eef0ff; color: #696cff; }
    .ic-green  { background: #ecfdf5; color: #059669; }
    .ic-amber  { background: #fffbeb; color: #d97706; }
    .ic-blue   { background: #eff6ff; color: #3b82f6; }
    .ic-rose   { background: #fff1f2; color: #f43f5e; }
    .ic-teal   { background: #f0fdfb; color: #0d9488; }

    /* ── Status toggle ──────────────────────────────────────── */
    .status-group { display: flex; gap: .4rem; flex-wrap: wrap; }
    .status-btn {
        flex: 1;
        text-align: center;
        padding: .45rem .5rem;
        border-radius: 50px;
        font-size: .78rem;
        font-weight: 600;
        cursor: pointer;
        border: 1.5px solid transparent;
        transition: all .18s;
        user-select: none;
    }
    .status-btn.available        { border-color: #059669; color: #059669; background: #ecfdf5; }
    .status-btn.sold             { border-color: #f43f5e; color: #f43f5e; background: #fff1f2; }
    .status-btn.pending          { border-color: #d97706; color: #d97706; background: #fffbeb; }
    .status-btn.active-status    { color: #fff !important; }
    .status-btn.available.active-status { background: #059669 !important; }
    .status-btn.sold.active-status      { background: #f43f5e !important; }
    .status-btn.pending.active-status   { background: #d97706 !important; }
    .status-btn:hover { transform: scale(1.04); }

    /* ── Action buttons ─────────────────────────────────────── */
    .btn-pv-edit {
        display: flex; align-items: center; justify-content: center; gap: 6px;
        padding: .55rem 1.25rem;
        background: linear-gradient(135deg,#696cff,#8592ff);
        color: #fff;
        border-radius: 10px;
        font-size: .88rem;
        font-weight: 600;
        text-decoration: none;
        border: none;
        transition: box-shadow .2s, transform .15s;
        width: 100%;
    }
    .btn-pv-edit:hover { color:#fff; box-shadow: 0 6px 18px rgba(105,108,255,.35); transform: translateY(-1px); }
    .btn-pv-back {
        display: flex; align-items: center; justify-content: center; gap: 6px;
        padding: .55rem 1.25rem;
        background: #f3f4fb;
        color: #566a7f;
        border-radius: 10px;
        font-size: .88rem;
        font-weight: 600;
        text-decoration: none;
        border: none;
        transition: background .15s;
        width: 100%;
        margin-top: .5rem;
    }
    .btn-pv-back:hover { background: #e8eaf6; color: #566a7f; }

    /* ── Document preview ───────────────────────────────────── */
    .doc-preview {
        border: 1.5px dashed #d8daf0;
        border-radius: 12px;
        overflow: hidden;
        text-align: center;
        background: #fafbff;
        transition: border-color .2s;
        cursor: pointer;
    }
    .doc-preview:hover { border-color: #696cff; }
    .doc-preview img { width: 100%; max-height: 160px; object-fit: cover; display: block; }
    .doc-preview .dp-inner { padding: 1.5rem 1rem; }
    .doc-preview .dp-icon { font-size: 2.2rem; color: #d4d8f0; }
    .doc-preview .dp-text { font-size: .8rem; color: #a0aaba; margin-top: .4rem; font-weight: 500; }
    .doc-preview .dp-label {
        padding: .45rem .75rem;
        font-size: .78rem;
        font-weight: 600;
        color: #696cff;
        background: #eef0ff;
        display: flex; align-items: center; justify-content: center; gap: 5px;
    }

    /* ── Remarks block ──────────────────────────────────────── */
    .remarks-box {
        background: #fafbff;
        border-left: 3px solid #696cff;
        border-radius: 0 10px 10px 0;
        padding: .9rem 1.1rem;
        color: #3d3d6b;
        font-size: .9rem;
        line-height: 1.6;
    }

    /* ── Responsive ─────────────────────────────────────────── */
    @media (max-width: 991.98px) {
        .pv-wrap { flex-direction: column; }
        .pv-sidebar { width: 100%; position: static; }
    }
</style>
@endsection

@section('content')
<div class="container-fluid flex-grow-1 container-p-y">

    {{-- Page Breadcrumb --}}
    <div class="d-flex align-items-center justify-content-between mb-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.properties.index') }}">Properties</a></li>
                <li class="breadcrumb-item active" aria-current="page">View Property</li>
            </ol>
        </nav>
        <div class="d-flex gap-2 d-md-none">
            <a href="{{ route('admin.properties.edit', $property->id) }}" class="btn btn-sm btn-primary"><i class="bx bx-edit-alt"></i></a>
            <a href="{{ route('admin.properties.index') }}" class="btn btn-sm btn-outline-secondary"><i class="bx bx-arrow-back"></i></a>
        </div>
    </div>

    <div class="pv-wrap">

        {{-- ════════════════ MAIN COLUMN ════════════════ --}}
        <div class="pv-main">

            {{-- ── Hero Header ── --}}
            <div class="pv-hero">
                <div class="pv-hero-title">{{ $property->title }}</div>
                <div class="pv-hero-meta">
                    <span><i class="bx bx-hash"></i> ID #{{ $property->id }}</span>
                    <span><i class="bx bx-calendar"></i> Created {{ $property->created_at->format('d M Y') }}</span>
                    @if($property->add_on_date)
                        <span><i class="bx bx-calendar-check"></i> Listed {{ \Carbon\Carbon::parse($property->add_on_date)->format('d M Y') }}</span>
                    @endif
                    @if($property->city)
                        <span><i class="bx bx-map"></i> {{ $property->city }}{{ $property->state ? ', ' . $property->state : '' }}</span>
                    @endif
                </div>
                <div class="pv-hero-badges">
                    <span class="pv-hero-badge"><i class="bx bx-building-house me-1"></i>{{ $property->property_category }}</span>
                    @if($property->build_type)
                        <span class="pv-hero-badge"><i class="bx bx-layer me-1"></i>{{ $property->build_type }}</span>
                    @endif
                    @if($property->property_type)
                        <span class="pv-hero-badge">{{ $property->property_type }}</span>
                    @endif
                    @if($property->facing)
                        <span class="pv-hero-badge"><i class="bx bx-compass me-1"></i>{{ $property->facing }} Facing</span>
                    @endif
                </div>
            </div>

            {{-- ── Location Details ── --}}
            <div class="pv-card">
                <div class="pv-card-head">
                    <div class="pv-card-head-icon"><i class="bx bx-map-pin"></i></div>
                    <div class="pv-card-head-title">Location Details</div>
                </div>
                <div class="pv-card-body">
                    <div class="info-row">
                        <div class="info-item">
                            <div class="lbl"><i class="bx bx-map"></i> City</div>
                            <div class="val {{ $property->city ? '' : 'na' }}">{{ $property->city ?? 'Not specified' }}</div>
                        </div>
                        <div class="info-item">
                            <div class="lbl"><i class="bx bx-flag"></i> State</div>
                            <div class="val {{ $property->state ? '' : 'na' }}">{{ $property->state ?? 'Not specified' }}</div>
                        </div>
                        <div class="info-item">
                            <div class="lbl"><i class="bx bx-current-location"></i> Location</div>
                            <div class="val {{ $property->location ? '' : 'na' }}">{{ $property->location ?? 'Not specified' }}</div>
                        </div>
                        <div class="info-item">
                            <div class="lbl"><i class="bx bx-mail-send"></i> Pin Code</div>
                            <div class="val {{ $property->pin_code ? '' : 'na' }}">{{ $property->pin_code ?? '-' }}</div>
                        </div>
                        @if($property->plot_number)
                        <div class="info-item">
                            <div class="lbl"><i class="bx bx-hash"></i> Plot No.</div>
                            <div class="val">{{ $property->plot_number }}</div>
                        </div>
                        @endif
                    </div>
                    @if($property->address)
                        <div class="pv-divider"></div>
                        <div class="info-item">
                            <div class="lbl"><i class="bx bx-home-alt"></i> Full Address</div>
                            <div class="val" style="font-size:.9rem;font-weight:500;color:#444;">{{ $property->address }}</div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- ── Size & Facing ── --}}
            <div class="pv-card">
                <div class="pv-card-head">
                    <div class="pv-card-head-icon"><i class="bx bx-ruler"></i></div>
                    <div class="pv-card-head-title">Size & Facing</div>
                </div>
                <div class="pv-card-body">
                    <div class="info-row">
                        <div class="info-item">
                            <div class="lbl"><i class="bx bx-expand"></i> Dimensions</div>
                            <div class="val">
                                @if($property->length && $property->width)
                                    {{ $property->length }} × {{ $property->size_separator }} × {{ $property->width }} {{ $property->area_unit ?? 'Sq.ft' }}
                                @else
                                    <span class="na">Not specified</span>
                                @endif
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="lbl"><i class="bx bx-area"></i> Area Size</div>
                            <div class="val {{ $property->area_size ? '' : 'na' }}">
                                {{ $property->area_size ? $property->area_size . ' ' . ($property->area_unit ?? 'Sq.ft') : 'Not specified' }}
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="lbl"><i class="bx bx-compass"></i> Facing</div>
                            <div class="val {{ $property->facing ? '' : 'na' }}">{{ $property->facing ?? 'Not specified' }}</div>
                        </div>
                        <div class="info-item">
                            <div class="lbl"><i class="bx bx-transfer-alt"></i> Corner Plot</div>
                            <div class="val">
                                @if($property->corner_plot === 'Yes')
                                    <span class="badge" style="background:#ecfdf5;color:#059669;padding:.3rem .75rem;border-radius:50px;font-size:.82rem;">✓ Yes</span>
                                @else
                                    <span class="badge" style="background:#f3f4fb;color:#8592a3;padding:.3rem .75rem;border-radius:50px;font-size:.82rem;">No</span>
                                @endif
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="lbl"><i class="bx bx-category"></i> Area Unit</div>
                            <div class="val {{ $property->area_unit ? '' : 'na' }}">{{ $property->area_unit ?? '-' }}</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ── Pricing ── --}}
            <div class="pv-card">
                <div class="pv-card-head">
                    <div class="pv-card-head-icon"><i class="bx bx-rupee"></i></div>
                    <div class="pv-card-head-title">Pricing</div>
                </div>
                <div class="pv-card-body">
                    <div class="info-row">
                        <div class="info-item">
                            <div class="lbl"><i class="bx bx-money-withdraw"></i> Full Amount</div>
                            <div class="val money">{{ $property->price ? '₹ ' . number_format($property->price) : '-' }}</div>
                        </div>
                        <div class="info-item">
                            <div class="lbl"><i class="bx bx-trending-up"></i> Sq. Yard Rate</div>
                            <div class="val {{ $property->sq_yard_rate ? 'money' : 'na' }}">
                                {{ $property->sq_yard_rate ? '₹ ' . number_format($property->sq_yard_rate) : 'Not specified' }}
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="lbl"><i class="bx bx-receipt"></i> Stamp Duty</div>
                            <div class="val {{ $property->stamp_duty ? '' : 'na' }}">
                                {{ $property->stamp_duty ? '₹ ' . number_format($property->stamp_duty) : 'Not specified' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ── Property Details ── --}}
            <div class="pv-card">
                <div class="pv-card-head">
                    <div class="pv-card-head-icon"><i class="bx bx-detail"></i></div>
                    <div class="pv-card-head-title">Property Details</div>
                </div>
                <div class="pv-card-body">
                    <div class="info-row">
                        <div class="info-item">
                            <div class="lbl"><i class="bx bx-wrench"></i> Construction</div>
                            <div class="val {{ $property->construction_type ? '' : 'na' }}">{{ $property->construction_type ?? 'Not specified' }}</div>
                        </div>
                        <div class="info-item">
                            <div class="lbl"><i class="bx bx-time-five"></i> Property Age</div>
                            <div class="val {{ $property->property_age ? '' : 'na' }}">{{ $property->property_age ?? 'Not specified' }}</div>
                        </div>
                        <div class="info-item">
                            <div class="lbl"><i class="bx bx-sofa"></i> Setup Type</div>
                            <div class="val {{ $property->setup_type ? '' : 'na' }}">{{ $property->setup_type ?? 'Not specified' }}</div>
                        </div>
                        <div class="info-item">
                            <div class="lbl"><i class="bx bx-check-shield"></i> Condition</div>
                            <div class="val {{ $property->property_condition ? '' : 'na' }}">{{ $property->property_condition ?? 'Not specified' }}</div>
                        </div>
                        <div class="info-item">
                            <div class="lbl"><i class="bx bx-calendar-event"></i> Add On Date</div>
                            <div class="val {{ $property->add_on_date ? '' : 'na' }}">
                                {{ $property->add_on_date ? \Carbon\Carbon::parse($property->add_on_date)->format('d M Y') : 'Not specified' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ── Additional Info ── --}}
            <div class="pv-card">
                <div class="pv-card-head">
                    <div class="pv-card-head-icon"><i class="bx bx-info-circle"></i></div>
                    <div class="pv-card-head-title">Additional Info</div>
                </div>
                <div class="pv-card-body">
                    <div class="info-row">
                        <div class="info-item">
                            <div class="lbl"><i class="bx bx-user-circle"></i> Owner Name</div>
                            <div class="val {{ $property->owner_name ? '' : 'na' }}">{{ $property->owner_name ?? 'Not specified' }}</div>
                        </div>
                        <div class="info-item">
                            <div class="lbl"><i class="bx bx-phone"></i> Owner Phone</div>
                            <div class="val {{ $property->owner_phone ? '' : 'na' }}">{{ $property->owner_phone ?? 'Not specified' }}</div>
                        </div>
                        <div class="info-item">
                            <div class="lbl"><i class="bx bx-id-card"></i> Registry Owner</div>
                            <div class="val {{ $property->registry_owner ? '' : 'na' }}">{{ $property->registry_owner ?? 'Not specified' }}</div>
                        </div>
                        <div class="info-item">
                            <div class="lbl"><i class="bx bx-git-branch"></i> Via</div>
                            <div class="val {{ $property->via ? '' : 'na' }}">{{ $property->via ?? 'Not specified' }}</div>
                        </div>
                        <div class="info-item">
                            <div class="lbl"><i class="bx bx-user-pin"></i> Sales Persons</div>
                            <div class="val {{ $property->salesPersons->count() ? '' : 'na' }}">
                                @if($property->salesPersons->count())
                                    {{ $property->salesPersons->pluck('name')->implode(', ') }}
                                @else
                                    Not assigned
                                @endif
                            </div>
                        </div>
                    </div>
                    @if($property->remarks)
                        <div class="pv-divider"></div>
                        <div class="lbl mb-2" style="font-size:.74rem;font-weight:600;color:#a0aaba;text-transform:uppercase;letter-spacing:.4px;">
                            <i class="bx bx-comment-dots" style="color:#b0b5ff;"></i> Remarks
                        </div>
                        <div class="remarks-box">{{ $property->remarks }}</div>
                    @endif
                </div>
            </div>

            {{-- ── Documents ── --}}
            <div class="pv-card">
                <div class="pv-card-head">
                    <div class="pv-card-head-icon"><i class="bx bx-folder-open"></i></div>
                    <div class="pv-card-head-title">Documents & Photos</div>
                </div>
                <div class="pv-card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            @if($property->property_photo)
                                <a href="{{ $property->property_photo }}" target="_blank" class="doc-preview d-block">
                                    <img src="{{ $property->property_photo }}" alt="Property Photo">
                                    <div class="dp-label"><i class="bx bx-image"></i> Property Photo – Click to view</div>
                                </a>
                            @else
                                <div class="doc-preview">
                                    <div class="dp-inner">
                                        <div class="dp-icon"><i class="bx bx-image"></i></div>
                                        <div class="dp-text">No property photo uploaded</div>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-6">
                            @if($property->registry_document)
                                <a href="{{ $property->registry_document }}" target="_blank" class="doc-preview d-block">
                                    @if(pathinfo($property->registry_document, PATHINFO_EXTENSION) === 'pdf')
                                        <div class="dp-inner">
                                            <div class="dp-icon" style="color:#696cff;"><i class="bx bxs-file-pdf" style="font-size:3rem;"></i></div>
                                            <div class="dp-text" style="color:#696cff;font-weight:600;">PDF Document</div>
                                        </div>
                                    @else
                                        <img src="{{ $property->registry_document }}" alt="Registry Document">
                                    @endif
                                    <div class="dp-label"><i class="bx bx-file"></i> Registry Document – Click to view</div>
                                </a>
                            @else
                                <div class="doc-preview">
                                    <div class="dp-inner">
                                        <div class="dp-icon"><i class="bx bx-file"></i></div>
                                        <div class="dp-text">No registry document uploaded</div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        </div>
        {{-- ════════════════ END MAIN ════════════════ --}}

        {{-- ════════════════ SIDEBAR ════════════════ --}}
        <div class="pv-sidebar">

            {{-- Action Buttons --}}
            <div class="pv-card">
                <div class="pv-card-body" style="padding:.9rem 1.1rem;">
                    <a href="{{ route('admin.properties.edit', $property->id) }}" class="btn-pv-edit">
                        <i class="bx bx-edit-alt"></i> Edit Property
                    </a>
                    <a href="{{ route('admin.properties.index') }}" class="btn-pv-back">
                        <i class="bx bx-arrow-back"></i> Back to List
                    </a>
                </div>
            </div>

            {{-- Status Toggle --}}
            <div class="pv-card">
                <div class="pv-card-head">
                    <div class="pv-card-head-icon"><i class="bx bx-toggle-left"></i></div>
                    <div class="pv-card-head-title">Status</div>
                </div>
                <div class="pv-card-body">
                    <div class="status-group status-toggle-group" data-id="{{ $property->id }}">
                        @foreach(['available', 'sold', 'pending'] as $st)
                            <div class="status-btn {{ $st }} {{ $property->status === $st ? 'active-status' : '' }}"
                                 data-status="{{ $st }}"
                                 onclick="changeStatus(this, {{ $property->id }}, '{{ $st }}')">
                                {{ ucfirst($st) }}
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Key Stats --}}
            <div class="pv-card">
                <div class="pv-card-head">
                    <div class="pv-card-head-icon"><i class="bx bx-stats"></i></div>
                    <div class="pv-card-head-title">Key Info</div>
                </div>
                <div class="pv-card-body" style="padding:.9rem 1.1rem;">

                    <div class="stat-pill">
                        <div class="stat-pill-icon ic-green"><i class="bx bx-rupee"></i></div>
                        <div>
                            <div class="stat-pill-lbl">Full Amount</div>
                            <div class="stat-pill-val money">{{ $property->price ? '₹ ' . number_format($property->price) : '—' }}</div>
                        </div>
                    </div>

                    <div class="stat-pill">
                        <div class="stat-pill-icon ic-purple"><i class="bx bx-area"></i></div>
                        <div>
                            <div class="stat-pill-lbl">Area Size</div>
                            <div class="stat-pill-val">{{ $property->area_size ? $property->area_size . ' ' . ($property->area_unit ?? 'Sq.ft') : '—' }}</div>
                        </div>
                    </div>

                    @if($property->length && $property->width)
                    <div class="stat-pill">
                        <div class="stat-pill-icon ic-blue"><i class="bx bx-expand"></i></div>
                        <div>
                            <div class="stat-pill-lbl">Dimensions</div>
                            <div class="stat-pill-val">{{ $property->length }} × {{ $property->size_separator }} × {{ $property->width }} {{ $property->area_unit ?? 'Sq.ft' }}</div>
                        </div>
                    </div>
                    @endif

                    <div class="stat-pill">
                        <div class="stat-pill-icon ic-teal"><i class="bx bx-map-pin"></i></div>
                        <div>
                            <div class="stat-pill-lbl">Location</div>
                            <div class="stat-pill-val">{{ $property->location ?? '—' }}</div>
                        </div>
                    </div>

                    <div class="stat-pill">
                        <div class="stat-pill-icon ic-amber"><i class="bx bx-user"></i></div>
                        <div>
                            <div class="stat-pill-lbl">Sales Persons</div>
                            <div class="stat-pill-val">
                                @if($property->salesPersons->count())
                                    {{ $property->salesPersons->pluck('name')->implode(', ') }}
                                @else
                                    —
                                @endif
                            </div>
                        </div>
                    </div>

                    @if($property->sq_yard_rate)
                    <div class="stat-pill">
                        <div class="stat-pill-icon ic-rose"><i class="bx bx-trending-up"></i></div>
                        <div>
                            <div class="stat-pill-lbl">Sq. Yard Rate</div>
                            <div class="stat-pill-val money">₹ {{ number_format($property->sq_yard_rate) }}</div>
                        </div>
                    </div>
                    @endif

                </div>
            </div>

        </div>
        {{-- ════════════════ END SIDEBAR ════════════════ --}}

    </div>
</div>
@endsection

@section('script')
<script>
    function changeStatus(el, id, status) {
        const url = "{{ route('admin.properties.toggle-status', ['id' => '__ID__']) }}";
        fetch(url.replace('__ID__', id), {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ status })
        })
        .then(r => r.json())
        .then(res => {
            if (res.success) {
                const group = el.closest('.status-toggle-group');
                group.querySelectorAll('.status-btn').forEach(btn => {
                    btn.classList.remove('active-status');
                    if (btn.dataset.status === res.status) {
                        btn.classList.add('active-status');
                    }
                });
            }
        })
        .catch(() => {});
    }
</script>
@endsection
