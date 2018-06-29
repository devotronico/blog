<?php
return [
    'GET' => [
        '' => 'App\Controllers\HomeController@home',
        'home/download' => 'App\Controllers\HomeController@download',
        'blog' => 'App\Controllers\BlogController@getPosts', // 'blog' => 'App\Controllers\PostController@getPosts',
        '#blog/page/:id' => 'App\Controllers\BlogController@getPosts', //  '#blog/page/:id' => 'App\Controllers\PostController@getPosts',
        '#blog/:m/:y' => 'App\Controllers\BlogController@getPostsByDate', //   '#blog/:m/:y' => 'App\Controllers\PostController@getPostsByDate',
        'post/create' => 'App\Controllers\PostController@create', 
        '#post/:id' => 'App\Controllers\PostController@postSingle',
        '#post/:id/edit' => 'App\Controllers\PostController@editPost',
        '#post/:id/delete' => 'App\Controllers\PostController@delete',
        '#comment/:id/delete' => 'App\Controllers\PostController@deleteComment',
        'auth/signin/form' => 'App\Controllers\SigninController@signinForm', 
        'auth/signup/form' => 'App\Controllers\SignupController@signupForm', 
        'auth/signup/verify'=> 'App\Controllers\SignupController@signupVerify', 
        'auth/password/form'=> 'App\Controllers\PasswordController@passwordForm', 
        'auth/password/new'=> 'App\Controllers\PasswordController@passwordNew', 
        'auth/logout' => 'App\Controllers\SigninController@logout', 
        '#profile/:id' => 'App\Controllers\ProfileController@profile',
        '#profile/:id/:usertype' => 'App\Controllers\ProfileController@setUsertype', 
    ],
    'POST' => [
        'home/contact' => 'App\Controllers\HomeController@contact',
        'post/save' => 'App\Controllers\PostController@savePost',
        '#post/:id/update' => 'App\Controllers\PostController@updatePost',
        '#post/:id/comment' => 'App\Controllers\PostController@saveComment',
        'auth/signin/access' => 'App\Controllers\SigninController@signinAccess', 
        'auth/signup/store' => 'App\Controllers\SignupController@signupStore',  
        'auth/password/check' =>'App\Controllers\PasswordController@passwordCheck',
        'auth/password/save' =>'App\Controllers\PasswordController@passwordSave', 
        '#profile/image/:id' =>'App\Controllers\ProfileController@setAvatar',   
    ]
];

