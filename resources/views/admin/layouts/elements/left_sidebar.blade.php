<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
	<div class="app-brand demo">
		<a href="{{route('admin.dashboard')}}" class="app-brand-link">
			<span class="app-brand-text demo menu-text fw-bold" style="font-size: 1.125rem;">{{ config('app.name') }}</span>
		</a>

		<a href="javascript:void(0);"
			class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
			<i class="bx bx-chevron-left bx-sm align-middle"></i>
		</a>
	</div>

	<div class="menu-inner-shadow"></div>

	<ul class="menu-inner py-1">
		<li class="menu-item {{ request()->is('admin/dashboard') ? 'active' : ''}}">
			<a href="{{route('admin.dashboard')}}" class="menu-link">
				<i class="menu-icon tf-icons bx bx-home-circle"></i>
				<div data-i18n="Dashboard">Dashboard</div>
			</a>
		</li>
		<li class="menu-item {{ request()->is('admin/salespersons*') ? 'active' : ''}}">
			<a href="{{route('admin.salespersons.index')}}" class="menu-link">
				<i class="menu-icon tf-icons bx bx-group"></i>
				<div data-i18n="Sales Persons">Sales Persons</div>
			</a>
		</li>
		<li class="menu-item {{ request()->is('admin/areamaster*') ? 'active' : ''}}">
			<a href="{{route('admin.areamaster.index')}}" class="menu-link">
				<i class="menu-icon tf-icons bx bx-map"></i>
				<div data-i18n="Area Master">Area Master</div>
			</a>
		</li>
		<li class="menu-item {{ request()->is('admin/properties*') ? 'active' : ''}}">
			<a href="{{route('admin.properties.index')}}" class="menu-link">
				<i class="menu-icon tf-icons bx bx-buildings"></i>
				<div data-i18n="Properties">Properties</div>
			</a>
		</li>
		<li class="menu-item {{ request()->is('admin/customers*') ? 'active' : ''}}">
			<a href="{{route('admin.customers.index')}}" class="menu-link">
				<i class="menu-icon tf-icons bx bx-user"></i>
				<div data-i18n="Customers">Customers</div>
			</a>
		</li>
		<li class="menu-item {{ request()->is('admin/message-templates*') ? 'active' : ''}}">
			<a href="{{route('admin.message-templates.index')}}" class="menu-link">
				<i class="menu-icon tf-icons bx bx-message-detail"></i>
				<div data-i18n="Message Templates">Message Templates</div>
			</a>
		</li>
	</ul>
</aside>
