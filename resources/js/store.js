import { isLoggedIn, logOut, isUserId, isUserRole } from "./shared/utils/auth";

export default {
    strict:true,
    state:{
        isLoggedIn: false,
        userId: null,
        userRole: null,
        user: {}
    },
    mutations:{
        setUser(state, payload){
            state.user = payload;
        },
        setUserId(state, payload){
            state.userId = payload;
        },
        setLoggedIn(state, payload){
            state.isLoggedIn = payload;
        },
        setRoleId(state, payload){
            state.userRole = payload;
        },

    },
    actions:{
        async loadStoredState(context){

            context.commit("setLoggedIn", isLoggedIn());
            context.commit("setUserId", isUserId());
            context.commit("setRoleId", isUserRole());

        },
        async loadUser({commit, dispatch}){
            if(isLoggedIn()){
                try {
                    const user = (await axios.get("/user")).data;
                    commit("setUserId", user.id);
                    commit("setRoleId", user.role);
                    commit("setUser", user);
                    commit("setLoggedIn", true);
                    localStorage.setItem("userId", user.id);
                    localStorage.setItem("userRole", user.role);
                } catch (error) {
                    dispatch("logout");

                }
            }
        },

        logout({ commit }){
            commit("setUser", {});
            commit("setLoggedIn", false);
            commit("setRoleId", null);
            logOut();
        }
    },

};
