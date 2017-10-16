import http from '../http';

export default {
    roles:{
        paginate : async (params)=>{
            let roles = await http.post('api/auth/roles/paginate' ,params);
            return Promise.resolve(roles);
        },
        all : async (params)=>{
            let roles = await http.post('api/auth/roles/all' ,params);
            return Promise.resolve(roles);
        },
        menus: async (params)=>{
            let route = await http.post('api/auth/role/menus' , params);
            return Promise.resolve(route);
        },
        modifyMenus: async (params)=>{
            let saved = await http.post('api/auth/role/modifyMenus' , params);
            return Promise.resolve(saved);
        },
    },
    role:{
        apis: async (params)=>{
            let apis = await http.post('api/auth/role/apis' , params);
            return Promise.resolve(apis);
        },
        modifyApis: async (params)=>{
            let saved = await http.post('api/auth/role/modifyApis' , params);
            return Promise.resolve(saved);
        },
        modifyRoutes: async (params)=>{
            let saved = await http.post('api/auth/role/modifyRoutes' , params);
            return Promise.resolve(saved);
        },
        create    : async (params)=>{
            let role = await http.post('api/auth/role/create' , params);
            return Promise.resolve(role);
        },
        remove    : async (params)=>{
            let deleted = await http.post('api/auth/role/delete' , params);
            return Promise.resolve(deleted);
        },
        basic     : async (params)=>{
            let role = await http.post('api/auth/role/basic' , params);
            return Promise.resolve(role);
        },
        users     : async (params)=>{
            let users = await http.post('api/auth/role/users' , params);
            return Promise.resolve(users);
        },
        detachUser: async (params)=>{
            let excluded = await http.post('api/auth/role/detachUser' , params);
            return Promise.resolve(excluded);
        },
    },
    user:{
        detachRole: async (params)=>{
            let quited = await http.post('api/auth/user/detachRole' ,params);
            return Promise.resolve(quited);
        },
        remove    : async (params)=>{
            let deleted = await http.post('api/auth/user/delete' , params);
            return Promise.resolve(deleted);
        },
        create    : async (params)=>{
            let created = await http.post('api/auth/user/create' , params);
            return Promise.resolve(created);
        },
        modify    : async (params)=>{
            let saved = await http.post('api/auth/user/modify' , params);
            return Promise.resolve(saved);
        }
    },
    users:{
        paginate : async (params)=>{
            let users = await http.post('api/auth/users/paginate' ,params);
            return Promise.resolve(users);
        },
        deleteByUserId : async (params)=>{
            let deleted = await http.post('api/auth/user/delete' , params);
            return Promise.resolve(deleted);
        },
    },
    menus:{ // note: system_menus
        save : async (params)=>{
            let menus = await http.post('api/auth/menus/save' ,params);
            return Promise.resolve(menus);
        },
        all : async ()=>{
            let menus = await http.post('api/auth/menus/all');
            return Promise.resolve(menus);
        }
    }
};

