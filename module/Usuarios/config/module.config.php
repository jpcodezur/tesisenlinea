<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'Usuarios\Controller\Index' => 'Usuarios\Controller\IndexController',
            'Usuarios\Controller\Usuario' => 'Usuarios\Controller\UsuarioController',
            'Usuarios\Controller\Login' => 'Usuarios\Controller\LoginController',
            'Usuarios\Controller\Alerta' => 'Usuarios\Controller\AlertaController',
            'Usuarios\Controller\Mensaje' => 'Usuarios\Controller\MensajeController',
            'Usuarios\Controller\Pagina' => 'Usuarios\Controller\PaginaController',
            'Usuarios\Controller\Grupo' => 'Usuarios\Controller\GrupoController',
            'Usuarios\Controller\Pregunta' => 'Usuarios\Controller\PreguntaController',
            'Usuarios\Controller\Formulario' => 'Usuarios\Controller\FormularioController',
        ),
    ),
    'db' => array(
        'driver'         =>'Pdo',
        'dsn'            =>'mysql:dbname=tesis_en_linea;host=localhost',
        'username' => 'root',
        'password' => '',
        'driver_options' => array(
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
        ),
    ),
    'navigation' => array(
         'default' => array(
             array(
                 'label' => 'Index',
                 'route' => 'usuarios',
                 'pages' => array(
                     'Users' => array(
                         'label' => 'Users',
                         'route' => 'usuarios',
                         'controller'=>'usuario',
                         'action' => 'index',
                         'pages' => array(
                            'list' => array(
                                'label' => 'List',
                                'route' => 'usuarios',
                                'controller'=>'usuario',
                                'action' => 'list'
                            ),
                            'add' => array(
                                'label' => 'Add',
                                'route' => 'usuarios',
                                'controller'=>'usuario',
                                'action' => 'add'
                            )
                        ),
                     ),
                 ),
            ),
         ),
        'agent' => array(
             array(
                 'label' => 'Index',
                 'route' => 'usuarios',
                 'pages' => array(
                     'Users' => array(
                         'label' => 'Users',
                         'route' => 'usuarios',
                         'controller'=>'index',
                         'action' => 'index'
                     ),
                     'Evaluations' => array(
                         'label' => 'Evaluations',
                         'route' => 'usuarios',
                         'controller'=>'evaluacion',
                         'action' => 'list',
                         'pages' => array(
                            'list' => array(
                                'label' => 'List',
                                'route' => 'usuarios',
                                'controller'=>'evaluacion',
                                'action' => 'list'
                            ),
                        ),
                     ),
                     
                 ),
            ),
         ),
     ),
    'service_manager'=>array(
        'factories' => array(
            'Zend\Db\Adapter\Adapter' => 'Zend\Db\Adapter\AdapterServiceFactory',
            'navigation' => 'Zend\Navigation\Service\DefaultNavigationFactory',
        )
    ),
    'router' => array(
        'routes' => array(
            'usuarios' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/usuarios[/:controller[/:action[/:id]]]',
                    'constraints' => array(
                        'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                         'id' => '[0-9]+'
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'Usuarios\Controller',
                        'controller' => 'Usuarios\Controller\Index',
                        'action' => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/[:controller[/:action[/:id]]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]+'
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'Usuarios' => __DIR__ . '/../view',
        ),
        'strategies' => array(
            'ViewJsonStrategy',
        ),
    ),
);
