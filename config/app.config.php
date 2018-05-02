
<?php

return [
    'routes' => [
        'GET' => [
            '' => 'App\Controllers\HomeController@home',
            'blog' => 'App\Controllers\PostController@getPosts',
            'posts' => 'App\Controllers\PostController@getPosts',
            'post/create' => 'App\Controllers\PostController@create',
            'post/:id' => 'App\Controllers\PostController@show',
            'post/:postid/edit' => 'App\Controllers\PostController@edit',
            'auth/signin/form' => 'App\Controllers\AuthController@signinForm', // ok
            'auth/signup/form' => 'App\Controllers\AuthController@signupForm', // ok
            'auth/signup/verify'=> 'App\Controllers\AuthController@signupVerify', // ok
            'auth/password/form'=> 'App\Controllers\AuthController@passwordForm',
            'auth/password/new'=> 'App\Controllers\AuthController@passwordNew',
            'auth/signup/success' => 'App\Controllers\AuthController@signupSuccess',
            'auth/logout' => 'App\Controllers\AuthController@authLogout'
        ],
        'POST' => [
            'post/save' => 'App\Controllers\PostController@save',
            'post/:id/store' => 'App\Controllers\PostController@store',
            'post/:id/delete' => 'App\Controllers\PostController@delete',
            'post/:id/comment' => 'App\Controllers\PostController@saveComment',
            'auth/signin/access' => 'App\Controllers\AuthController@signinAccess',//ok
            'auth/signup/store' => 'App\Controllers\AuthController@signupStore',  // ok  
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
