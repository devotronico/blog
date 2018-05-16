
<?php

return [
    'routes' => [
        'GET' => [
            '' => 'App\Controllers\HomeController@home',
            'blog' => 'App\Controllers\PostController@getPosts',
            'posts' => 'App\Controllers\PostController@getPosts',
            'posts/page/:id' => 'App\Controllers\PostController@getPostsPage',
            'post/create' => 'App\Controllers\PostController@create',
            'post/:id' => 'App\Controllers\PostController@postSingle',
            'post/:id/edit' => 'App\Controllers\PostController@edit',
            'post/:id/delete' => 'App\Controllers\PostController@delete',
            'comment/:id/delete' => 'App\Controllers\PostController@deleteComment',
            'auth/signin/form' => 'App\Controllers\AuthController@signinForm', 
            'auth/signup/form' => 'App\Controllers\AuthController@signupForm', 
            'auth/signup/verify'=> 'App\Controllers\AuthController@signupVerify', 
            'auth/password/form'=> 'App\Controllers\AuthController@passwordForm',
            'auth/password/new'=> 'App\Controllers\AuthController@passwordNew',
            'auth/signup/success' => 'App\Controllers\AuthController@signupSuccess',
            'auth/logout' => 'App\Controllers\AuthController@authLogout',
            'auth/:id/profile' => 'App\Controllers\AuthController@profile',
            
        ],
        'POST' => [
            'post/save' => 'App\Controllers\PostController@savePost',
            'post/update' => 'App\Controllers\PostController@update',
            'post/:id/comment' => 'App\Controllers\PostController@saveComment',
            'auth/signin/access' => 'App\Controllers\AuthController@signinAccess',
            'auth/signup/store' => 'App\Controllers\AuthController@signupStore',   
            'auth/password/check' =>'App\Controllers\AuthController@passwordCheck',
            'auth/password/save' =>'App\Controllers\AuthController@passwordSave' 
        ]
    ]
];



/*
//['routes' => [ 'GET' => [''=>'PostController@getPosts', 'posts'=>'PostController@getPosts', 'post/create'=>'create']]];
//[0[1[2,2,2]]]

array[routes[GET[''][posts][post/create]]]

*/
