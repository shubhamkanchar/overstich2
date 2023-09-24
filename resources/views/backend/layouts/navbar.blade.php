<div class="container-fluid border align-middle">
  <div class="row">
    <div class="col-2">
      <button class="btn " type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
        <i class="bi bi-layout-text-sidebar fs-4"></i>
      </button>
    </div>
    <div class="col-10 text-end">
      <div class="dropdown me-5 mt-2">
        <button class=" dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown">
          {{ ucwords(Auth::user()->name) }}
        </button>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
          <li class="dropdown-item">
            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();">
              {{ __('Logout') }}
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
              @csrf
            </form>
          </li>
        </ul>
      </div>
    </div>
  </div>
</div>