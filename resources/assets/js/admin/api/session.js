import http from '../http';

export default {
    sync : async ()=>{
        let latest = await http.post('/api/session/sync');
        if (latest && latest.user && latest.user.username) {
            return Promise.resolve(latest)
        }else{
            return Promise.reject('user session expired')
        }
    }
};

