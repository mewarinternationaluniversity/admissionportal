<div class="topnav">
    <div class="container-fluid">
        <nav class="navbar navbar-light navbar-expand-lg topnav-menu">
            <div class="collapse navbar-collapse" id="topnav-menu-content">
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link arrow-none" href="{{ route('dashboard') }}" id="topnav-dashboard" role="button">
                            <i class="ri-dashboard-line me-1"></i> Home
                        </a>
                    </li>
                    
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-applications" role="button" data-bs-toggle="dropdown">
                            <i class="ri-apps-2-line me-1"></i> Applications <div class="arrow-down"></div>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="topnav-applications" data-bs-popper="none">
                            <a href="{{ route('applications.student.start') }}" class="dropdown-item">
                                <i class="ri-calendar-2-line align-middle me-1"></i> New Application
                            </a>
                            <a href="{{ route('applications.student') }}" class="dropdown-item">
                                <i class="ri-calendar-2-line align-middle me-1"></i> My Applications
                            </a>
                        </div>                        
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-courses" role="button" data-bs-toggle="dropdown">
                            <i class="ri-pencil-ruler-2-line me-1"></i> Course <div class="arrow-down"></div>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="topnav-courses" data-bs-popper="none">
                            <a href="{{ route('courses.bachelors') }}" class="dropdown-item">
                                <i class="ri-calendar-2-line align-middle me-1"></i> Bachelors
                            </a>
                            <a href="{{ route('courses.diploma') }}" class="dropdown-item">
                                <i class="ri-message-2-line align-middle me-1"></i> Diploma
                            </a>
                        </div>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-apps" role="button" data-bs-toggle="dropdown">
                            <i class="ri-stack-line me-1"></i> Institutes <div class="arrow-down"></div>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="topnav-apps" data-bs-popper="none">
                            <a href="{{ route('institutes.bachelors') }}" class="dropdown-item">
                                <i class="ri-calendar-2-line align-middle me-1"></i> Bachelors
                            </a>
                            <a href="{{ route('institutes.diploma') }}" class="dropdown-item">
                                <i class="ri-message-2-line align-middle me-1"></i> Diploma
                            </a>
                        </div>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-mapping" role="button" data-bs-toggle="dropdown">
                            <i class="ri-layout-line me-1"></i> Mapping <div class="arrow-down"></div>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="topnav-mapping" data-bs-popper="none">
                            <a href="{{ route('mapping.bachelors') }}" class="dropdown-item">
                                <i class="ri-calendar-2-line align-middle me-1"></i> Institute Bachelors Mapping
                            </a>
                            <a href="{{ route('mapping.diploma') }}" class="dropdown-item">
                                <i class="ri-message-2-line align-middle me-1"></i> Institute Diploma Mapping
                            </a>
                            <a href="{{ route('mapping.diploma.bachelors') }}" class="dropdown-item">
                                <i class="ri-message-2-line align-middle me-1"></i> Diploma/Bachelors Mapping
                            </a>
                        </div>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-users" role="button" data-bs-toggle="dropdown">
                            <i class="ri-layout-line me-1"></i> Users <div class="arrow-down"></div>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="topnav-users" data-bs-popper="none">
                            <a href="{{ route('users.students') }}" class="dropdown-item">
                                <i class="ri-calendar-2-line align-middle me-1"></i> Students
                            </a>
                            <a href="{{ route('users.managers') }}" class="dropdown-item">
                                <i class="ri-message-2-line align-middle me-1"></i> Managers
                            </a>
                            <a href="{{ route('users.admins') }}" class="dropdown-item">
                                <i class="ri-message-2-line align-middle me-1"></i> Admins
                            </a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link arrow-none" href="{{ route('applications.student.payments') }}" id="topnav-dashboard" role="button">
                            <i class="ri-layout-line me-1"></i> Payments
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>
