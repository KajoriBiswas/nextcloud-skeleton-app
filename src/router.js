
import Vue from 'vue'
import Router from 'vue-router'
import DisplayComponent from './App'

Vue.use(Router)

const router = new Router({
	routes: [
		{
			path: 'displayButton',
			name: 'DisplayComponentView',
			component: DisplayComponent,
		},
	],
})

export default router
