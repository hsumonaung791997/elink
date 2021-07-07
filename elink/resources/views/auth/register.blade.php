<!DOCTYPE html>
<html lang="en">
  <head>
    <title>eLink</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Nanum+Gothic:400,700,800" rel="stylesheet">
    <link href="{{asset('plugins/font-awesome-4.7.0/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{asset('fonts/icomoon/style.css')}}">

    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/magnific-popup.css')}}">
    <link rel="stylesheet" href="{{asset('css/jquery-ui.css')}}">
    <link rel="stylesheet" href="{{asset('css/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/owl.theme.default.min.css')}}">

    <link rel="stylesheet" href="{{asset('css/bootstrap-datepicker.css')}}">

    <link rel="stylesheet" href="{{asset('fonts/flaticon/font/flaticon.css')}}">

    <link rel="stylesheet" href="{{asset('css/aos.css')}}">
    <link rel="stylesheet" href="{{asset('css/rangeslider.css')}}">

    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    
  </head>
  <body class="bg-light">
  
  <div class="site-wrap">

    <div class="site-mobile-menu">
      <div class="site-mobile-menu-header">
        <div class="site-mobile-menu-close mt-3">
          <span class="icon-close2 js-menu-toggle"></span>
        </div>
      </div>
      <div class="site-mobile-menu-body"></div>
    </div>
    
    <header class="site-navbar container py-0 bg-white" role="banner">

      <!-- <div class="container"> -->
        <div class="row align-items-center">
          
          <div class="col-6 col-xl-2">
            <h1 class="mb-0 site-logo"><a href="index.html" class="text-black mb-0">e<span class="text-primary">Link</span>  </a></h1>
          </div>
          <div class="col-12 col-md-10 d-none d-xl-block">
            <nav class="site-navigation position-relative text-right" role="navigation">

              <ul class="site-menu js-clone-nav mr-auto d-none d-lg-block font-weight-bold">
                <li><a href="/">Home</a></li>
                <li class="has-children">
                  <a href="javascript:void(0);">Category</a>
                  <ul class="dropdown" style="overflow-y: scroll; max-height: 200px;">
                    @foreach($categories as $category)
                      <form action="{{route('getitems')}}" method="post">
    									@csrf
    									@method('GET')
    									<input type="hidden" name="id" value="{{$category->id}}">
    									<li><button type="submit" class="dropdown-item">{{$category->name}}</button></li>
    				  				</form>
                    @endforeach
                  </ul>
                </li>
                <li><a href="{{route('about')}}">About</a></li>
                <li><a href="{{route('contact')}}">Contact</a></li>

                @guest
                  <li class="ml-xl-3 "><a href="{{route('login')}}"><span class="border-left pl-xl-4"></span>Login</a></li>
                  @if (Route::has('register'))
                  <li class="ml-xl-3 active"><a href="{{route('register')}}"><span class="border-left pl-xl-4"></span>Register</a></li>
                  @endif
                @else

                
                <li class="has-children">
                  <a href="javascript:void(0);"><img src="{{asset(Auth::user()->avatar)}}" class="rounded-circle" width="30" height="30"></a>
                  <ul class="dropdown" style="overflow-y: scroll; max-height: 200px;">
                    @if(Auth::check() && Auth::user()->role == 'admin')
                      <li><a href="{{'/category'}}">Add Category</a></li>
                      <li><a href="{{'/balance'}}">Add Balance</a></li>
                    @endif
                    <li><a href="{{'/favouritelist'}}">Saved Items</a></li>
                    <li><a href="{{'/postlist'}}">Listed Items</a></li>
                    <li><a href="{{'/orderlist'}}">Order Details</a></li>
                    <li><a href="{{route('profile.edit',Auth::user()->id)}}">Profile</a></li>
                    <li><a href="{{route('logout')}}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">logout</a></li>
                    <form id="logout-form" method="post" action="{{route('logout')}}" style="display: none;">
                      @csrf
                    </form>
                  </ul>
                </li>
                @endguest

                <li><a href="{{route('item.create')}}" class="cta"><span class="bg-primary font-weight-bold text-white rounded">+ Sell</span></a></li>
              </ul>
            </nav>
          </div>


          <div class="d-inline-block d-xl-none ml-auto py-3 col-6 text-right" style="position: relative; top: 3px;">
            <a href="javascript:void(0);" class="site-menu-toggle js-menu-toggle text-black"><span class="icon-menu h3"></span></a>
          </div>

        </div>
      <!-- </div> -->
      
    </header>
    
    <div class="site-blocks-cover inner-page-cover overlay" style="background-image: url('{{asset('images/cover4.jpg')}}');" data-aos="fade" data-stellar-background-ratio="0.5">
      <div class="container">
        <div class="row align-items-center justify-content-center text-center">

          <div class="col-md-10" data-aos="fade-up" data-aos-delay="400">
            
            
            <div class="row justify-content-center mt-5">
              <div class="col-md-8 text-center">
                <h1>Please Register Here!</h1>
              </div>
            </div>

            
          </div>
        </div>
      </div>
    </div>


    <div class="site-section bg-light">
          <div class="container" >
            <div class="row justify-content-center">
              <div class="col-md-7 mb-3 mt-3"  data-aos="fade">

                <form action="{{route('register')}}" method="post" class="p-5 bg-white" style="border:1px solid black;border-radius: 20px;">
                    @csrf
                  <div class="row form-group">
                    <div class="col-md-12">
                      <label class="text-black font-weight-bold" for="name">Name</label> 
                      <input type="text" placeholder="Enter Name" id="name" name="name" class="form-control @error('name') is-invalid @enderror" style="border-radius: 7px;"  value="{{old('name')}}">
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                  </div>
                 
                  <div class="row form-group">
                    <div class="col-md-12">
                      <label class="text-black font-weight-bold" for="email">Email</label> 
                      <input type="email" placeholder="Enter Email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" style="border-radius: 7px;" value="{{old('email')}}">
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                  </div>

                  <div class="row form-group">
                    <div class="col-md-12">
                      <label class="text-black font-weight-bold" for="email">Phone</label> 
                      <input type="text" placeholder="Enter Phone" id="phone" name="phone" class="form-control @error('phone') is-invalid @enderror" style="border-radius: 7px;" value="{{old('phone')}}">
                        @error('phone')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                  </div>

                  <div class="row form-group">
                    <div class="col-md-12">
                      <label class="text-black font-weight-bold" for="subject">Password</label> 
                      <input type="password" placeholder="Enter Password" id="subject" name="password" class="form-control @error('password') is-invalid @enderror" style="border-radius: 7px;" value="{{old('password')}}">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                  </div>

                  <div class="row form-group">
                    <div class="col-md-12">
                      <label class="text-black font-weight-bold" for="subject">Re-type Password</label> 
                      <input type="password" placeholder="Enter Re-type Password" id="subject" name="password_confirmation" class="form-control" style="border-radius: 7px;">
                    </div>
                  </div>

                  <div class="row form-group">
                    <div class="col-12 text-center">
                      <p class="font-weight-bold">Have an account? <a href="{{route('login')}}">Log In</a></p>
                    </div>
                  </div>

                  <div class="row form-group">
                    <div class="col-md-12 text-center">
                      <input type="submit" value="Sign In" class="btn btn-primary font-weight-bold py-2 px-4 text-white" style="border-radius: 7px;">
                    </div>
                  </div>

      
                </form>
              </div>
              
            </div>
          </div>
    </div>

     <footer class="site-footer">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="row">
              <div class="col-md-6">
                <h2>About eLink.com</h2>
                <p>We believe in creating a platform which caters to the needs of our local communities, supporting them in improving their livelihoods. </p>
              </div>
              
              <div class="col-md-3 ml-3">
                <h2 class="footer-heading mb-4">Follow Us</h2>
                <a href="#" class="pl-0 pr-3"><span class="icon-facebook"></span></a>
                <a href="#" class="pl-3 pr-3"><span class="icon-twitter"></span></a>
                <a href="#" class="pl-3 pr-3"><span class="icon-instagram"></span></a>
                <a href="#" class="pl-3 pr-3"><span class="icon-linkedin"></span></a>
              </div>
            </div>
          </div>
        </div>
        <div class="row text-center">
          <div class="col-md-12">
            <div class="border-top text-dark">
            <p>
            Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | Designed <i class="icon-heart" aria-hidden="true"></i> by <a href="#" target="_blank" >Young Developer</a>
            </p>
            </div>
          </div>
          
        </div>
      </div>
    </footer>
  </div>

  <script src="{{asset('js/jquery-3.2.1.min.js')}}"></script>
  <script src="{{asset('js/jquery-migrate-3.0.1.min.js')}}"></script>
  <script src="{{asset('js/jquery-ui.js')}}"></script>
  <script src="{{asset('js/popper.min.js')}}"></script>
  <script src="{{asset('js/bootstrap.min.js')}}"></script>
  <script src="{{asset('js/owl.carousel.min.js')}}"></script>
  <script src="{{asset('js/jquery.stellar.min.js')}}"></script>
  <script src="{{asset('js/jquery.countdown.min.js')}}"></script>
  <script src="{{asset('js/jquery.magnific-popup.min.js')}}"></script>
  <script src="{{asset('js/bootstrap-datepicker.min.js')}}"></script>
  <script src="{{asset('js/aos.js')}}"></script>
  <script src="{{asset('js/rangeslider.min.js')}}"></script>

  <script src="{{asset('js/main.js')}}"></script>
    
  </body>
</html>