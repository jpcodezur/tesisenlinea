<?php
return array(
    'router' => array(
        'routes' => array(
            'admin.rest.steps' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/steps[/:steps_id]',
                    'defaults' => array(
                        'controller' => 'Admin\\V1\\Rest\\Steps\\Controller',
                    ),
                ),
            ),
        ),
    ),
    'db' => array(
        'driver' => 'Pdo',
        'dsn' => 'mysql:dbname=tesisenlinea;host=localhost',
        'username' => 'dbuser',
        'password' => '123',
        'driver_options' => array(
            1002 => 'SET NAMES \'UTF8\'',
        ),
    ),
    'zf-versioning' => array(
        'uri' => array(
            0 => 'admin.rest.steps',
        ),
    ),
    'service_manager' => array(
        'factories' => array(),
    ),
    'zf-rest' => array(
        'Admin\\V1\\Rest\\Steps\\Controller' => array(
            'listener' => 'Admin\\V1\\Rest\\Steps\\StepsResource',
            'route_name' => 'admin.rest.steps',
            'route_identifier_name' => 'steps_id',
            'collection_name' => 'steps',
            'entity_http_methods' => array(
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
                3 => 'DELETE',
            ),
            'collection_http_methods' => array(
                0 => 'GET',
                1 => 'POST',
            ),
            'collection_query_whitelist' => array(),
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => 'Admin\\V1\\Rest\\Steps\\StepsEntity',
            'collection_class' => 'Admin\\V1\\Rest\\Steps\\StepsCollection',
            'service_name' => 'steps',
        ),
    ),
    'zf-content-negotiation' => array(
        'controllers' => array(
            'Admin\\V1\\Rest\\Steps\\Controller' => 'HalJson',
        ),
        'accept_whitelist' => array(
            'Admin\\V1\\Rest\\Steps\\Controller' => array(
                0 => 'application/vnd.admin.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
        ),
        'content_type_whitelist' => array(
            'Admin\\V1\\Rest\\Steps\\Controller' => array(
                0 => 'application/vnd.admin.v1+json',
                1 => 'application/json',
            ),
        ),
    ),
    'zf-hal' => array(
        'metadata_map' => array(
            'Admin\\V1\\Rest\\Steps\\StepsEntity' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'admin.rest.steps',
                'route_identifier_name' => 'steps_id',
                'hydrator' => 'Zend\\Stdlib\\Hydrator\\ArraySerializable',
            ),
            'Admin\\V1\\Rest\\Steps\\StepsCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'admin.rest.steps',
                'route_identifier_name' => 'steps_id',
                'is_collection' => true,
            ),
        ),
    ),
    'zf-apigility' => array(
        'db-connected' => array(
            'Admin\\V1\\Rest\\Steps\\StepsResource' => array(
                'adapter_name' => 'adapter',
                'table_name' => 'steps',
                'hydrator_name' => 'Zend\\Stdlib\\Hydrator\\ArraySerializable',
                'controller_service_name' => 'Admin\\V1\\Rest\\Steps\\Controller',
                'entity_identifier_name' => 'id',
            ),
        ),
    ),
    'zf-content-validation' => array(
        'Admin\\V1\\Rest\\Steps\\Controller' => array(
            'input_filter' => 'Admin\\V1\\Rest\\Steps\\Validator',
        ),
    ),
    'input_filter_specs' => array(
        'Admin\\V1\\Rest\\Steps\\Validator' => array(
            0 => array(
                'name' => 'id',
                'required' => true,
                'filters' => array(),
                'validators' => array(),
                'allow_empty' => false,
                'continue_if_empty' => false,
            ),
            1 => array(
                'name' => 'tite',
                'required' => false,
                'filters' => array(),
                'validators' => array(),
                'allow_empty' => true,
                'continue_if_empty' => true,
            ),
            2 => array(
                'name' => 'order',
                'required' => false,
                'filters' => array(),
                'validators' => array(),
                'allow_empty' => true,
                'continue_if_empty' => true,
            ),
            3 => array(
                'name' => 'display_status',
                'required' => false,
                'filters' => array(),
                'validators' => array(),
                'allow_empty' => true,
                'continue_if_empty' => true,
            ),
        ),
    ),
);
