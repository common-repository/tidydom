<script>
  import { getReport, getPages } from './service';
  import Logo from './components/Logo.svelte';
  import Stats from './components/Stats.svelte';
  import Chart from './components/Chart.svelte';
  import Button from './components/Button.svelte';
  import Table from './components/Table.svelte';
  import Tabs from './components/Tabs.svelte';

  let adminFormRoot = window.__tidydom.adminFormRoot;
  let wpNonce = window.__tidydom.nonce;
  let loadingPage = true;
  let loadingTable = false;

  let errorCode;
  let pagination;
  let chartData,
    tableCaption,
    tableHeaders,
    tableRows,
    scanData,
    scanDate,
    team,
    site;
  let report;
  let pages = {};

  const tabs = [
    { key: 'report', label: 'History' },
    { key: 'pages', label: 'Pages' },
  ];
  let activeTab = 'report';

  let chartConfig = {
    fullWidth: true,
    chartPadding: {
      right: 30,
      bottom: 12,
    },
    axisY: {
      high: 100,
      onlyInteger: true,
    },
  };

  function setActiveTab(e) {
    activeTab = e.detail.key;
  }

  function loadReport() {
    errorCode = null;
    const setValues = (report) => {
      chartData = report.chartData;
      tableCaption = report.tableData.caption;
      tableHeaders = report.tableData.headers;
      tableRows = report.tableData.rows;
      scanData = report.scan;
      pagination = report.pagination ? { ...report.pagination } : null;
    };

    if (report) {
      setValues(report);
      return new Promise((resolve) => resolve());
    }
    return getReport()
      .then((resp) => {
        let ds = 'latest scan';
        try {
          ds = new Date(resp.data.scan.date);
          scanDate = `${
            ds.getUTCMonth() + 1
          }/${ds.getUTCDate()}/${ds.getUTCFullYear()}`;
        } catch (e) {}
        report = resp.data;
        site = resp.data.site;
        team = resp.data.team;
        setValues(report);
        loadingPage = false;
      })
      .catch((error) => {
        if (error.response) {
          errorCode = error.response.status;
        } else {
          errorCode = 9;
        }
      });
  }

  function loadPages() {
    errorCode = null;
    const forPage =
      pagination && pagination.current_page ? pagination.current_page : 1;
    const setValues = (pages) => {
      tableCaption = pages.tableData.caption;
      tableHeaders = pages.tableData.headers;
      tableRows = pages.tableData.rows;
      pagination = pages.pagination ? { ...pages.pagination } : null;
    };
    if (pages[forPage]) {
      setValues(pages[forPage]);
      return new Promise((resolve) => resolve());
    }

    return getPages(forPage)
      .then((resp) => {
        pages[forPage] = resp.data;
        setValues(pages[forPage]);
      })
      .catch((error) => {
        if (error.response) {
          errorCode = error.response.status;
        } else {
          errorCode = 9;
        }
      });
  }

  function fetchData() {
    if (activeTab === 'report') {
      loadingTable = true;
      return loadReport().then(() => {
        loadingPage = false;
        loadingTable = false;
      });
    } else if (activeTab === 'pages') {
      loadingTable = true;
      return loadPages().then(() => {
        loadingPage = false;
        loadingTable = false;
      });
    }
  }

  function previousPage() {
    if (pagination && pagination.current_page && pagination.current_page > 1) {
      pagination.current_page--;
      fetchData();
    }
  }

  function nextPage() {
    if (
      pagination &&
      pagination.current_page &&
      pagination.current_page < pagination.total_pages
    ) {
      pagination.current_page++;
      fetchData();
    }
  }

  $: if (activeTab === 'report') {
    fetchData();
  }

  $: if (activeTab === 'pages') {
    fetchData();
  }

  $: logo = team && team.logo ? team.logo : null;
</script>

<main>
  <div class="td--hero">
    <h1 class="td--title">Accessibility Report</h1>
    {#if site}
      <div class="td--provided-by">
        <span>Provided by </span>
        {#if logo}
          <img src={logo} alt={team.name} />
        {:else}
          <Logo width="240px" />
        {/if}
      </div>
    {/if}
  </div>

  {#if errorCode}
    <div class="td--error">
      <div>There was an error loading the report. Please try again later.</div>
      <div>
        If you continue to have problems, please contact <a
          href="mailto:support@tidydom.com">support@tidydom.com</a
        >
      </div>
      <div>
        Error code: {errorCode}
      </div>
    </div>
  {:else if loadingPage}
    <div class="td--loader">
      <span class="td--loading"> Loading report... </span>
    </div>
  {:else if scanData }
    <h2>{site.url} &mdash;&nbsp; Results from {scanDate}</h2>
    <Stats {scanData} />
    <div class="td--chart-header">
      <h3>Score Evolution</h3>
      <div class="td--download">
        <form method="POST" action={adminFormRoot} target="_blank">
          <input type="hidden" name="action" value="tidydom_download_report" />
          <input type="hidden" name="download_type" value="pdf" />
          <input type="hidden" name="nonce" value={wpNonce} />
          <Button
            type="submit"
            text=".PDF"
            title="Download PDF Report"
            download={true}
          />
        </form>
        <form
          method="POST"
          class="td--ml-3"
          action={adminFormRoot}
          target="_blank"
        >
          <input type="hidden" name="action" value="tidydom_download_report" />
          <input type="hidden" name="download_type" value="csv" />
          <input type="hidden" name="nonce" value={wpNonce} />
          <Button
            type="submit"
            text=".CSV"
            title="Download CSV Report"
            download={true}
          />
        </form>
      </div>
    </div>
    <Chart config={chartConfig} data={chartData} />

    <Tabs {tabs} {activeTab} on:tabChange={setActiveTab} />
    {#if loadingTable}
      <div class="td--loader">
        <span class="td--loading"> Loading... </span>
      </div>
    {:else}
      <div style="width:100%;overflow-x:scroll">
        <Table caption={tableCaption} headers={tableHeaders} rows={tableRows} />
      </div>
    {/if}
    {#if pagination && pagination.total_pages > 1}
      <div class="pagination">
        <div class="pagination-wrapper">
          <button
            disabled={pagination.current_page == 1}
            class="pagination-link pagination-previous"
            on:click={previousPage}>Previous</button
          >

          <button
            disabled={pagination.current_page == pagination.total_pages}
            class="pagination-link pagination-next"
            on:click={nextPage}>Next</button
          >
          <div class="pagination-count">
            Page {pagination.current_page} of {pagination.total_pages}
          </div>
        </div>
      </div>
    {/if}
  {:else}
  <div class="td--loading">
  	<h2>No data yet for {site.url}.
	  </h2>
	  <p> Visit your <a href="https://app.tidydom.com" target="_blank" rel="noopener"
		>tidyDOM dashboard</a> to start a scan, or wait until your first scheduled scan is complete.</p>
  </div>
  {/if}
  <div class="td--attribution">
	via <a href="https://tidydom.com" target="_blank" rel="noopener"
	  >tidyDOM.com</a
	>
  </div>
</main>

<style>
  h1,
  h2,
  h3 {
    @apply m-0 text-gray-800;
  }

  h2 {
    @apply m-0 mt-4 text-lg font-semibold;
  }

  h3 {
    @apply m-0 text-lg font-semibold;
  }
  main {
    @apply p-4 my-0 mx-auto max-w-6xl;
  }

  .td--ml-3 {
    @apply ml-3;
  }

  .td--hero {
    @apply flex items-center justify-between text-gray-800 w-full;
    height: 100px;
  }

  .td--loader {
    @apply animate-pulse flex w-full items-center justify-center;
  }

  .td--loading {
    @apply border border-gray-800 bg-gray-50 rounded shadow w-full mt-2 text-center py-4 text-2xl font-semibold block;
  }

  .td--error {
    @apply items-center justify-center border-2 border-red-800 bg-gray-50 rounded shadow w-full mt-2 text-center py-4 text-base font-semibold;
  }

  h1.td--title {
    @apply text-2xl md:text-4xl font-semibold;
  }

  .td--provided-by {
    @apply flex flex-col;
    max-height: 100px;
  }

  .td--provided-by img {
    max-width: 240px;
    height: 120px;
  }

  .td--provided-by {
    @apply p-1;
  }
  .td--provided-by span {
    @apply text-base font-semibold pb-1;
  }

  .td--chart-header {
    @apply flex mt-10 items-center justify-between;
  }

  .td--download {
    @apply flex;
  }

  .td--attribution {
    @apply text-right mt-2;
  }

  .pagination-wrapper {
    @apply flex w-full mt-2 items-center justify-start;
  }

  .pagination-link {
    @apply text-blue-500 border-transparent hover:text-blue-700 hover:border-blue-300 focus:outline-none focus:text-blue-700 focus:border-blue-300 py-2 px-4 text-base font-medium leading-5 whitespace-nowrap border-none cursor-pointer bg-white border-gray-300 rounded w-32;
  }

  .pagination-link:disabled {
    @apply text-gray-500 bg-gray-200 pointer-events-none;
  }
  .pagination-next,
  .pagination-count {
    @apply ml-4;
  }
</style>
