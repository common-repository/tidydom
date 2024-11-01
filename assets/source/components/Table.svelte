<script>
  export let caption;
  export let rows = [];
  export let headers = [];
</script>

<table id="td--table">
  <caption>
    {caption}
  </caption>
  <thead>
    <tr>
      {#each headers as header, i}
        <th scope="col" class={i > 0 ? 'td--text-centered' : 'td--text-left'}>
          {header}
        </th>
      {/each}
    </tr>
  </thead>
  <tbody>
    {#each rows as row}
      <tr>
        {#each row as col, i}
          <td class={i > 0 ? 'td--text-centered' : 'td--text-left'}>
            {col}
          </td>
        {/each}
      </tr>
    {/each}
  </tbody>
</table>

<style>
  #td--table {
    @apply w-full divide-y divide-gray-200 text-gray-800 overflow-scroll;
  }

  caption {
    @apply p-4 text-lg font-semibold text-left;
  }

  thead {
    @apply bg-gray-50;
  }

  thead tr {
    @apply px-4 py-3 text-xs font-medium tracking-wider text-left uppercase;
  }

  thead tr th {
    @apply px-4 py-3 text-xs font-medium tracking-wider uppercase;
  }

  .td--text-left {
    @apply text-left;
  }

  .td--text-centered {
    @apply text-center;
  }

  tbody {
    @apply bg-white divide-y divide-gray-200;
  }

  tbody td {
    @apply px-4 py-4 text-sm whitespace-nowrap;
  }
</style>
