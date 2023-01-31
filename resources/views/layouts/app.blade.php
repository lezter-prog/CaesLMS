<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title> @yield('title')</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <script src="{{ URL::asset('js/jquery.min.js'); }}"></script>

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <link href="{{ URL::asset('css/app.css'); }} " rel="stylesheet">
    <link href="{{ URL::asset('js/DataTables/datatables.min.css'); }} " rel="stylesheet">
    <link href="{{ URL::asset('js/DataTables/datatables.select.min.css'); }} " rel="stylesheet">
    <link href="{{ URL::asset('js/select2-4.0.13/dist/css/select2.min.css'); }} " rel="stylesheet">
    <link href="{{ URL::asset('js/select2/select2-bootstrap-5-theme.min.css'); }} " rel="stylesheet">

    @yield('style')


</head>
<body>
    <div id="app">
        @auth
        <nav id="sidebarMenu" class="sidebarMenu collapse d-lg-block sidebar collapse ">
            <div class="position-sticky">
                <div class="list-group list-group-flush mx-3 mt-4">
                   
                    @if ( Auth::user()->role == "R2")
                        <a href="/teacher/home" class="{{$teacherDashboard}} list-group-item list-group-item-action py-2 ripple sidebar-color" aria-current="true">
                           <span class ="me-3"><i class="fas fa-tachometer-alt fa-fw  icon-bg-color fa-2x"></i></span> 
                                <span>Teacher dashboard</span>
                                
                        </a>

                        <a href="#" class="list-group-item list-group-item-action py-2 ripple sidebar-color" aria-current="true">
                            <span class ="me-3"><i class="fa-solid fa-id-card fa-fw  icon-bg-color fa-2x"></i></span> 
                                <span>Teacher Profile</span>
                        </a>

                        <a href="/teacher/announcement" class="{{$teacherAnnouncement}} list-group-item list-group-item-action py-2 ripple sidebar-color" aria-current="true">
                            <span class ="me-3"><i class="fa-solid fa-bullhorn  fa-fw  icon-bg-color fa-2x"></i></span> 
                                <span>Announcement</span>
                        </a>
                        <a href="/teacher/lesson" class="{{$teacherLesson}} list-group-item list-group-item-action py-2 ripple sidebar-color" aria-current="true">
                            <span class ="me-3"><i class="fa-solid fa-person-chalkboard fa-fw  icon-bg-color fa-2x"></i></span> 
                                <span>Lessons</span>
                        </a>
                        <a href="/teacher/activity" class="{{$teacherActivity}} list-group-item list-group-item-action py-2 ripple sidebar-color" aria-current="true">
                            <span class ="me-3"><i class="fa-solid fa-chart-line fa-fw  icon-bg-color fa-2x"></i></span> 
                                <span>Activity</span>
                        </a>
                        <a href="/teacher/exam" class="{{$teacherExam}} list-group-item list-group-item-action py-2 ripple sidebar-color" aria-current="true">
                            <span class ="me-3"><i class="fa-solid fa-book-open fa-fw  icon-bg-color fa-2x"></i></span> 
                                <span>Exam</span>

                        <a href="/teacher/quiz" class="{{$teacherQuiz}} list-group-item list-group-item-action py-2 ripple sidebar-color" aria-current="true">
                            <span class ="me-3"><i class="fa-solid fa-lines-leaning fa-fw  icon-bg-color fa-2x"></i></span> 
                                <span>Quiz</span>
                        </a>
                        <a href="/teacher/templates" class="{{$teacherTemplates}} list-group-item list-group-item-action py-2 ripple sidebar-color" aria-current="true">
                            <span class ="me-3"><i class="fa-solid fa-cubes-stacked fa-fw icon-bg-color fa-2x"></i></span> 
                                <span>Templates</span>
                        </a>
                    @endif

                    @if ( Auth::user()->role == "R1")
                        <a href="/student/home" class="{{ $studentHome }} list-group-item list-group-item-action py-2 ripple sidebar-color" aria-current="true">
                            <h6><i class="fas fa-tachometer-alt fa-fw me-1 fa-lg icon-bg-color"></i>
                                <span>Students Dashboard</span></h6>
                            {{-- <h4><i class="{{$subj->icon}} fa-fw me-3 fa-fw fa-sm" style="background:white;padding:2px 2px;border-radius:10px;color:{{$subj->color}}"></i>
                                <span>{{$subj->subj_code}}</span></h4> --}}
                        </a>
                        <a href="#" class="list-group-item list-group-item-action py-2 ripple sidebar-color" aria-current="true">
                            <h6><i class="fa-solid fa-id-card me-1 fa-fw fa-lg icon-bg-color"></i>
                                <span>Students Profile</span></h6>
                                
                        </a>

                        <a href="#" class="list-group-item list-group-item-action py-2 ripple sidebar-color" aria-current="true">
                            <h6><i class="fa-solid fa-book-open  me-1 fa-fw fa-lg icon-bg-color"></i>
                                <span>Subjects</span></h6>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action py-2 ripple sidebar-color" aria-current="true">
                            <h6><i class="fa-solid fa-person-running me-1 fa-fw fa-lg icon-bg-color"></i>
                                <span>School Activities</span></h6>
                        </a>
                    @endif

                    @if ( Auth::user()->role == "R0")
                        

                        <a href="/admin/home" class="{{ $adminHome }} list-group-item list-group-item-action py-2 ripple sidebar-color" aria-current="true">
                            <span class ="me-3"><i class="fa-solid fa-id-card fa-fw icon-bg-color fa-2x"></i></span> 
                                <span>CAES Profile</span>
                        </a>
                        

                        <a href="/admin/teacher" class=" {{ $adminTeacher }} list-group-item list-group-item-action py-2 ripple sidebar-color" aria-current="true">
                            <span class ="me-3"><i class="fa-solid fa-user-tie fa-fw  icon-bg-color fa-2x"></i></span> 
                                <span>Teachers</span>
                        </a>
                        <a href="/admin/sections" class="{{ $adminSections }} list-group-item list-group-item-action py-2 ripple sidebar-color" aria-current="true">
                            <span class ="me-3"><i class="fa-solid fa-puzzle-piece fa-fw icon-bg-color fa-2x"></i></i></span> 
                                <span>Sections</span>
                        </a>
                        <a href="/admin/subjects" class="{{ $adminSubjects }} list-group-item list-group-item-action py-2 ripple sidebar-color" aria-current="true">
                            <span class ="me-3"><i class="fa-solid fa-swatchbook fa-fw  icon-bg-color fa-2x"></i></i></span> 
                                <span>Subjects</span>
                        </a>
                        <a href="/admin/students" class="{{ $adminStudent }} list-group-item list-group-item-action py-2 ripple sidebar-color" aria-current="true">
                            <span class ="me-3"><i class="fa-solid fa-user-group fa-fw  icon-bg-color fa-2x"></i></span> 
                                <span>Students</span>
                        </a>
                        {{-- <a href="#" class="list-group-item list-group-item-action py-2 ripple sidebar-color" aria-current="true">
                            <span class ="me-3"><i class="fa-solid fa-book-open fa-fw fa-lg icon-bg-color"></i></span> 
                                <span>Subjects / Grade</span>
                        </a> --}}
                        {{-- <a href="/admin/announcement" class="{{ $adminAnnouncement }} list-group-item list-group-item-action py-2 ripple sidebar-color" aria-current="true">
                            <span class ="me-3"><i class="fa-solid fa-bullhorn fa-fw  icon-bg-color fa-2x"></i></span> 
                                <span>Announcement</span>
                        </a> --}}
                        <a href="/admin/quarter" class="list-group-item list-group-item-action py-2 ripple sidebar-color" aria-current="true">
                            <span class ="me-3"><i class="fa-solid fa-bars-progress fa-fw  icon-bg-color fa-2x"></i></span> 
                                <span>Quarters</span>
                        </a>
                        <a href="/admin/grades" class="list-group-item list-group-item-action py-2 ripple sidebar-color" aria-current="true">
                            <span class ="me-3"><i class="fa-solid fa-clipboard-user fa-fw  icon-bg-color fa-2x"></i></span> 
                                <span>Grades</span>
                        </a>
                        <a href="/admin/icons" class="list-group-item list-group-item-action py-2 ripple sidebar-color" aria-current="true">
                            <span class ="me-3"><i class="fa-solid fa-icons  fa-fw icon-bg-color  fa-2x"></i></span> 
                                <span>Icons</span>
                        </a>
                        
                    @endif
                   
                </div> 
            </div>
        </nav>

        <nav id="main-navbar" class=" main-navbar navbar navbar-expand-lg navbar-expand-sm navbar-expand-xs navbar-dark fixed-top">
    <!-- Container wrapper -->
            <div id="particle-js" style=""></div>
            <div class="container-fluid" style="position: absolute">
            <!-- Toggle button -->
            <button
                    class="navbar-toggler"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#sidebarMenu"
                    aria-controls="sidebarMenu"
                    aria-expanded="true"
                    aria-label="Toggle navigation"
                    >
                    <i class="fa-solid fa-bars"></i>
            </button>

            <!-- Brand -->
            <a class="navbar-brand" href="#">
                <i class="fa-solid fa-globe fa-2x"></i> <span class="abre-font-size orange">C</span><span class="abre-font-size">A</span><span class="abre-font-size neon">E</span><span class="abre-font-size">S </span>
                <span class="abre-font-size orange">L</span><span class="abre-font-size">M</span><span class="abre-font-size neon">S</span>
            </a>

            <!-- Right links -->
            <ul class="navbar-nav ms-auto d-flex flex-row">
                <!-- Notification dropdown -->
               
                {{-- <li class="nav-item">{{ Auth::user() }}</li> --}}
            
                {{-- <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-bell"></i>
                        <span class="badge rounded-pill badge-notification bg-danger">1</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDarkDropdownMenuLink">
                      <li><a class="dropdown-item" href="#">Action</a></li>
                      <li><a class="dropdown-item" href="#">Another action</a></li>
                      <li><a class="dropdown-item" href="#">Something else here</a></li>
                    </ul>
                </li> --}}

                <!-- Icon dropdown -->
                <li class="nav-item dropdown">
                    
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        <img
                        src="https://mdbootstrap.com/img/Photos/Avatars/img (31).jpg"
                        class="rounded-circle"
                        height="22"
                        alt=""
                        loading="lazy"
                        /> {{ Auth::user()->name }}
                    </a>

                    <div class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="/auth/change-password">
                           Change Password
                        </a>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </li>

                
            </ul>
            </div>
            <!-- Container wrapper -->
        </nav>
        @endauth

       

        <main class ="main-content" style="padding-top:70px !important">
            
            @yield('content')
        </main>
    </div>
    @yield('script')
    <script src="{{ URL::asset('js/DataTables/datatables.min.js'); }}"></script>
    <script src="{{ URL::asset('js/DataTables/datatables.select.min.js'); }}"></script>
    <script src="{{ URL::asset('js/select2-4.0.13/dist/js/select2.min.js'); }}"></script>
    <script src="{{ URL::asset('js/particles.js'); }}"></script>
    

    <script>

        particlesJS.load('particle-js', '/json/particles-config.json', function() {
            console.log('callback - particles.js config loaded');
        });
    </script>
</body>
</html>
