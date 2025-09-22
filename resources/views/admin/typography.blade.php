<!DOCTYPE html>
<html lang="en">


<!-- typography.html  21 Nov 2019 03:54:24 GMT -->
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Otika - Admin Dashboard Template</title>
  <!-- General CSS Files -->
  <link rel="stylesheet" href="{{ asset('assets-admin/css/app.min.css') }}">
  <link rel="stylesheet" href="assets/bundles/prism/prism.css">
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
                    <h4>Text</h4>
                  </div>
                  <div class="card-body">
                    <h1>Heading 1</h1>
                    <h2>Heading 2</h2>
                    <h3>Heading 3</h3>
                    <h4>Heading 4</h4>
                    <h5>Heading 5</h5>
                    <h6>Heading 6</h6>
                    <h3 class="mt-4">
                      Fancy display heading
                      <small class="text-muted">With faded secondary text</small>
                    </h3>
                    <p class="lead mt-4">
                      Lead &mdash; Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor. Duis mollis,
                      est non commodo luctus.
                    </p>
                    <p class="mt-4 mb-4">Paragraph &mdash; Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed
                      do eiusmod
                      tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p>
                    <a href="#">You can click me!</a>
                  </div>
                </div>
                <div class="card">
                  <div class="card-header">
                    <h4>Text Colors</h4>
                  </div>
                  <div class="card-body">
                    <div class="text-primary mb-2">Text Primary</div>
                    <div class="text-secondary mb-2">Text Secondary</div>
                    <div class="text-success mb-2">Text Success</div>
                    <div class="text-info mb-2">Text Info</div>
                    <div class="text-warning mb-2">Text Warning</div>
                    <div class="text-light mb-2">Text Light</div>
                    <div class="text-dark mb-2">Text Dark</div>
                  </div>
                </div>
                <div class="card">
                  <div class="card-header">
                    <h4>Inline Text Element</h4>
                  </div>
                  <div class="card-body">
                    <p>You can use the mark tag to <mark>highlight</mark> text.</p>
                    <p><del>This line of text is meant to be treated as deleted text.</del></p>
                    <p><s>This line of text is meant to be treated as no longer accurate.</s></p>
                    <p><ins>This line of text is meant to be treated as an addition to the document.</ins></p>
                    <p><u>This line of text will render as underlined</u></p>
                    <p><small>This line of text is meant to be treated as fine print.</small></p>
                    <p><strong>This line rendered as bold text.</strong></p>
                    <p><em>This line rendered as italicized text.</em></p>
                  </div>
                </div>
                <div class="card">
                  <div class="card-header">
                    <h4>Abbreviations</h4>
                  </div>
                  <div class="card-body">
                    <p><abbr title="attribute">attr</abbr></p>
                    <p><abbr title="HyperText Markup Language" class="initialism">HTML</abbr></p>
                  </div>
                </div>
              </div>
              <div class="col-12 col-md-6 col-lg-6">
                <div class="card">
                  <div class="card-header">
                    <h4>Color</h4>
                  </div>
                  <div class="card-body">
                    <div class="colors">
                      <div class="color bg-primary text-white">
                        <div>Primary</div>
                      </div>
                      <div class="color bg-secondary text-white">
                        <div>Secondary</div>
                      </div>
                      <div class="color bg-success text-white">
                        <div>Success</div>
                      </div>
                      <div class="color bg-info text-white">
                        <div>Info</div>
                      </div>
                      <div class="color bg-warning text-white">
                        <div>Warning</div>
                      </div>
                      <div class="color bg-danger text-white">
                        <div>Danger</div>
                      </div>
                      <div class="color bg-light">
                        <div>Light</div>
                      </div>
                      <div class="color bg-dark text-white">
                        <div>Dark</div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card">
                  <div class="card-header">
                    <h4>Text Block</h4>
                  </div>
                  <div class="card-body">
                    <div class="section-title mt-0">Blockquote</div>
                    <blockquote>
                      Otika made with hand
                    </blockquote>
                    <div class="section-title">Inline Code</div>
                    <p>Lorem ipsum dolor sit amet, <code>consectetur</code> adipisicing elit, sed do eiusmod
                      tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                      quis nostrud <code>exercitation</code> ullamco laboris nisi ut aliquip ex ea commodo
                      consequat.</p>
                    <div class="section-title">Code Block</div>
                    <p>We use PrismJS to do this, you can adjust themes, syntax and more. <a
                        href="http://prismjs.com/">Visit their documentation</a>.</p>
                    <pre class="language-javascript"><code>var code = 'Hello';</code></pre>
                  </div>
                </div>
                <div class="card">
                  <div class="card-header">
                    <h4>Display</h4>
                  </div>
                  <div class="card-body">
                    <div class="display-1">Display 1</div>
                    <hr>
                    <div class="display-2">Display 2</div>
                    <hr>
                    <div class="display-3">Display 3</div>
                    <hr>
                    <div class="display-4">Display 4</div>
                  </div>
                </div>
                <div class="card">
                  <div class="card-header">
                    <h4>Naming a Source</h4>
                  </div>
                  <div class="card-body">
                    <blockquote class="blockquote">
                      <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a
                        ante.</p>
                      <footer class="blockquote-footer">Someone famous in <cite title="Source Title">Source Title</cite>
                      </footer>
                    </blockquote>
                  </div>
                </div>
              </div>
            </div>
            <h2 class="section-title">List</h2>
            <div class="row">
              <div class="col-12 col-md-6 col-lg-6">
                <div class="card">
                  <div class="card-header">
                    <h4>Unordered List</h4>
                  </div>
                  <div class="card-body">
                    <p>Sunt in culpa qui officia deserunt mollit anim id est laborum:</p>
                    <ul>
                      <li>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod</li>
                      <li>tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,</li>
                      <li>quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo</li>
                      <li>consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse</li>
                      <li>cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non</li>
                      <li>proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</li>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="col-12 col-md-6 col-lg-6">
                <div class="card">
                  <div class="card-header">
                    <h4>Ordered List</h4>
                  </div>
                  <div class="card-body">
                    <p>Sunt in culpa qui officia deserunt mollit anim id est laborum:</p>
                    <ol>
                      <li>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod</li>
                      <li>tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,</li>
                      <li>quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo</li>
                      <li>consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse</li>
                      <li>cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non</li>
                      <li>proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</li>
                      <li>consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse</li>
                    </ol>
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


<!-- typography.html  21 Nov 2019 03:54:26 GMT -->
</html>