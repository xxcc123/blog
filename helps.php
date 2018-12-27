<?php

if (!function_exists("user_id")){
    /**
     * @return mixed
     */
    function user_id(){
        return auth()->user()->id;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Model|null|static
     */
    function user() {
        if (!session_id()) session_start();
        return \App\Models\User\User::where('email',array_get($_SESSION,'email'))->first();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null|static|static[]
     */
    function admin_user(){
        return \App\Models\User\User::find(user_id());
    }
}

if (!function_exists("SessionName")) {
    /**
     * @return mixed
     */
    function SessionName(){
        if (!session_id()) session_start();
        if (array_get($_SESSION,'name')){
            return $_SESSION['name'];
        }else{
            return '';
        }
    }
}
