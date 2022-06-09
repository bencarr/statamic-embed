<template>
	<div class="space-y-1">
		<div class="relative">
			<text-input type="url" v-model="buffer" placeholder="https://" :classes="{ 'pr-4': fetching }"/>
		</div>

		<div class="relative rounded mt-2 overflow-hidden" v-if="url">
			<transition
				name="test"
				enter-class="transition-opacity duration-150"
				enter-active-class="opacity-100"
				leave-class="transition-opacity duration-300"
				leave-active-class="opacity-0"
			>
				<div class="z-10 embed-loading-bar rounded-t absolute top-0 left-0 w-full h-2" v-if="fetching"></div>
			</transition>
			<iframe
				:src="previewUrl"
				@load="onPreviewLoad"
				class="w-full bg-grey-20 border transition"
				height="315"
				:class="{ 'opacity-50': fetching }"
			></iframe>
		</div>
	</div>
</template>

<script>
import qs from 'qs'

export default {
	mixins: [Fieldtype],
	data() {
		return {
			// Flags for state changes
			metaChanging: false,
			fetching: true,

			// Core data
			url: this.value,
			buffer: this.value,

			// Preview
			preview: {},
		}
	},

	computed: {
		previewUrl() {
			if (!this.url) return null

			return cp_url('embed-fieldtype/preview', {url: this.url}) + '?' + qs.stringify({url: encodeURIComponent(this.url)})
		},
		code() {
			return _.get(this, ['preview', 'code', 'html'])
		},
	},

	methods: {
		// fetch() {
		// 	if (!this.url) return;
		//
		// 	let endpoint = cp_url('embed-fieldtype/fetch');
		// 	this.fetching = true;
		// 	this.$axios
		// 		.get(endpoint, { params: { url: this.url } })
		// 		.then(response => {
		// 			this.preview = response.data
		// 		})
		// 		.finally(() => this.fetching = false)
		// },
		onPreviewLoad() {
			this.fetching = false
		},
	},
	watch: {
		meta(meta) {
			// Flag that we're changing sites
			this.metaChanging = true

			// Update the component data with the new meta state
			this.url = meta.url

			// Listen for changes again
			this.$nextTick(() => this.metaChanging = false)
		},
		url() {
			// Don’t fire an update when changing sites so unsaved changes handler
			// doesn't think the field was edited
			if (this.metaChanging) return

			this.fetching = true

			this.updateDebounced(this.url)
		},
		buffer: _.debounce(function (newValue) {
			console.log('debounced')

			this.url = newValue
		}, 500),
	},
	// mounted() {
	// 	this.fetch();
	// },
}
</script>
<style>
.embed-loading-bar {
	position: relative;
	overflow: hidden;
	background: rgba(255, 38, 158);
}

.embed-loading-bar::after {
	content: '';
	position: absolute;
	height: 100%;
	width: 100%;
	background: linear-gradient(to right, rgba(255, 255, 255, 0), rgba(255, 255, 255, 1) 25%, rgba(255, 255, 255, 0));
	opacity: 0.75;
	animation: progress 1.5s infinite ease-in-out;
}

@-webkit-keyframes progress {
	0% {
		left: 0;
		transform: translateX(-100%);
	}
	100% {
		left: 100%;
		transform: translateX(0%);
	}
}
</style>