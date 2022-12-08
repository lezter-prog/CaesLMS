import _ from 'lodash';
window._ = _;

import '@fortawesome/fontawesome-free/js/all';


import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';