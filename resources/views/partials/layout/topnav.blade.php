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
                    @hasrole('admin')
                        <li class="nav-item dropdown">
                            <a class="nav-link arrow-none" href="{{ route('applications.admin') }}" id="topnav-dashboard" role="button">
                                <i class="ri-apps-2-line me-1"></i> Applications
                            </a>
                        </li>
                    @endhasrole

                    @hasrole('manager')
                        @if (Auth::user()->institute->type == 'DIPLOMA')
                            <li class="nav-item">
                                <a class="nav-link arrow-none" href="{{ route('applications.students.upload.view') }}" id="topnav-dashboard" role="button">
                                    <i class="ri-apps-2-line me-1"></i> Legacy Students upload
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link arrow-none" href="{{ route('manager.students.list') }}" id="topnav-dashboard" role="button">
                                    <i class="ri-apps-2-line me-1"></i> List students
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link arrow-none" href="{{ route('courses.diploma.institute') }}" id="topnav-dashboard" role="button">
                                    <i class="ri-apps-2-line me-1"></i> Courses
                                </a>
                            </li>
                            
                            <li class="nav-item">
                                <a class="nav-link arrow-none" href="{{ route('my.account') }}" id="topnav-dashboard" role="button">
                                    <i class="ri-apps-2-line me-1"></i> My Account
                                </a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link arrow-none" href="{{ route('applications.manager') }}" id="topnav-dashboard" role="button">
                                    <i class="ri-apps-2-line me-1"></i> Applications List
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link arrow-none" href="{{ route('applications.manager.approved') }}" id="topnav-dashboard" role="button">
                                    <i class="ri-apps-2-line me-1"></i> Approved Students List
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link arrow-none" href="{{ route('manager.institute.profile') }}" id="topnav-dashboard" role="button">
                                    <i class="ri-apps-2-line me-1"></i> Institute profile
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link arrow-none" href="{{ route('mapping.bachelors.institute') }}" id="topnav-dashboard" role="button">
                                    <i class="ri-apps-2-line me-1"></i> Mapping
                                </a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link arrow-none" href="{{ route('applications.manager.payments') }}" id="topnav-dashboard" role="button">
                                    <i class="ri-layout-line me-1"></i> Payments
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link arrow-none" href="{{ route('my.account') }}" id="topnav-dashboard" role="button">
                                    <i class="ri-apps-2-line me-1"></i> My Account
                                </a>
                            </li>
                        @endif
                    @endhasrole

                    @hasrole('student')
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
                    @endhasrole

                    @hasrole('admin')
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-courses" role="button" data-bs-toggle="dropdown">
                                <i class="ri-pencil-ruler-2-line me-1"></i> Course <div class="arrow-down"></div>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="topnav-courses" data-bs-popper="none">
                                <a href="{{ route('courses.bachelors') }}" class="dropdown-item">
                                    <i class="ri-calendar-2-line align-middle me-1"></i> Bachelors
                                </a>
                                <a href="{{ route('courses.diploma') }}" class="dropdown-item">
                                    <i class="ri-message-2-line align-middle me-1"></i> HND
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
                                    <i class="ri-message-2-line align-middle me-1"></i> HND
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
                                    <i class="ri-message-2-line align-middle me-1"></i> Institute HND Mapping
                                </a>
                                <a href="{{ route('mapping.diploma.bachelors') }}" class="dropdown-item">
                                    <i class="ri-message-2-line align-middle me-1"></i> HND/Bachelors Mapping
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
                    @endhasrole

                    @hasrole('admin')
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-payments" role="button" data-bs-toggle="dropdown">
                                <i class="ri-apps-2-line me-1"></i> Payments <div class="arrow-down"></div>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="topnav-payments" data-bs-popper="none">
                                <a href="{{ route('applications.admin.payments') }}" class="dropdown-item">
                                    <i class="ri-calendar-2-line align-middle me-1"></i> Payments
                                </a>
                                <a href="{{ route('fees.admin') }}" class="dropdown-item">
                                    <i class="ri-calendar-2-line align-middle me-1"></i> Fees
                                </a>
                            </div>
                        </li>
                    @endhasrole

                    @hasrole('student')
                        <li class="nav-item dropdown">
                            <a class="nav-link arrow-none" href="{{ route('applications.student.payments') }}" id="topnav-dashboard" role="button">
                                <i class="ri-layout-line me-1"></i> Payments
                            </a>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link arrow-none" href="{{ route('my.account') }}" id="topnav-dashboard" role="button">
                                <i class="ri-account-circle-line"></i> My Account
                            </a>
                        </li>
                    @endhasrole                    
                </ul>
            </div>
        </nav>
    </div>
</div>
