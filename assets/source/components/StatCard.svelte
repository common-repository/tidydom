<script>
  export let title;
  export let value;
  export let change;
  export let icon;

  let intChange = parseInt(change);
</script>

<div class="td--card">
  <div class="td--card-p">
    <div class="td--card-l">
      <div class="td--card-icon">
        {#if icon == 'user'}
          <svg
            class="td--heroicon"
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"
            />
          </svg>
        {:else if icon == 'alert'}
          <svg
            class="td--heroicon"
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"
            />
          </svg>
        {:else if icon == 'chart'}
          <svg
            class="td--heroicon"
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"
            />
          </svg>
        {/if}
      </div>
      <div class="td--card-wrap">
        <h3 class="td--card-title">
          {title}
        </h3>
        <div class="td--card-content">
          <div class="td--card-content-body">
            {value}
          </div>
          <div
            class:td--card-change-up={intChange > 0}
            class:td--card-change-down={intChange < 0}
            class:td--card-change-none={intChange == 0}
          >
            <svg
              class:td--card-change-icon-up={intChange > 0}
              class:td--card-change-icon-down={intChange < 0}
              class:td--card-change-icon-none={intChange == 0}
              fill="currentColor"
              viewBox="0 0 20 20"
              aria-hidden="true"
            >
              <path
                fill-rule="evenodd"
                d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z"
                clip-rule="evenodd"
              />
            </svg>
            {#if intChange > 0}
              <span class="td--sr-only"> Increased by </span>
            {:else if intChange < 0}
              <span class="td--sr-only"> Decreased by </span>
            {:else}
              <span class="td--sr-only"> No change </span>
            {/if}
            {change}
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<style>
  .td--sr-only {
    @apply sr-only;
  }

  .td--heroicon {
    @apply w-6 h-6 text-white;
  }

  .td--card {
    @apply overflow-hidden bg-white rounded-lg shadow;
  }

  .td--card-p {
    @apply px-4 py-5 sm:p-6;
  }

  .td--card-l {
    @apply flex items-center justify-center;
  }

  .td--card-icon {
    @apply flex-shrink-0 p-3 bg-indigo-500 rounded-md;
  }

  .td--card-wrap {
    @apply flex-1 w-0 ml-5;
  }

  .td--card-title {
    @apply m-0 text-sm font-medium text-gray-500 truncate;
  }

  .td--card-content {
    @apply flex items-center;
  }

  .td--card-content-body {
    @apply text-2xl font-semibold text-gray-900;
  }

  .td--card-change-up {
    @apply flex items-center ml-2 text-sm font-semibold text-green-600;
  }

  .td--card-change-down {
    @apply flex items-center ml-2 text-sm font-semibold text-red-600;
  }

  .td--card-change-none {
    @apply flex items-center ml-2 text-sm font-semibold text-gray-600;
  }

  .td--card-change-icon-up {
    @apply self-center flex-shrink-0 w-5 h-5 text-green-500;
  }

  .td--card-change-icon-down {
    @apply self-center flex-shrink-0 w-5 h-5 text-red-500 transform rotate-180;
  }

  .td--card-change-icon-none {
    @apply self-center flex-shrink-0 w-5 h-5 text-gray-500;
  }
</style>
