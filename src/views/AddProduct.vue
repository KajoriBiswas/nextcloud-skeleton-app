<template>
	<AppContent>
		<div class="content">
			<h2> {{ t('AddProduct', 'Add product') }} </h2>
			<form @submit.prevent="saveProduct">
				<input v-model="productName"
					type="text"
					:placeholder="t('AddProduct', 'Product name')">
				<input v-model="productNumber"
					type="number"
					:placeholder="t('AddProduct', 'Product quantity')">
				<input v-model="productPrice"
					type="text"
					:placeholder="t('AddProduct', 'Product price')">
				<input v-model="productSku"
					type="text"
					:placeholder="t('AddProduct', 'Product sku')">
				<input v-model="productCategory"
					type="text"
					:placeholder="t('AddProduct', 'Product category')">

				<textarea v-model="productDescription" rows="4" />
				<input
					type="submit"
					class="primary"
					:value="t('AddProduct', 'Save')">
				<ul>
					<ActionLink icon="icon-external" href="/index.php/apps/skeleton_app/">
						View Products
					</ActionLink>
				</ul>
			</form>
		</div>
	</AppContent>
</template>

<script>
import AppContent from '@nextcloud/vue/dist/Components/AppContent';
import axios from '@nextcloud/axios';
import { ActionLink } from '@nextcloud/vue/dist/Components/ActionLink';
import { generateUrl } from '@nextcloud/router';

export default {
	name: 'AddProduct',
	components: {
		AppContent,
		ActionLink,
	},
	data: function() {
		return {
			notes: [],
			productName: '',
			productNumber: '',
			productPrice: '',
			productSku: '',
			productCategory: '',
			productDescription: '',
		};
	},
	methods: {
		saveProduct() {
			axios.post(
				generateUrl('apps/skeleton_app/create'),
				{
					name: this.productName,
					quantity: this.productNumber,
					price: this.productPrice,
					sku: this.productSku,
					category: this.productCategory,
					description: this.productDescription,
				}
			).then(response => {
				alert('Product inserted');
				// OCP.Toast.success(t('AddProduct', 'Product Inserted'));
			}).catch(reason => {
				alert(JSON.stringify(reason));
				OCP.Toast.error(t('AddProduct', 'Product could not be inserted'));
			});
		},
	},
};
</script>
<style>
.content {
	padding: 7em 12em;
}

input[type='text'], input[type='number'], input[type='submit'] {
	width: 50%;
}

textarea {
	flex-grow: 1;
	width: 50%;
}
</style>
