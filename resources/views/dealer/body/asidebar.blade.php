<aside class="col-lg-3 border-end">
    <nav class="nav nav-pills flex-lg-column mb-4">
        <a class="nav-link {{ (Route::current()->getName() == 'dealer.profile')? 'active':'' }}" aria-current="page" href="{{ route('dealer.profile') }}">General</a>
        <a class="nav-link {{ (Route::current()->getName() == 'dealer.edit.profile')? 'active':'' }}" href="{{ route('dealer.edit.profile') }}">Edit Profile</a>
        <a class="nav-link {{ (Route::current()->getName() == ' dealer.change.password')? 'active':'' }}" href="{{ route('dealer.change.password') }}">Change Password</a>
    </nav>
</aside>