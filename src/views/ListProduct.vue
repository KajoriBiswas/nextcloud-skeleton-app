<template>
	<AppContent>
		<div class="wrapper">
			<div id="grid-template">
				<a href="add-product">{{ $t('skeleton_app', 'Add Product' ) }}</a>
				<div class="table-header-wrapper">
					<table class="table-header">
						<thead>
							<th v-for="heading in productHeads" :key="heading.id">
								{{ heading | capitalize }}
							</th>
						</thead>
					</table>
				</div>
				<div class="table-body-wrapper">
					<table class="table-body">
						<tbody>
							<tr v-for="product in products" :key="product.id">
								<td>{{ product.name }}</td>
								<td>{{ product.quantity }}</td>
								<td>{{ product.price }}</td>
								<td>{{ product.sku }}</td>
								<td>{{ product.category }}</td>
								<td>{{ product.description }}</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</AppContent>
</template>

<script>
import AppContent from '@nextcloud/vue/dist/Components/AppContent';
import axios from '@nextcloud/axios';

export default {
	name: 'ListProduct',
	components: {
		AppContent,
	},
	data: function() {
		return {
			productHeads: ['name', 'quantity', 'price', 'sku', 'category', 'description'],
			products: [],
		};
	},
	async mounted() {
		try {
			const response = await axios.get(OC.generateUrl('/apps/skeleton_app/show'));
			this.products = response.data;
			OCP.Toast.success(t('ListProduct', 'Fetching Products'));
		} catch (e) {
			console.error(e);
			OCP.Toast.error(t('App', 'Could not fetch products'));
		}
		this.loading = false;
	},
};
</script>

<style>
body {
	font-family: Helvetica Neue, Arial, sans-serif;
	font-size: 14px;
	color: #555;
}

table {
	border-spacing: 0;
	width: 100%;
}

th {
	background-color: #008f68;
	color: rgba(255, 255, 255, 0.66);
	cursor: pointer;
	-webkit-user-select: none;
	-moz-user-select: none;
	-ms-user-select: none;
	user-select: none;
}

td {
	border-bottom: 1px #008f68 solid;
}

th,
td {
	min-width: 150px;
	padding: 10px 20px;
}

#grid-template {
	display: flex;
	display: -webkit-flex;
	flex-direction: column;
	-webkit-flex-direction: column;
	padding: 7em;
}
</style>
