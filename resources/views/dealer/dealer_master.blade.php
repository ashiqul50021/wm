<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Dealer Dashboard</title>
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta property="og:title" content="">
        <meta property="og:type" content="">
        <meta property="og:url" content="">
        <meta property="og:image" content="">

        <!-- Favicon -->
        @php
            $logo = get_setting('site_favicon');
        @endphp
        @if($logo != null)
            <link rel="shortcut icon" type="image/x-icon" href="{{ asset(get_setting('site_favicon')->value ?? 'null') }}" />
        @else
            <link rel="shortcut icon" type="image/x-icon" href="{{ asset('upload/no_image.jpg') }}" alt="{{ env('APP_NAME') }}" />
        @endif
        
        <!-- Template CSS -->
        <link href="{{ asset('backend/assets/css/main.css?v=1.1 ' ) }}" rel="stylesheet" type="text/css">
        <!-- Custom CSS -->
        <link href="{{ asset('backend/assets/css/custom.css' ) }}" rel="stylesheet" type="text/css">
        <!-- toastr css -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" type="text/css">
        <!-- Color Picker -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.5.3/css/bootstrap-colorpicker.min.css" rel="stylesheet" type="text/css">

        <!-- front awesome -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" rel="stylesheet" type="text/css">
        
        <!-- bootstrap tags input css -->
        <link href="{{ asset('backend/assets/bootstrap-tags/bootstrap-tagsinput.css ' ) }}" rel="stylesheet" type="text/css">

        <!-- Datatable CSS -->
        <link href="{{ asset('backend/datatable/css/jquery.dataTables.css ') }}" rel="stylesheet" type="text/css">

        <!-- Data Range CSS -->
        <link href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" rel="stylesheet" type="text/css">
        <!-- summernote -->
        <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet" type="text/css">
        
        @stack('css')
    </head>

    <body>
        <div class="screen-overlay"></div>
        <!-- ========== Header Section ========== -->
          @include('dealer.body.sidebar')
        <main class="main-wrap">
            <!-- ========== Header Section ========== -->
            @include('dealer.body.header')
           
            <!-- ========== Main Content Section ========== -->
            @yield('dealer')
            <!-- content-main end// -->

            <!-- ========== Footer Section ========== -->
            @include('dealer.body.footer')
            
        </main>

        <!-- Datatable Js -->
        <script src="{{ asset('backend/datatable/js/jquery-1.11.3.min.js ') }}"></script>
        <script src="{{ asset('backend/datatable/js/jquery.dataTables.js ') }}"></script>
        <script src="{{ asset('backend/datatable/js/datatable.js ') }}"></script>
        <script src="{{ asset('backend/assets/js/vendors/bootstrap.bundle.min.js ') }}"></script>
        <script src="{{ asset('backend/assets/js/vendors/select2.min.js ') }}"></script>
        <script src="{{ asset('backend/assets/js/vendors/perfect-scrollbar.js ') }}"></script>
        <script src="{{ asset('backend/assets/js/vendors/jquery.fullscreen.min.js ') }}"></script>
        <script src="{{ asset('backend/assets/js/vendors/chart.js ') }}"></script>
        <!-- Main Script -->
        <script src="{{ asset('backend/assets/js/main.js?v=1.1 ') }}"></script>
        <script src="{{ asset('backend/assets/js/custom-chart.js ') }}"></script>

        <!-- toastr js -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

        <!-- ColorPicker -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.5.3/js/bootstrap-colorpicker.min.js"></script>
        <script>
            $('#color').colorpicker();
        </script>

        <!-- bootstrap tags input js -->
        <script src="{{ asset('backend/assets/bootstrap-tags/bootstrap-tagsinput.min.js ') }}" type="text/javascript"></script>

        <!-- Data Range -->
        <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

        <!-- summernote start-->
        <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
        <script>
          $('.summernote').summernote({
            placeholder: 'Write Description',
            tabsize: 2,
            height: 120,
            minHeight: null,// set minimum height of editor
            maxHeight: null,// set maximum height of editor
            lang: true,
            focus: false,
            toolbar: [
              ['style', ['style']],
              ['fontname', ['fontname']],
              ['font', ['bold', 'underline', 'clear']],
              ['color', ['color']],
              ['para', ['ul', 'ol', 'paragraph']],
              ['table', ['table']],
              // ['insert', ['link', 'picture', 'video']],
              // ['view', ['fullscreen', 'codeview', 'help']]
            ]
          });
        </script>
        <!-- summernote End-->

        <!-- all toastr message show  Update-->
        <script>
            @if(Session::has('message'))
            var type = "{{ Session::get('alert-type','info') }}"
            switch(type){
                case 'info':
                toastr.info(" {{ Session::get('message') }} ");
                break;

                case 'success':
                toastr.success(" {{ Session::get('message') }} ");
                break;

                case 'warning':
                toastr.warning(" {{ Session::get('message') }} ");
                break;

                case 'error':
                toastr.error(" {{ Session::get('message') }} ");
                break; 
            }
            @endif 
        </script>

        <!-- all toastr message show  old-->
        <script type="text/javascript">
            @if(Session::has('success'))
              toastr.success("{{Session::get('success')}}");
            @endif
            @if(Session::has('info'))
              toastr.info("{{Session::get('info')}}");
            @endif
            @if(Session::has('warning'))
              toastr.warning("{{Session::get('warning')}}");
            @endif
            @if(Session::has('error'))
              toastr.info("{{Session::get('error')}}");
            @endif
            @if(Session::has('danger'))
              toastr.danger("{{Session::get('danger')}}");
            @endif
        </script>

        <!-- sweetalert js--> 
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

        <script type="text/javascript">
            $(function(){
                $(document).on('click','#delete',function(e){
                    e.preventDefault();
                    var link = $(this).attr("href");
        
                    Swal.fire({
                      title: 'Are you sure?',
                      text: "Delete This Data!",
                      icon: 'warning',
                      showCancelButton: true,
                      confirmButtonColor: '#3085d6',
                      cancelButtonColor: '#d33',
                      confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                    if (result.isConfirmed) {
                      window.location.href = link
                      Swal.fire(
                        'Deleted!',
                        'Your file has been deleted.',
                        'success'
                      )
                    }
                })
      
              });
            });
        </script>

    <!-- Image Show -->
    <script type="text/javascript">
        $(document).ready(function(){
            $('#image').change(function(e){
                var reader = new FileReader();
                reader.onload = function(e){
                    $('#showImage').attr('src',e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            });
        });
    </script>

    @stack('footer-script')
    </body>
</html>
