<?php
return [
    'routes' => [
        'GET' => [
            '' => 'App\Controllers\HomeController@home',
            'home/download' => 'App\Controllers\HomeController@download',
            'blog' => 'App\Controllers\PostController@getPosts',
            'posts' => 'App\Controllers\PostController@getPosts',
            'posts/page/:id' => 'App\Controllers\PostController@getPosts',
            'post/create' => 'App\Controllers\PostController@create', 
            'post/:id' => 'App\Controllers\PostController@postSingle',
            'post/:id/edit' => 'App\Controllers\PostController@editPost',
            'post/:id/delete' => 'App\Controllers\PostController@delete',
            'comment/:id/delete' => 'App\Controllers\PostController@deleteComment',
            'auth/signin/form' => 'App\Controllers\SigninController@signinForm', // 'auth/signin/form' => 'App\Controllers\AuthController@signinForm',
            'auth/signup/form' => 'App\Controllers\SignupController@signupForm', //  'auth/signup/form' => 'App\Controllers\AuthController@signupForm', 
            'auth/signup/verify'=> 'App\Controllers\SignupController@signupVerify', // 'auth/signup/verify'=> 'App\Controllers\AuthController@signupVerify',
            'auth/password/form'=> 'App\Controllers\PasswordController@passwordForm', // 'auth/password/form'=> 'App\Controllers\AuthController@passwordForm',
            'auth/password/new'=> 'App\Controllers\PasswordController@passwordNew', // 'auth/password/new'=> 'App\Controllers\AuthController@passwordNew',
            'auth/signup/success' => 'App\Controllers\AuthController@signupSuccess',
            'auth/logout' => 'App\Controllers\SigninController@logout', // 'auth/logout' => 'App\Controllers\AuthController@logout',
            'auth/:id/profile' => 'App\Controllers\ProfileController@profile', // 'auth/:id/profile' => 'App\Controllers\AuthController@profile',
            'auth/:id/administrator' => 'App\Controllers\ProfileController@setAdministrator', //  'auth/:id/administrator' => 'App\Controllers\AuthController@setAdministrator',
            'auth/:id/contributor' => 'App\Controllers\ProfileController@setContributor',//   'auth/:id/contributor' => 'App\Controllers\AuthController@setContributor',
            'auth/:id/reader' => 'App\Controllers\ProfileController@setReader', //  'auth/:id/reader' => 'App\Controllers\AuthController@setReader',
            'auth/:id/banned' => 'App\Controllers\ProfileController@setBanned',
        ],
        'POST' => [
            'home/contact' => 'App\Controllers\HomeController@contact',
            'post/save' => 'App\Controllers\PostController@savePost',
            'post/:id/update' => 'App\Controllers\PostController@updatePost',
            'post/:id/comment' => 'App\Controllers\PostController@saveComment',
            'auth/signin/access' => 'App\Controllers\SigninController@signinAccess', // 'auth/signin/access' => 'App\Controllers\AuthController@signinAccess',
            'auth/signup/store' => 'App\Controllers\SignupController@signupStore',  // 'auth/signup/store' => 'App\Controllers\AuthController@signupStore', 
            'auth/password/check' =>'App\Controllers\PasswordController@passwordCheck', //  'auth/password/check' =>'App\Controllers\AuthController@passwordCheck',
            'auth/password/save' =>'App\Controllers\PasswordController@passwordSave', // 'auth/password/save' =>'App\Controllers\AuthController@passwordSave',
            'auth/:id/image' =>'App\Controllers\ProfileController@setAvatar',  // 'auth/:id/image' =>'App\Controllers\AuthController@setAvatar',  
        ]
    ]
];



/*
//['routes' => [ 'GET' => [''=>'PostController@getPosts', 'posts'=>'PostController@getPosts', 'post/create'=>'create']]];
//[0[1[2,2,2]]]

array[routes[GET[''][posts][post/create]]]

*/
