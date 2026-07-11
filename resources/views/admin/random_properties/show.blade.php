@extends('admin.layouts.app')

@section('title', 'Show Random Property')

@section('style')
<style>
    .filter-card {
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        border: none;
        background: #ffffff;
        margin-bottom: 2rem;
    }
    .table-responsive {
        border-radius: 12px;
        overflow: hidden;
    }
    .table-premium {
        margin-bottom: 0 !important;
    }
    .table-premium th {
        background-color: #f5f6ff !important;
        color: #566a7f !important;
        font-weight: 600 !important;
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 0.5px;
        padding: 1rem 1.25rem !important;
        border-bottom: 1px solid #e4e6fc !important;
    }
    .table-premium td {
        padding: 1.1rem 1.25rem !important;
        vertical-align: middle !important;
        border-bottom: 1px solid #f0f2f9 !important;
    }
    .table-premium tbody tr {
        transition: background-color 0.2s ease;
    }
    .table-premium tbody tr:hover {
        background-color: #f9faff !important;
    }
</style>
@endsection

@section('content')
<div class="container-fluid flex-grow-1 container-p-y">
    <div class="d-flex align-items-center justify-content-between py-3 mb-3">
        <h4 class="fw-bold mb-0">
            <span class="text-muted fw-light">Management / Random Property /</span> Show
        </h4>
        <a href="{{ route('admin.random_properties.index') }}" class="btn btn-outline-secondary">
            <i class="bx bx-arrow-back"></i> Back
        </a>
    </div>

    <div class="card filter-card mb-4 p-4">
        <h5 class="mb-0">Customer: <strong>{{ $selectedCustomer->name }}</strong></h5>
    </div>

    <div class="card border-0 shadow-sm mb-5" style="border-radius: 12px; overflow: hidden;">
        <div class="table-responsive">
            <table class="table table-premium align-middle">
                <thead>
                    <tr>
                        <th style="width: 80px;">S.No.</th>
                        <th>Date</th>
                        <th>Property Name</th>
                        <th>Remark</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($randomProperties as $index => $prop)
                        <tr>
                            <td>
                                <span class="text-muted fw-medium">{{ $index + 1 }}</span>
                            </td>
                            <td>
                                <span class="fw-semibold text-dark">{{ $prop->date ? $prop->date->format('d/m/Y') : '-' }}</span>
                            </td>
                            <td>
                                <span class="fw-semibold text-dark">{{ $prop->property_name }}</span>
                            </td>
                            <td>
                                <span class="text-muted">{{ $prop->remark ?? '-' }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">
                                <i class="bx bx-info-circle fs-3 mb-2 d-block text-secondary"></i>
                                No properties found for this customer.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
