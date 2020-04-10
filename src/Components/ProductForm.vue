<template>
	<form v-on="{ submit: isEdit ? editForm : checkForm }">
		<p v-if="errors.length">
			<b>Please correct the following error(s):</b>
			<ul>
				<li v-for="error in errors" :key="error.id">
					{{ error }}
				</li>
			</ul>
		</p>
		<input v-model="productName"
			type="text"
			:placeholder="t('AddProduct', 'Product name')">
		<input v-model="productNumber"
			type="number"
			min="0"
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
		<div v-if="loadingIndicator" class="loading-indicator">
			<div class="icon-loading" />
		</div>
	</form>
</template>

<script>
import axios from '@nextcloud/axios';
import { generateUrl } from '@nextcloud/router';

export default {
	name: 'ProductForm',
	props: {
		'productArr': {
			type: Array,
			default: function() { return []; },
		},
		'isEdit': Boolean,
	},
	data: function() {
		return {
			productId: '',
			productName: '',
			productNumber: '',
			productPrice: '',
			productSku: '',
			productCategory: '',
			productDescription: '',
			loadingIndicator: false,
			errors: [],
		};
	},
	mounted() {
		this.productId = this.productArr.id;
		this.productName = this.productArr.name;
		this.productNumber = this.productArr.quantity;
		this.productPrice = this.productArr.price;
		this.productSku = this.productArr.sku;
		this.productCategory = this.productArr.category;
		this.productDescription = this.productArr.description;
	},
	methods: {
		checkForm() {
			const products = {
				productName: this.productName,
				productNumber: this.productNumber,
				productPrice: this.productPrice,
				productSku: this.productSku,
				productCategory: this.productCategory,
				productDescription: this.productDescription,
			};
			this.$root.$emit('product-entered', products);
		},
		editForm() {
			axios.put(
				generateUrl('apps/skeleton_app/update'),
				{
					id: this.productId,
					name: this.productName,
					quantity: this.productNumber,
					price: this.productPrice,
					sku: this.productSku,
					category: this.productCategory,
					description: this.productDescription,
				}
			).then(response => {
				alert('Product Updated');
			  OCP.Toast.success(t('ListProduct', 'Product Updated Successfully'));
			}).catch(reason => {
				alert(JSON.stringify(reason));
				OCP.Toast.error(t('ListProduct', 'Product could not be updated'));
			});
		},
	},
};
</script>
