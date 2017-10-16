import Vue from 'vue'
import Vuex from 'vuex'
import api from '../api'

Vue.use(Vuex);

const store = new Vuex.Store({
    state: {
        app:{
            name:'Yet Another Laravel-SPA-Admin',
            title:'Yet Another Laravel-SPA-Admin - Setting up'
        },
        user   : {
            username: '',
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
                username   : undefined,
            }
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
                context.commit('flush_local_user_info');
                return Promise.resolve(true)
            }catch(error){
                return Promise.reject('store: failed logging out')
            }
        },
        async flush_local_user_info(context){   // when user session expired, we need to flush user info in front end
            try{
                context.commit('flush_local_user_info');
                return Promise.resolve(true)
            }catch(error){
                return Promise.reject('store: failed logging out locally')
            }
        },
    },
    getters: {
        userHasLoggedIn(state){
            return (state.user && state.user.username);
        },
    },
    modules: {

    }
});
export default store
