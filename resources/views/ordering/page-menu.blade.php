<header>
    <nav class="navbar navbar-expand-lg navbar-scroll navbar-scrolled gray-black shadow-0 h-topbar">
        <div class="container-fluid ps-0">

            <a class="navbar-brand nav-link goto" id="pagehome" href="#page_1">
                <h4 class="text-white-50 my-0 fs-2x me-2">{{$comp->logotxt}}</h4>
            </a>
            <!-- navbar right -->
            <ul class="navbar-nav ms-auto d-flex flex-row">
                <li class="nav-item">
                    @include('ordering.partials.toprightbar')
                </li>
            </ul>

        </div>
    </nav>
</header>
@include('ordering.partials.orderlay')
