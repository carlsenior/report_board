<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component
{
    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();
        $this->redirect('/', navigate: true);
    }
}; ?>
    <!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item d-flex">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <!-- Right navbar links -->

    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <div class="d-flex">
                <div class="user-panel" style="overflow: visible;">
                    <img src="{{ Auth::user()->gravatar }}" class="img-circle elevation-2" alt="User Image">
                </div>
            </div>
        </li>
        <li class="nav-item dropdown">

            <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
                {{ Auth::user()->name }}
            </a>
            <div class="dropdown-menu dropdown-menu-right" style="left: inherit; right: 0px;">
                <a href="{{ route('profile') }}" class="dropdown-item"
                   wire:navigate>
                    <i class="mr-2 fas fa-file"></i>
                    {{ __('My profile') }}
                </a>
                <div class="dropdown-divider"></div>
                <button class="dropdown-item"
                   wire:click="logout">
                    <i class="mr-2 fas fa-sign-out-alt"></i>
                    {{ __('Log Out') }}
                </button>
            </div>
        </li>
    </ul>
</nav>
<!-- /.navbar -->



