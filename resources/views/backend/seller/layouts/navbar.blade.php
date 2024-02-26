<div class="container-fluid border align-middle">
    <div class="row">
        <div class="col-2">
            <button class="btn " type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample"
                aria-controls="offcanvasExample">
                <i class="bi bi-layout-text-sidebar fs-4"></i>
            </button>
        </div>
        <div class="col-10 text-end">
            <div class="dropdown me-md-3 mt-2">
                @if(auth()->user()->sellerInfo->is_approved)
                <button type="button" class="btn btn-sm btn-dark me-3" data-bs-toggle="modal"
                    data-bs-target="#exampleModal">
                    Pickup request
                </button>
                @endif
                <button class=" dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown">
                    {{ ucwords(Auth::user()->name) }}
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                    <li class="dropdown-item">
                        <a class="dropdown-item" href="{{ route('seller.account.index')}}">Account</a>
                    </li>
                    <li class="dropdown-item">
                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
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


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('seller.pickup') }}" method="post">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Raise pickup request</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body row">
                    <div class="col-6">
                      <label for="date">Pickup Date</label>
                      <input class="form-control" type="date" name="date" id="date" required>
                    </div>
                    <div class="col-6">
                      <label for="time">Pickup Time</label>
                      <input class="form-control" type="time" name="time" id="time" required>
                    </div>
                    <div class="col-12">
                      <label for="time">Package Count</label>
                      <input class="form-control" type="number" name="count" id="count" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-dark">Request</button>
                </div>
            </div>
        </form>
    </div>
</div>
