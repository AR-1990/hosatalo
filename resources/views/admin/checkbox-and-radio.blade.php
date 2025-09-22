<!DOCTYPE html>
<html lang="en">


<!-- checkbox-and-radio  21 Nov 2019 03:51:00 GMT -->
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Otika - Admin Dashboard Template</title>
  <!-- General CSS Files -->
  <link rel="stylesheet" href="{{ asset('assets-admin/css/app.min.css') }}">
  <!-- Template CSS -->
  <link rel="stylesheet" href="{{ asset('assets-admin/css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('assets-admin/bundles/pretty-checkbox/pretty-checkbox.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets-admin/css/components.css') }}">
  <!-- Custom style CSS -->
  <link rel="stylesheet" href="{{ asset('assets-admin/css/custom.css') }}">
  <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets-admin/img/favicon.ico') }}" />
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
                    <h4>Basic checkbox</h4>
                  </div>
                  <div class="card-body">
                    <div class="section-title">Default</div>
                    <!-- add class p-default -->
                    <div class="pretty p-default">
                      <input type="checkbox" />
                      <div class="state">
                        <label>Default</label>
                      </div>
                    </div>
                    <!-- add class p-fill -->
                    <div class="pretty p-default p-fill">
                      <input type="checkbox" />
                      <div class="state">
                        <label>Fill</label>
                      </div>
                    </div>
                    <!-- add class p-thick -->
                    <div class="pretty p-default p-thick">
                      <input type="checkbox" />
                      <div class="state">
                        <label>Thick</label>
                      </div>
                    </div>
                    <div class="section-title">Curve</div>
                    <!-- add class p-curve -->
                    <div class="pretty p-default p-curve">
                      <input type="checkbox" />
                      <div class="state">
                        <label>Default</label>
                      </div>
                    </div>
                    <div class="pretty p-default p-curve p-fill">
                      <input type="checkbox" />
                      <div class="state">
                        <label>Fill</label>
                      </div>
                    </div>
                    <div class="pretty p-default p-curve p-thick">
                      <input type="checkbox" />
                      <div class="state">
                        <label>Thick</label>
                      </div>
                    </div>
                    <div class="section-title">Round</div>
                    <!-- add class p-round -->
                    <div class="pretty p-default p-round">
                      <input type="checkbox" />
                      <div class="state">
                        <label>Default</label>
                      </div>
                    </div>
                    <div class="pretty p-default p-round p-fill">
                      <input type="checkbox" />
                      <div class="state">
                        <label>Fill</label>
                      </div>
                    </div>
                    <div class="pretty p-default p-round p-thick">
                      <input type="checkbox" />
                      <div class="state">
                        <label>Thick</label>
                      </div>
                    </div>
                    <div class="section-title">Switch</div>
                    <!-- add class p-switch -->
                    <div class="pretty p-switch">
                      <input type="checkbox" />
                      <div class="state">
                        <label>Outline</label>
                      </div>
                    </div>
                    <!-- add class p-switch -->
                    <div class="pretty p-switch p-fill">
                      <input type="checkbox" />
                      <div class="state">
                        <label>Fill</label>
                      </div>
                    </div>
                    <!-- add class p-switch -->
                    <div class="pretty p-switch p-slim">
                      <input type="checkbox" />
                      <div class="state">
                        <label>Slim</label>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-12 col-md-6 col-lg-6">
                <div class="card">
                  <div class="card-header">
                    <h4>Color Checkbox</h4>
                  </div>
                  <div class="card-body">
                    <div class="section-title">Solid</div>
                    <!-- primary -->
                    <div class="pretty p-default">
                      <input type="checkbox" />
                      <div class="state p-primary">
                        <label>Primary</label>
                      </div>
                    </div>
                    <!-- success -->
                    <div class="pretty p-default">
                      <input type="checkbox" />
                      <div class="state p-success">
                        <label>Success</label>
                      </div>
                    </div>
                    <!-- info -->
                    <div class="pretty p-default">
                      <input type="checkbox" />
                      <div class="state p-info">
                        <label>Info</label>
                      </div>
                    </div>
                    <!-- warning -->
                    <div class="pretty p-default">
                      <input type="checkbox" />
                      <div class="state p-warning">
                        <label>Warning</label>
                      </div>
                    </div>
                    <!-- danger -->
                    <div class="pretty p-default">
                      <input type="checkbox" />
                      <div class="state p-danger">
                        <label>Danger</label>
                      </div>
                    </div>
                    <div class="section-title">Mixed</div>
                    <!-- primary -->
                    <div class="pretty p-default p-round p-thick">
                      <input type="checkbox" />
                      <div class="state p-primary-o">
                        <label>Primary</label>
                      </div>
                    </div>
                    <!-- success -->
                    <div class="pretty p-default p-round">
                      <input type="checkbox" />
                      <div class="state p-success-o">
                        <label>Success</label>
                      </div>
                    </div>
                    <!-- info -->
                    <div class="pretty p-default p-fill">
                      <input type="checkbox" />
                      <div class="state p-info">
                        <label>Info</label>
                      </div>
                    </div>
                    <!-- warning -->
                    <div class="pretty p-default p-curve p-thick">
                      <input type="checkbox" />
                      <div class="state p-warning">
                        <label>Warning</label>
                      </div>
                    </div>
                    <!-- danger -->
                    <div class="pretty p-default p-curve p-thick">
                      <input type="checkbox" />
                      <div class="state p-danger-o">
                        <label>Danger</label>
                      </div>
                    </div>
                    <div class="section-title">Round</div>
                    <!-- primary -->
                    <div class="pretty p-default p-round p-thick">
                      <input type="checkbox" />
                      <div class="state p-primary-o">
                        <label>Primary</label>
                      </div>
                    </div>
                    <!-- success -->
                    <div class="pretty p-default p-round p-thick">
                      <input type="checkbox" />
                      <div class="state p-success-o">
                        <label>Success</label>
                      </div>
                    </div>
                    <!-- info -->
                    <div class="pretty p-default p-round p-thick">
                      <input type="checkbox" />
                      <div class="state p-info-o">
                        <label>Info</label>
                      </div>
                    </div>
                    <!-- warning -->
                    <div class="pretty p-default p-round p-thick">
                      <input type="checkbox" />
                      <div class="state p-warning-o">
                        <label>Warning</label>
                      </div>
                    </div>
                    <!-- danger -->
                    <div class="pretty p-default p-round p-thick">
                      <input type="checkbox" />
                      <div class="state p-danger-o">
                        <label>Danger</label>
                      </div>
                    </div>
                    <div class="section-title">Switch</div>
                    <div class="pretty p-switch">
                      <input type="checkbox" />
                      <div class="state p-primary">
                        <label>Primary</label>
                      </div>
                    </div>
                    <div class="pretty p-switch p-fill">
                      <input type="checkbox" />
                      <div class="state p-success">
                        <label>Success</label>
                      </div>
                    </div>
                    <div class="pretty p-switch p-slim">
                      <input type="checkbox" />
                      <div class="state p-info">
                        <label>Info</label>
                      </div>
                    </div>
                    <div class="pretty p-switch p-slim">
                      <input type="checkbox" />
                      <div class="state p-warning">
                        <label>Warning</label>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12 col-md-6 col-lg-6">
                <div class="card">
                  <div class="card-header">
                    <h4>Checkbox With Icons</h4>
                  </div>
                  <div class="card-body">
                    <div class="section-title">Font Awesome Icons</div>
                    <div class="pretty p-icon p-smooth">
                      <input type="checkbox" />
                      <div class="state p-success">
                        <i class="icon fa fa-check"></i>
                        <label>fa-check</label>
                      </div>
                    </div>
                    <div class="pretty p-icon p-smooth">
                      <input type="checkbox" />
                      <div class="state p-danger-o">
                        <i class="icon fas fa-times"></i>
                        <label>fa-close</label>
                      </div>
                    </div>
                    <div class="section-title">Material Icons</div>
                    <div class="pretty p-icon p-smooth">
                      <input type="checkbox" />
                      <div class="state p-success">
                        <i class="icon material-icons">done</i>
                        <label>done</label>
                      </div>
                    </div>
                    <div class="pretty p-icon p-smooth">
                      <input type="checkbox" />
                      <div class="state p-danger-o">
                        <i class="icon material-icons">clear</i>
                        <label>clear</label>
                      </div>
                    </div>
                    <div class="pretty p-icon p-toggle p-plain">
                      <input type="checkbox" />
                      <div class="state p-off">
                        <i class="icon material-icons">favorite_border</i>
                        <label>favorite_border</label>
                      </div>
                      <div class="state p-on p-info-o">
                        <i class="icon material-icons">favorite</i>
                        <label>favorite</label>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-12 col-md-6 col-lg-6">
                <div class="card">
                  <div class="card-header">
                    <h4>SVG &amp; Plain</h4>
                  </div>
                  <div class="card-body">
                    <div class="section-title">SVG Icons</div>
                    <div class="pretty p-svg p-curve">
                      <input type="checkbox" />
                      <div class="state p-success">
                        <!-- svg path -->
                        <svg class="svg svg-icon" viewBox="0 0 20 20">
                          <path
                            d="M7.629,14.566c0.125,0.125,0.291,0.188,0.456,0.188c0.164,0,0.329-0.062,0.456-0.188l8.219-8.221c0.252-0.252,0.252-0.659,0-0.911c-0.252-0.252-0.659-0.252-0.911,0l-7.764,7.763L4.152,9.267c-0.252-0.251-0.66-0.251-0.911,0c-0.252,0.252-0.252,0.66,0,0.911L7.629,14.566z"
                            style="stroke: white;fill:white;"></path>
                        </svg>
                        <label>Recurring</label>
                      </div>
                    </div>
                    <div class="pretty p-svg p-curve">
                      <input type="checkbox" />
                      <div class="state p-danger">
                        <!-- svg path -->
                        <svg class="svg svg-icon" viewBox="0 0 20 20">
                          <path
                            d="M7.629,14.566c0.125,0.125,0.291,0.188,0.456,0.188c0.164,0,0.329-0.062,0.456-0.188l8.219-8.221c0.252-0.252,0.252-0.659,0-0.911c-0.252-0.252-0.659-0.252-0.911,0l-7.764,7.763L4.152,9.267c-0.252-0.251-0.66-0.251-0.911,0c-0.252,0.252-0.252,0.66,0,0.911L7.629,14.566z"
                            style="stroke: white;fill:white;"></path>
                        </svg>
                        <label>Recurring</label>
                      </div>
                    </div>
                    <div class="section-title">Plain</div>
                    <div class="pretty p-icon p-round p-smooth p-plain">
                      <input type="checkbox" />
                      <div class="state p-warning-o">
                        <i class="icon material-icons">done</i>
                        <label>done</label>
                      </div>
                    </div>
                    <div class="pretty p-default p-round p-smooth p-plain">
                      <input type="checkbox" />
                      <div class="state p-success-o">
                        <label> Add</label>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12 col-md-6 col-lg-6">
                <div class="card">
                  <div class="card-header">
                    <h4>Toggle Checkbox</h4>
                  </div>
                  <div class="card-body">
                    <div class="section-title">Toggle</div>
                    <div class="pretty p-default p-curve p-toggle">
                      <input type="checkbox" />
                      <div class="state p-success p-on">
                        <label>Subscribed</label>
                      </div>
                      <div class="state p-danger p-off">
                        <label>Subscribe </label>
                      </div>
                    </div>
                    <div class="pretty p-icon p-toggle">
                      <input type="checkbox" />
                      <div class="state p-on">
                        <i class="icon material-icons">volume_up</i>
                        <label>On</label>
                      </div>
                      <div class="state p-off">
                        <i class="icon material-icons">volume_off</i>
                        <label>Off</label>
                      </div>
                    </div>
                    <div class="pretty p-icon p-toggle p-plain">
                      <input type="checkbox" />
                      <div class="state p-on">
                        <i class="icon material-icons">wifi</i>
                        <label>Wifi on</label>
                      </div>
                      <div class="state p-off">
                        <i class="icon material-icons">wifi_off</i>
                        <label>Wifi off</label>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-12 col-md-6 col-lg-6">
                <div class="card">
                  <div class="card-header">
                    <h4>Different Size</h4>
                  </div>
                  <div class="card-body">
                    <div class="section-title">Different Size</div>
                    <div class="pretty p-icon p-jelly p-round p-bigger">
                      <input type="checkbox" />
                      <div class="state p-info">
                        <i class="icon material-icons">done</i>
                        <label>done</label>
                      </div>
                    </div>
                    <div class="pretty p-default p-smooth p-bigger">
                      <input type="checkbox" />
                      <div class="state p-danger">
                        <label>clear</label>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12 col-md-6 col-lg-6">
                <div class="card">
                  <div class="card-header">
                    <h4>Radio Buttons</h4>
                  </div>
                  <div class="card-body">
                    <div class="section-title">Basic</div>
                    <div class="pretty p-default p-round">
                      <input type="radio" name="radio1">
                      <div class="state">
                        <label>Male</label>
                      </div>
                    </div>
                    <div class="pretty p-default p-round">
                      <input type="radio" name="radio1">
                      <div class="state">
                        <label>Female</label>
                      </div>
                    </div>
                    <div class="pretty p-default p-round">
                      <input type="radio" name="radio1">
                      <div class="state">
                        <label>Special</label>
                      </div>
                    </div>
                    <div class="section-title">Animation</div>
                    <div class="pretty p-icon p-curve p-tada">
                      <input type="radio" name="radio66">
                      <div class="state p-primary-o">
                        <i class="icon material-icons">done</i>
                        <label>HTML</label>
                      </div>
                    </div>
                    <div class="pretty p-icon p-curve p-rotate">
                      <input type="radio" name="radio66">
                      <div class="state p-success-o">
                        <i class="icon material-icons">done</i>
                        <label> Javascript</label>
                      </div>
                    </div>
                    <div class="pretty p-icon p-curve p-pulse">
                      <input type="radio" name="radio66">
                      <div class="state p-info-o">
                        <i class="icon material-icons">done</i>
                        <label> Python</label>
                      </div>
                    </div>
                    <div class="pretty p-icon p-curve p-jelly">
                      <input type="radio" name="radio66">
                      <div class="state p-warning">
                        <i class="icon material-icons">done</i>
                        <label> PHP</label>
                      </div>
                    </div>
                    <div class="pretty p-icon p-curve p-smooth">
                      <input type="radio" name="radio66">
                      <div class="state">
                        <i class="icon material-icons">done</i>
                        <label>Swift</label>
                      </div>
                    </div>
                    <div class="section-title">Plain</div>
                    <div class="pretty p-icon p-round p-plain p-smooth">
                      <input type="radio" name="plain">
                      <div class="state p-primary-o">
                        <i class="icon material-icons">accessibility</i>
                        <label>Single</label>
                      </div>
                    </div>
                    <div class="pretty p-icon p-round p-plain p-smooth">
                      <input type="radio" name="plain">
                      <div class="state p-info-o">
                        <i class="icon material-icons">supervisor_account</i>
                        <label>Married</label>
                      </div>
                    </div>
                    <div class="pretty p-icon p-round p-plain p-smooth">
                      <input type="radio" name="plain">
                      <div class="state p-success-o">
                        <i class="icon material-icons">favorite</i>
                        <label>In relationship</label>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-12 col-md-6 col-lg-6">
                <div class="card">
                  <div class="card-header">
                    <h4>Color Radio Buttons</h4>
                  </div>
                  <div class="card-body">
                    <div class="section-title">Color Radio Buttons</div>
                    <div class="pretty p-default p-curve">
                      <input type="radio" name="color" />
                      <div class="state p-primary-o">
                        <label>Primary</label>
                      </div>
                    </div>
                    <div class="pretty p-default p-curve">
                      <input type="radio" name="color" />
                      <div class="state p-success-o">
                        <label>Success</label>
                      </div>
                    </div>
                    <div class="pretty p-default p-curve">
                      <input type="radio" name="color" />
                      <div class="state p-info-o">
                        <label>Info</label>
                      </div>
                    </div>
                    <div class="pretty p-default p-curve">
                      <input type="radio" name="color" />
                      <div class="state p-warning-o">
                        <label>Warning</label>
                      </div>
                    </div>
                    <div class="pretty p-default p-curve">
                      <input type="radio" name="color" />
                      <div class="state p-danger-o">
                        <label>Danger</label>
                      </div>
                    </div>
                    <div class="section-title">Outline</div>
                    <div class="pretty p-icon p-round">
                      <input type="radio" name="icon" />
                      <div class="state p-primary-o">
                        <i class="icon material-icons">done</i>
                        <label>Dollar</label>
                      </div>
                    </div>
                    <div class="pretty p-icon p-round">
                      <input type="radio" name="icon" />
                      <div class="state p-success-o">
                        <i class="icon material-icons">done</i>
                        <label>Euro</label>
                      </div>
                    </div>
                    <div class="pretty p-icon p-round">
                      <input type="radio" name="icon" />
                      <div class="state p-info-o">
                        <i class="icon material-icons">done</i>
                        <label>Dinar</label>
                      </div>
                    </div>
                    <div class="pretty p-icon p-round">
                      <input type="radio" name="icon" />
                      <div class="state p-warning-o">
                        <i class="icon material-icons">done</i>
                        <label>Pound</label>
                      </div>
                    </div>
                    <div class="pretty p-icon p-round">
                      <input type="radio" name="icon" />
                      <div class="state p-danger-o">
                        <i class="icon material-icons">done</i>
                        <label>Rupee</label>
                      </div>
                    </div>
                    <div class="section-title">Switch</div>
                    <div class="pretty p-switch">
                      <input type="radio" name="switch1" />
                      <div class="state p-success">
                        <label>Summer</label>
                      </div>
                    </div>
                    <div class="pretty p-switch p-fill">
                      <input type="radio" name="switch1" />
                      <div class="state p-success">
                        <label>Winter</label>
                      </div>
                    </div>
                    <div class="pretty p-switch p-slim">
                      <input type="radio" name="switch1" />
                      <div class="state p-success">
                        <label>Fall</label>
                      </div>
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
<!-- JS Libraries -->
<!-- Page Specific JS File -->
<!-- Template JS File -->
<script src="{{ asset('assets-admin/js/scripts.js') }}"></script>
<!-- Custom JS File -->
<script src="{{ asset('assets-admin/js/custom.js') }}"></script>

</body>


<!-- checkbox-and-radio  21 Nov 2019 03:51:01 GMT -->
</html>