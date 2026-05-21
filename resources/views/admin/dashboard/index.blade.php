@extends('admin.layouts.app')

@section('style')
<style>
.stat-card {
    transition: transform .2s, box-shadow .2s;
    border-left: 4px solid;
    cursor: default;
}
.stat-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 .5rem 1rem rgba(0,0,0,.12);
}
.stat-card .stat-icon {
    width: 48px; height: 48px;
    display: flex; align-items: center; justify-content: center;
    border-radius: 12px; font-size: 1.5rem;
}

.welcome-section, .welcome-section h4, .welcome-section p { color: #ffffff !important; }
.welcome-section {
    background: linear-gradient(135deg, #696cff 0%, #4a4dcf 100%);
    border-radius: 12px; padding: 2rem; margin-bottom: 2rem;
}
.welcome-section h4 { font-weight: 600; margin-bottom: .5rem; }
.welcome-section p { opacity: .85; margin-bottom: 0; font-size: .95rem; }

.dashboard-card {
    border-radius: 16px;
    padding: 1.25rem 1rem;
    min-height: 130px;
    display: flex;
    flex-direction: row;
    align-items: center;
    gap: 1rem;
    transition: all .3s ease;
    position: relative;
    overflow: hidden;
    border: 1px solid rgba(0,0,0,.04);
}
.dashboard-card:hover { transform: translateY(-4px); box-shadow: 0 8px 20px rgba(0,0,0,.1); }
.dashboard-card .card-icon {
    width: 48px; height: 48px;
    border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.4rem; flex-shrink: 0;
}
.dashboard-card .card-text { flex: 1; }
.dashboard-card h4 { font-size: .85rem; font-weight: 600; line-height: 1.3; margin-bottom: .25rem; }
.dashboard-card h3 { font-size: 1.35rem; font-weight: 700; margin: 0; }
.dashboard-card .card-bg-icon {
    position: absolute; right: -5px; bottom: -5px;
    font-size: 4rem; opacity: .06;
}

.card-purple {
    background: linear-gradient(135deg, #f5f0ff, #ede5ff);
    border-left: 4px solid #7c3aed;
}
.card-purple .card-icon { background: #7c3aed; color: #fff; }
.card-purple h4, .card-purple h3 { color: #4c1d95; }

.card-green {
    background: linear-gradient(135deg, #ecfdf5, #d1fae5);
    border-left: 4px solid #10b981;
}
.card-green .card-icon { background: #10b981; color: #fff; }
.card-green h4, .card-green h3 { color: #065f46; }

.card-blue {
    background: linear-gradient(135deg, #eff6ff, #dbeafe);
    border-left: 4px solid #3b82f6;
}
.card-blue .card-icon { background: #3b82f6; color: #fff; }
.card-blue h4, .card-blue h3 { color: #1e40af; }

.card-amber {
    background: linear-gradient(135deg, #fffbeb, #fef3c7);
    border-left: 4px solid #f59e0b;
}
.card-amber .card-icon { background: #f59e0b; color: #fff; }
.card-amber h4, .card-amber h3 { color: #92400e; }
</style>
@endsection

@section('content')

<div class="container-fluid flex-grow-1 container-p-y">

    <div class="welcome-section">
        <h4>Welcome back, {{ Auth::user()->full_name ?? 'Admin' }}!</h4>
        <p>Here's what's happening with your platform today.</p>
    </div>

    <div class="row g-4">

        <div class="col-lg-4 col-md-6">
            <div class="dashboard-card card-purple">
                <div class="card-icon"><i class="bx bx-building-house"></i></div>
                <i class="bx bx-building-house card-bg-icon"></i>
                <div class="card-text">
                    <h4>Sales Person V/s Property</h4>
                    <h3>10</h3>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6">
            <div class="dashboard-card card-green">
                <div class="card-icon"><i class="bx bx-group"></i></div>
                <i class="bx bx-group card-bg-icon"></i>
                <div class="card-text">
                    <h4>Sales Person V/s Customers</h4>
                    <h3>10</h3>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6">
            <div class="dashboard-card card-amber">
                <div class="card-icon"><i class="bx bx-trending-up"></i></div>
                <i class="bx bx-trending-up card-bg-icon"></i>
                <div class="card-text">
                    <h4>Property V/s Customers</h4>
                    <h3>10</h3>
                </div>
            </div>
        </div>

    </div>

</div>

@endsection

@section('script')
@endsection