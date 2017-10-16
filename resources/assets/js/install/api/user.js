import http from '../http';

export default {
    loginByUserNameAndPassword : async (loginForm)=>{
        await http.post('api/user/login' ,loginForm);
        return Promise.resolve(true);
    },
    logout : async ()=>{
        let res = await http.post('/api/user/logout');
        let logout_success = res && res.session_cleared;
        if (logout_success) {
            return Promise.resolve(logout_success);
        }else{
            return Promise.reject('api/user/logout: user logging out failed!');
        }
    }
};

