<script>
    import StatCard from './StatCard.svelte';
    export let scanData;
</script>
<div class="stats-wrapper">
    <StatCard title="Accessibility Score" value={scanData.statistics.score} change={scanData.statistics.score_change} icon="user" />

    <StatCard title="Active Issues" value={scanData.statistics.active_issues} change={scanData.statistics.active_issues_change}  icon="alert" />

    <StatCard title="Average Instances/Page" value={scanData.statistics.average_instances_page} change={scanData.statistics.average_instances_page_change}  icon="chart" />
</div>

<style>
    .stats-wrapper {
        @apply grid grid-cols-1 gap-5 mt-5 sm:grid-cols-2 lg:grid-cols-3;
    }
</style>
