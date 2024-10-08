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

                        <!-- Inbox Link for Admins Only -->
                        <li class="nav-item">
                            <a class="nav-link arrow-none" href="{{ route('admin.inbox') }}" id="topnav-inbox" role="button">
                                <i class="ri-mail-line me-1"></i> Inbox
                            </a>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-courses" role="button" data-bs-toggle="dropdown">
                                <i class="ri-pencil-ruler-2-line me-1"></i> Course <div class="arrow-down"></div>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="topnav-courses" data-bs-popper="none">
                                <a href="{{ route('courses.bachelors') }}" class="dropdown-item">
                                    <i class="ri-calendar-2-line align-middle me-1"></i> HND Courses
                                </a>
                                <a href="{{ route('courses.diploma') }}" class="dropdown-item">
                                    <i class="ri-message-2-line align-middle me-1"></i> ND Courses
                                </a>
                            </div>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-apps" role="button" data-bs-toggle="dropdown">
                                <i class="ri-stack-line me-1"></i> Institutes <div class="arrow-down"></div>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="topnav-apps" data-bs-popper="none">
                                <a href="{{ route('institutes.bachelors') }}" class="dropdown-item">
                                    <i class="ri-calendar-2-line align-middle me-1"></i> HND Institutes
                                </a>
                                <a href="{{ route('institutes.diploma') }}" class="dropdown-item">
                                    <i class="ri-message-2-line align-middle me-1"></i> ND Institutes
                                </a>
                            </div>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-mapping" role="button" data-bs-toggle="dropdown">
                                <i class="ri-layout-line me-1"></i> Mapping <div class="arrow-down"></div>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="topnav-mapping" data-bs-popper="none">
                                <a href="{{ route('mapping.bachelors') }}" class="dropdown-item">
                                    <i class="ri-calendar-2-line align-middle me-1"></i> HND Institute Course Mapping
                                </a>
                                <a href="{{ route('mapping.diploma') }}" class="dropdown-item">
                                    <i class="ri-message-2-line align-middle me-1"></i> Institute ND Mapping
                                </a>
                                <a href="{{ route('mapping.diploma.bachelors') }}" class="dropdown-item">
                                    <i class="ri-message-2-line align-middle me-1"></i> HND/ND Eligibility Mapping
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
                                    <i class="ri-message-2-line align-middle me-1"></i> Institute Managers
                                </a>
                                <a href="{{ route('users.admins') }}" class="dropdown-item">
                                    <i class="ri-message-2-line align-middle me-1"></i> Admins
                                </a>
                            </div>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link arrow-none" href="{{ route('applications.admin.payments') }}" id="topnav-payments" role="button">
                                <i class="ri-calendar-2-line align-middle me-1"></i> Form fees
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
                                <a class="nav-link arrow-none" href="{{ route('applications.manager.payments') }}" id="topnav-payments" role="button">
                                    <i class="ri-calendar-2-line align-middle me-1"></i> Form fees
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

                    @hasrole('student|manager|other_roles_except_admin')
                        <li class="nav-item">
                            <a class="nav-link arrow-none" href="{{ route('messages.chat') }}" id="topnav-contact-admin" role="button">
                                <i class="ri-mail-line me-1"></i> Contact Admin
                            </a>
                        </li>
                    @endhasrole

                    @hasrole('student')
                        <li class="nav-item dropdown">
                            <a class="nav-link arrow-none" href="{{ route('applications.student.payments') }}" id="topnav-payments" role="button">
                                <i class="ri-calendar-2-line align-middle me-1"></i> Form Fees
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

