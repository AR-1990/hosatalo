<!DOCTYPE html>
<html lang="en">


<!-- badge  21 Nov 2019 03:51:00 GMT -->
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Otika - Admin Dashboard Template</title>
  <!-- General CSS Files -->
  <link rel="stylesheet" href="{{ asset('assets-admin/css/app.min.css') }}">
  <!-- Template CSS -->
  <link rel="stylesheet" href="{{ asset('assets-admin/css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('assets-admin/css/components.css') }}">
  <!-- Custom style CSS -->
  <link rel="stylesheet" href="{{ asset('assets-admin/css/custom.css') }}">
  <link rel='shortcut icon' type='image/x-icon' href='{{ asset('assets-admin/img/favicon.ico') }}' />
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-94034622-3"></script>
</head>

<body>
  <div class="loader"></div>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <div class="navbar-bg"></div>
      @include('admin.layout.header')
      @include('admin.layout.sidebar')
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-body">
            <div class="row">
              <div class="col-12 col-md-6 col-lg-6">
                <div class="card">
                  <div class="card-header">
                    <h4>Heading</h4>
                  </div>
                  <div class="card-body">
                    <h1>Heading 1 <span class="badge badge-secondary">New</span></h1>
                    <h2>Heading 2 <span class="badge badge-secondary">New</span></h2>
                    <h3>Heading 3 <span class="badge badge-secondary">New</span></h3>
                    <h4>Heading 4 <span class="badge badge-secondary">New</span></h4>
                    <h5>Heading 5 <span class="badge badge-secondary">New</span></h5>
                    <h6>Heading 6 <span class="badge badge-secondary">New</span></h6>
                  </div>
                </div>
                <div class="card">
                  <div class="card-header">
                    <h4>Variation</h4>
                  </div>
                  <div class="card-body">
                    <div class="badges">
                      <span class="badge badge-primary">Primary</span>
                      <span class="badge badge-secondary">Secondary</span>
                      <span class="badge badge-success">Success</span>
                      <span class="badge badge-danger">Danger</span>
                      <span class="badge badge-warning">Warning</span>
                      <span class="badge badge-info">Info</span>
                      <span class="badge badge-light">Light</span>
                      <span class="badge badge-dark">Dark</span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-12 col-md-6 col-lg-6">
                <div class="card">
                  <div class="card-header">
                    <h4>Button</h4>
                  </div>
                  <div class="card-body">
                    <div class="buttons">
                      <div class="section-title mt-0">Simple</div>
                      <button type="button" class="btn btn-primary">
                        Notifications <span class="badge badge-transparent">4</span>
                      </button>
                      <button type="button" class="btn btn-danger">
                        Notifications <span class="badge badge-transparent">4</span>
                      </button>
                      <button type="button" class="btn btn-warning">
                        Notifications <span class="badge badge-transparent">4</span>
                      </button>
                      <button type="button" class="btn btn-success">
                        Notifications <span class="badge badge-transparent">4</span>
                      </button>
                      <button type="button" class="btn btn-dark">
                        Notifications <span class="badge badge-transparent">4</span>
                      </button>
                      <div class="section-title">Icons</div>
                      <button type="button" class="btn btn-primary btn-icon icon-left">
                        <i class="fas fa-plane"></i> Notifications <span class="badge badge-transparent">4</span>
                      </button>
                      <button type="button" class="btn btn-danger btn-icon icon-left">
                        <i class="fas fa-plane"></i> Notifications <span class="badge badge-transparent">4</span>
                      </button>
                      <button type="button" class="btn btn-warning btn-icon icon-left">
                        <i class="fas fa-plane"></i> Notifications <span class="badge badge-transparent">4</span>
                      </button>
                      <button type="button" class="btn btn-success btn-icon icon-left">
                        <i class="fas fa-plane"></i> Notifications <span class="badge badge-transparent">4</span>
                      </button>
                    </div>
                  </div>
                </div>
                <div class="card">
                  <div class="card-header">
                    <h4>Link</h4>
                  </div>
                  <div class="card-body">
                    <div class="badges">
                      <a href="#" class="badge badge-primary">Primary</a>
                      <a href="#" class="badge badge-secondary">Secondary</a>
                      <a href="#" class="badge badge-success">Success</a>
                      <a href="#" class="badge badge-danger">Danger</a>
                      <a href="#" class="badge badge-warning">Warning</a>
                      <a href="#" class="badge badge-info">Info</a>
                      <a href="#" class="badge badge-light">Light</a>
                      <a href="#" class="badge badge-dark">Dark</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
        <div class="settingSidebar">
          <a href="javascript:void(0)" class="settingPanelToggle"> <i class="fa fa-spin fa-cog"></i>
          </a>
          <div class="settingSidebar-body ps-container ps-theme-default">
            <div class=" fade show active">
              <div class="setting-panel-header">Setting Panel
              </div>
              <div class="p-15 border-bottom">
                <h6 class="font-medium m-b-10">Select Layout</h6>
                <div class="selectgroup layout-color w-50">
                  <label class="selectgroup-item">
                    <input type="radio" name="value" value="1" class="selectgroup-input-radio select-layout" checked>
                    <span class="selectgroup-button">Light</span>
                  </label>
                  <label class="selectgroup-item">
                    <input type="radio" name="value" value="2" class="selectgroup-input-radio select-layout">
                    <span class="selectgroup-button">Dark</span>
                  </label>
                </div>
              </div>
              <div class="p-15 border-bottom">
                <h6 class="font-medium m-b-10">Sidebar Color</h6>
                <div class="selectgroup selectgroup-pills sidebar-color">
                  <label class="selectgroup-item">
                    <input type="radio" name="icon-input" value="1" class="selectgroup-input select-sidebar">
                    <span class="selectgroup-button selectgroup-button-icon" data-toggle="tooltip"
                      data-original-title="Light Sidebar"><i class="fas fa-sun"></i></span>
                  </label>
                  <label class="selectgroup-item">
                    <input type="radio" name="icon-input" value="2" class="selectgroup-input select-sidebar" checked>
                    <span class="selectgroup-button selectgroup-button-icon" data-toggle="tooltip"
                      data-original-title="Dark Sidebar"><i class="fas fa-moon"></i></span>
                  </label>
                </div>
              </div>
              <div class="p-15 border-bottom">
                <h6 class="font-medium m-b-10">Color Theme</h6>
                <div class="theme-setting-options">
                  <ul class="choose-theme list-unstyled mb-0">
                    <li title="white" class="active">
                      <div class="white"></div>
                    </li>
                    <li title="cyan">
                      <div class="cyan"></div>
                    </li>
                    <li title="black">
                      <div class="black"></div>
                    </li>
                    <li title="purple">
                      <div class="purple"></div>
                    </li>
                    <li title="orange">
                      <div class="orange"></div>
                    </li>
                    <li title="green">
                      <div class="green"></div>
                    </li>
                    <li title="red">
                      <div class="red"></div>
                    </li>
                  </ul>
                </div>
              </div>
              <div class="p-15 border-bottom">
                <div class="theme-setting-options">
                  <label class="m-b-0">
                    <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input"
                      id="mini_sidebar_setting">
                    <span class="custom-switch-indicator"></span>
                    <span class="control-label p-l-10">Mini Sidebar</span>
                  </label>
                </div>
              </div>
              <div class="p-15 border-bottom">
                <div class="theme-setting-options">
                  <label class="m-b-0">
                    <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input"
                      id="sticky_header_setting">
                    <span class="custom-switch-indicator"></span>
                    <span class="control-label p-l-10">Sticky Header</span>
                  </label>
                </div>
              </div>
              <div class="mt-4 mb-4 p-3 align-center rt-sidebar-last-ele">
                <a href="#" class="btn btn-icon icon-left btn-primary btn-restore-theme">
                  <i class="fas fa-undo"></i> Restore Default
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <footer class="main-footer">
        <div class="footer-left">
          <a href="templateshub.net">Templateshub</a></a>
        </div>
        <div class="footer-right">
        </div>
      </footer>
    </div>
  </div>
  <!-- General JS Scripts -->
  <script src="{{ asset('assets-admin/js/app.min.js') }}"></script>
  <!-- JS Libraies -->
  <!-- Page Specific JS File -->
  <!-- Template JS File -->
  <script src="{{ asset('assets-admin/js/scripts.js') }}"></script>
  <!-- Custom JS File -->
  <script src="{{ asset('assets-admin/js/custom.js') }}"></script>
</body>


<!-- badge  21 Nov 2019 03:51:00 GMT -->
</html>