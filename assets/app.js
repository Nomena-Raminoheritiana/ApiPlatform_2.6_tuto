/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';

// start the Stimulus application
import './bootstrap';
const axios = require('axios').default;

console.log('ato oh');
axios.post('/login', {
        mail: 'n.raminoheritiana@bolzanogroup.com',
        password: 'nomena'
    })
    .then(response => {
        console.log(response.headers);
        //this.$emit('user-authenticated', userUri);
        //this.email = '';
        //this.password = '';
    }).catch(error => {
    console.log(error.response.data);
    })
