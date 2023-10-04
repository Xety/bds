<template>
    <div class="flex flex-wrap">
        <div class="w-full">
            <ul class="flex flex-row list-none flex-wrap pt-3 pb-4 gap-4">
                <li class="flex-auto text-center">
                    <a class="text-xs font-bold uppercase px-5 py-3 shadow-md rounded block leading-normal cursor-pointer" v-on:click="toggleTabs('partEntries')" v-bind:class="{'text-neutral bg-white dark:text-white dark:bg-neutral': openTab !== 'partEntries', 'text-white bg-neutral dark:text-neutral dark:bg-white': openTab === 'partEntries'}">
                        <i class="fa-solid fa-arrow-right-to-bracket mr-2"></i>Pièces Détachées Entrées
                    </a>
                </li>
                <li class="flex-auto text-center">
                    <a class="text-xs font-bold uppercase px-5 py-3 shadow-md rounded block leading-normal cursor-pointer" v-on:click="toggleTabs('partExits')" v-bind:class="{'text-neutral bg-white dark:text-white dark:bg-neutral': openTab !== 'partExits', 'text-white bg-neutral dark:text-neutral dark:bg-white': openTab === 'partExits'}">
                        <i class="fa-solid fa-right-from-bracket mr-2"></i>Pièces Détachées Sorties
                    </a>
                </li>
            </ul>
            <div class="relative flex flex-col w-full mb-6">
                <div class="flex-auto">
                    <div v-bind:class="{'hidden': openTab !== 'partEntries', 'block': openTab === 'partEntries'}">
                        <slot name="part-entries"></slot>
                    </div>
                    <div v-bind:class="{'hidden': openTab !== 'partExits', 'block': openTab === 'partExits'}">
                        <slot name="part-exits"></slot>
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
        openTab: 'partEntries'
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