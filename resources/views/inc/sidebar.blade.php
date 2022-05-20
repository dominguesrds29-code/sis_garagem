@if ($page_name != 'error404' && $page_name != 'error500' && $page_name != 'error503' && $page_name != 'maintenence')
    <!--  BEGIN SIDEBAR  -->
    <div class="sidebar-wrapper sidebar-theme">

        <nav id="sidebar">
            <div class="shadow-bottom"></div>

            <ul class="list-unstyled menu-categories" id="accordionVaturas">

                <li class="menu {{ ($category_name === 'home') ? 'active' : '' }}">
                    <a href="{{ route('home') }}" aria-expanded="{{ ($category_name === 'home') ? 'true' : 'false' }}" class="dropdown-toggle">
                        <div class="">
                            <i data-feather="home"></i>                            
                            <span> Home </span>
                        </div>
                    </a>
                </li>

                <li class="menu {{ ($category_name === 'viaturas') ? 'active' : '' }}">
                    <a href="#viatura" data-toggle="collapse" aria-expanded="{{ ($category_name === 'viatura') ? 'true' : 'false' }}" class="dropdown-toggle">
                        <div class="">
                            <i data-feather="truck"></i>
                            <span>Viaturas</span>
                        </div>
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                        </div>
                    </a>
                    <ul class="collapse submenu list-unstyled {{ ($category_name === 'viatura') ? 'show' : '' }}" id="viatura" data-parent="#accordionVaturas">
                        <li class="{{ ($page_name === 'solicitar_viatura') ? 'active' : '' }}">
                            <a href="{{ route('solicitar.viatura') }}"> Solicitar Viatura </a>
                        </li>
                        <li class="{{ ($page_name === 'listar_viaturas') ? 'active' : '' }}">
                            <a href="{{ route('viatura.index') }}"> Listar Viaturas </a>
                        </li>
                        <li class="{{ ($page_name === 'cadastrar_viatura') ? 'active' : '' }}">
                            <a href="{{ route('viatura.create') }}"> Cadastrar Viaturas </a>
                        </li>
                    </ul>
                </li>

            </ul>

        </nav>

    </div>
    <!--  END SIDEBAR  -->
@endif
