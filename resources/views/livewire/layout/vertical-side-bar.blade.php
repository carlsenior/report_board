<!-- Sidebar -->
<div class="sidebar">


    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
            data-accordion="false">
            <li class="nav-item">
                <a href="{{ route('dashboard') }}" class="nav-link" wire:navigate>
                    <i class="nav-icon fas fa-th"></i>
                    <p>
                        {{ __('DashBoard') }}
                    </p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('profile') }}" class="nav-link" wire:navigate>
                    <i class="nav-icon fas fa-circle nav-icon"></i>
                    <p>
                        Profile
{{--                        <i class="fas fa-angle-left right"></i>--}}
                    </p>
                </a>
            </li>
        </ul>
    </nav>
    <!-- /.sidebar-menu -->
</div>
<!-- /.sidebar -->
