 <header class="main-header navbar">
    <div class="col-search">
        <a class="nav-link d-inline-block" target="_blank" href="{{ route('home') }}"><i class="fas fa-globe me-2"></i>Visit Site</a>

        <a class="btn btn-sm btn-danger nav-link d-inline-block" href="{{ route('worker.cache.clear')}}"><i class="fa-solid fa-shower me-2"></i>Clear Cache</a>
        </a>


    </div>
    <div class="col-nav">
        <button class="btn btn-icon btn-mobile me-auto" data-trigger="#offcanvas_aside"><i class="material-icons md-apps"></i></button>
        <ul class="nav">
           <!--  <li class="nav-item">
                <a class="nav-link btn-icon" href="#">
                    <i class="material-icons md-notifications animation-shake"></i>
                    <span class="badge rounded-pill">3</span>
                </a>
            </li> -->
            <li class="nav-item">
                <a class="nav-link btn-icon darkmode" href="#"> <i class="material-icons md-nights_stay"></i> </a>
            </li>
            <?php
                use App\Models\User;
                $id = Auth::guard('worker')->user()->id;
                $workerData = User::find($id);
                // @dd($workerData->profile_image)
            ?>

            <li class="dropdown nav-item">
                <a class="dropdown-toggle" data-bs-toggle="dropdown" href="#" id="dropdownAccount" aria-expanded="false"> <img class="img-xs rounded-circle" src="{{ (!empty($workerData->profile_image))? url($workerData->profile_image):url('upload/no_image.jpg') }}" alt="User Avatar"></a>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownAccount">
                    <a class="dropdown-item" href="{{ route('worker.profile') }}"><i class="material-icons md-perm_identity"></i>My Profile</a>
                    <a class="dropdown-item" href="#"><i class="material-icons md-settings"></i>Account Settings</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item text-danger" href="{{ route('worker.logout') }}"><i class="material-icons md-exit_to_app"></i>Logout</a>
                </div>
            </li>
        </ul>
    </div>
</header>
