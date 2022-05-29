import Embed from './components/fieldtypes/Embed.vue'

Statamic.booting(() => {
    Statamic.component('embed-fieldtype', Embed)
})
