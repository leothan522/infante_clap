<?php

function sidebar($modulo = null): ?string
{

    if (is_null($modulo)) {
        return null;
    }

    $sidebar = [
        [
            'permiso' => true,
            'url' => public_url('admin'),
            'active' => $modulo == 'dashboard',
            'icono' => '<i class="nav-icon fas fa-home"></i>',
            'titulo' => 'Dashboard',
            'badge' => null,
            'treeview' => []
        ],

        [
            'permiso' => validarPermisos('usuarios.index') || validarPermisos('root'),
            'url' => '#',
            'active' => ($modulo == 'usuarios.index') || ($modulo == 'parametros.index'),
            'icono' => '<i class="nav-icon fas fa-cogs"></i>',
            'titulo' => 'Configuración',
            'badge' => null,
            'treeview' => [
                [
                    'permiso' => validarPermisos('usuarios.index'),
                    'url' => public_url('admin/usuarios'),
                    'active' => $modulo == 'usuarios.index',
                    'icono' => '<i class="fas fa-users-cog nav-icon"></i>',
                    'titulo' => 'Usuarios'
                ],
                [
                    'permiso' => validarPermisos('root'),
                    'url' => public_url('admin/parametros'),
                    'active' => $modulo == 'parametros.index',
                    'icono' => '<i class="fas fa-cog nav-icon"></i>',
                    'titulo' => 'Parametros'
                ]
            ]
        ],


        /*
         * MENU DESPLEGABLE **********************************************************
        [
            'permiso'       => true,
            'url'           => '#',
            'active'        => true,
            'icono'         => '<i class="nav-icon fas fa-tachometer-alt"></i>',
            'titulo'        => 'Starter Pages',
            'badge'         => null,
            'treeview'      => [
                [
                    'permiso'       => true,
                    'url'       => 'index.php',
                    'active'    => true,
                    'icono'     => '<i class="far fa-circle nav-icon"></i>',
                    'titulo'    =>  'Active Page'
                ],
                [
                    'permiso'       => true,
                    'url'       => '#88',
                    'active'    => false,
                    'icono'     => '<i class="far fa-circle nav-icon"></i>',
                    'titulo'    =>  'Inactive Page'
                ]
            ]
        ],
        * LINK SIMPLE **********************************************************
        [
            'url'           => 'prueba.php',
            'active'        => false,
            'icono'         => '<i class="nav-icon fas fa-th"></i>',
            'titulo'        => 'Simple Link',
            'badge'         => '<span class="right badge badge-danger">New</span>',
            'treeview'      => []
        ],
        */
    ];

    $html = '<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">';
    $html .= '
            <!-- Add icons to the links using the .nav-icon class
                 with font-awesome or any other icon font library -->';

    foreach ($sidebar as $menu) {

        if ($menu['active']) {
            $menu_open = 'menu-open';
            $menu_active = 'active';
        } else {
            $menu_active = null;
            $menu_open = null;
        }
        if (!empty($menu['treeview'])) {
            $menu_right_angle = '<i class="right fas fa-angle-left"></i>';
            $menu_badge = null;
            $menu_treeview = '<ul class="nav nav-treeview">';

            foreach ($menu['treeview'] as $item) {

                if ($item['active']) {
                    $item_active = 'active';
                } else {
                    $item_active = null;
                }

                if ($item['permiso']) {

                    $menu_treeview .= '<li class="nav-item">';
                    $menu_treeview .= '<a href="' . $item['url'] . '" class="nav-link ' . $item_active . '">';
                    $menu_treeview .= $item['icono'];
                    $menu_treeview .= '<p>';
                    $menu_treeview .= $item['titulo'];
                    $menu_treeview .= '</p>';
                    $menu_treeview .= '</a>';
                    $menu_treeview .= '</li>';

                }
            }

            $menu_treeview .= '</ul>';
        } else {
            $menu_right_angle = null;
            $menu_badge = $menu['badge'];
            $menu_treeview = null;
        }

        if ($menu['permiso']) {

            $html .= '<li class="nav-item ' . $menu_open . '">';
            $html .= '<a href="' . $menu['url'] . '" class="nav-link ' . $menu_active . '">';
            $html .= $menu['icono'];
            $html .= '<p>';
            $html .= $menu['titulo'];
            $html .= $menu_right_angle;
            $html .= $menu_badge;
            $html .= '</p>';
            $html .= '</a>';
            $html .= $menu_treeview;
            $html .= '</li>';

        }
    }

    $html .= '</ul>';

    return $html;
}

function verPermisos(): array
{

    $permisos = [
        [
            'permiso' => 'usuarios.index',
            'text' => 'Usuarios',
            'opciones' => [
                [
                    'permiso' => 'usuarios.create',
                    'text' => 'Crear Usuarios'
                ],
                [
                    'permiso' => 'usuarios.edit',
                    'text' => 'Editar Usuarios'
                ],
                [
                    'permiso' => 'usuarios.destroy',
                    'text' => 'Borrar Usuarios'
                ]
            ]
        ],

        /*
         * Ejemplo de permiso
         *
         *
        [ 'permiso' => 'usuarios.index',
            'text' => 'Usuarios',
            'opciones' => [
                [
                    'permiso' => 'usuarios.create',
                    'text' => 'Crear Usuarios'
                ],
                [
                    'permiso' => 'usuarios.edit',
                    'text' => 'Editar Usuarios'
                ]
            ]
        ]

        */
    ];

    $array = array();
    $html = null;
    $i = 0;
    foreach ($permisos as $menu) {
        $i++;
        $explode = explode('.', $menu['permiso']);
        $id = $explode[0] . '_' . $explode[1];
        $array[] = $id;
        $html .= '<div class="col-md-4">
                <div class="card card-primary card-outline collapsed-card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <div class="custom-control custom-checkbox">';
        $html .= '<input class="custom-control-input" type="checkbox" name="permiso_' . $i . '" value="' . $menu['permiso'] . '" id="' . $id . '" >';
        $html .= '<label for="' . $id . '" class="custom-control-label">' . $menu['text'] . '</label>';
        $html .= '</div>
                        </h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-plus"></i>
                            </button>
                         </div>
                    </div>';

        $html .= '<div class="card-body">';

        foreach ($menu['opciones'] as $item) {
            $i++;
            $explode = explode('.', $item['permiso']);
            $id = $explode[0] . '_' . $explode[1];
            $array[] = $id;
            $html .= '<div class="form-group">
                    <div class="custom-control custom-checkbox">';
            $html .= '<input class="custom-control-input custom-control-input-primary custom-control-input-outline" 
                            type="checkbox" name="permiso_' . $i . '" value="' . $item['permiso'] . '" id="' . $id . '" >';
            $html .= '<label for="' . $id . '" class="custom-control-label">' . $item['text'] . '</label>';
            $html .= '</div>
                  </div>';
        }

        $html .= '</div>
                  </div>
              </div>';

    }

    $html .= '<input type="hidden" name="contador" placeholder="contador" value="' . $i . '">';

    return [$html, $array];

}
