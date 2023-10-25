<?php

if (! function_exists("userLink")){
        /**
     * redirect route to user page profile
     *
     * @param $data
     * @return string
     */
    function userLink($data)
    {
        return "<a class='info-color' href='" . route("users.show", $data->user->id) . "'>{$data->user->name()}</a>";
    }
}
