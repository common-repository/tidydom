<script>
  import { onMount, afterUpdate, onDestroy } from 'svelte';
  import Chartist from 'chartist';
  import "chartist/dist/chartist.css";

  export let data;
  export let config;
  let chart = null;
  let chartRef;
  onMount(() => {
    chart = new Chartist.Line(chartRef, data, config);
  });

  afterUpdate(() => {
    chart = new Chartist.Line(chartRef, data, config);
  });

  onDestroy(() => {
    chart = null;
  });
</script>

<div bind:this={chartRef} class="td--chart-wrapper" id="td--chart-wrapper" />

<style>
  .td--chart-wrapper {
    @apply h-80 mt-4 bg-white py-6 pl-2 pr-4 rounded shadow;
  }

  :global(#td--chart-wrapper .ct-label.ct-horizontal) {
    @apply hidden md:block !important;
  }

</style>
