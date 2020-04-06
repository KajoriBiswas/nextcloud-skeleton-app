import Vue from 'vue';
import Router from 'vue-router';
import { getRootUrl, generateUrl } from '@nextcloud/router';
import AddProduct from './views/AddProduct';
import ListProduct from './views/ListProduct';

Vue.use(Router);

const webRootWithIndexPHP = getRootUrl() + '/index.php';
const doesURLContainIndexPHP = window.location.pathname.startsWith(webRootWithIndexPHP);
const base = generateUrl(
	'apps/skeleton_app',
	{},
	{
		noRewrite: doesURLContainIndexPHP,
	}
);

const router = new Router({
	mode: 'history',
	base,
	routes: [
		{
			path: '/add-product',
			name: 'AddProduct',
			component: AddProduct,
		},
		{
			path: '/',
			name: 'ListProduct',
			component: ListProduct,
		},
	],
});

export default router;
