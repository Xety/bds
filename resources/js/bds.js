import './bootstrap';
import Dismiss from './libs/dismiss.js'
import flatpickr from "flatpickr";
import { French } from "flatpickr/dist/l10n/fr.js";
import { vsprintf } from "sprintf-js";
import print from 'print-js';

import {createApp} from 'vue/dist/vue.esm-bundler.js';
import IncidentsMaintenancesGraph from "./Components/IncidentsMaintenancesGraph.vue"
import LotsGraph from "./Components/LotsGraph.vue"
import Notifications from "./Components/Notifications.vue";
import ActivitiesTabs from "./Components/ActivitiesTabs.vue";
import MaterialTabs from "./Components/MaterialTabs.vue";
import PartTabs from "./Components/PartTabs.vue";

// VueJS
const app = createApp({
    components: {
        Notifications,

        // Tabs
        ActivitiesTabs,
        MaterialTabs,
        PartTabs,

        //Graphs
        IncidentsMaintenancesGraph,
        LotsGraph
    },

    data() {
        return {
            nightMode: localStorage.getItem("nightMode") || false
        }
    },

    watch: {
        nightMode: function() {
			localStorage.setItem("nightMode", JSON.stringify(this.nightMode));

            let stylesheet = document.head.querySelector("link[href*='flatpickr']");

            if (String(this.nightMode) === 'true') {
                document.getElementsByTagName('html')[0].dataset.theme = "dark";
                stylesheet.href = "./assets/flatpickr_dark.css";
            } else {
                document.getElementsByTagName('html')[0].dataset.theme = "light";
                stylesheet.href = "./assets/flatpickr_default.css";
            }
		}
    },

    mounted() {
        const darkMode = localStorage.getItem("nightMode");
        let theme = "default";

        if (darkMode === 'true') {
            theme = "dark";
            this.nightMode = true;
            document.getElementById("nightMode").checked = true;
        } else {
            this.nightMode = false;
            document.getElementById("nightMode").checked = false;
        }

        document.getElementsByTagName('html')[0].dataset.theme = theme;

        let stylesheet = document.head.querySelector("link[href*='flatpickr']");
        stylesheet.href = "./assets/flatpickr_" + theme + ".css";
    }
});
app.mount("#bds-vue");

// Set the datetime picker locale to french
flatpickr.localize(French);

export default {
    Dismiss
}

 // Scroll to Top
let buttonBackToTop = document.getElementById('btn-back-to-top');
let drawer = document.getElementsByClassName('drawer-content')[0];
// When the user clicks on the button, scroll to the top of the document
buttonBackToTop.addEventListener('click', function() {
    drawer.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
});

 // When the user scrolls down 60px from the top of the document, show the button
 drawer.onscroll = function () {
    if (drawer.scrollTop > 60) {
        buttonBackToTop.style.display = 'block';
    } else {
        buttonBackToTop.style.display = 'none';
    }
};
