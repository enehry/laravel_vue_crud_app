import Token from './token'
import AppStorage from './app_storage'

class User {

    // After login store user token and data if is valid

    responseAfterLogin(res){
        const accessToken = res.data.access_token
        const user = res.data.user

        if(Token.isValid(accessToken)){
            AppStorage.storeAuth(accessToken, user)
            console.log('data successfully store')
        }
    }

    // check if token is valid or expired

    hasToken(){
        let storeToken = AppStorage.getToken()
        if(storeToken){
            return Token.isValid(storeToken) ? true : false
        } else {
            return false
        }

    }

    loggedIn(){
        return this.hasToken()
    }

    // get User Data

    userData(){
        if(this.loggedIn()){
            return AppStorage.getUser()
        }
    }

    id(){
        if(this.loggedIn()){
            const payload = Token.payload(AppStorage.getToken())

            return payload.sub
        }

        return false
    }

    logout(){
        if(this.loggedIn){
            AppStorage.clear()

            return true
        }
        
        return false;
    }

   
}

export default User = new User() 