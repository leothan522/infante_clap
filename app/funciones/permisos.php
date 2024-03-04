<?php

function permisos(): array
{
    return $permisos = [
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
                    'permiso' => 'usuarios.estatus',
                    'text' => 'Cambiar Estatus'
                ],
                [
                    'permiso' => 'usuarios.reset',
                    'text' => 'Reset Password'
                ],
                [
                    'permiso' => 'usuarios.destroy',
                    'text' => 'Borrar Usuarios'
                ]
            ]
        ],
        [
            'permiso' => 'territorio.index',
            'text' => 'Territorio',
            'opciones' => [
                [
                    'permiso' => 'municipios.create',
                    'text' => 'Crear Municipios'
                ],
                [
                    'permiso' => 'municipios.edit',
                    'text' => 'Editar Municipios'
                ],
                [
                    'permiso' => 'municipios.destroy',
                    'text' => 'Borrar Municipios'
                ],
                [
                    'permiso' => 'municipios.estatus',
                    'text' => 'Estatus Municipios'
                ],
                [
                    'permiso' => 'parroquias.create',
                    'text' => 'Crear Parroquias'
                ],
                [
                    'permiso' => 'parroquias.edit',
                    'text' => 'Editar Parroquias'
                ],
                [
                    'permiso' => 'parroquias.destroy',
                    'text' => 'Borrar Parroquias'
                ],
                [
                    'permiso' => 'parroquias.estatus',
                    'text' => 'Estatus Parroquias'
                ]
            ]
        ],

        [ 'permiso' => 'claps.index',
            'text' => 'Distribución',
            'opciones' => [
                [
                    'permiso' => 'claps.create',
                    'text' => 'Crear Claps'
                ],
                [
                    'permiso' => 'jefes.edit',
                    'text' => 'Editar Jefes'
                ],
                [
                    'permiso' => 'claps.edit',
                    'text' => 'Editar Claps'
                ],
                [
                    'permiso' => 'claps.destroy',
                    'text' => 'Eliminar Claps'
                ]
            ]
        ],
        [ 'permiso' => 'bloques.index',
            'text' => 'Bloques',
            'opciones' => [
                [
                    'permiso' => 'bloques.create',
                    'text' => 'Crear Bloques'
                ],
                [
                    'permiso' => 'bloques.destroy',
                    'text' => 'Eliminar Bloques'
                ]
            ]
        ],
        [ 'permiso' => 'entes.index',
            'text' => 'Entes',
            'opciones' => [
                [
                    'permiso' => 'entes.create',
                    'text' => 'Crear Entes'
                ],
                [
                    'permiso' => 'entes.destroy',
                    'text' => 'Eliminar Entes'
                ]
            ]
        ],
        [ 'permiso' => 'pagos.index',
            'text' => 'Validacion Pagos',
            'opciones' => [
                /*[
                    'permiso' => 'pagos.create',
                    'text' => 'Crear '
                ]*/
            ]
        ]

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
}