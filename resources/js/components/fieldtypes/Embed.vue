<template>
	<div class="space-y-1">
		<div class="relative">
			<input
				type="url"
				class="input-text"
				v-model="buffer"
				:readonly="isReadOnly"
				placeholder="https://"
				@paste="onPaste"
			/>
		</div>

		<div class="flex items-center justify-between gap-4" v-if="url">
			<button type="button"
					class="flex items-center text-2xs text-grey-60 uppercase"
					@click="preview = !preview">
				<svg class="transition duration-200 w-4 h-4"
					 fill="currentColor"
					 viewBox="0 0 20 20"
					 xmlns="http://www.w3.org/2000/svg"
					 :class="{'rotate-90': preview}">
					<path fill-rule="evenodd"
						  d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
						  clip-rule="evenodd"></path>
				</svg>
				{{ __('embed::fieldtype.preview.button') }}
			</button>
			<button type="button" @click="onRefresh" class="flex items-center space-x-2 text-xs text-grey hover:text-grey-80">
				<svg class="transition w-4 h-4 mr-.5"
					 fill="none"
					 stroke="currentColor"
					 viewBox="0 0 24 24"
					 xmlns="http://www.w3.org/2000/svg"
					 :class="{'animate-spin': refreshing}"
				>
					<path stroke-linecap="round"
						  stroke-linejoin="round"
						  stroke-width="2"
						  d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
				</svg>
				{{ __('embed::fieldtype.refresh.button') }}
			</button>
		</div>
		<div v-if="preview">
			<div class="relative rounded overflow-hidden" v-if="url">
				<transition
					enter-class="transition-opacity duration-150"
					enter-active-class="opacity-100"
					leave-class="transition-opacity duration-300"
					leave-active-class="opacity-0"
				>
					<div class="z-10 embed-loading-bar rounded-t absolute top-0 left-0 w-full h-2"
						 v-if="fetching"></div>
				</transition>
				<iframe
					:src="previewUrl"
					@load="onPreviewLoad"
					ref="iframe"
					class="w-full bg-grey-20 border transition"
					:height="height"
					:class="{ 'opacity-50': fetching }"
				></iframe>
			</div>
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
			refreshing: false,

			// Core data
			url: this.value ? this.value.url : null,
			buffer: this.value ? this.value.url : null,

			// Preview
			preview: this.value ? this.value.preview : true,
			height: 200,

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
		returnValue() {
			if (!this.url) return null

			return {
				url: this.url,
				preview: this.preview,
			}
		},
	},

	methods: {
		onPreviewLoad() {
			this.fetching = false

			this.$refs.iframe.style.height = this.$refs.iframe.contentWindow.document.body.scrollHeight
		},
		onPaste() {
			this.url = this.buffer
		},
		onRefresh() {
			this.refreshing = true;
			this.fetching = true;
			this.$axios
				.post(cp_url('embed-fieldtype/refresh'), {url: this.url})
				.then(response => {
					this.refreshing = false
					this.$toast.success(__('embed::fieldtype.refresh.success'))
					if (this.preview) {
						this.$refs.iframe.contentWindow.location.reload()
					} else {
						this.fetching = false
					}
				})
				.catch(response => {
					this.$toast.error(__('embed::fieldtype.refresh.failed'))
					this.refreshing = false
					this.fetching = false
				})
		},
	},
	watch: {
		meta(meta) {
			// Flag that we're changing sites
			this.metaChanging = true

			// Update the component data with the new meta state
			this.url = meta.url
			this.buffer = meta.url
			this.preview = meta.preview

			// Listen for changes again
			this.$nextTick(() => this.metaChanging = false)
		},
		returnValue() {
			// Don’t fire an update when changing sites so unsaved changes handler
			// doesn't think the field was edited
			if (this.metaChanging) return

			this.updateDebounced(this.returnValue)
		},
		url() {
			this.fetching = true
		},
		buffer: _.debounce(function (newValue) {
			this.url = newValue
		}, 350),
	},
	mounted() {
		window.addEventListener('message', (event) => {
			if (event.data && event.data.sender === 'resizer') {
				this.height = event.data.message
			}
		})
	},
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