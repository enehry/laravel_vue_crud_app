
<template>
    
</template>
<script>
import axios from 'axios';
import User from '../../helper/user'

export default {
    created(){
        if(User.loggedIn()){
            User.logout();

            Toast.fire({
                icon : 'success',
                title : 'Logout Successfu;;y'
            })

            this.$router.push({ name : 'Login'})
        }
    }
}
</script>
