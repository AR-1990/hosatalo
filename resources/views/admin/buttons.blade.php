<!DOCTYPE html>
<html lang="en">


<!-- buttons  21 Nov 2019 03:51:00 GMT -->
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
                    <h4>Basic</h4>
                  </div>
                  <div class="card-body">
                    <p class="text-muted">Use the <code>.btn .btn-{color}</code> classes.</p>
                    <div class="buttons">
                      <a href="#" class="btn btn-primary">Primary</a>
                      <a href="#" class="btn btn-secondary">Secondary</a>
                      <a href="#" class="btn btn-info">Info</a>
                      <a href="#" class="btn btn-warning">Warning</a>
                      <a href="#" class="btn btn-danger">Danger</a>
                      <a href="#" class="btn btn-success">Success</a>
                      <a href="#" class="btn btn-light">Light</a>
                      <a href="#" class="btn btn-dark">Dark</a>
                      <a href="#" class="btn">Link</a>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-12 col-md-6 col-lg-6">
                <div class="card">
                  <div class="card-header">
                    <h4>Buttons <code>.btn-outline</code></h4>
                  </div>
                  <div class="card-body">
                    <p class="text-muted">Use the <code>.btn .btn-outline-{color}</code> classes.</p>
                    <div class="buttons">
                      <a href="#" class="btn btn-outline-primary">Primary</a>
                      <a href="#" class="btn btn-outline-secondary">Secondary</a>
                      <a href="#" class="btn btn-outline-info">Info</a>
                      <a href="#" class="btn btn-outline-warning">Warning</a>
                      <a href="#" class="btn btn-outline-danger">Danger</a>
                      <a href="#" class="btn btn-outline-success">Success</a>
                      <a href="#" class="btn btn-outline-light">Light</a>
                      <a href="#" class="btn btn-outline-dark">Dark</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12 col-md-6 col-lg-6">
                <div class="card">
                  <div class="card-header">
                    <h4>Button Sizes</h4>
                  </div>
                  <div class="card-body">
                    <p class="text-muted">Use the <code>.btn-lg</code> or <code>.btn-sm</code> classes.</p>
                    <div class="buttons">
                      <a href="#" class="btn btn-sm btn-warning">Small</a>
                      <a href="#" class="btn btn-danger">Normal</a>
                      <a href="#" class="btn btn-lg btn-dark">Large</a>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-12 col-md-6 col-lg-6">
                <div class="card">
                  <div class="card-header">
                    <h4>Button States</h4>
                  </div>
                  <div class="card-body">
                    <p class="text-muted">Use the <code>.disabled</code> or <code>.btn-progress</code> classes.</p>
                    <div class="buttons">
                      <a href="#" class="btn btn-primary">Normal</a>
                      <a href="#" class="btn disabled btn-primary">Disabled</a>
                      <a href="#" class="btn disabled btn-primary btn-progress">Progress</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12 col-md-6 col-lg-6">
                <div class="card">
                  <div class="card-header">
                    <h4>Icon Button</h4>
                  </div>
                  <div class="card-body">
                    <p class="text-muted">Use the <code>.btn-icon</code> and <code>.icon-left</code> classes.</p>
                    <div class="buttons">
                      <a href="#" class="btn btn-icon icon-left"><i class="far fa-user"></i> Default</a>
                      <a href="#" class="btn btn-icon icon-left btn-primary"><i class="far fa-edit"></i> Primary</a>
                      <a href="#" class="btn btn-icon icon-left btn-secondary"><i class="far fa-user"></i> Secondary</a>
                      <a href="#" class="btn btn-icon icon-left btn-info"><i class="fas fa-info-circle"></i> Info</a>
                      <a href="#" class="btn btn-icon icon-left btn-warning"><i class="fas fa-exclamation-triangle"></i>
                        Warning</a>
                      <a href="#" class="btn btn-icon icon-left btn-danger"><i class="fas fa-times"></i> Danger</a>
                      <a href="#" class="btn btn-icon icon-left btn-success"><i class="fas fa-check"></i> Success</a>
                      <a href="#" class="btn btn-icon icon-left btn-light"><i class="fas fa-star"></i> Light</a>
                      <a href="#" class="btn btn-icon icon-left btn-dark"><i class="far fa-file"></i> Dark</a>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-12 col-md-6 col-lg-6">
                <div class="card">
                  <div class="card-header">
                    <h4>Only Icon Button</h4>
                  </div>
                  <div class="card-body">
                    <p class="text-muted">Use the <code>.btn-icon</code> class.</p>
                    <div class="buttons">
                      <a href="#" class="btn btn-icon btn-primary"><i class="far fa-edit"></i></a>
                      <a href="#" class="btn btn-icon btn-secondary"><i class="far fa-user"></i></a>
                      <a href="#" class="btn btn-icon btn-info"><i class="fas fa-info-circle"></i></a>
                      <a href="#" class="btn btn-icon btn-warning"><i class="fas fa-exclamation-triangle"></i></a>
                      <a href="#" class="btn btn-icon btn-danger"><i class="fas fa-times"></i></a>
                      <a href="#" class="btn btn-icon btn-success"><i class="fas fa-check"></i></a>
                      <a href="#" class="btn btn-icon btn-light"><i class="fas fa-star"></i></a>
                      <a href="#" class="btn btn-icon btn-dark"><i class="far fa-file"></i></a>
                    </div>
                    <p class="text-muted mt-2">Sizes.</p>
                    <div class="buttons">
                      <a href="#" class="btn btn-icon btn-sm btn-warning"><i
                          class="fas fa-exclamation-triangle"></i></a>
                      <a href="#" class="btn btn-icon btn-danger"><i class="fas fa-times"></i></a>
                      <a href="#" class="btn btn-icon btn-lg btn-success"><i class="fas fa-check"></i></a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12 col-md-6 col-lg-6">
                <div class="card">
                  <div class="card-header">
                    <h4>Button Group</h4>
                  </div>
                  <div class="card-body">
                    <div class="btn-group mb-3" role="group" aria-label="Basic example">
                      <button type="button" class="btn btn-info">Left</button>
                      <button type="button" class="btn btn-info">Middle</button>
                      <button type="button" class="btn btn-info">Right</button>
                    </div>
                    <div class="btn-group mb-3" role="group" aria-label="Basic example">
                      <button type="button" class="btn btn-danger">Left</button>
                      <button type="button" class="btn btn-warning">Middle</button>
                      <button type="button" class="btn btn-success">Right</button>
                    </div>
                    <div class="btn-group mb-3 btn-group-sm" role="group" aria-label="Basic example">
                      <button type="button" class="btn btn-primary">Left</button>
                      <button type="button" class="btn btn-primary">Middle</button>
                      <button type="button" class="btn btn-primary">Right</button>
                    </div>
                    <div class="clearfix"></div>
                    <div class="btn-group btn-group-lg" role="group" aria-label="Basic example">
                      <button type="button" class="btn btn-danger">Left</button>
                      <button type="button" class="btn btn-danger">Middle</button>
                      <button type="button" class="btn btn-danger">Right</button>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-12 col-md-6 col-lg-6">
                <div class="card">
                  <div class="card-header">
                    <h4>Vertical Variation</h4>
                  </div>
                  <div class="card-body">
                    <div class="btn-group-vertical" role="group" aria-label="Basic example">
                      <button type="button" class="btn btn-info">Left</button>
                      <button type="button" class="btn btn-info">Middle</button>
                      <button type="button" class="btn btn-info">Right</button>
                      <button type="button" class="btn btn-info">Justify</button>
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


<!-- buttons  21 Nov 2019 03:51:00 GMT -->
</html>