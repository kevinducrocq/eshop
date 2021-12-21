<?php

function isLoggedIn()
{
    if (isset($_SESSION['user_id'])) {
        return true;
    } else {
        return false;
    }
}

function isAdmin()
{
    if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 1) {
        return true;
    } else {
        return false;
    }
}
