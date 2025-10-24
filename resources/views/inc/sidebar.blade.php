@if ($page_name != 'error404' && $page_name != 'error500' && $page_name != 'error503' && $page_name != 'maintenence')
    <!--  BEGIN SIDEBAR  -->
    <div class="sidebar-wrapper sidebar-theme">

        <nav id="sidebar">
            <div class="shadow-bottom"></div>

            <ul class="list-unstyled menu-categories" id="accordionMenu">

                <li class="menu {{ ($category_name === 'home') ? 'active' : '' }}">
                    <a href="{{ route('home') }}" aria-expanded="{{ ($category_name === 'home') ? 'true' : 'false' }}"
                       class="dropdown-toggle">
                        <div class="">
                            <i data-feather="home"></i>
                            <span> Home </span>
                        </div>
                    </a>
                </li>
                @can('request-manage')
                    <li class="menu {{ ($category_name === 'solicitacoes') ? 'active' : '' }}">
                        <a href="#solicitacao" data-toggle="collapse"
                           aria-expanded="{{ ($category_name === 'solicitacoes') ? 'true' : 'false' }}"
                           class="dropdown-toggle">
                            <div class="">
                                <i data-feather="calendar"></i>
                                <span>Solicitações</span>
                            </div>
                            <div>
                                <i data-feather="chevron-right"></i>
                            </div>
                        </a>
                        <ul class="collapse submenu list-unstyled {{ ($category_name === 'solicitacoes') ? 'show' : '' }}"
                            id="solicitacao" data-parent="#accordionMenu">
                            @can('request-create')
                                <li class="{{ ($page_name === 'cadastrar_solicitacao') ? 'active' : '' }}">
                                    <a href="{{ route('solicitacao.create') }}"> Solicitar Viatura </a>
                                </li>
                            @endcan
                            @can('request-list-pending')
                                <li class="{{ ($page_name === 'listar_solicitacoes') ? 'active' : '' }}">
                                    <a href="{{ route('solicitacao.index') }}"> Pendentes </a>
                                </li>
                            @endcan
                            @can('request-list-preapproved')
                                <li class="{{ ($page_name === 'listar_solicitacoes_ass') ? 'active' : '' }}">
                                    <a href="{{ route('solicitacao.preauthorized') }}"> Autorizadas Enc. </a>
                                </li>
                            @endcan
                            @can('request-list-approved')
                                <li class="{{ ($page_name === 'listar_solicitacoes_ass_ch') ? 'active' : '' }}">
                                    <a href="{{ route('solicitacao.authorized') }}"> Autorizadas Chefe </a>
                                </li>
                            @endcan
                            @can('request-list-reproved')
                                <li class="{{ ($page_name === 'listar_solicitacoes_rp') ? 'active' : '' }}">
                                    <a href="{{ route('solicitacao.reproved') }}"> Reprovadas </a>
                                </li>
                            @endcan
                            @can('request-list-archived')
                                <li class="{{ ($page_name === 'historico_solicitacoes') ? 'active' : '' }}">
                                    <a href="{{ route('solicitacao.history') }}"> Arquivadas </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('viatura-manage')
                    <li class="menu {{ ($category_name === 'viaturas') ? 'active' : '' }}">
                        <a href="#viatura" data-toggle="collapse"
                           aria-expanded="{{ ($category_name === 'viatura') ? 'true' : 'false' }}"
                           class="dropdown-toggle">
                            <div class="">
                                <i data-feather="truck"></i>
                                <span>Viaturas</span>
                            </div>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                     stroke-linejoin="round" class="feather feather-chevron-right">
                                    <polyline points="9 18 15 12 9 6"></polyline>
                                </svg>
                            </div>
                        </a>
                        <ul class="collapse submenu list-unstyled {{ ($category_name === 'viatura') ? 'show' : '' }}"
                            id="viatura" data-parent="#accordionMenu">
                            @can('viatura-create')
                                <li class="{{ ($page_name === 'cadastrar_viatura') ? 'active' : '' }}">
                                    <a href="{{ route('viatura.create') }}"> Cadastrar Viaturas </a>
                                </li>
                            @endcan
                            @can('viatura-list-active')
                                <li class="{{ ($page_name === 'listar_viaturas') ? 'active' : '' }}">
                                    <a href="{{ route('viatura.index') }}"> Listar Viaturas </a>
                                </li>
                            @endcan
                            @can('viatura-list-desactive')
                                <li class="{{ ($page_name === 'historico_viatura') ? 'active' : '' }}">
                                    <a href="{{ route('viatura.history') }}"> Histórico </a>
                                </li>

                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('saidaviatura-manage')
                    <li class="menu {{ ($category_name === 'saida_viaturas') ? 'active' : '' }}">
                        <a href="#saidaviatura" data-toggle="collapse"
                           aria-expanded="{{ ($category_name === 'saida_viatura') ? 'true' : 'false' }}"
                           class="dropdown-toggle">
                            <div class="">
                                <i data-feather="truck"></i>
                                <span>Saída de Viaturas</span>
                            </div>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                     stroke-linejoin="round" class="feather feather-chevron-right">
                                    <polyline points="9 18 15 12 9 6"></polyline>
                                </svg>
                            </div>
                        </a>
                        <ul class="collapse submenu list-unstyled {{ ($category_name === 'saida_viatura') ? 'show' : '' }}"
                            id="saidaviatura" data-parent="#accordionMenu">
                            @can('viatura-create')
                                <li class="{{ ($page_name === 'cadastrar_saidaviatura') ? 'active' : '' }}">
                                    <a href="{{ route('saidaviatura.create') }}"> Registrar Saída </a>
                                </li>
                            @endcan
                            @can('saidaviatura-list-active')
                                <li class="{{ ($page_name === 'listar_saidaviaturas') ? 'active' : '' }}">
                                    <a href="{{ route('saidaviatura.index') }}"> Listar Saídas </a>
                                </li>
                            @endcan
                            @can('saidaviatura-list-complete')
                                <li class="{{ ($page_name === 'historico_saidaviatura') ? 'active' : '' }}">
                                    <a href="{{ route('saidaviatura.history') }}"> Histórico </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('driver-manage')
                    <li class="menu {{ ($category_name === 'motoristas') ? 'active' : '' }}">
                        <a href="#motorista" data-toggle="collapse"
                           aria-expanded="{{ ($category_name === 'motoristas') ? 'true' : 'false' }}"
                           class="dropdown-toggle">
                            <div class="">
                                <i data-feather="user-check"></i>
                                <span>Motoristas</span>
                            </div>
                            <div>
                                <i data-feather="chevron-right"></i>
                            </div>
                        </a>
                        <ul class="collapse submenu list-unstyled {{ ($category_name === 'motoristas') ? 'show' : '' }}"
                            id="motorista" data-parent="#accordionMenu">
                            @can('driver-create')
                                <li class="{{ ($page_name === 'cadastrar_motorista') ? 'active' : '' }}">
                                    <a href="{{ route('motorista.create') }}"> Cad. Autorização </a>
                                </li>
                            @endcan
                            @can('driver-list-active')
                                <li class="{{ ($page_name === 'listar_motoristas') ? 'active' : '' }}">
                                    <a href="{{ route('motorista.index') }}"> Listar Autorizações </a>
                                </li>
                            @endcan
                            @can('driver-list-desactive')
                                <li class="{{ ($page_name === 'historico_motorista') ? 'active' : '' }}">
                                    <a href="{{ route('motorista.history') }}"> Histórico </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('user-manage')
                    <li class="menu {{ ($category_name === 'usuarios') ? 'active' : '' }}">
                        <a href="#user" data-toggle="collapse"
                           aria-expanded="{{ ($category_name === 'usuarios') ? 'true' : 'false' }}"
                           class="dropdown-toggle">
                            <div class="">
                                <i data-feather="users"></i>
                                <span>Usuários</span>
                            </div>
                            <div>
                                <i data-feather="chevron-right"></i>
                            </div>
                        </a>
                        <ul class="collapse submenu list-unstyled {{ ($category_name === 'usuarios') ? 'show' : '' }}"
                            id="user" data-parent="#accordionMenu">
                            @can('user-create')
                                <li class="{{ ($page_name === 'cadastrar_usuario') ? 'active' : '' }}">
                                    <a href="{{ route('user.create') }}"> Cad. Usuários </a>
                                </li>
                            @endcan
                            @can('user-list')
                                <li class="{{ ($page_name === 'listar_usuarios') ? 'active' : '' }}">
                                    <a href="{{ route('user.index') }}"> Listar Usuários </a>
                                </li>
                                <li class="{{ ($page_name === 'historico_usuario') ? 'active' : '' }}">
                                    <a href="{{ route('user.history') }}"> Histórico </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('admin-acl-show')
                    <li class="menu {{ (in_array($category_name, ['permissions', 'roles'])) ? 'active' : '' }}">
                        <a href="#acl" data-toggle="collapse"
                           aria-expanded="{{ (in_array($category_name, ['permissions', 'roles'])) ? 'true' : 'false' }}"
                           class="dropdown-toggle">
                            <div class="">
                                <i data-feather="lock"></i>
                                <span>ACL</span>
                            </div>
                            <div>
                                <i data-feather="chevron-right"></i>
                            </div>
                        </a>
                        <ul class="collapse submenu list-unstyled {{ (in_array($category_name, ['permissions', 'roles'])) ? 'show' : '' }}"
                            id="acl" data-parent="#accordionMenu">
                            @can('permission-manage')
                                <li class="{{ ($category_name === 'permissions') ? 'active' : '' }}">
                                    <a href="#permission" data-toggle="collapse"
                                       aria-expanded="{{ ($category_name === 'permissions') ? 'true' : 'false' }}"
                                       class="dropdown-toggle">
                                        Permissões
                                        <div>
                                            <i data-feather="chevron-right"></i>
                                        </div>
                                    </a>
                                    <ul class="collapse sub-submenu list-unstyled {{ ($category_name === 'permissions') ? 'show' : '' }}"
                                        id="permission" data-parent="#acl">
                                        @can('permission-create')
                                            <li class="{{ ($page_name === 'cadastrar_permission') ? 'active' : '' }}">
                                                <a href="{{ route('permission.create') }}"> Cadastrar Permissão </a>
                                            </li>
                                        @endcan
                                        @can('permission-list')
                                            <li class="{{ ($page_name === 'listar_permissions') ? 'active' : '' }}">
                                                <a href="{{ route('permission.index') }}"> Listar Permissões </a>
                                            </li>
                                        @endcan
                                    </ul>
                                </li>
                            @endcan
                            @can('role-manage')
                                <li class="{{ ($category_name === 'roles') ? 'active' : '' }}">
                                    <a href="#roles" data-toggle="collapse"
                                       aria-expanded="{{ ($category_name === 'roles') ? 'true' : 'false' }}"
                                       class="dropdown-toggle">
                                        Perfis
                                        <div>
                                            <i data-feather="chevron-right"></i>
                                        </div>
                                    </a>
                                    <ul class="collapse sub-submenu list-unstyled {{ ($category_name === 'roles') ? 'show' : '' }}"
                                        id="roles" data-parent="#acl">
                                        @can('role-create')
                                            <li class="{{ ($page_name === 'cadastrar_role') ? 'active' : '' }}">
                                                <a href="{{ route('role.create') }}"> Cadastrar Perfil </a>
                                            </li>
                                        @endcan
                                        @can('role-list')
                                            <li class="{{ ($page_name === 'listar_roles') ? 'active' : '' }}">
                                                <a href="{{ route('role.index') }}"> Listar Perfis </a>
                                            </li>
                                        @endcan
                                    </ul>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
            </ul>
        </nav>
    </div>
    <!--  END SIDEBAR  -->
@endif
