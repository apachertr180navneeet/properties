@section('style')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .form-card {
        border-radius: 16px;
        border: 1px solid rgba(105, 108, 255, 0.1);
        box-shadow: 0 6px 24px rgba(0, 0, 0, 0.06);
        background: #fff;
        overflow: hidden;
    }
    .form-card-header {
        padding: 1.25rem 2rem;
        border-bottom: 1px solid #f0f2f9;
        background: linear-gradient(to right, #fafbff, #fff);
    }
    .form-card-title {
        color: #3b71ca !important;
        font-size: 1.15rem;
        font-weight: 700;
        margin: 0;
        text-transform: uppercase;
        letter-spacing: .5px;
    }
    .form-card-body {
        padding: 2rem 2.25rem;
    }
    .form-label-premium {
        font-weight: 600 !important;
        color: #435971 !important;
        font-size: .85rem !important;
        margin-bottom: .35rem !important;
    }
    .premium-input,
    .premium-select {
        border-radius: 8px !important;
        border: 1.5px solid #e4e6fc !important;
        padding: 0.55rem .9rem !important;
        font-size: .88rem !important;
        background-color: #fcfdfd !important;
        transition: all .2s ease !important;
    }
    .premium-select {
        padding-right: 2rem !important;
    }
    .premium-input:focus,
    .premium-select:focus {
        border-color: #696cff !important;
        background-color: #fff !important;
        box-shadow: 0 0 0 .2rem rgba(105,108,255,.12) !important;
    }
    .btn-premium {
        background-color: #3b71ca !important;
        color: #fff !important;
        border: none !important;
        padding: .6rem 1.8rem !important;
        border-radius: 8px !important;
        font-weight: 600 !important;
        font-size: .9rem !important;
        transition: all .2s ease;
    }
    .btn-premium:hover {
        background-color: #2b559b !important;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(59,113,202,.25);
    }
    .error-text {
        font-size: .78rem;
        color: #dc3545;
        margin-top: .25rem;
        display: block;
    }
    .premium-input.is-invalid, .premium-select.is-invalid {
        border-color: #dc3545 !important;
    }
    @media (max-width: 767.98px) {
        .form-card-body { padding: 1rem 1.25rem; }
        .form-card-header { padding: 1rem 1.25rem; }
    }
</style>
@endsection