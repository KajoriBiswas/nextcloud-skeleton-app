<template>
	<div>
		<AppNavigation>
			<ul>
				<AppNavigationItem>
					<a href="/index.php/apps/skeleton_app/" class="focus">
						<ActionButton icon="icon-toggle-pictures">
							{{ t('AddProduct', 'List Products') }}
						</ActionButton>
					</a>
					<a href="#" class="focus active">
						<ActionButton icon="icon-add">
							{{ t('AddProduct', 'Add Product') }}
						</ActionButton>
					</a>
				</AppNavigationItem>
			</ul>
		</AppNavigation>
		<AppContent>
			<div class="content">
				<h2> {{ t('AddProduct', 'Add product') }} </h2>
				<ProductForm />
			</div>
		</AppContent>
	</div>
</template>

<script>
import AppContent from '@nextcloud/vue/dist/Components/AppContent';
import axios from '@nextcloud/axios';
import { generateUrl } from '@nextcloud/router';
import AppNavigation from '@nextcloud/vue/dist/Components/AppNavigation';
import AppNavigationItem from '@nextcloud/vue/dist/Components/AppNavigationItem';
import { ActionButton } from '@nextcloud/vue/dist/Components/ActionButton';
import ProductForm from '../Components/ProductForm.vue';

export default {
	name: 'AddProduct',
	components: {
		AppContent,
		AppNavigation,
		AppNavigationItem,
		ActionButton,
		ProductForm,
	},
	data: function() {
		return {
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
		this.$root.$on('product-entered', (data) => {
			this.productName = data.productName;
			this.productNumber = data.productNumber;
			this.productPrice = data.productPrice;
			this.productSku = data.productSku;
			this.productCategory = data.productCategory;
			this.productDescription = data.productDescription;
			this.saveProduct();
		});
	},
	methods: {
		loading(isLoading) {
			this.loadingIndicator = isLoading;
		},
		saveProduct() {
			this.loading(true);
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
				this.loading(false);
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

input[type='text'], input[type='number'], input[type='submit'], textarea {
	width: 85%;
}

textarea {
	flex-grow: 1;
	width: 50%;
}

.loading-indicator {
	width: 100%;
	top: 0;
	height: 50px;
}

#app-navigation {
	width: 242px !important;
	top: 21px !important;
}

.focus:hover {
	background-color: #ededed;
}

a.active .action-button__text{
	color: black;
	font-weight: bold;
}
</style>
