<!doctype html>
<html lang="pt-br">
  <!--begin::Head-->
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>AdminLTE v4 | Dashboard</title>
    <!--begin::Primary Meta Tags-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="title" content="AdminLTE v4 | Dashboard" />
    <meta name="author" content="ColorlibHQ" />
    <meta
      name="description"
      content="AdminLTE is a Free Bootstrap 5 Admin Dashboard, 30 example pages using Vanilla JS."
    />
    <meta
      name="keywords"
      content="bootstrap 5, bootstrap, bootstrap 5 admin dashboard, bootstrap 5 dashboard, bootstrap 5 charts, bootstrap 5 calendar, bootstrap 5 datepicker, bootstrap 5 tables, bootstrap 5 datatable, vanilla js datatable, colorlibhq, colorlibhq dashboard, colorlibhq admin dashboard"
    />
    @vite('resources/scss/app.scss')
  </head>
  <!--end::Head-->
  <!--begin::Body-->
  <body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <!--begin::App Wrapper-->
    <div class="app-wrapper">
      @include('parts.header') <!-- Header -->  
      
      @include('parts.sidebar') <!-- Sidebar -->  
      
      <!--begin::App Main-->
      <main class="app-main">
        @include('parts.content-header') <!-- Content-header -->

        <!--begin::App Content-->
        <div class="app-content">
          <!--begin::Container-fluid -->
          <div class="container-fluid">

            @yield('content') <!-- Content -->
            
          </div>
          <!--end::Container-fluid -->      
        </div>
        <!--end::App Content-->
      </main>
      <!--end::App Main-->
      
      <!-- Footer -->  
      @include('parts.footer')
      
    </div>
  @vite('resources/js/app.js')  
  </body>
  <!--end::Body-->
</html>