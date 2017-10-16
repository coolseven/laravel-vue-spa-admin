import http from '../http';

export default {
    loginByUserNameAndPassword : async (loginForm)=>{
        let res = await http.post('/api/user/login' ,loginForm);
        let login_success = res && res.login_success;
        return Promise.resolve(login_success);
    },
    logout : async ()=>{
        let res = await http.post('/api/user/logout');
        let logout_success = res && res.session_cleared;
        if (logout_success) {
            return Promise.resolve(true);
        }else{
            return Promise.reject('api/user/logout: user logging out failed!');
        }
    }
};

