<template>
	<div class="space-y-1">
		<div class="relative">
			<text-input type="url" v-model="buffer" placeholder="https://" :classes="{ 'pr-4': fetching }"/>
			<div class="absolute top-0 right-0 p-1" v-if="fetching">
				<div class="embed-preview-spinner"></div>
			</div>
		</div>

		<div class="relative bg-grey-20 border rounded mt-2 overflow-hidden" v-if="url">
			<iframe
				:src="previewUrl"
				@load="onPreviewLoad"
				class="embed-preview-frame"
				:class="{ 'opacity-50 transition': fetching }"
			></iframe>
		</div>
	</div>
</template>

<script>
import qs from 'qs';

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
			if (!this.url) return null;

			return cp_url('embed-fieldtype/preview', { url: this.url }) + '?' + qs.stringify({ url: encodeURIComponent(this.url) })
		},
		code() {
			return _.get(this, ['preview', 'code', 'html']);
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
			this.fetching = false;
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

			this.fetching = true;

			this.updateDebounced(this.url)
		},
		buffer: _.debounce(function(newValue) {
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
.embed-preview-frame {
	width: 100%;
	height: 315px;
}

.embed-preview-spinner {
	display: inline-block;
	border: 3px solid rgba(0, 0, 0, 0.15);
	border-radius: 50%;
	width: 1.25rem;
	height: 1.25rem;
	border-top-color: rgba(0, 0, 0, 0.5);
	animation: spin calc(1s) linear infinite;
}

@keyframes spin {
	 0% { transform: rotate(0deg); }
	 100% { transform: rotate(360deg); }
 }
</style>