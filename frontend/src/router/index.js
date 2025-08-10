import Vue from 'vue'
import Router from 'vue-router'
import UserLogin from '../components/UserLogin.vue'
import TaskList from '../components/TaskList.vue'

Vue.use(Router)

export default new Router({
  routes: [
    //{ path: '/', redirect: '/login' },
    { path: '/', component: UserLogin },
    { path: '/tasks', component: TaskList }
  ]
})