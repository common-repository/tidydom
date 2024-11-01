import axios from 'axios';
axios.defaults.headers.common['X-WP-Nonce'] =  window.__tidydom.nonce;
axios.defaults.baseURL = window.__tidydom.apiRoot + 'tidydom/v1/';


export const getReport = () => {
    return axios.get('report');
}

export const getPages = (page = 1) => {
    return axios.get('pages', {params: {page}});
}
