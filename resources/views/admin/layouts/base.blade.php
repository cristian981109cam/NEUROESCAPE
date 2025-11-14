<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Neuroescape</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('vendor/adminlte/dist/img/Neuroescape.ico') }}" type="image/x-icon">

    <!-- Custom fonts for this template-->
    <link href="{{asset('/admin/plantilla/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
    
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{asset('/admin/plantilla/css/sb-admin-2.min.css')}}" rel="stylesheet">

    {{-- Datatables --}}
    {{-- <link href="{{ asset('/admin/plantilla/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet"> --}}

    {{-- Font-awesome 6.7.2 --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Bootstrap CSS 5.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- DataTables CSS para Bootstrap 5 -->
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">

    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        @include('admin.layouts.menu.menu')
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                @include('admin.layouts.header.header')
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                {{-- <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="mb-4 text-gray-800 h3">Blank Page</h1>

                </div> --}}
                @yield('content')
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            @include('admin.layouts.footer.footer')
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="rounded scroll-to-top" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    @php( $logout_url = View::getSection('logout_url') ?? config('adminlte.logout_url', 'logout') )

    @if (config('adminlte.use_route_url', false))
        @php( $logout_url = $logout_url ? route($logout_url) : '' )
    @else
        @php( $logout_url = $logout_url ? url($logout_url) : '' )
    @endif

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Seleccione "Salir" a continuación si está listo para finalizar su sesión actual.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                    <a class="btn btn-primary" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Salir</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Logout Form -->
    <form id="logout-form" action="{{ $logout_url }}" method="POST" style="display: none;">
        @if(config('adminlte.logout_method'))
            {{ method_field(config('adminlte.logout_method')) }}
        @endif
        {{ csrf_field() }}
    </form>

    <!-- Bootstrap core JavaScript-->
    <script src="{{asset('/admin/plantilla/vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('/admin/plantilla/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{asset('/admin/plantilla/vendor/jquery-easing/jquery.easing.min.js')}}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{asset('/admin/plantilla/js/sb-admin-2.min.js')}}"></script>

    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- <script src="{{ asset('/admin/plantilla/vendor/datatables/jquery.dataTables.min.js') }}"></script> --}}

    {{-- <script src="{{ asset('/admin/plantilla/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script> --}}

    {{-- <script src="{{ asset('/admin/plantilla/js/demo/datatables-demo.js') }}"></script> --}}

    <!-- Bootstrap JS 5.3 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- FullCalendar JS 6.1.15 -->
    {{-- <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script> --}}

    <script src="{{ asset('/admin/fullcalendar/dist/index.global.min.js') }}"></script>
    
    <script src="{{ asset('/admin/fullcalendar/dist/index.global.js') }}"></script>

    <!-- DataTables JS para Bootstrap 5 -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    
    @yield('js')

</body>

</html>