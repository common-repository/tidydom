import App from './App.svelte';

const target = document.getElementById('tidydom-app');

if (target) {
    const app = new App({
        target,
    });
}
