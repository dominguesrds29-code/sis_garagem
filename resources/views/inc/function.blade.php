{{-- Functions --}}
@php


    if (!function_exists('setTitle')) :
        function setTitle($page_name) {

            // echo $page_name;
            $admin_name = ' | ' . config('app.name') ;

            switch ($page_name){
                case 'home':
                    echo 'Home' . $admin_name;
					break;

                // Solicitações
                case 'listar_solicitacoes':
                case 'listar_solicitacoes_ass':
                case 'listar_solicitacoes_ass_ch':
                case 'listar_solicitacoes_rp':
                    echo 'Listagem de Solicitações' . $admin_name;
					break;
                case 'cadastrar_solicitacao':
                    echo 'Cadastro de Solicitação' . $admin_name;
					break;
                case 'editar_solicitacao':
                    echo 'Editar Solicitação' . $admin_name;
					break;
                case 'historico_solicitacoes':
                    echo 'Histórico de Solicitações' . $admin_name;
					break;

                // Motoristas
                case 'listar_motoristas':
                    echo 'Listagem de Autorizações' . $admin_name;
					break;
                case 'cadastrar_motorista':
                    echo 'Cadastro de Autorização' . $admin_name;
					break;
                case 'editar_motorista':
                    echo 'Editar Autorização' . $admin_name;
					break;
                case 'historico_motoristas':
                    echo 'Histórico de Autorizações' . $admin_name;
					break;

                // Viaturas
                case 'listar_viaturas':
                    echo 'Listagem de Viaturas' . $admin_name;
					break;
                case 'cadastrar_viatura':
                    echo 'Cadastro de Viatura' . $admin_name;
					break;
                case 'editar_viatura':
                    echo 'Editar Viatura' . $admin_name;
					break;
                case 'historico_viaturas':
                    echo 'Histórico de Viaturas' . $admin_name;
					break;

                // Permissões
                case 'listar_permissons':
                    echo 'Listagem de Permissões' . $admin_name;
					break;
                case 'cadastrar_permisson':
                    echo 'Cadastro de Permissão' . $admin_name;
					break;
                case 'editar_permission':
                    echo 'Editar Permissão' . $admin_name;
					break;

                // Perfis
                case 'listar_roles':
                    echo 'Listagem de Papéis' . $admin_name;
					break;
                case 'cadastrar_role':
                    echo 'Cadastro de Papel' . $admin_name;
					break;
                case 'editar_role':
                    echo 'Editar Papel' . $admin_name;
					break;

                // Usuários
                case 'listar_usuarios':
                    echo 'Listagem de Usuários' . $admin_name;
					break;
                case 'cadastrar_usuario':
                    echo 'Cadastro de Usuário' . $admin_name;
					break;
                case 'editar_usuario':
                    echo 'Editar dados do Usuário' . $admin_name;
					break;
                case 'historico_usuarios':
                    echo 'Histórico de Usuários' . $admin_name;
					break;
                default:
                    echo 'DTCEA-SJ' . $admin_name;
            }
        }
    endif;

    if (!function_exists('set_breadcrumb')) {
        function set_breadcrumb($page_name, $category_name) {

            $category = str_replace(['cao', 'coes', 'ario'], ['ção', 'ções', 'ário'], ucfirst($category_name));

            $removeUnderscore = str_replace('_', ' ', $page_name);

            $removeDash = str_replace('-', ' ', $removeUnderscore);

            $page = str_replace(['cao', 'coes', 'ario'], ['ção', 'ções', 'ário'], ucwords($removeDash));

            switch ($page_name){
                case 'home':
                    echo '<li class="breadcrumb-item active" aria-current="page"><span>' . $page .'</span></li>';
					break;

                // Solicitações
                case 'listar_solicitacoes':
                case 'listar_solicitacoes_ass':
                case 'listar_solicitacoes_ass_ch':
                case 'listar_solicitacoes_rp':
                case 'historico_solicitacoes':
                    echo '<li class="breadcrumb-item active" aria-current="page"><span>' . $page .'</span></li>';
					break;
                case 'cadastrar_solicitacao':
                case 'editar_solicitacao':
					echo '<li class="breadcrumb-item"><a href="'.route('solicitacao.index').'">'. $category .'</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><span>' . $page .'</span></li>';
					break;

                // Motoristas
                case 'listar_motoristas':
                case 'historico_motoristas':
                    echo '<li class="breadcrumb-item active" aria-current="page"><span>' . $page .'</span></li>';
					break;
                case 'cadastrar_motorista':
                case 'editar_motorista':
                    echo '<li class="breadcrumb-item"><a href="'.route('motorista.index').'">'. $category .'</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><span>' . $page .'</span></li>';
					break;

                // Viaturas
                case 'listar_viaturas':
                case 'historico_viaturas':
                    echo '<li class="breadcrumb-item active" aria-current="page"><span>' . $page .'</span></li>';
					break;
                case 'cadastrar_viatura':
                case 'editar_viatura':
                    echo '<li class="breadcrumb-item"><a href="'.route('viatura.index').'">'. $category .'</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><span>' . $page .'</span></li>';
					break;

                // Permissões
                case 'listar_permissons':
                    echo '<li class="breadcrumb-item active" aria-current="page"><span>' . $page .'</span></li>';
					break;
                case 'cadastrar_permisson':
                case 'editar_permission':
                   echo '<li class="breadcrumb-item"><a href="'.route('permission.index').'">'. $category .'</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><span>' . $page .'</span></li>';
					break;

                // Perfis
                case 'listar_roles':
                    echo '<li class="breadcrumb-item active" aria-current="page"><span>' . $page .'</span></li>';
					break;
                case 'cadastrar_role':
                case 'editar_role':
                    echo '<li class="breadcrumb-item"><a href="'.route('role.index').'">'. $category .'</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><span>' . $page .'</span></li>';
					break;

                // Usuários
                case 'listar_usuarios':
                    echo '<li class="breadcrumb-item active" aria-current="page"><span>' . $page .'</span></li>';
					break;
                case 'cadastrar_usuario':
                case 'editar_usuario':
                    echo '<li class="breadcrumb-item"><a href="'.route('user.index').'">'. $category .'</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><span>' . $page .'</span></li>';
					break;
                case 'profile_usuario':
                    echo '<li class="breadcrumb-item"><a href="'.route('home').'">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><span>' . $page .'</span></li>';
					break;

                default:
                    echo '<li class="breadcrumb-item active" aria-current="page"><span>' . $page .'</span></li>';
            }
        }
    }


    // Function to get the client IP address
    function get_client_ip() {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if(isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }

    function scrollspy($offset) {
        echo 'data-target="#navSection" data-spy="scroll" data-offset="'. $offset . '"';
    }

@endphp
