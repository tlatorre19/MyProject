<!-- Sidebar -->
      <div class="sidebar" data-background-color="dark">
        <div class="sidebar-logo">
          <!-- Logo Header -->
          <div class="logo-header" data-background-color="dark">
            <a href="{{ route('home') }}" class="logo" style="text-decoration: none; max-width: 150px;">
              <div style="display: flex; align-items: center; gap: 8px;">
                <svg width="26" height="26" viewBox="0 0 38 38" fill="none" xmlns="http://www.w3.org/2000/svg" style="flex-shrink: 0;">
                  <circle cx="15" cy="15" r="11" fill="#111827" stroke="#4f8ef7" stroke-width="2.2"/>
                  <path d="M11.5 15 C11.5 12 15 10.5 15 10.5 C15 10.5 18.5 12 18.5 15 C18.5 17.5 15 19.5 15 19.5 C15 19.5 11.5 17.5 11.5 15Z" fill="#f7617a"/>
                  <line x1="23" y1="23" x2="31" y2="31" stroke="#4f8ef7" stroke-width="2.8" stroke-linecap="round"/>
                  <circle cx="31" cy="31" r="2.5" fill="#4f8ef7"/>
                </svg>
                <div style="line-height: 1.1;">
                  <span style="display: block; font-family: Georgia, serif; font-size: 11px; font-weight: 700; letter-spacing: 0.06em; color: #ffffff; text-transform: uppercase; white-space: nowrap;">Lost &amp; Found</span>
                  <span style="display: block; font-family: Georgia, serif; font-size: 7px; letter-spacing: 0.18em; color: #4f8ef7; text-transform: uppercase; margin-top: 1px; white-space: nowrap;">Recovery System</span>
                </div>
              </div>
            </a>
            <div class="nav-toggle">
              <button class="btn btn-toggle toggle-sidebar">
                <i class="gg-menu-right"></i>
              </button>
              <button class="btn btn-toggle sidenav-toggler">
                <i class="gg-menu-left"></i>
              </button>
            </div>
            <button class="topbar-toggler more">
              <i class="gg-more-vertical-alt"></i>
            </button>
          </div>
          <!-- End Logo Header -->
        </div>
        <div class="sidebar-wrapper scrollbar scrollbar-inner">
          <div class="sidebar-content">
            <ul class="nav nav-secondary">
              <li class="nav-item active">
                <a
                  data-bs-toggle="collapse"
                  href="#dashboard"
                  class="collapsed"
                  aria-expanded="false"
                >
                  <i class="fas fa-home"></i>
                  <p>Dashboard</p>
                  <span class="caret"></span>
                </a>
                <div class="collapse" id="dashboard">
                  <ul class="nav nav-collapse">
                    <li>
                      <a href="{{ route('home') }}">
                        <span class="sub-item">Dashboard 1</span>
                      </a>
                    </li>
                  </ul>
                </div>
              </li>
              <li class="nav-section">
                <span class="sidebar-mini-icon">
                  <i class="fa fa-ellipsis-h"></i>
                </span>
                <h4 class="text-section">Components</h4>
              </li>
              <li class="nav-item">
                <a data-bs-toggle="collapse" href="#forms">
                  <i class="fas fa-pen-square"></i>
                  <p>Forms</p>
                  <span class="caret"></span>
                </a>
                <div class="collapse" id="forms">
                  <ul class="nav nav-collapse">
                    <li>
                      <a href="{{ route('forms') }}">
                        <span class="sub-item">Basic Form</span>
                      </a>
                    </li>
                    <li>
                      <a href="{{ route('category.create') }}">
                        <span class="sub-item">Add Category</span>
                      </a>
                    </li>
                    <li>
                      <a href="{{ route('browse') }}">
                        <span class="sub-item">Browse</span>
                      </a>
                    </li>
                  </ul>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <!-- End Sidebar -->