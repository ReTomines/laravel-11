<!--begin::Sidebar-->
<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
        <!--begin::Sidebar Brand-->
        <div class="sidebar-brand">
          <a href="{{ route('home')}}" class="brand-link">
            <img
              src="{{ Vite::asset('resources/images/AdminLTELogo.png') }}"
              alt="AdminLTE Logo"
              class="brand-image opacity-75 shadow"
            />
            <span class="brand-text fw-light">videoWall</span>
          </a>
        </div>
        <!--end::Sidebar Brand-->

        <!--begin::Sidebar Wrapper-->
        <div class="sidebar-wrapper">
          <nav class="mt-2">
            <!--begin::Sidebar Menu-->
            <ul
              class="nav sidebar-menu flex-column"
              data-lte-toggle="treeview"
              role="menu"
              data-accordion="false"
            >
            <li class="nav-header">PAINEL DE CONTROLE</li>
              
              <li class="nav-item">
                <a href="{{ route('videowall.index') }}" class="nav-link">
                  <i class="nav-icon bi bi-card-text "></i>
                  <p>Cadastros</p>
                </a>
              </li>            

              <!-- li class="nav-header">DOCUMENTATIONS
              <li class="nav-item">
                <a href="./docs/layout.html" class="nav-link">
                  <i class="nav-icon bi bi-grip-horizontal"></i>
                  <p>Layout</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./docs/color-mode.html" class="nav-link">
                  <i class="nav-icon bi bi-star-half"></i>
                  <p>Color Mode</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon bi bi-ui-checks-grid"></i>
                  <p>
                    Components
                    <i class="nav-arrow bi bi-chevron-right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="./docs/components/main-header.html" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Main Header</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="./docs/components/main-sidebar.html" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Main Sidebar</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon bi bi-filetype-js"></i>
                  <p>
                    Javascript
                    <i class="nav-arrow bi bi-chevron-right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="./docs/javascript/treeview.html" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Treeview</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="nav-item">
                <a href="./docs/browser-support.html" class="nav-link">
                  <i class="nav-icon bi bi-browser-edge"></i>
                  <p>Browser Support</p>
                </a>
              </li -->

              <br>
              <li class="nav-header">CONFIGURAÇÕES</li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon bi bi-person "></i>
                  <p>Perfil</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{ route('users.index') }}" class="nav-link">
                  <i class="nav-icon bi bi-people "></i>
                  <p>Usuários</p>
                </a>
              </li>

            </ul>
            <!--end::Sidebar Menu-->
          </nav>
        </div>
        <!--end::Sidebar Wrapper-->
      </aside>
      <!--end::Sidebar-->