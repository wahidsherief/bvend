<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>bvend</title>
    <!-- Font Awesome Icons -->
    <link href="{{asset('vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('css/toastr..css')}}" rel="stylesheet" type="text/css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Merriweather+Sans:400,700" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic' rel='stylesheet' type='text/css'>
    <!-- Plugin CSS -->
    <link href="{{asset('vendor/magnific-popup/magnific-popup.css')}}" rel="stylesheet">
    <!-- Theme CSS - Includes Bootstrap -->
    <link href="{{asset('css/creative.min.css')}}" rel="stylesheet">
    <style type="text/css">
        .bvend_color {
            color: #007E33;
        }

        header.masthead {
            background: url('img/bvend_bg.jpg') no-repeat;
            background-size: cover;
        }

        .findoutbutton,
        .about {
            background-color: #999 !important;
        }

        .about {
            background-color: #007E33 !important;
        }

        #mainNav .navbar-nav .nav-item .nav-link {
            color: #007E33;
        }

        #mainNav.navbar-scrolled .navbar-nav .nav-item .nav-link.active {
            color: #007E33 !important;
        }

        .nav-link:hover {
            color: #007E33 !important;
        }

        .bg-bvend {}

        .divider {
            border-color: #007E33 !important;
        }

        .d-block {
            color: #000;
        }
    </style>
</head>

<body id="page-top">
    <!-- Navigation -->
    <!-- <div class="links" style="margin-top: 50px">
            <a href="admin/login">Admin</a>
            <a href="manager/login">Manager</a>
            <a href="vendor/login">Vendor</a>
            <a href="user/send">User</a>
        </div>
 -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top py-3 navbar-toggleable-md" id="mainNav">
        <div class="container">
            <!-- <a class="navbar-brand js-scroll-trigger" href="#page-top">Start Bootstrap</a> -->
            <a class="navbar-brand js-scroll-trigger" href="#page-top">
                <img style="width: 30%; height: 12%" class="img-fluid" src="{{asset('img/bvend_web_logo.png')}}" alt="">
            </a>
            <button class="navbar-toggler mt-2" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse  justify-content-end" id="navbarResponsive">
                <ul class="navbar-nav ml-auto my-2 my-lg-0">
                    <li class="nav-item">
                        <a class="nav-link js-scroll-trigger" href="#about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link js-scroll-trigger" href="#services">Bvend</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link js-scroll-trigger" href="#portfolio">Gallery</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link js-scroll-trigger" href="#contact">Contact</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <center>

        <div class="login" style="margin-top: 250px;">
            <div class="card" style="width: 40rem;height:65rem;">
                <img src="{{asset('img/bvend_web_logo.png')}}" class="card-img-top" alt="...">
                <div class="card-body">
                    <h3 class="card-title"> Smart Vending Solution</h3>
                    @include('partials.alert')
                    <!-- form starts here-->
                    <form action="{{ route('request.save') }}" method="POST" id="regForm">
                        {{ csrf_field() }}
                        <div class="form-group col-md-15">
                            <input type="text" class="form-control" name='name' placeholder="Name">

                        </div>
                        <div class="form-group col-md-15">
                            <input type="email" class="form-control" id="validationServer01" name='email' placeholder="email">

                        </div>

                        <div class="form-group col-md-15">
                            <input type="text" class="form-control" id="validationServer01" name='business_name' placeholder="company name">

                        </div>

                        <div class="form-group col-md-15">
                            <input type="text" class="form-control" id="validationServer01" name='business_phone' placeholder="phone number">

                        </div>
                        <div class="form-group">
                            <input type="text" style="height:100px" class="form-control" id="validationServer01" name='address' placeholder="address">

                        </div>

                        <div class="form-group">
                            <input type="text" style="height:200px" class="form-control" id="validationServer01" name='message' placeholder="message">

                        </div>

                        <div class="form-group">
                            <!-- you cant use input type submit if you use jquery -->
                            <input type="submit" id="register" name="send" value="Send Request" class="btn btn-primary btn-lg btn-block">

                        </div>
                    </form>

                    <!--  form ends here -->
                </div>
            </div>
        </div>
    </center>






    <!-- Footer -->
    <footer class="py-5">
        <div class="container">
            <div class="small text-center">Copyright &copy; 2019 - Bvend Technologies Ltd.</div>
        </div>
    </footer>
    <!-- Bootstrap core JavaScript -->
    <script src="{{asset('vendor/jquery/jquery.min.js')}}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>

    <script src="{{asset('vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <!-- Plugin JavaScript -->
    <script src="{{asset('vendor/jquery-easing/jquery.easing.min.js')}}"></script>
    <script src="{{asset('vendor/magnific-popup/jquery.magnific-popup.min.js')}}"></script>
    <script src="{{asset('vendor/toastr/toastr.min.js')}}"></script>
    <!-- Custom scripts for this template -->
    <script src="{{asset('js/creative.min.js')}}"></script>

</body>

</html>