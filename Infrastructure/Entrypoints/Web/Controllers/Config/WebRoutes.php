<?php
declare(strict_types=1);

final class WebRoutes
{
    public static function routes(): array
    {
        return array(
            'home'              => array('method' => 'GET',  'action' => 'home'),
            'users.create'      => array('method' => 'GET',  'action' => 'create'),
            'users.store'       => array('method' => 'POST', 'action' => 'store'),
            'users.index'       => array('method' => 'GET',  'action' => 'index'),
            'users.show'        => array('method' => 'GET',  'action' => 'show'),
            'users.edit'        => array('method' => 'GET',  'action' => 'edit'),
            'users.update'      => array('method' => 'POST', 'action' => 'update'),
            'users.delete'      => array('method' => 'POST', 'action' => 'delete'),
            'movies.index'      => array('method' => 'GET',  'action' => 'movies.index'),
            'movies.create'     => array('method' => 'GET',  'action' => 'movies.create'),
            'movies.store'      => array('method' => 'POST', 'action' => 'movies.store'),
            'movies.show'       => array('method' => 'GET',  'action' => 'movies.show'),
            'movies.edit'       => array('method' => 'GET',  'action' => 'movies.edit'),
            'movies.update'     => array('method' => 'POST', 'action' => 'movies.update'),
            'movies.delete'     => array('method' => 'POST', 'action' => 'movies.delete'),
            'auth.login'        => array('method' => 'GET',  'action' => 'login'),
            'auth.authenticate' => array('method' => 'POST', 'action' => 'authenticate'),
            'auth.logout'       => array('method' => 'GET',  'action' => 'logout'),
            'auth.forgot'       => array('method' => 'GET',  'action' => 'forgot'),
            'auth.forgot.send'  => array('method' => 'POST', 'action' => 'forgot.send'),
            'auth.reset'        => array('method' => 'GET',  'action' => 'auth.reset'),
            'auth.reset.send'   => array('method' => 'POST', 'action' => 'auth.reset.send')
        );
    }
}
