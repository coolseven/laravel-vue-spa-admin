import Vue from 'vue'
import Vuex from 'vuex'
import api from '../api'

Vue.use(Vuex);

const store = new Vuex.Store({
    state: {
        app:{
            name:'Yet Another Laravel-SPA-Admin',
            title:'Yet Another Laravel-SPA-Admin'
        },
        user   : {
            username: '',
            roles   : [],
            menus   : [],
            routes  : [],
            apis    : []
        },
        session: {
            visited_tabs: []
        },
        system : {
            roles: [],
            menus: [],
            apis : [],
        }
    },
    mutations: {
        save_user_info(state,payload){
            state.user = payload;
        },
        flush_local_user_info(state){
            state.user = {
                username: '',
                roles   : [],
                menus   : [],
                routes  : [],
                apis    : []
            }
        },
        flush_session(state){
            state.session = {
                visited_tabs: []
            }
        },
        add_tab_to_visited(state,tab){
            if (state.session.visited_tabs.some(v => v.path === tab.path)) {
                return
            }
            if (['Refresh','NotFound','Login','Error'].indexOf(tab.name) >= 0 ) {
                return
            }
            state.session.visited_tabs.push({ name: tab.name, path: tab.path })
        },
        remove_tab_from_visited(state,tab){
            let tab_index
            for (const [index, value] of state.session.visited_tabs.entries()) {
                if (value.path === tab.path) {
                    tab_index = index
                    break
                }
            }
            state.session.visited_tabs.splice(tab_index, 1)
        },
        save_system_info(state,payload){
            state.system = payload
        },
    },
    actions: {
        async login(context,form){
            try {
                await api.user.loginByUserNameAndPassword(form)
                await this.dispatch('sync')
                return Promise.resolve(true)
            } catch(error){
                return Promise.reject('user login failed')
            }
        },
        async sync(context){
            try {
                let latest_info = await api.session.sync();
                context.commit('save_user_info', latest_info.user);
                context.commit('save_system_info' , latest_info.system);
                return Promise.resolve(true)
            } catch(error){
                return Promise.reject('store: failed syncing user into store')
            }
        },
        async logout(context){
            try{
                await api.user.logout();
                context.commit('flush_local_user_info')
                context.commit('flush_session')
                return Promise.resolve(true)
            }catch(error){
                return Promise.reject('store: failed logging out')
            }
        },
        async flush_local_user_info(context){   // when user logs out from server (session data were flushed in the back end), we should also flush user info in the front end
            try{
                context.commit('flush_local_user_info');
                return Promise.resolve(true)
            }catch(error){
                return Promise.reject('store: failed logging out locally')
            }
        },
        add_tab_to_visited(context,tab){
            context.commit('add_tab_to_visited',tab);
            return Promise.resolve(true)
        },
        remove_tab_from_visited(context,tab){
            context.commit('remove_tab_from_visited',tab);
            return Promise.resolve(true)
        }
    },
    getters: {
        userHasLoggedIn(state){
            return (state.user && state.user.username !== '');
        },
        userHomePage(state,userHasLoggedIn){
            if (!userHasLoggedIn) {
                return '/login'
            }
            if(state.user.routes.length){
                return state.user.routes[0]['path']
            }
            return '/welcome';
        },
    },
    modules: {

    }
});
export default store
