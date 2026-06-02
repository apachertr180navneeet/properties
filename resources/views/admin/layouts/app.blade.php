<!DOCTYPE html>
<html lang="en" ng-app="{{ config('app.name') }}" lang="en" class="light-style layout-menu-fixed layout-compact" dir="ltr" data-theme="theme-default"
    data-assets-path="../public/assets/" data-template="vertical-menu-template-free">
    <head>
        <meta charset="utf-8" />
        <title>{{ config('app.name') }}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
        <meta name="description" content="" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <meta name="ws_url" content="{{ env('WS_URL') }}">
        <meta name="user_id" content="{{ Auth::id() }}">
        <link rel="icon" type="image/x-icon" href="{{asset('public/assets/admin/img/favicon/favicon.ico')}}" />
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet"/>
        <link rel="stylesheet" href="{{asset('public/assets/admin/vendor/fonts/boxicons.css')}}" />
        <link rel="stylesheet" href="{{asset('public/assets/admin/vendor/css/core.css')}}" class="template-customizer-core-css" />
        <link rel="stylesheet" href="{{asset('public/assets/admin/vendor/css/theme-default.css')}}" class="template-customizer-theme-css" />
        <link rel="stylesheet" href="{{asset('public/assets/admin/css/demo.css')}}" />
        <link rel="stylesheet" href="{{asset('public/assets/admin/css/bootstrapDataTable.css')}}" />
        <link rel="stylesheet" href="{{asset('public/assets/admin/vendor/libs/perfect-scrollbar/perfect-scrollbar.css')}}" />
        <link rel="stylesheet" href="{{asset('public/assets/admin/vendor/libs/apex-charts/apex-charts.css')}}" />
        <script src="{{asset('public/assets/admin/vendor/js/helpers.js')}}"></script>
        <script src="{{asset('public/assets/admin/js/config.js')}}"></script>
        <link rel="stylesheet" href="{{asset('public/assets/admin/css/sweet-alert.css')}}" />
        @yield('style')
        <style>
            /* === Mobile Responsive Tweaks === */
            @media (max-width: 575.98px) {
                .container-p-y { padding-left: .75rem !important; padding-right: .75rem !important; }
                .welcome-section { padding: 1.25rem !important; }
                .welcome-section h4 { font-size: 1.1rem; }
                .welcome-section p { font-size: .85rem; }
            }
            @media (max-width: 767.98px) {
                .dashboard-card { min-height: 170px !important; padding: 1.25rem 1rem !important; }
                .dashboard-card h4 { font-size: 1rem; }
                .dashboard-card h3 { font-size: 1.5rem; }
                .dashboard-card .card-icon { width: 44px; height: 44px; font-size: 1.25rem; }
                .dashboard-card .card-bg-icon { font-size: 4rem !important; }
                .layout-menu-fixed .layout-page { padding-top: 56px !important; }
                .table-premium td, .table-premium th { padding: 0.6rem 0.5rem !important; font-size: 0.8rem !important; }
                .table-premium .btn-sm { padding: 0.3rem 0.5rem !important; font-size: 0.75rem !important; }
            }
            @media (max-width: 575.98px) {
                .card-body { padding: 1rem !important; }
                .app-brand-text { font-size: 1.25rem !important; }
                .table-premium td, .table-premium th { padding: 0.6rem 0.5rem !important; font-size: 0.75rem !important; }
                .table-premium .btn-sm { padding: 0.25rem 0.4rem !important; font-size: 0.7rem !important; }
                .table-premium .btn-sm i { font-size: 0.75rem !important; }
                .table-premium .premium-switch { width: 34px; height: 20px; }
                .table-premium .premium-switch-slider:before { height: 13px; width: 13px; left: 2px; bottom: 2px; }
                .table-premium .premium-switch input:checked + .premium-switch-slider:before { transform: translateX(16px); }
            }
            html { overflow-x: hidden; }
            body { overflow-x: hidden; }
            .table-responsive { -webkit-overflow-scrolling: touch; overflow-x: auto !important; }
            @media (max-width: 767.98px) {
                .table-responsive table { min-width: 750px !important; }
                .table-responsive { margin-bottom: 0; }
            }

            /* Desktop sidebar completely hidden when collapsed */
            @media (min-width: 1200px) {
                html.layout-menu-collapsed .layout-menu {
                    transform: translateX(-100%) !important;
                }
                html.layout-menu-collapsed .layout-page {
                    margin-left: 0 !important;
                }
                .layout-menu {
                    transition: transform 0.3s ease-in-out !important;
                }
                .layout-page {
                    transition: margin-left 0.3s ease-in-out !important;
                }
            }
        </style>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Toggle sidebar collapse on desktop
                document.querySelectorAll('.layout-menu-toggle').forEach(function(btn) {
                    btn.addEventListener('click', function(e) {
                        e.preventDefault();
                        document.querySelector('html').classList.toggle('layout-menu-collapsed');
                    });
                });
            });
        </script>
        
    </head>
    <body>
       <div class="layout-wrapper layout-content-navbar">
            <div class="layout-container">
                @include('admin.layouts.elements.left_sidebar')
                <div class="layout-page">
                    @include('admin.layouts.elements.header')
                    <div class="content-wrapper">
                        @yield('content')
                        @include('admin.layouts.elements.footer')
                        <div class="content-backdrop fade"></div>
                    </div>
                    @include('admin.layouts.elements.right_sidebar')
                </div>
        
                <script src="{{asset('public/assets/admin/vendor/libs/jquery/jquery.js')}}"></script>
                <script src="{{asset('public/assets/admin/vendor/libs/popper/popper.js')}}"></script>
                <script src="{{asset('public/assets/admin/vendor/js/bootstrap.js')}}"></script>
                <script src="{{asset('public/assets/admin/vendor/libs/perfect-scrollbar/perfect-scrollbar.js')}}"></script>
                <script src="{{asset('public/assets/admin/vendor/js/menu.js')}}"></script>
                <script src="{{asset('public/assets/admin/vendor/libs/apex-charts/apexcharts.js')}}"></script>
                <script src="{{asset('public/assets/admin/js/main.js')}}"></script>
                <script src="{{asset('public/assets/admin/js/dataTable.js')}}"></script>
                <script src="{{asset('public/assets/admin/js/bootstrapDataTable.js')}}"></script>
                <script src="{{asset('public/assets/admin/js/dashboards-analytics.js')}}"></script>
                <script src="{{asset('public/assets/admin/js/moment.min.js')}}"></script>
                <script async defer src="https://buttons.github.io/buttons.js"></script>
                @yield('script')
                @include('admin.layouts.elements.sweet_alerts')
            </div>
            <div class="layout-overlay layout-menu-toggle"></div>
        </div>
    </body>
</html>