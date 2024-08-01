<aside class="col-lg-3 border-end">
    <nav class="nav nav-pills flex-lg-column mb-4">
        <a class="nav-link {{ (Route::current()->getName() == 'seller.profile')? 'active':'' }}" aria-current="page" href="{{ route('seller.profile') }}">General</a>
        <a class="nav-link {{ (Route::current()->getName() == 'seller.edit.profile')? 'active':'' }}" href="{{ route('seller.edit.profile') }}">Edit Profile</a>
        <a class="nav-link {{ (Route::current()->getName() == ' seller.change.password')? 'active':'' }}" href="{{ route('seller.change.password') }}">Change Password</a>
    </nav>
</aside>
