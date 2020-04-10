<template>
	<div>
		<AppNavigation>
			<ul>
				<AppNavigationItem>
					<a href="#" class="focus active">
						<ActionButton icon="icon-toggle-pictures">
							{{ t('AddProduct', 'List Products') }}
						</ActionButton>
					</a>
					<a href="add-product" class="focus">
						<ActionButton icon="icon-add">
							{{ t('AddProduct', 'Add Product') }}
						</ActionButton>
					</a>
				</AppNavigationItem>
			</ul>
		</AppNavigation>
		<AppContent>
			<div class="wrapper">
				<div v-if="loadingIndicator" class="loading-indicator">
					<div class="icon-loading" />
				</div>
				<div id="grid-template">
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
													@click="showDeleteModal(product)">
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
						<div v-if="loadingIndicator" class="loading-indicator">
							<div class="icon-loading" />
						</div>
						<h3>Edit {{ productName }}</h3>
						<ProductForm :product-arr="productArr" :is-edit="isEdit" />
					</div>
				</Modal>
				<Modal1 v-if="modal1" @close="closeDeleteModal">
					<div class="modal__content modal1">
						<h2 class="deleteContent">
							Product Deletion
						</h2>
						<p class="deleteContent">
							{{ t('ListProduct',
								'Are you sure you want to delete ')+deleteName+ '?' }}
						</p>
						<div class="button-flex">
							<button type="button" class="cancelbtn" @click="closeDeleteModal">
								Cancel
							</button>
							<button type="button" class="deletebtn" @click="deleteProduct">
								Delete
							</button>
						</div>
					</div>
				</Modal1>
			</div>
		</AppContent>
	</div>
</template>

<script>
import AppContent from '@nextcloud/vue/dist/Components/AppContent';
import { ActionButton } from '@nextcloud/vue/dist/Components/ActionButton';
import { Actions } from '@nextcloud/vue/dist/Components/Actions';
import { Modal, Modal as Modal1 } from '@nextcloud/vue/dist/Components/Modal';
import AppNavigation from '@nextcloud/vue/dist/Components/AppNavigation';
import AppNavigationItem from '@nextcloud/vue/dist/Components/AppNavigationItem';
import axios from '@nextcloud/axios';
import { generateUrl } from '@nextcloud/router';
import ProductForm from '../Components/ProductForm.vue';

export default {
	name: 'ListProduct',
	components: {
		AppContent,
		ActionButton,
		Actions,
		Modal,
		AppNavigation,
		AppNavigationItem,
		Modal1,
		ProductForm,
	},
	data: function() {
		return {
			productHeads: ['name', 'quantity', 'price', 'sku', 'category', 'description', 'actions'],
			products: [],
			modal: false,
			modal1: false,
			isEdit: false,
			loadingIndicator: true,
			deleteProductArr: [],
			deleteProductId: '',
			deleteName: '',
			productArr: [],
		};
	},
	async mounted() {
		try {
			const response = await axios.get(OC.generateUrl('/apps/skeleton_app/show'));
			this.loading(false);
			this.products = response.data;
			OCP.Toast.success(t('ListProduct', 'Fetching Products'));
		} catch (e) {
			console.error(e);
			OCP.Toast.error(t('App', 'Could not fetch products'));
		}
		this.loading = false;
	},

	methods: {
		loading(isLoading) {
			this.loadingIndicator = isLoading;
		},
		showModal(product) {
			this.modal = true;
			this.isEdit = true;
			this.productArr = product;
			this.loading(false);
		},
		closeModal() {
			this.showUpdateData();
			this.modal = false;
		},
		showDeleteModal(product) {
			this.modal1 = true;
			this.deleteProductId = product.id;
			this.deleteProductArr = product;
			this.deleteName = product.name;
		},
		closeDeleteModal() {
			this.modal1 = false;
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
		deleteProduct() {
			try {
				const productId = this.deleteProductId;
				axios.delete(OC.generateUrl(`/apps/skeleton_app/products/${productId}`));
				this.products.splice(this.products.indexOf(this.deleteProductArr), 1);
				this.modal1 = false;
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
	width: 95%;
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
	min-width: 105px;
	padding: 10px 16px;
}

#grid-template {
	display: flex;
	display: -webkit-flex;
	flex-direction: column;
	-webkit-flex-direction: column;
	padding: 7em 0em;
}

th.product-heading {
	text-transform: capitalize;
}

.modal__content {
	width: 35vw;
	text-align: center;
	margin: 4vw 0;
}

.loading-indicator {
	width: 100%;
	position: absolute;
	top: 25em;
}

#app-navigation {
	width: 242px !important;
	top: 21px !important;
}

input[type='text'], input[type='number'], input[type='submit'], textarea {
	width: 85%;
}

.focus:hover {
	background-color: #ededed;
}

a.active .action-button__text{
	color: black;
	font-weight: bold;
}

.button-flex {
	display: flex;
	margin-top: 1em;
}

.deletebtn {
	width: 28%;
	margin-left: 19em;
	color: white;
	background-color: red;
}

.cancelbtn {
	margin-left: 1em;
}

.modal1 {
	width: 35vw;
	text-align: inherit;
	margin: 2vw 0vw;
}

.deleteContent {
	margin-left: 15px;
}
</style>
