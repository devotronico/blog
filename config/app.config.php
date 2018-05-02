
<?php

return [
    'routes' => [
        'GET' => [
            '' => 'App\Controllers\PostController@home',
            'blog' => 'App\Controllers\PostController@getPosts',
            'posts' => 'App\Controllers\PostController@getPosts',
            'post/create' => 'App\Controllers\PostController@create',
            'post/:id' => 'App\Controllers\PostController@show',
            'post/:postid/edit' => 'App\Controllers\PostController@edit',
            'auth/signin/form' => 'App\Controllers\PostController@signinForm', // ok
            'auth/signup/form' => 'App\Controllers\PostController@signupForm', // ok
            'auth/signup/verify'=> 'App\Controllers\PostController@signupVerify', // ok
            'auth/password/form'=> 'App\Controllers\PostController@passwordForm',
            'auth/password/new'=> 'App\Controllers\PostController@passwordNew',
            'auth/signup/success' => 'App\Controllers\PostController@signupSuccess',
            'auth/logout' => 'App\Controllers\PostController@authLogout'
        ],
        'POST' => [
            'post/save' => 'App\Controllers\PostController@save',
            'post/:id/store' => 'App\Controllers\PostController@store',
            'post/:id/delete' => 'App\Controllers\PostController@delete',
            'post/:id/comment' => 'App\Controllers\PostController@saveComment',
            'auth/signin/access' => 'App\Controllers\PostController@signinAccess',//ok
            'auth/signup/store' => 'App\Controllers\PostController@signupStore',  // ok  
            'auth/password/check' =>'App\Controllers\PostController@passwordCheck',
            'auth/password/save' =>'App\Controllers\PostController@passwordSave' 
        ]
    ]
];


/*
//['routes' => [ 'GET' => [''=>'PostController@getPosts', 'posts'=>'PostController@getPosts', 'post/create'=>'create']]];
//[0[1[2,2,2]]]

array[routes[GET[''][posts][post/create]]]

*/
