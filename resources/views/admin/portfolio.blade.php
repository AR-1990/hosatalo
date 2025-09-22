<!DOCTYPE html>
<html lang="en">


<!-- portfolio.html  21 Nov 2019 03:50:12 GMT -->
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
              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="card">
                  <div class="card-body">
                    <div class="bootstrap snippet">
                      <section id="portfolio" class="gray-bg padding-top-bottom">
                        <!--==== Portfolio Filters ====-->
                        <div class="categories">
                          <ul>
                            <li class="active">
                              <a href="#" data-filter="*">All Categories</a>
                            </li>
                            <li>
                              <a href="#" data-filter=".web-design">Web Design</a>
                            </li>
                            <li>
                              <a href="#" data-filter=".apps">Apps</a>
                            </li>
                            <li>
                              <a href="#" data-filter=".psd">PSD</a>
                            </li>
                          </ul>
                        </div>
                        <!-- ======= Portfolio items ===-->
                        <div class="projects-container scrollimation in">
                          <div class="row">
                            <article class="col-md-4 col-sm-6 portfolio-item web-design apps psd">
                              <div class="portfolio-thumb in">
                                <a href="#" class="main-link">
                                  <img class="img-responsive img-center" src="assets/img/posts/post4.png" alt="">
                                  <span class="project-title">Title 1</span>
                                  <span class="overlay-mask"></span>
                                </a>
                                <a class="enlarge cboxElement" href="#" title="Bills Project"><i
                                    class="fa fa-expand fa-fw"></i></a>
                                <a class="link" href="#"><i class="fa fa-eye fa-fw"></i></a>
                              </div>
                            </article>
                            <article class="col-md-4 col-sm-6 portfolio-item apps">
                              <div class="portfolio-thumb in">
                                <a href="#" class="main-link">
                                  <img class="img-responsive img-center" src="assets/img/posts/post5.png" alt="">
                                  <span class="project-title">Title 2</span>
                                  <span class="overlay-mask"></span>
                                </a>
                                <a class="link centered" href="#"><i class="fa fa-eye fa-fw"></i></a>
                              </div>
                            </article>
                            <article class="col-md-4 col-sm-6 portfolio-item web-design psd">
                              <div class="portfolio-thumb in">
                                <a href="#" class="main-link">
                                  <img class="img-responsive img-center" src="assets/img/posts/post6.png" alt="">
                                  <span class="project-title">Title 3</span>
                                  <span class="overlay-mask"></span>
                                </a>
                                <a class="enlarge centered cboxElement" href="#" title="Get Colored"><i
                                    class="fa fa-expand fa-fw"></i></a>
                              </div>
                            </article>
                            <article class="col-md-4 col-sm-6 portfolio-item apps">
                              <div class="portfolio-thumb in">
                                <a href="#" class="main-link">
                                  <img class="img-responsive img-center" src="assets/img/posts/post7.png" alt="">
                                  <span class="project-title">Title 4</span>
                                  <span class="overlay-mask"></span>
                                </a>
                                <a class="enlarge cboxElement" href="#" title="Holiday Selector"><i
                                    class="fa fa-expand fa-fw"></i></a>
                                <a class="link" href="#"><i class="fa fa-eye fa-fw"></i></a>
                              </div>
                            </article>
                            <article class="col-md-4 col-sm-6 portfolio-item web-design psd">
                              <div class="portfolio-thumb in">
                                <a href="#" class="main-link">
                                  <img class="img-responsive img-center" src="assets/img/posts/post8.png" alt="">
                                  <span class="project-title">Title 5</span>
                                  <span class="overlay-mask"></span>
                                </a>
                                <a class="enlarge cboxElement" href="#" title="Scavenger Hunt"><i
                                    class="fa fa-expand fa-fw"></i></a>
                                <a class="link" href="#"><i class="fa fa-eye fa-fw"></i></a>
                              </div>
                            </article>
                            <article class="col-md-4 col-sm-6 portfolio-item web-design apps">
                              <div class="portfolio-thumb in">
                                <a href="#" class="main-link">
                                  <img class="img-responsive img-center" src="assets/img/posts/post9.png" alt="">
                                  <span class="project-title">Title 6</span>
                                  <span class="overlay-mask"></span>
                                </a>
                                <a class="enlarge cboxElement" href="#" title="Sonor"><i
                                    class="fa fa-expand fa-fw"></i></a>
                                <a class="link" href="#"><i class="fa fa-eye fa-fw"></i></a>
                              </div>
                            </article>
                            <article class="col-md-4 col-sm-6 portfolio-item web-design apps psd">
                              <div class="portfolio-thumb in">
                                <a href="#" class="main-link">
                                  <img class="img-responsive img-center" src="assets/img/posts/post11.png" alt="">
                                  <span class="project-title">Title 7</span>
                                  <span class="overlay-mask"></span>
                                </a>
                                <a class="enlarge cboxElement" href="#" title="Bills Project"><i
                                    class="fa fa-expand fa-fw"></i></a>
                                <a class="link" href="#"><i class="fa fa-eye fa-fw"></i></a>
                              </div>
                            </article>
                            <article class="col-md-4 col-sm-6 portfolio-item apps">
                              <div class="portfolio-thumb in">
                                <a href="#" class="main-link">
                                  <img class="img-responsive img-center" src="assets/img/posts/post12.png" alt="">
                                  <span class="project-title">Title 8</span>
                                  <span class="overlay-mask"></span>
                                </a>
                                <a class="link centered" href="#"><i class="fa fa-eye fa-fw"></i></a>
                              </div>
                            </article>
                            <article class="col-md-4 col-sm-6 portfolio-item web-design psd">
                              <div class="portfolio-thumb in">
                                <a href="#" class="main-link">
                                  <img class="img-responsive img-center" src="assets/img/posts/post13.png" alt="">
                                  <span class="project-title">Title 9</span>
                                  <span class="overlay-mask"></span>
                                </a>
                                <a class="enlarge centered cboxElement" href="#" title="Get Colored"><i
                                    class="fa fa-expand fa-fw"></i></a>
                              </div>
                            </article>
                          </div>
                        </div>
                      </section>
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


<!-- portfolio.html  21 Nov 2019 03:50:31 GMT -->
</html>