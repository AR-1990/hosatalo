<!DOCTYPE html>
<html lang="en">


<!-- email-inbox  21 Nov 2019 03:50:57 GMT -->
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
              <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                <div class="card">
                  <div class="body">
                    <div id="mail-nav">
                      <button type="button" class="btn btn-danger waves-effect btn-compose m-b-15">COMPOSE</button>
                      <ul class="" id="mail-folders">
                        <li class="active">
                          <a href="mail-inbox" title="Inbox">Inbox (10)
                          </a>
                        </li>
                        <li>
                          <a href="javascript:;" title="Sent">Sent</a>
                        </li>
                        <li>
                          <a href="javascript:;" title="Draft">Draft</a>
                        </li>
                        <li>
                          <a href="javascript:;" title="Bin">Bin</a>
                        </li>
                        <li>
                          <a href="javascript:;" title="Important">Important</a>
                        </li>
                        <li>
                          <a href="javascript:;" title="Starred">Starred</a>
                        </li>
                      </ul>
                      <h5 class="b-b p-10 text-strong">Labels</h5>
                      <ul class="" id="mail-labels">
                        <li>
                          <a href="javascript:;">
                            <i class="material-icons col-red">local_offer</i>Family</a>
                        </li>
                        <li>
                          <a href="javascript:;">
                            <i class="material-icons col-blue">local_offer</i>Work</a>
                        </li>
                        <li>
                          <a href="javascript:;">
                            <i class="material-icons col-orange">local_offer</i>Shop</a>
                        </li>
                        <li>
                          <a href="javascript:;">
                            <i class="material-icons col-cyan">local_offer</i>Themeforest</a>
                        </li>
                        <li>
                          <a href="javascript:;">
                            <i class="material-icons col-blue-grey">local_offer</i>Google</a>
                        </li>
                      </ul>
                      <h5 class="b-b p-10 text-strong">Online</h5>
                      <ul class="online-user" id="online-offline">
                        <li><a href="javascript:;"> <img alt="image" src="assets/img/users/user-2.png"
                              class="rounded-circle" width="35" data-toggle="tooltip" title="Sachin Pandit">
                            Sachin Pandit
                          </a></li>
                        <li><a href="javascript:;"> <img alt="image" src="assets/img/users/user-1.png"
                              class="rounded-circle" width="35" data-toggle="tooltip" title="Sarah Smith">
                            Sarah Smith
                          </a></li>
                        <li><a href="javascript:;"> <img alt="image" src="assets/img/users/user-3.png"
                              class="rounded-circle" width="35" data-toggle="tooltip" title="Airi Satou">
                            Airi Satou
                          </a></li>
                        <li><a href="javascript:;"> <img alt="image" src="assets/img/users/user-4.png"
                              class="rounded-circle" width="35" data-toggle="tooltip" title="Angelica Ramos	">
                            Angelica Ramos
                          </a></li>
                        <li><a href="javascript:;"> <img alt="image" src="assets/img/users/user-5.png"
                              class="rounded-circle" width="35" data-toggle="tooltip" title="Cara Stevens">
                            Cara Stevens
                          </a></li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
                <div class="card">
                  <div class="boxs mail_listing">
                    <div class="inbox-center table-responsive">
                      <table class="table table-hover">
                        <thead>
                          <tr>
                            <th class="text-center">
                              <label class="form-check-label">
                                <input type="checkbox">
                                <span class="form-check-sign"></span>
                              </label>
                            </th>
                            <th colspan="3">
                              <div class="inbox-header">
                                <div class="mail-option">
                                  <div class="email-btn-group m-l-15">
                                    <a href="#" class="col-dark-gray waves-effect m-r-20" title="back"
                                      data-toggle="tooltip">
                                      <i class="material-icons">keyboard_return</i>
                                    </a>
                                    <a href="#" class="col-dark-gray waves-effect m-r-20" title="Archive"
                                      data-toggle="tooltip">
                                      <i class="material-icons">archive</i>
                                    </a>
                                    <div class="p-r-20">|</div>
                                    <a href="#" class="col-dark-gray waves-effect m-r-20" title="Error"
                                      data-toggle="tooltip">
                                      <i class="material-icons">error</i>
                                    </a>
                                    <a href="#" class="col-dark-gray waves-effect m-r-20" title="Delete"
                                      data-toggle="tooltip">
                                      <i class="material-icons">delete</i>
                                    </a>
                                    <a href="#" class="col-dark-gray waves-effect m-r-20" title="Folders"
                                      data-toggle="tooltip">
                                      <i class="material-icons">folder</i>
                                    </a>
                                    <a href="#" class="col-dark-gray waves-effect m-r-20" title="Tag"
                                      data-toggle="tooltip">
                                      <i class="material-icons">local_offer</i>
                                    </a>
                                  </div>
                                </div>
                              </div>
                            </th>
                            <th class="hidden-xs" colspan="2">
                              <div class="pull-right">
                                <div class="email-btn-group m-l-15">
                                  <a href="#" class="col-dark-gray waves-effect m-r-20" title="previous"
                                    data-toggle="tooltip">
                                    <i class="material-icons">navigate_before</i>
                                  </a>
                                  <a href="#" class="col-dark-gray waves-effect m-r-20" title="next"
                                    data-toggle="tooltip">
                                    <i class="material-icons">navigate_next</i>
                                  </a>
                                </div>
                              </div>
                            </th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr class="unread">
                            <td class="tbl-checkbox">
                              <label class="form-check-label">
                                <input type="checkbox">
                                <span class="form-check-sign"></span>
                              </label>
                            </td>
                            <td class="hidden-xs">
                              <i class="material-icons">star_border</i>
                            </td>
                            <td class="hidden-xs">Nelson Lane</td>
                            <td class="max-texts">
                              <a href="#">
                                <span class="badge badge-primary">Work</span>
                                Lorem ipsum perspiciatis unde omnis iste natus</a>
                            </td>
                            <td class="hidden-xs">
                              <i class="material-icons">attach_file</i>
                            </td>
                            <td class="text-right"> 12:30 PM </td>
                          </tr>
                          <tr class="unread">
                            <td class="tbl-checkbox">
                              <label class="form-check-label">
                                <input type="checkbox">
                                <span class="form-check-sign"></span>
                              </label>
                            </td>
                            <td class="hidden-xs">
                              <i class="material-icons text-warning">star</i>
                            </td>
                            <td class="hidden-xs">Kerry Mann</td>
                            <td class="max-texts">
                              <a href="#">Lorem ipsum perspiciatis unde omnis iste natus</a>
                            </td>
                            <td class="hidden-xs">
                              <i class="material-icons">attach_file</i>
                            </td>
                            <td class="text-right"> May 13 </td>
                          </tr>
                          <tr class="unread">
                            <td class="tbl-checkbox">
                              <label class="form-check-label">
                                <input type="checkbox">
                                <span class="form-check-sign"></span>
                              </label>
                            </td>
                            <td class="hidden-xs">
                              <i class="material-icons">star_border</i>
                            </td>
                            <td class="hidden-xs">Adam Peters</td>
                            <td class="max-texts">
                              <a href="#">
                                <span class="badge badge-secondary">Shopping</span>
                                Lorem ipsum perspiciatis unde omnis</a>
                            </td>
                            <td class="hidden-xs">
                              <i class="material-icons">attach_file</i>
                            </td>
                            <td class="text-right"> May 12 </td>
                          </tr>
                          <tr>
                            <td class="tbl-checkbox">
                              <label class="form-check-label">
                                <input type="checkbox">
                                <span class="form-check-sign"></span>
                              </label>
                            </td>
                            <td class="hidden-xs">
                              <i class="material-icons">star_border</i>
                            </td>
                            <td class="hidden-xs">Lula Reese</td>
                            <td class="max-texts">
                              <a href="#">
                                <span class="badge badge-success">Family</span>
                                Lorem ipsum perspiciatis unde omnis iste natus</a>
                            </td>
                            <td class="hidden-xs">
                              <i class="material-icons">attach_file</i>
                            </td>
                            <td class="text-right"> May 12 </td>
                          </tr>
                          <tr>
                            <td class="tbl-checkbox">
                              <label class="form-check-label">
                                <input type="checkbox">
                                <span class="form-check-sign"></span>
                              </label>
                            </td>
                            <td class="hidden-xs">
                              <i class="material-icons">star_border</i>
                            </td>
                            <td class="hidden-xs">Nelson Lane</td>
                            <td class="max-texts">
                              <a href="#">
                                Lorem ipsum perspiciatis unde omnis iste natus</a>
                            </td>
                            <td class="hidden-xs">
                              <i class="material-icons">attach_file</i>
                            </td>
                            <td class="text-right"> May 12 </td>
                          </tr>
                          <tr>
                            <td class="tbl-checkbox">
                              <label class="form-check-label">
                                <input type="checkbox">
                                <span class="form-check-sign"></span>
                              </label>
                            </td>
                            <td class="hidden-xs">
                              <i class="material-icons text-warning">star</i>
                            </td>
                            <td class="hidden-xs">Kerry Mann</td>
                            <td class="max-texts">
                              <a href="#">Lorem ipsum perspiciatis unde omnis iste natus</a>
                            </td>
                            <td class="hidden-xs">
                              <i class="material-icons">attach_file</i>
                            </td>
                            <td class="text-right"> May 11 </td>
                          </tr>
                          <tr>
                            <td class="tbl-checkbox">
                              <label class="form-check-label">
                                <input type="checkbox">
                                <span class="form-check-sign"></span>
                              </label>
                            </td>
                            <td class="hidden-xs">
                              <i class="material-icons">star_border</i>
                            </td>
                            <td class="hidden-xs">Adam Peters</td>
                            <td class="max-texts">
                              <a href="#">
                                <span class="badge badge-info">Office</span>
                                Lorem ipsum perspiciatis unde omnis iste natus</a>
                            </td>
                            <td class="hidden-xs">
                              <i class="material-icons">attach_file</i>
                            </td>
                            <td class="text-right"> May 11 </td>
                          </tr>
                          <tr>
                            <td class="tbl-checkbox">
                              <label class="form-check-label">
                                <input type="checkbox">
                                <span class="form-check-sign"></span>
                              </label>
                            </td>
                            <td class="hidden-xs">
                              <i class="material-icons">star_border</i>
                            </td>
                            <td class="hidden-xs">Lula Reese</td>
                            <td class="max-texts">
                              <a href="#">
                                Lorem ipsum perspiciatis unde omnis iste natus</a>
                            </td>
                            <td class="hidden-xs">
                              <i class="material-icons">attach_file</i>
                            </td>
                            <td class="text-right"> May 11 </td>
                          </tr>
                          <tr>
                            <td class="tbl-checkbox">
                              <label class="form-check-label">
                                <input type="checkbox">
                                <span class="form-check-sign"></span>
                              </label>
                            </td>
                            <td class="hidden-xs">
                              <i class="material-icons">star_border</i>
                            </td>
                            <td class="hidden-xs">Nelson Lane</td>
                            <td class="max-texts">
                              <a href="#">
                                <span class="badge badge-danger">Work</span>
                                Lorem ipsum perspiciatis unde omnis iste natus</a>
                            </td>
                            <td class="hidden-xs">
                              <i class="material-icons">attach_file</i>
                            </td>
                            <td class="text-right"> May 10 </td>
                          </tr>
                          <tr>
                            <td class="tbl-checkbox">
                              <label class="form-check-label">
                                <input type="checkbox">
                                <span class="form-check-sign"></span>
                              </label>
                            </td>
                            <td class="hidden-xs">
                              <i class="material-icons text-warning">star</i>
                            </td>
                            <td class="hidden-xs">Kerry Mann</td>
                            <td class="max-texts">
                              <a href="#">Lorem ipsum perspiciatis unde omnis iste natus</a>
                            </td>
                            <td class="hidden-xs">
                              <i class="material-icons">attach_file</i>
                            </td>
                            <td class="text-right"> May 10 </td>
                          </tr>
                          <tr>
                            <td class="tbl-checkbox">
                              <label class="form-check-label">
                                <input type="checkbox">
                                <span class="form-check-sign"></span>
                              </label>
                            </td>
                            <td class="hidden-xs">
                              <i class="material-icons">star_border</i>
                            </td>
                            <td class="hidden-xs">Adam Peters</td>
                            <td class="max-texts">
                              <a href="#">
                                <span class="badge badge-secondary">Shopping</span>
                                Lorem ipsum perspiciatis unde omnis</a>
                            </td>
                            <td class="hidden-xs">
                              <i class="material-icons">attach_file</i>
                            </td>
                            <td class="text-right"> May 10 </td>
                          </tr>
                          <tr>
                            <td class="tbl-checkbox">
                              <label class="form-check-label">
                                <input type="checkbox">
                                <span class="form-check-sign"></span>
                              </label>
                            </td>
                            <td class="hidden-xs">
                              <i class="material-icons">star_border</i>
                            </td>
                            <td class="hidden-xs">Lula Reese</td>
                            <td class="max-texts">
                              <a href="#">
                                Lorem ipsum perspiciatis unde omnis iste natus</a>
                            </td>
                            <td class="hidden-xs">
                              <i class="material-icons">attach_file</i>
                            </td>
                            <td class="text-right"> May 09 </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                    <div class="row">
                      <div class="col-sm-7 ">
                        <p class="p-15">Showing 1 - 15 of 200</p>
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
  <!-- JS Libraies -->
  <script src="{{ asset('assets-admin/bundles/jquery-ui/jquery-ui.min.js') }}"></script>
  <!-- Page Specific JS File -->
  <script src="{{ asset('assets-admin/js/page/advance-table.js') }}"></script>
  <!-- Template JS File -->
  <script src="{{ asset('assets-admin/js/scripts.js') }}"></script>
  <!-- Custom JS File -->
  <script src="{{ asset('assets-admin-admin/js/custom.js') }}"></script>
</body>


<!-- email-inbox  21 Nov 2019 03:50:58 GMT -->
</html>