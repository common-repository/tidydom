<script>
  import { createEventDispatcher } from 'svelte';
  const dispatch = createEventDispatcher();
  export let activeTab;
  export let tabs;

  function selectTab(tab) {
    dispatch('tabChange', tab);
  }
</script>

<ul class="tab-wrapper" role="tablist">
  {#each tabs as tab, i (tab.key)}
    <button
      id="tab-{tab.key}"
      class:first="{i===0}"
      class:active="{activeTab == tab.key}"
      class:inactive="{activeTab != tab.key}"
      aria-selected="{activeTab == tab.key}"
      on:click={selectTab(tab)}
      class="tab-button">
      {tab.label}
    </button>
  {/each}
</ul>

<style>
  .tab-wrapper {
    @apply flex border-solid border-gray-400 border-b border-t-0 border-l-0 border-r-0 mt-4 mb-2 w-full;
  }

  .tab-button {
    @apply py-2 px-4 text-base font-medium leading-5 whitespace-nowrap border-none cursor-pointer ml-4;
  }

  .tab-button.first {
    @apply ml-0;
  }

  .tab-button.active {
    @apply text-indigo-600 border-indigo-500 focus:outline-none focus:text-indigo-800 focus:border-indigo-700;
  }

  .tab-button.inactive {
    @apply text-gray-500 border-transparent hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300;
  } 

</style>
