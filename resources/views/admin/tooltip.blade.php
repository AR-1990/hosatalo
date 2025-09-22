<!DOCTYPE html>
<html lang="en">


<!-- tooltip.html  21 Nov 2019 03:51:03 GMT -->
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
                    <h4>Directions</h4>
                  </div>
                  <div class="card-body">
                    <button type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="top"
                      title="Vivamus sagittis lacus vel augue laoreet rutrum faucibus.">
                      On top
                    </button>
                    <button type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="right"
                      title="Vivamus sagittis lacus vel augue laoreet rutrum faucibus.">
                      On right
                    </button>
                    <button type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="bottom" title="Vivamus
                    sagittis lacus vel augue laoreet rutrum faucibus.">
                      On bottom
                    </button>
                    <button type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="left"
                      title="Vivamus sagittis lacus vel augue laoreet rutrum faucibus.">
                      On left
                    </button>
                  </div>
                </div>
                <div class="card">
                  <div class="card-header">
                    <h4>Disabled Tooltip</h4>
                  </div>
                  <div class="card-body">
                    <span class="d-inline-block" data-toggle="tooltip" data-title="Disabled tooltip">
                      <button class="btn btn-primary pe-none" type="button" disabled>Disabled button</button>
                    </span>
                  </div>
                </div>
              </div>
              <div class="col-12 col-md-6 col-lg-6">
                <div class="card">
                  <div class="card-header">
                    <h4>Link</h4>
                  </div>
                  <div class="card-body">
                    <a href="#" data-toggle="tooltip" title="Tooltip, bro!">Hover me!</a>
                  </div>
                </div>
                <div class="card">
                  <div class="card-header">
                    <h4>Paragraph</h4>
                  </div>
                  <div class="card-body">
                    <div class="buttons">
                      <p>Lorem ipsum dolor sit amet, consectetur <b data-toggle="tooltip"
                          title="Hello, this is tooltip.">adipisicing elit</b>, sed do eiusmod
                        tempor incididunt ut labore et dolore magna aliqua.</p>
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
 <script src="{{ asset('assets-admin/bundles/jquery-ui/jquery-ui.min.js') }}"></script>
 <!-- Page Specific JS File -->
 <script src="{{ asset('assets-admin/js/page/advance-table.js') }}"></script>
 <!-- Template JS File -->
 <script src="{{ asset('assets-admin/js/scripts.js') }}"></script>
 <!-- Custom JS File -->
 <script src="{{ asset('assets-admin-admin/js/custom.js') }}"></script>
</body>


<!-- tooltip.html  21 Nov 2019 03:51:03 GMT -->
</html>