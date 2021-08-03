import CryptoJS from "crypto-js";
import constant from "../constants"

class AppStorage {
    storeToken(token){
        localStorage.setItem('token', token)
    }

    storeUser(user){
        localStorage.setItem('user', user)
    }

    storeAuth(token, user){
        localStorage.setItem('token', token)
        localStorage.setItem('user', JSON.stringify(user))
    }

    clear(){
        localStorage.removeItem('token')
        localStorage.removeItem('user')
    }

    getToken(){
        return localStorage.getItem('token')
    }

    getUser(){
        return JSON.parse(localStorage.getItem('user'))
    }

    getAuth(){
        return  localStorage.getItem('token') , localStorage.getItem('user') 
    }

    storeLogin(email, password){
        let enc_pass = CryptoJS.AES.encrypt(password, constant.ENC_KEY).toString();

        localStorage.setItem('email', email) 
        localStorage.setItem('password', enc_pass)
    }

    clearLogin(){
        localStorage.removeItem('email')
        localStorage.removeItem('password')
    }

    getEmail = () => localStorage.getItem('email')
    
    getPassword(){
        return (CryptoJS.AES.decrypt(localStorage.getItem('password'), constant.ENC_KEY)).toString(CryptoJS.enc.Utf8)
    }

}

export default AppStorage = new AppStorage()