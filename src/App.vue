<template>
	<AppContent>
		<div class="content">
			<h2> {{ t('App', 'Add product') }} </h2>
			<form @submit.prevent="saveProduct">
				<input type="text"
					:placeholder="t('App', 'Product name')"
					v-model="productName" />
				<input type="number"
					:placeholder="t('App', 'Product quantity')"
					v-model="productNumber" />
				<input type="text"
					:placeholder="t('App', 'Product price')"
					v-model="productPrice" />
				<input type="text"
					:placeholder="t('App', 'Product sku')"
					v-model="productSku" />
				<input type="text"
					:placeholder="t('App', 'Product category')"
					v-model="productCategory" />

				<textarea rows="4" v-model="productDescription" />
				<input
					type="submit"
					class="primary"
					:value="t('App', 'Add product')" />
			</form>
		</div>
	</AppContent>
</template>
<script>
import AppContent from '@nextcloud/vue/dist/Components/AppContent'
import axios from '@nextcloud/axios'
import { generateUrl } from '@nextcloud/router'

export default {
	name: 'App',
	components: {
		AppContent
	},
	data: function() {
		return {
			notes: [],
			productName: '',
			productNumber: '',
			productPrice: '',
			productSku: '',
			productCategory: '',
			productDescription: ''
		}
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
				alert('Data inserted')
			}).catch(reason => {
				alert('error')
			})
		}
	}
}
</script>
<style>
.content {
	padding: 7em 12em;;
}
input[type='text'], input[type='number'], input[type='submit'] {
	width: 50%;
}
textarea {
	flex-grow: 1;
	width: 50%;
}
</style>
