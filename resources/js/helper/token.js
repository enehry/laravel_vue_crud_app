import constant from '../constants.js'

class Token {

    isValid(token){
        const payload = this.payload(token)
        if(payload){
            return payload.iss = `${constant.API_URL}auth/login` ||  `${constant.API_URL}auth/register` ? true : false
        }

        return false;
    }

    payload(token){
        const payload = token.split('.')[1]
        return this.decode(payload)
    }

    decode(payload){
        return JSON.parse(Buffer.from(payload, 'base64'))
    }
}

export default Token = new Token() 