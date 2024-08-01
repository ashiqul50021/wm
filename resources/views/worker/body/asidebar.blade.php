<aside class="col-lg-3 border-end">
    <nav class="nav nav-pills flex-lg-column mb-4">
        <a class="nav-link {{ (Route::current()->getName() == 'worker.profile')? 'active':'' }}" aria-current="page" href="{{ route('worker.profile') }}">General</a>
        <a class="nav-link {{ (Route::current()->getName() == 'worker.edit.profile')? 'active':'' }}" href="{{ route('worker.edit.profile') }}">Edit Profile</a>
        <a class="nav-link {{ (Route::current()->getName() == ' worker.change.password')? 'active':'' }}" href="{{ route('worker.change.password') }}">Change Password</a>
    </nav>
</aside>
