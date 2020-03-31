<template>
	<div id="content" class="app-skeleton_app">
		<button class="btn" v-on:click="displayTime">
			Display Time
		</button>
		<DisplayComponent>
			<button class="btn">
				Display Component
			</button>
		</DisplayComponent>
	</div>
</template>

<script>
import HttpClient from '@nextcloud/axios'
import { linkTo } from '@nextcloud/router'

export default {
	name: 'App',
	methods: {
		async displayTime() {
			const response = await HttpClient.get(getTime())
			const responseData = response.data
			const value = JSON.parse(responseData)
			alert(t('App', value.currentDate))
		},
	},
}
function getTime() {
	return [linkTo('skeleton_app', 'index.php'), 'test/index'].join('/')
}

</script>
<style scoped>
#app-content > div {
	width: 100%;
}

input[type='text'] {
	width: 100%;
}

.btn {
	width: 10%;
	height: 10%;
	margin: 50px;
}

textarea {
	flex-grow: 1;
	width: 100%;
}
</style>
