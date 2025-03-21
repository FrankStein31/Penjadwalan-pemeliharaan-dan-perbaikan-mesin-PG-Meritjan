<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- CSS -->
    {{-- <link href="{{ asset('css/styles.css') }}" rel="stylesheet"> --}}
    {{-- <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet"> --}}
    {{-- <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet"> --}}
    <script src="{{ asset('assets/js/plugin/webfont/webfont.min.js') }}"></script>
    <script>
        WebFont.load({
            google: {
                "families": ["Lato:300,400,700,900"]
            },
            custom: {
                "families": ["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands",
                    "simple-line-icons"
                ],
                urls: ['../assets/css/fonts.min.css']
            },
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/atlantis.css') }}">


    {{-- <link rel="stylesheet" href="{{ asset("assets/css/demo.css")}}"> --}}
    <!-- JS -->
    {{-- <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>

        <!-- Bootstrap CSS -->
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
        <!-- Bootstrap JS and dependencies -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Di bagian head -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <title>Penjadwalan Pemeliharaan dan Perbaikan Mesin</title>

    <!-- Custom fonts -->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <!-- Custom styles -->
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet"> --}}



    @stack('styles')
</head>

<body data-background-color="dark">
    <!-- Page Wrapper -->
    <div class ="wrapper">
        <div class="main-header">
            <!-- Header -->
            @include('layouts.header')
            @include('layouts.navbar')
        </div>

        @if (auth()->user()->level === 'Administrator')
            @include('layouts.sidebar')
        @elseif(auth()->user()->level === 'Teknisi')
            @include('layouts.sidebar-teknisi')
        @endif

        <div class="main-panel">
            <div class="container">
                <div class="page-inner">
                    @yield('contents')
                </div>
            </div>
            @include('layouts.footer')
        </div>
    </div>


    <script src="{{ asset('assets/js/core/jquery.3.2.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>

    <!-- jQuery UI -->
    <script src="{{ asset('assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js') }}"></script>

    <!-- jQuery Scrollbar -->
    <script src="{{ asset('assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>

    <!-- Moment JS -->
    {{-- <script src="{{ asset("assets/js/plugin/moment/moment.min.js") }}"></script> --}}

    <!-- Chart JS -->
    <script src="{{ asset('assets/js/plugin/chart.js/chart.min.js') }}"></script>

    <!-- jQuery Sparkline -->
    <script src="{{ asset('assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js') }}"></script>

    <!-- Chart Circle -->
    <script src="{{ asset('assets/js/plugin/chart-circle/circles.min.js') }}"></script>

    <!-- Datatables -->
    <script src="{{ asset('assets/js/plugin/datatables/datatables.min.js') }}"></script>

    <!-- Bootstrap Notify -->
    <script src="{{ asset('assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js') }}"></script>

    <!-- Bootstrap Toggle -->
    {{-- <script src="{{ asset("assets/js/plugin/bootstrap-toggle/bootstrap-toggle.min.js") }}"></script> --}}

    <!-- jQuery Vector Maps -->
    <script src="{{ asset('assets/js/plugin/jqvmap/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugin/jqvmap/maps/jquery.vmap.world.js') }}"></script>

    <!-- Google Maps Plugin -->
    {{-- <script src="{{ asset("assets/js/plugin/gmaps/gmaps.js") }}"></script> --}}

    <!-- Dropzone -->
    {{-- <script src="{{ asset("assets/js/plugin/dropzone/dropzone.min.js") }}"></script> --}}

    <!-- Fullcalendar -->
    {{-- <script src="{{ asset("assets/js/plugin/fullcalendar/fullcalendar.min.js") }}"></script> --}}

    <!-- DateTimePicker -->
    {{-- <script src="{{ asset("assets/js/plugin/datepicker/bootstrap-datetimepicker.min.js") }}"></script> --}}

    <!-- Bootstrap Tagsinput -->
    {{-- <script src="{{ asset("assets/js/plugin/bootstrap-tagsinput/bootstrap-tagsinput.min.js") }}"></script> --}}

    <!-- Bootstrap Wizard -->
    {{-- <script src="{{ asset("assets/js/plugin/bootstrap-wizard/bootstrapwizard.js") }}"></script> --}}

    <!-- jQuery Validation -->
    {{-- <script src="{{ asset("assets/js/plugin/jquery.validate/jquery.validate.min.js") }}"></script> --}}

    <!-- Summernote -->
    {{-- <script src="{{ asset("assets/js/plugin/summernote/summernote-bs4.min.js") }}"></script> --}}

    <!-- Select2 -->
    {{-- <script src="{{ asset("assets/js/plugin/select2/select2.full.min.js") }}"></script> --}}

    <!-- Sweet Alert -->
    <script src="{{ asset('assets/js/plugin/sweetalert/sweetalert.min.js') }}"></script>

    <!-- Owl Carousel -->
    {{-- <script src="{{ asset("assets/js/plugin/owl-carousel/owl.carousel.min.js") }}"></script> --}}

    <!-- Magnific Popup -->
    {{-- <script src="{{ asset("assets/js/plugin/jquery.magnific-popup/jquery.magnific-popup.min.js") }}"></script> --}}

    <!-- Atlantis JS -->
    <script src="{{ asset('assets/js/atlantis.js') }}"></script>

    <!-- Atlantis DEMO methods, don't include it in your project! -->
    <script src="{{ asset('assets/js/setting-demo.js') }}"></script>
    {{-- <script src="{{ asset("assets/js/demo.js") }}"></script> --}}

    <script>
        $('#alert_demo_3_3').click(function(e) {
            swal("Good job!", "You clicked the button!", {
                icon: "success",
                buttons: {
                    confirm: {
                        className: 'btn btn-success'
                    }
                },
            });
        });

        $('#lineChart').sparkline([102, 109, 120, 99, 110, 105, 115], {
            type: 'line',
            height: '70',
            width: '100%',
            lineWidth: '2',
            lineColor: 'rgba(255, 255, 255, .5)',
            fillColor: 'rgba(255, 255, 255, .15)'
        });

        $('#lineChart2').sparkline([99, 125, 122, 105, 110, 124, 115], {
            type: 'line',
            height: '70',
            width: '100%',
            lineWidth: '2',
            lineColor: 'rgba(255, 255, 255, .5)',
            fillColor: 'rgba(255, 255, 255, .15)'
        });

        $('#lineChart3').sparkline([105, 103, 123, 100, 95, 105, 115], {
            type: 'line',
            height: '70',
            width: '100%',
            lineWidth: '2',
            lineColor: 'rgba(255, 255, 255, .5)',
            fillColor: 'rgba(255, 255, 255, .15)'
        });
    </script>

    @stack('scripts')
</body>

</html>
