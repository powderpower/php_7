var path = require('path');

module.exports = 
{
    entry: {
        app: './resources/assets/js/app.js',
    },
    output: {
        path: path.resolve(__dirname, 'public/js'),
        filename: '[name].js'
    }
};