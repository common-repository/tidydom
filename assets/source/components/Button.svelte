<script>
  export let text;
  export let title;
  export let download = false;
  export let type = 'button';
</script>

<button {title} {type} class="td--button-white">
  {text}
  {#if download}
  <svg class="td--button-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
    <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"></path>
  </svg>
  {/if}
</button>

<style>
  .td--button-white {
    @apply px-3 py-2 text-sm leading-4 rounded-md inline-flex font-medium items-center shadow-sm cursor-pointer border border-gray-300 text-gray-700 bg-white;
  }

  .td--button-white:focus, .td--button-white:active {
    @apply ring-4 ring-blue-600 border-blue-500;
  }

  .td--button-white:hover {
    @apply text-gray-500;
  }

  .td--button-white:active {
    @apply text-gray-800 bg-gray-50;
  }

  .td--button-icon {
      @apply w-3 h-3 ml-1;
  }
</style>
