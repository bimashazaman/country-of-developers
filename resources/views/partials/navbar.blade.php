     {{-- if a user is logged in, show the it  --}}
     @auth
         <nav class="navbar navbar-expand-md shadow-sm position-fixed top-0 w-100 pt-4"
             style="background: linear-gradient(180deg, #00518C 0%, #102854 100%); color: #fff; z-index: 2000; height: 70px;
                ">
             <div class="container-fluid">
                 <a class="navbar-brand" href="{{ url('/') }}">
                     <img src="{{ asset('logo/pokersocial.png') }}" class="d-inline-block align-top"
                         style=" height: 45px; margin-top: -15px;" alt="">
                 </a>
                 <div class="collapse navbar-collapse" id="navbarSupportedContent">
                     <!-- Left Side Of Navbar -->
                     <ul class="navbar-nav me-auto">
                     </ul>

                     <ul class="navbar-nav me-auto text-center align-content-center justify-content-center w-100">
                         <li class="nav-item px-5">
                             <a href="{{ route('posts.all') }}" class=" text-decoration-none row mt-2">
                                 <center> <i style=" color: #fff; font-size: 20px; cursor: pointer; margin-top: 10px;"
                                         class="fas fa-home"></i>
                                     <p style=" color: #fff; font-size: 18px; cursor: pointer">
                                         Home </p>
                                 </center>
                             </a>
                         </li>

                         <li class="nav-item px-5">
                             <a class="nav-link" href={{ route('friends') }} class=" text-decoration-none">
                                 <center> <i style=" color: #fff; font-size: 20px; cursor: pointer; margin-top: 10px;"
                                         class="fas fa-user-friends"></i>
                                     <p style=" color: #fff; font-size: 18px; cursor: pointer">
                                         Friends
                                     </p>
                                 </center>
                             </a>
                         </li>
                         {{-- Profile avatar  --}}
                         <li class="nav-item px-5">
                             <a href="{{ route('profile.index', Auth::user()->id) }}"
                                 class=" text-decoration-none row mt-2">
                                 <center> <img
                                         src=@if (Auth::user()->avatar) {{ asset('avatars/' . Auth::user()->avatar) }}
                                    @else "https://ui-avatars.com/api/?name={{ Auth::user()->name }}&&background=0D8ABC&color=fff" @endif
                                         style="width: 35px; height: 35px; border-radius: 50%; border: 2px solid #fff; cursor: pointer; margin-top: 3px;">
                                     <p style=" color: #fff; font-size: 18px; cursor: pointer">
                                         Profile </p>
                                 </center>
                             </a>
                         </li>
                         <li class="nav-item px-5">
                             <a class="nav-link" href={{ route('notifications.index') }}
                                 class=" text-decoration-none row mt-2">
                                 <center><i style=" color: #fff; font-size: 20px; cursor: pointer; margin-top: 10px;"
                                         class="fas fa-bell"></i>
                                     <p style=" color: #fff; font-size: 18px; cursor: pointer">
                                         Notifications
                                     </p>
                                 </center>
                             </a>
                         </li>
                         <li class="nav-item px-5">
                             <a class="nav-link" href={{ url('chatify') }} class=" text-decoration-none row mt-2">
                                 <center> <i style=" color: #fff; font-size: 20px; cursor: pointer; margin-top: 10px;"
                                         class="fas fa-envelope"></i>
                                     <p style=" color: #fff; font-size: 18px; cursor: pointer">
                                         Messages
                                     </p>
                                 </center>
                             </a>
                         </li>

                     </ul>

                     <!-- Right Side Of Navbar -->
                     <ul class="navbar-nav ms-auto">
                         <!-- Authentication Links -->
                         @guest
                             @if (Route::has('login'))
                                 <li class="nav-item">
                                     <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                 </li>
                             @endif

                             @if (Route::has('register'))
                                 <li class="nav-item">
                                     <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                 </li>
                             @endif
                         @else
                             <form action="{{ route('search-friends') }}" method="GET" class="d-flex">
                                 <input type="text" class="form-control" placeholder="Search"
                                     style="width: 220px; background-color: #0E121C; color: #fff; border: none; border-radius: 20px; height: 40px;"
                                     name="search">
                                 <i class="fas fa-search" hidden
                                     style="color: #fff; font-size: 20px; margin-left: 10px; cursor: pointer; margin-top:10px"></i>
                                 <button type="submit" style="display: none;"></button>
                             </form>


                             <li class="nav-item dropdown">
                                 <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                     data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre
                                     style="color: #fff; font-size: 16px; background-color: #0E121C; border-radius: 40px; height: 37px; width: 37px;  margin-left: 10px; text-align: center; cursor: pointer;">
                                 </a>

                                 <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown"
                                     style="background-color: #0E121C; border: none; margin-left: -130px; margin-top: 10px; border-radius: 10px; border : 2px solid #0B8ABB; box-shadow: 0px 0px 10px 0px #0B8ABB;">
                                     <div>
                                         <a class="dropdown-item" href="{{ route('settings.index', Auth::user()->id) }}"
                                             style="color: #fff; font-size: 16px; background-color: #0E121C; border-radius: 40px; height: 37px; width: 37px;  margin-left: 10px; text-align: center; cursor: pointer;">
                                             Settings <i class="fas fa-cog"></i>
                                         </a>

                                     </div>
                                     <div>
                                         <a class="dropdown-item" href="{{ route('logout') }}"
                                             onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();"
                                             style="color: #fff; font-size: 16px; background-color: #0E121C; border-radius: 40px; height: 37px; width: 37px;  margin-left: 10px; text-align: center; cursor: pointer;">
                                             {{ __('Logout') }} <i class="fas fa-sign-out-alt"></i>
                                         </a>

                                         <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                             @csrf
                                         </form>
                                     </div>

                                     {{-- settings --}}

                                 </div>
                             </li>
                         @endguest
                     </ul>
                 </div>
             </div>
         </nav>

     @endauth
