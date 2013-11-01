<?php
 return array(
     'controllers' => array(
         'invokables' => array(
             'Site\Controller\Site' => 'Site\Controller\SiteController',
         ),
     ),
     
      // The following section is new and should be added to your file
     'router' => array(
         'routes' => array(
             'site' => array(
                 'type'    => 'segment',
                 'options' => array(
                     'route'    => '/site[/][:action][/:id]',
                     'constraints' => array(
                         'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                         'id'     => '[0-9]+',
                     ),
                     'defaults' => array(
                         'controller' => 'Site\Controller\Site',
                         'action'     => 'index',
                     ),
                 ),
             ),
         ),
     ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'site/site/index' => __DIR__ . '/../view/site/site/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),

 );