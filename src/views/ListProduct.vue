<template>
	<AppContent>
		<div class="wrapper">
			<div id="grid-template">
				<ul>
					<ActionLink icon="icon-external" href="add-product">
						Add a product
					</ActionLink>
				</ul>
				<div class="table-header-wrapper">
					<table class="table-header">
						<thead>
							<th v-for="heading in productHeads"
								:key="heading.id"
								class="product-heading">
								{{ heading }}
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
								<td>
									<ul>
										<Actions>
											<ActionButton
												icon="icon-edit"
												@click="showModal(product)">
												{{ t('ListProduct', 'Edit') }}
											</ActionButton>
											<ActionButton
												icon="icon-delete"
												@click="deleteProduct(product)">
												{{ t('ListProduct', 'Delete') }}
											</ActionButton>
										</Actions>
									</ul>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<Modal v-if="modal" @close="closeModal">
				<div class="modal__content">
					<form @submit.prevent="updateProduct">
						<input v-model="productName"
							type="text"
							:placeholder="t('ListProduct', 'Product name')">
						<input v-model="productNumber"
							type="number"
							:placeholder="t('ListProduct', 'Product quantity')">
						<input v-model="productPrice"
							type="text"
							:placeholder="t('ListProduct', 'Product price')">
						<input v-model="productSku"
							type="text"
							:placeholder="t('ListProduct', 'Product sku')">
						<input v-model="productCategory"
							type="text"
							:placeholder="t('ListProduct', 'Product category')">
						<textarea v-model="productDescription" rows="4" />
						<input
							type="submit"
							class="primary"
							:value="t('ListProduct', 'Save')">
					</form>
				</div>
			</Modal>
		</div>
	</AppContent>
</template>

<script>
import AppContent from '@nextcloud/vue/dist/Components/AppContent';
import { ActionButton } from '@nextcloud/vue/dist/Components/ActionButton';
import { Actions } from '@nextcloud/vue/dist/Components/Actions';
import { ActionLink } from '@nextcloud/vue/dist/Components/ActionLink';
import { Modal } from '@nextcloud/vue/dist/Components/Modal';
import axios from '@nextcloud/axios';
import { generateUrl } from '@nextcloud/router';

export default {
	name: 'ListProduct',
	components: {
		AppContent,
		ActionButton,
		Actions,
		ActionLink,
		Modal,
	},
	data: function() {
		return {
			productHeads: ['name', 'quantity', 'price', 'sku', 'category', 'description', 'actions'],
			products: [],
			modal: false,
			productId: '',
			productName: '',
			productNumber: '',
			productPrice: '',
			productSku: '',
			productCategory: '',
			productDescription: '',
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

	methods: {
		showModal(product) {
			this.modal = true;
			this.productId = product.id;
			this.productName = product.name;
			this.productNumber = product.quantity;
			this.productPrice = product.price;
			this.productSku = product.sku;
			this.productCategory = product.category;
			this.productDescription = product.description;
		},
		closeModal() {
			this.showUpdateData();
			this.modal = false;
		},
		/**
		 * Displays updated products in the frontend
		*/
		async showUpdateData() {
			const updatedData = await axios.get(OC.generateUrl('/apps/skeleton_app/show'));
			this.products = updatedData.data;
		},
		/**
		 * Delete a product, remove it from the frontend and show a hint
		 * @param {Object} product Product object
		 */
		deleteProduct(product) {
			try {
				axios.delete(OC.generateUrl(`/apps/skeleton_app/products/${product.id}`));
				this.products.splice(this.products.indexOf(product), 1);
				alert('product deleted');
				OCP.Toast.success(t('ListProduct', 'Product deleted'));
			} catch (e) {
				console.error(e);
				OCP.Toast.error(t('ListProduct', 'Could not delete the product'));
			}
		},
		/**
		 * Update a product.
		*/
		updateProduct() {
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
	min-width: 120px;
	padding: 10px 20px;
}

#grid-template {
	display: flex;
	display: -webkit-flex;
	flex-direction: column;
	-webkit-flex-direction: column;
	padding: 7em;
}

th.product-heading {
	text-transform: capitalize;
}

.modal__content {
	width: 50vw;
	text-align: center;
	margin: 4vw 0;
}
</style>
