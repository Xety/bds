<template>
    <div class="flex flex-wrap">
        <div class="w-full">
            <ul class="flex mb-0 list-none flex-wrap pt-3 pb-4 flex-row gap-3">
                <li class="-mb-px mr-2 last:mr-0 flex-auto text-center">
                    <a class="text-xs font-bold uppercase px-5 py-3 shadow-md rounded block leading-normal cursor-pointer" v-on:click="toggleTabs('incidents')" v-bind:class="{'text-neutral bg-white dark:text-white dark:bg-neutral': openTab !== 'incidents', 'text-white bg-neutral dark:text-neutral dark:bg-white': openTab === 'incidents'}">
                        <i class="fa-solid fa-triangle-exclamation mr-2"></i>Incidents
                    </a>
                </li>
                <li class="-mb-px mr-2 last:mr-0 flex-auto text-center">
                    <a class="text-xs font-bold uppercase px-5 py-3 shadow-md rounded block leading-normal cursor-pointer" v-on:click="toggleTabs('maintenances')" v-bind:class="{'text-neutral bg-white dark:text-white dark:bg-neutral': openTab !== 'maintenances', 'text-white bg-neutral dark:text-neutral dark:bg-white': openTab === 'maintenances'}">
                        <i class="fa-solid fa-screwdriver-wrench mr-2"></i>Maintenances
                    </a>
                </li>
                <li class="-mb-px mr-2 last:mr-0 flex-auto text-center">
                    <a class="text-xs font-bold uppercase px-5 py-3 shadow-md rounded block leading-normal cursor-pointer" v-on:click="toggleTabs('parts')" v-bind:class="{'text-neutral bg-white dark:text-white dark:bg-neutral': openTab !== 'parts', 'text-white bg-neutral dark:text-neutral dark:bg-white': openTab === 'parts'}">
                        <i class="fa-solid fa-gear mr-2"></i>Pièces Détachées
                    </a>
                </li>
                <li class="-mb-px mr-2 last:mr-0 flex-auto text-center">
                    <a class="text-xs font-bold uppercase px-5 py-3 shadow-md rounded block leading-normal cursor-pointer" v-on:click="toggleTabs('cleanings')" v-bind:class="{'text-neutral bg-white dark:text-white dark:bg-neutral': openTab !== 'cleanings', 'text-white bg-neutral dark:text-neutral dark:bg-white': openTab === 'cleanings'}">
                        <i class="fa-solid fa-broom mr-2"></i>Nettoyages
                    </a>
                </li>
            </ul>
            <div class="relative flex flex-col w-full mb-6">
                <div class="flex-auto">
                    <div v-bind:class="{'hidden': openTab !== 'incidents', 'block': openTab === 'incidents'}">
                        <slot name="incidents"></slot>
                    </div>
                    <div v-bind:class="{'hidden': openTab !== 'maintenances', 'block': openTab === 'maintenances'}">
                        <slot name="maintenances"></slot>
                    </div>
                    <div v-bind:class="{'hidden': openTab !== 'parts', 'block': openTab === 'parts'}">
                        <slot name="parts"></slot>
                    </div>
                    <div v-bind:class="{'hidden': openTab !== 'cleanings', 'block': openTab === 'cleanings'}">
                        <slot name="cleanings"></slot>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </template>

  <script>
  export default {
    data() {
      return {
        openTab: 'incidents'
      }
    },
    mounted() {
        if (window.location.hash) {
            this.openTab = window.location.hash.substring(1);
        } else {
            window.location.hash = this.openTab;
        }
    },
    methods: {
      toggleTabs: function(tabName){
        this.openTab = tabName;
        window.location.hash = tabName;
      }
    }
  }
  </script>